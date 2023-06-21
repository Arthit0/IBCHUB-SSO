<?php

/**
 *
 */
class Model extends Controller
{
  private $f_insert, $v_insert;
  private $f_update, $v_update;
  public $db;
  public $lang;
  public $config;
  public $token_drive = "46c6f9c9-b624-4ce4-969b-8c56e136314c";
  public $path_web = BASE_URL;//"https://sso-uat.ditp.go.th/sso/";
  function __construct()
  {
    $this->config = new Config();
    // $this->db = new db();
    $this->db = $this->connect();
  }
  function connect()
  {
    // Connecting to mysql database
    $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $this->conn->query("SET NAMES utf8");
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
//      echo "-System Fail-"; 
#exit();
}

    // returing connection resource
    return $this->conn;
  }
  /*** ค่า INSERT DB ***/
  function insert($table, $param, $get_query = 0)
  {

    if (empty($table) && (empty($this->f_insert) || empty($param))) {
      return false;
    }

    $fields = "";
    $values = "";
    $values_ = "";
    $i = 1;
    if (count($param) > 0) {
      foreach ($param as $key => $val) {
        if ($i != 1) {
          $fields .= ", ";
          $values .= ", ";
          $values_ .= ", ";
        }
        $fields .= "$key";
        $values .= "'" . mysqli_real_escape_string($this->db, trim($val)) . "'";
        $values_ .= "?";
        $i++;
      }
    }

    if (!empty($this->f_insert) && count($this->f_insert) > 0) {
      foreach ($this->f_insert as $key => $val) {
        if ($i != 1) {
          $fields .= ", ";
          $values .= ", ";
          $values_ .= ", ";
        }
        $fields .= "$val";
        $values .=  $this->v_insert[$key];
        $values_ .= "?";
        $i++;
      }
      $this->f_insert = [];
      $this->v_insert = [];
    }

    $sql = "INSERT INTO " . $table . " ($fields) VALUES ($values) ";
    if ($get_query == 1) {
      return $sql;
    }

    $query = $this->db->query($sql);

    if ($query) {
      // $lastid = $this->query("SELECT LAST_INSERT_ID();");

      $lastid = $this->db->insert_id;

      return $lastid;
    } else {
      if ($get_query == 2) {
        return $sql;
      } else {
        return false;
      }
    }
  }

  function set_insert($fields = '', $values = '')
  {
    $this->f_insert[] = $fields;
    $this->v_insert[] = $values;
  }
  function set_update($fields = '', $values = '')
  {
    $this->f_update[] = $fields;
    $this->v_update[] = $values;
  }


  /*** ค่า UPDATE DB ***/
  function update($table, $param, $where, $get_sql = 0)
  {
    $set = "";
    $i = 1;
    if (isset($param) && count($param) > 0) {
      foreach ($param as $key => $value) {
        $set .= "$key = " . "'" . mysqli_real_escape_string($this->db, trim($value)) . "'";
        if ($i < count($param)) {
          $set .= ',';
        }
        $i++;
      }
    }
    if (!empty($this->f_update) && count($this->f_update) > 0) {
      foreach ($this->f_update as $key => $val) {
        $value = $this->v_update[$key];
        if (is_null($value) && $value !== 0 && $value !== '0') {
          $value = "NULL";
        }
        if ($i > 1) {
          $set .= ',';
        }
        $set .= "$val =  $value ";

        $i++;
      }
      $this->f_update = [];
      $this->v_update = [];
    }
    $sql = " UPDATE " . $table . " SET $set WHERE " . $where . " ;";
    if ($get_sql == 1) {
      return $sql;
    }
    $query = $this->db->query($sql);
    if ($get_sql == 3) {
      return $sql;
    }
    if ($query) {

      return true;
    } else {
      if ($get_sql == 2) {
        return $sql;
      } else {
        return false;
      }
    }
  }

  function query($sql = '')
  {

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();


    $return = [];
    if ($result->num_rows) {
      while ($res = $result->fetch_assoc()) {
        $return[] = $res;
      }
    }
    $stmt->close();
    return $return;
  }

  function check_mail($member_email = ''){
    $sql_ckmail1 = 'SELECT 1 FROM tb_member_type1 WHERE member_email ="' . $member_email . '"';
    $sql_ckmail2 = 'SELECT 1 FROM tb_member_type2 WHERE email ="' . $member_email . '"';
    $sql_ckmail3 = 'SELECT 1 FROM tb_member_type3 WHERE email ="' . $member_email . '"';
    $sql_ckmail4 = 'SELECT 1 FROM tb_member_type4 WHERE email ="' . $member_email . '"';
    $sql_ckmail5 = 'SELECT 1 FROM tb_member_type5 WHERE email ="' . $member_email . '"';
    $sql_ckmail6 = 'SELECT 1 FROM Member_drive_v3 WHERE Mail ="' . $member_email . '"';
    //$sql_ckmail7 = 'SELECT 1 FROM Member WHERE member_email ="' . $member_email . '"';
    $sql_ckmail7 = 'SELECT 1 FROM Member_v2 WHERE member_email ="' . $member_email . '"';

    $ck_mail1 = $this->query($sql_ckmail1);
    $ck_mail2 = $this->query($sql_ckmail2);
    $ck_mail3 = $this->query($sql_ckmail3);
    $ck_mail4 = $this->query($sql_ckmail4);
    $ck_mail5 = $this->query($sql_ckmail5);
    $ck_mail6 = $this->query($sql_ckmail6);
    $ck_mail7 = $this->query($sql_ckmail7);

    if (!empty($ck_mail1) || !empty($ck_mail2) || !empty($ck_mail3) || !empty($ck_mail4) || !empty($ck_mail5) || !empty($ck_mail6) || $ck_mail7) {
      return false;
    }else{
      return true;
    }
  }

  function validate_email($email = ''){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return false;
    }else{
      return true;
    }
  }

  function check_log_table($table = ''){
    $sql = "SHOW TABLES LIKE '$table'";
    $result = $this->query($sql);
    if(count($result) == 0){
      return true; //ยังไม่มี
    }else{
      return false; //มีแล้ว
    }
  }
  
  function create_log_table($table = ''){
    $sql = "CREATE TABLE `$table` (
                          `log_id` int(11) NOT NULL AUTO_INCREMENT,
                          `mc_id` varchar(20) NOT NULL,
                          `url` varchar(300) NOT NULL,
                          `param` text NOT NULL,
                          `ip_address` varchar(100) NOT NULL,
                          `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          PRIMARY KEY (`log_id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result){
      return true; //สำเร็จ
    }else{
      return false; //ไม่สำเร็จ
    }
  }

  function get_mc_id($client_id = ''){
    $client = mysqli_real_escape_string($this->db, $client_id);
    $sql = "SELECT * FROM tb_merchant WHERE client_id = '$client_id'";
    $result = $this->query($sql);
    if(count($result) == 0){
      return false;
    }else{
      return $result[0]['mc_id'];
    }
  }

  function save_log_call_api($param = '', $client_id = ''){
    $mc_id = $this->get_mc_id($client_id);
    $table = "log_call_api_".date('Y_m_d');
    $ck_table = $this->check_log_table($table);
    
    if($ck_table){
      $create = $this->create_log_table($table);
    }

    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $ip = $this->get_client_ip();

    $data_insert = [
      'mc_id' => $mc_id,
      'url' => $url,
      'param' => $param,
      'ip_address' => $ip,
    ];
    $insert = $this->insert($table, $data_insert);
    // if($insert){
    //   return true;
    // }else{
    //   return false;
    // }
  }

  function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }

  function update_member_touch($member_id, $type, $data = []){

    $sql_get_touch = "SELECT * FROM tb_token_external WHERE member_id = '$member_id' AND member_type = 'TOUCH'";
    $result_get_touch = $this->query($sql_get_touch);
    $token_touch = $result_get_touch[0]['token_code'];

    if($type == 'person'){
      $data_update = [
        'token' => $token_touch,
        'basic[firstname]' => $data['firstname'],
        'basic[lastname]' => $data['lastname'],
        'basic[mobile]' => $data['mobile'],
      ];
    }else if($type == 'corporateTh'){
      $data_update = [
        'token' => $token_touch,
        'basic[company_name]' => $data['company_name'],
        'basic[company_address]' => $data['company_address'],
        'basic[company_postcode]' => $data['company_postcode'],
      ];
    }else if($type == 'corporateEn'){
      $data_update = [
        'token' => $token_touch,
        'basic[company_name]' => $data['company_name'],
        'basic[company_address]' => $data['company_address'],
      ];
    }

    if(isset($data_update)){
      $curl = curl_init();
      curl_setopt_array($curl, array(
        //CURLOPT_URL => 'https://api.ditptouch.rgb72.dev/v1/member/profile',
        CURLOPT_URL => 'https://api.ditptouch.com/v1/member/profile',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data_update
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      return $response;
    }

  }
}
