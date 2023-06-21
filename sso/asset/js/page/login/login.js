// $("#formlogin").submit(submitlogin());
function send_sms(member_id = '', tel = '', target = ''){
    $.ajax({
        url: BASE_URL + _INDEX + "register/send_sms_verify",
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
                                <div class="verification-code">
                                  <div class="verification-code--inputs">
                                    <input type="text" name="otp_digit_1" maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input" />
                                    <input type="text" name="otp_digit_2" maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input" />
                                    <input type="text" name="otp_digit_3" maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input" />
                                    <input type="text" name="otp_digit_4" maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input" />
                                    <input type="text" name="otp_digit_5" maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input" />
                                    <input type="text" name="otp_digit_6" maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input" />
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
                               <button type="button" onclick="send_sms(${member_id},'${result.real_tel}','${target}')" class="btn btn-resend-email">ส่งอีกครั้ง</button>
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

                // Handle keydown event
                $(".verification-code input[type=text]").on("keydown", function (e) {
                    // Allow only backspace, delete, and numeric keys
                    if (!e.key.match(/^[0-9]$/) && e.key !== "Backspace" && e.key !== "Delete") {
                        e.preventDefault();
                        return;
                    }
                });

                // Handle input event
                $(".verification-code input[type=text]").on("input", function (e) {
                    var firstInput = $(".verification-code input[type=text]").first();

                    // If the first input is empty and the current input is not the first one, clear the current input and focus on the first input.
                    if (firstInput.val() === "" && !$(this).is(firstInput)) {
                        $(this).val("");
                        firstInput.focus();
                        return;
                    }

                    var inputValue = $(this).val();
                    if (inputValue.length === 1) {
                        $(this).next().focus();
                    } else if (inputValue.length === 0) {
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
                    icon: "error",
                    title: `${result.message} 1169`,
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
        url: BASE_URL + _INDEX + "register/verify_sms",
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
            $("#overlay-fullsrc").css("display", "none").fadeOut('fast');
            $('.modal-spin').modal('hide'); //hide loading
            console.log("verify_sms result :" + result);
            if(result.status === '00'){
                $('#public_modal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'ยืนยันหมายเลขโทรศัพท์สำเร็จ',
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


function send_mail(member_id = '', email = '', target = ''){
    $.ajax({
        url: BASE_URL + _INDEX + "register/send_email_verify",
        data: {member_id : member_id, email : email, target : target},
        method: "post",
        beforeSend: function(){
            $('.modal-spin').modal('show');
        },
        success: function (result) {
            $("#overlay-fullsrc").css("display", "none").fadeOut('fast');
            $('.modal-spin').modal('hide'); //hide loading
            console.log("asdfasdfasfasdfasdfasdf")
            console.log(result)
            if(result.status === '00'){
                $('#public_modal').modal('hide');
                Swal.fire({
                    html: `<div>
                                <i class="fa-solid fa-envelope" style="font-size:5.5rem;color:var(--main-color-1);"></i>
                                <p class="mitr-r _f18 mb-0" >ส่งข้อมูลไปที่อีเมล</p>
                                <p class="mitr-r _f18 mb-0" style="color:var(--main-color-1);">${result.email}</p>
                                <p class="mitr-l _f14 mb-0" >รหัสอ้างอิง <span style="color:var(--main-color-1);">${result.ref_code}</span></p>
                                <small class="mitr-l _f14">หากไม่พบอีเมล กรุณาตรวจสอบใน Junk mail / Spam</small>
                            </div>
                            <div>
                               <button type="button" onclick="send_mail(${member_id},'${email}','${target}')" class="btn btn-resend-email">ส่งอีกครั้ง</button>
                               <a href="`+ BASE_PATH + _INDEX +`auth" class="btn btn-regis-login" title="">เข้าสู่ระบบ</a>
                            </div>
                            `,
                    showCloseButton: true,
                    showConfirmButton: false,
                    showCancelButton: false,
                    onClose: RedirectToLogin,

                });
            }else if(result.status === '01'){
                console.log(result.message);
                Swal.fire({
                    icon: "error",
                    title: `เกิดข้อผิดพลาด : ${result.message}`,
                    //text: result.message,
                    onClose: RedirectToLogin
                })
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
    // Swal.fire({
    //   icon: "error",
    //   title: `เกิดข้อผิดพลาด `,
    //   //text: result.message,
    //   onClose: RedirectToLogin
    // })
    return false;
}

function insert_mem(e){
  let target = $(e).attr('target')
  let member_id =  $(e).attr('mem-id')
  let password = $('.box-password input[type="password"]').val();
  let cid = $('.box-username input[type="text"]').val();

  $.ajax({
    type: "POST",
    url: BASE_URL + _INDEX + 'auth/insert',
    data: {target : target, id : member_id, ss : password, cid : cid},
    dataType: "json",
    beforeSend: function(){
      $('.modal-spin').modal('show');
    },
    success: function (response) {
      // console.log(response)

      if(response.res_code === '00'){
        if(typeof response.code !== 'undefined'){
          if(response.code.hasOwnProperty('code_drive')){

            //let fetch_drive = fetch('https://testdrive.ditp.go.th/Default.aspx?TabId=148&language=th-TH&code='+response.code.code_drive)
            let fetch_drive = fetch(BASE_URL_DRIVE+'Default.aspx?TabId=148&language=th-TH&code='+response.code.code_drive)
            .then(()=>{ 
              $('.modal-spin').modal('hide');
              window.location.href = response.url 
            });
          }
          if(response.code.hasOwnProperty('code_care')){
            let fetch_care = fetch(BASE_URL_CARE+'api_caresaveuser.php?code='+response.code.code_care+'&xx='+password)
            .then(()=>{ 
              $('.modal-spin').modal('hide');
              window.location.href = response.url 
            });
          }
        }
      }
      // let data = JSON.parse(response);
      // console.log({data})
    },
    complete: function() {
      //$('.modal-spin').modal('hide');
    }
  });
}
function getClient(callback) {
  $.ajax({
    url: BASE_URL + _INDEX + "auth/client_name",
    method: "post",
    success: function(result) {
      let data = JSON.parse(result);
      console.log(data.mc_id);
      callback(data); // Pass the data to the callback function
    }
  });
}
$(document).ready(function () {
   //แสดง alert กิจกรรม
  $("#public_alert").modal("show");
  // getClient();
  $("#formlogin").submit(function () {
    let block_user = $("#formlogin input[name='username']").val();
    if (block_user == '3100101222983') {
      Swal.fire({
        icon: 'error',
        title: 'บัญชีของท่านถูกระงับการใช้งาน ติดต่อข้อมูลเพิ่มเติม สายด่วน 1169',
      });
      return false;
    }
    let sendform = $(this).serialize();
    const d5 = BASE_URL + 'index.php/null';
    $.ajax({
      url: BASE_URL + _INDEX + "auth/login_",
      // url: BASE_URL + _INDEX + "auth/login_",
      method: "post",
      beforeSend: function(){
        $('.modal-spin').modal('show');
      },
      data: sendform,
      success: function (result) {
        let data = JSON.parse(result);
        // console.log("datadta");
        // console.log(data.code,data.code === undefined);
        // return false;
        if(data.code != undefined){
          getClient(function(dd) {
                var pass = $('.box-password input[type="password"]').val();
                let fetch_care = fetch(BASE_URL_CARE+'api_caresaveuser.php?code='+data.code.code_care+'&xx='+pass+'&clientid='+dd.client_id).then(()=>{
                    console.log('success');
                });
            });
          
          // return false;
        }
        //เช็ค รายชื่อใน dbd
        if(data.district != undefined ){
                if(data.district.status_case != undefined  && data.district.status_case != '99'){
                  $('.modal-spin').modal('hide');
                  console.log(data.district);
                  let style_title =  `style='font-family:Mitr;font-style: normal;font-weight: 400;font-size: 18px;line-height: 28px;'`;
                  let style_text =  `style='font-family: Mitr;font-style: normal;font-weight: 300;font-size: 16px;line-height: 25px;text-align: center;'`;
                  if(data.district.status_case == '0'){
                    if (data.district.director_status == 1) {
                        let html = `<p `+style_text+`>${data.district.text}</p><b>${data.district.foot}</b>`;
                        Swal.fire({
                          icon: data.district.icon,
                          title: `<a `+style_title+`>${data.district.title}</a>`,
                          html: html,
                          showCancelButton: true,
                          confirmButtonText:'แนบเอกสาร',
                          cancelButtonText:'ไว้คราวหลัง',
                        }).then((result) => {
                          if (result.isConfirmed) {
                            window.location.href = BASE_URL + _INDEX + data.district.url;
                          } else if (result.dismiss === Swal.DismissReason.cancel) {
                            window.location.href = data.url;
                          }
                        });
                    } else {
                          let html = `<p `+style_text+`>${data.district.text}</p><b>${data.district.foot}</b>`;
                          Swal.fire({
                            icon: data.district.icon,
                            title: `<a `+style_title+`>${data.district.title}</a>`,
                            html: html,
                            confirmButtonText:'รับทราบ',
                        }).then(function(){
                              window.location.href = data.url;
                        });
                    }

                  }else if (data.district.status_case == '1') {
                    $('.modal-spin').modal('hide');
                      let html = `<p `+style_text+`>${data.district.text}</p><b>${data.district.foot}</b>`;
                      Swal.fire({
                        icon: data.district.icon,
                        title: `<a `+style_title+`>${data.district.title}</a>`,
                        html: html,
                        showCancelButton: true,
                        confirmButtonText:data.district.btn3,
                        cancelButtonText:data.district.btn1,
                        
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: data.district.icon,
                                title: `<a `+style_title+`>`+data.district.title2+`</a>`,
                                html: html,
                                showCancelButton: true,
                                confirmButtonText:data.district.btn4,
                                cancelButtonText:data.district.btn2,
                                customClass: {
                                    confirmButton: 'swal2-primary',
                                    cancelButton: 'swal2-primary'
                                  },
                            }).then((result2) => {
                                if (result2.isConfirmed) {
                                  window.location.href = BASE_URL + _INDEX + data.district.url;
                                } else if (result2.dismiss === Swal.DismissReason.cancel) {
                                  window.location.href = BASE_URL + _INDEX + data.district.urltype2;
                                }
                            })
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                          window.location.href = data.url;
                        }
                    });
                 }else if(data.district.status_case == '2'){
                    $('.modal-spin').modal('hide');
                    let html = `<p `+style_text+`>${data.district.text}</p><b>${data.district.foot}</b>`;
                    Swal.fire({
                      icon: data.district.icon,
                      title: `<a `+style_title+`>${data.district.title}</a>`,
                      html: html,
                      showCancelButton: true,
                      confirmButtonText:data.district.btn2,
                      cancelButtonText:data.district.btn1,
                      reverseButtons: true
                    }).then((result) => {
                      if (result.isConfirmed) {
                        Swal.fire({
                            icon: data.district.icon,
                            title: `<a `+style_title+`>`+data.district.title2+`</a>`,
                            html: html,
                            showCancelButton: true,
                            confirmButtonText:data.district.btn5,
                            cancelButtonText:data.district.btn6,
                        }).then((result2) => {
                            if (result2.isConfirmed) {
                                window.location.href = BASE_URL + _INDEX + data.district.url;
                            } else if (result2.dismiss === Swal.DismissReason.cancel) {
                                $.ajax({
                                    url: BASE_URL + _INDEX + "auth/director_change_status",
                                    data: {member_id:data.district.member_id},
                                    method: "post",
                                    beforeSend: function(){
                                        $('.modal-spin').modal('show');
                                    },
                                    success: function (r) {
                                        window.location.href = BASE_URL + _INDEX + data.district.urltype2;
                                    },
                                    complete: function() {
                                        $('.modal-spin').modal('hide');
                                    }
                                });
                                
                            }
                        })
                        
                      } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = data.url;
                      }
                    });
                  }else if(data.district.status_case == '3'){
                    console.log('url');
                    console.log(data.url);
                      let html = `<p `+style_text+`>${data.district.text}</p><b>${data.district.foot}</b>`;
                      Swal.fire({
                        icon: data.district.icon,
                        title: `<a `+style_title+`>${data.district.title}</a>`,
                        html: html,
                        confirmButtonText:data.district.btn7,
                    }).then((result) => {
                        if (result.isConfirmed) {
                          window.location.href = data.url;
                        } 
                    });
                    $('.modal-spin').modal('hide');
                  }else if(data.district.status_case == '5'){
                    if (data.district.director_status == 1) {
                        let html = `<p `+style_text+`>${data.district.text}</p><b>${data.district.foot}</b>`;
                        Swal.fire({
                          icon: data.district.icon,
                          title: `<a `+style_title+`>${data.district.title}</a>`,
                          html: html,
                          showCancelButton: true,
                          confirmButtonText:data.district.btn2,
                          cancelButtonText:data.district.btn1,
                        }).then((result) => {
                          if (result.isConfirmed) {
                            window.location.href = BASE_URL + _INDEX + data.district.url;
                          } else {
                            window.location.href = data.url;
                          }
                        });
                        $('.modal-spin').modal('hide');
                    } else {
                        $('.modal-spin').modal('hide');
                          let html = `<p `+style_text+`>${data.district.text}</p><b>${data.district.foot}</b>`;
                          Swal.fire({
                            icon: data.district.icon,
                            title: `<a `+style_title+`>${data.district.title}</a>`,
                            html: html,
                            showCancelButton: true,
                            confirmButtonText:data.district.btn3,
                            cancelButtonText:data.district.btn1,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    icon: data.district.icon,
                                    title: `<a `+style_title+`>`+data.district.title2+`</a>`,
                                    html: html,
                                    showCancelButton: true,
                                    confirmButtonText:data.district.btn2,
                                    cancelButtonText:data.district.btn4,
                                    customClass: {
                                        confirmButton: 'swal2-primary',
                                        cancelButton: 'swal2-primary'
                                      },
                                }).then((result2) => {
                                    if (result2.isConfirmed) {
                                      window.location.href = BASE_URL + _INDEX + data.district.url;
                                    } else if (result2.dismiss === Swal.DismissReason.cancel) {
                                      window.location.href = BASE_URL + _INDEX + data.district.urltype2;
                                    }
                                })
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                              window.location.href = data.url;
                            }
                        });
                    }
                    
                  }

                return false;
            }
        }
        // เช็ค เบอร์ + อีเมล
        if (data.status === '02') {
          console.log("return data:");
          console.log(data);

          Swal.fire({
              icon: "warning",
              title: `${data.title}`,
              //text: result.message,
              html: `
                      <div>
                         <button type="button" onclick="send_mail(${data.email.member_id},'${data.email.email}','${data.email.target}')" class="w-100 btn btn-regis-login ${data.email_btn}"><i class="fa-solid fa-envelope"></i> ${data.email_txt}</button>
                      </div>
                      <div>
                         <button type="button" onclick="send_sms(${data.sms.member_id},'${data.sms.tel}','${data.sms.target}')" class="w-100 btn btn-resend-email ${data.sms_btn}"><i class="fa-solid fa-mobile-screen-button"></i> ${data.sms_txt}</button>
                      </div>
                      `,
                      showCloseButton: true,
                      showConfirmButton: false,
                      showCancelButton: false,
                      onClose: RedirectToLogin,
          });
          return false;
        }
        if (data.status === '01') {
          let html = "";
          html += "<div class='error-mess'>";
          if(data.data.length == 1){
            //console.log(data.data[0].member_id);  https://sso-uat.ditp.go.th/sso
            //window.location = `${'auth/insert?target='+data.data[0].member_target+'&id='+data.data[0].member_id}`;
          } else if (data.data.res_code) {
              $('.modal-spin').modal('hide');
                Swal.fire({
                  icon: 'error',
                  title: 'ขอภัยในความไม่สะดวกกรุณาเข้าสู่ระบบใหม่อีกครั้ง \n Sorry for the inconvenience, please login again.',
                 });
                return false;
          } else{
            if(typeof data.data === 'string'){
              let text1 = 'เนื่องจากบัญชีของท่านไม่มีข้อมูลสำนัก';
              let text2 = 'กรุณาอัพเดตข้อมูลส่วนตัวของท่าน<br>ให้เป็นปัจจุบันบนระบบ Intranet';
              let html = `<h3>${text1}</h3><br><p>${text2}</p>`;
               $('.modal-spin').modal('hide');
              Swal.fire({
                icon: "warning",
                html: html,
                showCancelButton: true,
                confirmButtonText: 'intranet-uat.ditp.go.th',
                cancelButtonText: 'ปิด',
              }).then((result) => {
                if (result.isConfirmed) {
                  // window.location.href = data.data;
                      // window.android.openBrowser("https://www.example.com");
                      window.open(data.data, '_blank');
                }
              }) 
            }else{
              $.each(data.data, function (k, v) {
                //console.log(v)
                //console.log(k)
                data = {
                  'target' : v.member_target,
                  'id' : v.member_id
                }
                html += "<div class='row'>";
                html += "<div class='col-12 p-header'>";
                html += '';
                html += "<h4><b>&nbsp;&nbsp;";
                html += (k+1)+'. '+v.member_name+'&nbsp;&nbsp;';
                html += v.member_lastname+'&nbsp;&nbsp;';
                html += v.member_target_name+'&nbsp;&nbsp;';
                html += `<!--<a href="${BASE_URL + _INDEX + 'auth/insert?target='+v.member_target+'&id='+v.member_id}" class="btn btn-primary" id="${v.member_id}"><font size='3'>เลือกใช้บัญชีนี้</font></a>-->
                        <button class="btn btn-primary" target="${ v.member_target}"  mem-id="${ v.member_id}" onclick="insert_mem(this)"><font size='3'>เลือกใช้บัญชีนี้</font></button>
                        </b></h4><hr>`;
                html += "</div>";
                html += "</div>";
              });
              html += "</div>";
            }
            $("#public_modal .modal-body").html(html);
            $("#public_modal").modal("show");
          }
        } else if(data.status){
            if (data.status == 'staff' || data.status == 'ldap') {

              if(data.result.url == BASE_URL + 'index.php/null'){
                    Swal.fire({
                      icon: 'error',
                      title: 'ขอภัยในความไม่สะดวกกรุณาเข้าสู่ระบบใหม่อีกครั้ง \n Sorry for the inconvenience, please login again.',
                  });
                  return false;
                }else{
                  console.log(data.result.url); 
                  // alert(data.result.url); 
                  // return false;
                  window.location.href = data.result.url;
                  // window.open(data.result.url, "_blank");
                  return false;
                }
            }
            if(typeof data.code !== 'undefined'){
              if(data.code.hasOwnProperty('code_care')){

                var pass = $('.box-password input[type="password"]').val();
                let fetch_care = fetch(BASE_URL_CARE+'api_caresaveuser.php?code='+data.code.code_care+'&xx='+pass)
                .then(()=>{
                  $.ajax({
                    url: BASE_URL + _INDEX + "register/login_after_reg",
                    method: "post",
                    //data: { email : data.code.ee, pass : data.code.xx },
                    data: { email : data.code.ee, pass : pass },
                    success: function (result) {
                      $('.modal-spin').modal('hide');
                      if(data.pdpa.status != '00'){
                        window.location.href = data.pdpa.RedirectURL;
                      }else{
                        console.log(data.url);
                        if(data.url == BASE_URL + 'index.php/null'){
                              Swal.fire({
                                icon: 'error',
                                title: 'ขอภัยในความไม่สะดวกกรุณาเข้าสู่ระบบใหม่อีกครั้ง \n Sorry for the inconvenience, please login again.',
                            });
                            return false;
                          }else{
                            window.location.href = data.url;
                          }
                      }
                    }
                  });
                });
              }
              if(data.code.hasOwnProperty('code_drive')){

                // console.log(data.code.code_drive)
                // let fetch_drive = fetch('https://testdrive.ditp.go.th/Default.aspx?TabId=148&language=th-TH&code='+data.code.code_drive)
                fetch('https://testdrive.ditp.go.th/Default.aspx?TabId=148&language=th-TH&code='+data.code.code_drive)
                .then(()=>{
                  if(data.pdpa.status != '00'){
                    window.location.href = data.pdpa.RedirectURL;
                  }else{
                    if(data.url == BASE_URL + 'index.php/null'){
                        Swal.fire({
                          icon: 'error',
                          title: 'ขอภัยในความไม่สะดวกกรุณาเข้าสู่ระบบใหม่อีกครั้ง \n Sorry for the inconvenience, please login again.',
                      });
                      return false;
                    }else{
                      window.location.href = data.url;
                    }
                  }
                })
                .catch(err => {
                  if(data.pdpa.status != '00'){
                    window.location.href = data.pdpa.RedirectURL;
                  }else{
                    if(data.url == BASE_URL + 'index.php/null'){
                        Swal.fire({
                          icon: 'error',
                          title: 'ขอภัยในความไม่สะดวกกรุณาเข้าสู่ระบบใหม่อีกครั้ง \n Sorry for the inconvenience, please login again.',
                      });
                      return false;
                    }else{
                      window.location.href = data.url;
                    }                        
                  }
                });

              }
            }else{
                if(data.pdpa.status != '00'){
                  window.location.href = data.pdpa.RedirectURL;
                }else{
                      if(data.url == BASE_URL + 'index.php/null'){
                          Swal.fire({
                            icon: 'error',
                            title: 'ขอภัยในความไม่สะดวกกรุณาเข้าสู่ระบบใหม่อีกครั้ง \n Sorry for the inconvenience, please login again.',
                        });
                        return false;
                      }else{
                        window.location.href = data.url;
                      }                
              }
            }
        } else if (data.error) {

          if(data.error ==  "ไม่พบบัญชีผู้ใช้งาน"){
            console.log("ไม่พบบัญชีผู้ใช้งาน loop")
             $('.modal-spin').modal('hide');
            Swal.fire({
              icon: "error",
              title: data.error,
              showCancelButton: true,
              confirmButtonText: 'ลงทะเบียน DITP Account',
              cancelButtonText: 'ปิด',
            }).then((result) => {
              if (result.isConfirmed) {
               
                window.location.href = "/sso/register";
              }
            }) 
          }else  if(data.error ==  "user_delete"){
            let text1 = 'เนื่องจากบัญชีของท่านไม่มีข้อมูลผู้ติดต่อ';
            // let text2 = 'ทำให้ข้อมูลของท่านไม่สมบูรณ์กรุณาลงทะเบียนใหม่และกรอกข้อมูลให้ครบถ้วนอีกครั้ง';
            let text2 = 'กรุณาลงทะเบียนใหม่และกรอกข้อมูลให้ครบถ้วนอีกครั้ง';
            let text3 = 'ทั้งนี้ประวัติการขอรับบริการของท่าน อาทิ การเข้าร่วมกิจกรรม จะยังคงอยู่ โดยท่านสามารถตรวจสอบข้อมูลหลังจากที่ลงทะเบียนใหม่เรียบร้อยแล้ว';
            
            let html = `<h3>${text1}</h3><br><p>${text2}</p><a>${text3}</a>`;
            console.log("user_delete loop")
             $('.modal-spin').modal('hide');
            Swal.fire({
              icon: "warning",
              html: html,
              showCancelButton: true,
              confirmButtonText: 'ลงทะเบียน DITP Account',
              cancelButtonText: 'ปิด',
            }).then((result) => {
              if (result.isConfirmed) {
               
                window.location.href = "/sso/register";
              }
            }) 
          }else{

            $('.modal-spin').modal('hide');
            Swal.fire({
              icon: "error",
              title: data.error,
              confirmButtonText: 'ปิด',
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            }) 
          }        
        }  else if(data.result.status){
            // console.log('test');
            // return false;
            if(data.pdpa.status && data.pdpa.status !== null){

              window.location.href = data.pdpa.RedirectURL;
            }else{
              if(data.url == BASE_URL + 'index.php/null'){
                    Swal.fire({
                      icon: 'error',
                      title: 'ขอภัยในความไม่สะดวกกรุณาเข้าสู่ระบบใหม่อีกครั้ง \n Sorry for the inconvenience, please login again.',
                  });
                  return false;
                }else{
                  // window.location.href = data.result.url;
                  window.open(data.result.url, "_blank");
                }
            }
        }
      },
      complete: function() {
        // setTimeout(makeAjaxCall, 10000);
      },

    });
    return false;
  });


  $('#login_moc').click(function(){
    // console.log($("#lg_username").val());
    // console.log($("#lg_password").val());
    

    var username = $('.box-username input[type="text"]').val();

    var password = $('.box-password input[type="password"]').val();
    var pathArray = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname + window.location.search;
    var redirect = window.location.search
    // console.log(redirect);


    var mocAccountUrl = "";
    mocAccountUrl+="https://account.moc.go.th/auth/authorize?"
    mocAccountUrl+="&response_type=code"
    mocAccountUrl += "&redirect_uri="+BASE_URL+"index.php/auth/moccallback"
    // mocAccountUrl+="&redirect_uri=https://sso.ditp.go.th/sso/test2.php"
    mocAccountUrl+="&client_id=5111195809841"
    // mocAccountUrl+="&goto=https://sso.ditp.go.th//sso/index.php/auth?response_type=token&client_id2=ssocareid&redirect_url=https%3A%2F%2Fcare.ditp.go.th%2Fapi%2Fautologin_sso_v2.php&state=ugfjdfksg1"

// console.log(mocAccountUrl);
// return false;

      // $.ajax({
      //   url: BASE_URL + _INDEX + "auth/moccallback",
      //   method: "post",
      //   beforeSend: function(){
      //     $('.modal-spin').modal('show');
      //   },
      //   // data: JSON.parse(JSON.stringify(sendform)),
      //   // datatype: "json",
      //   data: redirect,
      //   success: function (result) {
      //     // console.log('success');
      //     let data = JSON.parse(result);
      //     //console.log(data);
        
      //   },
      //   complete: function() {
      //     //$('.modal-spin').modal('hide');
      //   }
      // });


   return location.href = mocAccountUrl;

  })
});

$(document).on('click', '#show-pass', function(){
  let type = $('.box-password input[type="password"]').attr("type");
  if(type == 'password'){
    $('.box-password input[type="password"]').attr("type", "text");
    $(this).attr("class", "far fa-eye fa-flip-horizontal icon-password");
  }else{
    $('.box-password input[type="text"]').attr("type", "password");
    $(this).attr("class", "far fa-eye-slash fa-flip-horizontal icon-password");
  }
 
})

function RedirectToLogin() {
    $.ajax({
        url: BASE_URL + _INDEX + "register/getUrl",
        method: "post",
        success: function (response) {
            console.log(response);
            if (response.res_code == "00") {
                window.location.href = BASE_PATH + _INDEX + response.res_result
            } else {
                window.location.href = BASE_PATH + _INDEX + response.res_result
            }
        }
    })
}