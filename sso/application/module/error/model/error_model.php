<?php

require APPPATH.'/library/PHPMailer_v5.0.2/class.phpmailer.php';
use \Firebase\JWT\JWT;

class error_model extends Model
{
  function __construct()
  {
    define('FILEPATH', '/home/ssodev/www/sso/');
    parent::__construct();
  }

}
