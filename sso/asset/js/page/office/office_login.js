$(document).ready(function(){
    //แสดง alert กิจกรรม
    $("#public_alert").modal("show");
    

    $(`#formlogin`).submit(function(){
        let sendform = $(this).serialize();
        $.ajax({
            url: BASE_URL + _INDEX + "office/login",
            method: "post",
            data: sendform,
            success: function (result) {
                let data = JSON.parse(result);
                if(data.status === '00'){
                    //success
                    // console.log(BASE_URL + "office/user?type=1");
                    // return false;
                    window.location.href = BASE_URL + "office/user?type=1";
                    return false;
                }else if(data.status === '01'){
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด : "+data.message,
                        //text: data.error,
                    });
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        //text: data.error,
                    });
                }
            }
        });
        return false;
    })
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