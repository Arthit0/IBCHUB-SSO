<?php
class auth_model extends Model
{

  function __construct()
  {
    parent::__construct( );
    // code...
    // $this->db = new db();
  }

  function get_test(){
 
    $sql = 'select 1 ;';
    echo "<pre>" ;
    print_r($this->query($sql));
    echo "</pre>" ;
    exit();
  }
}


 ?>
