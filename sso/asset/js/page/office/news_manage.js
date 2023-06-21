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



$(`#form_edit_news`).submit(function(){
    var data = $('#form_edit_news')[0];
    var data_form = new FormData(data);

    console.log(data_form);
    // return false;

    $.ajax({
        url: BASE_URL + _INDEX + "office/save_edit_news",
        processData: false,
        contentType: false,
        async: false,
        dataType: "json",
        method: "post",
        data: data_form,
        success: function (result) {
            console.log(result);
            if(result.status === '00'){
                //success
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                    //text: data.error,
                }).then(()=>{
                    window.location.href = BASE_URL + "office/news";
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

$(`#form_add_news`).submit(function(){
    var data = $('#form_add_news')[0];
    var data_form = new FormData(data);

    console.log(data_form);
    $.ajax({
        url: BASE_URL + _INDEX + "office/save_add_news",
        processData: false,
        contentType: false,
        async: false,
        dataType: "json",
        method: "post",
        data: data_form,
        success: function (result) {
            console.log(result);
            // let data = JSON.parse(result);
            if(result.status === '00'){
                //success
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                    //text: data.error,
                }).then(()=>{
                    window.location.href = BASE_URL + "office/news";
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

$(document).on('click', '.sso-btn-del', function () {
    let id = $(this).data('nid');
    console.log(id);

    Swal.fire({
        icon: "warning",
        title: 'ยืนยันการลบข่าวนี้',
        showCancelButton: true,
        confirmButtonText: 'ลบ',
        denyButtonText: 'ยกเลิก',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('confirmed'+id);
            $.ajax({
                url: BASE_URL+ "office/delete_news",
                method: "post",
                dataType: "json",
                data: {n_id:id},
                success: function(result) {
                    console.log('delete result: ' + result);
                    if (result.status === '00') {
                        Swal.fire({
                            icon: "success",
                            title: "ลบข่าวสำเร็จ"
                            //text: data.error,
                        }).then(()=>{
                            window.location.href = BASE_URL + "office/news";
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "เกิดข้อผิดพลาด : "+result.message,
                            //text: data.error,
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