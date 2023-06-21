var is_laser_ck = 1;
$(".btn-profile-submit").click(function() {
	
	let type = $(this).data('member_type');
    let email = $(this).data('member_email');
    let callback = $(this).data('callback');
	let personal_info = $('#type24_form')[0];
	let personal_address = $('#personal_address')[0];
    let input_email = $("#type24_form input[name=email]").val();
    let email_change = 0;
	let type24Form = new FormData($('#type24_form')[0]);
	type24Form.append('type', type);
    type3Form.append('callback', callback);
    if (email != input_email) {
        email_change = 1;
    }
    type24Form.append('email_change', email_change);
	// console.log(formData);

	$.ajax({
		url: BASE_URL + _INDEX + "/portal/profile_update",
		method: "post",
		processData: false,
		contentType: false,
		async: true,
		dataType: 'json',
		data:type24Form,
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

