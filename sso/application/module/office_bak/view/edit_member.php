<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
//include ('component/menu.php');
include ('component/header.php');
?>
<style>
  .loader_input {
    position: relative;
  }
  .sso-input{
    height: 48px;
    object-fit: contain;
    border-radius: 24px;
    border: solid 1px #629cc1;
    background-color: #ffffff;
    padding: 22px 25px;
    width:100%;
    outline: 0;
    font-size: 20px;
  }
  .sso-input:focus {
    border-color: dodgerBlue;
    box-shadow: 0 0 8px 0 dodgerBlue;
  }
  .sso-row{
    padding:5px;
  }
  .sso-section{
    border-radius: 10px;
    box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.3);
    background-color: #ffffff;
    padding:20px;
  }
  .sso-btn-save{
    border-radius: 21.5px;
    border:0px;
    background-color: #4189b7;
    color:white;
    width: 120px;
    font-size: 18px;
  }
  .sso-btn-save:hover{
    color:white;
  }
  .sso-btn-back{
    border-radius: 21.5px;
    background-color: #2b485b;
    border:0px;
    color:white;
    width: 100px;
    font-size: 18px;
  }
  .sso-btn-back:hover{
    color:white;
  }
  .sso-hr{
    width:95%;
    background-color:#629cc1;
  }
  .btn-danger-delete{
    border-radius: 21.5px;
    border:0px;
    background-color: #c82333;
    color:white !important;
    width: 120px;
    font-size: 18px;
  }
  .btn-danger-delete:hover{
    color:white !important;
  }
  
</style>
<div class="wrapper">
<?php 
  include ('component/nav.php'); 
  include ('component/menu_lte.php'); 
?>
    <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">

       <form id="form_edit_member" method="post" enctype="multipart/form-data">
      
       <div class="row">
        <div class="col-6 text-left">
          <h2 style="color:#629cc1">User List > Edit User Infomation</h2>
        </div>
        <div class="col-6 text-right">
          <a href="<?php echo BASE_PATH; ?>office/user" class="btn sso-btn-back">กลับ</a> <button class="btn sso-btn-save">บันทึกข้อมูล</button> <a class="btn btn-danger-delete">ลบข้อมูล</a>
        </div>
       </div>
       <?php //print_r($member_type); //echo $data['data']; die(); //echo $data['member_name']; ?>
      <?php
      //echo "<h1>".$member['type']."</h1>";
        // var_dump($member,$member[0]['UserType'],$member[0]['Is_Thai']);
        // die();
        if($member['type'] == 1){ //นิติบุคคลไทย
          include ('component/type_1.php');
        }else if($member['type'] == 2){ //นิติบุคคลต่างชาติ
          include ('component/type_2.php');
        }else if($member['type'] == 3){ //บุคคลไทย 
          include ('component/type_3.php');
        }else if($member['type'] == 4){ //บุคคลต่างชาติ
          include ('component/type_4.php');
        }if($member['type'] == 5){ //บุคคลต่างชาติ
          include ('component/type_5.php');
        }if($member['type'] == 6){ //นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
          include ('component/type_6.php');
        }
        if($member[0]['UserType'] == "corporate" ){ //นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
          include ('component/corporate_Y.php');
        }else if($member[0]['UserType'] == "person"){ //นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
          include ('component/person_Y.php');
        }
      ?>  
      <div class="row">
        <div class="col-12 my-3 text-center">
           <a href="<?php echo BASE_PATH; ?>office/user" class="btn sso-btn-back">กลับ</a> <button class="btn sso-btn-save">บันทึกข้อมูล</button><a class="btn btn-danger-delete">ลบข้อมูล</a>
        </div>
      </div>
    </form>
      </div>
    </div>
      </div>
</div>
<!-- Footer -->
  </div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/user_manage.js"></script>
<?php include ('component/footer.php'); ?>