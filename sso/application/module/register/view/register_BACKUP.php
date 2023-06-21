<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
?>
<nav class="navbar navbar-light ">
  <div class="navbar-brand pointer">

    <a href="<?php echo BASE_PATH . _INDEX ?>auth" class="d-block d-md-none">
      <img src="<?php echo BASE_PATH; ?>asset/img/chevron-left-material@3x.png" alt="" style="height: 30px;">
    </a>
    </div>
    <div class="justify-content-end"> <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/th" class="change-lang"><img
        class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png"
        alt=""></a>
    <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/en" class="change-lang"><img
        class="<?php echo ($lang == 'en') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png"
        alt=""></a>
      </div>
   
  </div>
</nav>
<style>
  .error-mess {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
  }

  .box-policy {
    max-width: 720px;
    margin: 0 auto;
    padding: 0 20px;
    font-size: 22px;

  }

  .box-policy nav {
    padding-left: 0;

  }
  .sso-modal {
/*    font-family: 'Mitr';
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 22px;*/
  }
  .sso-ckb {
    position: relative;

    padding-left: 20px;
  }

  .sso-ckb input {
    display: none;
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  .sso-ckb .box-ckb {
    position: absolute;
    width: 15px;
    height: 15px;
    border: 2px solid #96b3cb;
    border-radius: 4px;
    position: absolute;
    top: 50%;
    left: 0%;
    transform: translate(0%, -50%);
    -ms-transform: translate(-0%, -50%);
    background-color: #fdfdfd;
  }

  .sso-ckb:hover input~.box-ckb {
    background-color: #ccc;
  }

  .sso-ckb input:checked~.box-ckb:after {
    display: block;
  }

  .sso-ckb input:checked~.box-ckb {
    background-color: #2196F3;
  }

  .box-ckb:after {
    content: "";
    position: absolute;
    display: none;
  }

  .box-ckb:after {
    left: 4px;
    top: 0px;
    width: 4px;
    height: 9px;
    border: solid white;
    border-width: 0 2px 2px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  #overlay-fullsrc {
    /* background-image: url('<?php //echo BASE_PATH; ?>/asset/img/group.png'); */
    background-color: #fff;
    padding: 0px !important;
    z-index: 1049;
    position: fixed;
    top: 0;
    width: 100vw;
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    display: none;
    color: #427c97 !important;
  }

  .overflow-body {
    height: 100vh;
    overflow-y: hidden;

  }

  .group-pill .nav-link {
    min-width: 123px !important;
    font-size: 18px;
    padding-left: 8px;
    padding-right: 8px;
  }

  /* #overlay-fullsrc .modal-dialog {
    max-width: 100%;
    margin: 0 !important;
  }

  #overlay-fullsrc .modal-content {
    border: none;
    background-color: unset !important;
  } */
  .loader_input {
    position: relative;
  }

  .iti__selected-flag {
    outline: none;
  }

  .iti--allow-dropdown .iti__flag-container:hover .iti__selected-flag {
    background-color: rgba(0, 0, 0, 0);
  }

  #user_id {
    position: relative;
  }

  .loader_input #show-input {
    font: normal normal normal 18px/1 FontAwesome;
    content: "\f002";
    position: absolute;
    right: 38px;
    top: 13px;
  }

  .show_load.loader_input::after {
    content: "";
    border: 2px solid #f3f3f3;
    border-radius: 50%;
    border-top: 2px solid #3498db;
    width: 15px;
    height: 15px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    position: absolute;
    right: 7%;
    top: 30%;
  }

  .show_wrong.loader_input::after {
    font: normal normal normal 18px/1 FontAwesome;
    content: "\f00d";
    position: absolute;
    right: 8%;
    top: 30%;
    color: #f12525;
  }

  .show_success.loader_input::after {
    font: normal normal normal 18px/1 FontAwesome;
    content: "\f00c";
    position: absolute;
    right: 8%;
    top: 30%;
    color: #55da73;
  }

  .closs-overlay {
    font-size: 25px;
    font-weight: 600;
    color: #427c97 !important;
  }

  /* Safari */
  @-webkit-keyframes spin {
    0% {
      -webkit-transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
    }
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .iti {
    width: 100%;
  }

  .dropdown_addr {
    font-size: 22px;
    height: auto;
    max-height: 400px;
    overflow-x: scroll;
    width: 90%;
  }

  .dropdown-link {
    cursor: pointer;
  }

  .dropdown-link:active {
    background-color: #dae0e5;
    color: #fff
  }

  .addr-icon {
    font-size: 1rem;
    font-weight: bold;
  }

  .drop-down-icon {
    cursor: default;
  }

  .drop-down-icon:hover {
    background-color: #fff;
  }

  .drop-down-icon:active {
    background-color: #fff;
  }

  .dropdown-item.active,
  .dropdown-item:active {
    color: #fff;
    text-decoration: none;
    background-color: #427c97;
  }


  .warning-niti {
    font-size: 16px;
    font-weight: 100;
    color: red;
    /* margin: 0 0 0 113px; */
    bottom: -8px;

  }

  .warning-pass {
    font-size: 16px;
    font-weight: 100;
    color: red;
    /* margin: 0 0 0 121px; */
    bottom: -8px;

  }

  .warning-repass {
    font-size: 16px;
    font-weight: 100;
    color: red;
    /* margin: 0 0 0 55px; */
    bottom: -8px;
  }

  .error-log {
    font-size: 1.3rem;
  }




  .selectcountry_div {
    position: relative;
    float: left;
    min-width: 200px;
  }

  .selectcountry_div:after {
    font: normal normal normal 18px/1 FontAwesome;
    content: "\f106";
    right: 30px;
    position: absolute;
    transform: rotate(180deg);
    top: 14px;
  }




  .select_country {
    cursor: pointer;
    position: relative;
    height: 45px;
    border-radius: 25px;
    border: 1px solid #cad8e140;
    -webkit-box-shadow: inset 0px 1px 1px 1px rgb(202 216 225);
    -moz-box-shadow: inset 0px 1px 1px 1px rgba(202, 216, 225, 1);
    box-shadow: inset 0px 1px 1px 1px rgb(202 216 225);
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-appearance: none;
  }
  .input-sso {
    display: flex;
    glow: 2;
  }
  .ck-citizen-btn {
    position: absolute;
    right: 24px;
    top: 3px;
    bottom: 3px;
    border: 0;
    background: #427c97;
    color: #fff;
    outline: none;
    margin: 0px;
    padding: 0px 34px;
    border-radius: 100px;
    z-index: 2;
    font-size: 22px;
  }
  .ck-contact-id-btn {
    position: absolute;
    right: 24px;
    top: 3px;
    bottom: 3px;
    border: 0;
    background: #427c97;
    color: #fff;
    outline: none;
    margin: 0px;
    padding: 0px 34px;
    border-radius: 100px;
    z-index: 2;
    font-size: 22px;
  }
  .laser-modal-close {
    position: absolute;
    top: -2%;
    right: 4%;
    background-color: white!important;
    opacity: 1;
    border-radius: 50px;
    padding: 1px 6px 1px 6px!important;
  }
  .close {
    font-size: inherit;
  }
  .sso-modal > .modal-dialog > .modal-content > .modal-footer .btn-secondary , .sso-modal > .modal-dialog > .modal-content > .modal-footer .btn-primary {
    padding: 5px 40px;
    font-size: 1.6rem;
  }
  /* .select_country select .option_style{
    position:relative;
    font-size: 220px;
    right: 30px;
    height: auto;
    max-height: 400px;
    overflow-x: scroll;
    width: 90%;
  } */

  /* .country_name {
    font-size: 220px !important;
    color: red;
  } */
</style>
<div class="container box-register">
  <div class="row">
    <div class=" col-sm-12 col-md-12 col-lg-12 text-center">
      <a href="<?php echo BASE_PATH . _INDEX ?>auth">
        <img src="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" style="width: 232px;height: 136px;">
      </a>

    </div>
    <div class=" col-sm-12 col-md-12 col-lg-12 text-center title-register" style="font-weight:bolder">
      <!-- ลงทะเบียน -->
      <?php echo lang('regis_header'); ?>
    </div>
 

    <div class=" col-sm-12 col-md-12 col-lg-12 text-center">
      <ul class="nav nav-pills mb-3 group-pill" id="pills-tab" role="tablist">
        <li class="nav-item ml-auto group-pill1 group-pillF1" role="presentation">
          <a class="nav-link active" id="company-tab" data-toggle="pill" href="#pills-company" role="tab"
            aria-controls="pills-company" aria-selected="true" onclick="settitle('<?php echo lang('regis_header'); ?>')">
            <div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget"><b><?php echo lang('regis_menu1'); ?></b>
            </div>
          </a>
        </li>
        <li class="nav-item group-pill2 group-pillF2" role="presentation">
          <a class="nav-link" id="people-tab" data-toggle="pill" href="#pills-people" role="tab"
            aria-controls="pills-people" aria-selected="false" onclick="settitle('<?php echo lang('regis_header'); ?>')">
            <div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget"><b><?php echo lang('regis_menu2'); ?></b>
            </div>
          </a>
        </li>
        <li class="nav-item mr-auto group-pill3 group-pillF3" role="presentation">
          <a class="nav-link" id="non-thai-tab" data-toggle="pill" href="#non-thai-tabs" role="tab"
            aria-controls="non-thai-tabs" aria-selected="false" onclick="settitle('REGISTER')">NON-THAI</a>
        </li>
      </ul>
    </div>
    <div class=" col-sm-12 sm-p-0-30">
      <div class="tab-content sso-input" id="pills-tabContent">

        <div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="company-tab">

          <form action="#" onsubmit="return false" id="<?php echo $form_reg_company = 'form_reg_company'; ?>"
            autocomplete="off">

            <div class="row">
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 d-flex justify-content-end">
                <label class="sso-radio pointer ">
                  <div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
                    <b><?php echo lang('regis_checkbox1'); ?></b>
                  </div>
                  <input class="ck_address" type="radio" name="data_type" value="1" checked>
                  <span class="checkmark"></span>
                </label>
              </div>

              <div class="col-6 col-sm-6 col-md-6 col-lg-6 pl-1">
                <label class="sso-radio pointer ">
                  <div class="" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
                    <b><?php echo lang('regis_checkbox2'); ?></b>
                  </div>
                  <input class="ck_address" type="radio" name="data_type" id="niti_no" value="6">
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>


            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12 d-flex justify-content-between">
                    <!-- <div class="col-8">
                      <span id="text-use1" >เลขนิติบุคคล(Username)&nbsp;<span class="text-danger">*</span></span> 
                      <span id="text-use2" style="display:none;">เลขประจำตัวผู้เสียภาษีอากร</span> 
                    </div> -->
                    <div class="col-8">
                      <span id="text-use1">
                        <div class="placeholder" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
                          <b><?php echo lang('regis_com_num'); ?></b>&nbsp;<span class="text-danger">*</span>
                        </div>
                      </span>
                      <span id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></span>
                    </div>
                    <div class="col-5 warning-niti">
                      <b><?php echo lang('regis_com_num_error'); ?></b>
                    </div>
                  </div>
                  <div class="col-12 loader_input">
                    <input class="input-sso" type="text" name="cid" id="user1_id" autocomplete="off" maxlength="13"
                      placeholder="<?php echo lang('regis_com_num'); ?>">
                    <!-- <i id="show-input" class="fa fa-search"></i> -->
                  </div>
                  <div class="col-12 minititle" id="thisVal1">
                  <?php echo lang('regis_com_recom'); ?>
                  </div>
                  <div class="col-12 minititle" id="thisVal6" style="display:none;">
                  <?php echo lang('regis_com_recom2'); ?>
                  </div>
                </div>
              </div>
            </div>




            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12 d-flex justify-content-between">
                    <!-- <div class="col-8">
                      รหัสผ่าน(Password)&nbsp;<span class="text-danger">*</span>
                    </div> -->
                    <div class="col-8">
                    <?php echo lang('regis_pass'); ?>&nbsp;<span class="text-danger">*</span>
                    </div>
                    <div class="col-5 warning-pass">
                      <b><?php echo lang('regis_com_pass_recom'); ?></b>
                    </div>
                  </div>

                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" id="password" name="password" minlength="8" require
                      autocomplete="off" placeholder=" <?php echo lang('regis_pass'); ?>">
                    <i id="show-pass" class="fa fa-eye-slash icon-password-reg"
                      onclick="show_pass(this,'password','form_reg_company')"></i>
                  </div>
                  <div class="col-12 minititle">
                  <?php echo lang('regis_pass_recom'); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-14 ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12 d-flex justify-content-between">

                    <!-- <div class="col-9">
                      ยืนยันรหัสผ่าน(Re-enter Password)&nbsp;<span class="text-danger">*</span>
                    </div> -->
                    <div class="col-8">
                    <?php echo lang('regis_pass_confirm'); ?>&nbsp;<span class="text-danger">*</span>
                    </div>
                    <div class="col-5 warning-repass">
                      <b><?php echo lang('regis_pass_nomatch'); ?></b>
                    </div>

                  </div>
                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="repassword" id="repassword" minlength="8"
                      require autocomplete="off" placeholder=" <?php echo lang('regis_pass_confirm'); ?>">
                    <i id="show-repass" class="fa fa-eye-slash icon-password-reg"
                      onclick="show_pass(this,'repassword','form_reg_company')"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">

              <div class="row">
                <div class="card w-100 card-comapny-member">
                  <h5 class="card-header"><?php echo lang('regis_com_header'); ?></h5>
                  <div class="card-body" id="corporation_container">
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_com_name'); ?>&nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class="input-sso" name="company_name" placeholder="<?php echo lang('regis_com_name'); ?>" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_com_address'); ?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="company_address" placeholder="<?php echo lang('regis_com_address'); ?>" readonly>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="find">


                      <div class="row">

                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12">
                              <?php echo lang('regis_com_postcode'); ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <input type="text" class=" input-sso postcode postcodeth" name="company_postcode"
                                placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" readonly>

                              <div class="dropdown-menu dropdown_addr" id="dropdown_company_postcode">
                              </div>
                              <!-- <input type="text" class=" input-sso" name="company_province" placeholder="จังหวัด" > -->
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-6 col-12 sso-row-input">

                          <div class="row ">
                            <div class="col-12">
                              <?php echo lang('regis_com_province'); ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12 provi1">
                              <input type="text" class=" input-sso" name="company_province" placeholder="<?php echo lang('regis_com_province'); ?>"
                                readonly>
                            </div>
                            <div class="col-12 provi2" style="display:none;">
                              <select class="form-control selectpicker sso-dropdown btn-province provinceth"
                                title="<?php echo lang('regis_com_province'); ?>" tabindex="-98" name="companyTH_province" data-live-search="false">
                              </select>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="row">

                        <div class="col-sm-6 col-12 sso-row-input">

                          <div class="row">
                            <div class="col-12 txtdetail txtdistrict">
                              <?php echo lang('regis_com_district'); ?>
                            </div>
                            <div class="col-12 txtdetail txtdistrict1" style="display:none;">
                              <?php echo lang('regis_com_khet'); ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12 dis1">
                              <input type="text" class=" input-sso" name="company_district" placeholder="<?php echo lang('regis_com_district'); ?>"
                                readonly>
                            </div>
                            <div class="col-12 dis2" style="display:none;">
                              <select class="form-control selectpicker sso-dropdown districtth" title="<?php echo lang('regis_com_district'); ?>"
                                tabindex="-98" name="companyTH_districts" data-live-search="false">
                                <option value=""><?php echo lang('regis_province_recom'); ?></option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12 txtdetail txtsubdistrict">
                              <?php echo lang('regis_com_subdistrict'); ?>
                            </div>
                            <div class="col-12 txtdetail txtsubdistrict1" style="display:none;">
                              <?php echo lang('regis_com_kwang'); ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12 subdis1">
                              <input type="text" class=" input-sso" name="company_subdistrict" placeholder="<?php echo lang('regis_com_subdistrict'); ?>"
                                readonly>
                            </div>
                            <div class="col-12 subdis2" style="display:none;">
                              <select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict'); ?>" tabindex="-98"
                                name="companyTH_subdistricts" data-live-search="false">
                                <option value=""><?php echo lang('regis_district_recom'); ?></option>
                              </select>
                            </div>
                          </div>

                        </div>
            
                      </div>
                    </div>
                    <hr>
                    <!--<div class="row">
                      <div class="footer-people">
                        หากท่านต้องการปรับเปลี่ยนข้อมูลโปรดติดต่อกรมพัฒนาธุรกิจการค้า
                      </div>
                    </div>-->
                  </div>

                  <!-- en -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                             <?php echo lang('regis_com_nameen'); ?>&nbsp;<span class="text-danger">*
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="company_nameEn"
                              placeholder=" <?php echo lang('regis_com_nameen'); ?>" pattern="([A-Za-z]|[@])+">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_com_addressen'); ?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="company_addressEn"
                              placeholder="<?php echo lang('regis_com_address'); ?>" pattern="([A-Za-z]|[@])+">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="find">



                      <div class="row">

                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row ">
                            <div class="col-12">
                              <?php echo lang('regis_com_postcode'); ?>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-12">
                              <input type="text" class="input-sso postcode" name="company_postcodeEn"
                                placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                              <div class="dropdown-menu dropdown_addr" id="dropdown_company_postcodeEn">
                                <!-- <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a> -->
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12">
                            <?php echo lang('regis_com_provinceen'); ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <!--<input type="text" class=" input-sso" name="company_provinceEn" placeholder="จังหวัด (อังกฤษ)">-->
                              <select class="form-control selectpicker sso-dropdown btn-province provinceen"
                                title="<?php echo lang('regis_com_province'); ?>" tabindex="-98" name="company_provinceEn" data-live-search="false">

                              </select>
                            </div>
                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12 txtdetail txtdistrict ">
                              <label for="" class=""><?php echo lang('regis_com_districten'); ?></label> 
                            </div>
                            <div class="col-12 txtdetail txtdistrict1" style="display:none;">
                            <label for=""><?php echo lang('regis_com_khet'); ?> <?php echo lang('regis_lang'); ?> </label>  
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <!--<input type="text" class=" input-sso" name="company_districtEn" placeholder="<?php echo lang('regis_com_districten'); ?> (อังกฤษ)">-->
                              <select class="form-control selectpicker sso-dropdown districten" title="<?php echo lang('regis_com_district'); ?>"
                                tabindex="-98" name="company_districtEn" data-live-search="false">
                                <option value=""><?php echo lang('regis_province_recom'); ?></option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12 txtdetail txtsubdistrict">
                              <label for="" class=""><?php echo lang('regis_com_subdistricten'); ?></label>
                            </div>
                            <div class="col-12 txtdetail txtsubdistrict1" style="display:none;">
                             <label for=""><?php echo lang('regis_com_kwang'); ?> <?php echo lang('regis_lang'); ?> </label> 
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <!--<input type="text" class=" input-sso" name="company_subdistrictEn" placeholder="<?php echo lang('regis_com_districtenen'); ?> (อังกฤษ)">-->
                              <select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict'); ?>" tabindex="-98"
                                name="company_subdistrictEn" data-live-search="false">
                                <option value=""><?php echo lang('regis_district_recom'); ?></option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="footer-people">
                      <?php echo lang('regis_com_recom1'); ?>
                      </div>
                    </div>
                  </div>
                  <!-- end of en -->

                </div>
              </div>
              <div class="row">
                <div class="card w-100 card-company-address  card-sm-show-border ">
                  <h5 class="card-header card-sm-show-header"><?php echo lang('regis_contact_header'); ?></h5>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12 col-12 sso-row-input ">
                        <div class="row">
                          <div class="col-4 col-sm-4 col-md-3 col-lg-2">

                            <input type="hidden" name="state" value="">
                            <input type="hidden" name="Hcontact_address" value="">
                            <input type="hidden" name="Hcontact_province" value="">
                            <input type="hidden" name="Hcontact_district" value="">
                            <input type="hidden" name="Hcontact_subdistrict" value="">
                            <input type="hidden" name="Hcontact_postcode" value="">

                            <label class="sso-radio pointer"> <?php echo lang('regis_contact_checkbox1'); ?>
                              <input class="ck_address radio_new_adress" type="radio" name="ck_address" checked
                                value="1" placeholder="<?php echo lang('regis_contact_checkbox1'); ?>">
                              <span class="checkmark"></span>
                            </label>
                          </div>

                          <div class="col-8 col-sm-6 col-md-8 col-lg-6">
                            <label class="sso-radio pointer old_adress1"> <?php echo lang('regis_contact_checkbox2'); ?>
                              <input class="ck_address radio_old_adress" type="radio" name="ck_address" value="2"
                                placeholder="<?php echo lang('regis_contact_checkbox2'); ?>">
                              <span class="checkmark"></span>
                            </label>
                            <label class="sso-radio pointer old_adress6" style="display:none;"> ที่อยู่เดียวกันด้านบน
                              <input class="ck_address radio_old_adress" type="radio" name="ck_address" value="2"
                                placeholder="ที่อยู่เดียวกับที่จดทะเบียน">
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="find">


                      <div class="row">

                        <div class="col-sm-6 col-12 sso-row-input ">
                          <div class="row ">
                            <div class="col-12">
                              <?php echo lang('regis_com_postcode'); ?><span class="text-danger">*</span>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <input type="text" class=" input-sso" name="contact_postcode_old"
                                placeholder="<?php echo lang('regis_com_postcode'); ?>" readonly>
                            </div>
                            <div class="col-12">
                              <input type="text" class=" input-sso postcode" name="contact_postcode"
                                placeholder="<?php echo lang('regis_com_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                              <div class="dropdown-menu dropdown_addr" id="dropdown_contact_postcode">
                                <!-- <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a> -->
                              </div>
                            </div>

                            <!--<div class="col-12">
                            <select class="form-control selectpicker sso-dropdown" title="รหัสไปรษณีย์" tabindex="-98" name="bus[postcode]">
                              <option value="นาย">นาย</option>
                              <option value="นาง">นาง</option>
                              <option value="นางสาว">นางสาว</option>
                            </select>
                          </div>-->

                          </div>
                        </div>
                        <div class="col-sm-6 col-12 sso-row-input ">
                          <div class="row">
                            <div class="col-12">
                              <?php echo lang('regis_com_province'); ?>&nbsp;<span class="text-danger">*</span>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <input type="text" class=" input-sso" name="contact_province_old" placeholder="<?php echo lang('regis_com_province'); ?>"
                                readonly>
                            </div>

                            <div class="col-12">
                              <select class="form-control selectpicker sso-dropdown btn-province" title="<?php echo lang('regis_com_province'); ?>"
                                tabindex="-98" name="contact_province" data-live-search="false">

                              </select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row sm-mb-14">
                        <div class="col-sm-6 col-12 sso-row-input ">
                          <div class="row">
                            <div class="col-12 txtdetail txtdistrict">
                              <label class="" for=""><?php echo lang('regis_com_district'); ?></label> &nbsp;<span class="text-danger">*</span>
                            </div>
                            <div class="col-12 txtdetail txtdistrict1" style="display:none;">
                             <label for=""><?php echo lang('regis_com_khet'); ?></label> &nbsp;<span class="text-danger">*</span></label> 
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <input type="text" class=" input-sso" name="contact_district_old" placeholder="<?php echo lang('regis_com_district'); ?>"
                                readonly>
                            </div>
                            <div class="col-12">
                              <select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_district'); ?>" tabindex="-98"
                                name="contact_district" data-live-search="false">
                                <option value=""><?php echo lang('regis_province_recom'); ?></option>
                              </select>
                            </div>

                          </div>
                        </div>

                        <div class="col-sm-6 col-12 sso-row-input ">
                          <div class="row">
                            <div class="col-12 txtdetail txtsubdistrict">
                              <label for="" class=""><?php echo lang('regis_com_subdistrict'); ?></label> &nbsp;<span class="text-danger">*</span>
                            </div>
                            <div class="col-12 txtdetail txtsubdistrict1" style="display:none;">
                             <label for=""><?php echo lang('regis_com_kwang'); ?></label> &nbsp;<span class="text-danger">*</span> </label> 
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <input type="text" class=" input-sso" name="contact_subdistrict_old" placeholder="<?php echo lang('regis_com_subdistrict'); ?>"
                                readonly>
                            </div>
                            <div class="col-12">
                              <select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict'); ?>" tabindex="-98"
                                name="contact_subdistrict" data-live-search="false">
                                <option value=""><?php echo lang('regis_district_recom'); ?></option>
                              </select>
                            </div>

                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input ">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_com_address'); ?>&nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="contact_address_old" placeholder="<?php echo lang('regis_com_address'); ?>"
                              readonly>
                            <input type="text" class=" input-sso" name="contact_address" placeholder="<?php echo lang('regis_com_address'); ?>">
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="card w-100 card-company-address  card-sm-show-border ">
                  <h5 class="card-header"> <?php echo lang('regis_contact_header1'); ?></h5>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_title'); ?> &nbsp;<span class="text-danger">*</span>
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

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_fname'); ?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="contact_name" placeholder="<?php echo lang('regis_contact_fname'); ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_sname'); ?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="contact_lastname" placeholder="<?php echo lang('regis_contact_sname'); ?>">
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- en -->
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <span id="text-enf"><?php echo lang('regis_contact_fnameen'); ?>&nbsp;<span class="text-danger">*</span></span>
                            <span id="text-thf" style="display:none;"><?php echo lang('regis_contact_fnameen'); ?>&nbsp;<span
                                class="text-danger">*</span></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="contact_nameEn" placeholder="<?php echo lang('regis_contact_fnameen'); ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <span id="text-enl"><?php echo lang('regis_contact_snameen'); ?>&nbsp;<span class="text-danger">*</span></span>
                            <span id="text-thl" style="display:none;"><?php echo lang('regis_contact_snameen'); ?>&nbsp;<span
                                class="text-danger">*</span></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="contact_lastnameEn"
                              placeholder="<?php echo lang('regis_contact_snameen'); ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end en -->

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_birthday'); ?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="date" class=" input-sso" name="contact_bday" placeholder="<?php echo lang('regis_contact_birthday'); ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_id'); ?> &nbsp;<span class="text-danger">*</span>
                            <!--<span class="text-danger">*</span> -->
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 loader_input">
                            <input type="text" class=" input-sso" name="contact_cid" maxlength="13" placeholder="<?php echo lang('regis_contact_id'); ?>">
                              <button class="btn ck-contact-id-btn">ตรวจสอบ</button>
                          </div>
                        </div>
                      </div>  
                    </div>

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_mail'); ?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="contact_email" placeholder="<?php echo lang('regis_contact_mail'); ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_phone'); ?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">

                            <!--<input type="text" class=" input-sso" name="contact_tel" placeholder="หมายเลขโทรศัพท์">-->
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
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="btn  submitform  btn-con-reg" style="font-weight:bolder"
                  data-form="<?php echo $form_reg_company ?>" data-type="1">
                  <?php echo lang('regis_header'); ?></div>
              </div>

            </div>
          </form>
        </div>



        <div class="tab-pane fade" id="pills-people" role="tabpanel" aria-labelledby="people-tab">
          <form action="#" onsubmit="return false" id="<?php echo $form_reg_people = 'form_reg_people'; ?>"
            autocomplete="off">
