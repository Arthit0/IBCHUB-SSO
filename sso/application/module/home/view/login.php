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
				<a href="tel:1169" class="contact-tel"><?php echo lang('home_contact_nav') ?><i class="fa fa-phone"></i>&nbsp;1169</a>
				<a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/th" class="change-lang">
					<img class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png" alt="">
				</a>
				<a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/en" class="change-lang">
					<img class="<?php echo ($lang == 'en') ? ' active ' : '';?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png" alt="">
				</a>
			</div>
		</nav>
		<div class="container-fluid">
			<form action="#" method="post" id="formlogin" enctype="multipart/form-data">
			  <div class="row  login-box">
			  
			    <div class="col-12 col-lg-12 text-center text-dark"><?php  echo strtoupper(lang('signin')); ?></div>
			    <div class="col-12 col-lg-12 ">
			      <div class="text-dark"><b>Username</b>&nbsp;</div>
			    </div>
			    <div class="col-12 col-lg-12 pb-15">

			      <div class="inputWithIcon box-username">
			        <input type="text" name="username" class="" placeholder="Username" aria-label="Username" id="lg_username" style="font-weight : bold;">
			        <img src="<?php echo BASE_PATH; ?>asset/img/input-login-user.png" alt="">
			        <br>
			        
			        <small id="water-mark" class="form-text text-muted" style="font-size: 1.13rem;margin-top: 2%;">เลขนิติบุคคล/Corporate ID, เลขบัตรประจำตัวประชาชน Passport ID / เจ้าหน้าที่ Email *@ditp.go.th</small>
			      </div>
			    </div>
			    <div class="col-12 col-lg-12 ">
			      <div class="text-dark"><b>Password</b></div>
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
			        <input type="password" name="password" class="" placeholder="Password" aria-label="Password" id="lg_password" style="font-weight : bold;">
			        <img src="<?php echo BASE_PATH; ?>asset/img/input-lock.png" alt="">
			        <i id="show-pass" class="fa fa-eye-slash icon-password" style="padding: 10px 9px!important;"></i>
			      </div>
			    </div>
			    <div class="col-12 col-lg-12 text-right pb-30">
			      <a href="<?php echo BASE_PATH . _INDEX ?>auth/forget" class="text-dark "><?php echo lang('change_forget_pass'); ?></a>
			    </div>

			    <div class="col-12 col-lg-12 mb-2">
			      <button type="submit" class="btn  w-100 btn-login text-white"><?php echo lang('signin'); ?></button>
			    </div>
			    <div class="col-12 col-lg-12 mb-2 d-flex justify-content-center text-center text-dark">
			    	<span><?php echo lang('home_or') ?></span>
			    </div>
			    <!-- <div class="col-12 col-lg-12 mb-2" style="display :none;"> -->
			    <div class="col-12 col-lg-12 mb-2">
			      <!-- <button onclick="window.location.href='auth/moccallback'" type="button" class="btn  w-100 btn-login-moc bdr-20 " id="login_moc"><b><?php echo lang('signin_moc'); ?></b></button> -->
			      <button type="button" class="btn  w-100 btn-login-moc text-white" id="login_moc"><?php echo lang('signin_moc'); ?></button>
			    </div>
			    <div class="col-12 col-lg-12 mb2">
			    	<small class="d-flex justify-content-center text-dark text-center mt-4"><?php echo lang('register') ?>&nbsp;<a href="<?php echo BASE_PATH . _INDEX ?>home/register"><?php echo lang('click_here') ?></a></small>
			    </div>
			  </div>
			</form>
		</div>
	</div>
</div>

<script src="<?php echo BASE_PATH; ?>asset/js/page/login/login.js?ver=<?php echo $cash_time; ?>"></script>