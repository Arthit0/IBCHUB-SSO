<?php
class api extends Controller
{

  function __construct()
  {
    parent::__construct();
    $func = $this->segment(2);
    if (empty($func)) {
      $func = 'index';
    }
    $func = $func . "_" . strtolower($_SERVER['REQUEST_METHOD']);

    if (method_exists($this, $func)) {
      $this->get_model('api_model');
      $this->$func();
    } else {
      http_response_code(404);
      echo json_encode(['error' => "Page Not Found."]);
      exit(3); // EXIT_CONFIG
    }
    exit();
  }
  private function respone($data = [], $code = 200)
  {
    http_response_code($code);
    echo json_encode($data);
    exit();
  }

  function index_get()
  {
  }

  function moc_id_post()
  {

    $data = $this->api_model->ck_moc($sso_id);
    $this->respone($data);
 
  }

  function register_post()
  {
      $data = $this->api_model->api_insert_member($type);
      $this->respone($data);
   
  }
  function registest_post()
  {

      $data = $this->api_model->api_insert_test($type);
      $this->respone($data);
   
  }
  

  function token_post()
  {
    $_POST = json_decode(file_get_contents("php://input"), 1);
    $client_id = $this->post('client_id');
    $code = $this->post('code');
    if (empty($client_id) || empty($code)) {
      $this->respone(['res_code' => '01', 'res_text' => 'Not valiable.']);
    } else {
      $get_token = $this->api_model->get_token();
      $this->respone($get_token);
    }
  }
  function getinfo_get()
  {

    $client_id = $this->get_header('client_id');
    $code = $this->get_header('code');



    if (empty($client_id) || empty($code)) {
      $this->respone(['res_code' => '01', 'res_text' => 'Not valiable.']);
    } else {
      $get_token = $this->api_model->get_info($client_id, $code);
      $this->respone($get_token);
    }
    
  }

  function getinfoportal_get()
  {
    
    $client_id = $this->get_header('client_id');
    $code = $this->get_header('code');

    if (empty($client_id) || empty($code)) {
      $this->respone(['res_code' => '01', 'res_text' => 'Not valiable.']);
    } else {
      $get_token = $this->api_model->get_info_portal($client_id, $code);
      $this->respone($get_token);
    }
    
  }

  function onegetinfo_post(){
    $cid = $this->post('cid');
    // echo "<pre>" ;
    // print_r($cid);
    // echo "</pre>" ;
    // exit();
    if($cid){
      $data = $this->api_model->one_get_info($cid);
      $this->respone($data);
    }else{
      $this->respone(['res_code' => '01', 'res_text' => 'Not valiable.']);
    }
    
  }

  function createtoken_get(){
    $client_id = $this->get_header('client_id');
    $code = $this->get_header('code');
    if (empty($client_id) || empty($code)) {
      $this->respone(['res_code' => '01', 'res_text' => 'Not valiable.']);
    } else {
      $create_token = $this->api_model->create_token($client_id, $code);
      $this->respone($create_token);
    }
  }

  function member_update_post(){
    $data = $this->api_model->model_member_update();
    $this->respone($data);
  }

  function userupdate_post(){
    $client_id = $this->post('client_id');
    $username = $this->post('username');
    $password = $this->post('password');

    if (empty($client_id)){
      $this->respone(['res_code' => '01', 'res_text' => 'client_id is require']);
    }else if (empty($username)) {
      $this->respone(['res_code' => '01', 'res_text' => 'username is require']);
    } elseif(empty($password)){
      $this->respone(['res_code' => '01', 'res_text' => 'password is require']);
    }else {
      $data = $this->api_model->model_user_update($client_id, $username, $password);
      $this->respone($data);
    }
  }
  function cronjob_member_get()
  {
      $get_token = $this->api_model->cronjob_member();
      $this->respone($get_token);
    
    
  }
  function getinfo_company_post(){
    $data = $this->api_model->model_getinfo_company();
    $this->respone($data);
  }
  function update_member_get()
  {
    $msg=file_get_contents('php://input') ;
      $get_token = $this->api_model->update_member($client_id, $code,$msg);
      $this->respone($get_token);
    
    
  }
  function getTextCancel_get(){
      $data = $this->api_model->model_getTextCancel();
      $this->respone_json($data);
  }
  function TextCancel_post(){
    $ssoid = $this->post('ssoid');
    $text_th = $this->post('text_th');
    $text_en = $this->post('text_en');

    if(!empty($ssoid) & !empty($text_th) & !empty($text_en)){
      $data = $this->api_model->model_TextCancel($ssoid,$text_th,$text_en);
    }else {
      $data = [ "status" => 400, "message" => "Not found" ];
    }
    $this->respone_json($data);
}
  function ck_com_dbd_get()
  {
    $msg=file_get_contents('php://input') ;
    $cid = $this->get('cid');
    $client_id = $this->get('client_id');
      $get = $this->api_model->ck_com_dbd($cid,$client_id);
      $this->respone_json($get);
  }
  function send_mail_post(){
    $data = $this->api_model->model_send_mail();
    $this->respone_json($data);
  }
  function check_otp_post(){
    $data = $this->api_model->model_check_otp();
    $this->respone_json($data);
  }
  function restore_account_post(){
    $data = $this->api_model->model_restore_account();
    $this->respone_json($data);
  }
  function remarkCancel_post(){
    $data = $this->api_model->model_remarkCancel();
    $this->respone_json($data);
  }
  function userinfo_post(){
    $data = $this->api_model->model_userinfo();
    $this->respone_json($data);
  }
  function userinfo_portal_post(){
    $data = $this->api_model->model_userinfo_portal();
    $this->respone_json($data);
  }
  function send_verify_post() { 
    $data = $this->api_model->model_send_mail_verify();
    $this->respone_json($data);
  } 

  function send_verify_bak_post() { 
    $data = $this->api_model->model_send_mail_verify_bak();
    $this->respone_json($data);
  } 
  
  function verify_post(){
    $ck_token = $this->api_model->model_ck_token();
      $this->respone_json($ck_token);
  }
  function ImagesService_post(){
    $ck_token = $this->api_model->model_ImagesService();
      $this->respone_json($ck_token);
  }
  function BalanceService_post(){
    $ck_token = $this->api_model->model_BalanceService();
      $this->respone_json($ck_token);
  }
  function getClient_get(){
      $Client = $this->api_model->model_getClient();
      $this->respone_json($Client);
  }
  function getAttachment_get(){
    $Client = $this->api_model->model_getAttachment();
    $this->respone_json($Client);
  }
}
