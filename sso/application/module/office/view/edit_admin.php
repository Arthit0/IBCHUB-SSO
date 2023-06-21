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
      <form id="form_edit_admin" action="" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-6 text-left">
            <h2 class="ibm-sb _f20 p-4">จัดการเจ้าหน้าที่</h2>
          </div>
       </div>
       <div class="sso-section">
        <!-- row 1 --> 
        <div class="row">
          <div class="col-sm-12">
            <input type="hidden" name="title_level" id="title_level" value="<?php echo htmlentities($data['level']); ?>">
            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">ชื่อ</h5></div>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="name_admin" autocomplete="off" placeholder="ชื่อ" value="<?php echo htmlentities($data['name_admin']); ?>" required >
              </div>
            </div>

            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">นามสกุล</h5></div>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="sname_admin" autocomplete="off" placeholder="นามสกุล" value="<?php echo htmlentities($data['sname_admin']); ?>" required >
              </div>
            </div>

            <div class="row sso-row d-inline-flex align-items-center w-100">
              <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">Username</h5></div>
              <div class="col-sm-6">
                <input class="form-control" type="text" name="sname_admin" autocomplete="off" placeholder="Username" value="<?php echo htmlentities($data['username']); ?>" required >
              </div>
            </div>

            <div class="row sso-row d-inline-flex align-items-center w-100 ">
                <div class="col-sm-3 text-right"><h5 class="mb-0 ibm-m _f16">สิทธิ์ผู้ใช้</h5></div>
                <div class="col-sm-4 level">
                  <select class="form-control " title="สถานะ" tabindex="-98" name="level">
                    <option value="1">Admin</option>
                    <option value="2">Super Admin</option>
                  </select>
                </div>
              </div>
          </div>
        </div>
        <!-- end of row1 -->
      </div>
      <div class="row">
        <div class="col-sm-12 my-3 text-center">
           <a href="<?php echo BASE_PATH; ?>office/admin" class="btn sso-btn-backs">กลับ</a>
           <button type="submit" class="btn sso-btn-save">บันทึกข้อมูล</button>
           <a class='btn sso-btn-pass edit-pass' member-id="<?php echo $data['id_admin']; ?>" member-name="<?php echo $data['username']; ?>" data-toggle='modal' data-target='#ShowModal'>เปลี่ยนรหัสผ่าน</a>
        </div>
      </div>
    </form>
      </div>
    </div>
</div>
</div>
<!-- Footer -->
<div class="modal fade" id="ShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title sso-text-pass" id="exampleModalLabel"><i class='fa fa-key mr-1'></i>เปลี่ยนรหัสผ่าน</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row row-modal">
                <div class="col">
                  <p class="sso-text-pass text-center" id="name_edit"><?php echo htmlentities($data['username']); ?></p>
                </div>
              </div>
              <hr style="margin-bottom: 1rem;margin-top: 0rem; width:70%">
              <div class="row row-modal mb-2">
                <div class="col-lg-4">
                  <p class="main-color sso-text-pass" style="margin-bottom: 0rem;margin-top: 0rem;">รหัสผ่านใหม่&nbsp;<span class="text-danger">*</span></p>
                </div>
                <div class="col-lg-8 inputWithIcon box-username">
                  <input type="password" name="password" id="password" required autocomplete="off" placeholder="รหัสผ่านใหม่" class="input-sso sso-text-pass" aria-label="<?php echo lang('passport_id'); ?>">
                  <i id="show-pass" class="fa fa-eye-slash icon-password"></i>  
                </div>
              </div>
              <div class="row row-modal">
                <div class="col-lg-4">
                  <p class="main-color sso-text-pass" style="margin-bottom: 0rem;margin-top: 0rem;">ยืนยันรหัสผ่าน&nbsp;<span class="text-danger">*</span></p>
                </div>
                  <div class="col-lg-8 inputWithIcon box-username">
                    <input type="password" name="repassword" id="repassword" required autocomplete="off" placeholder="ยืนยันรหัสผ่าน" class="input-sso sso-text-pass" aria-label="<?php echo lang('passport_id'); ?>">
                    <i id="show-repass" class="fa fa-eye-slash icon-password"></i>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-center">
                <input type="hidden" id="id_admin" value="<?php echo htmlentities($data['id_admin']); ?>">
                <button type="button" class="btn sso-btn-back modal-cancel" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn sso-btn-add reset_save">บันทึก</button>
              </div>
            </div>

          </div>
        </div>
      </div>
  </div>
</div>
<?php include ('component/footer.php'); ?>

<script src="<?php echo BASE_PATH; ?>asset/js/page/office/admin_manage.js"></script>
<script>
  $(document).ready(function(){
    var level =  $(`#title_level`).val();
    setTimeout(function(){
      $("div.level select").val(level).change();
    }, 500);
  });
</script>

