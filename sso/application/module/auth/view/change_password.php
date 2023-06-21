<?php
$lang = 'th';
$imgs = 'asset/img/Artboard.jpg';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
  $imgs = 'asset/img/ArtboardEng.jpg';
  }
?>
<style>
    .inputWithIcon i {
        top: 9px;
    } 
    .inputWithIcon img {
        top: 2px;
    }   
  @media  screen and (max-width: 425px) {
    .container-fluid {
      padding-right: 0;
    }

    .login-box {
      padding: 0px 10%!important;
    }
  }
</style>
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
                <p class="text-center text-white mitr-l _f14">
                  563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 <br>
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
        <a href="tel:1169" class="contact-tel mitr-l"><?php echo lang('home_contact_nav') ?><i class="fa fa-phone"></i>&nbsp;1169</a>
        <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/th" class="change-lang">
          <img class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png" alt="">
        </a>
        <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/en" class="change-lang mitr-l">
          <img class="<?php echo ($lang == 'en') ? ' active ' : '';?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png" alt="">
        </a>
      </div>
    </nav>
    <div class="container-fluid d-flex align-items-center" style="height:87vh;">
      <form action="#" method="post" id="form_changepassword" enctype="multipart/form-data">
        <div class="row  login-box mt-0">
        
          <div class="col-12 col-lg-12 text-center text-dark mitr-r" style="font-size: 32px"><?php echo lang('change_password'); ?></div>
          <!-- รหัสเดิม -->
          <div class="col-12 col-lg-12 ">
            <div class="text-dark mitr-r"><?php echo lang('old_password'); ?>&nbsp;<span class="text-danger">*</span></div>
          </div>
          <div class="col-12 col-lg-12 pb-15">

            <div class="inputWithIcon box-username">
              <input type="password" name="old_password" id="old_password" required autocomplete="off" placeholder="<?php echo lang('old_password'); ?>" class="input-sso" aria-label="<?php echo lang('passport_id'); ?>">
              <i id="old-pass" class="fa fa-eye-slash icon-password"></i>  
              <img src="<?php echo BASE_PATH; ?>asset/img/input-login-user.png" alt="">
                
            </div>
          </div>
          <!-- รหัสใหม่ -->
          <div class="col-12 col-lg-12 ">
            <div class="text-dark mitr-r"><?php echo lang('new_password'); ?>&nbsp;<span class="text-danger">*</span></div>
          </div>
          <div class="col-12 col-lg-12 pb-15">

            <div class="inputWithIcon box-username">
              <input type="password" name="new_password" id="new_password" required autocomplete="off" placeholder="<?php echo lang('new_password'); ?>" class="input-sso" aria-label="<?php echo lang('passport_id'); ?>">
              <i id="new-pass" class="fa fa-eye-slash icon-password"></i>  
              <img src="<?php echo BASE_PATH; ?>asset/img/input-login-user.png" alt="">
                
              <small id="water-mark" class="form-text text-dark mitr-l" style="font-size: 14px;margin-top: 2%;"><?php echo lang('regis_pass_recom'); ?></small>
            </div>
          </div>
          <!-- รหัสใหม่ยืนยัน -->
          <div class="col-12 col-lg-12 ">
            <div class="text-dark mitr-r"><?php echo lang('confirm_password'); ?>&nbsp;<span class="text-danger">*</span></div>
          </div>
          <div class="col-12 col-lg-12 pb-15">

            <div class="inputWithIcon box-username">
              <input type="password" name="new_password2" id="confirm_password" required autocomplete="off" placeholder="<?php echo lang('confirm_password'); ?>" class="input-sso" aria-label="<?php echo lang('passport_id'); ?>">
              <i id="confirm-pass" class="fa fa-eye-slash icon-password"></i>  
              <img src="<?php echo BASE_PATH; ?>asset/img/input-login-user.png" alt="">
            </div>
          </div>
          <button class="btn  w-100 btn-login btn-forget bdr-20" id="submitform" data-toggle="modal" data-target="#tooltip_username" style="font-weight: bold"><?php echo lang('change_password'); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Alert Modal -->
<div class="modal sso-modal" tabindex="-1" role="dialog" id="public_modal" data-backdrop="static">
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
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/login/change_password.js"></script>
    <script>
        $(document).ready(function(){
           var text =  $(".placeholder").text()
            $('.input-sso').attr('placeholder',text)
        })
    </script>