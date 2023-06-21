$(document).on('click','.reset_save', function(){
    let password = $('#password').val();
    let repassword = $('#repassword').val();
    let id_admin = $(`#id_admin`).val();
    let letters = /[A-Za-z]+/;
    console.log(id_admin);
    // -- รหัสผ่าน -- //
    if(password == ""){
        Swal.fire({
            icon: "info",
            title: `รหัสผ่าน : กรุณากรอกข้อมูล`,
            //text: obj.message,
        });
        return false;
    }

    if(letters.test(password) == false){
        Swal.fire({
            icon: "info",
            title: `รหัสผ่าน : อักษร a - z อย่างน้อย 1 ตัว`,
            //text: obj.message,
        });
        return false;
    }

    //-- เช็ครหัสผ่าน --//
    if(repassword == ""){
        Swal.fire({
            icon: "info",
            title: `ยืนยันรหัสผ่าน : กรุณากรอกข้อมูล`,
            //text: obj.message,
        });
        return false;
    }


    if(!letters.test(repassword)){
        Swal.fire({
            icon: "info",
            title: `ยืนยันรหัสผ่าน : อักษร a - z อย่างน้อย 1 ตัว`,
            //text: obj.message,
        });
        return false;
    }
    //-- เช็คตรงกัน --
    if(password != repassword){
        Swal.fire({
            icon: "error",
            title: `เกิดข้อผิดพลาด : ยืนยันรหัสผ่านไม่ตรงกัน`,
            //text: obj.message,
        });
        return false;
    }
    //window.location.reload();
    $.ajax({
        type: "post",
        url: BASE_URL + 'office/edit_admin_password', 
        data: {password : password, id_admin : id_admin},
        success: function (response) {
            let data = JSON.parse(response)
            console.log(data)
            $(`#ShowModal`).modal('hide')
            if(data.res_code === '00'){
                Swal.fire({
                    icon: "success",
                    title: `บันทึกข้อมูลสำเร็จ`,
                    //text: obj.message,
                }).then(function(){
                    window.location.reload();
                })
            }else{
                Swal.fire({
                    icon: "error",
                    title: `เกิดข้อผิดพลาด : `+data.res_text,
                    //text: obj.message,
                }).then(function(){
                    window.location.reload();
                })
            }
            
        }
    });
})
$(document).on('click', '#show-pass', function(){
    let type = $(`input[name="password"]`).attr("type");
    if(type == 'password'){
      $(`input[name="password"]`).attr("type", "text");
      $(this).attr("class", "fa fa-eye icon-password");
    }else{
      $(`input[name="password"]`).attr("type", "password");
      $(this).attr("class", "fa fa-eye-slash icon-password");
    }
   
  })

$(document).on('click', '#show-repass', function(){
    let type = $(`input[name="repassword"]`).attr("type");
    if(type == 'password'){
      $(`input[name="repassword"]`).attr("type", "text");
      $(this).attr("class", "fa fa-eye icon-password");
    }else{
      $(`input[name="repassword"]`).attr("type", "password");
      $(this).attr("class", "fa fa-eye-slash icon-password");
    }
  })
  $(`#form_edit_admin`).submit(function(){
    var data = $('#form_edit_admin')[0];
    var data_form = new FormData(data);

    console.log(data_form);
    // return false;

    $.ajax({
        url: BASE_URL + _INDEX + "office/save_edit",
        processData: false,
        contentType: false,
        async: false,
        dataType: "json",
        method: "post",
        data: data_form,
        success: function (result) {

            if(result.status === '00'){
                //success
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                    //text: data.error,
                }).then(()=>{
                    window.location.href = BASE_URL + "office/client";
                });
            }else{
                //fail
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด : "+result.message,
                    //text: data.error,
                });
            }
            //console.log(data);
        }
    });
    return false;
});