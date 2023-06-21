<?php
$lang = 'th';
$imgs = 'asset/img/popup-sso-26012565.jpg';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
  $imgs = 'asset/img/popup-sso-26012565.jpg';
  }
?>
<style>
  @media  screen and (max-width: 425px) {
    .container-fluid {
      padding-right: 0;
    }

    .login-box {
      padding: 0px 10%!important;
      margin-top: 1rem;
    }
  }
  .btn-white{
    background: #FFFFFF !important;
    border: 1px solid #2D6DC4 !important;
    border-radius: 8px;
  }
  .btn-attach{
    background: #2D6DC4 !important; 
    border-radius: 8px;
  }

  .btn-login:hover {
    background-color: white!important;
    border:1px solid var(--main-color-1)!important;
    color: var(--main-color-1)!important;
  }
</style>
<div class="row w-100 m-0">
  <div class=" d-md-block d-none col-md-4 px-0">
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
                <p class="text-center text-white mitr-l _f14">
                  563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 <br>
                  Call Center : 1169 | e-mail : 1169@ditp.go.th
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <div class="col-md-8 col-md-none pl-0" style="height: 100vh;overflow: hidden;overflow-y: auto;">
    <nav class="navbar navbar-light ">
      <div class="navbar-brand pointer">
        <a href="<?php echo BASE_PATH . _INDEX ?>auth" class="d-none">
          <img src="<?php echo BASE_PATH; ?>asset/img/chevron-left-material@3x.png" alt="" style="height: 30px;">
        </a>
      </div>
      <div class="justify-content-end">
        <a href="tel:1169" class="contact-tel mitr-l"><?php echo lang('home_contact_nav') ?><i class="fa fa-phone"></i>&nbsp;1169</a>
        <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/th" class="change-lang">
          <img class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png" alt="">
        </a>
        <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/en" class="change-lang mitr-l">
          <img class="<?php echo ($lang == 'en') ? ' active ' : '';?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png" alt="">
        </a>
      </div>
    </nav>
    <div class="container-fluid">
      <form action="#" method="post" id="formlogin" enctype="multipart/form-data" autocomplete="off">
        <div class="row  login-box">
          <img class="d-md-none login-logo" src="<?php echo BASE_PATH; ?>asset/img/new-logo-sso@3x.png" alt="sso-logo">
          <div class="col-12 col-lg-12 text-center text-dark mitr-r mb-4" style="font-size: 32px"><?php  echo strtoupper(lang('signin')); ?></div>
          <div class="col-12 col-lg-12 ">
            <div class="text-dark mitr-r mb-2">Username&nbsp;</div>
          </div>
          <div class="col-12 col-lg-12 pb-15">

            <div class="inputWithIcon box-username">
              <span class="d-inline-flex align-items-center w-100">
                <input type="text" class="" name="<?php echo $_SESSION['username'] ?>" class="" placeholder="Username"  autocomplete="off">
                <!-- <input type="text" name="username" class="" placeholder="Username" aria-label="Username" id="lg_username" autocomplete="off"> -->
                <img src="<?php echo BASE_PATH; ?>asset/img/input-login-user.png" alt="">
              </span>
              <small id="water-mark" class="form-text text-dark mitr-l" style="font-size: 14px;margin-top: 2%;">เลขนิติบุคคล/Corporate ID, เลขบัตรประจำตัวประชาชน, Passport ID หรือ อีเมลของเจ้าหน้าที่กรม </small>
            </div>
          </div>
          <div class="col-12 col-lg-12 ">
            <div class="text-dark mitr-r mb-2">Password</div>
          </div>
          <div class="col-12 col-lg-12 pb-15">
            <div class="inputWithIcon box-password">
              <span class="d-inline-flex align-items-center w-100">
                <input type="text" class="" name="<?php echo $_SESSION['password'] ?>" class="" placeholder="Password"  >
                <!-- <input type="text" name="password" class="" placeholder="Password" aria-label="Password" id="lg_password" autocomplete="new-password"> -->
                <img src="<?php echo BASE_PATH; ?>asset/img/input-lock.png" alt="">
                <i id="show-pass" class="far fa-eye-slash icon-password fa-flip-horizontal" style="padding: 10px 9px!important;color:#39414F;"></i>
              </span>
            </div>
          </div>
          <div class="col-12 col-lg-12 text-right pb-30">
            <a href="<?php echo BASE_PATH . _INDEX ?>auth/forget" class="text-dark "><?php echo lang('change_forget_pass'); ?></a>
          </div>

          <div class="col-12 col-lg-12">
            <button type="submit" class="btn  w-100 btn-login text-white mitr-r"><?php echo lang('signin'); ?></button>
          </div>
          <div class="col-12 col-lg-12 mb-2 d-flex justify-content-center text-center text-dark my-3">
            <span><?php echo lang('home_or') ?></span>
          </div>
          <!-- <div class="col-12 col-lg-12 mb-2" style="display :none;"> -->
          <div class="col-12 col-lg-12 mb-2">
            <!-- <button onclick="window.location.href='auth/moccallback'" type="button" class="btn  w-100 btn-login-moc bdr-20 " id="login_moc"><b><?php echo lang('signin_moc'); ?></b></button> -->
            <button type="button" class="btn  w-100 btn-login-moc text-white mitr-r" id="login_moc"><?php echo lang('signin_moc'); ?></button>
          </div>
          <div class="col-12 col-lg-12 w-100 mb-2">
            <p class="text-dark text-center mitr-l mt-4 mb-0 _f16 w-100"><?php echo lang('register') ?>&nbsp;<a class="mitr-r _f16" style="color:#2D6DC4;" href="<?php echo BASE_PATH . _INDEX ?>register"><?php echo lang('click_here') ?></a></p>
          </div>
          <div class="col-12 col-lg-12 mb-2">
            <img class="d-md-none login-ditp-logo" src="<?php echo BASE_PATH; ?>asset/img/ditp-logo@3x.png" alt="sso-logo">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal sso-modal " tabindex="-1" role="dialog" id="public_alert" >
        <div class="modal-dialog modal-dialog-centered modal-m">

            <div class="modal-content">
            <div class="pointer btn-close-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </div>
            <div style="text-align: center">
                <img src="<?php echo BASE_PATH.''.$imgs; ?>" alt="" style="height:100%; width: 100%;">
            </div>
            <br>
              <a class ="btn btn-info" data-dismiss="modal" aria-label="Close" style ="border-radius: 19px;width: 28%; margin-left:35%;color: white;">ปิด</a>
            </div>
            <br>
        </div>
        </div>  
<script src="<?php echo BASE_PATH; ?>asset/js/page/login/login.js?ver=<?php echo $cash_time; ?>"></script>
<script>
  $(function() {
     // document.getElementById('lg_password').type = 'password';
  });
  $(`.box-password input[type="text"]`).on('keyup', function () {
    this.type = 'password';
  })
</script>