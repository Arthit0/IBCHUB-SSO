<?php

use \Firebase\JWT\JWT;

class auth extends Controller
{

  function __construct()
  {
    parent::__construct();
    // code...
    $this->get_model('auth_model');
    $this->get_template();

  }
  function expired () {
    $this->template->home('new_login','session_expired');
  }
  function index()
  {
    
    $error = 0;
    $error_mess = '';
    if ((!isset($_GET['client_id']) || !isset($_GET['redirect_uri']) || !isset($_GET['response_type'])) && (!isset($_SESSION['client_id']) && !isset($_SESSION['response_type']) && !isset($_SESSION['redirect_uri']))) {
      echo "<script>
      alert('ไม่พบ Url ปลายทาง');
      window.location.href='".BASE_URL."index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/ck_portal&state=1';
      </script>";
    } elseif ((!isset($_GET['client_id']) || !isset($_GET['redirect_uri']) || !isset($_GET['response_type'])) && isset($_SESSION['client_id']) && isset($_SESSION['response_type']) && isset($_SESSION['redirect_uri'])) {
      header( "location: ".BASE_URL."index.php/auth?response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=". $_SESSION['redirect_uri']);
    }
    if (isset($_GET['client_id']) && isset($_GET['redirect_uri']) && isset($_GET['response_type'])) {
      $_SESSION['client_id'] = $this->get('client_id');
      $_SESSION['response_type'] = $this->get('response_type');
      $_SESSION['redirect_uri'] = $this->get('redirect_uri');
    }

    $client_id = $this->get('client_id');
    if ($client_id) {


      $this->auth_model->ck_client_id($client_id);
      
    }

    if (empty($_SESSION['client_id'])) {
      $error = 1;
    }
    $response_type = $this->get('response_type');

    if (in_array(strtoupper($response_type), ['CODE', 'TOKEN']) || isset($_SESSION['response_type'])) {
      if (!empty($response_type)) {
        $_SESSION['response_type'] = $response_type;
      }
    } else {
      $error = 1;
    }
    $redirect_uri = $this->get('redirect_uri');
    if (!empty($redirect_uri)) {
      $_SESSION['redirect_uri'] = $redirect_uri;
    }
    $state = $this->get('state');

    $_SESSION['state'] = $state;

    if ($error) {
      // $this->template->main('error', ['mess' => $error_mess]);
      //ถ้า ไม่เจอ session ไปหน้า portal
      header( "location: ".BASE_URL."index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=https://sso.ditp.go.th/sso/portal/ck_portal&state=1" );
    } else {
      $_SESSION['p_t'] = 'DITP Single Sign-On';
      if ($this->get('client_id') == 'SS8663835' && ($_COOKIE['ssoid'] && !empty($_COOKIE['ssoid']))) {
        header( "location: ".BASE_URL."portal" );
      }

      $this->auth_model->gen_input_name();

      $this->template->home('new_login', 'login_page', ['client_name' => $client_name]);
    }
    // $this->test_model->get_test();
    // $data =  $this->paser('testview', ['test' => 123546]);
    // $data=[];

  }
  function test()
  {
    $key = "example_key";
    $payload = array(
      "iss" => "http://example.org",
      "aud" => "http://example.com",
      "iat" => 1356999524,
      "nbf" => 1357000000
    );

    /**
     * IMPORTANT:
     * You must specify supported algorithms for your application. See
     * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
     * for a list of spec-compliant algorithms.
     */
    $jwt = JWT::encode($payload, $key);
    try {
      $decoded = JWT::decode($jwt . '55', $key, array('HS256'));
    } catch (Exception $e) {
      $decoded = '';
    }


    print_r($jwt);
    die();
  }
  function forget()
  {
    //forgetpassword
    if(!empty($this->get('callback'))){
      $_SESSION['callback'] = $this->get('callback');
    }
    $this->template->home('new_login', 'forget', []);
  }
  function lang($lang)
  {
    $arr = ['th', 'en'];
    if (in_array($lang, $arr)) {
      $_SESSION['lang'] = $lang;
    }

    // $_SERVER['HTTP_REFERER']
    redirect($_SERVER['HTTP_REFERER']);
  }
  function lang_regis($lang)
  {
    $arr = ['th', 'en'];
    if (in_array($lang, $arr)) {
      $_SESSION['lang'] = $lang;
    }

    // $_SERVER['HTTP_REFERER']
    return true;
  }
  function client_name () {
    $client_id = $_SESSION['client_id'];
    $client_name = $this->auth_model->get_client_name($client_id);
    echo json_encode($client_name);
  }

