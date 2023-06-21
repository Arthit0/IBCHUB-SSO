<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
?>
<style>
	.icon-img {
		margin: 0 auto;
		max-width: 80px;
	}
	.btn-group {
		width: 50%;
		margin: 0 auto;
	}
	.btn-send-again {
		background-color: #1B4176;
		color: white;
		border-radius: 8px;
		margin-right: 1rem;
	}
	.btn-group>.btn-group:not(:last-child)>.btn, .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {
		border-top-right-radius: 8px; 
		border-bottom-right-radius: 8px; 
	}
	.btn-send-again:hover {
		color: white;
	}
	.btn-login {
		padding: 0;
		margin: 0 auto;
	}
	.btn-login:hover {
		color: white;
	}
	p {
		font-size: 18px;
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
				<a href="tel:1169" class="contact-tel"><?php echo lang('home_contact_nav') ?><i class="fa fa-phone"></i>&nbsp;1169</a>
				<a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/th" class="change-lang">
					<img class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png" alt="">
				</a>
				<a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/en" class="change-lang">
					<img class="<?php echo ($lang == 'en') ? ' active ' : '';?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png" alt="">
				</a>
			</div>
		</nav>
		<div class="container-fluid d-flex flex-column justify-content-center align-items-center h-100">
			<?php if ($res['res_code'] == "00"): ?>
				<div class="d-flex flex-column justify-content-center w-100">
					<img class="icon-img" src="<?php echo BASE_PATH; ?>asset/img/new-check-green.png" alt="">
					<h4 class="text-center  mt-4">ลงทะเบียนสำเร็จ</h4>
					<p class="text-center">ท่านสามารถเข้าใช้งานระบบ DITP SSO ได้กรุณากดปุ่มเข้าสู่ระบบ</p>
					<a href="<?php echo BASE_PATH . _INDEX; ?>index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=https://sso-uat.ditp.go.th/sso/portal/ck_portal&state=1" class="btn btn-login w-50">เข้าสู่ระบบ</a>
				</div>
			<?php else: ?>
				<div class="d-flex flex-column justify-content-center w-100">
					<img class="icon-img" src="<?php echo BASE_PATH; ?>asset/img/new-cross-red.png" alt="">
					<h4 class="text-center  mt-4">เกิดข้อผิดพลาด</h4>
					<p class="text-center"><?php echo $res['res_text'] ?></p>
					<div class="btn-group">
						<button role="button" onclick="send_mail(<?php echo $_SESSION['id'] ?>, '<?php echo $_SESSION['email'] ?>', '<?php echo $_SESSION['target'] ?>')" class="btn btn-send-again ">ส่งอีกครั้ง</button>
						<a href="<?php echo BASE_PATH . _INDEX; ?>index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=https://sso-uat.ditp.go.th/sso/portal/ck_portal&state=1" class="btn btn-login">เข้าสู่ระบบ</a>
					</div>
				</div>
			<?php endif ?>

		</div>
	</div>
</div>
<!-- <script src="<?php echo BASE_PATH; ?>asset/js/page/register/main_register.js?ver=<?php echo $cash_time; ?>"></script> -->

<script>
	$(function(){

	});

	function send_mail(member_id = '', email = '', target = ''){
	    console.log(222222);
	    $.ajax({
	        url: BASE_URL + _INDEX + "register/send_email_verify",
	        data: {member_id : member_id, email : email, target : target},
	        method: "post",
	        beforeSend: function(){
	            $('.modal-spin').modal('show');
	        },
	        success: function (result) {
	            $("#overlay-fullsrc").fadeOut('fast');
	            $('.modal-spin').modal('hide'); //hide loading
	            console.log(result);
	            if(result.status === '00'){
	                $('#public_modal').modal('hide');
	                  Swal.fire({
	                      html: `
	                      			<i style="font-size:5rem;color:#2D6DC4;" class="fa-solid fa-envelope mb-0"></i>
	                						<h4 class="text-center mb-0">ส่งข้อมูลไปที่อีเมล</h4>
	                						<p class="text-center mb-0" style="color:#2D6DC4">${result.email}</p>
	                						<p class="text-center mb-0">รหัสอ้างอิง&nbsp;<span style="color:#2D6DC4">${result.ref_code}</span></p>
	                						<p class="text-center">หากไม่พบอีเมล กรุณาตรวจสอบใน Junk mail / Spam</p>
	                              `,
	                      showCancelButton: false, 
	                      confirmButtonText: 'ยืนยัน',
	                  });
	            }else if(result.status === '01'){
	                //console.log(result.message);
	                Swal.fire({
	                    icon: "error",
	                    title: `เกิดข้อผิดพลาด : ${result.message}`,
	                    //text: result.message,
	                    onClose: closeModal
	                })
	            }else{
	                Swal.fire({
	                    icon: "error",
	                    title: `เกิดข้อผิดพลาด `,
	                    //text: result.message,
	                    onClose: closeModal
	                })
	            }
	        },
	        complete: function() {
	            $('.modal-spin').modal('hide');
	        }
	    });
	    return false;
	}
</script>