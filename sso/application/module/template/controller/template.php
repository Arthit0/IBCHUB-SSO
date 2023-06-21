<?php

class template 
{

  function __construct()
  {
    // parent::__construct();
    // // code...
    // $this->get_model('portal_model');
    // // $this->get_library('lb_main');
    // $_SESSION['info'] = [];
    // if (!empty($_COOKIE['ssoid'])) {
    //   $_SESSION['info'] = $this->portal_model->user_info();
    // }

  }

  function main($view = '', $data = [])
  {

    $this->view('main', ['path' => $view, 'data' => $data]);
  }

  function home($template, $view = '', $data = [])
  {

    $this->view($template, ['path' => $view, 'data' => $data]);
  }


  function view($pathh = '', $data = array())
  {

    if (is_array($data)) {
      extract($data);
    }

    // include(DIRECTORY_SEPARATOR.$path.'.php');
    $_ci_path_tp = APPPATH . 'module/template/view' . DIRECTORY_SEPARATOR . $pathh . '.php';

    if (file_exists($_ci_path_tp)) {
      if (!is_php('5.4') && !ini_get('short_open_tag') && config_item('rewrite_short_tags') === TRUE) {
        echo eval('?>' . preg_replace('/;*\s*\?>/', '; ?>', str_replace('<?=', '<?php echo ', file_get_contents($_ci_path_tp))));
      } else {
        include($_ci_path_tp); // include() vs include_once() allows for multiple views with the same name
      }
    }
  }
}
