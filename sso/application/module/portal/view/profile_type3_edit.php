
<div class="dashboard-container">
	<div class="container">
		<div class="profile-container">
			<div class="profile-title"><h2 class="contact-title"><?= lang('home_profile_change_info_title') ?></h2></div>
			<div class="row">
				<div class="col-sm-12 mb-2">
					<form action="" method="post" id="type3_form">
						<input type="hidden" name="member_id" value="<?= $user_data['member_id'] ?>">
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
														<option <?= $user_data['member_title'] == "นาย"? 'selected' : '' ?> value="นาย"><?php echo lang('regis_Mr'); ?></option>
														<option <?= $user_data['member_title'] == "นาง"? 'selected' : '' ?> value="นาง"><?php echo lang('regis_Mrs'); ?></option>
														<option <?= $user_data['member_title'] == "นางสาว"? 'selected' : '' ?> value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fname'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" value="<?= $user_data['member_nameTh'] ?>" name="member_nameTh" placeholder="<?php echo lang('regis_contact_fname'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_sname'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" value="<?= $user_data['member_lastnameTh'] ?>" name="member_lastnameTh" placeholder="<?php echo lang('regis_contact_sname'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fnameen'); ?>&nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" value="<?= $user_data['member_nameEn'] ?>" name="member_nameEn" placeholder="<?php echo lang('regis_contact_fnameen'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_snameen'); ?>&nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" value="<?= $user_data['member_lastnameEn'] ?>" name="member_lastnameEn" placeholder="<?php echo lang('regis_contact_snameen'); ?>">
									</div>
									<!-- <div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_birthday'); ?>&nbsp;<span class="text-danger">*</span></label>
										<input type="date" class=" input-sso" value="<?= $user_data['member_birthday'] ?>" name="member_birthday" >
									</div> -->
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_mail'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" value="<?= $user_data['email'] ?>" name="email" placeholder="<?php echo lang('regis_contact_mail'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_phone'); ?> &nbsp;<span class="text-danger">*</span></label>
										<div id="tel3">
											<input type="text" class=" input-sso" value="<?= $user_data['tel'] ?>" name="tel" maxlength="15"
											placeholder="<?php echo lang('regis_contact_phone'); ?>">
											<input type="hidden" value="<?= $user_data['tel_country'] ?>" name="tel_country">
											<input type="hidden" value="<?= $user_data['tel_code'] ?>" name="tel_code">
										</div>
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
								<div class="form-row sso-input card-people-address  card-sm-show-border p-4" id="form_reg_people">
									<div class="find form-row w-100">
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_postcode'); ?><span class="text-danger">*</span></label>
											<input type="text" class=" input-sso postcode" name="postcode" value="<?= $user_data['postcode'] ?>" data-district="<?= $user_data['districtTh'] ?>" data-subdistrict="<?= $user_data['subdistrictTh'] ?>" placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<div class="dropdown-menu dropdown_addr" id="dropdown_postcode">
											</div>
										</div>	
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_province'); ?>&nbsp;<span class="text-danger">*</span></label>
											<select class="form-control selectpicker sso-dropdown btn-province" title="<?php echo lang('regis_com_province'); ?>"
												tabindex="-98" name="provinceTh" data-live-search="false">
											</select>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<div class="txtdetail">
												<label class="control-label"><?php echo lang('regis_com_district_2'); ?></label> <span class="text-danger"> *</span></label>
											</div>
											<div class="txtdistrict1" style="display:none;">
												<label class="control-label" for=""><?php echo lang('regis_com_khet'); ?></label> <span class="text-danger"> *</span></label>
											</div>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_district'); ?>" tabindex="-98"
												name="districtTh" data-live-search="false">
												<option value=""><?php echo lang('regis_province_recom'); ?></option>
											</select>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<div class="txtdetail">
												<label class="control-label"><?php echo lang('regis_com_subdistrict_2'); ?></label> <span class="text-danger"> *</span></label>
											</div>
											<div class="txtsubdistrict1" style="display:none;">
												<label for=""><?php echo lang('regis_com_kwang'); ?></label> <span class="text-danger"> *</span> </label>
											</div>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict'); ?>" tabindex="-98"
												name="subdistrictTh" data-live-search="false">
												<option value=""><?php echo lang('regis_district_recom'); ?></option>
											</select>
										</div>
										<div class="form-group col-sm-6 sso-row-input mb-4">
											<label class="control-label"><?php echo lang('regis_com_address'); ?>&nbsp;<span class="text-danger">*</span></label>
											<input type="text" class=" input-sso" value="<?= $user_data['addressTh'] ?>" name="addressTh" placeholder="<?php echo lang('regis_com_address'); ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="d-flex justify-content-center align-items-center">
						<?php if ($callback && !empty($callback)): ?>
							<a href="<?php echo $callback ?>" class="btn btn-cancel mr-4"><?= lang('home_profile_cancel') ?></a>
						<?php else: ?>	
							<a href="<?php echo BASE_PATH . _INDEX ?>portal/profile" class="btn btn-cancel mr-4"><?= lang('home_profile_cancel') ?></a>
						<?php endif ?>
						
						<button type="button" data-status_email_verify="<?php echo $user_data['status_email_verify'] ?>" data-status_sms_verify="<?php echo $user_data['status_sms_verify'] ?>" data-status_laser_verify="<?php echo $user_data['status_laser_verify'] ?>" data-fname="<?= $user_data['member_nameTh'] ?>" data-lname="<?= $user_data['member_lastnameTh'] ?>" data-contact-title="<?= $user_data['contact_title'] ?>" data-birthday="<?= $user_data['member_birthday'] ?>" data-member_type="<?= $user_data['type'] ?>" data-member_email="<?= $user_data['email'] ?>" data-member_phone="<?= $user_data['tel'] ?>" data-callback="<?= $callback ?>" class="btn btn-profile-submit"><?= lang('home_profile_submit') ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="tel2" class="d-none">
	<input type="text" class=" input-sso" name="fo_tel" maxlength="10" placeholder="Tel">
	<input type="hidden" name="fo_tel_country">
	<input type="hidden" name="fo_tel_code">
