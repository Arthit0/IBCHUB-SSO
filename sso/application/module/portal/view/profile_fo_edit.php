<div class="dashboard-container">
	<div class="container">
		<div class="profile-container">
			<div class="profile-title"><h2 class="contact-title"><?= lang('home_profile_change_info_title') ?></h2></div>
			<div class="row">
				<div class="col-sm-12 mb-2">
					<form action="" method="post" id="type24_form">
						<input type="hidden" name="member_id" value="<?= $user_data['member_id'] ?>">
						<?php if ($user_data['type'] == 2): ?>
							<div class="profile-card my-3">
								<div class="profile-card-head">
									<div class="container">
										<div class="profile-card-title"><h4><?= lang('home_profile_com_info_title') ?></h4></div>
									</div>
								</div>
								<div class="container">
									<div class="form-row sso-input p-4">
										<div class="form-group col-sm-6">
											<label class="control-label"><?php echo lang('passport_id'); ?>&nbsp;</label>
											<input class="input-sso" type="text" value="<?= $user_data['cid'] ?>" name="contact_cid" id="user1_id" autocomplete="off" maxlength="13"
											placeholder="<?php echo lang('passport_id'); ?>" readonly>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label">Corporate Name&nbsp;<span class="text-danger">*</span></label>
											<input type="text" class=" input-sso" value="<?= $user_data['corporate_name'] ?>" name="corporate_name" placeholder="<?php echo lang('regis_contact_fnameen'); ?>">
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label">Country&nbsp;<span class="text-danger">*</label>
											<select class="form-control selectpicker  sso-dropdown" title="Country" data-country="<?php echo $user_data['country'] ?>" id="country" tabindex="-98" name="fo_country_name">
											  <option class="country_name">Country</option>
											</select>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label">Address &nbsp;<span class="text-danger">*</span></label>
											<input type="text" class=" input-sso" value="<?= $user_data['address'] ?>" name="address" placeholder="<?php echo lang('regis_contact_mail'); ?>">
										</div>
									</div>
								</div>
							</div>		
						<?php endif ?>
						<div class="profile-card my-3">
							<div class="profile-card-head">
								<div class="container">
									<div class="profile-card-title"><h4><?= lang('home_profile_info_title') ?></h4></div>
								</div>
							</div>
							<div class="container">
								<div class="form-row sso-input p-4">
									<div class="form-group col-sm-6">
										<label class="control-label"><?php echo lang('regis_contact_id'); ?>&nbsp;</label>
										<input class="input-sso" type="text" value="<?= $user_data['cid'] ?>" name="contact_cid" id="user1_id" autocomplete="off" maxlength="13"
										placeholder="<?php echo lang('regis_contact_id'); ?>" readonly>
									</div>
									<div class="form-group col-sm-6">
										<div class="sso-row-input">
											<div class="row">
												<div class="col-12">
													<label class="control-label"><?php echo lang('regis_contact_title'); ?> &nbsp;<span class="text-danger">*</span></label>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_contact_title'); ?> / Title name"
														tabindex="-98" name="contact_title" placeholder="<?php echo lang('regis_contact_title'); ?>">
														<option <?= $user_data['member_title'] == "นาย" || $user_data['member_title'] == "Mr." ? 'selected' : '' ?> value="นาย"><?php echo lang('regis_Mr'); ?></option>
														<option <?= $user_data['member_title'] == "นาง" || $user_data['member_title'] == "Mrs." ? 'selected' : '' ?> value="นาง"><?php echo lang('regis_Mrs'); ?></option>
														<option <?= $user_data['member_title'] == "นางสาว" || $user_data['member_title'] == "Ms." ? 'selected' : '' ?> value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fnameen'); ?>&nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" value="<?= $user_data['member_nameEn'] ?>" name="member_nameEn" placeholder="<?php echo lang('regis_contact_fnameen'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_snameen'); ?>&nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" value="<?= $user_data['member_lastnameEn'] ?>" name="member_lastnameEn" placeholder="<?php echo lang('regis_contact_snameen'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_mail'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" value="<?= $user_data['email'] ?>" name="email" placeholder="<?php echo lang('regis_contact_mail'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_phone'); ?> &nbsp;<span class="text-danger">*</span></label>
										<div id="tel2">
											<input type="text" class=" input-sso" value="<?= $user_data['tel'] ?>"  name="fo_tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone'); ?>">
											<input type="hidden" value="<?= $user_data['tel_country'] ?>" name="fo_tel_country">
											<input type="hidden" value="<?= $user_data['tel_code'] ?>" name="fo_tel_code">
										</div>
									</div>
								</div>
							</div>
						</div>		
					</form>
					<div class="d-flex justify-content-center align-items-center">
						<<?php if ($callback && !empty($callback)): ?>
							<a href="<?php echo $callback ?>" class="btn btn-cancel mr-4"><?= lang('home_profile_cancel') ?></a>
						<?php else: ?>	
							<a href="<?php echo BASE_PATH . _INDEX ?>portal/profile" class="btn btn-cancel mr-4"><?= lang('home_profile_cancel') ?></a>
						<?php endif ?>
						<button type="button" data-member_type="<?= $user_data['type'] ?>" data-callback="<?= $callback ?>" data-member_email="<?= $user_data['email'] ?>" class="btn btn-profile-submit"><?= lang('home_profile_submit') ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="tel3" class="d-none">
	<input type="text" class=" input-sso"name="tel" maxlength="15">
	<input type="hidden" name="tel_country">
	<input type="hidden"name="tel_code">
