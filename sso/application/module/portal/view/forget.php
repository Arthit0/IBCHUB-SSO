<div class="container-fluid dashboard-container">
	<div class="forget-container">
		<h2 class="forget-title mitr-r _f20"><?= lang('change_password') ?></h2>
		<form action="" method="post" id="form_changepassword" enctype="multipart/form-data">
		  <div class="row  forget-box">
		  	<div class="forget-card row">
		  		<div class="col-12 col-lg-12 ">
		  		  <div class="text-dark mitr-r _f16"><?= lang('old_password') ?><span class="text-danger"> *</span></div>
		  		</div>
		  		<div class="col-12 col-lg-12 pb-15">

		  		  <div class="inputWithIcon box-username">
		  		    <input class="pl-2 pb-3" type="password" name="old_password" id="old_password" aria-label="Password" placeholder="<?php echo lang('old_password'); ?>">
		  		    <i id="old-pass" class="fa fa-eye-slash icon-password"></i>  
		  		  </div>
		  		</div>
		  		<div class="col-12 col-lg-12 ">
		  		  <div class="text-dark mitr-r _f16"> <?php echo lang('new_password'); ?><span class="text-danger"> *</span></div>
		  		</div>
		  		<div class="col-12 col-lg-12 pb-15">
		  		  <div class="inputWithIcon box-password">
		  		    <input class="pl-2 pb-3" type="password" name="new_password" id="new_password" aria-label="Password" placeholder="<?php echo lang('new_password'); ?>">
		  		    <i id="new-pass" class="fa fa-eye-slash icon-password"></i>
		  		    <br>
		  		    <small id="water-mark" class="form-text text-muted mitr-l _f14" >
		  		    	<?php echo lang('regis_pass_recom') ?>
		  		    </small>
		  		  </div>
		  		</div>
		  		<div class="col-12 col-lg-12 ">
		  		  <div class="text-dark mitr-r _f16"><?= lang('confirm_password') ?><span class="text-danger"> *</span></div>
		  		</div>
		  		<div class="col-12 col-lg-12 pb-15">

		  		  <div class="inputWithIcon box-username">
		  		    <input class="pl-2 pb-3" type="password" name="new_password2" id="confirm_password" aria-label="Password" placeholder="<?php echo lang('confirm_password'); ?>">    
		  		    <i id="confirm-pass" class="fa fa-eye-slash icon-password"></i>  
		  		  </div>
		  		</div>

		  	</div>
		  	<div class="col-12 col-lg-12 pb-15 d-flex justify-content-center align-items-center mt-4">
		  		<a href="<?php echo BASE_PATH . _INDEX ?>portal/" class="btn btn-cancel mr-4"><?= lang('home_profile_cancel') ?></a>
		  		<button type="button" id="submitform" class="btn btn-profile-submit"><?= lang('home_profile_submit') ?></button>
		  	</div>
		  </div>
		</form>
	</div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/portal/change_password.js"></script>
 <script>
 	// $(document).on('click', '#forget-submit-btn', function () {
 	//   Swal.fire({
 	//       icon: 'success',
 	//       title: 'เปลี่ยนรหัสผ่านสำเร็จ!',
 	//       confirmButtonText: 'เข้าสุ่ระบบ',
 	//   });
 	// })
 </script>