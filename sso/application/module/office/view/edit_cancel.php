<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
//include ('component/menu.php');
include ('component/header.php');
?>

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
        <div class="col-sm-6 text-left">
          <h2 class="ibm-sb _f20 p-4">จัดการยิกเลิกผู้ใช้</h2>
        </div>
       </div>
        <div class="sso-section">
        <!-- row 1 --> 
        <div class="row">
          <div class="col-12">
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-3 text-right"><h5 class="mb-0 ibm-m _f16">เนื่อหา (ภาษาไทย)</h5></div>
              <div class="col-6">
                <input class="form-control ibm-m _f16" type="text" name="text_th" autocomplete="off" placeholder="เนื่อหา (ภาษาไทย)" value = "<?php echo $data[1]; ?>" required>
              </div>
            </div>
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-3 text-right"><h5 class="mb-0 ibm-m _f16">เนื่อหา (ภาษาอังกฤษ)</h5></div>
              <div class="col-6">
                <input class="form-control ibm-m _f16" type="text" name="text_en" autocomplete="off" placeholder="เนื่อหา (ภาษาอังกฤษ)"  value = "<?php echo $data[2]; ?>" required>
              </div>
            </div>
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-3 text-right"><h5 class="mb-0 ibm-m _f16">ไอดีผู้แก้ไข</h5></div>
              <div class="col-6">
                <input class="form-control ibm-m _f16" type="text" name="ssoid" autocomplete="off" placeholder="Client ID" 
                required readonly value = "<?php echo $data[0]; ?>">
              </div>
            </div>
            
          </div>
        </div>
        <!-- end of row1 -->
      </div>
      <div class="row">
        <div class="col-sm-12 my-3 text-center">
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