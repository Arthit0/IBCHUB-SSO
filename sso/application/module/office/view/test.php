<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
//include ('component/menu.php');
include ('component/header.php');
?>

<div class="wrapper">

  <?php 
  include ('component/nav.php'); 
  include ('component/menu_lte.php'); 
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>

<script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <form action="javascript:void(0)" autocomplete="off">
          <div class="row mb-4">
            <div class="main-content container-fluid">
             <div class="page-title">
            
                <form action="" enctype="multipart/form-data" id="market_edit">
                        <div class="col-12 d-flex text-chart1 sso-input">
                        <div class="col-8">
                            <div class="row">
                            <div class="col-lg-4">
                            <b>สถิติการใช้งานตามแอปพลิเคชัน</b>
                            </div>
                            <div class="col-lg-8">
                            <input class="chart-input"  type="date" id="start" name="trip-start" style="color:#2d5b97">
                            &nbsp;ถึง&nbsp;
                            <input class="chart-input" type="date" id="end" name="trip-end" style="color:#2d5b97">
                            </div>
                            </div>
                        </div>

                        <div class="col-4">
                        <div class="row">
                            <div class="col-lg-5 text-center">
                            <select class="form-control selectpicker sso-dropdown year_budget" title="ปีงบประมาณ" tabindex="-98"
                                        name="contact_title" placeholder="ปีงบประมาณ">
                                        <option value="">กรุณาเลือกปีงบประมาณ</option>
                                        <option value="2020">ปีงบประมาณ ปี 63</option>
                                        <option value="2021">ปีงบประมาณ ปี 64</option>
                                        </select>
                            <!-- <br><h6 class="sub-titel-text-chart">กรุณาเลือกใช้ fountion อันใดอันนึง</h6> -->
                            </div>
                            <div class="col-lg-4 text-center">
                            <select class="form-control selectpicker sso-dropdown thaiYear" title="พ.ศ." tabindex="-98"
                                        name="contact_title" placeholder="พ.ศ.">
                                        <option value="">กรุณาเลือก พ.ศ.</option>
                                        <option value="2020">พ.ศ. 2563</option>
                                        <option value="2021">พ.ศ. 2564</option>
                                        </select>
                            </div>
                            <div class="col-lg-3 text-center">
                            <button type="submit" class="btn btn-primary test" style="border-radius: 25px;width: 90%;"><i class="fa fa-search"></i> ค้นหา</button>
                            </div>
                            </div>
            
                        </div>
                        </div>
                </form>
            </div>
            <div style='margin-top: 1%;'></div>
                <section class="section">
                    <div class="row mb-2">
                        <div class="col-12 col-md-3">
                            <div class="card card-statistic div-one">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class='tools-1 pb-2  text-center justify-content-between'>
                                            <font size ="4" color="#fff"><b>DITP ONE <span id="DITP-ONE-1">(0%)</span></b></font>
                                        </div>
                                        <div class="tools-2  pb-1 text-center align-items-center">
                                                <p ><font size ="6" color="#fff"><b><span id="DITP-ONE-2">0</span></b></font></p>
                                            </div>
                                            <div class="col-sm-12 div-sub-one">
                                            <div class="row">
                                                <div class="col-6 col-sm-6 div-col-1 text-left">
                                                <font class="tools-sub-1" size ="3" color="#fff">
                                                <b>นิติบุคคล <span id="DITP-ONE-3">(0%)</span></b>
                                                </font>
                                                <p class="tools-sub-2"><font size ="5" color="#fff"><b><span id="DITP-ONE-4">0</span></b></font></p>
                                                </div>
                                                <div class="col-6 col-sm-6 div-col-1 text-right">
                                                <font class="tools-sub-3" size ="3" color="#fff">
                                                <b>บุคคลทั่วไป <span id="DITP-ONE-5">(0%)</span></b>
                                                </font>
                                                <p class="tools-sub-4"><font size ="5" color="#fff"><b><span id="DITP-ONE-6">0</span></b></font></p>
                                                </div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class='div-care-9 pb-2  justify-content-between'></div>
                            
                            <div class="card card-statistic div-care">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                    <div class='care-1 pb-2  text-center justify-content-between'>
                                            <font size ="4" color="#fff"><b>DITP CARE <span id="DITP-CARE-1">(0%)</span></b></font>
                                        </div>
                                        <div class="care-2  pb-1 text-center align-items-center">
                                                <p ><font size ="6" color="#fff"><b><span id="DITP-CARE-2">0</span></b></font></p>
                                            </div>
                                            <div class="col-sm-12 div-sub-care">
                                            <div class="row">
                                                <div class="col-6 col-sm-6 div-col-1 text-left">
                                                <font class="care-sub-1" size ="3" color="#fff">
                                                <b>นิติบุคคล <span id="DITP-CARE-3">(0%)</span></b>
                                                </font>
                                                <p class="care-sub-2"><font size ="5" color="#fff"><b><span id="DITP-CARE-4">0</span></b></font></p>
                                                </div>
                                                <div class="col-6 col-sm-6 div-col-1 text-right">
                                                <font class="care-sub-3" size ="3" color="#fff">
                                                <b>บุคคลทั่วไป <span id="DITP-CARE-5">(0%)</span></b>
                                                </font>
                                                <p class="care-sub-4"><font size ="5" color="#fff"><b><span id="DITP-CARE-6">0</span></b></font></p>
                                                </div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class='div-care-9 pb-2  justify-content-between'></div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="card card-statistic div-drive text-center">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                    <div class='drive-1 pb-2  justify-content-between'>
                                            <font size ="4" color="#fff"><b>DITP DRIVE <span id="DITP-DRIVE-1">(0%)</span></b></font>
                                        </div>
                                        <div class="drive-2 pb-1  align-items-center">
                                                <p ><font size ="6" color="#fff"><b><span id="DITP-DRIVE-2">0</span></b></font></p>
                                            </div>
                                            <div class="col-sm-12 div-sub-drive">
                                                <div class="col-12 col-sm-12 ">
                                                <font class="drive-sub-1" size ="3" color="#fff">
                                                <b>นิติบุคคล <span id="DITP-DRIVE-3">(0%)</span></b>
                                                </font>
                                                <p class="drive-sub-2"><font size ="5" color="#fff"><b><span id="DITP-DRIVE-4">0</span></b></font></p>
                                                </div>
                                                <div class="col-12 col-sm-12 drive-3">
                                                <font class="drive-sub-3" size ="3" color="#fff">
                                                <b>บุคคลทั่วไป <span id="DITP-DRIVE-5">(0%)</span></b>
                                                </font>
                                                <p class="drive-sub-4"><font size ="5" color="#fff"><b><span id="DITP-DRIVE-6">0</span></b></font></p>
                                                </div>
                                            </div>
                                    </div>
                                    <div class='div-drive-9 pb-2  justify-content-between'></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-2">
                            <div class="card card-statistic div-e-academy text-center">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                    <div class='e-academy-1 pb-2  justify-content-between'>
                                            <font size ="3" color="#fff"><b>E-Academy <span id="E-Academy-1">(0%)</span></b></font>
                                        </div>
                                        <div class="e-academy-2 pb-1  align-items-center">
                                                <p ><font size ="6" color="#fff"><b><span id="E-Academy-2">0</span></b></font></p>
                                            </div>
                                            <div class="div-sub-e-academy">
                                                <font  size ="3" color="#fff">
                                                <b>นิติบุคคล <span id="E-Academy-3">(0%)</span></b>
                                                </font>  &nbsp;
                                                <font size ="5" color="#fff"><b><span id="E-Academy-4">0</span></b></font>
                                                <p class="e-academy-3">
                                                <font size ="3" color="#fff">
                                                <b>บุคคลทั่วไป <span id="E-Academy-5">(0%)</span></b>
                                                </font>&nbsp;
                                                <font size ="5" color="#fff"><b><span id="E-Academy-6">0</span></b></font>
                                                </p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-statistic div-business text-center">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                    <div class='business-1 pb-2  justify-content-between'>
                                            <font size ="3" color="#fff"><b>DITP Business AI <span id="DITP-Business-1">(0%)</span></b></font>
                                        </div>
                                        <div class="business-2 pb-1  align-items-center">
                                                <p ><font size ="6" color="#fff"><b><span id="DITP-Business-2">0</span></b></font></p>
                                            </div>
                                            <div class="div-sub-business">
                                                <font  size ="3" color="#fff">
                                                <b>นิติบุคคล <span id="DITP-Business-3">(0%)</span></b>
                                                </font>  &nbsp;
                                                <font size ="5" color="#fff"><b><span id="DITP-Business-4">0</span></b></font>
                                                <p class="business-3">
                                                <font size ="3" color="#fff">
                                                <b>บุคคลทั่วไป <span id="DITP-Business-5">(0%)</span></b>
                                                </font>&nbsp;
                                                <font size ="5" color="#fff"><b><span id="DITP-Business-6">0</span></b></font>
                                                </p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="card card-statistic div-SME">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class='SME-1 pb-2  text-center justify-content-between'>
                                            <font size ="4" color="#fff"><b>SME Proactive <span id="SME-Proactive-1">(0%)</span></b></font>
                                        </div>
                                        <div class="SME-2  pb-1 text-center align-items-center">
                                                <p ><font size ="6" color="#fff"><b><span id="SME-Proactive-2">0</span></b></font></p>
                                            </div>
                                            <div class="col-sm-12 div-sub-SME">
                                            <div class="row">
                                                <div class="col-6 col-sm-6 div-col-1 text-left">
                                                <font class="SME-sub-1" size ="3" color="#fff">
                                                <b>นิติบุคคล <span id="SME-Proactive-3">(0%)</span></b>
                                                </font>
                                                <p class="SME-sub-2"><font size ="5" color="#fff"><b><span id="SME-Proactive-4">0</span></b></font></p>
                                                </div>
                                                <div class="col-6 col-sm-6 div-col-1 text-right">
                                                <font class="SME-sub-3" size ="3" color="#fff">
                                                <b>บุคคลทั่วไป <span id="SME-Proactive-5">(0%)</span></b>
                                                </font>
                                                <p class="SME-sub-4"><font size ="5" color="#fff"><b><span id="SME-Proactive-6">0</span></b></font></p>
                                                </div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class='div-care-9 pb-2  justify-content-between'></div>

                            <div class="card card-statistic div-MOC">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class='MOC-1 pb-2  text-center justify-content-between'>
                                            <font size ="4" color="#fff"><b>MOC Account <span id="MOC-Account-1">(0%)</span></b></font>
                                        </div>
                                        <div class="MOC-2  pb-1 text-center align-items-center">
                                                <p ><font size ="6" color="#fff"><b><span id="MOC-Account-2">0</span></b></font></p>
                                            </div>
                                            <div class="col-sm-12 div-sub-MOC">
                                            <div class="row">
                                                <div class="col-6 col-sm-6 div-col-1 text-left">
                                                <font class="MOC-sub-1" size ="3" color="#fff">
                                                <b>นิติบุคคล <span id="MOC-Account-3">(0%)</span></b>
                                                </font>
                                                <p class="MOC-sub-2"><font size ="5" color="#fff"><b><span id="MOC-Account-4">0</span></b></font></p>
                                                </div>
                                                <div class="col-6 col-sm-6 div-col-1 text-right">
                                                <font class="MOC-sub-3" size ="3" color="#fff">
                                                <b>บุคคลทั่วไป <span id="MOC-Account-5">(0%)</span></b>
                                                </font>
                                                <p class="MOC-sub-4"><font size ="5" color="#fff"><b><span id="MOC-Account-6">0</span></b></font></p>
                                                </div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-2">
                            <div class="card card-statistic div-e-academy text-center">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                    <div class='e-academy-1 pb-2  justify-content-between'>
                                            <font size ="3" color="#fff"><b>สถิติการเข้าใช้แอพทั้งหมด</b></font>
                                        </div>
                                        <div class="e-academy-2 pb-1  align-items-center">
                                                <p ><font size ="6" color="#fff"><b><span id="ALL-1">0</span></b></font></p>
                                            </div>
                                            <div class="div-sub-e-academy">
                                                <font  size ="3" color="#fff">
                                                <b>นิติบุคคล </b>
                                                </font>  &nbsp;
                                                <font size ="5" color="#fff"><b><span id="ALL-2">0</span></b></font>
                                                <p class="e-academy-3">
                                                <font size ="3" color="#fff">
                                                <b>บุคคลทั่วไป </b>
                                                </font>&nbsp;
                                                <font size ="5" color="#fff"><b><span id="ALL-3">0</span></b></font>
                                                </p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-statistic div-T-Mark text-center">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class='T-Mark-1 pb-2  text-center justify-content-between'>
                                            <font size ="4" color="#fff"><b>T-Mark <span id="T-Mark-1">(0%)</span></b></font>
                                        </div>
                                        <div class="T-Mark-2  pb-1 text-center align-items-center">
                                               <font size ="6" color="#fff"><b><span id="T-Mark-2">0</span></b></font></p>
                                            </div> 
                                            <div class="div-sub-T-Mark">
                                                <font  size ="3" color="#fff">
                                                <b>นิติบุคคล <span id="T-Mark-3">(0%)</span></b>
                                                </font>  &nbsp;
                                                <font size ="5" color="#fff"><b><span id="T-Mark-4">0</span></b></font>
                                                <p class="e-academy-3">
                                                <font size ="3" color="#fff">
                                                <b>บุคคลทั่วไป <span id="T-Mark-5">(0%)</span></b>
                                                </font>&nbsp;
                                                <font size ="5" color="#fff"><b><span id="T-Mark-6">0</span></b></font>
                                                </p>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="card card-statistic div-business text-center">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                    <div class='business-1 pb-2  justify-content-between'>
                                            <font size ="3" color="#fff"><b>DITP Business AI <span id="DITP-Business-1">(0%)</span></b></font>
                                        </div>
                                        <div class="business-2 pb-1  align-items-center">
                                                <p ><font size ="6" color="#fff"><b><span id="DITP-Business-2">0</span></b></font></p>
                                            </div>
                                            <div class="div-sub-business">
                                                <font  size ="3" color="#fff">
                                                <b>นิติบุคคล <span id="DITP-Business-3">(0%)</span></b>
                                                </font>  &nbsp;
                                                <font size ="5" color="#fff"><b><span id="DITP-Business-4">0</span></b></font>
                                                <p class="business-3">
                                                <font size ="3" color="#fff">
                                                <b>บุคคลทั่วไป <span id="DITP-Business-5">(0%)</span></b>
                                                </font>&nbsp;
                                                <font size ="5" color="#fff"><b><span id="DITP-Business-6">0</span></b></font>
                                                </p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </div>


                </section>
                <div class="row mb-4">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                <h3 class='titel-text-chart'><b>ประเภทสมาชิกกรม</b>&nbsp;&nbsp;<span class="See-All" style="display:none;">&nbsp;&nbsp;See All&nbsp;&nbsp;</span></h3>
                                    <div class="row">
                                        <div class="col-12">
                                            <figure class="highcharts-figure">
                                            <div id="bar"></div>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                <h3 class='titel-text-chart'><b>ผู้ประกอบการตามภูมิภาค</b>&nbsp;&nbsp;<span class="See-All"  style="display:none;">&nbsp;&nbsp;See All&nbsp;&nbsp;</span></h3>
                                <div style='margin-top: 9%;'></div>
                                    <figure class="highcharts-figure">
                                        <div id="pie"></div>
                                        </figure>
                                <div class="col-md-12 center" style='margin-top: 12%;padding-left: 8%;'>
                                        <table class='table table-borderless'>
                                        <tbody>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <th class='col-3'><span style="color: #0a80ba;">&#9679;</span>&nbsp;ภูมิภาค</th>
                                            <th class='col-3 text-center'><span  style="font-size:1.5rem;">นิติบุคคล</span></th>
                                            <th class='col-3 text-center'><span  style="font-size:1.5rem;">บุคคลทั่วไป</span></th>
                                            <th class='col-3 text-center'><span  style="font-size:1.5rem;">รวม</span></th>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <td class='col-5'><span style="color: #0a80ba;">&#9679;</span>&nbsp;กรุงเทพและปริมณฑล</td>
                                            <td class='col-2 text-center'><span id="Nitiregions-0" style="font-size:1.5rem;">1,250</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-2 text-center'><span id="Personregions-0" style="font-size:1.5rem;">1,250</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-3 text-center'><span id="regions-0" style="font-size:1.5rem;">1,250</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <td class='col-5'><span style="color: #0a80ba;">&#9679;</span>&nbsp;ภาคกลาง</td>
                                            <td class='col-2 text-center'><span id="Nitiregions-1" style="font-size:1.5rem;">1,250</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-2 text-center'><span id="Personregions-1" style="font-size:1.5rem;">1,250</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-3 text-center'><span id="regions-1" style="font-size:1.5rem;">1,250</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <td class='col-5'><span style="color: #2ca4df;">&#9679;</span>&nbsp;ภาคเหนือ</td>
                                            <td class='col-2 text-center'><span id="Nitiregions-2" style="font-size:1.5rem;">125</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-5 text-center'><span id="Personregions-2" style="font-size:1.5rem;">125</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-3 text-center'><span id="regions-2" style="font-size:1.5rem;">125</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <td class='col-5'><span style="color: #2ca4df;">&#9679;</span>&nbsp;ภาคตะวันออก</td>
                                            <td class='col-2 text-center'><span id="Nitiregions-3" style="font-size:1.5rem;">125</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-2 text-center'><span id="Personregions-3" style="font-size:1.5rem;">125</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-3 text-center'><span id="regions-3" style="font-size:1.5rem;">125</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <td class='col-5'><span style="color: #a32e2f;">&#9679;</span>&nbsp;ภาคตะวันออกเฉียงเหนือ</td>
                                            <td class='col-2 text-center'><span id="Nitiregions-4" style="font-size:1.5rem;">250</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-2 text-center'><span id="Personregions-4" style="font-size:1.5rem;">250</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-3 text-center'><span id="regions-4" style="font-size:1.5rem;">250</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <td class='col-5'><span style="color: #da2123;">&#9679;</span>&nbsp;ภาคตะวันตก</td>
                                            <td class='col-2 text-center'><span id="Nitiregions-5" style="font-size:1.5rem;">375</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-2 text-center'><span id="Personregions-5" style="font-size:1.5rem;">375</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-3 text-center'><span id="regions-5" style="font-size:1.5rem;">375</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <td class='col-5'><span style="color: #d96f70;">&#9679;</span>&nbsp;ภาคใต้</td>
                                            <td class='col-2 text-center'><span id="Nitiregions-6" style="font-size:1.5rem;">375</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-2 text-center'><span id="Personregions-6" style="font-size:1.5rem;">375</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                            <td class='col-3 text-center'><span id="regions-6" style="font-size:1.5rem;">375</span>&nbsp;<a style="font-size:1.2rem;">ราย</a></td>
                                        </tr>
                                        </tbody>
                                    </table>  
                                    </div>
                                <div style='margin-top: 6%;'></div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-5">
                            <div class="card ">
                                <div class="card-body">
                                    <h4 class="titel-text-chart"><b>DITP SSO Account</b></h4>
                                    <h6 class="sub-titel-text-chart">(Active Account มีประวัติ Log in ย้อนหลัง 2 ปี)</h6>
                                    <figure class="highcharts-figure">
                                        <div class="chart-one2 text-center">
                                        <b><span class="titel-chart"></span></b>
                                        <p class="sub-titel-chart"><b>Accounts</b></p>
                                        </div> 	
                                        <div id="variablepie"></div>
                                        </figure>
                                        <table class='table table-borderless'>
                                        <!-- <tr class='text-chart1'>
                                            <td class='col-7'><span style="color: #2ca4df;">&#9679;</span>&nbsp;ผู้ใช้ทั้งหมดในระบบ</td>
                                            <td class='col-2 text-center'></td>
                                            <td class='col-3 text-right'><span id='sumAll' style="font-size:1.5rem;"></span>&nbsp;<a style="font-size:1.2rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <td class='col-7'>&nbsp;&nbsp;&nbsp;&nbsp;Active Accounts</td>
                                            <td class='col-2 text-center' id='persentActive_All'>6.91 %</td>
                                            <td class='col-3 text-right'><span id='sumActive_All' style="font-size:1.4rem;">500</span>&nbsp;<a style="font-size:1.2rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color2'>
                                            <td class='col-7'>&nbsp;&nbsp;&nbsp;&nbsp;Inactive Accounts</td>
                                            <td class='col-2 text-center' id='persentInactive_All'>6.91 %</td>
                                            <td class='col-3 text-right'><span id='sumInactive_All' style="font-size:1.4rem;">500</span>&nbsp;<a style="font-size:1.2rem;">Accounts</a></td>
                                        </tr> -->
                                        <tr class='text-chart1' >
                                            <td class='col-7'><span style="color: #2ca4df;">&#9679;</span>&nbsp;นิติบุคคล</td>
                                            <td class='col-2 text-center' id='persentNiti'>60 %</td>
                                            <td class='col-3 text-right'><span id='sumNiti' style="font-size:1.5rem;"></span>&nbsp;<a style="font-size:1.2rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                            <td class='col-7'>&nbsp;&nbsp;&nbsp;&nbsp;Active Accounts</td>
                                            <td class='col-2 text-center' id='persentActive_1'>6.91 %</td>
                                            <td class='col-3 text-right'><span id='sumActive_1' style="font-size:1.4rem;">500</span>&nbsp;<a style="font-size:1.2rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='sub1-titel-text-chart sub-text-1'>
                                             <td class='col-7'>&nbsp;&nbsp;&nbsp;&nbsp;จดทะเบียนกับกรมพัฒนาธุรกิจการค้า</td> <!--นิติบุคคลที่จดทะเบียนกับกรมพัฒนาธุรกิจการค้า -->
                                            <td class='col-2 text-center'id='persent_1'>60 %</td>
                                            <td class='col-3 text-right'><span id='sum_1'></span>&nbsp;<a style="font-size:0.9rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='sub1-titel-text-chart sub-text-1'>
                                            <td class='col-7'>&nbsp;&nbsp;&nbsp;&nbsp;ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า</td>
                                            <td class='col-2 text-center'id='persent_6'>60 %</td>
                                            <td class='col-3 text-right'><span id='sum_6'></span>&nbsp;<a style="font-size:0.9rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='sub1-titel-text-chart sub-text-1'>
                                            <td class='col-7'>&nbsp;&nbsp;&nbsp;&nbsp;นิติบุคคลในต่างประเทศ</td>
                                            <td class='col-2 text-center'id='persent_2'>60 %</td>
                                            <td class='col-3 text-right'><span id='sum_2'></span>&nbsp;<a style="font-size:0.9rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='text-chart1'>
                                            <td class='col-7'><span style="color: #da2123;">&#9679;</span>&nbsp;บุคคลทั่วไป</td>
                                            <td class='col-2 text-center' id='persentPerson'>60 %</td>
                                            <td class='col-3 text-right'><span id='sumPerson' style="font-size:1.5rem;"></span>&nbsp;<a style="font-size:1.2rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='sub-text-chart1 sub-titel-color2'>
                                            <td class='col-7'>&nbsp;&nbsp;&nbsp;&nbsp;Active Accounts</td>
                                            <td class='col-2 text-center'id='persentActive_2'>3.17 %</td>
                                            <td class='col-3 text-right'><span id='sumActive_2' style="font-size:1.4rem;">1,000</span>&nbsp;<a style="font-size:1.2rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='sub1-titel-text-chart sub-text-1'>
                                            <td class='col-7'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บุคคลทั่วไปไทย</td>
                                            <td class='col-2 text-center'id='persent_3'>60 %</td>
                                            <td class='col-3 text-right'><span id='sum_3'></span>&nbsp;<a style="font-size:0.9rem;">Accounts</a></td>
                                        </tr>
                                        <tr class='sub1-titel-text-chart sub-text-1'>
                                            <td class='col-7'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บุคคลต่างชาติ</td>
                                            <td class='col-2 text-center'id='persent_4'>60 %</td>
                                            <td class='col-3 text-right'><span id='sum_4'></span>&nbsp;<a style="font-size:0.9rem;">Accounts</a></td>
                                        </tr>
                                        
                                    </table>  

                                </div>
                            </div>
                            <div class="card ">
                                <div class="card-body">
                                <h4 class="titel-text-chart"><b>การยืนยันตัวตนในระบบ DITP ONE</b></h4>
                                <h4 class="titel-text-chart"><b>ทั้งหมด &nbsp;<span id='allConfirm'></span> &nbsp;Accountt</b></h4>
                                <figure class="highcharts-figure">
                                            <div id="bar2"></div>
                                            </figure>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        <div class="modal sso-modal " tabindex="-1" role="dialog" id="public_alert" >
        <div class="modal-dialog modal-dialog-centered modal-xl">

            <div class="modal-content">
            <div class="pointer btn-close-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </div>
            <div style="text-align: center">
            <a href=" https://www.ditp.go.th/ditp_web61/article_sub_view.php?filename=&title=778955&cate=2571&d=0"  target="_blank">
                <img src="<?php echo BASE_PATH; ?>asset/img/PDPA.png" alt="" style="    height:100%; width: 100%;">
            </div>
            

            </div>
        </div>
        </div>           
