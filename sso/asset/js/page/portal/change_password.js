$('#submitform').on('click', function(){
  // let sendform = "";
  // let formkey = "form_changepassword"
  // let formdata = $("#" + formkey + "  :input");

  // if (formdata.length) {
  //   $.each(formdata, function (k, v) {
  //     let ele = $(v);
  //     //   sendform[ele.attr("name")] = ele.val();
  //     sendform += ele.attr("name") + "=" + ele.val() + "&";
  //   });
  // }
  var data = $('#form_changepassword')[0];
  var data_form = new FormData(data);

  // console.log(data_form);
  // return false;
  $.ajax({
    url: BASE_URL + "portal/changepassword_save",
    processData: false,
    contentType: false,
    async: false,
    dataType: "json",
    method: "post",
    data: data_form,
    beforeSend: function(){
      $('.modal-spin').modal('show');
    },
    success: function (result) {
      console.log(result);
      if (result.code == "01" || result.error) {

        if (result.error.length > 0) {
          $.each(result.error, function (k, v) {
            Swal.fire({
                icon: 'warning',
                title: v.value,
                confirmButtonText: v.btn,
            });
          });
          $('.modal-spin').modal('hide');
        }
        // $("#public_modal .modal-body").html(html);
        // $("#public_modal").modal("show");
      } else if(result.redirect != ""){
          Swal.fire({
              icon: 'success',
              title: 'เปลี่ยนรหัสผ่านสำเร็จ!',
              confirmButtonText: 'เข้าสู่ระบบ',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = BASE_URL + "portal/";
            }
          });
      }
    },
    complete: function() {
      $('.modal-spin').modal('hide');
    }
  });
  return false;
  
});

$(document).on('click', '#old-pass', function(){
  let type = $(`#old_password`).attr("type");
  if(type == 'password'){
    $(`#old_password`).attr("type", "text");
    $(this).attr("class", "fa fa-eye icon-password");
  }else{
    $(`#old_password`).attr("type", "password");
    $(this).attr("class", "fa fa-eye-slash icon-password");
  }
 
})

$(document).on('click', '#new-pass', function(){
  let type = $(`#new_password`).attr("type");
  if(type == 'password'){
    $(`#new_password`).attr("type", "text");
    $(this).attr("class", "fa fa-eye icon-password");
  }else{
    $(`#new_password`).attr("type", "password");
    $(this).attr("class", "fa fa-eye-slash icon-password");
  }
 
})

$(document).on('click', '#confirm-pass', function(){
  let type = $(`#confirm_password`).attr("type");
  if(type == 'password'){
    $(`#confirm_password`).attr("type", "text");
    $(this).attr("class", "fa fa-eye icon-password");
  }else{
    $(`#confirm_password`).attr("type", "password");
    $(this).attr("class", "fa fa-eye-slash icon-password");
  }
 
})