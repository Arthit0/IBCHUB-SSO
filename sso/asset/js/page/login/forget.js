function ck_number(){
    let number = $(`[name="number"]`).val();
    //console.log(number);
    $.ajax({
        url : BASE_URL + _INDEX + "auth/ck_number",
        method : "post",
        data : {number : number},
        success: function (result) {
            let data = JSON.parse(result);
            if(data.status == '01'){
                Swal.fire({
                    icon: "error",
                    title: `เกิดข้อผิดพลาด : ${data.message}`,
                    //text: obj.message,
                });
            }else if(data.status == '00'){
                //success
                window.location.href = BASE_URL + _INDEX + "auth/reset";
            }
            //console.log(result);
        }
    })
}

function resend(){
    $('#formforget').submit()
 
}

function send_mail(member_id = '', email = '', target = '',callback = ''){
    // console.log(member_id,  email, target,callback);
    // return false;
    $.ajax({
        url: BASE_URL + _INDEX + "auth/send_mail",
        data: {member_id : member_id, email : email, target : target,callback : callback},
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

// function send_mail(member_id = '', email = '', target = ''){
//     console.log(222222);
//     $.ajax({
//         url: BASE_URL + _INDEX + "auth/send_mail",
//         data: {member_id : member_id, email : email, target : target},
//         method: "post",
//         beforeSend: function(){
//             $('.modal-spin').modal('show');
//         },
//         success: function (result) {
//             let obj = JSON.parse(result);
//             //$('.modal-spin').modal('hide'); //hide loading
//             //console.log(obj.status);
//             if(obj.status === '00'){
//                 $('#public_modal').modal('hide');
//                 // let text_mail = obj.email
//                 // show_mail = text_mail.substring(3, text_mail.length);
//                 // console.log(obj.message);
//                 html =
//                 `<h2><b>ระบบได้ส่งรายละเอียดการเปลี่ยนรหัสผ่านของคุณไปยัง email</b></h2>
//                 <h2 style="color:#4189b7"><b>${obj.email}</b></h2>
                
//                 <h4 style="color:#ff4747"><b>หากพบปัญหากรุณาติดต่อ 1169</b></h4>
//                 <p style="color:#ff4747; font-size:medium;">หมายเหตุ : หากไม่พบข้อมูลกรุณาตรวจสอบใน Junk mail (จดหมายขยะ)</p>
//                 <div class="col-12 col-lg-12 mt-4 form-inline justify-content-center">
//                     <div class="btn btn-primary w-20 bdr-20 btn-register mx-2" data-dismiss="modal" onclick="resend()" style="width:150px">ส่งอีกครั้ง</div>
//                     <a href="${BASE_URL+"auth"}" class="btn btn-primary w-20 bdr-20 btn-register mx-2" style="width:150px;">เข้าสู่ระบบ</a>
//                 </div>
//                 `
//                 $("#message_forget_modal .modal-body").html(html);
//                 $(`#message_forget_modal`).modal("show");
//             }else if(obj.status === '01'){
//                 //console.log(obj.message);
//                 Swal.fire({
//                     icon: "error",
//                     title: `เกิดข้อผิดพลาด : ${obj.message}`,
//                     //text: obj.message,
//                     onClose: closeModal
//                 })
//             }else{
//                 Swal.fire({
//                     icon: "error",
//                     title: `เกิดข้อผิดพลาด `,
//                     //text: obj.message,
//                     onClose: closeModal
//                 })
//             }
//         },
//         complete: function() {
//             $('.modal-spin').modal('hide');
//         }
//     });
//     return false;
// }

$(document).ready(function(){
    $(`#formforget`).submit(function(){
        console.log(333);
        $('.modal-spin').modal('show'); //show loading...

        // console.log($(`[name="member_cid"]`).val());
        let member_cid = $(`[name="member_cid"]`).val();
        $.ajax({
            url: BASE_URL + _INDEX + "auth/ck_mail",
            method: "post",
            data: { member_cid : member_cid },
            success: function (result) {
                let obj = JSON.parse(result);
                //hide loading
                //console.log(obj.status);

                
                if(obj.status === '00'){
                    if(obj.result.length == 1){
                        //console.log(typeof(obj.result[0].email)) 
                        send_mail(obj.result[0].member_id, obj.result[0].email, obj.result[0].target,obj.result[0].callback)
                    }else if(obj.result.length > 1){
                        $('.modal-spin').modal('hide');
                        let html = "";
                        html += "<div class='error-mess'>";
                        $.each(obj.result, function (k, v) {
                            //console.log(v)
                            let data = v.member_id+", '"+v.email+"', '"+v.target+"'"
                            console.log(data)
                            html += "<div class='row'>";
                            html += "<div class='col-12 p-header'>";
                            html += '';
                            html += "<h4><b>&nbsp;&nbsp;";
                            html += (k+1)+'. '+v.email+'&nbsp;&nbsp;';
                            html += v.target+'&nbsp;&nbsp;';
                            html += `<button class="btn btn-primary" onclick="send_mail(${data})"><font size='3'>เลือกใช้บัญชีนี้</font></button>`;
                            html += `</b></h4><hr>`;
                            html += "</div>";
                            html += "</div>";
                        });
                        html += "</div>";
                        $("#public_modal .modal-body").html(html);
                        $("#public_modal").modal("show");
                    }
                    return false;
                    
                }else if(obj.status === '01'){
                    $('.modal-spin').modal('hide');
                    //console.log(obj.message);
                    Swal.fire({
                        icon: "error",
                        title: `เกิดข้อผิดพลาด : ${obj.message}`,
                        //text: obj.message,
                        onClose: closeModal
                    })
                }else{
                    $('.modal-spin').modal('hide');
                    Swal.fire({
                        icon: "error",
                        title: `เกิดข้อผิดพลาด `,
                        // text: obj.message,
                        onClose: closeModal
                    })
                }
            },
            complete: function() {
                //$('.modal-spin').modal('hide');
            }
        })

        return false
    })
})

// $(document).ready(function(){
//     $(`#formforget`).submit(function(){
//         $('.modal-spin').modal('show'); //show loading...
//         //console.log($(`[name="member_cid"]`).val());
//         let member_cid = $(`[name="member_cid"]`).val();
//         let html = "";
//         $.ajax({
//             url: BASE_URL + _INDEX + "auth/send_mail",
//             method: "post",
//             beforeSend: function(){
//                 $('.modal-spin').modal('show');
//             },
//             data: { member_cid : member_cid },
//             success: function (result) {
//                 let obj = JSON.parse(result);
//                 //$('.modal-spin').modal('hide'); //hide loading
//                 //console.log(obj.status);
//                 if(obj.status === '00'){
//                     console.log(obj.message);
//                     html =
//                     `<!--<h2><b>ระบบจะทำการส่งข้อมูลไปที่อีเมล</b></h2>-->

//                     <h2><b>ระบบได้ทำการส่งตัวเลขรีเซ็ตรหัสผ่านไปที่</b></h2>
//                     <h2 style="color:#4189b7"><b>${obj.email}</b></h2>
//                     <p class="text-warning">*อาจอยู่ในจดหมายขยะ*</p>
//                     <h2><b>กรุณาตรวจสอบอีเมลของท่าน</b></h2>
//                     <input type="text" name="number" placeholder="กรอกตัวเลข 4 หลักใน Email"
//                     style="border-radius: 25px;
//                     border: 1px solid #cad8e140;
//                     -webkit-box-shadow: inset 0px 1px 1px 1px rgba(202, 216, 225, 1);
//                     -moz-box-shadow: inset 0px 1px 1px 1px rgba(202, 216, 225, 1);
//                     box-shadow: inset 0px 1px 1px 1px rgba(202, 216, 225, 1);
//                     padding: 22px 25px; 
//                     width: 80%;
//                     height: 30px;
//                     outline: none;"
//                     >
//                     <h4 style="color:#ff4747"><b>*หากท่านมีปัญหาหรือต้องการเปลี่ยน<br>อีเมลโปรดติดต่อเจ้าหน้าที่</b></h4>
//                     <div class="col-12 col-lg-12 mt-5">
//                         <!--<div class="btn btn-primary  w-50 bdr-20 btn-register" data-dismiss="modal" aria-label="Close">ต่อไป</div>-->
//                         <div class="btn btn-primary  w-50 bdr-20 btn-register" onclick="ck_number()">ต่อไป</div>
//                     </div>
//                     `
//                     $("#message_forget_modal .modal-body").html(html);
//                     $(`#message_forget_modal`).modal("show");
//                 }else if(obj.status === '01'){
//                     //console.log(obj.message);
//                     Swal.fire({
//                         icon: "error",
//                         title: `เกิดข้อผิดพลาด : ${obj.message}`,
//                         //text: obj.message,
//                         //onClose: closeModal
//                     })
//                 }else{
//                     Swal.fire({
//                         icon: "error",
//                         title: `เกิดข้อผิดพลาด`,
//                         //text: obj.message,
//                         //onClose: closeModal
//                     })
//                 }
//             },
//             complete: function() {
//                 $('.modal-spin').modal('hide');
//             }
//         })

//         return false
//     })
// })

function closeModal(){
    setTimeout(function(){$('.modal-spin').modal('hide')}, 400)
    //$('.modal-spin').modal('hide'); //hide loading
}