</div>
<div id="tel1" class="d-none">
	<input type="text" class=" input-sso" name="contact_tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone');?>">
	<input type="hidden" name="contact_tel_country">
	<input type="hidden" name="contact_tel_code">
	<input type="text" class=" input-sso" name="contact_director_tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone');?>">
	<input type="hidden" name="contact_director_tel_country">
	<input type="hidden" name="contact_director_tel_code">
</div>
<input type="hidden" id="lang" value="<?php echo $_SESSION['lang'] ?>">
<!-- laser code modal -->
<!-- <div class="modal sso-modal fade shadow" id="personal_laser_modal" tabindex="-1" role="dialog" aria-hidden="true">
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
</div> -->

<!-- laser code modal -->
<div class="modal sso-modal fade shadow" id="personal_laser_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 8px !important;">
      <div class="modal-header " style="border-bottom: 1px solid #8A919E;">
        <h5 class="modal-title mitr-r" style="font-size: 18px;"><?php echo lang('laser_modal_title') ?></h5>
        <button type="button" class="close laser-modal-close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body sso-input">
        <form onsubmit="return false" id="form_laser_people">
          <div class="error-log text-danger d-flex justify-content-center w-100"></div>
          <table class="table table-borderless" style="table-layout: fixed;width: 100%;">
            <thead>
              <th width="30%"></th>
              <th width="50%"></th>
            </thead>
            <tbody>
              <tr>
                <td class="float-right _f16" style="">เลขหน้าบัตร&nbsp;:</td>
                <td id="laser-modal-citizenid" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="cid" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style="">ชื่อ&nbsp;:</td>
                <td id="laser-modal-fname" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="fname" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style="">นามสกุล&nbsp;:</td>
                <td id="laser-modal-lname" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="lname" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style="">วันเดือนปีเกิด&nbsp;:</td>
                <td id="laser-modal-bday" style="color: var(--main-color-1);"><input type="text" class="form-control input-sso sso-date-picker" name="bday" id="contact_bday_contact_portal_1" placeholder="<?php echo lang('regis_contact_birthday_placeholder'); ?>"></td>
                
                <!-- <input type="hidden" name="bday" value=""> -->
              </tr>
              <tr>
                <td class="float-right _f16" style="">เลขหลังบัตร&nbsp;:</td>
                <td>
                  <input type="text" name="laser_id" id="laser_id" class="input-sso" placeholder="JC0-0000000-00" maxlength="14">
                  <div class="minititle mitr-l py-2">โปรดกรอก Laser ID หลังบัตรประชาชน</div>
                  <img src="<?php echo BASE_PATH; ?>asset/img/laser-card.png" class="mb-2" alt="laser-card">
                  <li class="mitr-l _f14">2 ตัวหลักแรกเป็นตัวอักษรภาษาอังกฤษ</li>
                  <li class="mitr-l _f14">หลักตัวที่ 3-12 ตัวหลังเป็นเลข</li>
                </td>
              </tr>
              <tr>
              	<td class="laser-warning-container" colspan="2">
              		<p class="mb-0 mitr-r _f14">
              			หมายเหตุ : <span class="mitr-l">ใช้เพื่อตรวจสอบยืนยันตัวตนจากกรมการปกครอง ทางกรมฯ 
              			จะไม่เก็บข้อมูล เลขหลังบัตรประชาชนของท่าน</span>
              		</p>
              	</td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center" style="border-top: 1px solid #8A919E;">
        <button type="button" class="btn ck-contact-laser-btn-cancel" data-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn ck-citizen-type3-laser-btn">ตรวจสอบข้อมูล</button>
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
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown2.js"></script>
<!-- <script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown_form_people.js"></script> -->
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown_form_companyEn.js"></script>
<!-- <script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown_form_company.js"></script> -->
<script src="<?php echo BASE_PATH; ?>asset/js/page/portal/type3_edit.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/main_function.js"></script>
<script>
	$(document).ready(function () {
		// let tel_code = $(`#tel3`).find(`.iti__country`).attr("data-country-code");
		var tel_code = document.querySelector("input[name='tel']");
		var tel_country = document.querySelector("input[name='tel_country']").value;
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

		// document.querySelector(".sso-date-picker").removeAttribute("readonly");

		$(".sso-date-picker").flatpickr({
			altInput: true,
			altFormat: "d/m/Y",
			dateFormat: "Y-m-d",
			allowInput: true,
			disableMobile: true,
			static: true
		});

		const numberInput = document.querySelector('.numInput');
		console.log(numberInput);
		// Remove the readonly attribute
		numberInput.removeAttribute('readonly');

		let province = "#form_reg_people [name='provinceTh']"
		let district = "#form_reg_people [name='districtTh']"
		let subdistrict = "#form_reg_people [name='subdistrictTh']"
		let zipcode = "#form_reg_people [name='postcode']"
		let lang = $('#lang').val();
		$('input[name="postcode"]').change(function(){
			let districts = $(this).data('district');
			let subdistricts = $(this).data('subdistrict');
			$.ajax({
			    type: "post",
			    url:BASE_URL + _INDEX+"register/get_address_from_zipcode_district",
			    data: { postcode: this.value, district: districts, subdistrict:subdistricts },
			    success: function(response) {
			        if (response.res_code == '00') {
			            response.res_result.forEach(function(value) {
			                subdistrict_name = value.name_th
			                amphure_name = value.amphure_name_th
			                province_name = value.province_name_th
			                let drop_down = `
							      <a class="dropdown-item dropdown-postcode dropdown-link" 
							          amphure-id="${value.amphure_id}" 
							          province-id="${value.province_id}" 
							          district-id="${value.district_id}"
							          zip-code="${value.zip_code}"

							          province-tag="${province}"
							          district-tag="${district}"
							          subdistrict-tag="${subdistrict}"
							          zipcode-tag="${zipcode}"

							          lang="${lang}"
							          onclick="store_addr(this)">
							          ${subdistrict_name
							            // +' <i class="fa fa-angle-double-right addr-icon" aria-hidden="true"></i> '+amphure_name
							            // +' <i class="fa fa-angle-double-right addr-icon" aria-hidden="true"></i> '+province_name
							            +' <i class="fa fa-angle-right addr-icon" aria-hidden="true"></i> '+value.zip_code
							          }
							      </a>`;
							      store_addr(drop_down);
			            })

			           
			        }
			    }
			});
			// store_addr(this.value);
		}).trigger('change');
		// $('input[name="postcode"]').val('11110').change();


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