<!--             <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12">
                  <div class="col-8">
                  <?php echo lang('regis_citizen'); ?> &nbsp;<span class="text-danger">*</span>
                    </div>
                  </div>

                  <div class="col-12 loader_input">
                    <input class=" input-sso" type="text" name="cid" id="user_id" maxlength="13" require
                      autocomplete="off" placeholder="<?php echo lang('regis_citizen'); ?>">
                  </div>
                  <div class="col-12 minititle">
                  <?php echo lang('regis_fill_recom'); ?>
                  </div>

                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12 d-flex justify-content-between">
                    <div class="col-8">
                      <?php echo lang('regis_pass'); ?>&nbsp;<span class="text-danger">*</span>
                    </div>
                    <div class="col-5 warning-pass" id="pass_nomal">
                    <?php echo lang('regis_com_pass_recom'); ?>
                    </div>
                  </div>
                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="password" id="password_nomal" minlength="8"
                      require autocomplete="off" placeholder="<?php echo lang('regis_pass'); ?>">
                    <i id="show-pass" class="fa fa-eye-slash icon-password-reg"
                      onclick="show_pass(this,'password','form_reg_people')"></i>
                  </div>
                  <div class="col-12 minititle">
                  <?php echo lang('regis_pass_recom'); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-14">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12 d-flex justify-content-between">

                    <div class="col-8">
                        <?php echo lang('regis_pass_confirm'); ?> &nbsp;<span class="text-danger">*</span>
                    </div>
                    <div class="col-5 warning-repass" id="repass_nomal">
                    <?php echo lang('regis_pass_nomatch'); ?>
                    </div>

                  </div>
                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="repassword" id="repassword_nomal"
                      minlength="8" require autocomplete="off" placeholder="<?php echo lang('regis_pass_confirm'); ?>">
                    <i id="show-pass" class="fa fa-eye-slash icon-password-reg"
                      onclick="show_pass(this,'repassword','form_reg_people')"></i>
                  </div>
                </div>
              </div>
            </div> -->
            <div class="col-sm-12">
              <div class="row">
                <div class="card w-100 card-company-address">
                  <h5 class="card-header"><?php echo lang('regis_person_header'); ?></h5>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                              <?php echo lang('regis_contact_title');?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_contact_title');?>"
                                tabindex="-98" name="title">
                                <option value="นาย"><?php echo lang('regis_Mr'); ?></option>
                                <option value="นาง"><?php echo lang('regis_Mrs'); ?></option>
                                <option value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input" style="display:none;">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_citizen');?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="contact_cid" maxlength="13"
                              placeholder="<?php echo lang('regis_citizen');?>">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_fname');?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="name_user" placeholder="<?php echo lang('regis_contact_fname');?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_sname');?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="lastname" placeholder="<?php echo lang('regis_contact_sname');?>">
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- en -->
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <span><?php echo lang('regis_contact_fnameen');?>&nbsp;<span class="text-danger">*</span></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="name_userEn" placeholder="<?php echo lang('regis_contact_fnameen');?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <span><?php echo lang('regis_contact_snameen');?>&nbsp;<span class="text-danger">*</span></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="lastnameEn" placeholder="<?php echo lang('regis_contact_snameen');?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end of en -->
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <span><?php echo lang('regis_birthday') ?>&nbsp;<span class="text-danger">*</span></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="date" name="birthday" placeholder="<?php echo lang('regis_birthday') ?>" class="input-sso">
                          </div>
                        </div>

                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <span><?php echo lang('regis_citizen'); ?> &nbsp;<span class="text-danger">*</span></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 loader_input">
                            <input class=" input-sso" type="text" name="cid" id="user_id" maxlength="13" require
                            autocomplete="off" placeholder="<?php echo lang('regis_citizen'); ?>">
                            <button class="btn ck-citizen-btn">ตรวจสอบ</button>
                          </div>
                          <div class="col-12 minititle">
                            <?php echo lang('regis_fill_recom'); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <span><?php echo lang('regis_pass')?>&nbsp;<span class="text-danger">*</span></span>
                          </div>
                          <div class="col-12 warning-pass" id="pass_nomal">
                            <?php echo lang('regis_com_pass_recom'); ?>
                          </div>
                          <div class="col-12">
                            <input class=" input-sso pass_input" type="text" name="password" id="password_nomal" minlength="8"
                            require autocomplete="off" placeholder="<?php echo lang('regis_pass'); ?>">
                            <i id="show-pass" class="fa fa-eye-slash icon-password-reg"
                            onclick="show_pass(this,'password','form_reg_people')"></i>
                          </div>
                          <div class="col-12 minititle">
                            <?php echo lang('regis_pass_recom'); ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <span> <?php echo lang('regis_pass_confirm'); ?> &nbsp;<span class="text-danger">*</span></span>
                          </div>
                          <div class="col-12 warning-pass" id="pass_nomal">
                            <?php echo lang('regis_pass_nomatch'); ?>
                          </div>
                          <div class="col-12">
                            <input class=" input-sso pass_input" type="text" name="repassword" id="repassword_nomal"
                            minlength="8" require autocomplete="off" placeholder="<?php echo lang('regis_pass_confirm'); ?>">
                            <i id="show-pass" class="fa fa-eye-slash icon-password-reg"
                            onclick="show_pass(this,'repassword','form_reg_people')"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_mail');?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="email" placeholder="<?php echo lang('regis_contact_mail');?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            <?php echo lang('regis_contact_phone');?> &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <!--<input type="text" class=" input-sso" name="tel" placeholder="หมายเลขโทรศัพท์">-->
                            <div id="tel3">
                              <input type="text" class=" input-sso" name="tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone');?>">
                              <input type="hidden" name="tel_country">
                              <input type="hidden" name="tel_code">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="find">


                <div class="row">
                  <div class="card w-100 card-company-address">
                    <h5 class="card-header"><?php echo lang('regis_contact_header');?></h5>
                    <div class="card-body">

                      <div class="row">

                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12">
                              <?php echo lang('regis_com_postcode');?>&nbsp;<span class="text-danger">*</span>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <input type="text" class=" input-sso postcode" name="postcode" placeholder="<?php echo lang('regis_com_postcode');?>"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <div class="dropdown-menu dropdown_addr" id="dropdown_postcode">
                                <!-- <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a> -->
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12">
                              <?php echo lang('regis_com_province');?>&nbsp;<span class="text-danger">*</span>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <!--<input type="text" class=" input-sso" name="provinceTh" placeholder="<?php echo lang('regis_com_province');?>">-->
                              <select class="form-control selectpicker sso-dropdown btn-province" title="<?php echo lang('regis_com_province');?>"
                                tabindex="-98" name="provinceTh" data-live-search="false">

                              </select>

                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12 txtdetail txtdistrict">
                              <label for="" class=""><?php echo lang('regis_com_district');?></label> &nbsp;<span class="text-danger">*</span>
                            </div>
                            <div class="col-12 txtdetail txtdistrict1" style="display:none;">
                              <label for=""><?php echo lang('regis_com_khet'); ?></label> &nbsp;<span class="text-danger">*</span> </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <!--<input type="text" class=" input-sso" name="districtTh" placeholder="<?php echo lang('regis_com_district');?>">-->
                              <select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_district');?>" tabindex="-98"
                                name="districtTh" data-live-search="false">
                                <option value=""><?php echo lang('regis_province_recom'); ?></option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12 txtdetail txtsubdistrict">
                              <label class=""><?php echo lang('regis_com_subdistrict');?></label> &nbsp;<span class="text-danger">*</span>
                            </div>
                            <div class="col-12 txtdetail txtsubdistrict1" style="display:none;">
                            <label for=""><?php echo lang('regis_com_kwang'); ?></label> &nbsp;<span class="text-danger">*</span> </label>  
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <!--<input type="text" class=" input-sso" name="subdistrictTh" placeholder="<?php echo lang('regis_com_subdistrict');?>">-->
                              <select class="form-control selectpicker sso-dropdown" title="<?php echo lang('regis_com_subdistrict');?>" tabindex="-98"
                                name="subdistrictTh" data-live-search="false">
                                <option value=""><?php echo lang('regis_district_recom'); ?></option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- en -->
                      <!--<div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            เลขที่อยู่ (อังกฤษ)
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="addressEn" placeholder="เลขที่อยู่ (อังกฤษ)">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            จังหวัด (อังกฤษ)
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="provinceEn" placeholder="จังหวัด (อังกฤษ)">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            อำเภอ (อังกฤษ)
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="districtEn" placeholder="อำเภอ (อังกฤษ)">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            ตำบล (อังกฤษ)
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="subdistrictEn" placeholder="ตำบล (อังกฤษ)">
                          </div>
                        </div>
                      </div>
                    </div>-->
                      <!-- end of en -->
                      <div class="row">
                        <div class="col-sm-6 col-12 sso-row-input">
                          <div class="row">
                            <div class="col-12">
                              <?php echo lang('regis_com_address');?>&nbsp;<span class="text-danger">*</span>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <input type="text" class=" input-sso" name="addressTh" placeholder="<?php echo lang('regis_com_address');?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="btn  submitform  btn-con-reg" data-form="<?php echo $form_reg_people; ?>" data-type="3"
                  style="font-weight:bolder">
                  <?php echo lang('regis_header');?></div>
              </div>
            </div>
          </form>
        </div>



        <div class="tab-pane fade" id="non-thai-tabs" role="tabpanel" aria-labelledby="non-thai-tab">
          <form action="#" onsubmit="return false" id="<?php echo $form_reg_foreigner = 'form_reg_foreigner'; ?>"
            autocomplete="off">
            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12">
                    <!-- Corporate ID (username) &nbsp;<span class="text-danger">*</span> -->
                    <div class="row">
                      <div class="col-sm-12 col-12 sso-row-input ">
                        <div class="row">
                          <div class="col-6 col-sm-6 col-md-6 col-lg-6 d-flex justify-content-around">
                            <label class="sso-radio pointer "> Corporate ID
                              <input class="ck_address" type="radio" name="data_type" value="2"
                                placeholder="Corporate ID" onclick="radio_foreigner(2)" checked>
                              <span class="checkmark"></span>
                            </label>
                          </div>

                          <div class="col-6 col-sm-6 col-md-6 col-lg-6">

                            <label class="sso-radio pointer "> Passport ID
                              <input class="ck_address" type="radio" name="data_type" value="4"
                                placeholder="Passport ID" onclick="radio_foreigner(4)">
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="col-12 loader_input">
                    <input class=" input-sso" type="text" name="cid" id="user_id" autocomplete="off" maxlength="13"
                      placeholder="Corporate ID">
                    <i id="show-input" class="fa fa-search"></i>
                  </div>
                  <div class="col-12 minititle">
                    You can use letters, numbers
                  </div>

                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12 d-flex justify-content-between">
                    <div class="col-6">
                      Password&nbsp;<span class="text-danger">*</span>
                    </div>
                    <div class="col-6 warning-pass" id="pass_nonthai">
                      Use 8 or more characters
                    </div>
                  </div>
                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="password" id="password_nonthai" minlength="8"
                      require autocomplete="off" placeholder="Password">
                    <i id="show-pass" class="fa fa-eye-slash icon-password-reg"
                      onclick="show_pass(this,'password','form_reg_foreigner')"></i>
                  </div>
                  <div class="col-12 minititle">
                    Use 8 or more characters
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-14">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12 d-flex justify-content-between">

                    <div class="col-8">
                      Re-enter Password&nbsp;<span class="text-danger">*</span>
                    </div>
                    <div class="col-4 warning-repass" id="repass_nonthai">
                      Passwords do not match
                    </div>

                  </div>

                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="repassword" id="repassword_nonthai"
                      minlength="8" require autocomplete="off" placeholder="Re-enter Password">
                    <i id="show-repass" class="fa fa-eye-slash icon-password-reg"
                      onclick="show_pass(this,'repassword','form_reg_foreigner')"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="row">
                <div class="card w-100 card-company-address " id="company-address">
                  <h5 class="card-header">Company Infomation</h5>
                  <div class="card-body">

                    <div class="row foreigner-corporatename">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Corporate name &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="fo_corporate_name" placeholder="Corporate name">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Country &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 selectcountry_div">
                            <!-- <input type="text" class=" input-sso" name="fo_country_name" placeholder="Country"> -->
                            <select class="form-control selectpicker sso-dropdown" title="Country" id="country"
                              tabindex="-98" name="fo_country_name">
                              <option class="country_name">Country</option>
                            </select>
                          </div>
                        </div>
                      </div>



                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Corporate address
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="fo_address" placeholder="Corporate address">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="card w-100 card-company-address ">
                  <h5 class="card-header">Personal Information</h5>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Title Name &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">

                          <!--<div class="col-12">
                            <input type="text" class=" input-sso" name="sub[title]" placeholder="Title Name">
                          </div>-->
                          <div class="col-12">
                            <select class="form-control selectpicker sso-dropdown" title="Title name" tabindex="-98"
                              name="fo_title">
                              <option value="Mr.">Mr.</option>
                              <option value="Mrs.">Mrs.</option>
                              <option value="Miss">Miss</option>
                            </select>
                          </div>
                        </div>
                      </div>

                    </div>

                    <!-- <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            First Name (Thai) &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="fo_nameTh" placeholder="First Name (Thai)">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Last Name (Thai) &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="fo_lastnameTh" placeholder="Last Name (Thai)">
                          </div>
                        </div>
                      </div>
                    </div> -->


                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            First name &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="fo_name" placeholder="First name">
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Last name &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="fo_lastname" placeholder="Last name">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row" id="country_address">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Country &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 selectcountry_div">
                            <!-- <input type="text" class=" input-sso" name="fo_country_name" placeholder="Country"> -->
                            <select class="form-control selectpicker sso-dropdown" title="Country" id="country1"
                              tabindex="-98" name="fo_country_name1">
                              <option class="country_name">Country</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Address
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="fo_address" placeholder="Corporate address">
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Email &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="fo_email" placeholder="Email">
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            Tel &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <!--<input type="text" class=" input-sso" name="fo_tel" placeholder="Tel">-->
                            <div id="tel2">
                              <input type="text" class=" input-sso" name="fo_tel" maxlength="10" placeholder="Tel">
                              <input type="hidden" name="fo_tel_country">
                              <input type="hidden" name="fo_tel_code">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="btn  submitform  btn-con-reg" data-form="<?php echo $form_reg_foreigner ?>" data-type="2"
                  style="font-weight:bolder">
                  Register</div>
              </div>
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
<div class="modal sso-modal fade" id="laser_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 0.3rem !important;">
      <div class="modal-header justify-content-center" style="border-bottom: 1px solid #000000;">
        <h5 class="modal-title text-center " ><?php echo lang('laser_modal_title') ?></h5>
        <button type="button" class="close laser-modal-close" data-dismiss="modal" aria-label="Close" >
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
      <div class="modal-footer d-flex justify-content-center" style="border-top: 1px solid #000000;">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-primary rounded-pill ck-laser-btn" style="background: #4189B7;">ตรวจสอบข้อมูล</button>
      </div>
    </div>
  </div>
