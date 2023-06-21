<?php
$lang = 'th';
if (isset($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
?>
<style>
	.swal2-close {
		font-size: 1.5em;
		color: var(--main-text-black);
	}
	.flatpickr-1 {
		display: none;
	}
	.flatpickr-6 {
		display: none;
	}
	.flatpickr-3 {
		display: none;
	}

	input[type="date"]:before { content: attr(placeholder) !important; color: #a1abed; position: absolute; }
</style>
<div class="row w-100 m-0">
	<div class=" d-md-block d-none col-md-4 px-0">
		<div class="left-side d-flex">
			<div class="container-fluid d-flex">
				<div class="row">
					<div class="col-12 d-flex align-items-end justify-content-center">
						<img class="w-50" src="<?php echo BASE_PATH; ?>asset/img/new-sso-logo-white.png" alt="">
					</div>
					<div class="col-12 d-flex align-items-end justify-content-center p-4">
						<div class="row">
							<div class="col-12 d-flex align-items-end justify-content-center">
								<img class="w-50 p-4" src="<?php echo BASE_PATH; ?>asset/img/ditp-logo-white.png" alt="">
							</div>
							<div class="col-12">
								<p class="text-center text-white mitr-l _f14">
									563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 <br>
									Call Center : 1169 | e-mail : 1169@ditp.go.th
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8 col-md-none pl-0" style="height:100vh;overflow:hidden;overflow-y:auto;">
		<nav class="navbar navbar-light ">
			<div class="justify-content-start pointer">
				<a href="<?php echo BASE_PATH . _INDEX ?>auth?response_type=<?php echo $_SESSION['response_type'] ?>&client_id=<?php echo $_SESSION['client_id'] ?>&redirect_uri=<?php echo $_SESSION['redirect_uri'] ?>" class="back-login text-dark">
					<i class="fas fa-arrow-left"></i> &nbsp;<span><?php echo lang('signin') ?></span>
				</a>
			</div>
			<div class="justify-content-end">
				<a href="tel:1169" class="contact-tel mitr-l"><?php echo lang('home_contact_nav') ?><i class="fa fa-phone"></i>&nbsp;<span class="mitr-r">1169</span></a>
				<a onClick="storeInputValues('th')" class="change-lang mitr-l" role="button">
					<img class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png" alt="">
				</a>
				<a onClick="storeInputValues('en')" class="change-lang mitr-l" role="button">
					<img class="<?php echo ($lang == 'en') ? ' active ' : '';?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png" alt="">
				</a>
			</div>
		</nav>
		<div class="container box-register">
			<div class="row">
				<div class=" col-sm-12 col-md-12 col-lg-12 text-center mt-4">
					<ul class="nav nav-pills mb-3 group-pill" id="pills-tab" role="tablist">
						<li class="nav-item group-pill group-pillF1 mr-2 mb-2" role="presentation">
							<a class="nav-link active" id="company-tab" data-toggle="pill" href="#pills-company" role="tab" aria-controls="pills-company" aria-selected="true" onclick="settitle('<?php echo lang('regis_header'); ?>');$('.ck_default').click();passreset();storetype(1);">
								<i class="fa-solid fa-check"></i>
								<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget"><?php echo lang('regis_menu1'); ?>
								</div>
							</a>
						</li>
						<li class="nav-item group-pill group-pillF1-1 mr-2 mb-2" role="presentation">
							<a class="nav-link" id="non-company-tab" data-toggle="pill" href="#pills-non-company" role="tab" aria-controls="pills-non-company" aria-selected="true" onclick="settitle('<?php echo lang('regis_header'); ?>');$('.ck-non-default').click();passreset();storetype(6);">
								<i class="fa-solid fa-check"></i>
								<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget"><?php echo lang('regis_checkbox2'); ?>
								</div>
							</a>
						</li>
						<li class="nav-item group-pill group-pillF2 mr-2 mb-2" role="presentation">
							<a class="nav-link" id="people-tab" data-toggle="pill" href="#pills-people" role="tab" aria-controls="pills-people" aria-selected="false" onclick="settitle('<?php echo lang('regis_header'); ?>');passreset();storetype(3);">
								<i class="fa-solid fa-check"></i>
								<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget"><?php echo lang('regis_menu2'); ?>
								</div>
							</a>
						</li>
						<li class="nav-item mr-auto group-pill group-pillF3 mr-2 mb-2" role="presentation">
							<a class="nav-link" id="non-thai-tab" data-toggle="pill" href="#non-thai-tabs" role="tab" aria-controls="non-thai-tabs" aria-selected="false" onclick="settitle('REGISTER');radio_foreigner(2);$('.ck_fo_default').click();passreset();storetype(2);">
								<i class="fa-solid fa-check"></i>
								NON-THAI
							</a>
						</li>
					</ul>
				</div>
				<div class=" col-sm-12 sm-p-0-30">
					<div class="tab-content sso-input" id="pills-tabContent">
						<!-- COMPANY TAB -->
						<div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="company-tab">
							<form action="#" onsubmit="return false" id="<?php echo $form_reg_company = 'form_reg_company'; ?>" autocomplete="off" class="form-horizontal" method="post">
								<!-- radiobox -->
								<div class="row sso-radio-container d-none">
									<div class="col-sm-12 col-md-6 col-lg-6 d-inline-flex align-items-center">
										<label class="sso-radio pointer text-white">
											<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
												<?php echo lang('regis_checkbox1'); ?>
											</div>
											<input class="ck_address ck_default" type="radio" id="data_type" name="data_type" value="1">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
								<!-- endradiobox -->
								<!-- niti-thai-header -->
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?php echo lang('regis_com_header') ?></span></h4>
								</div>
								<!-- end niti-thai-header -->
								<!-- niti-thai-data -->
								<div class="form-row sso-input">
									<div class="form-group col-sm-12 col-md-12 col-lg-6 loader_input load_dbd">
										<!-- <span id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></span> -->
										<div class="d-flex justify-content-between">
											<label class="control-label" id="text-use1"><?php echo lang('regis_com_num'); ?></b>&nbsp;<span class="text-danger">*</span></label>
											<label class="control-label" id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></b>&nbsp;<span class="text-danger">*</span></label>
											<div class="col-6 warning-niti load_dbd">
												<?php echo lang('regis_com_num_error'); ?>
											</div>
										</div>
										<div class="regis-com-check">
											<input class="input-sso" type="text" name="cid" id="user1_id" autocomplete="off" maxlength="13"
											placeholder="<?php echo lang('regis_com_num'); ?>">
											<button class="btn btn-primary regis-com-check-btn ck_dbd" id="1" data-ck="user1_id"type="button"><?php echo lang('regis_check_btn') ?></button> 
										</div>
										<div class="col-12 minititle mitr-l _f14 my-2 px-0" id="thisVal1">
											<?php echo lang('regis_com_recom'); ?>
										</div>
										<div class="col-12 minititle" id="thisVal6" style="display:none;">
											<?php echo lang('regis_com_recom2'); ?>
										</div>
									</div>
								</div>
								<div class="form-row sso-input" id="corporation_container">
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_name') ?>&nbsp;<span class="text-danger">*</label>
										<input type="text" class="input-sso" name="company_name" placeholder="<?php echo lang('regis_com_name'); ?>" readonly>

									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_nameen'); ?></label>
										<input type="text" class=" input-sso" name="company_nameEn" id="company_nameEn" placeholder=" <?php echo lang('regis_com_nameen'); ?>" readonly>
									</div>
									<!-- non-niti-data -->
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_email'); ?>&nbsp;<span class="text-danger">*</label>
										<input type="text" class=" input-sso" name="company_email" id="company_email" placeholder="<?php echo lang('regis_com_email'); ?>">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input"	>
										<label class="control-label"><?php echo lang('regis_com_phone'); ?></label>
										<input type="text" class=" input-sso" name="company_phone" id="company_phone" placeholder="<?php echo lang('regis_com_phone'); ?>"  inputmode="numeric" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
									</div>
									<!-- end non-niti-data -->
									<div class="form-group col-sm-6 sso-row-input">
										<div class="find">
											<label class="control-label"><?php echo lang('regis_com_postcode'); ?></label>
											<input type="text" class=" input-sso postcode postcodeth" name="company_postcode" placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" readonly>
											<div class="dropdown-menu" id="dropdown_company_postcode"></div>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_province'); ?></label>
											<div class="provi1">
												<input type="text" class=" input-sso" name="company_province" placeholder="<?php echo lang('regis_com_province'); ?>" readonly>
											</div>
											<!-- <div class="provi2" style="display:none;">
											  <select class="form-control selectpicker sso-dropdown btn-province provinceth"
											    title="<?php echo lang('regis_com_province'); ?>" tabindex="-98" name="companyTH_province" data-live-search="false">
											  </select>
											</div> -->
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
											<input type="text" class=" input-sso" name="company_subdistrict" placeholder="<?php echo lang('regis_com_subdistrict_2'); ?>"
											readonly>
										</div>
										<div class="subdis2" style="display:none;">
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict_2'); ?>" tabindex="-98"
												name="companyTH_subdistricts" data-live-search="false">
												<option value=""><?php echo lang('regis_district_recom'); ?></option>
											</select>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_address'); ?>&nbsp;<span class="text-danger">*</label>
										<input type="text" class=" input-sso" name="company_address" placeholder="<?php echo lang('regis_com_address'); ?>" readonly>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_addressen'); ?>&nbsp;<span class="text-danger">*</label>
										<input type="text" class=" input-sso" name="company_addressEn" id="company_addressEn" placeholder="<?php echo lang('regis_com_input_addressen'); ?>" oninput="this.value = this.value.replace(/[^A-Za-z0-9\s/,.\\-]+/g, '');">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
								</div>
								<!-- end niti-thai-data -->
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?= lang('regis_com_director_header') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-12">
										<div class="sso-row-input">
											<div class="row director-checkbox">
												<div class="col col-md-6 col-lg-6">
													<label class="sso-radio pointer"> <span><?php echo lang('regis_com_checkbox1'); ?></span>
														<input class="ck_address " type="radio" name="ck_director_type" id="ck_director_type1" value="1" placeholder="<?php echo lang('regis_com_checkbox1'); ?>">
														<br>
														<span><small class="_f14 mitr-l"><?php echo lang('regis_com_checkboxsub1'); ?></small></span>
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col col-md-6 col-lg-6">
													<label class="sso-radio pointer old_adress1"> <span><?php echo lang('regis_com_checkbox2'); ?><br>
														<span><small class="_f14 mitr-l"><?php echo lang('regis_com_checkboxsub2'); ?></small></span></span>

														<input class="ck_address " type="radio" name="ck_director_type" id="ck_director_type2" value="2" placeholder="<?php echo lang('regis_com_checkbox2'); ?>">
														
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</div>
									</div>
									<h4 class="mitr-r _f16 my-4"><span><?= lang('regis_nationality_title') ?></span></h4>
									<div class="form-row sso-input" id="type1_contact_group">
										<div class="form-group col-sm-12">
											<div class="sso-row-input">
												<div class="row">
													<div class="col col-md-5 col-lg-3">
														<label class="sso-radio pointer"> <?php echo lang('regis_nationality_checkbox1'); ?>
															<input class="ck_address " type="radio" role="button" name="ck_nationality_type" id="ck_national_thai" checked value="1" placeholder="<?php echo lang('regis_nationality_checkbox1'); ?>">
															<span class="checkmark"></span>
														</label>
													</div>
													<div class="col col-md-7 col-lg-8">
														<label class="sso-radio pointer old_adress1"> <span><?php echo lang('regis_nationality_checkbox2'); ?></span>
															<input class="ck_address " type="radio" role="button" name="ck_nationality_type" id="ck_national_foreigner" value="2" placeholder="<?php echo lang('regis_nationality_checkbox2'); ?>">
															<span class="checkmark"></span>
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group col-sm-6">
											<div class="sso-row-input">
												<div class="row">
													<div class="col-12">
														<label class="control-label"><?php echo lang('regis_contact_title'); ?> <span class="text-danger"> *</span></label>
													</div>
												</div>
												<div class="row">
													<div class="col-12">
														<select class="form-control selectpicker sso-dropdown" id="contact_title_contact_1" title="<?php echo lang('regis_contact_title'); ?>"
															tabindex="-98" name="contact_title" placeholder="<?php echo lang('regis_contact_title'); ?>">
															<option value="นาย"><?php echo lang('regis_Mr'); ?></option>
															<option value="นาง"><?php echo lang('regis_Mrs'); ?></option>
															<option value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-6"></div>
										<div class="form-group col-sm-4 sso-row-input nationality_thai_name_container">
											<label class="control-label"><?php echo lang('regis_contact_fname'); ?> <span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_name" id="contact_name_contact_1" placeholder="<?php echo lang('regis_contact_fname'); ?>">
										</div>
										<div class="form-group col-sm-4 sso-row-input nationality_thai_midname_container">
											<label class="control-label"><?php echo lang('regis_contact_midname'); ?> <small class="mitr-el"><?php echo lang('regis_not_required'); ?></small></label>
											<input type="text" class=" input-sso" name="contact_midname" id="contact_midname_contact_1" placeholder="<?php echo lang('regis_contact_midname'); ?>">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-4 sso-row-input nationality_thai_sname_container">
											<label class="control-label"><?php echo lang('regis_contact_sname'); ?> <span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_lastname" id="contact_lastname_contact_1" placeholder="<?php echo lang('regis_contact_sname'); ?>">
										</div>
										<div class="form-group col-sm-4 sso-row-input">
											<label class="control-label"><?php echo lang('regis_contact_fnameen'); ?> <span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_nameEn" id="contact_nameEn_contact_1" placeholder="<?php echo lang('regis_contact_fnameen'); ?>" oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-4 sso-row-input">
											<label class="control-label"><?php echo lang('regis_contact_midnameen'); ?> <small class="mitr-el"><?php echo lang('regis_not_required'); ?></small></label>
											<input type="text" class=" input-sso" name="contact_midnameEn" id="contact_midnameEn_contact_1" placeholder="<?php echo lang('regis_contact_midnameen'); ?>" oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-4 sso-row-input">
											<label class="control-label"><?php echo lang('regis_contact_snameen'); ?><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_lastnameEn" id="contact_lastnameEn_contact_1" placeholder="<?php echo lang('regis_contact_snameen'); ?>" oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input nationality_thai_bday_container">
											<label class="control-label"><?php echo lang('regis_contact_birthday'); ?> <small class="mitr-el"><?php echo lang('regis_contact_birthday_example'); ?></small><span class="text-danger">*</span></label>
											<input type="text" class="form-control input-sso sso-date-picker" name="contact_bday" id="contact_bday_contact_1" placeholder="<?php echo lang('regis_contact_birthday_placeholder'); ?>">
											<input type="text" class="form-control input-sso"  id="bday_copy_1" style="display: none;">
										</div>
										<div class="form-group col-sm-6 sso-row-input loader_input laser nationality_thai_container">
											<!-- <span id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></span> -->
											<div class="d-flex justify-content-between">
												<label class="control-label"><?php echo lang('regis_contact_id'); ?> <span class="text-danger"> *</span></label>
												<div class="col-5 warning-niti">
													<?php echo lang('regis_com_num_error'); ?>
												</div>
											</div>
											<div class="regis-noncom-check">
												<input type="text" class=" input-sso" name="contact_cid" id="contact_cid_contact_1" maxlength="13" placeholder="<?php echo lang('regis_contact_id'); ?>">
												<button class="btn btn-primary ck-contact-id-btn " data-ckcon="contact_1" type="submit"><?php echo lang('regis_check_btn') ?></button> 
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input loader_input laser nationality_foreigner_container d-none">
											<!-- <span id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></span> -->
											<div class="d-flex justify-content-between">
												<label class="control-label"><?php echo lang('regis_contact_id_fo'); ?> <span class="text-danger"> *</span></label>
												<div class="col-5 warning-niti">
													<?php echo lang('regis_com_num_error'); ?>
												</div>
											</div>
											<div class="regis-noncom-check">
												<input type="text" class=" input-sso" name="contact_cid_fo" id="contact_cid_contact_1" maxlength="13" placeholder="<?php echo lang('regis_contact_id'); ?>">
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_contact_mail'); ?> <small class="mitr-el"><?php echo lang('regis_contact_mail_example') ?></small><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_email" placeholder="<?php echo lang('regis_contact_mail'); ?>">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_contact_phone'); ?> <small class="mitr-el"><?php echo lang('regis_contact_phone_example') ?></small><span class="text-danger"> *</span></label>
											<div id="tel1">
												<input type="text" class=" input-sso" name="contact_tel"  placeholder="<?php echo lang('regis_contact_phone'); ?>" inputmode="numeric" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
												<input type="hidden" name="contact_tel_country">
												<input type="hidden" name="contact_tel_code">
											</div>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
									<!-- <div class="form-group col-sm-6 sso-row-input director-container d-none ">
										<label class="control-label"><?php echo lang('regis_contact_director_mail'); ?> <span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="contact_director_email" placeholder="<?php echo lang('regis_contact_director_mail'); ?>">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input director-container d-none ">
										<label class="control-label"><?php echo lang('regis_contact_director_phone'); ?> <span class="text-danger"> *</span></label>
										<div id="tel4">
											<input type="text" class=" input-sso" name="contact_director_tel" maxlength="10"
											placeholder="<?php echo lang('regis_contact_director_phone'); ?>">
											<input type="hidden" name="contact_director_tel_country">
											<input type="hidden" name="contact_director_tel_code">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div> -->
								</div>
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?= lang('home_profile_address_title') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-12">
										<div class="sso-row-input">
											<div class="row">
												<div class="col col-5 col-md-5 col-lg-3">
													<input type="hidden" name="state" value="">
													<input type="hidden" name="Hcontact_address" value="">
													<input type="hidden" name="Hcontact_province" value="">
													<input type="hidden" name="Hcontact_district" value="">
													<input type="hidden" name="Hcontact_subdistrict" value="">
													<input type="hidden" name="Hcontact_postcode" value="">
													<label class="sso-radio pointer"> <?php echo lang('regis_contact_checkbox1'); ?>
														<input class="ck_address radio_new_adress1" type="radio" name="ck_address" checked value="1" placeholder="<?php echo lang('regis_contact_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col col-7 col-md-7 col-lg-8 pr-0">
													<label class="sso-radio pointer old_adress1"> <?php echo lang('regis_contact_checkbox2'); ?>
														<input class="ck_address radio_old_adress1" type="radio" name="ck_address" value="2" placeholder="<?php echo lang('regis_contact_checkbox2'); ?>">
														<span class="checkmark"></span>
													</label>
													<!-- <label class="sso-radio pointer old_adress6" style="display:none;"> ที่อยู่เดียวกันกับที่จดทะเบียน
														<input class="ck_address radio_old_adress6" type="radio" name="ck_address" value="2" placeholder="ที่อยู่เดียวกับที่จดทะเบียน">
														<span class="checkmark"></span>
													</label> -->
												</div>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-12 find form-row w-100">
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_postcode'); ?><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_postcode_old" placeholder="<?php echo lang('regis_com_postcode'); ?>" readonly>
											<input type="text" class=" input-sso postcode" name="contact_postcode" placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<div class="dropdown-menu dropdown_addr" id="dropdown_contact_postcode">
											</div>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>	
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_province'); ?><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_province_old" placeholder="<?php echo lang('regis_com_province'); ?>"
											readonly>
											<select class="form-control selectpicker sso-dropdown btn-province" title="<?php echo lang('regis_com_province'); ?>"
												tabindex="-98" name="contact_province" data-live-search="false">
											</select>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<div class="txtdetail">
												<label class="control-label"><?php echo lang('regis_com_district_2'); ?></label> <span class="text-danger"> *</span></label>
											</div>
											<div class="txtdistrict1" style="display:none;">
												<label class="control-label" for=""><?php echo lang('regis_com_khet'); ?></label> <span class="text-danger"> *</span></label>
											</div>
											<input type="text" class=" input-sso" name="contact_district_old" placeholder="<?php echo lang('regis_com_district_2'); ?>"
											readonly>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_district_2'); ?>" tabindex="-98"
												name="contact_district" data-live-search="false">
												<option value=""><?php echo lang('regis_province_recom'); ?></option>
											</select>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<div class="txtdetail">
												<label class="control-label"><?php echo lang('regis_com_subdistrict_2'); ?></label> <span class="text-danger"> *</span></label>
											</div>
											<div class="txtsubdistrict1" style="display:none;">
												<label for=""><?php echo lang('regis_com_kwang'); ?></label> <span class="text-danger"> *</span> </label>
											</div>
											<input type="text" class=" input-sso" name="contact_subdistrict_old" placeholder="<?php echo lang('regis_com_subdistrict_2'); ?>"
											readonly>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict_2'); ?>" tabindex="-98"
												name="contact_subdistrict" data-live-search="false">
												<option value=""><?php echo lang('regis_district_recom'); ?></option>
											</select>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input mb-4">
											<label class="control-label"><?php echo lang('regis_com_address'); ?><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_address_old" placeholder="<?php echo lang('regis_com_address'); ?>"
											readonly>
											<input type="text" class=" input-sso" name="contact_address" placeholder="<?php echo lang('regis_com_address'); ?>">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
								</div>
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?= lang('regis_pass') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<label for="" class="control-label"><?php echo lang('regis_pass'); ?>&nbsp;(Password)<span class="text-danger"> *</span></label>
										<div class="warning-pass pass" id="company-password">
											<?php echo lang('regis_com_pass_recom'); ?>

										</div>
										<div class="warning-repass pass" id="company-password">
											<?php echo lang('regis_pass_nomatch'); ?>
										</div>
										<div class="pass-input-with-icon">
											<input class=" input-sso pass_input" type="text" id="password" name="password" minlength="8" required
											autocomplete="off" placeholder=" <?php echo lang('regis_pass'); ?>">
											<i id="show-pass" class="fa fa-eye-slash icon-password-reg"
											onclick="show_pass(this,'password','form_reg_company')"></i>
										</div>
										<div class="col-12 minititle pl-0">
											<?php echo lang('regis_pass_recom'); ?>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="" class="control-label"><?php echo lang('regis_pass_confirm'); ?><span class="text-danger"> *</span></label>
										<div class="warning-pass repass" id="company-password">
											<?php echo lang('regis_com_pass_recom'); ?>

										</div>
										<div class="warning-repass repass" id="company-password">
											<?php echo lang('regis_pass_nomatch'); ?>
										</div>
										<div class="pass-input-with-icon">
											<input class=" input-sso pass_input" type="text" id="repassword" name="repassword" minlength="8" required
											autocomplete="off" placeholder=" <?php echo lang('regis_pass_confirm'); ?>">
											<i id="show-repass" class="fa fa-eye-slash icon-password-reg"
											onclick="show_pass(this,'repassword','form_reg_company')"></i>
										</div>
									</div>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<div class="sso-row-input">
											<div class="row">
												<div class="col">
													<label class="sso-radio pointer"> <?php echo lang('regis_email_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify" data-radioemail="1" id="ck_radio_email" value="1" placeholder="<?php echo lang('regis_email_verify_checkbox1'); ?>" checked>
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col">
													<label class="sso-radio pointer"> <?php echo lang('regis_sms_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify" data-radiosms="1" id="ck_radio_sms" value="2" placeholder="<?php echo lang('regis_sms_verify_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</div>
								</div>
								<div class="form-group col-sm-6">
									<div class="btn  submitform1  btn-con-reg"
									  data-form="<?php echo $form_reg_company ?>" data-type="1">
									  <?php echo lang('regis_header'); ?></div>
								</div>
							</form>
							</div>
						</div>
						<!-- NON-COMPANY TAB -->
						<div class="tab-pane fade" id="pills-non-company" role="tabpanel" aria-labelledby="non-company-tab">
							<form action="#" onsubmit="return false" id="<?php echo $form_reg_company = 'form_reg_noncompany'; ?>" autocomplete="off" class="form-horizontal" method="post">
								<!-- radiobox -->
								<div class="row sso-radio-container d-none">
									<div class="col-sm-12 col-md-6 col-lg-6 d-inline-flex align-items-center">
										<label class="sso-radio pointer text-white ">
											<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
												<?php echo lang('regis_checkbox2'); ?>
											</div>
											<input class="ck_address ck-non-default" type="radio" id="data_type" name="data_type"  value="6">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
								<!-- endradiobox -->
								<!-- niti-thai-header -->
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?php echo lang('regis_com_non_header') ?></span></h4>
								</div>
								<!-- end niti-thai-header -->
								<!-- niti-thai-data -->
								<div class="form-row sso-input">
									<div class="form-group col-sm-12 col-md-12 col-lg-6 loader_input load_dbd">
										<!-- <span id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></span> -->
										<div class="d-flex justify-content-between">
											<label class="control-label" id="text-use1"><?php echo lang('regis_com_num'); ?></b>&nbsp;<span class="text-danger">*</span></label>
											<label class="control-label" id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></b>&nbsp;<span class="text-danger">*</span></label>
											<div class="col-6 warning-niti load_dbd">
												<?php echo lang('regis_com_num_error'); ?>
											</div>
										</div>
										<div class="regis-com-check">
											<input class="input-sso" type="text" name="cid" id="user6_id" autocomplete="off" maxlength="13"
											placeholder="<?php echo lang('regis_com_taxid'); ?>">
											<button class="btn btn-primary regis-com-check-btn ck_dbd" id="6" data-ck="user6_id" type="button"><?php echo lang('regis_check_btn') ?></button> 
										</div>
										<div class="col-12 minititle mitr-l _f14 my-2 px-0" id="thisVal1">
											<?php echo lang('regis_com_recom'); ?>
										</div>
										<div class="col-12 minititle" id="thisVal6" style="display:none;">
											<?php echo lang('regis_com_recom2'); ?>
										</div>
									</div>
								</div>
								<div class="form-row sso-input" id="corporation_container">
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_name_non') ?>&nbsp;<span class="text-danger">*</label>
										<input type="text" class="input-sso" name="company_name" placeholder="<?php echo lang('regis_com_name_non'); ?>" readonly>
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_nameen_non'); ?></label>
										<input type="text" class=" input-sso" name="company_nameEn" id="company_nameEn" placeholder=" <?php echo lang('regis_com_nameen_non'); ?>" readonly>
									</div>
									<!-- non-niti-data -->
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_emailnon'); ?>&nbsp;<span class="text-danger">*</label>
										<input type="text" class=" input-sso" name="company_email" id="company_email" placeholder="<?php echo lang('regis_com_emailnon'); ?>">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input"	>
										<label class="control-label"><?php echo lang('regis_com_phone_non'); ?></label>
										<input type="text" class=" input-sso" name="company_phone" id="company_phone" placeholder="<?php echo lang('regis_com_phone_non'); ?>"  inputmode="numeric" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
									</div>
									<!-- end non-niti-data -->
									<div class="form-group col-sm-6 sso-row-input">
										<div class="find">
											<label class="control-label"><?php echo lang('regis_com_postcode'); ?>&nbsp;<span class="text-danger">*</span></label>
											<input type="text" class=" input-sso postcode postcodeth" name="company_postcode" id="noncompany_postcode" placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" readonly>
											<div class="dropdown-menu dropdown_addr" id="dropdown_noncompany_postcode"></div>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_province'); ?></label>
											<div class="provi1">
												<input type="text" class=" input-sso" name="company_province" placeholder="<?php echo lang('regis_com_province'); ?>" readonly>
											</div>
											<div class="provi2" style="display:none;">
											  <select class="form-control selectpicker sso-dropdown btn-province provinceth"
											    title="<?php echo lang('regis_com_province'); ?>" tabindex="-98" name="companyTH_province" id="noncompanyTH_province" data-live-search="false">
											  </select>
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
												tabindex="-98" name="companyTH_districts" id="noncompanyTH_districts" data-live-search="false">
												<option value=""><?php echo lang('regis_province_recom'); ?></option>
											</select>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_subdistrict'); ?></label>
										<div class="subdis1">
											<input type="text" class=" input-sso" name="company_subdistrict" placeholder="<?php echo lang('regis_com_subdistrict_2'); ?>"
											readonly>
										</div>
										<div class="subdis2" style="display:none;">
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict_2'); ?>" tabindex="-98"
												name="companyTH_subdistricts" id="noncompanyTH_subdistricts" data-live-search="false">
												<option value=""><?php echo lang('regis_district_recom'); ?></option>
											</select>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_address'); ?>&nbsp;<span class="text-danger">*</label>
										<input type="text" class=" input-sso" name="company_address" id="noncompany_address" placeholder="<?php echo lang('regis_com_address'); ?>" readonly>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_addressen'); ?>&nbsp;<span class="text-danger">*</label>
										<input type="text" class=" input-sso" name="company_addressEn" id="noncompany_addressEn" placeholder="<?php echo lang('regis_com_input_addressen'); ?>" oninput="this.value = this.value.replace(/[^A-Za-z0-9\s/,.\\-]+/g, '');">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
								</div>
								<!-- end niti-thai-data -->
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?= lang('regis_com_director_header') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-12">
										<div class="sso-row-input">
											<div class="row">
												<div class="col col-md-5 col-lg-3">
													<label class="sso-radio pointer"> <?php echo lang('regis_com_checkbox1'); ?>
														<input class="ck_address " type="radio" name="ck_director_type" id="ck_director_type1" checked value="1" placeholder="<?php echo lang('regis_com_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col col-md-7 col-lg-8">
													<label class="sso-radio pointer old_adress1"> <?php echo lang('regis_com_checkbox2'); ?>
														<input class="ck_address " type="radio" name="ck_director_type" id="ck_director_type2" value="2" placeholder="<?php echo lang('regis_com_checkbox2'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div class="sso-row-input">
											<div class="row">
												<div class="col-12">
													<label class="control-label"><?php echo lang('regis_contact_title'); ?> <span class="text-danger"> *</span></label>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<select class="form-control selectpicker sso-dropdown" id="contact_title_contact_6" title="<?php echo lang('regis_contact_title'); ?>"
														tabindex="-98" name="contact_title" placeholder="<?php echo lang('regis_contact_title'); ?>">
														<option value="นาย"><?php echo lang('regis_Mr'); ?></option>
														<option value="นาง"><?php echo lang('regis_Mrs'); ?></option>
														<option value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6"></div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fname'); ?> <span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="contact_name" id="contact_name_contact_6" placeholder="<?php echo lang('regis_contact_fname'); ?>">
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_midname'); ?> <small class="mitr-el"><?php echo lang('regis_not_required'); ?></small></label>
										<input type="text" class=" input-sso" name="contact_midname" id="contact_midname_contact_6" placeholder="<?php echo lang('regis_contact_midname'); ?>">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_sname'); ?> <span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="contact_lastname" id="contact_lastname_contact_6" placeholder="<?php echo lang('regis_contact_sname'); ?>">
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fnameen'); ?><span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="contact_nameEn" id="contact_nameEn_contact_6" placeholder="<?php echo lang('regis_contact_fnameen'); ?>"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_midnameen'); ?> <small class="mitr-el"><?php echo lang('regis_not_required'); ?></small></label>
										<input type="text" class=" input-sso" name="contact_midnameEn" id="contact_midnameEn_contact_6" placeholder="<?php echo lang('regis_contact_midnameen'); ?>"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_snameen'); ?><span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="contact_lastnameEn" id="contact_lastnameEn_contact_6" placeholder="<?php echo lang('regis_contact_snameen'); ?>"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
									</div>
									<div class="form-group col-sm-6 sso-row-input non_company_tab_bday_container">
										<label class="control-label"><?php echo lang('regis_contact_birthday'); ?> <small class="mitr-el"><?php echo lang('regis_contact_birthday_example'); ?></small><span class="text-danger"> *</span></label>
										<input type="text" class="form-control input-sso sso-date-picker" name="contact_bday" id="contact_bday_contact_6" placeholder="<?php echo lang('regis_contact_birthday_placeholder'); ?>">
										<input type="text" class="form-control input-sso"  id="bday_copy_6" style="display: none;">
									</div>
									<div class="form-group col-sm-6 sso-row-input loader_input laser">
										<!-- <span id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></span> -->
										<div class="d-flex justify-content-between">
											<label class="control-label"><?php echo lang('regis_contact_id'); ?> <span class="text-danger"> *</span></label>
											<div class="col-5 warning-niti">
												<?php echo lang('regis_com_num_error'); ?>
											</div>
										</div>
										<div class="regis-noncom-check">
											<input type="text" class=" input-sso" name="contact_cid" id="contact_cid_contact_6" maxlength="13" placeholder="<?php echo lang('regis_contact_id'); ?>">
											<button class="btn btn-primary ck-contact-id-btn " data-ckcon="contact_6" type="submit"><?php echo lang('regis_check_btn') ?></button> 
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_mail'); ?> <small class="mitr-el"><?php echo lang('regis_contact_mail_example') ?></small><span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="contact_email" placeholder="<?php echo lang('regis_contact_mail'); ?>">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_phone'); ?> <small class="mitr-el"><?php echo lang('regis_contact_phone_example') ?></small><span class="text-danger"> *</span></label>
										<div id="tel1">
											<!-- <input type="text" class=" input-sso" name="contact_tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone'); ?>"> -->
											<input type="text" class=" input-sso" name="contact_tel"  placeholder="<?php echo lang('regis_contact_phone'); ?>"  inputmode="numeric" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
											<input type="hidden" name="contact_tel_country">
											<input type="hidden" name="contact_tel_code">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input director-container d-none ">
										<label class="control-label"><?php echo lang('regis_contact_director_mail'); ?> <span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="contact_director_email" placeholder="<?php echo lang('regis_contact_director_mail'); ?>">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input director-container d-none ">
										<label class="control-label"><?php echo lang('regis_contact_director_phone'); ?> <span class="text-danger"> *</span></label>
										<div id="tel4">
											<input type="text" class=" input-sso" name="contact_director_tel" maxlength="10"
											placeholder="<?php echo lang('regis_contact_director_phone'); ?>">
											<input type="hidden" name="contact_director_tel_country">
											<input type="hidden" name="contact_director_tel_code">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
								</div>
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?= lang('home_profile_address_title') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-12">
										<div class="sso-row-input">
											<div class="row">
												<div class="col col-5 col-md-5 col-lg-3">
													<input type="hidden" name="state" value="">
													<input type="hidden" name="Hcontact_address" value="">
													<input type="hidden" name="Hcontact_province" value="">
													<input type="hidden" name="Hcontact_district" value="">
													<input type="hidden" name="Hcontact_subdistrict" value="">
													<input type="hidden" name="Hcontact_postcode" value="">
													<label class="sso-radio pointer"> <?php echo lang('regis_contact_checkbox1'); ?>
														<input class="ck_address radio_new_adress6" type="radio" name="ck_address" checked value="1" placeholder="<?php echo lang('regis_contact_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col col-7 col-md-7 col-lg-8 pr-0">
													<label class="sso-radio pointer old_adress1"> <?php echo lang('regis_contact_checkbox2'); ?>
														<input class="ck_address radio_old_adress6" type="radio" name="ck_address" value="2" placeholder="<?php echo lang('regis_contact_checkbox2'); ?>">
														<span class="checkmark"></span>
													</label>
													<label class="sso-radio pointer old_adress6" style="display:none;"> <?php echo lang('regis_contact_checkbox2'); ?>
														<input class="ck_address radio_old_adress6" type="radio" name="ck_address" value="2" placeholder="<?php echo lang('regis_contact_checkbox2'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-12 find form-row w-100">
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_postcode'); ?><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_postcode_old" placeholder="<?php echo lang('regis_com_postcode'); ?>" readonly>
											<input type="text" class=" input-sso postcode" name="contact_postcode" id="noncontact_postcode" placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<div class="dropdown-menu dropdown_addr" id="dropdown_noncontact_postcode">
											</div>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>	
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_province'); ?><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_province_old" placeholder="<?php echo lang('regis_com_province'); ?>"
											readonly>
											<select class="form-control selectpicker sso-dropdown btn-province" title="<?php echo lang('regis_com_province'); ?>"
												tabindex="-98" name="contact_province" id="noncontact_province" data-live-search="false">
											</select>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<div class="txtdetail">
												<label class="control-label"><?php echo lang('regis_com_district_2'); ?></label> <span class="text-danger"> *</span></label>
											</div>
											<div class="txtdistrict1" style="display:none;">
												<label class="control-label" for=""><?php echo lang('regis_com_khet'); ?></label> <span class="text-danger"> *</span></label>
											</div>
											<input type="text" class=" input-sso" name="contact_district_old" placeholder="<?php echo lang('regis_com_district_2'); ?>"
											readonly>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_district_2'); ?>" tabindex="-98"
												name="contact_district" id="noncontact_district" data-live-search="false">
												<option value=""><?php echo lang('regis_province_recom'); ?></option>
											</select>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<div class="txtdetail">
												<label class="control-label"><?php echo lang('regis_com_subdistrict_2'); ?></label> <span class="text-danger"> *</span></label>
											</div>
											<div class="txtsubdistrict1" style="display:none;">
												<label for=""><?php echo lang('regis_com_kwang'); ?></label> <span class="text-danger"> *</span> </label>
											</div>
											<input type="text" class=" input-sso" name="contact_subdistrict_old" placeholder="<?php echo lang('regis_com_subdistrict_2'); ?>"
											readonly>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict_2'); ?>" tabindex="-98"
												name="contact_subdistrict" id="noncontact_subdistrict" data-live-search="false">
												<option value=""><?php echo lang('regis_district_recom'); ?></option>
											</select>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input mb-4">
											<label class="control-label"><?php echo lang('regis_com_address'); ?><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="contact_address_old" placeholder="<?php echo lang('regis_com_address'); ?>"
											readonly>
											<input type="text" class=" input-sso" name="contact_address" id="noncontact_address" placeholder="<?php echo lang('regis_com_address'); ?>">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
								</div>
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?= lang('regis_pass') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<label for="" class="control-label"><?php echo lang('regis_pass'); ?>&nbsp;(Password)<span class="text-danger"> *</span></label>
										<div class="warning-pass pass" id="company-password">
											<?php echo lang('regis_com_pass_recom'); ?>

										</div>
										<div class="warning-repass pass" id="company-password">
											<?php echo lang('regis_pass_nomatch'); ?>
										</div>
										<div class="pass-input-with-icon">
											<input class=" input-sso pass_input" type="text" id="noncom-password" name="password" minlength="8" required
											autocomplete="off" placeholder=" <?php echo lang('regis_pass'); ?>">
											<i id="show-pass" class="fa fa-eye-slash icon-password-reg"
											onclick="show_pass(this,'password','form_reg_noncompany')"></i>
										</div>
										<div class="col-12 minititle pl-0">
											<?php echo lang('regis_pass_recom'); ?>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="" class="control-label"><?php echo lang('regis_pass_confirm'); ?><span class="text-danger"> *</span></label>
										<div class="warning-pass repass" id="company-password">
											<?php echo lang('regis_com_pass_recom'); ?>

										</div>
										<div class="warning-repass repass" id="company-password">
											<?php echo lang('regis_pass_nomatch'); ?>
										</div>
										<div class="pass-input-with-icon">
											<input class=" input-sso pass_input" type="text" id="noncom-repassword" name="repassword" minlength="8" required
											autocomplete="off" placeholder=" <?php echo lang('regis_pass_confirm'); ?>">
											<i id="show-repass" class="fa fa-eye-slash icon-password-reg"
											onclick="show_pass(this,'repassword','form_reg_noncompany')"></i>
										</div>
									</div>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<div class="sso-row-input">
											<div class="row">
												<div class="col">
													<label class="sso-radio pointer"> <?php echo lang('regis_email_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify" data-radioemail="1" id="ck_radio_email" value="1" placeholder="<?php echo lang('regis_email_verify_checkbox1'); ?>" checked>
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col">
													<label class="sso-radio pointer"> <?php echo lang('regis_sms_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify" data-radiosms="1" id="ck_radio_sms" value="2" placeholder="<?php echo lang('regis_sms_verify_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</div>
								</div>
								<div class="form-group col-sm-6">
									<div class="btn  submitform6  btn-con-reg"
									  data-form="<?php echo $form_reg_company ?>" data-type="6">
									  <?php echo lang('regis_header'); ?></div>
								</div>
							</form>
							</div>
						</div>
						<!-- PEOPLE TAB -->
						<div class="tab-pane fade" id="pills-people" role="tabpanel" aria-labelledby="people-tab">
							<form action="#" class="form-horizontal" onsubmit="return false" id="<?php echo $form_reg_people = 'form_reg_people'; ?>" autocomplete="off">
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?= lang('regis_contact_header_type3') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<div class="sso-row-input">
											<div class="row">
												<div class="col-12">
													<label class="control-label"><?php echo lang('regis_contact_title'); ?><span class="text-danger"> *</span></label>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_contact_title'); ?>"
														tabindex="-98" id="title_3" name="title" placeholder="<?php echo lang('regis_contact_title'); ?>">
														<option value="นาย"><?php echo lang('regis_Mr'); ?></option>
														<option value="นาง"><?php echo lang('regis_Mrs'); ?></option>
														<option value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6"></div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fname'); ?><span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" id="name_user_3" name="name_user" placeholder="<?php echo lang('regis_contact_fname'); ?>">
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_midname'); ?> <small class="mitr-el"><?php echo lang('regis_not_required'); ?></small></label>
										<input type="text" class=" input-sso" id="midname_user_3" name="midname_user" placeholder="<?php echo lang('regis_contact_midname'); ?>">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_sname'); ?><span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" id="lastname_3" name="lastname" placeholder="<?php echo lang('regis_contact_sname'); ?>">
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fnameen'); ?> <span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" id="name_userEn_3" name="name_userEn" placeholder="<?php echo lang('regis_contact_fnameen'); ?>"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_midnameen'); ?> <small class="mitr-el"><?php echo lang('regis_not_required'); ?></small></label>
										<input type="text" class=" input-sso" id="midname_userEn_3" name="midname_userEn" placeholder="<?php echo lang('regis_contact_midnameen'); ?>"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_snameen'); ?><span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" id="lastnameEn_3" name="lastnameEn" placeholder="<?php echo lang('regis_contact_snameen'); ?>"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
									</div>
									<div class="form-group col-sm-6 sso-row-input people_tab_bday_container">
										<label class="control-label"><?php echo lang('regis_contact_birthday'); ?> <small class="mitr-el"><?php echo lang('regis_contact_birthday_example'); ?></small><span class="text-danger"> *</span></label>
										<input type="text" class="form-control input-sso sso-date-picker" name="birthday" id="contact_bday_contact_3" placeholder="<?php echo lang('regis_contact_birthday_placeholder'); ?>">
										<input type="text" class="form-control input-sso"  id="bday_copy_3" style="display: none;">
									</div>
									<div class="form-group col-sm-6 loader_input laser3">
										<div class="d-flex justify-content-between">
											<label class="control-label"><?php echo lang('regis_contact_id'); ?> <span class="text-danger"> *</span></label>
											<div class="col-5 warning-niti">
												<?php echo lang('regis_com_num_error'); ?>
											</div>
										</div>
										<div class="regis-com-check">
											<input type="text" class=" input-sso" name="cid" id="user_id" maxlength="13" placeholder="<?php echo lang('regis_contact_id'); ?>">
											<button class="btn btn-primary ck-citizen-btn"  type="button"><?php echo lang('regis_check_btn') ?></button> 
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_mail'); ?> <small class="mitr-el"><?php echo lang('regis_contact_mail_example') ?></small><span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="email" placeholder="<?php echo lang('regis_contact_mail'); ?>">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_phone'); ?> <small class="mitr-el"><?php echo lang('regis_contact_phone_example') ?></small><span class="text-danger"> *</span></label>
										<div id="tel3">
											<input type="text" class=" input-sso" name="tel" placeholder="<?php echo lang('regis_contact_phone'); ?>"  inputmode="numeric" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
											<input type="hidden" name="tel_country">
											<input type="hidden" name="tel_code">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
								</div>
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?= lang('regis_contact_header') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-12 find form-row w-100">
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_postcode'); ?><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso postcode" name="postcode" placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<div class="dropdown-menu" id="dropdown_postcode" >
											</div>
										</div>	
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_province'); ?><span class="text-danger"> *</span></label>
											<select class="form-control selectpicker sso-dropdown btn-province" title="<?php echo lang('regis_com_province'); ?>"
												tabindex="-98" name="provinceTh" data-live-search="false">
											</select>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<div class="txtdetail txtdistrict">
												<label class="control-label"><?php echo lang('regis_com_district_2'); ?></label><span class="text-danger"> *</span></label>
											</div>
											<div class="txtdistrict1" style="display:none;">
												<label for=""><?php echo lang('regis_com_khet'); ?></label><span class="text-danger"> *</span></label>
											</div>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_district_2'); ?>" tabindex="-98"
												name="districtTh" data-live-search="false">
												<option value=""><?php echo lang('regis_province_recom'); ?></option>
											</select>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<div class="txtdetail txtsubdistrict">
												<label class="control-label"><?php echo lang('regis_com_subdistrict_2'); ?></label><span class="text-danger"> *</span></label>
											</div>
											<div class="txtsubdistrict1" style="display:none;">
												<label for=""><?php echo lang('regis_com_kwang'); ?></label><span class="text-danger"> *</span> </label>
											</div>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict_2'); ?>" tabindex="-98"
												name="subdistrictTh" data-live-search="false">
												<option value=""><?php echo lang('regis_district_recom'); ?></option>
											</select>
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input mb-4">
											<label class="control-label"><?php echo lang('regis_com_address'); ?><span class="text-danger"> *</span></label>
											<input type="text" class=" input-sso" name="addressTh" placeholder="<?php echo lang('regis_com_address'); ?>">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
								</div>
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span><?= lang('regis_pass') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<label for="" class="control-label"><?php echo lang('regis_pass'); ?>&nbsp;(Password)<span class="text-danger"> *</span></label>
										<div class="warning-pass" id="company-password">
											<?php echo lang('regis_com_pass_recom'); ?>
										</div>
										<div class="pass-input-with-icon">
											<input class=" input-sso pass_input" type="text" name="password" id="password_nomal" minlength="8" required
											autocomplete="off" placeholder=" <?php echo lang('regis_pass'); ?>">
											<i id="show-pass" class="fa fa-eye-slash icon-password-reg"
											onclick="show_pass(this,'password','form_reg_people')"></i>
										</div>
										<div class="col-12 minititle">
											<?php echo lang('regis_pass_recom'); ?>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="" class="control-label"><?php echo lang('regis_pass_confirm'); ?><span class="text-danger"> *</span></label>
										<div class="warning-repass" id="company-password">
											<?php echo lang('regis_pass_nomatch'); ?>
										</div>
										<div class="pass-input-with-icon">
											<input class=" input-sso pass_input" type="text" name="repassword" id="repassword_nomal" minlength="8" required
											autocomplete="off" placeholder=" <?php echo lang('regis_pass_confirm'); ?>">
											<i id="show-repass" class="fa fa-eye-slash icon-password-reg"
											onclick="show_pass(this,'repassword','form_reg_people')"></i>
										</div>
									</div>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<div class="sso-row-input">
											<div class="row">
												<div class="col">
													<label class="sso-radio pointer"> <?php echo lang('regis_email_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify_normal" id="ck_normal_radio_email" checked value="email" placeholder="<?php echo lang('regis_email_verify_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col">
													<label class="sso-radio pointer"> <?php echo lang('regis_sms_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify_normal" id="ck_normal_radio_sms" value="sms" placeholder="<?php echo lang('regis_sms_verify_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</div>
								</div>
								<div class="form-group col-sm-6">
									<div class="btn  submitform3  btn-con-reg"
									  data-form="<?php echo $form_reg_people ?>" data-type="3">
									  <?php echo lang('regis_header'); ?></div>
								</div>
							</form>
						</div>
						</div>
						<!-- NON-THAI TAB -->
						<div class="tab-pane fade" id="non-thai-tabs" role="tabpanel" aria-labelledby="non-thai-tab">
							<form action="#" class="form-horizontal" onsubmit="return false" id="<?php echo $form_reg_foreigner = 'form_reg_foreigner'; ?>" autocomplete="off">
								<!-- radiobox -->
								<div class="row sso-radio-container">
									<div class="col d-flex">
										<label class="sso-radio pointer text-white">
											<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
												Company
											</div>
											<input class="ck_address ck_fo_default" placeholder="Corporate ID" type="radio" id="data_type2"  name="data_type" value="2" onclick="radio_foreigner(2);storetype(2);">
											<span class="checkmark"></span>
										</label>
									</div>
									<div class="col d-flex">
										<label class="sso-radio pointer text-white">
											<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
												Foreigner
											</div>
											<input class="ck_address" placeholder="Passport ID" type="radio" id="data_type4"  name="data_type" value="4" onclick="radio_foreigner(4);storetype(4);">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
								<!-- endradiobox -->
								<div id="company-address"  style="flex-direction: column;">
									<!-- Company Infomation-header -->
									<div class="regis-header my-4">
										<h4 class="mitr-r"><span>Company Infomation</span></h4>
									</div>
									<!-- end Company Infomation-header -->
									<!-- Company Infomation -->
									<div class="form-row sso-input">
										<div class="form-group col-sm-6 sso-row-input" id="corporateid" style="flex-direction: column;">
											<label class="control-label">Company ID<span class="text-danger"> *</label>
											<input input class=" input-sso" type="text" name="corporate_id" id="user_id" autocomplete="off" maxlength="13" placeholder="Company ID"   oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
											<div class="col-12 minititle">
											  You can use letters, numbers
											</div>
										</div>

										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label">Company Name<span class="text-danger"> *</label>
											<input input class=" input-sso" type="text" name="fo_corporate_name" placeholder="Company Name"  oninput="this.value = this.value.replace(/[^A-Za-z0-9\s/!@#$%^&*()_+<>?,.\\-]+/g, '');">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label">Country<span class="text-danger"> *</label>
											<select class="form-control selectpicker sso-dropdown" title="Country" id="country" tabindex="-98" name="fo_country_name">
											  <!-- <option class="country_name">Country</option> -->
											</select>
										</div>
										<div class="form-group col-sm-6 sso-row-input ">
											<label class="control-label">Company Address<span class="text-danger"> *</label>
											<input input class=" input-sso" type="text" name="fo_address" placeholder="Company address"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
									<!-- end Company Infomation -->
								</div>
								<!-- niti-thai-header -->
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span>Personal Information</span></h4>
								</div>
								<!-- end niti-thai-header -->
								<div class="form-row sso-input">
									<div class="form-group col-sm-6 sso-row-input" id="passportid" style="flex-direction: column;">
										<label class="control-label">Passport ID<span class="text-danger"> *</label>
										<input class=" input-sso" type="text" name="passport_id" id="user_id" autocomplete="off" maxlength="13" placeholder="Passport ID" oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');validate(this);"  required>
										<div class="col-12 minititle">
										  You can use letters, numbers
										</div>
									</div>
									<div class="col-sm-6" id="fo_space"></div>
									<div class="form-group col-sm-6">
										<div class="sso-row-input">
											<div class="row">
												<div class="col-12">
													<label class="control-label">Title Name <span class="text-danger"> *</span></label>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<select class="form-control selectpicker sso-dropdown" title="Title name"
														tabindex="-98" name="fo_title" placeholder="<?php echo lang('regis_contact_title'); ?>">
														<option value="Mr.">Mr.</option>
														<option value="Mrs.">Mrs.</option>
														<option value="Miss">Miss</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6"></div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label">First Name<span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="fo_name" placeholder="First Name"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label">Middle Name (Optional)</label>
										<input type="text" class=" input-sso" name="fo_midname" placeholder="Middle Name (Optional)"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label">Last Name<span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="fo_lastname" placeholder="Last Name "  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input" id="passport_county">
										<label class="control-label">Country<span class="text-danger"> *</span></label>
										<select class="form-control selectpicker sso-dropdown" title="Country" id="pp_country" tabindex="-98" name="passport_county_name">
										  <option class="country_name">Country</option>
										</select>
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input" id="passport_fo_address">
										<label class="control-label">Address<span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="passport_fo_address"  placeholder="Address"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label">Email (Used for sending verification emails)<span class="text-danger"> *</span></label>
										<input type="text" class=" input-sso" name="fo_email" placeholder="Email"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9/!@#$%^&*()_+<>?.',-]+/g, '');">
										<div class="err-msg">
											<small class="d-none input-sso-error-txt mitr-l"></small>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label">Tel.<span class="text-danger"> *</span></label>
										<div id="tel2">
											<input type="text" class=" input-sso" name="fo_tel"  inputmode="numeric" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Tel" >
											<input type="hidden" name="fo_tel_country">
											<input type="hidden" name="fo_tel_code">
											<div class="err-msg">
												<small class="d-none input-sso-error-txt mitr-l"></small>
											</div>
										</div>
									</div>
								</div>
								<div class="regis-header my-4">
									<h4 class="mitr-r"><span>Password</span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<label for="" class="control-label">Password<span class="text-danger"> *</span></label>
										<div class="warning-pass" id="pass_nonthai">
											Use 8 or more characters
										</div>
										<div class="pass-input-with-icon">
											<input class=" input-sso pass_input" type="text" name="password" id="password_nonthai" minlength="8" required
											autocomplete="off" placeholder="Password">
											<i id="show-pass" class="fa fa-eye-slash icon-password-reg"
											onclick="show_pass(this,'password','form_reg_foreigner')"></i>
										</div>
										<div class="col-12 minititle">
											Passwords must be at least 8 characters long and should contain uppercase English letters (A-Z), lowercase English letters (a-z), numbers (1-9), and symbols (e.g. #, $, &). etc.)
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="" class="control-label">Re-enter Password<span class="text-danger"> *</span></label>
										<div class="warning-repass" id="company-password">
											<?php echo lang('regis_pass_nomatch'); ?>
										</div>
										<div class="pass-input-with-icon">
											<input class=" input-sso pass_input" type="text" name="repassword" id="repassword_nonthai" minlength="8" required
											autocomplete="off" placeholder="Re-enter Password">
											<i id="show-repass" class="fa fa-eye-slash icon-password-reg"
											onclick="show_pass(this,'repassword','form_reg_foreigner')"></i>
										</div>
									</div>
								</div>
								<div class="form-row sso-input">
								<div class="form-group col-sm-6">
									<div class="btn  submitform4  btn-con-reg"
									  data-form="<?php echo $form_reg_foreigner ?>" data-type="4">
									  Register</div>
								</div>
							</form>
						</div>
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
<!-- laser code modal -->
<div class="modal sso-modal fade shadow" id="laser_modal" tabindex="-1" role="dialog" aria-hidden="true">
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
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_id_card') ?>&nbsp;:</td>
                <td id="laser-modal-citizenid" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="cid" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_fname') ?>&nbsp;:</td>
                <td id="laser-modal-fname" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="fname" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_lname') ?>&nbsp;:</td>
                <td id="laser-modal-lname" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="lname" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_birthday') ?>&nbsp;:</td>
                <td id="laser-modal-bday" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="bday" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_code') ?>&nbsp;:</td>
                <td>
                  <input type="text" name="laser_id" id="laser_id" class="input-sso" placeholder="JC0-0000000-00" maxlength="14">
                  <div class="minititle mitr-l py-2"><?php echo lang('modal_laser_code_input') ?></div>
                  <img src="<?php echo BASE_PATH; ?>asset/img/laser-card.png" class="mb-2" alt="laser-card">
                  <li class="mitr-l _f14"><?php echo lang('modal_laser_example1') ?></li>
                  <li class="mitr-l _f14"><?php echo lang('modal_laser_example2') ?></li>
                </td>
              </tr>
              <tr>
              	<td class="laser-warning-container" colspan="2">
              		<p class="mb-0 mitr-r _f14">
              			<?php echo lang('modal_laser_fyi1') ?><span class="mitr-l"><?php echo lang('modal_laser_fyi2') ?></span>
              		</p>
              	</td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center" style="border-top: 1px solid #8A919E;">
        <button type="button" class="btn ck-contact-laser-btn-cancel" data-dismiss="modal"><?php echo lang('modal_laser_cancel') ?></button>
        <button type="button" class="btn ck-citizen-laser-btn"><?php echo lang('modal_laser_verify') ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal sso-modal fade shadow" id="contact_laser_modal1" data-ck="contact_1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 8px !important;">
      <div class="modal-header " style="border-bottom: 1px solid #8A919E;">
        <h5 class="modal-title mitr-r" style="font-size: 18px;"><?php echo lang('laser_modal_title') ?></h5>
        <button type="button" class="close laser-modal-close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body sso-input">
        <form onsubmit="return false" id="form_laser_company_contact_1">
          <div class="error-log text-danger d-flex justify-content-center w-100"></div>
          <table class="table table-borderless" style="table-layout: fixed;width: 100%;">
            <thead>
              <th width="30%"></th>
              <th width="50%"></th>
            </thead>
            <tbody>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_id_card') ?>&nbsp;:</td>
                <td id="contact-laser-modal-citizenid_contact_1" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="cid" id="cid_contact_1" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_fname') ?>&nbsp;:</td>
                <td id="contact-laser-modal-fname_contact_1" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="fname" id="fname_contact_1" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_lname') ?>&nbsp;:</td>
                <td id="contact-laser-modal-lname_contact_1" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="lname" id="lname_contact_1" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_birthday') ?>&nbsp;:</td>
                <td id="contact-laser-modal-bday_contact_1" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="bday" id="bday_contact_1" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_code') ?>&nbsp;:</td>
                <td>
                  <input type="text" name="laser_id" id="laser1_id_contact_1" class="input-sso" placeholder="JC0-0000000-00" maxlength="14">
                  <div class="minititle mitr-l py-2"><?php echo lang('modal_laser_code_input') ?></div>
                  <img src="<?php echo BASE_PATH; ?>asset/img/laser-card.png" class="mb-2" alt="laser-card">
                  <li class="mitr-l _f14"><?php echo lang('modal_laser_example1') ?></li>
                  <li class="mitr-l _f14"><?php echo lang('modal_laser_example2') ?></li>
                </td>
              </tr>
              <tr>
              	<td class="laser-warning-container" colspan="2">
              		<p class="mb-0 mitr-r _f14">
              			<?php echo lang('modal_laser_fyi1') ?><span class="mitr-l"><?php echo lang('modal_laser_fyi2') ?></span>
              		</p>
              	</td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center" style="border-top: 1px solid #8A919E;">
        <button type="button" class="btn ck-contact-laser-btn-cancel" data-dismiss="modal"><?php echo lang('modal_laser_cancel') ?></button>
        <button type="button" class="btn ck-contact-laser-btn contact_1"><?php echo lang('modal_laser_verify') ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal sso-modal fade shadow" id="contact_laser_modal6" data-ck="contact_6" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 8px !important;">
      <div class="modal-header " style="border-bottom: 1px solid #8A919E;">
        <h5 class="modal-title mitr-r" style="font-size: 18px;"><?php echo lang('laser_modal_title') ?></h5>
        <button type="button" class="close laser-modal-close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body sso-input">
        <form onsubmit="return false" id="form_laser_company_contact_6">
          <div class="error-log text-danger d-flex justify-content-center w-100"></div>
          <table class="table table-borderless" style="table-layout: fixed;width: 100%;">
            <thead>
              <th width="30%"></th>
              <th width="50%"></th>
            </thead>
            <tbody>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_id_card') ?>&nbsp;:</td>
                <td id="contact-laser-modal-citizenid_contact_6" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="cid" id="cid_contact_6" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_fname') ?>&nbsp;:</td>
                <td id="contact-laser-modal-fname_contact_6" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="fname" id="fname_contact_6" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_lname') ?>&nbsp;:</td>
                <td id="contact-laser-modal-lname_contact_6" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="lname" id="lname_contact_6" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_birthday') ?>&nbsp;:</td>
                <td id="contact-laser-modal-bday_contact_6" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="bday" id="bday_contact_6" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style=""><?php echo lang('modal_laser_code') ?>&nbsp;:</td>
                <td>
                  <input type="text" name="laser_id" id="laser1_id_contact_6" class="input-sso" placeholder="JC0-0000000-00" maxlength="14">
                  <div class="minititle mitr-l py-2"><?php echo lang('modal_laser_code_input') ?></div>
                  <img src="<?php echo BASE_PATH; ?>asset/img/laser-card.png" class="mb-2" alt="laser-card">
                  <li class="mitr-l _f14"><?php echo lang('modal_laser_example1') ?></li>
                  <li class="mitr-l _f14"><?php echo lang('modal_laser_example2') ?></li>
                </td>
              </tr>
              <tr>
              	<td class="laser-warning-container" colspan="2">
              		<p class="mb-0 mitr-r _f14">
              			<?php echo lang('modal_laser_fyi1') ?><span class="mitr-l"><?php echo lang('modal_laser_fyi2') ?></span>
              		</p>
              	</td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center" style="border-top: 1px solid #8A919E;">
        <button type="button" class="btn ck-contact-laser-btn-cancel" data-dismiss="modal"><?php echo lang('modal_laser_cancel') ?></button>
        <button type="button" class="btn ck-contact-laser-btn contact_6"><?php echo lang('modal_laser_verify') ?></button>
      </div>
    </div>
  </div>
</div>
<!-- <div id="tel2" class="d-none">
	<input type="text" class=" input-sso" name="fo_tel" maxlength="10" placeholder="Tel">
	<input type="hidden" name="fo_tel_country">
	<input type="hidden" name="fo_tel_code">
</div>
<div id="tel3" class="d-none">
	<input type="text" class=" input-sso" name="tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone');?>">
	<input type="hidden" name="tel_country">
	<input type="hidden" name="tel_code">
</div> -->
<div class="" id="overlay-fullsrc">
  <div class=" box-policy">
    <nav class="navbar navbar-light ">
      <div class="navbar-brand pointer">
        <div class=" pointer closs-overlay">
          <img src="<?php echo BASE_PATH; ?>asset/img/chevron-left-material@3x.png" alt="" style="height: 22px;">
          เงื่อนไขการบริการ และนโยบายข้อมูลส่วนบุคคล
        </div>
      </div>
    </nav>
    <p>
      รายละเอียดประเภทสมาชิก
      คุณสมบัติ
      เป็นนิติบุคคลจดทะเบียนกับกระทรวงพาณิชย์
      จดทะเบียนภาษีนิติบุคคล
      จดทะเบียนโรงงานหรือมีโรงงานเครือข่ายของตนเอง
      มีประสบการณ์การส่งออกแล้ว
      สิทธิประโยชน์
      มีรายชื่ออยู่บนเว็บไซต์กรมส่งเสริมการค้าระหว่างประเทศ
      ได้รับสิทธิ์เข้าสู่ฐานข้อมูลกรมฯ เพื่อค้นหารายชื่อผู้นำเข้า หรือแก้ไขข้อมูลบริษัท
      และสมัครเข้าร่วมกิจกรรมทางออนไลน์
      มีสิทธิสมัครเข้าร่วมกิจกรรมกับกรมฯ ที่จัดทั้งในและต่างประเทศ </p>

    <p style="margin-bottom: 0;">เงื่อนไขและกฎระเบียบการสมัครสมาชิก</p>
    <p style="margin-bottom: 0;">1.การพิจารณาเป็นอำนาจของกรมส่งเสริมการค้า ระหว่างประเทศ</p>
    <p style="margin-bottom: 0;">2.ผู้สมัครต้องกรอกข้อมูลการสมัครให้ถูกต้องและ ครบถ้วน</p>
    <p style="margin-bottom: 0;">3.ต้องผ่านการตรวจสอบ ณ สำนักงาน/โรงงาน หรือเรียกดูสินค้า ว่าผู้ประกอบการและสินค้ามีตัว
      ตนจริง ตามนโยบายของกรม</p>
    <p style="margin-bottom: 0;">4.กรมจะพิจารณาอนุมัติการเป็นสมาชิก หรือเข้าร่วม โครงการ/กิจกรรม จากข้อมูลและเอกสารแนบใน
      ระบบ ของผู้สมัครเท่านั้น</p>
    <p style="margin-bottom: 0;">5.การแนบเอกสารในระบบทุกฉบับจะต้องประทับตรา บริษัท และผู้มีอำนาจลงนาม</p>
    <p style="margin-bottom: 0;">6.เอกสารแนบในระบบจะต้องครบถ้วนสมบรูณ์ หาก มีความผิดพลาดหรือต้องแก้ไขหรือขอเอกสารเพิ่ม
      เติม กรมจะแจ้งให้ผู้สมัครทราบและผู้สมัครต้องรีบ ดำเนินการตามที่กรมแจ้ง</p>
    <p style="margin-bottom: 0;">7.ในกรณีบริษัทดำเนินการส่งออกแล้ว และต้องการ ปรับสถานะจาก Pre-EL เป็น EL บริษัทต้องส่ง
      หนังสือขอปรับสถานะพร้อมแนบสำเนาหลักฐาน การส่งออก เช่น L/C หรือ B/L หรือในกรณีที่
      ลูกค้าต่างประเทศจัดการขนส่งสินค้าเอง กรุณา แนบใบเสร็จสินค้าที่มีชื่อลูกค้าในต่างประเทศ เพื่อ
      ให้กรมพิจารณาปรับสถานะ</p>
    <p style="margin-bottom: 0;">8.หากมีการแก้ไขข้อมูลผู้สมัครจะต้องดำเนินการ แก้ไขผ่านระบบนี้เท่านั้น
      เว้นแต่มีกรณีที่ผู้สมัครไม่ สามารถแก้ไขได้ด้วยตนเอง</p>
    <p style="margin-bottom: 0;">9.ผู้สมัครยอมรับว่าข้อมูลในการสมัครผ่านระบบนี้ เป็นความจริงทุกประการ</p>
    <p style="margin-bottom: 0;">10.หากภายหลังพบว่าข้อมูลของผู้สมัครเป็นเท็จหรือ ไม่ตรงตามเงื่อนไข
      กรมจะถือว่าการสมัครครั้งนี้ เป็นโมฆะ</p>
    <p style="margin-bottom: 0;">11.กรมฯ ขอสงวนสิทธิการเปลี่ยนแปลงเงื่อนไขและ สิทธิ์ประโยชน์ต่างๆ ในการสมัครสมาชิกนี้
      โดยมิ ต้องแจ้งให้ทราบล่วงหน้า</p>
    <div class="col-12">
      <div class="row">

        <label class="sso-ckb m-0-auto mb-3"> ยอมรับเงื่อนไข
          <input type="checkbox" id=ck_policy>
          <span class="box-ckb"></span>

        </label>
      </div>
      <div class="row">
        <div class="btn mt-4 w-50 btn-con-reg" id="con_policy">ตกลง</div>
      </div>
    </div>

  </div>
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
      
    });

    $(".ck_default").click();
    // $("#company-tab").click();
    document.querySelector(".sso-date-picker").removeAttribute("readonly");
	function getEra(year) {
		const currentDate = new Date();
		const years = currentDate.getFullYear()+500;
		if (year >= years) {
			return 'พ.ศ.';
		} else {
			return 'ค.ศ.';
		}
	}
	// $(".sso-date-picker").on("keypress", function (e) {
	// 	e.preventDefault();
	// });

	$('.nationality_thai_bday_container').on('keypress click', 'input[type="text"].sso-date-picker', function(e) {
			if(e.type === 'keypress'){
				e.preventDefault();
			}else{
				$('.flatpickr-calendar.open .numInput.cur-year').attr("disabled", true);
				let year = 	$('.flatpickr-calendar.open .numInput.cur-year').val();
				let thaiyear = '';
				const currentDate = new Date();
				const ck_year = currentDate.getFullYear();
				let era = getEra(year);
				if(era === 'พ.ศ.'){
					thaiyear = parseInt(year) -543;
					era = getEra(thaiyear);
				}else{
					thaiyear = year ;
				}
				if (e.type === 'click') {
					if(era === 'ค.ศ.'){
						$('.flatpickr-calendar.open .numInput.cur-year').val(parseInt(thaiyear) + 543);
					}
				}
			}
	});
	$('.non_company_tab_bday_container').on('keypress click', 'input[type="text"].sso-date-picker', function(e) {
		if(e.type === 'keypress'){
				e.preventDefault();
		}else{
			$('.flatpickr-calendar.open .numInput.cur-year').attr("disabled", true);
			let year = 	$('.flatpickr-calendar.open .numInput.cur-year').val();
			let thaiyear = '';
			const currentDate = new Date();
			const ck_year = currentDate.getFullYear();
			let era = getEra(year);
			if(era === 'พ.ศ.'){
				thaiyear = parseInt(year) -543;
				era = getEra(thaiyear);
			}else{
				thaiyear = year ;
			}
			if (e.type === 'click') {
				if(era === 'ค.ศ.'){
					$('.flatpickr-calendar.open .numInput.cur-year').val(parseInt(thaiyear) + 543);
				}
			}
		}
	});
	$('.people_tab_bday_container').on('keypress click', 'input[type="text"].sso-date-picker', function(e) {
		if(e.type === 'keypress'){
				e.preventDefault();
		}else{
			$('.flatpickr-calendar.open .numInput.cur-year').attr("disabled", true);
			let year = 	$('.flatpickr-calendar.open .numInput.cur-year').val();
			let thaiyear = '';
			const currentDate = new Date();
			const ck_year = currentDate.getFullYear();
			let era = getEra(year);
			if(era === 'พ.ศ.'){
				thaiyear = parseInt(year) -543;
				era = getEra(thaiyear);
			}else{
				thaiyear = year ;
			}
			if (e.type === 'click') {
				if(era === 'ค.ศ.'){
					$('.flatpickr-calendar.open .numInput.cur-year').val(parseInt(thaiyear) + 543);
				}
			}
		}
	});
	$('#bday_copy_1').on('keypress click', function(e) {
		if(e.type === 'keypress'){
				e.preventDefault();
		}else{
			$('.flatpickr-calendar.flatpickr-1').addClass('open');
			let year = 	$('.flatpickr-calendar.open .numInput.cur-year').val();
			let thaiyear = '';
			const currentDate = new Date();
			const ck_year = currentDate.getFullYear();
			let era = getEra(year);
			if(era === 'พ.ศ.'){
				thaiyear = parseInt(year) -543;
				era = getEra(thaiyear);
			}else{
				thaiyear = year ;
			}
			if (e.type === 'click') {
				if(era === 'ค.ศ.'){
					$('.flatpickr-calendar.open .numInput.cur-year').val(parseInt(thaiyear) + 543);
				}
			}
		}
	});
	$('#bday_copy_3').on('keypress click', function(e) {
		if(e.type === 'keypress'){
				e.preventDefault();
		}else{
			$('.flatpickr-calendar.flatpickr-3').addClass('open');
			let year = 	$('.flatpickr-calendar.open .numInput.cur-year').val();
			let thaiyear = '';
			const currentDate = new Date();
			const ck_year = currentDate.getFullYear();
			let era = getEra(year);
			if(era === 'พ.ศ.'){
				thaiyear = parseInt(year) -543;
				era = getEra(thaiyear);
			}else{
				thaiyear = year ;
			}
			if (e.type === 'click') {
				if(era === 'ค.ศ.'){
					$('.flatpickr-calendar.open .numInput.cur-year').val(parseInt(thaiyear) + 543);
				}
			}
		}
	});
	$('#bday_copy_6').on('keypress click', function(e) {
		if(e.type === 'keypress'){
				e.preventDefault();
		}else{
			$('.flatpickr-calendar.flatpickr-6').addClass('open');
			let year = 	$('.flatpickr-calendar.open .numInput.cur-year').val();
			let thaiyear = '';
			const currentDate = new Date();
			const ck_year = currentDate.getFullYear();
			let era = getEra(year);
			if(era === 'พ.ศ.'){
				thaiyear = parseInt(year) -543;
				era = getEra(thaiyear);
			}else{
				thaiyear = year ;
			}
			if (e.type === 'click') {
				if(era === 'ค.ศ.'){
					$('.flatpickr-calendar.open .numInput.cur-year').val(parseInt(thaiyear) + 543);
				}
			}
		}
	});


	$(document).on('change click', '.flatpickr-calendar.open .arrowUp,.flatpickr-calendar.open .arrowDown,.flatpickr-calendar.open .flatpickr-prev-month,.flatpickr-calendar.open .flatpickr-next-month,.flatpickr-calendar.open .flatpickr-monthDropdown-months', function(e) {
		setTimeout(function() {
			let year = 	$('.flatpickr-calendar.open .numInput.cur-year').val();
			let thaiyears = '';
			const currentDate = new Date();
			const ck_year = currentDate.getFullYear();
			var era = getEra(year);
				if(era === 'พ.ศ.'){
					thaiyears = parseInt(year) -543;
					era = getEra(thaiyears);
				}else{
					thaiyears = year ;
				}
				if (era === 'ค.ศ.'){
					let thaiYear = parseInt(thaiyears) + 543;
					$('.flatpickr-calendar.open .numInput.cur-year').val(thaiYear);
				}else if (era === 'ค.ศ.' && event.type === 'change'){
					$('.flatpickr-calendar.open .numInput.cur-year').val(parseInt(thaiyear) + 543);
				}
		}, 0);
	});

    // const togglePassword = document.querySelector("#show-pass"); flatpickr-monthDropdown-months
    // const togglePasswordre = document.querySelector("#show-repass");
    // const password = document.querySelector("#password");
    // const repassword = document.querySelector("#repassword");

    // togglePassword.addEventListener("click", function () {
    //     // toggle the type attribute
    //     const type = password.getAttribute("type") === "password" ? "text" : "password";
        
    //     password.setAttribute("type", type);
        
    //     // toggle the icon
    //     this.classList.toggle("bi-eye");
    // });

    // togglePasswordre.addEventListener("click", function () {
    //     // toggle the type attribute
    //     const type = repassword.getAttribute("type") === "password" ? "text" : "password";
    //     repassword.setAttribute("type", type);
        
    //     // toggle the icon
    //     this.classList.toggle("bi-eye");
    // });

    // prevent form submit
    const form = document.querySelector("form");
    form.addEventListener('submit', function (e) {
        e.preventDefault();
    });
  })

  function storetype(type) {
		var contact_3 = document.getElementById("contact_bday_contact_3");
        var contact_1 = document.getElementById("contact_bday_contact_1");
		var contact_6 = document.getElementById("contact_bday_contact_6");
		var id = 0;
		var data = 0;
  	if (type === 1) {
  		formtype = 'form_reg_company';
  		formtab = 'company-tab';
        contact_1.style.display = "flex";
        contact_3.style.display = "none";
        contact_6.style.display = "none";
		data = 	$('.nationality_thai_bday_container input[type="text"].sso-date-picker');
		id = contact_1;
  	} else if (type === 2) {
  		formtype = 'form_reg_foreigner';
  		formtab = 'non-thai-tab';
  	} else if (type === 3) {
  		formtype = 'form_reg_people';
  		formtab = 'people-tab';
		contact_1.style.display = "none";
        contact_3.style.display = "flex";
        contact_6.style.display = "none";
		id = contact_3;
		data = 	$('.people_tab_bday_container input[type="text"].sso-date-picker');
  	} else if (type === 4) {
  		formtype = 'form_reg_foreigner';
  		formtab = 'non-thai-tab';
  	} else if (type === 6) {
  		formtype = 'form_reg_noncompany';
  		formtab = 'non-company-tab';
		contact_1.style.display = "none";
        contact_3.style.display = "none";
        contact_6.style.display = "flex";
		id = contact_6;
		data = 	$('.non_company_tab_bday_container input[type="text"].sso-date-picker');
  	}
  	sessionStorage.setItem("formtype", JSON.stringify(formtype));
  	sessionStorage.setItem("formtab", JSON.stringify(formtab));
	// location.reload(); flatpickr-close-1
	if(id != 0){
		id.flatpickr({
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "d/m/Y",
            locale: "th",
            allowInput: true,
            disableMobile: true,
            onReady: function (selectedDates, dateStr, instance) {
                $(".sso-date-picker").on("change", function (e) {
                    if (e.type === 'change') {
                        var selectedDate = instance.selectedDates[0];
                        if (selectedDate) {
                            var year = selectedDate.getFullYear();
                            var month = (selectedDate.getMonth() + 1).toString().padStart(2, "0");
                            var day = selectedDate.getDate().toString().padStart(2, "0");
							$('.modal-spin').modal('show'); 
							const currentDate = new Date();
							const years = currentDate.getFullYear()+500;
							var thaiyear = 0;
							if (year >= years) {
								thaiyear = parseInt(year) - 543 + 543;
							} else {
								thaiyear = parseInt(year) + 543;
							}
                            var thaiDate = day + "/" + month + "/" + thaiyear;
							if (type === 1) {
								$('#bday_copy_1').val(thaiDate); 
								$('.nationality_thai_bday_container input[type="text"].sso-date-picker').css('display', 'none');
								$('#bday_copy_1').css('display', 'block');
								$('#bday_copy_3').css('display', 'none');
								$('#bday_copy_6').css('display', 'none');
								$('.modal-spin').modal('hide');
							}  else if (type === 3) {
								$('#bday_copy_3').val(thaiDate); 
								$('.people_tab_bday_container input[type="text"].sso-date-picker').css('display', 'none');
								$('#bday_copy_3').css('display', 'block');
								$('#bday_copy_1').css('display', 'none');
								// contact_3.style.display = "none";
								$('#bday_copy_6').css('display', 'none');
								$('.modal-spin').modal('hide');
							} else if (type === 6) {
								$('#bday_copy_6').val(thaiDate); 
								$('.non_company_tab_bday_container input[type="text"].sso-date-picker').css('display', 'none');
								$('#bday_copy_6').css('display', 'block');
								$('#bday_copy_1').css('display', 'none');
								$('#bday_copy_3').css('display', 'none');
								$('.modal-spin').modal('hide');
							}							
                        }
                     }
                 });
             }
        });
		if (type === 1) {
			$('.flatpickr-calendar:not(.flatpickr-3):not(.flatpickr-6)').addClass('flatpickr-1');
		}  else if (type === 3) {
			$('.flatpickr-calendar:not(.flatpickr-1):not(.flatpickr-6)').addClass('flatpickr-3');
			let val = $('#bday_copy_3').val();
			if(val != ''){
				$('.people_tab_bday_container input[type="text"].sso-date-picker').css('display', 'none');
				$('#bday_copy_3').css('display', 'block');
			}
		} else if (type === 6) {
			$('.flatpickr-calendar:not(.flatpickr-1):not(.flatpickr-3)').addClass('flatpickr-6');
		}	
	 }
  }


  var inputValues = {};

  function storeInputValues(lang) {

  	sessionStorage.setItem("inputValues", null);
  	let formId = JSON.parse(sessionStorage.getItem("formtype"));
  	if (formId === null) {
  		formtype = 'form_reg_company';
  		sessionStorage.setItem("formtype", JSON.stringify(formtype));
  		storeInputValues(lang);
  	}
    var form = document.getElementById(formId);
    if (!form) return;
    var inputs = form.querySelectorAll("input, select, textarea");
    inputs.forEach(function(input) {
      if (input.type === "radio" || input.type === "checkbox") {
        inputValues[formId + '_' + input.name + '_' + input.value] = input.checked;
      } else {
        inputValues[formId + '_' + input.name] = input.value;
      }
    });

    sessionStorage.setItem("inputValues", JSON.stringify(inputValues));

    $.ajax({
      url: BASE_URL + _INDEX + "auth/lang_regis/" + lang,
      method: "post",
      async: true,
      success: function(response) {

        location.reload();
      }
    });
  }

  window.addEventListener("load", function() {
    var storedInputValues = JSON.parse(sessionStorage.getItem("inputValues"));
    var tab = JSON.parse(sessionStorage.getItem("formtab"));
    if (storedInputValues) {
      inputValues = storedInputValues;
    }

    var forms = document.querySelectorAll("form");
    if (tab === null) {
    	tab = 'company-tab';
    	sessionStorage.setItem("formtab", JSON.stringify(tab));
    }
    $('#'+tab).click();
    forms.forEach(function(form) {
      var formId = form.getAttribute("id");
      if (!formId) return;
      var inputs = form.querySelectorAll("input, select, textarea");
      inputs.forEach(function(input) {
        if (input.type === "radio" || input.type === "checkbox") {
        	var inputId = formId + '_' + input.name + '_' + input.value;
        } else {
        	var inputId = formId + '_' + input.name;
        }
        if (inputValues[inputId] !== undefined) {
          if (input.type === "radio" || input.type === "checkbox") {
            input.checked = inputValues[inputId];
          } else {
            input.value = inputValues[inputId];
          }
        }
      });
      sessionStorage.setItem("inputValues", null);
      // sessionStorage.setItem("formtab", null);
    });

    let ck_nationality_type = 0;
    if( $('#ck_director_thai').is(':checked') ){
        ck_nationality_type = 1;
    }

    if( $('#ck_national_foreigner').is(':checked') ){
        ck_nationality_type = 2;
    }   

    if(ck_nationality_type == 1){
        $('.nationality_thai_container').removeClass('d-none');
        $('.nationality_thai_name_container').removeClass('d-none');
        $('.nationality_thai_midname_container').removeClass('d-none');
        $('.nationality_thai_sname_container').removeClass('d-none');
        $('.nationality_thai_bday_container').removeClass('d-none');
        $('.nationality_foreigner_container').addClass('d-none');
    } else if(ck_nationality_type == 2) {
        $('.nationality_thai_container').addClass('d-none');
        $('.nationality_thai_name_container').addClass('d-none');
        $('.nationality_thai_midname_container').addClass('d-none');
        $('.nationality_thai_sname_container').addClass('d-none');
        $('.nationality_thai_bday_container').addClass('d-none');
        $('.nationality_foreigner_container').removeClass('d-none');
    }
  });

  $(document).on('click', '#ck_national_thai, #ck_national_foreigner', function () {
  	
  	let ck_nationality_type = 0;
  	if( $('#ck_national_thai').is(':checked') ){
  	    ck_nationality_type = 1;
  	}

  	if( $('#ck_national_foreigner').is(':checked') ){
  	    ck_nationality_type = 2;
  	}   

  	if(ck_nationality_type == 1){
  	    $('.nationality_thai_container').removeClass('d-none');
  	    $('.nationality_thai_name_container').removeClass('d-none');
  	    $('.nationality_thai_midname_container').removeClass('d-none');
  	    $('.nationality_thai_sname_container').removeClass('d-none');
  	    $('.nationality_thai_bday_container').removeClass('d-none');
  	    $('.nationality_foreigner_container').addClass('d-none');
  	} else if(ck_nationality_type == 2) {
  	    $('.nationality_thai_container').addClass('d-none');
  	    $('.nationality_thai_name_container').addClass('d-none');
  	    $('.nationality_thai_midname_container').addClass('d-none');
  	    $('.nationality_thai_sname_container').addClass('d-none');
  	    $('.nationality_thai_bday_container').addClass('d-none');
  	    $('.nationality_foreigner_container').removeClass('d-none');
  	}

  })

</script>