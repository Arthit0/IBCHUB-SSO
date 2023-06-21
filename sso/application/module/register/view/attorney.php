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
                  โทร : 02507 7999 | e-mail : 1169@ditp.go.th
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <div class="col-md-8 col-md-none pl-0">
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
    			<div class="col-sm-12 col-md-6 mb-3 sso-row-input">
    				<label for="director_bday"><?php echo lang('regis_birthday') ?></label>
    				<input type="date" class="form-control input-sso" id="director_bday" name="director_bday" placeholder="">
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
    					<input type="text" class="form-control input-sso" name="contact_cid" maxlength="13" placeholder="<?php echo lang('regis_contact_id'); ?>">
    					<button class="btn btn-primary ck-contact-id-btn " type="button"><?php echo lang('regis_check_btn') ?></button> 
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
            <button class="btn btn-login w-100 mitr-r" type="button"><?php echo lang('director_confirm'); ?></button>
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
<?php pr($data) ?>
<script src="<?php echo BASE_PATH; ?>asset/js/page/login/login.js?ver=<?php echo $cash_time; ?>"></script>
<script>
	var tel = document.querySelector("input[name='tel']");
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
	$('.ck-contact-id-btn').click(function() {
	    $("#contact_laser_modal").modal();
	});
	$('#contact_laser_modal').on('show.bs.modal', function(e) {
	    let fname = $('#form_director_consent input[name^="director_name"]').val();
	    let lname = $('#form_director_consent input[name^="director_lastname"]').val();
	    let bday = $('#form_director_consent input[name^="director_bday"]').val();
	    let cid = $('#form_director_consent input[name^="director_cid"]').val();
	    const date = new Date(bday.replace(/-/g, "/"))
	    const thbday = date.toLocaleDateString('th-TH', {
	      year: 'numeric',
	      month: 'long',
	      day: 'numeric',
	    })


	    $("#contact-laser-modal-citizenid").empty().append(cid);
	    $("#contact-laser-modal-fname").empty().append(fname);
	    $("#contact-laser-modal-lname").empty().append(lname);
	    if (thbday == 'Invalid Date') {
	        console.log(thbday)
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

	    var laser_form = $('#form_laser_company').serialize();
	    $.ajax({
	        url:BASE_URL + _INDEX +"/register/ck_laser",
	        method: "post",
	        data:laser_form,
	        success:function(result) {
	            console.log(result);
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
	                laser_verify = 1;
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
</script>