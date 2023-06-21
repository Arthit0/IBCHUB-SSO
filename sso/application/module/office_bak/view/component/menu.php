<style>
  .sso-nav{
    box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.25);
    background-color: #ffffff;
    height: 70px;
    z-index: 1;
  }
  .sso-logo-nav{
    width: 98px;
    height: 56px;
    object-fit: contain;
    padding: 5px 5px 5px 5px !important;
    margin-left:5px;
  }

  .icon-toggle{
    background-color: #629cc1;
    padding :10px; 
    color:white;
    border-radius: 100px;
    font-size: 18px;
  }
  .icon-logout{
    background-color: #629cc1;
    padding :10px; 
    color:white;
    border-radius: 100px;
    font-size: 18px;
  }
  .menu_left{
    margin-top: -100px;
    margin-left: -6px;
    padding: 0px 0px 0px 0px;
  }
  .sso-menu{
    color:white;
    font-size:24px;
    display: block;
    padding-top:8px;
  }
  .sso-menu:hover{
    color:white;
    /*background-color: rgba(66, 124, 151, 0.6);*/
    text-decoration-line: none;
    width: 100%;
    height:50px;
    display: block;
  }
  .sso-menu-li{
    height:50px;
  }
  .sso-table{
    font-size:18px;
  }
  .sso-table.table-striped tbody tr:nth-of-type(odd) {
    /*background-color: #629cc1;
    opacity: 0.3;*/
    color:black;
  }
  .sso-table.table-striped tbody tr:nth-of-type(even) {
    /*background-color: #629cc1;
    opacity: 0.1;*/
    color:black;
  }
  .sso-table.table thead th {
    background: #629cc1;
    color:white;
  }
</style>

<nav class="navbar navbar-light bg-light sso-nav">
  <div class="col-6">
    <p>
      <!--<i class="fa fa-list-ul icon-toggle"></i>-->
      <a href="<?php echo BASE_PATH . _INDEX; ?>office">
        <img class=" sso-logo-nav" src="<?php echo BASE_PATH; ?>asset/img/sso-logo.png" alt="">
      </a>
    </p>
  </div>
  <div class="col-6 text-right">
    <div class="form-group">
      <h3><?php echo $_SESSION['name_admin']; ?> &nbsp; <a href="<?php echo BASE_PATH . _INDEX; ?>office/logout"><i class="fa fa-sign-out icon-logout"></i></a></h3>
    </div>
  </div>
  
</nav>

<div class="container-fluid">
  <div class="row  con-box-row">

  
    <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 menu_left" style="background: url('<?php echo BASE_PATH; ?>asset/img/group-2.png') center center / cover no-repeat; 
    height: 100%; 
    min-height: 1235.19px;">

      <ul class="nav navbar-nav" style="margin-top:103px">
        <li class="sso-menu-li"><a href="<?php echo BASE_PATH . _INDEX; ?>office/dashboard" class="sso-menu px-3"><i class="fa fa-users px-2"></i> Dashboard</a></li>
        <li class="sso-menu-li"><a href="<?php echo BASE_PATH . _INDEX; ?>office/user" class="sso-menu px-3"><i class="fa fa-users px-2"></i> User Management</a></li>
        <li class="sso-menu-li"><a href="<?php echo BASE_PATH . _INDEX; ?>office/client" class="sso-menu px-3"><i class="fa fa fa-cog px-2"></i> Clients Management</a></li>
        <li class="sso-menu-li"><a href="<?php echo BASE_PATH . _INDEX; ?>office/cancel" class="sso-menu px-3"><i class="fa fa fa-cog px-2"></i> cancel to member</a></li>
      </ul>
    </div>

    