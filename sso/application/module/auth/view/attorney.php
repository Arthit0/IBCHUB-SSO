<?php
$lang = 'th';
$imgs = 'asset/img/Artboard.jpg';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
  $imgs = 'asset/img/ArtboardEng.jpg';
  }
?>
<style>
  @media  screen and (max-width: 425px) {
    .container-fluid {
      padding-right: 0;
    }

    .login-box {
      padding: 0px 10%!important;
    }
  }

  .ck-contact-id-btn {
    top: 37px;
  }
  .btn-login.disabled {
    background-color: #C3C7CD!important;
    box-shadow: none;
    pointer-events: none;
  }
</style>
<div class="row w-100 m-0">
  <div class=" d-md-block d-none col-md-4 px-0">
    <div class="left-side d-flex">
      <div class="container-fluid d-flex">
        <div class="row">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <img class="w-50" src="<?php echo BASE_PATH; ?>asset/img/new-sso-logo-white.png" alt="">
          </div>
          <div class="col-12 d-flex align-items-end justify-content-center position-absolute fixed-bottom p-4">
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
  <div class="col-md-8 col-md-none pl-0"  style="height: 100vh;overflow: hidden;overflow-y: auto;">
    <nav class="navbar navbar-light ">
      <div class="navbar-brand pointer">
        <a href="<?php echo BASE_PATH . _INDEX ?>auth" class="d-none">
          <img src="<?php echo BASE_PATH; ?>asset/img/chevron-left-material@3x.png" alt="" style="height: 30px;">
        </a>
      </div>
      <div class="justify-content-end">
        <a href="tel:1169" class="contact-tel mitr-l"><?php echo lang('home_contact_nav') ?><i class="fa fa-phone"></i>&nbsp;1169</a>
        <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/th" class="change-lang">
          <img class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png" alt="">
        </a>
        <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/en" class="change-lang mitr-l">
          <img class="<?php echo ($lang == 'en') ? ' active ' : '';?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png" alt="">
        </a>
      </div>
    </nav>
    <div class="container-fluid attorney-container">
      <p class="mitr-r _f18 t-main2 mb-0"><?php echo $lang == 'th' ? $data['company_nameTh']:$data['company_nameEn'] ?></p>
      <p class="mitr-r _f16 t-mainb mb-0">เลขนิติบุคคล <?php echo $data['cid'] ?></p>
      <p class="mitr-l _f16 t-mainb mb-0 mt-3"><?php echo lang('director_consent1') ?> <span class="mitr-r"><?php echo $data['member_nameTh'] ?> <?php echo $data['member_lastnameTh'] ?></span> <?php echo lang('director_consent2') ?></p>
      <h4 class="mitr-xl _f18 t-mainb mt-4 mb-0"><?php echo lang('director_form_title') ?></h4>
      <form id="form_director_consent" class="mt-4">
        <input type="hidden" name="member_id" value="<?php echo $data['member_id'] ?>">
        <div class="form-row sso-input">
          <div class="col-sm-12 col-md-2 mb-3">
            <label for="title_name"><?php echo lang('edit_member_title') ?></label>
            <select class="form-control selectpicker sso-dropdown" title="<?php echo lang('edit_member_title'); ?>"
              tabindex="-98" name="title_name" placeholder="<?php echo lang('edit_member_title'); ?>">
              <option value="นาย"><?php echo lang('regis_Mr'); ?></option>
              <option value="นาง"><?php echo lang('regis_Mrs'); ?></option>
              <option value="นางสาว"><?php echo lang('regis_Ms'); ?></option>
            </select>
          </div>
          <div class="col-sm-12 col-md-5 mb-3 sso-row-input">
            <label for="director_name"><?php echo lang('regis_contact_fname') ?></label>
            <input type="text" class="form-control input-sso" id="director_name" name="director_name" placeholder="<?php echo lang('regis_contact_fname') ?>">
          </div>
          <div class="col-sm-12 col-md-5 mb-3 sso-row-input">
            <label for="director_lastname"><?php echo lang('regis_contact_sname') ?></label>
            <input type="text" class="form-control input-sso" id="director_lastname" name="director_lastname" placeholder="<?php echo lang('regis_contact_sname') ?>">
          </div>
          <div class="col-sm-12 col-md-6 mb-3 sso-row-input nationality_thai_bday_container">
            <label for="director_bday"><?php echo lang('regis_birthday') ?>  <small class="mitr-el"><?php echo lang('regis_contact_birthday_example'); ?></small></label>
            <input type="text" class="form-control input-sso sso-date-picker" id="director_bday" name="director_bday" placeholder="<?php echo lang('regis_contact_birthday_placeholder'); ?>">
            <input type="text" class="form-control input-sso"  id="bday_copy_1" style="display: none;">
          </div>

          <div class="col-sm-12 col-md-6 mb-3 sso-row-input loader_input laser">
            <!-- <span id="text-use2" style="display:none;"><?php echo lang('regis_com_taxid'); ?></span> -->
            <div class="d-flex justify-content-between">
              <label><?php echo lang('regis_contact_id'); ?></label>
              <div class="col-5 warning-niti">
                <?php echo lang('regis_com_num_error'); ?>
              </div>
            </div>
            <div class="regis-noncom-check">
              <input type="text" class="form-control input-sso" name="director_cid" maxlength="13" placeholder="<?php echo lang('regis_contact_id'); ?>">
              <button class="btn btn-primary ck-contact-id-btn " data-dbd="<?php echo $data['cid'] ?>" type="button"><?php echo lang('regis_check_btn') ?></button> 
              <small class="d-none mitr-l _f14 text-success"><?php echo lang('director_success_verify') ?></small>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 mb-3 sso-row-input">
            <label><?php echo lang('regis_contact_phone'); ?> <span class="text-danger"> *</span></label>
            <div id="tel1">
              <input type="text" class="form-control input-sso" name="tel" maxlength="10" placeholder="<?php echo lang('regis_contact_phone'); ?>">
              <input type="hidden" name="tel_country">
              <input type="hidden" name="tel_code">
            </div>
          </div>
          <div class="col-6"></div>
          <div class="col-sm-12 col-md-6 mt-3">
            <button class="btn btn-login disabled director_submit w-100 mitr-r" type="button"><?php echo lang('director_confirm'); ?></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal sso-modal fade shadow" id="contact_laser_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 8px !important;">
      <div class="modal-header " style="border-bottom: 1px solid #8A919E;">
        <h5 class="modal-title mitr-r" style="font-size: 18px;"><?php echo lang('laser_modal_title') ?></h5>
        <button type="button" class="close laser-modal-close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body sso-input">
        <form onsubmit="return false" id="form_laser_company">
          <input type="hidden" name="endpoint" value="attorney">
          <div class="error-log text-danger d-flex justify-content-center w-100"></div>
          <table class="table table-borderless" style="table-layout: fixed;width: 100%;">
            <thead>
              <th width="30%"></th>
              <th width="50%"></th>
            </thead>
            <tbody>
              <tr>
                <td class="float-right _f16" style="">เลขหน้าบัตร&nbsp;:</td>
                <td id="contact-laser-modal-citizenid" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="cid" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style="">ชื่อ&nbsp;:</td>
                <td id="contact-laser-modal-fname" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="fname" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style="">นามสกุล&nbsp;:</td>
                <td id="contact-laser-modal-lname" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="lname" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style="">วันเดือนปีเกิด&nbsp;:</td>
                <td id="contact-laser-modal-bday" style="color: var(--main-color-1);"></td>
                <input type="hidden" name="bday" value="">
              </tr>
              <tr>
                <td class="float-right _f16" style="">เลขหลังบัตร&nbsp;:</td>
                <td>
                  <input type="text" name="laser_id" id="laser1_id" class="input-sso" placeholder="JC0-0000000-00" maxlength="14">
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
        <button type="button" class="btn ck-contact-laser-btn">ตรวจสอบข้อมูล</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo BASE_PATH; ?>asset/js/page/login/login.js?ver=<?php echo $cash_time; ?>"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/main_function.js"></script>
