<div class="container-fluid dashboard-container">
	<div class="forget-container">
		<h2 class="forget-title"><?= lang('change_password') ?></h2>
		<form action="#" method="post" id="formlogin" enctype="multipart/form-data">
		  <div class="row  forget-box">
		  	<div class="forget-card row">
		  		<div class="col-12 col-lg-12 ">
		  		  <div class="text-dark"><b><?= lang('old_password') ?></b>&nbsp;</div>
		  		</div>
		  		<div class="col-12 col-lg-12 pb-15">

		  		  <div class="inputWithIcon box-username">
		  		    <input type="password" name="old_password" id="old_password" aria-label="Password" placeholder="<?php echo lang('old_password'); ?>">
		  		    <i id="old-pass" class="fa fa-eye-slash icon-password"></i>  
		  		  </div>
		  		</div>
		  		<div class="col-12 col-lg-12 ">
		  		  <div class="text-dark"><b> <?php echo lang('new_password'); ?>&nbsp;<span class="text-danger">*</span></b></div>
		  		</div>
		  		<div class="col-12 col-lg-12 pb-15">
		  		  <div class="inputWithIcon box-password">
		  		    <input type="password" name="new_password" id="new_password" aria-label="Password" placeholder="<?php echo lang('new_password'); ?>">
		  		    <i id="new-pass" class="fa fa-eye-slash icon-password"></i>
		  		    <br>
		  		    <small id="water-mark" class="form-text text-muted" style="font-size: 1.13rem;margin-top: 2%;">
		  		    	รหัสผ่านจะต้องมีความยาวอย่างน้อย 8 ตัวอักษร และควรประกอบไปด้วยอักษร
		  		    	ภาษาอังกฤษตัวใหญ่ (A-Z), อักษรภาษาอังกฤษตัวเล็ก (a-z), ตัวเลข (1-9)
		  		    	และสัญลักษณ์ (เช่น #, $, & เป็นต้น)
		  		    </small>
		  		  </div>
		  		</div>
		  		<div class="col-12 col-lg-12 ">
		  		  <div class="text-dark"><b><?= lang('confirm_password') ?></b>&nbsp;</div>
		  		</div>
		  		<div class="col-12 col-lg-12 pb-15">

		  		  <div class="inputWithIcon box-username">
		  		    <input type="password" name="new_password2" id="confirm_password" aria-label="Password" placeholder="<?php echo lang('confirm_password'); ?>">    
		  		    <i id="confirm-pass" class="fa fa-eye-slash icon-password"></i>  
		  		  </div>
		  		</div>
		  		<div class="col-12 col-lg-12 pb-15 d-flex justify-content-center align-items-center">
		  			<a href="<?php echo BASE_PATH . _INDEX ?>home/profile" class="btn btn-cancel mr-4"><?= lang('home_profile_cancel') ?></a>
		  			<button type="button" id="forget-submit-btn" class="btn btn-profile-submit"><?= lang('home_profile_submit') ?></button>
		  		</div>
		  	</div>
		  </div>
		</form>
	</div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/login/change_password.js"></script>
 <script>
 	$(document).on('click', '#forget-submit-btn', function () {
 	  Swal.fire({
 	      icon: 'success',
 	      title: 'เปลี่ยนรหัสผ่านสำเร็จ!',
 	      confirmButtonText: 'เข้าสู่ระบบ',
 	  });
 	})
 </script>