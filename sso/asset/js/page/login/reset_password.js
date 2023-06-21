$(document).ready(function(){
    function redirect(redirect_url){
        let ck_http = redirect_url[0]+redirect_url[1]+redirect_url[2]+redirect_url[3]
        if(ck_http == 'http'){ //web
            window.location.href = redirect_url;
        }else{ //not web
            window.location.href = BASE_URL+'office/reset_password_success'
        }
    }

    $(`#formreset`).submit(function(){
        let password = $(`[name="password"]`).val();
        let repassword = $(`[name="repassword"]`).val();
        let q = $(`[name="q"]`).val();
        //let letters = /^[0-9A-Za-z]+$/;
        let letters = /[A-Za-z]+/;

        // -- รหัสผ่าน -- //
        if(password == ""){
            Swal.fire({
                icon: "info",
                title: `รหัสผ่าน : กรุณากรอกข้อมูล`,
                //text: obj.message,
            });
            return false;
        }
        if(password.length < 8){
            Swal.fire({
                icon: "info",
                title: `รหัสผ่าน : อย่างน้อย 8 ตัว`,
                //text: obj.message,
            });
            return false;
        }
        // console.log(letters.test(password));
        // if(letters.test(password) == false){
        //     Swal.fire({
        //         icon: "info",
        //         title: `รหัสผ่าน : อักษร a - z อย่างน้อย 1 ตัว`,
        //         //text: obj.message,
        //     });
        //     return false;
        // }

        //-- เช็ครหัสผ่าน --//
        if(repassword == ""){
            Swal.fire({
                icon: "info",
                title: `ยืนยันรหัสผ่าน : กรุณากรอกข้อมูล`,
                //text: obj.message,
            });
            return false;
        }
        if(repassword.length < 8){
            Swal.fire({
                icon: "info",
                title: `ยืนยันรหัสผ่าน : อย่างน้อย 8 ตัว`,
                //text: obj.message,
            });
            return false;
        }

        // if(!letters.test(repassword)){
        //     Swal.fire({
        //         icon: "info",
        //         title: `ยืนยันรหัสผ่าน : อักษร a - z อย่างน้อย 1 ตัว`,
        //         //text: obj.message,
        //     });
        //     return false;
        // }

        //-- เช็คตรงกัน --
        if(password != repassword){
            Swal.fire({
                icon: "error",
                title: `เกิดข้อผิดพลาด : ยืนยันรหัสผ่านไม่ตรงกัน`,
                //text: obj.message,
            });
            return false;
        }
        $.ajax({
            url: BASE_URL + _INDEX + "auth/reset_save",
            method: "post",
            data: { password : password, q : q },
            beforeSend: function(){
                $('.modal-spin').modal('show');
            },
            success: function (result) {
                let data = JSON.parse(result);
                if(data.res_code == '00'){
                    if(data[0].callback == undefined){
                        window.location.href = BASE_URL + _INDEX + "auth?response_type="+data[0].response_type+"&client_id="+data[0].client_id+"&redirect_uri="+data[0].redirect_uri;
                        return false;
                    }else if(data[0].callback != undefined){
                        Swal.fire({
                            icon: "success",
                            title: `เปลี่ยนรหัสผ่านสำเร็จ`,
                            //text: obj.message,
                        }).then(function(){
                            window.location.href = data[0].callback;
                            return false;
                        });
                        
                    }else if(typeof data.code !== 'undefined'){
                        if(data.code.hasOwnProperty('code_care')){
                        var pass = $(`[name="password"]`).val();
                        //let fetch_care = fetch('https://care.ditp.go.th/api/api_caresaveuser.php?code='+data.code.code_care+'&xx='+data.code.xx)
                        let fetch_care = fetch('https://care.ditp.go.th/api/api_caresaveuser.php?code='+data.code.code_care+'&xx='+pass)
                        .then(()=>{
                            $.ajax({
                            url: BASE_URL + _INDEX + "register/login_after_reg",
                            method: "post",
                            //data: { email : data.code.ee, pass : data.code.xx },
                            data: { email : data.code.ee, pass : pass },
                            success: function (result) {
                                $('.modal-spin').modal('hide');
                                if(data.pdpa.status == '01'){
                                        redirect(data.pdpa.RedirectURL);
                                  }else{
                                        redirect(data.url);
                                  }
                                //window.location.href = data.url;
                            }
                            });
                        });
                        }
                        if(data.code.hasOwnProperty('code_drive')){
                            //console.log(data.code.code_drive)
                            //let fetch_drive = fetch('https://testdrive.ditp.go.th/Default.aspx?TabId=148&language=th-TH&code='+data.code.code_drive)
                            let fetch_drive = fetch('https://drive.ditp.go.th/Default.aspx?TabId=148&language=th-TH&code='+data.code.code_drive)
                            .then(()=>{
                                if(data.pdpa.status == '01'){
                                    redirect(data.pdpa.RedirectURL);
                              }else{
                                    redirect(data.url);
                              }
                            })
                            .catch(err => {
                                if(data.pdpa.status == '01'){
                                    redirect(data.pdpa.RedirectURL);
                              }else{
                                    redirect(data.url);
                              }
                            });
                        }
                    }else{
                        //window.location.href = data.url;
                        if(data.pdpa.status == '01'){
                            redirect(data.pdpa.RedirectURL);
                      }else{
                            redirect(data.url);
                      }
                    }
                }else if(data.res_code === '01'){
                    Swal.fire({
                        icon: "error",
                        title: `เกิดข้อผิดพลาด : `+data.message,
                        //text: obj.message,
                    }).then(function(){
                        window.location.href = BASE_URL;
                    });
                }else{
                    Swal.fire({
                        icon: "error",
                        title: `เกิดข้อผิดพลาด : ไม่สามารถบันทึกข้อมูลได้`,
                        //text: obj.message,
                    }).then(function(){
                        window.location.href = BASE_URL;
                    });
                }
            }
        })
        return false;
    })

    $(document).on('click', '#show-pass', function(){
        let type = $(`#password`).attr("type");
        if(type == 'password'){
          $(`#password`).attr("type", "text");
          $(this).attr("class", "fa fa-eye icon-password");
        }else{
          $(`#password`).attr("type", "password");
          $(this).attr("class", "fa fa-eye-slash icon-password");
        }
       
      })

      $(document).on('click', '#show-repass', function(){
        let type = $(`#repassword`).attr("type");
        if(type == 'password'){
          $(`#repassword`).attr("type", "text");
          $(this).attr("class", "fa fa-eye icon-password");
        }else{
          $(`#repassword`).attr("type", "password");
          $(this).attr("class", "fa fa-eye-slash icon-password");
        }
       
      })
    
    
});