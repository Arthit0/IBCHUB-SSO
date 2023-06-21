<?php
session_start();
require_once(APPPATH . 'config/database.php');
require_once(APPPATH . 'config/config.php');



require_once BASEPATH . 'Commom.php';
require_once BASEPATH . 'Controller.php';
require_once BASEPATH . 'db.php';
require_once BASEPATH . 'Model.php';
require_once BASEPATH . 'Route.php';







function is_php($version)
{
  static $_is_php;
  $version = (string) $version;

  if (!isset($_is_php[$version])) {
    $_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
  }

  return $_is_php[$version];
}

function lang($word = '')
{
  static  $lg, $arr_lg;

  if (empty($_SESSION['lang'])) {
    $lang = 'th';
  } else {
    $lang = $_SESSION['lang'];
  }
  if ($lg != $lang) {
    $file_path = 'lang/lang_' . $lang . '.php';
    if (file_exists($file_path)) {
      require_once($file_path);

      $arr_lg = $lang_page;
    }
  }
  $return = '';
  if (!empty($arr_lg[$word])) {
    $return = $arr_lg[$word];
  }

  $lg = $lang;

  return $return;
}

function titleTH_to_titleEN ($title) {
  switch ($title) {
    case 'นาย':
      echo "Mr.";
      break;
    case 'นาง':
      echo "Mrs.";
      break;
    case 'นางสาว':
      echo "Miss";
      break;    
  }
}

function pr ($arr) {
  echo "<pre>";
    print_r($arr);
  echo "</pre>";
}

function redirect($name = '/')
{
  header("location: " . $name);
  exit(0);
}

$_route = new Route;

$_route->_parse_routes();
