<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SSO</title>

  <!-- add icon link -->
  <link rel="icon" href="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" type="image/x-icon">
</head>
<?php
$cash_time = date('ymdhis');
?>
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/bootstrap-select.min.css">
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/bootstrap-table.min.css">

<!-- phone input -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

<script src="<?php echo BASE_PATH; ?>asset/bootstrap/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/bootstrap/js/popper.min.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/bootstrap/js/bootstrap.min.js"></script>

<script src="<?php echo BASE_PATH; ?>asset/js/controller.js?ver=<?php echo $cash_time; ?>"></script>

<script src="<?php echo BASE_PATH; ?>asset/js/sweetalert2.js"></script>

<script src="<?php echo BASE_PATH; ?>asset/js/bootstrap-select.min.js"></script>
<script src="<?php echo BASE_PATH; ?>asset/js/bootstrap-table.min.js"></script>

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
    /* background-size: cover; */
    background-repeat: no-repeat;
    background-color: #fbfcfc;
    font-family: Mitr;
    font-weight:bolder;
    font-size: 18px;
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
  button{
    z-index : 100;
  }
  .modal-backdrop {
    background-color: transparent;
  }
</style>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-190921230-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-190921230-1');
</script>
<!-------------------------------------------------->

<link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/main.css?v=<?php echo $cash_time; ?>">

<body class="sidebar-mini" ontouchstart="">

  <!-- Loading Modal -->
  <div class="modal modal-spin" tabindex="-1" role="dialog" style="justify:center" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">

      <!-- <div class="modal-content">
      <div class="modal-body"> -->
        <div class="d-flex justify-content-center">
          <div style="background-color:white; padding:10px; border-radius: 15px; box-shadow: 0px 0px 15px 0px rgba(184, 199, 219, 0.75);">
            <div class="spinner-border" role="status" style="color: #4189b7; background-color:white;">
              <!-- <span class="sr-only">Loading...</span> -->
            </div>
          </div>
        </div>
      <!-- </div>
      </div>  -->

    </div>
  </div>

  
  <?php
  if (is_array($data)) {
    extract($data);
  }

  // include(DIRECTORY_SEPARATOR.$path.'.php');
  $_ci_path = VIEWPATH . $path . '.php';
  if (file_exists($_ci_path)) {
    if (!is_php('5.4') && !ini_get('short_open_tag') && config_item('rewrite_short_tags') === TRUE) {
      echo eval('?>' . preg_replace('/;*\s*\?>/', '; ?>', str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
    } else {
      include($_ci_path); // include() vs include_once() allows for multiple views with the same name
    }
  }
  ?>
  <iframe name="k_frame" id="k_frame" style="display:none;"></iframe>
</body>

</html>