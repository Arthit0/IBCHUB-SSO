<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
?>
<div class="row">
	<div class=" d-md-block d-none col-md-4">
		<div class="left-side d-flex h-100">
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
	<div class="col-md-8 col-md-none">
		<nav class="navbar navbar-light ">
			<div class="justify-content-start pointer">
				<a href="<?php echo BASE_PATH . _INDEX ?>home/login" class="back-login text-dark">
					<i class="fas fa-arrow-left"></i> &nbsp;<span><?php echo lang('signin') ?></span>
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
		<div class="container box-register">
			<div class="row">
				<div class=" col-sm-12 col-md-12 col-lg-12 text-center">
					<ul class="nav nav-pills mb-3 group-pill" id="pills-tab" role="tablist">
						<li class="nav-item group-pill group-pillF1 mr-2" role="presentation">
							<a class="nav-link active" id="company-tab" data-toggle="pill" href="#pills-company" role="tab" aria-controls="pills-company" aria-selected="true" onclick="settitle('<?php echo lang('regis_header'); ?>')">
								<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget"><?php echo lang('regis_menu1'); ?>
								</div>
							</a>
						</li>
						<li class="nav-item group-pill group-pillF2 mr-2" role="presentation">
							<a class="nav-link" id="people-tab" data-toggle="pill" href="#pills-people" role="tab" aria-controls="pills-people" aria-selected="false" onclick="settitle('<?php echo lang('regis_header'); ?>')">
								<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget"><?php echo lang('regis_menu2'); ?>
								</div>
							</a>
						</li>
						<li class="nav-item mr-auto group-pill group-pillF3 mr-2" role="presentation">
							<a class="nav-link" id="non-thai-tab" data-toggle="pill" href="#non-thai-tabs" role="tab" aria-controls="non-thai-tabs" aria-selected="false" onclick="settitle('REGISTER')">NON-THAI
							</a>
						</li>
					</ul>
				</div>
				<div class=" col-sm-12 sm-p-0-30">
					<div class="tab-content sso-input" id="pills-tabContent">
						<!-- COMPANY TAB -->
						<div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="company-tab">
							<form action="#" onsubmit="return false" id="<?php echo $form_reg_company = 'form_reg_company'; ?>" autocomplete="off" class="form-horizontal">
								<!-- radiobox -->
								<div class="row sso-radio-container">
									<div class="col-sm-12 col-md-6 col-lg-6 d-flex">
										<label class="sso-radio pointer ">
											<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
												<b class="text-white"><?php echo lang('regis_checkbox1'); ?>
											</div>
											<input class="ck_address" type="radio" name="data_type" value="1" checked>
											<span class="checkmark"></span>
										</label>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-6 d-flex">
										<label class="sso-radio pointer ">
											<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
												<b class="text-white"><?php echo lang('regis_checkbox2'); ?>
											</div>
											<input class="ck_address" type="radio" name="data_type" id="niti_no" value="6">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
								<!-- endradiobox -->
								<!-- niti-thai-header -->
								<div class="regis-header mt-4">
									<h4><span><b class="w-50"><?php echo lang('regis_com_header') ?></span></h4>
								</div>
								<!-- end niti-thai-header -->
								<!-- niti-thai-data -->
								<div class="form-row sso-input">
									<div class="form-group col-sm-6 loader_input">
										<!-- <span id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></span> -->
										<div class="d-flex justify-content-between">
											<label class="control-label" id="text-use1"><?php echo lang('regis_com_num'); ?>&nbsp;<span class="text-danger">*</span></label>
											<label class="control-label" id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?>&nbsp;<span class="text-danger">*</span></label>
											<div class="col-5 warning-niti">
												<?php echo lang('regis_com_num_error'); ?>
											</div>
										</div>
										<div class="regis-com-check">
											<input class="input-sso" type="text" name="cid" id="user1_id" autocomplete="off" maxlength="13"
											placeholder="<?php echo lang('regis_com_num'); ?>">
											<button class="btn btn-primary regis-com-check-btn" type="submit"><?php echo lang('regis_check_btn') ?></button> 
										</div>
										<div class="col-12 minititle" id="thisVal1">
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
										<input type="text" class=" input-sso" name="company_nameEn" id="company_nameEn" placeholder=" <?php echo lang('regis_com_nameen'); ?>" pattern="([A-Za-z]|[@])+">
									</div>
									<!-- non-niti-data -->
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_email'); ?></label>
										<input type="text" class=" input-sso" name="company_email" id="company_email" placeholder="<?php echo lang('regis_com_email'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input"	>
										<label class="control-label"><?php echo lang('regis_com_phone'); ?></label>
										<input type="text" class=" input-sso" name="company_phone" id="company_phone" placeholder="<?php echo lang('regis_com_phone'); ?>">
									</div>
									<!-- end non-niti-data -->
									<div class="form-group col-sm-6 sso-row-input">
										<div class="find">
											<label class="control-label"><?php echo lang('regis_com_postcode'); ?></label>
											<input type="text" class=" input-sso postcode postcodeth" name="company_postcode" placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" readonly>
											<div class="dropdown-menu dropdown_addr" id="dropdown_company_postcode"></div>
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_com_province'); ?></label>
											<div class="provi1">
												<input type="text" class=" input-sso" name="company_province" placeholder="<?php echo lang('regis_com_province'); ?>" readonly>
											</div>
											<div class="provi2" style="display:none;">
											  <select class="form-control selectpicker sso-dropdown btn-province provinceth"
											    title="<?php echo lang('regis_com_province'); ?>" tabindex="-98" name="companyTH_province" data-live-search="false">
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
										<input type="text" class=" input-sso" name="company_addressEn" id="company_addressEn" placeholder="<?php echo lang('regis_com_input_addressen'); ?>" pattern="([A-Za-z]|[@])+">
									</div>
								</div>
								<!-- end niti-thai-data -->
								<div class="regis-header mt-4">
									<h4><span><b class="w-50"><?= lang('regis_contact_header') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-3">
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
														<option value="นาย"><?php echo lang('regis_Mr'); ?></option>
														<option value="นาง"><?php echo lang('regis_Mrs'); ?></option>
														<option value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fname'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="contact_name" placeholder="<?php echo lang('regis_contact_fname'); ?>">
									</div>
									<div class="form-group col-sm-5 sso-row-input">
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
										<label class="control-label"><?php echo lang('regis_contact_birthday'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="date" class=" input-sso" name="contact_bday" placeholder="<?php echo lang('regis_contact_birthday'); ?>">
									</div>
									<div class="form-group col-sm-6 loader_input">
										<!-- <span id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></span> -->
										<div class="d-flex justify-content-between">
											<label class="control-label"><?php echo lang('regis_contact_id'); ?> &nbsp;<span class="text-danger">*</span></label>
											<div class="col-5 warning-niti">
												<?php echo lang('regis_com_num_error'); ?>
											</div>
										</div>
										<div class="regis-com-check">
											<input type="text" class=" input-sso" name="contact_cid" maxlength="13" placeholder="<?php echo lang('regis_contact_id'); ?>">
											<button class="btn btn-primary ck-contact-id-btn " type="submit"><?php echo lang('regis_check_btn') ?></button> 
										</div>
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
								<div class="regis-header mt-4">
									<h4><span><b class="w-50"><?= lang('regis_com_header') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-12">
										<div class="sso-row-input">
											<div class="row">
												<div class="col-4 col-sm-5 col-md-4 col-lg-3">
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
												<div class="col-8 col-sm-7 col-md-8 col-lg-7">
													<label class="sso-radio pointer old_adress1"> <?php echo lang('regis_contact_checkbox2'); ?>
														<input class="ck_address radio_old_adress" type="radio" name="ck_address" value="2" placeholder="<?php echo lang('regis_contact_checkbox2'); ?>">
														<span class="checkmark"></span>
													</label>
													<label class="sso-radio pointer old_adress6" style="display:none;"> ที่อยู่เดียวกันกับที่จดทะเบียน
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
								<div class="regis-header mt-4">
									<h4><span><b class="w-50"><?= lang('regis_pass') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<label for="" class="control-label"><?php echo lang('regis_pass'); ?>&nbsp;(Password)&nbsp;<span class="text-danger">*</span></label>
										<div class="warning-pass" id="company-password">
											<?php echo lang('regis_com_pass_recom'); ?>
										</div>
										<div class="pass-input-with-icon">
											<input class=" input-sso pass_input" type="text" id="password" name="password" minlength="8" required
											autocomplete="off" placeholder=" <?php echo lang('regis_pass'); ?>">
											<i id="show-pass" class="fa fa-eye-slash icon-password-reg"
											onclick="show_pass(this,'password','form_reg_company')"></i>
										</div>
										<div class="col-12 minititle">
											<?php echo lang('regis_pass_recom'); ?>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="" class="control-label"><?php echo lang('regis_pass_confirm'); ?>&nbsp;<span class="text-danger">*</span></label>
										<div class="warning-repass" id="company-password">
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
												<div class="col-sm-6">
													<label class="sso-radio pointer"> <?php echo lang('regis_email_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify" checked value="email" placeholder="<?php echo lang('regis_email_verify_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col-sm-6">
													<label class="sso-radio pointer"> <?php echo lang('regis_sms_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify" value="sms" placeholder="<?php echo lang('regis_sms_verify_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</div>
								</div>
								<div class="form-group col-sm-6">
									<div class="btn  submitform  btn-con-reg" style=""
									  data-form="<?php echo $form_reg_company ?>" data-type="1">
									  <?php echo lang('regis_header'); ?></div>
								</div>
							</form>
							</div>
						</div>
						<!-- PEOPLE TAB -->
						<div class="tab-pane fade" id="pills-people" role="tabpanel" aria-labelledby="people-tab">
							<form action="#" class="form-horizontal" onsubmit="return false" id="<?php echo $form_reg_people = 'form_reg_people'; ?>" autocomplete="off">
								<div class="regis-header mt-4">
									<h4><span><b class="w-50"><?= lang('regis_contact_header') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-3">
										<div class="sso-row-input">
											<div class="row">
												<div class="col-12">
													<label class="control-label"><?php echo lang('regis_contact_title'); ?> &nbsp;<span class="text-danger">*</span></label>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_contact_title'); ?> / Title name"
														tabindex="-98" name="title" placeholder="<?php echo lang('regis_contact_title'); ?>">
														<option value="นาย"><?php echo lang('regis_Mr'); ?></option>
														<option value="นาง"><?php echo lang('regis_Mrs'); ?></option>
														<option value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fname'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="name_user" placeholder="<?php echo lang('regis_contact_fname'); ?>">
									</div>
									<div class="form-group col-sm-5 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_sname'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="lastname" placeholder="<?php echo lang('regis_contact_sname'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_fnameen'); ?>&nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="name_userEn" placeholder="<?php echo lang('regis_contact_fnameen'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_snameen'); ?>&nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="lastnameEn" placeholder="<?php echo lang('regis_contact_snameen'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_birthday'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="date" class=" input-sso" name="birthday" placeholder="<?php echo lang('regis_contact_birthday'); ?>">
									</div>
									<div class="form-group col-sm-6 loader_input">
										<div class="d-flex justify-content-between">
											<label class="control-label"><?php echo lang('regis_contact_id'); ?> &nbsp;(Username)<span class="text-danger">*</span></label>
											<div class="col-5 warning-niti">
												<?php echo lang('regis_com_num_error'); ?>
											</div>
										</div>
										<div class="regis-com-check">
											<input type="text" class=" input-sso" name="cid" id="user_id" maxlength="13" placeholder="<?php echo lang('regis_contact_id'); ?>">
											<button class="btn btn-primary ck-contact-id-btn " type="submit"><?php echo lang('regis_check_btn') ?></button> 
										</div>
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_mail'); ?> &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="email" placeholder="<?php echo lang('regis_contact_mail'); ?>">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label"><?php echo lang('regis_contact_phone'); ?> &nbsp;<span class="text-danger">*</span></label>
										<div id="tel1">
											<input type="text" class=" input-sso" name="tel" maxlength="10"
											placeholder="<?php echo lang('regis_contact_phone'); ?>">
											<input type="hidden" name="tel_country">
											<input type="hidden" name="tel_code">
										</div>
									</div>
								</div>
								<div class="regis-header mt-4">
									<h4><span><b class="w-50"><?= lang('regis_contact_header') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="find form-row w-100">
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_postcode'); ?><span class="text-danger">*</span></label>
											<input type="text" class=" input-sso postcode" name="postcode" placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
											<label class="control-label"><?php echo lang('regis_com_district'); ?></label> &nbsp;<span class="text-danger">*</span></label>
											<div class="txtdetail txtdistrict1" style="display:none;">
												<label for=""><?php echo lang('regis_com_khet'); ?></label> &nbsp;<span class="text-danger">*</span></label>
											</div>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_district'); ?>" tabindex="-98"
												name="districtTh" data-live-search="false">
												<option value=""><?php echo lang('regis_province_recom'); ?></option>
											</select>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label"><?php echo lang('regis_com_subdistrict'); ?></label> &nbsp;<span class="text-danger">*</span></label>
											<div class="txtdetail txtsubdistrict1" style="display:none;">
												<label for=""><?php echo lang('regis_com_kwang'); ?></label> &nbsp;<span class="text-danger">*</span> </label>
											</div>
											<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict'); ?>" tabindex="-98"
												name="subdistrictTh" data-live-search="false">
												<option value=""><?php echo lang('regis_district_recom'); ?></option>
											</select>
										</div>
										<div class="form-group col-sm-6 sso-row-input mb-4">
											<label class="control-label"><?php echo lang('regis_com_address'); ?>&nbsp;<span class="text-danger">*</span></label>
											<input type="text" class=" input-sso" name="addressTh" placeholder="<?php echo lang('regis_com_address'); ?>">
										</div>
									</div>
								</div>
								<div class="regis-header mt-4">
									<h4><span><b class="w-50"><?= lang('regis_pass') ?></span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<label for="" class="control-label"><?php echo lang('regis_pass'); ?>&nbsp;(Password)&nbsp;<span class="text-danger">*</span></label>
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
										<label for="" class="control-label"><?php echo lang('regis_pass_confirm'); ?>&nbsp;<span class="text-danger">*</span></label>
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
												<div class="col-sm-6">
													<label class="sso-radio pointer"> <?php echo lang('regis_email_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify_normal" checked value="email" placeholder="<?php echo lang('regis_email_verify_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col-sm-6">
													<label class="sso-radio pointer"> <?php echo lang('regis_sms_verify_checkbox1'); ?>
														<input class="" type="radio" name="ck_verify_normal" value="sms" placeholder="<?php echo lang('regis_sms_verify_checkbox1'); ?>">
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</div>
								</div>
								<div class="form-group col-sm-6">
									<div class="btn  submitform  btn-con-reg" style=""
									  data-form="<?php echo $form_reg_people ?>" data-type="1">
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
									<div class="col-sm-12 col-md-6 col-lg-6 d-flex">
										<label class="sso-radio pointer ">
											<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
												<b class="text-white">Corporate ID
											</div>
											<input class="ck_address" placeholder="Corporate ID" type="radio" name="data_type" value="2" onclick="radio_foreigner(2)" checked>
											<span class="checkmark"></span>
										</label>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-6 d-flex">
										<label class="sso-radio pointer ">
											<div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
												<b class="text-white">Passport ID
											</div>
											<input class="ck_address" placeholder="Passport ID" type="radio" name="data_type" i value="4" onclick="radio_foreigner(4)">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
								<!-- endradiobox -->
								<div id="company-address"  style="flex-direction: column;">
									<!-- Company Infomation-header -->
									<div class="regis-header mt-4">
										<h4><span><b class="w-50">Company Infomation</span></h4>
									</div>
									<!-- end Company Infomation-header -->
									<!-- Company Infomation -->
									<div class="form-row sso-input">
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label">Corporate ID&nbsp;<span class="text-danger">*</label>
											<input input class=" input-sso" type="text" name="cid" id="user_id" autocomplete="off" maxlength="13" placeholder="Corporate ID">
											<div class="col-12 minititle">
											  You can use letters, numbers
											</div>
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label">Corporate Name&nbsp;<span class="text-danger">*</label>
											<input input class=" input-sso" type="text" name="fo_corporate_name" placeholder="Corporate Name">
										</div>
										<div class="form-group col-sm-6 sso-row-input">
											<label class="control-label">Country&nbsp;<span class="text-danger">*</label>
											<select class="form-control selectpicker sso-dropdown" title="Country" id="country" tabindex="-98" name="fo_country_name">
											  <option class="country_name">Country</option>
											</select>
										</div>
										<div class="form-group col-sm-6 sso-row-input ">
											<label class="control-label">Corporate Address&nbsp;<span class="text-danger">*</label>
											<input input class=" input-sso" type="text" name="fo_address" placeholder="Corporate address">
										</div>
									</div>
									<!-- end Company Infomation -->
								</div>
								<!-- niti-thai-header -->
								<div class="regis-header mt-4">
									<h4><span><b class="w-50">Personal Information</span></h4>
								</div>
								<!-- end niti-thai-header -->
								<div class="form-row sso-input">
									<div class="form-group col-sm-3">
										<div class="sso-row-input">
											<div class="row">
												<div class="col-12">
													<label class="control-label">Title Name &nbsp;<span class="text-danger">*</span></label>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_contact_title'); ?> / Title name"
														tabindex="-98" name="fo_title" placeholder="<?php echo lang('regis_contact_title'); ?>">
														<option value="Mr.">Mr.</option>
														<option value="Mrs.">Mrs.</option>
														<option value="Miss">Miss</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group col-sm-4 sso-row-input">
										<label class="control-label">First Name &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="fo_name" placeholder="First Name">
									</div>
									<div class="form-group col-sm-5 sso-row-input">
										<label class="control-label">Last Name  &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="fo_lastname" placeholder="Last Name ">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label">Email &nbsp;<span class="text-danger">*</span></label>
										<input type="text" class=" input-sso" name="fo_email" placeholder="Email">
									</div>
									<div class="form-group col-sm-6 sso-row-input">
										<label class="control-label">Tel. &nbsp;<span class="text-danger">*</span></label>
										<div id="tel1">
											<input type="text" class=" input-sso" name="fo_tel" maxlength="10" placeholder="Tel">
											<input type="hidden" name="fo_tel_country">
											<input type="hidden" name="fo_tel_code">
										</div>
									</div>
								</div>
								<div class="regis-header mt-4">
									<h4><span><b class="w-50">Password</span></h4>
								</div>
								<div class="form-row sso-input">
									<div class="form-group col-sm-6">
										<label for="" class="control-label">Password&nbsp;<span class="text-danger">*</span></label>
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
										<label for="" class="control-label">Re-enter Password&nbsp;<span class="text-danger">*</span></label>
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
									<div class="btn  submitform  btn-con-reg" style=""
									  data-form="<?php echo $form_reg_foreigner ?>" data-type="1">
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
      <div class="modal-header justify-content-center" style="border-bottom: 1px solid #8A919E;">
        <h5 class="modal-title text-center " ><?php echo lang('laser_modal_title') ?>555</h5>
        <button type="button" class="close" aria-label="Close">
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
                  <input type="text" name="laser_id" id="laser1_id" class="input-sso" placeholder="JC0-0000000-00" maxlength="12">
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
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-primary rounded-pill ck-laser-btn" style="background: #4189B7;">ตรวจสอบข้อมูล</button>
      </div>
    </div>
  </div>
</div>
<div class="modal sso-modal fade shadow" id="contact_laser_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 8px !important;">
      <div class="modal-header justify-content-center" style="border-bottom: 1px solid #8A919E;">
        <h5 class="modal-title text-center " ><?php echo lang('laser_modal_title') ?>666</h5>
        <button type="button" class="close laser-modal-close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body sso-input">
        <form onsubmit="return false" id="form_laser_company">
          <div class="error-log text-danger d-flex justify-content-center w-100"></div>
          <table class="table table-borderless" style="table-layout: fixed;width: 100%;">
            <thead>
              <th width="30%"></th>
              <th width="50%"></th>
            </thead>
            <tbody>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">เลขหน้าบัตร&nbsp;:</td>
                <td id="contact-laser-modal-citizenid" style="font-size: 1.23rem;color: var(--main-color-1);"></td>
                <input type="hidden" name="cid" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">ชื่อ&nbsp;:</td>
                <td id="contact-laser-modal-fname" style="font-size: 1.23rem;color: var(--main-color-1);"></td>
                <input type="hidden" name="fname" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">นามสกุล&nbsp;:</td>
                <td id="contact-laser-modal-lname" style="font-size: 1.23rem;color: var(--main-color-1);"></td>
                <input type="hidden" name="lname" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">วินเดือนปีเกิด&nbsp;:</td>
                <td id="contact-laser-modal-bday" style="font-size: 1.23rem;color: var(--main-color-1);"></td>
                <input type="hidden" name="bday" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">เลขหลังบัตร&nbsp;:</td>
                <td>
                  <input type="text" name="laser_id" id="laser1_id" class="input-sso" placeholder="JC0-0000000-00" maxlength="12">
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
        <button type="button" class="btn ck-contact-laser-btn-cancel" data-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn ck-contact-laser-btn">ตรวจสอบข้อมูล</button>
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
<div class="" id="overlay-fullsrc">
  <!-- <div class="modal-dialog">
    <div class="modal-content"> -->


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

        <label class="sso-ckb m-0-auto"> ยอมรับเงื่อนไข
          <input type="checkbox" id=ck_policy>
          <span class="box-ckb"></span>

        </label>
      </div>
      <div class="row">
        <div class="btn   btn-con-reg w-100" id="con_policy">ตกลง</div>
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
      
    })
    const togglePassword = document.querySelector("#show-pass");
    const togglePasswordre = document.querySelector("#show-repass");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        
        // toggle the icon
        this.classList.toggle("bi-eye");
    });

    togglePasswordre.addEventListener("click", function () {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        
        // toggle the icon
        this.classList.toggle("bi-eye");
    });

    // prevent form submit
    const form = document.querySelector("form");
    form.addEventListener('submit', function (e) {
        e.preventDefault();
    });
  })
</script>