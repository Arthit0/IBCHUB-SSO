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
<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
?>
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/bootstrap-select.min.css">
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/bootstrap-table.min.css">
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/page/home/home.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.min.css">
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

<script src='https://unpkg.com/@wanoo21/countdown-time@1.2.0/dist/countdown-time.js'></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr-thai/dist/flatpickr.min.js"></script> -->

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

  * {
    font-family: Mitr;
  }
  small {
    font-size: larger;
  }
  body {
    font-family: Mitr;
    font-size: 16px;
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
  <div class="modal modal-spin" tabindex="-1" role="dialog" style="justify:center;background-color: rgba(38, 35, 35, 0.68);" data-backdrop="static" data-keyboard="false">
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
  <nav class="navbar navbar-expand-md navbar-light frontend-navbar">
    <div class="container pl-0">
      <div class="navbar-brand pointer">
        <a href="<?php echo BASE_PATH . _INDEX ?>portal" class="">
          <img src="<?php echo BASE_PATH; ?>asset/img/new-sso-logo.png" alt="" style="height: 45px;">
        </a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item text-center px-2">
            <a class="nav-link" href="<?php echo BASE_PATH . _INDEX; ?>portal"><?= lang('home_navbar_home') ?></a>
          </li>
          <li class="nav-item text-center px-2">
            <a class="nav-link" href="<?php echo BASE_PATH . _INDEX; ?>portal/news"><?= lang('home_navbar_news') ?></a>
          </li>
          <li class="nav-item text-center px-2">
            <a class="nav-link" href="<?php echo BASE_PATH . _INDEX; ?>portal/contact"><?= lang('home_navbar_contact') ?></a>
          </li>
        </ul>
        <div class="btn-group align-items-center justify-content-end " style="display:inline-flex">
          <div class="d-flex justify-content-end align-items-center col-sm-6 pr-0" style="border-right: 1px solid black;height:15px">
            <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/th" class="change-lang w-100 text-right d-block " style="margin-bottom: 7px;">
              <img class="<?php echo ($lang == 'th') ? ' active ' : ''; ?>" src="<?php echo BASE_PATH; ?>asset/img/logo-th.png" style="height: 15px;width:15px;" alt="">
            </a>
            <a href="<?php echo BASE_PATH . _INDEX; ?>auth/lang/en" class="change-lang w-100 text-left d-block " style="margin-bottom: 7px;margin-right: 7px;">
              <img class="<?php echo ($lang == 'en') ? ' active ' : '';?>" src="<?php echo BASE_PATH; ?>asset/img/logo-en.png" style="height: 15px;width:15px;" alt="">
            </a>
            <span></span>
          </div>
          <div class="justify-content-end dropdown ml-2 col-sm-6">
            <button class="btn btn-sm dropdown-toggle profile-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo !empty($_SESSION['info']->member_nameTh)?$_SESSION['info']->member_nameTh:$_SESSION['info']->member_nameEn;?>  <?php echo !empty($_SESSION['info']->member_lastnameTh)?$_SESSION['info']->member_lastnameTh:$_SESSION['info']->member_lastnameEn;?> 
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="<?php echo BASE_PATH . _INDEX; ?>portal/profile">
                <img src="<?php echo BASE_PATH; ?>asset/img/profile-black.png" alt="">&nbsp;
                <span><?= lang('home_navbar_profile') ?></span>
              </a>
              <a class="dropdown-item" href="<?php echo BASE_PATH . _INDEX; ?>portal/forget">
                <img src="<?php echo BASE_PATH; ?>asset/img/change-password.png" alt="">&nbsp;
                <span><?= lang('home_navbar_change_password') ?></span>
              </a>
              <a class="dropdown-item" href="<?php echo BASE_PATH . _INDEX; ?>portal/logout">
                <img src="<?php echo BASE_PATH; ?>asset/img/logout.png" alt="">&nbsp;
                <span><?= lang('home_navbar_logout') ?></span>
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </nav>
  <?php if ($_GET['test'] == 1123): ?>
    <?php pr($_SESSION); ?>
    <?php pr($_COOKIE); ?>
  <?php endif ?>
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
  <footer>
    <div class="frontend-footer pl-0">
      <div class="main-footer p-1">
        <p class="mb-0 mitr-r _f16">Copyright 2018 © Department of International Trade Promotion, Ministry of Commerce, Thailand. All right Reserved</p>
      </div>
      <div class="mini-footer">
        <div class="col-sm-6 footer-contact">
          <p class="mitr-r _f16">563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000
          โทร : 02507 7999 | e-mail : 1169@ditp.go.th</p>
        </div>
        <div class="col-sm-6 footer-logo">
          <img src="<?php echo BASE_PATH; ?>asset/img/ditp-logo.png" alt="ditp-logo">
        </div>
      </div>
    </div>
  </footer>
  <iframe name="k_frame" id="k_frame" style="display:none;"></iframe>
  <script>
    $(function(){
        $('a').each(function(){
            if ($(this).prop('href') == window.location.href) {
                $(this).addClass('active'); $(this).parents('li').addClass('active');
            }
        });
    });
  </script>
<!--   <?php if (empty($_SESSION)): ?>
    <script>
      Swal.fire({
        icon: 'danger',
        title: 'Session หมดอายุกรุณาเข้าสู่ระบบใหม่'
      })
    </script>
  <?php endif ?> -->
</body>

</html>