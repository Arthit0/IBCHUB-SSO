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
      <form id="form_edit_client" action="" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-6 text-left">
            <h2 style="color:#629cc1">User List > Edit User Infomation</h2>
          </div>
          <div class="col-6 text-right">
            <a href="<?php echo BASE_PATH; ?>office/client" class="btn sso-btn-back">กลับ</a> <button class="btn sso-btn-save">บันทึกข้อมูล</button>
          </div>
       </div>
       <div class="sso-section">
        <!-- row 1 --> 
        <div class="row">
          <div class="col-12">
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>ชื่อผู้เชื่อมต่อ (Client Name)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="mc_name" autocomplete="off" placeholder="Client Name" value="<?php echo htmlentities($data['mc_name']); ?>" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>ไอดีผู้เชื่อมต่อ (Client ID)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="client_id" autocomplete="off" placeholder="Client ID" value="<?php echo htmlentities($data['client_id']); ?>" required readonly>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>URL เพื่อตอบกลับ (URL for Reply)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="redirect_uri" autocomplete="off" placeholder="URL for Reply" value="<?php echo htmlentities($data['redirect_uri']); ?>">
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>จัดการผู้เชื่อมต่อ (Manage Client)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input type="hidden" name="mc_id" value="<?php echo htmlentities($data['mc_id']); ?>">
                <!--<input class="sso-input" type="text" name="cid" autocomplete="off" placeholder="">-->
                <select class="form-control selectpicker sso-dropdown sso-dropdown-edit" title="สถานะ" tabindex="-98" name="status">
                  <option value="0" <?php if($data['status']==0) echo "selected"; ?>>ปิดการเชื่อมต่อ</option>
                  <option value="1" <?php if($data['status']==1) echo "selected"; ?>>เปิดการเชื่อมต่อ</option>
                </select>
              </div>
            </div>

          </div>
        </div>
        <!-- end of row1 -->
      </div>
      <div class="row">
        <div class="col-12 my-3 text-center">
           <a href="<?php echo BASE_PATH; ?>office/client" class="btn sso-btn-back">กลับ</a> <button type="submit" class="btn sso-btn-save">บันทึกข้อมูล</button>
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
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/client_manage.js"></script>
<?php include ('component/footer.php'); ?>