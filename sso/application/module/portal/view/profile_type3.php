	<div class="dashboard-container">
	<div class="container">
		<div class="profile-container">
			<div class="profile-title">
				<h2 class="contact-title"><?= lang('home_profile_title') ?> &nbsp;(บุคคลทั่วไป)</h2>
				<a href="<?php echo BASE_PATH ._INDEX ?>portal/profile_edit" class="btn btn-sm change-profile-btn">
					<img src="<?php echo BASE_PATH; ?>asset/img/pen.png" alt="">&nbsp;<span><?= lang('home_profile_change_info') ?></span>
				</a>
			</div>
			<div class="row">
				<div class="col-sm-12 mb-2">
					<div class="profile-card my-3">
						<div class="profile-card-head">
							<div class="container">
								<div class="profile-card-title"><h4><?= lang('home_profile_info_title')  ?></h4></div>
							</div>
						</div>
						<div class="container">
							<div class="form-row">
								<div class="form-group col-sm-4 p-4">
									<label class="control-label">เลขบัตรประจำตัวประชาชน &nbsp;
										<?php if ($user_data['status_laser_verify']): ?>
											<small>
												<span data-isverify="Y" class="is_laser_verify text-success pointer"><i class="fa-regular fa-circle-check"></i>&nbsp;Verified</span>
											</small>
										<?php else: ?>
											<small>
												<span data-isverify="N" class="is_laser_verify text-danger"><i class="fa-solid fa-circle-exclamation"></i></i>&nbsp;Verify</span>
											</small>
										<?php endif ?>
									</label>
									<small class="form-text text-muted mt-0"><?= $user_data['cid'] ?></small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label">ชื่อ-นามสกุล</label>
									<small class="form-text text-muted mt-0"><?= $user_data['member_title'] ?>&nbsp;<?= $user_data['member_nameTh'] ?>&nbsp;<?= $user_data['member_lastnameTh'] ?></small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label">ชื่อ-นามสกุล (ภาษาอังกฤษ)</label>
									<small class="form-text text-muted mt-0"><?= titleTH_to_titleEN($user_data['member_title']) ?>&nbsp;<?= $user_data['member_nameEn'] ?>&nbsp;<?= $user_data['member_lastnameEn'] ?></small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label">อีเมล &nbsp;
										<?php if ($user_data['status_email_verify']): ?>
											<small>
												<span data-isverify="Y" class="is_email_verify text-success pointer"><i class="fa-regular fa-circle-check"></i>&nbsp;Verified</span>
											</small>
										<?php else: ?>
											<small>
												<span data-isverify="N" data-member_id="<?= $user_data['member_id'] ?>" data-email="<?= $user_data['email'] ?>" data-target="portal" class="is_email_verify text-danger"><i class="fa-solid fa-circle-exclamation"></i></i>&nbsp;Verify</span>
											</small>
										<?php endif ?>
										
									</label>
									<small class="form-text text-muted mt-0"><?= $user_data['email'] ?></small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label">หมายเลขโทรศัพท์ &nbsp;
										<?php if ($user_data['status_sms_verify']): ?>
											<small>
												<span data-isverify="Y" class="is_phone_verify text-success pointer"><i class="fa-regular fa-circle-check"></i>&nbsp;Verified</span>
											</small>
										<?php else: ?>
											<small>
												<span data-isverify="N" data-member_id="<?= $user_data['member_id'] ?>" data-tel="<?= $user_data['tel'] ?>" data-target="portal" class="is_phone_verify text-danger"><i class="fa-solid fa-circle-exclamation"></i></i>&nbsp;Verify</span>
											</small>
										<?php endif ?>
									</label>
									<small class="form-text text-muted mt-0"><?= $user_data['tel'] ?></small>
								</div>
							</div>
						</div>
					</div>
					<div class="profile-card my-3">
						<div class="profile-card-head">
							<div class="container">
								<div class="profile-card-title"><h4><?= lang('home_profile_address_title') ?></h4></div>
							</div>
						</div>
						<div class="container">
							<div class="form-row">
								<div class="form-group col-sm-12 p-4">
									<label class="control-label">ที่อยู่</label>
									<small class="form-text text-muted mt-0"><?= $user_data['addressTh'] ?>&nbsp;<?= $user_data['provinceTh'] ?>&nbsp;<?= $user_data['districtTh'] ?>&nbsp;<?= $user_data['subdistrictTh'] ?>&nbsp;<?= $user_data['postcode'] ?></small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function searchQueryParams(params) {
	  params.search = $('#search').val();
	  console.log(params);
	  return params; // body data
	}

	function send_mail(member_id = '', email = '', target = ''){
	    console.log(222222);

	    $.ajax({
	        url: BASE_URL + _INDEX + "portal/send_email_verify",
	        data: {member_id : member_id, email : email, target : target},
	        method: "post",
	        beforeSend: function(){
	            $('.modal-spin').modal('show');
	        }, 
	        success: function (result) {
	            $("#overlay-fullsrc").css("display", "none").fadeOut('fast');
	            $('.modal-spin').modal('hide'); //hide loading
	            console.log(result);
	            if(result.status === '00'){
	                $('#public_modal').modal('hide');
	                Swal.fire({
	                    html: `<div>
	                                <i class="fa-solid fa-envelope" style="font-size:5.5rem;color:var(--main-color-1);"></i>
	                                <p class="mitr-r _f18 mb-0" >ส่งข้อมูลไปที่อีเมล</p>
	                                <p class="mitr-r _f16 mb-0" style="color:var(--main-color-1);">${result.email}</p>
	                                <p class="mitr-l _f14 mb-0" >รหัสอ้างอิง <span style="color:var(--main-color-1);">${result.ref_code}</span></p>
	                                <small class="mitr-l _f14">หากไม่พบอีเมล กรุณาตรวจสอบใน Junk mail / Spam</small>
	                            </div>
	                            <div>
	                               <button type="button" onclick="send_mail(${member_id},'${email}','${target}')" class="btn btn-resend-email">ส่งอีกครั้ง</button>
	                               <a href="`+ BASE_PATH + _INDEX +`portal/profile" class="btn btn-regis-login" title="">ยืนยัน</a>
	                            </div>
	                            `,
	                    showCloseButton: true,
	                    showConfirmButton: false,
	                    showCancelButton: false,

	                });
	            }else if(result.status === '01'){
	                //console.log(result.message);
	                Swal.fire({
	                    icon: "error",
	                    title: `เกิดข้อผิดพลาด : ${result.message}`,
	                    //text: result.message,
	                })
	            }else{
	                Swal.fire({
	                    icon: "error",
	                    title: `เกิดข้อผิดพลาด `,
	                    //text: result.message,
	                })
	            }
	        },
	        complete: function() {
	            $('.modal-spin').modal('hide');
	        }
	    });
	    return false;
	}

	function send_sms(member_id = '', tel = '', target = ''){
	    console.log(222222);
	    $.ajax({
	        url: BASE_URL + _INDEX + "register/send_sms_verify",
	        data: {member_id : member_id, tel : tel, target : target},
	        method: "post",
	        beforeSend: function(){
	            $('.modal-spin').modal('show');
	        },
	        success: function (result) {
	            $("#overlay-fullsrc").css("display", "none").fadeOut('fast');
	            $('.modal-spin').modal('hide'); //hide loading
	        
	            if(result.status === '00'){
	                $('#public_modal').modal('hide');
	                Swal.fire({
	                    html: `
	                            <div>
	                                <i class="fa-solid fa-message" style="font-size:5.5rem;color:var(--main-color-1);"></i>
	                                <p class="mitr-r _f18 mb-0 mt-4" >ระบบได้ทำการส่งข้อมูล OTP ไปที่หมายเลข</p>
	                                <p class="mitr-r _f18 mb-4" style="color:var(--main-color-1);line-height: 28px;">${result.tel}</p>
	                            </div>

	                            <small class="mitr-l _f14 float-left ref-code">Ref Code:&nbsp;${result.ref_code}</small><br>
	                            <form action="" id="verify_sms" method="post" data-group-name="digits" data-autosubmit="false" autocomplete="off">
	                                <input type="hidden" name="tel" value="${result.real_tel}">
	                                <input type="hidden" name="token_verify" value="${result.token_verify}">
	                                <input type="hidden" name="target" value="${target}">
	                                <input type="hidden" name="member_id" value="${member_id}">
	                                <div class="verification-code">
	                                  <div class="verification-code--inputs">
	                                    <input type="text" name="otp_digit_1" maxlength="1" />
	                                    <input type="text" name="otp_digit_2" maxlength="1" />
	                                    <input type="text" name="otp_digit_3" maxlength="1" />
	                                    <input type="text" name="otp_digit_4" maxlength="1" />
	                                    <input type="text" name="otp_digit_5" maxlength="1" />
	                                    <input type="text" name="otp_digit_6" maxlength="1" />
	                                  </div>
	                                  <input type="hidden" id="verificationCode" />
	                                </div>
	                            </form>
	                            <div class="container d-flex countdown-container">
	                                <countdown-time autostart add="5m" format='{m}:{s}'>
	                                    <p show-on-expired>OTP หมดอายุการใช้งาน</p>
	                                    <p hide-on-expired>OTP มีอายุใช้งานในอีก &nbsp;</p>
	                                </countdown-time>
	                            </div>
	                            <div>
	                               <button type="button" onclick="send_sms(${member_id},'${result.real_tel}','${target}')" class="btn btn-resend-email">ส่งอีกครั้ง</button>
	                               <button type="button" onclick="verify_sms()" id="btn_verify_sms" class="btn btn-regis-login" title="">ยืนยัน</button>
	                            </div>
	                            `,
	                            showCloseButton: true,
	                            showConfirmButton: false,
	                            showCancelButton: false,
	                            onClose: RedirectToLogin,

	                });

	                //Code Verification
	                var verificationCode = [];

	                //handle touch events
	                $('.verification-code input').on("touchstart", function(e) {
	                    e.preventDefault();
	                    $(this).focus();
	                });

	                $('.verification-code input').on("touchend", function(e) {
	                    e.preventDefault();
	                    $(this).val("");
	                });

	                $('.verification-code input').on("touchmove", function(e) {
	                    e.preventDefault();
	                });

	                //handle input event
	                $(".verification-code input[type=text]").on("input", function (e) {
	                    var inputValue = $(this).val();
	                    if(inputValue.length === 1 && inputValue.match(/^[0-9]*$/)) {
	                        $(this).next().focus();
	                    } else if(inputValue.length === 0) {
	                        $(this).prev().focus();
	                    }
	                    // Get Input for Hidden Field
	                    $(".verification-code input[type=text]").each(function (i) {
	                        verificationCode[i] = $(".verification-code input[type=text]")[i].value;
	                        $('#verificationCode').val(Number(verificationCode.join('')));
	                    });
	                });
	            }else if(result.status === '01'){
	                console.log(result);
	                Swal.fire({
	                    html: `
	                            <div>
	                               <button type="button" onclick="send_sms(${member_id},'${result.real_tel}','${target}')" class="btn btn-resend-email">ส่งอีกครั้ง</button>
	                            </div>
	                            `,
	                            showCloseButton: true,
	                            showConfirmButton: false,
	                            showCancelButton: false,
	                            onClose: RedirectToLogin,

	                });
	            }else{
	                Swal.fire({
	                    icon: "error",
	                    title: `เกิดข้อผิดพลาด `,
	                    //text: result.message,
	                    onClose: RedirectToLogin
	                })
	            }
	        },
	        complete: function() {
	            $('.modal-spin').modal('hide');
	        }
	    });

	    return false;
	}

	function verify_sms() {

	    var data = $('#verify_sms')[0];
	    var form = new FormData(data);
	    console.log("clicked");
	    console.log(form);
	    $.ajax({
	        url: BASE_URL + _INDEX + "register/verify_sms",
	        processData: false,
	        contentType: false,
	        async: false,
	        dataType: "json",
	        data: form,
	        method: "post",
	        beforeSend: function(){
	            $('.modal-spin').modal('show');
	        },
	        success: function (result) {
	            $("#overlay-fullsrc").css("display", "none").fadeOut('fast');
	            $('.modal-spin').modal('hide'); //hide loading
	            console.log("verify_sms result :" + result);
	            if(result.status === '00'){
	                $('#public_modal').modal('hide');
	                Swal.fire({
	                    icon: 'success',
	                    title: 'ยืนยันหมายเลขโทรศัพท์สำเร็จ',
	                    confirmButtonText: 'ตกลง',
	                }).then((re) =>{
	                	if (re.isConfirmed) {
	                		location.reload();
	                	}

	                });
	            }else if(result.status === '01'){
                //console.log(result.message);
                Swal.fire({
                    icon: "error",
                    title: `${result.message}`,
                    //text: result.message,
                    html: `
                            <div>
                               <button type="button" onclick="send_sms(${result.member_id},'${result.tel}','${result.target}')" class="btn btn-resend-email">ส่งอีกครั้ง</button>
                            </div>
                            `,
                            showCloseButton: true,
                            showConfirmButton: false,
                            showCancelButton: false,
                            onClose: RedirectToLogin,
                });
            }else{
	                Swal.fire({
	                    icon: "error",
	                    title: `เกิดข้อผิดพลาด `,
	                    //text: result.message,
	                })
	            }
	        },
	        complete: function() {
	            $('.modal-spin').modal('hide');
	        }
	    });
	}

	$(document).on('click', '.is_email_verify', function () {
		let isverify = $(this).data('isverify');
		let member_id = $(this).data('member_id');
		let email = $(this).data('email');
		let target = $(this).data('target');
		console.log(isverify);
		if (isverify == "N") {
			send_mail(member_id , ''+email+'', ''+ target +'' );
		} else {
			Swal.fire({
			    icon: 'success',
			    title: 'ยืนยันอีเมลล์แล้ว',
			    confirmButtonText: 'ตกลง',
			});
		}
	})
	$(document).on('click', '.is_phone_verify', function () {
		let isverify = $(this).data('isverify');
		let member_id = $(this).data('member_id');
		let tel = $(this).data('tel');
		let target = $(this).data('target');
		console.log(isverify);
		if (isverify == "N") {
			send_sms(member_id , ''+tel+'', ''+ target +'' );
		} else {
			Swal.fire({
			    icon: 'success',
			    title: 'ยืนยันเบอร์โทรศัพท์แล้ว',
			    confirmButtonText: 'ตกลง',
			});
		}

	})
	function RedirectToLogin() {
	    window.location.href = BASE_PATH + 'portal/profile';
	}
	$(document).on('click', '#btn_search', function () {
	  $('.table-caseCh-list').bootstrapTable('refresh');
	  return false;
	})
</script>