/*$.ajax({
    url: BASE_URL + _INDEX + "office/data_table_client",
    method: "post",
    data: '',
    success: function (result) {
        var res = JSON.parse(result);
        $('.sso-table').bootstrapTable({data: res});
        $('.sso-table').bootstrapTable('refresh');
        console.log(res);
    }
});*/



$(`#form_edit_client`).submit(function(){
    var img = $('#portal-img')[0].files[0];
    var data = $('#form_edit_client')[0];
    var data_form = new FormData(data);
    data_form.append("img", img);

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

$(`#form_add_client`).submit(function(){
    var img = $('#portal-img')[0].files[0];
    var data = $('#form_add_client')[0];
    var data_form = new FormData(data);
    data_form.append("img", img);

    console.log(data_form);
    $.ajax({
        url: BASE_URL + _INDEX + "office/save_add",
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
$(document).on('click', '.client-del-btn', function() {
    let client_id = $(this).data('clientid');
    Swal.fire({
        icon: "warning",
        title: "ท่านยืนยันที่จะลบผู้บริการนี้ ?",
        showConfirmButton: true,
        showCancelButton: true,
    }).then((res) => {
        if (res.isConfirmed) {
            $.ajax({
                url: BASE_URL + "office/client_delete",
                method: "post",
                data: {client_id:client_id},
                success: function(result) {
                    if (result.res_code == '00') {
                        Swal.fire({
                            icon: "success",
                            title: "ลบรายการสำเร็จ"
                        }).then(()=>{
                            window.location.href = BASE_URL + "office/client";
                        });
                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "เกิดข้อผิดพลาด : "+result.res_text,
                        });
                    }
                }
            })
        }
    })
});

$(`#form_edit_cancel`).submit(function(){
    let data_form = $(this).serialize();
    $.ajax({
        url: BASE_URL+ "api/TextCancel",
        method: "post",
        data: data_form,
        success: function (result) {
            if(result.status == '200'){
                //success
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then(()=>{
                    window.location.href = BASE_URL + "office/cancel";
                });
            }else{
                //fail
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด : "+data.message,
                });
            }
        }
    });
    return false;
});