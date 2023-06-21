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
        <!-- <a href="tel:1169" class="contact-tel"><?php echo lang('home_contact_nav') ?><i class="fa fa-phone"></i>&nbsp;1169</a>
        <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/th" class="change-lang">
          <img class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png" alt="">
        </a>
        <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/en" class="change-lang">
          <img class="<?php echo ($lang == 'en') ? ' active ' : '';?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png" alt="">
        </a> -->
      </div>
    </nav>
    <div class="container-fluid">
      <form action="#" method="post" id="formlogin" enctype="multipart/form-data">
        <div class="row  login-box">
        
          <div class="col-12 col-lg-12 text-center text-dark"><h1><b>เข้าสู่ระบบ Back-office</b></h1></div>
          <div class="col-12 col-lg-12 ">
            <div class="text-dark"><b>Username</b>&nbsp;</div>
          </div>
          <div class="col-12 col-lg-12 pb-15">

            <div class="inputWithIcon box-username">
              <input type="text" name="username" class="" placeholder="Username" aria-label="Username" id="lg_username" style="font-weight : bold;">
              <img src="<?php echo BASE_PATH; ?>asset/img/input-login-user.png" alt="">
            </div>
          </div>
          <div class="col-12 col-lg-12 ">
            <div class="text-dark"><b>Password</b></div>
          </div>
          <div class="col-12 col-lg-12 pb-15">
            <div class="inputWithIcon box-password">
              <input type="password" name="password" class="" placeholder="Password" aria-label="Password" id="lg_password" style="font-weight : bold;">
              <img src="<?php echo BASE_PATH; ?>asset/img/input-lock.png" alt="">
              <i id="show-pass" class="fa fa-eye-slash icon-password" style="padding: 10px 9px!important;"></i>
            </div>
          </div>

          <div class="col-12 col-lg-12 mb-2">
            <button type="submit" class="btn  w-100 btn-login text-white"><?php echo lang('signin'); ?></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>





<nav class="navbar navbar-light ">
  <div class="navbar-brand"></div>
  <!--<div class="form-inline">
    <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/th" class="change-lang"><img class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png" alt=""></a>
    <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/en" class="change-lang"><img class="<?php echo ($lang == 'en') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png" alt=""></a>
  </div>-->
</nav>
<div class="container con-box">
  <div class="row  con-box-row">
    <div class=" col-sm-12 col-md-12 col-lg-6 text-center m-auto-0 pb-7-p box-logo">
      <img class=" sso-logo" src="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" alt="">
    </div>



    <div class=" col-sm-12 col-md-12 col-lg-5 m-auto-0">
      <form action="#" method="post" id="formlogin" enctype="multipart/form-data">
        <div class="row  login-box">
       
          <div class="col-12 col-lg-12 text-center login-title"><?php //echo password_hash('sso@ditpadmin3', PASSWORD_DEFAULT);//echo strtoupper(lang('signin')); ?>เข้าสู่ระบบ Back-office</div>
          <div class="col-12 col-lg-12 ">
            <div>Username&nbsp;<!--<span data-toggle="modal" data-target="#tooltip_username" style="cursor: pointer;"><img src="<?php //echo BASE_PATH; ?>asset/img/help-icon.png" alt="Help!!" style="width: 12px; height: 12px;"></span>--></div>
          </div>
          <div class="col-12 col-lg-12 pb-15">

            <div class="inputWithIcon box-username">
              <input type="text" name="username" class="" placeholder="Username" aria-label="Username" id="lg_username">
              <img src="<?php echo BASE_PATH; ?>asset/img/input-login-user.png" alt="">
            </div>
          </div>
          <div class="col-12 col-lg-12 ">
            <div>Password</div>
          </div>
          <div class="col-12 col-lg-12 pb-15">
            <!-- <div>
              <div class="input-group bdr-20">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" id="lg_password">
              </div>
            </div> -->
            <div class="inputWithIcon box-password">
              <input type="password" name="password" class="" placeholder="Password" aria-label="Password" id="lg_password">
              <img src="<?php echo BASE_PATH; ?>asset/img/input-lock.png" alt="">
            </div>
          </div>
          <div class="col-12 col-lg-12 text-right pb-30">
            <!--<a href="<?php //echo BASE_PATH . _INDEX ?>auth/forget" style="  text-decoration: underline;color:#cad8e1;"><?php //echo lang('forget_pass'); ?></a>-->
          </div>

          <div class="col-12 col-lg-12 mb-2">
            <button type="submit" class="btn  w-100 btn-login bdr-20 "><?php echo lang('signin'); ?></button>
          </div>

          <!--<div class="col-12 col-lg-12 ">
            <a href="<?php echo BASE_PATH . _INDEX ?>register">
              <div class="btn btn-primary w-100 bdr-20 btn-register"><?php echo lang('register'); ?></div>
            </a>

          </div>-->
          <div class="col-12  logo-ditp">
            <img src="<?php echo BASE_PATH; ?>asset/img/ditp-logo.png" alt="">
          </div>
        </div>

      </form>
    </div>

  </div>

</div>
<div class=" row-logo-ditp-sm">
  <div class="  logo-ditp-sm">
    <img src="<?php echo BASE_PATH; ?>asset/img/ditp-logo.png" alt="">
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