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
    <form id="form_add_client" action="" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-6 text-left">
          <h2 class="ibm-sb _f20 p-4">จัดการผู้ให้บริการ</h2>
        </div>
       </div>
        <div class="sso-section">
          <!-- row 1 --> 
          <div class="row">
            <div class="col-sm-12">
              <div class="row sso-row d-inline-flex align-items-center w-100">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Client ID</h5></div>
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="client_id" autocomplete="off" placeholder="Client ID" value="<?php echo htmlentities($data); ?>" required readonly>
                </div>
              </div>
              <div class="row sso-row d-inline-flex align-items-center w-100">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Client Name</h5></div>
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="mc_name" autocomplete="off" placeholder="Client Name" required>
                </div>
              </div>
              <div class="row sso-row d-inline-flex align-items-center w-100">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">URL for Reply</h5></div>
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="redirect_uri" autocomplete="off" placeholder="URL for Reply" >
                </div>
              </div>
              <div class="row sso-row d-inline-flex align-items-center w-100">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Manage Portal</h5></div>
                <div class="col-sm-4">
                  <select class="form-control " title="สถานะ" tabindex="-98" name="portal">
                    <option value="0">ปิดการเชื่อมต่อ</option>
                    <option value="1">เปิดการเชื่อมต่อ</option>
                  </select>
                </div>
              </div>
              <div class="row sso-row align-items-center w-100 portal-container d-none">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Portal Title</h5></div>
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="title" autocomplete="off" placeholder="Portal Title" >
                </div>
              </div>
              <div class="row sso-row align-items-center w-100 portal-container d-none">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Portal Description</h5></div>
                <div class="col-sm-6">
                  <textarea name="des" class="form-control" autocomplete="off" cols="10" rows="10"></textarea>
                </div>
              </div>
              <div class="row sso-row align-items-center w-100 portal-container d-none">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Portal Image</h5></div>
                <div class="col-sm-6">
                  <input class="form-control" type="file" name="img" id="portal-img">
                </div>
              </div>
              <div class="row sso-row d-inline-flex align-items-center w-100">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Manage Client</h5></div>
                <div class="col-sm-4">
                  <select class="form-control " title="สถานะ" tabindex="-98" name="status">
                    <option value="0">ปิดการเชื่อมต่อ</option>
                    <option value="1">เปิดการเชื่อมต่อ</option>
                  </select>
                </div>
              </div>
              <div class="row sso-row d-inline-flex align-items-center w-100">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Manage Type</h5></div>
                <div class="col-sm-4">
                  <select class="form-control " title="สถานะ" tabindex="-98" name="type">
                    <option value="0">Website</option>
                    <option value="1">Mobile APP</option>
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

<script src="<?php echo BASE_PATH; ?>asset/js/page/office/client_manage.js"></script>
<?php include ('component/footer.php'); ?>
<script>
  $(document).ready(function(){
      $('select[name="portal"]').change(function(){
          let pval = $(this).val();
          console.log(pval);
          if (pval == 1) {
              $('.portal-container').removeClass('d-none');//Hide all
          } else {
              $('.portal-container').removeClass('d-none');
              $('.portal-container').addClass('d-none');//Hide all
          }
      });
      $('select[name="portal"]').change();
  });
</script>