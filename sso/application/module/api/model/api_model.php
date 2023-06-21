<?php
require APPPATH.'/library/PHPMailer_v5.0.2/class.phpmailer.php';
use \Firebase\JWT\JWT;

class api_model extends Model
{


  function __construct()
  {
    parent::__construct();
  }

  function api_insert_member()
  {
    return $this->insert_member_api();
  }
  function api_insert_test()
  {
    return $this->insert_member_test();
  }
  function ck_moc()
  {
    return $this->check_link_moc();
  }

  public function isValidNationalId($nationalId = '')
  {
    if (strlen($nationalId) === 13) {
      $digits = str_split($nationalId);
      $lastDigit = array_pop($digits);
      $sum = array_sum(array_map(function ($d, $k) {
        return ($k + 2) * $d;
      }, array_reverse($digits), array_keys($digits)));
      return $lastDigit === strval((11 - $sum % 11) % 10);
    }
    return false;
  }

  function get_province($id, $ln){
    $sql = "SELECT * FROM dropdown_provinces WHERE id = '".$id."'";
    $result = $this->query($sql);
    if(count($result) < 1){
      $sql = "SELECT * FROM dropdown_provinces WHERE name_th LIKE'%".$id."%' OR name_en LIKE '%".$id."%'";
      $result = $this->query($sql);
    }
    if($ln == 'th') $return = $result[0]['name_th']; else $return = $result[0]['name_en'];
    return $return;
  }

  function get_district($id, $ln){
    $sql = "SELECT * FROM dropdown_amphures WHERE id = '".$id."'";
    $result = $this->query($sql);
    if(count($result) < 1){
      $sql = "SELECT * FROM dropdown_amphures WHERE name_th LIKE'%".$id."%' OR name_en LIKE '%".$id."%'";
      $result = $this->query($sql);
    }
    if($ln == 'th') $return = $result[0]['name_th']; else $return = $result[0]['name_en'];
    return $return;
  }

  function get_subdistrict($id, $ln){
    $sql = "SELECT * FROM dropdown_districts WHERE id = '".$id."'";
    $result = $this->query($sql);
    if(count($result) < 1){
      $sql = "SELECT * FROM dropdown_districts WHERE name_th LIKE'".$id."' OR name_en LIKE '".$id."'";
      $result = $this->query($sql);
    }
    if($ln == 'th') $return = $result[0]['name_th']; else $return = $result[0]['name_en'];
    return $return;
  }

  function get_data_client($client_id = '')
  {
    $sql = "SELECT * FROM tb_merchant WHERE client_id='" . mysqli_real_escape_string($this->db, $client_id) . "' and status = 1 limit 1";
    $data = $this->query($sql);
    $return = [];
    if (count($data) > 0) {
      $return = $data[0];
    }
    return $return;
  }

  // function gen_token($member_id = '')
  // {
  //   /******** insert tb_token ***************/
  //   $token_code = sha1($_SESSION['client_id'] . $member_id . date('YmhHis') . session_id()); 
  //   $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours")); //2 hours

  //   $insert_token = [
  //     'member_id' => $member_id,
  //     'token_code' => $token_code,
  //     'client_id' => $_SESSION['client_id'],
  //     'status' => 1,
  //     'exp_date' => $end_date,
  //   ];
  //   $last_id = $this->insert('tb_token', $insert_token);
  //   $return = [];
  //   if ($last_id) {

  //     /************** get id_token ***********/
  //     $sql = "SELECT * FROM tb_token WHERE token_code ='" . $token_code . "'";
  //     $data = $this->query($sql);
  //     if(count($data)>0){ 
  //       $val = $data[0];
  //       $refresh_token_code = sha1("refresh_token".$_SESSION['client_id'] . $member_id . date('YmhHis') . session_id());
  //       $end_date_refresh = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+14 days"));
        
  //       $insert_refresh = [
  //         'token_id' => $val['token_id'],
  //         'token_code' => $val['token_code'],
  //         'refresh_code' => $refresh_token_code,
  //         'status' => 1,
  //         'refresh_exp_date' => $end_date_refresh,
  //       ];
  //       $result = $this->insert('tb_refresh_token', $insert_refresh);
  //       if($result){
  //         $return['token'] = $token_code;
  //         $return['refresh_token'] = $refresh_token_code;
  //         $return['exp_date'] = $end_date;
  //         $return['exp_date_refresh'] = $end_date_refresh;
  //       }else{
  //         return false;
  //       }
  //     }
  //   }
  //   return $return;
  // }
  // function gen_access($member_id = '')
  // {
  //   $accesstoken = md5($_SESSION['client_id'] . $member_id . date('YmhHis') . session_id());
  //   $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours"));
  //   $insert_access = [
  //     'member_id' => $member_id,
  //     'ac_code' => $accesstoken,
  //     'client_id' => $_SESSION['client_id'],
  //     'status' => 1,
  //     'exp_date' => $end_date,
  //   ];

  //   $last_id = $this->insert('tb_access_code', $insert_access);
  //   $return = [];
  //   if ($last_id) {
  //     $return['access'] = $accesstoken;
  //     $return['exp_date'] = $end_date;
  //   }
  //   return $return;
  // }

  // function get_code($ck_mem, $client_id){
  //   //$data_client = $this->get_data_client($_SESSION['client_id']);
  //   $data_client = $this->get_data_client($client_id);
  //   $url = $data_client['redirect_uri'];
  //   if (!empty($_SESSION['redirect_uri'])) {
  //     $redirect_uri = $_SESSION['redirect_uri'];
  //     $url = $redirect_uri;
  //   }
  //   $query_url = parse_url($url, PHP_URL_QUERY);
  //   if ($query_url) {
  //     $url .= '&';
  //   } else {
  //     $url .= '?';
  //   }
  //   $key = $data_client['jwt_signature'];
  //   $response_type = $_SESSION['response_type'];


  //   if (strtoupper($response_type) == 'CODE') {
  //     $data_access = $this->gen_access($ck_mem);
  //     if (!empty($data_access['access'])) {
  //       $jwt_data = [
  //         'access_token' => $data_access['access'],
  //         'end_date' => $data_access['exp_date'],
  //         "token_type" => "Bearer"
  //       ];
  //       $jwt = JWT::encode($jwt_data, $key);
  //       //$url .= 'code=' . $jwt;
  //       $code = $jwt;

  //       $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
  //       setcookie($this->config->items('cookie_access'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
  //       //$return = ['code' => '00', 'success' => 1, 'url' => $url];
  //       return $code;
  //     }
  //   } else if (strtoupper($response_type) == 'TOKEN') {
  //     $data_token = $this->gen_token($ck_mem);
  //     if (!empty($data_token['token'])) {

  //       $jwt_data = [
  //         'id_token' => $data_token['token'],
  //         'refresh_token' => $data_token['refresh_token'],
  //         'end_date' =>  $data_token['exp_date'],
  //         'end_date_refresh' =>  $data_token['exp_date_refresh'],
  //         "token_type" => "Bearer"
  //       ];

  //       /*$jwt_data = [
  //         'id_token' => $data_token['token'],
  //         'end_date' =>  $data_token['exp_date'],
  //         "token_type" => "Bearer"
  //       ];*/
  //       $jwt = JWT::encode($jwt_data, $key);
  //       $state =  $_SESSION['state'];
  //       //$url .= 'code=' . $jwt . "&state=" . $state;
  //       $code = $jwt;

  //       $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
  //       setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
  //     }
  //     //$return = ['code' => '00', 'success' => 1, 'url' => $url];
  //     return $code;
  //   }
  // }

