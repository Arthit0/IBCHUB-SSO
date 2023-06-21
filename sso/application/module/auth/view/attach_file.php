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
  <div class="col-md-8 col-md-none px-0" style="height: 100vh;overflow: hidden;overflow-y: auto;">
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
    <div class="container-fluid attach-container">
    	<div class="row">
    		<div class="col-12 d-flex justify-content-center">
    			<div class="attach-radio-container mb-4">
    				<div class="row">
    					<div class="col-sm-12 col-md-6 col-lg-6 d-inline-flex align-items-center">
    						<label class="sso-radio pointer text-white">
    							<div class="mitr-r _f16" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
    								<?php echo lang('attach_checkbox1'); ?>
    							</div>
    							<input class="ck_address ck_default" type="radio" id="data_type" name="data_type" value="1" checked>
    							<span class="checkmark"></span>
    						</label>
    					</div>
    					<div class="col-sm-12 col-md-6 col-lg-6 d-inline-flex align-items-center">
    						<label class="sso-radio pointer text-white">
    							<div class="mitr-r _f16" href="<?php echo BASE_PATH . _INDEX ?>auth/forget">
    								<?php echo lang('attach_checkbox2'); ?>
    							</div>
    							<input class="ck_address disabled" type="radio" id="data_type" name="data_type" id="niti_no" value="6" disabled>
    							<span class="checkmark"></span>
    						</label>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="col sm-12 d-flex justify-content-center">
          <div class="attach-content-container">
            <div class="row">
              <div class="col-12 mb-2">
                <p class="mitr-r _f18"><?php echo lang('attach_document') ?><span class="mitr-l _f18"><?php echo lang('attach_document_example') ?></span></p>
              </div>
              <div class="col-12 px-0">
                <!--begin::Form-->
                <form id="form_attach_file" enctype="multipart/form-data" method="POST">
                  <div class="form-group col-sm-12">
                     <div id="dropzone" class="dropzone shadow"></div>
                  </div>
              </div>
              <div class="col 12" id="files-name">
                <!-- <div class="files-name w-100 mb-2">
                  <p class="mb-0"><i class="fa-solid fa-file"></i>&nbsp;ชื่อไฟล์ <span class="float-right text-danger"><i class="fa-solid fa-trash"></i></span></p>
                </div> -->
              </div>
              <div class="col-12 text-center">
                <p class="mb-0 mitr-r _f16"><?php echo lang('attach_note') ?><span class="mitr-l"><?php echo lang('attach_note_detail') ?></span></p>
              </div>
              <div class="col-12 text-center mt-4">
                <button type="submit" class="btn-login submit-dropzone w-50 border-none mitr-r _f16"><?php echo lang('attach_file_submit') ?></button>
              </div>
              </form>
              <div class="col-12 text-center my-4">
                <a id="back-to-login" class="mitr-l _f16" href="<?php echo BASE_PATH . _INDEX; ?>auth?response_type=<?php echo $_GET['response_type'] ?>&client_id=<?php echo $_GET['client_id'] ?>&redirect_uri=<?php echo $_GET['redirect_uri'] ?>"><?php echo lang('attach_back_login') ?></a>
              </div>
            </div>
          </div>
        </div>
    	</div>
    </div>
  </div>
</div>

