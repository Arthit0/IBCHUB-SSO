<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
//include ('component/menu.php');
include ('component/header.php');
?>
<script src="<?php echo BASE_PATH; ?>asset/js/vendors/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#n_des',
    branding: false,
    promotion: false,
    plugins: 'image code',
    toolbar: 'undo redo | link image | code',
    file_picker_types: 'image',
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
  });
</script>
<div class="wrapper">
<?php 
  include ('component/nav.php'); 
  include ('component/menu_lte.php'); 
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
    <form id="form_add_news" action="" method="post" enctype="multipart/form-data">
      <div class="row m-4">
        <div class="col-6 text-left">
          <h2 class="ibm-sb _f20">จัดการข่าวสาร/แจ้งเตือน</h2>
        </div>
       </div>
        <div class="sso-section">
          <!-- row 1 --> 
          <div class="row">
            <div class="col-sm-12">
              <div class="row sso-row d-inline-flex align-items-center w-100">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">หัวข้อข่าว/แจ้งเตือน</h5></div>
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="n_title" autocomplete="off" placeholder="หัวข้อข่าว/แจ้งเตือน" required>
                </div>
              </div>
              <div class="row sso-row d-inline-flex align-items-center w-100">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">รายละเอียด</h5></div>
                <div class="col-sm-6">
                  <textarea class="form-control" name="n_des" id="n_des" cols="30" rows="10"></textarea>
                </div>
              </div>
              <div class="row sso-row d-inline-flex align-items-center w-100">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">วันที่เผยแพร่</h5></div>
                <div class="col-sm-6">
                  <input class="form-control" type="date" name="publicdate" autocomplete="off" placeholder="DD/MM/YYYY" required>
                </div>
              </div>
            </div>
          </div>
          <!-- end of row1 -->
      </div>
      <div class="row">
        <div class="col-12 my-3 text-center">
           <a href="<?php echo BASE_PATH; ?>office/news" class="btn sso-btn-back">กลับ</a> <button type="submit" class="btn sso-btn-save">บันทึกข้อมูล</button>
        
          </div>
      </div>
    </form>
  </div>
  </div>
</div>
</div>
<!-- Footer -->

<script src="<?php echo BASE_PATH; ?>asset/js/page/office/news_manage.js"></script>
<?php include ('component/footer.php'); ?>
