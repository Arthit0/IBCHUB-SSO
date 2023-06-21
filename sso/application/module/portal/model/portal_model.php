<?php

use \Firebase\JWT\JWT;

class portal_model extends Model
{

  function __construct()
  {
    parent::__construct();
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    // code...
    // $this->db = new db();
  }

  function get_province($id, $ln){

    $sql = "SELECT * FROM dropdown_provinces WHERE id = '".$id."'";
    $result = $this->query($sql);
    // echo "<pre>";
    // print_r($result);
    // exit;

    if($ln == 'th') $return = $result[0]['name_th']; else $return = $result[0]['name_en'];
    return $return;
  }

  function get_district($id, $ln){
    $sql = "SELECT * FROM dropdown_amphures WHERE id = '".$id."'";
    $result = $this->query($sql);
    if($ln == 'th') $return = $result[0]['name_th']; else $return = $result[0]['name_en'];
    return $return;
  }

  function get_subdistrict($id, $ln){
    $sql = "SELECT * FROM dropdown_districts WHERE id = '".$id."'";
    $result = $this->query($sql);
    if($ln == 'th') $return = $result[0]['name_th']; else $return = $result[0]['name_en'];
    return $return;
  }
  function get_sesstion () {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_URL.'api/userinfo_portal',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('refid' => $_COOKIE['ssoid'])
    ));

    $response = curl_exec($curl);
    $res = json_decode($response);

    curl_close($curl);
    if (empty($res)) {
      $redirect = BASE_URL."index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/&state=1";
      return $return = [
          'res_code' => "01",
          'res_text' => "fail",
          'redirect' => $redirect
        ];
    }

    $_SESSION['info'] = $res->result;
    $_SESSION['lang'] = !empty($_SESSION['lang'])?$_SESSION['lang']:'th';
    $_SESSION['client_id'] = 'SS8663835';
    $_SESSION['response_type'] = 'token';

    $return = [
      'res_code' => "00",
      'res_text' => "success"
    ];

    return $return = [
          'res_code' => "00",
          'res_text' => "success"
        ];
  }

  function ck_portal ($code) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_URL.'api/getinfoportal',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'code: Bearer '.$code,
        'client_id: SS8663835'
      ),
    ));

    $response = curl_exec($curl);
    $res = json_decode($response);
    curl_close($curl);

    $return = [];

    if (empty($res)) {
      $redirect = BASE_URL."index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/&state=1";
      return $return = [
          'res_code' => "01",
          'res_text' => "fail",
          'redirect' => $redirect
        ];
    }

    setcookie('ssoid', $res->res_result->ssoid, time() + (86400 * 30), "/");
    setcookie('type', $res->res_result->type, time() + (86400 * 30), "/");

    if ($res->res_result->type == 2 || $res->res_result->type == 4) {
      $_SESSION['lang'] = 'en';
    }

    if ($res->res_result->type == 1 && $res->res_result->status_contact_nationality == 2) {
      $_SESSION['lang'] = 'en';
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_URL.'api/userinfo_portal',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('refid' => $res->res_result->ssoid)
    ));

    $response = curl_exec($curl);
    $res = json_decode($response);
    curl_close($curl);
    if (empty($res)) {
      $redirect = BASE_URL."index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/&state=1";
      return $return = [
          'res_code' => "01",
          'res_text' => "fail",
          'redirect' => $redirect
        ];
    }


    $return = [
      'res_code' => "00",
      'res_text' => "success"
    ];


    $_SESSION['info'] = $res->result;
    $_SESSION['client_id'] = 'SS8663835';
    $_SESSION['response_type'] = 'token';

    return $return;
  }

  function user_info () {
    $ssoid = $_COOKIE['ssoid'];
    $table = 'tb_member_type'.$_COOKIE['type'];
    $sql = "SELECT * FROM tb_member m INNER JOIN {$table} t ON m.member_id = t.member_id WHERE m.sso_id = '{$ssoid}' LIMIT 1";
    $result = $this->query($sql);

    $return = [];
    if (count($result) == 0 ) {
      return $return = [
        'res_code' => "01",
        'res_text' => "error"
      ];
    }

    return $result[0];
  }
  
  function user_log () {
    $ssoid = $_COOKIE['ssoid'];
    $limit = $this->post('limit');
    $offset = $this->post('offset');

    $sql = "SELECT m.member_id, m.sso_id, t.create_date, mc.mc_name FROM tb_token t LEFT JOIN tb_member m ON t.member_id = m.member_id LEFT JOIN tb_merchant mc ON t.client_id = mc.client_id WHERE m.sso_id = '{$ssoid}' GROUP BY t.create_date ORDER BY t.create_date DESC";
    $count = "SELECT m.member_id, m.sso_id, t.create_date, mc.mc_name FROM tb_token t LEFT JOIN tb_member m ON t.member_id = m.member_id LEFT JOIN tb_merchant mc ON t.client_id = mc.client_id WHERE m.sso_id = '{$ssoid}' GROUP BY t.create_date ORDER BY t.create_date DESC";
    $sql .= " LIMIT $limit offset $offset";

    $result = $this->query($sql);
    $total = count($this->query($count));

    $data = array();
    for($i = 0, $n = 1 + $offset; $i < sizeof($result); $i++, $n++){
        $col_arr["td1"] = '<div style="font-size:16px;font-weight:300;">'.$n .'</div>';
        $col_arr["td2"] = '<div style="font-size:16px;font-weight:300;">'.$result[$i]['mc_name'] .'</div>';
        $col_arr["td3"] = '<div style="font-size:16px;font-weight:300;"> '.$result[$i]['create_date'].' </div>';
        array_push($data, $col_arr);
    }
    $data_array = array('total' => $total, 'rows' => $data );
    return $data_array;
  }

  function portal_list() {
    $sql = "SELECT * FROM tb_merchant WHERE portal = 1 ORDER BY mc_order DESC";
    $rs = $this->query($sql);
    return $rs;
  }

  function test_ldap() {
    $sql = "SELECT * FROM tb_member WHERE email = 'nittayaneek@ditp.go.th'";
    $result = $this->query($sql);
    print_r($result);
    die();
  }

  function model_newpassword(){
    $return = [];
    $error = [];

    $old_password = $this->post('old_password');
    $new_password = $this->post('new_password');
    $new_password2 = $this->post('new_password2');
    $new_password_hash = sha1($new_password);


   
    // $sql = "SELECT member_id FROM tb_member WHERE sso_id = {$_COOKIE['ssoid']}";
    // $rs = $this->query($sql);
    $stmt = $this->db->prepare("SELECT member_id FROM tb_member WHERE sso_id = ?");
    $stmt->bind_param("s", $_COOKIE['ssoid']);
    $stmt->execute();
    $results = $stmt->get_result();
    $sql_ckcid1 = $results->fetch_assoc();
    $val = $sql_ckcid1;
    /******** check input empty **************/
    if(empty($old_password)) $error['old_password'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณากรอกข้อมูล';
    if(empty($new_password)) $error['new_password'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณากรอกข้อมูล';
    if(empty($new_password2)) $error['new_password2'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณากรอกข้อมูล';
    if(empty($new_password2)) $error['new_password2'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณากรอกข้อมูล';

    if ($_SESSION['lang'] == 'en') {
      if(empty($old_password)) $error['old_password'] = "Can't change password <br> Please fill in all required fields.";
      if(empty($new_password)) $error['new_password'] = "Can't change password <br> Please fill in all required fields.";
      if(empty($new_password2)) $error['new_password2'] = "Can't change password <br> Please fill in all required fields.";
      if(empty($new_password2)) $error['new_password2'] = "Can't change password <br> Please fill in all required fields.";
    }
    if($val['member_id'] != "" ){
      $ck_member_id = $val['member_id'];
        $table = 'member_id';
        $text = 'redirect';
      }else{
    $ck_member_id = $this->post('member_id');
        if(empty($ck_member_id)) $error['member_id'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณากรอกข้อมูล';
        if ($_SESSION['lang'] == 'en') {
          if(empty($ck_member_id)) $error['member_id'] = "Can't change password <br> Please fill in all required fields.";
        }
        $table = 'cid';
        $text = 'message';
        $redirect_uri = 'sucess';
    }

    /************* strong password ***********/
    // if(!preg_match("#[a-zA-Z]+#", $new_password)) {
    //   if($_SESSION['lang'] == 'en'){
    //     $error['new_password'] = "Can't change password <br> must include at least one letter!";
    //   }else{
    //     $error['new_password'] = "ไม่สามารถเปลี่ยนรหัสผ่านได้<br>ต้องมี a - z อย่างน้อย 1 ตัว";
    //   }
    // }

    if(strlen($new_password) < 8) {
      if($_SESSION['lang'] == 'en'){
        $error['new_password'] = "Can't change password <br> more than 8 characters";
      }else{
        $error['new_password'] = "ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณาป้อนรหัสผ่าน 8 ตัวขึ้นไป";
      }
    }

    if($error){
      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value,
          'btn' => $_SESSION['lang'] == 'en' ? 'Confirm':'ตกลง'
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];
      return json_encode($return);
    }
    
    /********** check confirm new_password  **************/
    if($new_password != $new_password2){
      if($_SESSION['lang'] == 'en'){
        $error['new_password2'] = "Can't change password <br>Password not match";
      }else{
        $error['new_password2'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>รหัสผ่านไม่ตรงกัน';
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value,
          'btn' => $_SESSION['lang'] == 'en'? 'Confirm':'ตกลง'
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];
      return json_encode($return);
    }

    /************ check old_password  *************/
    // $sql = "SELECT * FROM tb_member WHERE $table = '" . $ck_member_id . "' AND password = '" . sha1($old_password) . "'";
    // $data = $this->query($sql);
    $stmt_password = $this->db->prepare("SELECT * FROM tb_member WHERE $table = ? AND `password` = ?");
    $stmt_password->bind_param("ss", $ck_member_id,sha1($old_password));
    $stmt_password->execute();
    $password = $stmt_password->get_result();
    $data = $password->fetch_assoc();

  
    if(count($data) < 1){
      if($_SESSION['lang'] == 'en'){
        $error['old_password'] = "Can't change password <br> Not found";
      }else{
        $error['old_password'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>ไม่มีในระบบ';
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value,
          'btn' => $_SESSION['lang'] == 'en'? 'Confirm':'ตกลง'
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];
      return json_encode($return);
    }

    /************* check รหัสผ่านใหม่ว่าตรงกับที่มีอยู่หรือไม่ **************/
    // $sql2 = "SELECT * FROM tb_member WHERE $table = '" . $ck_member_id . "' AND password = '" . sha1($new_password) . "'";
    // $data2 = $this->query($sql2);
    $stmt_check_password = $this->db->prepare("SELECT * FROM tb_member WHERE $table = ? AND `password` = ?");
    $stmt_check_password->bind_param("ss", $ck_member_id,sha1($new_password));
    $stmt_check_password->execute();
    $check_password = $stmt_check_password->get_result();
    $data2 = $check_password->fetch_assoc();

    if(count($data2) > 0){
      if($_SESSION['lang'] == 'en'){
        $error['new_password'] = "Can't change password <br> is your old password";
      }else{
        $error['new_password'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>ตรงกับรหัสผ่านเดิม';
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value,
          'btn' => $_SESSION['lang'] == 'en'? 'Confirm':'ตกลง'
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];
      return json_encode($return);
    }


    if (empty($error)) {
      //example :: $this->update('tb_member',['password'=>$new_password]," member_id = 5 and boot < 5");

      try{
        // $this->update('tb_member', ['password'=>sha1($new_password)], "$table ='$ck_member_id'");
        // UPDATE `tb_member` SET `password` = '7c222fb2927d828af22f592134e8932480637c0' WHERE `tb_member`.`member_id` = 46762;
        $stmt_update = $this->db->prepare("UPDATE `tb_member` SET `password` = ? WHERE `member_id` = ?");
        $stmt_update->bind_param("ss", sha1($new_password),$ck_member_id);
        $stmt_update->execute();

      } catch (Exception $e){
        if($_SESSION['lang'] == 'en'){
          $error['Error'] = "Can't change password <br> save fail";
        }else{
          $error['Error'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>ดำเนินการไม่สำเร็จ';
        }
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value,
            'btn' => $_SESSION['lang'] == 'en'? 'Confirm':'ตกลง'
          ];
        }
        $return = ['code' => '01', 'error' => $error_res];
        return json_encode($return);
      }finally{
        //redirect($_SESSION['redirect_uri']);
        unset($_COOKIE['ssoid']); 
        unset($_COOKIE['type']); 
        setcookie('ssoid', null, -1, '/'); 
        setcookie('type', null, -1, '/'); 
        unset($_SESSION['client_id']);
        unset($_SESSION['response_type']);
        unset($_SESSION['info']);
        $return = [$text => $redirect_uri];
        return json_encode($return);
      }
    }
  }

  function model_news_list () {
    $text_search = $this->get('text_search');

    $limit = $this->get('limit');
    $offset = $this->get('offset');
    $sort = $this->get('sort');
    $order = $this->get('order');
    $range = " LIMIT $limit OFFSET $offset";

    $sql = "SELECT * FROM tb_news WHERE publicdate <= NOW()";
    $count = "SELECT * FROM tb_news WHERE publicdate <= NOW()";
    if ($text_search != '') {
      $sql = "SELECT * FROM tb_news WHERE publicdate <= NOW() AND (n_title LIKE '%{$text_search}%' OR n_des LIKE '%{$text_search}%') ";
      $count = "SELECT * FROM tb_news WHERE publicdate <= NOW() AND (n_title LIKE '%{$text_search}%' OR n_des LIKE '%{$text_search}%') ";
    }
    if (!empty($sort)) {
      $count .= " ORDER BY $sort $order";
      $sql .= " ORDER BY $sort $order";
    }
    $count .= " LIMIT $limit offset $offset";
    $sql .= " LIMIT $limit offset $offset";

    $result = $this->query($sql);
    $total = count($this->query($count));

    $n = 0;

    $data = array();
    for($i = 0, $n = 1; $i < sizeof($result); $i++, $n++){
      $url = BASE_PATH . "portal/news?view=" . $result[$i]['n_id'];
      $col_arr['n_title'] = "<a href='".$url."'>".htmlentities($result[$i]['n_title'])."</a>";
      $col_arr['publicdate'] = htmlentities($result[$i]['publicdate']);
        array_push($data, $col_arr);
    }
    $data_array = array('total' => $total, 'rows' => $data );

    return $data_array;

  }

  function model_news ($n_id = '') {
    $sql = "SELECT * FROM tb_news WHERE n_id = {$n_id}";
    $return = $this->query($sql);

    return $return[0];
  }

  function dummy_data() {
    //mockup data
    $limit = $this->post('limit');
    $offset = $this->post('offset');
    $search = $this->post('search');

    $sql = "SELECT * FROM tb_member WHERE type = 3";
    $count = "SELECT * FROM tb_member WHERE type = 3";
    if ($search != '') {
      $sql = "SELECT * FROM tb_member WHERE type = 3 AND (member_id LIKE '%{$search}%' OR sso_id LIKE '%{$search}%' OR create_date LIKE '%{$search}%')";
      $count = "SELECT * FROM tb_member WHERE type = 3 AND (member_id LIKE '%{$search}%' OR sso_id LIKE '%{$search}%' OR create_date LIKE '%{$search}%')";
    }
    $sql .= " LIMIT $limit offset $offset";


    $result = $this->query($sql);
    $total = count($this->query($count));
    // print_r($result[0]['sso_id']);
    // die();
    $data = array();
    for($i = 0; $i < sizeof($result); $i++){
        $col_arr["td1"] = '<div style="font-size:18px;">'.$result[$i]['member_id'].'</div>';
        $col_arr["td2"] = '<div style="font-size:18px;"><a href="#">'.$result[$i]['sso_id'] .'</a></div>';
        $col_arr["td3"] = '<div style="font-size:18px;"> '.$result[$i]['create_date'].' </div>';
        array_push($data, $col_arr);
    }
    $data_array = array('total' => $total, 'rows' => $data );
    return $data_array;
  }

  function model_profile_update () {
    $type = $this->post('type');
    // $email_change = $this->post('email_change');
    // $phone_change = $this->post('phone_change');
    // pr($email_change);
    // pr($phone_change);
    // die();
    if ($type == 1) {
      $callback = !empty($this->post('callback'))?$this->post('callback'):'';
      if(empty($this->post('contact_title'))) $error['title'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('member_nameTh'))) $error['name_user'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $this->post('member_nameTh')) && $this->post('status_contact_nationality') == 1) {
        $error['name_user'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if(empty($this->post('member_lastnameTh'))) $error['lastname'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $this->post('member_lastnameTh')) && $this->post('status_contact_nationality') == 1) {
        $error['lastname'] = "กรุณากรอกนามสกุลเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if(empty($this->post('member_nameEn'))) $error['name_userEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_nameEn'))) {
        $error['name_userEn'] = "กรุณากรอกชื่อเป็นตัวอักษร a - z เท่านั้น";
      }
      if(empty($this->post('member_lastnameEn'))) $error['lastnameEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_lastnameEn'))) {
        $error['lastnameEn'] = "กรุณากรอกนามสกุลเป็นตัวอักษร a - z เท่านั้น";
      }

      if(!filter_var($this->post('member_email'), FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'รูปแบบไม่ถูกต้อง';
      }

      if(empty($this->post('member_email'))) $error['email'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('contact_tel'))) $error['tel'] = 'กรุณากรอกข้อมูล';

      if(empty($this->post('company_nameEn'))) $error['company_nameEn'] = 'กรุณากรอกข้อมูล';
      //if(empty($addressEn)) $error['addressEn'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('provinceTh'))) $error['provinceTh'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('districtTh'))) $error['districtTh'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('subdistrictTh'))) $error['subdistrictTh'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('postcode'))) $error['postcode'] = 'กรุณากรอกข้อมูล';

      $proID = $this->post('provinceTh');
      $disID = $this->post('districtTh');
      $subID = $this->post('subdistrictTh');
      if(empty($error)){
        if(!empty($proID)) $provinceTh = $this->get_province($proID, 'th');
        if(!empty($disID)) $districtTh = $this->get_district($disID, 'th');
        if(!empty($subID)) $subdistrictTh = $this->get_subdistrict($subID, 'th');

        if(!empty($proID)) $provinceEn = $this->get_province($proID, 'en');
        if(!empty($disID)) $districtEn = $this->get_district($disID, 'en');
        if(!empty($subID)) $subdistrictEn = $this->get_subdistrict($subID, 'en');
      }

      if (empty($error)) {

        $data = [
          'company_addressEn' => $this->post('company_addressEn'),
          'member_title' => $this->post('contact_title'),
          'member_nameTh' => $this->post('member_nameTh'),
          'member_lastnameTh' => $this->post('member_lastnameTh'),
          'member_nameEn' => $this->post('member_nameEn'),
          'member_lastnameEn' => $this->post('member_lastnameEn'),
          'member_birthday' => $this->post('member_birthday'),
          'member_email' => $this->post('member_email'),
          'member_tel' => str_replace(" ", "", $this->post('contact_tel')),
          'member_tel_country' => ($this->post('contact_tel_country') == '')? 'TH' : strtoupper($this->post('contact_tel_country')),
          'member_tel_code' => ($this->post('contact_tel_code') == '')? '+66' : "+".$this->post('contact_tel_code'),
          'contact_postcode' => $this->post('postcode'),
          'contact_province' => $provinceTh,
          'contact_district' => $districtTh,
          'contact_subdistrict' => $subdistrictTh,
          'contact_address' => $this->post('addressTh'),
        ];

        $this->update('tb_member_type1', $data, '  member_id ="' . $this->post('member_id') . '"');
        //ถ้าอีเมลหรือเบอร์เปลี่ยน ให้เปลี่ยนสถานะยืนยันเป็นไม่ยืนยัน
        $e = 0;
        $s = 0;
        if ($this->post('email_change') == 1) {
          if ($this->post('veri_mail') == 1) {
            $e = 0;
          } else {
            $e = 1;
          }
        } else {
          if ($this->post('veri_mail') == 1) {
            $e = 1;
          } else {
            $e = 0;
          }
        }
        if ($this->post('phone_change') == 1) {
          if ($this->post('veri_sms') == 1) {
            $s = 0;
          } else {
            $s = 1;
          }
        } else {
          if ($this->post('veri_sms') == 1) {
            $s = 1;
          } else {
            $s = 0;
          }
        }
        $data2 = [
          'status_email_verify' => $e,
          'status_sms_verify' => $s,
        ];
        $this->update('tb_member', $data2, '  member_id ="' . $this->post('member_id') . '"');
        if ($this->post('is_laser_veri') && $this->post('is_laser_veri') == 1) {
          $data3 = [
            'status_laser_verify' => 1
          ];
          $this->update('tb_member', $data3, '  member_id ="' . $this->post('member_id') . '"');
        }
        $return = [
          'status' => '00',
          'message' => 'Success',
          'callback' => $callback
        ];
        return $return;
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];

      return $return;
    } elseif ($type == 2) {
      $callback = !empty($this->post('callback'))?$this->post('callback'):'';
      if(empty($this->post('contact_title'))) $error['title'] = 'Please fill out';
      if(empty($this->post('member_nameEn'))) $error['name_user'] = 'Please fill out';

      if(empty($this->post('member_nameEn'))) $error['name_userEn'] = 'Please fill out';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_nameEn'))) {
        $error['name_userEn'] = "Please enter your name in letters a - z only.";
      }
      if(empty($this->post('member_lastnameEn'))) $error['lastnameEn'] = 'Please fill out';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_lastnameEn'))) {
        $error['lastnameEn'] = "Please enter your last name in letters a - z only.";
      }

      if(!filter_var($this->post('email'), FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'Invalid format';
      }

      if(empty($this->post('email'))) $error['email'] = 'Please fill out';
      if(empty($this->post('fo_tel'))) $error['tel'] = 'Please fill out';

      // if(empty($this->post('address'))) $error['address'] = 'Please fill out';


      if (empty($error)) {

        $data = [
          'member_title' => $this->post('contact_title'),
          'corporate_name' => $this->post('corporate_name'),
          'country' => $this->post('fo_country_name'),
          'member_nameEn' => $this->post('member_nameEn'),
          'member_lastnameEn' => $this->post('member_lastnameEn'),
          'email' => $this->post('email'),
          'tel' => str_replace(" ", "", $this->post('fo_tel')),
          'tel_country' => $this->post('fo_tel_country'),
          'tel_code' => $this->post('fo_tel_code')
        ];

        $this->update('tb_member_type2', $data, '  member_id ="' . $this->post('member_id') . '"');
        //ถ้าอีเมลหรือเบอร์เปลี่ยน ให้เปลี่ยนสถานะยืนยันเป็นไม่ยืนยัน
        $data2 = [
          'status_email_verify' => ($this->post('email_change') == 1)?0:1
        ];
        $this->update('tb_member', $data2, '  member_id ="' . $this->post('member_id') . '"');
        $return = [
          'status' => '00',
          'message' => 'Success',
          'callback' => $callback
        ];
        return $return;
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];

      return $return;
    } elseif ($type == 3) {

      $callback = !empty($this->post('callback'))?$this->post('callback'):'';
      if(empty($this->post('contact_title'))) $error['title'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('member_nameTh'))) $error['name_user'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $this->post('member_nameTh'))) {
        $error['name_user'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if(empty($this->post('member_lastnameTh'))) $error['lastname'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $this->post('member_lastnameTh'))) {
        $error['lastname'] = "กรุณากรอกนามสกุลเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if(empty($this->post('member_nameEn'))) $error['name_userEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_nameEn'))) {
        $error['name_userEn'] = "กรุณากรอกชื่อเป็นตัวอักษร a - z เท่านั้น";
      }
      if(empty($this->post('member_lastnameEn'))) $error['lastnameEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_lastnameEn'))) {
        $error['lastnameEn'] = "กรุณากรอกนามสกุลเป็นตัวอักษร a - z เท่านั้น";
      }

      if(!filter_var($this->post('email'), FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'รูปแบบไม่ถูกต้อง';
      }

      if(empty($this->post('email'))) $error['email'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('tel'))) $error['tel'] = 'กรุณากรอกข้อมูล';

      if(empty($this->post('addressTh'))) $error['addressTh'] = 'กรุณากรอกข้อมูล';
      //if(empty($addressEn)) $error['addressEn'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('provinceTh'))) $error['provinceTh'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('districtTh'))) $error['districtTh'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('subdistrictTh'))) $error['subdistrictTh'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('postcode'))) $error['postcode'] = 'กรุณากรอกข้อมูล';

      $proID = $this->post('provinceTh');
      $disID = $this->post('districtTh');
      $subID = $this->post('subdistrictTh');
      if(empty($error)){
        if(!empty($proID)) $provinceTh = $this->get_province($proID, 'th');
        if(!empty($disID)) $districtTh = $this->get_district($disID, 'th');
        if(!empty($subID)) $subdistrictTh = $this->get_subdistrict($subID, 'th');

        if(!empty($proID)) $provinceEn = $this->get_province($proID, 'en');
        if(!empty($disID)) $districtEn = $this->get_district($disID, 'en');
        if(!empty($subID)) $subdistrictEn = $this->get_subdistrict($subID, 'en');
      }

      if (empty($error)) {

        $data = [
          'member_title' => $this->post('contact_title'),
          'member_nameTh' => $this->post('member_nameTh'),
          'member_lastnameTh' => $this->post('member_lastnameTh'),
          'member_nameEn' => $this->post('member_nameEn'),
          'member_lastnameEn' => $this->post('member_lastnameEn'),
          'member_birthday' => $this->post('member_birthday'),
          'email' => $this->post('email'),
          'tel' => str_replace(" ", "", $this->post('tel')),
          'tel_country' => $this->post('tel_country'),
          'tel_code' => $this->post('tel_code'),
          'postcode' => $this->post('postcode'),
          'provinceTh' => $provinceTh,
          'districtTh' => $districtTh,
          'subdistrictTh' => $subdistrictTh,
          'provinceEn' => $provinceEn,
          'districtEn' => $districtEn,
          'subdistrictEn' => $subdistrictEn,
          'addressTh' => $this->post('addressTh'),
        ];

        $this->update('tb_member_type3', $data, '  member_id ="' . $this->post('member_id') . '"');
        //ถ้าอีเมลหรือเบอร์เปลี่ยน ให้เปลี่ยนสถานะยืนยันเป็นไม่ยืนยัน
        $e = 0;
        $s = 0;
        if ($this->post('email_change') == 1) {
          if ($this->post('veri_mail') == 1) {
            $e = 0;
          } else {
            $e = 1;
          }
        } else {
          if ($this->post('veri_mail') == 1) {
            $e = 1;
          } else {
            $e = 0;
          }
        }
        if ($this->post('phone_change') == 1) {
          if ($this->post('veri_sms') == 1) {
            $s = 0;
          } else {
            $s = 1;
          }
        } else {
          if ($this->post('veri_sms') == 1) {
            $s = 1;
          } else {
            $s = 0;
          }
        }
        $data2 = [
          'status_email_verify' => $e,
          'status_sms_verify' => $s,
        ];
        $this->update('tb_member', $data2, '  member_id ="' . $this->post('member_id') . '"');
        if ($this->post('is_laser_veri') && $this->post('is_laser_veri') == 1) {
          $data3 = [
            'status_laser_verify' => 1
          ];
          $this->update('tb_member', $data3, '  member_id ="' . $this->post('member_id') . '"');
        }
        $return = [
          'status' => '00',
          'message' => 'Success',
          'callback' => $callback
        ];
        return $return;
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];

      return $return;

    } elseif ($type == 4) {
      $callback = !empty($this->post('callback'))?$this->post('callback'):'';
      if(empty($this->post('contact_title'))) $error['title'] = 'Please fill out';
      if(empty($this->post('member_nameEn'))) $error['name_user'] = 'Please fill out';

      if(empty($this->post('member_nameEn'))) $error['name_userEn'] = 'Please fill out';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_nameEn'))) {
        $error['name_userEn'] = "Please enter your name in letters a - z only.";
      }
      if(empty($this->post('member_lastnameEn'))) $error['lastnameEn'] = 'Please fill out';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_lastnameEn'))) {
        $error['lastnameEn'] = "Please enter your last name in letters a - z only.";
      }

      if(!filter_var($this->post('email'), FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'Invalid format';
      }

      if(empty($this->post('email'))) $error['email'] = 'Please fill out';
      if(empty($this->post('fo_tel'))) $error['tel'] = 'Please fill out';

      // if(empty($this->post('address'))) $error['address'] = 'Please fill out';


      if (empty($error)) {

        $data = [
          'member_title' => $this->post('contact_title'),
          'member_nameEn' => $this->post('member_nameEn'),
          'member_lastnameEn' => $this->post('member_lastnameEn'),
          'email' => $this->post('email'),
          'tel' => str_replace(" ", "", $this->post('fo_tel')),
          'tel_country' => $this->post('fo_tel_country'),
          'tel_code' => $this->post('fo_tel_code')
        ];

        $this->update('tb_member_type2', $data, '  member_id ="' . $this->post('member_id') . '"');
        //ถ้าอีเมลหรือเบอร์เปลี่ยน ให้เปลี่ยนสถานะยืนยันเป็นไม่ยืนยัน
        $data2 = [
          'status_email_verify' => ($this->post('email_change') == 1)?0:1
        ];
        $this->update('tb_member', $data2, '  member_id ="' . $this->post('member_id') . '"');
        $return = [
          'status' => '00',
          'message' => 'Success',
          'callback' => $callback
        ];
        return $return;
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];

      return $return;

    } elseif ($type == 5) {

    } elseif ($type == 6) {
      $callback = !empty($this->post('callback'))?$this->post('callback'):'';
      if(empty($this->post('contact_title'))) $error['title'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('member_nameTh'))) $error['name_user'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $this->post('member_nameTh'))) {
        $error['name_user'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if(empty($this->post('member_lastnameTh'))) $error['lastname'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $this->post('member_lastnameTh'))) {
        $error['lastname'] = "กรุณากรอกนามสกุลเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if(empty($this->post('member_nameEn'))) $error['name_userEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_nameEn'))) {
        $error['name_userEn'] = "กรุณากรอกชื่อเป็นตัวอักษร a - z เท่านั้น";
      }
      if(empty($this->post('member_lastnameEn'))) $error['lastnameEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z]+$/", $this->post('member_lastnameEn'))) {
        $error['lastnameEn'] = "กรุณากรอกนามสกุลเป็นตัวอักษร a - z เท่านั้น";
      }

      if(!filter_var($this->post('member_email'), FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'รูปแบบไม่ถูกต้อง';
      }

      if(empty($this->post('member_email'))) $error['email'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('contact_tel'))) $error['tel'] = 'กรุณากรอกข้อมูล';

      if(empty($this->post('company_nameEn'))) $error['company_nameEn'] = 'กรุณากรอกข้อมูล';
      //if(empty($addressEn)) $error['addressEn'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('provinceTh'))) $error['provinceTh'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('districtTh'))) $error['districtTh'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('subdistrictTh'))) $error['subdistrictTh'] = 'กรุณากรอกข้อมูล';
      if(empty($this->post('postcode'))) $error['postcode'] = 'กรุณากรอกข้อมูล';

      $proID = $this->post('provinceTh');
      $disID = $this->post('districtTh');
      $subID = $this->post('subdistrictTh');

      $ComproID = $this->post('company_provinceTh');
      $ComdisID = $this->post('company_districtTh');
      $ComsubID = $this->post('company_subdistrictTh');
      if(empty($error)){
        if(!empty($proID)) $provinceTh = $this->get_province($proID, 'th');
        if(!empty($disID)) $districtTh = $this->get_district($disID, 'th');
        if(!empty($subID)) $subdistrictTh = $this->get_subdistrict($subID, 'th');

        if(!empty($proID)) $provinceEn = $this->get_province($proID, 'en');
        if(!empty($disID)) $districtEn = $this->get_district($disID, 'en');
        if(!empty($subID)) $subdistrictEn = $this->get_subdistrict($subID, 'en');

        if(!empty($ComproID)) $company_provinceTh = $this->get_province($ComproID, 'th');
        if(!empty($ComdisID)) $company_districtTh = $this->get_district($ComdisID, 'th');
        if(!empty($ComsubID)) $company_subdistrictTh = $this->get_subdistrict($ComsubID, 'th');

        if(!empty($ComproID)) $company_provinceEn = $this->get_province($ComproID, 'en');
        if(!empty($ComdisID)) $company_districtEn = $this->get_district($ComdisID, 'en');
        if(!empty($ComsubID)) $company_subdistrictEn = $this->get_subdistrict($ComsubID, 'en');
      }

      if (empty($error)) {

        $data = [
          'company_nameTh' => $this->post('company_nameTh'),
          'company_nameEn' => $this->post('company_nameEn'),
          'company_provinceTh' => $company_provinceTh,
          'company_districtTh' => $company_districtTh,
          'company_subdistrictTh' => $company_subdistrictTh,
          'company_postcodeTh' => $this->post('company_postcode'),
          'company_addressEn' => $this->post('company_addressEn'),
          'member_title' => $this->post('contact_title'),
          'member_nameTh' => $this->post('member_nameTh'),
          'member_lastnameTh' => $this->post('member_lastnameTh'),
          'member_nameEn' => $this->post('member_nameEn'),
          'member_lastnameEn' => $this->post('member_lastnameEn'),
          'member_birthday' => $this->post('member_birthday'),
          'member_email' => $this->post('member_email'),
          'member_tel' => str_replace(" ", "", $this->post('contact_tel')), 
          'member_tel_country' => ($this->post('contact_tel_country') == '')? 'TH' : strtoupper($this->post('contact_tel_country')),
          'member_tel_code' => ($this->post('contact_tel_code') == '')? '+66' : "+".$this->post('contact_tel_code'),
          'contact_postcode' => $this->post('postcode'),
          'contact_province' => $provinceTh,
          'contact_district' => $districtTh,
          'contact_subdistrict' => $subdistrictTh,
          'contact_address' => $this->post('addressTh'),
        ];

        $this->update('tb_member_type6', $data, '  member_id ="' . $this->post('member_id') . '"');
        //ถ้าอีเมลหรือเบอร์เปลี่ยน ให้เปลี่ยนสถานะยืนยันเป็นไม่ยืนยัน
        $e = 0;
        $s = 0;
        if ($this->post('email_change') == 1) {
          if ($this->post('veri_mail') == 1) {
            $e = 0;
          } else {
            $e = 1;
          }
        } else {
          if ($this->post('veri_mail') == 1) {
            $e = 1;
          } else {
            $e = 0;
          }
        }
        if ($this->post('phone_change') == 1) {
          if ($this->post('veri_sms') == 1) {
            $s = 0;
          } else {
            $s = 1;
          }
        } else {
          if ($this->post('veri_sms') == 1) {
            $s = 1;
          } else {
            $s = 0;
          }
        }
        $data2 = [
          'status_email_verify' => $e,
          'status_sms_verify' => $s,
        ];

        $this->update('tb_member', $data2, '  member_id ="' . $this->post('member_id') . '"');
        if ($this->post('is_laser_veri') && $this->post('is_laser_veri') == 1) {
          $data3 = [
            'status_laser_verify' => 1
          ];
          $this->update('tb_member', $data3, '  member_id ="' . $this->post('member_id') . '"');
        }
        $return = [
          'status' => '00',
          'message' => 'Success',
          'callback' => $callback
        ];
        return $return;
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];

      return $return;
    } else {
      return false;
    }

  }

  /////////////////
  function model_send_email_verify () {
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ"
    ];
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_URL.'index.php/api/send_verify',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('member_id' => $this->post('member_id'),'target' => $this->post('target'),'email' => $this->post('email')),

    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $res = json_decode($response);

    if ($res->status == "00") {

      $_SESSION['id'] = $this->post('member_id');
      $_SESSION['email'] = $this->post('email');
      $_SESSION['target'] = $this->post('target');
      $return = [
        "status" => "00",
        "message" => "success",
        "email" => substr_replace($this->post('email'),"****",0,4),
        "ref_code" => $res->ref_code
      ];
    } 

    return $return;

  }
}