  function insert_touch($data = [], $type){ //NEW 
    if($type == 1){ //PERSONAL
      $data_insert = "register_type=".$data['register_type']."&";
      $data_insert .= "identify=".$data['identify']."&";
      $data_insert .= "email=".$data['email']."&";
      $data_insert .= "password=".$data['password']."&";
      $data_insert .= "firstname=".$data['firstname']."&";
      $data_insert .= "lastname=".$data['lastname']."&";
      $data_insert .= "citizen_id=".$data['citizen_id']."&";
      $data_insert .= "mobile=".$data['mobile'];

    }else if($type == 2){ //CORPORATE
      $data_insert = "register_type=".$data['register_type']."&";
      $data_insert .= "identify=".$data['identify']."&";
      $data_insert .= "email=".$data['email']."&";
      $data_insert .= "password=".$data['password']."&";
      $data_insert .= "company_name=".$data['company_name']."&";
      $data_insert .= "company_tax_id=".$data['company_tax_id']."&";
      $data_insert .= "company_telephone=".$data['company_telephone'];
    }

    $curl = curl_init();
    curl_setopt_array($curl, array(
      // CURLOPT_URL => "https://api.ditptouch.rgb72.dev/v1/signup",
      // CURLOPT_URL => "https://api.ditptouch.com/v1/signup",
      CURLOPT_URL => "https://api.ditptouch.com/v1/ditp-one/signup",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $data_insert,
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded"
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }

  function login_care($data = []){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => BASE_CARE."v2/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data,
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
  }

  function insert_care($code){
    //echo "code in curl = ".$code;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_CARE."api_caresaveuser.php?code=$code",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cookie: PHPSESSID=7i5rf3p851p0vlmeq7hc523um5"
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
    /*echo "res in curl = ";
    print_r($response);
    exit;*/
  }

  function check_link_moc($sso_id){
    $sso_id = $this->post('sso_id');
    // $nid = $this->post('nid');
    // $moc_ref_code = $this->post('moc_ref_code');
    $url = $this->post('url');
    $return = [];
    // $return['redirect'] = $url;

    $sql_ck_moc_id = "SELECT moc_account_id FROM tb_member WHERE sso_id = $sso_id AND moc_account_id IS NOT NULL";
    $moc_id = $this->query($sql_ck_moc_id);

    if(!empty($moc_id)){
      
      $return['moc_account_id'] = $moc_id[0]['moc_account_id'];
      $return['status'] = '01';
      $return['message'] = 'Link ไว้อยู่แล้ว, Error';
      $return['redirect'] = $url;

    }
    else {

    $mocAccountUrl = "";
    $mocAccountUrl.="https://account.moc.go.th/auth/authorize?";
    $mocAccountUrl.="&response_type=code";
    $mocAccountUrl.="&redirect_uri=https://sso.ditp.go.th/sso/index.php/auth/moccallback_link";
    $mocAccountUrl.="&client_id=5111195809841";
    header("Location: ".$mocAccountUrl);
    exit();


      $return['moc_account_id'] = $moc_id[0]['moc_account_id'];
      $return['status'] = '00';
      $return['message'] = 'Success';
      $return['redirect'] = $url;
    }

    return $return;
  }

  function insert_member_api($type_is = 0)
  {
    $type = $this->post('type');
   
    
    if($type == 1){ //นิติไทย
    
      //-- data tb_member --//
      $cid = $this->post('cid');
      $password = $this->post('password');
   

      //-- data tb_member_type1 ---//
      
      $company_nameTh = $this->post('company_name');
      $company_nameEn = $this->post('company_nameEn');
      $company_email = $this->post('company_email');
      $company_tel = $this->post('company_phone');
      $company_addressTh = $this->post('company_address');
      $company_provinceTh = $this->post('company_province');
      $company_districtTh = $this->post('company_district');
      $company_subdistrictTh = $this->post('company_subdistrict');
      $company_postcode = $this->post('company_postcode');
      $company_addressEn = $this->post('company_addressEn');
      $company_provinceEn = $this->post('company_provinceEn');
      $company_districtEn = $this->post('company_districtEn');
      $company_subdistrictEn = $this->post('company_subdistrictEn');
      $company_postcodeEn = $this->post('company_postcodeEn');

      $state = $this->post('state');
      $ck_nationality_type = $this->post('ck_nationality_type');
     
      $contact_address = $this->post('Hcontact_address');
      $contact_province = $this->post('Hcontact_province');
      $contact_district = $this->post('Hcontact_district');
      $contact_subdistrict = $this->post('Hcontact_subdistrict');
      $contact_postcode = $this->post('Hcontact_postcode');

      $member_title = $this->post('contact_title');
      $member_cid = $this->post('contact_cid');
      $member_nameTh = $this->post('contact_name');
      $member_midnameTh = $this->post('contact_midname');
      $member_lastnameTh = $this->post('contact_lastname');
      $member_nameEn = $this->post('contact_nameEn');
      $member_midnameEn = $this->post('contact_midnameEn');
      $member_lastnameEn = $this->post('contact_lastnameEn');
      $member_email = $this->post('contact_email');
      $member_tel = $this->post('contact_tel');
      $member_birthday = $this->post('contact_bday');

      $member_tel_country = $this->post('contact_tel_country');
      $member_tel_code = $this->post('contact_tel_code');

      $sql_ckcid1 = 'SELECT 1 , sso_id FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
      $sql_ckcid2 = 'SELECT 1 FROM Member_v2 WHERE member_cid ="' . $cid . '"';
      $sql_ckcid3 = 'SELECT 1 FROM Member_drive_v3 WHERE Username ="' . $cid . '"';

      $ck_cid1 = $this->query($sql_ckcid1);
      $ck_cid2 = $this->query($sql_ckcid2);
      $ck_cid3 = $this->query($sql_ckcid3);
      if (!empty($ck_cid1) || !empty($ck_cid2) || !empty($ck_cid3) ) {
        //if (!empty($ck_cid1)) {
          $error['cid'] = 'You have account already SSO ID :'.$ck_cid1[0]['sso_id'];
        }

        if(empty($cid)) $error['cid'] = 'Please input cid';

        if(!preg_match("#[a-zA-Z]+#", $password)) {
          $error['password'] = "Must have a - z at least 1 letters";
        }
        if(strlen($password) < 8) {
          $error['password'] = "Please input password more than 8";
        }

        if(empty($password)) $error['password'] = 'Please input password';
        if(empty($company_nameTh)) $error['company_name'] = 'Not found';
        if(empty($company_nameEn)) $error['company_nameEn'] = 'Please input company_nameEn';
        

        if(empty($member_title)) $error['contact_title'] = 'Please input contact_title';
        // if (!$this->isValidNationalId($member_cid)) {
        //   $error['contact_cid'] = 'Not correct';
        // }
        if(empty($member_cid)) $error['contact_cid'] = 'Please input contact_cid';
        if(empty($member_nameTh)) $error['contact_name'] = 'Please input contact_name';
        if(empty($member_lastnameTh)) $error['contact_lastname'] = 'Please input contact_lastname';
        if(empty($member_nameEn)) $error['contact_nameEn'] = 'Please input contact_nameEn';
        if(empty($member_lastnameEn)) $error['contact_lastnameEn'] = 'Please input contact_lastnameEn';

      //   $ck_mail = $this->check_mail($member_email);
      // if($ck_mail == false){
      //   $error['contact_email'] = 'Have email already';
      // }

      if(!filter_var($member_email, FILTER_VALIDATE_EMAIL)) {
        $error['contact_email'] = 'Format email incorrect';
      }

      if(empty($member_email)) $error['contact_email'] = 'Please input contact_email';
      if(empty($member_tel)) $error['contact_tel'] = 'Please input contact_tel';

      if(empty($error)){
        if($state == 'new'){
        if(empty($contact_address)) $error['Hcontact_address'] = 'Please input Hcontact_address';
        if(empty($contact_province)) $error['Hcontact_province'] = 'Please input Hcontact_province';
        if(empty($contact_district)) $error['Hcontact_district'] = 'Please input Hcontact_district';
        if(empty($contact_subdistrict)) $error['Hcontact_subdistrict'] = 'Please input Hcontact_subdistrict';
        if(empty($contact_subdistrict)) $error['Hcontact_postcode'] = 'Please input Hcontact_postcode';

        
          $contact_province = $this->get_province($contact_province, 'th');
          $contact_district = $this->get_district($contact_district, 'th');
          $contact_subdistrict = $this->get_subdistrict($contact_subdistrict, 'th');
        }
      }

      if(!empty($company_provinceTh)) $company_provinceTh = $this->get_province($company_provinceTh, 'th');
      if(!empty($company_districtTh)) $company_districtTh = $this->get_district($company_districtTh, 'th');
      if(!empty($company_subdistrictTh)) $company_subdistrictTh = $this->get_subdistrict($company_subdistrictTh, 'th');

      if(!empty($company_provinceEn)) $company_provinceEn = $this->get_province($company_provinceEn, 'en');
      if(!empty($company_districtEn)) $company_districtEn = $this->get_district($company_districtEn, 'en');
      if(!empty($company_subdistrictEn)) $company_subdistrictEn = $this->get_subdistrict($company_subdistrictEn, 'en');

      
      if(empty($error)){
        $type_is = $type;
        if($type_is){
          $data_insert_member = [
            'member_app' => '',
            'member_app_id' => '',
            'cid' => $cid,
            'password' => sha1($password),
            'type' => $type,
            'status_contact_nationality' => $ck_nationality_type,
            'status_laser_verify' => 0,
            'status' => '1',
            'register_from' => '1'
          ];
    
          $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
          $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
          $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");

          $ck_mem = $this->insert('tb_member', $data_insert_member);

          
    
          if(!empty($ck_mem)){
            $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $result_max = $this->query($sql_max);
            $member_id = $result_max[0]['member_id'];
            $data_insert_type1 = [
              'member_id' => $member_id,
              'company_nameTh' => $company_nameTh,
              'company_nameEn' => $company_nameEn,
              'company_email' => $company_email,
              'company_tel' => $company_tel,
              'company_addressTh' => $company_addressTh,
              'company_provinceTh' => $company_provinceTh,
              'company_districtTh' => $company_districtTh,
              'company_subdistrictTh' => $company_subdistrictTh,
              'company_postcodeTh' => $company_postcode,
              'company_addressEn' => $company_addressEn,
              'company_provinceEn' => $company_provinceEn,
              'company_districtEn' => $company_districtEn,
              'company_subdistrictEn' => $company_subdistrictEn,
              'company_postcodeEn' => $company_postcodeEn,
              'contact_address' => $contact_address,
              'contact_province' => $contact_province,
              'contact_district' => $contact_district,
              'contact_subdistrict' => $contact_subdistrict,
              'contact_postcode' => $contact_postcode,
              'member_title' => $member_title,
              'member_cid' => $member_cid,
              'member_nameTh' => ($ck_nationality_type == 1)?$member_nameTh:$member_nameEn,
              'member_midnameTh' => ($ck_nationality_type == 1)?$member_midnameTh:$member_midnameEn,
              'member_lastnameTh' => ($ck_nationality_type == 1)?$member_lastnameTh:$member_lastnameEn,
              'member_nameEn' => $member_nameEn,
              'member_midnameEn' => $member_midnameEn,
              'member_lastnameEn' => $member_lastnameEn,
              'member_email' => $member_email,
              'member_birthday' => $member_birthday,
              'member_tel' => $member_tel,
              'member_tel_country' => ($member_tel_country == '')? 'TH' : strtoupper($member_tel_country),
              'member_tel_code' => ($member_tel_code == '')? '+66' : "+".$member_tel_code,
              // 'director_email' => $director_email,
              // 'director_tel' => $director_tel,
              // 'director_tel_country' => ($director_tel_country == '')? 'TH' : strtoupper($director_tel_country),
              // 'director_tel_code' => ($director_tel_code == '')? '+66' : "+".$director_tel_code,
              // 'position_id' =>$position 
            ];
            // $data_insert_type1 = [
            //   'member_id' => $member_id,
            //   'company_nameTh' => $company_nameTh,
            //   'company_nameEn' => $company_nameEn,
            //   'company_addressTh' => $company_addressTh,
            //   'company_provinceTh' => $company_provinceTh,
            //   'company_districtTh' => $company_districtTh,
            //   'company_subdistrictTh' => $company_subdistrictTh,
            //   'company_postcodeTh' => $company_postcode,
            //   'company_addressEn' => $company_addressEn,
            //   'company_provinceEn' => $company_provinceEn,
            //   'company_districtEn' => $company_districtEn,
            //   'company_subdistrictEn' => $company_subdistrictEn,
            //   'company_postcodeEn' => $company_postcodeEn,
            //   'contact_address' => $contact_address,
            //   'contact_province' => $contact_province,
            //   'contact_district' => $contact_district,
            //   'contact_subdistrict' => $contact_subdistrict,
            //   'contact_postcode' => $contact_postcode,
            //   'member_title' => $member_title,
            //   'member_cid' => $member_cid,
            //   'member_nameTh' => $member_nameTh,
            //   'member_lastnameTh' => $member_lastnameTh,
            //   'member_nameEn' => $member_nameEn,
            //   'member_lastnameEn' => $member_lastnameEn,
            //   'member_email' => $member_email,
            //   'member_tel' => $member_tel,
            //   'member_tel_country' => ($member_tel_country == '')? 'TH' : strtoupper($member_tel_country),
            //   'member_tel_code' => ($member_tel_code == '')? '+66' : "+".$member_tel_code
            // ];
            $dat = [
              'cid' => $member_id,
              'data' => json_encode($data_insert_type1),
              'type' => 1
            ];
            $insert_register_log = $this->insert('tb_register_log', $dat);
            $insert_type1 = $this->insert('tb_member_type1', $data_insert_type1);

            
            
            // //------------------------ INSERT AND LOGIN connect --------------------------//
            //   //-- insert_touch ---/
            //   $data_insert_touch = [
            //     'register_type' => 'FORM',
            //     'identify' => 'CORPORATE',
            //     'email' => $member_email,
            //     'password' => $password,
            //     'company_name' => $company_nameTh,
            //     'company_tax_id' => $cid,
            //     'company_telephone' => $member_tel
            //   ];
            //   $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //2 IS CORPORATE

            //   if($insert_connect2['status'] == TRUE){

            //     //-------- update member_id and token connect --------//
            //     $member_id_connect = $insert_connect2['member_id'];
            //     $token_connect = $insert_connect2['token'];
            //     $id_connect = $insert_connect2['member_id'];

            //     $data_insert_member_app = [
            //       'member_id' => $member_id, //id ของ tb_member
            //       'member_id_app' => $member_id_connect, //primary in app
            //       'client_id' => 'SS6931846'
            //     ];
            //     $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

            //     //------- insert token_external --------//
            //     $data_insert_token_external = [
            //       'member_id' => $member_id,
            //       'member_id_app' => $id_connect,
            //       'token_code' => $token_connect,
            //       'member_type' => 'TOUCH',
            //     ];
            //     $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
            //   }
            //------------------------ END OFF INSERT AND LOGIN connect --------------------------//


            // $code_care = $this->get_code($member_id, 'ssocareid');
            // $insert_care = $this->insert_care($code_care);

            if($insert_type1){
              $sql_sso = "SELECT sso_id FROM `tb_member` WHERE cid = '$cid'";
            $chk_ssoid = $this->query($sql_sso);
            }
            
          }
          
         $return = ['Code' => '00', 'Msg' => 'Success' , 'SSO_ID' => $chk_ssoid[0]['sso_id']]; 
        }else{
          $return = ['Code' => '01', 'Msg' => 'Error'];
          
        }
      }
      else{
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['Code' => '01', 'Msg' => $error_res];
      }

      
      return $return ;
    
    }
    else if($type == 2){
       // -- data tb_member --//
       $cid = $this->post('cid');
       $password = $this->post('password');
 
       //-- data tb_member_type2 --//
       $corporate_name = $this->post('fo_corporate_name');
       $member_title = $this->post('fo_title');
       $member_nameEn = $this->post('fo_name');
      $member_midnameEn = $this->post('fo_midname');
      $member_lastnameEn = $this->post('fo_lastname');
       $country = $this->post('fo_country_name');
       $address = $this->post('fo_address');
       $email = $this->post('fo_email');
       $tel = $this->post('fo_tel');
 
       $tel_country = $this->post('fo_tel_country');
       $tel_code = $this->post('fo_tel_code');
 
       $text_alert = "Please fill in the information";
    
       //---------- check cid -----------//
       $sql_ckcid1 = 'SELECT 1 , sso_id FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
       //$sql_ckcid2 = 'SELECT 1 FROM Member WHERE member_cid ="' . $cid . '"';
       $sql_ckcid2 = 'SELECT 1 FROM Member_v2 WHERE member_cid ="' . $cid . '"';
       $sql_ckcid3 = 'SELECT 1 FROM Member_drive_v3 WHERE Username ="' . $cid . '"';

       
       $ck_cid1 = $this->query($sql_ckcid1);
       $ck_cid2 = $this->query($sql_ckcid2);
       $ck_cid3 = $this->query($sql_ckcid3);

       if (!empty($ck_cid1) || !empty($ck_cid2) || !empty($ck_cid3) ) {
       //if (!empty($ck_cid1)) {
         $error['cid'] = 'has already been used SSO ID :'.$ck_cid1[0]['sso_id'];
       }

       if(empty($cid)) $error['cid'] =  $text_alert;

      if(!preg_match("#[a-zA-Z]+#", $password)) {
        $error['password'] = "must include at least one letter!";
      }
      if(strlen($password) < 8) {
        $error['password'] = "more than 8 characters";
      }

      if(empty($password)) $error['password'] =  $text_alert;

      if(empty($corporate_name)) $error['fo_corporate_name'] =  $text_alert;
      if(empty($country)) $error['fo_country_name'] =  $text_alert;

      if(empty($member_title)) $error['fo_title'] =  $text_alert;
      if(empty($member_nameEn)) $error['fo_name'] =  $text_alert;
      if(empty($member_lastnameEn)) $error['fo_lastname'] =  $text_alert;

      // $ck_mail = $this->check_mail($email);

      // if($ck_mail == false){
      //   $error['fo_email'] = 'has already been used';
      // }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['fo_email'] = 'not a valid ';
      }

      if(empty($email)) $error['fo_email'] =  $text_alert;
      if(empty($tel)) $error['fo_tel'] =  $text_alert;

      if(empty($error)){
        $type_is = $type;
        if($type_is){
          $data_insert_member = [
            'member_app' => '',
            'member_app_id' => '',
            'cid' => $cid,
            'password' => sha1($password),
            'type' => $type,
            'status' => '1',
            'register_from' => '1'
          ];
 
          $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
          $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
          $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
          $ck_mem = $this->insert('tb_member', $data_insert_member);

          if(!empty($ck_mem)){
            $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $result_max = $this->query($sql_max);
            $member_id = $result_max[0]['member_id'];
            $data_insert_type2 = [
              'member_id' => $member_id,
              'corporate_name' =>  $corporate_name,
              'country' => $country,
              'address' => $address,
              'member_title' => $member_title,
              'member_nameTh' => $member_nameEn,
              'member_lastnameTh' => $member_lastnameEn,
              'member_nameEn' => $member_nameEn,
              'member_midnameEn' => $member_midnameEn,
              'member_lastnameEn' => $member_lastnameEn,
              'email' => $email,
              'tel' => $tel,
              'tel_country' => ($tel_country == '')? 'TH' : strtoupper($tel_country),
              'tel_code' => ($tel_code == '')? '+66' : "+".$tel_code
            ];
            $dat = [
              'cid' => $member_id,
              'data' => json_encode($data_insert_type2),
              'type' => 2
            ];
            $insert_register_log = $this->insert('tb_register_log', $dat);

            $insert_type2 = $this->insert('tb_member_type2', $data_insert_type2);

          //   //------------------------ INSERT AND LOGIN connect --------------------------//
          //    //-- insert_touch ---/
          //    $data_insert_touch = [
          //     'register_type' => 'FORM',
          //     'identify' => 'CORPORATE',
          //     'email' => $email,
          //     'password' => $password,
          //     'company_name' => $corporate_name,
          //     'company_tax_id' => $cid,
          //     'company_telephone' => $tel
          //   ];

          //   $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 2), TRUE); //2 IS CORPORATE
          //   print_r($insert_connect2['status']);
          //   die();
          //   if($insert_connect2['status'] == TRUE){

          //     //-------- update member_id and token connect --------//
          //     $member_id_connect = $insert_connect2['member_id'];
          //     $token_connect = $insert_connect2['token'];
          //     $id_connect = $insert_connect2['member_id'];

          //     $data_insert_member_app = [
          //       'member_id' => $member_id, //id ของ tb_member
          //       'member_id_app' => $member_id_connect, //primary in app
          //       'client_id' => 'SS6931846'
          //     ];
          //     $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

          //     //------- insert token_external --------//
          //     $data_insert_token_external = [
          //       'member_id' => $member_id,
          //       'member_id_app' => $id_connect,
          //       'token_code' => $token_connect,
          //       'member_type' => 'TOUCH',
          //     ];
          //     $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
          //   }
          // //------------------------ END OFF INSERT AND LOGIN connect --------------------------//

          // $code_care = $this->get_code($member_id, 'ssocareid');
            // $insert_care = $this->insert_care($code_care);
            if($insert_type2){
              $sql_sso = "SELECT sso_id FROM `tb_member` WHERE cid = '$cid'";
             $chk_ssoid = $this->query($sql_sso);
            }
          }
          $return = ['Code' => '00', 'Msg' => 'Success' , 'SSO_ID' => $chk_ssoid[0]['sso_id']]; 
        }
        else{
          $return = ['Code' => '01', 'Msg' => 'Error'];
          
        }
      }else{
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['Code' => '01', 'Msg' => $error_res];
      }
      return $return;
    
    }
    else if($type == 3){
      // -- data tb_member --//
 
      $cid = $this->post('cid');
      $password = $this->post('password');

      //-- data tb_member_type3 --//
      $member_title = $this->post('title');
      $member_nameTh = $this->post('name_user');
      $member_midnameTh = $this->post('midname_user');
      $member_lastnameTh = $this->post('lastname');
      $member_nameEn = $this->post('name_userEn');
      $member_midnameEn = $this->post('midname_userEn');
      $member_lastnameEn = $this->post('lastnameEn');
      $member_birthday = $this->post('birthday');
      $email = $this->post('email');
      $tel = $this->post('tel');
      $tel_country = $this->post('tel_country');
      $tel_code = $this->post('tel_code');
      $addressTh = $this->post('addressTh');
      $provinceTh = $this->post('provinceTh');
      $districtTh = $this->post('districtTh');
      $subdistrictTh = $this->post('subdistrictTh');
      $postcode = $this->post('postcode');
      
      $addressEn = $this->post('addressEn');
      $provinceEn = "";
      $districtEn = "";
      $subdistrictEn = "";

      if (!$this->isValidNationalId($cid)) {
        $error['cid'] = 'Not correct';
      }
        //---------- check cid -----------//
        $sql_ckcid1 = 'SELECT 1 , sso_id FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
        $sql_ckcid2 = 'SELECT 1 FROM Member_v2 WHERE member_cid ="' . $cid . '"';
        $sql_ckcid3 = 'SELECT 1 FROM Member_drive_v3 WHERE Username ="' . $cid . '"';
  
        $ck_cid1 = $this->query($sql_ckcid1);
        $ck_cid2 = $this->query($sql_ckcid2);
        $ck_cid3 = $this->query($sql_ckcid3);
  
  
        if (!empty($ck_cid1) || !empty($ck_cid2) || !empty($ck_cid3) ) {
          $error['cid'] = 'has already been used SSO ID :'.$ck_cid1[0]['sso_id'];
        }

        if(empty($cid)) $error['cid'] = 'Please input information';

        if(!preg_match("#[a-zA-Z]+#", $password)) {
          $error['password'] = "must include at least one letter!";
        }
        if(strlen($password) < 8) {
          $error['password'] = "more than 8 characters";
        }
  
        if(empty($password)) $error['password'] = 'Please input information';

        if(empty($member_title)) $error['title'] = 'Please input information';
        if(empty($member_nameTh)) $error['name_user'] = 'Please input information';
        if(empty($member_lastnameTh)) $error['lastname'] = 'Please input information';
        if(empty($member_nameEn)) $error['name_userEn'] = 'Please input information';
        if(empty($member_lastnameEn)) $error['lastnameEn'] = 'Please input information';

        $ck_mail = $this->check_mail($email);
        if($ck_mail == false){
          $error['email'] = 'has already been used';
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $error['email'] = 'not a valid';
        }
  
        if(empty($email)) $error['email'] = 'Please input information';
        if(empty($tel)) $error['tel'] = 'Please input information';
  
        if(empty($addressTh)) $error['addressTh'] = 'Please input information';
        if(empty($provinceTh)) $error['provinceTh'] = 'Please input information';
        if(empty($districtTh)) $error['districtTh'] = 'Please input information';
        if(empty($subdistrictTh)) $error['subdistrictTh'] = 'Please input information';
        if(empty($postcode)) $error['postcode'] = 'Please input information';

      $proID = $provinceTh;
      $disID = $districtTh;
      $subID = $subdistrictTh;

      if(empty($error)){
        if(!empty($proID)) $provinceTh = $this->get_province($proID, 'th');
        if(!empty($disID)) $districtTh = $this->get_district($disID, 'th');
        if(!empty($subID)) $subdistrictTh = $this->get_subdistrict($subID, 'th');

        if(!empty($proID)) $provinceEn = $this->get_province($proID, 'en');
        if(!empty($disID)) $districtEn = $this->get_district($disID, 'en');
        if(!empty($subID)) $subdistrictEn = $this->get_subdistrict($subID, 'en');
      }
 
      if(empty($error)){
        $type_is = $type;
        if($type_is){
         
          $data_insert_member = [
            'member_app' => '',
            'member_app_id' => '',
            'cid' => $cid,
            'password' => sha1($password),
            'type' => $type,
            'status' => '1',
            'register_from' => '1'
          ];
        
          $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
          $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
          $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
          $ck_mem = $this->insert('tb_member', $data_insert_member);
  
          if(!empty($ck_mem)){
            $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $result_max = $this->query($sql_max);
            $member_id = $result_max[0]['member_id'];
            $data_insert_type3 = [
              'member_id' => $member_id,
              'member_title' => $member_title,
              'member_nameTh' => $member_nameTh,
              'member_midnameTh' => $member_midnameTh,
              'member_lastnameTh' => $member_lastnameTh,
              'member_nameEn' => $member_nameEn,
              'member_midnameEn' => $member_midnameEn,
              'member_lastnameEn' => $member_lastnameEn,
              'member_birthday' => $member_birthday,
              'email' => $email,
              'tel' => $tel,
              'tel_country' => ($tel_country == '')? 'TH' : strtoupper($tel_country),
              'tel_code' => ($tel_code == '')? '+66' : "+".$tel_code,
              'addressTh' => $addressTh,
              'provinceTh' => $provinceTh,
              'districtTh' => $districtTh,
              'subdistrictTh' => $subdistrictTh,
              'postcode' => $postcode,
              'addressEn' => $addressEn,
              'provinceEn' => $provinceEn,
              'districtEn' => $districtEn,
              'subdistrictEn' => $subdistrictEn
            ];
            $dat = [
              'cid' => $member_id,
              'data' => json_encode($data_insert_type3),
              'type' => 3
            ];
            $insert_register_log = $this->insert('tb_register_log', $dat);
            $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);


            // //------------------------ INSERT AND LOGIN connect --------------------------//
            //   //-- insert_touch ---/
            //   $data_insert_touch = [
            //     'register_type' => 'FORM',
            //     'identify' => 'PERSONAL',
            //     'email' => $email,
            //     'password' => $password,
            //     'firstname' => $member_nameEn,
            //     'lastname' => $member_lastnameEn,
            //     'citizen_id' => $cid,
            //     'mobile' => $tel
            //   ];
            //   $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

            //   if($insert_connect2['status'] == TRUE){

            //     //-------- update member_id and token connect --------//
            //     $member_id_connect = $insert_connect2['member_id'];
            //     $token_connect = $insert_connect2['token'];
            //     $id_connect = $insert_connect2['member_id'];

            //     $data_insert_member_app = [
            //       'member_id' => $member_id, //id ของ tb_member
            //       'member_id_app' => $member_id_connect, //primary in app
            //       'client_id' => 'SS6931846'
            //     ];
            //     $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

            //     //------- insert token_external --------//
            //     $data_insert_token_external = [
            //       'member_id' => $member_id,
            //       'member_id_app' => $id_connect,
            //       'token_code' => $token_connect,
            //       'member_type' => 'TOUCH',
            //     ];
            //     $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
            //   }
            // //------------------------ END OFF INSERT AND LOGIN connect --------------------------//

            // $code_care = $this->get_code($member_id, 'ssocareid');
            // $insert_care = $this->insert_care($code_care);


            if($insert_type3){
              $sql_sso = "SELECT sso_id FROM `tb_member` WHERE cid = '$cid'";
            $chk_ssoid = $this->query($sql_sso);
            }
          }
          $return = ['Code' => '00', 'Msg' => 'Success' , 'SSO_ID' => $chk_ssoid[0]['sso_id']]; 
        }
        else{
          $return = ['Code' => '01', 'Msg' => 'Error'];
        }
      }else{
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['Code' => '01', 'Msg' => $error_res];
      }
      return $return;
    
    }
    else if($type == 4){

       // -- data tb_member --//
       $cid = $this->post('cid');
       $password = $this->post('password');
 
       // -- data tb_member_type4 --//
       $member_title = $this->post('fo_title');
       $member_nameEn = $this->post('fo_name');
       $member_midnameEn = $this->post('fo_midname');
       $member_lastnameEn = $this->post('fo_lastname');
       $country = $this->post('fo_country_name');
       $address = $this->post('fo_address');
       $email = $this->post('fo_email');
       $tel = $this->post('fo_tel');
       $tel_country = $this->post('fo_tel_country');
       $tel_code = $this->post('fo_tel_code');
 
       $text_alert = "Please fill in the information";
       if(empty($cid)) $error['cid'] = $text_alert;
 
       if(!preg_match("#[a-zA-Z]+#", $password)) {
         $error['password'] = "must include at least one letter!";
       }
       if(strlen($password) < 8) {
         $error['password'] = "more than 8 characters";
       }

       if(empty($password)) $error['password'] = $text_alert;
       
       if(empty($country)) $error['fo_country_name'] = $text_alert;
       if(empty($member_title)) $error['fo_title'] = $text_alert;
       if(empty($member_nameEn)) $error['fo_name'] = $text_alert;
       if(empty($member_lastnameEn)) $error['fo_lastname'] = $text_alert;
    

       $ck_mail = $this->check_mail($email);
       if($ck_mail == false){
         $error['fo_email'] = 'has already been used';
       }
       if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['fo_email'] = 'not a valid';
      }
      if(empty($email)) $error['fo_email'] = $text_alert;
      if(empty($tel)) $error['fo_tel'] = $text_alert;

      //---------- check cid -----------//
      $sql_ckcid1 = 'SELECT 1 , sso_id FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
      //$sql_ckcid2 = 'SELECT 1 FROM Member WHERE member_cid ="' . $cid . '"';
      $sql_ckcid2 = 'SELECT 1 FROM Member_v2 WHERE member_cid ="' . $cid . '"';
      $sql_ckcid3 = 'SELECT 1 FROM Member_drive_v3 WHERE Username ="' . $cid . '"';
      
      $ck_cid1 = $this->query($sql_ckcid1);
      $ck_cid2 = $this->query($sql_ckcid2);
      $ck_cid3 = $this->query($sql_ckcid3);

      if (!empty($ck_cid1) || !empty($ck_cid2) || !empty($ck_cid3) ) {
        $error['cid'] = 'has already been used SSO ID :'.$ck_cid1[0]['sso_id'];
      }

      if(empty($error)){
        $type_is = $type;
        if($type_is){
          $data_insert_member = [
            'member_app' => '',
            'member_app_id' => '',
            'cid' => $cid,
            'password' => sha1($password),
            'type' => $type,
            'status' => '1',
            'register_from' => '1'
          ];
    
          $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
          $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
          $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
          $ck_mem = $this->insert('tb_member', $data_insert_member);
    
          if(!empty($ck_mem)){
            $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $result_max = $this->query($sql_max);
            $member_id = $result_max[0]['member_id'];

            $data_insert_type4 = [
              'member_id' => $member_id,
              'member_title' => $member_title,
              'member_nameTh' => $member_nameEn,
              'member_lastnameTh' => $member_lastnameEn,
              'member_nameEn' => $member_nameEn,
              'member_midnameEn' => $member_midnameEn,
              'member_lastnameEn' => $member_lastnameEn,
              'country' => $country,
              'address' => $address,
              'email' => $email,
              'tel' => $tel,
              'tel_country' => ($tel_country == '')? 'TH' : strtoupper($tel_country),
              'tel_code' => ($tel_code == '')? '+66' : "+".$tel_code
            ];
            $dat = [
              'cid' => $member_id,
              'data' => json_encode($data_insert_type4),
              'type' => 4
            ];
            $insert_register_log = $this->insert('tb_register_log', $dat);
            $insert_type4 = $this->insert('tb_member_type4', $data_insert_type4);


            // //------------------------ INSERT AND LOGIN connect --------------------------//
            //   //-- insert_touch ---/
            //   $data_insert_touch = [
            //     'register_type' => 'FORM',
            //     'identify' => 'PERSONAL',
            //     'email' => $email,
            //     'password' => $password,
            //     'firstname' => $member_nameEn,
            //     'lastname' => $member_lastnameEn,
            //     'citizen_id' => $cid,
            //     'mobile' => $tel
            //   ];
            //   $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

            //   if($insert_connect2['status'] == TRUE){

            //     //-------- update member_id and token connect --------//
            //     $member_id_connect = $insert_connect2['member_id'];
            //     $token_connect = $insert_connect2['token'];
            //     $id_connect = $insert_connect2['member_id'];

            //     $data_insert_member_app = [
            //       'member_id' => $member_id, //id ของ tb_member
            //       'member_id_app' => $member_id_connect, //primary in app
            //       'client_id' => 'SS6931846'
            //     ];
            //     $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

            //     //------- insert token_external --------//
            //     $data_insert_token_external = [
            //       'member_id' => $member_id,
            //       'member_id_app' => $id_connect,
            //       'token_code' => $token_connect,
            //       'member_type' => 'TOUCH',
            //     ];
            //     $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
            //   }
            // //------------------------ END OFF INSERT AND LOGIN connect --------------------------//

            // $code_care = $this->get_code($member_id, 'ssocareid');
            // $insert_care = $this->insert_care($code_care);

            if($insert_type4){
              $sql_sso = "SELECT sso_id FROM `tb_member` WHERE cid = '$cid'";
            $chk_ssoid = $this->query($sql_sso);
            }
          }
          $return = ['Code' => '00', 'Msg' => 'Success' , 'SSO_ID' => $chk_ssoid[0]['sso_id']]; 
        }
        else{
          $return = ['Code' => '01', 'Msg' => 'Error'];
        }
      }else{
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['Code' => '01', 'Msg' => $error_res];
      }
      return json_encode($return);

 
    }
    else {
      $return = ['Code' => '01', 'Msg' => 'Not have this type'];
      return $return;
 
    }
    
  }

  function get_info_drive($userid = ''){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_drive."UserProfile?token=".$this->token_drive."&userid=".$userid,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array('Content-Length: 0')
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }

  function check_client_id($client_id = ''){
    $sql = "SELECT 1 FROM tb_merchant WHERE client_id = '$client_id'";
    $result = $this->query($sql);
    if(count($result) > 0){
      return true;
    }else{
      return false;
    }
  }

  function check_cid($cid){
    $sql = "SELECT 1 FROM tb_member WHERE cid = '$cid'";
    $result = $this->query($sql);
    if(count($result) > 0){
      return true;
    }else{
      return false;
    }
  }
  
  function get_token()
  {

    $client_id = $this->post('client_id');
    $code = $this->post('code');
    $return = ['res_code' => '01', 'res_text' => 'Data Not Found.'];
    $sql = 'SELECT * FROM tb_merchant where client_id="' . mysqli_real_escape_string($this->db, $client_id) . '" and status = 1 limit 1';
    $query = $this->query($sql);

    if (count($query) > 0) {
      $data = $query[0];
      $key = $data['jwt_signature'];
      //decode JWT//
      $sub_code = explode(' ', $code);
      if (count($sub_code) > 1) {
        if ($sub_code[0] == 'Bearer' && $sub_code[1]) {
          try {
            $decoded = JWT::decode($sub_code[1], $key, array('HS256'));

            if (empty($decoded->access_token)) {
              $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
            } else {
              $access_token = $decoded->access_token;
            }
          } catch (Exception $e) {

            $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
          }
        }
      } else {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
      }
      ////////////////
      // dd(1111111);
      if (empty($access_token)) {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
      } else {
        $sql_q = "SELECT * FROM tb_access_code where ac_code='" . $access_token . "' AND client_id='" . $client_id . "' AND status = 1 limit 1";
        $query_q = $this->query($sql_q);
        if (count($query_q) > 0) {
          $access = $query_q[0];
          if ($access['exp_date'] < date('Y-m-d H:i:s')) {
            // dd();
            // $return = ['res_code' => '01', 'res_text' => 'อ้าวเห้ยย'];
            $return = ['res_code' => '01', 'res_text' => 'Access_code Expire'];
          } else {
            $data_token = $this->gen_token($access['member_id'], $client_id);
            if (!empty($data_token['token'])) {

              $this->update('tb_access_code', ['status' => 0], '  ac_code="' . $access_token . '"');

              $jwt_data = [
                'id_token' => $data_token['token'],
                'refresh_token' => $data_token['refresh_token'],
                'end_date' =>  $data_token['exp_date'],
                'end_date_refresh' =>  $data_token['exp_date_refresh'],
                "token_type" => "Bearer"
              ];

              $jwt = JWT::encode($jwt_data, $key);
              $return = ['res_code' => '00', 'res_text' => 'success !', 'res_result' => ['code' => $jwt]];
            }
          }
        } else {
          $return = ['res_code' => '01', 'res_text' => 'Access_code Not Found.'];
        }
        // }
      }
    } else {
      $return = ['res_code' => '01', 'res_text' => 'Client_ID Not Found.'];
    }
    return $return;
  }

  function gen_token($member_id = '', $client_id = '')
  {
    /*$token_code = sha1($client_id . $member_id . date('YmhHis') . session_id());

    $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours"));
    $insert_token = [
      'member_id' => $member_id,
      'token_code' => $token_code,
      'status' => 1,
      'exp_date' => $end_date,
      'client_id' => $client_id
    ];
    $last_id = $this->insert('tb_token', $insert_token);
    $return = [];
    if ($last_id) {
      $return['token'] = $token_code;
      $return['exp_date'] = $end_date;
    }

    return $return;*/

    /******** insert tb_token ***************/
    $token_code = sha1($client_id . $member_id . date('YmhHis') . session_id()); 
    $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours")); //2 hours

    $insert_token = [
      'member_id' => $member_id,
      'token_code' => $token_code,
      'client_id' => $client_id,
      'status' => 1,
      'exp_date' => $end_date,
    ];
    $last_id = $this->insert('tb_token', $insert_token);
    $return = [];
    if ($last_id) {

      /************** get id_token ***********/
      $sql = "SELECT * FROM tb_token WHERE token_code ='" . $token_code . "'";
      $data = $this->query($sql);
      if(count($data)>0){ 
        $val = $data[0];
        $refresh_token_code = sha1("refresh_token".$client_id . $member_id . date('YmhHis') . session_id());
        $end_date_refresh = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+14 days"));
        
        $insert_refresh = [
          'token_id' => $val['token_id'],
          'token_code' => $val['token_code'],
          'refresh_code' => $refresh_token_code,
          'status' => 1,
          'refresh_exp_date' => $end_date_refresh,
        ];
        $result = $this->insert('tb_refresh_token', $insert_refresh);
        if($result){
          $return['token'] = $token_code;
          $return['refresh_token'] = $refresh_token_code;
          $return['exp_date'] = $end_date;
          $return['exp_date_refresh'] = $end_date_refresh;
        }else{
          return false;
        }
      }
    }
    return $return;
    //return "eiei";
  }


  function get_info($client_id = '', $code = '')
  {
    #save log
    // $param = [
    //   'code' => $code,
    //   'client_id' => $client_id,
    // ];
    // $this->save_log_call_api(json_encode($param), $client_id);
    $return = ['res_code' => '01', 'res_text' => 'Data Not Found.'];
    $sql_m = 'SELECT * FROM tb_merchant where client_id="' . mysqli_real_escape_string($this->db, $client_id) . '" and status = 1 limit 1';
    $query = $this->query($sql_m);

    if (count($query) > 0) {
      $data = $query[0];
      $key = $data['jwt_signature'];
      //decode JWT//
      $sub_code = explode(' ', $code);

      if (count($sub_code) > 1) {
        if ($sub_code[0] == 'Bearer' && $sub_code[1]) {
          try {
            $decoded = JWT::decode($sub_code[1], $key, array('HS256'));
            // var_dump($decoded);
            // die();
            if (empty($decoded->id_token)) {
              $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
            } else {
              $id_token  = $decoded->id_token;
            }
          } catch (Exception $e) {

            $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
          }
        }else{
            $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
        }
      } else {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
      }

      ////////////////
      if (empty($id_token)) {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
      } else {
        $sql = "SELECT * FROM tb_token WHERE client_id='" . $client_id . "' AND token_code='" . $id_token . "' limit 1 ";
        $query_token = $this->query($sql);

        if (count($query_token) > 0) {
          $tokendata =  $query_token[0];
          if ($tokendata['exp_date'] < date('Y-m-d H:i:s')) { //token หมดอายุ
            $return = ['res_code' => '01', 'res_text' => 'Access_code Expire'];
          } else {
            $sql_m = 'SELECT * FROM tb_member WHERE member_id="' . $tokendata['member_id'] . '" and status = 1 limit 1';
            $query_m = $this->query($sql_m);

            if (count($query_m) > 0) {
              $data_m = $query_m[0];
              $update['update'] = [
                "update_date" => (empty($data_m['update_date']))? '': $data_m['update_date'] ,
                "system_update" => (empty($data_m['system_update']))? '': $data_m['system_update']
              ];
              $type = $data_m['type'];
              $status_contact = $data_m['status_contact_nationality'];
        
              if($client_id == 'SS0047423'){ // App one
                //-- care --//
                $sql_care = "SELECT * FROM tb_member_app_id WHERE member_id='" . $tokendata['member_id']."' AND client_id = 'ssocareid'";
                $query_care = $this->query($sql_care);
                if(count($query_care)>0){
                  $data_care = $query_care[0];
                  $user_care = $data_care['member_id_app'];
                }else{ 
                  $user_care = '';
                }

                //-- drive --//
                $sql_drive = "SELECT * FROM tb_member_app_id WHERE member_id='" . $tokendata['member_id']."' AND client_id = 'ssonticlient'";
                $query_drive = $this->query($sql_drive);
             
                if(count($query_drive)>0){
                  $data_drive = $query_drive[0];
                  $user_drive = $data_drive['member_id_app'];
                }else{ 
                  $user_drive = '';
                }
                // var_dump($update);
                // die();
                //-- connect --//
                // $sql_con = "SELECT * FROM tb_member_app_id WHERE member_id='" . $tokendata['member_id']."' AND client_id = 'SS6931846'";
                // $query_con = $this->query($sql_con);
                // if(count($query_con)>0){
                //   $data_con = $query_con[0];
                //   $user_con = $data_con['member_id_app'];
                // }else{ $user_con= ''; }
                ///------- Auto Login care -----------///
                // $curl = curl_init();
                // curl_setopt_array($curl, array(
                //   CURLOPT_URL => BASE_CARE.'autoreg_sso.php',
                //   CURLOPT_RETURNTRANSFER => true,
                //   CURLOPT_ENCODING => '',
                //   CURLOPT_MAXREDIRS => 10,
                //   CURLOPT_SSL_VERIFYPEER  => 0,
                //   CURLOPT_TIMEOUT => 0,
                //   CURLOPT_FOLLOWLOCATION => true,
                //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //   CURLOPT_CUSTOMREQUEST => 'POST',
                //   CURLOPT_POSTFIELDS =>'{
                //     "member_cid":"'.$data_m['cid'].'",
                //     "ssoid":"'.$data_m['sso_id'].'"
                // }',
                //   CURLOPT_HTTPHEADER => array(
                //     'Content-Type: application/json',
                //     'Cookie: PHPSESSID=2gj9nhqqki5bvgktgf5ula5qt6'
                //   ),
                // ));
                // $response = curl_exec($curl);
                // curl_close($curl);       
                // $error = curl_error($curl);       
                // $json = json_decode($response);
                // if(isset($json->res_result)){
                //   $ck_memberCare = "SELECT * FROM `tb_token_external` WHERE `member_id` = '".$data_m['member_id']."' AND `member_type` = 'CARE'";
                //   $query_memberCare = $this->query($ck_memberCare);
                //  if(count($query_memberCare) < 1){
                //   $auto = "INSERT INTO `tb_token_external`(`member_id`,`member_id_app`,`member_type`) VALUES ('".$data_m['member_id']."','".$json->res_result->member_id."','CARE')";
                //   if ($this->query($auto) === FALSE ) {
                //     echo "Failed to connect to MySQL: " . $this->error;
                //     die();
                //     } 
                //   }else{
                //     $sql = "UPDATE tb_token_external SET member_id_app = '".$json->res_result->member_id."'  WHERE member_id = '".$data_m['member_id']."' AND `member_type` = 'CARE'";
                //     if ($this->query($sql) === FALSE) {
                //       echo json_encode("Error updating record: " . $conn->error);
                //       } 
                //   }
                // }
                //--- token care ---//
                $sql_tcare = "SELECT * FROM tb_token_external WHERE member_id='" . $tokendata['member_id']."' AND member_type = 'CARE' ORDER BY id DESC limit 0,1";
                $query_tcare = $this->query($sql_tcare);
                if(count($query_tcare)>0){
                  $data_tcare = $query_tcare[0];
                  $token_care = $data_tcare['token_code'];
                  $user_care2 = $data_tcare['member_id_app'];
                  
                }else{ $token_care= ''; }

                //--- token touch ---//
                $sql_tconnect = "SELECT * FROM tb_token_external WHERE member_id='" . $tokendata['member_id']."' AND member_type = 'TOUCH' ORDER BY id DESC limit 0,1";
                $query_tconnect = $this->query($sql_tconnect);
                if(count($query_tconnect)>0){
                  $data_tconnect = $query_tconnect[0];
                  $token_connect = $data_tconnect['token_code'];
                }else{ $token_connect= ''; }

                $verify['verify'] = [
                  'laser_code' => $data_m['status_laser_verify'] == null ? 0: $data_m['status_laser_verify'],
                  'email' => $data_m['status_email_verify'],
                  'sms' => $data_m['status_sms_verify']
                ];

                $result = [
                  'ssoid' => $data_m['sso_id'],
                  'naturalId' => $data_m['cid'],
                  'type' => $type,
                  'userID_drive' => $user_drive,
                  'userID_care' => $user_care2,
                  // 'userID_connect' => $user_con,

                  'token_care' => $token_care,
                  'token_connect' => $token_connect
                ];
                
              }else{

                $verify['verify'] = [
                  'laser_code' => $data_m['status_laser_verify'] == null ? 0: $data_m['status_laser_verify'],
                  'email' => $data_m['status_email_verify'],
                  'sms' => $data_m['status_sms_verify']
                ];

                $result = [
                  'ssoid' => $data_m['sso_id'],
                  'naturalId' => $data_m['cid'],
                  'type' => $type,
                ];
                $data_s = [];
              }
             
              //------- check update_drive ------------//
              $sql_d = "SELECT 1 FROM Member_drive_v3 WHERE Username = '$data_m[cid]'";
              $result_d = $this->query($sql_d);
              $result_drive = "";
              if(count($result_d) >0){
                
                $sql_d2 = "SELECT 1 FROM tb_member WHERE cid = '$data_m[cid]' AND status_update_drive = 'N'";
                $result_d2 = $this->query($sql_d2);

                  if(count($result_d2) > 0){
                    
                    $result_drive = '';
                    try{
                      $result_drive = $this->get_info_drive($data_m['cid']);
                    } catch (Exception $e){
                     
                    }
                    $data_drive = $this->get_info_drive($data_m['cid']);


                    
                    $result_drive = json_decode($data_drive,1);
       
                    if($result_drive != '' && $result_drive['code'] == "200" && $result_drive['message'] == "OK"){
                     
                      if($type == '1' && $result_drive['UserType'] == "company"){
                        $data_update_type1 = [
                          'company_nameTh' => $result_drive['CorporateNameTH'],
                          'company_nameEn' => $result_drive['CorporateNameEN'],

                          'company_addressTh' => $result_drive['User_Address']['AddressTH'],
                          'company_provinceTh' => $result_drive['User_Address']['Province']['name'],
                          'company_districtTh' => $result_drive['User_Address']['District']['name'],
                          'company_subdistrictTh' => $result_drive['User_Address']['SubDistrict']['name'],
                          'company_postcodeTh' => $result_drive['User_Address']['PostCode'],

                          'company_addressEn' => $result_drive['User_Address']['AddressEN'],
                          'company_provinceEn' => $result_drive['User_Address']['Province']['nameEN'],
                          'company_districtEn' => $result_drive['User_Address']['District']['nameEN'],
                          'company_subdistrictEn' => $result_drive['User_Address']['SubDistrict']['nameEN'],
                          'company_postcodeEn' => $result_drive['User_Address']['PostCode'],

                          'contact_address' => $result_drive['User_Address']['AddressTH'],
                          'contact_province' => $result_drive['User_Address']['Province']['name'],
                          'contact_district' => $result_drive['User_Address']['District']['name'],
                          'contact_subdistrict' => $result_drive['User_Address']['SubDistrict']['name'],
                          'contact_postcode' => $result_drive['User_Address']['PostCode'],

                          'member_title' => $result_drive['User_Contact']['Title']['name'],
                          //'member_cid' => $result_drive[''],
                          'member_nameTh' => $result_drive['User_Contact']['FirstNameTH'],
                          'member_lastnameTh' => $result_drive['User_Contact']['LastNameTH'],
                          'member_nameEn' => $result_drive['User_Contact']['FirstNameEN'],
                          'member_lastnameEn' => $result_drive['User_Contact']['LastNameEN'],
                          'member_email' => $result_drive['Mail'],
                          'member_tel' => $result_drive['User_Contact']['Contact_Tel'],
                          'member_tel_country' => "TH",
                                  'member_tel_code' => "+66"
                        ];
                        try{
                          $this->update('tb_member_type1', $data_update_type1, "member_id ='$tokendata[member_id]'");
                          $this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
                        } catch (Exception $e){
              
                        }
                        

                      }else if($type == '2' && $result_drive['UserType'] == "company"){
                        $data_update_type2 = [
                          'corporate_name' =>  $result_drive['CorporateNameEN'],
                          'country' => $result_drive['User_Address']['Country']['nameEN'],
                          'address' => $result_drive['User_Address']['AddressEN'],
                          //'member_title' => $result_drive,
                          //'member_nameTh' => $result_drive,
                          //'member_lastnameTh' => $result_drive,
                          //'member_nameEn' => $result_drive,
                          //'member_lastnameEn' => $result_drive,
                          'email' => $result_drive['Mail'],
                          'tel' => $result_drive['Tel'],
                          //'tel_country' => "TH",
                          //'tel_code' => "+66"
                        ];
                        try{
                          $this->update('tb_member_type2', $data_update_type2, "member_id ='$tokendata[member_id]'");
                          $this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
                        } catch (Exception $e){
              
                        }
                        

                      }else if($type == '3' && $result_drive['UserType'] == "individual"){
                        # บุคคล ไทย
                       
                        $data_update_type3 = [
                          'member_title' => $result_drive['Title']['name'],
                          'member_nameTh' => $result_drive['FirstNameTH'],
                          'member_lastnameTh' => $result_drive['LastNameTH'],
                          'member_nameEn' => $result_drive['FirstNameEN'],
                          'member_lastnameEn' => $result_drive['LastNameEN'],
                          'email' => $result_drive['Mail'],
                          'tel' => $result_drive['Tel'],
                          'tel_country' => "TH",
                          'tel_code' => "+66",
                          'addressTh' => $result_drive['User_Address']['AddressTH'],
                          'provinceTh' => $result_drive['User_Address']['Province']['name'],
                          'districtTh' => $result_drive['User_Address']['District']['name'],
                          'subdistrictTh' => $result_drive['User_Address']['SubDistrict']['name'],
                          'postcode' => $result_drive['User_Address']['PostCode'],

                          'addressEn' => $result_drive['User_Address']['AddressEN'],
                          'provinceEn' => $result_drive['User_Address']['Province']['nameEN'],
                          'districtEn' => $result_drive['User_Address']['District']['nameEN'],
                          'subdistrictEn' => $result_drive['User_Address']['SubDistrict']['nameEN']
                        ];
                        try{
                          $this->update('tb_member_type3', $data_update_type3, "member_id ='$tokendata[member_id]'");
                          $this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
                        } catch (Exception $e){
              
                        }
                        

                      }else if($type == '4' && $result_drive['UserType'] == "individual"){
                        # บุคคล ต่างชาติ
                        $data_update_type4 = [
                          'member_title' => $result_drive['Title']['nameEN'],
                          'member_nameTh' => $result_drive['FirstNameTH'],
                          'member_lastnameTh' => $result_drive['LastNameTH'],
                          'member_nameEn' => $result_drive['FirstNameEN'],
                          'member_lastnameEn' => $result_drive['LastNameEN'],
                          'country' => $result_drive['User_Address']['Country']['nameEN'],
                          'address' => $result_drive['User_Address']['AddressEN'],
                          'email' => $result_drive['Mail'],
                          'tel' => $result_drive['Tel'],
                          //'tel_country' => strtoupper($tel_country),
                          //'tel_code' => "+".$tel_code
                        ];
                        try{
                          $this->update('tb_member_type4', $data_update_type4, "member_id ='$tokendata[member_id]'");
                          $this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
                        } catch (Exception $e){
              
                        }
                        
                      }
                    }
                }
                
              }

              switch ($type) {
                case '1':
                  # update ข้อมูลส่วนตัว

                  # นิติบุคคล ไทย

                  $sql_m = 'SELECT * FROM tb_member_type1 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }

                  $detail['company'] = [
                    "nameTh" => (empty($data_m['company_nameTh']))? '': $data_m['company_nameTh'] ,
                    "nameEn" => (empty($data_m['company_nameEn']))? '': $data_m['company_nameEn'] ,
                    "tel" => (empty($data_m['company_tel']))? '': $data_m['company_tel'] ,
                    "email" => (empty($data_m['company_email']))? '': $data_m['company_email']
                  ];
                  $detail['addressTh'] = [
                    "address" => (empty($data_m['company_addressTh']))? '': $data_m['company_addressTh'],
                    "province" => (empty($data_m['company_provinceTh']))? '': $data_m['company_provinceTh'],
                    "district" => (empty($data_m['company_districtTh']))? '':$data_m['company_districtTh'],
                    "subdistrict" => (empty($data_m['company_subdistrictTh']))? '':$data_m['company_subdistrictTh'],
                    "postcode" => (empty($data_m['company_postcodeTh']))? '':$data_m['company_postcodeTh']
                  ];
                  $detail['addressEn'] = [
                    "address" => (empty($data_m['company_addressEn']))? '': $data_m['company_addressEn'],
                    "province" => (empty($data_m['company_provinceEn']))? '': $data_m['company_provinceEn'],
                    "district" => (empty($data_m['company_districtEn']))? '': $data_m['company_districtEn'],
                    "subdistrict" => (empty($data_m['company_subdistrictEn']))? '': $data_m['company_subdistrictEn'],
                    "postcode" => (empty($data_m['company_postcodeEn']))? '':$data_m['company_postcodeEn'] ,
                  ];
                  $detail['contact'] = [
                    "address" => (empty($data_m['contact_address']))? '': $data_m['contact_address'],
                    "province" => (empty($data_m['contact_province']))? '': $data_m['contact_province'],
                    "district" => (empty($data_m['contact_district']))? '': $data_m['contact_district'],
                    "subdistrict" => (empty($data_m['contact_subdistrict']))? '': $data_m['contact_subdistrict'],
                    "postcode" => (empty($data_m['contact_postcode']))? '': $data_m['contact_postcode'],
                  ];

                  $titleEn = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'นาย'){
                      $titleEn = 'Mr.';
                    }else if($data_m['member_title'] == 'นาง'){
                      $titleEn = 'Mrs.';
                    }elseif($data_m['member_title'] == 'นางสาว'){
                      $titleEn = 'Miss';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['member_tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }
                  switch ($data_m['status_case']) {
                    case '99':
                      $status_name = 'อนุมัติแล้ว';
                      break;
                    case '1':
                      $status_name = 'รอกรรมการอนุมัติอีเมล';
                      break;
                    case '2':
                      $status_name = 'รายชื่อกรรมการแต่ชื่อไม่ตรงกับ DBD';
                      break;
                    case '3':
                      $status_name = 'รออนุมัติ';
                      break;
                    case '4':
                      $status_name = 'ไม่อนุมัติ';
                      break;
                    case '5':
                      $status_name = 'ไม่อนุมัติ';
                      break;
                    default:
                      $status_name = 'ยังไม่ยืนยันตัวตน';
                      break;
                  }
                  
                  if($status_contact == '1'){
                    $name_contact = 'ผู้ติดต่อไทย';
                  }else{
                    $name_contact = 'ผู้ติดต่อต่างชาติ';
                  }
                  $detail['sub_member'] = [//operator_name
                    "operator_type" =>  $data_m['director_status'],
                    "operator_name" =>  ($data_m['director_status'] == '1')? "กรรมการ":"ผู้รับมอบอำนาจ",
                    "operator_verify_id" => (empty($data_m['status_case']))? '': $data_m['status_case'],
                    "operator_verify_name" => (empty($status_name))? '': $status_name,
                    "status_contact" => (empty($status_contact))? '': $status_contact,
                    "name_contact" => (empty($name_contact))? '': $name_contact,
                    "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                    "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                    "titleEn" => $titleEn,
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "midnameTh" => (empty($data_m['member_midnameTh']))? '': $data_m['member_midnameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "midnameEn" => (empty($data_m['member_midnameEn']))? '': $data_m['member_midnameEn'],
                    "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "birthday" => (empty($data_m['member_birthday']))? '': $data_m['member_birthday'],
                    "cid" => (empty($data_m['member_cid']))? '': $data_m['member_cid'],
                    "email" => (empty($data_m['member_email']))? '': $data_m['member_email'],
                    "tel" => (empty($data_m['member_tel']))? '': $data_m['member_tel'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['member_tel_country']))? '': $data_m['member_tel_country'],
                    "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['member_tel_country'].".png"
                  ];
   
                  $stmt_att = $this->db->prepare("SELECT * FROM tb_member_attachment WHERE member_id = ?");
                  $stmt_att->bind_param("s", $tokendata['member_id']);
                  $stmt_att->execute();
                  $result_att = $stmt_att->get_result();
                  foreach ($result_att as $value_attachment) {
                    switch ($value_attachment['status']) {
                      case '1':
                        $status_name = 'อนุมัติแล้ว';
                        break;
                      case '2':
                        $status_name = 'ไม่อนุมัติ';
                        break;
                      default:
                        $status_name = 'รอตรวจสอบ';
                        break;
                    }
                    if($value_attachment['director_status'] == '1'){
                        $power_attorney_href = $value_attachment['attachment_file_name'];
                        $detail['attachment'] []= [
                          "type_file" => $value_attachment['type_file'],
                          "type_name" => "เอกสาร",
                          "status_id" => $value_attachment['status'],
                          "status_name" => $status_name,
                          "url" => BASE_URL."asset/attach/".$tokendata['member_id']."/".$power_attorney_href,
                          "updated_at" => $value_attachment['updated_at']
                      ];
                    }else if($value_attachment['director_status'] == '2'){
                        $power_attorney_href = $value_attachment['attachment_file_name'];
                        $detail['attachment'] []= [
                          "type_file" => $value_attachment['type_file'],
                          "type_name" => ($value_attachment['type_file'] == '1')? "เอกสารมอบอำนาจ":"สำเนาบัตรประชาชนผู้มอบอำนาจ",
                          "status_id" => $value_attachment['status'],
                          "status_name" => $status_name,
                          "url" => BASE_URL."asset/attach/".$tokendata['member_id']."/".$power_attorney_href,
                          "updated_at" => $value_attachment['updated_at']
                      ];
                    }else {
                      $detail['attachment'] = [];
                    }
                  }
  
                  break;
                case '2':
                  # นิติบุคคล ต่างชาติ
                  $sql_m = 'SELECT * FROM tb_member_type2 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }
                  $detail['corporate'] = [
                    "name" => (empty($data_m['corporate_name']))? '': $data_m['corporate_name'],

                  ];
                  $detail['address'] = [
                    "country" => (empty($data_m['country']))? '': $data_m['country'],
                    "address" => (empty($data_m['address']))? '': $data_m['address'],
                  ];
                  $titleTh = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'Mr.'){
                      $titleTh = 'นาย';
                    }else if($data_m['member_title'] == 'Mrs.'){
                      $titleTh = 'นาง';
                    }elseif($data_m['member_title'] == 'Miss'){
                      $titleTh = 'นางสาว';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }

                  $detail['sub_member'] = [
                    "titleTh" => $titleTh,
                    "titleEn" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "midnameTh" => (empty($data_m['member_midnameTh']))? '': $data_m['member_midnameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "midnameEn" => (empty($data_m['member_midnameEn']))? '': $data_m['member_midnameEn'],
                    "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "email" => (empty($data_m['email']))? '': $data_m['email'],
                    "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
                    //"tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
                    "tel_icon_country" => (empty($data_m['tel_country']))? '' : BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
                  ];

                  break;
                case '3':
                  # บุคคล ไทย
                  $sql_m = 'SELECT * FROM tb_member_type3 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }

                  $titleEn = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'นาย'){
                      $titleEn = 'Mr.';
                    }else if($data_m['member_title'] == 'นาง'){
                      $titleEn = 'Mrs.';
                    }else if($data_m['member_title'] == 'นางสาว'){
                      $titleEn = 'Miss';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }

                  $detail['member'] = [
                    "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                    "titleEn" => $titleEn,
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "midnameTh" => (empty($data_m['member_midnameTh']))? '': $data_m['member_midnameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "midnameEn" => (empty($data_m['member_midnameEn']))? '': $data_m['member_midnameEn'],
                    "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "birthday" => (empty($data_m['member_birthday']))? '': $data_m['member_birthday'],
                    "email" => (empty($data_m['email']))? '': $data_m['email'],
                    "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
                    "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
                  ];
                  $detail['addressTh'] = [
                    "address" => (empty($data_m['addressTh']))? '': $data_m['addressTh'],
                    "province" => (empty($data_m['provinceTh']))? '': $data_m['provinceTh'],
                    "district" => (empty($data_m['districtTh']))? '': $data_m['districtTh'],
                    "subdistrict" => (empty($data_m['subdistrictTh']))? '': $data_m['subdistrictTh'],
                    "postcode" => (empty($data_m['postcode']))? '': $data_m['postcode'],
                  ];
                  $detail['addressEn'] = [
                    "address" => (empty($data_m['addressEn']))? '': $data_m['addressEn'],
                    "province" => (empty($data_m['provinceEn']))? '': $data_m['provinceEn'],
                    "district" => (empty($data_m['districtEn']))? '': $data_m['districtEn'],
                    "subdistrict" => (empty($data_m['subdistrictEn']))? '': $data_m['subdistrictEn'],
                    "postcode" => (empty($data_m['postcode']))? '': $data_m['postcode'],
                  ];

                  break;
                case '4':
                  # บุคคล ต่างชาติ
                  $sql_m = 'SELECT * FROM tb_member_type4 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }

                  $titleTh = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'Mr.'){
                      $titleTh = 'นาย';
                    }else if($data_m['member_title'] == 'Mrs.'){
                      $titleTh = 'นาง';
                    }elseif($data_m['member_title'] == 'Miss'){
                      $titleTh = 'นางสาว';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }

                  $detail['member'] = [
                    "titleTh" => $titleTh,
                    "titleEn" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "midnameTh" => (empty($data_m['member_midnameTh']))? '': $data_m['member_midnameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "midnameEn" => (empty($data_m['member_midnameEn']))? '': $data_m['member_midnameEn'],
                    "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "email" => (empty($data_m['email']))? '': $data_m['email'],
                    "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
                    //"tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
                    "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
                  ];
                  $detail['address'] = [
                    "country" => (empty($data_m['country']))? '': $data_m['country'],
                    "address" => (empty($data_m['address']))? '': $data_m['address'],
                  ];

                  break;

                case '5':
                  # อื่นๆ
                  $sql_m = 'SELECT * FROM tb_member_type5 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }

                  $titleEn = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'นาย'){
                      $titleEn = 'Mr.';
                    }else if($data_m['member_title'] == 'นาง'){
                      $titleEn = 'Mrs.';
                    }elseif($data_m['member_title'] == 'นางสาว'){
                      $titleEn = 'Miss';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }

                  $detail['member'] = [
                    "titleTh" => $data_m['member_title'],
                    "titleEn" => $titleEn,
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => '', //(empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "lastnameEn" => '', //(empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "email" => (empty($data_m['email']))? '': $data_m['email'],
                    "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
                    //"tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
                    "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
                  ];
                  $detail['address'] = [
                    "address" => (empty($data_m['addressTh']))? '': $data_m['addressTh'],
                    "province" => (empty($data_m['provinceTh']))? '': $data_m['provinceTh'],
                    "district" => (empty($data_m['districtTh']))? '': $data_m['districtTh'],
                    "subdistrict" => (empty($data_m['subdistrictTh']))? '': $data_m['subdistrictTh'],
                    "postcode" => (empty($data_m['postcode']))? '': $data_m['postcode'],
                  ];

                  break;
                  case '6':
  
                    # นิติบุคคลที่ยังไม่จดทะเบียน ไทย
  
                    $sql_m = 'SELECT * FROM tb_member_type6 WHERE member_id = "' . $tokendata['member_id'] . '"';
                    $query_m = $this->query($sql_m);
                    $data_m = [];
                    if (count($query_m) > 0) {
                      $data_m = $query_m[0];
                    }
  
                    $detail['company'] = [
                      "nameTh" => (empty($data_m['company_nameTh']))? '': $data_m['company_nameTh'] ,
                      "nameEn" => (empty($data_m['company_nameEn']))? '': $data_m['company_nameEn']
                    ];
                    $detail['addressTh'] = [
                      "address" => (empty($data_m['company_addressTh']))? '': $data_m['company_addressTh'],
                      "province" => (empty($data_m['company_provinceTh']))? '': $data_m['company_provinceTh'],
                      "district" => (empty($data_m['company_districtTh']))? '':$data_m['company_districtTh'],
                      "subdistrict" => (empty($data_m['company_subdistrictTh']))? '':$data_m['company_subdistrictTh'],
                      "postcode" => (empty($data_m['company_postcodeTh']))? '':$data_m['company_postcodeTh']
                    ];
                    $detail['addressEn'] = [
                      "address" => (empty($data_m['company_addressEn']))? '': $data_m['company_addressEn'],
                      "province" => (empty($data_m['company_provinceEn']))? '': $data_m['company_provinceEn'],
                      "district" => (empty($data_m['company_districtEn']))? '': $data_m['company_districtEn'],
                      "subdistrict" => (empty($data_m['company_subdistrictEn']))? '': $data_m['company_subdistrictEn'],
                      "postcode" => (empty($data_m['company_postcodeEn']))? '':$data_m['company_postcodeEn'] ,
                    ];
                    $detail['contact'] = [
                      "address" => (empty($data_m['contact_address']))? '': $data_m['contact_address'],
                      "province" => (empty($data_m['contact_province']))? '': $data_m['contact_province'],
                      "district" => (empty($data_m['contact_district']))? '': $data_m['contact_district'],
                      "subdistrict" => (empty($data_m['contact_subdistrict']))? '': $data_m['contact_subdistrict'],
                      "postcode" => (empty($data_m['contact_postcode']))? '': $data_m['contact_postcode'],
                    ];
  
                    $titleEn = '';
                    if(!empty($data_m['member_title'])){ 
                      if($data_m['member_title'] == 'นาย'){
                        $titleEn = 'Mr.';
                      }else if($data_m['member_title'] == 'นาง'){
                        $titleEn = 'Mrs.';
                      }elseif($data_m['member_title'] == 'นางสาว'){
                        $titleEn = 'Miss';
                      }
                    }
  
                    $member_tel_code = '';
                    $data_tel_code = $data_m['member_tel_code'];
                    if(!empty($data_tel_code)){
                      if(strstr($data_tel_code,'+')) //found
                        $member_tel_code = $data_tel_code;
                      else
                        $member_tel_code = "+".$data_tel_code; 
                    }
  
                    $detail['sub_member'] = [
                      "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                      "titleEn" => $titleEn,
                      "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                      "midnameTh" => (empty($data_m['member_midnameTh']))? '': $data_m['member_midnameTh'],
                      "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                      "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                      "midnameEn" => (empty($data_m['member_midnameEn']))? '': $data_m['member_midnameEn'],
                      "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                      "birthday" => (empty($data_m['member_birthday']))? '': $data_m['member_birthday'],
                      "cid" => (empty($data_m['member_cid']))? '': $data_m['member_cid'],
                      "email" => (empty($data_m['member_email']))? '': $data_m['member_email'],
                      "tel" => (empty($data_m['member_tel']))? '': $data_m['member_tel'],
                      //"tel_code" => (empty($data_m['member_tel_code']))? '': $data_m['member_tel_code'],
                      "tel_code" => $member_tel_code,
                      "tel_country_code" => (empty($data_m['member_tel_country']))? '': $data_m['member_tel_country'],
                      "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['member_tel_country'].".png"
                    ];
  
                    break;
                default:
                  # ไม่มี 
                  $detail = [];
                  break;
              }
            }
            $return_data = array_merge($result, $detail, $update, $verify);
            $return = ['res_code' => '00', 'res_text' => 'success !', 'res_result' => $return_data];
          }
        } else {
          $return = ['res_code' => '01', 'res_text' => 'Token Not Found.'];
        }
      }
    } else {
      $return = ['res_code' => '01', 'res_text' => 'Client_ID Not Found.'];
    }

    return $return;
  }

  function one_get_info($cid = '')
  {
    $return = ['res_code' => '01', 'res_text' => 'Data Not Found.'];
    
    $sql_m = 'SELECT * FROM tb_member WHERE cid ="' . $cid . '" and status = 1 limit 1';
    $query_m = $this->query($sql_m);
    if (count($query_m) > 0) {
      $data_m = $query_m[0];
      $type = $data_m['type'];
      $date_explode = explode(" ", $data_m['create_date']);
      $create_date_explode = explode("-",$date_explode[0]);
      $y = $create_date_explode[0];
      $m = $create_date_explode[1];
      $d = $create_date_explode[2];

      $create_date = $d."/".$m."/".$y;
      $result = [
        'ssoid' => $data_m['sso_id'],
        'naturalId' => $data_m['cid'],
        'create_date' => $create_date,
        'type' => $type,
      ];

      switch ($type) {
        case '1':
          # นิติบุคคล ไทย

          $sql_m = 'SELECT * FROM tb_member_type1 WHERE member_id = "' . $data_m['member_id'] . '"';
          $query_m = $this->query($sql_m);
          $data_m = [];
          if (count($query_m) > 0) {
            $data_m = $query_m[0];
          }

          $detail['company'] = [
            "nameTh" => (empty($data_m['company_nameTh']))? '': $data_m['company_nameTh'] ,
            "nameEn" => (empty($data_m['company_nameEn']))? '': $data_m['company_nameEn']
          ];
          $detail['addressTh'] = [
            "address" => (empty($data_m['company_addressTh']))? '': $data_m['company_addressTh'],
            "province" => (empty($data_m['company_provinceTh']))? '': $data_m['company_provinceTh'],
            "district" => (empty($data_m['company_districtTh']))? '':$data_m['company_districtTh'],
            "subdistrict" => (empty($data_m['company_subdistrictTh']))? '':$data_m['company_subdistrictTh'],
            "postcode" => (empty($data_m['company_postcodeTh']))? '':$data_m['company_postcodeTh']
          ];
          $detail['addressEn'] = [
            "address" => (empty($data_m['company_addressEn']))? '': $data_m['company_addressEn'],
            "province" => (empty($data_m['company_provinceEn']))? '': $data_m['company_provinceEn'],
            "district" => (empty($data_m['company_districtEn']))? '': $data_m['company_districtEn'],
            "subdistrict" => (empty($data_m['company_subdistrictEn']))? '': $data_m['company_subdistrictEn'],
            "postcode" => (empty($data_m['company_postcodeEn']))? '':$data_m['company_postcodeEn'] ,
          ];
          $detail['contact'] = [
            "address" => (empty($data_m['contact_address']))? '': $data_m['contact_address'],
            "province" => (empty($data_m['contact_province']))? '': $data_m['contact_province'],
            "district" => (empty($data_m['contact_district']))? '': $data_m['contact_district'],
            "subdistrict" => (empty($data_m['contact_subdistrict']))? '': $data_m['contact_subdistrict'],
            "postcode" => (empty($data_m['contact_postcode']))? '': $data_m['contact_postcode'],
          ];

          $titleEn = '';
          if(!empty($data_m['member_title'])){ 
            if($data_m['member_title'] == 'นาย'){
              $titleEn = 'Mr.';
            }else if($data_m['member_title'] == 'นาง'){
              $titleEn = 'Mrs.';
            }elseif($data_m['member_title'] == 'นางสาว'){
              $titleEn = 'Miss';
            }
          }

          $detail['sub_member'] = [
            "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
            "titleEn" => $titleEn,
            "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
            "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
            "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
            "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
            "cid" => (empty($data_m['member_cid']))? '': $data_m['member_cid'],
            "email" => (empty($data_m['member_email']))? '': $data_m['member_email'],
            "tel" => (empty($data_m['member_tel']))? '': $data_m['member_tel'],
            "tel_code" => (empty($data_m['member_tel_code']))? '': $data_m['member_tel_code'],
            "tel_country_code" => (empty($data_m['member_tel_country']))? '': $data_m['member_tel_country'],
            "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['member_tel_country'].".png"
          ];
          break;
        case '2':
          # นิติบุคคล ต่างชาติ
          $sql_m = 'SELECT * FROM tb_member_type2 WHERE member_id = "' . $data_m['member_id'] . '"';
          $query_m = $this->query($sql_m);
          $data_m = [];
          if (count($query_m) > 0) {
            $data_m = $query_m[0];
          }
          $detail['corporate'] = [
            "name" => (empty($data_m['corporate_name']))? '': $data_m['corporate_name'],

          ];
          $detail['address'] = [
            "country" => (empty($data_m['country']))? '': $data_m['country'],
            "address" => (empty($data_m['address']))? '': $data_m['address'],
          ];

          $titleTh = '';
          if(!empty($data_m['member_title'])){ 
            if($data_m['member_title'] == 'Mr.'){
              $titleTh = 'นาย';
            }else if($data_m['member_title'] == 'Mrs.'){
              $titleTh = 'นาง';
            }elseif($data_m['member_title'] == 'Miss'){
              $titleTh = 'นางสาว';
            }
          }

          $detail['sub_member'] = [
            "titleTh" => $titleTh,
            "titleEn" => (empty($data_m['member_title']))? '': $data_m['member_title'],
            "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
            "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
            "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
            "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
            "email" => (empty($data_m['email']))? '': $data_m['email'],
            "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
            "tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
            "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
            "tel_icon_country" => (empty($data_m['tel_country']))? '' : BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
          ];
          break;
        case '3':
          # บุคคล ไทย
          $sql_m = 'SELECT * FROM tb_member_type3 WHERE member_id = "' . $data_m['member_id'] . '"';
          $query_m = $this->query($sql_m);
          $data_m = [];
          if (count($query_m) > 0) {
            $data_m = $query_m[0];
          }

          $titleEn = '';
          if(!empty($data_m['member_title'])){ 
            if($data_m['member_title'] == 'นาย'){
              $titleEn = 'Mr.';
            }else if($data_m['member_title'] == 'นาง'){
              $titleEn = 'Mrs.';
            }else if($data_m['member_title'] == 'นางสาว'){
              $titleEn = 'Miss';
            }
          }

          $detail['member'] = [
            "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
            "titleEn" => $titleEn,
            "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
            "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
            "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
            "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
            "email" => (empty($data_m['email']))? '': $data_m['email'],
            "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
            "tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
            "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
            "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
          ];
          $detail['addressTh'] = [
            "address" => (empty($data_m['addressTh']))? '': $data_m['addressTh'],
            "province" => (empty($data_m['provinceTh']))? '': $data_m['provinceTh'],
            "district" => (empty($data_m['districtTh']))? '': $data_m['districtTh'],
            "subdistrict" => (empty($data_m['subdistrictTh']))? '': $data_m['subdistrictTh'],
            "postcode" => (empty($data_m['postcode']))? '': $data_m['postcode'],
          ];
          $detail['addressEn'] = [
            "address" => (empty($data_m['addressEn']))? '': $data_m['addressEn'],
            "province" => (empty($data_m['provinceEn']))? '': $data_m['provinceEn'],
            "district" => (empty($data_m['districtEn']))? '': $data_m['districtEn'],
            "subdistrict" => (empty($data_m['subdistrictEn']))? '': $data_m['subdistrictEn'],
            "postcode" => (empty($data_m['postcode']))? '': $data_m['postcode'],
          ];
          break;
        case '4':

          # บุคคล ต่างชาติ
          $sql_m = 'SELECT * FROM tb_member_type4 WHERE member_id = "' . $data_m['member_id'] . '"';
          $query_m = $this->query($sql_m);
          $data_m = [];
          if (count($query_m) > 0) {
            $data_m = $query_m[0];
          }

          $titleTh = '';
          if(!empty($data_m['member_title'])){ 
            if($data_m['member_title'] == 'Mr.'){
              $titleTh = 'นาย';
            }else if($data_m['member_title'] == 'Mrs.'){
              $titleTh = 'นาง';
            }elseif($data_m['member_title'] == 'Miss'){
              $titleTh = 'นางสาว';
            }
          }
          
          $detail['member'] = [
            "titleTh" => $titleTh,
            "titleEn" => (empty($data_m['member_title']))? '': $data_m['member_title'],
            "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
            "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
            "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
            "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
            "email" => (empty($data_m['email']))? '': $data_m['email'],
            "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
            "tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
            "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
            "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
          ];
          $detail['address'] = [
            "country" => (empty($data_m['country']))? '': $data_m['country'],
            "address" => (empty($data_m['address']))? '': $data_m['address'],
          ];
          break;

          case '5':
            # อื่นๆ
            $sql_m = 'SELECT * FROM tb_member_type5 WHERE member_id = "' . $data_m['member_id'] . '"';
            $query_m = $this->query($sql_m);
            $data_m = [];
            if (count($query_m) > 0) {
              $data_m = $query_m[0];
            }

            // $titleTh = '';
            // if(!empty($data_m['member_title'])){ 
            //   if($data_m['member_title'] == 'Mr.'){
            //     $titleTh = 'นาย';
            //   }else if($data_m['member_title'] == 'Mrs.'){
            //     $titleTh = 'นาง';
            //   }elseif($data_m['member_title'] == 'Miss'){
            //     $titleTh = 'นางสาว';
            //   }
            // }

            $detail['member'] = [
              "titleTh" => (empty($data_m['member_titleTh']))? '': $data_m['member_titleTh'],
              "titleEn" => '', //(empty($data_m['member_title']))? '': $data_m['member_title'],
              "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
              "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
              "nameEn" => '', //(empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
              "lastnameEn" => '', //(empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
              "email" => (empty($data_m['email']))? '': $data_m['email'],
              "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
              "tel_code" => '', //(empty($data_m['tel_code']))? '': $data_m['tel_code'],
              "tel_country_code" => '',//(empty($data_m['tel_country']))? '': $data_m['tel_country'],
              "tel_icon_country" => '',//BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
            ];
            $detail['address'] = [
              "address" => (empty($data_m['addressTh']))? '': $data_m['addressTh'],
              "province" => (empty($data_m['provinceTh']))? '': $data_m['provinceTh'],
              "district" => (empty($data_m['districtTh']))? '': $data_m['districtTh'],
              "subdistrict" => (empty($data_m['subdistrictTh']))? '': $data_m['subdistrictTh'],
              "postcode" => (empty($data_m['postcode']))? '': $data_m['postcode'],
            ];
          break;

          case '6':
            # นิติบุคคล ไทย
  
            $sql_m = 'SELECT * FROM tb_member_type6 WHERE member_id = "' . $data_m['member_id'] . '"';
            $query_m = $this->query($sql_m);
            $data_m = [];
            if (count($query_m) > 0) {
              $data_m = $query_m[0];
            }
  
            $detail['company'] = [
              "nameTh" => (empty($data_m['company_nameTh']))? '': $data_m['company_nameTh'] ,
              "nameEn" => (empty($data_m['company_nameEn']))? '': $data_m['company_nameEn']
            ];
            $detail['addressTh'] = [
              "address" => (empty($data_m['company_addressTh']))? '': $data_m['company_addressTh'],
              "province" => (empty($data_m['company_provinceTh']))? '': $data_m['company_provinceTh'],
              "district" => (empty($data_m['company_districtTh']))? '':$data_m['company_districtTh'],
              "subdistrict" => (empty($data_m['company_subdistrictTh']))? '':$data_m['company_subdistrictTh'],
              "postcode" => (empty($data_m['company_postcodeTh']))? '':$data_m['company_postcodeTh']
            ];
            $detail['addressEn'] = [
              "address" => (empty($data_m['company_addressEn']))? '': $data_m['company_addressEn'],
              "province" => (empty($data_m['company_provinceEn']))? '': $data_m['company_provinceEn'],
              "district" => (empty($data_m['company_districtEn']))? '': $data_m['company_districtEn'],
              "subdistrict" => (empty($data_m['company_subdistrictEn']))? '': $data_m['company_subdistrictEn'],
              "postcode" => (empty($data_m['company_postcodeEn']))? '':$data_m['company_postcodeEn'] ,
            ];
            $detail['contact'] = [
              "address" => (empty($data_m['contact_address']))? '': $data_m['contact_address'],
              "province" => (empty($data_m['contact_province']))? '': $data_m['contact_province'],
              "district" => (empty($data_m['contact_district']))? '': $data_m['contact_district'],
              "subdistrict" => (empty($data_m['contact_subdistrict']))? '': $data_m['contact_subdistrict'],
              "postcode" => (empty($data_m['contact_postcode']))? '': $data_m['contact_postcode'],
            ];
  
            $titleEn = '';
            if(!empty($data_m['member_title'])){ 
              if($data_m['member_title'] == 'นาย'){
                $titleEn = 'Mr.';
              }else if($data_m['member_title'] == 'นาง'){
                $titleEn = 'Mrs.';
              }elseif($data_m['member_title'] == 'นางสาว'){
                $titleEn = 'Miss';
              }
            }
  
            $detail['sub_member'] = [
              "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
              "titleEn" => $titleEn,
              "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
              "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
              "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
              "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
              "cid" => (empty($data_m['member_cid']))? '': $data_m['member_cid'],
              "email" => (empty($data_m['member_email']))? '': $data_m['member_email'],
              "tel" => (empty($data_m['member_tel']))? '': $data_m['member_tel'],
              "tel_code" => (empty($data_m['member_tel_code']))? '': $data_m['member_tel_code'],
              "tel_country_code" => (empty($data_m['member_tel_country']))? '': $data_m['member_tel_country'],
              "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['member_tel_country'].".png"
            ];
            break;
          default:
          # ไม่มี 
          $detail = [];
          break;
      }
      $return_data = array_merge($result, $detail);
      $return = ['res_code' => '00', 'res_text' => 'success !', 'res_result' => $return_data];
    }
    return $return;
  }

  function create_token($client_id = '', $code = ''){
    /*$return = ['client_id' => $client_id, 'code' => $code];
    return $return;*/

    #save log
    // $param = [
    //   'code' => $code,
    //   'client_id' => $client_id,
    // ];
    // $this->save_log_call_api(json_encode($param), $client_id);

    /*********** decode JWT *************/
    $return = ['res_code' => '01', 'res_text' => 'Data Not Found.'];
    $sql = 'SELECT * FROM tb_merchant where client_id="' . mysqli_real_escape_string($this->db, $client_id) . '" and status = 1 limit 1';
    $query = $this->query($sql);
    if (count($query) > 0) {
      $data = $query[0];
      $key = $data['jwt_signature'];
      //decode JWT//
      $sub_code = explode(' ', $code);
      if (count($sub_code) > 1) {
        if ($sub_code[0] == 'Bearer' && $sub_code[1]) {
          
          try {
            $decoded = JWT::decode($sub_code[1], $key, array('HS256'));
            if (empty($decoded->id_token)) {
              $return = ['res_code' => '01', 'res_text' => 'Code Not Found1.'];
            } else {
              $token = $decoded->id_token;
              $refresh_token = $decoded->refresh_token;
            }
          } catch (Exception $e) {
            $return = ['res_code' => '01', 'res_text' => 'Code Not Found2.'];
          }
        }
      } else {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found3.'];
      }
      if (empty($token) && empty($refresh_token)) {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found4.'];
      } else {
        $sql = "SELECT * FROM tb_refresh_token, tb_token WHERE tb_token.token_id = tb_refresh_token.token_id 
        AND tb_refresh_token.refresh_code = '" . $refresh_token . "' AND tb_refresh_token.token_code='" . $token . "' limit 1 ";
        $result = $this->query($sql);

        if(count($result)>0){
          
          $data = $result[0];
          $data_token = $this->gen_token($data['member_id'], $client_id);
            if (!empty($data_token['token'])) {
              
              //$this->update('tb_access_code', ['status' => 0], '  ac_code="' . $access_token . '"');
              $jwt_data = [
                'id_token' => $data_token['token'],
                'refresh_token' => $data_token['refresh_token'],
                'end_date' =>  $data_token['exp_date'],
                'end_date_refresh' =>  $data_token['exp_date_refresh'],
                "token_type" => "Bearer"
              ];

              $jwt = JWT::encode($jwt_data, $key);
              $return = ['res_code' => '00', 'res_text' => 'success !', 'res_result' => ['code' => $jwt]];
            }
        }
      }
    }
    return $return;
  }

  // function model_member_update(){
  //   $_POST = json_decode(file_get_contents("php://input"), 1);
  //   $code = $_POST['code'];
  //   $client_id = $_POST['client_id'];
  //   $return = ['res_code' => '01', 'res_text' => 'Data Not Found.'];
  //   $sql_m = 'SELECT * FROM tb_merchant where client_id="' . mysqli_real_escape_string($this->db, $client_id) . '" and status = 1 limit 1';
  //   $query = $this->query($sql_m);
  //   if (count($query) > 0) {
  //     $data = $query[0];
  //     $key = $data['jwt_signature'];
  //     //decode JWT//
  //     $sub_code = explode(' ', $code);
  //     if (count($sub_code) > 1) {
  //       if ($sub_code[0] == 'Bearer' && $sub_code[1]) {
  //         try {
  //           $decoded = JWT::decode($sub_code[1], $key, array('HS256'));
  //           if (empty($decoded->id_token)) {
  //             $return = ['res_code' => '01', 'res_text' => 'Code Not Found1.'];
  //           } else {
  //             $id_token  = $decoded->id_token;
  //           }
  //         } catch (Exception $e) {

  //           $return = ['res_code' => '01', 'res_text' => 'Code Not Found2.'];
  //         }
  //       }
  //     } else {
  //       $return = ['res_code' => '01', 'res_text' => 'Code Not Found3.'];
  //     }
  //     ////////////////

  //     if (empty($id_token)) {
  //       $return = ['res_code' => '01', 'res_text' => 'Code Not Found4.'];
  //     } else {

  //       $sql = "SELECT * FROM tb_token WHERE client_id='" . $client_id . "' AND token_code='" . $id_token . "' limit 1 ";
  //       $query_token = $this->query($sql);
  //       if (count($query_token) > 0) {
  //         $tokendata =  $query_token[0];
  //         $member_id = $tokendata['member_id'];
  //         if ($tokendata['exp_date'] < date('Y-m-d H:i:s')) { //token หมดอายุ
  //           $return = ['res_code' => '01', 'res_text' => 'Access_code Expire'];
  //           // $return = ['res_code' => '01', 'res_text' => '.......'];
  //         } else {
  //           //-------------------------- code ผ่านการตรวจสอบ ---------------------//
  //           $sql_ck = "SELECT * FROM tb_member WHERE member_id = '$member_id'";
  //           $query_ck = $this->query($sql_ck);
  //           $sso_id = $query_ck[0]['sso_id'];
  //           $system_update = $_POST['client_id'];
  //           if(count($query_ck) > 0){
  //             $type = $query_ck[0]['type'];
  //             switch ($type) {
  //               case '1': # นิติบุคคลไทย
  //                 $company_nameTh = $_POST['company']['nameTh'];
  //                 $company_nameEn = $_POST['company']['nameEn'];

  //                 $company_addressTh = $_POST['addressTh']['address'];
  //                 $company_provinceTh = $_POST['addressTh']['province'];
  //                 $company_districtTh = $_POST['addressTh']['district'];
  //                 $company_subdistrictTh = $_POST['addressTh']['subdistrict'];
  //                 $company_postcodeTh = $_POST['addressTh']['postcode'];

  //                 $company_addressEn = $_POST['addressEn']['address'];
  //                 $company_provinceEn = $_POST['addressEn']['province'];
  //                 $company_districtEn = $_POST['addressEn']['district'];
  //                 $company_subdistrictEn = $_POST['addressEn']['subdistrict'];
  //                 $company_postcodeEn = $_POST['addressEn']['postcode'];

  //                 $contact_address = $_POST['contact']['address'];
  //                 $contact_province = $_POST['contact']['province'];
  //                 $contact_district = $_POST['contact']['district'];
  //                 $contact_subdistrict = $_POST['contact']['subdistrict'];
  //                 $contact_postcode = $_POST['contact']['postcode'];

  //                 $member_titleTh = $_POST['sub_member']['titleTh'];
  //                 // $member_titleEn = $_POST['sub_member']['titleEn'];
  //                 $member_nameTh = $_POST['sub_member']['nameTh'];
  //                 $member_midnameTh = $_POST['sub_member']['member_midnameTh'];
  //                 $member_lastnameTh = $_POST['sub_member']['lastnameTh'];
  //                 $member_nameEn = $_POST['sub_member']['nameEn'];
  //                 $member_midnameEn = $_POST['sub_member']['member_midnameEn'];
  //                 $member_lastnameEn = $_POST['sub_member']['lastnameEn'];
  //                 $member_cid = $_POST['sub_member']['cid'];
  //                 $member_email = $_POST['sub_member']['email'];
  //                 $member_birthday = $_POST['sub_member']['member_birthday'];
  //                 $member_tel = $_POST['sub_member']['tel'];
  //                 $member_tel_code = $_POST['sub_member']['tel_code'];
  //                 $member_tel_country_code = $_POST['sub_member']['tel_country_code'];

  //                 $tel_code_update = '';
  //                 $data_tel_code = $member_tel_code;
  //                 if(!empty($data_tel_code)){
  //                   if(strstr($data_tel_code,'+')) //found
  //                     $tel_code_update = $data_tel_code;
  //                   else
  //                     $tel_code_update = "+".$data_tel_code; 
  //                 }

  //                 $data_update_type1 = [
  //                   'company_nameTh' => $company_nameTh,
  //                   'company_nameEn' => $company_nameEn,
  //                   'company_addressTh' => $company_addressTh,
  //                   'company_provinceTh' => $company_provinceTh,
  //                   'company_districtTh' => $company_districtTh,
  //                   'company_subdistrictTh' => $company_subdistrictTh,
  //                   'company_postcodeTh' => $company_postcodeTh,
  //                   'company_addressEn' => $company_addressEn,
  //                   'company_provinceEn' => $company_provinceEn,
  //                   'company_districtEn' => $company_districtEn,
  //                   'company_subdistrictEn' => $company_subdistrictEn,
  //                   'company_postcodeEn' => $company_postcodeEn,
  //                   'contact_address' => $contact_address,
  //                   'contact_province' => $contact_province,
  //                   'contact_district' => $contact_district,
  //                   'contact_subdistrict' => $contact_subdistrict,
  //                   'contact_postcode' => $contact_postcode,
  //                   'member_title' => $member_titleTh,
  //                   'member_cid' => $member_cid,
  //                   'member_nameTh' => $member_nameTh,
  //                   'member_midnameTh' => $member_midnameTh,
  //                   'member_lastnameTh' => $member_lastnameTh,
  //                   'member_nameEn' => $member_nameEn,
  //                   'member_midnameEn' => $member_midnameEn,
  //                   'member_lastnameEn' => $member_lastnameEn,
  //                   'member_email' => $member_email,
  //                   'member_tel' => $member_tel,
  //                   'member_tel_country' => strtoupper($member_tel_country_code),
  //                   'member_birthday' => $member_birthday,
  //                   'member_tel_code' => $tel_code_update
  //                 ];
                  
  //                 $status_type1 = $this->update('tb_member_type1', $data_update_type1, "member_id ='$member_id'");
  //                 if($status_type1){
  //                    $this->update('tb_member',['system_update'=> $system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
  //                   // $return = ['res_code' => '00', 'res_text' => 'success !'];
  //                   $return = $this->get_info($client_id, $code);
  //                 }else{
  //                   $return = ['res_code' => '01', 'res_text' => 'update fail'];
  //                 }

  //                 //------- update touch ------//
  //                 $data_update_touch = [
  //                   'company_name' => $company_nameTh,
  //                   'company_address' => $company_addressTh,
  //                   'company_postcode' => $company_postcodeTh,
  //                 ];
  //                 $type_touch = 'corporateTh';
  //                 $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
  //                 //---------------------------//

  //                 break;

  //               case '2': # นิติบุคคลต่างชาติ
  //                 $corporate_name = $_POST['corporate']['name'];
  //                 $country = $_POST['address']['country'];
  //                 $address = $_POST['address']['address'];
  //                 $member_title = $_POST['sub_member']['titleEn'];
  //                 $member_nameEn = $_POST['sub_member']['nameEn'];
  //                 $member_midnameEn = $_POST['sub_member']['member_midnameEn'];
  //                 $member_lastnameEn = $_POST['sub_member']['lastnameEn'];
  //                 $email = $_POST['sub_member']['email'];
  //                 $tel = $_POST['sub_member']['tel'];
  //                 $tel_country = $_POST['sub_member']['tel_country_code'];
  //                 $tel_code = $_POST['sub_member']['tel_code'];

  //                 $tel_code_update = '';
  //                 $data_tel_code = $tel_code;
  //                 if(!empty($data_tel_code)){
  //                   if(strstr($data_tel_code,'+')) //found
  //                     $tel_code_update = $data_tel_code;
  //                   else
  //                     $tel_code_update = "+".$data_tel_code; 
  //                 }

  //                 $data_update_type2 = [
  //                   'corporate_name' =>  $corporate_name,
  //                   'country' => $country,
  //                   'address' => $address,
  //                   'member_title' => $member_title,
  //                   'member_nameEn' => $member_nameEn,
  //                   'member_midnameEn' => $member_midnameEn,
  //                   'member_lastnameEn' => $member_lastnameEn,
  //                   'email' => $email,
  //                   'tel' => $tel,
  //                   'tel_country' => strtoupper($tel_country),
  //                   'tel_code' => $tel_code_update
  //                 ];

  //                 $status_type2 = $this->update('tb_member_type2', $data_update_type2, ' member_id="' . $member_id . '"');
  //                 if($status_type2){
  //                   $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
                    
  //                   //$return = ['res_code' => '00', 'res_text' => 'success !'];
  //                   $return = $this->get_info($client_id, $code);
  //                 }else{
  //                   $return = ['res_code' => '01', 'res_text' => 'update fail'];
  //                 }

  //                 //------- update touch ------//
  //                 $data_update_touch = [
  //                   'company_name' => $corporate_name,
  //                   'company_address' => $address,
  //                 ];
  //                 $type_touch = 'corporateEn';
  //                 $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
  //                 //---------------------------//

  //                 break;

  //               case '3': # บุคคลไทย
  //                 $member_title = $_POST['member']['titleTh'];
  //                 $member_nameTh = $_POST['member']['nameTh'];
  //                 $member_midnameTh = $_POST['member']['member_midnameTh'];
  //                 $member_lastnameTh = $_POST['member']['lastnameTh'];
  //                 $member_nameEn = $_POST['member']['nameEn'];
  //                 $member_midnameEn = $_POST['member']['member_midnameEn'];
  //                 $member_lastnameEn = $_POST['member']['lastnameEn'];
  //                 $email = $_POST['member']['email'];
  //                 $member_birthday = $_POST['member']['member_birthday'];
  //                 $tel = $_POST['member']['tel'];
  //                 $tel_country = $_POST['member']['tel_country_code'];
  //                 $tel_code = $_POST['member']['tel_code'];

  //                 $addressTh = $_POST['addressTh']['address'];
  //                 $provinceTh = $_POST['addressTh']['province'];
  //                 $districtTh = $_POST['addressTh']['district'];
  //                 $subdistrictTh = $_POST['addressTh']['subdistrict'];
  //                 $postcode = $_POST['addressTh']['postcode'];

  //                 $addressEn = $_POST['addressEn']['address'];
  //                 $provinceEn = $_POST['addressEn']['province'];
  //                 $districtEn = $_POST['addressEn']['district'];
  //                 $subdistrictEn = $_POST['addressEn']['subdistrict'];

  //                 $tel_code_update = '';
  //                 $data_tel_code = $tel_code;
  //                 if(!empty($data_tel_code)){
  //                   if(strstr($data_tel_code,'+')) //found
  //                     $tel_code_update = $data_tel_code;
  //                   else
  //                     $tel_code_update = "+".$data_tel_code; 
  //                 }

  //                 $data_update_type3 = [
  //                   'member_title' => $member_title,
  //                   'member_nameTh' => $member_nameTh,
  //                   'member_midnameTh' => $member_midnameTh,
  //                   'member_lastnameTh' => $member_lastnameTh,
  //                   'member_nameEn' => $member_nameEn,
  //                   'member_midnameEn' => $member_midnameEn,
  //                   'member_lastnameEn' => $member_lastnameEn,
  //                   'member_birthday' => $member_birthday,
  //                   'email' => $email,
  //                   'tel' => $tel,
  //                   'tel_country' => strtoupper($tel_country),
  //                   //'tel_code' => $tel_code,
  //                   'tel_code' => $tel_code_update,
  //                   'addressTh' => $addressTh,
  //                   'provinceTh' => $provinceTh,
  //                   'districtTh' => $districtTh,
  //                   'subdistrictTh' => $subdistrictTh,
  //                   'postcode' => $postcode,
  //                   'addressEn' => $addressEn,
  //                   'provinceEn' => $provinceEn,
  //                   'districtEn' => $districtEn,
  //                   'subdistrictEn' => $subdistrictEn
  //                 ];
  //                 $status_type3 = $this->update('tb_member_type3', $data_update_type3, ' member_id="' . $member_id . '"');
  //                 if($status_type3){
  //                   //$return = ['res_code' => '00', 'res_text' => 'success !'];
  //                   $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
  //                   $return = $this->get_info($client_id, $code);
  //                 }else{
  //                   $return = ['res_code' => '01', 'res_text' => 'update fail'];
  //                 }

  //                 //------- update touch ------//
  //                 $data_update_touch = [
  //                   'firstname' => $member_nameTh,
  //                   'lastname' => $member_lastnameTh,
  //                   'mobile' => $tel,
  //                 ];
  //                 $type_touch = 'person';
  //                 $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
  //                 //---------------------------//
  //                 break;

  //               case '4': # บุคคลต่างชาติ
  //                 $member_title = $_POST['member']['titleEn'];
  //                 //$member_nameTh = $_POST['member']['nameTh'];
  //                 //$member_lastnameTh = $_POST['member']['lastnameTh'];
  //                 $member_nameEn = $_POST['member']['nameEn'];
  //                 $member_midnameEn = $_POST['member']['member_midnameEn'];
  //                 $member_lastnameEn = $_POST['member']['lastnameEn'];
  //                 $email = $_POST['member']['email'];
  //                 $tel = $_POST['member']['tel'];
  //                 $tel_country = $_POST['member']['tel_country_code'];
  //                 $tel_code = $_POST['member']['tel_code'];
                  
  //                 $country = $_POST['address']['country'];
  //                 $address = $_POST['address']['address'];
                  
  //                 $tel_code_update = '';
  //                 $data_tel_code = $tel_code;
  //                 if(!empty($data_tel_code)){
  //                   if(strstr($data_tel_code,'+')) //found
  //                     $tel_code_update = $data_tel_code;
  //                   else
  //                     $tel_code_update = "+".$data_tel_code; 
  //                 }

  //                 $data_update_type4 = [
  //                   'member_title' => $member_title,
  //                   //'member_nameTh' => $member_nameTh,
  //                   //'member_lastnameTh' => $member_lastnameTh,
  //                   'member_nameEn' => $member_nameEn,
  //                   'member_nameEn' => $member_midnameEn,
  //                   'member_lastnameEn' => $member_lastnameEn,
  //                   'country' => $country,
  //                   'address' => $address,
  //                   'email' => $email,
  //                   'tel' => $tel,
  //                   'tel_country' => strtoupper($tel_country),
  //                   //'tel_code' => $tel_code
  //                   'tel_code' => $tel_code_update
  //                 ];
  //                 $status_type4 = $this->update('tb_member_type4', $data_update_type4, ' member_id="' . $member_id . '"');
  //                 if($status_type4){
  //                   //$return = ['res_code' => '00', 'res_text' => 'success !'];
  //                   $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
  //                   $return = $this->get_info($client_id, $code);
  //                 }else{
  //                   $return = ['res_code' => '01', 'res_text' => 'update fail'];
  //                 }

  //                 //------- update touch ------//
  //                 $data_update_touch = [
  //                   'firstname' => $member_nameEn,
  //                   'lastname' => $member_lastnameEn,
  //                   'mobile' => $tel,
  //                 ];
  //                 $type_touch = 'person';
  //                 $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
  //                 //---------------------------//

  //                 break;

  //               case '5': # อื่นๆ
  //                 $member_title = $_POST['member']['titleTh'];
  //                 $member_nameTh = $_POST['member']['nameTh'];
  //                 $member_lastnameTh = $_POST['member']['lastnameTh'];
  //                 $member_nameEn = $_POST['member']['nameEn'];
  //                 $member_lastnameEn = $_POST['member']['lastnameEn'];
  //                 $email = $_POST['member']['email'];
  //                 $tel = $_POST['member']['tel'];
  //                 $tel_country = $_POST['member']['tel_country_code'];
  //                 $tel_code = $_POST['member']['tel_code'];

  //                 $addressTh = $_POST['address']['address'];
  //                 $provinceTh = $_POST['address']['province'];
  //                 $districtTh = $_POST['address']['district'];
  //                 $subdistrictTh = $_POST['address']['subdistrict'];
  //                 $postcodeTh = $_POST['address']['postcode'];
                  
  //                 $tel_code_update = '';
  //                 $data_tel_code = $tel_code;
  //                 if(!empty($data_tel_code)){
  //                   if(strstr($data_tel_code,'+')) //found
  //                     $tel_code_update = $data_tel_code;
  //                   else
  //                     $tel_code_update = "+".$data_tel_code; 
  //                 }

  //                 $data_update_type5 = [
  //                   'member_title' => $member_title,
  //                   'member_nameTh' => $member_nameTh,
  //                   'member_lastnameTh' => $member_lastnameTh,
  //                   'member_nameEn' => $member_nameEn,
  //                   'member_lastnameEn' => $member_lastnameEn,
  //                   'addressTh' => $addressTh,
  //                   'provinceTh' => $provinceTh,
  //                   'districtTh' => $districtTh,
  //                   'subdistrictTh' => $subdistrictTh,
  //                   'postcode' => $postcodeTh,

  //                   'email' => $email,
  //                   'tel' => $tel,
  //                   'tel_country' => strtoupper($tel_country),
  //                   //'tel_code' => $tel_code
  //                   'tel_code' => $tel_code_update
  //                 ];

  //                 $status_type5 = $this->update('tb_member_type5', $data_update_type5, ' member_id="' . $member_id . '"');
  //                 if($status_type5){
  //                   //$return = ['res_code' => '00', 'res_text' => 'success !'];
  //                   $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
  //                   $return = $this->get_info($client_id, $code);
  //                 }else{
  //                   $return = ['res_code' => '01', 'res_text' => 'update fail'];
  //                 }

  //                 //------- update touch ------//
  //                 $data_update_touch = [
  //                   'firstname' => $member_nameTh,
  //                   'lastname' => $member_lastnameTh,
  //                   'mobile' => $tel,
  //                 ];
  //                 $type_touch = 'person';
  //                 $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
  //                 //---------------------------//

  //                 break;

  //               case '6': # นิติบุคคลไทยที่ไม่ลงทะเบียนการค้า
  //                 $company_nameTh = $_POST['company']['nameTh'];
  //                 $company_nameEn = $_POST['company']['nameEn'];

  //                 $company_addressTh = $_POST['addressTh']['address'];
  //                 $company_provinceTh = $_POST['addressTh']['province'];
  //                 $company_districtTh = $_POST['addressTh']['district'];
  //                 $company_subdistrictTh = $_POST['addressTh']['subdistrict'];
  //                 $company_postcodeTh = $_POST['addressTh']['postcode'];

  //                 $company_addressEn = $_POST['addressEn']['address'];
  //                 $company_provinceEn = $_POST['addressEn']['province'];
  //                 $company_districtEn = $_POST['addressEn']['district'];
  //                 $company_subdistrictEn = $_POST['addressEn']['subdistrict'];
  //                 $company_postcodeEn = $_POST['addressEn']['postcode'];

  //                 $contact_address = $_POST['contact']['address'];
  //                 $contact_province = $_POST['contact']['province'];
  //                 $contact_district = $_POST['contact']['district'];
  //                 $contact_subdistrict = $_POST['contact']['subdistrict'];
  //                 $contact_postcode = $_POST['contact']['postcode'];

  //                 $member_titleTh = $_POST['sub_member']['titleTh'];
  //                 //$member_titleEn = $_POST['sub_member']['titleEn'];
  //                 $member_nameTh = $_POST['sub_member']['nameTh'];
  //                 $member_midnameTh = $_POST['sub_member']['member_midnameTh'];
  //                 $member_lastnameTh = $_POST['sub_member']['lastnameTh'];
  //                 $member_nameEn = $_POST['sub_member']['nameEn'];
  //                 $member_midnameEn = $_POST['sub_member']['member_midnameEn'];
  //                 $member_lastnameEn = $_POST['sub_member']['lastnameEn'];
  //                 $member_cid = $_POST['sub_member']['cid'];
  //                 $member_email = $_POST['sub_member']['email'];
  //                 $member_tel = $_POST['sub_member']['tel'];
  //                 $member_tel_code = $_POST['sub_member']['tel_code'];
  //                 $member_tel_country_code = $_POST['sub_member']['tel_country_code'];

  //                 $tel_code_update = '';
  //                 $data_tel_code = $member_tel_code;
  //                 if(!empty($data_tel_code)){
  //                   if(strstr($data_tel_code,'+')) //found
  //                     $tel_code_update = $data_tel_code;
  //                   else
  //                     $tel_code_update = "+".$data_tel_code; 
  //                 }

  //                 $data_update_type6 = [
  //                   'company_nameTh' => $company_nameTh,
  //                   'company_nameEn' => $company_nameEn,
  //                   'company_addressTh' => $company_addressTh,
  //                   'company_provinceTh' => $company_provinceTh,
  //                   'company_districtTh' => $company_districtTh,
  //                   'company_subdistrictTh' => $company_subdistrictTh,
  //                   'company_postcodeTh' => $company_postcodeTh,
  //                   'company_addressEn' => $company_addressEn,
  //                   'company_provinceEn' => $company_provinceEn,
  //                   'company_districtEn' => $company_districtEn,
  //                   'company_subdistrictEn' => $company_subdistrictEn,
  //                   'company_postcodeEn' => $company_postcodeEn,
  //                   'contact_address' => $contact_address,
  //                   'contact_province' => $contact_province,
  //                   'contact_district' => $contact_district,
  //                   'contact_subdistrict' => $contact_subdistrict,
  //                   'contact_postcode' => $contact_postcode,
  //                   'member_title' => $member_titleTh,
  //                   'member_cid' => $member_cid,
  //                   'member_nameTh' => $member_nameTh,
  //                   'member_midnameTh' => $member_midnameTh,
  //                   'member_lastnameTh' => $member_lastnameTh,
  //                   'member_nameEn' => $member_nameEn,
  //                   'member_midnameEn' => $member_midnameEn,
  //                   'member_lastnameEn' => $member_lastnameEn,
  //                   'member_birthday' => $member_birthday,
  //                   'member_email' => $member_email,
  //                   'member_tel' => $member_tel,
  //                   'member_tel_country' => strtoupper($member_tel_country_code),
  //                   //'member_tel_code' => $member_tel_code
  //                   'member_tel_code' => $tel_code_update
  //                 ];

  //                 $status_type6 = $this->update('tb_member_type6', $data_update_type6, ' member_id="' . $member_id . '"');
  //                 if($status_type6){
  //                   //$return = ['res_code' => '00', 'res_text' => 'success !'];
  //                   $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
  //                   $return = $this->get_info($client_id, $code);
  //                 }else{
  //                   $return = ['res_code' => '01', 'res_text' => 'update fail'];
  //                 }

  //                 //------- update touch ------//
  //                 $data_update_touch = [
  //                   'company_name' => $company_nameTh,
  //                   'company_address' => $company_addressTh,
  //                   'company_postcode' => $company_postcodeTh,
  //                 ];
  //                 $type_touch = 'corporateTh';
  //                 $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
  //                 //---------------------------//

  //                 break; 

  //             }
  //           }
  //         }
          
  //       }
  //     }
  //   }

  //   return $return;
  // }
  function model_member_update(){
    $_POST = json_decode(file_get_contents("php://input"), 1);
    $code = $_POST['code'];
    $client_id = $_POST['client_id'];
    $edit = [];
    $return = ['res_code' => '01', 'res_text' => 'Data Not Found.'];
    $sql_m = 'SELECT * FROM tb_merchant where client_id="' . mysqli_real_escape_string($this->db, $client_id) . '" and status = 1 limit 1';
    $query = $this->query($sql_m);
    if (count($query) > 0) {
      $data = $query[0];
      $key = $data['jwt_signature'];
      //decode JWT//
      $sub_code = explode(' ', $code);
      if (count($sub_code) > 1) {
        if ($sub_code[0] == 'Bearer' && $sub_code[1]) {
          try {
            $decoded = JWT::decode($sub_code[1], $key, array('HS256'));
            if (empty($decoded->id_token)) {
              $return = ['res_code' => '01', 'res_text' => 'Code Not Found1.'];
            } else {
              $id_token  = $decoded->id_token;
            }
          } catch (Exception $e) {

            $return = ['res_code' => '01', 'res_text' => 'Code Not Found2.'];
          }
        }
      } else {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found3.'];
      }
      ////////////////

      if (empty($id_token)) {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found4.'];
      } else {

        $sql = "SELECT * FROM tb_token WHERE client_id='" . $client_id . "' AND token_code='" . $id_token . "' limit 1 ";
        $query_token = $this->query($sql);
        if (count($query_token) > 0) {
          $tokendata =  $query_token[0];
          $member_id = $tokendata['member_id'];
          if ($tokendata['exp_date'] < date('Y-m-d H:i:s')) { //token หมดอายุ
            $return = ['res_code' => '01', 'res_text' => 'Access_code Expire'];
            // $return = ['res_code' => '01', 'res_text' => '.......'];
          } else {
            //-------------------------- code ผ่านการตรวจสอบ ---------------------//
            $sql_ck = "SELECT * FROM tb_member WHERE member_id = '$member_id'";
            $query_ck = $this->query($sql_ck);
            $sso_id = $query_ck[0]['sso_id'];
            $system_update = $_POST['client_id'];
            if(count($query_ck) > 0){
              $type = $query_ck[0]['type'];
              switch ($type) {
                case '1': # นิติบุคคลไทย
                  $company_nameTh = $_POST['company']['nameTh'];
                  $company_nameEn = $_POST['company']['nameEn'];

                  $company_addressTh = $_POST['addressTh']['address'];
                  $company_provinceTh = $_POST['addressTh']['province'];
                  $company_districtTh = $_POST['addressTh']['district'];
                  $company_subdistrictTh = $_POST['addressTh']['subdistrict'];
                  $company_postcodeTh = $_POST['addressTh']['postcode'];

                  $company_addressEn = $_POST['addressEn']['address'];
                  $company_provinceEn = $_POST['addressEn']['province'];
                  $company_districtEn = $_POST['addressEn']['district'];
                  $company_subdistrictEn = $_POST['addressEn']['subdistrict'];
                  $company_postcodeEn = $_POST['addressEn']['postcode'];

                  $contact_address = $_POST['contact']['address'];
                  $contact_province = $_POST['contact']['province'];
                  $contact_district = $_POST['contact']['district'];
                  $contact_subdistrict = $_POST['contact']['subdistrict'];
                  $contact_postcode = $_POST['contact']['postcode'];

                  $member_titleTh = $_POST['sub_member']['titleTh'];
                  // $member_titleEn = $_POST['sub_member']['titleEn'];
                  $member_nameTh = $_POST['sub_member']['nameTh'];
                  $member_midnameTh = $_POST['sub_member']['member_midnameTh'];
                  $member_lastnameTh = $_POST['sub_member']['lastnameTh'];
                  $member_nameEn = $_POST['sub_member']['nameEn'];
                  $member_midnameEn = $_POST['sub_member']['member_midnameEn'];
                  $member_lastnameEn = $_POST['sub_member']['lastnameEn'];
                  $member_cid = $_POST['sub_member']['cid'];
                  $member_email = $_POST['sub_member']['email'];
                  $member_birthday = $_POST['sub_member']['member_birthday'];
                  $member_tel = $_POST['sub_member']['tel'];
                  $member_tel_code = $_POST['sub_member']['tel_code'];
                  $member_tel_country_code = $_POST['sub_member']['tel_country_code'];

                  $tel_code_update = '';
                  $data_tel_code = $member_tel_code;
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $tel_code_update = $data_tel_code;
                    else
                      $tel_code_update = "+".$data_tel_code; 
                  }
                  if (empty($member_nameTh)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  if (empty($member_lastnameTh)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  if (empty($member_email)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  if (empty($member_tel)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  $data_update_type1 = [
                    // 'company_nameTh' => $company_nameTh,
                    // 'company_nameEn' => $company_nameEn,
                    // 'company_addressTh' => $company_addressTh,
                    // 'company_provinceTh' => $company_provinceTh,
                    // 'company_districtTh' => $company_districtTh,
                    // 'company_subdistrictTh' => $company_subdistrictTh,
                    // 'company_postcodeTh' => $company_postcodeTh,
                    // 'company_addressEn' => $company_addressEn,
                    // 'company_provinceEn' => $company_provinceEn,
                    // 'company_districtEn' => $company_districtEn,
                    // 'company_subdistrictEn' => $company_subdistrictEn,
                    // 'company_postcodeEn' => $company_postcodeEn,
                    'contact_address' => $contact_address,
                    'contact_province' => $contact_province,
                    'contact_district' => $contact_district,
                    'contact_subdistrict' => $contact_subdistrict,
                    'contact_postcode' => $contact_postcode,
                    'member_title' => $member_titleTh,
                    // 'member_cid' => $member_cid,
                    'member_nameTh' => $member_nameTh,
                    'member_midnameTh' => $member_midnameTh,
                    'member_lastnameTh' => $member_lastnameTh,
                    'member_nameEn' => $member_nameEn,
                    'member_midnameEn' => $member_midnameEn,
                    'member_lastnameEn' => $member_lastnameEn,
                    'member_email' => $member_email,
                    'member_tel' => $member_tel,
                    'member_tel_country' => strtoupper($member_tel_country_code),
                    // 'member_birthday' => $member_birthday,
                    'member_tel_code' => $tel_code_update
                  ];

                  $stmt_ck = $this->db->prepare("SELECT * FROM tb_member_type1 WHERE member_id = ?");
                  $stmt_ck->bind_param("s", $member_id);
                  $stmt_ck->execute();
                  $result_ck = $stmt_ck->get_result();
                  $ck = $result_ck->fetch_assoc();
                  $status_type1 = $this->update('tb_member_type1', $data_update_type1, "member_id ='$member_id'");
                  $edit = [
                    "member_id" => $member_id,
                    "text_old" => json_encode($ck),
                    "text_edit" => json_encode($data_update_type1),
                    "system" => $client_id
                  ];
                  if($status_type1){
                    if(($ck['member_cid'] != $member_cid) || ($ck['member_nameTh'] != $member_nameTh) || ($ck['member_midnameTh'] != $member_midnameTh) || ($ck['member_lastnameTh'] != $member_lastnameTh)){
                      $save = [
                        "status_laser_verify" => 0,
                        "laser_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    if($ck['member_tel'] != $member_tel){
                      $save = [
                        "status_sms_verify" => 0,
                        "sms_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    if($ck['member_email'] != $member_email){
                      $save = [
                        "status_email_verify" => 0,
                        "email_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    $save = ['system_update'=> $system_update,'update_date'=>date('Y-m-d H:i:s')];

                    $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    $return = $this->get_info($client_id, $code);
                  }else{
                    $return = ['res_code' => '01', 'res_text' => 'update fail'];
                  }

                  //------- update touch ------//
                  $data_update_touch = [
                    'company_name' => $company_nameTh,
                    'company_address' => $company_addressTh,
                    'company_postcode' => $company_postcodeTh,
                  ];
                  $type_touch = 'corporateTh';
                  $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
                  //---------------------------//

                  break;

                case '2': # นิติบุคคลต่างชาติ
                  $corporate_name = $_POST['corporate']['name'];
                  $country = $_POST['address']['country'];
                  $address = $_POST['address']['address'];
                  $member_title = $_POST['sub_member']['titleEn'];
                  $member_nameEn = $_POST['sub_member']['nameEn'];
                  $member_midnameEn = $_POST['sub_member']['member_midnameEn'];
                  $member_lastnameEn = $_POST['sub_member']['lastnameEn'];
                  $email = $_POST['sub_member']['email'];
                  $tel = $_POST['sub_member']['tel'];
                  $tel_country = $_POST['sub_member']['tel_country_code'];
                  $tel_code = $_POST['sub_member']['tel_code'];

                  $tel_code_update = '';
                  $data_tel_code = $tel_code;
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $tel_code_update = $data_tel_code;
                    else
                      $tel_code_update = "+".$data_tel_code; 
                  }

                  $data_update_type2 = [
                    'corporate_name' =>  $corporate_name,
                    'country' => $country,
                    'address' => $address,
                    'member_title' => $member_title,
                    'member_nameEn' => $member_nameEn,
                    'member_midnameEn' => $member_midnameEn,
                    'member_lastnameEn' => $member_lastnameEn,
                    'email' => $email,
                    'tel' => $tel,
                    'tel_country' => strtoupper($tel_country),
                    'tel_code' => $tel_code_update
                  ];
                  $stmt_ck = $this->db->prepare("SELECT * FROM tb_member_type1 WHERE member_id = ?");
                  $stmt_ck->bind_param("s", $member_id);
                  $stmt_ck->execute();
                  $result_ck = $stmt_ck->get_result();
                  $ck = $result_ck->fetch_assoc();
                  $status_type2 = $this->update('tb_member_type2', $data_update_type2, ' member_id="' . $member_id . '"');
                  $edit = [
                    "member_id" => $member_id,
                    "text_old" => json_encode($ck),
                    "text_edit" => json_encode($data_update_type2),
                    "system" => $client_id
                  ];
                  if($status_type2){
                    if($ck['email'] != $email){
                      $save = [
                        "status_email_verify" => 0,
                        "email_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
                    
                    //$return = ['res_code' => '00', 'res_text' => 'success !'];
                    $return = $this->get_info($client_id, $code);
                  }else{
                    $return = ['res_code' => '01', 'res_text' => 'update fail'];
                  }

                  //------- update touch ------//
                  $data_update_touch = [
                    'company_name' => $corporate_name,
                    'company_address' => $address,
                  ];
                  $type_touch = 'corporateEn';
                  $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
                  //---------------------------//

                  break;

                case '3': # บุคคลไทย
                  $member_title = $_POST['member']['titleTh'];
                  $member_nameTh = $_POST['member']['nameTh'];
                  $member_midnameTh = $_POST['member']['member_midnameTh'];
                  $member_lastnameTh = $_POST['member']['lastnameTh'];
                  $member_nameEn = $_POST['member']['nameEn'];
                  $member_midnameEn = $_POST['member']['member_midnameEn'];
                  $member_lastnameEn = $_POST['member']['lastnameEn'];
                  $email = $_POST['member']['email'];
                  $member_birthday = $_POST['member']['member_birthday'];
                  $tel = $_POST['member']['tel'];
                  $tel_country = $_POST['member']['tel_country_code'];
                  $tel_code = $_POST['member']['tel_code'];

                  $addressTh = $_POST['addressTh']['address'];
                  $provinceTh = $_POST['addressTh']['province'];
                  $districtTh = $_POST['addressTh']['district'];
                  $subdistrictTh = $_POST['addressTh']['subdistrict'];
                  $postcode = $_POST['addressTh']['postcode'];

                  $addressEn = $_POST['addressEn']['address'];
                  $provinceEn = $_POST['addressEn']['province'];
                  $districtEn = $_POST['addressEn']['district'];
                  $subdistrictEn = $_POST['addressEn']['subdistrict'];

                  $tel_code_update = '';
                  $data_tel_code = $tel_code;
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $tel_code_update = $data_tel_code;
                    else
                      $tel_code_update = "+".$data_tel_code; 
                  }

                  if (empty($member_nameTh)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  if (empty($member_lastnameTh)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  if (empty($email)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  if (empty($tel)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }

                  if (empty($addressTh)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }

                  $data_update_type3 = [
                    'member_title' => $member_title,
                    'member_nameTh' => $member_nameTh,
                    'member_midnameTh' => $member_midnameTh,
                    'member_lastnameTh' => $member_lastnameTh,
                    'member_nameEn' => $member_nameEn,
                    'member_midnameEn' => $member_midnameEn,
                    'member_lastnameEn' => $member_lastnameEn,
                    // 'member_birthday' => $member_birthday,
                    'email' => $email,
                    'tel' => $tel,
                    'tel_country' => strtoupper($tel_country),
                    //'tel_code' => $tel_code,
                    'tel_code' => $tel_code_update,
                    'addressTh' => $addressTh,
                    'provinceTh' => $provinceTh,
                    'districtTh' => $districtTh,
                    'subdistrictTh' => $subdistrictTh,
                    'postcode' => $postcode,
                    'addressEn' => $addressEn,
                    'provinceEn' => $provinceEn,
                    'districtEn' => $districtEn,
                    'subdistrictEn' => $subdistrictEn
                  ];
                  $stmt_ck = $this->db->prepare("SELECT * FROM tb_member_type1 WHERE member_id = ?");
                  $stmt_ck->bind_param("s", $member_id);
                  $stmt_ck->execute();
                  $result_ck = $stmt_ck->get_result();
                  $ck = $result_ck->fetch_assoc();
                  $status_type3 = $this->update('tb_member_type3', $data_update_type3, ' member_id="' . $member_id . '"');
                  $edit = [
                    "member_id" => $member_id,
                    "text_old" => json_encode($ck),
                    "text_edit" => json_encode($data_update_type3),
                    "system" => $client_id
                  ];
                  if($status_type3){
                    if($ck['tel'] != $tel){
                      $save = [
                        "status_sms_verify" => 0,
                        "sms_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    if($ck['email'] != $email){
                      $save = [
                        "status_email_verify" => 0,
                        "email_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
                    $return = $this->get_info($client_id, $code);
                  }else{
                    $return = ['res_code' => '01', 'res_text' => 'update fail'];
                  }

                  //------- update touch ------//
                  $data_update_touch = [
                    'firstname' => $member_nameTh,
                    'lastname' => $member_lastnameTh,
                    'mobile' => $tel,
                  ];
                  $type_touch = 'person';
                  $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
                  //---------------------------//
                  break;

                case '4': # บุคคลต่างชาติ
                  $member_title = $_POST['member']['titleEn'];
                  //$member_nameTh = $_POST['member']['nameTh'];
                  //$member_lastnameTh = $_POST['member']['lastnameTh'];
                  $member_nameEn = $_POST['member']['nameEn'];
                  $member_midnameEn = $_POST['member']['member_midnameEn'];
                  $member_lastnameEn = $_POST['member']['lastnameEn'];
                  $email = $_POST['member']['email'];
                  $tel = $_POST['member']['tel'];
                  $tel_country = $_POST['member']['tel_country_code'];
                  $tel_code = $_POST['member']['tel_code'];
                  
                  $country = $_POST['address']['country'];
                  $address = $_POST['address']['address'];
                  
                  $tel_code_update = '';
                  $data_tel_code = $tel_code;
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $tel_code_update = $data_tel_code;
                    else
                      $tel_code_update = "+".$data_tel_code; 
                  }

                  $data_update_type4 = [
                    'member_title' => $member_title,
                    //'member_nameTh' => $member_nameTh,
                    //'member_lastnameTh' => $member_lastnameTh,
                    'member_nameEn' => $member_nameEn,
                    'member_nameEn' => $member_midnameEn,
                    'member_lastnameEn' => $member_lastnameEn,
                    'country' => $country,
                    'address' => $address,
                    'email' => $email,
                    'tel' => $tel,
                    'tel_country' => strtoupper($tel_country),
                    //'tel_code' => $tel_code
                    'tel_code' => $tel_code_update
                  ];
                  $stmt_ck = $this->db->prepare("SELECT * FROM tb_member_type1 WHERE member_id = ?");
                  $stmt_ck->bind_param("s", $member_id);
                  $stmt_ck->execute();
                  $result_ck = $stmt_ck->get_result();
                  $ck = $result_ck->fetch_assoc();
                  $status_type4 = $this->update('tb_member_type4', $data_update_type4, ' member_id="' . $member_id . '"');
                  $edit = [
                    "member_id" => $member_id,
                    "text_old" => json_encode($ck),
                    "text_edit" => json_encode($data_update_type4),
                    "system" => $client_id
                  ];
                  if($status_type4){
                    if($ck['email'] != $email){
                      $save = [
                        "status_email_verify" => 0,
                        "email_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    //$return = ['res_code' => '00', 'res_text' => 'success !'];
                    $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
                    $return = $this->get_info($client_id, $code);
                  }else{
                    $return = ['res_code' => '01', 'res_text' => 'update fail'];
                  }

                  //------- update touch ------//
                  $data_update_touch = [
                    'firstname' => $member_nameEn,
                    'lastname' => $member_lastnameEn,
                    'mobile' => $tel,
                  ];
                  $type_touch = 'person';
                  $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
                  //---------------------------//

                  break;

                case '5': # อื่นๆ
                  $member_title = $_POST['member']['titleTh'];
                  $member_nameTh = $_POST['member']['nameTh'];
                  $member_lastnameTh = $_POST['member']['lastnameTh'];
                  $member_nameEn = $_POST['member']['nameEn'];
                  $member_lastnameEn = $_POST['member']['lastnameEn'];
                  $email = $_POST['member']['email'];
                  $tel = $_POST['member']['tel'];
                  $tel_country = $_POST['member']['tel_country_code'];
                  $tel_code = $_POST['member']['tel_code'];

                  $addressTh = $_POST['address']['address'];
                  $provinceTh = $_POST['address']['province'];
                  $districtTh = $_POST['address']['district'];
                  $subdistrictTh = $_POST['address']['subdistrict'];
                  $postcodeTh = $_POST['address']['postcode'];
                  
                  $tel_code_update = '';
                  $data_tel_code = $tel_code;
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $tel_code_update = $data_tel_code;
                    else
                      $tel_code_update = "+".$data_tel_code; 
                  }

                  $data_update_type5 = [
                    'member_title' => $member_title,
                    'member_nameTh' => $member_nameTh,
                    'member_lastnameTh' => $member_lastnameTh,
                    'member_nameEn' => $member_nameEn,
                    'member_lastnameEn' => $member_lastnameEn,
                    'addressTh' => $addressTh,
                    'provinceTh' => $provinceTh,
                    'districtTh' => $districtTh,
                    'subdistrictTh' => $subdistrictTh,
                    'postcode' => $postcodeTh,

                    'email' => $email,
                    'tel' => $tel,
                    'tel_country' => strtoupper($tel_country),
                    //'tel_code' => $tel_code
                    'tel_code' => $tel_code_update
                  ];

                  $status_type5 = $this->update('tb_member_type5', $data_update_type5, ' member_id="' . $member_id . '"');
                  if($status_type5){
                    //$return = ['res_code' => '00', 'res_text' => 'success !'];
                    $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
                    $return = $this->get_info($client_id, $code);
                  }else{
                    $return = ['res_code' => '01', 'res_text' => 'update fail'];
                  }

                  //------- update touch ------//
                  $data_update_touch = [
                    'firstname' => $member_nameTh,
                    'lastname' => $member_lastnameTh,
                    'mobile' => $tel,
                  ];
                  $type_touch = 'person';
                  $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
                  //---------------------------//

                  break;

                case '6': # นิติบุคคลไทยที่ไม่ลงทะเบียนการค้า
                  $company_nameTh = $_POST['company']['nameTh'];
                  $company_nameEn = $_POST['company']['nameEn'];

                  $company_addressTh = $_POST['addressTh']['address'];
                  $company_provinceTh = $_POST['addressTh']['province'];
                  $company_districtTh = $_POST['addressTh']['district'];
                  $company_subdistrictTh = $_POST['addressTh']['subdistrict'];
                  $company_postcodeTh = $_POST['addressTh']['postcode'];

                  $company_addressEn = $_POST['addressEn']['address'];
                  $company_provinceEn = $_POST['addressEn']['province'];
                  $company_districtEn = $_POST['addressEn']['district'];
                  $company_subdistrictEn = $_POST['addressEn']['subdistrict'];
                  $company_postcodeEn = $_POST['addressEn']['postcode'];

                  $contact_address = $_POST['contact']['address'];
                  $contact_province = $_POST['contact']['province'];
                  $contact_district = $_POST['contact']['district'];
                  $contact_subdistrict = $_POST['contact']['subdistrict'];
                  $contact_postcode = $_POST['contact']['postcode'];

                  $member_titleTh = $_POST['sub_member']['titleTh'];
                  //$member_titleEn = $_POST['sub_member']['titleEn'];
                  $member_nameTh = $_POST['sub_member']['nameTh'];
                  $member_midnameTh = $_POST['sub_member']['member_midnameTh'];
                  $member_lastnameTh = $_POST['sub_member']['lastnameTh'];
                  $member_nameEn = $_POST['sub_member']['nameEn'];
                  $member_midnameEn = $_POST['sub_member']['member_midnameEn'];
                  $member_lastnameEn = $_POST['sub_member']['lastnameEn'];
                  $member_cid = $_POST['sub_member']['cid'];
                  $member_email = $_POST['sub_member']['email'];
                  $member_tel = $_POST['sub_member']['tel'];
                  $member_tel_code = $_POST['sub_member']['tel_code'];
                  $member_tel_country_code = $_POST['sub_member']['tel_country_code'];

                  $tel_code_update = '';
                  $data_tel_code = $member_tel_code;
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $tel_code_update = $data_tel_code;
                    else
                      $tel_code_update = "+".$data_tel_code; 
                  }

                  if (empty($member_nameTh)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  if (empty($member_lastnameTh)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  if (empty($member_email)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }
                  if (empty($member_tel)) {
                    $return = ['res_code' => '01', 'res_text' => 'update fail']; 
                    break; 
                  }

                  $data_update_type6 = [
                    // 'company_nameTh' => $company_nameTh,
                    // 'company_nameEn' => $company_nameEn,
                    // 'company_addressTh' => $company_addressTh,
                    // 'company_provinceTh' => $company_provinceTh,
                    // 'company_districtTh' => $company_districtTh,
                    // 'company_subdistrictTh' => $company_subdistrictTh,
                    // 'company_postcodeTh' => $company_postcodeTh,
                    // 'company_addressEn' => $company_addressEn,
                    // 'company_provinceEn' => $company_provinceEn,
                    // 'company_districtEn' => $company_districtEn,
                    // 'company_subdistrictEn' => $company_subdistrictEn,
                    // 'company_postcodeEn' => $company_postcodeEn,
                    'contact_address' => $contact_address,
                    'contact_province' => $contact_province,
                    'contact_district' => $contact_district,
                    'contact_subdistrict' => $contact_subdistrict,
                    'contact_postcode' => $contact_postcode,
                    'member_title' => $member_titleTh,
                    'member_cid' => $member_cid,
                    'member_nameTh' => $member_nameTh,
                    'member_midnameTh' => $member_midnameTh,
                    'member_lastnameTh' => $member_lastnameTh,
                    'member_nameEn' => $member_nameEn,
                    'member_midnameEn' => $member_midnameEn,
                    'member_lastnameEn' => $member_lastnameEn,
                    // 'member_birthday' => $member_birthday,
                    'member_email' => $member_email,
                    'member_tel' => $member_tel,
                    'member_tel_country' => strtoupper($member_tel_country_code),
                    //'member_tel_code' => $member_tel_code
                    'member_tel_code' => $tel_code_update
                  ];
                  $stmt_ck = $this->db->prepare("SELECT * FROM tb_member_type1 WHERE member_id = ?");
                  $stmt_ck->bind_param("s", $member_id);
                  $stmt_ck->execute();
                  $result_ck = $stmt_ck->get_result();
                  $ck = $result_ck->fetch_assoc();
                  $status_type6 = $this->update('tb_member_type6', $data_update_type6, ' member_id="' . $member_id . '"');
                  $edit = [
                    "member_id" => $member_id,
                    "text_old" => json_encode($ck),
                    "text_edit" => json_encode($data_update_type6),
                    "system" => $client_id
                  ];
                  if($status_type6){
                    if(($ck['member_cid'] != $member_cid) || ($ck['member_nameTh'] != $member_nameTh) || ($ck['member_midnameTh'] != $member_midnameTh) || ($ck['member_lastnameTh'] != $member_lastnameTh)){
                      $save = [
                        "status_laser_verify" => 0,
                        "laser_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    if($ck['member_tel'] != $member_tel){
                      $save = [
                        "status_sms_verify" => 0,
                        "sms_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    if($ck['member_email'] != $member_email){
                      $save = [
                        "status_email_verify" => 0,
                        "email_verify_at" => date("Y-m-d H:m:s")
                      ];
                      $this->update('tb_member',$save, ' member_id="' . $member_id . '"');
                    }
                    $this->update('tb_member',['system_update'=>$system_update,'update_date'=>date('Y-m-d H:i:s')], ' member_id="' . $member_id . '"');
                    $return = $this->get_info($client_id, $code);
                  }else{
                    $return = ['res_code' => '01', 'res_text' => 'update fail'];
                  }

                  //------- update touch ------//
                  $data_update_touch = [
                    'company_name' => $company_nameTh,
                    'company_address' => $company_addressTh,
                    'company_postcode' => $company_postcodeTh,
                  ];
                  $type_touch = 'corporateTh';
                  $result_update_touch = $this->update_member_touch($member_id, $type_touch, $data_update_touch);
                  //---------------------------//

                  break; 

              }
            }
          }
          
        }
      }
    }
    $this->insert('log_edit_member', $edit);
    return $return;
  }

  function model_user_update($client_id = '', $username = '', $password = ''){
    $client_id = mysqli_real_escape_string($this->db, $client_id);
    $username = mysqli_real_escape_string($this->db, $username);
    $password = mysqli_real_escape_string($this->db, $password);

    $ck_client_id = $this->check_client_id($client_id);
    $ck_cid = $this->check_cid($username);

    if(!$ck_client_id){
      $return = [
        'res_code' => '01',
        'res_text' => 'client_id not found !'
      ];
      return $return;
    }
    if($ck_cid){
      $return = [
        'res_code' => '01',
        'res_text' => 'This Username is already in SSO'
      ];
      return $return;
    }

    $drive_info = $this->get_info_drive($username);
    $result_drive = json_decode($drive_info,1);

    if($result_drive != '' && $result_drive['code'] == 200 && $result_drive['message'] == 'OK'){

      if($result_drive['IsThai'] == 'Y' && $result_drive['UserType'] == "company") $type = '1';
      else if($result_drive['IsThai'] == 'N' && $result_drive['UserType'] == "company") $type = '2';
      else if($result_drive['IsThai'] == 'Y' && $result_drive['UserType'] == "individual") $type = '3';
      else if($result_drive['IsThai'] == 'N' && $result_drive['UserType'] == "individual") $type = '4';

      //--------------------- insert master tb_member --------------------------//
      $data_insert_member = [
        'member_app' => '',
        'member_app_id' => '',
        'cid' => $username,
        'password' => sha1($password),
        'type' => $type,
        'status' => '1'
      ];

      $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
      $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
      $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
      $ck_mem = $this->insert('tb_member', $data_insert_member);
      //--------------------- end of insert master tb_member ------------------------//


      //------------------------ insert tb_member_type ----------------------------------//
      if(!empty($ck_mem)){
        $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
        $result_max = $this->query($sql_max);
        $member_id = $result_max[0]['member_id'];

          if($type == '1' && $result_drive['UserType'] == "company"){
            $data_insert_type1 = [
              'member_id' => $member_id,
              'company_nameTh' => $result_drive['CorporateNameTH'],
              'company_nameEn' => $result_drive['CorporateNameEN'],

              'company_addressTh' => $result_drive['User_Address']['AddressTH'],
              'company_provinceTh' => $result_drive['User_Address']['Province']['name'],
              'company_districtTh' => $result_drive['User_Address']['District']['name'],
              'company_subdistrictTh' => $result_drive['User_Address']['SubDistrict']['name'],
              'company_postcodeTh' => $result_drive['User_Address']['PostCode'],

              'company_addressEn' => $result_drive['User_Address']['AddressEN'],
              'company_provinceEn' => $result_drive['User_Address']['Province']['nameEN'],
              'company_districtEn' => $result_drive['User_Address']['District']['nameEN'],
              'company_subdistrictEn' => $result_drive['User_Address']['SubDistrict']['nameEN'],
              'company_postcodeEn' => $result_drive['User_Address']['PostCode'],

              'contact_address' => $result_drive['User_Address']['AddressTH'],
              'contact_province' => $result_drive['User_Address']['Province']['name'],
              'contact_district' => $result_drive['User_Address']['District']['name'],
              'contact_subdistrict' => $result_drive['User_Address']['SubDistrict']['name'],
              'contact_postcode' => $result_drive['User_Address']['PostCode'],

              'member_title' => $result_drive['User_Contact']['Title']['name'],
              //'member_cid' => $result_drive[''],
              'member_nameTh' => $result_drive['User_Contact']['FirstNameTH'],
              'member_lastnameTh' => $result_drive['User_Contact']['LastNameTH'],
              'member_nameEn' => $result_drive['User_Contact']['FirstNameEN'],
              'member_lastnameEn' => $result_drive['User_Contact']['LastNameEN'],
              'member_email' => $result_drive['Mail'],
              'member_tel' => $result_drive['User_Contact']['Contact_Tel'],
              'member_tel_country' => "TH",
                      'member_tel_code' => "+66"
            ];
            try{
              $insert_type1 = $this->insert('tb_member_type1', $data_insert_type1);
              //$this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$member_id");
            } catch (Exception $e){

            }
            

          }else if($type == '2' && $result_drive['UserType'] == "company"){
            $data_insert_type2 = [
              'member_id' => $member_id,
              'corporate_name' =>  $result_drive['CorporateNameEN'],
              'country' => $result_drive['User_Address']['Country']['nameEN'],
              'address' => $result_drive['User_Address']['AddressEN'],
              //'member_title' => $result_drive,
              //'member_nameTh' => $result_drive,
              //'member_lastnameTh' => $result_drive,
              //'member_nameEn' => $result_drive,
              //'member_lastnameEn' => $result_drive,
              'email' => $result_drive['Mail'],
              'tel' => $result_drive['Tel'],
              //'tel_country' => "TH",
              //'tel_code' => "+66"
            ];
            try{
              $insert_type2 = $this->insert('tb_member_type2', $data_insert_type2);
              //$this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
            } catch (Exception $e){

            }
            

          }else if($type == '3' && $result_drive['UserType'] == "individual"){
            # บุคคล ไทย
            $data_insert_type3 = [
              'member_id' => $member_id,
              'member_title' => $result_drive['Title']['name'],
              'member_nameTh' => $result_drive['FirstNameTH'],
              'member_lastnameTh' => $result_drive['LastNameTH'],
              'member_nameEn' => $result_drive['FirstNameEN'],
              'member_lastnameEn' => $result_drive['LastNameEN'],
              'email' => $result_drive['Mail'],
              'tel' => $result_drive['Tel'],
              'tel_country' => "TH",
              'tel_code' => "+66",
              'addressTh' => $result_drive['User_Address']['AddressTH'],
              'provinceTh' => $result_drive['User_Address']['Province']['name'],
              'districtTh' => $result_drive['User_Address']['District']['name'],
              'subdistrictTh' => $result_drive['User_Address']['SubDistrict']['name'],
              'postcode' => $result_drive['User_Address']['PostCode'],

              'addressEn' => $result_drive['User_Address']['AddressEN'],
              'provinceEn' => $result_drive['User_Address']['Province']['nameEN'],
              'districtEn' => $result_drive['User_Address']['District']['nameEN'],
              'subdistrictEn' => $result_drive['User_Address']['SubDistrict']['nameEN']
            ];
            try{
              $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);
              //$this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
            } catch (Exception $e){

            }
            

          }else if($type == '4' && $result_drive['UserType'] == "individual"){
            # บุคคล ต่างชาติ
            $data_insert_type4 = [
              'member_id' => $member_id,
              'member_title' => $result_drive['Title']['nameEN'],
              'member_nameTh' => $result_drive['FirstNameTH'],
              'member_lastnameTh' => $result_drive['LastNameTH'],
              'member_nameEn' => $result_drive['FirstNameEN'],
              'member_lastnameEn' => $result_drive['LastNameEN'],
              'country' => $result_drive['User_Address']['Country']['nameEN'],
              'address' => $result_drive['User_Address']['AddressEN'],
              'email' => $result_drive['Mail'],
              'tel' => $result_drive['Tel'],
              //'tel_country' => strtoupper($tel_country),
              //'tel_code' => "+".$tel_code
            ];
            try{
              $insert_type4 = $this->insert('tb_member_type4', $data_insert_type4);
              //$this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
            } catch (Exception $e){

            }
            
          }
          $return = [
            'res_code' => '00',
            'res_text' => 'Success !'
          ];
        }else{
          $return = [
            'res_code' => '01',
            'res_text' => 'ดำเนินการไม่สำเร็จ'
          ];
        }
    }else{
      $return = [
        'res_code' => '01',
        'res_text' => 'Not found data from Drive'
      ];
    }

    return $return;
    
  }

  function model_getinfo_company(){
    $_POST = json_decode(file_get_contents("php://input"), 1);

    $jurisdiction_id = mysqli_real_escape_string($this->db, $_POST['jurisdiction_id']);
    $token = mysqli_real_escape_string($this->db, $_POST['token']);

    if($jurisdiction_id =='') $error['jurisdiction_id'] = 'required field';
    if($token =='') $error['token'] = 'required field';
    if(isset($error) && count($error)){
      $return = [
        'res_code' => '01',
        'res_text' => $error
      ];
      return $return;
    }
    $ck_token = $this->query("SELECT * FROM tb_token_dbd WHERE token_dbd_code = '".$token."' AND status ='1'");
    if(count($ck_token) < 1){
      $return = [
        'res_code' => '01',
        'res_text' => 'token not found !'
      ];
      return $return;
    }

    $keyFile = "/home/care/www_dev/dbd/ditp.key";
    $caFile = "/home/care/www_dev/dbd/ditp.ca";
    $certFile = "/home/care/www_dev/dbd/ditp.crt";

    $xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.wsdata.dbd.gov/">
                  <soapenv:Header/>
                  <soapenv:Body>
                    <ser:getData>
                        <!--Optional:-->
                        <subscriberId>6211005</subscriberId>
                        <!--Optional:-->
                        <subscriberPwd>$PSk3754</subscriberPwd>
                        <!--Optional:-->
                        <serviceId>0001</serviceId>
                        <!--Zero or more repetitions:-->
                        <params>
                          <!--Optional:-->
                          <name>JURISDICTION_ID</name>
                          <!--Optional:-->
                          <value>'.$jurisdiction_id.'</value>
                        </params>
                    </ser:getData>
                  </soapenv:Body>
                  </soapenv:Envelope>';


    $contentlength = strlen($xml_data);
    $URL = "https://ssodev.ditp.go.th/dbdws/";

    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);
    curl_setopt($ch, CURLOPT_CAINFO, $caFile);
    curl_setopt($ch, CURLOPT_CAPATH, '');
    curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: text/xml'
      )
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
   
    $return = [];
    if ($output === false) {
      $content = curl_exec($ch);
      $err     = curl_errno($ch);
      $errmsg  = curl_error($ch);
      $header  = curl_getinfo($ch);
      curl_close($ch);

      $header['errno']   = $err;
      $header['errmsg']  = $errmsg;
      $header['content'] = $content;

      $return = [
        'res_code' => '01',
        'res_text' => 'temporarily unavailable please try again later'
      ];

    } else {
      curl_close($ch);
      $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
      $xml = new SimpleXMLElement($response);
      $body = $xml->xpath('//SBody')[0];
      $array = json_decode(json_encode((array) $body), TRUE);
      if (!empty($array['ns0getDataResponse']['return'])) {
        $data = $array['ns0getDataResponse']['return']['arrayRRow']['childTables'];
        $com = $array['ns0getDataResponse']['return']['arrayRRow']['columns'];
        $da = [];
        if (!empty($data) && count($data)) {
          $err = [];
          foreach ($data as $k => $v) {
            if (!empty($v['rows'][0])) {
              foreach ($v['rows'] as $key => $val) {
                if ($val['columns']) {
                  foreach ($val['columns'] as $kk => $vv) {
                    $da[$v['adServiceName']][$key][$vv['columnName']] = (empty($vv['columnValue'])) ? "" : $vv['columnValue'];
                  }
                }
              }
            } else if (!empty($v['rows']['columns'])) {

              $val = $v['rows']['columns'];

              if ($this->isAssoc($val)) {
                $err[] = $val;
                $da[$v['adServiceName']][$val['columnName']] = (empty($val['columnValue'])) ? "" : $val['columnValue'];
              } else {
                $err[] = $val;
                foreach ($val as $kk => $vv) {
                  $da[$v['adServiceName']][$vv['columnName']] = (empty($vv['columnValue'])) ? "" : $vv['columnValue'];
                }
              }
            }
          }
        }
         
        if (!empty($com) && count($com)) {

          foreach ($com as $k => $v) {
            $da['etc'][$v['columnName']] = (empty($v['columnValue'])) ? "" : $v['columnValue'];
          }
        }

        // $data = [
        //   'company_name' => (empty($da['etc']['JURISTICNAME'])) ? '' : trim($da['etc']['JURISTICNAME']),
        //   'company_address' => (empty($da['AddressDetail']['FULLADDRESS'])) ? '' : trim($da['AddressDetail']['FULLADDRESS']),
        //   'company_province' => (empty($da['AddressDetail']['JURISTICPROVINCE'])) ? '' : trim($da['AddressDetail']['JURISTICPROVINCE']),
        //   'company_district' => (empty($da['AddressDetail']['JURISTICAMPUR'])) ? '' : trim($da['AddressDetail']['JURISTICAMPUR']),
        //   'company_subdistrict' => (empty($da['AddressDetail']['JURISTICTUMBOL'])) ? '' : trim($da['AddressDetail']['JURISTICTUMBOL'])
        // ];
        
        $return = [
          'res_code' => '00',
          'res_text' => 'success !',
          'res_result' => $da
        ];


      }else{
        $return = [
          'res_code' => '01',
          'res_text' => 'data not found !'
        ];
      }

      
    }

    // print_r($return);
    return $return;
    exit;
  }
  function update_member($client_id = '', $code = '',$msg = '')
  {
    #save log
    // $param = [
    //   'code' => $code,
    //   'client_id' => $client_id,
    // ];
    // $this->save_log_call_api(json_encode($param), $client_id);

    $return = ['res_code' => '01', 'res_text' => 'Data Not Found.'];
    $dat = json_decode($msg);
    $sql_m = 'SELECT * FROM `tb_member` WHERE `tb_member`.`sso_id` = '.$dat->ssoid.' LIMIT 1';
    $query = $this->query($sql_m);


    if(empty($dat->member_title)){
      $alert['member_title'] = 'กรุณากรอกข้อมูล';
      return $alert;
    }
    if(empty($dat->member_nameTh)) {
      $alert['member_nameTh'] = 'กรุณากรอกข้อมูล';
      return $alert;
    }
    if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $dat->member_nameTh)) {
      $alert['member_nameTh'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
      return $alert;
    }
    if(empty($dat->member_lastnameTh)) {
      $alert['member_lastnameTh'] = 'กรุณากรอกข้อมูล';
      return $alert;
    }
    if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $dat->member_lastnameTh)) {
      $alert['member_lastnameTh'] = "กรุณากรอกนามสกุลเป็นตัวอักษร ก - ฮ เท่านั้น";
      return $alert;
    }
    if(empty($dat->member_nameEn)) {
      $alert['member_nameEn'] = 'กรุณากรอกข้อมูล';
      return $alert;
    }
    if(!preg_match("/^[a-zA-Z]+$/", $dat->member_nameEn)) {
      $alert['member_nameEn'] = "กรุณากรอกชื่อเป็นตัวอักษร a - z เท่านั้น";
    }
    if(empty($dat->member_nameEn)) {
      $alert['member_nameEn'] = 'กรุณากรอกข้อมูล';
      return $alert;
    }
    if(!preg_match("/^[a-zA-Z]+$/", $dat->member_nameEn)) {
      $alert['member_nameEn'] = "กรุณากรอกนามสกุลเป็นตัวอักษร a - z เท่านั้น";
      return $alert;
    }
    if(empty($dat->member_email)) {
      $alert['member_email'] = 'กรุณากรอกข้อมูล';
      return $alert;
    }
    if(!filter_var($dat->member_email, FILTER_VALIDATE_EMAIL)) {
      $alert['member_email'] = 'รูปแบบไม่ถูกต้อง';
      return $alert;
    }

    if(count($query) > 0){
      foreach($query as $item){
        if($item['type'] == '1'){
          $data_update_type1 = [
            'contact_address' => $dat->contact_address,
            'contact_province' => $dat->contact_province,
            'contact_district' => $dat->contact_district,
            'contact_subdistrict' => $dat->contact_subdistrict,
            'contact_postcode' => $dat->contact_postcode,

            'member_title' => $dat->member_title,
            'member_nameTh' => $dat->member_nameTh,
            'member_lastnameTh' => $dat->member_lastnameTh,
            'member_nameEn' => $dat->member_nameEn,
            'member_lastnameEn' => $dat->member_lastnameEn,
            'member_email' => $dat->member_email,
            'member_tel' => $dat->member_tel,
          ];
          return $data_update_type1;
          try{
            $this->update('tb_member_type1', $data_update_type1, "member_id ='$item[member_id]'");
            $alert = 'success';
          } catch (Exception $e){

          }
          

        }else if($item['type'] == '2'){
          $data_update_type2 = [
            'country' => $dat->country,
            'address' => $dat->contact_address,
            'email' => $dat->member_email,
            'tel' => $dat->member_tel,

            'member_title' => $dat->member_title,
            'member_nameTh' => $dat->member_nameTh,
            'member_lastnameTh' => $dat->member_lastnameTh,
            'member_nameEn' => $dat->member_nameEn,
            'member_lastnameEn' => $dat->member_lastnameEn,
          ];
          return $data_update_type2;
          try{
            $this->update('tb_member_type2', $data_update_type2, "member_id ='$item[member_id]'");
            $alert = 'success';
          } catch (Exception $e){

          }
          

        }else if($item['type'] == '3'){
          # บุคคล ไทย
        
          $data_update_type3 = [
            'member_title' => $dat->member_title,
            'member_nameTh' => $dat->member_nameTh,
            'member_lastnameTh' => $dat->member_lastnameTh,
            'member_nameEn' => $dat->member_nameEn,
            'member_lastnameEn' => $dat->member_lastnameEn,
            'email' => $dat->member_email,
            'tel' => $dat->member_tel,
            'addressTh' => $dat->contact_addressTh,
            'provinceTh' => $dat->contact_provinceTh,
            'districtTh' => $dat->contact_districtTh,
            'subdistrictTh' => $dat->contact_subdistrictTh,
            'postcode' => $dat->contact_postcode,
            'addressEn' => $dat->contact_addressEn,
            'provinceEn' => $dat->contact_provinceTh,
            'districtEn' => $dat->contact_districtEn,
            'subdistrictEn' => $dat->contact_subdistrictEn,
          ];
          try{
            $this->update('tb_member_type3', $data_update_type3, "member_id ='$item[member_id]'");
            $alert = 'success';
          } catch (Exception $e){

          }
          

        }else if($item['type'] == '4'){
          # บุคคล ต่างชาติ
          $data_update_type4 = [
            'member_title' => $result_drive['Title']['nameEN'],
            'member_nameTh' => $result_drive['FirstNameTH'],
            'member_lastnameTh' => $result_drive['LastNameTH'],
            'member_nameEn' => $result_drive['FirstNameEN'],
            'member_lastnameEn' => $result_drive['LastNameEN'],
            'country' => $result_drive['User_Address']['Country']['nameEN'],
            'address' => $result_drive['User_Address']['AddressEN'],
            'email' => $result_drive['Mail'],
            'tel' => $result_drive['Tel'],
            //'tel_country' => strtoupper($tel_country),
            //'tel_code' => "+".$tel_code
          ];
          return $data_update_type4;
          try{
            $this->update('tb_member_type4', $data_update_type4, "member_id ='$item[member_id]'");
            $alert = 'success';
          } catch (Exception $e){

          }
          
        }
       }
      }
      return $alert;
    }
    function mysql_escape($inp)
      { 
          if(is_array($inp)) return array_map(__METHOD__, $inp);

          if(!empty($inp) && is_string($inp)) { 
              return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a",",",'()'), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
          } 

          return $inp; 
      }
    function cronjob_member()
    {
        $mysqli = new mysqli("10.8.99.131","oneuat","Ibusiness19#","oneuat");
        // Check connection
        if ($mysqli->connect_errno) {
          return "Failed to connect to MySQL: " . $mysqli->connect_error;
          exit();
        }
        $TRUNCATE = "TRUNCATE ditpstaff_member_main";
        if ($this->query($TRUNCATE) === FALSE ) {
        echo "Failed to connect to MySQL: " . $this->error;
        } 
        $sql = 'select * from ditpstaff_member_main';
        $query = $mysqli->query($sql);
        foreach ($query as $key => $value) {
          $DITP_ONE = "INSERT INTO `ditpstaff_member_main`(`User_ID`, `DBD_Register_No`, `DBD_Register_Date`, `Corporate_Type`, `Corporate_Type_TH`, 
                      `Corporate_Type_EN`, `IsDBD_Register`, `IsDBD_Register_Name`, `Corporate_Name_TH`, `Corporate_Name_EN`, `Is_Thai`, `Is_Thai_Name`, 
                      `Property_ID`, `Property_Name`, `Member_Status_ID`, `Member_Status_Name`, `DITPMemberNo`, `DITPMemberDate`, `Mobile_No_SMS`, `Modify_Date`) 
                      VALUES ('".($value['User_ID'])."','".$value['DBD_Register_No']."','".$value['DBD_Register_Date']."','".$value['Corporate_Type']."','".$this->mysql_escape($value['Corporate_Type_TH'])."',
                      '".$this->mysql_escape($value['Corporate_Type_EN'])."','".$value['IsDBD_Register']."','".$this->mysql_escape($value['IsDBD_Register_Name'])."','".$this->mysql_escape($value['Corporate_Name_TH'])."','".$this->mysql_escape($value['Corporate_Name_EN'])."',
                      '".$value['Is_Thai']."','".$this->mysql_escape($value['Is_Thai_Name'])."','".$value['Property_ID']."','".$this->mysql_escape($value['Property_Name'])."','".$value['Member_Status_ID']."','".$this->mysql_escape($value['Member_Status_Name'])."',
                      '".$value['DITPMemberNo']."','".$value['DITPMemberDate']."','".$value['Mobile_No_SMS']."','".$value['Modify_Date']."')";
          print_r($DITP_ONE);
          if ($this->query($DITP_ONE) === FALSE ) {
              echo "Failed to connect to MySQL: " . $mysqli->error;
              die();
          } 

        }
    }
    function insert_member_test($type_is = 0)
    {
      $type = $this->post('type');
     
      
      if($type == 1){ //นิติไทย
      
        //-- data tb_member --//
        $cid = $this->post('cid');
        $password = $this->post('password');
     
  
        //-- data tb_member_type1 ---//
        
        $company_nameTh = $this->post('company_name');
        $company_nameEn = $this->post('company_nameEn');
        $company_addressTh = $this->post('company_address');
        $company_provinceTh = $this->post('company_province');
        $company_districtTh = $this->post('company_district');
        $company_subdistrictTh = $this->post('company_subdistrict');
        $company_postcode = $this->post('company_postcode');
        $company_addressEn = $this->post('company_addressEn');
        $company_provinceEn = $this->post('company_provinceEn');
        $company_districtEn = $this->post('company_districtEn');
        $company_subdistrictEn = $this->post('company_subdistrictEn');
        $company_postcodeEn = $this->post('company_postcodeEn');
  
        $state = $this->post('state');
       
        $contact_address = $this->post('Hcontact_address');
        $contact_province = $this->post('Hcontact_province');
        $contact_district = $this->post('Hcontact_district');
        $contact_subdistrict = $this->post('Hcontact_subdistrict');
        $contact_postcode = $this->post('Hcontact_postcode');
  
        $member_title = $this->post('contact_title');
        $member_cid = $this->post('contact_cid');
        $member_nameTh = $this->post('contact_name');
        $member_lastnameTh = $this->post('contact_lastname');
        $member_nameEn = $this->post('contact_nameEn');
        $member_lastnameEn = $this->post('contact_lastnameEn');
        $member_email = $this->post('contact_email');
        $member_tel = $this->post('contact_tel');
  
        $member_tel_country = $this->post('contact_tel_country');
        $member_tel_code = $this->post('contact_tel_code');
  
        $sql_ckcid1 = 'SELECT 1 , sso_id FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
        $sql_ckcid2 = 'SELECT 1 FROM Member_v2 WHERE member_cid ="' . $cid . '"';
        $sql_ckcid3 = 'SELECT 1 FROM Member_drive_v3 WHERE Username ="' . $cid . '"';
  
        $ck_cid1 = $this->query($sql_ckcid1);
        $ck_cid2 = $this->query($sql_ckcid2);
        $ck_cid3 = $this->query($sql_ckcid3);
          
        if (!empty($ck_cid1) || !empty($ck_cid2) || !empty($ck_cid3) ) {
          //if (!empty($ck_cid1)) {
            $error['cid'] = 'You have account already SSO ID :'.$ck_cid1[0]['sso_id'];
          }
  
          if(empty($cid)) $error['cid'] = 'Please input cid';
  
          if(!preg_match("#[a-zA-Z]+#", $password)) {
            $error['password'] = "Must have a - z at least 1 letters";
          }
          if(strlen($password) < 8) {
            $error['password'] = "Please input password more than 8";
          }
  
          if(empty($password)) $error['password'] = 'Please input password';
          if(empty($company_nameTh)) $error['company_name'] = 'Not found';
          if(empty($company_nameEn)) $error['company_nameEn'] = 'Please input company_nameEn';
          
  
          if(empty($member_title)) $error['contact_title'] = 'Please input contact_title';
  
          if (!$this->isValidNationalId($member_cid)) {
            $error['contact_cid'] = 'Not correct';
          }
          if(empty($member_cid)) $error['contact_cid'] = 'Please input contact_cid';
        
          if(empty($member_nameTh)) $error['contact_name'] = 'Please input contact_name';
          if(empty($member_lastnameTh)) $error['contact_lastname'] = 'Please input contact_lastname';
          if(empty($member_nameEn)) $error['contact_nameEn'] = 'Please input contact_nameEn';
          if(empty($member_lastnameEn)) $error['contact_lastnameEn'] = 'Please input contact_lastnameEn';
  
        //   $ck_mail = $this->check_mail($member_email);
        // if($ck_mail == false){
        //   $error['contact_email'] = 'Have email already';
        // }
  
        if(!filter_var($member_email, FILTER_VALIDATE_EMAIL)) {
          $error['contact_email'] = 'Format email incorrect';
        }
  
        if(empty($member_email)) $error['contact_email'] = 'Please input contact_email';
        if(empty($member_tel)) $error['contact_tel'] = 'Please input contact_tel';
  
        if(empty($error)){
          if($state == 'new'){
          if(empty($contact_address)) $error['Hcontact_address'] = 'Please input Hcontact_address';
          if(empty($contact_province)) $error['Hcontact_province'] = 'Please input Hcontact_province';
          if(empty($contact_district)) $error['Hcontact_district'] = 'Please input Hcontact_district';
          if(empty($contact_subdistrict)) $error['Hcontact_subdistrict'] = 'Please input Hcontact_subdistrict';
          if(empty($contact_subdistrict)) $error['Hcontact_postcode'] = 'Please input Hcontact_postcode';
  
          
            $contact_province = $this->get_province($contact_province, 'th');
            $contact_district = $this->get_district($contact_district, 'th');
            $contact_subdistrict = $this->get_subdistrict($contact_subdistrict, 'th');
          }
        }
   
        if(!empty($company_provinceTh)) $company_provinceTh = $this->get_province($company_provinceTh, 'th');
        if(!empty($company_districtTh)) $company_districtTh = $this->get_district($company_districtTh, 'th');
        if(!empty($company_subdistrictTh)) $company_subdistrictTh = $this->get_subdistrict($company_subdistrictTh, 'th');

        if(!empty($company_provinceEn)) $company_provinceEn = $this->get_province($company_provinceEn, 'en');
        if(!empty($company_districtEn)) $company_districtEn = $this->get_district($company_districtEn, 'en');
        if(!empty($company_subdistrictEn)) $company_subdistrictEn = $this->get_subdistrict($company_subdistrictEn, 'en');

        
        if(empty($error)){
          $type_is = $type;
          if($type_is){
            $data_insert_member = [
              'member_app' => '',
              'member_app_id' => '',
              'cid' => $cid,
              'password' => sha1($password),
              'type' => $type,
              'status' => '1',
              'register_from' => '1'
            ];
           
            $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
            $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
            $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
  
            $ck_mem = $this->insert('tb_member', $data_insert_member);
  
            
      
            if(!empty($ck_mem)){
              $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
              $result_max = $this->query($sql_max);
              $member_id = $result_max[0]['member_id'];
      
              $data_insert_type1 = [
                'member_id' => $member_id,
                'company_nameTh' => $company_nameTh,
                'company_nameEn' => $company_nameEn,
                'company_addressTh' => $company_addressTh,
                'company_provinceTh' => $company_provinceTh,
                'company_districtTh' => $company_districtTh,
                'company_subdistrictTh' => $company_subdistrictTh,
                'company_postcodeTh' => $company_postcode,
                'company_addressEn' => $company_addressEn,
                'company_provinceEn' => $company_provinceEn,
                'company_districtEn' => $company_districtEn,
                'company_subdistrictEn' => $company_subdistrictEn,
                'company_postcodeEn' => $company_postcodeEn,
                'contact_address' => $contact_address,
                'contact_province' => $contact_province,
                'contact_district' => $contact_district,
                'contact_subdistrict' => $contact_subdistrict,
                'contact_postcode' => $contact_postcode,
                'member_title' => $member_title,
                'member_cid' => $member_cid,
                'member_nameTh' => $member_nameTh,
                'member_lastnameTh' => $member_lastnameTh,
                'member_nameEn' => $member_nameEn,
                'member_lastnameEn' => $member_lastnameEn,
                'member_email' => $member_email,
                'member_tel' => $member_tel,
                'member_tel_country' => ($member_tel_country == '')? 'TH' : strtoupper($member_tel_country),
                'member_tel_code' => ($member_tel_code == '')? '+66' : "+".$member_tel_code
              ];
  
              $insert_type1 = $this->insert('tb_member_type1', $data_insert_type1);
  
              
              
              // //------------------------ INSERT AND LOGIN connect --------------------------//
              //   //-- insert_touch ---/
              //   $data_insert_touch = [
              //     'register_type' => 'FORM',
              //     'identify' => 'CORPORATE',
              //     'email' => $member_email,
              //     'password' => $password,
              //     'company_name' => $company_nameTh,
              //     'company_tax_id' => $cid,
              //     'company_telephone' => $member_tel
              //   ];
              //   $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //2 IS CORPORATE
  
              //   if($insert_connect2['status'] == TRUE){
  
              //     //-------- update member_id and token connect --------//
              //     $member_id_connect = $insert_connect2['member_id'];
              //     $token_connect = $insert_connect2['token'];
              //     $id_connect = $insert_connect2['member_id'];
  
              //     $data_insert_member_app = [
              //       'member_id' => $member_id, //id ของ tb_member
              //       'member_id_app' => $member_id_connect, //primary in app
              //       'client_id' => 'SS6931846'
              //     ];
              //     $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
  
              //     //------- insert token_external --------//
              //     $data_insert_token_external = [
              //       'member_id' => $member_id,
              //       'member_id_app' => $id_connect,
              //       'token_code' => $token_connect,
              //       'member_type' => 'TOUCH',
              //     ];
              //     $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
              //   }
              //------------------------ END OFF INSERT AND LOGIN connect --------------------------//
  
  
              // $code_care = $this->get_code($member_id, 'ssocareid');
              // $insert_care = $this->insert_care($code_care);
  
              if($insert_type1){
                $sql_sso = "SELECT sso_id FROM `tb_member` WHERE cid = '$cid'";
              $chk_ssoid = $this->query($sql_sso);
              }
              
            }
            
           $return = ['Code' => '00', 'Msg' => 'Success' , 'SSO_ID' => $chk_ssoid[0]['sso_id']]; 
          }else{
            $return = ['Code' => '01', 'Msg' => 'Error'];
            
          }
        }
        else{
          $error_res = [];
          foreach ($error as $key => $value) {
            $error_res[] = [
              'name' => $key,
              'value' => $value
            ];
          }
          $return = ['Code' => '01', 'Msg' => $error_res];
        }
  
        
        return $return ;
      
      }
      else if($type == 2){
         // -- data tb_member --//
         $cid = $this->post('cid');
         $password = $this->post('password');
   
         //-- data tb_member_type2 --//
         $corporate_name = $this->post('fo_corporate_name');
         $member_title = $this->post('fo_title');
         $member_nameEn = $this->post('fo_name');
         $member_lastnameEn = $this->post('fo_lastname');
         $country = $this->post('fo_country_name');
         $address = $this->post('fo_address');
         $email = $this->post('fo_email');
         $tel = $this->post('fo_tel');
   
         $tel_country = $this->post('fo_tel_country');
         $tel_code = $this->post('fo_tel_code');
   
         $text_alert = "Please fill in the information";
      
         //---------- check cid -----------//
         $sql_ckcid1 = 'SELECT 1 , sso_id FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
         //$sql_ckcid2 = 'SELECT 1 FROM Member WHERE member_cid ="' . $cid . '"';
         $sql_ckcid2 = 'SELECT 1 FROM Member_v2 WHERE member_cid ="' . $cid . '"';
         $sql_ckcid3 = 'SELECT 1 FROM Member_drive_v3 WHERE Username ="' . $cid . '"';
  
         
         $ck_cid1 = $this->query($sql_ckcid1);
         $ck_cid2 = $this->query($sql_ckcid2);
         $ck_cid3 = $this->query($sql_ckcid3);
  
         if (!empty($ck_cid1) || !empty($ck_cid2) || !empty($ck_cid3) ) {
         //if (!empty($ck_cid1)) {
           $error['cid'] = 'has already been used SSO ID :'.$ck_cid1[0]['sso_id'];
         }
  
         if(empty($cid)) $error['cid'] =  $text_alert;
  
        if(!preg_match("#[a-zA-Z]+#", $password)) {
          $error['password'] = "must include at least one letter!";
        }
        if(strlen($password) < 8) {
          $error['password'] = "more than 8 characters";
        }
  
        if(empty($password)) $error['password'] =  $text_alert;
  
        if(empty($corporate_name)) $error['fo_corporate_name'] =  $text_alert;
        if(empty($country)) $error['fo_country_name'] =  $text_alert;
  
        if(empty($member_title)) $error['fo_title'] =  $text_alert;
        if(empty($member_nameEn)) $error['fo_name'] =  $text_alert;
        if(empty($member_lastnameEn)) $error['fo_lastname'] =  $text_alert;
  
        // $ck_mail = $this->check_mail($email);
  
        // if($ck_mail == false){
        //   $error['fo_email'] = 'has already been used';
        // }
  
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $error['fo_email'] = 'not a valid ';
        }
  
        if(empty($email)) $error['fo_email'] =  $text_alert;
        if(empty($tel)) $error['fo_tel'] =  $text_alert;
  
        if(empty($error)){
          $type_is = $type;
          if($type_is){
            $data_insert_member = [
              'member_app' => '',
              'member_app_id' => '',
              'cid' => $cid,
              'password' => sha1($password),
              'type' => $type,
              'status' => '1',
              'register_from' => '1'
            ];
   
            $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
            $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
            $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
            $ck_mem = $this->insert('tb_member', $data_insert_member);
  
            if(!empty($ck_mem)){
              $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
              $result_max = $this->query($sql_max);
              $member_id = $result_max[0]['member_id'];
              $data_insert_type2 = [
                'member_id' => $member_id,
                'corporate_name' =>  $corporate_name,
                'country' => $country,
                'address' => $address,
                'member_title' => $member_title,
                'member_nameEn' => $member_nameEn,
                'member_lastnameEn' => $member_lastnameEn,
                'email' => $email,
                'tel' => $tel,
                'tel_country' => ($tel_country == '')? 'TH' : strtoupper($tel_country),
                'tel_code' => ($tel_code == '')? '+66' : "+".$tel_code
              ];
  
              $insert_type2 = $this->insert('tb_member_type2', $data_insert_type2);
  
            //   //------------------------ INSERT AND LOGIN connect --------------------------//
            //    //-- insert_touch ---/
            //    $data_insert_touch = [
            //     'register_type' => 'FORM',
            //     'identify' => 'CORPORATE',
            //     'email' => $email,
            //     'password' => $password,
            //     'company_name' => $corporate_name,
            //     'company_tax_id' => $cid,
            //     'company_telephone' => $tel
            //   ];
  
            //   $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 2), TRUE); //2 IS CORPORATE
            //   print_r($insert_connect2['status']);
            //   die();
            //   if($insert_connect2['status'] == TRUE){
  
            //     //-------- update member_id and token connect --------//
            //     $member_id_connect = $insert_connect2['member_id'];
            //     $token_connect = $insert_connect2['token'];
            //     $id_connect = $insert_connect2['member_id'];
  
            //     $data_insert_member_app = [
            //       'member_id' => $member_id, //id ของ tb_member
            //       'member_id_app' => $member_id_connect, //primary in app
            //       'client_id' => 'SS6931846'
            //     ];
            //     $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
  
            //     //------- insert token_external --------//
            //     $data_insert_token_external = [
            //       'member_id' => $member_id,
            //       'member_id_app' => $id_connect,
            //       'token_code' => $token_connect,
            //       'member_type' => 'TOUCH',
            //     ];
            //     $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
            //   }
            // //------------------------ END OFF INSERT AND LOGIN connect --------------------------//
  
            // $code_care = $this->get_code($member_id, 'ssocareid');
              // $insert_care = $this->insert_care($code_care);
              if($insert_type2){
                $sql_sso = "SELECT sso_id FROM `tb_member` WHERE cid = '$cid'";
               $chk_ssoid = $this->query($sql_sso);
              }
            }
            $return = ['Code' => '00', 'Msg' => 'Success' , 'SSO_ID' => $chk_ssoid[0]['sso_id']]; 
          }
          else{
            $return = ['Code' => '01', 'Msg' => 'Error'];
            
          }
        }else{
          $error_res = [];
          foreach ($error as $key => $value) {
            $error_res[] = [
              'name' => $key,
              'value' => $value
            ];
          }
          $return = ['Code' => '01', 'Msg' => $error_res];
        }
        return $return;
      
      }
      else if($type == 3){
        // -- data tb_member --//
   
        $cid = $this->post('cid');
        $password = $this->post('password');
  
        //-- data tb_member_type3 --//
        $member_title = $this->post('title');
        $member_nameTh = $this->post('name_user');
        $member_lastnameTh = $this->post('lastname');
        $member_nameEn = $this->post('name_userEn');
        $member_lastnameEn = $this->post('lastnameEn');
        $email = $this->post('email');
        $tel = $this->post('tel');
        $tel_country = $this->post('tel_country');
        $tel_code = $this->post('tel_code');
        $addressTh = $this->post('addressTh');
        $provinceTh = $this->post('provinceTh');
        $districtTh = $this->post('districtTh');
        $subdistrictTh = $this->post('subdistrictTh');
        $postcode = $this->post('postcode');
        
        $addressEn = $this->post('addressEn');
        $provinceEn = "";
        $districtEn = "";
        $subdistrictEn = "";
  
        if (!$this->isValidNationalId($cid)) {
          $error['cid'] = 'Not correct';
        }
          //---------- check cid -----------//
          $sql_ckcid1 = 'SELECT 1 , sso_id FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
          $sql_ckcid2 = 'SELECT 1 FROM Member_v2 WHERE member_cid ="' . $cid . '"';
          $sql_ckcid3 = 'SELECT 1 FROM Member_drive_v3 WHERE Username ="' . $cid . '"';
    
          $ck_cid1 = $this->query($sql_ckcid1);
          $ck_cid2 = $this->query($sql_ckcid2);
          $ck_cid3 = $this->query($sql_ckcid3);
    
    
          if (!empty($ck_cid1) || !empty($ck_cid2) || !empty($ck_cid3) ) {
            $error['cid'] = 'has already been used SSO ID :'.$ck_cid1[0]['sso_id'];
          }
  
          if(empty($cid)) $error['cid'] = 'Please input information';
  
          if(!preg_match("#[a-zA-Z]+#", $password)) {
            $error['password'] = "must include at least one letter!";
          }
          if(strlen($password) < 8) {
            $error['password'] = "more than 8 characters";
          }
    
          if(empty($password)) $error['password'] = 'Please input information';
  
          if(empty($member_title)) $error['title'] = 'Please input information';
          if(empty($member_nameTh)) $error['name_user'] = 'Please input information';
          if(empty($member_lastnameTh)) $error['lastname'] = 'Please input information';
          if(empty($member_nameEn)) $error['name_userEn'] = 'Please input information';
          if(empty($member_lastnameEn)) $error['lastnameEn'] = 'Please input information';
  
          $ck_mail = $this->check_mail($email);
          if($ck_mail == false){
            $error['email'] = 'has already been used';
          }
  
          if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'not a valid';
          }
    
          if(empty($email)) $error['email'] = 'Please input information';
          if(empty($tel)) $error['tel'] = 'Please input information';
    
          if(empty($addressTh)) $error['addressTh'] = 'Please input information';
          if(empty($provinceTh)) $error['provinceTh'] = 'Please input information';
          if(empty($districtTh)) $error['districtTh'] = 'Please input information';
          if(empty($subdistrictTh)) $error['subdistrictTh'] = 'Please input information';
          if(empty($postcode)) $error['postcode'] = 'Please input information';
  
        $proID = $provinceTh;
        $disID = $districtTh;
        $subID = $subdistrictTh;
          print_r($error);
  
        if(empty($error)){
          if(!empty($proID)) $provinceTh = $this->get_province($proID, 'th');
          if(!empty($disID)) $districtTh = $this->get_district($disID, 'th');
          if(!empty($subID)) $subdistrictTh = $this->get_subdistrict($subID, 'th');
  
          if(!empty($proID)) $provinceEn = $this->get_province($proID, 'en');
          if(!empty($disID)) $districtEn = $this->get_district($disID, 'en');
          if(!empty($subID)) $subdistrictEn = $this->get_subdistrict($subID, 'en');
        }
   
        if(empty($error)){
          $type_is = $type;
          if($type_is){
           
            $data_insert_member = [
              'member_app' => '',
              'member_app_id' => '',
              'cid' => $cid,
              'password' => sha1($password),
              'type' => $type,
              'status' => '1',
              'register_from' => '1'
            ];
          
            $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
            $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
            $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
            $ck_mem = $this->insert('tb_member', $data_insert_member);
    
            if(!empty($ck_mem)){
              $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
              $result_max = $this->query($sql_max);
              $member_id = $result_max[0]['member_id'];
              $data_insert_type3 = [
                'member_id' => $member_id,
                'member_title' => $member_title,
                'member_nameTh' => $member_nameTh,
                'member_lastnameTh' => $member_lastnameTh,
                'member_nameEn' => $member_nameEn,
                'member_lastnameEn' => $member_lastnameEn,
                'email' => $email,
                'tel' => $tel,
                'tel_country' => ($tel_country == '')? 'TH' : strtoupper($tel_country),
                'tel_code' => ($tel_code == '')? '+66' : "+".$tel_code,
  
                'addressTh' => $addressTh,
                'provinceTh' => $provinceTh,
                'districtTh' => $districtTh,
                'subdistrictTh' => $subdistrictTh,
                'postcode' => $postcode,
                'addressEn' => $addressEn,
                'provinceEn' => $provinceEn,
                'districtEn' => $districtEn,
                'subdistrictEn' => $subdistrictEn
              ];
              $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);
  
  
              // //------------------------ INSERT AND LOGIN connect --------------------------//
              //   //-- insert_touch ---/
              //   $data_insert_touch = [
              //     'register_type' => 'FORM',
              //     'identify' => 'PERSONAL',
              //     'email' => $email,
              //     'password' => $password,
              //     'firstname' => $member_nameEn,
              //     'lastname' => $member_lastnameEn,
              //     'citizen_id' => $cid,
              //     'mobile' => $tel
              //   ];
              //   $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL
  
              //   if($insert_connect2['status'] == TRUE){
  
              //     //-------- update member_id and token connect --------//
              //     $member_id_connect = $insert_connect2['member_id'];
              //     $token_connect = $insert_connect2['token'];
              //     $id_connect = $insert_connect2['member_id'];
  
              //     $data_insert_member_app = [
              //       'member_id' => $member_id, //id ของ tb_member
              //       'member_id_app' => $member_id_connect, //primary in app
              //       'client_id' => 'SS6931846'
              //     ];
              //     $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
  
              //     //------- insert token_external --------//
              //     $data_insert_token_external = [
              //       'member_id' => $member_id,
              //       'member_id_app' => $id_connect,
              //       'token_code' => $token_connect,
              //       'member_type' => 'TOUCH',
              //     ];
              //     $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
              //   }
              // //------------------------ END OFF INSERT AND LOGIN connect --------------------------//
  
              // $code_care = $this->get_code($member_id, 'ssocareid');
              // $insert_care = $this->insert_care($code_care);
  
  
              if($insert_type3){
                $sql_sso = "SELECT sso_id FROM `tb_member` WHERE cid = '$cid'";
              $chk_ssoid = $this->query($sql_sso);
              }
            }
            $return = ['Code' => '00', 'Msg' => 'Success' , 'SSO_ID' => $chk_ssoid[0]['sso_id']]; 
          }
          else{
            $return = ['Code' => '01', 'Msg' => 'Error'];
          }
        }else{
          $error_res = [];
          foreach ($error as $key => $value) {
            $error_res[] = [
              'name' => $key,
              'value' => $value
            ];
          }
          $return = ['Code' => '01', 'Msg' => $error_res];
        }
        return $return;
      
      }
      else if($type == 4){
  
         // -- data tb_member --//
         $cid = $this->post('cid');
         $password = $this->post('password');
   
         // -- data tb_member_type4 --//
         $member_title = $this->post('fo_title');
         $member_nameEn = $this->post('fo_name');
         $member_lastnameEn = $this->post('fo_lastname');
         $country = $this->post('fo_country_name');
         $address = $this->post('fo_address');
         $email = $this->post('fo_email');
         $tel = $this->post('fo_tel');
         $tel_country = $this->post('fo_tel_country');
         $tel_code = $this->post('fo_tel_code');
   
         $text_alert = "Please fill in the information";
         if(empty($cid)) $error['cid'] = $text_alert;
   
         if(!preg_match("#[a-zA-Z]+#", $password)) {
           $error['password'] = "must include at least one letter!";
         }
         if(strlen($password) < 8) {
           $error['password'] = "more than 8 characters";
         }
  
         if(empty($password)) $error['password'] = $text_alert;
         
         if(empty($country)) $error['fo_country_name'] = $text_alert;
         if(empty($member_title)) $error['fo_title'] = $text_alert;
         if(empty($member_nameEn)) $error['fo_name'] = $text_alert;
         if(empty($member_lastnameEn)) $error['fo_lastname'] = $text_alert;
      
  
         $ck_mail = $this->check_mail($email);
         if($ck_mail == false){
           $error['fo_email'] = 'has already been used';
         }
         if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $error['fo_email'] = 'not a valid';
        }
        if(empty($email)) $error['fo_email'] = $text_alert;
        if(empty($tel)) $error['fo_tel'] = $text_alert;
  
        //---------- check cid -----------//
        $sql_ckcid1 = 'SELECT 1 , sso_id FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
        //$sql_ckcid2 = 'SELECT 1 FROM Member WHERE member_cid ="' . $cid . '"';
        $sql_ckcid2 = 'SELECT 1 FROM Member_v2 WHERE member_cid ="' . $cid . '"';
        $sql_ckcid3 = 'SELECT 1 FROM Member_drive_v3 WHERE Username ="' . $cid . '"';
        
        $ck_cid1 = $this->query($sql_ckcid1);
        $ck_cid2 = $this->query($sql_ckcid2);
        $ck_cid3 = $this->query($sql_ckcid3);
  
        if (!empty($ck_cid1) || !empty($ck_cid2) || !empty($ck_cid3) ) {
          $error['cid'] = 'has already been used SSO ID :'.$ck_cid1[0]['sso_id'];
        }
  
        if(empty($error)){
          $type_is = $type;
          if($type_is){
            $data_insert_member = [
              'member_app' => '',
              'member_app_id' => '',
              'cid' => $cid,
              'password' => sha1($password),
              'type' => $type,
              'status' => '1',
              'register_from' => '1'
            ];
      
            $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
            $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
            $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
            $ck_mem = $this->insert('tb_member', $data_insert_member);
      
            if(!empty($ck_mem)){
              $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
              $result_max = $this->query($sql_max);
              $member_id = $result_max[0]['member_id'];
  
              $data_insert_type4 = [
                'member_id' => $member_id,
                'member_title' => $member_title,
                // 'member_nameTh' => $member_nameTh,
                // 'member_lastnameTh' => $member_lastnameTh,
                'member_nameEn' => $member_nameEn,
                'member_lastnameEn' => $member_lastnameEn,
                'country' => $country,
                'address' => $address,
                'email' => $email,
                'tel' => $tel,
                'tel_country' => ($tel_country == '')? 'TH' : strtoupper($tel_country),
                'tel_code' => ($tel_code == '')? '+66' : "+".$tel_code
              ];
              $insert_type4 = $this->insert('tb_member_type4', $data_insert_type4);
  
  
              // //------------------------ INSERT AND LOGIN connect --------------------------//
              //   //-- insert_touch ---/
              //   $data_insert_touch = [
              //     'register_type' => 'FORM',
              //     'identify' => 'PERSONAL',
              //     'email' => $email,
              //     'password' => $password,
              //     'firstname' => $member_nameEn,
              //     'lastname' => $member_lastnameEn,
              //     'citizen_id' => $cid,
              //     'mobile' => $tel
              //   ];
              //   $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL
  
              //   if($insert_connect2['status'] == TRUE){
  
              //     //-------- update member_id and token connect --------//
              //     $member_id_connect = $insert_connect2['member_id'];
              //     $token_connect = $insert_connect2['token'];
              //     $id_connect = $insert_connect2['member_id'];
  
              //     $data_insert_member_app = [
              //       'member_id' => $member_id, //id ของ tb_member
              //       'member_id_app' => $member_id_connect, //primary in app
              //       'client_id' => 'SS6931846'
              //     ];
              //     $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
  
              //     //------- insert token_external --------//
              //     $data_insert_token_external = [
              //       'member_id' => $member_id,
              //       'member_id_app' => $id_connect,
              //       'token_code' => $token_connect,
              //       'member_type' => 'TOUCH',
              //     ];
              //     $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
              //   }
              // //------------------------ END OFF INSERT AND LOGIN connect --------------------------//
  
              // $code_care = $this->get_code($member_id, 'ssocareid');
              // $insert_care = $this->insert_care($code_care);
  
              if($insert_type4){
                $sql_sso = "SELECT sso_id FROM `tb_member` WHERE cid = '$cid'";
              $chk_ssoid = $this->query($sql_sso);
              }
            }
            $return = ['Code' => '00', 'Msg' => 'Success' , 'SSO_ID' => $chk_ssoid[0]['sso_id']]; 
          }
          else{
            $return = ['Code' => '01', 'Msg' => 'Error'];
          }
        }else{
          $error_res = [];
          foreach ($error as $key => $value) {
            $error_res[] = [
              'name' => $key,
              'value' => $value
            ];
          }
          $return = ['Code' => '01', 'Msg' => $error_res];
        }
        return json_encode($return);
  
   
      }
      else {
        $return = ['Code' => '01', 'Msg' => 'Not have this type'];
        return $return;
   
      }
      
    }
    function ck_com_dbd($cid = '')
    {
          set_time_limit(15);
          $keyFile = "/home/care/www_dev/dbd/ditp.key";
          $caFile = "/home/care/www_dev/dbd/ditp.ca";
          $certFile = "/home/care/www_dev/dbd/ditp.crt";

          $xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.wsdata.dbd.gov/">
                        <soapenv:Header/>
                        <soapenv:Body>
                          <ser:getData>
                              <!--Optional:-->
                              <subscriberId>6211005</subscriberId>
                              <!--Optional:-->
                              <subscriberPwd>$PSk3754</subscriberPwd>
                              <!--Optional:-->
                              <serviceId>0001</serviceId>
                              <!--Zero or more repetitions:-->
                              <params>
                                <!--Optional:-->
                                <name>JURISDICTION_ID</name>
                                <!--Optional:-->
                                <value>' . $cid . '</value>
                              </params>
                          </ser:getData>
                        </soapenv:Body>
                        </soapenv:Envelope>';


          $contentlength = strlen($xml_data);
          $URL = "https://ssodev.ditp.go.th/dbdws/";

          //$URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService";
          // $URL = "https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService";
          $ch = curl_init($URL);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_VERBOSE, true);
          curl_setopt($ch,CURLOPT_TIMEOUT,6);
          // this with CURLOPT_SSLKEYPASSWD
          curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);
          // // The --cacert option
          curl_setopt($ch, CURLOPT_CAINFO, $caFile);
          curl_setopt($ch, CURLOPT_CAPATH, '');
          // // The --cert option
          curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
          curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
              'Content-Type: text/xml'
            )
          );
          curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $output = curl_exec($ch);
          $error =  curl_error($ch);
          if(!empty($error)){
             echo ''.$error.' output: '.$output;
             die;
          }
          $return = [];
          if ($output === false) {
            $content = curl_exec($ch);
            $err     = curl_errno($ch);
            $errmsg  = curl_error($ch);
            $header  = curl_getinfo($ch);
            curl_close($ch);

            $header['errno']   = $err;
            $header['errmsg']  = $errmsg;
            $header['content'] = $content;
          } else {
            curl_close($ch);
            $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
            $xml = new SimpleXMLElement($response);
            $body = $xml->xpath('//SBody')[0];
            $array = json_decode(json_encode((array) $body), TRUE);
            $return = $array;
          }
          // $sql = "UPDATE `cancel_text` SET `edit_by` = '".$ssoid."', `text_th` = '".$text_th."', `text_en` = '".$text_en."' WHERE `cancel_text`.`id` = 1";
          // $result = $this->query($sql);
          // pr($return['ns0getDataResponse']['return']['arrayRRow']['columns']);
          // die();
          return $return;
  }
  function ck_com_dbd_data ($cid = '') {
    
  }
  function model_getTextCancel()
  {
      $sql = 'SELECT * FROM `cancel_text` limit 1';
      $result = $this->query($sql);
          if(isset($result[0])){
              $return = [
                "status" => 200,
                "result" => $result[0]
            ];
          }else{
            $return = [
              "status" => 400,
              "message" => 'Not found'
          ];
          }
      return $return;
    }
    function model_TextCancel($ssoid,$text_th,$text_en)
    {
      try {
        $sql = "UPDATE `cancel_text` SET `edit_by` = '".$ssoid."', `text_th` = '".$text_th."', `text_en` = '".$text_en."' WHERE `cancel_text`.`id` = 1";
        $result = $this->query($sql);
                $return = [
                  "status" => 200,
                  "message" => 'success'
              ];
        return $return;
      } catch (\Throwable $th) {
              $return = [
                "status" => 400,
                "message" => 'Not found'
            ];
        return $return;
      }
    }
    function gen_id()
    {
      $digits = 4;
        $number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $ssoid = "SS" . $number;
      return $ssoid;
    }
    function model_send_mail(){
      $return = [
        "status" => "01",
        "message" => "ดำเนินการไม่สำเร็จ"
      ];
      $cid = $this->post('cid');
      $target = $this->post('target');
      $email = $this->post('email');
      $member_name = $this->post('member_name');
      // var_dump($cid,$target,$email,$member_name);
      // die();
      if($email != "" && $cid !="" && $target != ""){
            $otp_pass = $this->gen_id();
            $exp_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+15 minutes"));
            $sql = "SELECT * FROM `cancel_member` WHERE cid = '".$cid."' limit 1";
            $result = $this->query($sql);
            $cancel_member = [
              'cid' => $cid,
              'target' => $target,
              'member_name' => $member_name,
              'otp_pass' => $otp_pass,
              'exp_date' => $exp_date
            ];

          if(empty($result)){
              //-- insert tb_token_reset --//
              $this->insert('cancel_member', $cancel_member);
          }else{
              $this->update('cancel_member', $cancel_member, ' cid="' . $cid . '"');
          }

        // ----- Google SMTP ----- //
        // $mail = new PHPMailer();
        // $mail->isSMTP();
        // $mail->SMTPDebug = 0;
        // $mail->SMTPAuth = true;
        // $mail->SMTPSecure = "tls";
        // $mail->Host = "smtp.gmail.com"; // ถ้าใช้ smtp ของ server เป็นอยู่ในรูปแบบนี้ mail.domainyour.com
        // $mail->Port = 587;
        // $mail->isHTML();
        // $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
        // $mail->Username = "kittiporn.s@ibusiness.co.th"; //กรอก Email Gmail หรือ เมลล์ที่สร้างบน server ของคุณเ
        // $mail->Password = "0856225746"; // ใส่รหัสผ่าน email ของคุณ
        // $mail->SetFrom = ('kittiporn.s@ibusiness.co.th'); //กำหนด email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง
        // $mail->FromName = "DITP SSO"; //ชื่อที่ใช้ในการส่ง
        // $mail->Subject = "รีเซ็ตรหัสผ่าน DITP SSO";  //หัวเรื่อง emal ที่ส่ง
        
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->SMTPAuth = true;
          $mail->SMTPDebug = 0;
          $mail->SMTPSecure = "tlsv1.2";
          $mail->Host = Host_Mailjet;
          $mail->Port = 587;
          $mail->isHTML();
          $mail->CharSet = "utf-8";
          $mail->Username = USERNAME_Mailjet;
          $mail->Password = PASSWORD_Mailjet;
  
        $mail->From = ('sso@ditp.go.th');//pdpa@ditp.go.th
        $mail->FromName = "DITP Single Sign-on";
        $mail->Subject = "ลบบัญชีผู้ใช้ DITP Single Sign-on";
  
        $mail->Body = '<!doctype html>';
        $mail->Body.= '<html>';
        $mail->Body.= '<head>';
        $mail->Body.= '<meta name="viewport" content="width=device-width" />';
        $mail->Body.= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $mail->Body.= '<title>SSO DITP Reset Password</title>';
        $mail->Body.= '<style>';
        $mail->Body.= '/* -------------------------------------';
        $mail->Body.= 'GLOBAL RESETS';
        $mail->Body.= '------------------------------------- */';
        $mail->Body.= '';
        $mail->Body.= '/*All the styling goes here*/';
        $mail->Body.= '';
        $mail->Body.= 'img {';
        $mail->Body.= 'border: none;';
        $mail->Body.= '-ms-interpolation-mode: bicubic;';
        $mail->Body.= 'max-width: 100%;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= 'body {';
        $mail->Body.= 'background-color: #f6f6f6;';
        $mail->Body.= 'font-family: sans-serif;';
        $mail->Body.= '-webkit-font-smoothing: antialiased;';
        $mail->Body.= 'font-size: 14px;';
        $mail->Body.= 'line-height: 1.4;';
        $mail->Body.= 'margin: 0;';
        $mail->Body.= 'padding: 0;';
        $mail->Body.= '-ms-text-size-adjust: 100%;';
        $mail->Body.= '-webkit-text-size-adjust: 100%;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= 'table {';
        $mail->Body.= 'border-collapse: separate;';
        $mail->Body.= 'mso-table-lspace: 0pt;';
        $mail->Body.= 'mso-table-rspace: 0pt;';
        $mail->Body.= 'width: 100%; }';
        $mail->Body.= 'table td {';
        $mail->Body.= 'font-family: sans-serif;';
        $mail->Body.= 'font-size: 14px;';
        $mail->Body.= 'vertical-align: top;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '/* -------------------------------------';
        $mail->Body.= 'BODY & CONTAINER';
        $mail->Body.= '------------------------------------- */';
        $mail->Body.= '';
        $mail->Body.= '.body {';
        $mail->Body.= 'background-color: #f6f6f6;';
        $mail->Body.= 'width: 100%;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */';
        $mail->Body.= '.container {';
        $mail->Body.= 'display: block;';
        $mail->Body.= 'margin: 0 auto !important;';
        $mail->Body.= '/* makes it centered */';
        $mail->Body.= 'max-width: 580px;';
        $mail->Body.= 'padding: 10px;';
        $mail->Body.= 'width: 580px;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '/* This should also be a block element, so that it will fill 100% of the .container */';
        $mail->Body.= '.content {';
        $mail->Body.= 'box-sizing: border-box;';
        $mail->Body.= 'display: block;';
        $mail->Body.= 'margin: 0 auto;';
        $mail->Body.= 'max-width: 580px;';
        $mail->Body.= 'padding: 10px;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '/* -------------------------------------';
        $mail->Body.= 'HEADER, FOOTER, MAIN';
        $mail->Body.= '------------------------------------- */';
        $mail->Body.= '.main {';
        $mail->Body.= 'background: #ffffff;';
        $mail->Body.= 'border-radius: 3px;';
        $mail->Body.= 'width: 100%;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.wrapper {';
        $mail->Body.= 'box-sizing: border-box;';
        $mail->Body.= 'padding: 20px;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.content-block {';
        $mail->Body.= 'padding-bottom: 10px;';
        $mail->Body.= 'padding-top: 10px;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.footer {';
        $mail->Body.= 'clear: both;';
        $mail->Body.= 'margin-top: 10px;';
        $mail->Body.= 'text-align: center;';
        $mail->Body.= 'width: 100%;';
        $mail->Body.= '}';
        $mail->Body.= '.footer td,';
        $mail->Body.= '.footer p,';
        $mail->Body.= '.footer span,';
        $mail->Body.= '.footer a {';
        $mail->Body.= 'color: #999999;';
        $mail->Body.= 'font-size: 12px;';
        $mail->Body.= 'text-align: center;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '/* -------------------------------------';
        $mail->Body.= 'TYPOGRAPHY';
        $mail->Body.= '------------------------------------- */';
        $mail->Body.= 'h1,';
        $mail->Body.= 'h2,';
        $mail->Body.= 'h3,';
        $mail->Body.= 'h4 {';
        $mail->Body.= 'color: #000000;';
        $mail->Body.= 'font-family: sans-serif;';
        $mail->Body.= 'font-weight: 400;';
        $mail->Body.= 'line-height: 1.4;';
        $mail->Body.= 'margin: 0;';
        $mail->Body.= 'margin-bottom: 30px;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= 'h1 {';
        $mail->Body.= 'font-size: 35px;';
        $mail->Body.= 'font-weight: 300;';
        $mail->Body.= 'text-align: center;';
        $mail->Body.= 'text-transform: capitalize;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= 'p,';
        $mail->Body.= 'ul,';
        $mail->Body.= 'ol {';
        $mail->Body.= 'font-family: sans-serif;';
        $mail->Body.= 'font-size: 14px;';
        $mail->Body.= 'font-weight: normal;';
        $mail->Body.= 'margin: 0;';
        $mail->Body.= 'margin-bottom: 15px;';
        $mail->Body.= '}';
        $mail->Body.= 'p li,';
        $mail->Body.= 'ul li,';
        $mail->Body.= 'ol li {';
        $mail->Body.= 'list-style-position: inside;';
        $mail->Body.= 'margin-left: 5px;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= 'a {';
        $mail->Body.= 'color: #3498db;';
        $mail->Body.= 'text-decoration: underline;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '/* -------------------------------------';
        $mail->Body.= 'BUTTONS';
        $mail->Body.= '------------------------------------- */';
        $mail->Body.= '.btn {';
        $mail->Body.= 'box-sizing: border-box;';
        $mail->Body.= 'width: 100%; }';
        $mail->Body.= '.btn > tbody > tr > td {';
        $mail->Body.= 'padding-bottom: 15px; }';
        $mail->Body.= '.btn table {';
        $mail->Body.= 'width: auto;';
        $mail->Body.= '}';
        $mail->Body.= '.btn table td {';
        $mail->Body.= 'background-color: #ffffff;';
        $mail->Body.= 'border-radius: 5px;';
        $mail->Body.= 'text-align: center;';
        $mail->Body.= '}';
        $mail->Body.= '.btn a {';
        $mail->Body.= 'background-color: #ffffff;';
        $mail->Body.= 'border: solid 1px #3498db;';
        $mail->Body.= 'border-radius: 5px;';
        $mail->Body.= 'box-sizing: border-box;';
        $mail->Body.= 'color: #3498db;';
        $mail->Body.= 'cursor: pointer;';
        $mail->Body.= 'display: inline-block;';
        $mail->Body.= 'font-size: 14px;';
        $mail->Body.= 'font-weight: bold;';
        $mail->Body.= 'margin: 0;';
        $mail->Body.= 'padding: 12px 25px;';
        $mail->Body.= 'text-decoration: none;';
        $mail->Body.= 'text-transform: capitalize;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.btn-primary table td {';
        $mail->Body.= 'background-color: #3498db;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.btn-primary a {';
        $mail->Body.= 'background-color: #3498db;';
        $mail->Body.= 'border-color: #3498db;';
        $mail->Body.= 'color: #ffffff;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '/* -------------------------------------';
        $mail->Body.= 'OTHER STYLES THAT MIGHT BE USEFUL';
        $mail->Body.= '------------------------------------- */';
        $mail->Body.= '.last {';
        $mail->Body.= 'margin-bottom: 0;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.first {';
        $mail->Body.= 'margin-top: 0;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.align-center {';
        $mail->Body.= 'text-align: center;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.align-right {';
        $mail->Body.= 'text-align: right;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.align-left {';
        $mail->Body.= 'text-align: left;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.clear {';
        $mail->Body.= 'clear: both;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.mt0 {';
        $mail->Body.= 'margin-top: 0;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.mb0 {';
        $mail->Body.= 'margin-bottom: 0;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.preheader {';
        $mail->Body.= 'color: transparent;';
        $mail->Body.= 'display: none;';
        $mail->Body.= 'height: 0;';
        $mail->Body.= 'max-height: 0;';
        $mail->Body.= 'max-width: 0;';
        $mail->Body.= 'opacity: 0;';
        $mail->Body.= 'overflow: hidden;';
        $mail->Body.= 'mso-hide: all;';
        $mail->Body.= 'visibility: hidden;';
        $mail->Body.= 'width: 0;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '.powered-by a {';
        $mail->Body.= 'text-decoration: none;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= 'hr {';
        $mail->Body.= 'border: 0;';
        $mail->Body.= 'border-bottom: 1px solid #f6f6f6;';
        $mail->Body.= 'margin: 20px 0;';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '/* -------------------------------------';
        $mail->Body.= 'RESPONSIVE AND MOBILE FRIENDLY STYLES';
        $mail->Body.= '------------------------------------- */';
        $mail->Body.= '@media only screen and (max-width: 620px) {';
        $mail->Body.= 'table[class=body] h1 {';
        $mail->Body.= 'font-size: 28px !important;';
        $mail->Body.= 'margin-bottom: 10px !important;';
        $mail->Body.= '}';
        $mail->Body.= 'table[class=body] p,';
        $mail->Body.= 'table[class=body] ul,';
        $mail->Body.= 'table[class=body] ol,';
        $mail->Body.= 'table[class=body] td,';
        $mail->Body.= 'table[class=body] span,';
        $mail->Body.= 'table[class=body] a {';
        $mail->Body.= 'font-size: 16px !important;';
        $mail->Body.= '}';
        $mail->Body.= 'table[class=body] .wrapper,';
        $mail->Body.= 'table[class=body] .article {';
        $mail->Body.= 'padding: 10px !important;';
        $mail->Body.= '}';
        $mail->Body.= 'table[class=body] .content {';
        $mail->Body.= 'padding: 0 !important;';
        $mail->Body.= '}';
        $mail->Body.= 'table[class=body] .container {';
        $mail->Body.= 'padding: 0 !important;';
        $mail->Body.= 'width: 100% !important;';
        $mail->Body.= '}';
        $mail->Body.= 'table[class=body] .main {';
        $mail->Body.= 'border-left-width: 0 !important;';
        $mail->Body.= 'border-radius: 0 !important;';
        $mail->Body.= 'border-right-width: 0 !important;';
        $mail->Body.= '}';
        $mail->Body.= 'table[class=body] .btn table {';
        $mail->Body.= 'width: 100% !important;';
        $mail->Body.= '}';
        $mail->Body.= 'table[class=body] .btn a {';
        $mail->Body.= 'width: 100% !important;';
        $mail->Body.= '}';
        $mail->Body.= 'table[class=body] .img-responsive {';
        $mail->Body.= 'height: auto !important;';
        $mail->Body.= 'max-width: 100% !important;';
        $mail->Body.= 'width: auto !important;';
        $mail->Body.= '}';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '/* -------------------------------------';
        $mail->Body.= 'PRESERVE THESE STYLES IN THE HEAD';
        $mail->Body.= '------------------------------------- */';
        $mail->Body.= '@media all {';
        $mail->Body.= '.ExternalClass {';
        $mail->Body.= 'width: 100%;';
        $mail->Body.= '}';
        $mail->Body.= '.ExternalClass,';
        $mail->Body.= '.ExternalClass p,';
        $mail->Body.= '.ExternalClass span,';
        $mail->Body.= '.ExternalClass font,';
        $mail->Body.= '.ExternalClass td,';
        $mail->Body.= '.ExternalClass div {';
        $mail->Body.= 'line-height: 100%;';
        $mail->Body.= '}';
        $mail->Body.= '.apple-link a {';
        $mail->Body.= 'color: inherit !important;';
        $mail->Body.= 'font-family: inherit !important;';
        $mail->Body.= 'font-size: inherit !important;';
        $mail->Body.= 'font-weight: inherit !important;';
        $mail->Body.= 'line-height: inherit !important;';
        $mail->Body.= 'text-decoration: none !important;';
        $mail->Body.= '}';
        $mail->Body.= '#MessageViewBody a {';
        $mail->Body.= 'color: inherit;';
        $mail->Body.= 'text-decoration: none;';
        $mail->Body.= 'font-size: inherit;';
        $mail->Body.= 'font-family: inherit;';
        $mail->Body.= 'font-weight: inherit;';
        $mail->Body.= 'line-height: inherit;';
        $mail->Body.= '}';
        $mail->Body.= '.btn-primary table td:hover {';
        $mail->Body.= 'background-color: #34495e !important;';
        $mail->Body.= '}';
        $mail->Body.= '.btn-primary a:hover {';
        $mail->Body.= 'background-color: #34495e !important;';
        $mail->Body.= 'border-color: #34495e !important;';
        $mail->Body.= '}';
        $mail->Body.= '}';
        $mail->Body.= '';
        $mail->Body.= '</style>';
        $mail->Body.= '</head>';
        $mail->Body.= '<body class="">';
        // $mail->Body.= '<span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>';
        $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">';
        $mail->Body.= '<tr>';
        $mail->Body.= '<td>&nbsp;</td>';
        $mail->Body.= '<td class="container">';
        $mail->Body.= '<div class="content">';
        $mail->Body.= '';
        $mail->Body.= '<!-- START CENTERED WHITE CONTAINER -->';
        $mail->Body.= '<table role="presentation" class="main">';
        $mail->Body.= '';
        $mail->Body.= '<!-- START MAIN CONTENT AREA -->';
        $mail->Body.= '<tr>';
        $mail->Body.= '<td class="wrapper">';
        $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
        $mail->Body.= '<tr>';
        $mail->Body.= '<td>';
        $mail->Body.= '<center><img src="https://sso.ditp.go.th/sso/asset/img/sso-logo.png" alt="SSO Logo" width="120" border="0" style="border:0; outline:none; text-decoration:none; display:block;"></center><hr>';
        //$mail->Body.= "<p>เรียนคุณ {$name} {$lastname}</p>";
        $mail->Body.= '<p>ทาง DITP Single Sign-on ได้รับคำขอของคุณในการลบบัญชีผู้ใช้งาน</p>';
        $mail->Body.= '<p>กรุณาเอา OTP ที่ได้ไปยืนยัน</p>';
        $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
        $mail->Body.= '<tbody>';
        $mail->Body.= '<tr>';
        $mail->Body.= '<td align="center">';
        $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
        $mail->Body.= '<tbody>';
        $mail->Body.= '<tr>';
        //$mail->Body.= "<td><a>{$number}</a></td>"; $otp_pass
        $mail->Body.= "<td><center><h2>$otp_pass</h2></center></td>";
        $mail->Body.= '</tr>';
        $mail->Body.= '</tbody>';
        $mail->Body.= '</table>';
        $mail->Body.= '</td>';
        $mail->Body.= '</tr>';
        $mail->Body.= '</tbody>';
        $mail->Body.= '</table>';
        $mail->Body.= '<p>กรุณาดำเนินการภายใน 15 นาที หากคุณไม่ได้ส่งคำขอ ตามเวลาที่กำหนดระบบจะละเว้น email ฉบับนี้</p>';     
        $mail->Body.= '</td>';
        $mail->Body.= '</tr>';
        $mail->Body.= '</table>';
        $mail->Body.= '</td>';
        $mail->Body.= '</tr>';
        $mail->Body.= '';
        $mail->Body.= '<!-- END MAIN CONTENT AREA -->';
        $mail->Body.= '</table>';
        $mail->Body.= '<!-- END CENTERED WHITE CONTAINER -->';
        $mail->Body.= '';
        $mail->Body.= '';
        $mail->Body.= '</div>';
        $mail->Body.= '</td>';
        $mail->Body.= '<td>&nbsp;</td>';
        $mail->Body.= '</tr>';
        $mail->Body.= '</table>';
        $mail->Body.= '</body>';
        $mail->Body.= '</html>';
        $mail->Body.= '';
          
        if (!$this->validate_email($email)) {
          $text_email = explode("/", $email);
          $text_email2 = explode(",", $email);
          if(count($text_email) > 1){
              $email_list = '';
              foreach($text_email as $item){
                  if ($this->validate_email(trim($item))) {
                      $mail->AddAddress($item);
                      if ($mail->Send()){
                          $email_list.= substr_replace($item,"****",0,4)."<br>";
                          $mail->ClearAddresses();
                      } 
                  }
              }
              if($email_list != ''){
                $return = [
                  "status" => "00",
                  "message" => "success",
                  "email" => $email_list
                ];
              }
              
          }else if(count($text_email2) > 1){
              $email_list = '';
              foreach($text_email2 as $item){
                  if ($this->validate_email(trim($item))) {
                      $mail->AddAddress($item);
                      if ($mail->Send()){
                          $email_list.= substr_replace($item,"****",0,4)."<br>";
                          $mail->ClearAddresses();
                      } 
                  }
              }
              if($email_list != ''){
                $return = [
                  "status" => "00",
                  "message" => "success",
                  "email" => $email_list
                ];
              }
          }else{
            $return = [
              "status" => "01",
              "message" => "รูปแบบ Email ไม่ถูกต้อง"
            ];
            return $return;
          }
        }else{
          $mail->AddAddress(trim($email));
  
          if ($mail->Send()){
            $return = [
              "status" => "00",
              "message" => "success",
              "email" => substr_replace($email,"****",0,4)
            ];
          }else{
            $return = [
              "status" => "01",
              "message" => "ส่ง Email ไม่สำเร็จ"
            ];
          }
        }
        
      }else{
        $return = [
          "status" => "01",
          "message" => "ไม่พบบัญชี Email ในระบบ"
        ];
      }
      return $return;
    }
    function cancel_one($token,$client_id,$note){
     $get_info =  $this->get_info($client_id, 'Bearer '.$token );
      $member_id = null;
      $password = null;
      $type	= null;
      $register_from	= null;
      $status_update_drive	= null;
      $status	= null;
      $company_nameTh = null;
      $company_nameEn = null;
      $company_addressTh = null;
      $company_provinceTh = null;
      $company_districtTh = null;
      $company_subdistrictTh = null;
      $company_postcodeTh = null;
      $company_addressEn = null;
      $company_provinceEn = null;
      $company_districtEn = null;
      $company_subdistrictEn = null;
      $company_postcodeEn = null;
      $contact_address = null;
      $contact_province = null;
      $contact_district = null;
      $contact_subdistrict = null;
      $contact_postcode = null; 
      $member_title = null;
      $member_cid = null;
      $member_nameTh = null;
      $member_lastnameTh = null;
      $member_nameEn = null;
      $member_lastnameEn = null;
      $member_email = null;
      $member_tel = null;
      $member_tel_country = null;
      $member_tel_code = null;    
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => BASE_ONE.'cancel_member',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
          "ssoid":"'.$get_info['res_result']['ssoid'].'",
          "name":"'.$get_info['res_result']['sub_member']['nameTh'].'",
          "lastname":"'.$get_info['res_result']['sub_member']['lastnameTh'].'",
          "tel":"'.$get_info['res_result']['sub_member']['tel'].'",
          "email":"'.$get_info['res_result']['sub_member']['email'].'",
          "note":"'.$note.'",
          "status":"1"
      }',
        CURLOPT_HTTPHEADER => array(
          'token: '.$token.'',
          'Content-Type: application/json'
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);  
      $sql = "SELECT * FROM `tb_member` WHERE cid =  '".$get_info['res_result']['naturalId']."'  limit 1";
      $result = $this->query($sql);
      if(!empty($result)){
        $member_id = $result[0]['member_id'];
        $password = $result[0]['password'];
        $type	= $result[0]['type'];
        $register_from	= $result[0]['register_from'];
        $status	= $result[0]['status'];
        $status_update_drive	= $result[0]['status_update_drive'];
      }
      switch ($type) {
        case '1':
          $company_nameTh = $get_info['res_result']['company']['nameTh'];
          $company_nameEn = $get_info['res_result']['company']['nameEn'];
          $company_addressTh = $get_info['res_result']['addressTh']['address'];
          $company_provinceTh = $get_info['res_result']['addressTh']['province'];
          $company_districtTh = $get_info['res_result']['addressTh']['district'];
          $company_subdistrictTh = $get_info['res_result']['addressTh']['subdistrict'];
          $company_postcodeTh = $get_info['res_result']['addressTh']['postcode'];
          $company_addressEn = $get_info['res_result']['addressEn']['address'];
          $company_provinceEn = $get_info['res_result']['addressEn']['province'];
          $company_districtEn = $get_info['res_result']['addressEn']['district'];
          $company_subdistrictEn = $get_info['res_result']['addressEn']['subdistrict'];
          $company_postcodeEn = $get_info['res_result']['addressEn']['postcode'];
          $contact_address = $get_info['res_result']['contact']['address'];
          $contact_province = $get_info['res_result']['contact']['province'];
          $contact_district = $get_info['res_result']['contact']['district'];
          $contact_subdistrict = $get_info['res_result']['contact']['subdistrict'];
          $contact_postcode = $get_info['res_result']['contact']['postcode']; 
          $member_title = $get_info['res_result']['sub_member']['titleTh'];
          $member_cid = $get_info['res_result']['sub_member']['cid'];
          $member_nameTh = $get_info['res_result']['sub_member']['nameTh'];
          $member_lastnameTh = $get_info['res_result']['sub_member']['lastnameTh'];
          $member_nameEn = $get_info['res_result']['sub_member']['nameEn'];
          $member_lastnameEn = $get_info['res_result']['sub_member']['lastnameEn'];
          $member_email = $get_info['res_result']['sub_member']['email'];
          $member_tel = $get_info['res_result']['sub_member']['tel'];
          $member_tel_country = $get_info['res_result']['sub_member']['tel_country_code'];
          $member_tel_code = $get_info['res_result']['sub_member']['tel_code'];                 
          break;
        case '2':
          $company_nameTh = $get_info['res_result']['corporate']['name'];
          $company_nameEn = $get_info['res_result']['corporate']['name'];
          $company_addressTh = $get_info['res_result']['address']['address'];
          $company_provinceTh = $get_info['res_result']['address']['country'];
          $member_title = $get_info['res_result']['sub_member']['titleTh'];
          $member_cid = $get_info['res_result']['sub_member']['cid'];
          $member_nameTh = $get_info['res_result']['sub_member']['nameTh'];
          $member_lastnameTh = $get_info['res_result']['sub_member']['lastnameTh'];
          $member_nameEn = $get_info['res_result']['sub_member']['nameEn'];
          $member_lastnameEn = $get_info['res_result']['sub_member']['lastnameEn'];
          $member_email = $get_info['res_result']['sub_member']['email'];
          $member_tel = $get_info['res_result']['sub_member']['tel'];
          $member_tel_country = $get_info['res_result']['sub_member']['tel_country_code'];
          $member_tel_code = $get_info['res_result']['sub_member']['tel_code']; 
          break;
        case '3':
          $member_title = $get_info['res_result']['member']['titleTh'];
          $member_nameTh = $get_info['res_result']['member']['nameTh'];
          $member_lastnameTh = $get_info['res_result']['member']['lastnameTh'];
          $member_nameEn = $get_info['res_result']['member']['nameEn'];
          $member_lastnameEn = $get_info['res_result']['member']['lastnameEn'];
          $member_email = $get_info['res_result']['member']['email'];
          $member_tel = $get_info['res_result']['member']['tel'];
          $member_tel_country = $get_info['res_result']['member']['tel_country_code'];
          $member_tel_code = $get_info['res_result']['member']['tel_code'];
          $company_addressTh = $get_info['res_result']['addressTh']['address'];
          $company_provinceTh = $get_info['res_result']['addressTh']['province'];
          $company_districtTh = $get_info['res_result']['addressTh']['district'];
          $company_subdistrictTh = $get_info['res_result']['addressTh']['subdistrict'];
          $company_postcodeTh = $get_info['res_result']['addressTh']['postcode'];
          $company_addressEn = $get_info['res_result']['addressEn']['address'];
          $company_provinceEn = $get_info['res_result']['addressEn']['province'];
          $company_districtEn = $get_info['res_result']['addressEn']['district'];
          $company_subdistrictEn = $get_info['res_result']['addressEn']['subdistrict'];
          $company_postcodeEn = $get_info['res_result']['addressEn']['postcode'];
          break;
        case '4':
          $member_title = $get_info['res_result']['member']['titleTh'];
          $member_nameTh = $get_info['res_result']['member']['nameTh'];
          $member_lastnameTh = $get_info['res_result']['member']['lastnameTh'];
          $member_nameEn = $get_info['res_result']['member']['nameEn'];
          $member_lastnameEn = $get_info['res_result']['member']['lastnameEn'];
          $member_email = $get_info['res_result']['member']['email'];
          $member_tel = $get_info['res_result']['member']['tel'];
          $member_tel_country = $get_info['res_result']['member']['tel_country_code'];
          $member_tel_code = $get_info['res_result']['member']['tel_code'];
          $company_addressTh = $get_info['res_result']['address']['address'];
          $company_provinceTh = $get_info['res_result']['address']['country'];
          break;
        case '5':
          $member_title = $get_info['res_result']['member']['titleTh'];
          $member_nameTh = $get_info['res_result']['member']['nameTh'];
          $member_lastnameTh = $get_info['res_result']['member']['lastnameTh'];
          $member_nameEn = $get_info['res_result']['member']['nameEn'];
          $member_lastnameEn = $get_info['res_result']['member']['lastnameEn'];
          $member_email = $get_info['res_result']['member']['email'];
          $member_tel = $get_info['res_result']['member']['tel'];
          $member_tel_country = $get_info['res_result']['member']['tel_country_code'];
          $member_tel_code = $get_info['res_result']['member']['tel_code'];
          $company_addressTh = $get_info['res_result']['address']['address'];
          $company_provinceTh = $get_info['res_result']['address']['province'];
          $company_districtTh = $get_info['res_result']['address']['district'];
          $company_subdistrictTh = $get_info['res_result']['address']['subdistrict'];
          $company_postcodeTh = $get_info['res_result']['address']['postcode'];
          break;
        case '6':
          $company_nameTh = $get_info['res_result']['company']['nameTh'];
          $company_nameEn = $get_info['res_result']['company']['nameEn'];
          $company_addressTh = $get_info['res_result']['addressTh']['address'];
          $company_provinceTh = $get_info['res_result']['addressTh']['province'];
          $company_districtTh = $get_info['res_result']['addressTh']['district'];
          $company_subdistrictTh = $get_info['res_result']['addressTh']['subdistrict'];
          $company_postcodeTh = $get_info['res_result']['addressTh']['postcode'];
          $company_addressEn = $get_info['res_result']['addressEn']['address'];
          $company_provinceEn = $get_info['res_result']['addressEn']['province'];
          $company_districtEn = $get_info['res_result']['addressEn']['district'];
          $company_subdistrictEn = $get_info['res_result']['addressEn']['subdistrict'];
          $company_postcodeEn = $get_info['res_result']['addressEn']['postcode'];
          $contact_address = $get_info['res_result']['contact']['address'];
          $contact_province = $get_info['res_result']['contact']['province'];
          $contact_district = $get_info['res_result']['contact']['district'];
          $contact_subdistrict = $get_info['res_result']['contact']['subdistrict'];
          $contact_postcode = $get_info['res_result']['contact']['postcode']; 
          $member_title = $get_info['res_result']['sub_member']['titleTh'];
          $member_cid = $get_info['res_result']['sub_member']['cid'];
          $member_nameTh = $get_info['res_result']['sub_member']['nameTh'];
          $member_lastnameTh = $get_info['res_result']['sub_member']['lastnameTh'];
          $member_nameEn = $get_info['res_result']['sub_member']['nameEn'];
          $member_lastnameEn = $get_info['res_result']['sub_member']['lastnameEn'];
          $member_email = $get_info['res_result']['sub_member']['email'];
          $member_tel = $get_info['res_result']['sub_member']['tel'];
          $member_tel_country = $get_info['res_result']['sub_member']['tel_country_code'];
          $member_tel_code = $get_info['res_result']['sub_member']['tel_code'];  
          break;
      }
      $arr = [
        "sso_id" => $get_info['res_result']['ssoid'],	
        "member_id"	=> $member_id,
        "password"	=> $password,
        "type"	=> $type,
        "register_from"	=> $register_from,
        "status"	=> $status,
        "status_update_drive"	=> $status_update_drive,
        "company_nameTh" => $company_nameTh,	
        "company_nameEn" => $company_nameEn,	
        "company_addressTh" => $company_addressTh,	
        "company_provinceTh" => $company_provinceTh,	
        "company_districtTh" => $company_districtTh,	
        "company_subdistrictTh" => $company_subdistrictTh,	
        "company_postcodeTh" => $company_postcodeTh,	
        "company_addressEn" => $company_addressEn,	
        "company_provinceEn" => $company_provinceEn,	
        "company_districtEn" => $company_districtEn,	
        "company_subdistrictEn" => $company_subdistrictEn,	
        "company_postcodeEn" => $company_postcodeEn,	
        "contact_address" => $contact_address,	
        "contact_province" => $contact_province,	
        "contact_district" => $contact_district,	
        "contact_subdistrict" => $contact_subdistrict,	
        "contact_postcode" => $contact_postcode,	
        "member_title" => $member_title,	
        "member_cid" => $member_cid,	
        "member_nameTh" => $member_nameTh,	
        "member_lastnameTh" => $member_lastnameTh,	
        "member_nameEn" => $member_nameEn,	
        "member_lastnameEn" => $member_lastnameEn,	
        "member_email" => $member_email,	
        "member_tel" => $member_tel,	
        "member_tel_country" => $member_tel_country,	
        "member_tel_code" => $member_tel_code,	
      ];

        $this->update('cancel_member', $arr, ' cid="' . $get_info['res_result']['naturalId'] . '"');
        $sqlmember_type = "DELETE FROM tb_member_type$type WHERE tb_member_type$type.member_id = $member_id";
        $sqltb_member = "DELETE FROM `tb_member` WHERE `tb_member`.`member_id` = $member_id";
         $this->query($sqlmember_type);
        $this->query($sqltb_member);
      return  $response;   
    }
    function model_check_otp()
    {
        $cid = $this->post('cid');
        $otp_pass = $this->post('otp_pass');
        $token = $this->post('token');
        $client_id = $this->post('client_id');
        $sql = "SELECT * FROM `cancel_member` WHERE cid =  '".$cid."' and otp_pass = '".$otp_pass."' limit 1";
        $result = $this->query($sql);
            if(!empty($result)){
              if($result[0]['exp_date'] < date('Y-m-d H:i:s')){
                  $return = [
                    "status" => 200,
                    "message" => 'OTP expired'
                  ];
              }else{
                    $this->cancel_one($token,$client_id,$result[0]['remark']);
                    $this->update('tb_member', ['status'=>2], 'cid="' . $cid . '"');
                    $return = [
                      "status" => 200,
                      "message" => 'success'
                  ];
              }
            }else{
                $return = [
                  "status" => 200,
                  "message" => 'Not found'
                ];
            }
        return $return;
      }
      function model_restore_account()
      {
          $cid = $this->post('cid');
          $sql = "SELECT * FROM `tb_member` WHERE cid =  '".$cid."'  limit 1";
          $result = $this->query($sql);
              if(!empty($result)){
                      $this->update('tb_member', ['status'=>1], 'cid="' . $cid . '"');
                      $return = [
                        "status" => 200,
                        "message" => 'success'
                    ];
              }else{
                  $return = [
                    "status" => 200,
                    "message" => 'Not found'
                  ];
              }
          return $return;
        }
        function model_remarkCancel()
        {
            $cid = $this->post('cid');
            $remark = $this->post('remark');
            $sql = "SELECT * FROM `cancel_member` WHERE cid =  '".$cid."'  limit 1";
            $result = $this->query($sql);
                if(empty($result)){
                        $this->insert('cancel_member', ['cid' => $cid, 'remark' => $remark]);
                        $return = [
                          "status" => 200,
                          "message" => 'success'
                      ];
                }else{
                    $return = [
                      "status" => 200,
                      "message" => 'Not found'
                    ];
                }
            return $return;
          }
          function updateDBD($data,$reftext=''){
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => BASE_URL.'index.php/api/ck_com_dbd?cid='.$data['cid'].'',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'async: false',
                'Cookie: PHPSESSID=9dcso94grvcn91e52u22vh31q5'
              ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);
            (empty($response->ns0getDataResponse->return->arrayRRow->columns[4]->columnValue))? $company_nameTh = "": $company_nameTh = $response->ns0getDataResponse->return->arrayRRow->columns[4]->columnValue;
            (empty($response->ns0getDataResponse->return->arrayRRow->columns[5]->columnValue))? $company_nameEn = "": $company_nameEn = $response->ns0getDataResponse->return->arrayRRow->columns[5]->columnValue;
            if(!empty($reftext)){
            $array = $response->ns0getDataResponse->return->arrayRRow->childTables[2]->rows->columns;
            $arrays = $response->ns0getDataResponse->return->arrayRRow->childTables;

            $AMPUR = (empty($array[13]->columnValue)) ? '' : trim($array[13]->columnValue);
            $TUMBOL = (empty($array[12]->columnValue)) ? '' : trim($array[12]->columnValue);
            $sql = "SELECT dropdown_districts.*,dropdown_districts.id AS district_id, dropdown_districts.name_th AS district_name_th,T1.*,T2.*  FROM `dropdown_districts` 
                  LEFT JOIN (SELECT name_th AS amphure_name_th, name_en AS amphure_name_en, id AS amphure_id,province_id FROM dropdown_amphures) T1 ON T1.amphure_id = dropdown_districts.amphure_id
                  LEFT JOIN (SELECT name_th AS province_name_th, name_en AS province_name_en, id AS province_id FROM dropdown_provinces) T2 ON T2.province_id = T1.province_id
                  WHERE dropdown_districts.`name_th` LIKE '%$TUMBOL%' and amphure_name_th  LIKE '%$AMPUR%'";
            $result = $this->query($sql);
            $company_email = (isset($array[11]->columnValue))?$array[11]->columnValue:NULL;
            $company_tel_code = (isset($array[10]->columnValue))?'+66':NULL;
            $company_tel = (isset($array[10]->columnValue))?$array[10]->columnValue:NULL;
            $company_addressTh = $array[1]->columnValue;
            $company_provinceTh = $result[0]['province_name_th'];
            $company_districtTh = $result[0]['name_th'];
            $company_subdistrictTh = $result[0]['name_en'];
            $company_postcodeTh = $result[0]['zip_code'];
            $company_addressEn = NULL;//$array[1]->columnValue;
            $company_provinceEn = $result[0]['province_name_en'];
            $company_districtEn = $result[0]['name_en'];
            $company_subdistrictEn = $result[0]['amphure_name_en'];
            $company_postcodeEn = $result[0]['zip_code'];
            $data_insert_type1 = [
                'company_email' => $company_email,
                'company_tel' => $company_tel,
                'company_tel_code' => $company_tel_code,
                'company_nameTh' => $company_nameTh,
                'company_nameEn' => $company_nameEn,
                'company_addressTh' => $company_addressTh,
                'company_provinceTh' => $company_provinceTh,
                'company_districtTh' => $company_districtTh,
                'company_subdistrictTh' => $company_subdistrictTh,
                'company_postcodeTh' => $company_postcodeTh,
                'company_addressEn' => $company_addressEn,
                'company_provinceEn' => $company_provinceEn,
                'company_districtEn' => $company_districtEn,
                'company_subdistrictEn' => $company_subdistrictEn,
                'company_postcodeEn' => $company_postcodeEn,
              ];

          }else{
            $data_insert_type1 = [
              'company_nameTh' => $company_nameTh,
              'company_nameEn' => $company_nameEn,
            ];
          }
              $status_type1 = $this->update('tb_member_type1', $data_insert_type1, ' member_id="' . $data['member_id'] . '"');
              return  $status_type1;

          }

          function model_userinfo()
          {
            $refid = $this->post('refid');
            $reftext = $this->post('reftext');
            if(empty($refid)){
                 $_POST = json_decode(file_get_contents("php://input"), 1);
                 $refid = $_POST['refid'];
            }
 
            $sqltb_member = "SELECT * FROM `tb_member` WHERE `cid` =  '".$refid."'";
            $query= $this->query($sqltb_member);
            if(!empty($query)){
              if($query[0]['type'] == '1'){
                $updateDBD = $this->updateDBD($query[0],$reftext);
              }
              $sqlmember_type = "SELECT * FROM `tb_member_type".$query[0]['type']."` WHERE `member_id` =  ".$query[0]['member_id']."";
              $querytype = $this->query($sqlmember_type);
                if(!empty($querytype)){
                    if(($query[0]['type'] == 1) || ($query[0]['type'] == 6)){
                      $querytype[0]['company_cid'] = $query[0]['cid'];
                    }else{
                      $querytype[0]['member_cid'] = $query[0]['cid'];
                    }
                    $querytype[0]['verify'] = [
                    "status_laser_verify" => ($query[0]['status_laser_verify'] == '1')? true :false,
                    "status_email_verify" => ($query[0]['status_email_verify'] == '1')? true :false,
                    "status_sms_verify" => ($query[0]['status_sms_verify'] == '1')? true :false,
                  ];

                  $return = [
                    "status" => 200,
                    "result" => $querytype[0],
                  ];
                }else{
                  $return = [
                    "status" => 400,
                    "message" => "Not found",
                  ];
                }
            }else{
                $return = [
                  "status" => 400,
                  "message" => "Not found",
                ];
            }
            return $return;
          }

          function model_userinfo_portal()
          {
            $refid = $this->post('refid');
            $sqltb_member = "SELECT * FROM `tb_member` WHERE `sso_id` =  '".$refid."'";
            $query= $this->query($sqltb_member);
            if(!empty($query)){
              $sqlmember_type = "SELECT * FROM `tb_member_type".$query[0]['type']."` WHERE `member_id` =  ".$query[0]['member_id']."";
              $querytype = $this->query($sqlmember_type);
                if(!empty($querytype)){
                  $return = [
                    "status" => 200,
                    "result" => $querytype[0],
                  ];
                }else{
                  $return = [
                    "status" => 400,
                    "message" => "Not found",
                  ];
                }
            }else{
                $return = [
                  "status" => 400,
                  "message" => "Not found",
                ];
            }
            return $return;
          }
  



  function get_info_portal($client_id = '', $code = '')
  {
    #save log
    // $param = [
    //   'code' => $code,
    //   'client_id' => $client_id,
    // ];
    // $this->save_log_call_api(json_encode($param), $client_id);
    $return = ['res_code' => '01', 'res_text' => 'Data Not Found.'];
    $sql_m = 'SELECT * FROM tb_merchant where client_id="' . mysqli_real_escape_string($this->db, $client_id) . '" and status = 1 limit 1';
    $query = $this->query($sql_m);

    if (count($query) > 0) {
      $data = $query[0];
      $key = $data['jwt_signature'];
      //decode JWT//
      $sub_code = explode(' ', $code);

      if (count($sub_code) > 1) {
        if ($sub_code[0] == 'Bearer' && $sub_code[1]) {
          try {
            $decoded = JWT::decode($sub_code[1], $key, array('HS256'));
            // var_dump($decoded);
            // die();
            if (empty($decoded->id_token)) {
              $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
            } else {
              $id_token  = $decoded->id_token;
            }
          } catch (Exception $e) {

            $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
          }
        }
      } else {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
      }
      ////////////////
      if (empty($id_token)) {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
      } else {
        $sql = "SELECT * FROM tb_token WHERE client_id='" . $client_id . "' AND token_code='" . $id_token . "' limit 1 ";
        $query_token = $this->query($sql);
        if (count($query_token) > 0) {
          $tokendata =  $query_token[0];
          if ($tokendata['exp_date'] < date('Y-m-d H:i:s')) { //token หมดอายุ
            $return = ['res_code' => '01', 'res_text' => 'Access_code Expire'];
          } else {

            $sql_m = 'SELECT * FROM tb_member WHERE member_id="' . $tokendata['member_id'] . '" and status = 1 limit 1';
            $query_m = $this->query($sql_m);

            if (count($query_m) > 0) {

              $data_m = $query_m[0];
              // return $data_m;
              $update['update'] = [
                "update_date" => (empty($data_m['update_date']))? '': $data_m['update_date'] ,
                "system_update" => (empty($data_m['system_update']))? '': $data_m['system_update']
              ];
              $type = $data_m['type'];
              if($client_id == 'SS0047423'){ // App one

                //-- care --//
                $sql_care = "SELECT * FROM tb_member_app_id WHERE member_id='" . $tokendata['member_id']."' AND client_id = 'ssocareid'";
                $query_care = $this->query($sql_care);
                if(count($query_care)>0){
                  $data_care = $query_care[0];
                  $user_care = $data_care['member_id_app'];
                }else{ $user_care = '';}

                //-- drive --//
                $sql_drive = "SELECT * FROM tb_member_app_id WHERE member_id='" . $tokendata['member_id']."' AND client_id = 'ssonticlient'";
                $query_drive = $this->query($sql_drive);
             
                if(count($query_drive)>0){
                  $data_drive = $query_drive[0];
                  $user_drive = $data_drive['member_id_app'];
                }else{ $user_drive = '';}

                //-- connect --//
                $sql_con = "SELECT * FROM tb_member_app_id WHERE member_id='" . $tokendata['member_id']."' AND client_id = 'SS6931846'";
                $query_con = $this->query($sql_con);
                if(count($query_con)>0){
                  $data_con = $query_con[0];
                  $user_con = $data_con['member_id_app'];
                }else{ $user_con= ''; }

                ///------- Auto Login care -----------///
                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => BASE_CARE.'autoreg_sso.php',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
                    "member_cid":"'.$data_m['cid'].'",
                    "ssoid":"'.$data_m['sso_id'].'"
                }',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Cookie: PHPSESSID=2gj9nhqqki5bvgktgf5ula5qt6'
                  ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);       
                $json = json_decode($response);
                if(isset($json->res_result)){
                  $ck_memberCare = "SELECT * FROM `tb_token_external` WHERE `member_id` = '".$data_m['member_id']."' AND `member_type` = 'CARE'";
                  $query_memberCare = $this->query($ck_memberCare);
                 if(count($query_memberCare) < 1){
                  $auto = "INSERT INTO `tb_token_external`(`member_id`,`member_id_app`,`member_type`) VALUES ('".$data_m['member_id']."','".$json->res_result->member_id."','CARE')";
                  if ($this->query($auto) === FALSE ) {
                    echo "Failed to connect to MySQL: " . $this->error;
                    die();
                    } 
                  }else{
                    $sql = "UPDATE tb_token_external SET member_id_app = '".$json->res_result->member_id."'  WHERE member_id = '".$data_m['member_id']."' AND `member_type` = 'CARE'";
                    if ($this->query($sql) === FALSE) {
                      echo json_encode("Error updating record: " . $conn->error);
                      } 
                  }
                }
                //--- token care ---//
                $sql_tcare = "SELECT * FROM tb_token_external WHERE member_id='" . $tokendata['member_id']."' AND member_type = 'CARE' ORDER BY id DESC limit 0,1";
                $query_tcare = $this->query($sql_tcare);
              
                if(count($query_tcare)>0){
                  $data_tcare = $query_tcare[0];
                  $token_care = $data_tcare['token_code'];
                  $user_care2 = $data_tcare['member_id_app'];
                  
                }else{ $token_care= ''; }

                //--- token touch ---//
                $sql_tconnect = "SELECT * FROM tb_token_external WHERE member_id='" . $tokendata['member_id']."' AND member_type = 'TOUCH' ORDER BY id DESC limit 0,1";
                $query_tconnect = $this->query($sql_tconnect);
                if(count($query_tconnect)>0){
                  $data_tconnect = $query_tconnect[0];
                  $token_connect = $data_tconnect['token_code'];
                }else{ $token_connect= ''; }

                $result = [
                  'ssoid' => $data_m['sso_id'],
                  'naturalId' => $data_m['cid'],
                  'type' => $type,
                  'userID_drive' => $user_drive,
                  'userID_care' => $user_care2,
                  'userID_connect' => $user_con,

                  'token_care' => $token_care,
                  'token_connect' => $token_connect
                ];
                
              }else{

                $result = [
                  'ssoid' => $data_m['sso_id'],
                  'naturalId' => $data_m['cid'],
                  'type' => $type,
                  'status_contact_nationality' => $data_m['status_contact_nationality'],
                ];
                $data_s = [];
              }
             
              //------- check update_drive ------------//
              $sql_d = "SELECT 1 FROM Member_drive_v3 WHERE Username = '$data_m[cid]'";
              $result_d = $this->query($sql_d);
              $result_drive = "";
              if(count($result_d) >0){
                
                $sql_d2 = "SELECT 1 FROM tb_member WHERE cid = '$data_m[cid]' AND status_update_drive = 'N'";
                $result_d2 = $this->query($sql_d2);

                  if(count($result_d2) > 0){
                    
                    $result_drive = '';
                    try{
                      $result_drive = $this->get_info_drive($data_m['cid']);
                    } catch (Exception $e){
                     
                    }
                    $data_drive = $this->get_info_drive($data_m['cid']);


                    
                    $result_drive = json_decode($data_drive,1);
       
                    if($result_drive != '' && $result_drive['code'] == "200" && $result_drive['message'] == "OK"){
                     
                      if($type == '1' && $result_drive['UserType'] == "company"){
                        $data_update_type1 = [
                          'company_nameTh' => $result_drive['CorporateNameTH'],
                          'company_nameEn' => $result_drive['CorporateNameEN'],

                          'company_addressTh' => $result_drive['User_Address']['AddressTH'],
                          'company_provinceTh' => $result_drive['User_Address']['Province']['name'],
                          'company_districtTh' => $result_drive['User_Address']['District']['name'],
                          'company_subdistrictTh' => $result_drive['User_Address']['SubDistrict']['name'],
                          'company_postcodeTh' => $result_drive['User_Address']['PostCode'],

                          'company_addressEn' => $result_drive['User_Address']['AddressEN'],
                          'company_provinceEn' => $result_drive['User_Address']['Province']['nameEN'],
                          'company_districtEn' => $result_drive['User_Address']['District']['nameEN'],
                          'company_subdistrictEn' => $result_drive['User_Address']['SubDistrict']['nameEN'],
                          'company_postcodeEn' => $result_drive['User_Address']['PostCode'],

                          'contact_address' => $result_drive['User_Address']['AddressTH'],
                          'contact_province' => $result_drive['User_Address']['Province']['name'],
                          'contact_district' => $result_drive['User_Address']['District']['name'],
                          'contact_subdistrict' => $result_drive['User_Address']['SubDistrict']['name'],
                          'contact_postcode' => $result_drive['User_Address']['PostCode'],

                          'member_title' => $result_drive['User_Contact']['Title']['name'],
                          //'member_cid' => $result_drive[''],
                          'member_nameTh' => $result_drive['User_Contact']['FirstNameTH'],
                          'member_lastnameTh' => $result_drive['User_Contact']['LastNameTH'],
                          'member_nameEn' => $result_drive['User_Contact']['FirstNameEN'],
                          'member_lastnameEn' => $result_drive['User_Contact']['LastNameEN'],
                          'member_email' => $result_drive['Mail'],
                          'member_tel' => $result_drive['User_Contact']['Contact_Tel'],
                          'member_tel_country' => "TH",
                                  'member_tel_code' => "+66"
                        ];
                        try{
                          $this->update('tb_member_type1', $data_update_type1, "member_id ='$tokendata[member_id]'");
                          $this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
                        } catch (Exception $e){
              
                        }
                        

                      }else if($type == '2' && $result_drive['UserType'] == "company"){
                        $data_update_type2 = [
                          'corporate_name' =>  $result_drive['CorporateNameEN'],
                          'country' => $result_drive['User_Address']['Country']['nameEN'],
                          'address' => $result_drive['User_Address']['AddressEN'],
                          //'member_title' => $result_drive,
                          //'member_nameTh' => $result_drive,
                          //'member_lastnameTh' => $result_drive,
                          //'member_nameEn' => $result_drive,
                          //'member_lastnameEn' => $result_drive,
                          'email' => $result_drive['Mail'],
                          'tel' => $result_drive['Tel'],
                          //'tel_country' => "TH",
                          //'tel_code' => "+66"
                        ];
                        try{
                          $this->update('tb_member_type2', $data_update_type2, "member_id ='$tokendata[member_id]'");
                          $this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
                        } catch (Exception $e){
              
                        }
                        

                      }else if($type == '3' && $result_drive['UserType'] == "individual"){
                        # บุคคล ไทย
                       
                        $data_update_type3 = [
                          'member_title' => $result_drive['Title']['name'],
                          'member_nameTh' => $result_drive['FirstNameTH'],
                          'member_lastnameTh' => $result_drive['LastNameTH'],
                          'member_nameEn' => $result_drive['FirstNameEN'],
                          'member_lastnameEn' => $result_drive['LastNameEN'],
                          'email' => $result_drive['Mail'],
                          'tel' => $result_drive['Tel'],
                          'tel_country' => "TH",
                          'tel_code' => "+66",
                          'addressTh' => $result_drive['User_Address']['AddressTH'],
                          'provinceTh' => $result_drive['User_Address']['Province']['name'],
                          'districtTh' => $result_drive['User_Address']['District']['name'],
                          'subdistrictTh' => $result_drive['User_Address']['SubDistrict']['name'],
                          'postcode' => $result_drive['User_Address']['PostCode'],

                          'addressEn' => $result_drive['User_Address']['AddressEN'],
                          'provinceEn' => $result_drive['User_Address']['Province']['nameEN'],
                          'districtEn' => $result_drive['User_Address']['District']['nameEN'],
                          'subdistrictEn' => $result_drive['User_Address']['SubDistrict']['nameEN']
                        ];
                        try{
                          $this->update('tb_member_type3', $data_update_type3, "member_id ='$tokendata[member_id]'");
                          $this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
                        } catch (Exception $e){
              
                        }
                        

                      }else if($type == '4' && $result_drive['UserType'] == "individual"){
                        # บุคคล ต่างชาติ
                        $data_update_type4 = [
                          'member_title' => $result_drive['Title']['nameEN'],
                          'member_nameTh' => $result_drive['FirstNameTH'],
                          'member_lastnameTh' => $result_drive['LastNameTH'],
                          'member_nameEn' => $result_drive['FirstNameEN'],
                          'member_lastnameEn' => $result_drive['LastNameEN'],
                          'country' => $result_drive['User_Address']['Country']['nameEN'],
                          'address' => $result_drive['User_Address']['AddressEN'],
                          'email' => $result_drive['Mail'],
                          'tel' => $result_drive['Tel'],
                          //'tel_country' => strtoupper($tel_country),
                          //'tel_code' => "+".$tel_code
                        ];
                        try{
                          $this->update('tb_member_type4', $data_update_type4, "member_id ='$tokendata[member_id]'");
                          $this->update('tb_member', ['status_update_drive'=>'Y'], "member_id ='$tokendata[member_id]'");
                        } catch (Exception $e){
              
                        }
                        
                      }
                    }
                }
                
              }

              switch ($type) {
                case '1':
                  # update ข้อมูลส่วนตัว

                  # นิติบุคคล ไทย

                  $sql_m = 'SELECT * FROM tb_member_type1 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }

                  $detail['company'] = [
                    "nameTh" => (empty($data_m['company_nameTh']))? '': $data_m['company_nameTh'] ,
                    "nameEn" => (empty($data_m['company_nameEn']))? '': $data_m['company_nameEn']
                  ];
                  $detail['addressTh'] = [
                    "address" => (empty($data_m['company_addressTh']))? '': $data_m['company_addressTh'],
                    "province" => (empty($data_m['company_provinceTh']))? '': $data_m['company_provinceTh'],
                    "district" => (empty($data_m['company_districtTh']))? '':$data_m['company_districtTh'],
                    "subdistrict" => (empty($data_m['company_subdistrictTh']))? '':$data_m['company_subdistrictTh'],
                    "postcode" => (empty($data_m['company_postcodeTh']))? '':$data_m['company_postcodeTh']
                  ];
                  $detail['addressEn'] = [
                    "address" => (empty($data_m['company_addressEn']))? '': $data_m['company_addressEn'],
                    "province" => (empty($data_m['company_provinceEn']))? '': $data_m['company_provinceEn'],
                    "district" => (empty($data_m['company_districtEn']))? '': $data_m['company_districtEn'],
                    "subdistrict" => (empty($data_m['company_subdistrictEn']))? '': $data_m['company_subdistrictEn'],
                    "postcode" => (empty($data_m['company_postcodeEn']))? '':$data_m['company_postcodeEn'] ,
                  ];
                  $detail['contact'] = [
                    "address" => (empty($data_m['contact_address']))? '': $data_m['contact_address'],
                    "province" => (empty($data_m['contact_province']))? '': $data_m['contact_province'],
                    "district" => (empty($data_m['contact_district']))? '': $data_m['contact_district'],
                    "subdistrict" => (empty($data_m['contact_subdistrict']))? '': $data_m['contact_subdistrict'],
                    "postcode" => (empty($data_m['contact_postcode']))? '': $data_m['contact_postcode'],
                  ];

                  $titleEn = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'นาย'){
                      $titleEn = 'Mr.';
                    }else if($data_m['member_title'] == 'นาง'){
                      $titleEn = 'Mrs.';
                    }elseif($data_m['member_title'] == 'นางสาว'){
                      $titleEn = 'Miss';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['member_tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }

                  $detail['sub_member'] = [
                    "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                    "titleEn" => $titleEn,
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "cid" => (empty($data_m['member_cid']))? '': $data_m['member_cid'],
                    "email" => (empty($data_m['member_email']))? '': $data_m['member_email'],
                    "tel" => (empty($data_m['member_tel']))? '': $data_m['member_tel'],
                    //"tel_code" => (empty($data_m['member_tel_code']))? '': $data_m['member_tel_code'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['member_tel_country']))? '': $data_m['member_tel_country'],
                    "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['member_tel_country'].".png"
                  ];

                  break;
                case '2':
                  # นิติบุคคล ต่างชาติ
                  $sql_m = 'SELECT * FROM tb_member_type2 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }
                  $detail['corporate'] = [
                    "name" => (empty($data_m['corporate_name']))? '': $data_m['corporate_name'],

                  ];
                  $detail['address'] = [
                    "country" => (empty($data_m['country']))? '': $data_m['country'],
                    "address" => (empty($data_m['address']))? '': $data_m['address'],
                  ];
                  $titleTh = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'Mr.'){
                      $titleTh = 'นาย';
                    }else if($data_m['member_title'] == 'Mrs.'){
                      $titleTh = 'นาง';
                    }elseif($data_m['member_title'] == 'Miss'){
                      $titleTh = 'นางสาว';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }

                  $detail['sub_member'] = [
                    "titleTh" => $titleTh,
                    "titleEn" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "email" => (empty($data_m['email']))? '': $data_m['email'],
                    "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
                    //"tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
                    "tel_icon_country" => (empty($data_m['tel_country']))? '' : BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
                  ];

                  break;
                case '3':
                  # บุคคล ไทย
                  $sql_m = 'SELECT * FROM tb_member_type3 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }

                  $titleEn = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'นาย'){
                      $titleEn = 'Mr.';
                    }else if($data_m['member_title'] == 'นาง'){
                      $titleEn = 'Mrs.';
                    }else if($data_m['member_title'] == 'นางสาว'){
                      $titleEn = 'Miss';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }

                  $detail['member'] = [
                    "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                    "titleEn" => $titleEn,
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "email" => (empty($data_m['email']))? '': $data_m['email'],
                    "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
                    //"tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
                    "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
                  ];
                  $detail['addressTh'] = [
                    "address" => (empty($data_m['addressTh']))? '': $data_m['addressTh'],
                    "province" => (empty($data_m['provinceTh']))? '': $data_m['provinceTh'],
                    "district" => (empty($data_m['districtTh']))? '': $data_m['districtTh'],
                    "subdistrict" => (empty($data_m['subdistrictTh']))? '': $data_m['subdistrictTh'],
                    "postcode" => (empty($data_m['postcode']))? '': $data_m['postcode'],
                  ];
                  $detail['addressEn'] = [
                    "address" => (empty($data_m['addressEn']))? '': $data_m['addressEn'],
                    "province" => (empty($data_m['provinceEn']))? '': $data_m['provinceEn'],
                    "district" => (empty($data_m['districtEn']))? '': $data_m['districtEn'],
                    "subdistrict" => (empty($data_m['subdistrictEn']))? '': $data_m['subdistrictEn'],
                    "postcode" => (empty($data_m['postcode']))? '': $data_m['postcode'],
                  ];

                  break;
                case '4':
                  # บุคคล ต่างชาติ
                  $sql_m = 'SELECT * FROM tb_member_type4 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }

                  $titleTh = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'Mr.'){
                      $titleTh = 'นาย';
                    }else if($data_m['member_title'] == 'Mrs.'){
                      $titleTh = 'นาง';
                    }elseif($data_m['member_title'] == 'Miss'){
                      $titleTh = 'นางสาว';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }

                  $detail['member'] = [
                    "titleTh" => $titleTh,
                    "titleEn" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "email" => (empty($data_m['email']))? '': $data_m['email'],
                    "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
                    //"tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
                    "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
                  ];
                  $detail['address'] = [
                    "country" => (empty($data_m['country']))? '': $data_m['country'],
                    "address" => (empty($data_m['address']))? '': $data_m['address'],
                  ];

                  break;

                case '5':
                  # อื่นๆ
                  $sql_m = 'SELECT * FROM tb_member_type5 WHERE member_id = "' . $tokendata['member_id'] . '"';
                  $query_m = $this->query($sql_m);
                  $data_m = [];
                  if (count($query_m) > 0) {
                    $data_m = $query_m[0];
                  }

                  $titleEn = '';
                  if(!empty($data_m['member_title'])){ 
                    if($data_m['member_title'] == 'นาย'){
                      $titleEn = 'Mr.';
                    }else if($data_m['member_title'] == 'นาง'){
                      $titleEn = 'Mrs.';
                    }elseif($data_m['member_title'] == 'นางสาว'){
                      $titleEn = 'Miss';
                    }
                  }

                  $member_tel_code = '';
                  $data_tel_code = $data_m['tel_code'];
                  if(!empty($data_tel_code)){
                    if(strstr($data_tel_code,'+')) //found
                      $member_tel_code = $data_tel_code;
                    else
                      $member_tel_code = "+".$data_tel_code; 
                  }

                  $detail['member'] = [
                    "titleTh" => $data_m['member_title'],
                    "titleEn" => $titleEn,
                    "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                    "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                    "nameEn" => '', //(empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                    "lastnameEn" => '', //(empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                    "email" => (empty($data_m['email']))? '': $data_m['email'],
                    "tel" => (empty($data_m['tel']))? '': $data_m['tel'],
                    //"tel_code" => (empty($data_m['tel_code']))? '': $data_m['tel_code'],
                    "tel_code" => $member_tel_code,
                    "tel_country_code" => (empty($data_m['tel_country']))? '': $data_m['tel_country'],
                    "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['tel_country'].".png"
                  ];
                  $detail['address'] = [
                    "address" => (empty($data_m['addressTh']))? '': $data_m['addressTh'],
                    "province" => (empty($data_m['provinceTh']))? '': $data_m['provinceTh'],
                    "district" => (empty($data_m['districtTh']))? '': $data_m['districtTh'],
                    "subdistrict" => (empty($data_m['subdistrictTh']))? '': $data_m['subdistrictTh'],
                    "postcode" => (empty($data_m['postcode']))? '': $data_m['postcode'],
                  ];

                  break;
                  case '6':
  
                    # นิติบุคคลที่ยังไม่จดทะเบียน ไทย
  
                    $sql_m = 'SELECT * FROM tb_member_type6 WHERE member_id = "' . $tokendata['member_id'] . '"';
                    $query_m = $this->query($sql_m);
                    $data_m = [];
                    if (count($query_m) > 0) {
                      $data_m = $query_m[0];
                    }
  
                    $detail['company'] = [
                      "nameTh" => (empty($data_m['company_nameTh']))? '': $data_m['company_nameTh'] ,
                      "nameEn" => (empty($data_m['company_nameEn']))? '': $data_m['company_nameEn']
                    ];
                    $detail['addressTh'] = [
                      "address" => (empty($data_m['company_addressTh']))? '': $data_m['company_addressTh'],
                      "province" => (empty($data_m['company_provinceTh']))? '': $data_m['company_provinceTh'],
                      "district" => (empty($data_m['company_districtTh']))? '':$data_m['company_districtTh'],
                      "subdistrict" => (empty($data_m['company_subdistrictTh']))? '':$data_m['company_subdistrictTh'],
                      "postcode" => (empty($data_m['company_postcodeTh']))? '':$data_m['company_postcodeTh']
                    ];
                    $detail['addressEn'] = [
                      "address" => (empty($data_m['company_addressEn']))? '': $data_m['company_addressEn'],
                      "province" => (empty($data_m['company_provinceEn']))? '': $data_m['company_provinceEn'],
                      "district" => (empty($data_m['company_districtEn']))? '': $data_m['company_districtEn'],
                      "subdistrict" => (empty($data_m['company_subdistrictEn']))? '': $data_m['company_subdistrictEn'],
                      "postcode" => (empty($data_m['company_postcodeEn']))? '':$data_m['company_postcodeEn'] ,
                    ];
                    $detail['contact'] = [
                      "address" => (empty($data_m['contact_address']))? '': $data_m['contact_address'],
                      "province" => (empty($data_m['contact_province']))? '': $data_m['contact_province'],
                      "district" => (empty($data_m['contact_district']))? '': $data_m['contact_district'],
                      "subdistrict" => (empty($data_m['contact_subdistrict']))? '': $data_m['contact_subdistrict'],
                      "postcode" => (empty($data_m['contact_postcode']))? '': $data_m['contact_postcode'],
                    ];
  
                    $titleEn = '';
                    if(!empty($data_m['member_title'])){ 
                      if($data_m['member_title'] == 'นาย'){
                        $titleEn = 'Mr.';
                      }else if($data_m['member_title'] == 'นาง'){
                        $titleEn = 'Mrs.';
                      }elseif($data_m['member_title'] == 'นางสาว'){
                        $titleEn = 'Miss';
                      }
                    }
  
                    $member_tel_code = '';
                    $data_tel_code = $data_m['member_tel_code'];
                    if(!empty($data_tel_code)){
                      if(strstr($data_tel_code,'+')) //found
                        $member_tel_code = $data_tel_code;
                      else
                        $member_tel_code = "+".$data_tel_code; 
                    }
  
                    $detail['sub_member'] = [
                      "titleTh" => (empty($data_m['member_title']))? '': $data_m['member_title'],
                      "titleEn" => $titleEn,
                      "nameTh" => (empty($data_m['member_nameTh']))? '': $data_m['member_nameTh'],
                      "lastnameTh" => (empty($data_m['member_lastnameTh']))? '': $data_m['member_lastnameTh'],
                      "nameEn" => (empty($data_m['member_nameEn']))? '': $data_m['member_nameEn'],
                      "lastnameEn" => (empty($data_m['member_lastnameEn']))? '': $data_m['member_lastnameEn'],
                      "cid" => (empty($data_m['member_cid']))? '': $data_m['member_cid'],
                      "email" => (empty($data_m['member_email']))? '': $data_m['member_email'],
                      "tel" => (empty($data_m['member_tel']))? '': $data_m['member_tel'],
                      //"tel_code" => (empty($data_m['member_tel_code']))? '': $data_m['member_tel_code'],
                      "tel_code" => $member_tel_code,
                      "tel_country_code" => (empty($data_m['member_tel_country']))? '': $data_m['member_tel_country'],
                      "tel_icon_country" => BASE_URL."asset/img/flags/".$data_m['member_tel_country'].".png"
                    ];
  
                    break;
                default:
                  # ไม่มี 
                  $detail = [];
                  break;
              }
            }
            $return_data = array_merge($result, $detail, $update);
            $return = ['res_code' => '00', 'res_text' => 'success !', 'res_result' => $return_data];
          }
        } else {
          $return = ['res_code' => '01', 'res_text' => 'Token Not Found.'];
        }
      }
    } else {
      $return = ['res_code' => '01', 'res_text' => 'Client_ID Not Found.'];
    }

    return $return;
  }    
  function model_send_mail_verify(){
      $return = [
        "status" => "01",
        "message" => "ดำเนินการไม่สำเร็จ"
      ];
      $member_id = $this->post('member_id');
      $target = $this->post('target');
      $email = $this->post('email');
      $tel = $this->post('tel');
      if($email != ""){
          if($email != "" && $member_id !="" && $target != ""){
            $number = mt_rand(1000,9999);
            $_SESSION['id'] = $member_id;
            $_SESSION['email'] = $email;
            $_SESSION['target'] = $target;
            $_SESSION['number'] = $number;
            $_SESSION['status_reset'] = true;
            $token_verify = sha1($member_id . date('YmhHis'));
            $exp_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+15 minutes"));
            $ref_codes = substr(str_shuffle("1234567890"), 0, 6);
            $ref_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 6);
            //-- เคลียร์ Token เก่า --// 
            $this->update('tb_token_verify', ['status'=>'1'], "member_id ='$member_id'");
            //-- insert tb_token_reset --//
            $data_token_verify = [
              'token_verify' => $token_verify,
              'ref_code' => $ref_codes,
              'member_id' => $member_id,
              'target' => $target,
              'redirect_uri' => ($_SESSION['redirect_uri'])?$_SESSION['redirect_uri']:"ditpone://my-host/callback",
              'response_type' => ($_SESSION['response_type'])?$_SESSION['response_type']:"token",
              'client_id' => ($_SESSION['client_id'])?$_SESSION['client_id']:"SS0047423",
              'state' => ($_SESSION['state'])?$_SESSION['state']:"email",
              'status' => '0',
              'exp_date' => $exp_date
            ];
            $insert = $this->insert('tb_token_verify', $data_token_verify);
            $_SESSION['ref_code'] = $ref_codes;
            // ----- Google SMTP ----- //
            // $mail = new PHPMailer();
            // $mail->isSMTP();
            // $mail->SMTPDebug = 0;
            // $mail->SMTPAuth = true;
            // $mail->SMTPSecure = "tls";
            // $mail->Host = "smtp.gmail.com"; // ถ้าใช้ smtp ของ server เป็นอยู่ในรูปแบบนี้ mail.domainyour.com
            // $mail->Port = 587;
            // $mail->isHTML();
            // $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
            // $mail->Username = "kittiporn.s@ibusiness.co.th"; //กรอก Email Gmail หรือ เมลล์ที่สร้างบน server ของคุณเ
            // $mail->Password = "0856225746"; // ใส่รหัสผ่าน email ของคุณ
            // $mail->SetFrom = ('kittiporn.s@ibusiness.co.th'); //กำหนด email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง
            // $mail->FromName = "DITP SSO"; //ชื่อที่ใช้ในการส่ง
            // $mail->Subject = "รีเซ็ตรหัสผ่าน DITP SSO";  //หัวเรื่อง emal ที่ส่ง
            
            // $mail = new PHPMailer(true);
            // try {
            //     $mail->isSMTP();
            //     $mail->Host = 'in-v3.mailjet.com'; // host
            //     $mail->SMTPAuth = true;
            //     $mail->Username = 'API_KEY'; //username
            //     $mail->Password = 'SECRET_KEY'; //password
            //     $mail->SMTPSecure = 'tls';
            //     $mail->Port = 587; //smtp port
                
            //     $mail->setFrom('SENDER_EMAIL_ADDRESS', 'SENDER_NAME');
            //     $mail->addAddress('RECIPIENT_EMAIL_ADDRESS', 'RECIPIENT_NAME');
              
            //     $mail->isHTML(true);
            //     $mail->Subject = 'Email Subject';
            //     $mail->Body    = '<b>Email Body</b>';
              
            //     $mail->send();
            //     echo 'Email sent successfully.';
            // } catch (Exception $e) {
            //     echo 'Email could not be sent. Mailer Error: '. $mail->ErrorInfo; in-v3.mailjet.com mgtrelay01.mail.go.th
            // }
            
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = 0;
            $mail->SMTPSecure = "tlsv1.2";
            $mail->Host = Host_Mailjet;
            $mail->Port = 587;
            $mail->isHTML();
            $mail->CharSet = "utf-8";
            $mail->Username = USERNAME_Mailjet;
            $mail->Password = PASSWORD_Mailjet;
    
            $mail->From = ('sso@ditp.go.th');
            $mail->FromName = "DITP Single Sign-on";
            $mail->Subject = "การยืนยันตัวตนผ่านระบบ DITP SSO ของกรมส่งเสริมการค้าระหว่างประเทศ";
    
            $mail->Body .= '<!DOCTYPE html>';
            $mail->Body .= '<html lang="en">';
            $mail->Body .= '<head>';
            $mail->Body .= '<meta name="viewport" content="width=device-width" />';
            $mail->Body .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            $mail->Body .= '<title>SSO DITP Email Verification</title>';
            $mail->Body .= '</head>';
            $mail->Body .= '<body>';
            $mail->Body .= '<div class="container" style="display: flex;justify-content: center;">';
            $mail->Body .= '<div  style="max-width: 740px;width:100%;padding: 1rem;">';
            $mail->Body .= '<div style="background:linear-gradient(318.86deg, #5DBDE6 -33.84%, #1D61BD 135.37%);display:flex;width:100%;justify-content: center;padding: 1rem">';
            $mail->Body .= '<img style="max-width: 110px;margin:0 auto;" src="'.BASE_URL.'asset/img/new-sso-logo-white.png" alt="">';
            $mail->Body .= '</div>';
            $mail->Body .= '<div style="width:100%;padding: 1rem;">';
            $mail->Body .= '<h4 class="t-main1" style="color: #39414F!important;">การยืนยันตัวตนผ่านระบบ DITP SSO ของกรมส่งเสริมการค้าระหว่างประเทศ</h4>';
            $mail->Body .= '<p class="t-main1" style="color: #39414F!important;">รหัสอ้างอิง : '.$ref_code.'</p>';
            $mail->Body .= '<p class="t-main1 text-center" style="color: #39414F!important;padding-left: 18rem;font-size: 2em;">'.$ref_codes.'</p>';
            if(strtoupper($target) != 'DITP ONE'){
              $url = $this->path_web."register/verify_email?q=".$token_verify."&ref=".$ref_codes."&response_type=token&state=portal";
              $mail->Body .= '<p class="t-main1" style="color: #39414F!important;">กรุณายืนยันอีเมลของท่านอีกครั้ง เพื่อความสมบูรณ์ในการลงทะเบียน SSO โดยกดปุ่มยืนยันด้านล่าง</p>';
              $mail->Body .= '<div style="display:grid;text-align:center;">';
              $mail->Body .= '<a style="font-weight: 400;line-height: 1.5;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;border: 1px solid transparent;font-size: 1rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;background-color: #2D6DC4;border-radius: 8px;color: white;display: inline-flex;justify-content: center;padding: 8px 15px;margin: 0 auto;"';
              $mail->Body .= 'href="'.$url.'">ยืนยัน (Confirmed)</a>';
              $mail->Body .= '<small class="t-main1" style="color: #39414F!important;">หากท่านมีข้อสงสัยสามารถติดต่อ : 1169</small>';
              $mail->Body .= '</div>';
            }
            $mail->Body .= '</div>';
            $mail->Body .= '<div style="background-color: #EFF6F9;width: 100%;padding:1rem;">';
            $mail->Body .= '<div style="--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: calc(var(--bs-gutter-y) * -1);margin-right: calc(var(--bs-gutter-x) * -.5);margin-left: calc(var(--bs-gutter-x) * -.5);padding:1rem;">';
            $mail->Body .= '<div style="flex:0 0 auto;width:75%;">';
            $mail->Body .= '<p style="color: #39414F!important;">';
            $mail->Body .= 'กรมส่งเสริมการค้าระหว่างประเทศ กระทรวงพาณิชย์ <br>';
            $mail->Body .= '563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 <br>';
            $mail->Body .= 'Call Center : 1169 <br> e-mail : tiditp@ditp.go.th';
            $mail->Body .= '</p>';
            $mail->Body .= '</div>';
            $mail->Body .= '<div style="flex:0 0 auto;width:25%;">';
            $mail->Body .= '<img style="width:100%;" src="'.BASE_URL.'asset/img/ditp-logo.png">';
            $mail->Body .= '</div>';
            $mail->Body .= '</div>';
            $mail->Body .= '</div>';
            $mail->Body .= '</div>';
            $mail->Body .= '</div>';
            $mail->Body .= '</body>';
            $mail->Body .= '</html>';
            

            if (!$this->validate_email($email)) {
              $text_email = explode("/", $email);
              $text_email2 = explode(",", $email);
              if(count($text_email) > 1){
                  $email_list = '';
                  foreach($text_email as $item){
                      if ($this->validate_email(trim($item))) {
                          $mail->AddAddress($item);
                          if ($mail->Send()){
                              $email_list.= substr_replace($item,"****",0,4)."<br>";
                              $mail->ClearAddresses();
                          } 
                      }
                  }
                  if($email_list != ''){
                    $return = [
                      "status" => "00",
                      "message" => "success",
                      "email" => $email_list,
                      "token_verify" => $token_verify,
                      "ref_code" => $ref_code
                    ];
                  }
                  
              }else if(count($text_email2) > 1){
                  $email_list = '';
                  foreach($text_email2 as $item){
                      if ($this->validate_email(trim($item))) {
                          $mail->AddAddress($item);
                          if ($mail->Send()){
                              $email_list.= substr_replace($item,"****",0,4)."<br>";
                              $mail->ClearAddresses();
                          } 
                      }
                  }
                  if($email_list != ''){
                    $return = [
                      "status" => "00",
                      "message" => "success",
                      "email" => $email_list,
                      "token_verify" => $token_verify,
                      "ref_code" => $ref_code
                    ];
                  }
              }else{
                $return = [
                  "status" => "01",
                  "message" => "รูปแบบ Email ไม่ถูกต้อง"
                ];
                return $return;
              }
            }else{
              $mail->AddAddress(trim($email));
              $Send = $mail->Send();
              if ($Send){
                $return = [
                  "status" => "00",
                  "message" => "success",
                  "email" => substr_replace($email,"****",0,4),
                  "token_verify" => $token_verify,
                  "ref_code" => $ref_code
                ];
              }else{
                $return = [
                  "status" => "01",
                  "message" => "ส่ง Email ไม่สำเร็จ"
                ];
              }
            }
            
          }else{
            $return = [
              "status" => "01",
              "message" => "ไม่พบบัญชี Email ในระบบ"
            ];
          }
      }else{
            $post_data = array('key' => '1745295121138668','secret' => 'ffbe674774233c1c666fc5d07d60297b','msisdn' => $tel);
            foreach ( $post_data as $key => $value) {
              $post_items[] = $key . '=' . $value;
            }
            //create the final string to be posted using implode()
            $post_string = implode ('&', $post_items);
            //create cURL connection
            $curl_connection = curl_init('https://otp.thaibulksms.com/v2/otp/request');
            //set options
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, "accept: application/json","content-type: application/x-www-form-urlencoded");
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
            //set data to be posted
            curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
            //perform our request
            $result = curl_exec($curl_connection);
            $result = json_decode($result);
            //close the connection
            curl_close($curl_connection);
            $token_verify = $result->token;
            $refno = $result->refno;
            $exp_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+15 minutes"));
            $ref_code = $result->refno;
            //-- เคลียร์ Token เก่า --// 
            $this->update('tb_token_verify', ['status'=>'1'], "member_id ='$member_id'");
            //-- insert tb_token_reset --//
            $number = mt_rand(1000,9999);
            $_SESSION['id'] = $member_id;
            $_SESSION['tel'] = $tel;
            $_SESSION['target'] = $target;
            $_SESSION['number'] = $number;
            $_SESSION['status_reset'] = true;
            $data_token_verify = [
              'token_verify' => $token_verify,
              'ref_code' => $ref_code,
              'member_id' => $member_id,
              'target' => $target,
              'redirect_uri' => ($_SESSION['redirect_uri'])?$_SESSION['redirect_uri']:"ditpone://my-host/callback",
              'response_type' => ($_SESSION['response_type'])?$_SESSION['response_type']:"token",
              'client_id' => ($_SESSION['client_id'])?$_SESSION['client_id']:"SS0047423",
              'state' => ($_SESSION['state'])?$_SESSION['state']:"OTP",
              'status' => '0',
              'exp_date' => $exp_date
            ];
    
            $this->insert('tb_token_verify', $data_token_verify);
            $_SESSION['ref_code'] = $ref_code;
            if(isset($result->errors)){
              $return = [
                "status" => "01",
                "message" => $result->errors[0]->message.' '.$tel,
              ];
            }else{
              $return = [
                "status" => "00",
                "message" => "success",
                "token_verify" => $token_verify,
                "refno" => $refno,
              ];
            }
      }

      return $return;
  }    
  function model_send_mail_verify_bak(){
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ"
    ];
    $member_id = $this->post('member_id');
    $target = $this->post('target');
    $email = $this->post('email');
    $tel = $this->post('tel');
    if($email != ""){
        if($email != "" && $member_id !="" && $target != ""){
          $number = mt_rand(1000,9999);
          $_SESSION['id'] = $member_id;
          $_SESSION['email'] = $email;
          $_SESSION['target'] = $target;
          $_SESSION['number'] = $number;
          $_SESSION['status_reset'] = true;
          $token_verify = sha1($member_id . date('YmhHis'));
          $exp_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+15 minutes"));
          $ref_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 6);
          //-- เคลียร์ Token เก่า --// 
          $this->update('tb_token_verify', ['status'=>'1'], "member_id ='$member_id'");
          //-- insert tb_token_reset --//
          $data_token_verify = [
            'token_verify' => $token_verify,
            'ref_code' => $ref_code,
            'member_id' => $member_id,
            'target' => $target,
            'redirect_uri' => ($_SESSION['redirect_uri'])?$_SESSION['redirect_uri']:"ditpone://my-host/callback",
            'response_type' => ($_SESSION['response_type'])?$_SESSION['response_type']:"token",
            'client_id' => ($_SESSION['client_id'])?$_SESSION['client_id']:"SS0047423",
            'state' => ($_SESSION['state'])?$_SESSION['state']:"email",
            'status' => '0',
            'exp_date' => $exp_date
          ];
          $insert = $this->insert('tb_token_verify', $data_token_verify);
          $_SESSION['ref_code'] = $ref_code;
          // ----- Google SMTP ----- //
          // $mail = new PHPMailer();
          // $mail->isSMTP();
          // $mail->SMTPDebug = 0;
          // $mail->SMTPAuth = true;
          // $mail->SMTPSecure = "tls";
          // $mail->Host = "smtp.gmail.com"; // ถ้าใช้ smtp ของ server เป็นอยู่ในรูปแบบนี้ mail.domainyour.com
          // $mail->Port = 587;
          // $mail->isHTML();
          // $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
          // $mail->Username = "kittiporn.s@ibusiness.co.th"; //กรอก Email Gmail หรือ เมลล์ที่สร้างบน server ของคุณเ
          // $mail->Password = "0856225746"; // ใส่รหัสผ่าน email ของคุณ
          // $mail->SetFrom = ('kittiporn.s@ibusiness.co.th'); //กำหนด email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง
          // $mail->FromName = "DITP SSO"; //ชื่อที่ใช้ในการส่ง
          // $mail->Subject = "รีเซ็ตรหัสผ่าน DITP SSO";  //หัวเรื่อง emal ที่ส่ง
          
          // $mail = new PHPMailer(true);
          // try {
          //     $mail->isSMTP();
          //     $mail->Host = 'in-v3.mailjet.com'; // host
          //     $mail->SMTPAuth = true;
          //     $mail->Username = 'API_KEY'; //username
          //     $mail->Password = 'SECRET_KEY'; //password
          //     $mail->SMTPSecure = 'tls';
          //     $mail->Port = 587; //smtp port
              
          //     $mail->setFrom('SENDER_EMAIL_ADDRESS', 'SENDER_NAME');
          //     $mail->addAddress('RECIPIENT_EMAIL_ADDRESS', 'RECIPIENT_NAME');
            
          //     $mail->isHTML(true);
          //     $mail->Subject = 'Email Subject';
          //     $mail->Body    = '<b>Email Body</b>';
            
          //     $mail->send();
          //     echo 'Email sent successfully.';
          // } catch (Exception $e) {
          //     echo 'Email could not be sent. Mailer Error: '. $mail->ErrorInfo; in-v3.mailjet.com mgtrelay01.mail.go.th
          // }
          // USERNAME_Mailjet=f6b9d3f6d47987a760d9ad1b7e385cbd
          // PASSWORD_Mailjet=6af683f5f40da8350cd451daa6ead955

          $mail = new PHPMailer(true);
          $mail->isSMTP();
          $mail->SMTPAuth = true;
          $mail->SMTPDebug = 1;
          $mail->SMTPSecure = "tlsv1.2";
          $mail->Host = "in-v3.mailjet.com";
          $mail->Port = 587;
          $mail->isHTML();
          $mail->CharSet = "utf-8";
          $mail->Username = USERNAME_Mailjet;
          $mail->Password = PASSWORD_Mailjet;
  
          $mail->From = ('sso@ditp.go.th');
          $mail->FromName = "DITP Single Sign-on";
          // $mail->FromName = "DITP Single Sign-on MailJet";
          $mail->Subject = "การยืนยันตัวตนผ่านระบบ DITP SSO ของกรมส่งเสริมการค้าระหว่างประเทศ";
  
          $mail->Body .= '<!DOCTYPE html>';
          $mail->Body .= '<html lang="en">';
          $mail->Body .= '<head>';
          $mail->Body .= '<meta name="viewport" content="width=device-width" />';
          $mail->Body .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
          $mail->Body .= '<title>SSO DITP Email Verification</title>';
          $mail->Body .= '</head>';
          $mail->Body .= '<body>';
          $mail->Body .= '<div class="container" style="display: flex;justify-content: center;">';
          $mail->Body .= '<div  style="max-width: 740px;width:100%;padding: 1rem;">';
          $mail->Body .= '<div style="background:linear-gradient(318.86deg, #5DBDE6 -33.84%, #1D61BD 135.37%);display:flex;width:100%;justify-content: center;padding: 1rem">';
          $mail->Body .= '<img style="max-width: 110px;margin:0 auto;" src="https://sso-uat.ditp.go.th/sso/asset/img/new-sso-logo-white.png" alt="">';
          $mail->Body .= '</div>';
          $mail->Body .= '<div style="width:100%;padding: 1rem;">';
          $mail->Body .= '<h4 class="t-main1" style="color: #39414F!important;">การยืนยันตัวตนผ่านระบบ DITP SSO ของกรมส่งเสริมการค้าระหว่างประเทศ</h4>';
          $mail->Body .= '<p class="t-main1" style="color: #39414F!important;">รหัสอ้างอิง : '.$ref_code.'</p>';
          if(strtoupper($target) != 'DITP ONE'){
            $url = $this->path_web."register/verify_email?q=".$token_verify."&ref=".$ref_code."&response_type=token&state=portal";
            $mail->Body .= '<p class="t-main1" style="color: #39414F!important;">กรุณายืนยันอีเมลของท่านอีกครั้ง เพื่อความสมบูรณ์ในการลงทะเบียน SSO โดยกดปุ่มยืนยันด้านล่าง</p>';
            $mail->Body .= '<div style="display:grid;text-align:center;">';
            $mail->Body .= '<a style="font-weight: 400;line-height: 1.5;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;border: 1px solid transparent;font-size: 1rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;background-color: #2D6DC4;border-radius: 8px;color: white;display: inline-flex;justify-content: center;padding: 8px 15px;margin: 0 auto;"';
            $mail->Body .= 'href="'.$url.'">ยืนยัน (Confirmed)</a>';
            $mail->Body .= '<small class="t-main1" style="color: #39414F!important;">หากท่านมีข้อสงสัยสามารถติดต่อ : 1169</small>';
            $mail->Body .= '</div>';
          }
          $mail->Body .= '</div>';
          $mail->Body .= '<div style="background-color: #EFF6F9;width: 100%;padding:1rem;">';
          $mail->Body .= '<div style="--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: calc(var(--bs-gutter-y) * -1);margin-right: calc(var(--bs-gutter-x) * -.5);margin-left: calc(var(--bs-gutter-x) * -.5);padding:1rem;">';
          $mail->Body .= '<div style="flex:0 0 auto;width:75%;">';
          $mail->Body .= '<p style="color: #39414F!important;">';
          $mail->Body .= 'กรมส่งเสริมการค้าระหว่างประเทศ กระทรวงพาณิชย์ <br>';
          $mail->Body .= '563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 <br>';
          $mail->Body .= 'Call Center : 1169 <br> e-mail : tiditp@ditp.go.th';
          $mail->Body .= '</p>';
          $mail->Body .= '</div>';
          $mail->Body .= '<div style="flex:0 0 auto;width:25%;">';
          $mail->Body .= '<img style="width:100%;" src="https://sso-uat.ditp.go.th/sso/asset/img/ditp-logo.png">';
          $mail->Body .= '</div>';
          $mail->Body .= '</div>';
          $mail->Body .= '</div>';
          $mail->Body .= '</div>';
          $mail->Body .= '</div>';
          $mail->Body .= '</body>';
          $mail->Body .= '</html>';
          
        
          if (!$this->validate_email($email)) {
            $text_email = explode("/", $email);
            $text_email2 = explode(",", $email);
            if(count($text_email) > 1){
                $email_list = '';
                foreach($text_email as $item){
                    if ($this->validate_email(trim($item))) {
                        $mail->AddAddress($item);
                        if ($mail->Send()){
                            $email_list.= substr_replace($item,"****",0,4)."<br>";
                            $mail->ClearAddresses();
                        } 
                    }
                }
                if($email_list != ''){
                  $return = [
                    "status" => "00",
                    "message" => "success",
                    "email" => $email_list,
                    "token_verify" => $token_verify,
                    "ref_code" => $ref_code
                  ];
                }
                
            }else if(count($text_email2) > 1){
                $email_list = '';
                foreach($text_email2 as $item){
                    if ($this->validate_email(trim($item))) {
                        $mail->AddAddress($item);
                        if ($mail->Send()){
                            $email_list.= substr_replace($item,"****",0,4)."<br>";
                            $mail->ClearAddresses();
                        } 
                    }
                }
                if($email_list != ''){
                  $return = [
                    "status" => "00",
                    "message" => "success",
                    "email" => $email_list,
                    "token_verify" => $token_verify,
                    "ref_code" => $ref_code
                  ];
                }
            }else{
              $return = [
                "status" => "01",
                "message" => "รูปแบบ Email ไม่ถูกต้อง"
              ];
              return $return;
            }
          }else{
            $mail->AddAddress(trim($email));
            $Send = $mail->Send();
            if ($Send){
              $return = [
                "status" => "00",
                "message" => "success",
                "email" => substr_replace($email,"****",0,4),
                "token_verify" => $token_verify,
                "ref_code" => $ref_code
              ];
            }else{
              $return = [
                "status" => "01",
                "message" => "ส่ง Email ไม่สำเร็จ"
              ];
            }
          }
          
        }else{
          $return = [
            "status" => "01",
            "message" => "ไม่พบบัญชี Email ในระบบ"
          ];
        }
    }else{
          $post_data = array('key' => '1745295121138668','secret' => 'ffbe674774233c1c666fc5d07d60297b','msisdn' => $tel);
          foreach ( $post_data as $key => $value) {
            $post_items[] = $key . '=' . $value;
          }
          //create the final string to be posted using implode()
          $post_string = implode ('&', $post_items);
          //create cURL connection
          $curl_connection = curl_init('https://otp.thaibulksms.com/v2/otp/request');
          //set options
          curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
          curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
          curl_setopt($curl_connection, CURLOPT_HTTPHEADER, "accept: application/json","content-type: application/x-www-form-urlencoded");
          curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
          //set data to be posted
          curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
          //perform our request
          $result = curl_exec($curl_connection);
          $result = json_decode($result);
          //close the connection
          curl_close($curl_connection);
          $token_verify = $result->token;
          $refno = $result->refno;
          $exp_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+15 minutes"));
          $ref_code = $result->refno;
          //-- เคลียร์ Token เก่า --// 
          $this->update('tb_token_verify', ['status'=>'1'], "member_id ='$member_id'");
          //-- insert tb_token_reset --//
          $number = mt_rand(1000,9999);
          $_SESSION['id'] = $member_id;
          $_SESSION['tel'] = $tel;
          $_SESSION['target'] = $target;
          $_SESSION['number'] = $number;
          $_SESSION['status_reset'] = true;
          $data_token_verify = [
            'token_verify' => $token_verify,
            'ref_code' => $ref_code,
            'member_id' => $member_id,
            'target' => $target,
            'redirect_uri' => ($_SESSION['redirect_uri'])?$_SESSION['redirect_uri']:"ditpone://my-host/callback",
            'response_type' => ($_SESSION['response_type'])?$_SESSION['response_type']:"token",
            'client_id' => ($_SESSION['client_id'])?$_SESSION['client_id']:"SS0047423",
            'state' => ($_SESSION['state'])?$_SESSION['state']:"OTP",
            'status' => '0',
            'exp_date' => $exp_date
          ];
  
          $this->insert('tb_token_verify', $data_token_verify);
          $_SESSION['ref_code'] = $ref_code;
          if(isset($result->errors)){
            $return = [
              "status" => "01",
              "message" => $result->errors[0]->message.' '.$tel,
            ];
          }else{
            $return = [
              "status" => "00",
              "message" => "success",
              "token_verify" => $token_verify,
              "refno" => $refno,
            ];
          }
    }

    return $return;
}
function model_email_verify_by_member_id($member_id = ''){
  $data = [];
  //-------- check db_sso ---------//
  $stmt = $this->db->prepare("SELECT email,cid,member_id,type FROM tb_member WHERE member_id = ?");
  $stmt->bind_param("s", $member_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows){
    $read = $result->fetch_assoc();
    $member_id = $read['member_id'];
    
    if($read['type'] == 1){
      $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type1 WHERE member_id = ?");
    }else if($read['type'] == 2){
      $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type2 WHERE member_id = ?");
    }else if($read['type'] == 3){
      $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type3 WHERE member_id = ?");
    }else if($read['type'] == 4){
      $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type4 WHERE member_id = ?");
    }else if($read['type'] == 5){
      $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type5 WHERE member_id = ?");
    }else if($read['type'] == 6){
      $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type6 WHERE member_id = ?");
    }
    
    $stmt_m->bind_param("s", $member_id);
    $stmt_m->execute();
    $result_m = $stmt_m->get_result();
    if($result_m->num_rows){
      $read_m = $result_m->fetch_assoc();
      ($read['type'] == 1 || $read['type'] == 5 || $read['type'] == 6 )? $email = $read_m['member_email'] : $email = $read_m['email'];
      // ($read['type'] == 1 && $read_m['director_status'] == 2)? $email = $read_m['director_email'] : $email = $email;
      $name = $read_m['member_nameTh']; 
      $lastname = $read_m['member_lastnameTh'];
      
      if($email != ""){
        $data[] = [
          'email' => $email,
          'member_id' => $read['member_id'],
          'target' => 'SSO'
        ];

        $return = [
          'status' => '00',
          'result' => $data
        ];

        return $return;
      }else{
        $data[] = [
          'email' => $email,
          'member_id' => $read['member_id'],
          'target' => 'SSO'
        ];
        $return = [
          'status' => '01',
          'message' => 'ไม่พบอีเมลของท่านในระบบ กรุณาติดต่อเจ้าหน้าที่',$data
        ];
        return $return;
      }
    }
  }

  if(count($data) > 0){
    $return = [
      'status' => '00',
      'result' => $data
    ];
  }else{
    $return = [
      'status' => '01',
      'message' => 'ไม่พบข้อมูล'
    ];
  }
  
  return $return;
}  
  function model_ck_token(){
    $token_verify = $this->post('token_verify');
    $ref_code = $this->post('ref_code');
    $target = $this->post('target');
    $sql = "SELECT * FROM tb_token_verify WHERE token_verify = '$token_verify' AND `status` = 0";
    $data = $this->query($sql);
    $return = [];
    if (count($data) > 0) {
      $result = $data[0];
      // return $result;
      $email = $this->model_email_verify_by_member_id($result['member_id']);
      if ($result['exp_date'] > date('Y-m-d H:i:s')) {
        if($result['state'] != "OTP"){
          if ($result['ref_code'] == $ref_code) {
            if ($result['status'] == '1' && strtoupper($target) != 'DITP ONE'){
                  $return = [
                    'res_code' => '01',
                    'res_text' => 'ขออภัยลิงก์นี้ไม่สามารถใช้งานได้',
                    'res_result' => [
                      'member_id' => $email['result'][0]['member_id'],
                      'email' => $email['result'][0]['email'],
                      'target' => $target
                    ]
                  ];
            }else if ($result['status'] == '1' && strtoupper($target) == 'DITP ONE'){
              $return = [
                'res_code' => '01',
                'res_text' => 'ขออภัย ref_code นี้ไม่สามารถใช้งานได้',
                'res_result' => [
                  'member_id' => $email['result'][0]['member_id'],
                  'email' => $email['result'][0]['email'],
                  'target' => $target
                ]
              ];
            }else if (strtoupper($target) != 'DITP ONE') {
              $this->update('tb_token_verify', ['status'=>'1'], "member_id ='{$result['member_id']}'");
              $this->update('tb_member', ['status_email_verify'=>'1'], "member_id ='{$result['member_id']}'");
              $return = [
                'res_code' => '00',
                'res_text' => 'success !'
              ];
            }else if (strtoupper($target) == 'DITP ONE') {
              $this->update('tb_token_verify', ['status'=>'1'], "member_id ='{$result['member_id']}'");
              $this->update('tb_member', ['status_email_verify'=>'1'], "sso_id ='{$result['member_id']}'");
              $return = [
                'res_code' => '00',
                'res_text' => 'success !'
              ];
            }
          } else {
            $return = [
              'res_code' => '01',
              'res_text' => 'ขออภัยลิงก์นี้ไม่สามารถใช้งานได้',
              'res_result' => [
                'member_id' => $email['result'][0]['member_id'],
                'email' => $email['result'][0]['email'],
                'target' => $target
              ]
            ];
          }
        }else{
            $post_data = array('key' => '1745295121138668','secret' => 'ffbe674774233c1c666fc5d07d60297b','token' => $token_verify,'pin' => $ref_code);
            foreach ( $post_data as $key => $value) {
              $post_items[] = $key . '=' . $value;
            }

            //create the final string to be posted using implode()
            $post_string = implode ('&', $post_items);
            //create cURL connection
            $curl_connection = curl_init('https://otp.thaibulksms.com/v2/otp/verify');
            //set options
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, "accept: application/json","content-type: application/x-www-form-urlencoded");
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
            //set data to be posted

            curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
            //perform our request
            $response = curl_exec($curl_connection);
            $response = json_decode($response);
            //close the connection
            curl_close($curl_connection);

            if(isset($response->errors)){
              $return = [
                "status" => "01",
                "message" => $response->errors[0]->message,
              ];
            }else{
              $this->update('tb_token_verify', ['status'=>'1'], "member_id ='{$result['member_id']}'");
              $this->update('tb_member', ['status_sms_verify'=>'1'], "sso_id ='{$result['member_id']}'");
              $return = [
                'res_code' => '00',
                'res_text' => 'success !'
              ];
            }
        }
      }else{
        $return = [
          'res_code' => '01',
          'res_text' => 'ลิงก์หมดอายุ กรุณาส่งอีกครั้งและทำรายการภายใน 15 นาที'
        ];
      }
    }else{
      $return = [
        'res_code' => '01',
        'res_text' => 'ขออภัยลิงก์ นี้ไม่สามารถใช้งานได้'
      ];
    }
    return $return;
  }
  function model_ImagesService(){
    $serviceId = $this->post('serviceId');
    $mfno1 = $this->post('mfno1');
    // return  $serviceId;
        $keyFile = "/home/care/www_dev/dbd/ditp.key";
        $caFile = "/home/care/www_dev/dbd/ditp.ca";
        $certFile = "/home/care/www_dev/dbd/ditp.crt";

        // $xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.wsdata.dbd.gov/">
        //               <soapenv:Header/>
        //               <soapenv:Body>
        //                 <ser:getBytePDFBorikonByJuristicID>
        //                     <!--Optional:-->
        //                     <subscriberId>6211005</subscriberId>
        //                     <!--Optional:-->
        //                     <subscriberPwd>$PSk3754</subscriberPwd>
        //                     <!--Optional:-->
        //                     <serviceId>'.$serviceId.'</serviceId>
        //                     <!--Optional:-->
        //                     <mfno1>'.$mfno1.'</mfno1>
        //                 </ser:getBytePDFBorikonByJuristicID>
        //               </soapenv:Body>
        //               </soapenv:Envelope>';
                            

        $xml_data =   '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.wsdata.dbd.gov/">
                       <soapenv:Header/>
                       <soapenv:Body>
                          <ser:getByteImg>
                             <!--Optional:-->
                            <subscriberId>6211005</subscriberId>
                             <!--Optional:-->
                            <subscriberPwd>$PSk3754</subscriberPwd>
                             <!--Optional:-->
                            <serviceId>'.$serviceId.'</serviceId>
                             <!--Optional:-->
                            <mfno1>'.$mfno1.'</mfno1>
                          </ser:getByteImg>
                       </soapenv:Body>
                    </soapenv:Envelope>';

        $contentlength = strlen($xml_data);
        $URL = "https://sso.ditp.go.th/dbdws/img.php";

        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        // this with CURLOPT_SSLKEYPASSWD
        curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);
        // // The --cacert option
        curl_setopt($ch, CURLOPT_CAINFO, $caFile);
        curl_setopt($ch, CURLOPT_CAPATH, '');
        // // The --cert option
        curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
        curl_setopt(
          $ch,
          CURLOPT_HTTPHEADER,
          array(
            'Content-Type: text/xml'
          )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $return = [];
        if ($output === false) {
          $content = curl_exec($ch);
          $err     = curl_errno($ch);
          $errmsg  = curl_error($ch);
          $header  = curl_getinfo($ch);
          curl_close($ch);

          $header['errno']   = $err;
          $header['errmsg']  = $errmsg;
          $header['content'] = $content;
        } else {
          curl_close($ch);
          $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
          $xml = new SimpleXMLElement($response);
          $body = $xml->xpath('//SBody')[0];
          $array = json_decode(json_encode((array) $body), TRUE);
          return $array;
        }
  }
  function model_BalanceService(){
    $serviceId = $this->post('serviceId');
    $cid = $this->post('cid');
    $year = $this->post('year');
    // return  $serviceId;
        $keyFile = "/home/care/www_dev/dbd/ditp.key";
        $caFile = "/home/care/www_dev/dbd/ditp.ca";
        $certFile = "/home/care/www_dev/dbd/ditp.crt";
        $xml_data =   '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.wsdata.dbd.gov/">
                        <soapenv:Header/>
                        <soapenv:Body>
                          <ser:getDataAndBalance>
                              <!--Optional:-->
                              <subscriberId>6211005</subscriberId>
                              <!--Optional:-->
                              <subscriberPwd>$PSk3754</subscriberPwd>
                              <!--Optional:-->
                              <serviceId>'.$serviceId.'</serviceId>
                              <!--Zero or more repetitions:-->
                              <params>
                                <!--Optional:-->
                                <name>JURISTICID</name>
                                <!--Optional:-->
                                <value>'.$cid.'</value>
                              </params>
                              <params>
                                <!--Optional:-->
                                <name>STATEMENTYEAR</name>
                                <!--Optional:-->
                                <value>'.$year.'</value>
                              </params>
                          </ser:getDataAndBalance>
                        </soapenv:Body>
                    </soapenv:Envelope>';

        $contentlength = strlen($xml_data);
        $URL = "https://sso-uat.ditp.go.th/dbdws/";

        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        // this with CURLOPT_SSLKEYPASSWD
        curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);
        // // The --cacert option
        curl_setopt($ch, CURLOPT_CAINFO, $caFile);
        curl_setopt($ch, CURLOPT_CAPATH, '');
        // // The --cert option
        curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
        curl_setopt(
          $ch,
          CURLOPT_HTTPHEADER,
          array(
            'Content-Type: text/xml'
          )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $return = [];
        if ($output === false) {
          $content = curl_exec($ch);
          $err     = curl_errno($ch);
          $errmsg  = curl_error($ch);
          $header  = curl_getinfo($ch);
          curl_close($ch);

          $header['errno']   = $err;
          $header['errmsg']  = $errmsg;
          $header['content'] = $content;
        } else {
          curl_close($ch);
          $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
          $xml = new SimpleXMLElement($response);
          $body = $xml->xpath('//SBody')[0];
          $array = json_decode(json_encode((array) $body), TRUE);
          return $array;
        }
  }
  
  function model_getClient(){
    $client_id = $this->get('client_id');
    $arr = [];
    $stmt = $this->db->prepare("SELECT * FROM tb_merchant WHERE client_id = ?");
    $stmt->bind_param("s", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
      $read = $result->fetch_assoc();
        $arr []= [
            "client_name" => $read["mc_name"],
            "client_id" => $read["client_id"],
            "redirect_uri" => $read["redirect_uri"]
        ];
      $return = [
          "status" => "200",
          "massage" => "success",
          "result" => $arr
      ];
    }else{
      $return = [
          "status" => "404",
          "massage" => "not found",
      ];
    }
    return $return;
  }
  function model_getAttachment(){
    $member_id = $this->get('member_id');
    $status = 0;
    $arr = [];
    $stmt = $this->db->prepare("SELECT * FROM tb_member_attachment WHERE member_id = ? AND `status` = ?");
    $stmt->bind_param("si", $member_id,$status);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows >= 2){
      $return = [
          "status" => "200",
          "massage" => "success",
      ];
    }else{
      $return = [
          "status" => "404",
          "massage" => "not found",
      ];
    }
    return $return;
  }
}