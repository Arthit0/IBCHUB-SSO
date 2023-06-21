 
 <?php
 error_reporting(0);
  if($_SERVER['HTTPS']!="on"){
    $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location:$redirect");
  }
  define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
  //define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
  /*
*---------------------------------------------------------------
* ERROR REPORTING
*---------------------------------------------------------------
*
* Different environments will require different levels of error reporting.
* By default development will show errors but testing and live will hide them.
*/
  switch (ENVIRONMENT) {
    case 'development':
      error_reporting(0);
      ini_set('display_errors', 1);
      break;

    case 'testing':
    case 'production':
      //ini_set('display_errors', 0);display_errors = Off
      ini_set('display_errors', 1);
      if (version_compare(PHP_VERSION, '5.3', '>=')) {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
      } else {
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
      }
      break;

    default:
      header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
      echo 'The application environment is not set correctly.';
      exit(1); // EXIT_ERROR
  }
  ini_set('display_errors', 0);
  ini_set('display_startup_errors', 0);
  error_reporting(0);

  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);
 
  $application_folder = 'application';
  $system_path = 'system';

  define('BASEPATH', $system_path . DIRECTORY_SEPARATOR);
  define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);


  // preg_match('/module[.][a-z0-9A-Z]{1,}[\/][^.]+\.[^.]+$/', $_SERVER['REQUEST_URI'], $matches, PREG_UNMATCHED_AS_NULL);
  preg_match('/module[.][a-z0-9A-Z]{1,}[\/][^.]+\.[^.]+$/', $_SERVER['REQUEST_URI'], $matches);



  require_once 'vendor/autoload.php';
  require_once BASEPATH . 'system.php';
  // $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."sso";
  // header("Location:$redirect");
  ?>
