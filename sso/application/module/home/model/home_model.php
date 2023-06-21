<?php

use \Firebase\JWT\JWT;

class home_model extends Model
{

  function __construct()
  {
    parent::__construct();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // code...
    // $this->db = new db();
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
}