<!-- Footer -->
</div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/user_manage.js"></script>
<script>
   $('#load_model').ready(()=>{
        $('#load_model').modal('show');
    })
$(document).ready(function () {
    $.ajax({
        url: BASE_URL + _INDEX + "office/statistics",
        method: "post",
        success: function (result) {
            console.log(result)
            let totalAll = result.total;
            let total_niti = result.total_niti;
            let total_person = result.total_person;
            let data = result.data;
            let count = data.length;
            $('#start').val(result.startDate);
            $('#end').val(result.endDate);
            for (let i = 0; i < count; i++) {
            let name = data[i].name;
            let niti = data[i].niti;
            let nitiPercent = data[i].nitiPercent;
            let person = data[i].person;
            let personPercent = data[i].personPercent;
            let TotalPercent = data[i].TotalPercent;
            let total = data[i].total;
                        $('#ALL-1').text(new Intl.NumberFormat().format(totalAll));
                        $('#ALL-2').text(new Intl.NumberFormat().format(total_niti));
                        $('#ALL-3').text(new Intl.NumberFormat().format(total_person));
                switch (name) {
                    case "DITP-ONE":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;
                    case "SME-Proactive":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;
                    case "DITP-CARE":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;
                    case "T-Mark":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;
                    case "DITP-DRIVE":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;   
                    case "E-Academy":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;                      
                }
            }
            $('#load_model').modal('hide');
         }
     })
    
});
    $.ajax({
        url: BASE_URL + _INDEX + "office/DITP_SSO_Account",
        method: "post",
        success: function (result) {
            let total = result.total;
            let Account = result.Account;
            let active = result.active;
            let count = Account.length;
            for (let i = 0; i < count; i++) {
            let persent = Account[i].persent;
            let sum = Account[i].sum;
            let type = Account[i].type;
                switch (type) {
                    case 1:
                        $('#persent_'+type).text(new Intl.NumberFormat().format(persent)+' %');
                        $('#sum_'+type).text(new Intl.NumberFormat().format(sum));
                        break;
                    case 2:
                        $('#persent_'+type).text(new Intl.NumberFormat().format(persent)+' %');
                        $('#sum_'+type).text(new Intl.NumberFormat().format(sum));
                        break;
                    case 3:
                        $('#persent_'+type).text(new Intl.NumberFormat().format(persent)+' %');
                        $('#sum_'+type).text(new Intl.NumberFormat().format(sum));
                        break;
                    case 4:
                        $('#persent_'+type).text(new Intl.NumberFormat().format(persent)+' %');
                        $('#sum_'+type).text(new Intl.NumberFormat().format(sum));
                        break;
                    case 6:
                        $('#persent_'+type).text(new Intl.NumberFormat().format(persent)+' %');
                        $('#sum_'+type).text(new Intl.NumberFormat().format(sum));
                        break;                        
                }
            }
            console.log(result,result.sum[0],total,result.data[0].y);

            //persent_1 person sumActive_1
            $('.titel-chart').text(new Intl.NumberFormat().format(total));
            $('#sumNiti').text(new Intl.NumberFormat().format(result.sum[0]));
            $('#persentNiti').text(new Intl.NumberFormat().format(result.data[0].y)+' %');
            $('#persentActive_1').text(new Intl.NumberFormat().format(active.niti.persent)+' %');
            $('#sumActive_1').text(new Intl.NumberFormat().format(active.niti.value));
            $('#persentPerson').text(new Intl.NumberFormat().format(result.data[1].y)+' %');
            $('#sumPerson').text(new Intl.NumberFormat().format(result.sum[1]));
            $('#persentActive_2').text(new Intl.NumberFormat().format(active.person.persent)+' %');
            $('#sumActive_2').text(new Intl.NumberFormat().format(active.person.value));
            Highcharts.chart('variablepie', {
            chart: {
                type: 'variablepie'
            },
            title:false,
            tooltip: {
                headerFormat: '',
                pointFormat: '<span style="color:#2d5b97;">\u25CF</span><b> {point.name}</b><br/>' +
                'ประวัติการเข้าใช้งาน (เปอร์เซ็น): <b>{point.y}%</b><br/>' +
                'จากประวัติการเข้าใช้งานทั้งหมด (เปอร์เซ็น): <b>{point.z}%</b><br/></a>'
            }, plotOptions: {
                variablepie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<a style="font-size:1.2rem;font-family: PSLKittithadaPro !important;">{point.y}%<br>{point.name}</a>',
                    distance: -130,
                    filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                    }
                }
                }
            },
            series: [{
                minPointSize: 10,
                innerSize: '25%',
                zMin: 0,
                name: 'countries',
                data: result.data 
                
            }]
          });
        }
    });
