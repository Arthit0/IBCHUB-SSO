<?php

/**
 *
 */
class Controller
{

  // private $_segment;
  public $config;
  function __construct()
  {

    // $this->_segment = $_segment;
    $this->config = new Config();
  }
  function view($path = '', $data = array())
  {
    if (is_array($data)) {
      extract($data);
    }

    // include(DIRECTORY_SEPARATOR.$path.'.php');
    $_ci_path = VIEWPATH . $path . '.php';
    if (file_exists($_ci_path)) {
      if (!is_php('5.4') && !ini_get('short_open_tag') && config_item('rewrite_short_tags') === TRUE) {
        echo eval('?>' . preg_replace('/;*\s*\?>/', '; ?>', str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
      } else {
        include($_ci_path); // include() vs include_once() allows for multiple views with the same name
      }
    }
  }
  function paser($path = '', $data = array())
  {
    if (is_array($data)) {
      extract($data);
    }
    $_ci_path = VIEWPATH . $path . '.php';

    if (file_exists($_ci_path)) {
      return eval('?>' . preg_replace('/;*\s*\?>/', '; ?>', str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
    } else {
      return FALSE;
    }
  }

  function get_model($model_name)
  {

    $modelpath = APPPATH . 'module/' . $this->segment(1) . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . $model_name . '.php';

    if (file_exists($modelpath)) {
      require_once $modelpath;

      $this->$model_name = new $model_name;
    } else {
      header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
      echo "Call Model Error.";
      exit(3); // EXIT_CONFIG
    }
  }

  function get_library($lb_name)
  {
    static   $lb_val;
    if (empty($lb_val)) {
      $lbpath = APPPATH . 'library' . DIRECTORY_SEPARATOR . $lb_name . '.php';

      if (file_exists($lbpath)) {
        require_once $lbpath;

        $this->$lb_name = new $lb_name;
        $lb_val = $this->$lb_name;
      } else {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo "Call Model Error.";
        exit(3); // EXIT_CONFIG
      }
    }
  }
  function get_template()
  {
    static   $tp_val;
    if (empty($tp_val)) {
      $lbpath = APPPATH . 'module/template/controller' . DIRECTORY_SEPARATOR .  'template.php';

      if (file_exists($lbpath)) {
        require_once $lbpath;

        $this->template = new template;
        $tp_val = $this->template;
      } else {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo "Call Model Error.";
        exit(3); // EXIT_CONFIG
      }
    }
  }

  public function segment($i = '')
  {
    $_segment_glo = $GLOBALS['_segment_glo'];

    $_segment = $_segment_glo;
    $return = '';

    if (!empty($_segment[$i])) {
      $return = $_segment[$i];
    }
    return $return;
  }
  /*** ค่า GET ***/
  public function get($key = '', $null = '')
  {
    if (isset($_GET[$key])) {
      $return = trim(rawurldecode($_GET[$key]));
    } else {
      $return = trim($null);
    }

    return $return;
  }
  /*** ค่า POST ***/
  public function post($key = '', $null = '')
  {

    if (isset($_POST[$key])) {
      $p = $_POST[$key];
      if (is_array($p)) {
        $return = $p;
      } else {
        $return = trim($p);
      }
    } else {
      $return = trim($null);
    }

    return $return;
  }

  function get_header($name = '')
  {
    static $arr_header;
    if (empty($arr_header)) {
      // $arr_header = getallheaders();

      $header = getallheaders();
      $arr_header = [];
      foreach ($header as $key => $value) {
        $key = strtolower(str_replace('-', '_', $key));
        $arr_header[$key] = $value;
      }
    }
    if (empty($arr_header[$name])) {
      $return = '';
    } else {
      $return = trim($arr_header[$name]);
    }
    return $return;
  }

  function respone_json($data = [], $code = 200)
  {
    header('Content-Type: application/json');
    http_response_code($code);
    if (is_array($data)) {
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
      echo $data;
    }

    exit();
  }
  function isAssoc($arr = [])
  {
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
  }
}