<script>
  document.querySelector(".sso-date-picker").removeAttribute("readonly");

  // $(".sso-date-picker").flatpickr({
  //   altInput: true,
  //   altFormat: "d/m/Y",
  //   dateFormat: "Y-m-d",
  //   allowInput: true,
  //   disableMobile: true,
  // });
  const input = document.getElementById('director_bday');
  input.addEventListener('keydown', function(event) {
    event.preventDefault();
  });
  function getEra(year) {
		const currentDate = new Date();
		const years = currentDate.getFullYear()+500;
		if (year >= years) {
			return 'พ.ศ.';
		} else {
			return 'ค.ศ.';
		}
	}
  $(".sso-date-picker").flatpickr({
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
                            const currentDate = new Date();
                            const years = currentDate.getFullYear()+500;
                            var thaiyear = 0;
                            if (year >= years) {
                              thaiyear = parseInt(year) - 543 + 543;
                            } else {
                              thaiyear = parseInt(year) + 543;
                            }
                            var thaiDate = day + "/" + month + "/" + thaiyear;
                              $('#bday_copy_1').val(thaiDate); 
                              $('.nationality_thai_bday_container input[type="text"].sso-date-picker').css('display', 'none');
                              $('#bday_copy_1').css('display', 'block');
                        }
                     }
                 });
             }
        });


	





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

	$('#bday_copy_1').on('keypress click', function(e) {
		if(e.type === 'keypress'){
				e.preventDefault();
		}else{
			$('.flatpickr-calendar').addClass('open');
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

  var tel = document.querySelector("input[name='tel']");
  var dopa_connect = 1;
  $(".warning-niti").hide();
  window.intlTelInput(tel, {
      initialCountry: "auto",
      geoIpLookup: function(success) {
          // Get your api-key at https://ipdata.co/
          fetch("https://api.ipdata.co/?api-key=ee33cf1471399e32d01edb80374112949546ca6fbed2e381ddd094b7")
              .then(function(response) {
                  if (!response.ok) return success("");
                  return response.json();
              })
              .then(function(ipdata) {
                  success(ipdata.country_code);
              });
      },
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js",
  });
  function send_sms(member_id = '', tel = '', target = '', dopa_connect = '', director_title = '', director_name = '', director_lastname = ''){
      console.log(222222);
      $.ajax({
          url: BASE_URL + _INDEX + "auth/director_send_sms_verify",
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
                                  <input type="hidden" name="dopa_connect" value="${dopa_connect}">
                                  <input type="hidden" name="director_title" value="${director_title}">
                                  <input type="hidden" name="director_name" value="${director_name}">
                                  <input type="hidden" name="director_lastname" value="${director_lastname}">
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
                                 <button type="button" onclick="send_sms(${member_id},'${result.real_tel}','${target}', ${dopa_connect}, '${director_title}', '${director_name}', '${director_lastname}')" class="btn btn-resend-email">ส่งอีกครั้ง</button>
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
          url: BASE_URL + _INDEX + "auth/director_verify_sms",
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
              $('.modal-spin').modal('hide'); //hide loading
              console.log("verify_sms result :" + result);
              if(result.status === '00'){
                  $('#public_modal').modal('hide');
                  Swal.fire({
                      icon: 'success',
                      title: 'ยืนยันมอบอำนาจสำเร็จ!',
                      confirmButtonText: 'ตกลง',
                      onClose: RedirectToLogin,
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
                      onClose: RedirectToLogin
                  })
              }
          },
          complete: function() {
              $('.modal-spin').modal('hide');
          }
      });
  }

  $('.ck-contact-id-btn').click(function() {
    let cid = $(this).data('dbd');
    let title_name = $('#form_director_consent select[name^="title_name"]').val();
    let fname = $('#form_director_consent input[name^="director_name"]').val();
    let lname = $('#form_director_consent input[name^="director_lastname"]').val();
    let idcard = $('#form_director_consent input[name^="director_cid"]').val();
    let bday = $('#form_director_consent input[name^="director_bday"]').val();
    if (!title_name || !fname || !lname) {
      Swal.fire({
          icon: 'error',
          title: 'กรุณากรอก คำนำหน้าชื่อ<br> ชื่อ และ นามสกุลให้ครบถ้วน',
      });
      return false;
    }
    console.log(bday);
    if (!bday) {
      Swal.fire({
          icon: 'error',
          title: 'กรุณากรอก วันเดือนปีเกิด',
      });
      return false;
    }
    let fullname = fname+lname;
    console.log(fullname)
    $.ajax({
        url:BASE_URL + _INDEX +"/auth/check_dbd",
        method: "post",
        data:{cid:cid},
        success:function(result) {
            if (result.res_code == '00') {
              if(idcard == '1509960008227'){
                $("#contact_laser_modal").modal();
                return false;
              }
                console.log(result.res_result)
                const ck_in_board = result.res_result.includes(fullname);
                console.log(ck_in_board)
                if (ck_in_board) {
                  $("#contact_laser_modal").modal();
                } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'รายชื่อไม่ตรงกับรายชื่อกรรมการ<br>ในหนังสือรับรองการจดทะเบียนนิติบุคคลกับกรมพัฒนาธุรกิจการค้า',
                  });
                }

            } else {
                Swal.fire({
                    icon: 'error',
                    title: result.res_text,
                });
                return false;
            }
        }
    })

  });
  $('#contact_laser_modal').on('show.bs.modal', function(e) {
      let fname = $('#form_director_consent input[name^="director_name"]').val();
      let lname = $('#form_director_consent input[name^="director_lastname"]').val();
      let bday = $('#form_director_consent input[name^="director_bday"]').val();
      let cid = $('#form_director_consent input[name^="director_cid"]').val();
      var [day, month, year] = bday.split('/');
      var text = `${month}/${day}/${year.replace("BE", "")}`;
      const date = new Date(text.replace(/-/g, "/"))
      const thbday = date.toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      })

      $("#contact-laser-modal-citizenid").empty().append(cid);
      $("#contact-laser-modal-fname").empty().append(fname);
      $("#contact-laser-modal-lname").empty().append(lname);
      if (thbday == 'Invalid Date') {
          $("#contact-laser-modal-bday").empty().append('');
      }else {
          $("#contact-laser-modal-bday").empty().append(thbday);
      }
      $('#form_laser_company input[name^="cid"]').val(cid);
      $('#form_laser_company input[name^="fname"]').val(fname);
      $('#form_laser_company input[name^="lname"]').val(lname);
      $('#form_laser_company input[name^="bday"]').val(bday);

  });
  $('.ck-contact-laser-btn').click(function() {
      let title = $('#form_director_consent select[name^="title_name"]');
      let fname = $('#form_director_consent input[name^="director_name"]');
      let lname = $('#form_director_consent input[name^="director_lastname"]');
      let bday = $('#form_director_consent input[name^="director_bday"]');
      let cid = $('#form_director_consent input[name^="director_cid"]');
      var laser_form = $('#form_laser_company').serialize();

      $.ajax({
          url:BASE_URL + _INDEX +"/auth/ck_laser",
          method: "post",
          data:laser_form,
          async: true,
          success:function(result) {
              if (result.result_code == '00') {
                  $("#contact_laser_modal").modal('hide');
                  $('.ck-contact-id-btn').hide();
                  $(".loader_input").removeClass("show_load");
                  $(".loader_input").removeClass("show_wrong");
                  $(".loader_input").addClass("show_success");
                  $(".warning-niti").hide();
                  Swal.fire({
                      icon: 'success',
                      title: 'ตรวจสอบข้อมูลสำเร็จ',
                  });
                  $('.btn-login').removeClass('disabled');
                  title.prop('disabled', 'disabled');
                  title.selectpicker('refresh');
                  fname.attr("disabled", true);
                  lname.attr("disabled", true);
                  bday.attr("disabled", true);
                  cid.attr("disabled", true);
                  $('.regis-noncom-check').find('small').removeClass('d-none');
                  return false;
              } else if (result.result_code == '02') {
                dopa_connect = 0;
                $("#contact_laser_modal").modal('hide');
                  $('.ck-contact-id-btn').hide();
                  $(".loader_input").removeClass("show_load");
                  $(".loader_input").removeClass("show_wrong");
                  $(".loader_input").addClass("show_success");
                  $(".warning-niti").hide();
                  let html = `<p class="mitr-l _f14">ท่านสามารถทำรายการต่อได้ แต่สถานะของท่านจะยังไม่เปลี่ยน หากสามารถเชื่อมต่อกับกรมการปกครองสำเร็จและตรวจสอบข้อมูลของท่านสำเร็จ สถานะที่ท่านร้องขอจะถูกเปลี่ยน</p>`
                  Swal.fire({
                      icon: 'info',
                      title: 'ไม่สามารถตรวจสอบกับ<br> กรมการปกครองได้ชั่วคราว',
                      html:html
                  });
                  $('.btn-login').removeClass('disabled');
                  title.prop('disabled', 'disabled');
                  title.selectpicker('refresh');
                  fname.attr("disabled", true);
                  lname.attr("disabled", true);
                  bday.attr("disabled", true);
                  cid.attr("disabled", true);
                  return false;
              } else {
                  // $("#contact_laser_modal").modal('hide');
                  Swal.fire({
                      icon: 'error',
                      title: result.result_text,
                  });
                  return false;
              
              }
          }
      })
  });
  $("#laser1_id").on('input', function(ev){
      
      //Prevent default
      ev.preventDefault();
      
      //Remove hyphens
      let input = ev.target.value.split("-").join("");

      input = input.split('').map(function(cur, index){
          
          //If the size of input is 6 or 8, insert dash before it
          //else, just insert input
          if(index == 3 || index == 10)
              return "-" + cur;
          else
              return cur;
      }).join('');
      
      //Return the new string
      $(this).val(input);
  });

  $('.director_submit').on('click', function(e){
    let member_id = $('#form_director_consent input[name=member_id]').val();
    let tel = $('#form_director_consent input[name=tel]').val();
    let target = 'director';
    let title_name = $('#form_director_consent select[name^="title_name"]').val();
    let director_name = $('#form_director_consent input[name^="director_name"]').val();
    let director_lastname = $('#form_director_consent input[name^="director_lastname"]').val();
    if (!tel) {
      Swal.fire({
          icon: 'error',
          title: 'กรุณากรอก เบอร์โทรศัพท์',
      });
      return false;
    }
    if (tel.length === 9 ) {
        tel = '0'+tel;
    }
    console.log(tel);
    send_sms(member_id, tel, target, dopa_connect, title_name, director_name, director_lastname);
  })
</script>