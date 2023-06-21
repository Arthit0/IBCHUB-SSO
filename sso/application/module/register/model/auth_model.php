<?php

require APPPATH.'/library/PHPMailer_v5.0.2/class.phpmailer.php';
use \Firebase\JWT\JWT;

class auth_model extends Model
{
  function __construct()
  {
    define('FILEPATH', '/home/sso/www/sso/');
    parent::__construct();
  }

  // moc login //
  function moc_callback()
  {
    
    $client_id = 5111195809841;
    $code = $_GET['code'];
    $client_secret = "eawh7mio9nkua42b0kx98t5s6nl7dv2j"; 
    $redirect_uri = BASE_URL."index.php/auth/moccallback"; 
    // $mocAccountUrl = [
    //   'grant_type' => 'authorization_code',
    //   'client_id' => $client_id,
    //   'code' => $code,
    //   'client_secret' => $client_secret,
    //   'redirect_uri' => $redirect_uri,

    // ];

    $mocAccountUrl = 'grant_type=authorization_code&client_id=5111195809841&code='.$code.'&client_secret=eawh7mio9nkua42b0kx98t5s6nl7dv2j&redirect_uri='.$redirect_uri;

    // return $mocAccountUrl;


    if($code){
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://account.moc.go.th/auth/accesstoken',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $mocAccountUrl,
        CURLOPT_HTTPHEADER => array(
          'content-type: application/x-www-form-urlencoded;charset=utf-8'
        ),
      ));
  
      $response = curl_exec($curl);
  
          curl_close($curl);
        // echo $response;

        $access_token = json_decode($response);
        // echo "<pre>";
        // var_dump($access_token,$mocAccountUrl);
        // echo "</pre>";
        // die;
        if($response){
          $curl_token = curl_init();

          curl_setopt_array($curl_token, array(
            CURLOPT_URL => 'https://account.moc.go.th/auth/resource',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'Authorization: Bearer '.$access_token->access_token
            ),
          ));

          $response_token = curl_exec($curl_token);

          curl_close($curl_token);

          $moc_account_id = json_decode($response_token);

          // $sql_ck_cid = "SELECT cid FROM tb_member WHERE cid = '$moc_account_id->IdentificationNo'";
          // $result_ck_cid = $this->query($sql_ck_cid);
          
