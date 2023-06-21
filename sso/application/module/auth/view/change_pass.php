<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
}
?>
<style>
    .sso-modal .modal-body p {
        margin-bottom: 7px;
    }
</style>
<nav class="navbar navbar-light ">
    <div class="navbar-brand pointer">

        <a href="<?php echo BASE_PATH . _INDEX ?>auth" class="d-block d-md-none">
            <img src="<?php echo BASE_PATH; ?>asset/img/chevron-left-material@3x.png" alt="" style="height: 30px;">
        </a>
    </div>
</nav>
<div class="container con-box">
    <div class="row  con-box-row">
        <div class=" col-sm-12 col-md-12 col-lg-6 text-center m-auto-0 pb-7-p box-logo">
            <a href="<?php echo BASE_PATH . _INDEX ?>auth">
                <img class=" sso-logo" src="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" alt="">
            </a>
        </div>



        <div class=" col-sm-12 col-md-12 col-lg-5 m-auto-0">
            <form action="#" method="post" id="formlogin" enctype="multipart/form-data">
                <div class="row  login-box sso-input">

                    <div class="col-12 col-lg-12 text-center login-title">ลืมรหัสผ่าน</div>
                    <div class=" col-12 sso-row-input  sm-mt-5">
                        <div class="row">
                            <div class="col-12">
                                เลขนิติบุคคลเลข / บัตรประจำตัวประชาชน&nbsp;<span class="text-danger">*</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class=" input-sso" name="province" placeholder="เลขนิติบุคคลเลข / บัตรประจำตัวประชาชน">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12 mb-2 mt-5">
                        <!-- <button type="submit" class="btn  w-100 btn-login bdr-20 ">ยืนยัน</button> -->
                        <button type="button" class="btn  w-100 btn-login bdr-20 " data-toggle="modal" data-target="#tooltip_username">ยืนยัน</button>
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
            <div class="modal-body text-center" style="  font-size: 24px;
  font-weight: bold;
  font-stretch: normal;
  font-style: normal;
  line-height: normal;
  letter-spacing: normal;
  text-align: center;
  color: #4d4d4d;">
                <p>ระบบจะทำการส่งข้อมูลไปที่อีเมล</p>
                <p>$YOUREMAIL</p>
                <p>กรุณาตรวจสอบอีเมลของท่าน</p>

                <div class="col-12 col-lg-12 mt-5">

                    <div class="btn btn-primary  w-50 bdr-20 btn-register" data-dismiss="modal" aria-label="Close">ปิด</div>


                </div>
            </div>

        </div>
    </div>
    <script src="<?php echo BASE_PATH; ?>asset/js/page/login/forget.js"></script>