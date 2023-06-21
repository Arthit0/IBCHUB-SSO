<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4 menu-left-lte" style="background: url('<?php echo BASE_PATH; ?>asset/img/group-2-2.png') center center / cover no-repeat;">
  <!-- Brand Logo -->
  <div class="brand-link bg-light" style="height: 62px;">
      <!--<a class="nav-link" id="push_left" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>-->

    <img src="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" alt="SSO Logo" width="30%" class="ml-5" style="margin-left:78px !important;">
    <span class="brand-text font-weight-light"></span>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      
      <li class="nav-item">
          <a href="<?php echo BASE_PATH . _INDEX; ?>office/dashboard" class="nav-link <?php if($_SESSION['page'] == "dashboard") echo "active"; ?>" style="color:white;">
            <i class="fa fa-users px-1"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo BASE_PATH . _INDEX; ?>office/user" class="nav-link <?php if($_SESSION['page'] == "user") echo "active"; ?>" style="color:white;">
            <i class="fa fa-users px-1"></i>
            <p>
              User management
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_PATH . _INDEX; ?>office/client" class="nav-link <?php if($_SESSION['page'] == "client") echo "active"; ?>" style="color:white;">
            <i class="fa fa fa-cog px-1"></i>
            <p>
              Client management
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_PATH . _INDEX; ?>office/cancel" class="nav-link <?php if($_SESSION['page'] == "cancel") echo "active"; ?>" style="color:white;">
            <i class="fa fa fa-cog px-1"></i>
            <p>
              cancel to member
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