  function login_()
  {
    $return = $this->auth_model->ck_login();
    echo json_encode($return);
  }

  function login_moc()
  {
    //   $return = 1;
    // echo json_encode($return);
    $return = $this->auth_model->ck_login_moc();
    echo json_encode($return);
  }

  function moccallback()
  {

    //  $return = 1;
    // echo json_encode($return);
    $return = $this->auth_model->moc_callback();
    echo json_encode($return);
  }

  function login_portal()
  {
    $return = $this->auth_model->ck_portal();
    echo json_encode($return);
  }

  // function login_moc()
  // {
  //   $return = $this->moc_model->ck_login();
  //   echo json_encode($return);

  // }
  
  //---------- version ส่งแค่ token -----------//
  function pre_changepassword(){

    /* 3 param
    1. client_id
    2. redirect_url
    3. token
    4. c_lang
    */
    $error = 0;
    $redirect_uri = "";
    $_SESSION['token'] = "";
    $_SESSION['member_id'] = "";
    $_SESSION['redirect_uri'] = "";

    $lang = $this->get('lang');

    if($lang != ''){
      $_SESSION['lang'] = $lang;
    }else{
      $_SESSION['lang'] = 'th';
    }
    
    $client_id = $this->get('client_id');
    ($client_id)? $this->auth_model->ck_client_id($client_id) : $error = 1;
    
    $token = $this->get('token');
    ($token)? $this->auth_model->ck_token($token) : $error = 1;

    $redirect_uri = $this->get('redirect_uri');
    if ($redirect_uri) {
      $_SESSION['redirect_uri'] = $redirect_uri;
      
    } else {
      //$redirect_uri = $this->auth_model->get_reurl();
      $error = 1;
    }

    //$arr = ['re_url' => $redirect_uri];
    if(($_SESSION['token'] == "") || ($_SESSION['client_id'] == "")) $error = 1;
    ($error == 1)? $this->template->main('error') : redirect("changepassword");
  }

  //---------- version ส่ง code เต็ม -----------//
  function ck_changepassword(){
    /* 3 param
    1. client_id
    2. redirect_url
    3. token
    4. c_lang
    */
    $error = 0;
    $redirect_uri = "";
    $_SESSION['token'] = "";
    $_SESSION['member_id'] = "";
    $_SESSION['redirect_uri'] = "";

    $lang = $this->get('lang');

    if($lang != ''){
      $_SESSION['lang'] = $lang;
    }else{
      $_SESSION['lang'] = 'th';
    }
    
    $client_id = $this->get('client_id');
    ($client_id)? $this->auth_model->ck_client_id($client_id) : $error = 1;
    
    $token = $this->get('token');
    ($token)? $this->auth_model->ck_code($token) : $error = 1;
    
    $redirect_uri = $this->get('redirect_uri');

    if ($redirect_uri) {
      $_SESSION['redirect_uri'] = $redirect_uri;
      
    } else {
      //$redirect_uri = $this->auth_model->get_reurl();
      $error = 1;
    }

    //$arr = ['re_url' => $redirect_uri];
    if(($_SESSION['token'] == "") || ($_SESSION['client_id'] == "")) $error = 1;
    ($error == 1)? $this->template->main('error', ['eiei']) : redirect("changepassword");
  }

  /************* Password **************/
  function changepassword()
  {
    // required 3 param
    /*
    1. $_SESSION[token]
    2. $_SESSION[client_id]
    3. $redirect_url
    */
   
    if((isset($_SESSION['token']) && isset($_SESSION['client_id']))){ //check Declared
      if(($_SESSION['token'] != "") || ($_SESSION['client_id'] != "")){ //check empty
        $this->template->home('new_login', 'change_password');
      }else{
        $this->template->main('error');
      }
    }else{
      $this->template->main('error');
    } 
  }

