
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/adminlte.css">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/bootstrap/css/OverlayScrollbars.min.css">

  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/bootstrap-table.min.css">

  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="<?php echo BASE_PATH; ?>asset/js/vendors/chartjs/Chart.min.css">
  <!-- <link rel="stylesheet" href="<?php //echo BASE_PATH; ?>asset/css/main.css"> -->
  <style>
  @font-face {
    font-family: PSLKittithadaPro;
    src: url('<?php echo BASE_PATH; ?>asset/font/psl/PSL094pro.ttf');

  }

  @font-face {
    font-family: PSLKittithadaPro;
    src: url('<?php echo BASE_PATH; ?>asset/font/psl/PSL095pro.ttf');
    font-style: italic;
  }

  @font-face {
    font-family: PSLKittithadaPro;
    src: url('<?php echo BASE_PATH; ?>asset/font/psl/PSL096pro.ttf');
    font-weight: 600;
  }

  @font-face {
    font-family: PSLKittithadaPro;
    src: url('<?php echo BASE_PATH; ?>asset/font/psl/PSL097pro.ttf');
    font-weight: 600;
    font-style: italic;
  }
  .content-wrapper {
    background: none;
  }

  body {
    background-image: url('<?php echo BASE_PATH; ?>asset/img/group.png');
    /* background-size: cover; */
    background-repeat: no-repeat;
    background-color: #fbfcfc;
    font-family: PSLKittithadaPro;
    font-size:26px;
  }
  .sso-table{
    font-size:20px;
    border:unset !important;
  }
  .sso-table.table-striped tbody tr:nth-of-type(odd) {
    /*background-color: #629cc1;
    opacity: 0.3;*/
    color:black;
    background-color: #f0f5f9;
  }
  .sso-table.table-striped tbody tr:nth-of-type(even) {
    background-color: #cfe1eb;
    color:black;
  }
  .sso-table.table thead th {
    background: #629cc1;
    color:white;
    font-size:20px;
  }

  .bootstrap-table .fixed-table-container .table td, .bootstrap-table .fixed-table-container .table th {
    border-right: 1px solid #fff !important;
    border:unset;
  }

  .bootstrap-table .fixed-table-container .table td, .bootstrap-table .fixed-table-container .table th:last-of-type {
    border-right: unset !important;
  }

  .bootstrap-table .fixed-table-container .table td{
    border-right: 1px solid #fff !important;
  }
  .bootstrap-table .fixed-table-container .table td:last-of-type{
    border-right: unset !important;
  }

  .sso-btn-edit{
    border-radius: 21.5px;
    border:0px;
    background-color: #4189b7;
    color:white;
    width: 87px;
    font-size: 1rem;
  }
  .sso-btn-edit:hover{
    /*color:white;*/
  }
  .fixed-table-body{
    box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.3);
    border-radius: 15px;
    border: none;
  }
  .sso-btn-add{
    border-radius: 21.5px;
    border:0px;
    background-color: #4189b7;
    color:white;
    width: 120px;
    font-size: 18px;
  }
  .sso-btn-add:hover{
    color:white;
  }

  .btn-secondary:not(:disabled):not(.disabled):active, .btn-secondary:not(:disabled):not(.disabled).active, .show > .btn-secondary.dropdown-toggle {
    background-color: #f8f9fa;
    border-color: #ddd;
    color: #444;
  }
  .fixed-table-pagination .dropdown-toggle{
    background-color: #f8f9fa;
    border-color: #ddd;
    color: #444;
  }
  .fixed-table-pagination .dropdown-toggle:hover{
    background-color: #e9ecef;
    color: #2b2b2b;
  }
  .fixed-table-pagination .dropdown-toggle.active{
    background-color: #e9ecef;
    color: #2b2b2b;
  }
  
  .icon-logout{
    border-radius: 100px;
    background-color: #629cc1;
    height: 35px;
    width: 35px;
    color: white;
    padding: 8px 9px 9px 9px;
    font-size: 20px;
  }

  .bootstrap-table .fixed-table-pagination>.pagination, .bootstrap-table .fixed-table-pagination>.pagination-detail {
    margin-top: 10px;
    margin-bottom: 10px;
    font-size: 20px;
  }
  .dropdown-item.active, .dropdown-item:active {
    background-color: #4189b7;
  }
  .page-item.active .page-link {
      z-index: 3;
      color: #ffffff;
      background-color: #4189b7;
      border-color: #4189b7;
  }
  .page-link {
    color: black;
  }
  .search_button{
    border-radius: 0px 30px 30px 0px;
    background-color: #4189b7;
    font-size: 18px;
    color:white;
  }
  .search_button:hover{
    border-radius: 0px 30px 30px 0px;
    background-color: #4189b7;
    font-size: 18px;
    color:white;
  }

  .sso-btn-back{
    border-radius: 21.5px;
    background-color: #2b485b;
    border:0px;
    color:white;
    width: 107px;
    font-size: 1rem;
  }
  .sso-btn-back.modal-cancel:hover{
    border-radius: 21.5px;
    background-color: #2b485b;
    border:0px;
    color:white;
    /*width: 100px;*/
    font-size: 18px;
  }

  [class*='sidebar-light-'] .nav-sidebar > .nav-item > .nav-link.active {
    color: #000;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0), 0 1px 2px rgba(0, 0, 0, 0);
  }
  .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active, .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
    background-color: rgba(0, 0, 0, 0.1);
  }
  .menu-left-lte{
    height: 100%; 
    min-height: 1235.19px;
  }

    .div-col-1{
    padding-left: 0% !important;
    padding-right: 0% !important;
  }
  .div-col-2{
    margin-right: -85%;
  }
  .div-one{
  background-color: #3c8cb3;
  border-radius: 5px;
  padding-left: 10%;
  padding-right:10%;
  padding-top: 1.5%;
  }
  .div-sub-one{
    margin-top: -12%;
  }
  .tools-1{
  /* padding-left: 39% !important; */
  margin-top: 2.5%;
  }
  .tools-2{
  /* padding-left: 44% !important; */
  margin-top: -4%;
  }
  .tools-sub-1{
    padding-left: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .tools-sub-2{
    padding-left: 15% !important;
    font-family: PSLKittithadaPro;
    margin-top: -8%;
  }
  .tools-sub-3{
    padding-right: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .tools-sub-4{
    font-family: PSLKittithadaPro;
    padding-right: 15% !important;
    margin-top: -8%;
  }
  .div-drive{
  background-color: #2962ad;
  border-radius: 5px;
  padding-right: 6%;
  padding-left: 6%;
  padding-top: 2%;
  }
  .div-sub-drive{
    margin-top: 1%;
  }
  .div-drive-9{
    margin-top: 22%;
  }
  .drive-1{
  margin-top: 12%;
  }
  .drive-2{
  margin-top: -10%;
  }
  .drive-3{
  margin-top: -6%;
  }
  .drive-9{
  margin-top: 9.5%;
  }
  .drive-sub-1{
    /* padding-left: 6% !important; */
    font-family: PSLKittithadaPro;
    margin-top: 10%;
  }
  .drive-sub-2{
    /* padding-left: 18% !important; */
    font-family: PSLKittithadaPro;
    margin-top: -18px;
  }
  .drive-sub-3{
    /* padding-left: 18% !important; */
    font-family: PSLKittithadaPro;
    margin-top: -20%;
  }
  .drive-sub-4{
    /* padding-left: 18% !important; */
    font-family: PSLKittithadaPro;
    margin-top: -14px;
  }
  .div-e-academy{
  background-color: #0b428c;
  border-radius: 5px;
  padding-right: 6%;
  padding-left: 6%;
  padding-top: 5%;
  }
  .div-sub-e-academy{
    margin-top: -15%;
  }
  .e-academy-1{
    margin-top: -2%;
  }
  .e-academy-2{
  margin-top: -10%;
  }
  .e-academy-3{
  margin-top: -3%;
  }
  .div-business{
  background-color: #b95d5e;
  border-radius: 5px;
  padding-right: 6%;
  padding-left: 6%;
  padding-top: 5%;
  }
  .div-sub-business{
    margin-top: -15%;

  }
  .business-1{
    margin-top: -2%;
  }
  .business-2{
  margin-top: -10%;
  }
  .business-3{
  margin-top: -3%;
  }
  .div-SME{
  background-color: #bc2829;
  border-radius: 5px;
  padding-left: 10%;
  padding-right:10%;
  padding-top: 1.5%;
  }
  .div-sub-SME{
    margin-top: -12%;
  }
  .SME-1{
  /* padding-left: 39% !important; */
  margin-top: 2.5%;
  }
  .SME-2{
  /* padding-left: 44% !important; */
  margin-top: -4%;
  }
  .SME-sub-1{
    padding-left: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .SME-sub-2{
    padding-left: 15% !important;
    font-family: PSLKittithadaPro;
    margin-top: -8%;
  }
  .SME-sub-3{
    padding-right: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .SME-sub-4{
    font-family: PSLKittithadaPro;
    padding-right: 15% !important;
    margin-top: -8%;
  }
  .div-T-Mark{
  background-color: #bf6f2e;
  border-radius: 5px;
  padding-right: 6%;
  padding-left: 6%;
  padding-top: 5%;
  }
  .div-sub-T-Mark{
    margin-top: -15%;
  }
  .T-Mark-1{
  /* padding-left: 39% !important; */
  margin-top: -2%;
  }
  .T-Mark-2{
  /* padding-left: 44% !important; */
  margin-top: -10%;
  }
  .T-Mark-sub-1{
    padding-left: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .T-Mark-sub-2{
    padding-right: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .div-MOC{
  background-color: #e89023;
  border-radius: 5px;
  padding-left: 10%;
  padding-right:10%;
  padding-top: 1.5%;
  }
  .div-sub-MOC{
    margin-top: -12%;
  }
  .MOC-1{
  /* padding-left: 39% !important; */
  margin-top: 2.5%;
  }
  .MOC-2{
  /* padding-left: 44% !important; */
  margin-top: -4%;
  }
  .MOC-sub-1{
    padding-left: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .MOC-sub-2{
    padding-left: 15% !important;
    font-family: PSLKittithadaPro;
    margin-top: -8%;
  }
  .MOC-sub-3{
    padding-right: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .MOC-sub-4{
    font-family: PSLKittithadaPro;
    padding-right: 15% !important;
    margin-top: -8%;
  }
  .div-care-1{
    padding-left: 0% !important;
    padding-right: 0% !important;
  }
  .div-care-2{
    margin-right: -85%;
  }
  .div-care-9{
    margin-top: -5%;
  }
  .div-care{
  background-color: #2ca4df;
  border-radius: 5px;
  padding-left: 10%;
  padding-right:10%;
  margin-top: 1.5%;
  }
  .div-sub-care{
    margin-top: -12%;
  }
  .care-1{
  /* padding-left: 39% !important; */
  margin-top: 2.5%;
  }
  .care-2{
  /* padding-left: 44% !important; */
  margin-top: -4%;
  }
  .care-sub-1{
    padding-left: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .care-sub-2{
    padding-left: 15% !important;
    font-family: PSLKittithadaPro;
    margin-top: -8%;
  }
  .care-sub-3{
    padding-right: 6% !important;
    font-family: PSLKittithadaPro;
  }
  .care-sub-4{
    font-family: PSLKittithadaPro;
    padding-right: 15% !important;
    margin-top: -8%;
  }
  .chart-one2{
    transform: translateX(-50%) translateY(-50%);
    top: 29%;
    left: 49.9%;
    display:flex;
    position:absolute;
    flex-direction: column;
    z-index:10;
  }
  .titel-chart{
    margin-right: auto;
    margin-left: auto;
    font-size:1.5rem;
    color: #2d5b97;
  }
  .titel-text-chart{
    color: #2d5b97;
  }
  .sub-titel-text-chart{
    color: #b3b3b3;
  }
  .sub1-titel-text-chart{
    color: #4d4d4d;
  }
  .sub-titel-color1{
    color: #2ca4df;
  }
  .sub-titel-color2{
    color: #d35351;
  }
  .text-chart1{
    font-family: PSLKittithadaPro;
    font-size:1.8rem;
    color: #2d5b97;
  }
  .sub-text-1{
    font-family: PSLKittithadaPro;
    font-size:1.1rem;
  }
  .sub-text-chart1{
    font-family: PSLKittithadaPro;
    font-size:1.5rem;
  }
  .sub-text-chart2{
    font-family: PSLKittithadaPro;
    font-size:1.5rem;
  }
  
  .sub-titel-chart{
    margin-right: auto;
    margin-left: auto;
    margin-top: -29%;
    font-size:1rem;
    color: #2d5b97;
  }
  #container {
  height: 500px;
  position:relative;
}

.highcharts-figure,
.highcharts-data-table table {
  min-width: 320px;
  max-width: 700px;
  margin: 1em auto;
}
.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #ebebeb;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}
.highcharts-credits{
  display: none;
}
/* text,tspan{
  font-family: PSLKittithadaPro !important;
}
.highcharts-text-outline{
  font-family: PSLKittithadaPro !important;
} */
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}

.highcharts-data-table th {
  font-weight: 600;
  padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
  padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}

.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
.See-All {
  width: 36px !important;
  height: 19px !important;
  object-fit: contain !important;
  -webkit-text-stroke: 0.9px #69a6f6 !important;
  font-family: PSLKittithadaPro !important;
  font-weight: bold !important;
  font-stretch: normal !important;
  font-style: normal !important;
  line-height: normal !important;
  letter-spacing: 0.5px !important;
  color: #69a6f6 !important;
  border-style: solid;
  font-size:0.8rem !important;
  border-color: #69a6f6;
  border-width: 1px;
  border-radius: 0.25rem;
}
.chart-input{
    width: 45%;
    height: 22px;
    outline: 0;
}
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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