<?php

require APPPATH.'/library/PHPMailer_v5.0.2/class.phpmailer.php';
use \Firebase\JWT\JWT;

class moc_model extends Model
{
  function __construct()
  {
    parent::__construct();
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
      CURLOPT_URL => "https://driveapi.ditp.go.th/api/VerifyUser",
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

  function ck_login()
  {
    $return = [];
    $user_name = mysqli_real_escape_string($this->db, $this->post('username'));
    $user_password = $this->post('password');
    $user_password_hash = sha1($user_password);

    if ($user_name == '') {
      $return['error'] = lang('required_user');
      return $return;
    }

    if ($user_password == ''){
      $return['error'] = lang('required_pass');
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
      
      $sql_ck_token_care = "SELECT * FROM tb_token_external WHERE member_id = '".$val['member_id']."' AND member_type = 'CARE'";
      $result_ck_token_care = $this->query($sql_ck_token_care);
      
      $sql_ck_id_drive = "SELECT * FROM tb_member_app_id WHERE member_id = '".$val['member_id']."' AND client_id = 'ssonticlient'";
      $result_ck_id_drive = $this->query($sql_ck_id_drive);

      $return = $this->get_data_return($val);

      $code_care = $this->get_code($val['member_id'], 'ssocareid');
      $code_drive = $this->get_code($val['member_id'], 'ssonticlient');
      
      $code = [];
      if(count($result_ck_token_care) <= 0){ //-- auto regis care
        $code = [
          'code_care' => $code_care
        ];  
      }
      if(count($result_ck_id_drive) <= 0){ //-- auto regis drive
        $code = [
          'code_drive' => $code_drive
        ]; 
      }
      if((count($result_ck_id_drive) <= 0) && (count($result_ck_token_care) <= 0)){
        $code = [
          'code_care' => $code_care,
          'code_drive' => $code_drive
        ]; 
      }
      if(count($code) > 0){
        $return_data = array_merge($return, ['code' => $code]);
        return $return_data;
      }
      
      return $return;

    }else{
      $sql_ck_cid = "SELECT 1 FROM tb_member WHERE cid = '$user_name'";
      $result_ck_cid = $this->query($sql_ck_cid);
      if(count($result_ck_cid) > 0){
        //$return['error'] = lang('signin_fail');
        $return['error'] = lang('password_incorrect');
        return $return;
        exit;
      }
      //-- ถ้าไม่เจอใน tb_member sso จะไปหาอีก 2 ตาราง Member Member_drive --//
      $data = [];
      //$stmt_drive = $this->db->prepare("SELECT * FROM Member_drive WHERE Username = ?"); //หาใน Drive
      $stmt_drive = $this->db->prepare("SELECT * FROM Member_drive_v3 WHERE Username = ?"); //หาใน Drive
      $stmt_drive->bind_param("s",$user_name);
      $stmt_drive->execute();
      $result_drive = $stmt_drive->get_result();
      $num_drive = $result_drive->num_rows;
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
      $return['error'] = lang('user_notfound');
    }
    return $return;
  }

  function moc_callback()
  {
  
      $return['access'] = 1;
      $return['exp_date'] = 2;

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

    /******** check input empty **************/
    if(empty($old_password)) $error['old_password'] = 'กรุณากรอกข้อมูล';
    if(empty($new_password)) $error['new_password'] = 'กรุณากรอกข้อมูล';
    if(empty($new_password2)) $error['new_password2'] = 'กรุณากรอกข้อมูล';

    /************* strong password ***********/
    if(!preg_match("#[a-zA-Z]+#", $new_password)) {
      if($_SESSION['lang'] == 'en'){
        $error['new_password'] = "must include at least one letter!";
      }else{
        $error['new_password'] = "ต้องมี a - z อย่างน้อย 1 ตัว";
      }
    }

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
    $sql = "SELECT * FROM tb_member WHERE member_id = '" . $_SESSION['member_id'] . "' AND password = '" . sha1($old_password) . "'";
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
    $sql2 = "SELECT * FROM tb_member WHERE member_id = '" . $_SESSION['member_id'] . "' AND password = '" . sha1($new_password) . "'";
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
        $this->update('tb_member', ['password'=>sha1($new_password)], "member_id ='$_SESSION[member_id]'");
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
        $return = ['redirect' => $_SESSION['redirect_uri']];
        return json_encode($return);
      }
    }
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
      CURLOPT_URL => "https://driveapi.ditp.go.th/api/UserProfile?token=".$this->token_drive."&userid=".$userid,
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
          $return = [
            'status' => '01',
            'message' => 'ไม่พบอีเมลของท่านในระบบ กรุณาติดต่อเจ้าหน้าที่'
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

      //-- เคลียร์ Token เก่า --//
      $this->update('tb_token_reset', ['status'=>'1'], "member_id ='$member_id'");

      //-- insert tb_token_reset --//
      $data_token_reset = [
        'token_reset' => $token_reset,
        'member_id' => $member_id,
        'target' => $target,
        'redirect_uri' => $_SESSION['redirect_uri'],
        'response_type' => $_SESSION['response_type'],
        'client_id' => $_SESSION['client_id'],
        'state' => $_SESSION['state'],
        'status' => '0',
        'exp_date' => $exp_date
      ];
      $insert = $this->insert('tb_token_reset', $data_token_reset);

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
      $mail->Host = "mgtrelay01.mail.go.th";
      $mail->Port = 587;
      $mail->isHTML();
      $mail->CharSet = "utf-8";
      $mail->Username = "sso@ditp.go.th";
      $mail->Password = "Ditp@1169";

      $mail->From = ('sso@ditp.go.th');
      $mail->FromName = "DITP Single Sign-on";
      $mail->Subject = "รีเซ็ตรหัสผ่าน DITP Single Sign-on";

      $url = $this->path_web."auth/reset?q=".$token_reset;
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
      $mail->Body.= '<p>ทาง DITP Single Sign-on ได้รับคำขอของคุณในการเปลี่ยนรหัสผ่าน</p>';
      $mail->Body.= '<p>กรุณากดปุ่ม "เปลี่ยนรหัสผ่าน" และกำหนดรหัสผ่านใหม่</p>';
      $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">';
      $mail->Body.= '<tbody>';
      $mail->Body.= '<tr>';
      $mail->Body.= '<td align="center">';
      $mail->Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
      $mail->Body.= '<tbody>';
      $mail->Body.= '<tr>';
      //$mail->Body.= "<td><a>{$number}</a></td>";
      $mail->Body.= "<td><a href={$url}>เปลี่ยนรหัสผ่าน</a></td>";
      $mail->Body.= '</tr>';
      $mail->Body.= '</tbody>';
      $mail->Body.= '</table>';
      $mail->Body.= '</td>';
      $mail->Body.= '</tr>';
      $mail->Body.= '</tbody>';
      $mail->Body.= '</table>';
      $mail->Body.= '<p>การเปลี่ยนรหัสผ่าน</p>';
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
            // $mail = new PHPMailer();
            // $mail->isSMTP();
            // $mail->SMTPDebug = 2;
            // $mail->SMTPAuth = true;
            // //$mail->SMTPSecure = "tls";
            // $mail->Host = "203.150.62.22"; // ถ้าใช้ smtp ของ server เป็นอยู่ในรูปแบบนี้ mail.domainyour.com
            // $mail->Port = 25;
            // $mail->isHTML();
            // $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
            // $mail->Username = "sso@ditp.go.th"; //กรอก Email Gmail หรือ เมลล์ที่สร้างบน server ของคุณเ
            // $mail->Password = "Ditp@1169"; // ใส่รหัสผ่าน email ของคุณ
            // $mail->SetFrom = ('sso@ditp.go.th'); //กำหนด email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง
            // $mail->FromName = "DITP Single Sign-on"; //ชื่อที่ใช้ในการส่ง
            // $mail->Subject = "รีเซ็ตรหัสผ่าน DITP Single Sign-on";  //หัวเรื่อง emal ที่ส่ง
            
            /*$mail->Body = "<center><div style = '
            border: solid #bfbfbf 1px;
            border-radius: 20px;
            width: 80%;'>";
            $mail->Body .= "<img src=\"https://ssodev.ditp.go.th/sso/asset/img/sso-logo.png\" style='width:80px; padding-top: 10px;'>&nbsp;&nbsp;";
            $mail->Body .= "<img src='".BASE_URL."asset/img/ditp-logo.png' style='width:120px;padding-bottom: 11px;'>";
            $mail->Body .= "<hr width='80%'><center style='color:black'><h4>กรุณาใช้ตัวเลข 4 หลัก ในการรีเซ็ตรหัสผ่าน</h4>";
            $mail->Body .= "<h1 style='color: #08bf11;'><b>{$number}</b></h1>";
            $mail->Body .= "----------------------------------------------";
            $mail->Body .= "<p align='left' style='padding-left:10px;'><b>ขั้นตอนการใช้งาน</b></p>";
            $mail->Body .= "<p align='left' style='padding-left:15px; margin-top:-12px'>1. นำตัวเลข 4 หลักกรอกในช่องที่ปรากฏ <br> 
                      2. จากนั้นจะปรากฏหน้าสำหรับ รีเซ็ตรหัสผ่าน <br>
                      3. ทำการกรอก รหัสผ่านใหม่ <br>
                      4. กด \"ยืนยัน\" เพื่อบันทึกรหัสผ่านใหม่</p>";
            $mail->Body .= "</div></center>";*/
            
            /*$mail->Body = "<center><h2>DITP SSO : Code Reset Password</h2><hr/>"; 
            $mail->Body .= "<center><h2>กรุณาใช้ตัวเลข 4 หลัก ในการรีเซ็ตรหัสผ่าน</h2><br/>";
            $mail->Body .= "<h1><b>{$number}</b></h1>";
            $mail->Body .= "</center>";*/

            //$mail->Body = "ทดสอบส่งเมลล์ในส่วนของรายละเอียดเนื้อหา</b>"; //รายละเอียดที่ส่ง



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
      CURLOPT_URL => "https://sso.ditp.go.th/sso/auth/insert",
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
      }else if($target == 'CARE'){
        //$sql_cid = "SELECT * FROM Member WHERE member_id = '$id'";
        $sql_cid = "SELECT * FROM Member_v2 WHERE member_id = '$id'";
        $result_cid = $this->query($sql_cid);
        $member_cid = $result_cid[0]['member_cid'];
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

  function model_ck_token($q = ''){
    $token_reset = mysqli_real_escape_string($this->db, $q);
    $sql = "SELECT * FROM tb_token_reset WHERE token_reset='$token_reset'";
    $data = $this->query($sql);
    $return = [];
    if (count($data) > 0) {
      $result = $data[0];
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
          'res_text' => 'ลิงก์หมดอายุ กรุณาส่งอีกครั้งและทำรายการภายใน 15 นาที'
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

}
