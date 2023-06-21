<div class="dashboard-container">
	<div class="container">
		<div class="profile-container">
			<div class="profile-title"><h2><b><?= lang('home_profile_change_info_title') ?></b></h2></div>
			<div class="row">
				<div class="col-sm-12 mb-2">
					<div class="profile-card my-3">
						<div class="profile-card-head">
							<div class="container">
								<div class="profile-card-title"><h4><b><?= lang('home_profile_com_info_title') ?></b></h4></div>
							</div>
						</div>
						<div class="container">
							<div class="form-row sso-input p-4">
								<div class="form-group col-sm-6">
									<label class="control-label"><?php echo lang('regis_com_num'); ?></b>&nbsp;</label>
									<input class="input-sso" type="text" name="cid" id="user1_id" autocomplete="off" maxlength="13"
									placeholder="<?php echo lang('regis_com_num'); ?>" readonly>
								</div>
								<div class="col-sm-6"></div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_com_name') ?>&nbsp;<span class="text-danger">*</label>
									<input type="text" class="input-sso" name="company_name" placeholder="<?php echo lang('regis_com_name'); ?>" readonly>
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_com_nameen'); ?></label>
									<input type="text" class=" input-sso" name="company_nameEn"
									placeholder=" <?php echo lang('regis_com_nameen'); ?>" pattern="([A-Za-z]|[@])+" readonly>
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<div class="find">
										<label class="control-label"><?php echo lang('regis_com_postcode'); ?></label>
										<input type="text" class=" input-sso postcode postcodeth" name="company_postcode"
										placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false" readonly>
										<div class="dropdown-menu dropdown_addr" id="dropdown_company_postcode"></div>
									</div>
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_com_province'); ?></label>
										<div class="provi1">
											<input type="text" class=" input-sso" name="company_province" placeholder="<?php echo lang('regis_com_province'); ?>"
											readonly>
										</div>
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_com_district'); ?></label>
									<div class="dis1">
										<input type="text" class=" input-sso" name="company_district" placeholder="<?php echo lang('regis_com_district'); ?>"
										readonly>
									</div>
									<div class="dis2" style="display:none;">
										<select class="form-control selectpicker sso-dropdown districtth" title="<?php echo lang('regis_com_district'); ?>"
											tabindex="-98" name="companyTH_districts" data-live-search="false">
											<option value=""><?php echo lang('regis_province_recom'); ?></option>
										</select>
									</div>
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_com_subdistrict'); ?></label>
									<div class="subdis1">
										<input type="text" class=" input-sso" name="company_subdistrict" placeholder="<?php echo lang('regis_com_subdistrict'); ?>"
										readonly>
									</div>
									<div class="subdis2" style="display:none;">
										<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict'); ?>" tabindex="-98"
											name="companyTH_subdistricts" data-live-search="false">
											<option value=""><?php echo lang('regis_district_recom'); ?></option>
										</select>
									</div>
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_com_address'); ?></label>
									<input type="text" class=" input-sso" name="company_address" placeholder="<?php echo lang('regis_com_address'); ?>" readonly>
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_com_addressen'); ?></label>
									<input type="text" class=" input-sso" name="company_addressEn"
									placeholder="<?php echo lang('regis_com_input_addressen'); ?>" pattern="([A-Za-z]|[@])+">
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
							<div class="form-row sso-input p-4">
								<div class="form-group col-sm-6">
									<label class="control-label"><?php echo lang('regis_contact_id'); ?></b>&nbsp;</label>
									<input class="input-sso" type="text" value="1 5099 6000 822 7" name="contact_cid" id="user1_id" autocomplete="off" maxlength="13"
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
											<!--<div class="col-12">
												<input type="text" class=" input-sso" name="sub[title]" placeholder="<?php echo lang('regis_contact_title'); ?>">
											</div>-->
											<div class="col-12">
												<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_contact_title'); ?> / Title name"
													tabindex="-98" name="contact_title" placeholder="<?php echo lang('regis_contact_title'); ?>">
													<option value="นาย"><?php echo lang('regis_Mr'); ?></option>
													<option value="นาง"><?php echo lang('regis_Mrs'); ?></option>
													<option value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_contact_fname'); ?> &nbsp;<span class="text-danger">*</span></label>
									<input type="text" class=" input-sso" name="contact_name" placeholder="<?php echo lang('regis_contact_fname'); ?>">
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_contact_sname'); ?> &nbsp;<span class="text-danger">*</span></label>
									<input type="text" class=" input-sso" name="contact_lastname" placeholder="<?php echo lang('regis_contact_sname'); ?>">
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_contact_fnameen'); ?>&nbsp;<span class="text-danger">*</span></label>
									<input type="text" class=" input-sso" name="contact_nameEn" placeholder="<?php echo lang('regis_contact_fnameen'); ?>">
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_contact_snameen'); ?>&nbsp;<span class="text-danger">*</span></label>
									<input type="text" class=" input-sso" name="contact_lastnameEn" placeholder="<?php echo lang('regis_contact_snameen'); ?>">
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_contact_mail'); ?> &nbsp;<span class="text-danger">*</span></label>
									<input type="text" class=" input-sso" name="contact_email" placeholder="<?php echo lang('regis_contact_mail'); ?>">
								</div>
								<div class="form-group col-sm-6 sso-row-input">
									<label class="control-label"><?php echo lang('regis_contact_phone'); ?> &nbsp;<span class="text-danger">*</span></label>
									<div id="tel1">
										<input type="text" class=" input-sso" name="contact_tel" maxlength="10"
										placeholder="<?php echo lang('regis_contact_phone'); ?>">
										<input type="hidden" name="contact_tel_country">
										<input type="hidden" name="contact_tel_code">
									</div>
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
							<div class="form-row sso-input card-company-address  card-sm-show-border" id="form_reg_company">
								<div class="form-group col-sm-12 p-4">
									<div class="sso-row-input">
										<div class="row">
											<div class="col-4 col-sm-4 col-md-3 col-lg-2">
												<input type="hidden" name="state" value="">
												<input type="hidden" name="Hcontact_address" value="">
												<input type="hidden" name="Hcontact_province" value="">
												<input type="hidden" name="Hcontact_district" value="">
												<input type="hidden" name="Hcontact_subdistrict" value="">
												<input type="hidden" name="Hcontact_postcode" value="">
												<label class="sso-radio pointer"> <?php echo lang('regis_contact_checkbox1'); ?>
													<input class="ck_address radio_new_adress" type="radio" name="ck_address" checked value="1" placeholder="<?php echo lang('regis_contact_checkbox1'); ?>">
													<span class="checkmark"></span>
												</label>
											</div>
											<div class="col-8 col-sm-6 col-md-8 col-lg-6">
												<label class="sso-radio pointer old_adress1"> <?php echo lang('regis_contact_checkbox2'); ?>
													<input class="ck_address radio_old_adress" type="radio" name="ck_address" value="2" placeholder="<?php echo lang('regis_contact_checkbox2'); ?>">
													<span class="checkmark"></span>
												</label>
												<label class="sso-radio pointer old_adress6" style="display:none;"> ที่อยู่เดียวกันด้านบน
													<input class="ck_address radio_old_adress" type="radio" name="ck_address" value="2" placeholder="ที่อยู่เดียวกับที่จดทะเบียน">
													<span class="checkmark"></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="find form-row w-100">
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_postcode'); ?><span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="contact_postcode_old" placeholder="<?php echo lang('regis_com_postcode'); ?>" readonly>
										<input type="text" class=" input-sso postcode" name="contact_postcode" placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<div class="dropdown-menu dropdown_addr" id="dropdown_contact_postcode">
										</div>
									</div>	
									<div class="col-sm-6"></div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_province'); ?>&nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="contact_province_old" placeholder="<?php echo lang('regis_com_province'); ?>"
										readonly>
										<select class="form-control selectpicker sso-dropdown btn-province" title="<?php echo lang('regis_com_province'); ?>"
											tabindex="-98" name="contact_province" data-live-search="false">
										</select>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_district'); ?></label> &nbsp;<span class="text-danger">*</span></label>
										<div class="txtdetail txtdistrict1" style="display:none;">
											<label for=""><?php echo lang('regis_com_khet'); ?></label> &nbsp;<span class="text-danger">*</span></label>
										</div>
										<input type="text" class=" input-sso" name="contact_district_old" placeholder="<?php echo lang('regis_com_district'); ?>"
										readonly>
										<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_district'); ?>" tabindex="-98"
											name="contact_district" data-live-search="false">
											<option value=""><?php echo lang('regis_province_recom'); ?></option>
										</select>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_subdistrict'); ?></label> &nbsp;<span class="text-danger">*</span></label>
										<div class="txtdetail txtsubdistrict1" style="display:none;">
											<label for=""><?php echo lang('regis_com_kwang'); ?></label> &nbsp;<span class="text-danger">*</span> </label>
										</div>
										<input type="text" class=" input-sso" name="contact_subdistrict_old" placeholder="<?php echo lang('regis_com_subdistrict'); ?>"
										readonly>
										<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict'); ?>" tabindex="-98"
											name="contact_subdistrict" data-live-search="false">
											<option value=""><?php echo lang('regis_district_recom'); ?></option>
										</select>
									</div>
									<div class="form-group col-sm-6 sso-row-input mb-4">
										<label class="control-label"><?php echo lang('regis_com_address'); ?>&nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="contact_address_old" placeholder="<?php echo lang('regis_com_address'); ?>"
										readonly>
										<input type="text" class=" input-sso" name="contact_address" placeholder="<?php echo lang('regis_com_address'); ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="d-flex justify-content-center align-items-center">
						<a href="<?php echo BASE_PATH . _INDEX ?>home/profile" class="btn btn-cancel mr-4"><?= lang('home_profile_cancel') ?></a>
						<button type="submit" class="btn btn-profile-submit"><?= lang('home_profile_submit') ?></button>
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
<div id="tel3" class="d-none">
	<input type="text" class=" input-sso" name="tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone');?>">
	<input type="hidden" name="tel_country">
	<input type="hidden" name="tel_code">
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/main_register.js?ver=<?php echo $cash_time; ?>"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown_form_people.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown_form_companyEn.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/dropdown_form_company.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/main_function.js"></script>
<script>
	$(document).ready(function () {
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
	function searchQueryParams(params) {
	  params.search = $('#search').val();
	  console.log(params);
	  return params; // body data
	}
	$(document).on('click', '#btn_search', function () {
	  $('.table-caseCh-list').bootstrapTable('refresh');
	  return false;
	})
</script>