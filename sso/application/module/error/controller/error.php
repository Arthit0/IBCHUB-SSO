<?php

use \Firebase\JWT\JWT;

class error extends Controller
{

  function __construct()
  {
    parent::__construct();
    // code...
    $this->get_model('error_model');
    $this->get_template();

  }
  function index()
  {

    $this->template->home('new_login', 'session_expired', ['referer' => $this->get('referer')]);

  }

}