<script src="<?php echo BASE_PATH; ?>asset/js/page/login/login.js?ver=<?php echo $cash_time; ?>"></script>
<script>
  Dropzone.autoDiscover = false;

  var myDropzone = new Dropzone("#dropzone", {
      url: BASE_URL + _INDEX + "/auth/upload_attach_file",
      method: "POST",
      paramName: "file",
      autoProcessQueue : false,
      acceptedFiles: "image/jpeg,image/jpg,image/png,image/gif,application/pdf",
      maxFiles: 3,
      maxFilesize: 10, // MB
      uploadMultiple: true,
      parallelUploads: 100, // use it with uploadMultiple
      createImageThumbnails: false,
      thumbnailWidth: 120,
      thumbnailHeight: 120,
      addRemoveLinks: true,
      dictMaxFilesExceeded: "สามารถอัพโหลดได้สูงสุด {{maxFiles}} ไฟล์",
      // removedfile: function(file) {
      //     Swal.fire({
      //      icon:'warning',
      //      title: 'ต้องการยกเลิกไฟล์นี้?',
      //      showConfirmButton: true,
      //      showCancelButton: true,
      //     }).then((res) => {
      //       if (res.isConfirmed) {
      //         file.previewElement.remove();
      //       }
      //     });
      // },
      timeout: 180000,
      previewsContainer: '#files-name',
      dictRemoveFileConfirmation: "ต้องการยกเลิกไฟล์นี้?",
      // Language Strings
      dictFileTooBig: "ขนาดไฟล์ใหญ่เกินไป ({{filesize}}mb). <br>ขนาดไฟล์ไม่เกิน {{maxFilesize}}mb",
      dictInvalidFileType: "ไม่สามารถอัพโหลดไฟล์ประเภทนี้ได้",
      dictCancelUpload: "Cancel",
      // dictRemoveFile: "Remove",
      dictDefaultMessage: "<div class=\"d-flex justify-content-center align-items-center \"><img class=\"\" src=\"/sso/asset/img/upload-file.png\" alt=\"\"><div class=\"d-flex flex-column justify-content-start align-items-start p-4\"><p class=\"mb-0 mitr-r _f16\"><span class=\"chose-file\">เลือกไฟล์</span></p><p class=\"mb-0 mitr-l _f14 text-left\">สนับสนุนไฟล์ประเภท .gif .jpeg .jpg .png .pdf <br> ขนาดไฟล์อัปโหลดสูงสุด: 10MB</p></div></div>",
      // dictDefaultMessage: "<p><i class=\"fas fa-images\"></i><br>เพิ่มรูปภาพ (ขนาดไม่เกิน 2MB ไม่เกิน 5 รูป)</p>",
  });

  myDropzone.on("addedfile", function(file) {
    console.log('addedfile');

        $(file.previewElement).find(".dz-details .dz-filename").append('<i class="fa-solid fa-file"></i>');
        // Create the remove button
        
    // console.log(file.name)
    //     html = `<div class="files-name w-100 mb-2">
    //               <p class="mb-0"><i class="fa-solid fa-file"></i>&nbsp;`+file.name+` <span class="float-right text-danger" ><i class="fa-solid fa-trash" data-dz-remove></i></span></p>
    //             </div>`;

    //     $("#files-name").append(html);
    //     file.previewElement.appendChild(removeButton);
  });

  myDropzone.on("removedfile", function(file) {


  });

  // Add mmore data to send along with the file as POST data. (optional)
  myDropzone.on("sending", function(file, xhr, formData) {
    console.log('sending');
    formData.append("dropzone", "1"); // $_POST["dropzone"]
  });

  myDropzone.on("error", function(file, response) {
    Swal.fire({
     icon:'warning',
     title: response
    })
    this.removeFile(file);
  });

  myDropzone.on("maxfilesexceeded", function(file) {
    Swal.fire({
      icon: 'warning',
      title: 'อัปโหลดได้ไม่เกิน 3 ไฟล์'
    })
    this.removeFile(file);
  });

  // on success
  myDropzone.on("successmultiple", function(file, response) {
      // get response from successful ajax request
      // console.log('successmultiple');
      // console.log(response);
      // Swal.fire({
      //  icon:'success',
      //  title: 'อัปโหลดเอกสารสำเร็จ',
      //  onClose: BackToLogin,
      // })
      $('.modal-spin').modal('hide');
      let text1 = 'ส่งเอกสารเรียบร้อยแล้ว!';
      let text2 = 'เจ้าหน้าที่จะทำการตรวจสอบเอกสาร<br>โดยใช้เวลา 1-3 วันทำการ';
      let html = `<h3>${text1}</h3><p>${text2}</p>`;
      Swal.fire({
          icon:'success',
          html: html,
          confirmButtonText: 'รับทราบ',
          onClose: BackToLogin
      });
      // submit the form after images upload
      // (if u want yo submit rest of the inputs in the form)
      // document.getElementById("form_attach_file").submit();
  });



  // button trigger for processingQueue

  var frm = document.getElementById("form_attach_file");
  frm.addEventListener("submit", function(e) {
      // Make sure that the form isn't actually being sent.
      e.preventDefault();
      e.stopPropagation();
      
       if (myDropzone.files != "") {
          $('.modal-spin').modal('show');
           myDropzone.processQueue();
       } else {
      // if no file submit the form    
          //  Swal.fire({
          //   icon:'warning',
          //   title: 'กรุณาอัปโหลดไฟล์ให้ถูกต้อง'
          //  })
          let text1 = 'เอกสารไม่ครบถ้วน!';
          let text2 = 'โปรดแนบเอกสารของท่านให้ครบถ้วน<br>และทำการกดปุ่ม “<b>ส่งเอกสาร</b>”';
          let html = `<h3>${text1}</h3><p>${text2}</p>`;
           Swal.fire({
              icon:'warning',
              html: html,
              confirmButtonText: 'รับทราบ',
           });
       }

  });

  function BackToLogin() {
    console.log('BackToLogin');
    var href = $('#back-to-login').attr('href');
    window.location.href = href;
  }
</script>