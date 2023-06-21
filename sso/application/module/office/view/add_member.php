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
    <form id="form_add_user" action="" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-6 text-left">
          <h2 style="color:#629cc1">User List > Add User</h2>
        </div>
        <div class="col-6 text-right">
          <a href="<?php echo BASE_PATH; ?>office/user" class="btn sso-btn-back">กลับ</a> <button type="submit" class="btn sso-btn-save">บันทึกข้อมูล </button>
        </div>
       </div>
        <div class="sso-section">
        <!-- row 1 --> 
        <div class="row">
          <div class="col-12">
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>รหัสประจำตัวประชาชน (Username)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="cid" autocomplete="off" placeholder="รหัสประชาชน (Username)" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>รหัสผ่าน</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="password" autocomplete="off" placeholder="รหัสผ่าน" required>
              </div>
            </div>
            <hr class="sso-hr">
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>คำนำหน้าชื่อ</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="member_title" autocomplete="off" placeholder="คำนำหน้าชื่อ" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>ชื่อ</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="member_nameTh" autocomplete="off" placeholder="ชื่อ" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>นามสกุล</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="member_lastnameTh" autocomplete="off" placeholder="นามสกุล" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>อีเมล</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="email" autocomplete="off" placeholder="อีเมล" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>เบอร์โทรศัพท์</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="tel" autocomplete="off" placeholder="เบอร์โทรศัพท์" required>
              </div>
            </div>
            <hr class="sso-hr">
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>เลขที่อยู่</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="addressTh" autocomplete="off" placeholder="เลขที่อยู่" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>จังหวัด</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="provinceTh" autocomplete="off" placeholder="จังหวัด" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>อำเภอ</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="districtTh" autocomplete="off" placeholder="อำเภอ" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>ตำบล</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="subdistrictTh" autocomplete="off" placeholder="ตำบล" required>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>รหัสไปรษณีย์</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="postcode" autocomplete="off" placeholder="รหัสไปรษณีย์" required>
              </div>
            </div>
          </div>
        </div>
        <!-- end of row1 -->
      </div>
      <div class="row">
        <div class="col-12 my-3 text-center">
           <a href="<?php echo BASE_PATH; ?>office/user" class="btn sso-btn-back">กลับ</a> <button type="submit" class="btn sso-btn-save">บันทึกข้อมูล</button>
        
          </div>
      </div>
    </form>
  </div>
  </div>
</div>
</div>
<!-- Footer -->

<script src="<?php echo BASE_PATH; ?>asset/js/page/office/user_manage.js"></script>
<?php include ('component/footer.php'); ?>