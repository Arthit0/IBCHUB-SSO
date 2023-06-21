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
                  โทร : 02507 7999 | e-mail : 1169@ditp.go.th
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
        <a href="<?php echo BASE_PATH . _INDEX ?>auth?response_type=<?php echo $_SESSION['response_type'] ?>&client_id=<?php echo $_SESSION['client_id'] ?>&redirect_uri=<?php echo $_SESSION['redirect_uri'] ?>" class="back-login text-dark">
          <i class="fas fa-arrow-left"></i> &nbsp;<span><?php echo lang('signin') ?></span>
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
    	<p class="mitr-r _f16 t-mainb mb-0"><?php echo lang('edit_cid') ?> <?php echo $data['cid'] ?></p>
    	<p class="mitr-l _f16 t-mainb mb-0 mt-3"><?php echo lang('director_consent1') ?> <span class="mitr-r"><?php echo $data['member_nameTh'] ?> <?php echo $data['member_lastnameTh'] ?></span> <?php echo lang('director_consent2') ?></p>
    	<form id="form_director" class="mt-4">
    		<input type="hidden" name="member_id" value="<?php echo $data['member_id'] ?>">
    		<div class="form-row sso-input">
    			<div class="col-sm-12 col-md-6 mb-3">
    				<label class="control-label"><?php echo lang('regis_contact_director_mail'); ?> <span class="text-danger"> *</span></label>
            <input type="text" class=" input-sso" name="contact_director_email" placeholder="<?php echo lang('regis_contact_director_mail'); ?>" value="<?php echo ($data['director_email'])?$data['director_email']:'' ?>">
    			</div>
    			<div class="col-sm-12 col-md-6 mb-3 sso-row-input">
    				<label class="control-label"><?php echo lang('regis_contact_director_phone'); ?> <span class="text-danger"> *</span></label>
            <div id="tel4">
              <input type="text" class=" input-sso" name="contact_director_tel" maxlength="15"
              placeholder="<?php echo lang('regis_contact_director_phone'); ?>" value="<?php echo ($data['director_tel'])?$data['director_tel']:'' ?>">
              <input type="hidden" name="contact_director_tel_country" value="<?= empty($data['director_tel_country'])?'':$data['director_tel_country'] ?>">
              <input type="hidden" name="contact_director_tel_code" value="<?= empty($data['director_tel_code'])?'':$data['director_tel_code'] ?>">
            </div>
    			</div>
          <div class="col-sm-12 col-md-6 mt-3">
            <button class="btn btn-login director_submit w-100 mitr-r" type="button"><?php echo lang('director_confirm'); ?></button>
          </div>
    		</div>
    	</form>
    </div>
  </div>
</div>

<script src="<?php echo BASE_PATH; ?>asset/js/page/login/login.js?ver=<?php echo $cash_time; ?>"></script>
<script>
  $(document).ready(function() {
      var tel = document.querySelector("input[name='contact_director_tel']");
      var tel_country = document.querySelector("input[name='contact_director_tel_country']").value;
      console.log(tel_country);
      $(".warning-niti").hide();
      window.intlTelInput(tel, {
          initialCountry: tel_country,
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
  })

  $('.director_submit').on('click', function(e){
    var data = $('#form_director')[0];
    var form = new FormData(data);
    console.log("clicked");
    console.log(form);
    $.ajax({
        url: BASE_URL + _INDEX + "auth/director_form_send",
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
            let style_title =  `style='font-family:Mitr;font-style: normal;font-weight: 400;font-size: 18px;line-height: 28px;'`;
            let style_text =  `style='font-family: Mitr;font-style: normal;font-weight: 300;font-size: 16px;line-height: 25px;text-align: center;'`;
            $('.modal-spin').modal('hide'); //hide loading
            console.log(result);
            if(result.res_code === '00'){
              let html = `<p `+style_text+`>${result.res_text}</p>`;
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกสำเร็จ',
                    html: html,
                    confirmButtonText: 'ตกลง',
                    onClose: RedirectToLogin,
                });
            }else if(result.res_code === '01'){
              //console.log(result.message);
              Swal.fire({
                  icon: "error",
                  title: result.res_text
              });
          }
        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
  })
</script>