  function changepassword_save(){
    $data = $this->auth_model->model_newpassword();
    $this->respone_json($data);
  }
  function newpassword_save(){
    $data = $this->auth_model->model_resetpassword();
    $this->respone_json($data);
  }
  function checkloginSSO(){
    $data = $this->auth_model->model_checkloginSSO();
    $this->respone_json($data);
  }
  /********* UPDATE member SSO **********/
  function insert()
  {
    $data = $this->auth_model->model_insert();
    $this->respone_json($data);
    //echo json_encode($data);
    //$this->respone($data);
  }

  /**************  send mail ***************/
  function send_mail(){
    $data = $this->auth_model->model_send_mail();
    // echo json_encode($data);
    $this->respone_json($data);
  }
  
  function ck_mail(){
    $data = $this->auth_model->model_email_reset($this->post('member_cid'));
    echo json_encode($data);
  }

  /*********** reset password **************/
  function reset(){
    // if(isset($_SESSION['status_reset'])){
    //   $this->template->main('reset_password');
    // }else{
    //   $this->template->main('error');
    // }


    $_SESSION['callback'] = $this->get('callback');

    $ck_token = $this->auth_model->model_ck_token($this->get('q'), $this->get('ref_code'));
    if($ck_token['res_code'] == '00'){
      $this->template->home('new_login', 'reset_password');
    }else{
      $this->template->home('new_login','reset_fail', ['res' => $ck_token]);
    }
  }

  /********** check number 4 digit  ***********/
  function ck_number(){
    $number = $this->post('number');
    $return = [
      "status" => "01",
      "message" => "Not Match Number"
    ];

    if($_SESSION['number'] == $number){
      $return = [
        "status" => "00",
        "message" => "Match! Success"
      ];
    }
    echo json_encode($return);
    //echo json_encode(["number" => $number]);
  }

  /*********** save password_reset ************/
  function reset_save(){
    $data = $this->auth_model->model_reset_save();
    echo json_encode($data);
  }

  /*********** update member_id ************/
  function update_member(){
    $data = $this->auth_model->model_update_member();
    echo json_encode($data);
  }

  /*********** update member_id ************/
  function update_token(){
    $data = $this->auth_model->model_update_token();
    echo json_encode($data);
  }
  //--------- test ldap --------------//
  function check_ldap(){
    $data = $this->auth_model->model_check_ldap();
    $this->respone_json($data);
    // echo json_encode($data);
  }
  function send_mail_ditpOne(){
    $data = $this->auth_model->model_send_mail_ditpOne();
    $this->respone_json($data);
    // echo json_encode($data);
  }
  function testview()
  {
    //forgetpassword
    $this->template->main('testview',[]);
  }
  function check_dbd() {
    $data = $this->auth_model->ck_com_dbd($this->post('cid'));
    $this->respone_json($data);
  }
  function verify_director() {
    $data = $this->auth_model->model_verify_director($this->get('q'));
    if ($data['status_case'] == 99) {
      header( "location: https://sso.ditp.go.th/sso/index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=https://sso.ditp.go.th/sso/portal/ck_portal&state=1" );
    }
    $this->template->home('new_login','attorney', ['data' => $data]);
  }

  function director_send_sms_verify() { 
    $data = $this->auth_model->model_director_send_sms_verify();
    $this->respone_json($data);
  }

  function director_verify_sms(){
    $data = $this->auth_model->model_director_verify_sms();
    $this->respone_json($data);
  }
  function ck_laser () {
    $data = $this->auth_model->laser_validation();
    $this->respone_json($data);

  }