</div>
<div id="tel1" class="d-none">
	<input type="text" class=" input-sso" name="contact_tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone');?>">
	<input type="hidden" name="contact_tel_country">
	<input type="hidden" name="contact_tel_code">
	<input type="text" class=" input-sso" name="contact_director_tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone');?>">
	<input type="hidden" name="contact_director_tel_country">
	<input type="hidden" name="contact_director_tel_code">
</div>
<!-- laser code modal -->
<div class="modal sso-modal fade shadow" id="personal_laser_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 8px !important;">
      <div class="modal-header justify-content-center" style="border-bottom: 1px solid #8A919E;">
        <h5 class="modal-title text-center " ><?php echo lang('laser_modal_title') ?> บุคคลทั่วไป</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body sso-input">
        <form onsubmit="return false" id="form_laser_people" style="table-layout: fixed;width: 100%;">

          <table class="table table-borderless">
            <thead>
              <th width="50%"></th>
              <th width="50%"></th>
            </thead>
            <tbody>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">เลขหน้าบัตร&nbsp;:</td>
                <td id="laser-modal-citizenid" style="font-size: 1.23rem;color: #427C97;"></td>
                <input type="hidden" name="cid" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">ชื่อ&nbsp;:</td>
                <td id="laser-modal-fname" style="font-size: 1.23rem;color: #427C97;"></td>
                <input type="hidden" name="fname" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">นามสกุล&nbsp;:</td>
                <td id="laser-modal-lname" style="font-size: 1.23rem;color: #427C97;"></td>
                <input type="hidden" name="lname" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">วินเดือนปีเกิด&nbsp;:</td>
                <td id="laser-modal-bday" style="font-size: 1.23rem;color: #427C97;"></td>
                <input type="hidden" name="bday" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">เลขหลังบัตร&nbsp;:</td>
                <td>
                  <input type="text" name="laser_id" id="laser_id" class="input-sso" placeholder="JC0-0000000-00" maxlength="14">
                  <div class="minititle">โปรดกรอก Laser ID หลังบัตรประชาชน</div>
                  <img src="<?php echo BASE_PATH; ?>asset/img/laser-card.png" alt="laser-card">
                  <li>2 ตัวหลักแรกเป็นตัวอักษรภาษาอังกฤษ</li>
                  <li>หลักตัวที่ 3-12 ตัวหลังเป็นเลข</li>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center" style="border-top: 1px solid #8A919E;">
      	<button type="button" class="btn ck-citizen-laser-btn-cancel" data-dismiss="modal">ยกเลิก</button>
      	<button type="button" class="btn btn-login ck-citizen-type3-laser-btn">ตรวจสอบข้อมูล</button>
      </div>
    </div>
  </div>
</div>
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
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/main_register.js?ver=<?php echo $cash_time; ?>"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown_form_people.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown_form_companyEn.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown_form_company.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/page/portal/type24_edit.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/main_function.js"></script>
<script>
	$(document).ready(function () {
		// let tel_code = $(`#tel3`).find(`.iti__country`).attr("data-country-code");
		var tel_code = document.querySelector("input[name='fo_tel']");
		var tel_country = document.querySelector("input[name='fo_tel_country']").value;
		console.log(tel_country);
		window.intlTelInput(tel_code, {
		    initialCountry: tel_country,
		    geoIpLookup: function(success) {
		        // Get your api-key at https://ipdata.co/
		        fetch("https://api.ipdata.co/?api-key=ee33cf1471399e32d01edb80374112949546ca6fbed2e381ddd094b7")
		            .then(function(response) {
		                if (!response.ok) return success("");
		                console.log(response);
		                return response.json();
		            })
		            .then(function(ipdata) {
		                success(ipdata.country_code);
		            });
		    },
		    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js",
		});

		$('#type24_form [name="fo_country_name"]').change(function(){
			let country = $(this).data('country');

			console.log(country)
			$.ajax({
			    url:BASE_URL + _INDEX +"/register/get_country",
			    method: "post",
			    data: { "coutry": 1 },
			    success: function(result) {
			        $.each(result, function(key, data) {
			        		$('#country').append("<option class='country_name' value=" + data.CountryNameEN + ">" + data.CountryNameEN + "</option>");
			        });
			        $('.selectpicker').selectpicker('refresh');

			        let select_subdistrict = $("#type24_form [name='fo_country_name']").val();
			        let option_subdistrict = $("#type24_form [name='fo_country_name'] option");
			        console.log(select_subdistrict)
			        $.each(option_subdistrict, function (index, item) {
			            if ($(item).html() == country && !select_subdistrict) {
			                $(item).prop("selected", true);
			                $('.selectpicker').selectpicker('refresh');
			                return false;
			            }
			        });
			    }
			});

		}).trigger('change');



	  $(document).on('click',".ck_address",function(){
	    var val = $(this).val();
	    if(val == 1 ){
	     var text =  $('#text-use1').text();
	     $('#user1_id').attr('placeholder',$.trim(text).slice(0,-1))
	    }else{
	      var text =  $('#text-use2').text();
	     $('#user1_id').attr('placeholder',$.trim(text))
	    }
	    
	  })

	})

</script>