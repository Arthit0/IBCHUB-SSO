
$('#submitform').on('click', function(){
  let sendform = "";
  let formkey = "form_changepassword"
  let formdata = $("#" + formkey + "  :input");

  if (formdata.length) {
    $.each(formdata, function (k, v) {
      let ele = $(v);
      //   sendform[ele.attr("name")] = ele.val();
      sendform += ele.attr("name") + "=" + ele.val() + "&";
    });
  }

  $.ajax({
    url: BASE_URL + _INDEX + "auth/changepassword_save",
    method: "post",
    beforeSend: function(){
      $('.modal-spin').modal('show');
    },
    // data: JSON.parse(JSON.stringify(sendform)),
    // datatype: "json",
    data: sendform,
    success: function (result) {
      if (result.code == "01" || result.error) {
        let html = "";
        if (result.error.length > 0) {

          html += "<div class='error-mess'>";
          $.each(result.error, function (k, v) {
            let namee = $("#" + formkey + ' input[name="' + v.name + '"]').attr("placeholder")
            namee? $("#" + formkey + ' input[name="' + v.name + '"]').attr("placeholder") : v.name;
            html += "<div class='row'>";
            html += "<div class='col-12 p-header'>";
            html += namee;
            html += " ";
            html += v.value;
            html += "</div>";
            html += "</div>";
          });

          html += "</div>";

        }
        $("#public_modal .modal-body").html(html);
        $("#public_modal").modal("show");
      } else if(result.redirect != ""){
        window.location.replace(result.redirect);
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