$.ajax({
            url: BASE_URL + _INDEX + "office/ChartRegios",
            type: "post",
            success: function (result) {
                let Krungthep = result.Krungthep;
             let KrungthepNiti = result.KrungthepNiti;
             let KrungthepPerson = result.KrungthepPerson;
             let KrungthepPercent = result.KrungthepPercent;
             let Central = result.Central;
             let CentralNiti = result.CentralNiti;
             let CentralPerson = result.CentralPerson;
             let CentralPercent = result.CentralPercent;
             let East = result.East;
             let EastNiti = result.EastNiti;
             let EastPerson = result.EastPerson;
             let EastPercent = result.EastPercent;
             let North = result.North;
             let NorthNiti = result.NorthNiti;
             let NorthPerson = result.NorthPerson;
             let NorthPercent = result.NorthPercent;
             let Northeast = result.Northeast;
             let NortheastNiti = result.NortheastNiti;
             let NortheastPerson = result.NortheastPerson;
             let NortheastPercent = result.NortheastPercent;
             let South = result.South;
             let SouthNiti = result.SouthNiti;
             let SouthPerson = result.SouthPerson;
             let SouthPercent = result.SouthPercent;
             let West = result.West;
             let WestNiti = result.WestNiti;
             let WestPerson = result.WestPerson;
             var WestPercent = result.WestPercent;
             console.log(result.total,result.NorthPercent,result.North)
             $('#regions-0').text(new Intl.NumberFormat().format(Krungthep));
             $('#Nitiregions-0').text(new Intl.NumberFormat().format(KrungthepNiti));
             $('#Personregions-0').text(new Intl.NumberFormat().format(KrungthepPerson));
             $('#regions-1').text(new Intl.NumberFormat().format(Central));
             $('#Nitiregions-1').text(new Intl.NumberFormat().format(CentralNiti));
             $('#Personregions-1').text(new Intl.NumberFormat().format(CentralPerson));
             $('#regions-2').text(new Intl.NumberFormat().format(North));
             $('#Nitiregions-2').text(new Intl.NumberFormat().format(NorthNiti));
             $('#Personregions-2').text(new Intl.NumberFormat().format(NorthPerson));
             $('#regions-3').text(new Intl.NumberFormat().format(East));
             $('#Nitiregions-3').text(new Intl.NumberFormat().format(EastNiti));
             $('#Personregions-3').text(new Intl.NumberFormat().format(EastPerson));
             $('#regions-4').text(new Intl.NumberFormat().format(Northeast));
             $('#Nitiregions-4').text(new Intl.NumberFormat().format(NorthNiti));
             $('#Personregions-4').text(new Intl.NumberFormat().format(NorthPerson));
             $('#regions-5').text(new Intl.NumberFormat().format(West));
             $('#Nitiregions-5').text(new Intl.NumberFormat().format(WestNiti));
             $('#Personregions-5').text(new Intl.NumberFormat().format(WestPerson));
             $('#regions-6').text(new Intl.NumberFormat().format(South));
             $('#Nitiregions-6').text(new Intl.NumberFormat().format(SouthNiti));
             $('#Personregions-6').text(new Intl.NumberFormat().format(SouthPerson));
            Highcharts.chart('pie', {
                    chart: {
                        type: 'variablepie'
                    },
                    title:false,
                    tooltip: {
                        headerFormat: '',
                        pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                        'จำนวนผู้ประกอบการ (เปอร์เซ็น): <b>{point.y}%</b><br/>' +
                        'จากจำนวนผู้ประกอบการทั้งหมด (เปอร์เซ็น): <b>{point.z}%</b><br/>'
                    },
                    plotOptions: {
                            variablepie: {
                            allowPointSelect: false,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<a style="font-size:1.2rem;font-family: PSLKittithadaPro;"> {point.name}<br> {point.y}%</a>',
                                distance: 90,
                                filter: {
                                property: 'percentage',
                                operator: '>',
                                value: 4
                                }
                            }
                            }
                        },
                    series: [{
                        minPointSize: 10,
                        innerSize: '25%',
                        zMin: 0,
                        name: 'countries',
                        data: [
                            {
                            name: 'กรุงเทพและปริมณฑล',
                            y: KrungthepPercent,
                            z: 100,
                            color: '#2ca4df',
                            },{
                            name: 'ภาคกลาง',
                            y: CentralPercent,
                            z: 100,
                            color: '#0c5b82',
                            }, {
                            name: 'ภาคเหนือ',
                            y: NorthPercent,
                            z: 100,
                            color: '#2ca4df',
                            }, {
                            name: 'ภาคตะวันออก',
                            y: EastPercent,
                            z: 100,
                            color: '#0c5b82',
                            }, {
                            name: 'ภาคตะวันออกเฉียงเหนือ',
                            y: NortheastPercent,
                            z: 100,
                            color: '#a32e2f',
                            }, {
                            name: 'ภาคตะวันตก',
                            y: 6,
                            z: 100,
                            color: '#da2123',
                            }, {
                            name: 'ภาคใต้',
                            y: SouthPercent,
                            z: 100,
                            color: '#d96f70',
                            }]
                        }]
                    })
            }
        });
