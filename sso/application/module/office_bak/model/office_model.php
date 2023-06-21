<?php

use \Firebase\JWT\JWT;

class office_model extends Model
{

  function __construct()
  {
    parent::__construct();
  }



  function ck_login()
  {

    $return = ["status" => "01", "message" => "Not Found!"];

    $username = mysqli_real_escape_string($this->db, $this->post('username'));
    $password = $this->post('password');


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
    }
    return $return;
  }


  function model_data_table()
  {
    $type = $this->get('type');
    $status = $this->get('status');
    $text_search = $this->get('text_search');
    $andnew = " WHERE 1";
    $and = " HAVING 1";

    $where = 1;
    $limit = $this->get('limit');
    $offset = $this->get('offset');
    $range = " LIMIT $limit OFFSET $offset";
    $groupby = " GROUP BY tb_member.cid";

    // if(status==0){
    //   $sql = "SELECT DISTINCT tb_token.member_id
    //   FROM tb_token
    //   INNER JOIN tb_member ON tb_token.member_id = tb_member.member_id
    //   WHERE tb_token.create_date < DATE_SUB( CURDATE( ) , INTERVAL 3 YEAR )";

    //   $where = `tb_token.create_date < DATE_SUB( CURDATE( ) , INTERVAL 3 YEAR )`;
    // }


    if ($type != "") {

      $and .= " AND type = '$type'";
    }

    if ($status != "") {
      $and .= " AND token = '$status'";
    }

    if ($text_search != "") {
      $andnew .= " AND (tb_member.cid LIKE '%$text_search%' 
                    OR type1.member_email LIKE '%$text_search%'
                    OR type2.email LIKE '%$text_search%'
                    OR type3.email LIKE '%$text_search%'
                    OR type4.email LIKE '%$text_search%'
                    OR type5.email LIKE '%$text_search%'

                    OR type1.company_nameTh LIKE '%$text_search%'
                    OR type1.company_nameEn LIKE '%$text_search%'

                    OR type2.corporate_name LIKE '%$text_search%'

                    OR type1.member_nameTh LIKE '%$text_search%'
                    OR type2.member_nameTh LIKE '%$text_search%'
                    OR type3.member_nameTh LIKE '%$text_search%'
                    OR type4.member_nameTh LIKE '%$text_search%'
                    OR type5.member_nameTh LIKE '%$text_search%'

                    OR type1.member_lastnameTh LIKE '%$text_search%'
                    OR type2.member_lastnameTh LIKE '%$text_search%'
                    OR type3.member_lastnameTh LIKE '%$text_search%'
                    OR type4.member_lastnameTh LIKE '%$text_search%'
                    OR type5.member_lastnameTh LIKE '%$text_search%'

                    OR type1.member_nameEn LIKE '%$text_search%'
                    OR type2.member_nameEn LIKE '%$text_search%'
                    OR type3.member_nameEn LIKE '%$text_search%'
                    OR type4.member_nameEn LIKE '%$text_search%'

                    OR type1.member_lastnameEn LIKE '%$text_search%'
                    OR type2.member_lastnameEn LIKE '%$text_search%'
                    OR type3.member_lastnameEn LIKE '%$text_search%'
                    OR type4.member_lastnameEn LIKE '%$text_search%'

                    OR type1.member_tel LIKE '%$text_search%'
                    OR type2.tel LIKE '%$text_search%'
                    OR type3.tel LIKE '%$text_search%'
                    OR type4.tel LIKE '%$text_search%'
                    OR type5.tel LIKE '%$text_search%'

                  ) ";
    }

    $sql = "SELECT DISTINCT tb_member.member_id,tb_member.*,
                            IF(tb_token.create_date < DATE_SUB( CURDATE( ) , INTERVAL 3 YEAR),0,1) AS token ,
                            type1.member_nameTh AS t1_member_nameTh,
                            type1.member_lastnameTh AS t1_member_lastnameTh,
                            type1.company_nameTh AS t1_company_nameTh,
                            type2.member_nameTh AS t2_member_nameEn,
                            type2.member_lastnameTh AS t2_member_lastnameEn,
                            type2.corporate_name AS t2_corporate_name,
                            type3.member_nameTh AS t3_member_nameTh,
                            type3.member_lastnameTh AS t3_member_lastnameTh,
                            type4.member_nameTh AS t4_member_nameEn,
                            type4.member_lastnameTh AS t4_member_lastnameEn,
                            type5.member_nameTh AS t5_member_nameTh,
                            type5.member_lastnameTh AS t5_member_lastnameTh,
                            type6.member_nameTh AS t6_member_nameTh,
                            type6.member_lastnameTh AS t6_member_lastnameTh 
                            
                            FROM tb_member 
                            
                            LEFT JOIN tb_member_type1 AS type1 ON tb_member.member_id = type1.member_id 
                            LEFT JOIN tb_member_type2 AS type2 ON tb_member.member_id = type2.member_id 
                            LEFT JOIN tb_member_type3 AS type3 ON tb_member.member_id = type3.member_id 
                            LEFT JOIN tb_member_type4 AS type4 ON tb_member.member_id = type4.member_id 
                            LEFT JOIN tb_member_type5 AS type5 ON tb_member.member_id = type5.member_id 
                            LEFT JOIN tb_member_type6 AS type6 ON tb_member.member_id = type6.member_id 
                            LEFT JOIN tb_token ON tb_member.member_id = tb_token.member_id";

    $sql2 = "SELECT DISTINCT tb_member.member_id,tb_member.type,IF(tb_token.create_date < DATE_SUB( CURDATE( ) , INTERVAL 3 YEAR),0,1) AS token FROM tb_member LEFT JOIN tb_token ON tb_member.member_id = tb_token.member_id";
    $sql_rows = $sql . $andnew . $groupby . $and . $range;
    if ($text_search != "") {
      $sql_count = $sql . $andnew . $groupby . $and;
    } else {
      $sql_count = $sql2 . $andnew . $groupby . $and;
    }
    // return $sql_count;
    $query = $this->query($sql_rows);
    $sql_countt = $this->query($sql_count);
    $result = $query;
    $n = 0;
    $main = array();

    if(empty($result)){
        $sql_rows = "SELECT DISTINCT Member_drive_v3.UserID,Member_drive_v3.Firstname,Member_drive_v3.LastName,Member_drive_v3.Username,
                      Member_drive_v3.Mail,Member_drive_v3.UserType,Member_drive_v3.Is_Thai   FROM Member_drive_v3  WHERE 
                      (
                        Member_drive_v3.Username LIKE '%$text_search%' 
                        OR Member_drive_v3.Mail  LIKE '%$text_search%'
                        OR Member_drive_v3.Firstname  LIKE '%$text_search%'
                        OR Member_drive_v3.LastName LIKE '%$text_search%'
                        OR Member_drive_v3.Telephone LIKE '%$text_search%'
                      )  GROUP BY Member_drive_v3.Username HAVING 1 LIMIT 10 OFFSET 0";
       $query = $this->query($sql_rows);
       $result = $query;
       foreach ($result as $item) {
              if ($item['UserType'] == "corporate" && $item['Is_Thai'] == "Y") {
                $name_type = "นิติบุคคลไทย";
              } else if ($item['UserType'] == "corporate" && $item['Is_Thai'] == "N") {
                $name_type = "นิติบุคคลต่างชาติ";
              } elseif ($item['UserType'] == "person" && $item['Is_Thai'] == "Y" ||  $item['Is_Thai'] == " ") {
                $name_type = "บุคคลไทย";
              } else if ($item['UserType'] == "person" && $item['Is_Thai'] == "N") {
                $name_type = "บุคคลต่างชาติ";
              } else {
                $name_type = "-";
              }

              $n++;
              $td2 = ($item['Firstname'] == '') ? "-" : $item['Firstname']; //First Name
              $td3 = ($item['LastName'] == '') ? "-" : $item['LastName']; //Last Name
              $td4 =  "-"; //Coporate Name
              $td5 = ($item['Username'] == '') ? "-" : $item['Username']; //Coporate ID
              $td6 = '-'; //Password ID
              $td7 = '-'; //ID Card Number
              $td8 = $name_type; //Type
              $td9 = ($item['Username'] == '') ? "-" : $item['Username']; //Username
              $td14 = "-"; //Register Date
                $td12 = 'Activate';
                $color = 'green';
              $url = BASE_PATH . "office/edit_member?type=old&id=" . $item['UserID'];
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
              $data['td11'] = "<a href='#' class='btn sso-btn-back edit-pass' member-id='" . $item['UserID'] . "' member-name='" . $item['UserType'] . "' data-toggle='modal' data-target='#ShowModal'>
                                <i class='fa fa-edit mr-1'></i>เปลี่ยนรหัสผ่าน
                              </a>";
              $data['td12'] = '<span style="color:' . $color . ';"> ' . htmlentities($td12) . ' </span>'; //Status
              $data['td14'] = htmlentities($td14);
              array_push($main, $data);        
       }
    }else{
          foreach ($result as $item) {
            if ($item['type'] == 1) {
              $name_type = "นิติบุคคลไทย";
            } else if ($item['type'] == 2) {
              $name_type = "นิติบุคคลต่างชาติ";
            } elseif ($item['type'] == 3) {
              $name_type = "บุคคลไทย";
            } else if ($item['type'] == 4) {
              $name_type = "บุคคลต่างชาติ";
            } else if ($item['type'] == 5) {
              $name_type = "อื่นๆ";
            } else if ($item['type'] == 6) {
              $name_type = "นิติบุคคลไทยที่ไม่ได้ลงทะเบียน";
            } else {
              $name_type = "-";
            }
      
      
            if ($item['type'] == 1) {
              $n++;
              $td2 = ($item['t1_member_nameTh'] == '') ? "-" : $item['t1_member_nameTh']; //First Name
              $td3 = ($item['t1_member_lastnameTh'] == '') ? "-" : $item['t1_member_lastnameTh']; //Last Name
              $td4 = ($item['t1_company_nameTh'] == '') ? "-" : $item['t1_company_nameTh']; //Coporate Name
              $td5 = $item['cid']; //Coporate ID
              $td6 = '-'; //Password ID
              $td7 = '-'; //ID Card Number
              $td8 = $name_type; //Type
              $td9 = $item['cid']; //Username
              $td14 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date
              if ($item['token'] == 1) {
                $td12 = 'Activate';
                $color = 'green';
              } else {
                $td12 = 'Inactivate';
                $color = 'red';
              }
      
              $url = BASE_PATH . "office/edit_member?id=" . $item['member_id'];
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
              $data['td11'] = "<a href='#' class='btn sso-btn-back edit-pass' member-id='" . $item['member_id'] . "' member-name='" . $td4 . "' data-toggle='modal' data-target='#ShowModal'>
                                <i class='fa fa-edit mr-1'></i>เปลี่ยนรหัสผ่าน
                              </a>";
              $data['td12'] = '<span style="color:' . $color . ';"> ' . htmlentities($td12) . ' </span>'; //Status
              $data['td14'] = htmlentities($td14);
              array_push($main, $data);
            } else if ($item['type'] == 2) {
              $n++;
              $td2 = ($item['t2_member_nameEn'] == '') ? "-" : $item['t2_member_nameEn']; //First Name
              $td3 = ($item['t2_member_lastnameEn'] == '') ? "-" : $item['t2_member_lastnameEn']; //Last Name
              $td4 = ($item['t2_corporate_name'] == '') ? "-" : $item['t2_corporate_name']; //Coporate Name
              $td5 = $item['cid']; //Coporate ID
              $td6 = '-'; //Password ID
              $td7 = '-'; //ID Card Number
              $td8 = $name_type; //Type
              $td9 = $item['cid']; //Username
              $td14 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date
              if ($item['token'] == 1) {
                $td12 = 'Activate';
                $color = 'green';
              } else {
                $td12 = 'Inactivate';
                $color = 'red';
              }
              $url = BASE_PATH . "office/edit_member?id=" . $item['member_id'];
              //$data['td1'] = $n;
              $data['td2'] = htmlentities($td2); //First Name
              $data['td3'] = htmlentities($td3); //Last Name
              $data['td4'] = htmlentities($td4); //Coporate Name
              $data['td5'] = htmlentities($td5); //Coporate ID
              $data['td6'] = htmlentities($td6); //Password ID
              $data['td7'] = htmlentities($td7); //ID Card Number
              $data['td8'] = $td8; //Type
              $data['td9'] = htmlentities($td9); //Username
              $data['td10'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit'><i class='fa fa-pencil mr-1'></i>แก้ไขข้อมูล</a>";
              $data['td11'] = "<a href='#' class='btn sso-btn-back edit-pass' member-id='" . $item['member_id'] . "' member-name='" . $td4 . "' data-toggle='modal' data-target='#ShowModal'>
                                <i class='fa fa-edit mr-1'></i>เปลี่ยนรหัสผ่าน
                              </a>";
              $data['td12'] = '<span style="color:' . $color . ';"> ' . htmlentities($td12) . ' </span>'; //Status
              $data['td14'] = htmlentities($td14);
              array_push($main, $data);
            } else if ($item['type'] == 3) {
              //บุคคลไทย
              $n++;
              $td2 = ($item['t3_member_nameTh'] == '') ? "-" : $item['t3_member_nameTh']; //First Name
              $td3 = ($item['t3_member_lastnameTh'] == '') ? "-" : $item['t3_member_lastnameTh']; //Last Name
              $td4 = '-'; //Coporate Name
              $td5 = '-'; //Coporate ID
              $td6 = '-'; //Password ID
              $td7 = $item['cid']; //ID Card Number
              $td8 = $name_type; //Type
              $td9 = $item['cid']; //Username
              $td14 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date
              if ($item['token'] == 1) {
                $td12 = 'Activate';
                $color = 'green';
              } else {
                $td12 = 'Inactivate';
                $color = 'red';
              }
              $url = BASE_PATH . "office/edit_member?id=" . $item['member_id'];
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
            } else if ($item['type'] == 4) {
              //บุคคลต่างชาติ
              $n++;
              $td2 = ($item['t4_member_nameEn'] == '') ? "-" : $item['t4_member_nameEn']; //First Name
              $td3 = ($item['t4_member_lastnameEn'] == '') ? "-" : $item['t4_member_lastnameEn']; //Last Name
              $td4 = '-'; //Coporate Name
              $td5 = '-'; //Coporate ID
              $td6 = $item['cid']; //Password ID
              $td7 = '-'; //ID Card Number
              $td8 = $name_type; //Type
              $td9 = $item['cid']; //Username
              $td14 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date
              if ($item['token'] == 1) {
                $td12 = 'Activate';
                $color = 'green';
              } else {
                $td12 = 'Inactivate';
                $color = 'red';
              }
              $url = BASE_PATH . "office/edit_member?id=" . $item['member_id'];
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
            } else if ($item['type'] == 5) {
              //อื่นๆ
              $n++;
              $td2 = ($item['t5_member_nameTh'] == '') ? "-" : $item['t5_member_nameTh']; //First Name
              $td3 = ($item['t5_member_lastnameTh'] == '') ? "-" : $item['t5_member_lastnameTh']; //Last Name
              $td4 = '-'; //Coporate Name
              $td5 = '-'; //Coporate ID
              $td6 = '-'; //Password ID
              $td7 = $item['cid']; //ID Card Number
              $td8 = $name_type; //Type
              $td9 = $item['cid']; //Username
              $td14 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date
              if ($item['token'] == 1) {
                $td12 = 'Activate';
                $color = 'green';
              } else {
                $td12 = 'Inactivate';
                $color = 'red';
              }
              $url = BASE_PATH . "office/edit_member?id=" . $item['member_id'];
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
            } else if ($item['type'] == 6) {
              $n++;
              $td2 = ($item['t6_member_nameTh'] == '') ? "-" : $item['t6_member_nameTh']; //First Name
              $td3 = ($item['t6_member_lastnameTh'] == '') ? "-" : $item['t6_member_lastnameTh']; //Last Name
              $td4 = ($item['t6_company_nameTh'] == '') ? "-" : $item['t6_company_nameTh']; //Coporate Name
              $td5 = $item['cid']; //Coporate ID
              $td6 = '-'; //Password ID
              $td7 = '-'; //ID Card Number
              $td8 = $name_type; //Type
              $td9 = $item['cid']; //Username
              $td14 = date('d-m-Y H:i:s', strtotime($item['create_date'])); //Register Date
              if ($item['token'] == 1) {
                $td12 = 'Activate';
                $color = 'green';
              } else {
                $td12 = 'Inactivate';
                $color = 'red';
              }
      
              $url = BASE_PATH . "office/edit_member?id=" . $item['member_id'];
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
              $data['td11'] = "<a href='#' class='btn sso-btn-back edit-pass' member-id='" . $item['member_id'] . "' member-name='" . $td4 . "' data-toggle='modal' data-target='#ShowModal'>
                                <i class='fa fa-edit mr-1'></i>เปลี่ยนรหัสผ่าน
                              </a>";
              $data['td12'] = '<span style="color:' . $color . ';"> ' . htmlentities($td12) . ' </span>'; //Status
              $data['td14'] = htmlentities($td14);
              array_push($main, $data);
            }
        }
    }
    
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
        $status_on = BASE_PATH . "asset/img/check-circle-anticon.png";
        $status_off = BASE_PATH . "asset/img/cross-circle-anticon.png";
      } else {
        $status_on = BASE_PATH . "asset/img/check-circle-anticon-copy-4.png";
        $status_off = BASE_PATH . "asset/img/cross-circle-anticon-copy-4.png";
      }

      $data['td1'] = htmlentities($n);
      $data['td2'] = htmlentities(($read['mc_name'] == '') ? "-" : $read['mc_name']);
      $data['td3'] = htmlentities($read['client_id']);
      $data['td4'] = htmlentities(($read['redirect_uri'] == '') ? "-" : $read['redirect_uri']);
      $data['td5'] = "<img src='" . $status_on . "'>&nbsp;<img src='" . $status_off . "'>";
      $data['td6'] = "<a href='" . htmlentities($url) . "' class='btn sso-btn-edit'><i class='fa fa-pencil mr-1'></i>แก้ไขข้อมูล</a>";
      array_push($main, $data);
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

    return $return;
  }
  function model_delete_user($mc_id)
  {
    $return = false;
    $stmt = $this->db->prepare("SELECT * FROM tb_member WHERE sso_id = ?");
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
    }

    $data = [
      'member' => $read,
      'member_type' => $return
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
    $data = [
      'mc_id' => $mc_id,
      'mc_name' => $mc_name,
      'client_id' => $client_id,
      'redirect_uri' => $redirect_uri,
      'status' => $status
    ];
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

    $naturalId = $this->post('naturalId');
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
          'message' => 'Success'
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
      echo "<pre>";
      var_dump($type,"2");
      echo "</pre>";
      die();
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

      try {
        $this->update('tb_member_type1', $data, '  member_id ="' . $member_id . '"');
        $return = [
          'status' => '00',
          'message' => 'Success'
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
      $member_nameTh = $this->post('member_nameTh');
      $member_lastnameTh = $this->post('member_lastnameTh');
      $member_nameEn = $this->post('member_nameEn');
      $member_lastnameEn = $this->post('member_lastnameEn');
      $email = $this->post('email');
      $tel = $this->post('tel');

      $data = [
        'corporate_name' => $corporate_name,
        'country' => $country,
        'address' => $address,
        'member_title' => $member_title,
        'member_nameTh' => $member_nameTh,
        'member_lastnameTh' => $member_lastnameTh,
        'member_nameEn' => $member_nameEn,
        'member_lastnameEn' => $member_lastnameEn,
        'email' => $email,
        'tel' => $tel
      ];
      try {
        $this->update('tb_member_type2', $data, '  member_id ="' . $member_id . '"');
        $return = [
          'status' => '00',
          'message' => 'Success'
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    } else if ($type == 3) {
      $this->update('tb_member', ['cid' => $naturalId, 'system_update' => 'Back-office'], '  member_id ="' . $member_id . '"');

      $member_title = $this->post('member_title');
      $member_nameTh = $this->post('member_nameTh');
      $member_lastnameTh = $this->post('member_lastnameTh');
      $member_nameEn = $this->post('member_nameEn');
      $member_lastnameEn = $this->post('member_lastnameEn');
      $email = $this->post('email');
      $tel = $this->post('tel');
      $addressTh = $this->post('addressTh');
      $provinceTh = $this->post('provinceTh');
      $districtTh = $this->post('districtTh');
      $subdistrictTh = $this->post('subdistrictTh');
      $postcode = $this->post('postcode');

      /*$addressEn = $tis->post('addressEn');
      $provinceEn = $tis->post('provinceEn');
      $districtEn = $tis->post('districtEn');
      $subdistrictEn = $tis->post('subdistrictEn');*/

      $data = [
        'member_title' => $member_title,
        'member_nameTh' => $member_nameTh,
        'member_lastnameTh' => $member_lastnameTh,
        'member_nameEn' => $member_nameEn,
        'member_lastnameEn' => $member_lastnameEn,
        'email' => $email,
        'tel' => $tel,
        'addressTh' => $addressTh,
        'provinceTh' => $provinceTh,
        'districtTh' => $districtTh,
        'subdistrictTh' => $subdistrictTh,
        'postcode' => $postcode
      ];
      try {
        $this->update('tb_member_type3', $data, '  member_id ="' . $member_id . '"');
        $return = [
          'status' => '00',
          'message' => 'Success'
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    } else if ($type == 4) {
      $this->update('tb_member', ['cid' => $naturalId, 'system_update' => 'Back-office'], '  member_id ="' . $member_id . '"');

      $member_title = $this->post('member_title');
      $member_nameTh = $this->post('member_nameTh');
      $member_lastnameTh = $this->post('member_lastnameTh');
      $member_nameEn = $this->post('member_nameEn');
      $member_lastnameEn = $this->post('member_lastnameEn');
      $country = $this->post('country');
      $address = $this->post('address');
      $email = $this->post('email');
      $tel = $this->post('tel');

      $data = [
        'member_title' => $member_title,
        'member_nameTh' => $member_nameTh,
        'member_lastnameTh' => $member_lastnameTh,
        'member_nameEn' => $member_nameEn,
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
          'type' => $type
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
          'type' => $type
        ];
      } catch (Exception $e) {
        $return = ['status' => '01', 'message' => $e];
      }
    } else if ($type == 6) {
      $this->update('tb_member', ['cid' => $naturalId, 'system_update' => 'Back-office'], '  member_id ="' . $member_id . '"');

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

      try {
        $this->update('tb_member_type6', $data, '  member_id ="' . $member_id . '"');
        $return = [
          'status' => '00',
          'message' => 'Success'
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
    $data = [
      'mc_name' => $mc_name,
      'client_id' => $client_id,
      'secret_key' => $mc_name,
      'jwt_signature' => $mc_name,
      'redirect_uri' => $redirect_uri,
      'status' => $status
    ];
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
        CURLOPT_URL => 'https://sso-uat.ditp.go.th/sso/api/TextCancel',
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
        'color' => '#2ca4df',
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
        'color' => '#da2123',
      ];
    }
    $response = [
      'message' => 'success',
      'res_result' => $arr
    ];
    return $arr;
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
    $sql = 'SELECT a.client_id,a.jwt_signature,COUNT(DISTINCT c.member_id ) as CN FROM tb_merchant a LEFT JOIN tb_token b ON a.client_id = b.client_id 
            LEFT JOIN tb_member c ON b.member_id = c.member_id WHERE a.client_id IN ("SS0047423","SS3214573","ssocareid","ssoidtest","ssonticlient","SS1639726") 
            AND c.sso_id <> 0 AND c.create_date BETWEEN "' . $yearPast . '" AND "' . $yearNow . '" GROUP BY a.client_id';
    //(empty($da['etc']['JURISTICNAME'])) ? '' : trim($da['etc']['JURISTICNAME'])

    $total = $this->query($sql);
    $arr['total'] = $this->sumdata($total);
    $arr['startDate'] = $yearPast;
    $arr['endDate'] = $yearNow;
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
        case 'ssoidtest':
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

    $sql = 'SELECT a.client_id,a.jwt_signature,COUNT(DISTINCT c.member_id ) as CN FROM tb_merchant a LEFT JOIN tb_token b ON a.client_id = b.client_id 
            LEFT JOIN tb_member c ON b.member_id = c.member_id WHERE a.client_id IN ("SS0047423","SS3214573","ssocareid","ssoidtest","ssonticlient","SS1639726") AND  c.type IN (1,2,6)
            AND c.sso_id <> 0 AND c.create_date BETWEEN "' . $yearPast . '" AND "' . $yearNow . '" GROUP BY a.client_id';

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
        case 'ssoidtest':
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
    $sql = 'SELECT a.client_id,a.jwt_signature,COUNT(DISTINCT c.member_id ) as CN FROM tb_merchant a LEFT JOIN tb_token b ON a.client_id = b.client_id 
          LEFT JOIN tb_member c ON b.member_id = c.member_id WHERE a.client_id IN ("SS0047423","SS3214573","ssocareid","ssoidtest","ssonticlient","SS1639726") AND  c.type IN (3,4)
          AND c.sso_id <> 0 AND c.create_date BETWEEN "' . $yearPast . '" AND "' . $yearNow . '" GROUP BY a.client_id';
    //  print_r($sql);
    //  die();
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
        case 'ssoidtest':
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
    return $arr;
  }
  function searchData()
  {
    $data1 = $this->post('thaiYear');
    $data2 = $this->post('year_budget');
    $data3 = $this->post('start_date');
    $data4 = $this->post('end_date');
    $data = $this->post('data');
    // SELECT a.client_id,a.jwt_signature,COUNT(DISTINCT c.member_id ) as CN 
    // FROM tb_merchant a LEFT JOIN tb_token b ON a.client_id = b.client_id LEFT JOIN tb_member c ON b.member_id = c.member_id 
    // WHERE a.client_id IN ("SS0047423","SS3214573","ssocareid","ssoidtest","ssonticlient","SS1639726") AND c.sso_id <> 0 
    // AND c.create_date BETWEEN "2021-12-01" AND "2022-03-13" GROUP BY a.client_id
    $sql = ' SELECT a.client_id,a.jwt_signature,COUNT(DISTINCT c.member_id ) as CN 
             FROM tb_merchant a LEFT JOIN tb_token b ON a.client_id = b.client_id LEFT JOIN tb_member c ON b.member_id = c.member_id 
             WHERE a.client_id IN ("SS0047423","SS3214573","ssocareid","ssoidtest","ssonticlient","SS1639726") AND c.sso_id <> 0 ';
    if ($data3 != '' && $data4 != '') {
      $sql = $sql . ' AND c.`create_date` BETWEEN "' . $data3 . '" AND "' . $data4 . '"  GROUP BY a.`client_id`';
    }
    if ($data1 != '') {
      $sql = $sql . ' AND c.`create_date` BETWEEN "' . $data1 . '-01-01" AND "' . $data1 . '-12-30"  GROUP BY a.`client_id`';
    }
    if ($data2 != '') {
      $past = $data2 - 1;
      $sql = $sql . ' AND c.`create_date` BETWEEN "' . $past . '-10-01" AND "' . $data2 . '-09-30"  GROUP BY a.`client_id`';
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
        case 'ssoidtest':
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
    $sql = 'SELECT a.client_id,a.jwt_signature,COUNT(DISTINCT c.member_id ) as CN FROM tb_merchant a LEFT JOIN tb_token b ON a.client_id = b.client_id 
            LEFT JOIN tb_member c ON b.member_id = c.member_id WHERE a.client_id IN ("SS0047423","SS3214573","ssocareid","ssoidtest","ssonticlient","SS1639726") AND  c.type IN (1,2,6)
            AND c.sso_id <> 0';
    if ($data3 != '' && $data4 != '') {
      $sql = $sql . ' AND c.`create_date` BETWEEN "' . $data3 . '" AND "' . $data4 . '"  GROUP BY a.`client_id`';
    }
    if ($data1 != '') {
      $sql = $sql . ' AND c.`create_date` BETWEEN "' . $data1 . '-01-01" AND "' . $data1 . '-12-30"  GROUP BY a.`client_id`';
    }
    if ($data2 != '') {
      $past = $data2 - 1;
      $sql = $sql . ' AND c.`create_date` BETWEEN "' . $past . '-10-01" AND "' . $data2 . '-09-30"  GROUP BY a.`client_id`';
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
        case 'ssoidtest':
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
    $sql = 'SELECT a.client_id,a.jwt_signature,COUNT(DISTINCT c.member_id ) as CN FROM tb_merchant a LEFT JOIN tb_token b ON a.client_id = b.client_id 
      LEFT JOIN tb_member c ON b.member_id = c.member_id WHERE a.client_id IN ("SS0047423","SS3214573","ssocareid","ssoidtest","ssonticlient","SS1639726") AND  c.type IN (3,4) AND c.sso_id <> 0';
    if ($data3 != '' && $data4 != '') {
      $sql = $sql . ' AND c.`create_date` BETWEEN "' . $data3 . '" AND "' . $data4 . '"  GROUP BY a.`client_id`';
    }
    if ($data1 != '') {
      $sql = $sql . ' AND c.`create_date` BETWEEN "' . $data1 . '-01-01" AND "' . $data1 . '-12-30"  GROUP BY a.`client_id`';
    }
    if ($data2 != '') {
      $past = $data2 - 1;
      $sql = $sql . ' AND c.`create_date` BETWEEN "' . $past . '-10-01" AND "' . $data2 . '-09-30"  GROUP BY a.`client_id`';
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
        case 'ssoidtest':
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
    $sql = "SELECT * FROM  ChartTypeMemberV1 ";
    $total = $this->query($sql);
    $arr['total'] = $this->sumdata($total);
    foreach ($total as $key => $item) {
      switch ($item['Property_Name']) {
        case 'EL':
          $Count['EL'] = $item['CN'];
          break;
        case 'Pre-EL':
          $Count['Pre-EL'] = $item['CN'];
          break;
        case 'Pre-TDC':
          $Count['Pre-TDC'] = $item['CN'];
          break;
        case 'TDC':
          $Count['TDC'] = $item['CN'];
          break;
        case 'LSP':
          $Count['LSP'] = $item['CN'];
          break;
      }
    }

    $sql = "SELECT *FROM  ChartTypeMemberV2";
    $active = $this->query($sql);
    $arr['active_member'] = $this->sumdata($active);
    $arr['not_active_member'] = $arr['total'] - $arr['active_member'];
    foreach ($active as $key => $item) {
      switch ($item['Property_Name']) {
        case 'EL':
          $arr['name'][] = $item['Property_Name'];
          $arr['active']['Count'][] = $item['CN'];
          $arr['inactive']['Count'][] = ($Count['EL'] > $item['CN']) ? $Count['EL'] - $item['CN'] : $item['CN'] - $Count['EL'];
          break;
        case 'Pre-EL':
          $arr['name'][] = $item['Property_Name'];
          $arr['active']['Count'][] = $item['CN'];
          $arr['inactive']['Count'][] = ($Count['Pre-EL'] > $item['CN']) ? $Count['Pre-EL'] - $item['CN'] : $item['CN'] - $Count['Pre-EL'];
          break;
        case 'Pre-TDC':
          $arr['name'][] = $item['Property_Name'];
          $arr['active']['Count'][] = $item['CN'];
          $arr['inactive']['Count'][] = ($Count['Pre-TDC'] > $item['CN']) ? $Count['Pre-TDC'] - $item['CN'] : $item['CN'] - $Count['Pre-TDC'];
          break;
        case 'TDC':
          $arr['name'][] = $item['Property_Name'];
          $arr['active']['Count'][] = $item['CN'];
          $arr['inactive']['Count'][] = ($Count['TDC'] > $item['CN']) ? $Count['TDC'] - $item['CN'] : $item['CN'] -  $Count['TDC'];
          break;
        case 'LSP':
          $arr['name'][] = $item['Property_Name'];
          $arr['active']['Count'][] = $item['CN'];
          $arr['inactive']['Count'][] = ($Count['LSP'] > $item['CN']) ? $Count['LSP'] - $item['CN'] : $item['CN'] - $Count['LSP'];
          break;
      }
    }

    return $arr;
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
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
    LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
    WHERE  tb_member_type1.`contact_province` IN ('Bangkok','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon') 
    UNION ALL
    SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
    LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
    WHERE tb_member_type6.`contact_province` IN ('Bangkok','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon')
    UNION ALL
    SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
    LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
    WHERE  tb_member_type3.`provinceTh` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon')";
    $person = $this->query($sql);
    $arr['Krungthep'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE  tb_member_type1.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE tb_member_type6.`contact_province` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon')";
    $personNiti = $this->query($sql);
    $arr['KrungthepNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE  tb_member_type3.`provinceTh` IN ('BANGKOK','Bangkok .','กรุงเทพมหานคร','Thailand','กทม','กทม.','กรุงเทพ','กรุงเทพฯ','นนทบุรี','NONTHABURI','Nonthaburi','นครปฐม','NAKHON PATHOM','Nakhon Pathom','ปทุมธานี','PATHUM THANI','Pathum Thani','สมุทรปราการ','SAMUT PRAKAN','Samut Prakan','สมุทรสาคร','SAMUTSAKHON','Samut Sakhon')";
    $personPerson = $this->query($sql);
    $arr['KrungthepPerson'] = $this->sumdata($personPerson);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
                WHERE  tb_member_type1.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี') 
                UNION ALL
                SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
                WHERE tb_member_type6.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')
                UNION ALL
                SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
                LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
                WHERE  tb_member_type3.`provinceTh` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')";
    $person = $this->query($sql);
    $arr['Central'] = $this->sumdata($person);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type1.`contact_province`,tb_member_type1.member_id FROM tb_member_type1) tb_member_type1 ON tb_member.member_id = tb_member_type1.member_id 
              WHERE  tb_member_type1.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี') 
              UNION ALL
              SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type6.`contact_province`,tb_member_type6.member_id FROM tb_member_type6) tb_member_type6 ON tb_member.member_id = tb_member_type6.member_id 
              WHERE tb_member_type6.`contact_province` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')";
    $personNiti = $this->query($sql);
    $arr['CentralNiti'] = $this->sumdata($personNiti);
    $sql = "SELECT COUNT(tb_member.`member_id`) as CN  FROM `tb_member` 
              LEFT JOIN (SELECT tb_member_type3.`provinceTh`,tb_member_type3.member_id FROM tb_member_type3) tb_member_type3 ON tb_member.member_id = tb_member_type3.member_id 
              WHERE  tb_member_type3.`provinceTh` IN ('กำแพงเพชร','ชัยนาท','นครนายก','นครสวรรค์','พระนครศรีอยุธยา','พิจิตร','พิษณุโลก','เพชรบูรณ์','ลพบุรี','สมุทรสงคราม','สระบุรี','สิงห์บุรี','สุโขทัย','สุพรรณบุรี','อ่างทอง','อุทัยธานี')";
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
}
