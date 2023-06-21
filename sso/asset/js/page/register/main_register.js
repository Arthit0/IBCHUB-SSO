var type_from = 0;
var time_send_dbd;
var time_send_postcode;
var laser_verify = 0;
var laser_error = 0;
var laser_citizen_verify = 0;
var laser_type3_onsubmit = 1;

function send_sms(member_id = '', tel = '', target = ''){
    console.log(222222);
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

                            <small class="mitr-l _f14 float-left ref-code" style="padding-left: 17% !important;">Ref Code:&nbsp;${result.ref_code}</small><br>
                            <form action="" id="verify_sms" method="post" data-group-name="digits" data-autosubmit="false" autocomplete="off">
                                <input type="hidden" name="tel" value="${result.real_tel}">
                                <input type="hidden" name="token_verify" value="${result.token_verify}">
                                <input type="hidden" name="target" value="${target}">
                                <input type="hidden" name="member_id" value="${member_id}">
                                <div class="verification-code" style="padding-left: 17% !important;">
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
                            <div class="container d-flex countdown-container" style="padding-left: 14% !important;">
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
    console.log(222222);
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
            console.log(result);
            if(result.status === '00'){
                $('#public_modal').modal('hide');
                Swal.fire({
                    html: `<div>
                                <i class="fa-solid fa-envelope" style="font-size:5.5rem;color:var(--main-color-1);"></i>
                                <p class="mitr-r _f18 mb-0" >ท่านสมัครสมาชิกแล้ว</p>
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
                //console.log(result.message);
                Swal.fire({
                    icon: "error",
                    title: `เกิดข้อผิดพลาด : ${result.message}`,
                    //text: result.message,
                    onClose: closeModal
                })
            }else{
                Swal.fire({
                    icon: "error",
                    title: `เกิดข้อผิดพลาด `,
                    //text: result.message,
                    onClose: closeModal
                })
            }
        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
    return false;
}

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
$("#laser1_id_contact_1").on('input', function(ev){
    
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
    console.log(input);
    //Return the new string
    $(this).val(input);
});
$("#laser1_id_contact_6").on('input', function(ev){
    
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

$("#laser_id").on('input', function(ev){
    
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

$(".submitform1,.submitform6,.submitform3,.submitform4").click(function() {
    //-- set Data Tel code --//  
    $(`input[name="contact_tel_country"]`).val($(`#tel1`).find(`.iti__active`).attr("data-country-code"));
    $(`input[name="contact_tel_code"]`).val($(`#tel1`).find(`.iti__active`).find('.iti__dial-code').html());

    $(`input[name="contact_director_tel_country"]`).val($(`#tel4`).find(`.iti__active`).attr("data-country-code"));
    $(`input[name="contact_director_tel_code"]`).val($(`#tel4`).find(`.iti__active`).find('.iti__dial-code').html());

    $(`input[name="fo_tel_country"]`).val($(`#tel2`).find(`.iti__active`).attr("data-country-code"));
    $(`input[name="fo_tel_code"]`).val($(`#tel2`).find(`.iti__active`).find('.iti__dial-code').html());

    $(`input[name="tel_country"]`).val($(`#tel3`).find(`.iti__active`).attr("data-country-code"));
    $(`input[name="tel_code"]`).val($(`#tel3`).find(`.iti__active`).find('.iti__dial-code').html());

    let state = $(`#form_reg_company input[name="state"]`).val();
    if (state == 'new') {
        let contact_province = $(`#form_reg_company [name="contact_province"] option:selected`).val();
        let contact_district = $(`#form_reg_company [name="contact_district"] option:selected`).val();
        let contact_subdistrict = $(`#form_reg_company [name="contact_subdistrict"] option:selected`).val();
        let contact_address = $(`#form_reg_company [name="contact_address"]`).val();
        let contact_postcode = $(`#form_reg_company [name="contact_postcode"]`).val();
        let contact_country1 = $(`#country1`).val();
        let contact_country = $(`#country`).val();

        if (contact_country != "") {
            $(`#country1`).val(contact_country);
        } else {
            $(`#country`).val(contact_country1);
        }

        $(`#form_reg_company [name="Hcontact_province"]`).val(contact_province);
        $(`#form_reg_company [name="Hcontact_district"]`).val(contact_district);
        $(`#form_reg_company [name="Hcontact_subdistrict"]`).val(contact_subdistrict);
        $(`#form_reg_company [name="Hcontact_address"]`).val(contact_address);
        $(`#form_reg_company [name="Hcontact_postcode"]`).val(contact_postcode);




    } else if (state == 'old') {
        let contact_province = $(`#form_reg_company [name="contact_province_old"]`).val();
        let contact_district = $(`#form_reg_company [name="contact_district_old"]`).val();
        let contact_subdistrict = $(`#form_reg_company [name="contact_subdistrict_old"]`).val();
        let contact_address = $(`#form_reg_company [name="contact_address_old"]`).val();
        let contact_postcode = $(`#form_reg_company [name="contact_postcode_old"]`).val();
        let contact_country = $(`#country`).val();
        let contact_country1 = $(`#country1`).val();

        $(`#country`).val(contact_country1);
        $(`#country1`).val(contact_country);
        $(`#form_reg_company [name="Hcontact_province"]`).val(contact_province);
        $(`#form_reg_company [name="Hcontact_district"]`).val(contact_district);
        $(`#form_reg_company [name="Hcontact_subdistrict"]`).val(contact_subdistrict);
        $(`#form_reg_company [name="Hcontact_address"]`).val(contact_address);
        $(`#form_reg_company [name="Hcontact_postcode"]`).val(contact_postcode);
    } else {
        console.log(state); 
    }


    let state2 = $(`#form_reg_noncompany input[name="state"]`).val();
    if (state2 == 'new') {
        let contact_province = $(`#form_reg_noncompany [name="contact_province"] option:selected`).val();
        let contact_district = $(`#form_reg_noncompany [name="contact_district"] option:selected`).val();
        let contact_subdistrict = $(`#form_reg_noncompany [name="contact_subdistrict"] option:selected`).val();
        let contact_address = $(`#form_reg_noncompany [name="contact_address"]`).val();
        let contact_postcode = $(`#form_reg_noncompany [name="contact_postcode"]`).val();
        let contact_country1 = $(`#country1`).val();
        let contact_country = $(`#country`).val();

        if (contact_country != "") {
            $(`#country1`).val(contact_country);
        } else {
            $(`#country`).val(contact_country1);
        }

        $(`#form_reg_noncompany [name="Hcontact_province"]`).val(contact_province);
        $(`#form_reg_noncompany [name="Hcontact_district"]`).val(contact_district);
        $(`#form_reg_noncompany [name="Hcontact_subdistrict"]`).val(contact_subdistrict);
        $(`#form_reg_noncompany [name="Hcontact_address"]`).val(contact_address);
        $(`#form_reg_noncompany [name="Hcontact_postcode"]`).val(contact_postcode);




    } else if (state2 == 'old') {
        let contact_province = $(`#form_reg_noncompany [name="contact_province_old"]`).val();
        let contact_district = $(`#form_reg_noncompany [name="contact_district_old"]`).val();
        let contact_subdistrict = $(`#form_reg_noncompany [name="contact_subdistrict_old"]`).val();
        let contact_address = $(`#form_reg_noncompany [name="contact_address_old"]`).val();
        let contact_postcode = $(`#form_reg_noncompany [name="contact_postcode_old"]`).val();
        let contact_country = $(`#country`).val();
        let contact_country1 = $(`#country1`).val();

        $(`#country`).val(contact_country1);
        $(`#country1`).val(contact_country);
        $(`#form_reg_noncompany [name="Hcontact_province"]`).val(contact_province);
        $(`#form_reg_noncompany [name="Hcontact_district"]`).val(contact_district);
        $(`#form_reg_noncompany [name="Hcontact_subdistrict"]`).val(contact_subdistrict);
        $(`#form_reg_noncompany [name="Hcontact_address"]`).val(contact_address);
        $(`#form_reg_noncompany [name="Hcontact_postcode"]`).val(contact_postcode);
    } else {
        console.log(state2); 
    }



    // 1 นิติบุคคล 2 Foreigner 3 บุคคลทั่วไป(ไทย) 4 passpot 6 นิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
    var formkey = $(this).data("form");
    var datatype = $(this).data("type"); 
    // let datatype = document.querySelector('input[name="data_type"]:checked').value; 
    type_from = datatype;
    // return false

    let formdata = $("#" + formkey + "  :input");
    let forms = '';
    if (type_from == 1) {
        forms = '#form_reg_company';
    } else if(type_from == 6) {
        forms = '#form_reg_noncompany';
    }
    let sendform = "";
    if (formdata.length) {
        $.each(formdata, function(k, v) {
            let ele = $(v);
            sendform += ele.attr("name") + "=" + ele.val() + "&";
        });
    }
    //เช็คว่าเป็นกรรมการหรือผู้รับมอบ
    let ck_director_type = 0;
    if( $('#ck_director_type1').is(':checked') ){
        ck_director_type = 1;
    }

    if( $('#ck_director_type2').is(':checked') ){
        ck_director_type = 2;
    }    
    
    //เช็คว่าเป็น contact ไทยหรือต่างชาติ
    let ck_nationality_type = 1;
    if( $('#ck_director_thai').is(':checked') ){
        ck_nationality_type = 1;
    }

    if( $('#ck_national_foreigner').is(':checked') ){
        ck_nationality_type = 2;
    }    


    let type1_verify = 0;
    if( $(forms + ' #ck_radio_email').is(':checked') ){
        type1_verify = 1;
    }

    if( $(forms + ' #ck_radio_sms').is(':checked') ){
        type1_verify = 2;
    }    

    let type3_verify = 0;
    if( $('#ck_normal_radio_email').is(':checked') ){
        type3_verify = 1;
    }

    if( $('#ck_normal_radio_sms').is(':checked') ){
        type3_verify = 2;
    }  

    //ตรวจสอบว่า ยืนยัน laser code หรือยัง
    if ((type_from == 1 || type_from == 6) && (laser_verify != 1 && ck_nationality_type == 1) && laser_error != 1) {
        if(type_from == 6){
            $("#contact_laser_modal6").modal();  
        }else{
            $("#contact_laser_modal1").modal();  
        }
        return false;
    }
    //ตรวจสอบว่า ยืนยัน laser code หรือยัง type 3
    if (type_from == 3 && laser_citizen_verify != 1  && laser_error != 1) {
        if (laser_type3_onsubmit == 0) {
            $("#laser_modal").modal();  
            return false;
        }
        return false;
    }


    sendform += "type=" + datatype + "&";
    sendform += "ck_director_type=" + ck_director_type + "&";
    sendform += "ck_nationality_type=" + ck_nationality_type + "&";
    sendform += "type1_verify=" + type1_verify + "&";
    sendform += "type3_verify=" + type3_verify + "&";
    sendform += "laser_type1=" + laser_verify + "&";
    sendform += "laser_type3=" + laser_citizen_verify;
    $.ajax({
        url:BASE_URL + _INDEX +"/register/add_member",
        method: "post",
        data: sendform,
        success: function(result) {
            if (result.code == "01" || result.error) {
                let html = "";
                let num_mes = result.error.length;
                console.log("add_member :");
                console.log(result.error);
                if (result.error.length > 0) {
                    html += "<div class='error-mess mitr-r'>";
                    $('input').removeClass('input-sso-error');
                    $('.input-sso-error-txt').addClass("d-none").text('');

                    $.each(result.error, function(k, v) {
                        $("#" + formkey + ' input[name="' + v.name + '"]').addClass("input-sso-error");
                        $("#" + formkey + ' select[name="' + v.name + '"]').closest('.sso-row-input').find('.dropdown').addClass("input-sso-error");
                        $("#" + formkey + ' input[name="' + v.name + '"]').closest('.sso-row-input').find('.input-sso-error-txt').removeClass("d-none");
                        $("#" + formkey + ' input[name="' + v.name + '"]').closest('.sso-row-input').find('.input-sso-error-txt').text(v.value);
                        $("#" + formkey + ' select[name="' + v.name + '"]').closest('.sso-row-input').find('.input-sso-error-txt').removeClass("d-none");
                        $("#" + formkey + ' select[name="' + v.name + '"]').closest('.sso-row-input').find('.input-sso-error-txt').text(v.value);
                        let namee = $("#" + formkey + ' input[name="' + v.name + '"]').attr(
                                "placeholder"
                            ) ?
                            $("#" + formkey + ' input[name="' + v.name + '"]').attr(
                                "placeholder"
                            ) :
                            $("#" + formkey + ' [name="' + v.name + '"]').attr(
                                "title"
                            );
                        if (namee == 'contact_title') {
                            namee = 'คำนำหน้าชื่อ';
                        } else if (namee == 'fo_title') {
                            namee = 'Title Name';
                        } else if (namee == 'title') {
                            namee = 'คำนำหน้าชื่อ';
                        } else if (namee == 'ชื่อบริษัท') {
                            namee = 'เลขนิติบุคคล';
                        }
                        if (k == 0) {
                            html += "<div class='row'>";
                            html += "<div class='col-12 p-header'>";
                            // html += namee;
                            html += " ";
                            html += v.value;
                            html += "</div>";
                            html += "</div>";
                        }
                    });
                    html += "</div>";
                    html += ``
                }
                let swaltitle = 'ไม่สามารถสมัครได้';
                if (type_from == 2 || type_from == 4) {
                    swaltitle = 'Unable to apply for membership'; 
                }
                Swal.fire({
                  title: swaltitle,
                  icon: 'warning',
                  html: html
                })
                // $("#public_modal .modal-body").html(html);
                // $("#public_modal").modal("show");
            } else if (result.code == "00") {
                $("#con_policy").data("from", formkey);
                $("#con_policy").data("type", datatype);
                $("#con_policy").click();
                // $("#overlay-fullsrc").css("display", "flex").fadeIn('fast');
                // $("body").addClass("overflow-body");
            }
        },
    });
});
$(".closs-overlay").click(function() {
    $("body").removeClass("overflow-body");
    $("#overlay-fullsrc").css("display", "none").fadeOut('fast');
});
function check_laser_verify(submit) {

    $.ajax({
        url:BASE_URL + _INDEX +"/register/ck_laser_verify",
        method: "post",
        data:{submit: submit},
        success:function(result) {
            console.log("ck_lasser_verify" + result.result_code);
        }
    })
}
function settitle(title) {
    $(".title-register").html(title);
}
function passreset () {
    $('#password').val('');
    $('#repassword').val('');
    $('#password_nonthai').val('');
    $('#repassword_nonthai').val('');
    $(".warning-pass").hide();
    $(".warning-repass").hide();
}
$('.ck-contact-id-btn').click(function() {
    if($(this).data("ckcon") == 'contact_1'){
        $("#contact_laser_modal1").modal();
    }else{
        $("#contact_laser_modal6").modal();
    }

});
$('#contact_laser_modal1').on('show.bs.modal', function(e) {
    var fname = $('#contact_name_contact_1').val();
    var lname = $('#contact_lastname_contact_1').val();
    var bday = $('#contact_bday_contact_1').val();
    var cid = $('#contact_cid_contact_1').val();
    var [day, month, year] = bday.split('/');
    var text = `${month}/${day}/${year}`;
    const date = new Date(text.replace(/-/g, "/"))
    const thbday = date.toLocaleDateString('th-TH', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    })
    $("#contact-laser-modal-citizenid_contact_1").empty().append(cid);
    $("#contact-laser-modal-fname_contact_1").empty().append(fname);
    $("#contact-laser-modal-lname_contact_1").empty().append(lname);
    if (thbday == 'Invalid Date') {
        $("#contact-laser-modal-bday_contact_1").empty().append('');
    }else {
        $("#contact-laser-modal-bday_contact_1").empty().append(thbday);
    }
    $('#cid_contact_1').val(cid);
    $('#fname_contact_1').val(fname);
    $('#lname_contact_1').val(lname);
    $('#bday_contact_1').val(bday);

});
$('#contact_laser_modal6').on('show.bs.modal', function(e) {
    var fname = $('#contact_name_contact_6').val();
    var lname = $('#contact_lastname_contact_6').val();
    var bday = $('#contact_bday_contact_6').val();
    var cid = $('#contact_cid_contact_6').val();
    var [day, month, year] = bday.split('/');
    var text = `${month}/${day}/${year}`;
    const date = new Date(text.replace(/-/g, "/"))
    const thbday = date.toLocaleDateString('th-TH', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    })
    $("#contact-laser-modal-citizenid_contact_6").empty().append(cid);
    $("#contact-laser-modal-fname_contact_6").empty().append(fname);
    $("#contact-laser-modal-lname_contact_6").empty().append(lname);
    if (thbday == 'Invalid Date') {
        $("#contact-laser-modal-bday_contact_6").empty().append('');
    }else {
        $("#contact-laser-modal-bday_contact_6").empty().append(thbday);
    }
    $('#cid_contact_6').val(cid);
    $('#fname_contact_6').val(fname);
    $('#lname_contact_6').val(lname);
    $('#bday_contact_6').val(bday);


});
$('.contact_1').click(function() {
    // let title = $('#form_reg_company select[name^="contact_title"]');
    // let fname = $('#form_reg_company input[name^="contact_name"]');
    // let fnameen = $('#form_reg_company input[name^="contact_nameEn"]');
    // let lname = $('#form_reg_company input[name^="contact_lastname"]');
    // let lnameen = $('#form_reg_company input[name^="contact_lastnameEn"]');
    // let bday = $('#form_reg_company input[name^="contact_bday"]');
    // let cid = $('#form_reg_company input[name^="contact_cid"]');
    var title = $('#contact_title_contact_1');
    var fname = $('#contact_name_contact_1');
    var midname = $('#contact_midname_contact_1');
    var lname = $('#contact_lastname_contact_1');
    var fnameen = $('#contact_nameEn_contact_1');
    var midnameen = $('#contact_midnameEn_contact_1');
    var lnameen = $('#contact_lastnameEn_contact_1');
    // var bday = $('#contact_bday_contact_1');
    var bday = $('#bday_copy_1');
    var cid = $('#contact_cid_contact_1');
    var laser_form = $('#form_laser_company_contact_1').serialize();
    console.log(laser_form);
    $.ajax({
        url:BASE_URL + _INDEX +"/register/ck_laser",
        method: "post",
        data:laser_form,
        success:function(result) {
            if (result.result_code == '00') {
                $("#contact_laser_modal1").modal('hide');
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
                title.prop('disabled', 'disabled');
                title.selectpicker('refresh');
                fname.attr("disabled", true);
                midname.attr("disabled", true);
                lname.attr("disabled", true);
                bday.attr("disabled", true);
                cid.attr("disabled", true);
                fnameen.attr("disabled", false);
                midnameen.attr("disabled", false);
                lnameen.attr("disabled", false);
                return false;
            } else if (result.result_code == '02') {
                    $("#contact_laser_modal1").modal('hide');
                    // $('.ck-contact-id-btn').hide();
                    // $(".loader_input").removeClass("show_load");
                    // $(".loader_input").removeClass("show_wrong");
                    // $(".loader_input").addClass("show_success");
                    $(".warning-niti").hide();
                  let html = `<p class="mitr-l _f14">ท่านสามารถทำรายการต่อได้ แต่สถานะของท่านจะยังไม่เปลี่ยน หากสามารถเชื่อมต่อกับกรมการปกครองสำเร็จและตรวจสอบข้อมูลของท่านสำเร็จ สถานะที่ท่านร้องขอจะถูกเปลี่ยน</p>`
                  Swal.fire({
                      icon: 'info',
                      title: 'ไม่สามารถตรวจสอบกับ<br> กรมการปกครองได้ชั่วคราว',
                      html:html
                  });
                laser_verify = 0;
                laser_error = 1;
                //   $('.btn-login').removeClass('disabled');
                //   title.prop('disabled', 'disabled');
                //   title.selectpicker('refresh');
                //   fname.attr("disabled", true);
                //   lname.attr("disabled", true);
                //   bday.attr("disabled", true);
                //   cid.attr("disabled", true);
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
$('.contact_6').click(function() {
    // let title = $('#form_reg_company select[name^="contact_title"]');
    // let fname = $('#form_reg_company input[name^="contact_name"]');
    // let fnameen = $('#form_reg_company input[name^="contact_nameEn"]');
    // let lname = $('#form_reg_company input[name^="contact_lastname"]');
    // let lnameen = $('#form_reg_company input[name^="contact_lastnameEn"]');
    // let bday = $('#form_reg_company input[name^="contact_bday"]');
    // let cid = $('#form_reg_company input[name^="contact_cid"]');
    var title = $('#contact_title_contact_6');
    var fname = $('#contact_name_contact_6');
    var midname = $('#contact_midname_contact_6');
    var lname = $('#contact_lastname_contact_6');
    var fnameen = $('#contact_nameEn_contact_6');
    var midnameen = $('#contact_midnameEn_contact_6');
    var lnameen = $('#contact_lastnameEn_contact_6');
    // var bday = $('#contact_bday_contact_6');
    var bday = $('#bday_copy_6');
    var cid = $('#contact_cid_contact_6');bday_copy_1
    var laser_form = $('#form_laser_company_contact_6').serialize();
    $.ajax({
        url:BASE_URL + _INDEX +"/register/ck_laser",
        method: "post",
        data:laser_form,
        success:function(result) {
            console.log(result);
            if (result.result_code == '00') {
                $("#contact_laser_modal6").modal('hide');
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
                title.prop('disabled', 'disabled');
                title.selectpicker('refresh');
                fname.attr("disabled", true);
                midname.attr("disabled", true);
                lname.attr("disabled", true);
                bday.attr("disabled", true);
                cid.attr("disabled", true);
                fnameen.attr("disabled", false);
                midnameen.attr("disabled", false);
                lnameen.attr("disabled", false);
                return false;
            }else if (result.result_code == '02') {
                $("#contact_laser_modal6").modal('hide');
                // $('.ck-contact-id-btn').hide();
                // $(".loader_input").removeClass("show_load");
                // $(".loader_input").removeClass("show_wrong");
                // $(".loader_input").addClass("show_success");
                $(".warning-niti").hide();
              let html = `<p class="mitr-l _f14">ท่านสามารถทำรายการต่อได้ แต่สถานะของท่านจะยังไม่เปลี่ยน หากสามารถเชื่อมต่อกับกรมการปกครองสำเร็จและตรวจสอบข้อมูลของท่านสำเร็จ สถานะที่ท่านร้องขอจะถูกเปลี่ยน</p>`
              Swal.fire({
                  icon: 'info',
                  title: 'ไม่สามารถตรวจสอบกับ<br> กรมการปกครองได้ชั่วคราว',
                  html:html
              });
            laser_verify = 0;
            laser_error = 1;
            //   $('.btn-login').removeClass('disabled');
            //   title.prop('disabled', 'disabled');
            //   title.selectpicker('refresh');
            //   fname.attr("disabled", true);
            //   lname.attr("disabled", true);
            //   bday.attr("disabled", true);
            //   cid.attr("disabled", true);
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
$('.ck-citizen-btn').click(function() {
    let cid = $('#form_reg_people input[name^="cid"]').val();
    
    let ck = check_member(cid);
    if (ck.length == 0) {
        $("#laser_modal").modal();
    }
    
});
$('#laser_modal').on('show.bs.modal', function(e) {
    let name = $('#form_reg_people input[name^="name_user"]').val();
    let lastname = $('#form_reg_people input[name^="lastname"]').val();
    let bday = $('#form_reg_people input[name^="birthday"]').val();
    let cid = $('#form_reg_people input[name^="cid"]').val();
    var [day, month, year] = bday.split('/');
    var text = `${month}/${day}/${year}`;
    const date = new Date(text.replace(/-/g, "/"))
    const thbday = date.toLocaleDateString('th-TH', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    })

    $("#laser-modal-citizenid").empty().append(cid);
    $("#laser-modal-fname").empty().append(name);
    $("#laser-modal-lname").empty().append(lastname);
    if (thbday == 'Invalid Date') {
        $("#laser-modal-bday").empty().append('');
    }else {
        $("#laser-modal-bday").empty().append(thbday);
    }
    $('#form_laser_people input[name^="cid"]').val(cid);
    $('#form_laser_people input[name^="fname"]').val(name);
    $('#form_laser_people input[name^="lname"]').val(lastname);
    $('#form_laser_people input[name^="bday"]').val(bday);

});
$('.ck-citizen-laser-btn').click(function() {
    var title = $('#title_3');
    var fname = $('#name_user_3');
    var midname = $('#midname_user_3');
    var lname = $('#lastname_3');
    var fnameen = $('#name_userEn_3');
    var midnameen = $('#midname_userEn_3');
    var lnameen = $('#lastnameEn_3');
    // var bday = $('#contact_bday_contact_1');
    var bday = $('#bday_copy_3');
    var cid = $('#user_id');
    var laser_form = $('#form_laser_people').serialize();
    $.ajax({
        url:BASE_URL + _INDEX +"/register/ck_laser",
        method: "post",
        data:laser_form,
        success:function(result) {
            console.log(result.result_code);
            if (result.result_code == '00') {
                $("#laser_modal").modal('hide');
                $('.ck-citizen-btn').hide();
                $(".loader_input").removeClass("show_load");
                $(".loader_input").removeClass("show_wrong");
                $(".loader_input").addClass("show_success");
                $(".warning-niti").hide();
                laser_citizen_verify = 1;
                Swal.fire({
                    icon: 'success',
                    title: 'ตรวจสอบข้อมูลสำเร็จ',
                });
                title.prop('disabled', 'disabled');
                title.selectpicker('refresh');
                fname.attr("disabled", true);
                midname.attr("disabled", true);
                lname.attr("disabled", true);
                bday.attr("disabled", true);
                cid.attr("disabled", true);
                fnameen.attr("disabled", false);
                midnameen.attr("disabled", false);
                lnameen.attr("disabled", false);
                return false;
            }else if (result.result_code == '02') {
                $("#laser_modal").modal('hide');
                $(".warning-niti").hide();
              let html = `<p class="mitr-l _f14">ท่านสามารถทำรายการต่อได้ แต่สถานะของท่านจะยังไม่เปลี่ยน หากสามารถเชื่อมต่อกับกรมการปกครองสำเร็จและตรวจสอบข้อมูลของท่านสำเร็จ สถานะที่ท่านร้องขอจะถูกเปลี่ยน</p>`
              Swal.fire({
                  icon: 'info',
                  title: 'ไม่สามารถตรวจสอบกับ<br> กรมการปกครองได้ชั่วคราว',
                  html:html
              });
            laser_verify = 0;
            laser_error = 1;
              return false;
          } else {
                Swal.fire({
                    icon: 'error',
                    title: result.result_text,
                });
                return false;
            }
        }
    })
});
$("#con_policy").on("click", function() {
    $('.modal-spin').modal('show');
        console.log(BASE_URL + _INDEX);

    let formkey = $(this).data("from");
    let datatype = $(this).data("type");
    let ck_policy = 1;
    if (ck_policy) {
        let formdata = $("#" + formkey + "  :input");
        let forms = '';
        if (datatype == 1) {
            forms = '#form_reg_company';
        } else if(datatype == 6) {
            forms = '#form_reg_noncompany';
        }

        let sendform = "";
        if (formdata.length) {
            $.each(formdata, function(k, v) {
                let ele = $(v);
                sendform += ele.attr("name") + "=" + ele.val() + "&";
            });
        }

        let ck_director_type = 0;
        if( $('#ck_director_type1').is(':checked') ){
            ck_director_type = 1;
        }

        if( $('#ck_director_type2').is(':checked') ){
            ck_director_type = 2;
        }    

        let ck_nationality_type = 1;
        if( $('#ck_director_thai').is(':checked') ){
            ck_nationality_type = 1;
        }

        if( $('#ck_national_foreigner').is(':checked') ){
            ck_nationality_type = 2;
        }    
  

        let type1_verify = 0;
        if( $(forms + ' #ck_radio_email').is(':checked') ){
            type1_verify = 1;
        }

        if( $(forms + ' #ck_radio_sms').is(':checked') ){
            type1_verify = 2;
        }    

        let type3_verify = 0;
        if( $('#ck_normal_radio_email').is(':checked') ){
            type3_verify = 1;
        }

        if( $('#ck_normal_radio_sms').is(':checked') ){
            type3_verify = 2;
        }  


        console.log('type1_verify :' + type1_verify);
        console.log('type3_verify :' + type3_verify);
        sendform += "type=" + datatype + "&";
        sendform += "type1_verify=" + type1_verify + "&";
        sendform += "type3_verify=" + type3_verify + "&";
        sendform += "ck_director_type=" + ck_director_type + "&";
        sendform += "ck_nationality_type=" + ck_nationality_type + "&";
        sendform += "laser_type1=" + laser_verify + "&";
        sendform += "laser_type3=" + laser_citizen_verify;
        console.log("sendform 2:" + sendform);
        $.ajax({
            url:BASE_URL + _INDEX +"/register/add_member_con",
            method: "post",
            async: false,
            data: sendform,
            beforeSend: function() {},
            success: function(result) {
                 console.log(result);
                if (result.code == "01" && result.error) {
                    let html = "";
                    if (result.error.length > 0) {
                        html += "<div class='error-mess'>";
                        $.each(result.error, function(k, v) {
                            let namee = $(
                                    "#" + formkey + ' input[name="' + v.name + '"]'
                                ).attr("placeholder") ?
                                $("#" + formkey + ' input[name="' + v.name + '"]').attr(
                                    "placeholder"
                                ) :
                                v.name;
                            html += "<div class='row'>";
                            html += "<div class='col-12 p-header'>";
                            html += namee;
                            html += " ";
                            html += v.value;
                            html += "</div>";
                            html += "</div>";
                        });
                        html += "</div>";
                    }
                    $("#public_modal .modal-body").html(html);
                    $("#public_modal").modal("show");
                } else {
                    if (result.url) {
                        console.log("reg2 :" + result.type_verify);
                        if (result.type_verify && result.type_verify == 1) {
                            //ปิด care ติด vpn
                            // let fetch_care = fetch(BASE_URL_CARE + 'api_caresaveuser.php?code=' + result.code.code_care + '&xx=' + result.code.xx)
                            //     .then(() => {
                                    
                            //     });
                            $.ajax({
                                url :BASE_URL + _INDEX + "register/email_verify", 
                                method: "post",
                                data: { cid:result.cid },
                                success: function(data) { 
                                    console.log('success loop:'); 
                                    $('.modal-spin').modal('hide');
                                    console.log(data);
                                    // if(result.pdpa.status == '01'){
                                    //     window.location.href = result.pdpa.RedirectURL;
                                    // }else{
                                    //     window.location.href = result.url;
                                    // }
                                    
                                    send_mail(data.result[0].member_id, data.result[0].email, data.result[0].target);
                                }
                            });
                        } else if (result.type_verify && result.type_verify == 2) {
                            // let fetch_care = fetch(BASE_URL_CARE + 'api_caresaveuser.php?code=' + result.code.code_care + '&xx=' + result.code.xx)
                            //     .then(() => {
                                    
                            //     });
                            $.ajax({
                                url :BASE_URL + _INDEX + "register/sms_verify", 
                                method: "post",
                                data: { cid:result.cid },
                                success: function(data) { 
                                    console.log('success loop:'); 
                                    $('.modal-spin').modal('hide');
                                    console.log(data);
                                    // if(result.pdpa.status == '01'){
                                    //     window.location.href = result.pdpa.RedirectURL;
                                    // }else{
                                    //     window.location.href = result.url;
                                    // }
                                    
                                    send_sms(data.result[0].member_id, data.result[0].tel, data.result[0].target);
                                }
                            });

                        } else {
                            if(data.code != undefined){
                              var pass = $(`[name="password"]`).val();
                              let fetch_care = fetch(BASE_URL_CARE + 'api_caresaveuser.php?code=' + result.code.code_care + '&xx=' + result.code.xx);
                            }
                            
                            // let fetch_care = fetch(BASE_URL_CARE + 'api_caresaveuser.php?code=' + result.code.code_care + '&xx=' + result.code.xx)
                            //     .then(() => {
                                    
                            //     });
                            $.ajax({
                                url :BASE_URL + _INDEX + "register/email_verify", 
                                method: "post",
                                data: { cid:result.cid },
                                success: function(data) { 
                                    console.log('success loop:'); 
                                    $('.modal-spin').modal('hide');
                                    console.log(data);
                                    // if(result.pdpa.status == '01'){
                                    //     window.location.href = result.pdpa.RedirectURL;
                                    // }else{
                                    //     window.location.href = result.url;
                                    // }
                                    
                                    send_mail(data.result[0].member_id, data.result[0].email, data.result[0].target);
                                }
                            });
                        }



                    }
                }
            },
            complete: function() {}
        });
    } else {
        console.log(10000);
        $('.modal-spin').modal('hide');
        Swal.fire({
            icon: 'warning',
            title: "กรุณากด ยอมรับเงื่อนไข <br> (PLASE ENTER POLICY)",
            showCancelButton: true,
            showConfirmButton: true
        });
        // let htmll = "";
        // htmll +=
        //     "<div class='error-mess'>กรุณากด ยอมรับเงื่อนไข (PLASE ENTER POLICY)</div>";

        // $("#public_modal .modal-body").html(htmll);
        // $("#public_modal").modal("show");
    }
});

function radio_foreigner(type) {
    if (type == 2) {
        $("#form_reg_foreigner #country_address").css(`display`, 'none');
        $("#form_reg_foreigner #company-address").css(`display`, 'flex');
        $(`#form_reg_foreigner #passportid`).css(`display`, 'none');
        $(`#form_reg_foreigner #corporateid`).css(`display`, 'flex');
        $(`#form_reg_foreigner #fo_space`).css(`display`, 'none');
        $(`#form_reg_foreigner #passport_county`).css(`display`, 'none');
        $(`#form_reg_foreigner #passport_fo_address`).css(`display`, 'none');
    } else if (type == 4) {
        $("#form_reg_foreigner #company-address").css(`display`, 'none');
        $("#form_reg_foreigner #country_address").css(`display`, 'flex');
        $(`#form_reg_foreigner #corporateid`).css(`display`, 'none');
        $(`#form_reg_foreigner #passportid`).css(`display`, 'flex');
        $(`#form_reg_foreigner #fo_space`).css(`display`, 'flex');
        $(`#form_reg_foreigner #passport_county`).css(`display`, 'block');
        $(`#form_reg_foreigner #passport_fo_address`).css(`display`, 'block');

    }
    $("#form_reg_foreigner .submitform4").removeData("type");
    $("#form_reg_foreigner .submitform4").data("type", type);
}
// --------------------------------------------------------------------------------------------------------------------------------------------------------
$(`[name=data_type]`).on(`click`, function() {

    let thisVal = $(this).val()
    let title_corporation_text = `เลขนิติบุคคล (Username)`
    let remark_text = `กรอกตัวอักษร หรือตัวเลขให้ครบถ้วน (บูรณาการฐานข้อมูลจากกรมพัฒนาธุรกิจ)`
    let propReadonly = true
    let header_text = `ข้อมูลบริษัท`
    let name_corporation = `ชื่อบริษัท`

    let displayDetail1 = `flex`
    let displayDetail2 = `none`


    if (parseInt(thisVal) === 1) {

        $('#text-thf , #text-thl, #text-use2, #thisVal6').hide();
        $('#text-enf , #text-enl, #text-use1, #thisVal1').show();
        $('#user1_id').attr("placeholder", "เลขนิติบุคคล");
        title_corporation_text = title_corporation_text
        remark_text = remark_text
        header_text = header_text
        name_corporation = name_corporation
        propReadonly = true
        displayDetail1 = displayDetail1
        displayDetail2 = displayDetail2

    } else if (parseInt(thisVal) === 6) {

        $('#text-thf , #text-thl , #text-use2, #thisVal6').show();
        $('#text-enf , #text-enl , #text-use1, #thisVal1').hide();
        $(".loader_input").removeClass("show_wrong");
        // $('#user1_id').attr("placeholder", "เลขประจำตัวผู้เสียภาษีอากร 13 หลัก");
        // $('#user6_id').attr("placeholder", "เลขประจำตัวผู้เสียภาษีอากร");
        $(".warning-niti").hide();
        title_corporation_text = `เลขประจำตัวองค์กร 13 หลัก (Username) `
        remark_text = `กรอกตัวอักษร หรือตัวเลขให้ครบถ้วน`
        propReadonly = false
        header_text = `ข้อมูลองค์กร`
        name_corporation = `ชื่อองค์กร`
        displayDetail1 = `none`
        displayDetail2 = `flex`
    } else {
        console.log(`error`)
    }
    
    $(".detail1").css(`display`, displayDetail1)
    $(".detail2").css(`display`, displayDetail2)
    $(".old_adress1").css(`display`, displayDetail1)
    $(".old_adress6").css(`display`, displayDetail2)
    $(".footer-people").css(`display`, displayDetail1)

    $(".div_cid").removeClass("loader_input");
    $(".div_cid").removeClass("load_dbd");
    $(`#corporation_container input`).prop(`readonly`, propReadonly).val(null)
    // $(`#corporation_container #company_nameEn`).prop(`readonly`, false).val(null)
    $(`#corporation_container #company_addressEn`).prop(`readonly`, false).val(null)
    $(`#corporation_container #company_email`).prop(`readonly`, false).val(null)
    $(`#corporation_container #company_phone`).prop(`readonly`, false).val(null)
    $(`.dis1`).css(`display`, displayDetail1);
    $(`.dis2`).css(`display`, displayDetail2);
    $(`.subdis1`).css(`display`, displayDetail1)
    $(`.subdis2`).css(`display`, displayDetail2)
    $(`.provi1`).css(`display`, displayDetail1)
    $(`.provi2`).css(`display`, displayDetail2)
    $(`#footer_text`).toggle(propReadonly)
    $(`#title_corporation_text`).html(title_corporation_text)
    $(`#remark_text`).html(remark_text)
    $(`#header_text`).html(header_text)
    $(`#name_corporation`).html(name_corporation)
    $(`#company_name`).attr("placeholder", name_corporation)
    $("#form_reg_company .submitform").data("type", parseInt(thisVal));
})

// $(".ck_dbd").click(function() {
//     let cid = $("#form_reg_company input[name='cid']").val();
//     console.log(cid);
//     ck_dbd(cid);
// });


function ck_dbd(cid) {
   var ckmember =  check_member(cid);
   if(ckmember.length != 0){
        $(".loader_input.load_dbd").removeClass("show_load");
        $(".loader_input.load_dbd").removeClass("show_wrong");
        $(".loader_input.load_dbd").removeClass("show_success");
        $(".loader_input.load_dbd").addClass("show_wrong");
        texterror = 'เลขนิติบุคคลนี้ได้มีการสมัครสมาชิกแล้ว'
        Swal.fire({
            icon: 'error',
            title: texterror,
            customClass: 'swal-dbd-fail',
        });
        return false;
   }
    if (!cid) {
        cid = "";
    }
    $.ajax({
        url:BASE_URL + _INDEX +"/register/ck_com_dbd",
        method: "post",
        data: { cid: cid },
        error: ((error) => {
            console.log({ error });
        }),
        success: function(result) {
           let name_user = result.company_name;
           let name_useren = result.company_nameen;
           let address = result.company_address;
           let province = result.company_province;
           let district = result.company_district;
           let subdistrict = result.company_subdistrict;
           let postcode = result.company_postcode;
  
            
            if(name_user != "" && name_user != undefined){
                $(".loader_input.load_dbd").removeClass("show_load");
                $(".loader_input.load_dbd").removeClass("show_wrong");
                $(".loader_input.load_dbd").addClass("show_success");
                $(".warning-niti.load_dbd").hide();
                $("#form_reg_company input[name='company_name']").val(name_user);
                $("#form_reg_company input[name='company_nameEn']").val(name_useren);
                $("#form_reg_company input[name='company_address']").val(address);
                $("#form_reg_company input[name='company_province']").val(province);
                $("#form_reg_company input[name='company_district']").val(district);
                $("#form_reg_company input[name='company_subdistrict']").val(subdistrict);
                $("#form_reg_company input[name='company_postcode']").val(postcode);

                $("#form_reg_company input[name='companyTh_address']").val(address);
                $("#form_reg_company input[name='companyTh_province']").val(province);
                $("#form_reg_company input[name='companyTh_district']").val(district);
                $("#form_reg_company input[name='companyTh_subdistrict']").val(subdistrict);

                $("#form_reg_company select[name='company_provinceEn']").val(getprovinceid(province)).change()
                setTimeout(function(){
                    $("#form_reg_company select[name='company_districtEn']").val(get_districtsid(district)).change();
                },750);
                setTimeout(function(){
                    $("#form_reg_company select[name='company_subdistrictEn']").val(get_subdistrictid(subdistrict)).change();
                },750);
            }else {
                $(".warning-niti.load_dbd").show();
                $(".loader_input.load_dbd").removeClass("show_load");
                $(".loader_input.load_dbd").removeClass("show_success");
                $(".loader_input.load_dbd").addClass("show_wrong");
                texterror = 'เลขนิติบุคคลนี้ยังไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า'
                                                            
                Swal.fire({
                    icon: 'error',
                    title: texterror,
                });
                return false;
            }
            console.log(postcode);
            $("#form_reg_company input[name='company_postcode']").val(postcode);
        },
    }).fail((error) => {
        console.log(error)
    });
}
function check_member(id){
    var result1 
           $.ajax({
               url:BASE_URL + _INDEX +"/register/ck_member",
               method: "post",
               data: {
                   cid:id
               },
               async:false,
               success: function (result) {
                console.log(result);
                    result1 = result
               }
             });
             return result1;
}

function getprovinceid(province){
 var  idprovince = 0
    $.ajax({
        url:BASE_URL + _INDEX +"/register/get_provincestest",
        method: "post",
        data: '',
        async:false,
        success: function (result) {
            for(var i = 0; i< result.length;i++){
                if(result[i]['name_th'] == province){
                    idprovince = result[i]['id']
                    break
                }
            }
        }
      });
      
      return idprovince
}

function get_districtsid(district){
    var iddistrict = 0
    $.ajax({
        url:BASE_URL + _INDEX +"/register/get_districtstest",
        method: "post",
        data: '',
        async:false,
        success: function (result) {
            for(var i = 0; i< result.length;i++){
                if(result[i]['name_th'] == district){
                    iddistrict = result[i]['id']
                    break
                }
            }
        }
      });
      return iddistrict
}
function get_subdistrictid(subdistrict){
    var idsubdistrict = 0
    $.ajax({
        url:BASE_URL + _INDEX +"/register/get_amphurestest",
        method: "post",
        data: '',
        async:false,
        success: function (result) {
            for(var i = 0; i< result.length;i++){
                if(result[i]['name_th'] == subdistrict){
                    idsubdistrict = result[i]['id']
                    break
                }
            }
        }
      });
      return idsubdistrict
    
}
$("#form_reg_company input[name='cid']").on("focus", function(){
    $(".regis-com-check-btn").show("show");
    $(".regis-noncom-check-btn").show("show");
})
$("#form_reg_noncompany input[name='cid']").on("focus", function(){
    $(".regis-com-check-btn").show("show");
    $(".regis-noncom-check-btn").show("show");
})
$("#form_reg_company .regis-com-check-btn").on("click", function() {
    $(".loader_input").removeClass("show_load");
    $(".loader_input").removeClass("show_wrong");
    $(".loader_input").removeClass("show_success");
    $(".loader_input").addClass("show_load");
    $("#show-input").hide("hide");
    $(".regis-com-check-btn").hide("hide");

    // let checkCoperationType = $('#form_reg_company [name=data_type]:checked').val();
    var DATA = $(this).data("ck");
    var checkCoperationType = this.id;
    if (!checkCoperationType) {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาเลือกประเภทจดทะเบียน',
        });
    }
    console.log('coperationtype:'+checkCoperationType);
    // return false;
    clearTimeout(time_send_dbd);
    time_send_dbd = setTimeout(function() {

        // let cid = $("#form_reg_company input[name='cid']").val();
        let cid = $('#'+DATA+'').val();
        if (checkCoperationType === '1') {
            ck_dbd(cid,checkCoperationType)
        } else if (checkCoperationType === '6') {
            if (cid.length > 12) {
                var ckmember =  check_member(cid);
                if(ckmember.length != 0){
                     $(".loader_input").removeClass("show_load");
                     $(".loader_input").removeClass("show_wrong");
                     $(".loader_input").removeClass("show_success");
                     $(".loader_input").addClass("show_wrong");
                     texterror = 'เลขประจำตัวผู้เสียภาษีอากรนี้ได้มีการสมัครสมาชิกแล้ว'
                     Swal.fire({
                         icon: 'error',
                         title: texterror,
                     });
                     return false;
                }else{
                    $(".warning-niti").hide();
                    $(".loader_input").removeClass("show_load");
                    $(".loader_input").removeClass("show_wrong");
                    $(".loader_input").removeClass("show_success");
                    $(".loader_input").addClass("show_success");
                }
            } else {
                $(".loader_input.load_dbd").removeClass("show_load");
                $(".loader_input.load_dbd").removeClass("show_wrong");
                $(".loader_input.load_dbd").removeClass("show_success");
                $(".loader_input.load_dbd").addClass("show_wrong");
                texterror = 'กรุณากรอกข้อมูล'
                Swal.fire({
                    icon: 'error',
                    title: texterror,
                });
                return false;
            }
            
        } else {
            // Deflaut
            console.log(`Defualt check params:`, this.id)
        }

    }, 750);
}); 

$("#form_reg_noncompany .regis-com-check-btn").on("click", function() {
    $(".loader_input").removeClass("show_load");
    $(".loader_input").removeClass("show_wrong");
    $(".loader_input").removeClass("show_success");
    $(".loader_input").addClass("show_load");
    $("#show-input").hide("hide");
    $(".regis-com-check-btn").hide("hide");

    // let checkCoperationType = $('#form_reg_company [name=data_type]:checked').val();
    var DATA = $(this).data("ck");
    var checkCoperationType = this.id;
    if (!checkCoperationType) {
        Swal.fire({
            icon: 'error',
            title: 'กรุณาเลือกประเภทจดทะเบียน',
        });
    }
    console.log('coperationtype:'+checkCoperationType);
    // return false;
    clearTimeout(time_send_dbd);
    time_send_dbd = setTimeout(function() {

        // let cid = $("#form_reg_company input[name='cid']").val();
        let cid = $('#'+DATA+'').val();
        if (checkCoperationType === '1') {
            ck_dbd(cid,checkCoperationType)
        } else if (checkCoperationType === '6') {
            if (cid.length > 12) {
                var ckmember =  check_member(cid);
                console.log(ckmember);
                if(ckmember.length != 0){
                     $(".loader_input").removeClass("show_load");
                     $(".loader_input").removeClass("show_wrong");
                     $(".loader_input").removeClass("show_success");
                     $(".loader_input").addClass("show_wrong");
                     texterror = 'เลขประจำตัวผู้เสียภาษีอากรนี้ได้มีการสมัครสมาชิกแล้ว'
                     Swal.fire({
                         icon: 'error',
                         title: texterror,
                     });
                     return false;
                }else{
                    $(".warning-niti").hide();
                    $(".loader_input").removeClass("show_load");
                    $(".loader_input").removeClass("show_wrong");
                    $(".loader_input").removeClass("show_success");
                    $(".loader_input").addClass("show_success");
                }
            } else {
                $(".loader_input.load_dbd").removeClass("show_load");
                $(".loader_input.load_dbd").removeClass("show_wrong");
                $(".loader_input.load_dbd").removeClass("show_success");
                $(".loader_input.load_dbd").addClass("show_wrong");
                texterror = 'กรุณากรอกข้อมูล'
                Swal.fire({
                    icon: 'error',
                    title: texterror,
                });
                return false;
            }
            
        } else {
            // Deflaut
            console.log(`Defualt check params:`, this.id)
        }

    }, 750);
}); 

$("#form_reg_people input[name='cid']").on("keyup", function() {
    $(".loader_input").removeClass("show_load");
    $(".loader_input").removeClass("show_wrong");
    $(".loader_input").removeClass("show_success");
    $(".loader_input").addClass("show_load");
    // $("#show-input").hide("hide");
    $("#show-input").show();
        let cid = $(this).val();
        if (cid.length > 12) {
            var ckmember =  check_member(cid);
            if(ckmember.length != 0){
            $(".loader_input").removeClass("show_load");
            $(".loader_input").removeClass("show_wrong");
            $(".loader_input").removeClass("show_success");
            $(".loader_input").addClass("show_wrong");
            texterror = 'เลขบัตรประจำตัวประชาชนนี้ได้มีการสมัครสมาชิกแล้ว';
            $("#form_reg_people input[name='cid']").closest('.regis-com-check').find('.input-sso-error-txt').removeClass("d-none");
            $("#form_reg_people input[name='cid']").closest('.regis-com-check').find('.input-sso-error-txt').text(texterror);
            laser_type3_onsubmit = 1;
            Swal.fire({
                icon: 'error',
                title: texterror,
            });
                return false;
            }else{
            $(".warning-niti").hide();
            $(".loader_input").removeClass("show_load");
            $(".loader_input").removeClass("show_wrong");
            $(".loader_input").removeClass("show_success");
            $("#form_reg_people input[name='cid']").closest('.regis-com-check').find('.input-sso-error-txt').addClass("d-none");
            // $(".loader_input").addClass("show_success");
            laser_type3_onsubmit = 0;
            }
        }
        
});

$("#form_reg_foreigner input[name='cid']").on("keyup", function() {
    $('.fa-search').hide()
    $(".loader_input").removeClass("show_load");
    $(".loader_input").removeClass("show_wrong");
    $(".loader_input").removeClass("show_success");
    $(".loader_input").addClass("show_load");
    $("#show-input").hide("hide");
        let cid = $(this).val();
        if (cid.length > 12) {
            var ckmember =  check_member(cid);
                if(ckmember.length != 0){
                $(".loader_input").removeClass("show_load");
                $(".loader_input").removeClass("show_wrong");
                $(".loader_input").removeClass("show_success");
                $(".loader_input").addClass("show_wrong");
                texterror = 'This identification number has already been registered.';
                $("#form_reg_foreigner input[name='cid']").closest('.regis-com-check').find('.input-sso-error-txt').removeClass("d-none");
                $("#form_reg_foreigner input[name='cid']").closest('.regis-com-check').find('.input-sso-error-txt').text(texterror);
                laser_type3_onsubmit = 1;
                Swal.fire({
                    icon: 'error',
                    title: texterror,
                });
                return false;
            }else{
                $(".warning-niti").hide();
                $(".loader_input").removeClass("show_load");
                $(".loader_input").removeClass("show_wrong");
                $(".loader_input").removeClass("show_success");
                // $(".loader_input").addClass("show_success");
                $("#form_reg_foreigner input[name='cid']").closest('.regis-com-check').find('.input-sso-error-txt').addClass("d-none");
                laser_type3_onsubmit = 0;
            }
        }
    
});


// setTimeout(function(){ alert("Hello"); }, 3000);


var contact_tel = document.querySelector("input[name='contact_tel']");
var contact_director_tel = document.querySelector("input[name='contact_director_tel']");
var fo_tel = document.querySelector("input[name='fo_tel']");
var tel = document.querySelector("input[name='tel']");

window.intlTelInput(contact_tel, {
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

window.intlTelInput(contact_director_tel, {
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

window.intlTelInput(fo_tel, {
    initialCountry: "auto",
    geoIpLookup: function(success) {
        // Get your api-key at https://ipdata.co/
        fetch("https://api.ipdata.co/?api-key=ee33cf1471399e32d01edb80374112949546ca6fbed2e381ddd094b7")
            .then(function(response) {

                if (!response.ok) return success("");
                return response.json();
            })
            .then(function(ipdata) {
                //console.log('test');
                success(ipdata.country_code);
            });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js",
});

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

function show_pass(me, name, form) {
    //console.log(me);
    let state = $('#' + form).find(' [name="'+name+'"]');
    let element = $('#'+form+ ' [name="'+name+'"]');
    
    if (!$(state).hasClass('pass_input')) {
        console.log("not has");
        $(state).addClass('pass_input')
        $(me).attr("class", "fa fa-eye-slash icon-password-reg");

    } else {
        console.log("has");
        $(state).removeClass('pass_input')
        $(me).attr("class", "fa fa-eye icon-password-reg");

    }
}


//--------- search zip_code -------------//

function portal_store_addr (e) {
       $('.dropdown-menu').find('a.dropdown-item.dropdown-link.active').removeClass('active')
       $(e).addClass('active')
       let amphure_id = $(e).attr('amphure-id')
       let province_id = $(e).attr('province-id')
       let district_id = $(e).attr('district-id')
       let zip_code = $(e).attr('zip-code')

       let province_tag = $(e).attr('province-tag')
       let district_tag = $(e).attr('district-tag')
       let subdistrict_tag = $(e).attr('subdistrict-tag')
       let zipcode_tag = $(e).attr('zipcode-tag')

       let lang = $(e).attr('lang')
       $(zipcode_tag).val(zip_code)
       $.ajax({
           url:BASE_URL + _INDEX +"/register/get_provinces",
           method: "post",
           data: '',
           success: function(result) {
               $(province_tag).empty()
               $.each(result, function(key, value) {
                   if (lang == 'th') $(province_tag).append(`<option value="${value.id}">${value.name_th}</option>`);
                   else $(province_tag).append(`<option value="${value.id}">${value.name_en}</option>`);
               });
               $('.selectpicker').selectpicker('refresh');

               let option_province = $(province_tag + " option");
               $.each(option_province, function(index, item) {
                   if ($(item).val() == province_id) {
                   
                       $(item).prop("selected", true);
                       $('.selectpicker').selectpicker('refresh');   
                       var province =  $(e).closest('.find').find('.selectpicker').val()
                       if(province == 1){
                           $(e).closest('.find').find('.txtdetail').hide();
                           $(e).closest('.find').find('.txtdistrict1').show();
                           $(e).closest('.find').find('.txtsubdistrict1').show();
                           // $(e).closest('.find').find('.txtdistrict').empty().append('เขต') 
                           // $(e).closest('.find').find('.txtsubdistrict').empty().append('แขวง') 
                        
                       }else{
                            console.log(province)
                           $(e).closest('.find').find('.txtdetail').show();
                           $(e).closest('.find').find('.txtdistrict1').hide();
                           $(e).closest('.find').find('.txtsubdistrict1').hide();
                           // $(e).closest('.find').find('.txtdistrict').empty().append('อำเภอ') 
                           // $(e).closest('.find').find('.txtsubdistrict').empty().append('ตำบล') 
                       }
                      return false;
                   }
               });

           }
       });

       $.ajax({
           url:BASE_URL + _INDEX +"/register/get_amphures",
           method: "post",
           data: "id=" + province_id,
           success: function(result) {
               $(district_tag).empty()
               $.each(result, function(key, value) {
                   if (lang == 'th') $(district_tag).append(`<option value="${value.id}">${value.name_th}</option>`);
                   else $(district_tag).append(`<option value="${value.id}">${value.name_en}</option>`);
               });

               $('.selectpicker').selectpicker('refresh');

               let option_district = $(district_tag + " option");
               $.each(option_district, function(index, item) {
                   if ($(item).val() == amphure_id) {
                       $(item).prop("selected", true);
                       $('.selectpicker').selectpicker('refresh');
                       return false;
                   }
               });
           }
       });

       $.ajax({
           url:BASE_URL + _INDEX +"/register/get_districts",
           method: "post",
           data: "id=" + amphure_id,
           success: function(result) {
               $(subdistrict_tag).empty()
               $.each(result, function(key, value) {
                   if (lang == 'th') $(subdistrict_tag).append(`<option value="${value.id}">${value.name_th}</option>`);
                   else $(subdistrict_tag).append(`<option value="${value.id}">${value.name_en}</option>`);
               });
               $('.selectpicker').selectpicker('refresh');
               let option_subdistrict = $(subdistrict_tag + " option");
               $.each(option_subdistrict, function(index, item) {
                   if ($(item).val() == district_id) {
                       $(item).prop("selected", true);
                       $('.selectpicker').selectpicker('refresh');
                       return false;
                   }

               });
           }
       });
}
const store_addr = (e) => {

    $('.dropdown-menu').find('a.dropdown-item.dropdown-link.active').removeClass('active')
    $(e).addClass('active')
    let amphure_id = $(e).attr('amphure-id')
    let province_id = $(e).attr('province-id')
    let district_id = $(e).attr('district-id')
    let zip_code = $(e).attr('zip-code')

    let province_tag = $(e).attr('province-tag')
    let district_tag = $(e).attr('district-tag')
    let subdistrict_tag = $(e).attr('subdistrict-tag')
    let zipcode_tag = $(e).attr('zipcode-tag')

    let lang = $(e).attr('lang')
 console.log(zipcode_tag)
    $(zipcode_tag).val(zip_code)
    $.ajax({
        url:BASE_URL + _INDEX +"/register/get_provinces",
        method: "post",
        data: '',
        success: function(result) {
            $(province_tag).empty()
            $.each(result, function(key, value) {
                if(value.id != undefined){
                    if (lang == 'th') {
                        $(province_tag).append(`<option value="${value.id}">${value.name_th}</option>`);
                    }
                    else {
                        $(province_tag).append(`<option value="${value.id}">${value.name_en}</option>`);
                    }
                }
            });
            $('.selectpicker').selectpicker('refresh');

            let option_province = $(province_tag + " option");
            $.each(option_province, function(index, item) {
                if ($(item).val() == province_id) {
                
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');   
                    var province =  $(e).closest('.find').find('.selectpicker').val();
                    console.log('as;ldfjals;dkfjieiieieieieieieieieieieiieieieei');
                    console.log(e);
                    if(province == 1){
                        $(e).closest('.find').find('.txtdetail').hide();
                        $(e).closest('.find').find('.txtdistrict1').show();
                        $(e).closest('.find').find('.txtsubdistrict1').show();
                        // $(e).closest('.find').find('.txtdistrict').empty().append('เขต') 
                        // $(e).closest('.find').find('.txtsubdistrict').empty().append('แขวง') 
                     
                    }else{
                        $(e).closest('.find').find('.txtdetail').show();
                        $(e).closest('.find').find('.txtdistrict1').hide();
                        $(e).closest('.find').find('.txtsubdistrict1').hide();
                        // $(e).closest('.find').find('.txtdistrict').empty().append('อำเภอ') 
                        // $(e).closest('.find').find('.txtsubdistrict').empty().append('ตำบล') 
                    }
                   return false;
                }
            });

        }
    });

    $.ajax({
        url:BASE_URL + _INDEX +"/register/get_amphures",
        method: "post",
        data: "id=" + province_id,
        success: function(result) {
            $(district_tag).empty()
            $.each(result, function(key, value) {
                if(value.id != undefined){
                    if (lang == 'th') $(district_tag).append(`<option value="${value.id}">${value.name_th}</option>`);
                    else $(district_tag).append(`<option value="${value.id}">${value.name_en}</option>`);
                }
            });

            $('.selectpicker').selectpicker('refresh');

            let option_district = $(district_tag + " option");
            $.each(option_district, function(index, item) {
                if ($(item).val() == amphure_id) {
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');
                    return false;
                }
            });
        }
    });

    $.ajax({
        url:BASE_URL + _INDEX +"/register/get_districts",
        method: "post",
        data: "id=" + amphure_id,
        success: function(result) {
            $(subdistrict_tag).empty()
            $.each(result, function(key, value) {
                if(value.id != undefined){
                    if (lang == 'th') $(subdistrict_tag).append(`<option value="${value.id}">${value.name_th}</option>`);
                    else $(subdistrict_tag).append(`<option value="${value.id}">${value.name_en}</option>`);
                }
            });
            $('.selectpicker').selectpicker('refresh');
            let option_subdistrict = $(subdistrict_tag + " option");
            $.each(option_subdistrict, function(index, item) {
                if ($(item).val() == district_id) {
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');
                    return false;
                }

            });
        }
    });
}

const get_address_from_zipcode = (postcode, dropdown, province, district, subdistrict, zipcode, lang) => {
    $.ajax({
        type: "post",
        url:BASE_URL + _INDEX +"/register/get_address_from_zipcode",
        data: { postcode: postcode },
        success: function(response) {
            $(dropdown).empty();
            // console.log(dropdown);
            // return false;
            if (response.res_code == '00') {
                response.res_result.forEach(function(value) {
                    //console.log(value.district_id)
                    if (lang == 'th') {
                        subdistrict_name = value.name_th
                        amphure_name = value.amphure_name_th
                        province_name = value.province_name_th
                    } else {
                        subdistrict_name = value.name_en
                        amphure_name = value.amphure_name_en
                        province_name = value.province_name_en
                    }
                    let drop_down = `
          <a class="dropdown-item dropdown-postcode dropdown-link" 
              amphure-id="${value.amphure_id}" 
              province-id="${value.province_id}" 
              district-id="${value.district_id}"
              zip-code="${value.zip_code}"

              province-tag="${province}"
              district-tag="${district}"
              subdistrict-tag="${subdistrict}"
              zipcode-tag="${zipcode}"

              lang="${lang}"
              onclick="store_addr(this)">
              ${subdistrict_name
                // +' <i class="fa fa-angle-double-right addr-icon" aria-hidden="true"></i> '+amphure_name
                // +' <i class="fa fa-angle-double-right addr-icon" aria-hidden="true"></i> '+province_name
                +' <i class="fa fa-angle-right addr-icon" aria-hidden="true"></i> '+value.zip_code
              }
          </a>`;
                    $(dropdown).append(drop_down)
                })
            } else {
                $(dropdown).append(`<a class="dropdown-item drop-down-icon text-center">ไม่พบข้อมูล</a>`)
                    //console.log('ไม่พบข้อมูล')
            }
            //console.log(data)
            $(dropdown).dropdown('show')
        }
    });
}

//--- on click ---//
$(`[name="corporation_postcode"]`).on('click', function() {
    if ($(this).val() == '') {
        show_drop_down_default('#dropdown_corporation_postcode')
    }
})
$(`[name="company_postcodeEn"]`).on('click', function() {
    if ($(this).val() == '') {
        show_drop_down_default('#dropdown_company_postcodeEn')
    }
})
$(`[name="contact_postcode"]`).on('click', function() {
    if ($(this).val() == '') {
        if(this.getAttribute('id') == 'noncontact_postcode'){
            show_drop_down_default('#dropdown_noncontact_postcode')
        }else{
            show_drop_down_default('#dropdown_contact_postcode')
        }
        // console.log(show_drop_down_default('#dropdown_contact_postcode'));
    }
})
$(`[name="company_postcode"]`).on('click', function() {
    if ($(this).val() == '') {//company_postcode
        console.log(this.getAttribute('id'),this.getAttribute('id') == 'noncompany_postcode','#dropdown_noncompany_postcode');
        if(this.getAttribute('id') == 'noncompany_postcode'){
            show_drop_down_default('#dropdown_noncompany_postcode');
        }else{
            show_drop_down_default('#dropdown_company_postcode');
        }
    }
})
$(`[name="postcode"]`).on('click', function() {
    if ($(this).val() == '') {
        show_drop_down_default('#dropdown_postcode')
        // Set the top position using the style property
        document.getElementById('dropdown_postcode').style.setProperty('width', '99%', 'important');
        setTimeout(function() {
            document.getElementById('dropdown_postcode').style.setProperty('top', '0%', '');
          }, 0);
    }
})


//--- on keyup ---//
$(`[name="contact_postcode"]`).on('keyup', function() {
    if(this.getAttribute('id') == 'noncontact_postcode'){
        let postcode = $(this).val();
        let dropdown2 = '#dropdown_noncontact_postcode';
        let province2 = "#noncontact_province";
        let district2 = "#noncontact_district";
        let subdistrict2 = "#noncontact_subdistrict";
        let zipcode = "#noncontact_postcode";
        let lang = 'th'
        show_drop_down_load(dropdown2);
        add_data_dropdown(postcode, dropdown2, province2, district2, subdistrict2, zipcode, lang);
    }else{
        let postcode = $(this).val();
        let dropdown = '#dropdown_contact_postcode';
        let province = "#form_reg_company [name='contact_province']";
        let district = "#form_reg_company [name='contact_district']";
        let subdistrict = "#form_reg_company [name='contact_subdistrict']";
        let zipcode = "#form_reg_company [name='contact_postcode']";
        let lang = 'th'
        show_drop_down_load(dropdown);
        add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    }
})
$(`[name="company_postcodeEn"]`).on('keyup', function() {
    let postcode = $(this).val();
    let dropdown = '#dropdown_company_postcodeEn';
    let province = "#form_reg_company [name='company_provinceEn']";
    let district = "#form_reg_company [name='company_districtEn']";
    let subdistrict = "#form_reg_company [name='company_subdistrictEn']";
    let zipcode = "#form_reg_company [name='company_postcodeEn']";
    let lang = 'en'
    show_drop_down_load(dropdown)
    add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang)
})
$(`[name="company_postcode"]`).on('keyup', function() {
    if(this.getAttribute('id') == 'noncompany_postcode'){
        let postcode = $(this).val();
        let dropdown2 = '#dropdown_noncompany_postcode';
        let province2 = "#noncompanyTH_province";
        let district2 = "#noncompanyTH_districts";
        let subdistrict2 = "#noncompanyTH_subdistricts";
        let zipcode = "#noncompany_postcode";
        let lang = 'th'//noncompanyTH_province
        show_drop_down_load(dropdown2)
        add_data_dropdown(postcode, dropdown2, province2, district2, subdistrict2, zipcode, lang);
    }else{
        let postcode = $(this).val();
        let dropdown = '#dropdown_company_postcode';
        let province = "#form_reg_company [name='companyTH_province']";
        let district = "#form_reg_company [name='companyTH_districts']";
        let subdistrict = "#form_reg_company [name='companyTH_subdistricts']";
        let zipcode = "#form_reg_company [name='company_postcode']";
        let lang = 'th'//noncompanyTH_province
        show_drop_down_load(dropdown)
        add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    }

})
$(`[name="postcode"]`).on('keyup', function() {
    let postcode = $(this).val();
    let dropdown = '#dropdown_postcode';
    let province = "#form_reg_people [name='provinceTh']";
    let district = "#form_reg_people [name='districtTh']";
    let subdistrict = "#form_reg_people [name='subdistrictTh']";
    let zipcode = "#form_reg_people [name='postcode']";
    let lang = 'th'
    show_drop_down_load(dropdown)
    add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang)
})
$(`[name="corporation_postcode"]`).on('keyup', function() {
    let postcode = $(this).val();
    let dropdown = '#dropdown_corporation_postcode';
    let province = "#form_reg_company [name='corporation_province']";
    let district = "#form_reg_company [name='corporation_district']";
    let subdistrict = "#form_reg_company [name='corporation_subdistrict']";
    let zipcode = "#form_reg_company [name='corporation_postcode']";
    let lang = 'th'
    show_drop_down_load(dropdown)
    add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang)
})
//--- function --//
const show_drop_down_default = (e) => {
    $(e).empty();
    console.log(e);
    $(e).append(`<a class="dropdown-item drop-down-icon"><i class="fa fa-address-card-o" aria-hidden="true" style="font-size:1rem"></i> กรอกรหัสไปรษณีย์</a>`)
}
const show_drop_down_load = (e) => {
    $(e).empty();
    $(e).append(`<a class="dropdown-item drop-down-icon text-center">Loading...</a>`)
}
const add_data_dropdown = (postcode, dropdown, province, district, subdistrict, zipcode, lang) => {
    if (postcode != '') {
        clearTimeout(time_send_postcode);
        time_send_postcode = setTimeout(function() {
            get_address_from_zipcode(postcode, dropdown, province, district, subdistrict, zipcode, lang)
        }, 750);
    } else {
        $(dropdown).dropdown(`hide`)

    }
}

$(`[data="menu_perssent"]`).click(function() {
    $(`[data="menu_perssent"] >.nav-link`).css(`background`, ``)

    $(this).find(`.nav-link`).css(`background`, `#fff`)
})



$(document).ready(function() {
    const showAlert = () => {
      swal.fire({
        icon: 'warning',
        title: 'โปรดระบุการเข้าใช้งานระบบในฐานะ'
      });
    };

    const isDisabledElement = (element) => {
      return element.closest('input[readonly], input[disabled], select[readonly], select[disabled]');
    };

    // Check if no radio button is checked
    let is_director_checked = $('#form_reg_company input:radio[name="ck_director_type"]:checked').val();
    if (is_director_checked === undefined) {
      // Disable all input and select elements
      $('#type1_contact_group input, #type1_contact_group select').attr('readonly', true).attr('disabled', true);
    }

    // Listen for click events on elements within the #type1_contact_group div
    document.querySelector('#type1_contact_group').addEventListener('click', (event) => {
      if (is_director_checked === undefined && isDisabledElement(event.target)) {
        event.stopPropagation();
        showAlert();
      }
    });

    // Radio button change event
    $('input:radio[name="ck_director_type"]').change(function () {
      let divElement = document.querySelector('#type1_contact_group');
      let allInputs = divElement.querySelectorAll('input');
      let allSelect = divElement.querySelectorAll('select');

      allInputs.forEach(input => {
        $(input).removeAttr('readonly');
        input.disabled = false;
      });

      allSelect.forEach(select => {
        $(select).removeAttr('readonly');
        select.disabled = false;
        $(select).selectpicker('refresh');
      });

      let pval = $(this).val();
      console.log(pval);
      if (pval == 2) {
        $('.director-container').removeClass('d-none');
      } else {
        $('.director-container').removeClass('d-none');
        $('.director-container').addClass('d-none');
      }

      // Update is_director_checked value
      is_director_checked = pval;
    });
    // $('input:radio[name="ck_director_type"]:checked').change();


$(document).on('click','.dropdown-item',function(){
//   var id =   $(this).closest('.find').find('.btn-province').val()
//     console.log(id)
})
//  address companyTH
    $(document).on('change', '.btn-province', function () {
        var province = $(this).find('.dropdown-toggle').text()
        var useprovince = $.trim(province)
        console.log(useprovince)
        if (useprovince == "Bangkok" || useprovince == "กรุงเทพมหานคร") {
            $(this).closest('.find').find('.txtdetail').hide();
            $(this).closest('.find').find('.txtdistrict1').show();
            $(this).closest('.find').find('.txtsubdistrict1').show();
  
        } else {
            $(this).closest('.find').find('.txtdetail').show();
            $(this).closest('.find').find('.txtdistrict1').hide();
            $(this).closest('.find').find('.txtsubdistrict1').hide();
        }
  
  
      })
      // 
      $.ajax({
        url:BASE_URL + _INDEX +"/register/get_provinces",
        method: "post",
        beforeSend: function () {
          $('.modal-spin').modal('show');
        },
        data: '',
        success: function (result) {
          $.each(result, function (key, value) {
            if (result.lang === 'th') {
                if(value.id != undefined){
                    $(`#form_reg_noncompany [name^="companyTH_province"]`).append(
                        `<option value="${value.id}">${value.name_th}</option>`);
                }
            } else {
                if(value.id != undefined){
                    $(`#form_reg_noncompany [name^="companyTH_province"]`).append(
                    `<option value="${value.id}">${value.name_en}</option>`);
                }
            }
            
          });
          $('.selectpicker').selectpicker('refresh');
        },
        complete: function () {
          $('.modal-spin').modal('hide');
        }
      });
  
      const change_provinceTH_com = (obj) => {
        $(`#form_reg_noncompany [name="companyTH_districts"]`).find('option').remove();
        $(`#form_reg_noncompany [name="companyTH_subdistricts"]`).find('option').remove();
         $(`#form_reg_noncompany [name^="companyTH_subdistricts"]`).html(`<option value="">กรุณาเลือกอำเภอ</option>`);
        // $(`#form_reg_noncompany [name="company_postcode"]`).val('');
  
        var id = obj.val();
        console.log('in change' + id);
        //console.log(id)
        $.ajax({
          url:BASE_URL + _INDEX +"/register/get_amphures",
          method: "post",
          beforeSend: function () {
            $('.modal-spin').modal('show');
          },
          data: "id=" + id,
          success: function (result) {
            console.log(result);
            $.each(result, function (key, value) {
                if (result.lang === 'th') {
                    if(value.id != undefined){
                        $(`#form_reg_noncompany [name="companyTH_districts"]`).append(
                            `<option value="${value.id}">${value.name_th}</option>`);
                    }
                } else {
                    if(value.id != undefined){
                        $(`#form_reg_noncompany [name="companyTH_districts"]`).append(
                            `<option value="${value.id}">${value.name_en}</option>`);
                    }
                }
              
            });
            $('.selectpicker').selectpicker('refresh');
  
            let select_district = $("#form_reg_noncompany [name='companyTH_districts']").val();
            let option_district = $("#form_reg_noncompany [name='companyTH_districts'] option");
            $.each(option_district, function (index, item) {
              if ($(item).html() == select_district) {
                $(item).prop("selected", true);
                $('.selectpicker').selectpicker('refresh');
                return false;
              }
            });
                    $("#form_reg_noncompany [name='company_provinceEn']").val(id).change();
            // store data option to sub_districe
            
            change_district_com($(`[name^="companyTH_districts"]`))
          },
          complete: function () {
            $('.modal-spin').modal('hide');
          }
        });
      }
      const change_districtTH_com = (obj) => {
        $(`#form_reg_noncompany [name^="companyTH_subdistricts"]`).find('option').remove();
        $(`#form_reg_noncompany [name^="companyTH_subdistricts"]`).html(`<option value="">กรุณาเลือกอำเภอ</option>`);
        $('.selectpicker').selectpicker('refresh');
        // $(`#form_reg_noncompany [name^="company_postcode"]`).val('');
  
        var id = obj.val();
        console.log(id)
        //console.log(id)
        $.ajax({
          url:BASE_URL + _INDEX +"/register/get_districts",
          method: "post",
          beforeSend: function () {
            $('.modal-spin').modal('show');
          },
          data: "id=" + id,
          success: function (result) {
            //console.log(result)
            $.each(result, function (key, value) {
              //console.log(value)
              if (result.lang === 'th') {
                if(value.id != undefined){
                  $(`#form_reg_noncompany [name^="companyTH_subdistricts"]`).append(
                    `<option value="${value.id}">${value.name_th}</option>`);
                  }
              } else {
                if(value.id != undefined){
                  $(`#form_reg_noncompany [name^="companyTH_subdistricts"]`).append(
                    `<option value="${value.id}">${value.name_en}</option>`);
                }
              }
              
            });
            $('.selectpicker').selectpicker('refresh');
  
            let select_subdistrict = $("#form_reg_noncompany [name='companyTH_subdistricts']").val();
            let option_subdistrict = $("#form_reg_noncompany [name='companyTH_subdistricts'] option");
            $.each(option_subdistrict, function (index, item) {
              if ($(item).html() == select_subdistrict) {
                $(item).prop("selected", true);
                $('.selectpicker').selectpicker('refresh');
                return false;
              }
            });

            var thdistrict = $("#form_reg_noncompany [name='company_districtEn']").val()
            if(thdistrict != id){
                $("#form_reg_noncompany [name='company_districtEn']").val(id).change();
            }
            $("#form_reg_noncompany [name='company_districtEn']").val(id).change();
          },
          complete: function () {
            $('.modal-spin').modal('hide');
          }
        });
      }
  
      $(`#form_reg_noncompany [name^="companyTH_province"]`).on('change', function () {
        change_provinceTH_com($(this));
      })
  
  
      /********** On Change amphures อำเภอ ***********/
      $(`#form_reg_noncompany [name^="companyTH_districts"]`).on('change', function () {
        change_districtTH_com($(this));
      })
      $(`#form_reg_noncompany [name^="companyTH_subdistricts"]`).on('change', function () {
        var id = $(this).val();
  
        $.ajax({
          url:BASE_URL + _INDEX +"/register/get_zipcode",
          method: "post",
          beforeSend: function () {
            $('.modal-spin').modal('show');
          },
          data: "id=" + id,
          success: function (result) {
            console.log(result[0].zip_code)
            $(`#form_reg_noncompany [name^="company_postcode"]`).val(result[0].zip_code);
            var thprovince = $("#form_reg_noncompany [name='company_subdistrictEn']").val()
            if(thprovince != id){
                $("#form_reg_noncompany [name='company_subdistrictEn']").val(id).change();
            }
            $("#form_reg_noncompany [name='company_subdistrictEn']").val(id).change();
          },
          complete: function () {
            $('.modal-spin').modal('hide');
          }
        });
      })

// 



    $(`#form_reg_foreigner .foreigner-address`).hide();
    $(".warning-niti").hide();
    $(".warning-pass").hide();
    $(".warning-repass").hide();
    $("#show-input").hide();
    // $("#show-pass").hide();
    // $("#show-repass").hide();


    /////// niti///////////
    $("#password").on("change", function() {
        console.log($(this).val().length);
        if ($(this).val().length < 8) {
            $(".warning-pass.pass").show();
        } else {
            $(".warning-pass.pass").hide();
        }
    });

    $("#repassword").on("change", function() {
        let old_pass = $(`#password`).val();
        if ($(this).val() != old_pass) {
            $(".warning-repass").show();
        } else {
            $(".warning-repass").hide();
        }
    });

    $("#repassword").on("change", function() {
        if ($(this).val().length < 8) {
            $(".warning-pass.repass").show();
        } else {
            $(".warning-pass.repass").hide();
        }
    });

    /////// noaml ///////////
    $("#password_nomal").on("change", function() {
        console.log($(this).val().length);
        if ($(this).val().length < 8) {
            $("#pass_nomal").show();
        } else {
            $("#pass_nomal").hide();
        }
    });
    $("#repassword_nomal").on("change", function() {
        let old_pass = $(`#password_nomal`).val();
        if ($(this).val() != old_pass) {
            $("#repass_nomal").show();
        } else {
            $("#repass_nomal").hide();
        }
    });

    /////// nonthai ///////////
    $("#password_nonthai").on("change", function() {
        console.log($(this).val().length);
        if ($(this).val().length < 8) {
            $("#pass_nonthai").show();
        } else {
            $("#pass_nonthai").hide();
        }
    });
    $("#repassword_nonthai").on("change", function() {
        let old_pass = $(`#password_nonthai`).val();
        if ($(this).val() != old_pass) {
            $("#repass_nonthai").show();
        } else {
            $("#repass_nonthai").hide();
        }
    });

    // $("#password").on("keyup", function() {
    //     $("#show-pass").show();
    // });
    // $("#repassword").on("keyup", function() {
    //     $("#show-repass").show();
    // });

    $(`#user_id`).on(`click`, function() {
        if ($(this).val() == '') {
            $(`#show-input`).show();
        } else {
            $(`#show-input`).hide();
        }
    });



    $.ajax({
        url:BASE_URL + _INDEX +"/register/get_country",
        method: "post",
        data: { "coutry": 1 },
        success: function(result) {

            $.each(result, function(key, data) {

                $('#country').append("<option class='country_name' value=" + data.CountryNameEN + ">" + data.CountryNameEN + "</option>");
                $('#pp_country').append("<option class='country_name' value=" + data.CountryNameEN + ">" + data.CountryNameEN + "</option>");

                // var span = parent.find('.text').text(data.CountryNameEN);
                // var input = "<input type='hidden' value="+data.CountryNameEN.trim()+" name='country_name'>";

                // parent.append(span);




            });
        }
    });

    $.ajax({
        url:BASE_URL + _INDEX +"/register/get_country",
        method: "post",
        data: { "coutry": 1 },
        success: function(result) {

            $.each(result, function(key, data) {

                $("#country1").append("<option class='country_name' value=" + data.CountryNameEN + ">" + data.CountryNameEN + "</option>");
                // console.log($("#country1").val());
                // var span = parent.find('.text').text(data.CountryNameEN);
                // var input = "<input type='hidden' value="+data.CountryNameEN.trim()+" name='country_name'>";

                // parent.append(span);




            });
        }
    });

    $('.digit-group').find('input').each(function() {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function(e) {
            var parent = $($(this).parent());
            
            if(e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));
                
                if(prev.length) {
                    $(prev).select();
                }
            } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));
                
                if(next.length) {
                    $(next).select();
                } else {
                    if(parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
    });

});

