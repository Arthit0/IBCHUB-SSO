<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light" style="margin-left: 0px !important; z-index: 1040; box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.25); background-color:#fff">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" id="push_right" data-widget="pushmenu" href="#" role="button" style="padding-top:2px"><i class="fa fa-bars icon-logout"></i></a>
    </li>
    <li class="nav-item">
      <img src="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" alt="SSO Logo" style="width:4rem">
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!--<li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li>-->

    <div class="form-group" style="height: 29px;">
      <h3 style="padding-top: 0.3rem;"><?php echo htmlentities($_SESSION['name_admin']); ?> &nbsp; <i class="fa fa-sign-out icon-logout logout" style="cursor:pointer;"></i></h3>
    </div>

  </ul>
</nav>
<!-- /.navbar -->

<script>
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
  })
</script>