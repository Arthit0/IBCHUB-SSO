<style>
.bell-num  {
  width: 23px !important;
    height: 23px !important;
    border-radius: 50% !important;
    background: #e7081d !important;
    transform: translate(-69%, -58%) !important;
    font-size: 12px !important;
    padding: 2px  0px 0px 0px;
    color: #ffff;
}
.bell-none  {
  width: 23px !important;
    height: 23px !important;
    border-radius: 50% !important;
    background: rgb(255 255 255 / 0%) !important;
    transform: translate(-69%, -58%) !important;
    font-size: 12px !important;
    padding: 2px  0px 0px 0px;
    color: #ffff;
}
#modal_noti.modal-backdrop {
  display: none;
 
}
.hide{
  display: none;
}

</style>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light" style="z-index: 1038; box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.25); background-color:#fff">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" id="push_right" data-widget="pushmenu" href="#" role="button" style="padding-top:2px"><i class="fa fa-bars icon-logout"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <div class="form-group mb-0"   style="height: 29px;" id="noti" role="button" data-toggle="dropdown" aria-expanded="false">
      <span class="d-inline-flex align-items-center"> <i class="fa fa-bell pointer" style="font-size: 25px;color: #2D6DC4;"></i>
      </span>
      <label class="bell-num text-center" id="bells">5</label>
      <div class="dropdown sso-table" style="left: -907%;margin-top: -11%;">
          <ul class="dropdown-menu" id="noti_list"  aria-labelledby="noti"  style="width: 1000%;height: 284px;border-radius: 6px;background: #ffff;overflow-y: scroll;">
             
          </ul>
      </div>
    </div>
    <div class="form-group mb-0" style="height: 29px;">
      <span class="d-inline-flex align-items-center"><h3 class="mitr-r _f16" style="padding-top: 0.3rem;"><?php echo htmlentities($_SESSION['name_admin']); ?> </h3>&nbsp; <img width="15px" class="logout-img logout pointer" src="<?php echo BASE_PATH . _INDEX."asset/img/logout.png" ?>" alt="logout"></span>
    </div>

  </ul>

</nav>
<!-- /.navbar -->
<!-- <div class="modal" id="modal_noti" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
    </div>
  </div>
</div> -->
<script>
    function myFunction(data) {
      window.location.replace(data);
    }
  $.ajax({ 
    url: BASE_URL + _INDEX + "office/noti_sso",
    method: "GET",
    dataType: "text",
    beforeSend: function() {
              $('#noti_list').empty();
    },
    success: function (result) {
      var res = JSON.parse(result);
      var list = '';
      if(res.count < 1){
          document.getElementById("bells").style.background = "#ffff";
        // document.getElementById("bells").style.display = "none";
         list = `
                    <li>
                      <a class="dropdown-item" href="#" style="background: #ffff;border-bottom: 1px solid #A6ACB6;">
                        <div class="row d-inline-flex align-items-center mb-2 w-100">
                          <div class="col-sm-12  text-center">
                            <p><b>ไม่มีการเเจ้งเตือน</b></p>
                          </div>
                      </a>
                    </li>
              `;
      }else{
        if(res.count_active > 0){
          document.getElementById("bells").classList.remove('bell-none');
          document.getElementById("bells").classList.add('bell-num');
          $('#bells').empty().append(res.count_active);
        }else{
          // bell-none
          document.getElementById("bells").classList.remove('bell-num');
          document.getElementById("bells").classList.add('bell-none');
          $('#bells').empty().append(0);
        }
        document.getElementById("noti_list").style.background = res.background;
        $.each(res.data, function(key, value) {
            if(key == 0){
              list = `
                    <li onclick="myFunction('`+value.url+`')">
                      <a class="dropdown-item" href="`+value.url+`" style="background: `+value.background+`;">
                        <div class="row d-inline-flex align-items-center mb-2 w-100">
                          <div class="col-sm-8  text-left">
                            <p><b>`+value.status+`</b></p>
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 text-right" style="color: #8A919E;">
                              <p>`+value.date_noti+`</p>
                          </div>
                          <div class="col-sm-8  text-left">
                            <p>`+value.cid+` `+value.company_nameTh+`</p>
                            <p>`+value.member_nameTh+`</p>
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 text-right" style="color: #ffff;">
                            <p `+value.point+`></p>
                          </div>
                        </div>
                      </a>
                    </li>
              `;
            }else{
              list = `
                    <li onclick="myFunction('`+value.url+`')">
                      <a class="dropdown-item" href="`+value.url+`" style="background: `+value.background+`;border-top: 1px solid #A6ACB6;">
                        <div class="row d-inline-flex align-items-center mb-2 w-100">
                          <div class="col-sm-8  text-left">
                            <p><b>`+value.status+`</b></p>
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 text-right" style="color: #8A919E;">
                              <p>`+value.date_noti+`</p>
                          </div>
                          <div class="col-sm-8  text-left">
                            <p>`+value.cid+` `+value.company_nameTh+`</p>
                            <p>`+value.member_nameTh+`</p>
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 text-right" style="color: #ffff;">
                            <p `+value.point+`></p>
                          </div>
                        </div>
                      </a>
                    </li>
              `;
            }
                
              $("#noti_list").append(list);
        });
      }
    }
  });


  $(`.logout`).on('click', function(){
    Swal.fire({
      icon: 'question',
      title: `แน่ใจหรือไม่ที่จะออกจากระบบ ?`,
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonText: "ใช่",
      cancelButtonText: "ยกเลิก"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = BASE_URL + _INDEX + "office/logout"
      }
    })
    return false
  });
</script>