          if($response_token){
            $this->ck_login_moc($val = $moc_account_id);
          }
          else{
            header( "location:".BASE_URL."test2.php" );
            exit(0);
          }


          
          return $this->ck_login_moc($val = $moc_account_id);



        }
        
    }

    
    
    
    
    // header( "location:BASE_URL. test2.php" );
    // exit(0);
   

    // $mocAccountUrl = "";
    // $mocAccountUrl += "https://account.moc.go.th/auth/authorize?"; 
    // $mocAccountUrl += "&response_type=code";
    // $mocAccountUrl += "&redirect_uriBASE_URL.=index.php/auth/moccallback"; 
    // $mocAccountUrl += "&client_id=5111195809841"; 

   
    // return Linking.openURL( mocAccountUrl );
  }


  function random_char($max) {
    unset($pass,$i);
    $salt = "abchefghjkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    srand((double)microtime()*1000000);
    while ($i++ < $max)
      $pass .= substr($salt, rand() % strlen($salt), 1);
    return $pass;
  }

  

  //-- verify password care --//
  function unique_salt() {
      return substr(sha1(mt_rand()), 0, 22);
  }
  function hash_password($password) {
    $algo = '$2a';
    $cost = '$10';
    return crypt($password, $algo.$cost .'$' . $this->unique_salt());
  }
  function check_password($hash, $password) { //$password from db 
      $full_salt = substr($hash, 0, 29);
      $new_hash = crypt($password, $full_salt);
      return ($hash == $new_hash);
  }
  
  //-- verify password drive --//
  function verify_password_drive($username = '', $password = ''){
    $data = [
      'username' => $username,
      'password' => $password,
      'token' => '40AC3FB5-71E8-4581-A4B7-05707C3ABDF0'
    ];
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_DRIVE."VerifyUser",
      //CURLOPT_URL => "http://testdriveapi.ditp.go.th/api/VerifyUser",
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

  function get_data_return($val = []){
    $data_client = $this->get_data_client($_SESSION['client_id']);
    $url = $data_client['redirect_uri'];

    if (!empty($_SESSION['redirect_uri'])) {
      $redirect_uri = $_SESSION['redirect_uri'];
      $url = $redirect_uri;
    }
    $query_url = parse_url($url, PHP_URL_QUERY);
    if ($query_url) {
      $url .= '&';
    } else {
      $url .= '?';
    }
    
    $key = $data_client['jwt_signature'];
    
    $response_type = $_SESSION['response_type'];

    $state =  $_SESSION['state'];
    if (strtoupper($response_type) == 'CODE') {
      $data_access = $this->gen_access($val['member_id']);

      if (!empty($data_access['access'])) {
        $jwt_data = [
          'access_token' => $data_access['access'],
          'end_date' => $data_access['exp_date'],
          "token_type" => "Bearer"
        ];
        $jwt = JWT::encode($jwt_data, $key);
        $url .= 'code=' . $jwt . "&state=" . $state;

        $return = [
          'status' => true,
          'url' => $url

        ];
        
        //echo json_encode($return); die();
        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_access'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        
      }
    } else if (strtoupper($response_type) == 'TOKEN') {
      $data_token = $this->gen_token($val['member_id']);
      if (!empty($data_token['token'])) {

        $jwt_data = [
          'id_token' => $data_token['token'],
          'refresh_token' => $data_token['refresh_token'],
          'end_date' =>  $data_token['exp_date'],
          'end_date_refresh' =>  $data_token['exp_date_refresh'],
          "token_type" => "Bearer"
        ];
        $jwt = JWT::encode($jwt_data, $key);
        $url .= 'code=' . $jwt . "&state=" . $state;
        $return = [
          'status' => true,
          'url' => $url
        ];
        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
    } else {
      $data_token = $this->gen_token($val['member_id']);
      if (!empty($data_token['token'])) {

        $jwt_data = [
          'id_token' => $data_token['token'],
          'refresh_token' => $data_token['refresh_token'],
          'end_date' =>  $data_token['exp_date'],
          'end_date_refresh' =>  $data_token['exp_date_refresh'],
          "token_type" => "Bearer"
        ];
        $jwt = JWT::encode($jwt_data, $key);
        $url .= 'code=' . $jwt . "&state=" . $state;
        $return = [
          'status' => true,
          'url' => $url
        ];
        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
    }
    return $return;
  }

  function get_data_portal_return($val = [], $client_id){
    $data_client = $this->get_data_client($client_id);
    $url = $data_client['redirect_uri'];
    $val = $val[0];
    // var_dump($val);
    // die();

    // if (!empty($_SESSION['redirect_uri'])) {
    //   $redirect_uri = $_SESSION['redirect_uri'];
    //   $url = $redirect_uri;
    // }
    
    $query_url = parse_url($url, PHP_URL_QUERY);
    if ($query_url) {
      $url .= '&';
    } else {
      $url .= '?';
    }

    $key = $data_client['jwt_signature'];
    
    // $response_type = $_SESSION['response_type'];
    $response_type = 'TOKEN';
    $state =  'statename';
    if (strtoupper($response_type) == 'CODE') {
      $data_access = $this->gen_portal_access($client_id, $val['member_id']);

      if (!empty($data_access['access'])) {
        $jwt_data = [
          'access_token' => $data_access['access'],
          'end_date' => $data_access['exp_date'],
          "token_type" => "Bearer"
        ];
        $jwt = JWT::encode($jwt_data, $key);
        var_dump($data_access, $jwt);
        die();
        $url .= 'code=' . $jwt . "&state=" . $state;

        $return = [
          'status' => true,
          'url' => $url

        ];
        
        //echo json_encode($return); die();
        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_access'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        
      }
    } else if (strtoupper($response_type) == 'TOKEN') {
      // var_dump($val['member_id']);
      // die();
      $data_token = $this->gen_portal_token($client_id, $val['member_id']);
      if (!empty($data_token['token'])) {

        $jwt_data = [
          'id_token' => $data_token['token'],
          'refresh_token' => $data_token['refresh_token'],
          'end_date' =>  $data_token['exp_date'],
          'end_date_refresh' =>  $data_token['exp_date_refresh'],
          "token_type" => "Bearer"
        ];
        $jwt = JWT::encode($jwt_data, $key);
        $url .= 'code=' . $jwt . "&state=" . $state;
        $return = [
          'status' => true,
          'url' => $url
        ];
        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
    }
    return $return;
  }

  function get_code($ck_mem, $client_id){
    //$data_client = $this->get_data_client($_SESSION['client_id']);
    $data_client = $this->get_data_client($client_id);
    $url = $data_client['redirect_uri'];
    if (!empty($_SESSION['redirect_uri'])) {
      $redirect_uri = $_SESSION['redirect_uri'];
      $url = $redirect_uri;
    }
    $query_url = parse_url($url, PHP_URL_QUERY);
    if ($query_url) {
      $url .= '&';
    } else {
      $url .= '?';
    }
    $key = $data_client['jwt_signature'];
    $response_type = $_SESSION['response_type'];

    if (strtoupper($response_type) == 'CODE') {
      $data_access = $this->gen_access($ck_mem);
      if (!empty($data_access['access'])) {
        $jwt_data = [
          'access_token' => $data_access['access'],
          'end_date' => $data_access['exp_date'],
          "token_type" => "Bearer"
        ];
        $jwt = JWT::encode($jwt_data, $key);
        //$url .= 'code=' . $jwt;
        $code = $jwt;

        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_access'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        //$return = ['code' => '00', 'success' => 1, 'url' => $url];
        return $code;
      }
    } else if (strtoupper($response_type) == 'TOKEN') {
      $data_token = $this->gen_token($ck_mem);
      if (!empty($data_token['token'])) {

        $jwt_data = [
          'id_token' => $data_token['token'],
          'refresh_token' => $data_token['refresh_token'],
          'end_date' =>  $data_token['exp_date'],
          'end_date_refresh' =>  $data_token['exp_date_refresh'],
          "token_type" => "Bearer"
        ];

        /*$jwt_data = [
          'id_token' => $data_token['token'],
          'end_date' =>  $data_token['exp_date'],
          "token_type" => "Bearer"
        ];*/
        $jwt = JWT::encode($jwt_data, $key);
        $state =  $_SESSION['state'];
        //$url .= 'code=' . $jwt . "&state=" . $state;
        $code = $jwt;

        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
      //$return = ['code' => '00', 'success' => 1, 'url' => $url];
      return $code;
    }
  }

  // function insert_connect($data){
  //   $data_insert = "member_type=".$data['member_type']."&";
  //   $data_insert .= "register_type=".$data['register_type']."&";
  //   $data_insert .= "email=".$data['email']."&";
  //   $data_insert .= "password=".$data['password']."&";
  //   $data_insert .= "oauth_token=".$data['oauth_token']."&";
  //   $data_insert .= "device_id=".$data['device_id']."&";
  //   $data_insert .= "device_model=".$data['device_model']."&";
  //   $data_insert .= "device_token=".$data['device_token']."&";
  //   $data_insert .= "firstname=".$data['firstname']."&";
  //   $data_insert .= "lastname=".$data['lastname']."&";
  //   $data_insert .= "sex=".$data['sex']."&";
  //   $data_insert .= "birthday=".$data['birthday']."&";
  //   $data_insert .= "mobile=".$data['mobile']."&";
  //   $data_insert .= "products=".$data['products'];

  //   $curl = curl_init();
  //   curl_setopt_array($curl, array(
  //     CURLOPT_URL => "https://connect.ditp.go.th/api/v3/member/register/",
  //     CURLOPT_RETURNTRANSFER => true,
  //     CURLOPT_ENCODING => "",
  //     CURLOPT_MAXREDIRS => 10,
  //     CURLOPT_TIMEOUT => 0,
  //     CURLOPT_FOLLOWLOCATION => true,
  //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //     CURLOPT_CUSTOMREQUEST => "POST",
  //     CURLOPT_POSTFIELDS => $data_insert,
  //     CURLOPT_HTTPHEADER => array(
  //       "Content-Type: application/x-www-form-urlencoded",
  //       "Cookie: PHPSESSID=03886gqmt94vbmsoqtjel9ie30"
  //     ),
  //   ));

  //   $response = curl_exec($curl);
  //   curl_close($curl);
  //   return $response;
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
    CURLOPT_URL => "http://care.ditp.go.th/api/v2/login",
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

  function login_connect($data = []){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.ditptouch.com/v1/auth/member",
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
  function checkconsent($data){
    (isset($data[1]['url']))?  $url = $data[1]['url'] : $url = str_replace('https://caredev.ditp.go.th/api/autologin_sso_v2.php','https://caredev.ditp.go.th/frontend/index.php?page=home',$data[2]); //$url = 'https://caredev.ditp.go.th/': $url = $data[2]."code=".$data[1]['code'];//$data[1]['url']: $url = $data[2]."code=".$data[1]['code'];
      $UrlFail = BASE_URL.'index.php/auth?response_type='.$_SESSION['response_type'].'&client_id='.$_SESSION['client_id'].'&redirect_uri='.$_SESSION['redirect_uri'].'&state='.$_SESSION['state'];
      (isset($data[0]['sso_id']))? $sso_id = $data[0]['sso_id'] : $sso_id = $data[0][0]['sso_id'];
      (isset($data[0]['email']))? $email = $data[0]['email'] : $email = $data[0][0]['email'];

    $user = curl_init();
    curl_setopt_array($user, array(
      CURLOPT_URL => BASE_URL.'index.php/api/userinfo',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('refid' => ''.$data[0]['cid'].''),
      CURLOPT_HTTPHEADER => array(
        'Cookie: PHPSESSID=ohqaa0v0685v9pqeu21u3kvpc6'
      ),
    ));
    $response = curl_exec($user);
    curl_close($user);   
    $userinfo = json_decode($response)->result;
    $client_id = "SELECT * FROM tb_merchant WHERE client_id = '".$_SESSION['client_id']."'";
    $client_name = $this->query($client_id);

    ($data[0]['type'] == '1')? $ConsRoleId = 19 : $ConsRoleId = 14;
      $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => BASE_PDPA.'service/consents/checkconsent',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "UserName": "ditpSSOUser",
          "Password": "password",
          "RefUid": "'.$data[0]['cid'].'",
          "RefUidKey": "",
          "Email": "'.$email.'",
          "Name": "'.$userinfo->member_nameTh.' '.$userinfo->member_lastnameTh.'",
          "Client_Id": "'.$client_name[0]['mc_name'].'",
          "ConsRoleId": '.$ConsRoleId.',
          "UrlSuccess": "'.$url.'",
          "UrlFail": "'.$url.'"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        // pr($response);
        // pr(curl_getinfo($curl));
        // pr(curl_error($curl));
        // // pr($pdpa);
        // die();
        curl_close($curl);   
        $pdpa = json_decode($response);

        $log_response_pdpa = json_encode($pdpa);
        $log_pdpa = '{
                  "UserName": "ditpSSOUser",
                  "Password": "password",
                  "RefUid": "'.$data[0]['cid'].'",
                  "RefUidKey": "",
                  "Email": "'.$email.'",
                  "Name": "'.$userinfo->member_nameTh.' '.$userinfo->member_lastnameTh.'",
                  "Client_Id": "'.$client_name[0]['mc_name'].'",
                  "ConsRoleId": '.$ConsRoleId.',
                  "UrlSuccess": "'.$url.'",
                  "UrlFail": "'.$url.'"
                }';
        $data_insert_pdpa_log = [
          'function' => 'checkconsent',
          'pid' => $data[0]['sso_id'],
          'data' => $log_pdpa,
          'response' => $log_response_pdpa,
          'response2' => $response
        ];


        if ($pdpa == null || empty($pdpa)) {
          $data_insert_pdpa_log = [
            'function' => 'checkconsent(null)',
            'pid' => $data[0]['sso_id'],
            'data' => $log_pdpa,
            'response' => $log_response_pdpa,
            'response2' => $response
          ];
          $insert_pdpa_log = $this->insert('tb_pdpa_log', $data_insert_pdpa_log);
          $this->checkconsent($data);
          // exit();
        }
        $insert_pdpa_log = $this->insert('tb_pdpa_log', $data_insert_pdpa_log);

        $result = [
            'status' => $pdpa->CheckStatus,
            'RedirectURL' => $pdpa->RedirectURL,
          ];
        return  $result;
  }
  function sentPDPA($data){

    // $curl_refID_Key = curl_init();
    // curl_setopt_array($curl_refID_Key, array(
    //   CURLOPT_URL => BASE_ONE.'get/refID_Key',
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => '',
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => 'POST',
    //   CURLOPT_POSTFIELDS => array('email' => $data[1]->res_result->email),
    // ));
    // $refID_Key = curl_exec($curl_refID_Key);
    // $refID_Key = json_decode($refID_Key);
    // curl_close($curl_refID_Key);
    // ($refID_Key->message == "ยังไม่มีคีย์")? $key = "" : $key = $refID_Key->refId_Key;
      if(isset($data[1]->res_result->position)){
          switch ($data[1]->res_result->position) {
            case "อธิบดี":
                $ConsRoleId = 9;
                break;
            case "รองอธิบดี":
                $ConsRoleId = 9;
                break;
            case "ผู้เชียวชาญ":
                $ConsRoleId = 9;
                break;
            case "ผู้อำนวยการ":
                $ConsRoleId = 9;
                break;
            case "หัวหน้ากลุ่มงาน":
                $ConsRoleId = 9;
                break;
            case "ข้าราชการ":
                $ConsRoleId = 9;
                break;
            case "พนักงานราชการ":
                $ConsRoleId = 10;
                break;
            case "ผู้ปฏิบัติงานกรม":
                $ConsRoleId = 12;
                break;
            default:
                $ConsRoleId = 9;
                break;

        }
      }else{
        $ConsRoleId = 9;
      }
   
  $client_id = "SELECT * FROM tb_merchant WHERE client_id = '".$_SESSION['client_id']."'";
  $client_name = $this->query($client_id);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_PDPA.'service/consents/checkconsent',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
      "UserName": "ditpSSOUser",
      "Password": "password",
      "RefUid": "'.$data[1]->res_result->email.'",
      "RefUidKey": "",
      "Email": "'.$data[1]->res_result->email.'",
      "Name": "'.$data[1]->res_result->name.'",
      "Client_Id": "'.$client_name[0]['mc_name'].'",
      "ConsRoleId": '.$ConsRoleId.',
      "UrlSuccess": "'.$data[0]->url.'",
      "UrlFail": "'.$data[0]->url.'"
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);   
    $pdpa = json_decode($response);
    $log_response_pdpa = json_encode($pdpa);
    $log_pdpa = '{
      "UserName": "ditpSSOUser",
      "Password": "password",
      "RefUid": "'.$data[1]->res_result->email.'",
      "RefUidKey": "",
      "Email": "'.$data[1]->res_result->email.'",
      "Name": "'.$data[1]->res_result->name.'",
      "Client_Id": "'.$client_name[0]['mc_name'].'",
      "ConsRoleId": '.$ConsRoleId.',
      "UrlSuccess": "'.$data[0]->url.'",
      "UrlFail": "'.$data[0]->url.'"
    }';

    if ($pdpa == null || empty($pdpa)) {
      $data_insert_pdpa_log = [
        'function' => 'sentPDPA(null)',
        'pid' => $data[1]->res_result->email,
        'data' => $log_pdpa,
        'response' => $log_response_pdpa,
        'response2' => $response
      ];
      $insert_pdpa_log = $this->insert('tb_pdpa_log', $data_insert_pdpa_log);
      $this->sentPDPA($data);
      // exit();
    }

    $insert_pdpa_log = $this->insert('tb_pdpa_log', $data_insert_pdpa_log);
    $result = [
        'status' => $pdpa->CheckStatus,
        'RedirectURL' => $pdpa->RedirectURL,
      ];
    return  $result;
  }
    function userstaff($data){
      $arr = [];
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_ONE.'login',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('email' => ''.$data['email'].'','password' => ''.$data['password'].''),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
    $staff = json_decode($response);
    if ($staff->res_code == "01") {
      return $return = ['status' => '01', 'data' => $staff];
    }

    $curl_details = curl_init();
    curl_setopt_array($curl_details, array(
      CURLOPT_URL => BASE_intranet.'getlist_user?email='.$data['email'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $details = curl_exec($curl_details);
    curl_close($curl_details);
    $details = json_decode($details);  
    //Get Ldap
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_URL.'auth/check_ldap',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('email' => $data['email'],'password' => $data['password']),
      CURLOPT_HTTPHEADER => array(
        'Cookie: PHPSESSID=j5ail71ljioi4jo2abra0rujb0'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $ldap = json_decode($response);
    $importer_token = null;
    if ($ldap->res_code == '00') {
      // Login Importet List
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => BASE_ONESTAFF.'loginImporter',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('username' => $ldap->res_result->uid, 'password' => $data['password']),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$staff->res_result->token
        ),
      ));

      $res = curl_exec($curl);
      $importerlist = json_decode($res);

      curl_close($curl);
      $importer_token = ($importerlist->res_code == '00')? $importerlist->res_result:null;
    }

    
    ($_SESSION['client_id'] == 'SS0047423')?$status = 'staff': $status = 'ldap';
    $test = preg_match("/ditpone:/i", $_SESSION['redirect_uri']);
    $staff->url = (preg_match("/ditpone:/i", $_SESSION['redirect_uri']) == '1')? ($_SESSION['client_id'] == "SS0047423")? $_SESSION['redirect_uri'].'?code='.$staff->res_result->token.'&state=appstaff&importer_token='.$importer_token : BASE_URL.'test2.php?code='.$staff->res_result->token.'&state='.$staff->status.'&importer_token=123456789' : $_SESSION['redirect_uri'].'?code='.$staff->res_result->token.'&state=ldap';
    $sentPDPA = $this->sentPDPA([$staff,$details]);

    $return_data = array_merge($arr, ['status' => $status, 'result' => $staff,'pdpa' => $sentPDPA]);
    return  $return_data;
  }
  function updateDBD($data){
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
      $data_insert_type1 = [
        'company_nameTh' => $company_nameTh,
        'company_nameEn' => $company_nameEn,
      ];
      $status_type1 = $this->update('tb_member_type1', $data_insert_type1, ' member_id="' . $data['member_id'] . '"');
      return  $status_type1;

  }
  // function checkDBD($result,$data){
  //   $status = true;
  //   $DBD_names = "";
  //   $user_names = "";
  //   $curl = curl_init();
  //   curl_setopt_array($curl, array(
  //     CURLOPT_URL => BASE_URL.'index.php/api/ck_com_dbd?cid='.$data.'',
  //     CURLOPT_RETURNTRANSFER => true,
  //     CURLOPT_ENCODING => '',
  //     CURLOPT_MAXREDIRS => 10,
  //     CURLOPT_TIMEOUT => 0,
  //     CURLOPT_FOLLOWLOCATION => true,
  //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //     CURLOPT_CUSTOMREQUEST => 'GET',
  //     CURLOPT_HTTPHEADER => array(
  //       'async: false',
  //       'Cookie: PHPSESSID=9dcso94grvcn91e52u22vh31q5'
  //     ),
  //   ));
  //   $response = curl_exec($curl);
  //   curl_close($curl);
  //   $response = json_decode($response);
  //   foreach ($response->ns0getDataResponse->return->arrayRRow->childTables[0]->rows as $key => $value) {
  //     if ($value->columns) {
  //       // $DBD_names .= $value->columns[2]->columnValue;
  //       $DBD_names .= $value->columns[3]->columnValue;
  //       $DBD_names .= $value->columns[4]->columnValue;
  //     } else {
  //       // $DBD_names .= $value->columns[2]->columnValue;
  //       $DBD_names .= $value[3]->columnValue;
  //       $DBD_names .= $value[4]->columnValue;
  //     }
      
  //     // $user_names .= $result['member_title'];
  //     $user_names .= $result['member_nameTh'];
  //     $user_names .= $result['member_lastnameTh'];
  //     $DBD_names = str_replace(["/"," "], "", $DBD_names);
  //     if($user_names != $DBD_names){
  //        $this->update('tb_member_type1', ["status_case" => 2], ' member_id="' . $result['member_id'] . '"');
  //       $status = false;   
  //     }else{
  //       $this->update('tb_member_type1', ["status_case" => 99], ' member_id="' . $result['member_id'] . '"');
  //       break;
  //     }
  //   }
  //     return  $status;

  // }
  function checkDBD($result,$data){
          $status = true;
          $DBD_names = "";
          $user_names = "";
          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => BASE_URL.'index.php/api/ck_com_dbd?cid='.$data.'',
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
       
          
          foreach ($response->ns0getDataResponse->return->arrayRRow->childTables[0]->rows as $key => $value) {
            // $DBD_names .= $value->columns[2]->columnValue;
            $DBD_names = "";
            $user_names = "";
            if(isset($value->columns)){
              $DBD_names .= $value->columns[3]->columnValue;
              $DBD_names .= $value->columns[4]->columnValue;
            }else{
              $explode = explode(" ",$value[3]->columnValue);
              $DBD_names .= $explode[0];
              $explode2 = explode(" ",$value[4]->columnValue);
              (count($explode2) == '2')? $DBD_names .= $explode2[1]:$DBD_names .= $explode2[0];
            }
            // $user_names .= $result['member_title'];
            $explode = explode(" ",$result['member_nameTh']);
            $user_names .= $explode[0];
            $explode2 = explode(" ",$result['member_lastnameTh']);
            (count($explode2) == '2')? $user_names .= $explode2[1]:$user_names .= $explode2[0];
            // $user_names .= $result['member_nameTh'];
            // $user_names .= $result['member_lastnameTh'];
            $DBD_names = str_replace(["/"," "], "", $DBD_names);
            // var_dump($user_names , $DBD_names);
            // die;
            if($user_names != $DBD_names){
               $this->update('tb_member_type1', ["status_case" => 2], ' member_id="' . $result['member_id'] . '"');
              $status = false;   
            }else{
              $this->update('tb_member_type1', ["status_case" => 99], ' member_id="' . $result['member_id'] . '"');
              break;
            }
          }
            return  $status;
      
        }
  function model_email_verify($member_cid = ''){
    $data = [];
    //-------- check db_sso ---------//
    $stmt = $this->db->prepare("SELECT email,cid,member_id,type FROM tb_member WHERE cid = ?");
    $stmt->bind_param("s", $member_cid);
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

    // //-------- check db_drive -------//
    // $stmt_drive = $this->db->prepare("SELECT UserID, Mail FROM Member_drive_v3 WHERE Username = ?");
    // $stmt_drive->bind_param("s", $member_cid);
    // $stmt_drive->execute();
    // $result_drive = $stmt_drive->get_result();
    // if($result_drive->num_rows){
    //   foreach($result_drive as $item_drive){
    //     $data_drive = $this->get_info_drive($member_cid);
    //     $result_drive = json_decode($data_drive,1);
    //     $mail_drive = '';
    //     if($result_drive != '' && $result_drive['code'] == 200 && $result_drive['message'] == 'OK'){
    //       if($result_drive['IsThai'] == 'Y' && $result_drive['UserType'] == "company") $mail_drive = $result_drive['Mail'];
    //       else if($result_drive['IsThai'] == 'N' && $result_drive['UserType'] == "company") $mail_drive = $result_drive['Mail'];
    //       else if($result_drive['IsThai'] == 'Y' && $result_drive['UserType'] == "individual") $mail_drive = $result_drive['Mail'];
    //       else if($result_drive['IsThai'] == 'N' && $result_drive['UserType'] == "individual") $mail_drive = $result_drive['Mail'];
    //     }
    //     if($mail_drive == ""){
    //       $mail_drive = $item_drive['Mail'];
    //     }
    //     $data[] = [
    //       'email' => $mail_drive,
    //       'member_id' => $item_drive['UserID'],
    //       'target' => 'DRIVE'
    //     ];
    //   }
    // }

    // //-------- check db_care ---------//
    // //$stmt_care = $this->db->prepare("SELECT member_id, member_email FROM Member WHERE member_cid = ?");
    // $stmt_care = $this->db->prepare("SELECT member_id, member_email FROM Member_v2 WHERE member_cid = ?");
    // $stmt_care->bind_param("s", $member_cid);
    // $stmt_care->execute();
    // $result_care = $stmt_care->get_result();
    // if($result_care->num_rows){
    //   foreach($result_care as $item_care){
    //     $data[] = [
    //       'email' => $item_care['member_email'],
    //       'member_id' => $item_care['member_id'],
    //       'target' => 'CARE'
    //     ];
    //   }
    // }

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

  function model_district($data = ''){
    $return = [];
    $member_cid = $data['member_id'];
    $result = $this->query("SELECT * FROM `tb_member_type1` WHERE `member_id` = $member_cid");
    if(!empty($result)){
      $title = null;
      $text = null;
      $url = null;
      $urltype2 = null;
      $next = null;
      $foot = null;

      if((empty($result[0]['director_date']) || $result[0]['director_date'] == '0000-00-00 00:00:00') && $result[0]['status_case'] != 99){
        // pr($result[0]['director_date']);
        // pr($result['member_id']);
        // die();
        $this->update('tb_member_type1', ["director_date" => date("Y-m-d H:i:s")], ' member_id="' . $result[0]['member_id'] . '"');

      } else if ($result[0]['director_date'] >  date("Y-m-d H:i:s",strtotime($result[0]['director_date']) ."300 Day")  && $result[0]['status_case'] != 99) {
        $this->update('tb_member_type1', ["status_case" => 4], ' member_id="' . $result[0]['member_id'] . '"');
      }
     
      if($result[0]['director_status'] == '1'   && $result[0]['status_case'] != '3' && $result[0]['status_case'] != '5' ){
        $attachment = $this->query("SELECT * FROM `tb_member_attachment` WHERE `member_id` = $member_cid");
        if(empty($attachment)){
          $this->checkDBD($result[0],$data['cid']);
        }else{
          foreach ($attachment as $key => $value) {
            if($value['status'] != '1'){
               $this->checkDBD($result[0],$data['cid']);
             }
          }
        }
        $result = $this->query("SELECT * FROM `tb_member_type1` WHERE `member_id` = $member_cid");
      }

      switch ($result[0]['status_case']) {
        case '0':
          if($result[0]['director_status'] == '1'){
            $icon = "warning";
            $title = 'แจ้งเตือนข้อมูลนิติบุคคล';
            $text = ' ระบบตรวจพบว่าชื่อกรรมการผู้มีอำนาจที่ท่านกรอก ไม่ตรงกับชื่อกรรมการในหนังสือรับรองการจดทะเบียนนิติบุคคลกับกรมพัฒนาธุรกิจการค้าหากท่านเป็นผู้รับมอบอำนาจ โปรดแนบเอกสารเพิ่มเติมเพื่อเป็นการยืนยันตัวตน';
            $url = "auth/attach_file?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];
            $next = true;
            // หากท่านยังไม่ได้รับการยืนยันตัวตน ท่านมีสิทธิเข้าใช้งานระบบได้เพียง 3 วัน
            $foot = "";
          }else{
            $icon = "warning";
            $title = 'แจ้งเตือนข้อมูลนิติบุคคล';
            $text = 'ระบบจะส่งอีเมลเพื่อยืนยันฐานะผู้รับมอบอำนาจของท่านไปยังอีเมลของกรรมการและกรรมการของท่านจะต้องกรอกข้อมูลยืนยัน เพื่ออนุมัติว่าท่านเป็นผู้รับมอบอำนาจจริง ';
            // หากท่านยังไม่ได้รับการยืนยันตัวตน ท่านมีสิทธิเข้าใช้งานระบบได้เพียง 3 วัน
            $foot = "หากมีปัญหาการใช้งาน ติดต่อ 1169";
          }
          $status_case = $result[0]['status_case'];
          break;
        case '1':
          $icon = "warning";
          $title = 'แจ้งเตือนข้อมูลนิติบุคคล';
          $text = ' สถานะผู้รับมอบอำนาจของท่านยังไม่ถูกยืนยันโดยกรรมการ <br>หรือยังไม่ได้แนบเอกสารมอบอำนาจ';
          $urltype2 = "auth/attach_file?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];
          $url = "auth/director_form?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];

          $next = true;
          // หากท่านยังไม่ได้รับการยืนยันตัวตน ท่านมีสิทธิเข้าใช้งานระบบได้เพียง 3 วัน
          $foot = "หากมีปัญหาการใช้งาน ติดต่อ 1169";
          $status_case = $result[0]['status_case'];
          break;
        case '2':
          $icon = "warning";
          $title = 'แจ้งเตือนข้อมูลนิติบุคคล';
          $text = ' ระบบตรวจพบว่าชื่อกรรมการผู้มีอำนาจที่ท่านกรอก ไม่ตรงกับชื่อกรรมการในหนังสือรับรองการจดทะเบียนนิติบุคคลกับกรมพัฒนาธุรกิจการค้าหากท่านเป็นผู้รับมอบอำนาจ โปรดแนบเอกสารเพิ่มเติมเพื่อเป็นการยืนยันตัวตน';
          $url = "auth/attach_file?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];
          $urltype2 = "auth/director_form?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];

          $next = true;
          // หากท่านยังไม่ได้รับการยืนยันตัวตน ท่านมีสิทธิเข้าใช้งานระบบได้เพียง 3 วัน
          $foot = "หากมีปัญหาการใช้งาน ติดต่อ 1169";
          $status_case = $result[0]['status_case'];
          break;
        case '3':
          $icon = "warning";
          $title = 'รอดำเนินการ';
          $text = ' เจ้าหน้าที่จะดำเนินการตรวจสอบเอกสารของท่านภายใน 1-3 วันทำการ';
          $foot = 'หากมีปัญหาการใช้งาน ติดต่อ 1169';
          $status_case = $result[0]['status_case'];
          $next = true;
          break;
        case '4':
          $icon = "warning";
          $title = 'ไม่สามารถเข้าใช้งานได้';
          $text = ' ท่านได้ใช้สิทธิ์เข้าใช้งานชั่วคราวครบกำหนดแล้ว หากต้องการใช้งานโปรดแนบเอกสารเพิ่มเติม เพื่อยืนยันตัวตน';
          $url = "auth/attach_file?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];
          $status_case = $result[0]['status_case'];
          $foot = 'หากมีปัญหาการใช้งาน ติดต่อ 1169';
          break;
        case '5':
          $icon = "error";
          $title = 'เอกสารของท่านไม่ได้รับการอนุมัติ';
          $text = ' ท่านยังไม่ได้รับการยืนยันตัวตน เนื่องจากเอกสารยืนยันตัวตนของท่านไม่สมบูรณ์ กรุณาแนบเอกสารใหม่เพื่อให้เจ้าหน้าที่ตรวจสอบอีกครั้ง';
          $url = "auth/attach_file?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];
          $urltype2 = "auth/director_form?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];
          $status_case = $result[0]['status_case'];
          $foot = 'หากมีปัญหาการใช้งาน ติดต่อ 1169';
          break;
        // case '7':
        //   $icon = "warning";
        //   $title = 'แจ้งเตือนข้อมูลนิติบุคคล';
        //   $text = ' สถานะผู้รับมอบอำนาจของท่านยังไม่ถูกยืนยันโดยกรรมการ หรือยังไม่ได้แนบเอกสารมอบอำนาจ';
        //   $url = "auth/attach_file?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];
        //   $urltype2 = "auth/director_form?q=".$result[0]['member_id']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&redirect_uri=".$_SESSION['redirect_uri'];

        //   $next = true;
        //   // หากท่านยังไม่ได้รับการยืนยันตัวตน ท่านมีสิทธิเข้าใช้งานระบบได้เพียง 3 วัน
        //   $foot = "";
        //   $status_case = $result[0]['status_case'];
        //   break;  
      }
      $return = [
        "title" => $title,
        "text" => $text,
        "icon" => $icon,
        "next" => $next,
        "url" => $url,
        "urltype2" => $urltype2,
        "foot" => $foot,
        "status_case" => $status_case,
        "member_id" => $member_cid,
        "director_status" => $result[0]['director_status'],
      ];
        // pr($return);
        // pr($result[0]['director_status']);
        // die();
    }
    return $return;
  }
  function model_sms_verify($member_cid = ''){
    $data = [];
    //-------- check db_sso ---------//
    $stmt = $this->db->prepare("SELECT email,cid,member_id,type FROM tb_member WHERE cid = ?");
    $stmt->bind_param("s", $member_cid);
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
        ($read['type'] == 1 || $read['type'] == 5 || $read['type'] == 6 )? $tel = $read_m['member_tel'] : $tel = $read_m['tel'];
        // ($read['type'] == 1 && $read_m['director_status'] == 2)? $tel = $read_m['director_tel'] : $tel = $tel;
        $name = $read_m['member_nameTh']; 
        $lastname = $read_m['member_lastnameTh'];
        
        if($tel != ""){
          $data[] = [
            'tel' => $tel,
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
            'tel' => $tel,
            'member_id' => $read['member_id'],
            'target' => 'SSO'
          ];
          $return = [
            'status' => '01',
            'message' => 'ไม่พบเบอร์โทรศัพท์ของท่านในระบบ กรุณาติดต่อเจ้าหน้าที่',$data
          ];
          return $return;
        }
      }
    }

    // //-------- check db_drive -------//
    // $stmt_drive = $this->db->prepare("SELECT UserID, Mail FROM Member_drive_v3 WHERE Username = ?");
    // $stmt_drive->bind_param("s", $member_cid);
    // $stmt_drive->execute();
    // $result_drive = $stmt_drive->get_result();
    // if($result_drive->num_rows){
    //   foreach($result_drive as $item_drive){
    //     $data_drive = $this->get_info_drive($member_cid);
    //     $result_drive = json_decode($data_drive,1);
    //     $mail_drive = '';
    //     if($result_drive != '' && $result_drive['code'] == 200 && $result_drive['message'] == 'OK'){
    //       if($result_drive['IsThai'] == 'Y' && $result_drive['UserType'] == "company") $mail_drive = $result_drive['Mail'];
    //       else if($result_drive['IsThai'] == 'N' && $result_drive['UserType'] == "company") $mail_drive = $result_drive['Mail'];
    //       else if($result_drive['IsThai'] == 'Y' && $result_drive['UserType'] == "individual") $mail_drive = $result_drive['Mail'];
    //       else if($result_drive['IsThai'] == 'N' && $result_drive['UserType'] == "individual") $mail_drive = $result_drive['Mail'];
    //     }
    //     if($mail_drive == ""){
    //       $mail_drive = $item_drive['Mail'];
    //     }
    //     $data[] = [
    //       'email' => $mail_drive,
    //       'member_id' => $item_drive['UserID'],
    //       'target' => 'DRIVE'
    //     ];
    //   }
    // }

    // //-------- check db_care ---------//
    // //$stmt_care = $this->db->prepare("SELECT member_id, member_email FROM Member WHERE member_cid = ?");
    // $stmt_care = $this->db->prepare("SELECT member_id, member_email FROM Member_v2 WHERE member_cid = ?");
    // $stmt_care->bind_param("s", $member_cid);
    // $stmt_care->execute();
    // $result_care = $stmt_care->get_result();
    // if($result_care->num_rows){
    //   foreach($result_care as $item_care){
    //     $data[] = [
    //       'email' => $item_care['member_email'],
    //       'member_id' => $item_care['member_id'],
    //       'target' => 'CARE'
    //     ];
    //   }
    // }

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

  function ck_login($user='',$pass='',$bool=false)
  {
    $return = [];
    if(!$bool) {
      $user=$this->post('username');
      $pass=$this->post('password');
    }

    $user_name = mysqli_real_escape_string($this->db,$user );


    if ($user_name == '') {
      $return['error'] = lang('required_user');

      return $return;
    }
 
    $user_password = $pass;
    $user_password_hash = $bool?$user_password:sha1($user_password);

    if ($user_password == ''){

      $return['error'] = lang('required_pass');

      return $return;
    }
    // var_dump($user_password_hash,$user_password);
    // die();

    $ck_user_name = preg_match("/@ditp.go.th/i", $user);
    if($ck_user_name == '1'){// && $_SESSION['client_id'] == "SS0047423"
      $userstaff = $this->userstaff(['email' => $user,'password' => $pass]);
      // $checkconsent = $this->checkconsent([$val,$return,$_SESSION['redirect_uri']]);
      // $return_data = array_merge($return, ['code' => $code , 'pdpa' => $checkconsent]);
      return $userstaff;
    }


    //---------------------------- All new ----------------------------//
 
      $stmt = $this->db->prepare("SELECT * FROM tb_member WHERE cid = ? AND password = ? AND status = 1");
      $stmt->bind_param("ss",$user_name, $user_password_hash);
      $stmt->execute();
      $result = $stmt->get_result();
      $num = $result->num_rows;

    if($num > 0){ //-- เจอใน tb_member sso ปกติ --//
      $val = $result->fetch_assoc();

      $insert_login_log = [
        'cid' => $user_name,
        'query' => "loop เช็คเจอ user ใน database",
        'result' => ($num > 0)?json_encode($val):0
      ];

      
      $login_log = $this->insert('tb_login_error_log', $insert_login_log);

      // เช็คว่ายืนยันอีเมลล์หรือ เบอร์ยัง
      if ($val['status_email_verify'] == 0 && $val['status_sms_verify'] == 0) {
        $mail = $this->model_email_verify($val['cid']);
        $sms = $this->model_sms_verify($val['cid']);
        return $return = [
          'status' => '02',
          'foot' => 'หากมีปัญหาการใช้งาน ติดต่อ 1169',
          'title' => lang('email_or_sms_not_verify'),
          'email' => ($mail['status'] == '00') ? $mail['result'][0]:$mail[0],
          'email_txt' => ($mail['status'] == '00') ? lang('email_verify_btn'):null,
          'email_btn' => ($mail['status'] == '00') ? '':'d-none',
          'sms' => ($sms['status'] == '00') ? $sms['result'][0]:$sms[0],
          'sms_txt' => ($sms['status'] == '00') ? lang('sms_verify_btn'):null,
          'sms_btn' => ($sms['status'] == '00') ? '':'d-none'
        ];
      }
      if($val['type'] == '1'){
        $district = $this->model_district($val);
        if(!empty($district) && $district['status_case'] != "99" && !empty($district['status_case'])){
          //Flow เดิมคือเช็คว่า status ไหนกดข้ามไม่ได้ อันใหม่คือข้ามได้หมด 23/1/2566
          // if($district['status_case'] == "0" || $district['status_case'] == "1" || $district['status_case'] == "2" || $district['status_case'] == "3"){
          //   $return = $this->get_data_return($val);
          //   $return_data = array_merge($return, ['district' => $district]);
          // }else{
          //   $return_data['district'] = $district;
          // }
          $return = $this->get_data_return($val);
          $return_data = array_merge($return, ['district' => $district]);
          $insert_login_log = [
            'cid' => $user_name,
            'query' => "เช็คว่าได้ token มาไหม",
            'result' => json_encode($return_data)
          ];

          
          $login_log = $this->insert('tb_login_error_log', $insert_login_log);
          return $return_data;
        }
        // $this->updateDBD(['cid' => $val['cid'],'member_id' => $val['member_id']]);
      }
      
      $sql_ck_token_care = "SELECT * FROM tb_token_external WHERE member_id = '".$val['member_id']."' AND member_type = 'CARE'";
      $result_ck_token_care = $this->query($sql_ck_token_care);

      // $result_ck_token_care = [];

      $sql_ck_id_drive = "SELECT * FROM tb_member_app_id WHERE member_id = '".$val['member_id']."' AND client_id = 'ssonticlient'";
      $result_ck_id_drive = $this->query($sql_ck_id_drive);
      // $result_ck_id_drive = [];
      $return = $this->get_data_return($val);
      $code = [];

      $insert_login_log = [
        'cid' => $user_name,
        'query' => "เช็คว่าได้ token มาไหม",
        'result' => json_encode($return)
      ];

      
      $login_log = $this->insert('tb_login_error_log', $insert_login_log);
      // var_dump($return);
      //       die();
      if(count($result_ck_token_care) <= 0){ //-- auto regis care
         $code_care = $this->get_code($val['member_id'], 'ssocareid');
        $code = [
          'code_care' => $code_care
        ];  
      }else{
        $code_care = $this->get_code($val['member_id'], 'ssocareid');
        $code = [
          'code_care' => $code_care
        ];  
      }

      if(count($result_ck_id_drive) <= 0){ //-- auto regis drive 
       $code_drive = $this->get_code($val['member_id'], 'ssonticlient');
       if(count($code) != 0){
          $code ['code_drive']= $code_drive;
       }else{
          $code = [ 
            'code_drive' => $code_drive
          ]; 
       }

      }
      // if((count($result_ck_id_drive) <= 0) && (count($result_ck_token_care) <= 0)){
      //   print_r($code);
      //   $code = array_merge($code, ['code_drive' => $code_drive]);
      //   var_dump((count($result_ck_id_drive) <= 0) && (count($result_ck_token_care) <= 0));

      // }
      $checkconsent = $this->checkconsent([$val,$return,$_SESSION['redirect_uri']]);
      //  var_dump($return);
      // die();    
    
      if(count($code) > 0 ){
        $return_data = array_merge($return, ['status' => "00",'district' => $district,'pdpa' => $checkconsent]);
        return $return_data;
      }
      // if(count($code) > 0 && $_SESSION['client_id'] != 'SS0047423'){
      //   $return_data = array_merge($return, ['code' => $code , 'pdpa' => $checkconsent]);
      //   return $return_data;
      // }
      //else if(count($code) > 0 && $_SESSION['client_id'] == 'SS0047423'){
      //   $return_data = array_merge($return, ['code' => $code , 'pdpa' => $checkconsent , 'status' => $_SESSION['state'] ]);
      //   return $return_data;
      // }else if($_SESSION['client_id'] == 'SS0047423'){
      //   $return_data = array_merge($return, ['pdpa' => $checkconsent , 'status' => $_SESSION['state'] ]);
      //   return $return_data;
      // }else{
      //   $return_data = array_merge($return, ['pdpa' => $checkconsent]);
      //   return $return_data;
      // }
      return $return;

    }else{
      $ck_user = $this->query("SELECT * FROM tb_member WHERE cid = $user_name  AND status = 1");
      $ck_user_del = $this->query("SELECT * FROM tb_member_backup WHERE cid = $user_name  AND status = 1");
      if(count($ck_user) == 0 && count($ck_user_del) == 0){
        $user_notfound = false;
      }else if(count($ck_user_del) > 0 && count($ck_user) == 0){
        $user_del = true;
      }else{
        $user_notfound = true;
      }
    }
    // else{
    //   $sql_ck_cid = "SELECT 1 FROM tb_member WHERE cid = '$user_name' AND status = 1";
    //   $result_ck_cid = $this->query($sql_ck_cid);

    //   if(count($result_ck_cid) > 0){
    //     //$return['error'] = lang('signin_fail');
    //     $return['error'] = lang('password_incorrect');
    //     return $return;
    //     exit;
    //   }

    //   //-- ถ้าไม่เจอใน tb_member sso จะไปหาอีก 2 ตาราง Member Member_drive --//
    //   $data = [];
    //   //$stmt_drive = $this->db->prepare("SELECT * FROM Member_drive WHERE Username = ?"); //หาใน Drive
    //   $stmt_drive = $this->db->prepare("SELECT * FROM Member_drive_v3 WHERE Username = ?"); //หาใน Drive
    //   $stmt_drive->bind_param("s",$user_name);
    //   $stmt_drive->execute();
    //   $result_drive = $stmt_drive->get_result();
    //   $num_drive = $result_drive->num_rows;
    //   // print_r($result_drive);
    //   // exit;
    //   if($num_drive > 0){
    //     $ck_drive = $this->verify_password_drive($user_name, $user_password);
    //     $data_ck = json_decode($ck_drive,1);
    //     if(isset($data_ck['VerifyStatus']) && ($data_ck['VerifyStatus'] == "True")){ //check user pass DRIVE
    //       $read_drive = $result_drive->fetch_assoc();
    //       array_push($data, array(
    //           "member_id" => $read_drive['UserID'],
    //           "member_name" => $read_drive['Firstname'],
    //           "member_lastname" => $read_drive['LastName'],
    //           "member_target" => '2', //1 = care, 2 = drive
    //           "member_target_name" => 'DRIVE'
    //         )
    //       );
    //     }else{
    //       $user_notfound = true;
    //     }
    //   }
    //   else{
    //     //$stmt_care = $this->db->prepare("SELECT * FROM Member WHERE member_cid = ?"); //หาใน care
    //     $stmt_care = $this->db->prepare("SELECT * FROM Member_v2 WHERE member_cid = ?");
    //     $stmt_care->bind_param("s",$user_name);
    //     $stmt_care->execute();
    //     $result_care = $stmt_care->get_result();
    //     $num_care = $result_care->num_rows;
    //     if($num_care > 0){
    //       while($read_care = $result_care->fetch_assoc()){
    //         $ck_care = $this->check_password($read_care['member_password'], $user_password); //check user pass CARE
    //         if($ck_care){
    //           array_push($data, array(
    //               "member_id" => $read_care['member_id'],
    //               "member_name" => $read_care['member_fname'],
    //               "member_lastname" => $read_care['member_lname'],
    //               "member_target" => '1', //1 = care, 2 = drive
    //               "member_target_name" => 'CARE'
    //             )
    //           );
    //         }else{
    //           $user_notfound = true;
    //         }
    //       }
    //     }
    //   }
      


    //   if(sizeof($data) == 1){ //--- กรณีเจอข้อมูลเดียว CARE หรือ DRIVE ---//
    //     //------- นำข้อมูลมา Insert tb_member --------//
    //     $table = $data[0]['member_target'];
    //     $id = $data[0]['member_id'];  //Primary ของ Drive

    //     if($table == 1){ //---- insert_care ----//
    //       //$sql_get = "SELECT * FROM Member where member_id ='" . $id ."'";
    //       $sql_get = "SELECT * FROM Member_v2 where member_id ='" . $id ."'";
    //       $data_get = $this->query($sql_get);
    //       $read_get = $data_get[0];
    //       //$type = $read_get['member_type']; //0 = คนทั่วไป, 1 = ตัวแทนบริษัท

    //       //--------------------- insert master tb_member --------------------------//
    //       $data_insert_member = [
    //         'member_app' => '',
    //         'member_app_id' => '',
    //         'cid' => $user_name,
    //         'password' => sha1($user_password),
    //         'type' => '3',
    //         'status' => '1'
    //       ];
    
    //       $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
    //       $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
    //       $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
    //       $ck_mem = $this->insert('tb_member', $data_insert_member);
    //       //--------------------- end of insert master tb_member ------------------------//


    //       //------------------------ insert tb_member_type3 ----------------------------------//
    //       if(!empty($ck_mem)){
    //         $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
    //         $result_max = $this->query($sql_max);
    //         $member_id = $result_max[0]['member_id'];

    //         //--------------------- insert member_app ----------------------//
    //         $data_insert_member_app = [
    //           'member_id' => $member_id, //id ของ tb_member
    //           'member_id_app' => $id, //primary in app
    //           'client_id' => 'ssocareid'
    //         ];
    //         $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
    //         //----------------- end of insert member_app -------------------//

    //         //------------- insert tb_token_external -----------------//
    //         $data_insert_token_external = [
    //           'member_id' => $member_id,
    //           'member_id_app' => $id,
    //           'token_code' => $read_get['member_api_key'],
    //           'member_type' => 'CARE',
    //         ];
    //         $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
    //         //------------- end of tb_token_external ----------------//
            
    //         $data_insert_type3 = [
    //           'member_id' => $member_id,
    //           'member_title' => '',
    //           'member_nameTh' => $read_get['member_fname'],
    //           'member_lastnameTh' => $read_get['member_lname'],
    //           'member_nameEn' => '',
    //           'member_lastnameEn' => '',
    //           'email' => $read_get['member_email'],
    //           'tel' => $read_get['member_cellphone'],
    //           'tel_country' => '',
    //           'tel_code' => '',
    //           'addressTh' => $read_get['member_address'],
    //           'provinceTh' => '',
    //           'districtTh' => '',
    //           'subdistrictTh' => '',
    //           'postcode' => $read_get['member_postcode'],
    //           'addressEn' => '',
    //           'provinceEn' => '',
    //           'districtEn' => '',
    //           'subdistrictEn' => ''
    //         ];
    //         $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

    //         $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
    //         $data_get2 = $this->query($sql_get2);
    //         $read_get2 = $data_get2[0];
    //         //$return = $this->get_data_return($read_get2);
    //         $data_return = $this->get_data_return($read_get2);
    //       }
    //       //----------------------- end of insert tb_member_type3 ---------------------------//

    //       //-------------------- insert_touch ----------------------------/
    //       $data_insert_touch = [
    //         'register_type' => 'FORM',
    //         'identify' => 'PERSONAL',
    //         'email' => $read_get['member_email'],
    //         'password' => $user_password,
    //         'firstname' => $read_get['member_fname'],
    //         'lastname' => $read_get['member_lname'],
    //         'citizen_id' => $user_name,
    //         'mobile' => $read_get['member_cellphone']
    //       ];
    //       $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

    //       if($insert_connect2['status'] == TRUE){

    //         //-------- update member_id and token connect --------//
    //         $member_id_connect = $insert_connect2['member_id'];
    //         $token_connect = $insert_connect2['token'];
    //         $id_connect = $insert_connect2['member_id'];

    //         $data_insert_member_app = [
    //           'member_id' => $member_id, //id ของ tb_member
    //           'member_id_app' => $member_id_connect, //primary in app
    //           'client_id' => 'SS6931846'
    //         ];
    //         $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

    //         //------- insert token_external --------//
    //         $data_insert_token_external = [
    //           'member_id' => $member_id,
    //           'member_id_app' => $id_connect,
    //           'token_code' => $token_connect,
    //           'member_type' => 'TOUCH',
    //         ];
    //         $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
    //       }
    //       //----------------------- End of insert touch -------------------------//


    //       //-------------------- return ----------------//
    //       $code_drive = $this->get_code($member_id, 'ssonticlient');
    //       $code = [
    //         'code_drive' => $code_drive
    //       ];
    //       $return = array_merge($data_return, ['code' => $code]);
    //       //----------------- end of return -----------------//

    //     }else if($table == 2){ //insert_drive
    //       //$sql_get = "SELECT * FROM Member_drive where UserID ='" . $id ."'";
    //       $sql_get = "SELECT * FROM Member_drive_v3 where UserID ='" . $id ."'";
    //       $data_get = $this->query($sql_get);
    //       $read_get = $data_get[0];
    //       $type = $read_get['UserType']; //corporate, person
    //       $is_thai = $read_get['Is_Thai'];

    //       if($type == 'corporate' ){
    //         //-- insert master member --//
    //         $data_insert_member = [
    //           'member_app' => '',
    //           'member_app_id' => '',
    //           'cid' => $user_name,
    //           'password' => sha1($user_password),
    //           'type' => ($is_thai == "Y")? '1' : '2',
    //           'status' => '1'
    //         ];
    //         $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
    //         $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
    //         $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
    //         $ck_mem = $this->insert('tb_member', $data_insert_member);
            
    //         if(!empty($ck_mem)){
    //           $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
    //           $result_max = $this->query($sql_max);
    //           $member_id = $result_max[0]['member_id']; //Primary ใน tb_member

    //           //-- insert member_app --//
    //           $data_insert_member_app = [
    //             'member_id' => $member_id, //id ของ tb_member
    //             'member_id_app' => $id, //primary in app
    //             'client_id' => 'ssonticlient'
    //           ];
    //           $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
    //           //-- end of insert member_app --//
              
    //           //----------- insert_touch ----------//
    //           $data_insert_touch = [
    //             'register_type' => 'FORM',
    //             'identify' => 'CORPORATE',
    //             'email' => $read_get['Mail'],
    //             'password' => $user_password,
    //             'company_name' => $read_get['Firstname'],
    //             'company_tax_id' => $user_name,
    //             'company_telephone' => $read_get['Telephone']
    //           ];
    //           $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 2), TRUE); //2 IS CORPORATE

    //           if($insert_connect2['status'] == TRUE){

    //             //-------- update member_id and token connect --------//
    //             $member_id_connect = $insert_connect2['member_id'];
    //             $token_connect = $insert_connect2['token'];
    //             $id_connect = $insert_connect2['member_id'];

    //             $data_insert_member_app = [
    //               'member_id' => $member_id, //id ของ tb_member
    //               'member_id_app' => $member_id_connect, //primary in app
    //               'client_id' => 'SS6931846'
    //             ];
    //             $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

    //             //------- insert token_external --------//
    //             $data_insert_token_external = [
    //               'member_id' => $member_id,
    //               'member_id_app' => $id_connect,
    //               'token_code' => $token_connect,
    //               'member_type' => 'TOUCH',
    //             ];
    //             $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
    //           }
    //           //-------- End of insert touch ---------//

    //           if($is_thai == "Y"){
    //             $member_type_connect = "THAI";
    //             //-- insert member_type1 --//
    //             $data_insert_type1 = [
    //               'member_id' => $member_id,
    //               'company_nameTh' => $read_get['Firstname'],
    //               'member_email' => $read_get['Mail'],
    //               'member_tel' => $read_get['Telephone'],
    //             ];
    
    //             $insert_type1 = $this->insert('tb_member_type1', $data_insert_type1);

    //             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
    //             $data_get2 = $this->query($sql_get2);
    //             $read_get2 = $data_get2[0];
    //             //$return = $this->get_data_return($read_get2);
    //             $data_return = $this->get_data_return($read_get2);

    //           }else if($is_thai == "N"){
    //             $member_type_connect = "FOREIGN";
    //             //-- insert member_type2 --//
    //             $data_insert_type2 = [
    //               'member_id' => $member_id,
    //               'corporate_name' =>  $read_get['Firstname'],
    //               'email' => $read_get['Mail'],
    //               'tel' => $read_get['Telephone'],
    //             ];
    
    //             $insert_type2 = $this->insert('tb_member_type2', $data_insert_type2);

    //             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
    //             $data_get2 = $this->query($sql_get2);
    //             $read_get2 = $data_get2[0];
    //             //$return = $this->get_data_return($read_get2);
    //             $data_return = $this->get_data_return($read_get2);
    //           }
    //         }

    //       }else if($type == 'person'){
    //         //-- insert master member --//
    //         $data_insert_member = [
    //           'member_app' => '',
    //           'member_app_id' => '',
    //           'cid' => $user_name,
    //           'password' => sha1($user_password),
    //           'type' => ($is_thai == "Y")? '3' : '4',
    //           'status' => '1'
    //         ];
    //         $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
    //         $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
    //         $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
    //         $ck_mem = $this->insert('tb_member', $data_insert_member);
            
    //         if(!empty($ck_mem)){
    //           $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
    //           $result_max = $this->query($sql_max);
    //           $member_id = $result_max[0]['member_id'];

    //           //--------------------- insert member_app ----------------------//
    //           $data_insert_member_app = [
    //             'member_id' => $member_id, //id ของ tb_member
    //             'member_id_app' => $id, //primary in app
    //             'client_id' => 'ssonticlient'
    //           ];
    //           $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
    //           //----------------- end of insert member_app -------------------//

    //           //------------------ insert touch -----------------------//
    //           $data_insert_touch = [
    //             'register_type' => 'FORM',
    //             'identify' => 'PERSONAL',
    //             'email' => $read_get['Mail'],
    //             'password' => $user_password,
    //             'firstname' => $read_get['Firstname'],
    //             'lastname' => $read_get['LastName'],
    //             'citizen_id' => $user_name,
    //             'mobile' => $read_get['Telephone']
    //           ];
    //           $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

    //           if($insert_connect2['status'] == TRUE){

    //             //-------- update member_id and token connect --------//
    //             $member_id_connect = $insert_connect2['member_id'];
    //             $token_connect = $insert_connect2['token'];
    //             $id_connect = $insert_connect2['member_id'];

    //             $data_insert_member_app = [
    //               'member_id' => $member_id, //id ของ tb_member
    //               'member_id_app' => $member_id_connect, //primary in app
    //               'client_id' => 'SS6931846'
    //             ];
    //             $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

    //             //------- insert token_external --------//
    //             $data_insert_token_external = [
    //               'member_id' => $member_id,
    //               'member_id_app' => $id_connect,
    //               'token_code' => $token_connect,
    //               'member_type' => 'TOUCH',
    //             ];
    //             $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
    //           }
    //           //------------------ End of insert touch -----------------------//

    //           if($is_thai == "Y"){ //-- บุคคลไทย
    //             $member_type_connect = "THAI";
    //             //-- insert member_type3 --//
    //             $data_insert_type3 = [
    //               'member_id' => $member_id,
    //               'member_nameTh' => $read_get['Firstname'],
    //               'member_lastnameTh' => $read_get['LastName'],
    //               'email' => $read_get['Mail'],
    //               'tel' => $read_get['Telephone'],
    //             ];
    //             $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

    //             //-- get_return state --//
    //             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
    //             $data_get2 = $this->query($sql_get2);
    //             $read_get2 = $data_get2[0];
    //             //$return = $this->get_data_return($read_get2);
    //             $data_return = $this->get_data_return($read_get2);

    //           }else if($is_thai == "N"){ //-- บุคคลต่างชาติ
    //             $member_type_connect = "FOREIGN";
    //             //-- insert member_type4 --//
    //             $data_insert_type4 = [
    //               'member_id' => $member_id,
    //               'member_nameEn' => $read_get['Firstname'],
    //               'member_lastnameEn' => $read_get['LastName'],
    //               'email' => $read_get['Mail'],
    //               'tel' => $read_get['Telephone'],
    //             ];
    //             $insert_type4 = $this->insert('tb_member_type4', $data_insert_type4);

    //             //-- get_return state --//
    //             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
    //             $data_get2 = $this->query($sql_get2);
    //             $read_get2 = $data_get2[0];
    //             //$return = $this->get_data_return($read_get2);
    //             $data_return = $this->get_data_return($read_get2);
    //           }
    //         }
    //       }

    //       //-------------------- return ----------------//
    //       $code_care = $this->get_code($member_id, 'ssocareid');
    //       $code = [
    //         'code_care' => $code_care,
    //         'xx' => $user_password,
    //         'ee' => $read_get['Mail']
    //       ];
    //       $return = array_merge($data_return, ['code' => $code]);
    //       //----------------- end of return -----------------//
    //     }
    //   }else if(sizeof($data) > 1){
    //     $_SESSION['user_name'] = $user_name;
    //     $_SESSION['user_password'] = $user_password;

    //     $return = ['status' => '01', 'data' => $data];
    //   }
    // }

    if (empty($return)) {
      //$return['error'] = lang('signin_fail');

      if($user_notfound){
        $return['error'] = lang('password_incorrect');
        return $return;
      }else if($user_del){
        $return['error'] = 'user_delete' ;
       return $return;
      }else{
          (lang('user_notfound') == 'ไม่พบผู้ใช้ในระบบ')? $return['error'] = 'ไม่พบบัญชีผู้ใช้งาน' : $return['error'] = lang('user_notfound') ;
        }

    }

    return $return;
  }


  function ck_login_moc($val = [])
  {

    
    $return = [];
    
    if($val->IsVerify=='Y'){
      if($val->Type=="person"){
        $type = 3;
      }
      else if($val->Type=="juristic"){
        $type = 1;

      }
      else{
        $type = 5;
      }
 
    //---------------------------- All new ----------------------------//

    $sql_ck_cid = "SELECT * FROM tb_member WHERE cid = $val->IdentificationNo";
    $cid = $this->query($sql_ck_cid);
  //  return $cid;
    if(!empty($cid)){ //-- เจอใน tb_member sso ปกติ --//
     
      $sql_ck_moc_id = "SELECT member_id FROM tb_member WHERE cid = $val->IdentificationNo AND moc_account_id IS NULL";
      $moc_id = $this->query($sql_ck_moc_id);
      $member_id = $moc_id[0]['member_id'];

      if (!empty($moc_id)){ // กรณีเจอเลขบัตรประชาชน แต่ไม่มี moc_account
        $update_sql = "UPDATE tbl_member SET moc_account_id = $val->ID WHERE member_id = $member_id ";
        $update_moc_id = $this->update('tb_member', ['moc_account_id'=>$val->ID ], "member_id = $member_id");
       
          if($update_moc_id){
            $sql_sso_id = "SELECT cid , password FROM tb_member WHERE moc_account_id = $val->ID";
            $sso_id = $this->query($sql_sso_id);
            if(!empty($sso_id)){
              $redirect_login = $this->ck_login($sso_id[0]['cid'],$sso_id[0]['password'],true);
              header("Location: ".$redirect_login['url']);
              exit;

            }
           
            $return = 'Update Moc_account Success';
          }
          else{
            $return = 'Not Update';

          }

     
        
      }
      else {// กรณีเจอเลขบัตรประชาชน มี moc_account
        $sql_sso_moc = "SELECT cid , password FROM tb_member WHERE moc_account_id = $val->ID";
        $sso_moc = $this->query($sql_sso_moc);
        
        if(!empty($sso_moc)){
          $return = 'Moc account Have sso_id';
          
          $redirect_login = $this->ck_login($sso_moc[0]['cid'],$sso_moc[0]['password'],true);
          header("Location: ".$redirect_login['url']);
          
          exit;
          // return $redirect_login['url'];
        }
        else {
          $return = 'No Have sso_id';
        }
        // $return = $sql_sso_id;
        
   
      }
     

    }else {  // กรณีไม่มีเลขบัตรประชาชนนี้ใน SSO 
  
      $date_now = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
      $select_max = 'SELECT MAX(sso_id) as sso_id FROM tb_member';
      $maxid = $this->query($select_max);
      $sso_id = $maxid[0]['sso_id']+1;
   
   
        $insert_data_moc = [
          'sso_id' => $sso_id,
          'cid' => $val->IdentificationNo,
          'password' => sha1($val->IdentificationNo),
          'type' => $type,
          'register_from' => 3,
          'status' => 1,
          'status_update_drive' => 'N',
          'moc_account_id' => $val->ID,
          'create_date' => $date_now,
          'update_date' => $date_now,

        ];
  
        $last_id = $this->insert('tb_member', $insert_data_moc);
        $sql_select_account = "SELECT member_id , type FROM tb_member WHERE moc_account_id = $val->ID";
        $result_account = $this->query($sql_select_account);


      if(!empty($sql_select_account)){
        if($result_account[0]['type']==3){
          $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $result_max = $this->query($sql_max);
            $member_id = $result_max[0]['member_id'];
            $data_insert_type3 = [
              'member_id' => $result_account[0]['member_id'],
              'member_title' => $val->TitleName,
              'member_nameTh' => $val->FirstName,
              'member_lastnameTh' => $val->LastName,
              'member_nameEn' => $val->FirstNameEn,
              'member_lastnameEn' => $val->LastNameEn,
              'email' => $val->Email,
              'tel' => ' ',
              'tel_country' => 'TH',
              'tel_code' => '+66',
              'addressTh' => ' ',
              'provinceTh' => ' ',
              'districtTh' => ' ',
              'subdistrictTh' => ' ',
              'postcode' => ' ',
              'addressEn' => ' ',
              'provinceEn' => ' ',
              'districtEn' => ' ',
              'subdistrictEn' => ' ',
            ];

            $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

            $return = 'insert success';
        }
        else if($result_account[0]['type']==1){
          $type = 1;

          $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $result_max = $this->query($sql_max);
            $member_id = $result_max[0]['member_id'];
    
            $data_insert_type1 = [
              'member_id' => $member_id,
              'company_nameTh' => $val->DepartmentName,
              'company_nameEn' => $val->DepartmentName,
              'company_addressTh' => ' ',
              'company_provinceTh' => ' ',
              'company_districtTh' => ' ',
              'company_subdistrictTh' => ' ',
              'company_postcodeTh' => ' ',
              'company_addressEn' => ' ',
              'company_provinceEn' => ' ',
              'company_districtEn' => ' ',
              'company_subdistrictEn' => ' ',
              'company_postcodeEn' => ' ',
              'contact_address' => ' ',
              'contact_province' => ' ',
              'contact_district' => ' ',
              'contact_subdistrict' => ' ',
              'contact_postcode' => ' ',
              'member_title' => $val->TitleName,
              'member_cid' => $val->IdentificationNo,
              'member_nameTh' => $val->FirstName,
              'member_lastnameTh' => $val->LastName,
              'member_nameEn' => $val->FirstNameEn,
              'member_lastnameEn' => $val->LastNameEn,
              'member_email' => $val->Email,
              'member_tel' => ' ',
              'member_tel_country' => 'TH',
              'member_tel_code' => '+66',
            ];

            $insert_type1 = $this->insert('tb_member_type1', $data_insert_type1);

            $return = 'insert success';
        }
        else{
          $type = 5;

          $return = 'insert success';
        }

      }

    }
  }
  else{ // กรณี Verify = 'N'
    // header("Location: https://account.moc.go.th/profile");
    echo "<script>
    alert('กรุณายืนยันตัวตน ที่ Moc account ก่อนการใช้งาน');
    window.location.href='https://account.moc.go.th/profile';
    </script>";
    exit;
    $return = "https://account.moc.go.th/profile";
  }

    return $return;
  }
  
  function gen_access($member_id = '')
  {
    $accesstoken = md5($_SESSION['client_id'] . $member_id . date('YmhHis') . session_id());
    $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours"));
    $insert_access = [
      'member_id' => $member_id,
      'ac_code' => $accesstoken,
      'client_id' => $_SESSION['client_id'],
      'status' => 1,
      'exp_date' => $end_date,
    ];

    $last_id = $this->insert('tb_access_code', $insert_access);
    $return = [];
    if ($last_id) {
      $return['access'] = $accesstoken;
      $return['exp_date'] = $end_date;
    }
    return $return;
  }

  function gen_portal_access($client_id = '', $member_id = '')
  {
    $accesstoken = md5($client_id . $member_id . date('YmhHis') . session_id());
    $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours"));
    $insert_access = [
      'member_id' => $member_id,
      'ac_code' => $accesstoken,
      'client_id' => $client_id,
      'status' => 1,
      'exp_date' => $end_date,
    ];

    $last_id = $this->insert('tb_access_code', $insert_access);
    $return = [];
    if ($last_id) {
      $return['access'] = $accesstoken;
      $return['exp_date'] = $end_date;
    }
    return $return;
  }

  function gen_access_new($member_id = '', $client_id = '')
  {
    $accesstoken = md5($client_id . $member_id . date('YmhHis') . session_id());
    $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours"));
    $insert_access = [
      'member_id' => $member_id,
      'ac_code' => $accesstoken,
      'client_id' => $client_id,
      'status' => 1,
      'exp_date' => $end_date,
    ];

    $last_id = $this->insert('tb_access_code', $insert_access);
    $return = [];
    if ($last_id) {
      $return['access'] = $accesstoken;
      $return['exp_date'] = $end_date;
    }
    return $return;
  }

  function gen_token($member_id = '')
  {
    /******** insert tb_token ***************/
    $token_code = sha1($_SESSION['client_id'] . $member_id . date('YmhHis') . session_id()); 
    $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours")); //2 hours

    $insert_token = [
      'member_id' => $member_id,
      'token_code' => $token_code,
      'client_id' => $_SESSION['client_id'],
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
        $refresh_token_code = sha1("refresh_token".$_SESSION['client_id'] . $member_id . date('YmhHis') . session_id());
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
  }

  function gen_portal_token($client_id = '', $member_id = '')
  {
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
  }

  function gen_token_new($member_id = '', $client_id = '')
  {
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
  }
  function get_client_name ($client_id = '') {

    $sql = "SELECT * FROM tb_merchant WHERE client_id = '".mysqli_real_escape_string($this->db, $client_id)."' and status = 1";
    $query = $this->query($sql);
    $return = $query[0];  
    return $return;
  }
  function ck_client_id($client_id = '')
  {
    $_SESSION['client_id'] = "";
    $sql = "SELECT 1 FROM tb_merchant WHERE client_id='" . mysqli_real_escape_string($this->db, $client_id) . "' and status = 1";
    $data = $this->query($sql);

    if (count($data) > 0) $_SESSION['client_id'] = $client_id;
  }

  function ck_token($token = '')
  {
    $date_now = date("Y-m-d H:i:s");
  
    $sql = "SELECT member_id FROM tb_token WHERE token_code = '" . mysqli_real_escape_string($this->db, $token) . "' AND exp_date > '".$date_now."'";
    $data = $this->query($sql);

    if (count($data) > 0){
      $_SESSION['token'] = $token;
      $_SESSION['member_id'] = $data[0]['member_id'];
    } 
  }

  function ck_code($token = '')
  {
    $code = $token;
    $sql_m = 'SELECT * FROM tb_merchant where client_id="' .$_SESSION['client_id']. '" and status = 1 limit 1';
    $query = $this->query($sql_m);

    if (count($query) > 0) {
      $data = $query[0];
      $key = $data['jwt_signature'];

      $sub_code = explode(' ', $code);
      if ($code != "") {
          try {
            $decoded = JWT::decode($code, $key, array('HS256'));
            if (empty($decoded->id_token)) {
              $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
            } else {
              $id_token  = $decoded->id_token;
            }
          } catch (Exception $e) {
            $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
          }
      } else {
        $return = ['res_code' => '01', 'res_text' => 'Code Not Found.'];
      }
    }
    if($return !=""){
      echo json_encode($return);
      exit;
    }
    $date_now = date("Y-m-d H:i:s");
    $sql = "SELECT member_id FROM tb_token WHERE token_code = '$id_token' AND exp_date > '".$date_now."'";
    $data = $this->query($sql);

    if (count($data) > 0){
      $_SESSION['token'] = $token;
      $_SESSION['member_id'] = $data[0]['member_id'];
    } 
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


  function get_reurl()
  {
    $url = '';
    if (!empty($_SESSION['redirect_uri'])) {
      $data_client = $this->get_data_client($_SESSION['client_id']);
      $url = $data_client['redirect_uri'];
    }
    return $url;
  }

  function model_newpassword(){
    $return = [];
    $error = [];

    $old_password = $this->post('old_password');
    $new_password = $this->post('new_password');
    $new_password2 = $this->post('new_password2');
    $new_password_hash = sha1($new_password);

    // var_dump($old_password,$new_password, $new_password2);
    // die();
   

    /******** check input empty **************/
    if(empty($old_password)) $error['old_password'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณากรอกข้อมูล';
    if(empty($new_password)) $error['new_password'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณากรอกข้อมูล';
    if(empty($new_password2)) $error['new_password2'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณากรอกข้อมูล';
    if(empty($new_password2)) $error['new_password2'] = 'ไม่สามารถเปลี่ยนรหัสผ่านได้<br>กรุณากรอกข้อมูล';

    if ($_SESSION['lang'] == 'en') {
      if(empty($old_password)) $error['old_password'] = 'Please fill in all required fields.';
      if(empty($new_password)) $error['new_password'] = 'Please fill in all required fields.';
      if(empty($new_password2)) $error['new_password2'] = 'Please fill in all required fields.';
      if(empty($new_password2)) $error['new_password2'] = 'Please fill in all required fields.';
    }
    if($_SESSION['member_id'] != "" ){
      $ck_member_id = $_SESSION['member_id'];
        $table = 'member_id';
        $text = 'redirect';
        $redirect_uri = $_SESSION['redirect_uri'];
      }else{
    $ck_member_id = $this->post('member_id');
        if(empty($ck_member_id)) $error['member_id'] = 'กรุณากรอกข้อมูล';
        if ($_SESSION['lang'] == 'en') {
          if(empty($ck_member_id)) $error['member_id'] = 'Please fill in all required fields.';
        }
        $table = 'cid';
        $text = 'message';
        $redirect_uri = 'sucess';
    }
    /************* strong password ***********/
    // if(!preg_match("#[a-zA-Z]+#", $new_password)) {
    //   if($_SESSION['lang'] == 'en'){
    //     $error['new_password'] = "must include at least one letter!";
    //   }else{
    //     $error['new_password'] = "ต้องมี a - z อย่างน้อย 1 ตัว";
    //   }
    // }

    if(strlen($new_password) < 8) {
      if($_SESSION['lang'] == 'en'){
        $error['new_password'] = "more than 8 characters";
      }else{
        $error['new_password'] = "กรุณาป้อนรหัสผ่าน 8 ตัวขึ้นไป";
      }
    }

    if($error){
      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];
      return json_encode($return);
    }
    
    /********** check confirm new_password  **************/
    if($new_password != $new_password2){
      if($_SESSION['lang'] == 'en'){
        $error['new_password2'] = 'Not match';
      }else{
        $error['new_password2'] = 'ไม่ตรงกัน';
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];
      return json_encode($return);
    }

    /************ check old_password  *************/
    $sql = "SELECT * FROM tb_member WHERE $table = '" . $ck_member_id . "' AND password = '" . sha1($old_password) . "'";
    $data = $this->query($sql);
 
    if(count($data) < 1){
      if($_SESSION['lang'] == 'en'){
        $error['old_password'] = 'Not found';
      }else{
        $error['old_password'] = 'ไม่มีในระบบ';
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];
      return json_encode($return);
    }

    /************* check รหัสผ่านใหม่ว่าตรงกับที่มีอยู่หรือไม่ **************/
    $sql2 = "SELECT * FROM tb_member WHERE $table = '" . $ck_member_id . "' AND password = '" . sha1($new_password) . "'";
    $data2 = $this->query($sql2);

    if(count($data2) > 0){
      if($_SESSION['lang'] == 'en'){
        $error['new_password'] = 'is your old password';
      }else{
        $error['new_password'] = 'ตรงกับรหัสผ่านเดิม';
      }

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];
      return json_encode($return);
    }


    if (empty($error)) {
      //example :: $this->update('tb_member',['password'=>$new_password]," member_id = 5 and boot < 5");

      try{
        $this->update('tb_member', ['password'=>sha1($new_password)], "$table ='$ck_member_id'");
      } catch (Exception $e){
        if($_SESSION['lang'] == 'en'){
          $error['Error'] = 'save fail';
        }else{
          $error['Error'] = 'ดำเนินการไม่สำเร็จ';
        }
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['code' => '01', 'error' => $error_res];
        return json_encode($return);
      }finally{
        //redirect($_SESSION['redirect_uri']);
        $return = [$text => $redirect_uri];
        return json_encode($return);
      }
    }
  }
  function model_resetpassword(){
    $return = [];
    $error = [];
    /******** check input empty **************/
    $ck_member_id = $this->post('member_id');
        if(empty($ck_member_id)) $error['member_id'] = 'กรุณากรอกข้อมูล';
        $table = 'cid';
        $text = 'message';
        $sql2 = "SELECT * FROM tb_member WHERE $table = '" . $ck_member_id . "' limit 1";
        $data2 = $this->query($sql2);
        if(empty($data2)) $error['member_id'] = 'MemberID Not found';
        $redirect_uri = 'sucess';
        $new_password = uniqid();
    if($error){
      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }
      $return = ['code' => '01', 'error' => $error_res];
      return json_encode($return);
    }
    if (empty($error)) {
      
      try{
        $this->update('tb_member', ['password'=>sha1($new_password)], "$table ='$ck_member_id'");
      } catch (Exception $e){
        if($_SESSION['lang'] == 'en'){
          $error['Error'] = 'save fail';
        }else{
          $error['Error'] = 'ดำเนินการไม่สำเร็จ';
        }
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['code' => '01', 'error' => $error_res];
        return json_encode($return);
      }finally{
        //redirect($_SESSION['redirect_uri']);
        $return = [$text => $redirect_uri,'data'=>$new_password];
        return json_encode($return);
      }
    }
  }
  function model_gen_token($member_id = '',$client_id)
  {
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
  }
  function model_getToken($ck_mem, $client_id){
    $data_client = $this->get_data_client($client_id);
    $key = $data_client['jwt_signature'];
    $response_type = 'TOKEN';

  if (strtoupper($response_type) == 'TOKEN') {
      $data_token = $this->model_gen_token($ck_mem,$client_id);
      if (!empty($data_token['token'])) {

        $jwt_data = [
          'id_token' => $data_token['token'],
          'refresh_token' => $data_token['refresh_token'],
          'end_date' =>  $data_token['exp_date'],
          'end_date_refresh' =>  $data_token['exp_date_refresh'],
          "token_type" => "Bearer"
        ];
        $jwt = JWT::encode($jwt_data, $key);
        $state =  $_SESSION['state'];
        //$url .= 'code=' . $jwt . "&state=" . $state;
        $code = $jwt;

        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
      //$return = ['code' => '00', 'success' => 1, 'url' => $url];
      return $code;
    }
  }
  function model_checkloginSSO(){
    $return = [];
    $error = [];

    $pass = $this->post('password');
    $user = $this->post('username');
   

    // /******** check input empty **************/
    // if(empty($password)) $error['password'] = 'กรุณากรอกข้อมูล';
    // if(empty($ck_member_id)) $error['username'] = 'กรุณากรอกข้อมูล';
    // if($error){
    //   $error_res = [];
    //   foreach ($error as $key => $value) {
    //     $error_res[] = [
    //       'name' => $key,
    //       'value' => $value
    //     ];
    //   }
    //   $return = ['code' => '01', 'error' => $error_res];
    //   return json_encode($return);
    // }

    // /************ check old_password  *************/
    // $sql = "SELECT * FROM tb_member WHERE cid = '" . $ck_member_id . "' AND password = '" . sha1($password) . "'";
    // $data = $this->query($sql);
 
    // if(count($data) < 1){
    //   if($_SESSION['lang'] == 'en'){
    //     $error['password'] = 'Not found';
    //   }else{
    //     $error['password'] = 'ไม่มีในระบบ';
    //   }

    //   $error_res = [];
    //   foreach ($error as $key => $value) {
    //     $error_res[] = [
    //       'name' => $key,
    //       'value' => $value
    //     ];
    //   }
    //   $return = ['code' => '01', 'error' => $error_res];
    //   return json_encode($return);
    // }else{
    //   foreach ($data as $itemCk){
    //     $error_res = [
    //       'code' => 200,
    //       'message' => 'sucess',
    //       'data' => [
    //         'sso_id' => strval($itemCk['sso_id']),
    //         'cid' => strval($itemCk['cid']),
    //       ]
    //     ];
    //   }
    //   $return = $error_res;
    //   return json_encode($return);
    // }
    $user_name = mysqli_real_escape_string($this->db,$user );
   

    if ($user_name == '') {
       $return['username'] = 'กรุณากรอกข้อมูล';
      return $return;
    }
    $user_password = $pass;
    $user_password_hash = sha1($user_password);

    if ($user_password == ''){
      $return['password'] = 'กรุณากรอกข้อมูล';
      return $return;
    }
 


    //---------------------------- All new ----------------------------//

    $stmt = $this->db->prepare("SELECT * FROM tb_member WHERE cid = ? AND password = ? AND status = 1");
    $stmt->bind_param("ss",$user_name, $user_password_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;

    if($num > 0){ //-- เจอใน tb_member sso ปกติ --//

      $val = $result->fetch_assoc();
      $sql_ck_id_drive = "SELECT * FROM tb_member_app_id WHERE member_id = '".$val['member_id']."' AND client_id = 'ssonticlient'";
      $result_ck_id_drive = $this->query($sql_ck_id_drive);
      $code_drive = $this->model_getToken($val['member_id'], 'ssonticlient');
      $code = [];
       if(count($result_ck_id_drive) <= 0){ //-- auto regis drive
        $code = [
          'code_drive' => $code_drive
        ]; 
      }else{
        $code = [
          'code_drive' => $code_drive
        ]; 
      }
      return $code;
    }else{
      $return['error'] = 'ไม่พบบัญชีผู้ใช้งาน';
    }
    if (empty($code)) {
       $return['error'] = 'ไม่พบบัญชีผู้ใช้งาน';
    }
    return $return;
  }
  
  function get_return_url($ck_mem){
    $data_client = $this->get_data_client($_SESSION['client_id']);
    $url = $data_client['redirect_uri'];
    if (!empty($_SESSION['redirect_uri'])) {
      $redirect_uri = $_SESSION['redirect_uri'];
      $url = $redirect_uri;
    }
    $query_url = parse_url($url, PHP_URL_QUERY);
    if ($query_url) {
      $url .= '&';
    } else {
      $url .= '?';
    }
    $key = $data_client['jwt_signature'];
    $response_type = $_SESSION['response_type'];


    if (strtoupper($response_type) == 'CODE') {
      $data_access = $this->gen_access($ck_mem);
      if (!empty($data_access['access'])) {
        $jwt_data = [
          'access_token' => $data_access['access'],
          'end_date' => $data_access['exp_date'],
          "token_type" => "Bearer"
        ];
        $jwt = JWT::encode($jwt_data, $key);
        $url .= 'code=' . $jwt;

        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_access'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        //$return = ['code' => '00', 'success' => 1, 'url' => $url];
        return $url;
      }
    } else if (strtoupper($response_type) == 'TOKEN') {
      $data_token = $this->gen_token($ck_mem);
      if (!empty($data_token['token'])) {

        $jwt_data = [
          'id_token' => $data_token['token'],
          'refresh_token' => $data_token['refresh_token'],
          'end_date' =>  $data_token['exp_date'],
          'end_date_refresh' =>  $data_token['exp_date_refresh'],
          "token_type" => "Bearer"
        ];

        /*$jwt_data = [
          'id_token' => $data_token['token'],
          'end_date' =>  $data_token['exp_date'],
          "token_type" => "Bearer"
        ];*/
        $jwt = JWT::encode($jwt_data, $key);
        $state =  $_SESSION['state'];
        $url .= 'code=' . $jwt . "&state=" . $state;

        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
      //$return = ['code' => '00', 'success' => 1, 'url' => $url];
      return $url;
    }
  }

  function model_insert(){
    $target = $this->post('target');
    $id = $this->post('id');
    $user_password = $this->post('ss');
    $user_name = $this->post('cid');
    //----------------------- Insert care ----------------------------//
    if($target == 1){ //1 = care, 2 = drive
      //$stmt = $this->db->prepare("SELECT * FROM Member WHERE member_id = ?");
      $stmt = $this->db->prepare("SELECT * FROM Member_v2 WHERE member_id = ?");
      $stmt->bind_param("s", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $read = $result->fetch_assoc();

      //---------------------- insert Member care ----------------------//
      $data_insert_member = [
        'member_app' => '',
        'member_app_id' => '',
        'cid' => $user_name,
        'password' => sha1($user_password),
        'type' => '3', //บุคคลทั่วไป ใน tb_member
        'status' => '1'
      ];

      $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
      $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
      $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
      $ck_mem = $this->insert('tb_member', $data_insert_member); //--- tb_member master ---//

      if(!empty($ck_mem)){
        $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
        $result_max = $this->query($sql_max);
        $member_id = $result_max[0]['member_id'];
        $data_insert_type3 = [
          'member_id' => $member_id,
          'member_title' => '',
          'member_nameTh' => $read['member_fname'],
          'member_lastnameTh' => $read['member_lname'],
          'member_nameEn' => '',
          'member_lastnameEn' => '',
          'email' => $read['member_email'],
          'tel' => $read['member_cellphone'],
          'addressTh' => $read['member_address'],
          'provinceTh' => '',
          'districtTh' => '',
          'subdistrictTh' => '',
          'postcode' => $read['member_postcode'],
          'addressEn' => '',
          'provinceEn' => '',
          'districtEn' => '',
          'subdistrictEn' => ''
        ];
        $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

        //--------------------- insert member_app ----------------------//
        $data_insert_member_app = [
          'member_id' => $member_id, //id ของ tb_member
          'member_id_app' => $id, //primary in app
          'client_id' => 'ssocareid'
        ];
        $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
        //------------------------------------------------------------//

        //----------------- insert tb_token_external ------------------//
        $data_insert_token_external = [
          'member_id' => $member_id,
          'member_id_app' => $id,
          'token_code' => $read['member_api_key'],
          'member_type' => 'CARE',
        ];
        $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
        //-------------------------------------------------------------//

        //AutoRegis TOUCH
        //-------------------- insert_touch ----------------------------/
        $data_insert_touch = [
          'register_type' => 'FORM',
          'identify' => 'PERSONAL',
          'email' => $read['member_email'],
          'password' => $user_password,
          'firstname' => $read['member_fname'],
          'lastname' => $read['member_lname'],
          'citizen_id' => $user_name,
          'mobile' => $read['member_cellphone']
        ];
        $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

        if($insert_connect2['status'] == TRUE){

            //-------- update member_id and token connect --------//
            $member_id_connect = $insert_connect2['member_id'];
            $token_connect = $insert_connect2['token'];
            $id_connect = $insert_connect2['member_id'];

            $data_insert_member_app = [
              'member_id' => $member_id, //id ของ tb_member
              'member_id_app' => $member_id_connect, //primary in app
              'client_id' => 'SS6931846'
            ];
            $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

            //------- insert token_external --------//
            $data_insert_token_external = [
              'member_id' => $member_id,
              'member_id_app' => $id_connect,
              'token_code' => $token_connect,
              'member_type' => 'TOUCH',
            ];
            $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
        }
        //----------------------- End of insert touch -------------------------//
        
        //AutoRegis Drive

        //-- return code ไปให้ js fetch api --//
        $code_drive = $this->get_code($member_id, 'ssonticlient');
        $code_care = $this->get_code($member_id, 'ssocareid');

        //------- redirect -------//
        $url = $this->get_return_url($member_id);
        $return = [
          'res_code' => '00', 
          'success' => 1, 
          'url' => $url,
          'code' =>[
            //'code_care' => $code_care,
            'code_drive' => $code_drive,
            //'xx' => $password,
            //'ee' => $member_email
          ]
        ];
      }
    }else if($target == 2){ //drive
       //insert_drive
       //$sql_get = "SELECT * FROM Member_drive where UserID ='" . $id ."'";
       $sql_get = "SELECT * FROM Member_drive_v3 where UserID ='" . $id ."'";
       $data_get = $this->query($sql_get);
       $read_get = $data_get[0];
       $type = $read_get['UserType']; //corporate, person
       $is_thai = $read_get['Is_Thai'];

       if($type == 'corporate' ){
         //-- insert master member --//
         $data_insert_member = [
           'member_app' => '',
           'member_app_id' => '',
           'cid' => $user_name,
           'password' => sha1($user_password),
           'type' => ($is_thai == "Y")? '1' : '2',
           'status' => '1'
         ];
         $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
         $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
         $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
         $ck_mem = $this->insert('tb_member', $data_insert_member);
         
         if(!empty($ck_mem)){
           $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
           $result_max = $this->query($sql_max);
           $member_id = $result_max[0]['member_id']; //Primary ใน tb_member
           
           //-- insert member_app --//
           $data_insert_member_app = [
             'member_id' => $member_id, //id ของ tb_member
             'member_id_app' => $id, //primary in app
             'client_id' => 'ssonticlient'
           ];
           $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
           //-- end of insert member_app --//
           
           //----------- insert_touch ----------//
           $data_insert_touch = [
             'register_type' => 'FORM',
             'identify' => 'CORPORATE',
             'email' => $read_get['Mail'],
             'password' => $user_password,
             'company_name' => $read_get['Firstname'],
             'company_tax_id' => $user_name,
             'company_telephone' => $read_get['Telephone']
           ];
           $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 2), TRUE); //2 IS CORPORATE

           if($insert_connect2['status'] == TRUE){

             //-------- update member_id and token connect --------//
             $member_id_connect = $insert_connect2['member_id'];
             $token_connect = $insert_connect2['token'];
             $id_connect = $insert_connect2['member_id'];

             $data_insert_member_app = [
               'member_id' => $member_id, //id ของ tb_member
               'member_id_app' => $member_id_connect, //primary in app
               'client_id' => 'SS6931846'
             ];
             $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

             //------- insert token_external --------//
             $data_insert_token_external = [
               'member_id' => $member_id,
               'member_id_app' => $id_connect,
               'token_code' => $token_connect,
               'member_type' => 'TOUCH',
             ];
             $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
           }
           //-------- End of insert touch ---------//

           if($is_thai == "Y"){
             $member_type_connect = "THAI";
             //-- insert member_type1 --//
             $data_insert_type1 = [
               'member_id' => $member_id,
               'company_nameTh' => $read_get['Firstname'],
               'member_email' => $read_get['Mail'],
               'member_tel' => $read_get['Telephone'],
             ];
 
             $insert_type1 = $this->insert('tb_member_type1', $data_insert_type1);

             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
             $data_get2 = $this->query($sql_get2);
             $read_get2 = $data_get2[0];
             //$return = $this->get_data_return($read_get2);
             $data_return = $this->get_data_return($read_get2);

           }else if($is_thai == "N"){
             $member_type_connect = "FOREIGN";
             //-- insert member_type2 --//
             $data_insert_type2 = [
               'member_id' => $member_id,
               'corporate_name' =>  $read_get['Firstname'],
               'email' => $read_get['Mail'],
               'tel' => $read_get['Telephone'],
             ];
 
             $insert_type2 = $this->insert('tb_member_type2', $data_insert_type2);

             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
             $data_get2 = $this->query($sql_get2);
             $read_get2 = $data_get2[0];
             //$return = $this->get_data_return($read_get2);
             $data_return = $this->get_data_return($read_get2);
           }
           //-------------------- return ----------------//
            $code_care = $this->get_code($member_id, 'ssocareid');
            $url = $this->get_return_url($member_id);
            $return = [
              'res_code' => '00', 
              'success' => 1, 
              'url' => $url,
              'code' =>[
                //'code_care' => $code_care,
                'code_care' => $code_care,
                //'xx' => $password,
                //'ee' => $member_email
              ]
            ];
         }

       }else if($type == 'person'){
         //-- insert master member --//
         $data_insert_member = [
           'member_app' => '',
           'member_app_id' => '',
           'cid' => $user_name,
           'password' => sha1($user_password),
           'type' => ($is_thai == "Y")? '3' : '4',
           'status' => '1'
         ];
         $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
         $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
         $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
         $ck_mem = $this->insert('tb_member', $data_insert_member);
         
         if(!empty($ck_mem)){
           $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
           $result_max = $this->query($sql_max);
           $member_id = $result_max[0]['member_id'];

           //--------------------- insert member_app ----------------------//
           $data_insert_member_app = [
             'member_id' => $member_id, //id ของ tb_member
             'member_id_app' => $id, //primary in app
             'client_id' => 'ssonticlient'
           ];
           $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
           //----------------- end of insert member_app -------------------//

           //------------------ insert touch -----------------------//
           $data_insert_touch = [
             'register_type' => 'FORM',
             'identify' => 'PERSONAL',
             'email' => $read_get['Mail'],
             'password' => $user_password,
             'firstname' => $read_get['Firstname'],
             'lastname' => $read_get['LastName'],
             'citizen_id' => $user_name,
             'mobile' => $read_get['Telephone']
           ];
           $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

           if($insert_connect2['status'] == TRUE){

             //-------- update member_id and token connect --------//
             $member_id_connect = $insert_connect2['member_id'];
             $token_connect = $insert_connect2['token'];
             $id_connect = $insert_connect2['member_id'];

             $data_insert_member_app = [
               'member_id' => $member_id, //id ของ tb_member
               'member_id_app' => $member_id_connect, //primary in app
               'client_id' => 'SS6931846'
             ];
             $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

             //------- insert token_external --------//
             $data_insert_token_external = [
               'member_id' => $member_id,
               'member_id_app' => $id_connect,
               'token_code' => $token_connect,
               'member_type' => 'TOUCH',
             ];
             $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
           }
           //------------------ End of insert touch -----------------------//

           if($is_thai == "Y"){ //-- บุคคลไทย
             $member_type_connect = "THAI";
             //-- insert member_type3 --//
             $data_insert_type3 = [
               'member_id' => $member_id,
               'member_nameTh' => $read_get['Firstname'],
               'member_lastnameTh' => $read_get['LastName'],
               'email' => $read_get['Mail'],
               'tel' => $read_get['Telephone'],
             ];
             $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

             //-- get_return state --//
             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
             $data_get2 = $this->query($sql_get2);
             $read_get2 = $data_get2[0];
             //$return = $this->get_data_return($read_get2);
             $data_return = $this->get_data_return($read_get2);

           }else if($is_thai == "N"){ //-- บุคคลต่างชาติ
             $member_type_connect = "FOREIGN";
             //-- insert member_type4 --//
             $data_insert_type4 = [
               'member_id' => $member_id,
               'member_nameEn' => $read_get['Firstname'],
               'member_lastnameEn' => $read_get['LastName'],
               'email' => $read_get['Mail'],
               'tel' => $read_get['Telephone'],
             ];
             $insert_type4 = $this->insert('tb_member_type4', $data_insert_type4);

             //-- get_return state --//
             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
             $data_get2 = $this->query($sql_get2);
             $read_get2 = $data_get2[0];
             //$return = $this->get_data_return($read_get2);
             $data_return = $this->get_data_return($read_get2);
           }
         }
         //-------------------- return ----------------//
          $code_care = $this->get_code($member_id, 'ssocareid');
          $url = $this->get_return_url($member_id);
          $return = [
            'res_code' => '00', 
            'success' => 1, 
            'url' => $url,
            'code' =>[
              //'code_care' => $code_care,
              'code_care' => $code_care,
              //'xx' => $password,
              //'ee' => $member_email
            ]
          ];
       }
      //  $code = [
      //    'code_care' => $code_care,
      //    'xx' => $user_password,
      //    'ee' => $read_get['Mail']
      //  ];
      //  $return = array_merge($data_return, ['code' => $code]);
       //----------------- end of return -----------------//



    }
    return $return;
    
    /*********** create return ***********/
    // $sql = "SELECT MAX(member_id) as member_id FROM tb_member WHERE status = 1";
    // $data = $this->query($sql);
    // $val = $data[0];

    // $data_client = $this->get_data_client($_SESSION['client_id']);
    // $url = $data_client['redirect_uri'];
    // if (!empty($_SESSION['redirect_uri'])) {
    //   $redirect_uri = $_SESSION['redirect_uri'];
    //   $url = $redirect_uri;
    // }
    // $query_url = parse_url($url, PHP_URL_QUERY);
    // if ($query_url) {
    //   $url .= '&';
    // } else {
    //   $url .= '?';
    // }

    // $data_client = $this->get_data_client($_SESSION['client_id']);
    // $response_type = $_SESSION['response_type'];
    // $key = $data_client['jwt_signature'];
    // $response_type = $_SESSION['response_type'];
    // $state =  $_SESSION['state'];

    // if (strtoupper($response_type) == 'CODE') {
    //   $data_access = $this->gen_access($val['member_id']);
    //   if (!empty($data_access['access'])) {
    //     $jwt_data = [
    //       'access_token' => $data_access['access'],
    //       'end_date' => $data_access['exp_date'],
    //       "token_type" => "Bearer"
    //     ];
    //     $jwt = JWT::encode($jwt_data, $key);
    //     $url .= 'code=' . $jwt . "&state=" . $state;

    //     $return = [
    //       'status' => true,
    //       'url' => $url

    //     ];

    //     $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
    //     setcookie($this->config->items('cookie_access'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    //   }
    // } else if (strtoupper($response_type) == 'TOKEN') {
    //   $data_token = $this->gen_token($val['member_id']);
    //   if (!empty($data_token['token'])) {

    //     $jwt_data = [
    //       'id_token' => $data_token['token'],
    //       'refresh_token' => $data_token['refresh_token'],
    //       'end_date' =>  $data_token['exp_date'],
    //       'end_date_refresh' =>  $data_token['exp_date_refresh'],
    //       "token_type" => "Bearer"
    //     ];
    //     $jwt = JWT::encode($jwt_data, $key);
    //     $url .= 'code=' . $jwt . "&state=" . $state;
    //     $return = [
    //       'status' => true,
    //       'url' => $url
    //     ];
    //     $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
    //     setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    //   }
    // }
    // /*********** End of create return  **********/
    // return $return;
    
  }
  function model_insert_v2($data){
    $target = $data['target'];
    $id = $data['id'];
    $user_password = $data['ss'];
    $user_name = $data['cid'];

    $sql_ck_cid = "SELECT 1 FROM tb_member WHERE cid = '$user_name'";
    $result_ck_cid = $this->query($sql_ck_cid);
    if(count($result_ck_cid) > 0){
      $return = [
        'res_code' => '01', 
        'res_text' => 'username นี้มีอยู่ในระบบแล้ว', 
      ];
      return $return;
      exit;
    }
    
    //----------------------- Insert care ----------------------------//
    if($target == 1){ //1 = care, 2 = drive
      //$stmt = $this->db->prepare("SELECT * FROM Member WHERE member_id = ?");
      $stmt = $this->db->prepare("SELECT * FROM Member_v2 WHERE member_id = ?");
      $stmt->bind_param("s", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $read = $result->fetch_assoc();

      //---------------------- insert Member care ----------------------//
      $data_insert_member = [
        'member_app' => '',
        'member_app_id' => '',
        'cid' => $user_name,
        'password' => sha1($user_password),
        'type' => '3', //บุคคลทั่วไป ใน tb_member
        'status' => '1'
      ];

      $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
      $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
      $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
      $ck_mem = $this->insert('tb_member', $data_insert_member); //--- tb_member master ---//

      if(!empty($ck_mem)){
        $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
        $result_max = $this->query($sql_max);
        $member_id = $result_max[0]['member_id'];
        $data_insert_type3 = [
          'member_id' => $member_id,
          'member_title' => '',
          'member_nameTh' => $read['member_fname'],
          'member_lastnameTh' => $read['member_lname'],
          'member_nameEn' => '',
          'member_lastnameEn' => '',
          'email' => $read['member_email'],
          'tel' => $read['member_cellphone'],
          'addressTh' => $read['member_address'],
          'provinceTh' => '',
          'districtTh' => '',
          'subdistrictTh' => '',
          'postcode' => $read['member_postcode'],
          'addressEn' => '',
          'provinceEn' => '',
          'districtEn' => '',
          'subdistrictEn' => ''
        ];
        $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

        //--------------------- insert member_app ----------------------//
        $data_insert_member_app = [
          'member_id' => $member_id, //id ของ tb_member
          'member_id_app' => $id, //primary in app
          'client_id' => 'ssocareid'
        ];
        $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
        //------------------------------------------------------------//

        //----------------- insert tb_token_external ------------------//
        $data_insert_token_external = [
          'member_id' => $member_id,
          'member_id_app' => $id,
          'token_code' => $read['member_api_key'],
          'member_type' => 'CARE',
        ];
        $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
        //-------------------------------------------------------------//

        //AutoRegis TOUCH
        //-------------------- insert_touch ----------------------------/
        $data_insert_touch = [
          'register_type' => 'FORM',
          'identify' => 'PERSONAL',
          'email' => $read['member_email'],
          'password' => $user_password,
          'firstname' => $read['member_fname'],
          'lastname' => $read['member_lname'],
          'citizen_id' => $user_name,
          'mobile' => $read['member_cellphone']
        ];
        $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

        if($insert_connect2['status'] == TRUE){

            //-------- update member_id and token connect --------//
            $member_id_connect = $insert_connect2['member_id'];
            $token_connect = $insert_connect2['token'];
            $id_connect = $insert_connect2['member_id'];

            $data_insert_member_app = [
              'member_id' => $member_id, //id ของ tb_member
              'member_id_app' => $member_id_connect, //primary in app
              'client_id' => 'SS6931846'
            ];
            $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

            //------- insert token_external --------//
            $data_insert_token_external = [
              'member_id' => $member_id,
              'member_id_app' => $id_connect,
              'token_code' => $token_connect,
              'member_type' => 'TOUCH',
            ];
            $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
        }
        //----------------------- End of insert touch -------------------------//
        
        //AutoRegis Drive

        //-- return code ไปให้ js fetch api --//
        $code_drive = $this->get_code($member_id, 'ssonticlient');
        $code_care = $this->get_code($member_id, 'ssocareid');

        //------- redirect -------//
        $url = $this->get_return_url($member_id);
        $return = [
          'res_code' => '00', 
          'success' => 1, 
          'url' => $url,
          'code' =>[
            //'code_care' => $code_care,
            'code_drive' => $code_drive,
            //'xx' => $password,
            //'ee' => $member_email
          ]
        ];
      }
    }else if($target == 2){ //drive
       //insert_drive
       //$sql_get = "SELECT * FROM Member_drive where UserID ='" . $id ."'";
       $sql_get = "SELECT * FROM Member_drive_v3 where UserID ='" . $id ."'";
       $data_get = $this->query($sql_get);
       $read_get = $data_get[0];
       $type = $read_get['UserType']; //corporate, person
       $is_thai = $read_get['Is_Thai'];

       if($type == 'corporate' ){
         //-- insert master member --//
         $data_insert_member = [
           'member_app' => '',
           'member_app_id' => '',
           'cid' => $user_name,
           'password' => sha1($user_password),
           'type' => ($is_thai == "Y")? '1' : '2',
           'status' => '1'
         ];
         $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
         $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
         $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
         $ck_mem = $this->insert('tb_member', $data_insert_member);
         
         if(!empty($ck_mem)){
           $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
           $result_max = $this->query($sql_max);
           $member_id = $result_max[0]['member_id']; //Primary ใน tb_member
           
           //-- insert member_app --//
           $data_insert_member_app = [
             'member_id' => $member_id, //id ของ tb_member
             'member_id_app' => $id, //primary in app
             'client_id' => 'ssonticlient'
           ];
           $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
           //-- end of insert member_app --//
           
           //----------- insert_touch ----------//
           $data_insert_touch = [
             'register_type' => 'FORM',
             'identify' => 'CORPORATE',
             'email' => $read_get['Mail'],
             'password' => $user_password,
             'company_name' => $read_get['Firstname'],
             'company_tax_id' => $user_name,
             'company_telephone' => $read_get['Telephone']
           ];
           $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 2), TRUE); //2 IS CORPORATE

           if($insert_connect2['status'] == TRUE){

             //-------- update member_id and token connect --------//
             $member_id_connect = $insert_connect2['member_id'];
             $token_connect = $insert_connect2['token'];
             $id_connect = $insert_connect2['member_id'];

             $data_insert_member_app = [
               'member_id' => $member_id, //id ของ tb_member
               'member_id_app' => $member_id_connect, //primary in app
               'client_id' => 'SS6931846'
             ];
             $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

             //------- insert token_external --------//
             $data_insert_token_external = [
               'member_id' => $member_id,
               'member_id_app' => $id_connect,
               'token_code' => $token_connect,
               'member_type' => 'TOUCH',
             ];
             $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
           }
           //-------- End of insert touch ---------//

           if($is_thai == "Y"){
             $member_type_connect = "THAI";
             //-- insert member_type1 --//
             $data_insert_type1 = [
               'member_id' => $member_id,
               'company_nameTh' => $read_get['Firstname'],
               'member_email' => $read_get['Mail'],
               'member_tel' => $read_get['Telephone'],
             ];
 
             $insert_type1 = $this->insert('tb_member_type1', $data_insert_type1);

             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
             $data_get2 = $this->query($sql_get2);
             $read_get2 = $data_get2[0];
             //$return = $this->get_data_return($read_get2);
             $data_return = $this->get_data_return($read_get2);

           }else if($is_thai == "N"){
             $member_type_connect = "FOREIGN";
             //-- insert member_type2 --//
             $data_insert_type2 = [
               'member_id' => $member_id,
               'corporate_name' =>  $read_get['Firstname'],
               'email' => $read_get['Mail'],
               'tel' => $read_get['Telephone'],
             ];
 
             $insert_type2 = $this->insert('tb_member_type2', $data_insert_type2);

             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
             $data_get2 = $this->query($sql_get2);
             $read_get2 = $data_get2[0];
             //$return = $this->get_data_return($read_get2);
             $data_return = $this->get_data_return($read_get2);
           }
           //-------------------- return ----------------//
            $code_care = $this->get_code($member_id, 'ssocareid');
            $url = $this->get_return_url($member_id);
            $return = [
              'res_code' => '00', 
              'success' => 1, 
              'url' => $url,
              'code' =>[
                //'code_care' => $code_care,
                'code_care' => $code_care,
                //'xx' => $password,
                //'ee' => $member_email
              ]
            ];
         }

       }else if($type == 'person'){
         //-- insert master member --//
         $data_insert_member = [
           'member_app' => '',
           'member_app_id' => '',
           'cid' => $user_name,
           'password' => sha1($user_password),
           'type' => ($is_thai == "Y")? '3' : '4',
           'status' => '1'
         ];
         $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
         $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
         $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
         $ck_mem = $this->insert('tb_member', $data_insert_member);
         
         if(!empty($ck_mem)){
           $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
           $result_max = $this->query($sql_max);
           $member_id = $result_max[0]['member_id'];

           //--------------------- insert member_app ----------------------//
           $data_insert_member_app = [
             'member_id' => $member_id, //id ของ tb_member
             'member_id_app' => $id, //primary in app
             'client_id' => 'ssonticlient'
           ];
           $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
           //----------------- end of insert member_app -------------------//

           //------------------ insert touch -----------------------//
           $data_insert_touch = [
             'register_type' => 'FORM',
             'identify' => 'PERSONAL',
             'email' => $read_get['Mail'],
             'password' => $user_password,
             'firstname' => $read_get['Firstname'],
             'lastname' => $read_get['LastName'],
             'citizen_id' => $user_name,
             'mobile' => $read_get['Telephone']
           ];
           $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

           if($insert_connect2['status'] == TRUE){

             //-------- update member_id and token connect --------//
             $member_id_connect = $insert_connect2['member_id'];
             $token_connect = $insert_connect2['token'];
             $id_connect = $insert_connect2['member_id'];

             $data_insert_member_app = [
               'member_id' => $member_id, //id ของ tb_member
               'member_id_app' => $member_id_connect, //primary in app
               'client_id' => 'SS6931846'
             ];
             $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

             //------- insert token_external --------//
             $data_insert_token_external = [
               'member_id' => $member_id,
               'member_id_app' => $id_connect,
               'token_code' => $token_connect,
               'member_type' => 'TOUCH',
             ];
             $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
           }
           //------------------ End of insert touch -----------------------//

           if($is_thai == "Y"){ //-- บุคคลไทย
             $member_type_connect = "THAI";
             //-- insert member_type3 --//
             $data_insert_type3 = [
               'member_id' => $member_id,
               'member_nameTh' => $read_get['Firstname'],
               'member_lastnameTh' => $read_get['LastName'],
               'email' => $read_get['Mail'],
               'tel' => $read_get['Telephone'],
             ];
             $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

             //-- get_return state --//
             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
             $data_get2 = $this->query($sql_get2);
             $read_get2 = $data_get2[0];
             //$return = $this->get_data_return($read_get2);
             $data_return = $this->get_data_return($read_get2);

           }else if($is_thai == "N"){ //-- บุคคลต่างชาติ
             $member_type_connect = "FOREIGN";
             //-- insert member_type4 --//
             $data_insert_type4 = [
               'member_id' => $member_id,
               'member_nameEn' => $read_get['Firstname'],
               'member_lastnameEn' => $read_get['LastName'],
               'email' => $read_get['Mail'],
               'tel' => $read_get['Telephone'],
             ];
             $insert_type4 = $this->insert('tb_member_type4', $data_insert_type4);

             //-- get_return state --//
             $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
             $data_get2 = $this->query($sql_get2);
             $read_get2 = $data_get2[0];
             //$return = $this->get_data_return($read_get2);
             $data_return = $this->get_data_return($read_get2);
           }
         }
         //-------------------- return ----------------//
          $code_care = $this->get_code($member_id, 'ssocareid');
          $url = $this->get_return_url($member_id);
          $return = [
            'res_code' => '00', 
            'success' => 1, 
            'url' => $url,
            'code' =>[
              //'code_care' => $code_care,
              'code_care' => $code_care,
              //'xx' => $password,
              //'ee' => $member_email
            ]
          ];
       }
    }
    return $return;
    
  }

  function get_email_reset($member_cid = ''){
    
    //-------- check db_sso ---------//
    $stmt = $this->db->prepare("SELECT email,cid,member_id,type FROM tb_member WHERE cid = ?");
    $stmt->bind_param("s", $member_cid);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows){
      $read = $result->fetch_assoc();
      $return = [
        'status' => '00',
        'email' => $read['email'],
        'member_id' => $read['member_id'],
        'target' => 'SSO'
      ];
      return $return;
    }

    //-------- check db_drive -------//
    $stmt_drive = $this->db->prepare("SELECT UserID, Mail FROM Member_drive_v3 WHERE Username = ?");
    $stmt_drive->bind_param("s", $member_cid);
    $stmt_drive->execute();
    $result_drive = $stmt_drive->get_result();
    if($result_drive->num_rows){
      $read_drive = $result_drive->fetch_assoc();
      $return = [
        'status' => '00',
        'email' => $read_drive['Mail'],
        'member_id' => $read_drive['UserID'],
        'target' => 'DRIVE'
      ];
      return $return;
    }

    //-------- check db_care ---------//
    //$stmt_care = $this->db->prepare("SELECT member_id, member_email FROM Member WHERE member_cid = ?");
    $stmt_care = $this->db->prepare("SELECT member_id, member_email FROM Member_v2 WHERE member_cid = ?");
    $stmt_care->bind_param("s", $member_cid);
    $stmt_care->execute();
    $result_care = $stmt_care->get_result();
    if($result_care->num_rows){
      $read_care = $result_care->fetch_assoc();
      $return = [
        'status' => '00',
        'email' => $read_care['member_email'],
        'member_id' => $read_care['member_id'],
        'target' => 'CARE'
      ];
      return $return;
    }

    $return = [
      'status' => '01',
      'massage' => 'Not found'
    ];
    return $return;
  }

  function get_info_drive($userid = ''){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_DRIVE."UserProfile?token=".$this->token_drive."&userid=".$userid,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => array('Content-Length: 0')
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }

  function model_email_reset($member_cid = ''){
    $data = [];
    //-------- check db_sso ---------//
    $stmt = $this->db->prepare("SELECT email,cid,member_id,type FROM tb_member WHERE cid = ?");
    $stmt->bind_param("s", $member_cid);
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
        $name = $read_m['member_nameTh'];
        $lastname = $read_m['member_lastnameTh'];
        
        if($email != ""){
          $data[] = [
            'email' => $email,
            'member_id' => $read['member_id'],
            'target' => 'SSO RESET'
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
            'target' => 'SSO RESET'
          ];
          $return = [
            'status' => '01',
            'message' => 'ไม่พบอีเมลของท่านในระบบ กรุณาติดต่อเจ้าหน้าที่',$data
          ];
          return $return;
        }
      }
    }

    //-------- check db_drive -------//
    $stmt_drive = $this->db->prepare("SELECT UserID, Mail FROM Member_drive_v3 WHERE Username = ?");
    $stmt_drive->bind_param("s", $member_cid);
    $stmt_drive->execute();
    $result_drive = $stmt_drive->get_result();
    if($result_drive->num_rows){
      foreach($result_drive as $item_drive){
        $data_drive = $this->get_info_drive($member_cid);
        $result_drive = json_decode($data_drive,1);
        $mail_drive = '';
        if($result_drive != '' && $result_drive['code'] == 200 && $result_drive['message'] == 'OK'){
          if($result_drive['IsThai'] == 'Y' && $result_drive['UserType'] == "company") $mail_drive = $result_drive['Mail'];
          else if($result_drive['IsThai'] == 'N' && $result_drive['UserType'] == "company") $mail_drive = $result_drive['Mail'];
          else if($result_drive['IsThai'] == 'Y' && $result_drive['UserType'] == "individual") $mail_drive = $result_drive['Mail'];
          else if($result_drive['IsThai'] == 'N' && $result_drive['UserType'] == "individual") $mail_drive = $result_drive['Mail'];
        }
        if($mail_drive == ""){
          $mail_drive = $item_drive['Mail'];
        }
        $data[] = [
          'email' => $mail_drive,
          'member_id' => $item_drive['UserID'],
          'target' => 'DRIVE'
        ];
      }
    }

    //-------- check db_care ---------//
    //$stmt_care = $this->db->prepare("SELECT member_id, member_email FROM Member WHERE member_cid = ?");
    $stmt_care = $this->db->prepare("SELECT member_id, member_email FROM Member_v2 WHERE member_cid = ?");
    $stmt_care->bind_param("s", $member_cid);
    $stmt_care->execute();
    $result_care = $stmt_care->get_result();
    if($result_care->num_rows){
      foreach($result_care as $item_care){
        $data[] = [
          'email' => $item_care['member_email'],
          'member_id' => $item_care['member_id'],
          'target' => 'CARE'
        ];
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

  function model_send_mail_ditpOne(){
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ"
    ];
    $email = $this->post('email');
    if($email != ""){
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
        // $ref_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 6);

      $code1 = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
      $code2 = substr(str_shuffle("0123456789"), 0, 6);

      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPDebug = 0;
      $mail->SMTPSecure = "tls";
      $mail->Host = Host_Mailjet;
      $mail->Port = 587;
      $mail->isHTML();
      $mail->CharSet = "utf-8";
      $mail->Username = USERNAME_Mailjet;
      $mail->Password = PASSWORD_Mailjet;
      $mail->From = ('one@ditp.go.th');
      $mail->FromName = "DITP ONE";
      $mail->Subject = "สร้างรหัส PIN ใหม่ของคุณ";
      
      $mail->Body = '<!doctype html>';
      $mail->Body.= '<html>';
      $mail->Body.= '<head>';
      $mail->Body.= '<meta name="viewport" content="width=device-width" />';
      $mail->Body.= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
      $mail->Body.= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">';
      $mail->Body.= '<link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">';
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
      $mail->Body.= 'font-family: "Kanit", sans-serif !important;';
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
      $mail->Body.= 'font-family: "Kanit", sans-serif !important;';
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
      $mail->Body.= 'font-family: "Kanit", sans-serif !important;';
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
      $mail->Body.= 'font-weight: 400;';
      $mail->Body.= 'line-height: 1.4;';
      $mail->Body.= 'margin: 0;';
      $mail->Body.= 'margin-bottom: 30px;';
      $mail->Body.= '}';
      $mail->Body.= '';
      $mail->Body.= 'h1 {';
      $mail->Body.= 'font-family: "Kanit", sans-serif !important;';
      $mail->Body.= 'font-size: 35px;';
      $mail->Body.= 'font-weight: 300;';
      $mail->Body.= 'text-align: center;';
      $mail->Body.= 'text-transform: capitalize;';
      $mail->Body.= '}';
      $mail->Body.= '';
      $mail->Body.= 'p,';
      $mail->Body.= 'ul,';
      $mail->Body.= 'ol {';
      $mail->Body.= 'font-size: 14px;';
      $mail->Body.= 'font-family: "Kanit", sans-serif !important;';
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
      $mail->Body.= 'font-family: "Kanit", sans-serif !important;';
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
      $mail->Body.= 'font-family: "Kanit", sans-serif !important;';
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
      $mail->Body.= 'font-family: "Kanit", sans-serif !important;';
      $mail->Body.= 'font-size: inherit !important;';
      $mail->Body.= 'font-weight: inherit !important;';
      $mail->Body.= 'line-height: inherit !important;';
      $mail->Body.= 'text-decoration: none !important;';
      $mail->Body.= '}';
      $mail->Body.= '#MessageViewBody a {';
      $mail->Body.= 'color: inherit;';
      $mail->Body.= 'text-decoration: none;';
      $mail->Body.= 'font-size: inherit;';
      $mail->Body.= 'font-family: "Kanit", sans-serif !important;';
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
      $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">';
      $mail->Body.= '<tr>';
      $mail->Body.= '<td>&nbsp;</td>';
      $mail->Body.= '<td class="container">';
      $mail->Body.= '<div class="content">';
      $mail->Body.= '<!-- START CENTERED WHITE CONTAINER -->';
      // $mail->Body.= '<table role="presentation" class="main" style="background-color: #f6f6f6;">';
      // $mail->Body.= '';
      // $mail->Body.= '<!-- START MAIN CONTENT AREA -->';
      // $mail->Body.= '<tr >';
      // $mail->Body.= '<td class="wrapper">';
      // $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
      // $mail->Body.= '<tr>';
      // $mail->Body.= '<td>';
      $mail->Body.= '<div class="container" style="border-top-right-radius:11px;border-top-left-radius: 11px;background-image: url('.BASE_URL.'asset/img/Rectangle2.png);">';
      $mail->Body.= '</div>';
      $mail->Body.= '<div class="container" style="background-color: #ffff;">';
      $mail->Body.= '<img src="'.BASE_URL.'asset/img/DITP_ONE_Logo.png" alt="SSO Logo" width="20%" border="0" style="border:0; outline:none; text-decoration:none; display:block;"><hr>';
      $mail->Body.= '<p style="font-size: 1.5rem !important;"><b>สร้างรหัส PIN ใหม่ของท่าน</b></p>';
      $mail->Body.= '<p >รหัสอ้างอิง : <b>'.$code1.'</b></p>';
      $mail->Body.= '<p >รหัสยืนยันของคุณ : <b style="color: #2D6DC4 !important;font-size: 1.5rem !important;">'.$code2.'</b></p>';
      $mail->Body.= '<p >รหัสมีอายุใช้งาน 5 นาที กรุณาอย่าแบ่งปันรหัสนี้กับใคร</p>';
      $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">';
      $mail->Body.= '<tbody>';
      $mail->Body.= '<tr>';
      $mail->Body.= '<td align="center">';
      $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
      $mail->Body.= '<tbody>';
      $mail->Body.= '<tr>';
      $mail->Body.= "<td></td>";
      $mail->Body.= '</tr>';
      $mail->Body.= '</tbody>';
      $mail->Body.= '</table>';
      $mail->Body.= '</td>';
      $mail->Body.= '</tr>';
      $mail->Body.= '</tbody>';
      $mail->Body.= '</table>';
      $mail->Body.= '<p>หากท่านมีข้อสงสัยสามารถติดต่อ : 1169</p>';
      $mail->Body.= '</div>';
      $mail->Body.= '<div class="container" style="border-bottom-right-radius:11px;border-bottom-left-radius: 11px;background-image: url('.BASE_URL.'asset/img/Rectangle2.png);">';
      $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
      $mail->Body.= '<tbody>';
      $mail->Body.= '<tr>';
      $mail->Body.= '<td style="padding-left:2%;padding-top:2%;padding-bottom:2%;color:#ffff">';
      $mail->Body.= '<p>563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000</p>';
      $mail->Body.= '<p>โทร : 02507 7999 | e-mail : <a href="mailto:1169@ditp.go.th" target="_blank" style="color:#ffff">1169@ditp.go.th</a></p>';
      $mail->Body.= '</td>';
      $mail->Body.= '<td style="text-align: end;padding-top: 7%;">';
      $mail->Body.= '<a><img src="'.BASE_URL.'asset/img/DITP.png"  width="60%"></a>';
      $mail->Body.= '</td>';
      $mail->Body.= '</tr>';
      $mail->Body.= '</tbody>';
      $mail->Body.= '</table>';
      $mail->Body.= '</div>';
      // $mail->Body.= '</td>';<a href="mailto:1169@ditp.go.th" target="_blank">1169@ditp.go.th</a>
      // $mail->Body.= '</tr>';
      // $mail->Body.= '</table>';
      // $mail->Body.= '</td>';
      // $mail->Body.= '</tr>';
      // $mail->Body.= '';
      // $mail->Body.= '<!-- END MAIN CONTENT AREA -->';
      // $mail->Body.= '</table>';
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
                "email" => $email_list,
                "code" => $code2
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
                "code" => $code2
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
            "email" => substr_replace($email,"****",0,4),
            "code" => $code2
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
    // $to_email = 'supertoplnw001@gmail.com';
    // $subject = 'Testing PHP Mail';
    // $message = 'This mail is sent using the PHP mail ';
    // $headers = 'From: sso-noreply@ditp.go.th';
    // $return = mail($to_email, $subject, $message, $headers);
    // var_dump( $return);
    // die();
    // return $return;
  }

  /************* model send_mail **************/
  function model_send_mail(){
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ"
    ];
    $member_id = $this->post('member_id');
    $target = $this->post('target');
    $email = $this->post('email');
    
    if($email != "" && $member_id !="" && $target != ""){
      $number = mt_rand(1000,9999);

      $_SESSION['id'] = $member_id;
      $_SESSION['email'] = $email;
      $_SESSION['target'] = $target;

      $_SESSION['number'] = $number;
      $_SESSION['status_reset'] = true;

      $token_reset = sha1($member_id . date('YmhHis'));
      $exp_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+15 minutes"));
      $ref_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 6);
      //-- เคลียร์ Token เก่า --//
      $this->update('tb_token_reset', ['status'=>'1'], "member_id ='$member_id'");

      //-- insert tb_token_reset --//
      $data_token_reset = [
        'token_reset' => $token_reset,
        'ref_code' => $ref_code,
        'member_id' => $member_id,
        'target' => $target,
        'redirect_uri' => empty($_SESSION['redirect_uri'])?BASE_URL.'portal/ck_portal':$_SESSION['redirect_uri'],
        'response_type' => empty($_SESSION['response_type'])?'token':$_SESSION['response_type'],
        'client_id' => empty($_SESSION['client_id'])?'SS8663835':$_SESSION['client_id'],
        'state' => $_SESSION['state'],
        'status' => '0',
        'exp_date' => $exp_date
      ];
      $insert = $this->insert('tb_token_reset', $data_token_reset);
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
      
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPDebug = 0;
      $mail->SMTPSecure = "tls";
      $mail->Host = Host_Mailjet;
      $mail->Port = 587;
      $mail->isHTML();
      $mail->CharSet = "utf-8";
      $mail->Username = USERNAME_Mailjet;
      $mail->Password = PASSWORD_Mailjet;

      $mail->From = ('sso@ditp.go.th');
      $mail->FromName = "DITP Single Sign-on";
      $mail->Subject = "รีเซ็ตรหัสผ่าน DITP Single Sign-on";

      $url = $this->path_web."auth/reset?q=".$token_reset."&ref_code=".$ref_code."&response_type='token'";
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
      $mail->Body .= '<img style="max-width: 110px;margin:0 auto;" src=BASE_URL."asset/img/new-sso-logo-white.png" alt="">';
      $mail->Body .= '</div>';
      $mail->Body .= '<div style="width:100%;padding: 1rem;">';
      $mail->Body .= '<h4 class="t-main1" style="color: #39414F!important;">รีเซ็ตรหัสผ่าน DITP Single Sign-on</h4>';
      $mail->Body .= '<p class="t-main1" style="color: #39414F!important;">กรุณายืนยันอีกครั้ง เพื่อการรีเซ็ตรหัสผ่าน โดยกดปุ่มด้านล่าง</p>';
      $mail->Body .= '<div style="display:grid;text-align:center;">';
      $mail->Body .= '<a style="font-weight: 400;line-height: 1.5;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;border: 1px solid transparent;font-size: 1rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;background-color: #2D6DC4;border-radius: 8px;color: white;display: inline-flex;justify-content: center;padding: 8px 15px;margin: 0 auto;"';
      $mail->Body .= 'href="'.$url.'">รีเซ็ตรหัสผ่าน</a>';
      $mail->Body .= '<small class="t-main1" style="color: #39414F!important;">หากท่านมีข้อสงสัยสามารถติดต่อ : 1169</small>';
      $mail->Body .= '</div>';
      $mail->Body .= '</div>';
      $mail->Body .= '<div style="background-color: #EFF6F9;width: 100%;padding:1rem;">';
      $mail->Body .= '<div style="--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: calc(var(--bs-gutter-y) * -1);margin-right: calc(var(--bs-gutter-x) * -.5);margin-left: calc(var(--bs-gutter-x) * -.5);padding:1rem;">';
      $mail->Body .= '<div style="flex:0 0 auto;width:75%;">';
      $mail->Body .= '<p style="color: #39414F!important;">';
      $mail->Body .= 'กรมส่งเสริมการค้าระหว่างประเทศ กระทรวงพาณิชย์ <br>';
      $mail->Body .= '563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 <br>';
      $mail->Body .= 'Call Center : 1169 <br> e-mail : 1169@ditp.go.th';
      $mail->Body .= '</p>';
      $mail->Body .= '</div>';
      $mail->Body .= '<div style="flex:0 0 auto;width:25%;">';
      $mail->Body .= '<img style="width:100%;" src=BASE_URL."asset/img/ditp-logo.png">';
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

        if ($mail->Send()){
          $return = [
            "status" => "00",
            "message" => "success",
            "email" => substr_replace($email,"****",0,4),
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
    return $return;
  }
  function send_mail_director ($data = []) {
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ"
    ];

    $email = $data['email'];
    $member_id = $data['member_id'];
    $target = 'director';
    $fullname = $data['title'] . $data['name'] . ' ' . $data['lastname'];
    
    if($email != "" && $member_id !=""){
      $number = mt_rand(1000,9999);

      $token_verify = sha1($member_id . date('YmhHis'));
      $exp_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+15 minutes"));

      $ref_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 6);

      //-- เคลียร์ Token เก่า --//
      $this->update('tb_token_verify_director', ['status'=>'1'], "member_id ='$member_id'");

      //-- insert tb_token_reset --//
      $data_token_verify = [
        'token_verify' => $token_verify,
        'ref_code' => $ref_code,
        'member_id' => $member_id,
        'target' => $target,
        'redirect_uri' => BASE_URL.'portal/ck_portal',
        'response_type' => 'token',
        'client_id' => 'SS8663835',
        'state' => "email",
        'status' => '0',
        'exp_date' => $exp_date
      ];
      $insert = $this->insert('tb_token_verify_director', $data_token_verify);
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
      $mail->SMTPSecure = "tls";
      $mail->Host = Host_Mailjet;
      $mail->Port = 587;
      $mail->isHTML();
      $mail->CharSet = "utf-8";
      $mail->Username = USERNAME_Mailjet;
      $mail->Password = PASSWORD_Mailjet;

      $mail->From = ('sso@ditp.go.th');
      $mail->FromName = "DITP Single Sign-on";
      $mail->Subject = "ขั้นตอนการตรวจสอบผู้รับมอบอำนาจ";

      $state = "email";

      $url = $this->path_web."auth/verify_director?q=".$member_id."&redirect_uriBASE_URL.=portal/ck_portal&response_type=token&client_id=SS8663835&state=email";
      $mail->Body .= '<!DOCTYPE html>';
      $mail->Body .= '<html lang="en">';
      $mail->Body .= '<head>';
      $mail->Body .= '<meta name="viewport" content="width=device-width" />';
      $mail->Body .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
      $mail->Body .= '<title>ขั้นตอนการตรวจสอบผู้รับมอบอำนาจ</title>';
      $mail->Body .= '</head>';
      $mail->Body .= '<body>';
      $mail->Body .= '<div class="container" style="display: flex;justify-content: center;">';
      $mail->Body .= '<div  style="max-width: 740px;width:100%;padding: 1rem;">';
      $mail->Body .= '<div style="background:linear-gradient(318.86deg, #5DBDE6 -33.84%, #1D61BD 135.37%);display:flex;width:100%;justify-content: center;padding: 1rem">';
      $mail->Body .= '<img style="max-width: 110px;margin:0 auto;" src=BASE_URL."asset/img/new-sso-logo-white.png" alt="">';
      $mail->Body .= '</div>';
      $mail->Body .= '<div style="width:100%;padding: 1rem;">';
      $mail->Body .= '<h4 class="t-main1" style="color: #39414F!important;">เรียน คณะกรรมการบริษัท</h4>';
      $mail->Body .= '<p class="t-main1" style="color: #39414F!important;">';
      $mail->Body .= '<b>'.$fullname.'</b> ได้ลงทะเบียนในฐานะนิติบุคคลตัวแทนบริษัทของท่าน หากท่านยืนยันมอบอำนาจ
                      ให้ <b>'.$fullname.'</b> เป็นผู้ดำเนินการแทนนิติบุคคลในการเข้าถึงระบบกรมการค้าระหว่างประเทศ
                      กรุณากดปุ่ม “ยืนยันมอบอำนาจ” ที่ด้านล่าง';
      $mail->Body .= '</p>';
      $mail->Body .= '<div style="display:grid;text-align:center;">';
      $mail->Body .= '<a style="font-weight: 400;line-height: 1.5;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;border: 1px solid transparent;font-size: 1rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;background-color: #2D6DC4;border-radius: 8px;color: white;display: inline-flex;justify-content: center;padding: 8px 15px;margin: 0 auto;"';
      $mail->Body .= 'href="'.$url.'">ยืนยันมอบอำนาจ</a>';
      $mail->Body .= '</div>';
      $mail->Body .= '</div>';
      $mail->Body .= '<div style="background-color: #EFF6F9;width: 100%;padding:1rem;">';
      $mail->Body .= '<div style="--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: calc(var(--bs-gutter-y) * -1);margin-right: calc(var(--bs-gutter-x) * -.5);margin-left: calc(var(--bs-gutter-x) * -.5);padding:1rem;">';
      $mail->Body .= '<div style="flex:0 0 auto;width:75%;">';
      $mail->Body .= '<p style="color: #20416E!important;">';
      $mail->Body .= 'กรมส่งเสริมการค้าระหว่างประเทศ กระทรวงพาณิชย์ <br>';
      $mail->Body .= '563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 <br>';
      $mail->Body .= 'Call Center : 1169 <br> e-mail : 1169@ditp.go.th';
      $mail->Body .= '</p>';
      $mail->Body .= '</div>';
      $mail->Body .= '<div style="flex:0 0 auto;width:25%;">';
      $mail->Body .= '<img style="width:100%;" src=BASE_URL."asset/img/ditp-logo.png">';
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

        if ($mail->Send()){
          $return = [
            "status" => "00",
            "message" => "success",
            "email" => substr_replace($email,"****",0,4),
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
    return $return;
  }
  function _model_send_mail(){
    $return = [
      "status" => "01",
      "message" => "Not Found!"
    ];
    $member_cid = $this->post('member_cid');
    $stmt = $this->db->prepare("SELECT email,cid,member_id,type FROM tb_member WHERE cid = ?");
    $stmt->bind_param("s", $member_cid);
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
      }
      $stmt_m->bind_param("s", $member_id);
      $stmt_m->execute();
      $result_m = $stmt_m->get_result();
      if($result_m->num_rows){
        $read_m = $result_m->fetch_assoc();
        ($read['type'] == 1)? $email = $read_m['member_email'] : $email = $read_m['email'];
        $name = $read_m['member_nameTh'];
        $lastname = $read_m['member_lastnameTh'];

        if($email != ""){
          $number = mt_rand(1000,9999);
          $_SESSION['id'] = $read['member_id'];
          $_SESSION['number'] = $number;
          $_SESSION['status_reset'] = true;

          //--- old version --//
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->SMTPAuth = true;
          $mail->SMTPSecure = "tls";
          $mail->Host = "smtp.gmail.com"; // ถ้าใช้ smtp ของ server เป็นอยู่ในรูปแบบนี้ mail.domainyour.com
          $mail->Port = 587;
          $mail->isHTML();
          $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
          $mail->Username = "kittiporn.s@ibusiness.co.th"; //กรอก Email Gmail หรือ เมลล์ที่สร้างบน server ของคุณเ
          $mail->Password = "0856225746"; // ใส่รหัสผ่าน email ของคุณ
          $mail->SetFrom = ('kittiporn.s@ibusiness.co.th'); //กำหนด email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง
          $mail->FromName = "DITP SSO"; //ชื่อที่ใช้ในการส่ง
          $mail->Subject = "รีเซ็ตรหัสผ่าน DITP SSO";  //หัวเรื่อง emal ที่ส่ง
          try{
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
            $mail->Body.= '<center><img src=BASE_URL."asset/img/sso-logo.png" alt="SSO Logo" width="120" border="0" style="border:0; outline:none; text-decoration:none; display:block;"></center><hr>';
            $mail->Body.= "<p>เรียนคุณ {$name} {$lastname}</p>";
            $mail->Body.= '<p>ทาง SSO DITP ได้รับคำขอจากคุณในเรื่องการเปลี่ยนรหัสผ่าน หากคุณได้ส่งคำขอนี้';
            $mail->Body.= 'กรุณานำรหัสดังกล่าวไปใช้ในในการรีเซ็ตรหัสผ่าน</p>';
            $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">';
            $mail->Body.= '<tbody>';
            $mail->Body.= '<tr>';
            $mail->Body.= '<td align="center">';
            $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
            $mail->Body.= '<tbody>';
            $mail->Body.= '<tr>';
            $mail->Body.= "<td><a>{$number}</a></td>";
            $mail->Body.= '</tr>';
            $mail->Body.= '</tbody>';
            $mail->Body.= '</table>';
            $mail->Body.= '</td>';
            $mail->Body.= '</tr>';
            $mail->Body.= '</tbody>';
            $mail->Body.= '</table>';
            $mail->Body.= '<p>ห้ามเปิดเผยรหัสนี้ไม่ว่ากรณีใดๆ ทั้งสิ้น หากคุณไม่ได้ส่งคำขอ กรุณาละเว้นอีเมลฉบับนี้</p>';          
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

            $mail->AddAddress($email); //อีเมล์และชื่อผู้รับ
          } catch (phpmailerException $e) {
            $return = [
              "status" => "01",
              "message" => $e
            ];
            return $return;
          }
          
          //ส่วนของการแนบไฟล์ รองรับ .rar , .jpg , png
          //$mail->AddAttachment("files/1.rar");
          //$mail->AddAttachment("files/1.png");
          
          //ตรวจสอบว่าส่งผ่านหรือไม่
          if ($mail->Send()){
            //echo "ข้อความของคุณได้ส่งพร้อมไฟล์แนบแล้ว!!";
            $return = [
              "status" => "00",
              "message" => "success",
              "email" => $email
            ];
          }else{
            $return = [
              "status" => "01",
              "message" => "ส่ง Email ไม่สำเร็จ"
            ];
          }
          
          /*//$strTo = $email;
          $strTo = $email;
          //-- mail Subject --//
          $strSubject = "รีเซ็ตรหัสผ่าน DITP SSO";
          
          //-- mail Header --//
          $strHeader = "Content-type: text/html; charset=UTF-8\n"; // or UTF-8 //
          $strHeader .= "From: DITP SSO <kittiporn.s@ibusiness.co.th>\nReply-To: kittiporn.s@ibusiness.co.th";
          
          //-- mail Message --//
          $strMessage = "<center><h2>DITP SSO : Code Reset Password</h2><hr/>";
          $strMessage .= "<center><h2>กรุณาใช้ตัวเลข 4 หลัก ในการรีเซ็ตรหัสผ่าน</h2><br/>";
          $strMessage .= "<h1><b>{$number}</b></h1>";
          $strMessage .= "</center>";

          try{
            $flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);
          }catch (Exception $e){
            $return = [
              "status" => "01",
              "message" => $e
            ];
          }*/
          /*$return = [
            "status" => "00",
            "message" => "success",
            "email" => $email
          ];*/


        }else{
          $return = [
            "status" => "01",
            "message" => "ไม่พบบัญชี Email ในระบบ"
          ];
        }
      }else{
        $return = [
          "status" => "01",
          "message" => "ไม่พบบัญชีผู้ใช้ในระบบ"
        ];
      }
    }else{
      $return = [
        "status" => "01",
        "message" => "ไม่พบบัญชีผู้ใช้ในระบบ"
      ];
    }
    return $return;
  }

  function model_curl_insert($data = []){
    // echo "in model_curl_inesrt";
    // print_r($data);
    // exit;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_URL."auth/insert",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      //CURLOPT_POSTFIELDS => array('target' => 'eee','id' => 'id','ss' => 'ss','cid' => 'cid'),
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
        "Cookie: PHPSESSID=hrd6usviag03rqeemrev353ui3"
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response;
  }

  function getinfo_token_reset($q = ''){
    $token_reset = mysqli_real_escape_string($this->db, $q);
    $sql = "SELECT * FROM tb_token_reset WHERE token_reset='$token_reset' AND status = '0'";
    $data = $this->query($sql);
    $return = [];
    if (count($data) > 0) {
      $result = $data[0];

      //----------- update token_reset -------------//
      $this->update('tb_token_reset', ['status'=>'1'], "token_reset_id ='$result[token_reset_id]'");

      if ($result['exp_date'] > date('Y-m-d H:i:s')) {
        $return = [
          'res_code' => '00',
          'res_result' => $result
        ];
      }else{
        $return = [
          'res_code' => '01',
          'res_result' => 'URL Expire <br>please reset again and process within 15 minutes.'
        ];
      }
    }else{
      $return = [
        'res_code' => '01',
        'res_result' => 'Not Found !'
      ];
    }
    return $return;
  }

  /********** save reset_password *********/
  function model_reset_save(){
    $new_password = $this->post('password');
    $reset_data = $this->getinfo_token_reset($this->post('q'));
    //print_r($reset_data);
    if($reset_data['res_code']== '00'){
      $target = $reset_data['res_result']['target'];
      $id = $reset_data['res_result']['member_id'];
      $url = $reset_data['res_result']['redirect_uri'];
      $type = $reset_data['res_result']['response_type'];
      $client_id = $reset_data['res_result']['client_id'];
      $state =  $reset_data['res_result']['state'];

    }else{
      $return = [
        "res_code" => "01",
        "message" => "Token หมดอายุกรุณา Reset ใหม่"
      ];
      return $return;
    }

    try{
      if($target == 'SSO'){

        $this->update('tb_member', ['password'=>sha1($new_password)], "member_id ='$id'");
        $sql_ssvsv = 'SELECT * FROM tb_member WHERE member_id ="'.$id.'" ';
        $val = $this->query($sql_ssvsv);
      }else if($target == 'CARE'){
        //$sql_cid = "SELECT * FROM Member WHERE member_id = '$id'";
        $sql_cid = "SELECT * FROM Member_v2 WHERE member_id = '$id'";
        $result_cid = $this->query($sql_cid);
        $member_cid = $result_cid[0]['member_cid'];
        $sql_ssvsv = 'SELECT * FROM Member_v2 WHERE member_id ="'.$id.'" ';
        $val = $this->query($sql_ssvsv);
        $data = [
          'target' => 1,
          'id' => $id,
          'ss' => $new_password, //password
          'cid' => $member_cid
        ];
        
        $res = $this->model_insert_v2($data);
        //$res_result = json_decode($res,1);
        if($res['res_code'] != "00"){
          $return = [
            "res_code" => "01",
            "message" => "Error insert failed"
          ];
          return $return;
        }else{
          return $res;
        }

      }else if($target == 'DRIVE'){
        $sql_cid = "SELECT * FROM Member_drive_v3 WHERE UserID = '$id'";
        $result_cid = $this->query($sql_cid);
        $member_cid = $result_cid[0]['Username'];
        $val = $this->query($sql_cid);
        $data = [
          'target' => 2,
          'id' => $id,
          'ss' => $new_password,
          'cid' => $member_cid
        ];

        $res = $this->model_insert_v2($data);
        //$res_result = json_decode($res,1);
        if($res['res_code'] != "00"){
          $return = [
            "res_code" => "01",
            "message" => "Error inser failed"
          ];
          return $return;
        }else{
          return $res;
        }
        
      } else if ($target == 'SSO RESET') {
        $this->update('tb_member', ['password'=>sha1($new_password)], "member_id ='$id'");
        $sql_ssvsv = 'SELECT * FROM tb_member WHERE member_id ="'.$id.'" ';
        $val = $this->query($sql_ssvsv);
      }
      
      $data_client = $this->get_data_client($client_id);
      $key = $data_client['jwt_signature'];

      if (strtoupper($type) == 'CODE') {
        $data_access = $this->gen_access_new($id, $client_id);
        if (!empty($data_access['access'])) {
          $jwt_data = [
            'access_token' => $data_access['access'],
            'end_date' => $data_access['exp_date'],
            "token_type" => "Bearer"
          ];
          $jwt = JWT::encode($jwt_data, $key);
          $url .= '?code=' . $jwt . "&state=" . $state;
  
          $return = [
            'res_code' => '00',
            'message' => 'Success',
            'url' => $url
  
          ];
  
          $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
          setcookie($this->config->items('cookie_access'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        }
      } else if (strtoupper($type) == 'TOKEN') {
        $data_token = $this->gen_token_new($id, $client_id);
        if (!empty($data_token['token'])) {
          $jwt_data = [
            'id_token' => $data_token['token'],
            'refresh_token' => $data_token['refresh_token'],
            'end_date' =>  $data_token['exp_date'],
            'end_date_refresh' =>  $data_token['exp_date_refresh'],
            "token_type" => "Bearer"
          ];

          $jwt = JWT::encode($jwt_data, $key);
          $url .= '?code=' . $jwt . "&state=" . $state;
          $return = [
            'res_code' => '00',
            'message' => 'Success',
            'url' => $url
          ];

          $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
          setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
       }
      }

      unset($_SESSION['id']);
      unset($_SESSION['status_reset']);
      unset($_SESSION['number']);
      /*$return = [
        'status' => true,
        'message' => 'Success',
      ];*/

    } catch (Exception $e){
      $return = [
        "res_code" => "01",
        "message" => "Error insert failed"
      ];
    }
 
    array_push($return , ['redirect_uri' => $url, 'client_id' => $client_id, 'response_type' => $type]);
    $checkconsent = $this->checkconsent([$val,$return,$_SESSION['redirect_uri']]);
    if(count($checkconsent) > 0){
      $return_data = array_merge($return, ['pdpa' => $checkconsent]);
      return $return_data;
    }
    return $return;

  }

  function _model_reset_save(){
    $new_password = $this->post('password');
    try{
      $this->update('tb_member', ['password'=>sha1($new_password)], "member_id ='$_SESSION[id]'");
      $url = $_SESSION['redirect_uri'];
      $type = $_SESSION['response_type'];
      $client_id = $_SESSION['client_id'];

      $data_client = $this->get_data_client($_SESSION['client_id']);
      $url = $_SESSION['redirect_uri'];
      $type = $_SESSION['response_type'];

      $key = $data_client['jwt_signature'];
      $state =  $_SESSION['state'];

      if (strtoupper($type) == 'CODE') {
        $data_access = $this->gen_access($_SESSION['id']);
        if (!empty($data_access['access'])) {
          $jwt_data = [
            'access_token' => $data_access['access'],
            'end_date' => $data_access['exp_date'],
            "token_type" => "Bearer"
          ];
          $jwt = JWT::encode($jwt_data, $key);
          $url .= '?code=' . $jwt . "&state=" . $state;
  
          $return = [
            'status' => '00',
            'message' => 'Success',
            'url' => $url
  
          ];
  
          $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
          setcookie($this->config->items('cookie_access'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        }
      } else if (strtoupper($type) == 'TOKEN') {
        $data_token = $this->gen_token($_SESSION['id']);
        if (!empty($data_token['token'])) {
          $jwt_data = [
            'id_token' => $data_token['token'],
            'refresh_token' => $data_token['refresh_token'],
            'end_date' =>  $data_token['exp_date'],
            'end_date_refresh' =>  $data_token['exp_date_refresh'],
            "token_type" => "Bearer"
          ];

          $jwt = JWT::encode($jwt_data, $key);
          $url .= '?code=' . $jwt . "&state=" . $state;
          $return = [
            'status' => '00',
            'message' => 'Success',
            'url' => $url
          ];

          $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
          setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
       }
      }

      unset($_SESSION['id']);
      unset($_SESSION['status_reset']);
      unset($_SESSION['number']);
      /*$return = [
        'status' => true,
        'message' => 'Success',
      ];*/

    } catch (Exception $e){
      $return = [
        "status" => "01",
        "message" => "Error inser failed"
      ];
    }
    return $return;
  }

  /********** update member_id ***************/
  function model_update_member(){
    $_POST = json_decode(file_get_contents("php://input"), 1);
    $user_id = $_POST['user_id'];
    $client_id = $_POST['client_id'];
    $code = $_POST['code'];

    $return = [
      'res_code' => '01',
      'res_text' => 'Update Member Fail'
    ];

    if(empty($user_id) || empty($client_id) || empty($code)){
      $return = [
        'res_code' => '01',
        'res_text' => 'Value is null'
      ];
      return $return;
      exit;
    }
    $sql_m = 'SELECT * FROM tb_merchant where client_id="' . mysqli_real_escape_string($this->db, $client_id) . '" and status = 1 limit 1';
    $query = $this->query($sql_m);
    if (count($query) > 0) {
      $data = $query[0];
      $key = $data['jwt_signature'];

      //decode JWT//
      $sub_code = explode(' ', $code);
      if (count($sub_code) > 1) {
        if ($sub_code[0] == 'Bearer' && $sub_code[1]) {
          //echo json_encode($sub_code[0]); die();
          try {
            $decoded = JWT::decode($sub_code[1], $key, array('HS256'));
            
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
    }

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

          $sql_c = "SELECT * FROM tb_member_app_id WHERE member_id='" . $tokendata['member_id'] . "' AND client_id='" . $client_id . "' HAVING member_id_app != ''";
          $query_c = $this->query($sql_c);
          if(count($query_c) > 0){
            $return = ['res_code' => '01', 'res_text' => 'This UserID already information'];
          }else{
            //echo "ยังไม่มีข้อมูล";
            $sql_m = 'SELECT * FROM tb_member WHERE member_id="' . $tokendata['member_id'] . '" and status = 1 limit 1';
            $query_m = $this->query($sql_m);
            if (count($query_m) > 0) {
              $data_m = $query_m[0];

              $data = [
                'member_id' => $tokendata['member_id'], //id ของ tb_member
                'member_id_app' => $user_id, //primary in app
                'client_id' => $client_id
              ];
              $insert = $this->insert('tb_member_app_id', $data);
              $return = [
                'res_code' => '00',
                'res_text' => 'Success !'
              ];
              
            }
          }


        }
      }
    }
    return $return;
  }


  function model_update_token(){
    $_POST = json_decode(file_get_contents("php://input"), 1);
    $ssoid = $_POST['ssoid'];
    $user_id = $_POST['user_id'];
    $token = $_POST['token'];
    
    if(!isset($ssoid) && !isset($user_id) && !isset($token)){
      $return = [
        'res_code' => '01',
        'res_text' => 'Require fill'
      ];
    }
    $sql = "SELECT * FROM tb_member WHERE sso_id = '".$ssoid."'";
    $result = $this->query($sql);
    $read = $result[0];

    if(count($result) > 0){
      $member_id = $read['member_id'];
      $data = [
        'member_id' => $member_id,
        'member_id_app' => $user_id,
        'token_code' => $token,
        'member_type' => 'CARE'
      ];

      $insert = $this->insert('tb_token_external', $data);
      $return = [
        'res_code' => '00',
        'res_text' => 'Success !'
      ];
    }

    return $return;
  }

  function model_ck_token($q = '', $ref_code = ''){
    $token_reset = mysqli_real_escape_string($this->db, $q);
    $ref_code = mysqli_real_escape_string($this->db, $ref_code);
    $sql = "SELECT * FROM tb_token_reset WHERE token_reset='$token_reset'";
    $data = $this->query($sql);
    $return = [];
    if (count($data) > 0) {
      $result = $data[0];
      if ($result['ref_code'] == $ref_code) {
        if ($result['exp_date'] > date('Y-m-d H:i:s')) {
          if ($result['status'] == '1'){
            $return = [
              'res_code' => '01',
              'res_text' => 'ขออภัยลิงก์ นี้ไม่สามารถใช้งานได้'
            ];
          }else{
            $return = [
              'res_code' => '00',
              'res_text' => 'success !'
            ];
          }
        }else{
          $return = [
            'res_code' => '01',
            'res_text' => 'ลิงก์หมดอายุ <br>กรุณาทำรายการภายใน 15 นาที'
          ];
        }
      } else {
        $return = [
          'res_code' => '01',
          'res_text' => 'รหัสอ้างอิงไม่ถูกต้อง'
        ];
      }
    }else{
      $return = [
        'res_code' => '01',
        'res_text' => 'Not Found !'
      ];
    }

    return $return;
  }

  function model_check_ldap(){
      // print_r(22222);
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

    $username = $this->post('email');
    $password = $this->post('password');
    $ssoid = $this->post('ssoid');

    $ip = $this->get_client_ip();
    $ck_ssoid = $this->get_mc_id($ssoid);
    // print_r($ck_ssoid);
    
    // // print_r('$ck_ssoid');
    // exit;
    // if(!$ck_ssoid || $ip != '10.8.1.4'){
    //   return [
    //     'res_code' => '01',
    //     'res_text' => 'not allow'
    //   ];
    // }
    $return = [
        'res_code' => '01',
        'res_text' => 'Login fail'
    ];


    $ldap_uri = "ldap://10.8.99.17";
    $ds = ldap_connect($ldap_uri) or die('Could not connect to LDAP server.');
    $r = ldap_bind($ds);      // this is an "anonymous" bind, typically
                            // read-only access
    $sr=ldap_search($ds, "ou=mail,dc=linux,dc=co,dc=th", "mail=".$username);
    $info = ldap_get_entries($ds, $sr);
    // pr($info);
    // exit;
    if ($info["count"]>0){
        $first_name = $info[0]["cn"][0];
        $last_name = $info[0]["sn"][0];
        $uid = $info[0]["uid"][0];
        $displayname = $info[0]["displayname"][0];
        // print_r($info[0]['employeetype']);
        // exit;
        (isset($info[0]["employeetype"][0]))? $title = $info[0]["employeetype"][0] : $title = "";
        (isset($info[0]["employeetype"][0]))? $employeetype = $info[0]["employeetype"][0] : $employeetype = "";
        (isset($info[0]["telephonenumber"][0]))? $telephonenumber = $info[0]["telephonenumber"][0] : $telephonenumber = "";
        (isset($info[0]["mail"][0]))? $mail = $info[0]["mail"][0] : $mail = "";

        $result = [
            'uid' => $uid,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'displayname' => $displayname,
            'title' => $title,
            'employeetype' => $employeetype,
            'telephonenumber' => $telephonenumber,
            'mail' => $mail,
            'agency' => explode("=", explode(",", $info[0]["dn"])[2])[1]
        ];  

        $dn=$info[0]["dn"];
        $cn=$info[0]["cn"][0];
        $sn=$info[0]["sn"][0];
        $ldapbind = @ldap_bind($ds, $dn, $password);

        if($ldapbind){
            $return = [
                'res_code' => '00',
                'res_text' => 'success',
                'res_result' => $result
            ];
        }else{
            $return = [
                'res_code' => '01',
                'res_text' => 'Password incorrect'
            ];
        }

    }else{
        $return = [
            'res_code' => '01',
            'res_text' => 'Username not found'
        ];
    }

    ldap_close($ds);

    return $return;
  }

  function ck_portal()
  {
    $return = [];
    $ssoid = $this->post('ssoid');

    $client_id = $this->post('client_id');
    $sql = "SELECT cid FROM tb_member WHERE sso_id = {$ssoid}";
    $rs = $this->query($sql);
    $user_name = $rs[0]['cid'];

    //---------------------------- All new ----------------------------//
  
      // $stmt = $this->db->prepare("SELECT * FROM tb_member WHERE cid = ? AND status = 1");
      // $stmt->bind_param("s",$user_name);
      // $stmt->execute();
      // $result = $stmt->get_result();
      // $num = $result->num_rows;
      $sql = "SELECT * FROM tb_member WHERE cid = ".$user_name." AND status = 1";
      $rs = $this->query($sql);
    if(!empty($rs)){ //-- เจอใน tb_member sso ปกติ --//
      // if($rs['type'] == '1'){
      //     $this->updateDBD(['cid' => $rs['cid'],'member_id' => $rs['member_id']]);
      // } 

      // $sql_ck_token_care = "SELECT * FROM tb_token_external WHERE member_id = '".$val['member_id']."' AND member_type = 'CARE'";
      // $result_ck_token_care = $this->query($sql_ck_token_care);

      // // $result_ck_token_care = [];

      // $sql_ck_id_drive = "SELECT * FROM tb_member_app_id WHERE member_id = '".$val['member_id']."' AND client_id = 'ssonticlient'";
      // $result_ck_id_drive = $this->query($sql_ck_id_drive);
      // // $result_ck_id_drive = [];
      $return = $this->get_data_portal_return($rs , $client_id);

      // $code = [];

      // if(count($result_ck_token_care) <= 0){ //-- auto regis care
      //    $code_care = $this->get_code($val['member_id'], 'ssocareid');
      //   $code = [
      //     'code_care' => $code_care
      //   ];  
      // }else{
      //   $code_care = $this->get_code($val['member_id'], 'ssocareid');
      //   $code = [
      //     'code_care' => $code_care
      //   ];  
      // }

      // if(count($result_ck_id_drive) <= 0){ //-- auto regis drive 
      //  $code_drive = $this->get_code($val['member_id'], 'ssonticlient');
      //  if(count($code) != 0){
      //     $code ['code_drive']= $code_drive;
      //  }else{
      //     $code = [ 
      //       'code_drive' => $code_drive
      //     ]; 
      //  }

      // }
      // if((count($result_ck_id_drive) <= 0) && (count($result_ck_token_care) <= 0)){
      //   print_r($code);
      //   $code = array_merge($code, ['code_drive' => $code_drive]);
      //   var_dump((count($result_ck_id_drive) <= 0) && (count($result_ck_token_care) <= 0));

      // }
      // $checkconsent = $this->checkconsent([$val,$return,$_SESSION['redirect_uri']]);
      //  var_dump($checkconsent);
      // die();    
    
      // if(count($code) > 0 && $_SESSION['client_id'] != 'SS0047423'){
      //   $return_data = array_merge($return, ['code' => $code , 'pdpa' => $checkconsent]);
      //   return $return_data;
      // }else if(count($code) > 0 && $_SESSION['client_id'] == 'SS0047423'){
      //   $return_data = array_merge($return, ['code' => $code , 'pdpa' => $checkconsent , 'status' => $_SESSION['state'] ]);
      //   return $return_data;
      // }else if($_SESSION['client_id'] == 'SS0047423'){
      //   $return_data = array_merge($return, ['pdpa' => $checkconsent , 'status' => $_SESSION['state'] ]);
      //   return $return_data;
      // }else{
      //   $return_data = array_merge($return, ['pdpa' => $checkconsent]);
      //   return $return_data;
      // }
      return $return;

    }else{

      //-- ถ้าไม่เจอใน tb_member sso จะไปหาอีก 2 ตาราง Member Member_drive --//
      $data = [];
      //$stmt_drive = $this->db->prepare("SELECT * FROM Member_drive WHERE Username = ?"); //หาใน Drive
      $stmt_drive = $this->db->prepare("SELECT * FROM Member_drive_v3 WHERE Username = ?"); //หาใน Drive
      $stmt_drive->bind_param("s",$user_name);
      $stmt_drive->execute();
      $result_drive = $stmt_drive->get_result();
      $num_drive = $result_drive->num_rows;
      // print_r($result_drive);
      // exit;
      if($num_drive > 0){
        $ck_drive = $this->verify_password_drive($user_name, $user_password);
        $data_ck = json_decode($ck_drive,1);
        if(isset($data_ck['VerifyStatus']) && ($data_ck['VerifyStatus'] == "True")){ //check user pass DRIVE
          $read_drive = $result_drive->fetch_assoc();
          array_push($data, array(
              "member_id" => $read_drive['UserID'],
              "member_name" => $read_drive['Firstname'],
              "member_lastname" => $read_drive['LastName'],
              "member_target" => '2', //1 = care, 2 = drive
              "member_target_name" => 'DRIVE'
            )
          );
        }else{
          $user_notfound = true;
        }
      }
      else{
        //$stmt_care = $this->db->prepare("SELECT * FROM Member WHERE member_cid = ?"); //หาใน care
        $stmt_care = $this->db->prepare("SELECT * FROM Member_v2 WHERE member_cid = ?");
        $stmt_care->bind_param("s",$user_name);
        $stmt_care->execute();
        $result_care = $stmt_care->get_result();
        $num_care = $result_care->num_rows;
        if($num_care > 0){
          while($read_care = $result_care->fetch_assoc()){
            $ck_care = $this->check_password($read_care['member_password'], $user_password); //check user pass CARE
            if($ck_care){
              array_push($data, array(
                  "member_id" => $read_care['member_id'],
                  "member_name" => $read_care['member_fname'],
                  "member_lastname" => $read_care['member_lname'],
                  "member_target" => '1', //1 = care, 2 = drive
                  "member_target_name" => 'CARE'
                )
              );
            }else{
              $user_notfound = true;
            }
          }
        }
      }
      


      if(sizeof($data) == 1){ //--- กรณีเจอข้อมูลเดียว CARE หรือ DRIVE ---//
        //------- นำข้อมูลมา Insert tb_member --------//
        $table = $data[0]['member_target'];
        $id = $data[0]['member_id'];  //Primary ของ Drive

        if($table == 1){ //---- insert_care ----//
          //$sql_get = "SELECT * FROM Member where member_id ='" . $id ."'";
          $sql_get = "SELECT * FROM Member_v2 where member_id ='" . $id ."'";
          $data_get = $this->query($sql_get);
          $read_get = $data_get[0];
          //$type = $read_get['member_type']; //0 = คนทั่วไป, 1 = ตัวแทนบริษัท

          //--------------------- insert master tb_member --------------------------//
          $data_insert_member = [
            'member_app' => '',
            'member_app_id' => '',
            'cid' => $user_name,
            'password' => sha1($user_password),
            'type' => '3',
            'status' => '1'
          ];
    
          $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
          $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
          $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
          $ck_mem = $this->insert('tb_member', $data_insert_member);
          //--------------------- end of insert master tb_member ------------------------//


          //------------------------ insert tb_member_type3 ----------------------------------//
          if(!empty($ck_mem)){
            $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $result_max = $this->query($sql_max);
            $member_id = $result_max[0]['member_id'];

            //--------------------- insert member_app ----------------------//
            $data_insert_member_app = [
              'member_id' => $member_id, //id ของ tb_member
              'member_id_app' => $id, //primary in app
              'client_id' => 'ssocareid'
            ];
            $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
            //----------------- end of insert member_app -------------------//

            //------------- insert tb_token_external -----------------//
            $data_insert_token_external = [
              'member_id' => $member_id,
              'member_id_app' => $id,
              'token_code' => $read_get['member_api_key'],
              'member_type' => 'CARE',
            ];
            $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
            //------------- end of tb_token_external ----------------//
            
            $data_insert_type3 = [
              'member_id' => $member_id,
              'member_title' => '',
              'member_nameTh' => $read_get['member_fname'],
              'member_lastnameTh' => $read_get['member_lname'],
              'member_nameEn' => '',
              'member_lastnameEn' => '',
              'email' => $read_get['member_email'],
              'tel' => $read_get['member_cellphone'],
              'tel_country' => '',
              'tel_code' => '',
              'addressTh' => $read_get['member_address'],
              'provinceTh' => '',
              'districtTh' => '',
              'subdistrictTh' => '',
              'postcode' => $read_get['member_postcode'],
              'addressEn' => '',
              'provinceEn' => '',
              'districtEn' => '',
              'subdistrictEn' => ''
            ];
            $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

            $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
            $data_get2 = $this->query($sql_get2);
            $read_get2 = $data_get2[0];
            //$return = $this->get_data_return($read_get2);
            $data_return = $this->get_data_return($read_get2);
          }
          //----------------------- end of insert tb_member_type3 ---------------------------//

          //-------------------- insert_touch ----------------------------/
          $data_insert_touch = [
            'register_type' => 'FORM',
            'identify' => 'PERSONAL',
            'email' => $read_get['member_email'],
            'password' => $user_password,
            'firstname' => $read_get['member_fname'],
            'lastname' => $read_get['member_lname'],
            'citizen_id' => $user_name,
            'mobile' => $read_get['member_cellphone']
          ];
          $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

          if($insert_connect2['status'] == TRUE){

            //-------- update member_id and token connect --------//
            $member_id_connect = $insert_connect2['member_id'];
            $token_connect = $insert_connect2['token'];
            $id_connect = $insert_connect2['member_id'];

            $data_insert_member_app = [
              'member_id' => $member_id, //id ของ tb_member
              'member_id_app' => $member_id_connect, //primary in app
              'client_id' => 'SS6931846'
            ];
            $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

            //------- insert token_external --------//
            $data_insert_token_external = [
              'member_id' => $member_id,
              'member_id_app' => $id_connect,
              'token_code' => $token_connect,
              'member_type' => 'TOUCH',
            ];
            $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
          }
          //----------------------- End of insert touch -------------------------//


          //-------------------- return ----------------//
          $code_drive = $this->get_code($member_id, 'ssonticlient');
          $code = [
            'code_drive' => $code_drive
          ];
          $return = array_merge($data_return, ['code' => $code]);
          //----------------- end of return -----------------//

        }else if($table == 2){ //insert_drive
          //$sql_get = "SELECT * FROM Member_drive where UserID ='" . $id ."'";
          $sql_get = "SELECT * FROM Member_drive_v3 where UserID ='" . $id ."'";
          $data_get = $this->query($sql_get);
          $read_get = $data_get[0];
          $type = $read_get['UserType']; //corporate, person
          $is_thai = $read_get['Is_Thai'];

          if($type == 'corporate' ){
            //-- insert master member --//
            $data_insert_member = [
              'member_app' => '',
              'member_app_id' => '',
              'cid' => $user_name,
              'password' => sha1($user_password),
              'type' => ($is_thai == "Y")? '1' : '2',
              'status' => '1'
            ];
            $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
            $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
            $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
            $ck_mem = $this->insert('tb_member', $data_insert_member);
            
            if(!empty($ck_mem)){
              $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
              $result_max = $this->query($sql_max);
              $member_id = $result_max[0]['member_id']; //Primary ใน tb_member

              //-- insert member_app --//
              $data_insert_member_app = [
                'member_id' => $member_id, //id ของ tb_member
                'member_id_app' => $id, //primary in app
                'client_id' => 'ssonticlient'
              ];
              $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
              //-- end of insert member_app --//
              
              //----------- insert_touch ----------//
              $data_insert_touch = [
                'register_type' => 'FORM',
                'identify' => 'CORPORATE',
                'email' => $read_get['Mail'],
                'password' => $user_password,
                'company_name' => $read_get['Firstname'],
                'company_tax_id' => $user_name,
                'company_telephone' => $read_get['Telephone']
              ];
              $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 2), TRUE); //2 IS CORPORATE

              if($insert_connect2['status'] == TRUE){

                //-------- update member_id and token connect --------//
                $member_id_connect = $insert_connect2['member_id'];
                $token_connect = $insert_connect2['token'];
                $id_connect = $insert_connect2['member_id'];

                $data_insert_member_app = [
                  'member_id' => $member_id, //id ของ tb_member
                  'member_id_app' => $member_id_connect, //primary in app
                  'client_id' => 'SS6931846'
                ];
                $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

                //------- insert token_external --------//
                $data_insert_token_external = [
                  'member_id' => $member_id,
                  'member_id_app' => $id_connect,
                  'token_code' => $token_connect,
                  'member_type' => 'TOUCH',
                ];
                $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
              }
              //-------- End of insert touch ---------//

              if($is_thai == "Y"){
                $member_type_connect = "THAI";
                //-- insert member_type1 --//
                $data_insert_type1 = [
                  'member_id' => $member_id,
                  'company_nameTh' => $read_get['Firstname'],
                  'member_email' => $read_get['Mail'],
                  'member_tel' => $read_get['Telephone'],
                ];
    
                $insert_type1 = $this->insert('tb_member_type1', $data_insert_type1);

                $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
                $data_get2 = $this->query($sql_get2);
                $read_get2 = $data_get2[0];
                //$return = $this->get_data_return($read_get2);
                $data_return = $this->get_data_return($read_get2);

              }else if($is_thai == "N"){
                $member_type_connect = "FOREIGN";
                //-- insert member_type2 --//
                $data_insert_type2 = [
                  'member_id' => $member_id,
                  'corporate_name' =>  $read_get['Firstname'],
                  'email' => $read_get['Mail'],
                  'tel' => $read_get['Telephone'],
                ];
    
                $insert_type2 = $this->insert('tb_member_type2', $data_insert_type2);

                $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
                $data_get2 = $this->query($sql_get2);
                $read_get2 = $data_get2[0];
                //$return = $this->get_data_return($read_get2);
                $data_return = $this->get_data_return($read_get2);
              }
            }

          }else if($type == 'person'){
            //-- insert master member --//
            $data_insert_member = [
              'member_app' => '',
              'member_app_id' => '',
              'cid' => $user_name,
              'password' => sha1($user_password),
              'type' => ($is_thai == "Y")? '3' : '4',
              'status' => '1'
            ];
            $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
            $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
            $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
            $ck_mem = $this->insert('tb_member', $data_insert_member);
            
            if(!empty($ck_mem)){
              $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
              $result_max = $this->query($sql_max);
              $member_id = $result_max[0]['member_id'];

              //--------------------- insert member_app ----------------------//
              $data_insert_member_app = [
                'member_id' => $member_id, //id ของ tb_member
                'member_id_app' => $id, //primary in app
                'client_id' => 'ssonticlient'
              ];
              $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
              //----------------- end of insert member_app -------------------//

              //------------------ insert touch -----------------------//
              $data_insert_touch = [
                'register_type' => 'FORM',
                'identify' => 'PERSONAL',
                'email' => $read_get['Mail'],
                'password' => $user_password,
                'firstname' => $read_get['Firstname'],
                'lastname' => $read_get['LastName'],
                'citizen_id' => $user_name,
                'mobile' => $read_get['Telephone']
              ];
              $insert_connect2 = json_decode($this->insert_touch($data_insert_touch, 1), TRUE); //1 IS PERSONAL

              if($insert_connect2['status'] == TRUE){

                //-------- update member_id and token connect --------//
                $member_id_connect = $insert_connect2['member_id'];
                $token_connect = $insert_connect2['token'];
                $id_connect = $insert_connect2['member_id'];

                $data_insert_member_app = [
                  'member_id' => $member_id, //id ของ tb_member
                  'member_id_app' => $member_id_connect, //primary in app
                  'client_id' => 'SS6931846'
                ];
                $insert = $this->insert('tb_member_app_id', $data_insert_member_app);

                //------- insert token_external --------//
                $data_insert_token_external = [
                  'member_id' => $member_id,
                  'member_id_app' => $id_connect,
                  'token_code' => $token_connect,
                  'member_type' => 'TOUCH',
                ];
                $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
              }
              //------------------ End of insert touch -----------------------//

              if($is_thai == "Y"){ //-- บุคคลไทย
                $member_type_connect = "THAI";
                //-- insert member_type3 --//
                $data_insert_type3 = [
                  'member_id' => $member_id,
                  'member_nameTh' => $read_get['Firstname'],
                  'member_lastnameTh' => $read_get['LastName'],
                  'email' => $read_get['Mail'],
                  'tel' => $read_get['Telephone'],
                ];
                $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

                //-- get_return state --//
                $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
                $data_get2 = $this->query($sql_get2);
                $read_get2 = $data_get2[0];
                //$return = $this->get_data_return($read_get2);
                $data_return = $this->get_data_return($read_get2);

              }else if($is_thai == "N"){ //-- บุคคลต่างชาติ
                $member_type_connect = "FOREIGN";
                //-- insert member_type4 --//
                $data_insert_type4 = [
                  'member_id' => $member_id,
                  'member_nameEn' => $read_get['Firstname'],
                  'member_lastnameEn' => $read_get['LastName'],
                  'email' => $read_get['Mail'],
                  'tel' => $read_get['Telephone'],
                ];
                $insert_type4 = $this->insert('tb_member_type4', $data_insert_type4);

                //-- get_return state --//
                $sql_get2 = "SELECT * FROM tb_member where member_id ='" . $member_id ."'";
                $data_get2 = $this->query($sql_get2);
                $read_get2 = $data_get2[0];
                //$return = $this->get_data_return($read_get2);
                $data_return = $this->get_data_return($read_get2);
              }
            }
          }

          //-------------------- return ----------------//
          $code_care = $this->get_code($member_id, 'ssocareid');
          $code = [
            'code_care' => $code_care,
            'xx' => $user_password,
            'ee' => $read_get['Mail']
          ];
          $return = array_merge($data_return, ['code' => $code]);
          //----------------- end of return -----------------//
        }
      }else if(sizeof($data) > 1){
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_password'] = $user_password;

        $return = ['status' => '01', 'data' => $data];
      }
    }

    if (empty($return)) {
      //$return['error'] = lang('signin_fail');

      if($user_notfound){
        $return['error'] = lang('password_incorrect');
        return $return;
      }

      (lang('user_notfound') == 'ไม่พบผู้ใช้ในระบบ')? $return['error'] = 'ไม่พบบัญชีผู้ใช้งาน' : $return['error'] = lang('user_notfound') ;

    }

    return $return;
  }

  function ck_com_dbd ($cid = '') {
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
    $URL = BASE_URLS."dbdws/";

    //$URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService";
    // $URL = "https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService";
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
      $return = $array;
    }
    $dbd = [];
    if (!empty($return['ns0getDataResponse']['return']['arrayRRow']['childTables'][0]['rows'])) {
      foreach ($return['ns0getDataResponse']['return']['arrayRRow']['childTables'][0]['rows'] as $key => $value) {
        if ($value['columns']) {
          $commitee = $value['columns'][3]['columnValue'] . $value['columns'][4]['columnValue'];
        } else {
          $commitee = $value[3]['columnValue'] . $value[4]['columnValue'];
        }
        
        $commitee = str_replace("/", "", $commitee);
        array_push($dbd, $commitee);
      }
      $res = [
        'res_code' => '00',
        'res_text' => 'success',
        'res_result' => $dbd
      ];
      return $res;
    }

    $res = [
      'res_code' => '01',
      'res_text' => 'ไม่พบข้อมูล'
    ];
    return $res;
    
  }

  function model_verify_director($member_id = '') {
    $sql = "SELECT * FROM tb_member m LEFT JOIN tb_member_type1 t ON m.member_id = t.member_id WHERE m.member_id = {$member_id}";
    $return = $this->query($sql);
    if (empty($return)) {
      return false;
    }
    $return = $return[0];
    
    $dbd = $this->ck_com_dbd($return['cid']);
    $return['dbd'] = [];
    foreach ($dbd['ns0getDataResponse']['return']['arrayRRow']['childTables'][0]['rows'] as $key => $value) {
      if ($value['columns']) {
        $commitee = $value['columns'][3]['columnValue'] . $value['columns'][4]['columnValue'];
      } else {
        $commitee = $value[3]['columnValue'] . $value[4]['columnValue'];
      }
      $commitee = str_replace("/", "", $commitee);
      array_push($return['dbd'], $commitee);
    }

    return $return;

  }
  function model_director_form_send() {
    $email = $this->post('contact_director_email');
    $tel = str_replace(" ", "", $this->post('contact_director_tel'));
    $tel_country = ($this->post('contact_director_tel_country') == '')? 'TH' : $this->post('contact_director_tel_country');
    $tel_code = ($this->post('contact_director_tel_code') == '')? '+66' : $this->post('contact_director_tel_code');
    $member_id = $this->post('member_id');
    if (empty($this->post('contact_director_email')) || empty($this->post('contact_director_tel'))) {
      return $res = [
        'res_code' => '01',
        'res_text' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
      ];
    }

    $sql = "SELECT * FROM tb_member m LEFT JOIN tb_member_type1 t ON m.member_id = t.member_id WHERE t.member_id = {$member_id}";
    $user = $this->query($sql);
    $user = $user[0];

    if(strlen($tel) < 10) {
      return $res = [
        'res_code' => '01',
        'res_text' => 'เบอร์โทรศัพท์ไม่ถูกต้อง'
      ];
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return $res = [
        'res_code' => '01',
        'res_text' => 'รูปแบบอีเมลไม่ถูกต้อง'
      ];
    }

    if ($user['member_email'] == $email) {
      return $res = [
        'res_code' => '01',
        'res_text' => 'ไม่สามารถใช้อีเมลซ้ำกับผู้รับมอบอำนาจได้'
      ];
    }

    $this->update('tb_member_type1', ['director_email' => $email, 'director_tel' => $tel, 'director_tel_country' => $tel_country, 'director_tel_code' => $tel_code, 'status_case' => 1], "member_id ='{$member_id}'");

    

    $send_mail_data = [
      'member_id' => $member_id,
      'email' => $email,
      'title' => $user['member_title'],
      'name' => $user['member_nameTh'],
      'lastname' => $user['member_lastnameTh']
    ];

    $send = $this->send_mail_director($send_mail_data);
    $send_mail_director_log = [
      'member_id' => $member_id,
      'res' => json_encode($send)
    ];
    $this->insert('tb_send_mail_director_log', $send_mail_director_log);
    return $return = [
      'res_code' => '00',
      'res_text' => 'ระบบจะส่งอีเมลเพื่อยืนยันฐานะผู้รับมอบอำนาจของท่านไปยังอีเมลของกรรมการและกรรมการของท่านจะต้องกรอกข้อมูลยืนยัน เพื่ออนุมัติว่าท่านเป็นผู้รับมอบอำนาจจริง '
    ];
  }

  function model_director_change_status () {

    $member_id = $this->post('member_id');
    
    $this->update('tb_member_type1', ['director_status' => 2, 'status_case' => 1], "member_id ='{$member_id}'");

    return $return = [
      'res_code' => '00',
      'res_text' => 'success'
    ];

  }
  function model_director_send_sms_verify(){
    
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ"
    ];
  
    $member_id = $this->post('member_id');
    $target = $this->post('target');
    $tel = $this->post('tel');
  
    if($tel != "" && $member_id !="" && $target != ""){

      $_SESSION['id'] = $member_id;
      $_SESSION['tel'] = $tel;
      $_SESSION['target'] = $target;


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
        CURLOPT_POSTFIELDS => array('member_id' => $member_id,'tel' => $tel,'target' => $target),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      $res = json_decode($response);

      if ($res->status == "00") {
        $return = [
          "status" => "00",
          "message" => "success",
          "tel" => substr_replace($tel,"XXX",-3,3),
          "real_tel" => $tel,
          "ref_code" => $res->refno,
          "token_verify" => $res->token_verify
        ];
      } else {
        $return = [
          "status" => "01",
          "message" => "ส่ง SMS ไม่สำเร็จ กรุณาติดต่อเจ้าหน้าที่"
        ];
      }
    }
    return $return;
  }

  function model_director_verify_sms(){
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ"
    ];
    $dopa_connect = $this->post('dopa_connect');
    $director_title = $this->post('director_title');
    $director_name = $this->post('director_name');
    $director_lastname = $this->post('director_lastname');
    $token = $this->post('token_verify');
    $target = $this->post('target');
    $otp = $this->post('otp_digit_1') . $this->post('otp_digit_2') . $this->post('otp_digit_3') . $this->post('otp_digit_4') . $this->post('otp_digit_5') . $this->post('otp_digit_6');

    $tel = $this->post('tel');
    $member_id = $this->post('member_id');


    
    if($token != "" && $otp !="" && $target != ""){

      $_SESSION['token'] = $token;
      $_SESSION['tel'] = $tel;
      $_SESSION['target'] = $target;


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
        CURLOPT_POSTFIELDS => array('token_verify' => $token,'ref_code' => $otp,'target' => $target),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      $res = json_decode($response);
      if ($res->res_code == "00") {
        //update status ว่ายืนยัน sms แล้ว
        if ($dopa_connect == 1) {
          $this->update('tb_member_type1', ['status_case' => 99, 'director_approve' => 1, 'director_title' => $director_title, 'director_name' => $director_name, 'director_lastname' => $director_lastname ], "member_id ='{$member_id}'");
        }
        $return = [
          "status" => "00",
          "message" => "success",
          "member_id" => $member_id,
          "tel" => $tel,
          "target" => $target,
        ];
      } else {
        $return = [
          "status" => "01",
          "message" => "ยืนยัน SMS ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง",
          "member_id" => $member_id,
          "tel" => $tel,
          "target" => $target,
        ];
      }
    }
    return $return;
  }

  function laserToken ($data = '' ) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.egov.go.th/ws/auth/validate?ConsumerSecret=gfRZaZFYted&AgentID='.$data,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
        'Consumer-Key: 162e9858-bc39-4fe5-880a-49885481f69c'
      ),
    ));

    $response = curl_exec($curl);
    if ($response === false) {
        curl_close($curl);
        $return = [
          'code' => '01',
          'result' => 'error get token'
        ];
        return json_decode(json_encode($return));
    }

    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($httpCode != 200) {
        curl_close($curl);
        $return = [
          'code' => '01',
          'result' => 'error get token'
        ];
        return json_decode(json_encode($return));
    }

    curl_close($curl);
    $res = json_decode($response);
    return $res;
  }
  function ck_laser_id ($data) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.egov.go.th/ws/dopa/verification/personal?CitizenID='.$data['nationalId'].'&FirstName='.urlencode($data['fname']).'&LastName='.urlencode($data['lname']).'&BEBirthDate='.$data['bday'].'&LaserCode='.$data['laser'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded;Content-type: text/plain; charset=utf-8',
        'Consumer-Key: 162e9858-bc39-4fe5-880a-49885481f69c',
        'Token: '.$data['token']
      ),
    ));
    $response = curl_exec($curl);
    if ($response === false) {
        curl_close($curl);
        $return = [
          'code' => '01',
          'result' => 'error check laser'
        ];
        return json_decode(json_encode($return));
    }

    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($httpCode != 200) {
        curl_close($curl);
        $return = [
          'code' => '01',
          'result' => 'error check laser'
        ];
        return json_decode(json_encode($return));
    }
    curl_close($curl);
    return $response;
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
  public function getLaserError($message, $code) {
    if ($code == 4) {
      switch ($message) {
        case "CitizenID is not valid":
          $return = lang('api_laser_citizen_error');
          break;
        case "[4] สถานะไม่ปกติ => ไม่พบเลข Laser จาก PID นี้":
          $return = lang('api_laser_code_error');
          break;  
        case "[4] สถานะไม่ปกติ => ข้อมูลไม่ตรง":
          $return = lang('api_laser_data_error');
          break;
        case "[4] สถานะไม่ปกติ => ไม่พบเลขรหัสกำกับบัตร จากเลขประจำตัวประชาชนนี้":
          $return = lang('api_laser_code_error');
          break; 
        case "LaserCode is not specify":
          $return = lang('api_laser_not_found_error');
          break;
        default:
          $return = $message;
          break;
      }
    } else {
      $return = $message;
    }
    
    return $return;
  }
  public function laser_validation () {
    if($this->post('cid') == '1509960008227') {
      $_SESSION['laser_verify'] = true;
      $res = [
        'result_code' => '00',
        'result_text' => 'Success',
      ];
    }
    if (empty($this->post('cid')) && empty($this->post('fname')) && empty($this->post('lname')) && empty($this->post('laser_id'))) {
      return  $res = [
          'result_code' => '01',
          'result_text' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
        ];      
    }

    if (empty($this->post('cid'))) {
      return  $res = [
          'result_code' => '01',
          'result_text' => lang('api_laser_citizen_error')
        ];      
    }
    if (empty($this->post('laser_id'))) {
      return  $res = [
          'result_code' => '01',
          'result_text' => lang('api_laser_not_found_error')
        ];      
    }
    $insert_dopa_log = [
      'endpoint' => $this->post('endpoint'),
      'cid' => $this->post('cid'),
      'fname' => $this->post('fname'),
      'lname' => $this->post('lname'),
      'bday' => $this->post('bday'),
      'laser_id' => $this->post('laser_id'),
    ];
    $nationalId = $this->post('cid');
    // if ($nationalId == '1509960008227') {
    //   $res = [
    //     'result_code' => '00',
    //     'result_text' => 'Success',
    //   ];
    //   return $res;
    // }
    $token = $this->laserToken($nationalId);
    if (isset($token->code) && $token->code == '01') {

      $this->insert('tb_verify_dopa_log', $insert_dopa_log);

      return $res = [
          'result_code' => '02',
          'result_text' => 'ไม่สามรถเชื่อต่อ service DOPA'
        ];    
    }
    $date = $this->dateswap($this->post('bday'));
    $laser = str_replace("-","",$this->post('laser_id'));
    if (empty($this->post('fname')) || empty($this->post('lname')) || empty($this->post('laser_id'))) {
        $res = [
          'result_code' => '01',
          'result_text' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
        ];      
    }
    // if ($this->isValidNationalId($nationalId)) {
    //   $res = [
    //     'result_code' => '01',
    //     'result_text' => 'เลขบัตรประจำตัวประชาชน ไม่ถูกต้อง'
    //   ];
    //   return $res;
    // }
    $val = [
      'nationalId' => $nationalId,
      'fname' => $this->post('fname'),
      'lname' => $this->post('lname'),
      'bday' => $date,
      'laser' => $this->post('laser_id'),
      'token' => $token->Result
    ];
    $result = $this->ck_laser_id($val);
    if (isset($result->code) && $result->code == '01') {

      $this->insert('tb_verify_dopa_log', $insert_dopa_log);

      return $res = [
          'result_code' => '02',
          'result_text' => 'ไม่สามรถเชื่อต่อ service DOPA'
        ];    
    }
    $result = json_decode($result);
    if (isset($result->Result)) {
      $_SESSION['laser_verify'] = true;
      $res = [
        'result_code' => '00',
        'result_text' => 'Success',
      ];
    } else {
      $message = $this->getLaserError($result->Message, $result->Code); 
      $res = [
        'result_code' => $result->Code,
        'result_text' => $message
      ];
    }

    return $res;
  }
  
  function dateswap($datadate) {
    $datearray = explode("-",$datadate);
    if (strlen($datadate) > 3) {
      $meyear = $datearray[0] + 543;
      $datadate = $meyear . "" . $datearray[1] . "" . $datearray[2];
    }
   return $datadate;
  }
  function model_attach_file($member_id) {
    $sql = "SELECT * FROM tb_member m LEFT JOIN tb_member_type1 t ON m.member_id = t.member_id WHERE t.member_id = {$member_id}";
    $user = $this->query($sql);
    $user = $user[0];
    $_SESSION['member_id'] = $member_id;
    $_SESSION['director_status'] = $user['director_status'];
    return $user;
  }

  function model_upload_attach_file() {

    if ($_POST) {
      $err = false;
      $type = 0;
      if ($this->post('type')) {
        $type = $this->post('type');
      }
      if (!empty($_FILES)) {
        // if dest folder doesen't exists, create it
        $dest_folder = "asset/attach/".$_SESSION['member_id'];
        if(!is_dir(FILEPATH.$dest_folder)) @mkdir(FILEPATH.$dest_folder,0777);
        chmod(FILEPATH.$dest_folder,0777);
          foreach($_FILES['file']['tmp_name'] as $key => $value) {

            $x = pathinfo($_FILES["file"]["name"][$key]);

            $ext = $x["extension"];

            $filename = date('YmdGis')."-".$this->random_char(5).".".$ext;
              $tempFile = $_FILES['file']['tmp_name'][$key];
              $targetFile =  $dest_folder.'/'. $filename;

              if(is_uploaded_file($_FILES["file"]["tmp_name"][$key]))
              {
                  $moved = move_uploaded_file($tempFile,FILEPATH . $targetFile);
                  if($moved)
                  {
                      $data_insert = [
                        'member_id' => $_SESSION['member_id'],
                        'attachment' => $_FILES["file"]["name"][$key],
                        'attachment_file_name' => $filename,
                        'director_status' => $_SESSION['director_status'],
                        'type_file' => $type,
                        'status' => 0,
                      ];

                      $insert = $this->insert('tb_member_attachment', $data_insert);
                  } else {
                    $err = true;
                  }
              }
          }

          
      } 

      if (!$err) {
        $data_update = [
          'status_case' => 3,
        ];
        $update = $this->update('tb_member_type1', $data_update, ' member_id="' . $_SESSION['member_id'] . '"');
        //เช็คว่ามีไฟล์เก่าไหม
        $sql = "SELECT * FROM tb_member_attachment WHERE status = 2 AND member_id = {$_SESSION['member_id']}";
        $result = $this->query($sql);
        $ck_old_file = $result;
        foreach ($ck_old_file as $key => $value) {
          if(file_exists(FILEPATH . $dest_folder.'/'.$value['attachment_file_name'])){
              unlink(FILEPATH . $dest_folder.'/'.$value['attachment_file_name']);
              $del = "DELETE FROM tb_member_attachment WHERE id = {$value['id']}";
              $this->query($del);
          }
        }

      }
    }
    return false;
  }

  function model_attach_file_get($member_id) {
    $sql = "SELECT * FROM tb_member_attachment WHERE member_id = {$member_id} AND director_status = 2";
    $result = $this->query($sql);
    $file = $result;

    return $file;
  }

  function gen_input_name() {
    $gen_input_username = $this->random_char(5) . '_username_' . $this->random_char(5);
    $gen_input_password = $this->random_char(5) . '_password_' . $this->random_char(5);

    $_SESSION['username'] = $gen_input_username;
    $_SESSION['password'] = $gen_input_password;

    return false;
  }

  function model_redirect_log($url, $pid, $slug, $detail) {
    $data_insert = [
      'link' => $url,
      'pid' => $pid,
      'slug' => $slug,
      'detail' => $detail
    ];

    $insert = $this->insert('tb_redirect_log', $data_insert);

    return $return = [
      'res_code' => '00',
      'res_text' => 'success'
    ];
  }

}