</div>
<div class="modal sso-modal fade" id="contact_laser_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 0.3rem !important;">
      <div class="modal-header justify-content-center" style="border-bottom: 1px solid #000000;">
        <h5 class="modal-title text-center " ><?php echo lang('laser_modal_title') ?></h5>
        <button type="button" class="close laser-modal-close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body sso-input">
        <form onsubmit="return false" id="form_laser_company">
          <div class="error-log text-danger d-flex justify-content-center w-100"></div>
          <table class="table table-borderless" style="table-layout: fixed;width: 100%;">
            <thead>
              <th width="70%"></th>
              <th width="50%"></th>
            </thead>
            <tbody>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">เลขหน้าบัตร&nbsp;:</td>
                <td id="contact-laser-modal-citizenid" style="font-size: 1.23rem;color: #427C97;"></td>
                <input type="hidden" name="cid" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">ชื่อ&nbsp;:</td>
                <td id="contact-laser-modal-fname" style="font-size: 1.23rem;color: #427C97;"></td>
                <input type="hidden" name="fname" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">นามสกุล&nbsp;:</td>
                <td id="contact-laser-modal-lname" style="font-size: 1.23rem;color: #427C97;"></td>
                <input type="hidden" name="lname" value="">
              </tr>
              <tr>
                <td class="float-right" style="font-size: 1.23rem">วินเดือนปีเกิด&nbsp;:</td>
                <td id="contact-laser-modal-bday" style="font-size: 1.23rem;color: #427C97;"></td>
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
      <div class="modal-footer d-flex justify-content-center" style="border-top: 1px solid #000000;">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-primary rounded-pill ck-contact-laser-btn" style="background: #4189B7;">ตรวจสอบข้อมูล</button>
      </div>
    </div>
  </div>
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
  })
</script>