var is_laser_ck = 1;
$(".btn-profile-submit").click(function() {
	
	let type = $(this).data('member_type');
	let fname = $(this).data('fname');
	let lname = $(this).data('lname');
    let email = $(this).data('member_email');
    let phone = $(this).data('member_phone');
	let contact_title = $(this).data('contact_title');
	let birthday = $(this).data('birthday');
    let callback = $(this).data('callback');
	let input_fname = $("#type3_form input[name=member_nameTh]").val();
	let input_lastname = $("#type3_form input[name=member_lastnameTh]").val();
	let input_contact_title = $("#type3_form input[name=contact_title]").val();
	let input_birthday = $("#type3_form input[name=member_birthday]").val();
    let input_email = $("#type3_form input[name=email]").val();
    let input_phone = $("#type3_form input[name=tel]").val();
	let personal_info = $('#type3_form')[0];
	let personal_address = $('#personal_address')[0];
	let type3Form = new FormData($('#type3_form')[0]);
	type3Form.append('type', type);
    type3Form.append('callback', callback);
    let email_change = 0;
    let phone_change = 0;
	//เช็คก่อนว่าเปลี่ยนชื่อไหม
	if (fname != input_fname || lname != input_lastname || contact_title != input_contact_title) {
		if (is_laser_ck == 1) {
			$("#personal_laser_modal").modal();
			return false;
		}
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
    let name = $('#type3_form input[name^="member_nameTh"]').val();
    let lastname = $('#type3_form input[name^="member_lastnameTh"]').val();
    // let bday = $('#type3_form input[name^="member_birthday"]').val();
    let cid = $('#type3_form input[name^="contact_cid"]').val();
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

$('.ck-citizen-type3-laser-btn').click(function() {
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
