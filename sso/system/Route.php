<?php
require_once(APPPATH . 'config/route.php');

class Route
{

  private $routes;
  public $_segment;
  function __construct()
  {
    global $route;
    $this->routes = $route;
  }
  function get_all()
  {
    global $route;
    return $route;
  }


  function _parse_routes()
  {

    //$_segment = str_replace($_SERVER['SCRIPT_NAME'].DIRECTORY_SEPARATOR,'',$_SERVER['PHP_SELF']);
    //$_segment= explode('/',$_segment);

  
    if (empty($_SERVER['PATH_INFO'])) {
      $temp = '/' . str_replace(BASE_PATH, '', $_SERVER['REQUEST_URI']);
      $_segment = isset($temp) ? explode('/', preg_replace('~^/?(.*?)/?
      $~', '$1', $temp)) : array();
    }else{
      $_segment = isset($_SERVER['PATH_INFO']) ? explode('/', preg_replace('~^/?(.*?)/?
      $~', '$1', $_SERVER['PATH_INFO'])) : array();
    }
    // Turn the segment array into a URI string
    $uri = implode('/', $_segment);
    $uri = ltrim($uri, '/');
    // Get HTTP verb
    $http_verb = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';

    // Loop through the route array looking for wildcards
    foreach ($this->routes as $key => $val) {
      // Check if route format is using HTTP verbs
      if (is_array($val)) {
        $val = array_change_key_case($val, CASE_LOWER);
        if (isset($val[$http_verb])) {
          $val = $val[$http_verb];
        } else {
          continue;
        }
      }

      // Convert wildcards to RegEx
      $key = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);


      // Does the RegEx match?
      if (preg_match('#^' . $key . '$#', $uri, $matches)) {

        // Are we using callbacks to process back-references?
        if (!is_string($val) && is_callable($val)) {
          // Remove the original string from the matches array.
          array_shift($matches);

          // Execute the callback using the values in matches as its parameters.
          $val = call_user_func_array($val, $matches);
        }
        // Are we using the default routing method for back-references?
        elseif (strpos($val, '$') !== FALSE && strpos($key, '(') !== FALSE) {
          $val = preg_replace('#^' . $key . '$#', $val, $uri);
        }
        $val = '/' . ltrim($val, '/');

        $this->_set_request(explode('/', $val));
        return;
      }
    }

    // If we got this far it means we didn't encounter a
    // matching route so we'll set the site default route
    $this->_set_request(array_values($_segment));
  }
  private function _set_request($_segment = array())
  {

    $GLOBALS['_segment_glo']  = $_segment;
    $controller = '/controller';
    $con = $_segment[1];

    if (!empty($con)) {

      // $this->$_segment = $_segment;
      if (file_exists(APPPATH . 'module/' . $con . $controller . DIRECTORY_SEPARATOR . $con . '.php')) {

        require_once APPPATH . 'module/' . $con . $controller . DIRECTORY_SEPARATOR . $con . '.php';

        if (class_exists($con)) {
          $_fn = 'index';
          if (!empty($_segment[2])) {
            $_fn = $_segment[2];
          }

          $_class = new $con;

          $_attr = [];
          if (count($_segment) > 3) {
            for ($i = 3; $i < count($_segment); $i++) {
              $_attr[] = $_segment[$i];
            }
          }

          $view_folder =  APPPATH . 'module/' . $con . DIRECTORY_SEPARATOR . 'view';
          define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR);



          if (method_exists($_class, $_fn)) {
            // $_class->$_fn();
            // call_user_func_array(array($foo, "bar"), array("three", "four"));
            call_user_func_array([$_class, $_fn], $_attr);
          } else {
            header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
            echo "Please Check your's URL.1";
            echo "<br>";
            echo $_SERVER['HTTP_REFERER'];
            echo "<script>alert('505 : เกิดข้อผิดพลาด กรุณาลองอีกครั้ง')</script>";
            echo "<script>window.close();</script>";
            exit(3); // EXIT_CONFIG
          }
        } else {
          header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
          echo "Please Check your's Class Name to be like file name";
          exit(3); // EXIT_CONFIG
        }
      } else {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo "Please Check your's URL.2";
        echo "<br>";
        echo $_SERVER['HTTP_REFERER'];
        echo "<br>";
        echo "<pre>";
        print_r(json_encode($_segment));
        echo "</pre>";
        header('Location: https://sso-uat.ditp.go.th/sso/error?err='.json_encode($_segment).'&referer='.$_SERVER['HTTP_REFERER']);
        exit(3); // EXIT_CONFIG
      }
    }
  }
}
