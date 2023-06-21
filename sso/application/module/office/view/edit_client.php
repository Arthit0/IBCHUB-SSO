<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
//include ('component/menu.php');
include ('component/header.php');
?>
<style>
  .sso-btn-backs {
  /* font-family: 'IBM Plex Sans Thai Looped', sans-serif;
  border-radius: 8px;
  background-color: #6F7887;
  border: 0px;
  color: white;
  width: max-content;
  font-size: 16px;
  font-weight: 500;
  mix-blend-mode: normal; */

  font-family: 'IBM Plex Sans Thai Looped', sans-serif;
  color: white;
  width: 120px;
  font-size: 16px;
  font-weight: 500;
  mix-blend-mode: normal;
  width: 162px;
  height: 48px;
  background: #6F7887;
  border-radius: 8px;
  padding: 13px 19px;
}
  .sso-btn-backs:hover{
    color:white;
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
      <form id="form_edit_client" action="" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-6 text-left">
            <h2 class="ibm-sb _f20 p-4">จัดการผู้ให้บริการ API</h2>
          </div>
       </div>
       <div class="sso-section">
        <!-- row 1 --> 
        <div class="row">
          <div class="col-sm-12">
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Client ID</h5></div>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="client_id" autocomplete="off" placeholder="Client ID" value="<?php echo htmlentities($data['client_id']); ?>" required readonly>
              </div>
            </div>
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Client Name</h5></div>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="mc_name" autocomplete="off" placeholder="Client Name" value="<?php echo htmlentities($data['mc_name']); ?>" required>
              </div>
            </div>
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">URL for Reply</h5></div>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="redirect_uri" autocomplete="off" placeholder="URL for Reply" value="<?php echo htmlentities($data['redirect_uri']); ?>">
              </div>
            </div>
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Manage Portal</h5></div>
              <div class="col-sm-4">
                <select class="form-control " title="สถานะ" tabindex="-98" name="portal">
                  <option value="0" <?php if($data['portal']==0) echo "selected"; ?>>ปิดการเชื่อมต่อ</option>
                  <option value="1" <?php if($data['portal']==1) echo "selected"; ?>>เปิดการเชื่อมต่อ</option>
                </select>
              </div>
            </div>
            <div class="row sso-row align-items-center w-100 portal-container d-none">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Portal Title</h5></div>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="title" autocomplete="off" placeholder="URL for Reply" value="<?php echo htmlentities($data['title']); ?>">
              </div>
            </div>
            <div class="row sso-row align-items-center w-100 portal-container d-none">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Portal Description</h5></div>
              <div class="col-sm-6">
                <textarea name="des" class="form-control" autocomplete="off" cols="10" rows="10"><?php echo htmlentities($data['des']); ?></textarea>
              </div>
            </div>
            <div class="row sso-row align-items-center w-100 portal-container d-none">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Portal Image</h5></div>
              <div class="col-sm-6">
                <input class="form-control" type="file" name="img" id="portal-img">
              </div>
            </div>
            <?php if (!empty($data['img'])): ?>
              <div class="row sso-row align-items-center w-100 portal-container d-none">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Preview</h5></div>
                <div class="col-sm-6">
                  <img src="<?php echo BASE_PATH . $data['img'] ?>" alt="preview-img">
                </div>
              </div>
            <?php endif ?>
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Manage Client</h5></div>
              <div class="col-sm-4">
                <input type="hidden" name="mc_id" value="<?php echo htmlentities($data['mc_id']); ?>">
                <!--<input class="form-control" type="text" name="cid" autocomplete="off" placeholder="">-->
                <select class="form-control " title="สถานะ" tabindex="-98" name="status">
                  <option value="0" <?php if($data['status'] == 0) echo "selected"; ?>>ปิดการเชื่อมต่อ</option>
                  <option value="1" <?php if($data['status'] == 1) echo "selected"; ?>>เปิดการเชื่อมต่อ</option>
                </select>
              </div>
            </div>
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Manage Type</h5></div>
              <div class="col-sm-4">
                <input type="hidden" name="type" value="<?php echo htmlentities($data['type']); ?>">
                <!--<input class="form-control" type="text" name="cid" autocomplete="off" placeholder="">-->
                <select class="form-control " title="สถานะ" tabindex="-98" name="type">
                  <option value="0" <?php if($data['type']==0) echo "selected"; ?>>Website</option>
                  <option value="1" <?php if($data['type']==1) echo "selected"; ?>>Mobile APP</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <!-- end of row1 -->
      </div>
      <div class="row">
        <div class="col-sm-12 my-3 text-center">
           <a href="<?php echo BASE_PATH; ?>office/client" class="btn sso-btn-backs">กลับ</a> <button type="submit" class="btn sso-btn-save">บันทึกข้อมูล</button>
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
<?php include ('component/footer.php'); ?>

<script src="<?php echo BASE_PATH; ?>asset/js/page/office/client_manage.js"></script>
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

