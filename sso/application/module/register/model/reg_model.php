<?php
require APPPATH.'/library/PHPMailer_v5.0.2/class.phpmailer.php';
use \Firebase\JWT\JWT;

class reg_model extends Model
{

  function __construct()
  {
    parent::__construct();
    // code...
    // $this->db = new db();
  }


  function add_reg()
  {
    return $this->insert_member();
  }
  function con_reg()
  {
    return $this->insert_member(1);
  }
  function ck_client_id($client_id = '')
  {
    $_SESSION['client_id'] = "";
    $sql = "SELECT 1 FROM tb_merchant WHERE client_id='" . mysqli_real_escape_string($this->db, $client_id) . "' and status = 1";
    $data = $this->query($sql);

    if (count($data) > 0) $_SESSION['client_id'] = $client_id;
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

        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));
        setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
      //$return = ['code' => '00', 'success' => 1, 'url' => $url];
      return $url;
    }
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
        $code = $jwt;

        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_access'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
    } else if (strtoupper($response_type) == 'TOKEN') {
      $data_token = $this->gen_token($ck_mem,$client_id);
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
        $code = $jwt;
        $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
        setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
    }
    if(empty($code)){
      return false;
    }else{
      return $code;
    }
  }
  

  function get_province($id, $ln){
    // $sql = "SELECT * FROM dropdown_provinces WHERE id = '".$id."'";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT * FROM dropdown_provinces WHERE id  = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $results = $stmt->get_result();
    $result = $results->fetch_assoc();
    if($ln == 'th') $return = $result['name_th']; else $return = $result['name_en'];
    return $return;
  }

  function get_district($id, $ln){
    
    // $sql = "SELECT * FROM dropdown_amphures WHERE id = '".$id."'";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT * FROM dropdown_amphures WHERE id  = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $results = $stmt->get_result();
    $result = $results->fetch_assoc();
    if($ln == 'th') $return = $result['name_th']; else $return = $result['name_en'];
    return $return;
  }

  function get_subdistrict($id, $ln){
    
    // $sql = "SELECT * FROM dropdown_districts WHERE id = '".$id."'";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT * FROM dropdown_districts WHERE id  = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $results = $stmt->get_result();
    $result = $results->fetch_assoc();
    if($ln == 'th') $return = $result['name_th']; else $return = $result['name_en'];
    return $return;
  }

  function insert_connect($data){ //ไม่ใช้แล้ว ไปใช้ insert_touch แทน
    $data_insert = "member_type=".$data['member_type']."&";
    $data_insert .= "register_type=".$data['register_type']."&";
    $data_insert .= "email=".$data['email']."&";
    $data_insert .= "password=".$data['password']."&";
    $data_insert .= "oauth_token=".$data['oauth_token']."&";
    $data_insert .= "device_id=".$data['device_id']."&";
    $data_insert .= "device_model=".$data['device_model']."&";
    $data_insert .= "device_token=".$data['device_token']."&";
    $data_insert .= "firstname=".$data['firstname']."&";
    $data_insert .= "lastname=".$data['lastname']."&";
    $data_insert .= "sex=".$data['sex']."&";
    $data_insert .= "birthday=".$data['birthday']."&";
    $data_insert .= "mobile=".$data['mobile']."&";
    $data_insert .= "products=".$data['products'];

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://connect.ditp.go.th/api/v3/member/register/",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $data_insert,
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
        "Cookie: PHPSESSID=03886gqmt94vbmsoqtjel9ie30"
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }

  // function insert_connect2($data = []){ //ไม่ใช้แล้วเหมือนกัน ไปใช้ insert_touch แทน
  //   $curl = curl_init();
  //   curl_setopt_array($curl, array(
  //     CURLOPT_URL => "https://api.ditptouch.com/v1/signup",
  //     CURLOPT_RETURNTRANSFER => true,
  //     CURLOPT_ENCODING => "",
  //     CURLOPT_MAXREDIRS => 10,
  //     CURLOPT_TIMEOUT => 0,
  //     CURLOPT_FOLLOWLOCATION => true,
  //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //     CURLOPT_CUSTOMREQUEST => "POST",
  //     CURLOPT_POSTFIELDS => $data
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
      // CURLOPT_URL => "https://api.ditptouch.rgb72.dev/v1/signup",
      // CURLOPT_URL => "https://api.ditptouch.com/v1/signup",
      CURLOPT_URL => "https://api.ditptouch.rgb72.dev/v1/ditp-one/signup",
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

  function insert_care($code){
    //echo "code in curl = ".$code;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://caredev.ditp.go.th/api/api_caresaveuser.php?code=$code",
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
  
    /*echo "res in curl = ";
    print_r($response);
    exit;*/
  }
  function checkconsent($data){
    (isset($data[1]['url']))?  $url = $data[1]['url'] : $url = str_replace('https://caredev.ditp.go.th/api/autologin_sso_v2.php','https://caredev.ditp.go.th/frontend/index.php?page=home',$data[2]); //$url = 'https://caredev.ditp.go.th/': $url = $data[2]."code=".$data[1]['code'];//$data[1]['url']: $url = $data[2]."code=".$data[1]['code'];
      $UrlFail = BASE_URL.'index.php/auth?response_type='.$_SESSION['response_type'].'&client_id='.$_SESSION['client_id'].'&redirect_uri='.$_SESSION['redirect_uri'].'&state='.$_SESSION['state'];
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
          "UserName": "ssoUser",
          "Password": "password",
          "RefUid": "'.$data[0]['sso_id'].'",
          "RefUidKey": "",
          "Email": "'.$data[0]['email'].'",
          "ConsRoleId": 1,
          "UrlSuccess": "'.$url.'",
          "UrlFail": "'.$UrlFail.'"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);   
        $pdpa = json_decode($response);

        $result = [
            'status' => $pdpa->CheckStatus,
            'RedirectURL' => $pdpa->RedirectURL,
          ];
        return  $result;
  }
  function insert_drive($code){
    $url = str_replace('api/','',BASE_drive);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      //CURLOPT_URL => "https://testdrive.ditp.go.th/Default.aspx?TabId=148&language=th-TH&code='".$code."'",
      CURLOPT_URL => $url."Default.aspx?TabId=148&language=th-TH&code='".$code."'",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        //"Cookie: dnn_IsMobile=False; .ASPXANONYMOUS=llR8NSGSBacuuOWgl_JRdsosCkyGUIoVUz4fkoS-rBKABejk4i5IU8F31ECTR6qsH9_I0YcIqU5fkge5a0HIujLbW7AmZKTRF1Lu9DwFjUi9rJu00; ASP.NET_SessionId=kaafqll1qwyjzcx5nn1unmxz; language=th-TH; .DOTNETNUKE=BCF12C51257902B5BEBF17232EA29083328A48A894F78B1F90881E6E3477754BCC37C781C870233FD252388E16FE0A3BFCBAE4C16189681812BDF159FE28E303AB9792C085AF9433D85AF435FD6447AAB620B01A; LastPageId=0:59; __RequestVerificationToken=d_QLBa27vHG-sUt49qprRN9K8S6OIdGs_Rjw81fjlo2B0sUYxYQ6Qa5HV3xgMe2XDNokXQ2"
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
  }

  function send_mail_director ($data = []) {
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ"
    ];

    $email = $data['email'];
    $member_id = strval($data['member_id']);
    $target = 'director';
    $fullname = $data['title'] . $data['name'] . ' ' . $data['lastname'];
    if($email != "" && $member_id !=""){
      $number = mt_rand(1000,9999);

      $token_verify = sha1($member_id . date('YmhHis'));
      $exp_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+15 minutes"));

      $ref_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 6);

      //-- เคลียร์ Token เก่า --//
      // $this->update('tb_token_verify_director', ['status'=>'1'], "member_id ='$member_id'");
      $status = '1';
      $stmt_update = $this->db->prepare("UPDATE tb_token_verify_director SET `status` = ? WHERE member_id = ?");
      $stmt_update->bind_param("si", $status, $member_id);
      $stmt_update->execute();
      //-- insert tb_token_reset --//
      // $data_token_verify = [
      //   'token_verify' => $token_verify,
      //   'ref_code' => $ref_code,
      //   'member_id' => $member_id,
      //   'target' => $target,
      //   'redirect_uri' => BASE_URL.'portal/ck_portal',
      //   'response_type' => 'token',
      //   'client_id' => 'SS8663835',
      //   'state' => "email",
      //   'status' => '0',
      //   'exp_date' => $exp_date
      // ];
      $redirect_uri = BASE_URL.'portal/ck_portal';
      $response_type = 'token';
      $client_id = (empty($_SESSION['client_id']))? 'SS8663835':$_SESSION['client_id'];
      $state = 'email';
      $verify_status = '0';
      // $insert = $this->insert('tb_token_verify_director', $data_token_verify);
      $stmt_insert = $this->db->prepare("INSERT INTO tb_token_verify_director (`token_verify`, `ref_code`, `member_id`, `target`, `redirect_uri`, `response_type`, `client_id`, `state`, `status`, `exp_date`) VALUES (?,?,?,?,?,?,?,?,?,?)");
      $stmt_insert->bind_param("ssisssssis", $token_verify, $ref_code, $member_id, $target, $redirect_uri,$response_type, $client_id, $state, $verify_status, $exp_date);
      $stmt_insert->execute();
      // ----- Google SMTP ----- //
      // $mail = new PHPMailer();
      // $mail->isSMTP();
      // $mail->SMTPDebug = 0;
      // $mail->SMTPAuth = true;
      // $mail->SMTPSecure = "tlsv1.2";
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

      $mail->From = ('sso@ditp.go.th');
      $mail->FromName = "DITP Single Sign-on";
      $mail->Subject = "ขั้นตอนการตรวจสอบผู้รับมอบอำนาจ";

      $state = "email";

      $url = $this->path_web."auth/verify_director?q=".$member_id."&redirect_uri=".$this->path_web."portal/ck_portal&response_type=token&client_id=SS8663835&state=email";
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
      $mail->Body .= '<img style="max-width: 110px;margin:0 auto;" src="'.$this->path_web.'asset/img/new-sso-logo-white.png" alt="">';
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
  function insert_member($type_is = 0)
  {
    $type = $this->post('type');

  
    if($type == 1){ //นิติไทย
    
      //-- data tb_member --//
      $cid = $this->post('cid');
      $position = $this->post('position');
      $password = $this->post('password');
      $repassword = $this->post('repassword');

      //-- data tb_member_type1 ---//
      
      $company_nameTh = $this->post('company_name');
      $company_nameEn = $this->post('company_nameEn');
      $company_addressTh = $this->post('company_address');
      $company_provinceTh = $this->post('company_province');
      $company_email = $this->post('company_email');
      $company_tel = $this->post('company_phone');
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

      $ck_nationality_type = $this->post('ck_nationality_type');
      // pr($ck_nationality_type);
      // die();

      $member_title = $this->post('contact_title');
      $member_cid = ($ck_nationality_type == 1)?$this->post('contact_cid'):$this->post('contact_cid_fo');
      $member_nameTh = ($ck_nationality_type == 1)?$this->post('contact_name'):'';
      $member_midnameTh = ($ck_nationality_type == 1)?$this->post('contact_midname'):'';
      $member_lastnameTh = ($ck_nationality_type == 1)?$this->post('contact_lastname'):'';
      $member_nameEn = $this->post('contact_nameEn');
      $member_midnameEn = $this->post('contact_midnameEn');
      $member_lastnameEn = $this->post('contact_lastnameEn');
      $director_type = $this->post('ck_director_type');
      $member_email = $this->post('contact_email');
      $member_tel = $this->post('contact_tel');
      $member_birthday = $this->post('contact_bday');

      $member_tel_country = $this->post('contact_tel_country');
      $member_tel_code = $this->post('contact_tel_code');

      $director_email = $this->post('contact_director_email');
      $director_tel = $this->post('contact_director_tel');

      $director_tel_country = $this->post('contact_director_tel_country');
      $director_tel_code = $this->post('contact_director_tel_code');

      $laser_type_company = $this->post('laser_type1');


      $type1_verify = $this->post('type1_verify');

      if(strlen($member_tel) < 10) {
        $error['contact_tel'] = "โทรศัพท์มือถือไม่ถูกต้อง";
      }
      // if($director_type == 2 && strlen($director_tel) < 10) {
      //   $error['contact_director_tel'] = "ไม่ถูกต้อง";
      // }

      if(empty($cid)) $error['cid'] = 'กรุณากรอกข้อมูล';

      // if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)) {
      //   $error['password'] = "รหัสผ่านจะต้องประกอบไปด้วยอักษร ภาษาอังกฤษตัวใหญ่ (A-Z), อักษรภาษาอังกฤษตัวเล็ก (a-z), ตัวเลข (1-9) และสัญลักษณ์ (เช่น #, $, & เป็นต้น)";
      // }
      if(strlen($password) < 8) {
        $error['password'] = "กรุณาป้อนรหัสผ่าน 8 ตัวขึ้นไป";
      }
      if(empty($password)) $error['password'] = 'กรุณากรอกข้อมูล';
      if($password != $repassword) $error['repassword'] = 'รหัสผ่านไม่ตรงกัน';
      if(empty($repassword)) $error['repassword'] = 'กรุณากรอกข้อมูล';

      if(empty($company_nameTh)) $error['company_name'] = 'กรุณากรอกข้อมูล';
      // if(empty($company_nameEn)) $error['company_nameEn'] = 'กรุณากรอกข้อมูล';
      // if(empty($company_addressEn)) $error['company_addressEn'] = 'กรุณากรอกข้อมูล';
      // if(!preg_match("#[a-zA-Z]+#", $company_nameEn)) {
      //   $error['company_nameEn'] = "กรุณากรอกชื่อเป็นตัวอักษร a - z เท่านั้น";
      // }

      
      if(empty($contact_address)) $error['contact_address'] = 'กรุณากรอกข้อมูล';
      if(empty($contact_province)) $error['contact_province'] = 'กรุณากรอกข้อมูล';
      if(empty($contact_district)) $error['contact_district'] = 'กรุณากรอกข้อมูล';
      if(empty($contact_subdistrict)) $error['contact_subdistrict'] = 'กรุณากรอกข้อมูล';
      if(empty($contact_postcode)) $error['contact_postcode'] = 'กรุณากรอกข้อมูล';

      if(empty($member_title)) $error['contact_title'] = 'กรุณากรอกข้อมูล';

      // if (!$this->isValidNationalId($member_cid)) {
      //   $error['contact_cid'] = 'ไม่ถูกต้อง';
      // }
      // if(empty($member_cid)) $error['contact_cid'] = 'กรุณากรอกข้อมูล';
      
      if(empty($member_nameTh) && $ck_nationality_type == 1) $error['contact_name'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[\p{Thai}\p{P}\s]+$/u", $member_nameTh) && $ck_nationality_type == 1) {
        $error['contact_name'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
      }

      if (!empty($member_midnameTh && $ck_nationality_type == 1) && !preg_match("/^[\p{Thai}\p{P}\s]+$/u", $member_midnameTh) && $ck_nationality_type == 1) {
        $error['contact_midname'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
      }

      if(empty($member_lastnameTh) && $ck_nationality_type == 1) $error['contact_lastname'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[\p{Thai}\p{P}\s]+$/u", $member_lastnameTh) && $ck_nationality_type == 1) {
        $error['contact_lastname'] = "กรุณากรอกนามสกุลเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if(empty($member_nameEn)) $error['contact_nameEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?.,]+$/", $member_nameEn)) {
        $error['contact_nameEn'] = "กรุณากรอกชื่อเป็นตัวอักษร a - z เท่านั้น";
      }

      if (!empty($member_midnameEn) && !preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?.,]+$/", $member_midnameEn)) {
        $error['contact_midnameEn'] = "กรุณากรอกที่เป็นตัวอักษร a - z เท่านั้น";
      }
      if(empty($company_addressEn)) $error['company_addressEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?.,]+$/", $company_addressEn)) {
        $error['company_addressEn'] = "กรุณากรอกที่เป็นตัวอักษร a - z เท่านั้น";
      }

      if(empty($member_lastnameEn)) $error['contact_lastnameEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?.,]+$/", $member_lastnameEn)) {
        $error['contact_lastnameEn'] = "กรุณากรอกนามสกุลเป็นตัวอักษร a - z เท่านั้น";
      }
      if(!preg_match("/^[0-9]+$/", $member_tel) && $member_tel_country == 'th') {
        $error['contact_tel'] = "กรุณากรอกตัวเลข 0-9 เท่านั้น";
      }

      // if($director_type == 2 && !preg_match("/^[0-9]+$/", $director_tel) && $director_tel_country == 'th') {
      //   $error['contact_director_tel'] = "กรุณากรอกตัวเลข 0-9 เท่านั้น";
      // }

      //-------- Email ซ้ำ ---------//
      // $sql_ckmail1 = 'SELECT 1 FROM tb_member_type1 WHERE member_email ="' . $member_email . '"';
      // $sql_ckmail2 = 'SELECT 1 FROM tb_member_type2 WHERE email ="' . $member_email . '"';
      // $sql_ckmail3 = 'SELECT 1 FROM tb_member_type3 WHERE email ="' . $member_email . '"';
      // $sql_ckmail4 = 'SELECT 1 FROM tb_member_type4 WHERE email ="' . $member_email . '"';
      // $sql_ckmail5 = 'SELECT 1 FROM tb_member_type5 WHERE email ="' . $member_email . '"';

      // $ck_mail1 = $this->query($sql_ckmail1);
      // $ck_mail2 = $this->query($sql_ckmail2);
      // $ck_mail3 = $this->query($sql_ckmail3);
      // $ck_mail4 = $this->query($sql_ckmail4);
      // $ck_mail5 = $this->query($sql_ckmail5);
      ///----- อันนี้ใช้ -----///
      // $ck_mail = $this->check_mail($member_email);
      // if($ck_mail == false){
      //   $error['contact_email'] = 'มีอยู่แล้วในระบบ';
      // }
        ///----------------///-
      // if (!empty($ck_mail1) || !empty($ck_mail2) || !empty($ck_mail3) || !empty($ck_mail4) || !empty($ck_mail5)) {
      //   $error['contact_email'] = 'มีอยู่แล้วในระบบ';
      // }
      //--------------------------//

      if(!filter_var($member_email, FILTER_VALIDATE_EMAIL)) {
        $error['contact_email'] = 'รูปแบบไม่ถูกต้อง';
      }

      if(!filter_var($company_email, FILTER_VALIDATE_EMAIL) ) {
        $error['company_email'] = 'รูปแบบไม่ถูกต้อง';
      }

      // if(!filter_var($director_email, FILTER_VALIDATE_EMAIL) && $director_type == 2) {
      //   $error['contact_director_email'] = 'รูปแบบไม่ถูกต้อง';
      // }
      // if ($director_email == $member_email && $director_type == 2) {
      //   $error['contact_director_tel'] = 'กรรมการ และ ผู้รับมอบอำนาจ ไม่สามารถใช้อีเมลเดียวกันได้';
      // }

      // if ($member_tel == $director_tel && $director_type == 2) {
      // //   $error['member_tel'] = 'กรรมการ และ ผู้รับมอบอำนาจ ไม่สามารถใช้หมายเลขโทรศัพท์เดียวกันได้';
      // }
      if(empty($member_email)) $error['contact_email'] = 'กรุณากรอกข้อมูล';
      if(empty($company_email)) $error['company_email'] = 'กรุณากรอกข้อมูล';
      // if(empty($director_email) && $director_type == 2) $error['contact_director_email'] = 'กรุณากรอกข้อมูล';
      if(empty($member_tel)) $error['contact_tel'] = 'กรุณากรอกข้อมูล';
      // if(empty($director_tel) && $director_type == 2) $error['contact_director_tel'] = 'กรุณากรอกข้อมูล';

  
      /******* get address name_th *******/
      if(empty($error)){
        if($state == 'new'){
          $contact_province = $this->get_province($contact_province, 'th');
          $contact_district = $this->get_district($contact_district, 'th');
          $contact_subdistrict = $this->get_subdistrict($contact_subdistrict, 'th');
        }
      }

        /****** get address name_company en *******/
      if(!empty($company_provinceEn)) $company_provinceEn = $this->get_province($company_provinceEn, 'en');
      if(!empty($company_districtEn)) $company_districtEn = $this->get_district($company_districtEn, 'en');
      if(!empty($company_subdistrictEn)) $company_subdistrictEn = $this->get_subdistrict($company_subdistrictEn, 'en');
    

      //---------- check cid -----------//
      $stmt = $this->db->prepare("SELECT 1 FROM tb_member WHERE  cid = ? and status in(1,2)");
      $stmt->bind_param("s", $cid);
      $stmt->execute();
      $results = $stmt->get_result();
      $ck_cid1 = $results->fetch_assoc();
     

      if (!empty($ck_cid1)) {
        $error['cid'] = 'ของท่านมีอยู่ในระบบแล้วโปรดเข้าใช้งานระบบด้วยบัญชีที่ท่านเคยลงทะเบียนไว้ หรือหากลืมรหัสผ่านสามารถขอรับใหม่ได้ที่เมนู <br> <a href="'.BASE_URL.'auth/forget">"ลืมรหัสผ่าน"</a>';
      }
      //------------------------------//

      $data_client = $this->get_data_client($_SESSION['client_id']);
      $member_app = $data_client['mc_id'];
      if(empty($error)){

        if($type_is){
          $status = '1';
          $sha1 = sha1($password);
          $stmt_sso_id = $this->db->prepare("SELECT MAX(tb_member.sso_id) as ssoid from tb_member");
          $stmt_sso_id->execute();
          $results_sso_id = $stmt_sso_id->get_result();
          $result_sso = $results_sso_id->fetch_assoc();
          $m_sso_id = $result_sso['ssoid']+1;
          $stmt_insert = $this->db->prepare("INSERT INTO tb_member (`cid`, `password`, `type`, `status_contact_nationality`, `status_laser_verify`, `status`, `sso_id`) VALUES (?,?,?,?,?,?,?)");
          $stmt_insert->bind_param("sssssss", $cid, $sha1, $type, $ck_nationality_type, $laser_type_company, $status, $m_sso_id);
          $stmt_insert->execute();

          if(!empty($stmt_insert->insert_id)){
            $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $stmt_ck = $this->db->prepare($sql_max);
            $stmt_ck->execute();
            $results_max = $stmt_ck->get_result();
            $result_max = $results_max->fetch_assoc();
            $member_id = strval($result_max['member_id']);
    
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
              // 'member_birthday' => $member_birthday,
              'member_tel' => $member_tel,
              'member_tel_country' => ($member_tel_country == '')? 'TH' : strtoupper($member_tel_country),
              'member_tel_code' => ($member_tel_code == '')? '+66' : "+".$member_tel_code,
              'director_status' => $director_type,
              // 'director_email' => $director_email,
              // 'director_tel' => $director_tel,
              // 'director_tel_country' => ($director_tel_country == '')? 'TH' : strtoupper($director_tel_country),
              // 'director_tel_code' => ($director_tel_code == '')? '+66' : "+".$director_tel_code,
              'status_case' => ($director_type == 2)? '1' : '2',
              'director_date' => ($director_type == 2)? date("Y-m-d H:i:s") : null,
              // 'position_id' =>$position 
            ];
            $data = json_encode($data_insert_type1,JSON_UNESCAPED_UNICODE);
            $types = '1';
            $stmt_register_log = $this->db->prepare("INSERT INTO tb_register_log (`cid`, `data`, `type`) VALUES (?,?,?)");
            $stmt_register_log->bind_param("iss", $member_id, $data, $types);
            $stmt_register_log->execute();
            $member_names = ($ck_nationality_type == 1)?$member_nameTh:$member_nameEn;
            $member_midnames = ($ck_nationality_type == 1)?$member_midnameTh:$member_midnameEn;
            $member_lastnames = ($ck_nationality_type == 1)?$member_lastnameTh:$member_lastnameEn;
            $member_tel_countrys = ($member_tel_country == '')? 'TH' : strtoupper($member_tel_country);
            $member_tel_codes = ($member_tel_code == '')? '+66' : "+".$member_tel_code;
            $status_cases = ($director_type == 2)? '1' : '2';
            $director_dates = ($director_type == 2)? date("Y-m-d H:i:s") : null;
            if(empty($director_dates)){
              $stmt_insert_type1 = $this->db->prepare("INSERT INTO `tb_member_type1`( `member_id`,`company_nameTh`,`company_nameEn`,`company_tel`,`company_email`,`company_addressTh`,`company_provinceTh`,`company_districtTh`,`company_subdistrictTh`,`company_postcodeTh`,`company_addressEn`,`company_provinceEn`,`company_districtEn`,`company_subdistrictEn`,`company_postcodeEn`,`contact_address`,`contact_province`,`contact_district`,`contact_subdistrict`,`contact_postcode`,`member_title`,`member_cid`,`member_nameTh`,`member_midnameTh`,`member_lastnameTh`,`member_nameEn`,`member_midnameEn`,`member_lastnameEn`,`member_email`,`member_tel`,`member_tel_country`,`member_tel_code`,`director_status`,`status_case`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
              $stmt_insert_type1->bind_param("ssssssssssssssssssssssssssssssssss", $member_id,$company_nameTh,$company_nameEn,$company_tel,$company_email,$company_addressTh,$company_provinceTh,$company_districtTh,$company_subdistrictTh,$company_postcode,$company_addressEn,$company_provinceEn,$company_districtEn,$company_subdistrictEn,$company_postcodeEn,$contact_address,$contact_province,$contact_district,$contact_subdistrict,$contact_postcode,$member_title,$member_cid,$member_names,$member_midnames,$member_lastnames,$member_nameEn,$member_midnameEn,$member_lastnameEn,$member_email,$member_tel,$member_tel_countrys,$member_tel_codes,$director_type,$status_cases);
        
            }else{
              $stmt_insert_type1 = $this->db->prepare("INSERT INTO `tb_member_type1`( `member_id`,`company_nameTh`,`company_nameEn`,`company_tel`,`company_email`,`company_addressTh`,`company_provinceTh`,`company_districtTh`,`company_subdistrictTh`,`company_postcodeTh`,`company_addressEn`,`company_provinceEn`,`company_districtEn`,`company_subdistrictEn`,`company_postcodeEn`,`contact_address`,`contact_province`,`contact_district`,`contact_subdistrict`,`contact_postcode`,`member_title`,`member_cid`,`member_nameTh`,`member_midnameTh`,`member_lastnameTh`,`member_nameEn`,`member_midnameEn`,`member_lastnameEn`,`member_email`,`member_tel`,`member_tel_country`,`member_tel_code`,`director_status`,`status_case`,`director_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
              $stmt_insert_type1->bind_param("sssssssssssssssssssssssssssssssssss", $member_id,$company_nameTh,$company_nameEn,$company_tel,$company_email,$company_addressTh,$company_provinceTh,$company_districtTh,$company_subdistrictTh,$company_postcode,$company_addressEn,$company_provinceEn,$company_districtEn,$company_subdistrictEn,$company_postcodeEn,$contact_address,$contact_province,$contact_district,$contact_subdistrict,$contact_postcode,$member_title,$member_cid,$member_names,$member_midnames,$member_lastnames,$member_nameEn,$member_midnameEn,$member_lastnameEn,$member_email,$member_tel,$member_tel_countrys,$member_tel_codes,$director_type,$status_cases,$director_dates);
            }
            $stmt_insert_type1->execute();

            //------------------------ INSERT AND LOGIN connect --------------------------//
              //-- insert_touch ---/
              $data_insert_touch = [
                'register_type' => 'FORM',
                'identify' => 'CORPORATE',
                'email' => $member_email,
                'password' => $password,
                'company_name' => $company_nameTh,
                'company_tax_id' => $cid,
                'company_telephone' => $member_tel
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
                $client_ids = "SS6931846";
                $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_member_app_id (`member_id`, `member_id_app`, `client_id`) VALUES (?,?,?)");
                $stmt_member_app_id->bind_param("ssiiii", $member_id, $member_id_connect, $client_ids);
                $stmt_member_app_id->execute();
           
                //------- insert token_external --------//
                // $data_insert_token_external = [
                //   'member_id' => $member_id,
                //   'member_id_app' => $id_connect,
                //   'token_code' => $token_connect,
                //   'member_type' => 'TOUCH',
                // ];
                $TOUCH = 'TOUCH';
                // $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
                $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_token_external (`member_id`, `member_id_app`, `token_code`, `member_type`) VALUES (?,?,?,?)");
                $stmt_member_app_id->bind_param("ssiiii", $member_id, $id_connect, $token_connect,$TOUCH);
                $stmt_member_app_id->execute();
              }
            //------------------------ END OFF INSERT AND LOGIN connect --------------------------//

            //-- return code ไปให้ js fetch api --//
            $code_drive = $this->get_code($member_id, 'ssonticlient');
            $code_care = $this->get_code($member_id, 'ssocareid');

            //--- SESSION FOR LOGIN after reg ---//
            $_SESSION['tb_member_id'] = $member_id;

            //-- redirect --//
            $url = $this->get_return_url($member_id);

            $return = [
              'code' => '00', 
              'success' => 1, 
              'cid' => $cid,
              'url' => $url,
              'type_verify' => $type1_verify,
              'code' => [
                'code_care' => $code_care,
                'code_drive' => $code_drive,
                'xx' => $password,
                'ee' => $member_email
              ]
            ];
            // $sql_ssvsv = 'SELECT * FROM tb_member WHERE member_id ="'.$member_id.'" ';
            // $val = $this->query($sql_ssvsv); 

            $stmt_consent = $this->db->prepare("SELECT * FROM tb_member WHERE member_id = ?");
            $stmt_consent->bind_param("s", $member_id);
            $stmt_consent->execute();
            $result_data = $stmt_consent->get_result();
            $val = $result_data->fetch_assoc();
            if ($director_type == 2 && $ck_nationality_type == 1) {
              $send_mail_data = [
                'member_id' => $member_id,
                'email' => $director_email,
                'title' => $member_title,
                'name' => $member_nameTh,
                'lastname' => $member_lastnameTh
              ];

              $this->send_mail_director($send_mail_data);
            }

            $checkconsent = $this->checkconsent([$val,$return,$_SESSION['redirect_uri']]);
            if(count($checkconsent) > 0){
              $return_data = array_merge($return, ['pdpa' => $checkconsent]);
              return $return_data;
            }


            //$url = $this->get_return_url($member_id);
            //$return = ['code' => '00', 'success' => 1, 'url' => $url];
          }
        }else{
          $return = ['code' => '00', 'success' => 1, 'test' => 2];
        }
      }else{
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['code' => '01', 'error' => $error_res];
      }
      return $return;

    }else if($type == 2){ //นิติบุคคลต่างชาติ

      // -- data tb_member --//
      $cid = $this->post('corporate_id');
      $password = $this->post('password');
      $repassword = $this->post('repassword');

      //-- data tb_member_type2 --//
      $corporate_name = $this->post('fo_corporate_name');
      $member_title = $this->post('fo_title');
      //$member_nameTh = $this->post('fo_nameTh');
      //$member_lastnameTh = $this->post('fo_lastnameTh');
      $member_nameEn = $this->post('fo_name');
      $member_midnameEn = $this->post('fo_midname');
      $member_lastnameEn = $this->post('fo_lastname');
      $country = $this->post('fo_country_name');
      $address = $this->post('fo_address');
      $email = $this->post('fo_email');
      $tel = $this->post('fo_tel');

      $tel_country = $this->post('fo_tel_country');
      $tel_code = $this->post('fo_tel_code');

      if(strlen($tel) < 10) {
        $error['fo_tel'] = "Please fill in the information.";
      }
      $text_alert = "Please fill in the information";
      if(empty($cid)) $error['cid'] =  $text_alert;

      // if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)) {
      //   $error['password'] = "Password must contain letters. English uppercase (A-Z), lowercase English letters (a-z), numbers (1-9), and symbols (e.g. #, $, & etc.).";
      // }

      if(strlen($password) < 8) {
        $error['password'] = "more than 8 characters";
      }

      if(empty($password)) $error['password'] =  $text_alert;
      if($password != $repassword) $error['repassword'] = 'Not match';

      if(empty($repassword)) $error['repassword'] =  $text_alert;
      if(empty($corporate_name)) $error['fo_corporate_name'] =  $text_alert;
      if(empty($country)) $error['fo_country_name'] =  $text_alert;

      if(empty($member_title)) $error['fo_title'] =  $text_alert;
      //if(empty($member_nameTh)) $error['fo_nameTh'] =  $text_alert;
      //if(empty($member_lastnameTh)) $error['fo_lastnameTh'] =  $text_alert;
      if(empty($member_nameEn)) $error['fo_name'] =  $text_alert;
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?.,]+$/", $member_nameEn)) {
        $error['fo_name'] = "Please enter your name in letters a - z only.";
      }
      if (!empty($member_midnameEn) && !preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?.,]+$/", $member_midnameEn)) {
        $error['fo_midname'] = "Please enter your name in letters a - z only.";
      }
      if(empty($member_lastnameEn)) $error['fo_lastname'] =  $text_alert;
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?.,]+$/", $member_lastnameEn)) {
        $error['fo_lastname'] = "Please enter your last name in letters a - z only.";
      }

      if(!preg_match("/^[0-9]+$/", $tel) && $tel_country == 'th') {
        $error['fo_tel'] = "Please enter numbers 0-9 only.";
      }

      if(empty($address)) $error['address'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?.,]+$/", $address)) {
        $error['address'] = "Please enter your address in english only.";
      }
      //--------------------------//

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['fo_email'] = 'not a valid ';
      }

      if(empty($email)) $error['fo_email'] =  $text_alert;
      if(empty($tel)) $error['fo_tel'] =  $text_alert;
      
      //---------- check cid -----------//
      $stmt = $this->db->prepare("SELECT 1 FROM tb_member WHERE  cid = ? and status in(1,2)");
      $stmt->bind_param("s", $cid);
      $stmt->execute();
      $results = $stmt->get_result();
      $ck_cid1 = $results->fetch_assoc();

      if (!empty($ck_cid1)) {
        $error['corporate_id'] = 'has already been used please login with your account if forget your passsword please use <a href="'.BASE_URL.'auth/forget">"Forgot password"</a>';
      }
      //-------------------------------//
      $data_client = $this->get_data_client($_SESSION['client_id']);
      $member_app = $data_client['mc_id'];
      if(empty($error)){
        if($type_is){
          $status = '1';
          $sha1 = sha1($password);
          $stmt_sso_id = $this->db->prepare("SELECT MAX(tb_member.sso_id) as ssoid from tb_member");
          $stmt_sso_id->execute();
          $results_sso_id = $stmt_sso_id->get_result();
          $result_sso = $results_sso_id->fetch_assoc();
          $m_sso_id = $result_sso['ssoid']+1;
          $stmt_insert = $this->db->prepare("INSERT INTO tb_member (`cid`, `password`, `type`, `status`, `sso_id`) VALUES (?,?,?,?,?)");
          $stmt_insert->bind_param("sssss", $cid, $sha1, $type, $status, $m_sso_id);
          $stmt_insert->execute();
   
          if(!empty($stmt_insert->insert_id)){
            $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $stmt_ck = $this->db->prepare($sql_max);
            $stmt_ck->execute();
            $results_max = $stmt_ck->get_result();
            $result_max = $results_max->fetch_assoc();
            $member_id = strval($result_max['member_id']);

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
   
            $data = json_encode($data_insert_type2,JSON_UNESCAPED_UNICODE);
            $types = '2';
            $stmt_register_log = $this->db->prepare("INSERT INTO tb_register_log (`cid`, `data`, `type`) VALUES (?,?,?)");
            $stmt_register_log->bind_param("iss", $member_id, $data, $types);
            $stmt_register_log->execute();

            $tel_countrys = ($tel_country == '')? 'TH' : strtoupper($tel_country);
            $tel_codes = ($tel_code == '')? '+66' : "+".$tel_code;
            $stmt_insert_type2 = $this->db->prepare("INSERT INTO `tb_member_type2` (`member_id`, `corporate_name`, `country`, `address`, `member_title`, `member_nameTh`, `member_lastnameTh`, `member_nameEn`, `member_midnameEn`, `member_lastnameEn`, `email`, `tel`, `tel_country`, `tel_code`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt_insert_type2->bind_param("isssssssssssss", $member_id, $corporate_name, $country, $address, $member_title, $member_nameEn, $member_lastnameEn, $member_nameEn, $member_midnameEn, $member_lastnameEn, $email, $tel, $tel_countrys, $tel_codes);
            $stmt_insert_type2->execute();

            //------------------------ INSERT AND LOGIN connect --------------------------//
              //-- insert_touch ---/
              $data_insert_touch = [
                'register_type' => 'FORM',
                'identify' => 'CORPORATE',
                'email' => $email,
                'password' => $password,
                'company_name' => $corporate_name,
                'company_tax_id' => $cid,
                'company_telephone' => $tel
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
                $client_ids = "SS6931846";
                $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_member_app_id (`member_id`, `member_id_app`, `client_id`) VALUES (?,?,?)");
                $stmt_member_app_id->bind_param("ssiiii", $member_id, $member_id_connect, $client_ids);
                $stmt_member_app_id->execute();
                //------- insert token_external --------//
                $TOUCH = 'TOUCH';
                $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_token_external (`member_id`, `member_id_app`, `token_code`, `member_type`) VALUES (?,?,?,?)");
                $stmt_member_app_id->bind_param("ssiiii", $member_id, $id_connect, $token_connect,$TOUCH);
                $stmt_member_app_id->execute();
              }
            //------------------------ END OFF INSERT AND LOGIN connect --------------------------//

            //-- return code ไปให้ js fetch api --//
            $code_drive = $this->get_code($member_id, 'ssonticlient');
            $code_care = $this->get_code($member_id, 'ssocareid');

            //--- SESSION FOR LOGIN after reg ---//
            $_SESSION['tb_member_id'] = $member_id;

            //-- redirect --//
            $url = $this->get_return_url($member_id);
            $return = [
              'code' => '00', 
              'success' => 1, 
              'url' => $url,
              'type_verify' => 1,
              'cid' => $cid,
              'code' =>[
                'code_care' => $code_care,
                'code_drive' => $code_drive,
                'xx' => $password,
                'ee' => $email
              ]
            ];

            //$url = $this->get_return_url($member_id);
            //$return = ['code' => '00', 'success' => 1, 'url' => $url];
          }
        }else{
          $return = ['code' => '00', 'success' => 1];
        }
      }else{
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['code' => '01', 'error' => $error_res];
      }
      return $return;
      
    }else if($type == 3){ //บุคคลไทย
    
      // -- data tb_member --//
      $cid = $this->post('cid');
      $password = $this->post('password');
      $repassword = $this->post('repassword');

      //-- data tb_member_type3 --//
      $member_title = $this->post('title');
      $member_nameTh = $this->post('name_user');
      $member_midnameTh = $this->post('midname_user');
      $member_lastnameTh = $this->post('lastname');
      $member_nameEn = $this->post('name_userEn');
      $member_midnameEn = $this->post('midname_userEn');
      $member_lastnameEn = $this->post('lastnameEn');
      $email = $this->post('email');
      $tel = $this->post('tel');
      $tel_country = $this->post('tel_country');
      $tel_code = $this->post('tel_code');
      $addressTh = $this->post('addressTh');
      $provinceTh = $this->post('provinceTh');
      $districtTh = $this->post('districtTh');
      $subdistrictTh = $this->post('subdistrictTh');
      $member_birthday = $this->post('birthday');
      $postcode = $this->post('postcode');
      $laser_type_people = $this->post('laser_type3');
      $type3_verify = $this->post('type3_verify');
      $addressEn = $this->post('addressEn');
      $provinceEn = "";
      $districtEn = "";
      $subdistrictEn = "";
      if(strlen($tel) < 10) {
        $error['tel'] = "โทรศัพท์มือถือไม่ถูกต้อง";
      }
      if (!$this->isValidNationalId($cid)) {
        $error['cid'] = 'เลขบัตรประชาชนไม่ถูกต้อง';
      }
      if(empty($cid)) $error['cid'] = 'กรุณากรอกข้อมูล';

      // if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)) {
      //   $error['password'] = "รหัสผ่านจะต้องประกอบไปด้วยอักษร ภาษาอังกฤษตัวใหญ่ (A-Z), อักษรภาษาอังกฤษตัวเล็ก (a-z), ตัวเลข (1-9) และสัญลักษณ์ (เช่น #, $, & เป็นต้น)";
      // }

      // if(!preg_match("#[a-zA-Z]+#", $password)) {
      //   $error['password'] = "ต้องมีตัวอักษร a - z อย่างน้อย 1 ตัว";
      // }

      if(strlen($password) < 8) {
        $error['password'] = "กรุณาป้อนรหัสผ่าน 8 ตัวขึ้นไป";
      }

      if(empty($password)) $error['password'] = 'กรุณากรอกข้อมูล';
      if($password != $repassword) $error['repassword'] = 'รหัสผ่านไม่ตรงกัน';

      if(empty($repassword)) $error['repassword'] = 'กรุณากรอกข้อมูล';

      if(empty($member_title)) $error['title'] = 'กรุณากรอกข้อมูล';
      if(empty($member_nameTh)) $error['name_user'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $member_nameTh)) {
        $error['name_user'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if (!empty($member_midnameTh) && !preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $member_midnameTh)) {
        $error['midname_user'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if(empty($member_lastnameTh)) $error['lastname'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $member_lastnameTh)) {
        $error['lastname'] = "กรุณากรอกนามสกุลเป็นตัวอักษร ก - ฮ เท่านั้น";
      }

      if(empty($member_nameEn)) $error['name_userEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $member_nameEn)) {
        $error['name_userEn'] = "กรุณากรอกชื่อเป็นตัวอักษร a - z เท่านั้น";
      }
      if (!empty($member_midnameEn) && !preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $member_midnameEn)) {
        $error['midname_user'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
      }
      if(empty($member_lastnameEn)) $error['lastnameEn'] = 'กรุณากรอกข้อมูล';
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $member_lastnameEn)) {
        $error['lastnameEn'] = "กรุณากรอกนามสกุลเป็นตัวอักษร a - z เท่านั้น";
      }

      if(!preg_match("/^[0-9]+$/", $tel) && $tel_country == 'th') {
        $error['tel'] = "กรุณากรอกตัวเลข 0-9 เท่านั้น";
      }

      //-------- Email ซ้ำ ---------//
      // $sql_ckmail1 = 'SELECT 1 FROM tb_member_type1 WHERE member_email ="' . $email . '"';
      // $sql_ckmail2 = 'SELECT 1 FROM tb_member_type2 WHERE email ="' . $email . '"';
      // $sql_ckmail3 = 'SELECT 1 FROM tb_member_type3 WHERE email ="' . $email . '"';
      // $sql_ckmail4 = 'SELECT 1 FROM tb_member_type4 WHERE email ="' . $email . '"';
      // $sql_ckmail5 = 'SELECT 1 FROM tb_member_type5 WHERE email ="' . $email . '"';

      // $ck_mail1 = $this->query($sql_ckmail1);
      // $ck_mail2 = $this->query($sql_ckmail2);
      // $ck_mail3 = $this->query($sql_ckmail3);
      // $ck_mail4 = $this->query($sql_ckmail4);
      // $ck_mail5 = $this->query($sql_ckmail5);

      // if (!empty($ck_mail1) || !empty($ck_mail2) || !empty($ck_mail3) || !empty($ck_mail4) || !empty($ck_mail5)) {
      //   $error['email'] = 'มีอยู่แล้วในระบบ';
      // }
      /// อันนี้ใช้
      // $ck_mail = $this->check_mail($email);
      // if($ck_mail == false){
      //   $error['email'] = 'มีอยู่แล้วในระบบ';
      // }

      //--------------------------//


      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'รูปแบบไม่ถูกต้อง';
      }

      if(empty($email)) $error['email'] = 'กรุณากรอกข้อมูล';
      if(empty($tel)) $error['tel'] = 'กรุณากรอกข้อมูล';

      if(empty($addressTh)) $error['addressTh'] = 'กรุณากรอกข้อมูล';
      //if(empty($addressEn)) $error['addressEn'] = 'กรุณากรอกข้อมูล';
      if(empty($provinceTh)) $error['provinceTh'] = 'กรุณากรอกข้อมูล';
      if(empty($districtTh)) $error['districtTh'] = 'กรุณากรอกข้อมูล';
      if(empty($subdistrictTh)) $error['subdistrictTh'] = 'กรุณากรอกข้อมูล';
      if(empty($postcode)) $error['postcode'] = 'กรุณากรอกข้อมูล';

      /*if(empty($provinceEn)) $error['provinceEn'] = 'กรุณากรอกข้อมูล';
      if(empty($districtEn)) $error['districtEn'] = 'กรุณากรอกข้อมูล';
      if(empty($subdistrictEn)) $error['subdistrictEn'] = 'กรุณากรอกข้อมูล';*/
      

      /***** name_adress thai **********/
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

      //---------- check cid -----------//
      $stmt = $this->db->prepare("SELECT 1 FROM tb_member WHERE  cid = ? and status in(1,2)");
      $stmt->bind_param("s", $cid);
      $stmt->execute();
      $results = $stmt->get_result();
      $ck_cid1 = $results->fetch_assoc();


      if (!empty($ck_cid1)) {
      //if (!empty($ck_cid1)) {
        $error['cid'] = 'ของท่านมีอยู่ในระบบแล้วโปรดเข้าใช้งานระบบด้วยบัญชีที่ท่านเคยลงทะเบียนไว้ หรือหากลืมรหัสผ่านสามารถขอรับใหม่ได้ที่เมนู <a href="'.BASE_URL.'auth/forget">"ลืมรหัสผ่าน"</a>';
      }

      //-------------------------------//
      if(empty($error)){
        if($type_is){
          $data_client = $this->get_data_client($_SESSION['client_id']);
          $member_app = $data_client['mc_id'];
          $status = '1';
          $sha1 = sha1($password);
          $stmt_sso_id = $this->db->prepare("SELECT MAX(tb_member.sso_id) as ssoid from tb_member");
          $stmt_sso_id->execute();
          $results_sso_id = $stmt_sso_id->get_result();
          $result_sso = $results_sso_id->fetch_assoc();
          $m_sso_id = $result_sso['ssoid']+1;
          $stmt_insert = $this->db->prepare("INSERT INTO tb_member (`cid`, `password`, `type`, `status`,`status_laser_verify`, `sso_id`) VALUES (?,?,?,?,?,?)");
          $stmt_insert->bind_param("ssssss", $cid, $sha1, $type, $status,$laser_type_people, $m_sso_id);
          $stmt_insert->execute();

          if(!empty($stmt_insert->insert_id)){
            $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $stmt_ck = $this->db->prepare($sql_max);
            $stmt_ck->execute();
            $results_max = $stmt_ck->get_result();
            $result_max = $results_max->fetch_assoc();
            $member_id = strval($result_max['member_id']);

            $data_insert_type3 = [
              'member_id' => $member_id,
              'member_title' => $member_title,
              'member_nameTh' => $member_nameTh,
              'member_midnameTh' => $member_midnameTh,
              'member_lastnameTh' => $member_lastnameTh,
              'member_nameEn' => $member_nameEn,
              'member_midnameEn' => $member_midnameEn,
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
              'provinceEn' => $provinceEn,
              'districtEn' => $districtEn,
              'subdistrictEn' => $subdistrictEn
            ];
            // $insert_register_log = $this->insert('tb_register_log', $dat);
            // $insert_type3 = $this->insert('tb_member_type3', $data_insert_type3);

            $data = json_encode($data_insert_type3,JSON_UNESCAPED_UNICODE);
            $types = '3';
            $stmt_register_log = $this->db->prepare("INSERT INTO tb_register_log (`cid`, `data`, `type`) VALUES (?,?,?)");
            $stmt_register_log->bind_param("iss", $member_id, $data, $types);
            $stmt_register_log->execute();

            $tel_countrys = ($tel_country == '')? 'TH' : strtoupper($tel_country);
            $tel_codes = ($tel_code == '')? '+66' : "+".$tel_code;
            $stmt_insert_type3 = $this->db->prepare("INSERT INTO `tb_member_type3`(`member_id`, `member_title`, `member_nameTh`, `member_midnameTh`, `member_lastnameTh`, `member_nameEn`, `member_midnameEn`, `member_lastnameEn`, `email`, `tel`, `tel_country`, `tel_code`, `addressTh`, `provinceTh`, `districtTh`, `subdistrictTh`, `postcode`, `provinceEn`, `districtEn`, `subdistrictEn`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_insert_type3->bind_param("ssssssssssssssssssss", $member_id,$member_title,$member_nameTh,$member_midnameTh,$member_lastnameTh,$member_nameEn,$member_midnameEn,$member_lastnameEn,$email,$tel,$tel_countrys,$tel_codes,$addressTh,$provinceTh,$districtTh,$subdistrictTh,$postcode,$provinceEn,$districtEn,$subdistrictEn);
            $stmt_insert_type3->execute();
  
            //------------------------ INSERT AND LOGIN connect --------------------------//
              //-- insert_touch ---/
              $data_insert_touch = [
                'register_type' => 'FORM',
                'identify' => 'PERSONAL',
                'email' => $email,
                'password' => $password,
                'firstname' => $member_nameEn,
                'lastname' => $member_lastnameEn,
                'citizen_id' => $cid,
                'mobile' => $tel
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
                // $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
                $client_ids = "SS6931846";
                $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_member_app_id (`member_id`, `member_id_app`, `client_id`) VALUES (?,?,?)");
                $stmt_member_app_id->bind_param("ssiiii", $member_id, $member_id_connect, $client_ids);
                $stmt_member_app_id->execute();
                //------- insert token_external --------//
                $TOUCH = 'TOUCH';
                $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_token_external (`member_id`, `member_id_app`, `token_code`, `member_type`) VALUES (?,?,?,?)");
                $stmt_member_app_id->bind_param("ssiiii", $member_id, $id_connect, $token_connect,$TOUCH);
                $stmt_member_app_id->execute();
              }
            //------------------------ END OFF INSERT AND LOGIN connect --------------------------//

            //-- return code ไปให้ js fetch api --//
            $code_drive = $this->get_code($member_id, 'ssonticlient');
            $code_care = $this->get_code($member_id, 'ssocareid');

            //--- SESSION FOR LOGIN after reg ---//
            $_SESSION['tb_member_id'] = $member_id;

            //-- redirect --//
            $url = $this->get_return_url($member_id);
            $return = [
              'code' => '00', 
              'success' => 1, 
              'cid' => $cid,
              'url' => $url,
              'type_verify' => $type3_verify,
              'code' =>[
                'code_care' => $code_care,
                'code_drive' => $code_drive,
                'xx' => $password,
                'ee' => $email
              ]
            ];

            //$url = $this->get_return_url($member_id);
            //$return = ['code' => '00', 'success' => 1, 'url' => $url];
          }
        }else{
          $return = ['code' => '00', 'success' => 1];
        }
      }else{
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['code' => '01', 'error' => $error_res];
      }
      return $return;


    }else if($type == 4){ //บุคคลต่างชาติ
      //return "Passport ID";
      // -- data tb_member --//
      $cid = $this->post('passport_id');
      $password = $this->post('password');
      $repassword = $this->post('repassword');

      // -- data tb_member_type4 --//
      $member_title = $this->post('fo_title');
      //$member_nameTh = $this->post('fo_nameTh');
      //$member_lastnameTh = $this->post('fo_lastnameTh');
      $member_nameEn = $this->post('fo_name');
      $member_midnameEn = $this->post('fo_midname');
      $member_lastnameEn = $this->post('fo_lastname');
      $country = $this->post('passport_county_name');
      $address = $this->post('passport_fo_address');
      $email = $this->post('fo_email');
      $tel = $this->post('fo_tel');
      $tel_country = $this->post('fo_tel_country');
      $tel_code = $this->post('fo_tel_code');

      // print_r($_POST);
      // die();
      if(strlen($tel) < 10) {
        $error['fo_tel'] = "Please fill in the information.";
      }
      $text_alert = "Please fill in the information";
      if(empty($cid)) $error['cid'] = $text_alert;

      // if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)) {
      //   $error['password'] = "Password must contain letters. English uppercase (A-Z), lowercase English letters (a-z), numbers (1-9), and symbols (e.g. #, $, & etc.).";
      // }
      if(strlen($password) < 8) {
        $error['password'] = "more than 8 characters";
      }

      if(empty($password)) $error['password'] = $text_alert;
      if($password != $repassword) $error['repassword'] = 'Not match';

      if(empty($repassword)) $error['repassword'] = $text_alert;
      if(empty($country)) $error['fo_country_name'] = $text_alert;
      if(empty($member_title)) $error['fo_title'] = $text_alert;
      //if(empty($member_nameTh)) $error['fo_nameTh'] = $text_alert;
      //if(empty($member_lastnameTh)) $error['fo_lastnameTh'] = $text_alert;
      if(empty($member_nameEn)) $error['fo_name'] = $text_alert;
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $member_nameEn)) {
        $error['fo_name'] = "Please enter your name in letters a - z only.";
      }
      if (!empty($member_midnameEn) && !preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $member_nameEn)) {
        $error['fo_midname'] = "Please enter your name in letters a - z only.";
      }
      if(empty($member_lastnameEn)) $error['fo_lastname'] = $text_alert;
      if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $member_lastnameEn)) {
        $error['fo_lastname'] = "Please enter your last name in letters a - z only.";
      }

      if(!preg_match("/^[0-9]+$/", $tel) && $tel_country == 'th') {
        $error['fo_tel'] = "Please enter numbers 0-9 only.";
      }
      //if(empty($address)) $error['fo_address'] = $text_alert;
  
      //-------- Email ซ้ำ ---------//
      // $sql_ckmail1 = 'SELECT 1 FROM tb_member_type1 WHERE member_email ="' . $email . '"';
      // $sql_ckmail2 = 'SELECT 1 FROM tb_member_type2 WHERE email ="' . $email . '"';
      // $sql_ckmail3 = 'SELECT 1 FROM tb_member_type3 WHERE email ="' . $email . '"';
      // $sql_ckmail4 = 'SELECT 1 FROM tb_member_type4 WHERE email ="' . $email . '"';
      // $sql_ckmail5 = 'SELECT 1 FROM tb_member_type5 WHERE email ="' . $email . '"';

      // $ck_mail1 = $this->query($sql_ckmail1);
      // $ck_mail2 = $this->query($sql_ckmail2);
      // $ck_mail3 = $this->query($sql_ckmail3);
      // $ck_mail4 = $this->query($sql_ckmail4);
      // $ck_mail5 = $this->query($sql_ckmail5);

      // if (!empty($ck_mail1) || !empty($ck_mail2) || !empty($ck_mail3) || !empty($ck_mail4) || !empty($ck_mail5)) {
      //   $error['fo_email'] = 'has already been used';
      // }
      /// อันนี้ใช้
      // $ck_mail = $this->check_mail($email);
      // if($ck_mail == false){
      //   $error['fo_email'] = 'has already been used';
      // }

      //--------------------------//
      
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['fo_email'] = 'not a valid';
      }
      if(empty($email)) $error['fo_email'] = $text_alert;
      if(empty($tel)) $error['fo_tel'] = $text_alert;

      //---------- check cid -----------//
      $stmt = $this->db->prepare("SELECT 1 FROM tb_member WHERE  cid = ? and status in(1,2)");
      $stmt->bind_param("s", $cid);
      $stmt->execute();
      $results = $stmt->get_result();
      $ck_cid1 = $results->fetch_assoc();

      if (!empty($ck_cid1)) {
        $error['passport_id'] = 'has already been used please login with your account if forget your passsword please use <a href="'.BASE_URL.'auth/forget">"Forgot password"</a>';
      }
      //--------------------------------//
      $data_client = $this->get_data_client($_SESSION['client_id']);
      $member_app = $data_client['mc_id'];
      if(empty($error)){
        if($type_is){
          $status = '1';
          $sha1 = sha1($password);
          $stmt_sso_id = $this->db->prepare("SELECT MAX(tb_member.sso_id) as ssoid from tb_member");
          $stmt_sso_id->execute();
          $results_sso_id = $stmt_sso_id->get_result();
          $result_sso = $results_sso_id->fetch_assoc();
          $m_sso_id = $result_sso['ssoid']+1;
          $stmt_insert = $this->db->prepare("INSERT INTO tb_member (`cid`, `password`, `type`, `status`, `sso_id`) VALUES (?,?,?,?,?)");
          $stmt_insert->bind_param("sssss", $cid, $sha1, $type, $status, $m_sso_id);
          $stmt_insert->execute();
    
          if(!empty($stmt_insert->insert_id)){
            $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
            $stmt_ck = $this->db->prepare($sql_max);
            $stmt_ck->execute();
            $results_max = $stmt_ck->get_result();
            $result_max = $results_max->fetch_assoc();
            $member_id = strval($result_max['member_id']);

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
            // $dat = [
            //   'cid' => $member_id,
            //   'data' => json_encode($data_insert_type4),
            //   'type' => 4
            // ];
            // $insert_register_log = $this->insert('tb_register_log', $dat);
            // $insert_type4 = $this->insert('tb_member_type4', $data_insert_type4);
            $data = json_encode($data_insert_type4,JSON_UNESCAPED_UNICODE);
            $types = '4';
            $stmt_register_log = $this->db->prepare("INSERT INTO tb_register_log (`cid`, `data`, `type`) VALUES (?,?,?)");
            $stmt_register_log->bind_param("sss", $member_id, $data, $types);
            $stmt_register_log->execute();
          
            $tel_countrys = ($tel_country == '')? 'TH' : strtoupper($tel_country);
            $tel_codes = ($tel_code == '')? '+66' : "+".$tel_code;
            // $stmt_insert_type4 = $this->db->prepare("INSERT INTO `tb_member_type4`(`member_id`, `member_title`, `member_nameTh`, `member_lastnameTh`, `member_nameEn`, `member_midnameEn`, `member_lastnameEn`, `country`, `address`, `email`, `tel`, `tel_country`, `tel_code`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            // $stmt_insert_type4->bind_param("sssssssssssss", $member_id,$member_title,$member_nameEn,$member_midnameEn,$member_lastnameEn,$member_nameEn,$member_midnameEn,$member_lastnameEn,$country,$address,$email,$tel,$tel_countrys,$tel_codes);
            // $stmt_insert_type4->execute();
            $stmt_insert_type4 = $this->db->prepare("INSERT INTO `tb_member_type4`(`member_id`, `member_title`, `member_nameTh`, `member_lastnameTh`, `member_nameEn`, `member_midnameEn`, `member_lastnameEn`, `country`, `address`, `email`, `tel`, `tel_country`, `tel_code`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt_insert_type4->bind_param("sssssssssssss", $member_id, $member_title, $member_nameEn, $member_lastnameEn, $member_nameEn, $member_midnameEn, $member_lastnameEn, $country, $address, $email, $tel, $tel_countrys, $tel_codes);
            $stmt_insert_type4->execute();
      
            //------------------------ INSERT AND LOGIN connect --------------------------//
              //-- insert_touch ---/
              $data_insert_touch = [
                'register_type' => 'FORM',
                'identify' => 'PERSONAL',
                'email' => $email,
                'password' => $password,
                'firstname' => $member_nameEn,
                'lastname' => $member_lastnameEn,
                'citizen_id' => $cid,
                'mobile' => $tel
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
                // $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
                $client_ids = "SS6931846";
                $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_member_app_id (`member_id`, `member_id_app`, `client_id`) VALUES (?,?,?)");
                $stmt_member_app_id->bind_param("ssiiii", $member_id, $member_id_connect, $client_ids);
                $stmt_member_app_id->execute();
                //------- insert token_external --------//
                $TOUCH = 'TOUCH';
                $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_token_external (`member_id`, `member_id_app`, `token_code`, `member_type`) VALUES (?,?,?,?)");
                $stmt_member_app_id->bind_param("ssiiii", $member_id, $id_connect, $token_connect,$TOUCH);
                $stmt_member_app_id->execute();
                // $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
              }
            //------------------------ END OFF INSERT AND LOGIN connect --------------------------//

            //-- return code ไปให้ js fetch api --//
            $code_drive = $this->get_code($member_id, 'ssonticlient');
            $code_care = $this->get_code($member_id, 'ssocareid');
            
            //--- SESSION FOR LOGIN after reg ---//
            $_SESSION['tb_member_id'] = $member_id;
            
            //-- redirect --//
            $url = $this->get_return_url($member_id);
            $return = [
              'code' => '00', 
              'success' => 1, 
              'url' => $url,
              'type_verify' => 1,
              'cid' => $cid,
              'code' =>[
                'code_care' => $code_care,
                'code_drive' => $code_drive,
                'xx' => $password,
                'ee' => $email
              ]
            ];
          }
        }else{
          $return = ['code' => '00', 'success' => 1];
        }
      }else{
        $error_res = [];
        foreach ($error as $key => $value) {
          $error_res[] = [
            'name' => $key,
            'value' => $value
          ];
        }
        $return = ['code' => '01', 'error' => $error_res];
      }
      return json_encode($return);
    }else if($type == 6){
         //-- data tb_member --//
         $cid = $this->post('cid');
         $position = $this->post('position');
         $password = $this->post('password');
         $repassword = $this->post('repassword');
   
         //-- data tb_member_type6 ---//
         
         $company_nameTh = $this->post('company_name');
         $company_nameEn = $this->post('company_nameEn');
         $company_email = $this->post('company_email');
         $company_tel = $this->post('company_phone');
         $company_addressTh = $this->post('company_address');
         $company_provinceTh = $this->post('companyTH_provinces');
         $company_districtTh = $this->post('companyTH_districts');
         $company_subdistrictTh = $this->post('companyTH_subdistricts');
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

         $laser_type_company = $this->post('laser_type1');
         $type1_verify = $this->post('type1_verify');

         if(strlen($member_tel) < 10) {
          $error['contact_tel'] = "ไม่ถูกต้อง";
        }
         if(empty($cid)) $error['cid'] = 'กรุณากรอกข้อมูล';
   
         // if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)) {
         //   $error['password'] = "รหัสผ่านจะต้องประกอบไปด้วยอักษร ภาษาอังกฤษตัวใหญ่ (A-Z), อักษรภาษาอังกฤษตัวเล็ก (a-z), ตัวเลข (1-9) และสัญลักษณ์ (เช่น #, $, & เป็นต้น)";
         // }
         if(strlen($password) < 8) {
           $error['password'] = "กรุณาป้อนรหัสผ่าน 8 ตัวขึ้นไป";
         }
   
         if(empty($password)) $error['password'] = 'กรุณากรอกข้อมูล';
         if($password != $repassword) $error['repassword'] = 'รหัสผ่านไม่ตรงกัน';
         if(empty($repassword)) $error['repassword'] = 'กรุณากรอกข้อมูล';
   
         if(empty($company_nameTh)) $error['company_name'] = 'กรุณากรอกข้อมูล';
         // if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $company_nameTh)) {
         //    $error['company_name'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
         // }
         
         if(empty($company_nameEn)) $error['company_nameEn'] = 'กรุณากรอกข้อมูล';
         // if(!preg_match("#[a-zA-Z]+#", $company_nameEn)) {
         //    $error['company_nameEn'] = "กรุณากรอกชื่อเป็นตัวอักษร a - z เท่านั้น";
         // }
         
         if(empty($company_addressEn)) $error['company_addressEn'] = 'กรุณากรอกข้อมูล';
         if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $company_addressEn)) {
           $error['company_addressEn'] = "กรุณากรอกที่เป็นตัวอักษร a - z เท่านั้น";
         }

         if(empty($contact_address)) $error['contact_address'] = 'กรุณากรอกข้อมูล';
         if(empty($contact_province)) $error['contact_province'] = 'กรุณากรอกข้อมูล';
         if(empty($contact_district)) $error['contact_district'] = 'กรุณากรอกข้อมูล';
         if(empty($contact_subdistrict)) $error['contact_subdistrict'] = 'กรุณากรอกข้อมูล';
         
         if(empty($member_title)) $error['contact_title'] = 'กรุณากรอกข้อมูล';
   
         if (!$this->isValidNationalId($member_cid)) {
           $error['contact_cid'] = 'ไม่ถูกต้อง';
         }
         if(empty($member_cid)) $error['contact_cid'] = 'กรุณากรอกข้อมูล';
         
         if(empty($member_nameTh)) $error['contact_name'] = 'กรุณากรอกข้อมูล';
         if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $member_nameTh)) {
            $error['contact_name'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
         }
         if(empty($member_lastnameTh)) $error['contact_lastname'] = 'กรุณากรอกข้อมูล';
         if(!preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $member_lastnameTh)) {
             $error['contact_lastname'] = "กรุณากรอกนามสกุลเป็นตัวอักษร ก - ฮ เท่านั้น";
         }
         if(empty($member_nameEn)) $error['contact_nameEn'] = 'กรุณากรอกข้อมูล';
         if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $member_nameEn)) {
              $error['contact_nameEn'] = "กรุณากรอกชื่อเป็นตัวอักษร a - z เท่านั้น";
         }
         if(empty($member_lastnameEn)) $error['contact_lastnameEn'] = 'กรุณากรอกข้อมูล';
         if(!preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $member_lastnameEn)) {
          $error['contact_lastnameEn'] = "กรุณากรอกนามสกุลเป็นตัวอักษร a - z เท่านั้น";
         }       

         if (!empty($member_midnameTh) && !preg_match("/^[ก-์ ะ-ู เ-แ]+$/", $member_midnameTh)) {
            $error['contact_midname'] = "กรุณากรอกชื่อเป็นตัวอักษร ก - ฮ เท่านั้น";
          }
         if (!empty($member_midnameEn) && !preg_match("/^[a-zA-Z0-9\s\/*@#\-_$%^&+=§!\?]+$/", $member_midnameEn)) {
            $error['contact_lastnameEn'] = "กรุณากรอกนามสกุลเป็นตัวอักษร a - z เท่านั้น";
          }

         if(!preg_match("/^[0-9]+$/", $member_tel) && $member_tel_country == 'th') {
           $error['contact_tel'] = "กรุณากรอกตัวเลข 0-9 เท่านั้น";
         } 
     
         /// อันนี้ใช้
        //  $ck_mail = $this->check_mail($member_email);
        //  if($ck_mail == false){
        //    $error['contact_email'] = 'มีอยู่แล้วในระบบ';
        //  }
    
   
         if(!filter_var($member_email, FILTER_VALIDATE_EMAIL)) {
           $error['contact_email'] = 'รูปแบบไม่ถูกต้อง';
         }

         if(!filter_var($company_email, FILTER_VALIDATE_EMAIL)) {
           $error['company_email'] = 'รูปแบบไม่ถูกต้อง';
         }
         
         if(empty($member_email)) $error['contact_email'] = 'กรุณากรอกข้อมูล';
         if(empty($company_email)) $error['company_email'] = 'กรุณากรอกข้อมูล';
         if(empty($member_tel)) $error['contact_tel'] = 'กรุณากรอกข้อมูล';
   
         /******* get address name_th *******/
         if(empty($error)){
              //  $company_provinceTh = $this->post('H2contact_province');
              //   $company_districtTh = $this->post('H2contact_district');
              // $company_subdistrictTh = $this->post('H2contact_subdistrict');
           if($state == 'new'){
             $contact_province = $this->get_province($contact_province, 'th');
             $contact_district = $this->get_district($contact_district, 'th');
             $contact_subdistrict = $this->get_subdistrict($contact_subdistrict, 'th');
           }
         }
         /****** get address name_company th *******/
         if(!empty($company_provinceTh)) $company_provinceTh = $this->get_province($company_provinceTh, 'th');
         if(!empty($company_districtTh)) $company_districtTh = $this->get_district($company_districtTh, 'th');
         if(!empty($company_subdistrictTh)) $company_subdistrictTh = $this->get_subdistrict($company_subdistrictTh, 'th');
           /****** get address name_company en *******/
         if(!empty($company_provinceEn)) $company_provinceEn = $this->get_province($company_provinceEn, 'en');
         if(!empty($company_districtEn)) $company_districtEn = $this->get_district($company_districtEn, 'en');
         if(!empty($company_subdistrictEn)) $company_subdistrictEn = $this->get_subdistrict($company_subdistrictEn, 'en');
       
   
         //---------- check cid -----------//
         $stmt = $this->db->prepare("SELECT 1 FROM tb_member WHERE  cid = ?");
         $stmt->bind_param("s", $member_cid);
         $stmt->execute();
         $results = $stmt->get_result();
         $sql_ckcid1 = $results->fetch_assoc();
   
   
         if (!empty($ck_cid1)) {
          $error['cid'] = 'ของท่านมีอยู่ในระบบแล้วโปรดเข้าใช้งานระบบด้วยบัญชีที่ท่านเคยลงทะเบียนไว้ หรือหากลืมรหัสผ่านสามารถขอรับใหม่ได้ที่เมนู <br> <a href="'.BASE_URL.'auth/forget">"ลืมรหัสผ่าน"</a>';
        }

         $data_client = $this->get_data_client($_SESSION['client_id']);
         $member_app = $data_client['mc_id'];
         if(empty($error)){
           if($type_is){
                $status = '1';
                $sha1 = sha1($password);
                $stmt_sso_id = $this->db->prepare("SELECT MAX(tb_member.sso_id) as ssoid from tb_member");
                $stmt_sso_id->execute();
                $results_sso_id = $stmt_sso_id->get_result();
                $result_sso = $results_sso_id->fetch_assoc();
                $m_sso_id = $result_sso['ssoid']+1;
                $stmt_insert = $this->db->prepare("INSERT INTO tb_member (`cid`, `password`, `type`,  `status_laser_verify`, `status`, `sso_id`) VALUES (?,?,?,?,?,?)");
                $stmt_insert->bind_param("ssssss", $cid, $sha1, $type, $laser_type_company, $status, $m_sso_id);
                $stmt_insert->execute();
            
             if(!empty($stmt_insert->insert_id)){
                $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
                $stmt_ck = $this->db->prepare($sql_max);
                $stmt_ck->execute();
                $results_max = $stmt_ck->get_result();
                $result_max = $results_max->fetch_assoc();
                $member_id = strval($result_max['member_id']);

               $data_insert_type6 = [
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
                 'member_nameTh' => $member_nameTh,
                 'member_midnameTh' => $member_midnameTh,
                 'member_lastnameTh' => $member_lastnameTh,
                 'member_nameEn' => $member_nameEn,
                 'member_midnameEn' => $member_midnameEn,
                 'member_lastnameEn' => $member_lastnameEn,
                 'member_email' => $member_email,
                 'member_tel' => $member_tel,
                 'member_tel_country' => ($member_tel_country == '')? 'TH' : strtoupper($member_tel_country),
                 'member_tel_code' => ($member_tel_code == '')? '+66' : "+".$member_tel_code,
                 'position_id' =>$position 
               ];
                $dat = [
                  'cid' => $member_id,
                  'data' => json_encode($data_insert_type6),
                  'type' => 6
                ];
              //   $insert_register_log = $this->insert('tb_register_log', $dat);
              //  $insert_type6 = $this->insert('tb_member_type6', $data_insert_type6);
               $data = json_encode($data_insert_type6,JSON_UNESCAPED_UNICODE);
               $types = '6';
               $stmt_register_log = $this->db->prepare("INSERT INTO tb_register_log (`cid`, `data`, `type`) VALUES (?,?,?)");
               $stmt_register_log->bind_param("iss", $member_id, $data, $types);
               $stmt_register_log->execute();
               
               $member_tel_countrys = ($member_tel_country == '')? 'TH' : strtoupper($member_tel_country);
               $member_tel_codes = ($member_tel_code == '')? '+66' : "+".$member_tel_code;
               $stmt_insert_type6 = $this->db->prepare("INSERT INTO `tb_member_type6`(`member_id`,`company_nameTh`,`company_nameEn`,`company_email`,`company_tel`,`company_addressTh`,`company_provinceTh`,`company_districtTh`,`company_subdistrictTh`,`company_postcodeTh`,`company_addressEn`,`company_provinceEn`,`company_districtEn`,`company_subdistrictEn`,`company_postcodeEn`,`contact_address`,`contact_province`,`contact_district`,`contact_subdistrict`,`contact_postcode`,`member_title`,`member_cid`,`member_nameTh`,`member_midnameTh`,`member_lastnameTh`,`member_nameEn`,`member_midnameEn`,`member_lastnameEn`,`member_email`,`member_tel`,`member_tel_country`,`member_tel_code`,`position_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
               $stmt_insert_type6->bind_param("sssssssssssssssssssssssssssssssss", $member_id,$company_nameTh,$company_nameEn,$company_email,$company_tel,$company_addressTh,$company_provinceTh,$company_districtTh,$company_subdistrictTh,$company_postcode,$company_addressEn,$company_provinceEn,$company_districtEn,$company_subdistrictEn,$company_postcodeEn,$contact_address,$contact_province,$contact_district,$contact_subdistrict,$contact_postcode,$member_title,$member_cid,$member_nameTh,$member_midnameTh,$member_lastnameTh,$member_nameEn,$member_midnameEn,$member_lastnameEn,$member_email,$member_tel,$member_tel_countrys,$member_tel_codes,$position);
               $stmt_insert_type6->execute();


   
               //------------------------ INSERT AND LOGIN connect --------------------------//
                 //-- insert_touch ---/
                 $data_insert_touch = [
                   'register_type' => 'FORM',
                   'identify' => 'CORPORATE',
                   'email' => $member_email,
                   'password' => $password,
                   'company_name' => $company_nameTh,
                   'company_tax_id' => $cid,
                   'company_telephone' => $member_tel
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
                  //  $insert = $this->insert('tb_member_app_id', $data_insert_member_app);
                    $client_ids = "SS6931846";
                    $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_member_app_id (`member_id`, `member_id_app`, `client_id`) VALUES (?,?,?)");
                    $stmt_member_app_id->bind_param("ssiiii", $member_id, $member_id_connect, $client_ids);
                    $stmt_member_app_id->execute();   
                   //------- insert token_external --------//
                   $data_insert_token_external = [
                     'member_id' => $member_id,
                     'member_id_app' => $id_connect,
                     'token_code' => $token_connect,
                     'member_type' => 'TOUCH',
                   ];
                    $TOUCH = 'TOUCH';
                    // $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
                    $stmt_member_app_id = $this->db->prepare("INSERT INTO tb_token_external (`member_id`, `member_id_app`, `token_code`, `member_type`) VALUES (?,?,?,?)");
                    $stmt_member_app_id->bind_param("ssiiii", $member_id, $id_connect, $token_connect,$TOUCH);
                    $stmt_member_app_id->execute();
                 }
               //------------------------ END OFF INSERT AND LOGIN connect --------------------------//
   
               //-- return code ไปให้ js fetch api --//
               $code_drive = $this->get_code($member_id, 'ssonticlient');
               $code_care = $this->get_code($member_id, 'ssocareid');
   
               //--- SESSION FOR LOGIN after reg ---//
               $_SESSION['tb_member_id'] = $member_id;
   
               //-- redirect --//
               $url = $this->get_return_url($member_id);
               $return = [
                 'code' => '00', 
                 'success' => 1, 
                 'url' => $url,
                 'cid' => $cid,
                 'type_verify' => $type1_verify,
                 'code' =>[
                   'code_care' => $code_care,
                   'code_drive' => $code_drive,
                   'xx' => $password,
                   'ee' => $member_email
                 ]
               ];
               // pr($type1_verify);
               // pr($return);
               // die(); 
               //$url = $this->get_return_url($member_id);
               //$return = ['code' => '00', 'success' => 1, 'url' => $url];
             }
           }else{
             $return = ['code' => '00', 'success' => 1];
           }
         }else{
           $error_res = [];
           foreach ($error as $key => $value) {
             $error_res[] = [
               'name' => $key,
               'value' => $value
             ];
           }
           $return = ['code' => '01', 'error' => $error_res];
         }
         return $return;
         //------------------------------//
      // echo '<script> alert("Hello! I am an alert box!!");</script>';
    }else{
      var_dump($type);
    }
    
    /*$return = [];
    $error = [];
    $cid = $this->post('cid');

    $password = $this->post('password');

    $name = $this->post('name_user');
    $lastname = $this->post('lastname');
    $email = $this->post('email');
    $tel = $this->post('tel');
    $country_name = $this->post('country_name');
    if (empty($cid)) {
      $error['cid'] = 'กรุณากรอกข้อมูล';
    }
    if (empty($password)) {
      $error['password'] = 'กรุณากรอกข้อมูล';
    } else {
      $repassword =  $this->post('repassword');
      if ($password != $repassword) {
        $error['password'] = 'ไม่ตรงกับ repassword';
      }
      // repassword
    }
    $sub_member = [];
    switch ($type) {
      case '1':
        # นิติบุคคล ไทย

        $sub = $this->post('sub');

        if (empty($sub)) {
          $error['Contact'] = 'ไม่ถูกต้อง';
        } else {
          if (empty($sub['title'])) {
            $error['sub[title]'] = 'กรุณากรอกข้อมูล';
          }
          if (empty($sub['cid'])) {
            $error['sub[cid]'] = 'กรุณากรอกข้อมูล';
          } else {
            if (!$this->isValidNationalId($sub['cid'])) {
              $error['sub[cid]'] = 'ไม่ถูกต้อง';
            }
          }
          if (empty($sub['name'])) {
            $error['sub[name]'] = 'กรุณากรอกข้อมูล';
          }
          if (empty($sub['lastname'])) {
            $error['sub[lastname]'] = 'กรุณากรอกข้อมูล';
          }
          if (empty($sub['email'])) {
            $error['sub[email]'] = 'กรุณากรอกข้อมูล';
          }
          if (empty($sub['tel'])) {
            $error['sub[tel]'] = 'กรุณากรอกข้อมูล';
          }
        }
        if (empty($name)) {
          $error['name_user'] = 'ไม่ถูกต้อง';
        }
        // $error['Type'] = 'ไม่ถูกต้อง';
        break;
      case '2':
        # นิติบุคคล ต่างชาติ
        if (empty($name)) {
          $error['name_user'] = 'กรุณากรอกข้อมูล';
        }
        if (empty($country_name)) {
          $error['country_name'] = 'กรุณากรอกข้อมูล';
        }
        $sub = $this->post('sub');

        if (empty($sub)) {
          $error['Contact'] = 'ไม่ถูกต้อง';
        } else {
          if (empty($sub['title'])) {
            $error['sub[title]'] = 'กรุณากรอกข้อมูล';
          }
          if (empty($sub['name'])) {
            $error['sub[name]'] = 'กรุณากรอกข้อมูล';
          }
          if (empty($sub['lastname'])) {
            $error['sub[lastname]'] = 'กรุณากรอกข้อมูล';
          }
          if (empty($sub['email'])) {
            $error['sub[email]'] = 'กรุณากรอกข้อมูล';
          }
          if (empty($sub['tel'])) {
            $error['sub[tel]'] = 'กรุณากรอกข้อมูล';
          }
        }
        // $error['Type'] = 'ไม่ถูกต้อง';
        break;
      case '3':
        # บุคคล ไทย
        if (!$this->isValidNationalId($cid)) {
          $error['cid'] = 'ไม่ถูกต้อง';
        }
        if (empty($name)) {
          $error['name_user'] = 'กรุณากรอกข้อมูล';
        }
        if (empty($lastname)) {
          $error['lastname'] = 'กรุณากรอกข้อมูล';
        }
        if (empty($email)) {
          $error['email'] = 'กรุณากรอกข้อมูล';
        }
        if (empty($tel)) {
          $error['tel'] = 'กรุณากรอกข้อมูล';
        }
        break;
      case '4':
        # บุคคล ต่างชาติ
        if (empty($country_name)) {
          $error['country_name'] = 'กรุณากรอกข้อมูล';
        }

        $sub = $this->post('sub');

        if (empty($sub)) {
          $error['Contact'] = 'ไม่ถูกต้อง';
        } else {
          if (empty($sub['title'])) {
            $error['sub[title]'] = 'กรุณากรอกข้อมูล';
          }

          if (empty($sub['name'])) {
            $error['sub[name]'] = 'กรุณากรอกข้อมูล';
          } else {
            $name = $sub['name'];
          }
          if (empty($sub['lastname'])) {
            $error['sub[lastname]'] = 'กรุณากรอกข้อมูล';
          } else {
            $lastname = $sub['lastname'];
          }
          if (empty($sub['email'])) {
            $error['sub[email]'] = 'กรุณากรอกข้อมูล';
          } else {
            $email = $sub['email'];
          }
          if (empty($sub['tel'])) {
            $error['sub[tel]'] = 'กรุณากรอกข้อมูล';
          } else {
            $tel = $sub['tel'];
          }
        }

        break;
      default:
        $error['Type'] = 'ไม่ถูกต้อง';
        # ไม่มี 
        break;
    }


    $sql = 'SELECT 1 FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
    $ck_cid = $this->query($sql);
    if (!empty($ck_cid)) {
      $error['cid'] = 'มีอยู่แล้วในระบบ';
    }

    if (empty($error)) {

      if ($type_is) {

        if (in_array($type, [1, 2])) {
          $key_sub = ['sub_title' => 'title', 'sub_name' => 'name', 'sub_lastname' => 'lastname', 'sub_email' => 'email', 'sub_tel' => 'tel', 'sub_cid' => 'cid'];
          $sub_data = $this->post('sub');
          foreach ($key_sub as $key => $val) {
            if (isset($sub_data[$val])) {
              $sub_member[$key] = $sub_data[$val];
            }
          }
        }


        $insert = [
          'cid' => $cid,
          'password' => sha1($password),
          'type' => $type,
          'member_title' => $this->post('title'),
          'member_name' => $name,
          'member_lastname' => $lastname,
          'member_address' => $this->post('address'),
          'email' => $email,
          'tel' => $tel,
          'country' => $this->post('country_name'),
          'province' => $this->post('province'),
          'district' => $this->post('district'),
          'subdistrict' => $this->post('subdistrict'),
          'postcode' => $this->post('postcode'),
          'status' => 1

        ];
        $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
        $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
        $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
        $ck_mem = $this->insert('tb_member', $insert);
        
        if ($ck_mem) {
          if (!empty($sub_member)) {
            $sub_member['member_id'] = $ck_mem;
            $sub_member['status'] = 1;
            $this->insert('tb_sub_member', $sub_member);
          }
          $bus = $this->post('bus');
          if (count($bus) > 0) {
            $bus_insert = [
              'member_id' => $ck_mem,
              'bc_adress' => (empty($bus['address'])) ? '' : $bus['address'],
              'bc_province' => (empty($bus['province'])) ? '' : $bus['province'],
              'bc_district' => (empty($bus['district'])) ? '' : $bus['district'],
              'bc_subdistrict' => (empty($bus['subdistrict'])) ? '' : $bus['subdistrict'],
              'bc_postcode' => (empty($bus['postcode'])) ? '' : $bus['postcode'],
              'status' => 1
            ];
            $this->insert('tb_business_contact', $bus_insert);
          }

          // tb_business_contact
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
              $return = ['code' => '00', 'success' => 1, 'url' => $url];
            }
          } else if (strtoupper($response_type) == 'TOKEN') {
            $data_token = $this->gen_token($ck_mem);
            if (!empty($data_token['token'])) {

              $jwt_data = [
                'id_token' => $data_token['token'],
                'end_date' =>  $data_token['exp_date'],
                "token_type" => "Bearer"
              ];
              $jwt = JWT::encode($jwt_data, $key);
              $state =  $_SESSION['state'];
              $url .= 'code=' . $jwt . "&state=" . $state;

              $cookie_value = JWT::encode($jwt_data, $this->config->items('cookie_login_key'));;
              setcookie($this->config->items('cookie_login'), $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
            }
            $return = ['code' => '00', 'success' => 1, 'url' => $url];
          }
        }
      } else {
        $return = ['code' => '00', 'success' => 1];
      }
    } else {

      $error_res = [];
      foreach ($error as $key => $value) {
        $error_res[] = [
          'name' => $key,
          'value' => $value
        ];
      }

      $return = ['code' => '01', 'error' => $error_res];
    }
    return json_encode($return);*/
  }

  /*function gen_token($member_id = '')
  {
    $token_code = sha1($_SESSION['client_id'] . $member_id . date('YmhHis') . session_id());

    $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours"));
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
      $return['token'] = $token_code;
      $return['exp_date'] = $end_date;
    }
    return $return;
  }*/

  function gen_token($member_id = '',$client_id = '')
  {
    if(empty($client_id)){
      $client_id = $_SESSION['client_id'];
    }
    /******** insert tb_token ***************/
    $token_code = sha1($client_id . $member_id . date('YmhHis') . session_id()); 
    $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours")); //2 hours

    // $insert_token = [
    //   'member_id' => $member_id,
    //   'token_code' => $token_code,
    //   'client_id' => $_SESSION['client_id'],
    //   'status' => 1,
    //   'exp_date' => $end_date,
    // ];
    $client_ids = $client_id;
    $status = '1';
    // $last_id = $this->insert('tb_token', $insert_token);
    $stmt = $this->db->prepare("INSERT INTO tb_token (`member_id`, `token_code`, `client_id`, `status`, `exp_date`) VALUES (?,?,?,?,?)");
    $stmt->bind_param("issis", $member_id, $token_code, $client_ids, $status, $end_date);
    $stmt->execute();
    $return = [];
    if ($stmt->insert_id) {
      /************** get id_token ***********/
      // $sql = "SELECT * FROM tb_token WHERE token_code ='" . $token_code . "'";
      // $data = $this->query($sql);
      $stmt_token = $this->db->prepare("SELECT * FROM tb_token WHERE token_code = ?");
      $stmt_token->bind_param("s", $token_code);
      $stmt_token->execute();
      $result_data = $stmt_token->get_result();
      $val = $result_data->fetch_assoc();
      if(count($val)>0){ 
        // $val = $data[0];
        $refresh_token_code = sha1("refresh_token".$client_id . $member_id . date('YmhHis') . session_id());
        $end_date_refresh = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+14 days"));
        // $insert_refresh = [
        //   'token_id' => $val['token_id'],
        //   'token_code' => $val['token_code'],
        //   'refresh_code' => $refresh_token_code,
        //   'status' => 1,
        //   'refresh_exp_date' => $end_date_refresh,
        // ];
        $token_id = strval($val['token_id']);
        $token_codes = $val['token_code'];
        $refresh_code = $refresh_token_code;
        $status = '1';
        $refresh_exp_date = $end_date_refresh;
        // $result = $this->insert('tb_refresh_token', $insert_refresh);
        $stmt_result = $this->db->prepare("INSERT INTO tb_refresh_token (`token_id`, `token_code`, `refresh_code`, `status`, `refresh_exp_date`) VALUES (?,?,?,?,?)");
        $stmt_result->bind_param("ssisi", $token_id, $token_codes, $refresh_code, $status, $refresh_exp_date);
        $stmt_result->execute();
        if($stmt_result->insert_id){
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
  

  function gen_access($member_id = '')
  {
    $accesstoken = md5($_SESSION['client_id'] . $member_id . date('YmhHis') . session_id());
    $end_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+2 hours"));
    // $insert_access = [
    //   'member_id' => $member_id,
    //   'ac_code' => $accesstoken,
    //   'client_id' => $_SESSION['client_id'],
    //   'status' => 1,
    //   'exp_date' => $end_date,
    // ];
    $member_id = strval($member_id);
    $ac_code = $accesstoken;
    $client_id = $_SESSION['client_id'];
    $status = '1';
    $exp_date = $end_date;
    // $last_id = $this->insert('tb_access_code', $insert_access);
    $last_id = $this->db->prepare("INSERT INTO tb_access_code (`member_id`, `ac_code`, `client_id`, `status`, `exp_date`) VALUES (?,?,?,?,?)");
    $last_id->bind_param("ssiiii", $member_id, $ac_code, $client_id,$status,$exp_date);
    $last_id->execute();
    $return = [];
    if (!empty($last_id->insert_id)) {
      $return['access'] = $accesstoken;
      $return['exp_date'] = $end_date;
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
      $return = ['message'=>$message,'code'=>'03'];
    }
    
    return $return;
  }
  public function laser_validation () {
    // if ($this->post('cid') == '1509960008227') {
    //   $_SESSION['laser_verify'] = true;
    //   $res = [
    //     'result_code' => '00',
    //     'result_text' => 'Success',
    //   ];
    //   return $res;
    // }
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
    $nationalId = $this->post('cid');

    $token = $this->laserToken($nationalId);
    $date = $this->dateswap(str_replace(["BE"," "],"",$this->post('bday')));
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
      'laser' => $laser,//$this->post('laser_id'),
      'token' => $token->Result
    ];
    $result = $this->ck_laser_id($val);
    $result = json_decode($result);
    // if (isset($result->code) && $result->code == '01') {

    //   $this->insert('tb_verify_dopa_log', $insert_dopa_log);

    //   return $res = [
    //       'result_code' => '02',
    //       'result_text' => 'ไม่สามรถเชื่อต่อ service DOPA'
    //     ];    
    // } destination service temporarily unavailable
    // $result = (object)["Message" => "destination service temporarily unavailable"];

    if (!isset($result) || empty($result)) {
      $dat = [
        'fname' => $this->post('fname'),
        'lname' => $this->post('lname'),
        'cid' => $nationalId,
        'res' => 'no response',
        'bday' => $date,
        'laser' => $laser,
        'endpoint' => 'register'
      ];
      $insert_laser_verify_log = $this->insert('tb_laser_verify_log', $dat);
    }

    if (isset($result->Result) && $result->Result == true) {
      $dat = [
        'fname' => $this->post('fname'),
        'lname' => $this->post('lname'),
        'cid' => $nationalId,
        'res' => json_encode($result),
        'bday' => $date,
        'laser' => $laser,
        'endpoint' => 'register'
      ];
      $insert_laser_verify_log = $this->insert('tb_laser_verify_log', $dat);
      $_SESSION['laser_verify'] = true;
      $res = [
        'result_code' => '00',
        'result_text' => 'Success',
      ];
    } else if ($result->Result == false && !isset($result->Message)){
      $dat = [
        'fname' => $this->post('fname'),
        'lname' => $this->post('lname'),
        'cid' => $nationalId,
        'res' => NULL,
        'bday' => $date,
        'laser' => $laser,
        'endpoint' => 'register'
      ];
      $insert_laser_verify_log = $this->insert('tb_laser_verify_log', $dat);
      $res = [
        'result_code' => "01",
        'result_text' => "ท่านกรอกข้อมูลไม่ถูกต้อง"
      ];
    } else {
      $message = $this->getLaserError($result->Message, $result->Code); 
      $dat = [
        'fname' => $this->post('fname'),
        'lname' => $this->post('lname'),
        'cid' => $nationalId,
        'res' => json_encode($result),
        'bday' => $date,
        'laser' => $laser,
        'endpoint' => 'register'
      ];
      // var_dump($message,$dat);
      // die;
      $insert_laser_verify_log = $this->insert('tb_laser_verify_log', $dat);
      if($message['code'] == '03'){
        $res = [
          'result_code' => $message['code'],
          'result_text' => $message['message']
        ];
      }else{
        $res = [
          'result_code' => $result->Code,
          'result_text' => $message
        ];
      }
    }

    return $res;
  }
  function dateswap($datadate) {
    $datearray = explode("/",$datadate);
    if (strlen($datadate) > 3) {
      $meyear = $datearray[2] + 543;
      $datadate = $meyear . "" . $datearray[1] . "" . $datearray[0];
    }
   return $datadate;
  }

  function get_data_client($client_id = '')
  {
    $status = '1';
    $stmt = $this->db->prepare("SELECT * FROM tb_merchant WHERE tb_merchant.client_id = ? and tb_merchant.status = ?");
    $stmt->bind_param("ss", $client_id, $status); // สังเกตการใช้ "ss" แทน "s" เพราะมีพารามิเตอร์ 2 ตัว
    $stmt->execute();
    $results = $stmt->get_result();
    $data = $results->fetch_assoc();
    $return = [];
    if (!empty($data)) {
      $return = $data;
    }
    return $return;
  }
  function ck_com_dbd($cid = '')
  {
    //0125550046368
    // echo 'PHP_VERSION';
    // die();

    // $keyFile = "/home/care/www_dev/dbd/ditp.key";
    // $caFile = "/home/care/www_dev/dbd/ditp.ca";
    // $certFile = "/home/care/www_dev/dbd/ditp.crt";
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
    
     // pr($output);
     // exit();
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

      if (!empty($array['ns0getDataResponse']['return'])) {

        //        echo "<pre>" ;
        //        print_r($array['ns0getDataResponse']['return']);
        //         echo "</pre>" ;
        //  die();

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
      }
$AMPUR = (empty($da['AddressDetail']['JURISTICAMPUR'])) ? '' : trim($da['AddressDetail']['JURISTICAMPUR']);
$TUMBOL = (empty($da['AddressDetail']['JURISTICTUMBOL'])) ? '' : trim($da['AddressDetail']['JURISTICTUMBOL']);
$sql = "SELECT dropdown_districts.*,dropdown_districts.id AS district_id, dropdown_districts.name_th AS district_name_th,T1.*,T2.*  FROM `dropdown_districts` 
            LEFT JOIN (SELECT name_th AS amphure_name_th, name_en AS amphure_name_en, id AS amphure_id,province_id FROM dropdown_amphures) T1 ON T1.amphure_id = dropdown_districts.amphure_id
            LEFT JOIN (SELECT name_th AS province_name_th, name_en AS province_name_en, id AS province_id FROM dropdown_provinces) T2 ON T2.province_id = T1.province_id
            WHERE dropdown_districts.`name_th` LIKE '%$TUMBOL%' and amphure_name_th  LIKE '%$AMPUR%'";
    $result = $this->query($sql);
      //  echo "<pre>" ;
      //    print_r();
      //    echo "</pre>" ;
      //    exit;
      $return = [
        'company_name' => (empty($da['etc']['JURISTICNAME'])) ? '' : trim($da['etc']['JURISTICNAME']),
        'company_nameen' => (empty($da['etc']['JURISTICNAMEENG'])) ? '' : trim($da['etc']['JURISTICNAMEENG']),
        'company_address' => (empty($da['AddressDetail']['FULLADDRESS'])) ? '' : trim($da['AddressDetail']['FULLADDRESS']),
        'company_province' => (empty($da['AddressDetail']['JURISTICPROVINCE'])) ? '' : trim($da['AddressDetail']['JURISTICPROVINCE']),
        'company_district' => (empty($da['AddressDetail']['JURISTICAMPUR'])) ? '' : trim($da['AddressDetail']['JURISTICAMPUR']),
        'company_subdistrict' => (empty($da['AddressDetail']['JURISTICTUMBOL'])) ? '' : trim($da['AddressDetail']['JURISTICTUMBOL']),
        'company_postcode'=> (empty($result[0]['zip_code'])) ? '' : trim($result[0]['zip_code'])
      ];
      
    }
    // if (empty($header)) {

    // }

    return $return;
  }

  function get_position_model(){
    $sql = "SELECT * FROM position";
    $result = $this->query($sql);
    if(count($result) > 0) return $result;
  }

  function get_provinces_model(){
    // $sql = "SELECT * FROM dropdown_provinces";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT * FROM dropdown_provinces");
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
      $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
    }

    $rows['lang'] = empty($_SESSION['lang'])?'th':$_SESSION['lang'];
    if(count($rows) > 0) return $rows;
  }
  function get_provinces_modeltest(){
    $stmt = $this->db->prepare("SELECT * FROM dropdown_provinces");
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
      $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
    }

    if(count($rows) > 0) return $rows;
  }
  function get_districts_modeltest(){
    // $sql = "SELECT * FROM dropdown_amphures";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT * FROM dropdown_amphures");
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
      $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
    }
    if(count($rows) > 0) return $rows;
  }
  function get_amphures_modeltest(){
    // $sql = "SELECT * FROM dropdown_districts";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT * FROM dropdown_districts");
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
      $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
    }
    if(count($rows) > 0) return $rows;
  }
  function get_amphures_model(){
    $id = $this->post('id');
    // $sql = "SELECT * FROM dropdown_amphures WHERE province_id ='".mysqli_real_escape_string($this->db, $id)."'";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT * FROM dropdown_amphures WHERE province_id =  ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
      $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
    }
    $rows['lang'] = empty($_SESSION['lang'])?'th':$_SESSION['lang'];
    if(count($rows) > 0) return $rows;
  }

  function get_districts_model(){
    $id = $this->post('id');
    // $sql = "SELECT * FROM dropdown_districts WHERE amphure_id ='".mysqli_real_escape_string($this->db, $id)."'";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT * FROM dropdown_districts WHERE amphure_id =  ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
      $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
    }
    $rows['lang'] = empty($_SESSION['lang'])?'th':$_SESSION['lang'];
    if(count($rows) > 0) return $rows;
  }

  function get_country_model(){
    $id = $this->post('coutry');
    // $sql = "SELECT `CountryNameEN` FROM `tb_country` ";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT `CountryNameEN` FROM tb_country");
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
      $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
    }
    if(count($rows) > 0) return $rows;
  }

  function get_zipcode_model(){
    $id = $this->post('id');
    // $sql = "SELECT * FROM dropdown_districts WHERE id ='".mysqli_real_escape_string($this->db, $id)."'";
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT `dropdown_districts` WHERE id =  ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
      $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
    }
    if(count($rows) > 0) return $rows;
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

  /*function login_connect($data = []){
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
  }*/

  function model_login_after_reg(){
    $email = $this->post('email');
    $password = $this->post('pass');

    $data_login_care = [
      'email' => $email,
      'password' => $password
    ];
    $res_care = json_decode($this->login_care($data_login_care), TRUE);
    
    if($res_care['res_code'] == '00'){
      $data_insert_token_external = [
        'member_id' => $_SESSION['tb_member_id'],
        'member_id_app' => $res_care['res_result']['member_id'],
        'token_code' => $res_care['res_result']['member_api_key'],
        'member_type' => 'CARE',
      ];
      $insert_token_external = $this->insert('tb_token_external', $data_insert_token_external);
    }
    unset($_SESSION['tb_member_id']);
    return true;
  }

  function get_address_from_zipcode_model(){
    $postcode = mysqli_real_escape_string($this->db, $this->post('postcode'));

    if($postcode == '' || $postcode == '0' || (strlen($postcode) < 2)){
      $return = [
        'res_code' => '01',
        'res_text' => 'ไม่พบข้อมูล',
      ];
      return $return;
    }

    // $sql = "SELECT dropdown_districts.*,dropdown_districts.id AS district_id, dropdown_districts.name_th AS district_name_th,T1.*,T2.*  FROM `dropdown_districts` 
    //         LEFT JOIN (SELECT name_th AS amphure_name_th, name_en AS amphure_name_en, id AS amphure_id,province_id FROM dropdown_amphures) T1 ON T1.amphure_id = dropdown_districts.amphure_id
    //         LEFT JOIN (SELECT name_th AS province_name_th, name_en AS province_name_en, id AS province_id FROM dropdown_provinces) T2 ON T2.province_id = T1.province_id
    //         WHERE dropdown_districts.zip_code LIKE '%$postcode%'";
    // // print_r($sql); 
    // $result = $this->query($sql);
    $stmt = $this->db->prepare("SELECT dropdown_districts.*,dropdown_districts.id AS district_id, dropdown_districts.name_th AS district_name_th,T1.*,T2.*  FROM `dropdown_districts` 
                                LEFT JOIN (SELECT name_th AS amphure_name_th, name_en AS amphure_name_en, id AS amphure_id,province_id FROM dropdown_amphures) T1 ON T1.amphure_id = dropdown_districts.amphure_id
                                LEFT JOIN (SELECT name_th AS province_name_th, name_en AS province_name_en, id AS province_id FROM dropdown_provinces) T2 ON T2.province_id = T1.province_id
                                WHERE dropdown_districts.zip_code LIKE  ?");
    $stmt->bind_param("s", $postcode);
    $stmt->execute();
    $results = $stmt->get_result();
    while ($row = $results->fetch_assoc()) {
      $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
    }
    $return = [
      'res_code' => '01',
      'res_text' => 'ไม่พบข้อมูล',
    ];

    if(count($rows) > 0){
      $return = [
        'res_code' => '00',
        'res_text' => 'Success',
        'res_result' => $rows
      ];
    }
    return $return;
  }

  function get_address_from_zipcode_district_model(){
    $postcode = mysqli_real_escape_string($this->db, $this->post('postcode'));
    $district = mysqli_real_escape_string($this->db, $this->post('district'));
    $subdistrict = mysqli_real_escape_string($this->db, $this->post('subdistrict'));
    if($postcode == '' || $postcode == '0' || (strlen($postcode) < 2)){
      $return = [
        'res_code' => '01',
        'res_text' => 'ไม่พบข้อมูลรหัสไปรษณีย์',
      ];
      return $return;
    }

    $sql = "SELECT dropdown_districts.*,dropdown_districts.id AS district_id, dropdown_districts.name_th AS district_name_th,T1.*,T2.*  FROM `dropdown_districts` 
            LEFT JOIN (SELECT name_th AS amphure_name_th, name_en AS amphure_name_en, id AS amphure_id,province_id FROM dropdown_amphures) T1 ON T1.amphure_id = dropdown_districts.amphure_id
            LEFT JOIN (SELECT name_th AS province_name_th, name_en AS province_name_en, id AS province_id FROM dropdown_provinces) T2 ON T2.province_id = T1.province_id
            WHERE dropdown_districts.zip_code LIKE '%$postcode%' AND dropdown_districts.name_th LIKE '%$subdistrict%' AND T1.amphure_name_th LIKE '%$district%' ";

    $result = $this->query($sql);
    $return = [
      'res_code' => '01',
      'res_text' => 'ไม่พบข้อมูล',
    ];

    if(count($result) > 0){
      $return = [
        'res_code' => '00',
        'res_text' => 'Success',
        'res_result' => $result
      ];
    }

    return $return;
  }

  function ck_member_model(){
   $cid =  $_POST['cid'];
   $rows = [];
    // $sql = "SELECT * FROM `tb_member` WHERE cid = '$cid'";
    // $rows = $this->query($sql);
    $stmt = $this->db->prepare("SELECT * FROM `tb_member` WHERE cid  =  ?");
    $stmt->bind_param("s", $cid);
    $stmt->execute();
    $results = $stmt->get_result();
    if(!empty($results)){
      while ($row = $results->fetch_assoc()) {
        $rows[] = $row; // เพิ่มแถวในอาร์เรย์ $rows
      }
    }
    return $rows;
  }

  function model_send_mail_verify(){
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
        'redirect_uri' => empty($_SESSION['redirect_uri'])?BASE_URL.'portal/ck_portal':$_SESSION['redirect_uri'],
        'response_type' => empty($_SESSION['response_type'])?'token':$_SESSION['response_type'],
        'client_id' => empty($_SESSION['client_id'])?'SS8663835':$_SESSION['client_id'],
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
      // $mail->SMTPSecure = "tlsv1.2";
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
      $mail->Host = "in-v3.mailjet.com";
      $mail->Port = 587;
      $mail->isHTML();
      $mail->CharSet = "utf-8";
      $mail->Username = USERNAME_Mailjet;
      $mail->Password = PASSWORD_Mailjet;
      
      $mail->From = ('sso@ditp.go.th');
      $mail->FromName = "DITP Single Sign-on";
      $mail->Subject = "การยืนยันตัวตนผ่านระบบ DITP SSO ของกรมส่งเสริมการค้าระหว่างประเทศ";

      $state = ($_SESSION['state'])?$_SESSION['state']:"email";

      $url = $this->path_web."register/verify_email?q=".$token_verify."&ref=".$ref_code."&redirect_uri=".$_SESSION['redirect_uri']."&response_type=".$_SESSION['response_type']."&client_id=".$_SESSION['client_id']."&state=".$state;
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
      $mail->Body .= '<h4 class="t-main1" style="color: #39414F!important;">การยืนยันตัวตนผ่านระบบ DITP SSO ของกรมส่งเสริมการค้าระหว่างประเทศ</h4>';
      $mail->Body .= '<p class="t-main1" style="color: #39414F!important;">รหัสอ้างอิง : '.$ref_code.'</p>';
      $mail->Body .= '<p class="t-main1" style="color: #39414F!important;">กรุณากดปุ่มเพื่อยืนยัน</p>';
      $mail->Body .= '<div style="display:grid;text-align:center;">';
      $mail->Body .= '<a style="font-weight: 400;line-height: 1.5;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;border: 1px solid transparent;font-size: 1rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;background-color: #2D6DC4;border-radius: 8px;color: white;display: inline-flex;justify-content: center;padding: 8px 15px;margin: 0 auto;"';
      $mail->Body .= 'href="'.$url.'">ยืนยัน (Confirmed)</a>';
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
          $Send = $mail->Send();
        if ($Send){
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

  function model_send_sms_verify(){
    
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

  function model_verify_sms(){
    
    $token = $this->post('token_verify');
    $target = $this->post('target');
    $otp = $this->post('otp_digit_1') . $this->post('otp_digit_2') . $this->post('otp_digit_3') . $this->post('otp_digit_4') . $this->post('otp_digit_5') . $this->post('otp_digit_6');

    $tel = $this->post('tel');
    $member_id = $this->post('member_id');
    
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ",
      "member_id" => $member_id,
      "tel" => $tel,
      "target" => $target,
    ];
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
        $this->update('tb_member', ['status_sms_verify'=>'1', 'sms_verify_at' => date('Y-m-d H:i:s')], "member_id ='{$member_id}'");
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

  function model_ck_token($q = '', $ref = '', $redirect_uri = '', $response_type = '', $client_id = '', $state = ''){
    $token_verify = mysqli_real_escape_string($this->db, $q);
    $ref_code = mysqli_real_escape_string($this->db, $ref);

    $_SESSION['client_id'] = mysqli_real_escape_string($this->db, $client_id);
    $_SESSION['redirect_uri'] = mysqli_real_escape_string($this->db, $redirect_uri);
    $_SESSION['response_type'] = mysqli_real_escape_string($this->db, $response_type);
    $_SESSION['state'] = mysqli_real_escape_string($this->db, $state);

    $sql = "SELECT * FROM tb_token_verify WHERE token_verify = '$token_verify' AND ref_code = '$ref_code'";
    $data = $this->query($sql);
    $return = [];
    if (count($data) > 0) {
      $result = $data[0];
      $email = $this->model_email_verify_by_member_id($result['member_id']);
      if ($result['exp_date'] > date('Y-m-d H:i:s')) {
        if ($result['ref_code'] == $ref_code) {
          if ($result['status'] == '1'){
            $return = [
              'res_code' => '01',
              'res_text' => 'ขออภัยลิงก์นี้ถูกใช้งานแล้ว',
              'res_result' => [
                'member_id' => $email['result'][0]['member_id'],
                'email' => $email['result'][0]['email'],
                'target' => $result['result'][0]['target'],
              ]
            ];
          }else{
            $this->update('tb_token_verify', ['status'=>'1'], "member_id ='{$result['member_id']}'");
            $this->update('tb_member', ['status_email_verify'=>'1', 'email_verify_at' => date('Y-m-d H:i:s')], "member_id ='{$result['member_id']}'");
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
              'target' => $result['result'][0]['target'],
            ]
          ];
        }
      }else{
        $return = [
          'res_code' => '01',
          'res_text' => 'ลิงก์หมดอายุ กรุณาทำรายการใน 15 นาที',
          'res_result' => [
            'member_id' => $email['result'][0]['member_id'],
            'email' => $email['result'][0]['email'],
            'target' => $result['result'][0]['target'],
          ]
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

  function testinsert() {

    $data_insert_member = [
      'cid' => '123123123123',
      'password' => sha1('test'),
      'type' => 1,
      'status_contact_nationality' => 1,
      'status_laser_verify' => 1,
      'status' => '1'
    ];
    
    $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
    $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
    $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
    // pr($max_id);
    // die();
    $ck_mem = $this->insert('tb_member', $data_insert_member);
    
  }
}
