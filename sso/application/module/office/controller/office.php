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
      // var_dump($_SESSION['is_true_path'],BASE_URL,BASE_URL."404");
      // die;
    if (empty($_SESSION['is_true_path']) && !$_SESSION['is_true_path'] ) {
      header("location: ".BASE_URL."404"); 
    }

  }

  function backoffice_test () {
    $this->template->home('office', 'backoffice-test', []);
  }

  function index()
  {
    $_SESSION['page'] = "user_manage";
 
    if(isset($_SESSION['id_admin'])){
          // echo "Hi user";
      $this->template->main('user_manage', ['type' => 1, 'title' => 'นิติบุคคล (ไทย)']);
      // $this->template->main('dashboard', []);
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
      $type = $this->get('type');
      $title = 'นิติบุคคล (ไทย)';
      switch ($type) {
        case 1:
          $title = 'นิติบุคคล (ไทย)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 2:
          $title = 'นิติบุคคล (ต่างชาติ)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 3:
          $title = 'บุคคลทั่วไป (ไทย)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 4:
          $title = 'บุคคลทั่วไป (ต่างชาติ)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 5:
          $title = 'อื่นๆ';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 6:
          $title = 'นิติบุคคลไม่ได้จดทะเบียน (ไทย)';
          $_SESSION['page'] = 'usertype'.$type;
          break;

      }
      $this->template->main('user_manage', ['type' => $type, 'title' => $title]);
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
      $this->template->main('client_manage', ["test"=>'test']);
    }else{
      //$this->template->main('error', ['mess' => '$error_mess']);
      $this->template->main('error');

    }
  }

  function admin(){
    $_SESSION['page'] = "admin";
    if(isset($_SESSION['id_admin'])){
      //echo "Hi user";
      $this->template->main('admin_manage', ["test"=>'test']);
    }else{
      //$this->template->main('error', ['mess' => '$error_mess']);
      $this->template->main('error');

    }
  }

  function logout(){
    unset($_SESSION['id_admin']);
    header("location: ".BASE_URL."office"); 
  }

  function data_table(){
    if(isset($_SESSION['id_admin'])){
      $type = $this->get('type');
      $data = $this->office_model->model_data_table($type);
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }
  function getAttachment(){
    if(isset($_SESSION['id_admin'])){
      $id = $this->get('id');
      $data = $this->office_model->model_getAttachment($id);
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function saveAttachment(){
    if(isset($_SESSION['id_admin'])){
      $id = $this->post('member_id');
      $data = $this->office_model->model_saveAttachment($id);
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

  function data_table_admin(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_data_table_admin();
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
  function detail_member(){
    $member_id = $this->get('id');
    $type = $this->get('type');
    if(isset($_SESSION['id_admin']) && $member_id != ""){
      switch ($type) {
        case 1:
          $title = 'นิติบุคคล (ไทย)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 2:
          $title = 'นิติบุคคล (ต่างชาติ)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 3:
          $title = 'บุคคลทั่วไป (ไทย)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 4:
          $title = 'บุคคลทั่วไป (ต่างชาติ)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 6:
          $title = 'นิติบุคคลไม่ได้จดทะเบียน (ไทย)';
          $_SESSION['page'] = 'usertype'.$type;
          break;

      }
      $data = $this->office_model->model_detail_member_data($member_id,$type);
      if($type == 1){
        switch ($data['member_type']['status_case']) {
          case '99':
            $status_case = [
              'icon' => 'fas fa-check-circle',
              'status_name' => ' อนุมัติแล้ว',
              'icon_color' => '#0AC37D;',
            ];
            break;
          case '1':
            $status_case = [
              'icon' => 'fas fa-clock',
              'status_name' => ' รอกรรมการอนุมัติอีเมล', 
              'icon_color' => '#FFC80A;',
            ];
            break;
          case '2':
            $status_case = [
              'icon' => 'fas fa-exclamation-circle',
              'status_name' => ' ไม่ตรงกับรายชื่อกรรมการ',
              'icon_color' => '#FFC80A;',
            ];
            break;
          case '3':
            $status_case = [
              'icon' => 'fas fa-clock',
              'status_name' => ' รออนุมัติ',
              'icon_color' => '#FFC80A;',
            ];
            break;
          case '4':
            $status_case = [
              'icon' => 'fas fa-times-circle',
              'status_name' => ' ไม่อนุมัติ',
              'icon_color' => 'red;',
            ];
            break;
          case '5':
            $status_case = [
              'icon' => 'fas fa-times-circle',
              'status_name' => ' ไม่อนุมัติ',
              'icon_color' => 'red;',
            ];
            break;
          default:
            $status_case = [
              'icon' => 'fas fa-exclamation-circle',
              'status_name' => ' ยังไม่ยืนยันตัวตน',
              'icon_color' => '#8A919E;',
            ];
            break;
        }
      }else if($type == 2 || $type == 4){
        switch ($data['member']['status_email_verify']) {
          case '1':
            $status_case = [
              'icon' => 'fas fa-check-circle',
              'status_name' => ' อนุมัติแล้ว',
              'icon_color' => '#0AC37D;',
            ];
            break;
          default:
          $status_case = [
            'icon' => 'fas fa-exclamation-circle',
            'status_name' => ' ยังไม่ยืนยันตัวตน',
            'icon_color' => '#8A919E;',
          ];
            break;
        }
      }else {
        switch ($data['member']['status_laser_verify']) {
          case '1':
            $status_case = [
              'icon' => 'fas fa-check-circle',
              'status_name' => ' อนุมัติแล้ว',
              'icon_color' => '#0AC37D;',
            ];
            break;
          default:
          $status_case = [
            'icon' => 'fas fa-exclamation-circle',
            'status_name' => ' ยังไม่ยืนยันตัวตน',
            'icon_color' => '#8A919E;',
          ];
            break;
        }
      }
      if($data['member']['status_laser_verify'] == '1'){
        $status_laser = [
          'icon_laser' => 'fas fa-check-circle',
          'status_name_laser' => ' Verified',
          'icon_color_laser' => '#0AC37D'
        ];
      }else{
          $status_laser = [
          'icon_laser' => 'fas fa-exclamation-circle',
          'status_name_laser' => ' Verify',
          'icon_color_laser' => 'red',
          ];
        }
       if($data['member']['status_email_verify'] == '1'){
        $status_email = [
          "icon_email" => 'fas fa-check-circle',
          "status_name_email" => ' Verified',
          "icon_color_email" => '#0AC37D',
        ];
      }else{
        $status_email = [
          "icon_email" => 'fas fa-exclamation-circle',
          "status_name_email" => ' Verify',
          "icon_color_email" => 'red',
        ];
      }
       if($data['member']['status_sms_verify'] == '1'){
        $status_sms = [
          "icon_sms" => 'fas fa-check-circle',
          "status_name_sms" => ' Verified',
          "icon_color_sms" => '#0AC37D',
        ];
      }else{
        $status_sms = [
          "icon_sms" => 'fas fa-exclamation-circle',
          "status_name_sms" => ' Verify',
          "icon_color_sms" => 'red',
        ];
      }
      
      $data1 = $data['member'];
      $data2 = $data['member_type'];
      $result = [
        'member' => $data1,
        'member_type' => $data2,
        'title' => $title,
        'attachment' => $data['attachment'],
        'note' => $data['note'],
        'status_case' => $status_case,
        'status_laser' => $status_laser,
        'status_email' => $status_email,
        'status_sms' => $status_sms,
      ];
      // echo "<pre>";
      // var_dump($result);
      // echo "</pre>";
      // die;
      $this->template->main('detail_member', $result);
    }else{
      $this->template->main('error');
    }
  }
  function edit_member(){
    $member_id = $this->get('id');
    $type = $this->get('type');
    if(isset($_SESSION['id_admin']) && $member_id != ""){
      $data = $this->office_model->model_edit_user_data($member_id,$type);
      $data1 = $data['member'];
      $data2 = $data['member_type'];
      $title = 'แก้ไขข้อมูล';

      if(!empty($data1[0]["Is_Thai"])){
        $title = 'ยังไม่ได้เป็นสมาชิก SSO';
      }
      $_SESSION['page'] = 'usertype'.$type;
      if($data['member']['status_laser_verify'] == '1'){
        $status_laser = [
          'icon_laser' => 'fas fa-check-circle',
          'status_name_laser' => ' Verified',
          'icon_color_laser' => '#0AC37D'
        ];
      }else{
          $status_laser = [
          'icon_laser' => 'fas fa-exclamation-circle',
          'status_name_laser' => ' Verify',
          'icon_color_laser' => 'red',
          ];
        }
       if($data['member']['status_email_verify'] == '1'){
        $status_email = [
          "icon_email" => 'fas fa-check-circle',
          "status_name_email" => ' Verified',
          "icon_color_email" => '#0AC37D',
        ];
      }else{
        $status_email = [
          "icon_email" => 'fas fa-exclamation-circle',
          "status_name_email" => ' Verify',
          "icon_color_email" => 'red',
        ];
      }
       if($data['member']['status_sms_verify'] == '1'){
        $status_sms = [
          "icon_sms" => 'fas fa-check-circle',
          "status_name_sms" => ' Verified',
          "icon_color_sms" => '#0AC37D',
        ];
      }else{
        $status_sms = [
          "icon_sms" => 'fas fa-exclamation-circle',
          "status_name_sms" => ' Verify',
          "icon_color_sms" => 'red',
        ];
      }
      $result = [
        'member' => $data1,
        'member_type' => $data2,
        'title' => $title,
        'attachment' => $data['attachment'],
        'note' => $data['note'],
        'status_laser' => $status_laser,
        'status_email' => $status_email,
        'status_sms' => $status_sms,
      ];
      // echo "<pre>";
      // var_dump($data1['status_contact_nationality']); 
      // echo "</pre>";
      // die(); 
      $this->template->main('edit_member', $result);
    }else{
      $this->template->main('error');
    }
  }
  function delete_user(){
    $member_id = $this->post('member_id');
    if(isset($_SESSION['id_admin']) && $member_id != ""){
      $data = $this->office_model->model_delete_user($member_id);
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function edit_client(){
    $mc_id = $this->get('id');
    if(isset($_SESSION['id_admin']) && $mc_id != ""){
      $data = $this->office_model->model_edit_client_data($mc_id);
      $this->template->main('edit_client', ['data' => $data]);
    }else{
      $this->template->main('error');
    }
  }

  function edit_admin(){
    $mc_id = $this->get('id');
    if(isset($_SESSION['id_admin']) && $mc_id != ""){
      $data = $this->office_model->model_edit_admin_data($mc_id);
      $this->template->main('edit_admin', ['data' => $data]);
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

  function save_admin(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_save_admin();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function save_add(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_save_add();
      $this->respone_json($data);
    }else{
      $this->template->main('error');
    }
  }

  function client_delete() {
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_delete_client();
      $this->respone_json($data);
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
      $type = $this->get('type');
      switch ($type) {
        case 1:
          $title = 'นิติบุคคล (ไทย)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 2:
          $title = 'นิติบุคคล (ต่างชาติ)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 3:
          $title = 'บุคคลทั่วไป (ไทย)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 4:
          $title = 'บุคคลทั่วไป (ต่างชาติ)';
          $_SESSION['page'] = 'usertype'.$type;
          break;
        case 6:
          $title = 'นิติบุคคลไม่ได้จดทะเบียน (ไทย)';
          $_SESSION['page'] = 'usertype'.$type;
          break;

      }
      $this->template->main('add_member',['type' => $type, 'title' => $title]);
    }else{
      $this->template->main('error');
    }
  }
  function edit_note(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_edit_note();
      echo json_encode($data);
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

  function edit_admin_password(){
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_edit_admin_password();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function news() {
    $_SESSION['page'] = "news";
    if(isset($_SESSION['id_admin'])){
      $this->template->main('news_manage');
    }else{
      $this->template->main('error');
    }
  }

  function data_table_news () {
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_data_table_news();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function add_news(){
    if(isset($_SESSION['id_admin'])){
      $this->template->main('add_news');
    }else{
      $this->template->main('error');
    }
  }

  function save_add_news() {
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_save_add_news();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function edit_news() {
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_edit_news();
      $this->template->main('edit_news', ['data' => $data]);
    }else{
      $this->template->main('error');
    }
  }

  function save_edit_news() {
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_save_edit_news();
      echo json_encode($data);
    }else{
      $this->template->main('error');
    }
  }

  function delete_news() {
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_delete_news();
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
  function get_country(){
    $data = $this->office_model->model_country(); 
    $this->respone_json($data);
  }
  function get_address_from_zipcode(){
    // echo $this->post('postcode');
    $data = $this->office_model->get_address_from_zipcode_model();
    $this->respone_json($data);
  }

  function get_address_from_zipcode_district(){
    // echo $this->post('postcode');
    $data = $this->office_model->get_address_from_zipcode_district_model();
    $this->respone_json($data);
  }
  function get_provinces(){
    $data = $this->office_model->get_provinces_model();
    $this->respone_json($data);
  }
  function get_amphures(){
    $data = $this->office_model->get_amphures_model();
    $this->respone_json($data);
  }
  function get_districts(){
    $data = $this->office_model->get_districts_model();
    $this->respone_json($data);
  }
  function upload_attach_file () {
    $data = $this->office_model->model_upload_attach_file();
    $this->respone_json($data);
  }
  function noti_sso () {
    $data = $this->office_model->model_noti_sso();
    $this->respone_json($data);
  }
  function noti_redirect_uri() {
    if(isset($_SESSION['id_admin'])){
      $data = $this->office_model->model_noti_redirect_uri();
      header($data);
      exit();
    }else{
      $this->template->main('error');
    }
  }
}