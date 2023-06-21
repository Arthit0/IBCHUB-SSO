<!--<a href="<?php //echo $re_url; ?>">Back</a>-->

<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
}
?>
<style>

.icon-password {
        position: absolute;
    right: 20px;
    left: unset !important;
    padding: 5px 9px !important;
    font-size: 1.5rem;
    cursor: pointer;
    top: 5px;
}
  .error-mess {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
  }

  .box-policy {
    max-width: 720px;
    margin: 0 auto;
    padding: 0 20px;
    font-size: 22px;

  }

  .box-policy nav {
    padding-left: 0;

  }

  .sso-ckb {
    position: relative;

    padding-left: 20px;
  }

  .sso-ckb input {
    display: none;
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  .sso-ckb .box-ckb {
    position: absolute;
    width: 15px;
    height: 15px;
    border: 2px solid #96b3cb;
    border-radius: 4px;
    position: absolute;
    top: 50%;
    left: 0%;
    transform: translate(0%, -50%);
    -ms-transform: translate(-0%, -50%);
    background-color: #fdfdfd;
  }

  .sso-ckb:hover input~.box-ckb {
    background-color: #ccc;
  }

  .sso-ckb input:checked~.box-ckb:after {
    display: block;
  }

  .sso-ckb input:checked~.box-ckb {
    background-color: #2196F3;
  }

  .box-ckb:after {
    content: "";
    position: absolute;
    display: none;
  }

  .box-ckb:after {
    left: 4px;
    top: 0px;
    width: 4px;
    height: 9px;
    border: solid white;
    border-width: 0 2px 2px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  #overlay-fullsrc {
    background-image: url('<?php echo  BASE_PATH; ?>/asset/img/group.png');
    padding: 0px !important;
    z-index: 1049;
    position: fixed;
    top: 0;
    width: 100vw;
    height: 100vh;
    overflow-x: hidden;
    overflow-y: auto;
    display: none;
    color: #427c97 !important;
  }

  .overflow-body {
    height: 100vh;
    overflow-y: hidden;

  }

  /* #overlay-fullsrc .modal-dialog {
    max-width: 100%;
    margin: 0 !important;
  }

  #overlay-fullsrc .modal-content {
    border: none;
    background-color: unset !important;
  } */
  .loader_input {
    position: relative;
  }

  .show_load.loader_input::after {
    content: "";
    border: 2px solid #f3f3f3;
    border-radius: 50%;
    border-top: 2px solid #3498db;
    width: 15px;
    height: 15px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    position: absolute;
    right: 7%;
    top: 30%;

  }

  .closs-overlay {
    font-size: 25px;
    font-weight: 600;
    color: #427c97 !important;
  }

  /* Safari */
  @-webkit-keyframes spin {
    0% {
      -webkit-transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
    }
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }
</style>
<nav class="navbar navbar-light ">
    
</nav>
<div class="container con-box">
    <div class="row  con-box-row">
        <div class=" col-sm-12 col-md-12 col-lg-6 text-center m-auto-0 pb-7-p box-logo">
            <a href="<?php echo BASE_PATH . _INDEX ?>auth">
                <img class=" sso-logo" src="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" alt="">
            </a>
        </div>


        <div class=" col-sm-12 col-md-12 col-lg-5 m-auto-0">
            <form action="#" method="post" id="form_changepassword" enctype="multipart/form-data">
                <div class="row  login-box sso-input">

                    <div class="col-12 col-lg-12 text-center login-title"><?php echo lang('change_password'); ?></div>
                    <div class=" col-12 sso-row-input  sm-mt-5">
                        <div class="row">
                            <div class="col-12">
                              <?php echo lang('old_password'); ?>&nbsp;<span class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:15px">
                            <div class="col-12">
                                <input type="password" class=" input-sso" name="old_password" id="old_password" placeholder="<?php echo lang('old_password'); ?>">
                                <i id="old-pass" class="fa fa-eye-slash icon-password"></i>   
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                              <?php echo lang('new_password'); ?>&nbsp;<span class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:15px">
                            <div class="col-12">
                                <input type="password" class=" input-sso" name="new_password" id="new_password" placeholder="<?php echo lang('new_password'); ?>">
                                <i id="new-pass" class="fa fa-eye-slash icon-password"></i>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                              <?php echo lang('confirm_password'); ?>&nbsp;<span class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:15px">
                            <div class="col-12">
                                <input type="password" class=" input-sso" name="new_password2" id="confirm_password" placeholder="<?php echo lang('confirm_password'); ?>">
                                <i id="confirm-pass" class="fa fa-eye-slash icon-password"></i>   
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-lg-12 mb-2 mt-5">
                        <!-- <button type="submit" class="btn  w-100 btn-login bdr-20 ">ยืนยัน</button> -->
                        <button class="btn  w-100 btn-login bdr-20" id="submitform" data-toggle="modal" data-target="#tooltip_username" style="font-weight: bold"><?php echo lang('change_password'); ?></button>
                    </div>
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