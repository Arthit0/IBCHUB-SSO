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
<br>
<div class="container con-box">
    <div class="row  con-box-row">
        <div class=" col-sm-12 col-md-12 col-lg-6 text-center m-auto-0 pb-7-p box-logo">   
             <img class=" sso-logo" src="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" alt="">        
        </div>

        <div class=" col-sm-12 col-md-12 col-lg-5 m-auto-0">
            <div class="row  login-box sso-input">
                <div class="col-12 col-lg-12 text-center login-title" style="font-size: 2.5rem;">รีเซ็ตรหัสผ่านสำเร็จ</div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/login/reset_password.js?ver=<?php echo $cash_time; ?>"></script>