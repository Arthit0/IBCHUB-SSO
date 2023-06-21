<?php

use \Firebase\JWT\JWT;

class office extends Controller
{

  function __construct()
  {
    parent::__construct();
    // code...
    $this->get_model('office_model');
    $this->get_template();

  }

  function index()
  {
    $_SESSION['page'] = "dashboard";
    if(isset($_SESSION['id_admin'])){
      // echo "Hi user";
      $this->template->main('dashboard', []);
    }else{
      //$this->template->main('error', ['mess' => '$error_mess']);
      $this->template->home('new_login','login_page', []);

    }
  }
  function dashboard(){
    $_SESSION['page'] = "dashboard";
    if(isset($_SESSION['id_admin'])){
      $this->template->main('dashboard', []);
    }else{
      //$this->template->main('error', ['mess' => '$error_mess']);
      $this->template->main('error');

    }
  }

  function test(){
    $this->template->main('adminLTE', []);
  }
  function login(){
    $return = $this->office_model->ck_login();
    echo json_encode($return);
  }

  function user(){
    $_SESSION['page'] = "user";
    if(isset($_SESSION['id_admin'])){
      $this->template->main('user_manage', []);
    }else{
      //$this->template->main('error', ['mess' => '$error_mess']);
      $this->template->main('error');

    }
  }
  function cancel(){
    $_SESSION['page'] = "cancel";
    if(isset($_SESSION['id_admin'])){
      $this->template->main('cancel_member', []);
    }else{
      //$this->template->main('error', ['mess' => '$error_mess']);
      $this->template->main('error');

    }
  }

  function client(){
    $_SESSION['page'] = "client";
    if(isset($_SESSION['id_admin'])){
      //echo "Hi user";
      $this->template->main('client_manage', ["eiei"=>'eiei']);
    }else{
      //$this->template->main('error', ['mess' => '$error_mess']);
      $this->template->main('error');

    }
  }

  function logout(){
    unset($_SESSION['id_admin']);
    $this->template->main('login_page', []);
  }

  function data_table(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_data_table();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function data_table_client(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_data_table_client();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }
  function data_table_cancel(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_data_table_cancel();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }
  function edit_member(){
    $member_id = $this->get('id');
    $type = $this->get('type');
    if(isset($_SESSION['id_admin']) && $member_id != ""){
      $data = $this->office_model->model_edit_user_data($member_id,$type);
      //print_r($data); die();
      $data1 = $data['member'];
      $data2 = $data['member_type'];
      $result = [
        'member' => $data1,
        'member_type' => $data2
      ];
      $this->template->main('edit_member', $result);
    }else{
      $this->template->main('error');
    }
  }
  function delete_user(){
    $sso_id = $this->post('sso_id');
    if(isset($_SESSION['id_admin']) && $sso_id != ""){
      $data = $this->office_model->model_delete_user($sso_id);
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function edit_client(){
    $mc_id = $this->get('id');
    if(isset($_SESSION['id_admin']) && $mc_id != ""){
      $data = $this->office_model->model_edit_client_data($mc_id);
      $this->template->main('edit_client',$data);
    }else{
      $this->template->main('error');
    }
  }

  function save_edit_member(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_save_edit_member();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }


  function save_edit(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_save_edit();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function save_add(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_save_add();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function save_add_member(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_save_add_member();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function add_client(){

    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_gen_client_id();
      $this->template->main('add_client',$data);
    }else{
      $this->template->main('error');
    }
  }

  function edit_text(){
    $data = $_SESSION['id_admin'];
    $text_th = '';
    $text_en = '';
    if(isset($_SESSION['id_admin'])){
      $text = $this->office_model->model_edit_cancel();
      if(!empty($text)){
        $text_th = $text[0]['text_th'];
        $text_en = $text[0]['text_en'];
      }
      $this->template->main('edit_cancel',[$data,$text_th,$text_en]);
    }else{
      $this->template->main('error');
    }
  }

  function add_member(){
    if(isset($_SESSION['id_admin'])){
      $this->template->main('add_member');
    }else{
      $this->template->main('error');
    }
  }
  function edit_password(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_edit_password();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function reset_password_success(){
    $this->template->main('reset_password_success');
  }
  function DITP_SSO_Account(){
    $data = $this->office_model->SSO_Account(); 
    $this->respone_json($data);
  }
  function statistics(){
    $data = $this->office_model->statisticsLog_App(); 
    $this->respone_json($data);
  }
  function search(){
    $data = $this->office_model->searchData(); 
    $this->respone_json($data);
  }
  function ChartConfirm(){
    $data = $this->office_model->ChartConfirm(); 
    $this->respone_json($data);
  }
  function ChartTypeMember(){
    $data = $this->office_model->ChartTypeMember(); 
    $this->respone_json($data);
  }
  function ChartTypeMemberV2(){
    $data = $this->office_model->ChartTypeMemberV2(); 
    $this->respone_json($data);
  }
  function ChartTypeV2(){
    $data = $this->office_model->ChartType(); 
    $this->respone_json($data);
  }
  function ChartRegios(){
    $data = $this->office_model->Regios(); 
    $this->respone_json($data);
  }
  function testApi(){
    $data = $this->office_model->testApi(); 
    $this->respone_json($data);
  }
}