  function attach_file () {
    (!empty($this->get('q')))? $member_id = $this->get('q') : $member_id = $this->get('member_id');
    $data = $this->auth_model->model_attach_file($member_id);

    if (($data['director_status'] == 1 && $data['status_case'] == 2) || ($data['director_status'] == 1 && $data['status_case'] == 4)) {

      $this->template->home('new_login','attach_file',['user' => $data]);

    }else if ($data['director_status'] == 2 && ($data['status_case'] == 4 || $data['status_case'] == 1)) {
      $file = $this->auth_model->model_attach_file_get($member_id);
      // echo '<pre>';
      // var_dump(['user' => $data, 'file' => $file]);
      // echo '</pre>';
      // die;
      $this->template->home('new_login','attach_file_attorney',['user' => $data, 'file' => $file]);

    }else if (($data['director_status'] == 1 && $data['status_case'] == 5)) {
      $this->template->home('new_login','attach_file_fail',['user' => $data]);
    }else if (($data['director_status'] == 2 && $data['status_case'] == 5)) {
      $file = $this->auth_model->model_attach_file_get($member_id);
      foreach ($file as $key => $value) {
        if($value['type_file'] == 1){
          if($value['status'] == 1){
            $files1 = [
                'divclass' => "approved-file",
                'iclass' => "fa-regular fa-circle-check",
                'aclass' => "mitr-r _f16",
                'href' => "/sso/asset/attach/".$value['member_id']."/".$value['attachment_file_name'],
                'attachment' => $value['attachment'],
                'status' => $value['status']
            ];
            // `<div class=""><i class="fa-regular fa-circle-check"></i>&nbsp;<a class="mitr-r _f16" href="/sso/asset/attach/`.$value['member_id'].`/`.$value['attachment_file_name'].`" target="_blank">`.$value['attachment'].`</a></div>`;
          }else{
            $files1 = [
              'divclass' => "rejected-file",
              'iclass' => "fa-regular fa-circle-xmark",
              'aclass' => "mitr-r _f16",
              'href' => "/sso/asset/attach/".$value['member_id']."/".$value['attachment_file_name'],
              'attachment' => $value['attachment'],
              'status' => $value['status']
          ];
            // $files1 = `<div class="rejected-file"><i class="fa-regular fa-circle-xmark"></i>&nbsp;<a class="mitr-r _f16" href="/sso/asset/attach/`.$value['member_id'].`/`.$value['attachment_file_name'].`" target="_blank">`.$value['attachment'].`</a></div>`;
          }
        }else{
          if($value['status'] == 1){
            $files2 = [
              'divclass' => "approved-file",
              'iclass' => "fa-regular fa-circle-check",
              'aclass' => "mitr-r _f16",
              'href' => "/sso/asset/attach/".$value['member_id']."/".$value['attachment_file_name'],
              'attachment' => $value['attachment'],
              'status' => $value['status']
          ];
            // $files2 = `<div class="approved-file"><i class="fa-regular fa-circle-check"></i>&nbsp;<a class="mitr-r _f16" href="/sso/asset/attach/`.$value['member_id'].`/`.$value['attachment_file_name'].`" target="_blank">`.$value['attachment'].`</a></div>`;
          }else{
            $files2 = [
              'divclass' => "rejected-file",
              'iclass' => "fa-regular fa-circle-xmark",
              'aclass' => "mitr-r _f16",
              'href' => "/sso/asset/attach/".$value['member_id']."/".$value['attachment_file_name'],
              'attachment' => $value['attachment'],
              'status' => $value['status']
            ];
            // $files2 = `<div class="rejected-file"><i class="fa-regular fa-circle-xmark"></i>&nbsp;<a class="mitr-r _f16" href="/sso/asset/attach/`.$value['member_id'].`/`.$value['attachment_file_name'].`" target="_blank">`.$value['attachment'].`</a></div>`;
          }
        }
      }
      $files =[
        'files1'=>$files1,
        'files2'=>$files2
      ];
      // echo '<pre>';
      // var_dump($files);
      // echo '</pre>';
      // die;
      $this->template->home('new_login','attach_file_attorney_fail',['user' => $data, 'file' => $files]);
      
    } else {
      header( "location: https://sso.ditp.go.th/sso/index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=https://sso.ditp.go.th/sso/portal/ck_portal&state=1");
    }
    
  }

  function upload_attach_file () {
    $data = $this->auth_model->model_upload_attach_file();
    $this->respone_json($data);
  }

  function director_form () {
    $data = $this->auth_model->model_verify_director($this->get('q'));

    $this->template->home('new_login','director_form', ['data' => $data]);
  }

  function director_form_send() {
    $data = $this->auth_model->model_director_form_send();
    $this->respone_json($data);
  }

  function director_change_status() { 
    $data = $this->auth_model->model_director_change_status();
    $this->respone_json($data);
  }

  function redirect_log () {
    $data = $this->auth_model->model_redirect_log($this->post('url'), $this->post('pid'), $this->post('slug'), $this->post('detail'));
    return respone_json($data);
  }
}
