$(document).ready(function(){
    $(`#formlogin`).submit(function(){
        let sendform = $(this).serialize();
        $.ajax({
            url: BASE_URL + _INDEX + "home/login",
            method: "post",
            data: sendform,
            success: function (result) {
                let data = JSON.parse(result);
                if(data.status === '00'){
                    //success
                    window.location.href = BASE_URL + _INDEX + "home/user";
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
                console.log(result);
            }
        });
        return false;
    })
})