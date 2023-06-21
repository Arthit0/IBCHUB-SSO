
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/adminlte.css">
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/bootstrap/css/OverlayScrollbars.min.css">

  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/bootstrap-table.min.css">

  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/js/vendors/chartjs/Chart.min.css">
  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/office.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  @font-face {
    font-family: Mitr;
    src: url('<?php echo BASE_PATH; ?>asset/font/mitr/Mitr-ExtraLight.ttf');
    font-weight: 200;
  }

  @font-face {
    font-family: Mitr;
    src: url('<?php echo BASE_PATH; ?>asset/font/mitr/Mitr-Light.ttf');
    font-weight: 300;
  }

  @font-face {
    font-family: Mitr;
    src: url('<?php echo BASE_PATH; ?>asset/font/mitr/Mitr-Regular.ttf');
    font-weight: 400;
  }

  @font-face {
    font-family: Mitr;
    src: url('<?php echo BASE_PATH; ?>asset/font/mitr/Mitr-Medium.ttf');
    font-weight: 500;
  }

  @font-face {
    font-family: Mitr;
    src: url('<?php echo BASE_PATH; ?>asset/font/mitr/Mitr-SemiBold.ttf');
    font-weight: 600;
  }

  @font-face {
    font-family: Mitr;
    src: url('<?php echo BASE_PATH; ?>asset/font/mitr/Mitr-Bold.ttf');
    font-weight: 700;
  }



  body {
    background-image: url('<?php echo BASE_PATH; ?>asset/img/group.png');
    background-repeat: no-repeat;
    background-color: #39414F;
    font-family: Mitr;
    font-size: 16px;
    font-weight: 400;
  }

  .mitr-el {
    font-weight: 200!important;
  }
  .mitr-l {
    font-weight: 300!important;
  }
  .mitr-r {
    font-weight: 400!important;
  }
  .mitr-m {
    font-weight: 500!important;
  }
  .mitr-sb {
    font-weight: 600!important;
  }
  .mitr-b {
    font-weight: 700!important;
  }

</style>
<div class="modal fade" id="load_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

      <div class="modal-content" style="background-color: unset;border: unset;box-shadow: unset;margin-top:19rem;">
        <div class="modal" style="padding: 1rem 2rem;border-bottom:unset;">

        </div>
        <div class="modal-body" style="height: 200px">

        <div class="row">
             <div class="col-5 col-xl-5 col-md-5 col-sm-5"></div>
             <div class="loader"></div>
             <div class="col-5 col-xl-5 col-md-5 col-sm-5"></div>
        </div>

        </div>
        <div class="modal-footer" style="border-top:unset;">

        </div>
      </div>
    </div>
  </div>