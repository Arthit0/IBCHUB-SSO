<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4 menu-left-lte" style="background-color: background: linear-gradient(172.26deg, #1D61BD -32.7%, #5DBDE6 114.16%)!important;">
  <!-- Brand Logo -->
  <div class="brand-link" style="height: 62px;">
      <!--<a class="nav-link" id="push_left" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>-->

    <img src="<?php echo BASE_PATH; ?>asset/img/new-sso-logo-white.png" alt="SSO Logo" width="30%" class="ml-5" style="margin-left:78px !important;">
    <span class="brand-text font-weight-light"></span>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?php echo BASE_PATH . _INDEX; ?>office/dashboard" class="nav-link <?php if($_SESSION['page'] == "dashboard") echo "active"; ?>">
            <i class="fa-solid fa-house px-1"></i>
            <p>
              Dashboard
            </p>
          </a>  
        </li>
        <li class="nav-item <?php if($_SESSION['page'] == "usertype1"
                                    || $_SESSION['page'] == "usertype2"
                                    || $_SESSION['page'] == "usertype3"
                                    || $_SESSION['page'] == "usertype4"
                                    || $_SESSION['page'] == "usertype6"
                                    || $_SESSION['page'] == "cancel"
          ) echo "menu-open"; ?>">
          <a href="<?php echo BASE_PATH . _INDEX; ?>office/user" class="nav-link">
            <i class="fa fa-user px-1"></i>
            <p>
              ผู้ใช้งาน
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo BASE_PATH . _INDEX; ?>office/user?type=1" class="nav-link <?php if($_SESSION['page'] == "usertype1") echo "active"; ?>">
                <p>นิติบุคคล (ไทย)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo BASE_PATH . _INDEX; ?>office/user?type=6" class="nav-link <?php if($_SESSION['page'] == "usertype6") echo "active"; ?>">
                <p>นิติบุคคลไม่ได้จดทะเบียน (ไทย)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo BASE_PATH . _INDEX; ?>office/user?type=2" class="nav-link <?php if($_SESSION['page'] == "usertype2") echo "active"; ?>">
                <p>นิติบุคคล (ต่างชาติ)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo BASE_PATH . _INDEX; ?>office/user?type=3" class="nav-link <?php if($_SESSION['page'] == "usertype3") echo "active"; ?>">
                <p>บุคคลทั่วไป (ไทย)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo BASE_PATH . _INDEX; ?>office/user?type=4" class="nav-link <?php if($_SESSION['page'] == "usertype4") echo "active"; ?>">
                <p>บุคคลทั่วไป (ต่างชาติ)</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?php echo BASE_PATH . _INDEX; ?>office/user?type=5" class="nav-link <?php if($_SESSION['page'] == "usertype5") echo "active"; ?>">
                <p>อื่นๆ</p>
              </a>
            </li> -->
            <li class="nav-item">
              <a href="<?php echo BASE_PATH . _INDEX; ?>office/cancel" class="nav-link <?php if($_SESSION['page'] == "cancel") echo "active"; ?>">
                <p>
                  ยกเลิกสมาชิก
                </p>
              </a>
            </li>
          </ul>
        </li>  
        <li class="nav-item">
          <a href="<?php echo BASE_PATH . _INDEX; ?>office/admin" class="nav-link <?php if($_SESSION['page'] == "admin") echo "active"; ?>">
            <i class="far fa-id-card px-1"></i>
            <p>
              เจ้าหน้าที่
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_PATH . _INDEX; ?>office/client" class="nav-link <?php if($_SESSION['page'] == "client") echo "active"; ?>">
            <i class="fa-solid fa-grip px-1"></i>
            <p>
              จัดการผู้ให้บริการ API
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_PATH . _INDEX; ?>office/news" class="nav-link <?php if($_SESSION['page'] == "news") echo "active"; ?>">
            <i class="fa-solid fa-newspaper fa-flip-horizontal px-1"></i>
            <p>
              จัดการข่าวสาร
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<script>
  /*$(`#push_right`).hide();
  $(`#push_left`).show();
  let state = "open";

  $(`#push_left`).click(function(){
    if(state == )
    $(`#push_right`).show();
  })

  $(`#push_right`).click(function(){
    $(`#push_left`).hide();
  })*/

  /*$('#toggle-button').on('expanded.lte.controlsidebar', function(){
    console.log('555');
  })*/
</script>