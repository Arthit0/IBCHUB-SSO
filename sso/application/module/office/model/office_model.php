<?php
require APPPATH.'/library/PHPMailer_v5.0.2/class.phpmailer.php';
use \Firebase\JWT\JWT;

class office_model extends Model
{

  function __construct()
  {
    parent::__construct();
  }

  function random_char($max) {
    unset($pass,$i);
    $salt = "abchefghjkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    srand((double)microtime()*1000000);
    while ($i++ < $max)
      $pass .= substr($salt, rand() % strlen($salt), 1);
    return $pass;
  }

  function ck_login()
  {

    $return = ["status" => "01", "message" => "Not Found!"];

    $username = mysqli_real_escape_string($this->db, $this->post('username'));
    $password = $this->post('password');
 
    if(empty($username)){
      $return = ["status" => "01", "message" => "กรุณากรอก  Username"];
       return $return;
    }
    if(empty($password)){
      $return = ["status" => "01", "message" => "กรุณากรอก  Password"];
      return $return;
    }
    $stmt = $this->db->prepare("SELECT * FROM tb_admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    $num = $result->num_rows;

    if ($num > 0) {
      $read = $result->fetch_assoc();

      if (password_verify($password, $read['password'])) {
        $_SESSION['id_admin'] = $read['id_admin'];
        $_SESSION['name_admin'] = $read['name_admin'];
        $login_date = date('Y-m-d H:i:s');
        $create_date = date('Y-m-d H:i:s');
        $name = $read['name_admin'];
        $data = [
          'name_admin' => $name,
          'login_date' => $login_date,
          'create_date' => $create_date
        ];
        $this->insert('log_admin', $data);
        $return = ["status" => "00", "message" => "Success!"];
      }
    }else{
      $return = ["status" => "01", "message" => "รหัสผ่านของคุณไม่ถูกต้อง"];
    }
    return $return;
  }


  function model_data_table($type)
  {

        // $type = $this->get('type');
        $status = $this->get('status');
        $verify = $this->get('verify');
        $director = $this->get('director');
        $text_search = $this->get('text_search');
        $sort = $this->get('sort');
        $order = $this->get('order');
        $andnew = " WHERE ";
        // $and = " ";
        // var_dump($status ,
        // $verify ,
        // $director ,
        // $text_search ,
        // $sort ,
        // $order );
        // die;
        $where = "";
        $limit = $this->get('limit');
        $offset = $this->get('offset');
        $range = " LIMIT $limit OFFSET $offset";
        $groupby = " GROUP BY tb_member.cid";
        // $orderby = " ORDER BY tb_member.create_date DESC";
      if($sort ==  "td1"){
        $orderby = " ORDER BY tb_member.cid ".$order;
      }else if($sort == "td2"){
        $orderby = " ORDER BY type".$type.".company_nameTh ".$order;
      }else if($sort == "td3"){
        $orderby = " ORDER BY type".$type.".member_nameTh ".$order;
      }else if($sort == "td4"){
        $orderby = " ORDER BY type".$type.".director_status ".$order;
      }else if($sort == "td5"){
        $orderby = ($type == "1")? " ORDER BY type".$type.".status_case ".$order : " ORDER BY  tb_member.status_laser_verify ".$order ." ,tb_member.status_email_verify ".$order ." ,tb_member.status_sms_verify ".$order;
      }else if($sort == "td6"){
        $orderby = " ORDER BY tb_member.create_date ".$order;
      }else if($sort == "td7"){
        $orderby = " ORDER BY token ".$order;
      }else if($status == '0'){
        $orderby = " ORDER BY token ASC";
      }else if($status == '1'){
        $orderby = " ORDER BY token DESC";
      }else{
        $orderby = " ORDER BY tb_member.create_date DESC";
      }
    
    if ($type == "1") {
      $andnew .= " type = '$type'";
      $where = "type1.member_nameTh AS t1_member_nameTh,type1.member_midnameTh AS t1_member_midnameTh,type1.member_lastnameTh AS t1_member_lastnameTh,type1.member_nameEn AS t1_member_nameEn,type1.member_midnameEn AS t1_member_midnameEn,type1.member_lastnameEn AS t1_member_lastnameEn,type1.company_nameTh AS t1_company_nameTh ,type1.director_status,type1.status_case,type1.member_title AS t1_member_title";
      $JOIN = "LEFT JOIN tb_member_type1 AS type1 ON tb_member.member_id = type1.member_id ";
    }else if ($type == "2") {
      $andnew .= " type = '$type'";//member_midnameTh
      $where = "type2.member_nameEn AS t2_member_nameEn,type2.member_midnameEn AS t2_member_midnameEn,type2.member_lastnameEn AS t2_member_lastnameEn,type2.corporate_name AS t2_corporate_name,type2.member_title AS t2_member_title";
      $JOIN = "LEFT JOIN tb_member_type2 AS type2 ON tb_member.member_id = type2.member_id";
    }else if ($type == "3") {
      $andnew .= " type = '$type'";
      $where = "type3.member_nameTh AS t3_member_nameTh,type3.member_midnameTh AS t3_member_midnameTh,type3.member_lastnameTh AS t3_member_lastnameTh,type3.member_title AS t3_member_title";
      $JOIN = "LEFT JOIN tb_member_type3 AS type3 ON tb_member.member_id = type3.member_id";
    }else if ($type == "4") {
      $andnew .= " type = '$type'";
      $where = "type4.member_nameEn AS t4_member_nameEn, type4.member_midnameEn AS t4_member_midnameEn,type4.member_lastnameEn AS t4_member_lastnameEn,type4.member_title AS t4_member_title";
      $JOIN = "LEFT JOIN tb_member_type4 AS type4 ON tb_member.member_id = type4.member_id";
    }else if ($type == "5") {
      $andnew .= " type = '$type'";
      $where = "type5.member_nameTh AS t5_member_nameTh,type5.member_midnameTh AS t5_member_midnameTh,type5.member_lastnameTh AS t5_member_lastnameTh";
      $JOIN = "LEFT JOIN tb_member_type5 AS type5 ON tb_member.member_id = type5.member_id";
    }else if ($type == "6") {
      $andnew .= " type = '$type'";
      $where = "type6.member_nameTh AS t6_member_nameTh,type6.member_midnameTh AS t6_member_midnameTh ,type6.member_lastnameTh AS t6_member_lastnameTh ,type6.company_nameTh AS t6_company_nameTh,type6.member_title AS t6_member_title";
      $JOIN = "LEFT JOIN tb_member_type6 AS type6 ON tb_member.member_id = type6.member_id";
    }else {
      $where = "type1.member_nameTh AS t1_member_nameTh,type1.member_lastnameTh AS t1_member_lastnameTh,type1.member_lastnameTh AS t1_member_lastnameTh,type1.company_nameTh AS t1_company_nameTh ,type1.director_status,type1.status_case,type1.member_title AS t1_member_title";
      $JOIN = "LEFT JOIN tb_member_type1 AS type1 ON tb_member.member_id = type1.member_id";
    }
    
    // if ($status != "") {
    //   $andnew .= " AND token = '$status'";
    // }

    if ($verify != "") {
      if($type == '1'){
        switch ($verify) {
          case '99':
            $verify = "(99)";
            break;
          case '2':
            $verify = "(2)";
            break;
          case '3':
            $verify = "(3)";
            break;
          case '4':
            $verify = "(1)";
            break;
          case '5':
            $verify = "(4,5)";
            break;
          default:
            $verify = "(0)";
            break;
        }
        $table = "type1.status_case IN $verify";
      }else{
        switch ($verify) {
          case '1':
            $verify = 1;
            break;
          default:
            $verify = 0;
            break;
        }
        $table = "(tb_member.status_laser_verify = '$verify' OR status_email_verify = '$verify' OR status_sms_verify = '$verify')";
      }
      $andnew .= " AND ".$table;
    }
    if ($director != "") {
      switch ($director) {
        case '1':
          $name_type = "กรรมการ";
          break;
        case '2':
          $name_type = "ผู้รับมอบอำนาจ";
          break;
        default:
          $name_type = "ผู้รับมอบอำนาจ";
          break;
      }
      $andnew .= " AND type1.director_status = '$director'";
    }
    if ($text_search != "") {
          switch ($type) {
            case '1':
              $andnew .= " AND (tb_member.cid LIKE '%$text_search%' 
                    OR type1.member_email LIKE '%$text_search%'
                    OR type1.company_nameTh LIKE '%$text_search%'
                    OR type1.company_nameEn LIKE '%$text_search%'
                    OR type1.member_nameTh LIKE '%$text_search%'
                    OR type1.member_midnameTh LIKE '%$text_search%'
                    OR type1.member_lastnameTh LIKE '%$text_search%'
                    OR type1.member_nameEn LIKE '%$text_search%'
                    OR type1.member_midnameEn LIKE '%$text_search%'
                    OR type1.member_lastnameEn LIKE '%$text_search%'
                    OR type1.member_tel LIKE '%$text_search%'
                  ) ";
              break;
            case '2':
              $andnew .= " AND (tb_member.cid LIKE '%$text_search%' 
                    OR type2.email LIKE '%$text_search%'
                    OR type2.corporate_name LIKE '%$text_search%'
                    OR type2.member_nameTh LIKE '%$text_search%'
                    OR type2.member_lastnameTh LIKE '%$text_search%'
                    OR type2.member_nameEn LIKE '%$text_search%'
                    OR type2.member_lastnameEn LIKE '%$text_search%'
                    OR type2.tel LIKE '%$text_search%'
                  ) ";
              break;
            case '3':
              $andnew .= " AND (tb_member.cid LIKE '%$text_search%' 
                    OR type3.email LIKE '%$text_search%'
                    OR type3.member_nameTh LIKE '%$text_search%'
                    OR type3.member_lastnameTh LIKE '%$text_search%'
                    OR type3.member_nameEn LIKE '%$text_search%'
                    OR type3.member_lastnameEn LIKE '%$text_search%'
                    OR type3.tel LIKE '%$text_search%'
                  ) ";
              break;
            case '4':
              $andnew .= " AND (tb_member.cid LIKE '%$text_search%' 
                    OR type4.email LIKE '%$text_search%'
                    OR type4.member_nameTh LIKE '%$text_search%'
                    OR type4.member_lastnameTh LIKE '%$text_search%'
                    OR type4.member_nameEn LIKE '%$text_search%'
                    OR type4.member_lastnameEn LIKE '%$text_search%'
                    OR type4.tel LIKE '%$text_search%'
                  ) ";
              break;
            case '5':
              $andnew .= " AND (tb_member.cid LIKE '%$text_search%' 
                    OR type5.email LIKE '%$text_search%'
                    OR type5.member_nameTh LIKE '%$text_search%'
                    OR type5.member_lastnameTh LIKE '%$text_search%'
                    OR type5.tel LIKE '%$text_search%'
                  ) ";
              break;
            case '6':
              $andnew .= " AND (tb_member.cid LIKE '%$text_search%' 
                      OR type6.member_email LIKE '%$text_search%'
                      OR type6.company_nameTh LIKE '%$text_search%'
                      OR type6.company_nameEn LIKE '%$text_search%'
                      OR type6.member_nameTh LIKE '%$text_search%'
                      OR type6.member_lastnameTh LIKE '%$text_search%'
                      OR type6.member_nameEn LIKE '%$text_search%'
                      OR type6.member_lastnameEn LIKE '%$text_search%'
                      OR type6.member_tel LIKE '%$text_search%'
                    ) ";
              break;           
            default:
            $andnew .= " AND (tb_member.cid LIKE '%$text_search%' 
                    OR type1.member_email LIKE '%$text_search%'
                    OR type1.company_nameTh LIKE '%$text_search%'
                    OR type1.company_nameEn LIKE '%$text_search%'
                    OR type1.member_nameTh LIKE '%$text_search%'
                    OR type1.member_lastnameTh LIKE '%$text_search%'
                    OR type1.member_nameEn LIKE '%$text_search%'
                    OR type1.member_lastnameEn LIKE '%$text_search%'
                    OR type1.member_tel LIKE '%$text_search%'
                  ) ";
              break;
          }
    }
    $andnew .= " AND tb_member.status != 2";

      $sql = "SELECT DISTINCT tb_member.member_id,tb_member.*,
              IF(tb_token.create_date < DATE_SUB( CURDATE( ) , INTERVAL 3 MONTH),0,1) AS token ,
              ".$where."
              FROM tb_member 
              ".$JOIN."
              LEFT JOIN tb_token ON tb_member.member_id = tb_token.member_id";
    $sqlc = "SELECT COUNT(DISTINCT tb_member.member_id) as _count,
            IF(tb_token.create_date < DATE_SUB( CURDATE( ) , INTERVAL 3 MONTH),0,1) AS token ,
            ".$where."
            FROM tb_member 
            ".$JOIN."
            LEFT JOIN tb_token ON tb_member.member_id = tb_token.member_id";
    $sql2 = "SELECT DISTINCT tb_member.member_id,tb_member.type,IF(tb_token.create_date < DATE_SUB( CURDATE( ) , INTERVAL 3 MONTH),0,1) AS token FROM tb_member LEFT JOIN tb_token ON tb_member.member_id = tb_token.member_id";
    $sql_rows = $sql . $andnew  . $groupby . $orderby . $range ;

    // if ($text_search != "") {
      $sql_count = $sqlc . $andnew  . $groupby;
    // } else {
    //   $sql_count = $sql2 . $andnew . $groupby . $and;
    // }
    // return $sql_count;
 
    // var_dump($sql_rows);
    // die;
    $query = $this->query($sql_rows);
    // var_dump($query);
    // die;
    $sql_countt = $this->query($sql_count);
    $result = $query;
    // if ($type == 3) {
      // var_dump($query);
      // die();
    // }
    $n = 0;
    $main = array();

    
    // if(empty($result) && $director == "" && $verify == ""){
    //     $sql_rows = "SELECT DISTINCT Member_drive_v3.UserID,Member_drive_v3.Firstname,Member_drive_v3.LastName,Member_drive_v3.Username,
    //                   Member_drive_v3.Mail,Member_drive_v3.UserType,Member_drive_v3.Is_Thai FROM Member_drive_v3 WHERE 
    //                   (
    //                     Member_drive_v3.Username LIKE '%$text_search%' 
    //                     OR Member_drive_v3.Mail  LIKE '%$text_search%'
    //                     OR Member_drive_v3.Firstname  LIKE '%$text_search%'
    //                     OR Member_drive_v3.LastName LIKE '%$text_search%'
    //                     OR Member_drive_v3.Telephone LIKE '%$text_search%'
    //                   )  GROUP BY Member_drive_v3.Username HAVING 1 LIMIT 10 OFFSET 0";

    //    $query = $this->query($sql_rows);
    //    $result = $query;
    //    foreach ($result as $item) {
    //           if ($item['UserType'] == "corporate" && $item['Is_Thai'] == "Y") {
    //               $name_types = "กรรมการ";
    //               $name_type = "นิติบุคคลไทย";
    //           } else {
    //             $name_type = "-";
    //           }
    //           $url = BASE_PATH . "office/edit_member?type=old&id=" . $item['UserID'];
    //           $icon = 'fas fa-exclamation-circle';
    //           $status_name = ' ยังไม่ยืนยันตัวตน';
    //           $icon_color = '#8A919E';
    //           $n++;
    //           $td1 = ($item['Username'] == '') ? "-" : $item['Username']; //First Name
    //           $td2 = ($item['Firstname'] == '') ? "-" : $item['Firstname']; //Coporate Name
    //           $td3 =  "-";
    //           $td4 = $name_types; //ฐานะ
    //           $td6 = "-"; //Register Date
    //           $td7 = 'Inactivate';
    //           $color = '#8A919E';

    //           //$data['td1'] = $n;
    //           $data['td1'] = htmlentities($td1); //First Name
    //           $data['td2'] = htmlentities($td2); //Last Name
    //           $data['td3'] = htmlentities($td3); //Coporate Name
    //           $data['td4'] = htmlentities($td4); //Coporate ID
    //           $data['td5'] = '<div class="pl-1 icon-center-con"><i class="'.$icon.'" style="color:'.$icon_color.'"></i>&nbsp;'.htmlentities($status_name).'</div>'; //Password ID
    //           $data['td6'] = htmlentities($td6); //ID Card Number
    //           $data['td7'] = '<div class="pl-1 icon-center-con"><i class="fa fa-square" style="color:'.$color.'"></i>&nbsp;'.htmlentities($td7).'</div>'; //Password ID
    //           $data['td8'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit' style='width: 47px;height: 44px;background: #2D6DC4;border-radius: 8px;font-size: 17px;padding: 10px 14px;'><i class='fa-solid fa-magnifying-glass mr-1'></i></a>";
    //           array_push($main, $data);
    //    }
    // }else{

          foreach ($result as $item) {

            $url = BASE_PATH . "office/detail_member?id=" . $item['member_id'] . "&type=" . $item['type'];
            if ($item['type'] == 1) {
              // var_dump($item);
              //   die();
              switch ($item['director_status']) {
                case '1':
                  $name_type = "กรรมการ";
                  break;
                case '2':
                  $name_type = "ผู้รับมอบอำนาจ";
                  break;
                default:
                  $name_type = "ผู้รับมอบอำนาจ";
                  break;
              }
             
              switch ($item['status_case']) {
                case '99':
                  $icon = 'fas fa-check-circle';
                  $status_name = ' อนุมัติแล้ว';
                  $icon_color = '#0AC37D';
                  break;
                case '1':
                  $icon = 'fas fa-clock';
                  $status_name = ' รอกรรมการอนุมัติอีเมล';
                  $icon_color = '#FFC80A';
                  break;
                case '2':
                  $icon = 'fas fa-clock';
                  $status_name = ' ไม่ตรงกับรายชื่อกรรมการ';
                  $icon_color = '#FFC80A';
                  break;
                case '3':
                  $icon = 'fas fa-clock';
                  $status_name = ' รออนุมัติ';
                  $icon_color = '#FFC80A';
                  break;
                case '4':
                  $icon = 'fas fa-times-circle';
                  $status_name = ' ไม่อนุมัติ';
                  $icon_color = 'red';
                  break;
                case '5':
                  $icon = 'fas fa-times-circle';
                  $status_name = ' ไม่อนุมัติ';
                  $icon_color = 'red';
                  break;
                default:
                  $icon = 'fas fa-exclamation-circle';
                  $status_name = ' ยังไม่ยืนยันตัวตน';
                  $icon_color = '#8A919E';
                  break;
              }
              if($item['status_laser_verify'] == '1'){
                $icon_laser = 'fas fa-check-circle';
                $status_name_laser = ' Verified';
                $icon_color_laser = '#0AC37D';
              }else{
                $icon_laser = 'fas fa-exclamation-circle';
                $status_name_laser = ' Verify';
                $icon_color_laser = 'red';
              }
               if($item['status_email_verify'] == '1'){
                $icon_email = 'fas fa-check-circle';
                $status_name_email = ' Verified';
                $icon_color_email = '#0AC37D';
              }else{
                $icon_email = 'fas fa-exclamation-circle';
                $status_name_email = ' Verify';
                $icon_color_email = 'red';
              }
               if($item['status_sms_verify'] == '1'){
                $icon_sms = 'fas fa-check-circle';
                $status_name_sms = ' Verified';
                $icon_color_sms = '#0AC37D';
              }else{
                $icon_sms = 'fas fa-exclamation-circle';
                $status_name_sms = ' Verify';
                $icon_color_sms = 'red';
              }
              $n++;
              $td1 = ($item['cid'] == '') ? "-" : $item['cid']; //เลขนิติบุคคล/เลขบัตรประชาชน 
              $td2 = ($item['t1_company_nameTh'] == '') ? "-" : $item['t1_company_nameTh']; //ชื่อนิติบุคคล
              $td3 = ($item['t1_member_title'] == '') ? "" : $item['t1_member_title']; //คำนำหน้าชื่อ
              $td3 .= ($item['t1_member_nameTh'] == '') ?  " ".$item['t1_member_nameEn'] : " ".$item['t1_member_nameTh']; //ชื่อ
              $td3 .= ($item['t1_member_midnameTh'] == '') ?  " ".$item['t1_member_midnameEn'] : " ".$item['t1_member_midnameTh']; //ชื่อกลาง
              $td3 .= ($item['t1_member_lastnameTh'] == '') ?  " ".$item['t1_member_lastnameEn'] : " ".$item['t1_member_lastnameTh']; //นามสกุล
              $td4 = $name_type; //ฐานะ
              $td6 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date
                  if ($item['token'] == 1) {
                    $td7 = 'Activate';
                    $color = '#0AC37D';
                  } else {
                    $td7 = 'Inactivate';
                    $color = '#8A919E';
                  }
                    $data['td1'] = "<a href='" . htmlentities($url) . "'>".htmlentities($td1)."</a>"; //เลขนิติบุคคล/เลขบัตรประชาชน
                    $data['td2'] = htmlentities($td2); //ชื่อนิติบุคคล
                    $data['td3'] = htmlentities($td3); //ชื่อ - นามสกุล
                    $data['td4'] = htmlentities($td4); //ฐานะ
                    $data['td5'] = '<div class="pl-1 icon-center-con"><i class="'.$icon.'" style="color:'.$icon_color.'"></i>&nbsp;'.htmlentities($status_name).'</div>'; //สถานะยืนยันตัวตน
                    $data['td9'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_laser.'" style="color:'.$icon_color_laser.'"></i>&nbsp;'.htmlentities($status_name_laser).'</div>'; //ยืนยันตัวตนด้วยเลขหลังบัตร
                    $data['td10'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_email.'" style="color:'.$icon_color_email.'"></i>&nbsp;'.htmlentities($status_name_email).'</div>'; //ยืนยันตัวตนด้วยอีเมล
                    $data['td11'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_sms.'" style="color:'.$icon_color_sms.'"></i>&nbsp;'.htmlentities($status_name_sms).'</div>'; //ยืนยันตัวตนด้วยเบอร์โทร
                    $data['td6'] = htmlentities($td6); //วันที่สมัคร
                    $data['td7'] = '<div class="pl-1 icon-center-con"><i class="fa fa-square" style="color:'.$color.'"></i>&nbsp;'.htmlentities($td7).'</div>'; //สถานะการเข้าระบบ
                    $data['td8'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit' style='width: 47px;height: 44px;background: #2D6DC4;border-radius: 8px;font-size: 17px;padding: 10px 14px;'><i class='fa-solid fa-magnifying-glass mr-1'></i></a>";
                array_push($main, $data);
            } else if ($item['type'] == 2) {
              if($item['status_laser_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_email_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_sms_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else{
                $icon = 'fas fa-exclamation-circle';
                $status_name = ' ยังไม่ยืนยันตัวตน';
                $icon_color = '#8A919E';
              }

              if($item['status_laser_verify'] == '1'){
                $icon_laser = 'fas fa-check-circle';
                $status_name_laser = ' Verified';
                $icon_color_laser = '#0AC37D';
              }else{
                $icon_laser = 'fas fa-exclamation-circle';
                $status_name_laser = ' Verify';
                $icon_color_laser = 'red';
              }
               if($item['status_email_verify'] == '1'){
                $icon_email = 'fas fa-check-circle';
                $status_name_email = ' Verified';
                $icon_color_email = '#0AC37D';
              }else{
                $icon_email = 'fas fa-exclamation-circle';
                $status_name_email = ' Verify';
                $icon_color_email = 'red';
              }
               if($item['status_sms_verify'] == '1'){
                $icon_sms = 'fas fa-check-circle';
                $status_name_sms = ' Verified';
                $icon_color_sms = '#0AC37D';
              }else{
                $icon_sms = 'fas fa-exclamation-circle';
                $status_name_sms = ' Verify';
                $icon_color_sms = 'red';
              }
              $n++;
              $td1 = ($item['cid'] == '') ? "-" : $item['cid']; //cid
              $td2 = ($item['t2_corporate_name'] == '') ? "-" : $item['t2_corporate_name']; //Coporate Name
              $td3 = ($item['t2_member_title'] == '') ? "" : $item['t2_member_title']; //คำนำหน้าชื่อ
              $td3 .= ($item['t2_member_nameEn'] == '') ? "" : " ".$item['t2_member_nameEn']; //ชื่อ
              $td3 .= ($item['t2_member_midnameEn'] == '') ? "" : " ".$item['t2_member_midnameEn']; //ชื่อ
              $td3 .= ($item['t2_member_lastnameEn'] == '') ? "" : " ".$item['t2_member_lastnameEn']; //นามสกุล 
              $td6 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date
                    if ($item['token'] == 1) {
                      $td7 = 'Activate';
                      $color = '#0AC37D';
                    } else {
                      $td7 = 'Inactivate';
                      $color = '#8A919E';
                    }

                      //$data['td1'] = $n;
                      $data['td1'] = "<a href='" . htmlentities($url) . "'>".htmlentities($td1)."</a>"; //เลขนิติบุคคล/เลขบัตรประชาชน
                    // $data['td1'] = htmlentities($td1); // ID Card Number
                      $data['td2'] = htmlentities($td2); // Coporate Name
                      $data['td3'] = htmlentities($td3); // Name
                      $data['td5'] = '<div class="pl-1 icon-center-con"><i class="'.$icon.'" style="color:'.$icon_color.'"></i>&nbsp;'.htmlentities($status_name).'</div>'; //สถานะยืนยันตัวตน
                      $data['td9'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_laser.'" style="color:'.$icon_color_laser.'"></i>&nbsp;'.htmlentities($status_name_laser).'</div>'; //Password ID
                      $data['td10'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_email.'" style="color:'.$icon_color_email.'"></i>&nbsp;'.htmlentities($status_name_email).'</div>'; //Password ID
                      $data['td11'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_sms.'" style="color:'.$icon_color_sms.'"></i>&nbsp;'.htmlentities($status_name_sms).'</div>'; //Password ID
                      $data['td6'] = htmlentities($td6); // Register Date
                      $data['td7'] = '<div class="pl-1 icon-center-con"><i class="fa fa-square" style="color:'.$color.'"></i>&nbsp;'.htmlentities($td7).'</div>'; // Activate/Inactivate
                      $data['td8'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit' style='width: 47px;height: 44px;background: #2D6DC4;border-radius: 8px;font-size: 17px;padding: 10px 14px;'><i class='fa-solid fa-magnifying-glass mr-1'></i></a>";
                      array_push($main, $data);

            } else if ($item['type'] == 3) {
              //บุคคลไทย
              if($item['status_laser_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_email_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_sms_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else{
                $icon = 'fas fa-exclamation-circle';
                $status_name = ' ยังไม่ยืนยันตัวตน';
                $icon_color = '#8A919E';
              }

              if($item['status_laser_verify'] == '1'){
                $icon_laser = 'fas fa-check-circle';
                $status_name_laser = ' Verified';
                $icon_color_laser = '#0AC37D';
              }else{
                $icon_laser = 'fas fa-exclamation-circle';
                $status_name_laser = ' Verify';
                $icon_color_laser = 'red';
              }
               if($item['status_email_verify'] == '1'){
                $icon_email = 'fas fa-check-circle';
                $status_name_email = ' Verified';
                $icon_color_email = '#0AC37D';
              }else{
                $icon_email = 'fas fa-exclamation-circle';
                $status_name_email = ' Verify';
                $icon_color_email = 'red';
              }
               if($item['status_sms_verify'] == '1'){
                $icon_sms = 'fas fa-check-circle';
                $status_name_sms = ' Verified';
                $icon_color_sms = '#0AC37D';
              }else{
                $icon_sms = 'fas fa-exclamation-circle';
                $status_name_sms = ' Verify';
                $icon_color_sms = 'red';
              }
              // switch ($item['status_laser_verify']) {
              //   case '1':
              //     $icon = 'fas fa-check-circle';
              //     $status_name = ' อนุมัติแล้ว';
              //     $icon_color = '#0AC37D';
              //     break;
              //   default:
              //     $icon = 'fas fa-exclamation-circle';
              //     $status_name = ' ยังไม่ยืนยันตัวตน';
              //     $icon_color = '#8A919E';
              //     break;
              // }
              $n++;
              $td1 = ($item['cid'] == '') ? "-" : $item['cid']; //First Name
              $td3 = ($item['t3_member_title'] == '') ? "" : $item['t3_member_title']; //คำนำหน้าชื่อ
              $td3 .= ($item['t3_member_nameTh'] == '') ? "" : " ".$item['t3_member_nameTh']; //ชื่อ
              $td3 .= ($item['t3_member_midnameTh'] == '') ? "" : " ".$item['t3_member_midnameTh']; //ชื่อกลาง
              $td3 .= ($item['t3_member_lastnameTh'] == '') ? "" : " ".$item['t3_member_lastnameTh']; //นามสกุล
              $td6 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date 
              
                  if ($item['token'] == 1) {
                    $td7 = 'Activate';
                    $color = '#0AC37D';
                  } else {
                    $td7 = 'Inactivate';
                    $color = '#8A919E';
                  }
                    //$data['td1'] = $n;
                    $data['td1'] = "<a href='" . htmlentities($url) . "'>".htmlentities($td1)."</a>"; //เลขนิติบุคคล/เลขบัตรประชาชน
                    // $data['td1'] = htmlentities($td1); //ID Card Number
                    $data['td3'] = htmlentities($td3); //Name
                    $data['td5'] = '<div class="pl-1 icon-center-con"><i class="'.$icon.'" style="color:'.$icon_color.'"></i>&nbsp;'.htmlentities($status_name).'</div>'; //สถานะยืนยันตัวตน
                    $data['td9'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_laser.'" style="color:'.$icon_color_laser.'"></i>&nbsp;'.htmlentities($status_name_laser).'</div>'; //Password ID
                    $data['td10'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_email.'" style="color:'.$icon_color_email.'"></i>&nbsp;'.htmlentities($status_name_email).'</div>'; //Password ID
                    $data['td11'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_sms.'" style="color:'.$icon_color_sms.'"></i>&nbsp;'.htmlentities($status_name_sms).'</div>'; //Password ID
                    $data['td6'] = htmlentities($td6); //
                    $data['td7'] = '<div class="pl-1 icon-center-con"><i class="fa fa-square" style="color:'.$color.'"></i>&nbsp;'.htmlentities($td7).'</div>'; //วันที่สมัคร
                    $data['td8'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit' style='width: 47px;height: 44px;background: #2D6DC4;border-radius: 8px;font-size: 17px;padding: 10px 14px;'><i class='fa-solid fa-magnifying-glass mr-1'></i></a>";
                    array_push($main, $data);
              
            } else if ($item['type'] == 4) {
              //บุคคลต่างชาติ
              // var_dump($item);
              // die();
              // switch ($item['status_laser_verify']) {
              //   case '1':
              //     $icon = 'fas fa-check-circle';
              //     $status_name = ' อนุมัติแล้ว';
              //     $icon_color = '#0AC37D';
              //     break;
              //   default:
              //     $icon = 'fas fa-exclamation-circle';
              //     $status_name = ' ยังไม่ยืนยันตัวตน';
              //     $icon_color = '#8A919E';
              //     break;
              // }
             
              if($item['status_laser_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_email_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_sms_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else{
                $icon = 'fas fa-exclamation-circle';
                $status_name = ' ยังไม่ยืนยันตัวตน';
                $icon_color = '#8A919E';
              }

              if($item['status_laser_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_email_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_sms_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else{
                $icon = 'fas fa-exclamation-circle';
                $status_name = ' ยังไม่ยืนยันตัวตน';
                $icon_color = '#8A919E';
              }
              if($item['status_laser_verify'] == '1'){
                $icon_laser = 'fas fa-check-circle';
                $status_name_laser = ' Verified';
                $icon_color_laser = '#0AC37D';
              }else{
                $icon_laser = 'fas fa-exclamation-circle';
                $status_name_laser = ' Verify';
                $icon_color_laser = 'red';
              }
               if($item['status_email_verify'] == '1'){
                $icon_email = 'fas fa-check-circle';
                $status_name_email = ' Verified';
                $icon_color_email = '#0AC37D';
              }else{
                $icon_email = 'fas fa-exclamation-circle';
                $status_name_email = ' Verify';
                $icon_color_email = 'red';
              }
               if($item['status_sms_verify'] == '1'){
                $icon_sms = 'fas fa-check-circle';
                $status_name_sms = ' Verified';
                $icon_color_sms = '#0AC37D';
              }else{
                $icon_sms = 'fas fa-exclamation-circle';
                $status_name_sms = ' Verify';
                $icon_color_sms = 'red';
              }
              
              $n++;
              $td1 = ($item['cid'] == '') ? "-" : $item['cid']; //First Name
              $td3 = ($item['t4_member_title'] == '') ? "" : $item['t4_member_title']; //คำนำหน้าชื่อ
              $td3 .= ($item['t4_member_nameEn'] == '') ? "" : " ".$item['t4_member_nameEn']; //ชื่อ
              $td3 .= ($item['t4_member_midnameEn'] == '') ? "" : " ".$item['t4_member_midnameEn']; //ชื่อกลาง
              $td3 .= ($item['t4_member_lastnameEn'] == '') ? "" : " ".$item['t4_member_lastnameEn']; //นามสกุล

              $td6 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date 
                    if ($item['token'] == 1) {
                      $td7 = 'Activate';
                      $color = '#0AC37D';
                    } else {
                      $td7 = 'Inactivate';
                      $color = '#8A919E';
                    }
                      //$data['td1'] = $n;
                      $data['td1'] = "<a href='" . htmlentities($url) . "'>".htmlentities($td1)."</a>"; //เลขนิติบุคคล/เลขบัตรประชาชน
                    // $data['td1'] = htmlentities($td1); //ID Card Number
                      $data['td3'] = htmlentities($td3); //Name
                      $data['td5'] = '<div class="pl-1 icon-center-con"><i class="'.$icon.'" style="color:'.$icon_color.'"></i>&nbsp;'.htmlentities($status_name).'</div>'; //สถานะยืนยันตัวตน
                      $data['td9'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_laser.'" style="color:'.$icon_color_laser.'"></i>&nbsp;'.htmlentities($status_name_laser).'</div>'; //Password ID
                      $data['td10'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_email.'" style="color:'.$icon_color_email.'"></i>&nbsp;'.htmlentities($status_name_email).'</div>'; //Password ID
                      $data['td11'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_sms.'" style="color:'.$icon_color_sms.'"></i>&nbsp;'.htmlentities($status_name_sms).'</div>'; //Password ID
                      $data['td6'] = htmlentities($td6); //
                      $data['td7'] = '<div class="pl-1 icon-center-con"><i class="fa fa-square" style="color:'.$color.'"></i>&nbsp;'.htmlentities($td7).'</div>'; //วันที่สมัคร
                      $data['td8'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit' style='width: 47px;height: 44px;background: #2D6DC4;border-radius: 8px;font-size: 17px;padding: 10px 14px;'><i class='fa-solid fa-magnifying-glass mr-1'></i></a>";
                      array_push($main, $data);
                
            } else if ($item['type'] == 5) {
              //อื่นๆ
              if($item['status_laser_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_email_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_sms_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else{
                $icon = 'fas fa-exclamation-circle';
                $status_name = ' ยังไม่ยืนยันตัวตน';
                $icon_color = '#8A919E';
              }
              $n++;
              $td2 = ($item['t5_member_nameTh'] == '') ? "-" : $item['t5_member_nameTh']; //First Name
              $td3 = ($item['t5_member_lastnameTh'] == '') ? "-" : $item['t5_member_lastnameTh']; //Last Name
              $td4 = '-'; //Coporate Name
              $td5 = '<div class="pl-1 icon-center-con"><i class="'.$icon.'" style="color:'.$icon_color.'"></i>&nbsp;'.htmlentities($status_name).'</div>'; //สถานะยืนยันตัวตน
              $td6 = '-'; //Password ID
              $td7 = $item['cid']; //ID Card Number
              $td8 = $name_type; //Type
              $td9 = $item['cid']; //Username
              $td14 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date
                if($status != ""){
                  if ($status == $item['token'] && $status == 1) {
                    $td7 = 'Activate';
                    $color = '#0AC37D';
                    $url = BASE_PATH . "office/edit_member?id=" . $item['member_id'] . "&type=5";
                    //$data['td1'] = $n;
                    $data['td2'] = htmlentities($td2); //First Name
                    $data['td3'] = htmlentities($td3); //Last Name
                    $data['td4'] = htmlentities($td4); //Coporate Name
                    $data['td5'] = htmlentities($td5); //Coporate ID
                    $data['td6'] = htmlentities($td6); //Password ID
                    $data['td7'] = htmlentities($td7); //ID Card Number
                    $data['td8'] = htmlentities($td8); //Type
                    $data['td9'] = htmlentities($td9); //Username
                    $data['td10'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit'><i class='fa fa-pencil mr-1'></i>แก้ไขข้อมูล</a>";
                    $data['td11'] = "<a href='#' class='btn sso-btn-back edit-pass' member-id='" . $item['member_id'] . "' member-name='" . $td2 . " " . $td3 . "' data-toggle='modal' data-target='#ShowModal'> 
                                      <i class='fa fa-edit mr-1'></i>เปลี่ยนรหัสผ่าน
                                    </a>";
                    $data['td12'] = '<span style="color:' . $color . ';"> ' . htmlentities($td12) . ' </span>'; //Status
                    $data['td14'] = htmlentities($td14);
                    array_push($main, $data);
                  } else if($status == $item['token']  && $status == 0){
                    $td7 = 'Inactivate';
                    $color = '#8A919E';
                    $url = BASE_PATH . "office/edit_member?id=" . $item['member_id'] . "&type=5";
                    //$data['td1'] = $n;
                    $data['td2'] = htmlentities($td2); //First Name
                    $data['td3'] = htmlentities($td3); //Last Name
                    $data['td4'] = htmlentities($td4); //Coporate Name
                    $data['td5'] = htmlentities($td5); //Coporate ID
                    $data['td6'] = htmlentities($td6); //Password ID
                    $data['td7'] = htmlentities($td7); //ID Card Number
                    $data['td8'] = htmlentities($td8); //Type
                    $data['td9'] = htmlentities($td9); //Username
                    $data['td10'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit'><i class='fa fa-pencil mr-1'></i>แก้ไขข้อมูล</a>";
                    $data['td11'] = "<a href='#' class='btn sso-btn-back edit-pass' member-id='" . $item['member_id'] . "' member-name='" . $td2 . " " . $td3 . "' data-toggle='modal' data-target='#ShowModal'> 
                                      <i class='fa fa-edit mr-1'></i>เปลี่ยนรหัสผ่าน
                                    </a>";
                    $data['td12'] = '<span style="color:' . $color . ';"> ' . htmlentities($td12) . ' </span>'; //Status
                    $data['td14'] = htmlentities($td14);
                    array_push($main, $data);
                  }
                }else{
                  if ($item['token'] == 1) {
                    $td7 = 'Activate';
                    $color = '#0AC37D';
                  } else {
                    $td7 = 'Inactivate';
                    $color = '#8A919E';
                  }
                  $url = BASE_PATH . "office/edit_member?id=" . $item['member_id'] . "&type=5";
                  //$data['td1'] = $n;
                  $data['td2'] = htmlentities($td2); //First Name
                  $data['td3'] = htmlentities($td3); //Last Name
                  $data['td4'] = htmlentities($td4); //Coporate Name
                  $data['td5'] = htmlentities($td5); //Coporate ID
                  $data['td6'] = htmlentities($td6); //Password ID
                  $data['td7'] = htmlentities($td7); //ID Card Number
                  $data['td8'] = htmlentities($td8); //Type
                  $data['td9'] = htmlentities($td9); //Username
                  $data['td10'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit'><i class='fa fa-pencil mr-1'></i>แก้ไขข้อมูล</a>";
                  $data['td11'] = "<a href='#' class='btn sso-btn-back edit-pass' member-id='" . $item['member_id'] . "' member-name='" . $td2 . " " . $td3 . "' data-toggle='modal' data-target='#ShowModal'> 
                                    <i class='fa fa-edit mr-1'></i>เปลี่ยนรหัสผ่าน
                                  </a>";
                  $data['td12'] = '<span style="color:' . $color . ';"> ' . htmlentities($td12) . ' </span>'; //Status
                  $data['td14'] = htmlentities($td14);
                  array_push($main, $data);
              }
            } else if ($item['type'] == 6) {
              // switch ($item['status_laser_verify']) {
              //   case '1':
              //     $icon = 'fas fa-check-circle';
              //     $status_name = ' อนุมัติแล้ว';
              //     $icon_color = '#0AC37D';
              //     break;
              //   default:
              //     $icon = 'fas fa-exclamation-circle';
              //     $status_name = ' ยังไม่ยืนยันตัวตน';
              //     $icon_color = '#8A919E';
              //     break;
              // }

              if($item['status_laser_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_email_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else if($item['status_sms_verify'] == '1'){
                $icon = 'fas fa-check-circle';
                $status_name = ' อนุมัติแล้ว';
                $icon_color = '#0AC37D';
              }else{
                $icon = 'fas fa-exclamation-circle';
                $status_name = ' ยังไม่ยืนยันตัวตน';
                $icon_color = '#8A919E';
              }
              if($item['status_laser_verify'] == '1'){
                $icon_laser = 'fas fa-check-circle';
                $status_name_laser = ' Verified';
                $icon_color_laser = '#0AC37D';
              }else{
                $icon_laser = 'fas fa-exclamation-circle';
                $status_name_laser = ' Verify';
                $icon_color_laser = 'red';
              }
               if($item['status_email_verify'] == '1'){
                $icon_email = 'fas fa-check-circle';
                $status_name_email = ' Verified';
                $icon_color_email = '#0AC37D';
              }else{
                $icon_email = 'fas fa-exclamation-circle';
                $status_name_email = ' Verify';
                $icon_color_email = 'red';
              }
               if($item['status_sms_verify'] == '1'){
                $icon_sms = 'fas fa-check-circle';
                $status_name_sms = ' Verified';
                $icon_color_sms = '#0AC37D';
              }else{
                $icon_sms = 'fas fa-exclamation-circle';
                $status_name_sms = ' Verify';
                $icon_color_sms = 'red';
              }

              $n++;
              $td1 = ($item['cid'] == '') ? "-" : $item['cid']; //เลขนิติบุคคล
              $td2 = ($item['t6_company_nameTh'] == '') ? "-" : $item['t6_company_nameTh']; //ชื่อนิติบุคคล
              $td3 = ($item['t6_member_title'] == '') ? "" : $item['t6_member_title']; //คำนำหน้าชื่อ
              $td3 .= ($item['t6_member_nameTh'] == '') ? "" : " ".$item['t6_member_nameTh']; //ชื่อ
              $td3 .= ($item['t6_member_midnameEn'] == '') ? "" : " ".$item['t6_member_midnameEn']; //ชื่อ
              $td3 .= ($item['t6_member_lastnameTh'] == '') ? "" : " ".$item['t6_member_lastnameTh']; //นามสกุล
              $td4 = $item['status_laser_verify'];//status_laser_verify
              $td6 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date 
           
                    if ($item['token'] == 1) {
                      $td7 = 'Activate';
                      $color = '#0AC37D';
                    } else {
                      $td7 = 'Inactivate';
                      $color = '#8A919E';
                    }
                    //$data['td1'] = $n;
                    $data['td1'] = "<a href='" . htmlentities($url) . "'>".htmlentities($td1)."</a>"; //เลขนิติบุคคล/เลขบัตรประชาชน
                    // $data['td1'] = htmlentities($td1); //เลขนิติบุคคล
                    $data['td2'] = htmlentities($td2); //ชื่อนิติบุคคล
                    $data['td3'] = htmlentities($td3); //ชื่อ - นามสกุล
                    $data['td5'] = '<div class="pl-1 icon-center-con"><i class="'.$icon.'" style="color:'.$icon_color.'"></i>&nbsp;'.htmlentities($status_name).'</div>'; //Password ID
                    $data['td9'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_laser.'" style="color:'.$icon_color_laser.'"></i>&nbsp;'.htmlentities($status_name_laser).'</div>'; //Password ID
                    $data['td10'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_email.'" style="color:'.$icon_color_email.'"></i>&nbsp;'.htmlentities($status_name_email).'</div>'; //Password ID
                    $data['td11'] = '<div class="pl-1 icon-center-con"><i class="'.$icon_sms.'" style="color:'.$icon_color_sms.'"></i>&nbsp;'.htmlentities($status_name_sms).'</div>'; //Password ID
                    $data['td6'] = htmlentities($td6); //วันที่สมัคร
                    $data['td7'] = '<div class="pl-1 icon-center-con"><i class="fa fa-square" style="color:'.$color.'"></i>&nbsp;'.htmlentities($td7).'</div>'; //สถานะการเข้าระบบ
                    $data['td8'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit' style='width: 47px;height: 44px;background: #2D6DC4;border-radius: 8px;font-size: 17px;padding: 10px 14px;'><i class='fa-solid fa-magnifying-glass mr-1'></i></a>";
                    array_push($main, $data);
                              
            }
        }
    // }
    
    $data_array = array('total' => count($sql_countt), 'rows' => $main);

    return $data_array;
  }


  function model_data_table_client()
  {
    $stmt = $this->db->prepare("SELECT * FROM tb_merchant");
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    $main = array();
    $n = 0;

    while ($read = $result->fetch_assoc()) {
      $n++;
      $url = BASE_PATH . "office/edit_client?id=" . $read['mc_id'];

      if ($read['status'] == 1) { //activ
        $status = "<span class=\"d-inline-flex align-items-center\"><span class=\"material-symbols-outlined text-s\">crop_square</span>&nbsp;เปิดการเชื่อมต่อ</span>";
      } else {
        $status = "<span class=\"d-inline-flex align-items-center\"><span class=\"material-symbols-outlined text-muted\">crop_square</span>&nbsp;ปิดการเชื่อมต่อ</span>";
      }

      if ($read['portal'] == 1) { //activ
        $portal = "<span class=\"d-inline-flex align-items-center\"><span class=\"material-symbols-outlined text-s\">crop_square</span>&nbsp;เปิดการเชื่อมต่อ</span>";
      } else {
        $portal = "<span class=\"d-inline-flex align-items-center\"><span class=\"material-symbols-outlined text-muted\">crop_square</span>&nbsp;ปิดการเชื่อมต่อ</span>";
      }

      $data['td1'] = htmlentities($n);
      $data['td2'] = htmlentities(($read['mc_name'] == '') ? "-" : $read['mc_name']);
      $data['td3'] = htmlentities($read['client_id']);
      $data['td4'] = htmlentities(($read['redirect_uri'] == '') ? "-" : $read['redirect_uri']);
      $data['td5'] = $status;
      $data['td6'] = $portal;
      $data['td7'] = "<span class=\"d-inline-flex align-items-center\"><a href='" . htmlentities($url) . "' class='btn sso-btn-edit mr-2'><i class='fa fa-pencil'></i></a>";
      $data['td7'] .= "<button role='button' data-clientId='".$read['mc_id']."' class='btn sso-btn-del client-del-btn'><i class='fa fa-trash'></i></button></span>";
      array_push($main, $data); 
    }
    return $main;
  }

  function model_data_table_admin()
  {
    $stmt = $this->db->prepare("SELECT * FROM tb_admin");
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    $main = array();
    $n = 0;

    while ($read = $result->fetch_assoc()) {
      $n++;
      $url = BASE_PATH . "office/edit_admin?id=" . $read['id_admin'];

      if ($read['status_admin'] == 1) { //activ
        $status = "<span class=\"d-inline-flex align-items-center\"><span class=\"material-symbols-outlined text-s\">crop_square</span>&nbsp;เปิดการเชื่อมต่อ</span>";
      } else {
        $status = "<span class=\"d-inline-flex align-items-center\"><span class=\"material-symbols-outlined text-muted\">crop_square</span>&nbsp;ปิดการเชื่อมต่อ</span>";
      }

      
      $name_admin = '';
      $name_admin .= ($read['name_admin'] == '') ? "-" : $read['name_admin'];
      $name_admin .= ' ';
      $name_admin .= ($read['sname_admin'] == '') ? " " : $read['sname_admin'];
      $data['td1'] = htmlentities($n);
      $data['td2'] = htmlentities($name_admin);
      $data['td3'] = htmlentities(($read['level'] == '1')? "Admin" : "Super Admin");
      $data['td4'] = $status;
      $data['td5'] = "<span class=\"d-inline-flex align-items-center\"><a href='" . htmlentities($url) . "' class='btn sso-btn-edit mr-2'><i class='fa fa-pencil'></i></a>";
      $data['td5'] .= "<button role='button' data-clientId='".$read['id_admin']."' class='btn sso-btn-del client-del-btn'><i class='fa fa-trash'></i></button></span>";
      array_push($main, $data); 
    }
    return $main;
  }

  function model_getAttachment()
  {
    $member_id = $this->get('member_id');
    $director_status = $this->get('director_status');

    $result = $this->query("SELECT * FROM tb_member_attachment WHERE member_id = $member_id AND  director_status = $director_status");

    if(!empty($result)){
          if($result[0]['director_status'] == '1'){
            $file = [];
            $filename = [];
            foreach ($result as $key => $value) {
              $file[] = $value['attachment'];
              $filename[] = $value['attachment_file_name'];
            }
            $main = [
              "rename" => [
                  "file" => $file,
                  "filename" => $filename,
                  "folder" => $member_id,
                  "status" => $result[0]['status'],
              ]
            ];
          }else{
            foreach ($result as $key => $value) {
              if($value['type_file'] == '1'){
                $main["power_attorney"] = [
                    "file" => $value['attachment'],
                    "filename" => $value['attachment_file_name'],
                    "folder" => $member_id,
                    "status" => $value['status'],
                ];
              }else{
                $main["authorization"] = [
                  "file" => $value['attachment'],
                  "filename" => $value['attachment_file_name'],
                  "folder" => $member_id,
                  "status" => $value['status'],
                ];
              }
            }

          }
    }else{
      if($director_status == '1'){
        $main = [
          "rename" => [
              "file" => null,
              "status" => 0,
          ]
        ];
      }else{
        $main = [
          "power_attorney" => [
              "file" => null,
              "status" => 0,
          ],
          "authorization" => [
            "file" => null,
            "status" => 0,
          ]
        ];
      }
    }

    return $main;
  }

  function saveAttachment_sms($case, $phone, $cid,$type = "เอกสาร") {
    $msg = '';

    switch ($case) {
      case 1:
        $msg = "นิติบุคคลเลขที่ ".$cid." จากระบบ DITP SSO อนุมัติเรียบร้อยแล้ว";
        break;
      case 2:
        $msg = "นิติบุคคลเลขที่ ".$cid." จากระบบ DITP SSO ".$type."ไม่ได้รับการอนุมัติ";
        break;
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api-v2.thaibulksms.com/sms',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'msisdn='.$phone.'&message='.$msg.'&sender=DITPONE',
      CURLOPT_HTTPHEADER => array(
        'accept: application/json',
        'content-type: application/x-www-form-urlencoded',
        'Authorization: Basic MTgzYWU4YTY3ODU4Y2MzZmZiZjgyMjU2MWNmYjA4ZDE6OGUxMTFkODg0NDlhOTE1MDY5NzRlYzJmZTY1MDRiNzI='
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;

  }

  function model_send_mail_attorney($case, $member_id,$type = "เอกสาร"){
    $return = [
      "status" => "01",
      "message" => "ดำเนินการไม่สำเร็จ"
    ];

    if($case == 2){
      $remark = $member_id[1]; 
      $member_id = $member_id[0]; 
    }

    $msg = '';
    $btn = '';
    $query = $this->query("SELECT * FROM tb_member m LEFT JOIN tb_member_type1 m1 ON m.member_id = m1.member_id WHERE m.member_id = {$member_id}");
    $member = $query[0];

    switch ($case) {
      case 1:
        $msg = 'การยืนยันตัวตนของบริษัท '.$member['company_nameTh'].' นิติบุคคลเลขที่ '.$member['cid'].' <br>ได้รับการอนุมัติเรียบร้อยแล้ว ท่านสามารถเข้าใช้งานระบบได้ตามปกติ';
        $url = BASE_URL."index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/ck_portal&state=1";
        $btn = 'คลิกเพื่อเข้าสู่ระบบ';
        break;
      case 2:
        $msg = 'การยืนยันตัวตนของบริษัท '.$member['company_nameTh'].' นิติบุคคลเลขที่ '.$member['cid'].' <br>'.$type.'ของท่านไม่ได้ถูกอนุมัติเพราะ'.$remark.' กรุณาแนบเอกสารใหม่';
        $url = BASE_URL."index.php/auth/attach_file?q=".$member_id."&response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/ck_portal&state=1";
        $btn = 'แนบเอกสารเพิ่มเติม';
        break;
    }

    $email = $member['member_email'];

    if(!empty($member)){
      $number = mt_rand(1000,9999);
      
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
      $mail->Subject = "การตรวจสอบเอกสารยืนยันตัวตน DITP Single Sign-on";

      
      $mail->Body .= '<!DOCTYPE html>';
      $mail->Body .= '<html lang="en">';
      $mail->Body .= '<head>';
      $mail->Body .= '<meta name="viewport" content="width=device-width" />';
      $mail->Body .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
      $mail->Body .= '<title>SSO DITP Document Verification</title>';
      $mail->Body .= '</head>';
      $mail->Body .= '<body>';
      $mail->Body .= '<div class="container" style="display: flex;justify-content: center;">';
      $mail->Body .= '<div  style="max-width: 740px;width:100%;padding: 1rem;">';
      $mail->Body .= '<div style="background:linear-gradient(318.86deg, #5DBDE6 -33.84%, #1D61BD 135.37%);display:flex;width:100%;justify-content: center;padding: 1rem">';
      $mail->Body .= '<img style="max-width: 110px;margin:0 auto;" src=BASE_URL."asset/img/new-sso-logo-white.png" alt="">';
      $mail->Body .= '</div>';
      $mail->Body .= '<div style="width:100%;padding: 1rem;">';
      $mail->Body .= '<h4 class="t-main1" style="color: #39414F!important;">เรียนคุณ '.$member['member_nameTh'].' '.$member['member_lastnameTh'].'</h4>';
      $mail->Body .= '<p class="t-main1" style="color: #39414F!important;">'.$msg.'</p>'; 
      $mail->Body .= '<div style="display:grid;text-align:center;">';
      $mail->Body .= '<a style="font-weight: 400;line-height: 1.5;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;border: 1px solid transparent;font-size: 1rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;background-color: #2D6DC4;border-radius: 8px;color: white;display: inline-flex;justify-content: center;padding: 8px 15px;margin: 0 auto;"';
      $mail->Body .= 'href="'.$url.'">'.$btn.'</a>';
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

  function model_upload_attach_file() {
    $main = [
      "res_code" => "01",
    ];

    if ($_POST) {
      $err = false;
      $type = 0;
      if ($this->post('type')) {
        $type = $this->post('type');
      }
      // var_dump($_FILES,$type);
      // die;
      $member_id = $this->post('member_id');
      $dest_folder = "asset/attach/".$member_id;
      if (!empty($_FILES)) {
        // if dest folder doesen't exists, create it
        if(!is_dir(FILEPATH.$dest_folder)) @mkdir(FILEPATH.$dest_folder,0777);
        chmod(FILEPATH.$dest_folder,0777);
              $x = pathinfo($_FILES["file"]["name"]);
              $ext = $x["extension"];
              $filename = date('YmdGis')."-".$this->random_char(5).".".$ext;
              $tempFile = $_FILES['file']['tmp_name'];
              $targetFile =  $dest_folder.'/'. $filename;

              if(is_uploaded_file($_FILES["file"]["tmp_name"]))
              {
                $director_status = $this->query("SELECT * FROM tb_member_type1  WHERE member_id = ".$member_id)[0]['director_status'];
                  $moved = move_uploaded_file($tempFile,FILEPATH . $targetFile);
                  if($moved)
                  {
                      $data_insert = [
                        'member_id' => $member_id,
                        'attachment' => $_FILES["file"]["name"],
                        'attachment_file_name' => $filename,
                        'director_status' => $director_status,
                        'type_file' => $type,
                        'status' => 1,
                      ];
                      
                      $insert = $this->insert('tb_member_attachment', $data_insert);
                      $COUNT = $this->query("SELECT COUNT(*) as COUNT FROM tb_member_attachment  WHERE `status` = 1 AND  member_id = ".$member_id);
                      $main = [
                        "res_code" => "00",
                        "COUNT" => (isset($COUNT[0]['COUNT'])? $COUNT[0]['COUNT'] : 0),
                      ];
                  } else {
                    $main = [
                      "res_code" => "01",
                    ];
                  }
              }

          
      } 
    }
    return $main;
  }

  function model_saveAttachment()
  {
    $member_id = $this->post('member_id');
    $remark = '';
    if(!empty($this->post('authApprove'))){
      $director_status = 2 ;
      $type_file = 2 ;
      $texts = 'สำเนาบัตรประชาชนของกรรมการ';
      $status = 1 ; 
    }else if(!empty($this->post('authNoApprove'))){ 
      $director_status = 2;
      $type_file = 2 ;
      $status = 2;
      $texts = 'สำเนาบัตรประชาชนของกรรมการ';
      $remark = $this->post('remark');
    }else if(!empty($this->post('powerApprove'))){ 
      $director_status = 2;
      $type_file = 1 ;
      $texts = 'เอกสารมอบอำนาจ';
      $status = 1;
    }else if(!empty($this->post('powerNoApprove'))){ 
      $director_status = 2;
      $type_file = 1 ;
      $texts = 'เอกสารมอบอำนาจ';
      $status = 2;
      $remark = $this->post('remark');
    }else if(!empty($this->post('renameApprove'))){ 
      $director_status = 1;
      $status = 1;
    }else if(!empty($this->post('renameNoApprove'))){ 
      $director_status = 1;
      $status = 2;
    }else{
      $director_status = 1;
      $status = 0;
    }

    if(isset($type_file)){
      $attachment = $this->query("SELECT * FROM tb_member_attachment WHERE member_id = $member_id AND director_status = $director_status AND type_file = $type_file");
    }else{
      $attachment = $this->query("SELECT * FROM tb_member_attachment WHERE member_id = $member_id AND director_status = $director_status");
    }
    $main = [
      "res_code" => "01",
    ];
    $query = $this->query("SELECT * FROM tb_member_type1 LEFT JOIN tb_member ON tb_member_type1.member_id = tb_member.member_id WHERE tb_member_type1.member_id = $member_id");
    $usr = $query[0];

    if(!empty($attachment)){
      foreach($attachment as $key => $value) {
        $this->update('tb_member_attachment', ['status' => $status], 'id ="' . $value['id'] . '"');
      } 
      if($director_status == '1'){
        
        if($status == '1'){
          //กรรมการผ่านแล้ว
          $this->update('tb_member_type1', ['status_case' => 99], 'member_id ="' . $member_id . '"');
          $send_sms = $this->saveAttachment_sms(1, $usr['member_tel'], $usr['cid']);
          $send_email = $this->model_send_mail_attorney(1, $member_id);
        }else if($status == '2'){
          //กรรมการไม่ผ่าน
          $this->update('tb_member_type1', ['status_case' => 5], 'member_id ="' . $member_id . '"');
          $send_sms = $this->saveAttachment_sms(2, $usr['member_tel'], $usr['cid']);
          $send_email = $this->model_send_mail_attorney(2, [$member_id,$remark]);
        }
        $main = [
          "res_code" => "00",
        ];
      }else{
        $status_count = $this->query("SELECT COUNT(*) AS status_count FROM tb_member_attachment WHERE member_id = $member_id AND director_status = 2 AND `status` = 1");

        if($status_count[0]['status_count'] == '2'){
          $this->update('tb_member_type1', ['status_case' => 99], 'member_id ="' . $member_id . '"');
          $send_sms = $this->saveAttachment_sms(1, $usr['member_tel'], $usr['cid']);
          $send_email = $this->model_send_mail_attorney(1, $member_id);

          $main = [
            "res_code" => "02",
          ];
        }else if($status == '2'){
          $this->update('tb_member_type1', ['status_case' => 5], 'member_id ="' . $member_id . '"');
          if ($status_count[0]['status_count'] != '1') {
            $send_sms = $this->saveAttachment_sms(2, $usr['member_tel'], $usr['cid'],$texts);
            $send_email = $this->model_send_mail_attorney(2, [$member_id,$remark],$texts);
          }
          
          $main = [
            "res_code" => "00",
          ];
        }else{
          $statusAll = $this->query("SELECT * FROM tb_member_attachment WHERE member_id = $member_id AND director_status = 2 AND `status` = 2");
          if(isset($statusAll[0]['status'])){
             $this->update('tb_member_type1', ['status_case' => 5], 'member_id ="' . $member_id . '"');
             if ($status_count[0]['status_count'] != '1') {
               $send_sms = $this->saveAttachment_sms(2, $usr['member_tel'], $usr['cid'],$texts);
               $send_email = $this->model_send_mail_attorney(2, [$member_id,$remark],$texts);
             }
             $main = [
              "res_code" => "04",
            ];
          }else{
            $this->update('tb_member_type1', ['status_case' => 3], 'member_id ="' . $member_id . '"');
            $main = [
              "res_code" => "03",
            ];
          }

        }
      }
    }

    return $main;
  }

  function model_data_table_cancel()
  {
    $stmt = $this->db->prepare("SELECT * FROM cancel_member");
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    $main = array();
    $n = 0;

    while ($read = $result->fetch_assoc()) {
      $n++;
      $data['td1'] = htmlentities($n);
      $data['td2'] = htmlentities(($read['member_nameTh'] == '' && $read['member_lastnameTh'] == '') ? ($read['company_nameTh'] == '')? "-": $read['company_nameEn']: $read['member_nameTh'].' '.$read['member_lastnameTh']);
      $data['td3'] = htmlentities($read['target']);
      $data['td4'] = htmlentities(($read['created_at'] == '') ? "-" : $read['created_at']);
      $data['td5'] = htmlentities($read['remark']);
      array_push($main, $data);
    }
    return $main;
  }
  function model_edit_client_data($mc_id)
  {
    $stmt = $this->db->prepare("SELECT * FROM tb_merchant WHERE mc_id = ?");
    $stmt->bind_param("s", $mc_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $read = $result->fetch_assoc();

    $return = array();

    $return['mc_id'] = $read['mc_id'];
    $return['mc_name'] = $read['mc_name'];
    $return['client_id'] = $read['client_id'];
    $return['redirect_uri'] = $read['redirect_uri'];
    $return['status'] = $read['status'];
    $return['portal'] = $read['portal'];
    $return['title'] = $read['title'];
    $return['des'] = $read['des'];
    $return['img'] = $read['img'];
    $return['type'] = $read['type'];

    return $return;
  }
  function model_edit_admin_data($id_admin)
  {
    $stmt = $this->db->prepare("SELECT * FROM tb_admin WHERE id_admin = ?");
    $stmt->bind_param("s", $id_admin);
    $stmt->execute();
    $result = $stmt->get_result();
    $read = $result->fetch_assoc();

    $return = array();

    $return['id_admin'] = $read['id_admin'];
    $return['name_admin'] = $read['name_admin'];
    $return['sname_admin'] = $read['sname_admin'];
    $return['username'] = $read['username'];
    $return['level'] = $read['level'];

    return $return;
  }
  function model_delete_user($mc_id)
  {
    $return = false;
    $stmt = $this->db->prepare("SELECT * FROM tb_member WHERE member_id = ?");
    $stmt->bind_param("s", $mc_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $read = $result->fetch_assoc();
    $return = array();  
    if(empty($read)){
      $UserID = $this->query("SELECT * FROM Member_drive_v3 WHERE UserID = " . "'$mc_id'");
      $type1 = "DELETE FROM `Member_drive_v3` WHERE `Member_drive_v3`.`UserID` = '".$UserID[0]['UserID']."'";
      $datatype1 = $this->query($type1);
      $return = true;
    }else {
      if ($read['type'] == 1) {
        $type1 = "DELETE FROM tb_member_type1 WHERE member_id = '".$read['member_id']."'";
        $datatype1 = $this->query($type1);
        $tb_member = "DELETE FROM tb_member WHERE member_id = '".$read['member_id']."'";
        $datamember = $this->query($tb_member);
        $return = true;
      } else if ($read['type'] == 2) {
        $type2 = "DELETE FROM tb_member_type2 WHERE member_id = '".$read['member_id']."'";
        $datatype2 = $this->query($type2);
        $tb_member = "DELETE FROM tb_member WHERE member_id = '".$read['member_id']."'";
        $datamember = $this->query($tb_member);
        $return = true;
      } else if ($read['type'] == 3) {
        $type3 = "DELETE FROM tb_member_type3 WHERE member_id = '".$read['member_id']."'";
        $datatype3 = $this->query($type3);
        $tb_member = "DELETE FROM tb_member WHERE member_id = '".$read['member_id']."'";
        $datamember = $this->query($tb_member);
        $return = true;
      } else if ($read['type'] == 4) {
        $type4 = "DELETE FROM tb_member_type4 WHERE member_id = '".$read['member_id']."'";
        $datatype4 = $this->query($type4);
        $tb_member = "DELETE FROM tb_member WHERE member_id = '".$read['member_id']."'";
        $datamember = $this->query($tb_member);
        $return = true;
      } else if ($read['type'] == 5) {
        $type5 = "DELETE FROM tb_member_type5 WHERE member_id = '".$read['member_id']."'";
        $datatype5 = $this->query($type5);
        $tb_member = "DELETE FROM tb_member WHERE member_id = '".$read['member_id']."'";
        $datamember = $this->query($tb_member);
        $return = true;
      } else if ($read['type'] == 6) {
        $type6 = "DELETE FROM tb_member_type6 WHERE member_id = '".$read['member_id']."'";
        $datatype6 = $this->query($type6);
        $tb_member = "DELETE FROM tb_member WHERE member_id = '".$read['member_id']."'";
        $datamember = $this->query($tb_member);
        $return = true;
      } else {
        $return = $read;
      }
    }

    $data = [
      'res_code' => $return
    ];
    //echo json_encode($data); die();
    return $data;
  }
  
  function model_edit_user_data($member_id,$type)
  {
    if($type == "old"){
        $sql_rows = "SELECT * FROM Member_drive_v3 WHERE UserID = $member_id";
        $read = $this->query($sql_rows);
        $return = array();
        $return = $read;
    }else{
        $stmt = $this->db->prepare("SELECT * FROM tb_member WHERE member_id = ?");
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $read = $result->fetch_assoc();
        $return = array();

        if ($read['type'] == 1) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type1 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 2) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type2 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 3) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type3 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 4) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type4 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 5) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type5 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 6) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type6 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else {
          $return = $read;
        }
      if(!empty($member_id)){
        $stmt_att = $this->db->prepare("SELECT * FROM tb_member_attachment WHERE member_id = ?");
        $stmt_att->bind_param("s", $member_id);
        $stmt_att->execute();
        $result_att = $stmt_att->get_result();
        if ($result_att->num_rows > 0) {
          $return_att =  $result_att->fetch_assoc();
          foreach ($return_att as $value_attachment) {
            if($value_attachment->director_status == 1){
              $power_attorney = $value_attachment->attachment;
            }else {
              $power_attorney = null;
            }  
            if($value_attachment->director_status == 1){
              $authorization = $value_attachment->attachment;
            }else {
              $authorization = null;
            } 
            $attachment []= [
              "power_attorney" => $power_attorney,
              "authorization" => $authorization,
            ];
          }
        } else {
          $attachment = [
            "power_attorney" => null,
            "authorization" => null,
          ];
        }
        $stmt_note = $this->db->prepare("SELECT * FROM tb_member_note WHERE member_id = ?");
        $stmt_note->bind_param("s", $member_id);
        $stmt_note->execute();
        $result_note = $stmt_note->get_result();
        if ($result_note->num_rows > 0) {
          $note =  $result_note->fetch_assoc();
        } else {
          $note = null;
        }
      }else{
        $attachment = [
          "power_attorney" => null,
          "authorization" => null,
        ];
        $note = null;
      }
    }

    $data = [
      'member' => $read,
      'member_type' => $return,
      'attachment' => $attachment,
      'note' => $note,
    ];
    //echo json_encode($data); die();
    return $data;
  }
  function model_detail_member_data($member_id,$type)
  {
    if($type == "old"){
        $sql_rows = "SELECT * FROM Member_drive_v3 WHERE UserID = $member_id";
        $read = $this->query($sql_rows);
        $return = array();
        $return = $read;
    }else{
        $stmt = $this->db->prepare("SELECT * FROM tb_member WHERE member_id = ?");
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $read = $result->fetch_assoc();
        $return = array();

        if ($read['type'] == 1) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type1 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 2) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type2 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 3) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type3 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 4) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type4 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 5) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type5 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else if ($read['type'] == 6) {
          $stmt_m = $this->db->prepare("SELECT * FROM tb_member_type6 WHERE member_id = ?");
          $stmt_m->bind_param("s", $member_id);
          $stmt_m->execute();
          $result_m = $stmt_m->get_result();
          if ($result_m->num_rows > 0) {
            $return = $read_m = $result_m->fetch_assoc();
          } else {
            $return = $read;
          }
        } else {
          $return = $read;
        }
      if(!empty($member_id)){
        $stmt_att = $this->db->prepare("SELECT * FROM tb_member_attachment WHERE member_id = ?");
        $stmt_att->bind_param("s", $member_id);
        $stmt_att->execute();
        $result_att = $stmt_att->get_result();
        foreach ($result_att as $value_attachment) {
          if($value_attachment['director_status'] == '1'){
            if($value_attachment['type_file'] == 0){
              $power_attorney = $value_attachment['attachment'];
              $power_attorney_href = $value_attachment['attachment_file_name'];
              $attachment['power_attorney'] = $power_attorney;
              $attachment['power_attorney_href'] = BASE_URL."asset/attach/".$member_id."/".$power_attorney_href;
            }else {
              $power_attorney = null;
              $power_attorney_href = null;
              $attachment['power_attorney'] = $power_attorney;
              $attachment['power_attorney_href'] = $power_attorney_href;
            }
          }else if($value_attachment['director_status'] == '2'){
            if($value_attachment['type_file'] == 1){
              $power_attorney = $value_attachment['attachment'];
              $power_attorney_href = $value_attachment['attachment_file_name'];
              $attachment['power_attorney'] = $power_attorney;
              $attachment['power_attorney_href'] = BASE_URL."asset/attach/".$member_id."/".$power_attorney_href;
            }else if(!isset($attachment['power_attorney'])){
              $power_attorney = null;
              $power_attorney_href = null;
              $attachment['power_attorney'] = $power_attorney;
              $attachment['power_attorney_href'] = $power_attorney_href;
            } 
            if($value_attachment['type_file'] == 2){
              $authorization = $value_attachment['attachment'];
              $attachment['authorization'] = $authorization;
              $attachment_href = $value_attachment['attachment_file_name'];
              $attachment['authorization_href'] = BASE_URL."asset/attach/".$member_id."/".$attachment_href;
            }else if(!isset($attachment['authorization'])){
              $authorization = null;
              $attachment_href = null;
              $attachment['authorization_href'] = $attachment_href;
              $attachment['authorization'] = $authorization;
            } 
          }else {
            $attachment = [
              "power_attorney" => null,
              "authorization" => null,
            ];
          }
        }
  
        // if ($result_att->num_rows == 1) {
        //   foreach ($result_att as $value_attachment) {
        //     if($value_attachment['type_file'] == 0){
        //       $power_attorney = $value_attachment['attachment'];
        //       $power_attorney_href = $value_attachment['attachment_file_name'];
        //       $attachment['power_attorney'] = $power_attorney;
        //       $attachment['power_attorney_href'] = BASE_URL."asset/attach/".$member_id."/".$power_attorney_href;
        //     }else {
        //       $power_attorney = null;
        //       $power_attorney_href = null;
        //       $attachment['power_attorney'] = $power_attorney;
        //       $attachment['power_attorney_href'] = $power_attorney_href;
        //     }
        //   }
        // }else if ($result_att->num_rows == 2){
        //   foreach ($result_att as $value_attachment) {
        //     if($value_attachment['type_file'] == 1){
        //       $power_attorney = $value_attachment['attachment'];
        //       $power_attorney_href = $value_attachment['attachment_file_name'];
        //       $attachment['power_attorney'] = $power_attorney;
        //       $attachment['power_attorney_href'] = BASE_URL."asset/attach/".$member_id."/".$power_attorney_href;
        //     }else if(!isset($attachment['power_attorney'])){
        //       $power_attorney = null;
        //       $power_attorney_href = null;
        //       $attachment['power_attorney'] = $power_attorney;
        //       $attachment['power_attorney_href'] = $power_attorney_href;
        //     } 
        //     if($value_attachment['type_file'] == 2){
        //       $authorization = $value_attachment['attachment'];
        //       $attachment['authorization'] = $authorization;
        //       $attachment_href = $value_attachment['attachment_file_name'];
        //       $attachment['authorization_href'] = BASE_URL."asset/attach/".$member_id."/".$attachment_href;
        //     }else if(!isset($attachment['authorization'])){
        //       $authorization = null;
        //       $attachment_href = null;
        //       $attachment['authorization_href'] = $attachment_href;
        //       $attachment['authorization'] = $authorization;
        //     } 

        //     // $attachment = [
        //     //   "power_attorney" => $power_attorney,
        //     //   "authorization" => $authorization,
        //     // ];
        //   }
        // } else {
        //   $attachment = [
        //     "power_attorney" => null,
        //     "authorization" => null,
        //   ];
        // }
        $stmt_note = $this->db->prepare("SELECT * FROM tb_member_note WHERE member_id = ?");
        $stmt_note->bind_param("s", $member_id);
        $stmt_note->execute();
        $result_note = $stmt_note->get_result();
        if ($result_note->num_rows > 0) {
          $note =  $result_note->fetch_assoc();
        } else {
          $note = null;
        }
      }else{
        $attachment = [
          "power_attorney" => null,
          "authorization" => null,
        ];
        $note = null;
      }
    }

    $data = [
      'member' => $read,
      'member_type' => $return,
      'attachment' => $attachment,
      'note' => $note,
    ];
    //echo json_encode($data); die();
    return $data;
  }

  function model_save_edit()
  {

    $return = [
      'status' => '01',
      'message' => 'Edit Save fail'
    ];
    $mc_id = $this->post('mc_id');
    $mc_name = $this->post('mc_name');
    $client_id = $this->post('client_id');
    $redirect_uri = $this->post('redirect_uri');
    $status = $this->post('status');
    $type = $this->post('type');
    $portal = 0;
    $title = '';
    $des = '';

    $sql = "SELECT img FROM tb_merchant WHERE mc_id = {$mc_id}";
    $rs = $this->query($sql);
    $img = $rs[0]['img'];

    

    if (!empty($this->post('portal')) && $this->post('portal') == 1) {
      $portal = $this->post('portal');
      $title = $this->post('title');
      $des = $this->post('des');

      if(isset($_FILES["img"]) && $_FILES["img"]["size"] > 0 ) {

         if ($_FILES["img"]["size"] >= 5242880 ) {
            $err = true;
         }

         $ints = date('YmhHis') . $this->random_char(7);

         if($_FILES["img"]["type"]=="image/png" || $_FILES["img"]["type"]=="image/x-png"){
            $imgsn = $ints.".png";
         }
         if($_FILES["img"]["type"]=="image/gif"){
            $imgsn = $ints.".gif";
         }elseif($_FILES["img"]["type"]=="image/pjpeg" || $_FILES["img"]["type"]=="image/jpeg"){
            $imgsn = $ints.".jpg";
         }

         if(!empty($imgsn) && !$err) {

            $path =  "asset/img/portal/{$imgsn}" ; 
            if (move_uploaded_file($_FILES["img"]["tmp_name"] , FILEPATH . $path  )) {
              $img = $path ;
            } else {
              return $return = [
                'status' => '01',
                'message' => 'อัพโหลดไฟล์ล้มแหลว ' . $path
              ];
            }
            

         } else {
            return $return = [
              'status' => '01',
              'message' => 'ไม่สามารถอัพโหลดรูปภาพได้ ไม่ได้มีการอัพโหลดรูปภาพ หรือรูปภาพมีขนาดใหญ่เกินกำหนด'
            ];
         }
      }

      $data = [
        'mc_id' => $mc_id,
        'mc_name' => $mc_name,
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'status' => $status,
        'portal' => $portal,
        'title' => $title,
        'des' => $des,
        'img' => $img,
        'type' => $type
      ];
    } else {
      $data = [
        'mc_id' => $mc_id,
        'mc_name' => $mc_name,
        'client_id' => $client_id,
        'portal' => $portal,
        'redirect_uri' => $redirect_uri,
        'status' => $status,
        'type' => $type
      ];
    }
    
    try {
      $this->update('tb_merchant', $data, '  mc_id ="' . $mc_id . '"');
      $return = [
        'status' => '00',
        'message' => 'Success'
      ];
    } catch (Exception $e) {
      $return = ['status' => '01', 'message' => $e];
    }
    return $return;
  }

  function model_save_admin()
  {
    $return = [
      'status' => '01',
      'message' => 'Edit Save fail'
    ];
    return false;
    $mc_id = $this->post('mc_id');
    $mc_name = $this->post('mc_name');
    $client_id = $this->post('client_id');
    $redirect_uri = $this->post('redirect_uri');
    $status = $this->post('status');
    $type = $this->post('type');
    $portal = 0;
    $title = '';
    $des = '';

    $sql = "SELECT img FROM tb_merchant WHERE mc_id = {$mc_id}";
    $rs = $this->query($sql);
    $img = $rs[0]['img'];

    // var_dump($img, $_FILES['img']);
    // die();

    if (!empty($this->post('portal')) && $this->post('portal') == 1) {
      $portal = $this->post('portal');
      $title = $this->post('title');
      $des = $this->post('des');

      if(isset($_FILES["img"]) && $_FILES["img"]["size"] > 0 ) {

         if ($_FILES["img"]["size"] >= 5242880 ) {
            $err = true;
         }

         $ints = date('YmhHis') . $this->random_char(7);

         if($_FILES["img"]["type"]=="image/png" || $_FILES["img"]["type"]=="image/x-png"){
            $imgsn = $ints.".png";
         }
         if($_FILES["img"]["type"]=="image/gif"){
            $imgsn = $ints.".gif";
         }elseif($_FILES["img"]["type"]=="image/pjpeg" || $_FILES["img"]["type"]=="image/jpeg"){
            $imgsn = $ints.".jpg";
         }

         if(!empty($imgsn) && !$err) {

            $path =  "asset/img/portal/{$imgsn}" ; 
            if (move_uploaded_file($_FILES["img"]["tmp_name"] , FILEPATH . $path  )) {
              $img = $path ;
            } else {
              return $return = [
                'status' => '01',
                'message' => 'อัพโหลดไฟล์ล้มแหลว ' . $path
              ];
            }
            

         } else {
            return $return = [
              'status' => '01',
              'message' => 'ไม่สามารถอัพโหลดรูปภาพได้ ไม่ได้มีการอัพโหลดรูปภาพ หรือรูปภาพมีขนาดใหญ่เกินกำหนด'
            ];
         }
      }

      $data = [
        'mc_id' => $mc_id,
        'mc_name' => $mc_name,
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'status' => $status,
        'portal' => $portal,
        'title' => $title,
        'des' => $des,
        'img' => $img,
        'type' => $type
      ];
    } else {
      $data = [
        'mc_id' => $mc_id,
        'mc_name' => $mc_name,
        'client_id' => $client_id,
        'portal' => $portal,
        'redirect_uri' => $redirect_uri,
        'status' => $status,
        'type' => $type
      ];
    }
    
    try {
      $this->update('tb_merchant', $data, '  mc_id ="' . $mc_id . '"');
      $return = [
        'status' => '00',
        'message' => 'Success'
      ];
    } catch (Exception $e) {
      $return = ['status' => '01', 'message' => $e];
    }
    return $return;
  }

  function model_save_edit_member()
  {
    $return = [
      'status' => '01',
      'message' => 'Edit Save fail'
    ];

    $naturalId = $this->post('cid');
    $member_id = $this->post('member_id');
    $type = $this->post('type');

    if($type == "person"){
      $naturalId = $this->post('naturalId');
      $Firstname = $this->post('member_nameTh');
      $LastName = $this->post('member_lastnameTh');
      $member_email = $this->post('member_email');
      $member_tel = $this->post('member_tel');

      $data = [
        'Username' => $naturalId,
        'Firstname' => $Firstname,
        'LastName' => $LastName,
        'Mail' => $member_email,
        'Telephone' => $member_tel,
      ];

      try {
        $this->update('Member_drive_v3', $data, '  UserID ="' . $member_id . '"');
        $return = [
          'status' => '00',
          'message' => 'Success',
          'type' => $type
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    }else if ($type == "corporate") {
      $company_nameTh = $this->post('company_nameTh');
      $company_nameEn = $this->post('company_nameEn');
      $company_addressTh = $this->post('company_addressTh');
      $company_provinceTh = $this->post('company_provinceTh');
      $company_districtTh = $this->post('company_districtTh');
      $company_subdistrictTh = $this->post('company_subdistrictTh');
      $company_postcodeTh = $this->post('company_postcodeTh');
      $company_postcodeEn = $this->post('company_postcodeEn');
      $company_addressEn = $this->post('company_addressEn');
      $company_provinceEn = $this->post('company_provinceEn');
      $company_districtEn = $this->post('company_districtEn');
      $company_subdistrictEn = $this->post('company_subdistrictEn');
      $contact_address = $this->post('contact_address');
      $contact_province = $this->post('contact_province');
      $contact_district = $this->post('contact_district');
      $contact_subdistrict = $this->post('contact_subdistrict');
      $contact_postcode = $this->post('contact_postcode');
      $member_title = $this->post('member_title');
      $member_cid = $this->post('member_cid');
      $member_nameTh = $this->post('member_nameTh');
      $member_lastnameTh = $this->post('member_lastnameTh');
      $member_nameEn = $this->post('member_nameEn');
      $member_lastnameEn = $this->post('member_lastnameEn');
      $member_email = $this->post('member_email');
      $member_tel = $this->post('member_tel');

      $data = [
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
        'member_tel' => $member_tel
      ];
    }

    $ck_old_naturalId = $this->query("SELECT cid FROM tb_member WHERE member_id = " . "'$member_id'");
    if ($ck_old_naturalId[0]['cid'] != $naturalId) { //มีการกรอก cid มาใหม่
      $ck_naturalId = $this->query("SELECT 1 FROM tb_member WHERE cid = " . "'$naturalId'");
      if ($ck_naturalId) {
        $return = [
          'status' => '01',
          'message' => 'Username ซ้ำ'
        ];
        return $return;
      }
    }


    if ($type == 1) {
      $this->update('tb_member', ['cid' => $naturalId, 'system_update' => 'Back-office'], '  member_id ="' . $member_id . '"');
      $company_nameTh = $this->post('company_nameTh');
      $company_nameEn = $this->post('company_nameEn');
      $company_tel = $this->post('company_tel');
      $company_email = $this->post('company_email');
      $company_addressTh = $this->post('company_addressTh');
      $company_provinceTh = $this->post('company_provinceTh');
      $company_districtTh = $this->post('company_districtTh');
      $company_subdistrictTh = $this->post('company_subdistrictTh');
      $company_postcodeTh = $this->post('company_postcodeTh');
      $company_postcodeEn = $this->post('company_postcodeEn');
      $company_addressEn = $this->post('company_addressEn');
      $company_provinceEn = $this->post('company_provinceEn');
      $company_districtEn = $this->post('company_districtEn');
      $company_subdistrictEn = $this->post('company_subdistrictEn');
      $contact_address = $this->post('contact_address');
      $contact_province = $this->post('contact_province');
      $contact_district = $this->post('contact_district');
      $contact_subdistrict = $this->post('contact_subdistrict');
      $contact_postcode = $this->post('contact_postcode');
      $member_title = $this->post('member_title');
      $member_cid = $this->post('member_cid');
      $member_nameTh = $this->post('member_nameTh');
      $member_midnameTh = $this->post('member_midnameTh');
      $member_lastnameTh = $this->post('member_lastnameTh');
      $member_nameEn = $this->post('member_nameEn');
      $member_midnameEn = $this->post('member_midnameEn');
      $member_lastnameEn = $this->post('member_lastnameEn');
      $member_birthday = $this->post('member_birthday');
      $member_email = $this->post('member_email');
      $member_tel = $this->post('member_tel');
      $director_status_1 = $this->post('director_status_1');
      $director_status_2 = $this->post('director_status_2');
      $ck_national_thai = $this->post('ck_national_thai');
      $ck_national_foreigner = $this->post('ck_national_foreigner');
      if(!empty($director_status_2)){
        $director_status = $director_status_2;
        $status_case = 1;
      }else{
        $director_status = $director_status_1;
        $status_case = 0;
      }
      if(!empty($ck_national_foreigner)){
        $status_contact_nationality = $ck_national_foreigner;
      }else{
        $status_contact_nationality = $ck_national_thai;
      }
      // echo "<pre>";
      // var_dump($director_status_1,$director_status_2,$ck_national_thai,$ck_national_foreigner,"2");
      // echo "</pre>";
      // die();

      $stmt_ck = $this->db->prepare("SELECT * FROM tb_member_type1 WHERE member_id = ?");
      $stmt_ck->bind_param("s", $member_id);
      $stmt_ck->execute();
      $result_ck = $stmt_ck->get_result();
      $ck = $result_ck->fetch_assoc();
      $stmt_member = $this->db->prepare("SELECT * FROM tb_member WHERE member_id = ?");
      $stmt_member->bind_param("s", $member_id);
      $stmt_member->execute();
      $result_member = $stmt_member->get_result();
      $member = $result_member->fetch_assoc();
      if($director_status == $ck['director_status']){
        $data = [
          'company_nameTh' => $company_nameTh,
          'company_nameEn' => $company_nameEn,
          'company_tel' => $company_tel,
          'company_email' => $company_email,
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
          'member_birthday' => $member_birthday,
          'member_email' => $member_email,
          'member_tel' => $member_tel,
          'director_status' => $director_status
        ];
      }else{
        $stmt_attachment = $this->db->prepare("DELETE FROM `tb_member_attachment` WHERE  member_id = ?");
        $stmt_attachment->bind_param("s", $member_id);
        $stmt_attachment->execute();
        
        $data = [
          'company_nameTh' => $company_nameTh,
          'company_nameEn' => $company_nameEn,
          'company_tel' => $company_tel,
          'company_email' => $company_email,
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
          'member_birthday' => $member_birthday,
          'member_email' => $member_email,
          'member_tel' => $member_tel,
          'director_status' => $director_status,
          'status_case' => $status_case,
          'director_date' => date("Y-m-d H:m:s")
        ];
      }
      

      // echo "<pre>";
      // var_dump($member['status_contact_nationality'] , $status_contact_nationality , $status_contact_nationality,"2");
      // echo "</pre>";
      // die();
      try {
        $this->update('tb_member_type1', $data, '  member_id ="' . $member_id . '"');
        $edit = [
          "member_id"=> $member_id,
          "old_status"=> $ck['director_status'],
          "new_status"=> $director_status,
          "admin"=> $_SESSION['id_admin']
        ];
        $this->insert('edit_director', $edit);
        if($ck['status_contact_nationality'] != $status_contact_nationality){
          $save = [
            "status_laser_verify" => 0,
            "status_contact_nationality" => $status_contact_nationality
          ];
           $this->update('tb_member', $save, '  member_id ="' . $member_id . '"');
        }
        $return = [
          'status' => '00',
          'message' => 'Success',
          'type' => $type,
          'member_id' => $member_id
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    } else if ($type == 2) {
      $this->update('tb_member', ['cid' => $naturalId, 'system_update' => 'Back-office'], '  member_id ="' . $member_id . '"');

      $corporate_name = $this->post('corporate_name');
      $country = $this->post('country');
      $address = $this->post('address');
      $member_title = $this->post('member_title');
      $member_nameEn = $this->post('member_nameEn');
      $member_midnameEn = $this->post('member_midnameEn');
      $member_lastnameEn = $this->post('member_lastnameEn');
      $email = $this->post('email');
      $tel = $this->post('tel');

      $data = [
        'corporate_name' => $corporate_name,
        'country' => $country,
        'address' => $address,
        'member_title' => $member_title,
        'member_nameEn' => $member_nameEn,
        'member_midnameEn' => $member_midnameEn,
        'member_lastnameEn' => $member_lastnameEn,
        'email' => $email,
        'tel' => $tel
      ];
      try {
        $this->update('tb_member_type2', $data, '  member_id ="' . $member_id . '"');
        $return = [
          'status' => '00',
          'message' => 'Success',
          'type' => $type,
          'member_id' => $member_id
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    } else if ($type == 3) {

      // $this->update('tb_member', ['cid' => $naturalId, 'system_update' => 'Back-office'], '  member_id ="' . $member_id . '"');

      $member_title = $this->post('member_title');

      $member_nameTh = $this->post('member_nameTh');
      $member_midnameEn = $this->post('member_midnameEn');
      $member_lastnameTh = $this->post('member_lastnameTh');
      $member_nameEn = $this->post('member_nameEn');
      $member_midnameTh = $this->post('member_midnameTh');
      $member_lastnameEn = $this->post('member_lastnameEn');
      $member_birthday = $this->post('member_birthday');
      $email = $this->post('email');
      $tel = $this->post('tel');
      $addressTh = $this->post('addressTh');
      $provinceTh = $this->post('provinceTh');
      $districtTh = $this->post('districtTh');
      $subdistrictTh = $this->post('subdistrictTh');
      $postcode = $this->post('postcode');

     $addressEn = $this->post('addressEn');
      $provinceEn = $this->post('provinceEn');
      $districtEn = $this->post('districtEn');
      $subdistrictEn = $this->post('subdistrictEn');

      $data = [
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
        'addressTh' => $addressTh,
        'provinceTh' => $provinceTh,
        'districtTh' => $districtTh,
        'subdistrictTh' => $subdistrictTh,
        'addressEn' => $addressEn,
        'provinceEn' => $provinceEn,
        'districtEn' => $districtEn,
        'subdistrictEn' => $subdistrictEn,
        'postcode' => $postcode
      ];

      $stmt_ck = $this->db->prepare("SELECT * FROM tb_member_type3 WHERE member_id = ?");
      $stmt_ck->bind_param("s", $member_id);
      $stmt_ck->execute();
      $result_ck = $stmt_ck->get_result();
      $ck = $result_ck->fetch_assoc();
      // echo "<pre>";
      // var_dump($data,"2");
      // echo "</pre>";
      // die();
      try {
        $this->update('tb_member_type3', $data, '  member_id ="' . $member_id . '"');
        if($ck['member_cid'] != $member_cid){
          $save = [
            "status_laser_verify" => 0
          ];
           $this->update('tb_member', $save, '  member_id ="' . $member_id . '"');
        }
        $return = [
          'status' => '00',
          'message' => 'Success',
          'type' => $type,
          'member_id' => $member_id
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    } else if ($type == 4) {
      $this->update('tb_member', ['cid' => $naturalId, 'system_update' => 'Back-office'], '  member_id ="' . $member_id . '"');

      $member_title = $this->post('member_title');
      $member_nameEn = $this->post('member_nameEn');
      $member_midnameEn = $this->post('member_midnameEn');
      $member_lastnameEn = $this->post('member_lastnameEn');
      $country = $this->post('country');
      $address = $this->post('address');
      $email = $this->post('email');
      $tel = $this->post('tel');

      $data = [
        'member_title' => $member_title,
        'member_nameEn' => $member_nameEn,
        'member_midnameEn' => $member_midnameEn,
        'member_lastnameEn' => $member_lastnameEn,
        'country' => $country,
        'address' => $address,
        'email' => $email,
        'tel' => $tel
      ];
 
      try {
        $this->update('tb_member_type4', $data, '  member_id ="' . $member_id . '"');
        $return = [
          'status' => '00',
          'message' => 'Success',
          'type' => $type,
          'member_id' => $member_id
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    } else if ($type == 5) {
      $this->update('tb_member', ['cid' => $naturalId, 'system_update' => 'Back-office'], '  member_id ="' . $member_id . '"');

      $member_title = $this->post('member_title');
      $member_nameTh = $this->post('member_nameTh');
      $member_lastnameTh = $this->post('member_lastnameTh');
      $addressTh = $this->post('addressTh');
      $provinceTh = $this->post('provinceTh');
      $districtTh = $this->post('districtTh');
      $subdistrictTh = $this->post('subdistrictTh');
      $postcode = $this->post('postcode');
      $email = $this->post('email');
      $tel = $this->post('tel');

      $data = [
        'member_title' => $member_title,
        'member_nameTh' => $member_nameTh,
        'member_lastnameTh' => $member_lastnameTh,
        'addressTh' => $addressTh,
        'provinceTh' => $provinceTh,
        'districtTh' => $districtTh,
        'subdistrictTh' => $subdistrictTh,
        'postcode' => $postcode,
        'email' => $email,
        'tel' => $tel
      ];

      try {
        $this->update('tb_member_type5', $data, '  member_id ="' . $member_id . '"');
        $return = [
          'status' => '00',
          'message' => 'Success',
          'type' => $type,
          'member_id' => $member_id
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    } else if ($type == 6) {
      $this->update('tb_member', ['cid' => $naturalId, 'system_update' => 'Back-office'], '  member_id ="' . $member_id . '"');

      $company_nameTh = $this->post('company_nameTh');
      $company_nameEn = $this->post('company_nameEn');
      $company_tel = $this->post('company_tel');
      $company_email = $this->post('company_email');
      $company_addressTh = $this->post('company_addressTh');
      $company_provinceTh = $this->post('noncompany_provinceTh');
      $company_districtTh = $this->post('noncompany_districtTh');
      $company_subdistrictTh = $this->post('noncompany_subdistrictTh');
      $company_postcodeTh = $this->post('noncompany_postcodeTh');
      $company_postcodeEn = $this->post('company_postcodeEn');
      $company_addressEn = $this->post('company_addressEn');
      $company_provinceEn = $this->post('company_provinceEn');
      $company_districtEn = $this->post('company_districtEn');
      $company_subdistrictEn = $this->post('company_subdistrictEn');
      $contact_address = $this->post('contact_address');
      $contact_province = $this->post('contact_province');
      $contact_district = $this->post('contact_district');
      $contact_subdistrict = $this->post('contact_subdistrict');
      $contact_postcode = $this->post('contact_postcode');
      $member_title = $this->post('member_title');
      $member_cid = $this->post('member_cid');
      $member_nameTh = $this->post('member_nameTh');
      $member_midnameTh = $this->post('member_midnameTh');
      $member_lastnameTh = $this->post('member_lastnameTh');
      $member_nameEn = $this->post('member_nameEn');
      $member_midnameEn = $this->post('member_midnameEn');
      $member_lastnameEn = $this->post('member_lastnameEn');
      $member_birthday = $this->post('member_birthday');
      $member_email = $this->post('member_email');
      $member_tel = $this->post('member_tel');
      
      $data = [
        'company_nameTh' => $company_nameTh,
        'company_nameEn' => $company_nameEn,
        'company_tel' => $company_tel,
        'company_email' => $company_email,
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
        'member_birthday' => $member_birthday,
        'member_email' => $member_email,
        'member_tel' => $member_tel
      ];
      $stmt_ck = $this->db->prepare("SELECT * FROM tb_member_type3 WHERE member_id = ?");
      $stmt_ck->bind_param("s", $member_id);
      $stmt_ck->execute();
      $result_ck = $stmt_ck->get_result();
      $ck = $result_ck->fetch_assoc();
      // echo "<pre>";
      // var_dump($data,"2");
      // echo "</pre>";
      // die();
      try {
        $this->update('tb_member_type6', $data, '  member_id ="' . $member_id . '"');
        if($ck['member_cid'] != $member_cid){
          $save = [
            "status_laser_verify" => 0
          ];
           $this->update('tb_member', $save, '  member_id ="' . $member_id . '"');
        }
        $return = [
          'status' => '00',
          'message' => 'Success',
          'type' => $type,
          'member_id' => $member_id
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    }
    return $return;
  }


  function model_save_add()
  {
    $return = [
      'status' => '01',
      'message' => 'Edit Save fail'
    ];
    $mc_name = $this->post('mc_name');
    $client_id = $this->post('client_id');
    $redirect_uri = $this->post('redirect_uri');
    $status = $this->post('status');
    $type = $this->post('type');
    $portal = 0;
    $title = '';
    $des = '';
    if (!empty($this->post('portal')) && $this->post('portal') == 1) {
      $portal = $this->post('portal');
      $title = $this->post('title');
      $des = $this->post('des');

      if(isset($_FILES["img"]) && $_FILES["img"]["size"] > 0 ) {

         if ($_FILES["img"]["size"] >= 5242880 ) {
            $err = true;
         }

         $ints = date('YmhHis') . $this->random_char(7);

         if($_FILES["img"]["type"]=="image/png" || $_FILES["img"]["type"]=="image/x-png"){
            $imgsn = $ints.".png";
         }
         if($_FILES["img"]["type"]=="image/gif"){
            $imgsn = $ints.".gif";
         }elseif($_FILES["img"]["type"]=="image/pjpeg" || $_FILES["img"]["type"]=="image/jpeg"){
            $imgsn = $ints.".jpg";
         }

         if(!empty($imgsn) && !$err) {

            $path =  "asset/img/portal/{$imgsn}" ; 
            if (move_uploaded_file($_FILES["img"]["tmp_name"] , FILEPATH . $path  )) {
              $img = $path ;
            } else {
              return $return = [
                'status' => '01',
                'message' => 'อัพโหลดไฟล์ล้มแหลว ' . $path
              ];
            }
            

         } else {
            return $return = [
              'status' => '01',
              'message' => 'ไม่สามารถอัพโหลดรูปภาพได้ ไม่ได้มีการอัพโหลดรูปภาพ หรือรูปภาพมีขนาดใหญ่เกินกำหนด'
            ];
         }
      }

      $data = [
        'mc_name' => $mc_name,
        'client_id' => $client_id,
        'secret_key' => $mc_name,
        'jwt_signature' => $mc_name,
        'redirect_uri' => $redirect_uri,
        'status' => $status,
        'title' => $title,
        'des' => $des,
        'portal' => $portal,
        'img' => $img,
        'type' => $type
      ];
    } else {
      $data = [
        'mc_name' => $mc_name,
        'client_id' => $client_id,
        'secret_key' => $mc_name,
        'jwt_signature' => $mc_name,
        'redirect_uri' => $redirect_uri,
        'portal' => $portal,
        'status' => $status,
        'type' => $type
      ];
    }

    try {
      $this->insert('tb_merchant', $data);
      $return = [
        'status' => '00',
        'message' => 'Success'
      ];
    } catch (Exception $e) {
      $return = ['status' => '01', 'message' => $e];
    }

    return $return;
  }

  function model_delete_client() {
    $client_id = $this->post('client_id');
    $sql = "DELETE FROM tb_merchant WHERE mc_id = {$client_id}";
    $result = $this->query($sql);

    $return = [
      'res_code' => '00',
      'res_text' => 'Success'
    ];
    return $return;
  }

  function model_save_add_member()
  {
    $return = [
      'code' => '01',
      'message' => 'Edit Save fail'
    ];
    $cid = $this->post('cid');
    $password = $this->post('password');

    $member_title = $this->post('member_title');
    $member_nameTh = $this->post('member_nameTh');
    $member_lastnameTh = $this->post('member_lastnameTh');
    $addressTh = $this->post('addressTh');
    $provinceTh = $this->post('provinceTh');
    $districtTh = $this->post('districtTh');
    $subdistrictTh = $this->post('subdistrictTh');
    $postcode = $this->post('postcode');
    $email = $this->post('email');
    $tel = $this->post('tel');

    $sql = 'SELECT 1 FROM tb_member WHERE cid ="' . $cid . '" and status in(1,2)';
    $ck_cid = $this->query($sql);

    if (!empty($ck_cid)) {
      $return = [
        'code' => '01',
        'message' => 'User นี้มีอยู่แล้วในระบบ !'
      ];
    } else {

      $data_insert_member = [
        'member_app' => '0',
        'member_app_id' => '0',
        'cid' => $cid,
        'password' => sha1($password),
        'type' => '5',
        'status' => '1'
      ];

      $ss = '(SELECT MAX(t2.sso_id) from tb_member as t2)';
      $max_id = 'SUBSTRING(CASE WHEN ' . $ss . ' IS NOT NULL THEN ' . $ss . ' ELSE 0  END,6)';
      $this->set_insert('sso_id', "CONCAT( '1', '" . date('ym') . "', LPAD( " . $max_id . " +1,  8,   0 ) )");
      $ck_mem = $this->insert('tb_member', $data_insert_member);

      if (!empty($ck_mem)) {
        $sql_max = "SELECT MAX(member_id) AS member_id FROM tb_member";
        $result_max = $this->query($sql_max);
        $member_id = $result_max[0]['member_id'];

        $data_member_type5 = [
          'member_id' => $member_id,
          'member_title' => $member_title,
          'member_nameTh' => $member_nameTh,
          'member_lastnameTh' => $member_lastnameTh,
          'addressTh' => $addressTh,
          'provinceTh' => $provinceTh,
          'districtTh' => $districtTh,
          'subdistrictTh' => $subdistrictTh,
          'postcode' => $postcode,
          'email' => $email,
          'tel' => $tel
        ];

        try {
          $this->insert('tb_member_type5', $data_member_type5);
          $return = [
            'code' => '00',
            'message' => 'Success'
          ];
        } catch (Exception $e) {
          $return = ['code' => '01', 'message' => 'Edit Save fail'];
        }
      }
    }
    return $return;
  }

  function model_gen_client_id()
  {
    $digits = 7;
    while (1) {
      $number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
      $ssoid = "SS" . $number;
      //$ssoid = "ssoidtest";
      $sql = "SELECT client_id FROM tb_merchant WHERE client_id = '" . $ssoid . "'";
      $result = $this->query($sql);
      if (count($result) <= 0) {
        break;
      }
    }
    return $ssoid;
  }
  function model_text()
  {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => '".BASE_URL."api/TextCancel',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
                'ssoid' => '',
                'text_th' => '',
                'text_en' => ''
              ),
        CURLOPT_HTTPHEADER => array(
          'Cookie: PHPSESSID=vhtkaeghkopl02umobbjokr413'
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
  }
  function model_edit_note()
  {
      $return = [
        'res_code' => '400',
        'res_text' => 'error'
      ];
      $member_id = $this->post('member_id');
      $note = $this->post('note');
      $sql = "SELECT * FROM tb_member_note WHERE member_id = '" . $member_id . "'";
      $result = $this->query($sql);
        if(!empty($result)){
            $this->update('tb_member_note', ['note' => $note], '  member_id ="' . $member_id . '"');
            $return = [
              'res_code' => '200',
              'res_text' => 'success'
            ];
        }else{
            $tb_member_note = [
              'member_id' => $member_id,
              'note' => $note,
              'created_at' => date("Y-m-d H:m:s"),
            ];
            $this->insert("tb_member_note", $tb_member_note);
            $return = [
              'res_code' => '200',
              'res_text' => 'success'
            ];
        }
      return $return;
  }
  function model_edit_password()
  {
    $member_id = $this->post('member_id');
    $type = $this->post('type');
    $password = $this->post('password');

    if ($member_id == '' || $password == '') {
      $return = [
        'res_code' => '01',
        'res_text' => 'ข้อมูลไม่สมบูรณ์'
      ];
      return $return;
    }
    if($type == "corporate" || $type == "person"){
          $sql = "SELECT * FROM Member_drive_v3 WHERE UserID = '$member_id'";
          $result = $this->query($sql);

          $this->update('Member_drive_v3', ['PasswordSalt' => sha1($password)], '  UserID ="' . $member_id . '"');
    }else{
          #get member_cid
          $sql = "SELECT cid FROM tb_member WHERE member_id = '$member_id'";
          $result = $this->query($sql);
          $cid = $result[0]['cid'];

          #save log
          $data_log_reset = [
            'cid' => $cid,
            'id_admin' => $_SESSION['id_admin'],
            'ip_address' => $this->get_client_ip(),
          ];
          $this->insert("log_reset_password_by_admin", $data_log_reset);

          // if ($member_id == '' || $password == '') {
          //   $return = [
          //     'res_code' => '01',
          //     'res_text' => 'ข้อมูลไม่สมบูรณ์'
          //   ];
          //   return $return;
          // }

          $this->update('tb_member', ['password' => sha1($password)], '  member_id ="' . $member_id . '"');
    }
    
    $return = [
      'res_code' => '00',
      'res_text' => 'Success'
    ];
    return $return;
  }

  function model_edit_admin_password()
  {
    $id_admin = $this->post('id_admin');
    $password = $this->post('password');
   
    if ($id_admin == '' || $password == '') {
      $return = [
        'res_code' => '01',
        'res_text' => 'ข้อมูลไม่สมบูรณ์'
      ];
      return $return;
    }

          #get member_cid
          $sql = "SELECT * FROM tb_admin WHERE id_admin = '$id_admin'";
          $result = $this->query($sql);
          #save log
          $this->update('tb_admin', ['password' => sha1($password)], '  id_admin ="' . $id_admin . '"');
    
    $return = [
      'res_code' => '00',
      'res_text' => 'Success'
    ];
    return $return;
  }

  function model_data_table_news()
  {

    $text_search = $this->get('text_search');

    $limit = $this->get('limit');
    $offset = $this->get('offset');
    $sort = $this->get('sort');
    $order = $this->get('order');
    $range = " LIMIT $limit OFFSET $offset";

    $sql = "SELECT * FROM tb_news";
    $count = "SELECT * FROM tb_news";
    if ($text_search != '') {
      $sql = "SELECT * FROM tb_news WHERE n_title LIKE '%{$text_search}%' OR n_des LIKE '%{$text_search}%' ";
      $count = "SELECT * FROM tb_news WHERE n_title LIKE '%{$text_search}%' OR n_des LIKE '%{$text_search}%' ";
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
      $url = BASE_PATH . "office/edit_news?id=" . $result[$i]['n_id'];
      $col_arr['td1'] = htmlentities($n);
      $col_arr['n_title'] = htmlentities($result[$i]['n_title']);
      $col_arr['publicdate'] = htmlentities($result[$i]['publicdate']);
      $col_arr['createdate'] = htmlentities($result[$i]['createdate']);
      $col_arr['td5'] = "<span class=\"d-inline-flex align-items-center\"><a href='" . htmlentities($url) . "' class='btn sso-btn-edit mr-2'><i class='fa fa-pencil'></i></a>";
      $col_arr['td5'] .= "<a href='#' data-nid='".$result[$i]['n_id']."' class='btn sso-btn-del'><i class='fa fa-trash'></i></a></span>";
        array_push($data, $col_arr);
    }
    $data_array = array('total' => $total, 'rows' => $data );

    return $data_array;

  }

  function model_save_add_news () {
    $return = [
      'status' => '01',
      'message' => 'Add Save fail'
    ];
    $n_title = mysqli_real_escape_string($this->db, $this->post('n_title'));
    $n_des = $this->post('n_des');
    $publicdate = $this->post('publicdate');

    $data_news = [
      'n_title' => $n_title,
      'n_des' => $n_des,
      'publicdate' => $publicdate,
      'createdate' => date("Y-m-d H:i:s"),
      'updatedate' => date("Y-m-d H:i:s"),
    ];

    $this->insert('tb_news', $data_news);
    $return = [
      'status' => '00',
      'message' => 'Success'
    ];

    return $return;
  }

  function model_edit_news() {
    $n_id = $this->get('id');

    $sql = "SELECT * FROM tb_news WHERE n_id = {$n_id}";
    $result = $this->query($sql);

    return $result[0];
  }

  function model_save_edit_news () {
    $return = [
      'status' => '01',
      'message' => 'Edit Save fail'
    ];
    $n_title = mysqli_real_escape_string($this->db, $this->post('n_title'));
    $n_des = $this->post('n_des');
    $publicdate = $this->post('publicdate');
    $n_id = $this->post('n_id');
    $data_news = [
      'n_title' => $n_title,
      'n_des' => $n_des,
      'publicdate' => $publicdate,
      'updatedate' => date("Y-m-d H:i:s"),
    ];
    $this->update('tb_news', $data_news, '  n_id ="' . $n_id . '"');
    $return = [
      'status' => '00',
      'message' => 'Success'
    ];

    return $return;
  }

  function model_delete_news() {
    $return = [
      'status' => '01',
      'message' => 'เกิดข้อผิดพลาด กรุณาลองอีกครั้ง!'
    ];
    $n_id = $this->post('n_id');

    if (empty($n_id)) {
        return $return;
    }

    $sql = "DELETE FROM tb_news WHERE n_id = {$n_id}";
    $result = $this->query($sql);

    $return = [
      'status' => '00',
      'message' => 'Success'
    ];
    return $return;
  }

  function sumdata($data)
  {
    $NEA_arr = array();
    for ($i = 0; $i < count($data); $i++) {
      $NEA = $data[$i]['CN'];
      array_push($NEA_arr, $NEA);
      $NEA_SUM = array_sum($NEA_arr);
    }
    return $NEA_SUM;
  }
  function SSO_Account()
  {
    $yearNow = date('Y-m-d');
    $Past = $yearNow - 2;
    $yearPast = $Past . '-01-01';
    // $sql = 'SELECT COUNT( tb_member.member_id ) AS CN,tb_member.TYPE ,tb_member_app_id. create_date  
    //         FROM `tb_member` LEFT JOIN tb_member_app_id ON tb_member.member_id = tb_member_app_id.member_id
    //         WHERE tb_member_app_id.create_date BETWEEN "'.$yearPast.'" AND "'.$yearNow.'" AND tb_member.TYPE != 5 group by tb_member.TYPE';
    $sql = 'SELECT COUNT(DISTINCT c.member_id ) as CN FROM  tb_member c WHERE  c.member_id <> 0 GROUP BY c.type';
    $All = $this->query($sql);
    $arr['All'] = $this->sumdata($All);

    $sql = 'SELECT c.type,COUNT(DISTINCT c.member_id ) as CN FROM  tb_token b LEFT JOIN tb_member c ON b.member_id = c.member_id 
             WHERE  c.type != 5  AND c.member_id <> 0 AND b.create_date BETWEEN "' . $yearPast . '" AND "' . $yearNow . '" GROUP BY c.type';
    $total = $this->query($sql);
    $arr['total'] = $this->sumdata($total);
    ($arr['total'] > $arr['All']) ? $Inactive = $arr['total'] - $arr['All'] : $Inactive =  $arr['All'] - $arr['total'];
    $arr['Inactive'] = $Inactive;

    foreach ($total as $key => $item) {
      $arr['Account'][] = [
        'persent' => round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP),
        'sum' => $item['CN'],
        'type' => $item['type'],
      ];
    }
    $sql = 'SELECT c.type,COUNT(DISTINCT c.member_id ) as CN,COUNT(DISTINCT c.member_id ) as Active FROM  tb_token b LEFT JOIN tb_member c ON b.member_id = c.member_id 
            WHERE c.type IN (1,2,6)  AND c.member_id <> 0 AND b.create_date BETWEEN "' . $yearPast . '" AND "' . $yearNow . '"';
    $niti = $this->query($sql);
    foreach ($niti as $key => $item) {
      $arr['sum'][] = $item['CN'];
      $arr['active']['niti'] = [
        "value" => $item['Active'],
        "persent" => round(($item['Active'] / $arr['All']) * 100, 2, PHP_ROUND_HALF_UP),
      ];
      $arr['data'][] = [
        'name' => 'นิติบุคล',
        'y' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
        'z' => 100,
        'color' => '#2D6DC4',
      ];
    }

    $sql = 'SELECT c.type,COUNT(DISTINCT c.member_id ) as CN ,COUNT(DISTINCT c.member_id ) as Active FROM  tb_token b LEFT JOIN tb_member c ON b.member_id = c.member_id 
             WHERE c.type IN (3,4)  AND c.member_id <> 0 AND b.create_date BETWEEN "' . $yearPast . '" AND "' . $yearNow . '" ';
    $person = $this->query($sql);
    foreach ($person as $key => $item) {
      $arr['sum'][1] = $item['CN'];
      $arr['active']['person'] = [
        "value" => $item['Active'],
        "persent" => round(($item['Active'] /  $arr['All']) * 100, 2, PHP_ROUND_HALF_UP),
      ];
      $arr['data'][1] = [
        'name' => 'บุคคลทั่วไป',
        'y' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
        'z' => 100,
        'color' => '#1B4176',
      ];
    }
    $arr['export'] = [
      [
        '0' => 'นิติบุคล',
        '1' => $arr['sum'][0],
      ],
      [
        '0' => 'จดทะเบียนกับกรมพัฒนาธุรกิจการค้า',
        '1' => $arr['Account'][0]['sum'],
      ],
      [
        '0' => 'ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า',
        '1' => $arr['Account'][4]['sum'],
      ],
      [
        '0' => 'นิติบุคคลในต่างประเทศ',
        '1' => $arr['Account'][1]['sum'],
      ],
      [
        '0' => 'Active Accounts',
        '1' => $arr['active']['niti']['value'],
      ],
      [
        '0' => 'บุคคลทั่วไป',
        '1' => $arr['sum'][1],
      ],
      [
        '0' => 'บุคคลทั่วไปไทย',
        '1' => $arr['Account'][2]['sum'],
      ],
      [
        '0' => 'บุคคลต่างชาติ',
        '1' => $arr['Account'][3]['sum'],
      ],
      [
        '0' => 'Active Accounts',
        '1' => $arr['active']['person']['value'],
      ],
      [
        '0' => 'รวม',
        '1' => $arr['total']
      ]

    ];
    $arr['export2'] = [
      [
        '0' => 'corporation',
        '1' => $arr['sum'][0],
      ],
      [
        '0' => 'Registered with Department of Business Development',
        '1' => $arr['Account'][0]['sum'],
      ],
      [
        '0' => 'Not registered with Department of Business Development',
        '1' => $arr['Account'][4]['sum'],
      ],
      [
        '0' => 'Foreign juristic person',
        '1' => $arr['Account'][1]['sum'],
      ],
      [
        '0' => 'Active Accounts',
        '1' => $arr['active']['niti']['value'],
      ],
      [
        '0' => 'General individual',
        '1' => $arr['sum'][1],
      ],
      [
        '0' => 'Thai people',
        '1' => $arr['Account'][2]['sum'],
      ],
      [
        '0' => 'Foreign person',
        '1' => $arr['Account'][3]['sum'],
      ],
      [
        '0' => 'Active Accounts',
        '1' => $arr['active']['person']['value'],
      ],
      [
        '0' => 'Total',
        '1' => $arr['total']
      ]

    ];
    $response = [
      'message' => 'success',
      'res_result' => $arr
    ];

    return $arr;
  }
  function Log_niti($client_id , $yearPast, $yearNow) {
    $sql = 'SELECT COUNT(*) as CN ,cc.mc_name,cc.client_id ,cc.jwt_signature FROM (SELECT bb.* ,tb_merchant.mc_name,tb_merchant.jwt_signature FROM (SELECT aa.*,tb_member.type FROM(SELECT * FROM `tb_token` where  (client_id  IN ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726"))  GROUP BY member_id ORDER BY `tb_token`.`create_date` DESC ) aa 
            LEFT JOIN tb_member ON tb_member.member_id = aa.member_id) bb  INNER JOIN tb_merchant ON bb.client_id = tb_merchant.client_id)cc where (cc.create_date BETWEEN  "' . $yearPast . '" and  "' . $yearNow . '") AND cc.type NOT IN (3,4,5)  AND  cc.client_id = "'.$client_id.'"  GROUP BY cc.mc_name';
            
      
    $niti = $this->query($sql);

    return $niti[0];
  }
  function statisticsLog_App($data)
  {
    $yearNow = date('Y-m-d');
    $Past = date('m') - 3;
    if (str_replace(['0', '-1', '-2'], ['12', '11', '10'], $Past) < '10') {
      $yearPast = date('Y-0') . str_replace(['0', '-1', '-2'], ['12', '11', '10'], $Past) . '-01';
    } else {
      $yearPast = (date('Y') - 1) . '-' . str_replace(['0', '-1', '-2'], ['12', '11', '10'], $Past) . '-01';
    }
    // $sql = 'SELECT a.client_id,a.jwt_signature,COUNT(DISTINCT c.member_id ) as CN FROM tb_merchant a LEFT JOIN tb_token b ON a.client_id = b.client_id 
    //         LEFT JOIN tb_member c ON b.member_id = c.member_id WHERE c.sso_id <> 0 AND c.create_date BETWEEN "' . $yearPast . '" AND "' . $yearNow . '" GROUP BY a.client_id';
    // $sql_niti = 'SELECT a.client_id,a.jwt_signature,COUNT(DISTINCT c.member_id ) as CN FROM tb_merchant a LEFT JOIN tb_token b ON a.client_id = b.client_id 
    //         LEFT JOIN tb_member c ON b.member_id = c.member_id WHERE c.type NOT IN (3,4,5)
    //         AND c.sso_id <> 0 AND c.create_date BETWEEN "' . $yearPast . '" AND "' . $yearNow . '" GROUP BY a.client_id'; 
    
    $sql = 'SELECT COUNT(*) as CN ,cc.mc_name,cc.client_id ,cc.jwt_signature FROM (SELECT bb.* ,tb_merchant.mc_name,tb_merchant.jwt_signature FROM (SELECT aa.*,tb_member.type FROM(SELECT * FROM `tb_token` where  (client_id  IN ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726"))  GROUP BY member_id ORDER BY `tb_token`.`create_date` DESC ) aa 
            LEFT JOIN tb_member ON tb_member.member_id = aa.member_id) bb  INNER JOIN tb_merchant ON bb.client_id = tb_merchant.client_id)cc where (cc.create_date BETWEEN  "' . $yearPast . '" and  "' . $yearNow . '") AND cc.type != 5  GROUP BY cc.mc_name';
    $sql_niti = 'SELECT COUNT(*) as CN ,cc.mc_name,cc.client_id ,cc.jwt_signature FROM (SELECT bb.* ,tb_merchant.mc_name,tb_merchant.jwt_signature FROM (SELECT aa.*,tb_member.type FROM(SELECT * FROM `tb_token` where  (client_id  IN ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726"))  GROUP BY member_id ORDER BY `tb_token`.`create_date` DESC ) aa 
    LEFT JOIN tb_member ON tb_member.member_id = aa.member_id) bb  INNER JOIN tb_merchant ON bb.client_id = tb_merchant.client_id)cc where (cc.create_date BETWEEN  "' . $yearPast . '" and  "' . $yearNow . '") AND cc.type NOT IN (3,4,5)  GROUP BY cc.mc_name';   
    
    $total = $this->query($sql);
    $total_niti = $this->query($sql_niti);
    $arr['total'] = $this->sumdata($total);
    $arr['total_niti'] = $this->sumdata($total_niti);
    $arr['startDate'] = $yearPast;
    $arr['endDate'] = $yearNow;

    foreach ($total as $key => $item) {
      switch ($item['client_id']) {
        case 'SS0047423':
          $niti_c = $this->Log_niti($item['client_id'], $yearPast, $yearNow);
          $arr['data'][$key] = [
            'name' => 'DITP-ONE',
            'niti' => $niti_c['CN'],
            'nitiPercent' => round(($niti_c['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'SS3214573':
          $niti_c = $this->Log_niti($item['client_id'], $yearPast, $yearNow);
          $arr['data'][$key] = [
            'name' => 'SME-Proactive',
            'niti' => $niti_c['CN'],
            'nitiPercent' => round(($niti_c['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'ssocareid':
          $niti_c = $this->Log_niti($item['client_id'], $yearPast, $yearNow);
          $arr['data'][$key] = [
            'name' => 'DITP-CARE',
            'niti' => $niti_c['CN'],
            'nitiPercent' => round(($niti_c['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'SS3871575':
          $niti_c = $this->Log_niti($item['client_id'], $yearPast, $yearNow);
          $arr['data'][$key] = [
            'name' => 'T-Mark',
            'niti' => $niti_c['CN'],
            'nitiPercent' => round(($niti_c['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'ssonticlient':
          $niti_c = $this->Log_niti($item['client_id'], $yearPast, $yearNow);
          $arr['data'][$key] = [
            'name' => 'DITP-DRIVE',
            'niti' => $niti_c['CN'],
            'nitiPercent' => round(($niti_c['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'SS1639726':
          $niti_c = $this->Log_niti($item['client_id'], $yearPast, $yearNow);
          $arr['data'][$key] = [
            'name' => 'E-Academy',
            'niti' => $niti_c['CN'],
            'nitiPercent' => round(($niti_c['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
      }
    }
    
    $sql = 'SELECT COUNT(*) as CN ,cc.mc_name,cc.client_id ,cc.jwt_signature FROM (SELECT bb.* ,tb_merchant.mc_name,tb_merchant.jwt_signature FROM (SELECT aa.*,tb_member.type FROM(SELECT * FROM `tb_token` where  (client_id  IN ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726"))  GROUP BY member_id ORDER BY `tb_token`.`create_date` DESC ) aa 
            LEFT JOIN tb_member ON tb_member.member_id = aa.member_id) bb  INNER JOIN tb_merchant ON bb.client_id = tb_merchant.client_id)cc where (cc.create_date BETWEEN  "' . $yearPast . '" and  "' . $yearNow . '") AND cc.type  IN (3,4)  GROUP BY cc.mc_name';

    //(empty($da['etc']['JURISTICNAME'])) ? '' : trim($da['etc']['JURISTICNAME'])
    $person = $this->query($sql);
    $arr['total_person'] = $this->sumdata($person);
    foreach ($person as $key => $item) {
      switch ($item['client_id']) {
        case 'SS0047423':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'SS3214573':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'ssocareid':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'SS3871575':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'ssonticlient':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'SS1639726':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
      }
    }

    // print_r($arr['data'][1]);
    // die();
    return $arr;
  }
  function searchData()
  {
    $data1 = $this->post('thaiYear');
    $data2 = $this->post('year_budget');
    $data3 = $this->post('start_date');
    $data4 = $this->post('end_date');
    $data = $this->post('data');
    // SELECT COUNT(DISTINCT tb_token.member_id) as  CN,tb_merchant.mc_name,tb_merchant.client_id ,tb_merchant.jwt_signature  FROM `tb_member`  INNER JOIN tb_token  ON  tb_member.member_id = tb_token.member_id  LEFT JOIN   tb_merchant ON  tb_token.client_id = tb_merchant.client_id 
    // WHERE  tb_member.type  != 5 AND tb_token.client_id IN  ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726")  AND  tb_token.create_date >= '2020-07-01' AND  tb_token.create_date <= '2022-09-30'  GROUP BY tb_token.client_id
    $sql = 'SELECT COUNT(DISTINCT tb_token.member_id) as  CN,tb_merchant.mc_name,tb_merchant.client_id ,tb_merchant.jwt_signature  FROM `tb_member`  
            INNER JOIN tb_token  ON  tb_member.member_id = tb_token.member_id  LEFT JOIN   tb_merchant ON  tb_token.client_id = tb_merchant.client_id 
            WHERE  tb_member.type  != 5 AND tb_token.client_id IN ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726")';
    if ($data3 != '' && $data4 != '') {
      $sql = $sql . ' AND (tb_token.create_date BETWEEN "' . $data3 . '" AND "' . $data4 . '")  GROUP BY tb_merchant.mc_name';
    } 
    if ($data1 != '') {
      $sql = $sql . ' AND (tb_token.create_date BETWEEN "' . $data1 .'-01-01'. '" AND "' . $data1 . '-12-30")  GROUP BY tb_merchant.mc_name';
    }
    if ($data2 != '') {
      $sql = $sql . ' AND (tb_token.create_date BETWEEN "' . ($data2-1) .'-10-01'. '" AND "' . $data2 . '-09-30")  GROUP BY tb_merchant.mc_name';
    }

    $total = $this->query($sql);
    if (count($total) <= 0) {
      $response = [
        'message' => 'No data',
      ];
      return $response;
    }
    $arr['total'] = $this->sumdata($total);
    foreach ($total as $key => $item) {
      switch ($item['client_id']) {
        case 'SS0047423':
          $arr['data'][$key] = [
            'name' => 'DITP-ONE',
            'niti' => 0,
            'nitiPercent' => 0,
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'SS3214573':
          $arr['data'][$key] = [
            'name' => 'SME-Proactive',
            'niti' => 0,
            'nitiPercent' => 0,
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'ssocareid':
          $arr['data'][$key] = [
            'name' => 'DITP-CARE',
            'niti' => 0,
            'nitiPercent' => 0,
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'SS3871575':
          $arr['data'][$key] = [
            'name' => 'T-Mark',
            'niti' => 0,
            'nitiPercent' => 0,
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'ssonticlient':
          $arr['data'][$key] = [
            'name' => 'DITP-DRIVE',
            'niti' => 0,
            'nitiPercent' => 0,
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
        case 'SS1639726':
          $arr['data'][$key] = [
            'name' => 'E-Academy',
            'niti' => 0,
            'nitiPercent' => 0,
            'person' => 0,
            'personPercent' => 0,
            'total' => $item['CN'],
            'TotalPercent' => round(($item['CN'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP),
          ];
          break;
      }
    }
  
    // $sql = 'SELECT COUNT(*) as CN ,cc.mc_name,cc.client_id ,cc.jwt_signature FROM (SELECT bb.* ,tb_merchant.mc_name,tb_merchant.jwt_signature FROM (SELECT aa.*,tb_member.type FROM(SELECT * FROM `tb_token` where  (client_id  IN ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726"))  GROUP BY member_id ORDER BY `tb_token`.`create_date` DESC ) aa 
    //         LEFT JOIN tb_member ON tb_member.member_id = aa.member_id) bb  INNER JOIN tb_merchant ON bb.client_id = tb_merchant.client_id)cc  WHERE  cc.type IN (1,2,6) ';
    //    if ($data3 != '' && $data4 != '') {
    //     $sql = $sql . ' AND (cc.create_date BETWEEN "' . $data3 . '" AND "' . $data4 . '")  GROUP BY cc.mc_name';
    //   } 
    //   if ($data1 != '') {
    //     $sql = $sql . ' AND (cc.create_date BETWEEN "' . $data1 .'-01-01'. '" AND "' . $data1 . '-12-30")  GROUP BY cc.mc_name';
    //   }
    //   if ($data2 != '') {
    //     $sql = $sql . ' AND (cc.create_date BETWEEN "' . ($data2-1) .'-10-01'. '" AND "' . $data2 . '-09-30")  GROUP BY cc.mc_name';
    //   }

      $sql = 'SELECT COUNT(DISTINCT tb_token.member_id) as  CN,tb_merchant.mc_name,tb_merchant.client_id ,tb_merchant.jwt_signature  FROM `tb_member`  
      INNER JOIN tb_token  ON  tb_member.member_id = tb_token.member_id  LEFT JOIN   tb_merchant ON  tb_token.client_id = tb_merchant.client_id 
      WHERE  tb_member.type  IN (1,2,6) AND tb_token.client_id IN ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726")';
      if ($data3 != '' && $data4 != '') {
      $sql = $sql . ' AND (tb_token.create_date BETWEEN "' . $data3 . '" AND "' . $data4 . '")  GROUP BY tb_merchant.mc_name';
      } 
      if ($data1 != '') {
      $sql = $sql . ' AND (tb_token.create_date BETWEEN "' . $data1 .'-01-01'. '" AND "' . $data1 . '-12-30")  GROUP BY tb_merchant.mc_name';
      }
      if ($data2 != '') {
      $sql = $sql . ' AND (tb_token.create_date BETWEEN "' . ($data2-1) .'-10-01'. '" AND "' . $data2 . '-09-30")  GROUP BY tb_merchant.mc_name';
      }

    $niti = $this->query($sql);
    $arr['total_niti'] = $this->sumdata($niti);
    foreach ($niti as $key => $item) {
      switch ($item['client_id']) {
        case 'SS0047423':
          $arr['data'][$key]['niti'] = $item['CN'];
          $arr['data'][$key]['nitiPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'SS3214573':
          $arr['data'][$key]['niti'] = $item['CN'];
          $arr['data'][$key]['nitiPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'ssocareid':
          $arr['data'][$key]['niti'] = $item['CN'];
          $arr['data'][$key]['nitiPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'SS3871575':
          $arr['data'][$key]['niti'] = $item['CN'];
          $arr['data'][$key]['nitiPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'ssonticlient':
          $arr['data'][$key]['niti'] = $item['CN'];
          $arr['data'][$key]['nitiPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'SS1639726':
          $arr['data'][$key]['niti'] = $item['CN'];
          $arr['data'][$key]['nitiPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
      }
    }
    // $sql = 'SELECT COUNT(*) as CN ,cc.mc_name,cc.client_id ,cc.jwt_signature FROM (SELECT bb.* ,tb_merchant.mc_name,tb_merchant.jwt_signature FROM (SELECT aa.*,tb_member.type FROM(SELECT * FROM `tb_token` where  (client_id  IN ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726"))  GROUP BY member_id ORDER BY `tb_token`.`create_date` DESC ) aa 
    //         LEFT JOIN tb_member ON tb_member.member_id = aa.member_id) bb  INNER JOIN tb_merchant ON bb.client_id = tb_merchant.client_id)cc  WHERE  cc.type IN (3,4) ';
    //   if ($data3 != '' && $data4 != '') {
    //     $sql = $sql . ' AND (cc.create_date BETWEEN "' . $data3 . '" AND "' . $data4 . '")  GROUP BY cc.mc_name';
    //   } 
    //   if ($data1 != '') {
    //     $sql = $sql . ' AND (cc.create_date BETWEEN "' . $data1 .'-01-01'. '" AND "' . $data1 . '-12-30")  GROUP BY cc.mc_name';
    //   }
    //   if ($data2 != '') {
    //     $sql = $sql . ' AND (cc.create_date BETWEEN "' . ($data2-1) .'-10-01'. '" AND "' . $data2 . '-09-30")  GROUP BY cc.mc_name';
    //   } 
    $sql = 'SELECT COUNT(DISTINCT tb_token.member_id) as  CN,tb_merchant.mc_name,tb_merchant.client_id ,tb_merchant.jwt_signature  FROM `tb_member`  
    INNER JOIN tb_token  ON  tb_member.member_id = tb_token.member_id  LEFT JOIN   tb_merchant ON  tb_token.client_id = tb_merchant.client_id 
    WHERE  tb_member.type  IN (3,4) AND tb_token.client_id IN ("SS0047423","SS3214573","ssocareid","SS3871575","ssonticlient","SS1639726")';
    if ($data3 != '' && $data4 != '') {
    $sql = $sql . ' AND (tb_token.create_date BETWEEN "' . $data3 . '" AND "' . $data4 . '")  GROUP BY tb_merchant.mc_name';
    } 
    if ($data1 != '') {
    $sql = $sql . ' AND (tb_token.create_date BETWEEN "' . $data1 .'-01-01'. '" AND "' . $data1 . '-12-30")  GROUP BY tb_merchant.mc_name';
    }
    if ($data2 != '') {
    $sql = $sql . ' AND (tb_token.create_date BETWEEN "' . ($data2-1) .'-10-01'. '" AND "' . $data2 . '-09-30")  GROUP BY tb_merchant.mc_name';
    }    
   
    $person = $this->query($sql);
    $arr['total_person'] = $this->sumdata($person);
    foreach ($person as $key => $item) {
      switch ($item['client_id']) {
        case 'SS0047423':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'SS3214573':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'ssocareid':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'SS3871575':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'ssonticlient':
          $arr['data'][$key]['person'] = $item['CN'];
          $arr['data'][$key]['personPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
        case 'SS1639726':
          $arr['data'][$key]['niti'] = $item['CN'];
          $arr['data'][$key]['nitiPercent'] = round(($item['CN'] / $arr['total']) * 100, 2, PHP_ROUND_HALF_UP);
          break;
      }
    }
    return $arr;
  }
  function ChartConfirm()
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://one.ditp.go.th/api/ConfirmONE',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response)->res_result;
    $arr['total'] = $data->Confirm->total + $data->UnConfirm->total;
    $arr['Confirm'] = $data->Confirm->total;
    $arr['UnConfirm'] = $data->UnConfirm->total;

    return $arr;
  }
  function ChartTypeMember()
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://one.ditp.go.th/apistaff/drive/elil/main',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $response = curl_exec($curl);
    curl_close($curl);  
    $response = json_decode($response); 
    $total =  $response->res_result_row_1->total;
    $active_member =  $response->res_result_row_1->active_member;
    $not_active_member =  ($total - $active_member);
    // $sql = "SELECT * FROM  ChartTypeMemberV1 ";
    // $total = $this->query($sql);
    $arr['total'] = $total;//= $this->sumdata($total);
    foreach ($response->res_result_row_2 as $key => $item) {
      switch ($item->PropertyName) {
        case 'EL':
          $Count['EL'] = $item->all;
          break;
        case 'Pre-EL':
          $Count['Pre-EL'] = $item->all;
          break;
        case 'Pre-TDC':
          $Count['Pre-TDC'] = $item->all;
          break;
        case 'TDC':
          $Count['TDC'] = $item->all;
          break;
        case 'LSP':
          $Count['LSP'] = $item->all;
          break;
      }
    }
    
    $curl_active = curl_init();
    curl_setopt_array($curl_active, array(
      CURLOPT_URL => 'https://oneuat.ditp.go.th/apistaff/member_el',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $response_active = curl_exec($curl_active);
    curl_close($curl_active);
    $active = json_decode($response_active); 
    // $sql = "SELECT *FROM  ChartTypeMemberV2";
    // $active = $this->query($sql);
    $arr['active_member'] = $active_member;//$this->sumdata($active);
    $arr['not_active_member'] = $not_active_member;//$arr['total'] - $arr['active_member'];
    foreach ($active->res_result->data as $key => $item) {
      switch ($item->Property_Name) {
        case 'EL':
          $arr['name'][] = $item->Property_Name;
          $arr['active']['Count'][] = $item->CN;
          $arr['inactive']['Count'][] = (intval(str_replace(',','',$Count['EL'])) > $item->CN) ? intval(str_replace(',','',$Count['EL'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['EL']));
          $arr['export']['name'][] = $item->Property_Name;
          $arr['export']['active'][] = $item->CN;
          $arr['export']['inactive'][] = (intval(str_replace(',','',$Count['EL'])) > $item->CN) ? intval(str_replace(',','',$Count['EL'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['EL']));
          $arr['export2'][] = [
            'name' => $item->Property_Name,
            'active' => $item->CN,
            'inactive' => (intval(str_replace(',','',$Count['EL'])) > $item->CN) ? intval(str_replace(',','',$Count['EL'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['EL']))
          ];
          break;
        case 'Pre-EL':
          $arr['name'][] = $item->Property_Name;
          $arr['active']['Count'][] = $item->CN;
          $arr['inactive']['Count'][] = (intval(str_replace(',','',$Count['Pre-EL'])) > $item->CN) ? intval(str_replace(',','',$Count['Pre-EL'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['Pre-EL']));
          $arr['export']['name'][] = $item->Property_Name;
          $arr['export']['active'][] = $item->CN;
          $arr['export']['inactive'][] = (intval(str_replace(',','',$Count['Pre-EL'])) > $item->CN) ? intval(str_replace(',','',$Count['Pre-EL'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['Pre-EL']));
          $arr['export2'][] = [
            'name' => $item->Property_Name,
            'active' => $item->CN,
            'inactive' => (intval(str_replace(',','',$Count['Pre-EL'])) > $item->CN) ? intval(str_replace(',','',$Count['Pre-EL'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['Pre-EL']))
          ];
          break;
        case 'Pre-TDC':
          $arr['name'][] = $item->Property_Name;
          $arr['active']['Count'][] = $item->CN;
          $arr['inactive']['Count'][] = (intval(str_replace(',','',$Count['Pre-TDC'])) > $item->CN) ? intval(str_replace(',','',$Count['Pre-TDC'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['Pre-TDC']));
          $arr['export']['name'][] = $item->Property_Name;
          $arr['export']['active'][] = $item->CN;
          $arr['export']['inactive'][] = (intval(str_replace(',','',$Count['Pre-TDC'])) > $item->CN) ? intval(str_replace(',','',$Count['Pre-TDC'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['Pre-TDC']));
          $arr['export2'][] = [
            'name' => $item->Property_Name,
            'active' => $item->CN,
            'inactive' => (intval(str_replace(',','',$Count['Pre-TDC'])) > $item->CN) ? intval(str_replace(',','',$Count['Pre-TDC'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['Pre-TDC']))
          ];
          break;
        case 'TDC':
          $arr['name'][] = $item->Property_Name;
          $arr['active']['Count'][] = $item->CN;
          $arr['inactive']['Count'][] = (intval(str_replace(',','',$Count['TDC'])) > $item->CN) ? intval(str_replace(',','',$Count['TDC'])) - $item->CN : $item->CN -  intval(str_replace(',','',$Count['TDC']));
          $arr['export']['name'][] = $item->Property_Name;
          $arr['export']['active'][] = $item->CN;
          $arr['export']['inactive'][] = (intval(str_replace(',','',$Count['TDC'])) > $item->CN) ? intval(str_replace(',','',$Count['TDC'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['TDC']));
          $arr['export2'][] = [
            'name' => $item->Property_Name,
            'active' => $item->CN,
            'inactive' => (intval(str_replace(',','',$Count['TDC'])) > $item->CN) ? intval(str_replace(',','',$Count['TDC'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['TDC']))
          ];
          break;
        case 'LSP':
          $arr['name'][] = $item->Property_Name;
          $arr['active']['Count'][] = $item->CN;
          $arr['inactive']['Count'][] = (intval(str_replace(',','',$Count['LSP'])) > $item->CN) ? intval(str_replace(',','',$Count['LSP'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['LSP']));
          $arr['export']['name'][] = $item->Property_Name;
          $arr['export']['active'][] = $item->CN;
          $arr['export']['inactive'][] = (intval(str_replace(',','',$Count['LSP'])) > $item->CN) ? intval(str_replace(',','',$Count['LSP'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['LSP']));
          $arr['export2'][] = [
            'name' => $item->Property_Name,
            'active' => $item->CN,
            'inactive' => (intval(str_replace(',','',$Count['LSP'])) > $item->CN) ? intval(str_replace(',','',$Count['LSP'])) - $item->CN : $item->CN - intval(str_replace(',','',$Count['LSP']))
          ];
          break;
      }
    }
    return json_encode($arr);
  }
  function ChartTypeMemberV2()
  {
    $DROP = "DROP TABLE  ChartTypeMemberV1";
    if ($this->query($DROP) === FALSE) {
      echo "Failed to connect to MySQL: " . $this->error;
      die();
    }
    $sql = "SELECT  b.Property_Name, COUNT(DISTINCT b.User_ID) as CN FROM  tb_member a LEFT JOIN ditpstaff_member_main b ON  a.cid = b.User_ID WHERE b.User_ID  IS NOT NULL  AND b.Property_Name != 'OTHER' GROUP BY b.Property_Name";
    $total = $this->query($sql);
    foreach ($total as $key => $item) {
      $sqlC = "CREATE TABLE ChartTypeMemberV1 AS (SELECT  b.Property_Name, COUNT(DISTINCT b.User_ID) as CN FROM  tb_member a LEFT JOIN ditpstaff_member_main b ON  a.cid = b.User_ID WHERE b.User_ID  IS NOT NULL  AND b.Property_Name != 'OTHER' GROUP BY b.Property_Name)";
      if ($this->query($sqlC) === FALSE) {
        echo "Failed to connect to MySQL: " . $this->error;
        die();
      }
    }
    return 'Success';
  }
  function ChartType()
  {
    $DROP = "DROP TABLE  ChartTypeMemberV2";
    if ($this->query($DROP) === FALSE) {
      echo "Failed to connect to MySQL: " . $this->error;
      die();
    }
    $sql = "SELECT  b.Property_Name, COUNT(DISTINCT b.User_ID) as CN FROM  tb_member a LEFT JOIN ditpstaff_member_main b ON  a.cid = b.User_ID WHERE b.User_ID  IS NOT NULL  AND b.Property_Name != 'OTHER'  AND  Year(b.Modify_Date) = '" . date("Y") . "' OR  Year(b.Modify_Date) = '" . (date("Y") + 543) . "'  OR  Year(b.Modify_Date) =  '" . (date("Y") - 1) . "' OR  Year(b.Modify_Date) = '" . ((date("Y") - 1) + 543) . "'    GROUP BY b.Property_Name";
    $active = $this->query($sql);
    foreach ($active as $key => $item) {
      $sqlC = "CREATE TABLE ChartTypeMemberV2 AS (SELECT  b.Property_Name, COUNT(DISTINCT b.User_ID) as CN FROM  tb_member a LEFT JOIN ditpstaff_member_main b ON  a.cid = b.User_ID WHERE b.User_ID  IS NOT NULL  AND b.Property_Name != 'OTHER'  AND  Year(b.Modify_Date) = '" . date("Y") . "' OR  Year(b.Modify_Date) = '" . (date("Y") + 543) . "'  OR  Year(b.Modify_Date) =  '" . (date("Y") - 1) . "' OR  Year(b.Modify_Date) = '" . ((date("Y") - 1) + 543) . "'    GROUP BY b.Property_Name)";
      if ($this->query($sqlC) === FALSE) {
        echo "Failed to connect to MySQL: " . $this->error;
        die();
      }
    }
    return 'Success';
  }
  // 
  // 
  // 
  // 
  function Regios()
  {
    $data1 = $this->post('thaiYear');
    $data2 = $this->post('year_budget');
    $data3 = $this->post('start_date');
    $data4 = $this->post('end_date');
    if($data3 != '' && $data4 != ''){
      $yearNow = $data4;
      $yearPast = $data3;
    }else if($data1 != ''){
      $yearNow = $data1 .'-12-31';
      $yearPast = $data1 .'-01-01';
    }else if($data2 != ''){
      $yearPast = ($data2-1) .'-10-01';
      $yearNow = $data2 . '-09-30';
    }else{
      $yearNow = date('Y-m-d');
      $Past = date('m') - 3;
      if (str_replace(['0', '-1', '-2'], ['12', '11', '10'], $Past) < '10') {
        $yearPast = date('Y-0') . str_replace(['0', '-1', '-2'], ['12', '11', '10'], $Past) . '-01';
      } else {
        $yearPast = (date('Y') - 1) . '-' . str_replace(['0', '-1', '-2'], ['12', '11', '10'], $Past) . '-01';
      }
    }

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
    LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
    WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND tb_member_type1.`contact_province` IN ('Bangkok','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon') 
    UNION ALL
    SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
    LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
    WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('Bangkok','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon')
    UNION ALL
    SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
    LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
    WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon')";
    $person = $this->query($sql);
    // var_dump($sql,$person);
    // die;
  
    $arr['Krungthep'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE  (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon')";
    $personNiti = $this->query($sql);
    $arr['KrungthepNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE  (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon')";
    $personPerson = $this->query($sql);
    $arr['KrungthepPerson'] = $this->sumdata($personPerson);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
                WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี') 
                UNION ALL
                SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
                WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')
                UNION ALL
                SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
                WHERE  (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')";
    $person = $this->query($sql);
    $arr['Central'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')";
    $personNiti = $this->query($sql);
    $arr['CentralNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')";
    $personPerson = $this->query($sql);
    $arr['CentralPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
                WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์') 
                UNION ALL
                SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
                WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์')
                UNION ALL
                SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
                WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์')";
    $person = $this->query($sql);
    $arr['North'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์')";
    $personNiti = $this->query($sql);
    $arr['NorthNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์')";
    $personPerson = $this->query($sql);
    $arr['NorthPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND tb_member_type6.`contact_province` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร')
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร')";
    $person = $this->query($sql);
    $arr['Northeast'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร')";
    $personNiti = $this->query($sql);
    $arr['NortheastNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร')";
    $personPerson = $this->query($sql);
    $arr['NortheastPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์')
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์')";
    $person = $this->query($sql);
    $arr['West'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์')";
    $personNiti = $this->query($sql);
    $arr['WestNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์')";
    $personPerson = $this->query($sql);
    $arr['WestPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว')
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว')";
    $person = $this->query($sql);
    $arr['East'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE  (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว')";
    $personNiti = $this->query($sql);
    $arr['EastNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว')";
    $personPerson = $this->query($sql);
    $arr['EastPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี')
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี')";
    $person = $this->query($sql);
    $arr['South'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type1.`contact_province` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type6.`contact_province` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี')";
    $personNiti = $this->query($sql);
    $arr['SouthNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  (`tb_member`.create_date BETWEEN  '$yearPast' and  '$yearNow') AND  tb_member_type3.`provinceTh` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี')";
    $personPerson = $this->query($sql);
    $arr['SouthPerson'] = $this->sumdata($personPerson);

    $arr['total'] =  $arr['Krungthep'] +$arr['Central'] + $arr['North'] + $arr['Northeast'] + $arr['West'] + $arr['East'] + $arr['South'];
    $arr['totalNiti'] = $arr['KrungthepNiti']+$arr['CentralNiti'] + $arr['NorthNiti'] + $arr['NortheastNiti'] + $arr['WestNiti'] + $arr['EastNiti'] + $arr['SouthNiti'];
    $arr['totalPerson'] =  $arr['KrungthepPerson']+$arr['CentralPerson'] + $arr['NorthPerson'] + $arr['NortheastPerson'] + $arr['WestPerson'] + $arr['EastPerson'] + $arr['SouthPerson'];

    $arr['KrungthepPercent'] = round(($arr['Krungthep'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['KrungthepNitiPercent'] = round(($arr['KrungthepNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['KrungthepPersonPercent'] = round(($arr['KrungthepPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['CentralPercent'] = round(($arr['Central'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['CentralNitiPercent'] = round(($arr['CentralNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['CentralPersonPercent'] = round(($arr['CentralPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['NorthPercent'] = round(($arr['North'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_DOWN);
    $arr['NorthNitiPercent'] = round(($arr['NorthNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_DOWN);
    $arr['NorthPersonPercent'] = round(($arr['NorthPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_DOWN);

    $arr['NortheastPercent'] = round(($arr['Northeast'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['NortheastNitiPercent'] = round(($arr['NortheastNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['NortheastPersonPercent'] = round(($arr['NortheastPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['WestPercent'] = (round(($arr['West'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP) <= 4) ? 6 : round(($arr['West'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['WestNitiPercent'] = round(($arr['WestNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['WestPersonPercent'] = round(($arr['WestPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['EastPercent'] = round(($arr['East'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['EastNitiPercent'] = round(($arr['EastNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['EastPersonPercent'] = round(($arr['EastPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['SouthPercent'] = round(($arr['South'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['SouthNitiPercent'] = round(($arr['SouthNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['SouthPersonPercent'] = round(($arr['SouthPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['export'] = [
      [
        '0region' => 'กรุงเทพและปริมณฑล',
        '1niti' => $arr['KrungthepNiti'],
        '2person' => $arr['KrungthepPerson'],
        '3all' => $arr['Krungthep'],
        '4percen' => $arr['KrungthepPercent'].'%'
      ],
      [
        '0region' => 'ภาคกลาง',
        '1niti' => $arr['CentralNiti'],
        '2person' => $arr['CentralPerson'],
        '3all' => $arr['Central'],
        '4percen' => $arr['CentralPercent'].'%'
      ],
      [
        '0region' => 'ภาคเหนือ',
        '1niti' => $arr['NorthNiti'],
        '2person' => $arr['NorthPerson'],
        '3all' => $arr['North'],
        '4percen' => $arr['NorthPercent'].'%'
      ],
      [
        '0region' => 'ภาคตะวันออก',
        '1niti' => $arr['NortheastNiti'],
        '2person' => $arr['NortheastPerson'],
        '3all' => $arr['Northeast'],
        '4percen' => $arr['NortheastPercent'].'%'
      ],
      [
        '0region' => 'ภาคตะวันออกเฉียงเหนือ',
        '1niti' => $arr['WestNiti'],
        '2person' => $arr['WestPerson'],
        '3all' => $arr['West'],
        '4percen' => $arr['WestPercent'].'%'
      ],
      [
        '0region' => 'ภาคตะวันตก',
        '1niti' => $arr['EastNiti'],
        '2person' => $arr['EastPerson'],
        '3all' => $arr['East'],
        '4percen' => $arr['EastPercent'].'%'
      ],
      [
        '0region' => 'ภาคใต้',
        '1niti' => $arr['SouthNiti'],
        '2person' => $arr['SouthPerson'],
        '3all' => $arr['South'],
        '4percen' => $arr['SouthPercent'].'%'
      ],
    ];
    $arr['export2'] = [
      [
        '0region' => 'Bangkok Metropolitan Region',
        '1niti' => $arr['KrungthepNiti'],
        '2person' => $arr['KrungthepPerson'],
        '3all' => $arr['Krungthep'],
        '4percen' => $arr['KrungthepPercent'].'%'
      ],
      [
        '0region' => 'central',
        '1niti' => $arr['CentralNiti'],
        '2person' => $arr['CentralPerson'],
        '3all' => $arr['Central'],
        '4percen' => $arr['CentralPercent'].'%'
      ],
      [
        '0region' => 'north',
        '1niti' => $arr['NorthNiti'],
        '2person' => $arr['NorthPerson'],
        '3all' => $arr['North'],
        '4percen' => $arr['NorthPercent'].'%'
      ],
      [
        '0region' => 'eastern',
        '1niti' => $arr['NortheastNiti'],
        '2person' => $arr['NortheastPerson'],
        '3all' => $arr['Northeast'],
        '4percen' => $arr['NortheastPercent'].'%'
      ],
      [
        '0region' => 'west',
        '1niti' => $arr['WestNiti'],
        '2person' => $arr['WestPerson'],
        '3all' => $arr['West'],
        '4percen' => $arr['WestPercent'].'%'
      ],
      [
        '0region' => 'east',
        '1niti' => $arr['EastNiti'],
        '2person' => $arr['EastPerson'],
        '3all' => $arr['East'],
        '4percen' => $arr['EastPercent'].'%'
      ],
      [
        '0region' => 'south',
        '1niti' => $arr['SouthNiti'],
        '2person' => $arr['SouthPerson'],
        '3all' => $arr['South'],
        '4percen' => $arr['SouthPercent'].'%'
      ],
    ];
    return $arr;
  }
  function testApi()
  {
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
                WHERE  tb_member_type1.`contact_province` IN ('','contact_province') 
                UNION ALL
                SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
                WHERE tb_member_type6.`contact_province` IN ('12','Test','TesTบุคคลไม่จดทะเบียน')
                UNION ALL
                SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
                WHERE  tb_member_type3.`provinceTh` IN ('ใหม่','Test','')
                UNION ALL
                SELECT COUNT(DISTINCT tb_member_type4.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN  tb_member_type4 ON tb_member.member_id = tb_member_type4.member_id WHERE tb_member_type4.member_id is not null
                UNION ALL
                SELECT COUNT(DISTINCT tb_member_type2.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN  tb_member_type2 ON tb_member.member_id = tb_member_type2.member_id WHERE tb_member_type2.member_id is not null";
    $know = $this->query($sql);
    $arr['Know'] = $this->sumdata($know);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('','contact_province') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('12','Test','TesTบุคคลไม่จดทะเบียน')
            UNION ALL
            SELECT COUNT(DISTINCT tb_member_type2.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN  tb_member_type2 ON tb_member.member_id = tb_member_type2.member_id WHERE tb_member_type2.member_id is not null";
    $know = $this->query($sql);
    $arr['KnowNiti'] = $this->sumdata($know);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE  tb_member_type3.`provinceTh` IN ('ใหม่','Test','')
              UNION ALL
              SELECT COUNT(DISTINCT tb_member_type4.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN  tb_member_type4 ON tb_member.member_id = tb_member_type4.member_id WHERE tb_member_type4.member_id is not null";
    $know = $this->query($sql);
    $arr['Know_Person'] = $this->sumdata($know);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE  tb_member_type1.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นครปฐม','นนทบุรี','NONTHABURI','ปทุมธานี','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE tb_member_type6.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นครปฐม','นนทบุรี','NONTHABURI','ปทุมธานี','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร')
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE  tb_member_type3.`provinceTh` IN ('Bangkok','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรงุเทพ','กรุงเทพ','กรุงเทพฯ','นครนายก','นครปฐม','นครสวรรค์','นนทบุรี','NONTHABURI','ปทุมธานี','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร')";
    $person = $this->query($sql);
    $arr['Bkk'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE  tb_member_type1.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นครปฐม','นนทบุรี','NONTHABURI','ปทุมธานี','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE tb_member_type6.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นครปฐม','นนทบุรี','NONTHABURI','ปทุมธานี','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร')";
    $personNiti = $this->query($sql);
    $arr['BkklNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE  tb_member_type3.`provinceTh` IN ('BANGKOK','Bangkok','Bangkok .','กรุงเทพมหานคร','นครปฐม','NAKHON PATHOM','NAKHON PHANOM','นนทบุรี','NONTHABURI','ปทุมธานี','PATHUM THANI','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร')";
    $personPerson = $this->query($sql);
    $arr['BkkPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE  tb_member_type1.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE tb_member_type6.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE  tb_member_type3.`provinceTh` IN ('Bangkok','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรงุเทพ','กรุงเทพ','กรุงเทพฯ','กำแพงเพชร','ชัยนาท','นครนายก','นครปฐม','นครสวรรค์','นนทบุรี','NONTHABURI','ปทุมธานี','Pathum Thani','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')";
    $person = $this->query($sql);
    $arr['Central'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','กำแพงเพชร','ชัยนาท','นครนายก','นครปฐม','นครสวรรค์','นนทบุรี','NONTHABURI','ปทุมธานี','Pathum Thani','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','กำแพงเพชร','ชัยนาท','นครนายก','นครปฐม','นครสวรรค์','นนทบุรี','NONTHABURI','ปทุมธานี','Pathum Thani','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')";
    $personNiti = $this->query($sql);
    $arr['CentralNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  tb_member_type3.`provinceTh` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','กำแพงเพชร','ชัยนาท','นครนายก','นครปฐม','นครสวรรค์','นนทบุรี','NONTHABURI','ปทุมธานี','Pathum Thani','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรปราการ','SAMUT PRAKAN','สมุทรสงคราม','SAMUTSAKHON','สมุทรสาคร','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')";
    $personPerson = $this->query($sql);
    $arr['CentralPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE  tb_member_type1.`contact_province` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE tb_member_type6.`contact_province` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์')
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE  tb_member_type3.`provinceTh` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์')";
    $person = $this->query($sql);
    $arr['North'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์')";
    $personNiti = $this->query($sql);
    $arr['NorthNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  tb_member_type3.`provinceTh` IN ('เชียงราย','เชียงใหม่','น่าน','พะเยา','แพร่','แม่ฮ่องสอน','ลำปาง','ลำพูน','อุตรดิตถ์')";
    $personPerson = $this->query($sql);
    $arr['NorthPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร')
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  tb_member_type3.`provinceTh` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร')";
    $person = $this->query($sql);
    $arr['Northeast'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร')";
    $personNiti = $this->query($sql);
    $arr['NortheastNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  tb_member_type3.`provinceTh` IN ('นครราชสีมา','อุบลราชธานี','ขอนแก่น','บุรีรัมย์','อุดรธานี','ศรีสะเกษ','สุรินทร์','ร้อยเอ็ด','ชัยภูมิ','สกลนคร','กาฬสินธุ์','มหาสารคาม','นครพนม','เลย','ยโสธร','หนองคาย','หนองบัวลำภู','บึงกาฬ','อำนาจเจริญ','มุกดาหาร')";
    $personPerson = $this->query($sql);
    $arr['NortheastPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์')
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  tb_member_type3.`provinceTh` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์')";
    $person = $this->query($sql);
    $arr['West'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์')";
    $personNiti = $this->query($sql);
    $arr['WestNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  tb_member_type3.`provinceTh` IN ('ตาก','กาญจนบุรี','ราชบุรี','เพชรบุรี','ประจวบคีรีขันธ์')";
    $personPerson = $this->query($sql);
    $arr['WestPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว')
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  tb_member_type3.`provinceTh` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว')";
    $person = $this->query($sql);
    $arr['East'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว')";
    $personNiti = $this->query($sql);
    $arr['EastNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  tb_member_type3.`provinceTh` IN ('จันทบุรี','ชลบุรี','ตราด','ระยอง','ฉะเชิงเทรา','ปราจีนบุรี','สระแก้ว')";
    $personPerson = $this->query($sql);
    $arr['EastPerson'] = $this->sumdata($personPerson);

    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี')
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
            WHERE  tb_member_type3.`provinceTh` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี')";
    $person = $this->query($sql);
    $arr['South'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
            WHERE  tb_member_type1.`contact_province` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี') 
            UNION ALL
            SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
            LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
            WHERE tb_member_type6.`contact_province` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี')";
    $personNiti = $this->query($sql);
    $arr['SouthNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
          LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
          WHERE  tb_member_type3.`provinceTh` IN ('กระบี่','ชุมพร','ตรัง','นครศรีธรรมราช','นราธิวาส','ปัตตานี','พังงา','พัทลุง','ภูเก็ต','ยะลา','ระนอง','สงขลา','สตูล','สุราษฎร์ธานี')";
    $personPerson = $this->query($sql);
    $arr['SouthPerson'] = $this->sumdata($personPerson);

    $arr['total'] = $arr['Central'] + $arr['North'] + $arr['Northeast'] + $arr['West'] + $arr['East'] + $arr['South'];
    $arr['totalNiti'] = $arr['CentralNiti'] + $arr['NorthNiti'] + $arr['NortheastNiti'] + $arr['WestNiti'] + $arr['EastNiti'] + $arr['SouthNiti'];
    $arr['totalPerson'] = $arr['CentralPerson'] + $arr['NorthPerson'] + $arr['NortheastPerson'] + $arr['WestPerson'] + $arr['EastPerson'] + $arr['SouthPerson'];

    $arr['CentralPercent'] = round(($arr['Central'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['CentralNitiPercent'] = round(($arr['CentralNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['CentralPersonPercent'] = round(($arr['CentralPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['NorthPercent'] = round(($arr['North'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['NorthNitiPercent'] = round(($arr['NorthNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['NorthPersonPercent'] = round(($arr['NorthPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['NortheastPercent'] = round(($arr['Northeast'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['NortheastNitiPercent'] = round(($arr['NortheastNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['NortheastPersonPercent'] = round(($arr['NortheastPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['WestPercent'] = (round(($arr['West'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP) <= 4) ? 6 : round(($arr['West'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['WestNitiPercent'] = round(($arr['WestNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['WestPersonPercent'] = round(($arr['WestPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['EastPercent'] = round(($arr['East'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['EastNitiPercent'] = round(($arr['EastNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['EastPersonPercent'] = round(($arr['EastPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);

    $arr['SouthPercent'] = round(($arr['South'] / $arr['total']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['SouthNitiPercent'] = round(($arr['SouthNiti'] / $arr['totalNiti']) * 100, 0, PHP_ROUND_HALF_UP);
    $arr['SouthPersonPercent'] = round(($arr['SouthPerson'] / $arr['totalPerson']) * 100, 0, PHP_ROUND_HALF_UP);
    return $arr;
  }
  function model_edit_cancel(){
    $type1 = "SELECT * FROM cancel_text";
    $datatype1 = $this->query($type1);
    return $datatype1;
  }
  function model_country(){
    $sql = "SELECT `CountryNameEN` FROM `tb_country` ";
    $result = $this->query($sql);
     return $result;
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

    $sql = "SELECT dropdown_districts.*,dropdown_districts.id AS district_id, dropdown_districts.name_th AS district_name_th,T1.*,T2.*  FROM `dropdown_districts` 
            LEFT JOIN (SELECT name_th AS amphure_name_th, name_en AS amphure_name_en, id AS amphure_id,province_id FROM dropdown_amphures) T1 ON T1.amphure_id = dropdown_districts.amphure_id
            LEFT JOIN (SELECT name_th AS province_name_th, name_en AS province_name_en, id AS province_id FROM dropdown_provinces) T2 ON T2.province_id = T1.province_id
            WHERE dropdown_districts.zip_code LIKE '%$postcode%'";
    // print_r($sql);
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
  function get_provinces_model(){
    $id = $this->post('id');
    $where = '';
    if($id != ''){
      $where = ' WHERE id = '.$id;
    }
    $sql = "SELECT * FROM dropdown_provinces".$where;
    $result = $this->query($sql);
    $result['lang'] = empty($_SESSION['lang'])?'th':$_SESSION['lang'];
    if(count($result) > 0) return $result;
  }
  function get_amphures_model(){
    $id = $this->post('id');
    $where = '';
    if($id != ''){
      $where = ' WHERE id = '.mysqli_real_escape_string($this->db, $id);
    }
    
    $sql = "SELECT * FROM dropdown_amphures ".$where;
    $result = $this->query($sql);
    $result['lang'] = empty($_SESSION['lang'])?'th':$_SESSION['lang'];
    if(count($result) > 0) return $result;
  }

  function get_districts_model(){
    $id = $this->post('id');
    $where = '';
    if($id != ''){
      $where = ' WHERE id = '.mysqli_real_escape_string($this->db, $id);
    }
    $sql = "SELECT * FROM dropdown_districts ".$where;
    $result = $this->query($sql);
    $result['lang'] = empty($_SESSION['lang'])?'th':$_SESSION['lang'];
    if(count($result) > 0) return $result;
  }
  function model_noti_sso(){
    $stmt_att = $this->db->prepare("SELECT tb_member.cid,tb_member_attachment.director_status,tb_member_attachment.status,tb_member_attachment.status_open,tb_member_attachment.updated_at as date_noti,tb_member_type1.*  FROM `tb_member_attachment`
                                    INNER JOIN tb_member_type1 ON   tb_member_attachment.member_id = tb_member_type1.member_id INNER JOIN tb_member ON   tb_member_attachment.member_id = tb_member.member_id   WHERE  tb_member_attachment.`status`  = 0    GROUP BY  tb_member_attachment.member_id ORDER BY tb_member_attachment.updated_at DESC");
    $stmt_att->execute();
    $result = $stmt_att->get_result();
    $arr = ['count'=>0,'background'=>"",'data'=>[]];
    $num = 0;
    foreach($result as $key => $val){
      if($key == 0){
        $arr['background'] = ($val['status_open'] == 0)? "#EAF0F9": "#ffff";
      }
      //#EAF0F9  background-color: #ffff 
      if($val['status_open'] == 0){
        $num++;
      }
      ($val['director_status'] == 1)? $ck = "(กรรมการผู้มีอำนาจ)": $ck = "(ผู้รับมอบอำนาจ)";
      $arr['data'] []= [
          "member_id" => $val['member_id'],
          "cid" => $val['cid'],
          "url" => "/sso/office/noti_redirect_uri?member_id=".$val['member_id'],
          "status" => "รออนุมัติ",
          "status_open" => $val['status_open'],
          "background" => ($val['status_open'] == 0)? "#EAF0F9": "#ffff",
          "point" => ($val['status_open'] == 0)?  'style="width: 10px;height: 10px;border-radius: 50%;background: #2D6DC4;transform: translate(1415%, -245%);"' : "",
          "company_nameTh" => $val['company_nameTh'],
          "company_nameEn" => $val['company_nameEn'],
          "member_nameTh" => $val['member_title'].' '.$val['member_nameTh'].' '.$val['member_midnameTh'].' '.$val['member_lastnameTh'].' '.$ck,
          "date_noti" => date("d-m-Y H:m:s", strtotime($val['date_noti']))
      ];
    }
    $arr['count_active'] = $num;//count($arr['data']);
    $arr['count'] = count($arr['data']);
    return $arr;
  }//
  function model_noti_redirect_uri(){
    $member_id = $this->get('member_id');
    $result = $this->query("UPDATE `tb_member_attachment` SET `status_open` = '1' WHERE  `member_id` = ".$member_id);
    $url = "Location: ".BASE_URL."office/detail_member?id=".$member_id."&type=1";
    return $url;
  }
}

