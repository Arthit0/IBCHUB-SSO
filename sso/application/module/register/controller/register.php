<?php

class register extends Controller
{

  function __construct()
  {
    parent::__construct();

    // if (empty($_SESSION['client_id'])) {
    //   redirect(BASE_URL);
    //   exit(); application\module\register\controller\register.php
    // }

    // code...

    $this->get_model('reg_model');
    
    $error = 0;
    $error_mess = '';

    $client_id = $this->get('client_id');
    if ($client_id) {
      $this->reg_model->ck_client_id($client_id);
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
    $this->get_template();
    if ($error && empty($this->get('q'))) {
      // echo "test";
      // $this->template->main('error', ['mess' => $error_mess]);
      
      header( "location: ".BASE_URL."auth/expired" );
      exit();
    }

    
    // $this->get_library('lb_main'); https://drive.ditp.go.th/th-th/

  }

  function index()
  {
    $_SESSION['p_t'] = 'SSO | สมัครสมาชิก';
    $this->template->home('new_login','register', []);
    
  }

  function getUrl() {
    if ($_SESSION['client_id']&& $_SESSION['response_type'] && $_SESSION['redirect_uri']) {
      $res = [
        'res_code' => '00',
        'res_text' => 'success',
        'res_result' => "/auth?response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri']."&state=".$_SESSION['state']
      ];
      $this->respone_json($res);
    } else {
      $res = [
        'res_code' => '01',
        'res_text' => 'error!',
        'res_result' => "/auth?response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/ck_portal&state=1"
      ];
      $this->respone_json($res);
    }

  }
  function ck_laser () {
    $data = $this->reg_model->laser_validation();
    $this->respone_json($data);

  }
  function add_member()
  {
    // header('Content-Type: application/json');
  
    $data = $this->reg_model->add_reg();
    $this->respone_json($data);
  }

  function add_member_con()
  {
     
    // header('Content-Type: application/json');
    $data = $this->reg_model->con_reg();
    $this->respone_json($data);
  }
  function ck_com_dbd()
  {
    $cid = $this->post('cid');
    // print_r($cid);
    // die();
    if(empty($cid)){
      $this->respone_json([]);
    }else {
      $data = $this->reg_model->ck_com_dbd($cid);
      $this->respone_json($data);
    }
 
  }

    /******** dropdown position **********/
  function get_position(){
    $data = $this->reg_model->get_position_model();
    $this->respone_json($data);
  }

  /******** dropdown provice **********/
  function get_provinces(){
    $data = $this->reg_model->get_provinces_model();
    $this->respone_json($data);
  }
  function get_provincestest(){
    $data = $this->reg_model->get_provinces_modeltest();
    $this->respone_json($data);
  }
  function get_districtstest(){
    $data = $this->reg_model->get_districts_modeltest();
    $this->respone_json($data);
  }
  function get_amphurestest(){
    $data = $this->reg_model->get_amphures_modeltest();
    $this->respone_json($data);
  }
  /********* dropdown amphures **********/
  function get_amphures(){
    $data = $this->reg_model->get_amphures_model();
    $this->respone_json($data);
  }

  /********* dropdown amphures **********/
  function get_districts(){
    $data = $this->reg_model->get_districts_model();
    $this->respone_json($data);
  }

  /********* zip_code **********/
  function get_zipcode(){
    $data = $this->reg_model->get_zipcode_model();
    $this->respone_json($data);
  }

  function get_address_from_zipcode(){
    // echo $this->post('postcode');
    $data = $this->reg_model->get_address_from_zipcode_model();
    $this->respone_json($data);
  }

  function get_address_from_zipcode_district(){
    // echo $this->post('postcode');
    $data = $this->reg_model->get_address_from_zipcode_district_model();
    $this->respone_json($data);
  }

  function login_after_reg(){
    $data = $this->reg_model->model_login_after_reg();
    return true;
    //$this->respone_json($data);
  }

  function email_verify(){
    $data = $this->reg_model->model_email_verify($this->post('cid'));
    $this->respone_json($data);
  }

  function send_email_verify() { 
    $data = $this->reg_model->model_send_mail_verify();
    $this->respone_json($data);
  }

  function verify_email(){

    if ($this->get('state') == 'portal') {
      
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => BASE_URL.'index.php/api/verify',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('token_verify' => $this->get('q'),'ref_code' => $this->get('ref'),'target' => $this->get('state')),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      $res = json_decode($response);

      if (!empty($res)) {
        $this->template->home('new_login','email_verified', ['res' => $res, 'state' => $this->get('state')]);
      }
      
    } else {
      $ck_token = $this->reg_model->model_ck_token($this->get('q'), $this->get('ref'), $this->get('redirect_uri'), $this->get('response_type'), $this->get('client_id'), $this->get('state'));
      $this->template->home('new_login','email_verified', ['res' => $ck_token]);
    }
    
  }

  function sms_verify(){
    $data = $this->reg_model->model_sms_verify($this->post('cid'));
    $this->respone_json($data);
  }

  function send_sms_verify() { 
    $data = $this->reg_model->model_send_sms_verify();
    $this->respone_json($data);
  }

  function verify_sms(){
    $data = $this->reg_model->model_verify_sms();
    $this->respone_json($data);
  }

   /********* coutry **********/
   function get_country(){
    $data = $this->reg_model->get_country_model();
    $this->respone_json($data);
  }
  function ck_member(){
    $data = $this->reg_model->ck_member_model();
    $this->respone_json($data);
  }

  function testinsert(){
    $data = $this->reg_model->testinsert();
    $this->respone_json($data);
  }

}