$.ajax({
        url: BASE_URL + _INDEX + "office/ChartConfirm",
        method: "post",
        success: function (result) {
            let Confirm = result.Confirm;
            let UnConfirm = result.UnConfirm;
            let total = result.total;
            $('#allConfirm').text(new Intl.NumberFormat().format(total))
            Highcharts.chart('bar2', {
                chart: {
                    type: 'bar'
                },
                title:false,
                xAxis: false,
                yAxis: {
                    title: false,
                },
                legend: {
                    reversed: true
                },
                plotOptions: {
                    series: {
                    stacking: 'normal'
                    }
                },
                series: [{
                    name: 'ยังไม่ยืนยันตัวตน',
                    data: [UnConfirm],
                    color: '#da2123',
                    dataLabels: {
                    enabled: true,
                    rotation: 0,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '<a class="text-right">{point.y}<br>({point.percentage:.2f}%)', // one decimal
                    y: -7, // 10 pixels down from the top
                    style: {
                        fontSize: '20px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
                }, {
                    name: 'ยืนยันตัวตนแล้ว',
                    data: [Confirm],
                    color: '#2ba8e9',
                    dataLabels: {
                    enabled: true,
                    rotation: 0,
                    color: '#FFFFFF',
                    align: 'left',
                    format: '{point.y}<br>({point.percentage:.2f}%)', // one decimal
                    y: 5, // 10 pixels down from the top
                    style: {
                        fontSize: '20px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
                }]
            })
        }
    });
    $.ajax({
        url: BASE_URL + _INDEX + "office/ChartTypeMember",
        method: "post",
        success: function (result) {
            let active  = result.active.Count
            let inactive  = result.inactive.Count

            
            //Count
            Highcharts.chart('bar', {
                chart: {
                    type: 'bar'
                },
                title: false,
                xAxis: {
                    categories: result.name
                },
                yAxis: {
                    min: 0,
                    title: false,
                },
                legend: {
                    reversed: true
                },
                plotOptions: {
                    series: {
                    stacking: 'normal'
                    }
                },
                series: [{
                    name: 'Inactive Account',
                    data: inactive,
                    color: '#da2123'
                }, {
                    name: 'Active Account',
                    data: active,
                    color: '#2ba8e9'
                }]
            });
        }
    });
$(`.test`).on('click',function(){
        let start_date = $('#start').val();
        let end_date = $('#end').val();
        let year_budget = $('.year_budget option:selected').val();
        let thaiYear = $('.thaiYear option:selected').val();
        let data1  = '';
        let data2  = '';
        let data3  = '';
        let data4  = '';
            if(start_date && end_date && year_budget || start_date && end_date && thaiYear){
                Swal.fire({
                title: 'กรุณาเลือกใช้ fountin อันเดียว',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
                }) 
                return false;           
            } else if(start_date && !end_date || !start_date && end_date ){
                Swal.fire({
                title: 'กรุณาใส่วันที่ให้ครบสองค่า',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
                }) 
                return false;           
            }else if(year_budget && thaiYear){
                Swal.fire({
                title: 'กรุณาเลือกใช้ fountin อันเดียว',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
                }) 
                return false;           
            }else if(!year_budget && !start_date && !thaiYear && !end_date){
                Swal.fire({
                title: 'ไม่สามารถค้นหาได้เนื่องไม่ตรงเงื่อนไข',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
                }) 
                return false;           
            }else{
                if(thaiYear){
                     data1  = thaiYear;
                }else if(year_budget){
                     data2  = year_budget;
                }else{
                     data3  = start_date;
                     data4  = end_date;
                }
            }
        $.ajax({
            url: BASE_URL + _INDEX + "office/search",
            type: "post",
            data:{
                start_date : data3,
                end_date : data4,
                year_budget: data2,
                thaiYear: data1
            },
            success: function (result) {
                if(result.message == 'No data'){
                    Swal.fire(
                    'ไม่พบข้อมูล',
                    'เนื่องจากไม่มีที่ท่านค้นหากรุณาเลือกใหม่!',
                    'question'
                    )
                }else{
            let total = result.total;
            let data = result.data;
            let count = data.length;
            for (let i = 0; i < count; i++) {
            let name = data[i].name;
            let niti = data[i].niti;
            let nitiPercent = data[i].nitiPercent;
            let person = data[i].person;
            let personPercent = data[i].personPercent;
            let TotalPercent = data[i].TotalPercent;
            let total = data[i].total;
                switch (name) {
                    case "DITP-ONE":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;
                    case "SME-Proactive":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;
                    case "DITP-CARE":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;
                    case "T-Mark":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;
                    case "DITP-DRIVE":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;    
                    case "E-Academy":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+' %');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+' %');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+' %');
                        break;                    
                    }
                }
              }
            }
        })
    })

</script>
<?php include ('component/footer.php'); ?>