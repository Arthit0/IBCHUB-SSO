<div class="dashboard-container">
	<div class="container">
		<div class="profile-container">
			<div class="profile-title"><h2><b><?= lang('home_profile_title') ?></b></h2><a href="<?php echo BASE_PATH ._INDEX ?>home/profile_edit" class="btn btn-sm change-profile-btn"><img src="<?php echo BASE_PATH; ?>asset/img/pen.png" alt="">&nbsp;<span><b><?= lang('home_profile_change_info') ?></b></span></a></div>
			<div class="row">
				<div class="col-sm-12 mb-2">
					<div class="profile-card my-3">
						<div class="profile-card-head">
							<div class="container">
								<div class="profile-card-title"><h4><b><?= lang('home_profile_com_info_title') ?></b></h4></div>
							</div>
						</div>
						<div class="container">
							<div class="form-row">
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>เลขนิติบุคคล</b></label>
									<small class="form-text text-muted mt-0">1425634862142</small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>ชื่อนิติบุคคล</b></label>
									<small class="form-text text-muted mt-0">บริษัท ทรัพท์สิน จำกัด</small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>ชื่อนิติบุคคล (ภาษาอังกฤษ)</b></label>
									<small class="form-text text-muted mt-0">Sabsin Company Limited</small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>ที่อยู่</b></label>
									<small class="form-text text-muted mt-0">111/20 ต.ปากเกร็ด อ.ปากเกร็ด จ.นนทุบรี 11120</small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>ที่อยู่ (ภาษาอังกฤษ)</b></label>
									<small class="form-text text-muted mt-0">111/20 Pakkred , Pakkred Nonthaburi 11120</small>
								</div>
							</div>
						</div>
					</div>
					<div class="profile-card my-3">
						<div class="profile-card-head">
							<div class="container">
								<div class="profile-card-title"><h4><b><?= lang('home_profile_info_title') ?></b></h4></div>
							</div>
						</div>
						<div class="container">
							<div class="form-row">
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>เลขบัตรประจำตัวประชาชน</b></label>
									<small class="form-text text-muted mt-0">3 1005 00234 10 8</small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>ชื่อ-นามสกุล</b></label>
									<small class="form-text text-muted mt-0">นายสมชาย แสงมั่งมี</small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>ชื่อ-นามสกุล (ภาษาอังกฤษ)</b></label>
									<small class="form-text text-muted mt-0">Somchai Sangmangme</small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>อีเมล &nbsp;</b><small><span class="is_email_verify text-success pointer"><i class="fa-regular fa-circle-check"></i>&nbsp;Verified</span></small></label>
									<small class="form-text text-muted mt-0">myemail@gmail.com</small>
								</div>
								<div class="form-group col-sm-4 p-4">
									<label class="control-label"><b>หมายเลขโทรศัพท์ &nbsp;</b><small><span class="is_phone_verify text-warning"><i class="fa-solid fa-circle-exclamation"></i></i>&nbsp;Verify</span></small></label>
									<small class="form-text text-muted mt-0">061 234 5678</small>
								</div>
							</div>
						</div>
					</div>
					<div class="profile-card my-3">
						<div class="profile-card-head">
							<div class="container">
								<div class="profile-card-title"><h4><b><?= lang('home_profile_address_title') ?></b></h4></div>
							</div>
						</div>
						<div class="container">
							<div class="form-row">
								<div class="form-group col-sm-12 p-4">
									<label class="control-label"><b>ที่อยู่</b></label>
									<small class="form-text text-muted mt-0">111/20 ต.ปากเกร็ด อ.ปากเกร็ด จ.นนทุบรี 11120</small>
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
	$(document).on('click', '.is_email_verify', function () {

		Swal.fire({
		    title: 'ยืนยันอีเมล Code',
		    html: `<div class="prompt">
						ระบุอีเมล Code ที่ได้รับnางอีเมล
					</div>

					<form method="get" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
						<input type="text" id="digit-1" name="digit-1" data-next="digit-2" />
						<input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
						<input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
						<input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
						<input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
						<input type="text" id="digit-6" name="digit-6" data-next="digit-7" data-previous="digit-5" />
					</form>
					<div class="container d-flex countdown-container">
						<countdown-time autostart add="5m">
							<p show-on-expired>Countdown is expired.</p>
							<p hide-on-expired>Countdown is running.</p>

						</countdown-time>
						<span><a href="#" class="pl-4">ส่งอีกครั้ง</a></span>
					</div>
					`,
			showCancelButton: true, 
		    confirmButtonText: 'ยืนยัน',
		    CancelButtonText: 'ยกเลิก',
		    reverseButtons: true,
		}).then((result) => {
			  if (result.isConfirmed) {
			  	Swal.fire({
			  	    icon: 'success',
			  	    title: 'ยืนยันอีเมลล์สำเร็จ!',
			  	    confirmButtonText: 'ตกลง',
			  	});
			  }
		})

		$('.digit-group').find('input').each(function() {
			$(this).attr('maxlength', 1);
			$(this).on('keyup', function(e) {
				var parent = $($(this).parent());
				
				if(e.keyCode === 8 || e.keyCode === 37) {
					var prev = parent.find('input#' + $(this).data('previous'));
					
					if(prev.length) {
						$(prev).select();
					}
				} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
					var next = parent.find('input#' + $(this).data('next'));
					
					if(next.length) {
						$(next).select();
					} else {
						if(parent.data('autosubmit')) {
							parent.submit();
						}
					}
				}
			});
		});
	})
	$(document).on('click', '.is_phone_verify', function () {

		Swal.fire({
		    title: 'ยืนยันรหัส OTP',
		    html: `<div class="prompt">
						ระบุรหัส OTP ที่ได้รับnาง SMS
					</div>

					<form method="get" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
						<label class="control-label"> ABCD
						<input type="text" id="digit-1" name="digit-1" data-next="digit-2" />
						<input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
						<input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
						<input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
						<input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
						<input type="text" id="digit-6" name="digit-6" data-next="digit-7" data-previous="digit-5" />
						</label> 
					</form>
					<div class="container d-flex countdown-container">
						<countdown-time autostart add="5m">
							<p show-on-expired>Countdown is expired.</p>
							<p hide-on-expired>Countdown is running.</p>

						</countdown-time>
						<span><a href="#" class="pl-4">ส่งอีกครั้ง</a></span>
					</div>
					`,
			showCancelButton: true, 
		    confirmButtonText: 'ยืนยัน',
		    CancelButtonText: 'ยกเลิก',
		    reverseButtons: true,
		}).then((result) => {
			  if (result.isConfirmed) {
			  	Swal.fire({
			  	    icon: 'success',
			  	    title: 'ยืนยันหมายเลขโทรศัพท์สำเร็จ!!',
			  	    confirmButtonText: 'ตกลง',
			  	});
			  }
		})

		$('.digit-group').find('input').each(function() {
			$(this).attr('maxlength', 1);
			$(this).on('keyup', function(e) {
				var parent = $($(this).parent());
				
				if(e.keyCode === 8 || e.keyCode === 37) {
					var prev = parent.find('input#' + $(this).data('previous'));
					
					if(prev.length) {
						$(prev).select();
					}
				} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
					var next = parent.find('input#' + $(this).data('next'));
					
					if(next.length) {
						$(next).select();
					} else {
						if(parent.data('autosubmit')) {
							parent.submit();
						}
					}
				}
			});
		});
	})

	$(document).on('click', '#btn_search', function () {
	  $('.table-caseCh-list').bootstrapTable('refresh');
	  return false;
	})
</script>