var is_laser_ck = 1;
var is_laser_veri = 0;
$(".btn-profile-submit").click(function() {
    
    let type = $(this).data('member_type');
    let fname = $(this).data('fname');
    let lname = $(this).data('lname');
    let email = $(this).data('member_email');
    let phone = $(this).data('member_phone');
    let callback = $(this).data('callback');
    let veri_mail = $(this).data('status_email_verify');
    let veri_sms = $(this).data('status_sms_verify');
    let veri_laser = $(this).data('status_laser_verify');
    let contact_title = $(this).data('contact_title');
    let birthday = $(this).data('birthday');
    let status_contact_nationality = $(this).data('status_contact_nationality');
    let input_fname = $("#type16_edit input[name=member_nameTh]").val();
    let input_lastname = $("#type16_edit input[name=member_lastnameTh]").val();
    let input_contact_title = $("#type16_edit input[name=contact_title]").val();
    let input_birthday = $("#type16_edit input[name=member_birthday]").val();
    let input_email = $("#type16_edit input[name=member_email]").val();
    let input_phone = $("#type16_edit input[name=contact_tel]").val();
    let personal_info = $('#type16_edit')[0];
    let personal_address = $('#personal_address')[0];
    let type3Form = new FormData($('#type16_edit')[0]);
    type3Form.append('type', type);
    type3Form.append('status_contact_nationality', status_contact_nationality);
    type3Form.append('callback', callback);
    let email_change = 0;
    let phone_change = 0;
    
    console.log(status_contact_nationality)
    //เช็คก่อนว่าเปลี่ยนชื่อไหม
    if (fname != input_fname || lname != input_lastname || veri_laser == 0) {
        if (is_laser_ck == 1 && status_contact_nationality == 1) {
            $("#personal_laser_modal").modal();
            return false;
        }
    }

    if (is_laser_veri === 1) {
        type3Form.append('is_laser_veri', is_laser_veri);
    }
    
    if (email != input_email) {
        email_change = 1;
    }
    input_phone = input_phone.replace(/\s/g, "");
    console.log(input_phone)
    console.log(phone)
    // return false;
    if (phone != input_phone) {
        phone_change = 1;
    }
    type3Form.append('email_change', email_change);
    type3Form.append('phone_change', phone_change);
    type3Form.append('veri_mail', veri_mail);
    type3Form.append('veri_sms', veri_sms);
    // console.log(formData);

    $.ajax({
        url: BASE_URL + _INDEX + "/portal/profile_update",
        method: "post",
        processData: false,
        contentType: false,
        async: true,
        dataType: 'json',
        data:type3Form,
        success:function(result) {
            console.log(result);
            if (result.status == '00') {
                if (result.callback && result.callback != '') {
                    console.log('>>>>>>', result.callback)
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                    }).then((res) => {
                        if (res.isConfirmed) {
                            location.href = result.callback
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                    }).then((res) => {
                        if (res.isConfirmed) {
                            location.reload();  
                        }
                    });
                }
            } else if (result.code == "01" || result.error) {
                let html = "";
                let num_mes = result.error.length;
                console.log("add_member :" + result.error);
                if (result.error.length > 0) {
                    html += "<div class='error-mess'>";
                    $.each(result.error, function(k, v) {
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
                            html += namee;
                            html += " ";
                            html += v.value;
                            html += "</div>";
                            html += "</div>";
                        }
                    });
                    html += "</div>";
                    html += `<div class="col-12 col-lg-12 mt-5 text-center">
                    <div class="btn btn-primary  w-50 bdr-20 btn-register" data-dismiss="modal" aria-label="Close">ปิด / close</div>
                </div>`
                }
                $("#public_modal .modal-body").html(html);
                $("#public_modal").modal("show");
            }
        }
    })

});

$('#personal_laser_modal').on('show.bs.modal', function(e) {
    let name = $('#type16_edit input[name^="member_nameTh"]').val();
    let lastname = $('#type16_edit input[name^="member_lastnameTh"]').val();
    // let bday = $('#type16_edit input[name^="member_birthday"]').val();
    let cid = $('#type16_edit input[name^="contact_cid"]').val();
    // const date = new Date(bday.replace(/-/g, "/"));
    // const thbday = date.toLocaleDateString('th-TH', {
    //   year: 'numeric',
    //   month: 'long',
    //   day: 'numeric',
    // })
    $("#laser-modal-citizenid").empty().append(cid);
    $("#laser-modal-fname").empty().append(name);
    $("#laser-modal-lname").empty().append(lastname);
    // if (thbday == 'Invalid Date') {
    //     console.log(thbday)
    //     $("#laser-modal-bday").empty().append('');
    // }else {
    //     $("#laser-modal-bday").empty().append(thbday);
    // }
    $('#form_laser_people input[name^="cid"]').val(cid);
    $('#form_laser_people input[name^="fname"]').val(name);
    $('#form_laser_people input[name^="lname"]').val(lastname);
    // $('#form_laser_people input[name^="bday"]').val(bday);

});

$('.ck-contact-laser-btn').click(function() {
    var laser_form = $('#form_laser_people').serialize();
    $.ajax({
        url:BASE_URL + _INDEX +"/register/ck_laser",
        method: "post",
        data:laser_form,
        success:function(result) {
            console.log(result.result_code);
            if (result.result_code == '00') {
                $("#personal_laser_modal").modal('hide');
                is_laser_ck = 0;
                is_laser_veri = 1;
                $(".btn-profile-submit").click();
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
