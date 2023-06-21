<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
?>

<div class="row">
  <div class=" d-md-block d-none col-md-4 pr-0">
    <div class="left-side d-flex">
      <div class="container-fluid d-flex">
        <div class="row">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <img class="w-50" src="<?php echo BASE_PATH; ?>asset/img/new-sso-logo-white.png" alt="">
          </div>
          <div class="col-12 d-flex align-items-end justify-content-center position-absolute fixed-bottom p-4">
            <div class="row">
              <div class="col-12 d-flex align-items-end justify-content-center">
                <img class="w-50 p-4" src="<?php echo BASE_PATH; ?>asset/img/ditp-logo-white.png" alt="">
              </div>
              <div class="col-12">
                <p class="text-center text-white text-sm">
                  563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000
                  โทร : 02507 7999 | e-mail : 1169@ditp.go.th
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <div class="col-md-8 col-md-none pl-0">
    <nav class="navbar navbar-light ">
      <div class="navbar-brand pointer">
        <a href="<?php echo BASE_PATH . _INDEX ?>auth" class="d-block d-md-none">
          <img src="<?php echo BASE_PATH; ?>asset/img/chevron-left-material@3x.png" alt="" style="height: 30px;">
        </a>
      </div>
      <div class="justify-content-end">
      </div>
    </nav>
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height:95%">
      <form action="#" method="post" id="formlogin" enctype="multipart/form-data">
        <div class="row  login-box">
        
          <div class="col-12 col-lg-12 text-center text-dark"><h1 class="mitr-r _f32">เข้าสู่ระบบ Back-office</div>
          <div class="col-12 col-lg-12 ">
            <div class="text-dark mitr-r _f16">Username&nbsp;</div>
          </div>
          <div class="col-12 col-lg-12 pb-15">

            <div class="inputWithIcon box-username">
              <input type="text" name="username" class="" placeholder="Username" aria-label="Username" id="lg_username">
              <img src="<?php echo BASE_PATH; ?>asset/img/input-login-user.png" alt="">
            </div>
          </div>
          <div class="col-12 col-lg-12 ">
            <div class="text-dark mitr-r _f16">Password</div>
          </div>
          <div class="col-12 col-lg-12 pb-15">
            <div class="inputWithIcon box-password">
              <input type="password" name="password" class="" placeholder="Password" aria-label="Password" id="lg_password" >
              <img src="<?php echo BASE_PATH; ?>asset/img/input-lock.png" alt="">
              <i id="show-pass" class="fa fa-eye-slash icon-password" style="padding: 10px 9px!important;"></i>
            </div>
          </div>

          <div class="col-12 col-lg-12 mb-2">
            <button type="submit" class="btn  w-100 btn-login text-white mitr-r _f16"><?php echo lang('signin'); ?></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal sso-modal" tabindex="-1" role="dialog" id="tooltip_username">
  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">
      <div class="pointer btn-close-modal" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body">
        <p style="font-size:25px;color:#163c70;">Username :</p>
        <ul style="color: #7d7d7d;font-size:18px;">
          <li>เลขนิติบุคคล / Corporate ID </li>
          <li>เลขบัตรประจำตัวประชาชน / Passport ID</li>
          <li>เลขประจำตัวองค์กร, หน่วยงาน</li>
        </ul>
      </div>

    </div>
  </div>
</div>

<!-- <div class="modal sso-modal" tabindex="-1" role="dialog" id="public_modal" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">
      <div class="pointer btn-close-modal" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </div>
      <div style="text-align: center;padding-top: 30px;">
        <img src="<?php echo BASE_PATH; ?>asset/img/alert@3x.png" alt="" style="    height: 70px; width: 70px;">
      </div>
      <div class="modal-body">

      </div>

    </div>
  </div>
</div> -->

<!-- <div class="modal sso-modal" tabindex="-1" role="dialog" id="public_alert" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">
      <div class="pointer btn-close-modal" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </div>
      <div style="text-align: center">
        <img src="<?php echo BASE_PATH; ?>asset/img/Pop Up Maintenance-13.png" alt="" style="    height:100%; width: 100%;">
      </div>
     

    </div>
  </div>
</div> -->

<!-- <div class="modal sso-modal" tabindex="-1" role="dialog" id="public_alert" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">
      <div class="pointer btn-close-modal" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </div>
      <div class="">
        <img src="<?php echo BASE_PATH; ?>asset/img/intro_28_7.jpg" alt="" style=" height:100%; width: 100%;">
      </div>

    </div>
  </div>
</div> -->



<script src="<?php echo BASE_PATH; ?>asset/js/page/office/office_login.js"></script>