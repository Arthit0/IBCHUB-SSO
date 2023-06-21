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
  .bootstrap-select.sso-dropdown.sso-dropdown-edit .dropdown-toggle{
    border-radius: 25px;
    height: 48px;
    border: 1px solid #629cc1;
    -webkit-box-shadow: inset 0px 0px 0px 0px rgba(202, 216, 225, 1);
    -moz-box-shadow: inset 0px 0px 0px 0px rgba(202, 216, 225, 1);
    box-shadow: inset 0px 0px 0px 0px rgba(202, 216, 225, 1);
    background-color: #ffffff;
    font-size:24px;

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
    <form id="form_edit_cancel" action="" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-6 text-left">
          <h2 style="color:#629cc1">Cancel List > Edit Text</h2>
        </div>
        <div class="col-6 text-right">
          <a href="<?php echo BASE_PATH; ?>office/cancel" class="btn sso-btn-back">กลับ</a> <button type="submit" class="btn sso-btn-save">บันทึกข้อมูล </button>
        </div>
       </div>
        <div class="sso-section">
        <!-- row 1 --> 
        <div class="row">
          <div class="col-12">
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>เนื่อหา (ภาษาไทย)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="text_th" autocomplete="off" placeholder="เนื่อหา (ภาษาไทย)" value = "<?php echo $data[1]; ?>" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>เนื่อหา (ภาษาอังกฤษ)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="text_en" autocomplete="off" placeholder="เนื่อหา (ภาษาอังกฤษ)"  value = "<?php echo $data[2]; ?>" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>ไอดีผู้แก้ไข</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="ssoid" autocomplete="off" placeholder="Client ID" 
                required readonly value = "<?php echo $data[0]; ?>">
              </div>
            </div>
            
          </div>
        </div>
        <!-- end of row1 -->
      </div>
      <div class="row">
        <div class="col-12 my-3 text-center">
           <a href="<?php echo BASE_PATH; ?>office/cancel" class="btn sso-btn-back">กลับ</a> <button type="submit" class="btn sso-btn-save">บันทึกข้อมูล</button>
        
          </div>
      </div>
    </form>
  </div>
  </div>
</div>
</div>
<!-- Footer -->

<script src="<?php echo BASE_PATH; ?>asset/js/page/office/client_manage.js"></script>
<?php include ('component/footer.php'); ?>