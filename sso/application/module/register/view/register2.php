<nav class="navbar navbar-light ">
  <div class="navbar-brand pointer">

    <a href="<?php echo BASE_PATH . _INDEX ?>auth" class="d-block d-md-none">
      <img src="<?php echo BASE_PATH; ?>asset/img/chevron-left-material@3x.png" alt="" style="height: 30px;">
    </a>
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
    background-image: url('<?php echo  BASE_PATH; ?>/asset/img/group.png');
    padding: 0px !important;
    z-index: 1049;
    position: fixed;
    top: 0;
    width: 100vw;
    height: 100vh;
    overflow-x: hidden;
    overflow-y: auto;
    display: none;
    color: #427c97 !important;
  }

  .overflow-body {
    height: 100vh;
    overflow-y: hidden;

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
</style>
<div class="container box-register">
  <div class="row">
    <div class=" col-sm-12 col-md-12 col-lg-12 text-center">
      <a href="<?php echo BASE_PATH . _INDEX ?>auth">
        <img src="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" style="width: 232px;height: 136px;">
      </a>

    </div>
    <div class=" col-sm-12 col-md-12 col-lg-12 text-center title-register">
      ลงทะเบียน
    </div>
    <div class=" col-sm-12 col-md-12 col-lg-12 text-center">
      <ul class="nav nav-pills mb-3 group-pill" id="pills-tab" role="tablist">
        <li class="nav-item ml-auto" role="presentation">
          <a class="nav-link active" id="company-tab" data-toggle="pill" href="#pills-company" role="tab" aria-controls="pills-company" aria-selected="true" onclick="settitle('ลงทะเบียน')">นิติบุคคล (ไทย)</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="foreigner-tab" data-toggle="pill" href="#pills-foreigner" role="tab" aria-controls="pills-foreigner" aria-selected="false" onclick="settitle('REGISTER')">Foreigner</a>
        </li>
        <li class="nav-item mr-auto" role="presentation">
          <a class="nav-link" id="people-tab" data-toggle="pill" href="#pills-people" role="tab" aria-controls="pills-people" aria-selected="false" onclick="settitle('ลงทะเบียน')">บุคคลทั่วไป</a>
        </li>
      </ul>
    </div>
    <div class=" col-sm-12 sm-p-0-30">
      <div class="tab-content sso-input" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="company-tab">

          <form action="#" onsubmit="return false" id="<?php echo $form_reg_company = 'form_reg_company'; ?>" autocomplete="off">
            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12">
                    เลขนิติบุคคล (Username)&nbsp;<span class="text-danger">*</span>
                  </div>

                  <div class="col-12 loader_input">

                    <input class=" input-sso " type="text" name="cid" autocomplete="off" placeholder="เลขนิติบุคคล">
                  </div>
                  <div class="col-12 minititle">
                    กรอกตัวอักษร หรือตัวเลขให้ครบถ้วน (บูรณาการฐานข้อมูลจากกรมพัฒนาธุรกิจ)
                  </div>

                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12">
                    รหัสผ่าน (Password)&nbsp;<span class="text-danger">*</span>
                  </div>

                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="password" minlength="8" require autocomplete="off" placeholder="รหัสผ่าน">
                  </div>
                  <div class="col-12 minititle">
                    ใช้อักขระ 8 ตัวขึ้นไป
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-14 ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12">
                    ยืนยันรหัสผ่าน (Re-enter Password)&nbsp;<span class="text-danger">*</span>
                  </div>

                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="repassword" minlength="8" require autocomplete="off" placeholder="ยืนยันรหัสผ่าน">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">

              <div class="row">
                <div class="card w-100 card-comapny-member  ">
                  <h5 class="card-header">ข้อมูลบริษัท</h5>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            ชื่อบริษัท&nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="name_user" placeholder="ชื่อบริษัท" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            เลขที่อยู่
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="address" placeholder="เลขที่อยู่" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            จังหวัด
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="province" placeholder="จังหวัด" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            อำเภอ
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="district" placeholder="อำเภอ" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            ตำบล
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="subdistrict" placeholder="ตำบล" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row ">
                          <div class="col-12">
                            เลขรหัสไปรษณีย์
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="postcode" placeholder="เลขรหัสไปรษณีย์" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="footer-people">
                        หากท่านต้องการปรับเปลี่ยนข้อมูลโปรดติดต่อกรมพัฒนาธุรกิจการค้า
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="card w-100 card-company-address  card-sm-show-border ">
                  <h5 class="card-header card-sm-show-header">ที่อยู่ติดต่อ</h5>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12 col-12 sso-row-input ">
                        <div class="row">
                          <div class="col-4 col-sm-4 col-md-3 col-lg-2">


                            <label class="sso-radio pointer"> ที่อยู่ใหม่
                              <input class="ck_address radio_new_adress" type="radio" name="ck_address" checked value="1" placeholder="ที่อยู่ใหม่">
                              <span class="checkmark"></span>
                            </label>
                          </div>

                          <div class="col-8 col-sm-6 col-md-8 col-lg-6">
                            <label class="sso-radio pointer"> ที่อยู่เดียวกับที่จดทะเบียน
                              <input class="ck_address radio_old_adress" type="radio" name="ck_address" value="2" placeholder="ที่อยู่เดียวกับที่จดทะเบียน">
                              <span class="checkmark"></span>
                            </label>

                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input ">
                        <div class="row">
                          <div class="col-12">
                            เลขที่อยู่
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="bus[address]" placeholder="เลขที่อยู่">
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input ">
                        <div class="row">
                          <div class="col-12">
                            จังหวัด
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="bus[province]" placeholder="จังหวัด">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input ">
                        <div class="row">
                          <div class="col-12">
                            อำเภอ
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="bus[district]" placeholder="อำเภอ">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row sm-mb-14">
                      <div class="col-sm-6 col-12 sso-row-input ">
                        <div class="row">
                          <div class="col-12">
                            ตำบล
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="bus[subdistrict]" placeholder="ตำบล">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input ">
                        <div class="row ">
                          <div class="col-12">
                            เลขรหัสไปรษณีย์
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="bus[postcode]" placeholder="เลขรหัสไปรษณีย์">
                          </div>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
              <div class="row">
                <div class="card w-100 card-company-address  card-sm-show-border ">
                  <h5 class="card-header">ข้อมูลบุคคล</h5>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            คำนำหน้าชื่อ &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="sub[title]" placeholder="คำนำหน้าชื่อ">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            เลขประจำตัวประชาชน &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="sub[cid]" placeholder="เลขประจำตัวประชาชน">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            ชื่อ &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="sub[name]" placeholder="ชื่อ">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            นามสกุล &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="sub[lastname]" placeholder="นามสกุล">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            อีเมล &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="sub[email]" placeholder="อีเมล">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            หมายเลขโทรศัพท์ &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="sub[tel]" placeholder="หมายเลขโทรศัพท์">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="btn  submitform  btn-con-reg" data-form="<?php echo $form_reg_company ?>" data-type="1">ลงทะเบียน</div>
              </div>

            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="pills-foreigner" role="tabpanel" aria-labelledby="foreigner-tab">
          <form action="#" onsubmit="return false" id="<?php echo $form_reg_foreigner = 'form_reg_foreigner'; ?>" autocomplete="off">
            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12">
                    <!-- Corporate ID (username) &nbsp;<span class="text-danger">*</span> -->
                    <div class="row">
                      <div class="col-sm-12 col-12 sso-row-input ">
                        <div class="row">
                          <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                            <label class="sso-radio pointer "> Corporate ID
                              <input class="ck_address" type="radio" name="data_type" checked value="2" placeholder="Corporate ID" onclick="radio_foreigner(2)">
                              <span class="checkmark"></span>
                            </label>
                          </div>

                          <div class="col-6 col-sm-6 col-md-6 col-lg-6">

                            <label class="sso-radio pointer "> Passport ID
                              <input class="ck_address" type="radio" name="data_type" value="4" placeholder="Passport ID" onclick="radio_foreigner(4)">
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="col-12">
                    <input class=" input-sso" type="text" name="cid" autocomplete="off" placeholder="Corporate ID">
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
                  <div class="col-12">
                    Password &nbsp;<span class="text-danger">*</span>
                  </div>

                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="password" minlength="8" require autocomplete="off" placeholder="Password">
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
                  <div class="col-12">
                    Re-enter Password &nbsp;<span class="text-danger">*</span>
                  </div>

                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="repassword" minlength="8" require autocomplete="off" placeholder="Re-enter Password">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="row">
                <div class="card w-100 card-company-address ">
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
                            <input type="text" class=" input-sso" name="name_user" placeholder="Corporate name">
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
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="country_name" placeholder="Country">
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
                            <input type="text" class=" input-sso" name="address" placeholder="Corporate address">
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
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="sub[title]" placeholder="Title Name">
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            First name &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="sub[name]" placeholder="First name">
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
                            <input type="text" class=" input-sso" name="sub[lastname]" placeholder="Last name">
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
                            <input type="text" class=" input-sso" name="sub[email]" placeholder="Email">
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
                            <input type="text" class=" input-sso" name="sub[tel]" placeholder="Tel">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="btn  submitform  btn-con-reg" data-form="<?php echo $form_reg_foreigner ?>" data-type="2">Register</div>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="pills-people" role="tabpanel" aria-labelledby="people-tab">
          <form action="#" onsubmit="return false" id="<?php echo $form_reg_people = 'form_reg_people'; ?>" autocomplete="off">
            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12">
                    เลขบัตรประจำตัวประชาชน (Username) &nbsp;<span class="text-danger">*</span>
                  </div>

                  <div class="col-12">
                    <input class=" input-sso" type="text" name="cid" require autocomplete="off" placeholder="เลขบัตรประจำตัวประชาชน">
                  </div>
                  <div class="col-12 minititle">
                    กรอกตัวอักษร หรือตัวเลขให้ครบถ้วน
                  </div>

                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12">
                    รหัสผ่าน (Password)&nbsp;<span class="text-danger">*</span>
                  </div>

                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="password" minlength="8" require autocomplete="off" placeholder="รหัสผ่าน">
                  </div>
                  <div class="col-12 minititle">
                    ใช้อักขระ 8 ตัวขึ้นไป
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-14">
              <div class="col-sm-12 col-md-6 col-lg-5 m-0-auto">
                <div class="row">
                  <div class="col-12">
                    ยืนยันรหัสผ่าน (Re-enter Password)&nbsp;<span class="text-danger">*</span>
                  </div>

                  <div class="col-12">
                    <input class=" input-sso pass_input" type="text" name="repassword" minlength="8" require autocomplete="off" placeholder="ยืนยันรหัสผ่าน">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="row">
                <div class="card w-100 card-company-address">
                  <h5 class="card-header">ข้อมูลบุคคล</h5>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            คำนำหน้าชื่อ &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="title" placeholder="คำนำหน้าชื่อ">
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            ชื่อ &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="name_user" placeholder="ชื่อ">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            นามสกุล &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="lastname" placeholder="นามสกุล">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            อีเมล &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="email" placeholder="อีเมล">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            หมายเลขโทรศัพท์ &nbsp;<span class="text-danger">*</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="tel" placeholder="หมายเลขโทรศัพท์">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="card w-100 card-company-address">
                  <h5 class="card-header">ที่อยู่ติดต่อ</h5>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            เลขที่อยู่
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="address" placeholder="เลขที่อยู่">
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            จังหวัด
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="province" placeholder="จังหวัด">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            อำเภอ
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="district" placeholder="อำเภอ">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            ตำบล
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="subdistrict" placeholder="ตำบล">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12 sso-row-input">
                        <div class="row">
                          <div class="col-12">
                            เลขรหัสไปรษณีย์
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <input type="text" class=" input-sso" name="postcode" placeholder="เลขรหัสไปรษณีย์">
                          </div>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
              <div class="row">
                <div class="btn  submitform  btn-con-reg" data-form="<?php echo $form_reg_people; ?>" data-type="3">ลงทะเบียน</div>
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
        <span class=>

        </span>
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
      ได้รับสิทธิ์เข้าสู่ฐานข้อมูลกรมฯ เพื่อค้นหารายชื่อผู้นำเข้า หรือแก้ไขข้อมูลบริษัท และสมัครเข้าร่วมกิจกรรมทางออนไลน์
      มีสิทธิสมัครเข้าร่วมกิจกรรมกับกรมฯ ที่จัดทั้งในและต่างประเทศ </p>

    <p style="margin-bottom: 0;">เงื่อนไขและกฎระเบียบการสมัครสมาชิก</p>
    <p style="margin-bottom: 0;">1.การพิจารณาเป็นอำนาจของกรมส่งเสริมการค้า ระหว่างประเทศ</p>
    <p style="margin-bottom: 0;">2.ผู้สมัครต้องกรอกข้อมูลการสมัครให้ถูกต้องและ ครบถ้วน</p>
    <p style="margin-bottom: 0;">3.ต้องผ่านการตรวจสอบ ณ สำนักงาน/โรงงาน หรือเรียกดูสินค้า ว่าผู้ประกอบการและสินค้ามีตัว ตนจริง ตามนโยบายของกรม</p>
    <p style="margin-bottom: 0;">4.กรมจะพิจารณาอนุมัติการเป็นสมาชิก หรือเข้าร่วม โครงการ/กิจกรรม จากข้อมูลและเอกสารแนบใน ระบบ ของผู้สมัครเท่านั้น</p>
    <p style="margin-bottom: 0;">5.การแนบเอกสารในระบบทุกฉบับจะต้องประทับตรา บริษัท และผู้มีอำนาจลงนาม</p>
    <p style="margin-bottom: 0;">6.เอกสารแนบในระบบจะต้องครบถ้วนสมบรูณ์ หาก มีความผิดพลาดหรือต้องแก้ไขหรือขอเอกสารเพิ่ม เติม กรมจะแจ้งให้ผู้สมัครทราบและผู้สมัครต้องรีบ ดำเนินการตามที่กรมแจ้ง</p>
    <p style="margin-bottom: 0;">7.ในกรณีบริษัทดำเนินการส่งออกแล้ว และต้องการ ปรับสถานะจาก Pre-EL เป็น EL บริษัทต้องส่ง หนังสือขอปรับสถานะพร้อมแนบสำเนาหลักฐาน การส่งออก เช่น L/C หรือ B/L หรือในกรณีที่ ลูกค้าต่างประเทศจัดการขนส่งสินค้าเอง กรุณา แนบใบเสร็จสินค้าที่มีชื่อลูกค้าในต่างประเทศ เพื่อ ให้กรมพิจารณาปรับสถานะ</p>
    <p style="margin-bottom: 0;">8.หากมีการแก้ไขข้อมูลผู้สมัครจะต้องดำเนินการ แก้ไขผ่านระบบนี้เท่านั้น เว้นแต่มีกรณีที่ผู้สมัครไม่ สามารถแก้ไขได้ด้วยตนเอง</p>
    <p style="margin-bottom: 0;">9.ผู้สมัครยอมรับว่าข้อมูลในการสมัครผ่านระบบนี้ เป็นความจริงทุกประการ</p>
    <p style="margin-bottom: 0;">10.หากภายหลังพบว่าข้อมูลของผู้สมัครเป็นเท็จหรือ ไม่ตรงตามเงื่อนไข กรมจะถือว่าการสมัครครั้งนี้ เป็นโมฆะ</p>
    <p style="margin-bottom: 0;">11.กรมฯ ขอสงวนสิทธิการเปลี่ยนแปลงเงื่อนไขและ สิทธิ์ประโยชน์ต่างๆ ในการสมัครสมาชิกนี้ โดยมิ ต้องแจ้งให้ทราบล่วงหน้า</p>
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
    <!-- </div>
    </div> -->
  </div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/register/main_register.js"></script>