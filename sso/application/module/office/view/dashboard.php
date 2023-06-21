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
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"
        integrity="sha512-r22gChDnGvBylk90+2e/ycr3RVrDi8DIOkIGNhJlKfuyQM4tIRAI062MaV8sfjQKYVGjOBaZBOA87z+IhZE9DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    input[type="date"]::-webkit-inner-spin-button,
    input[type="date"]::-webkit-calendar-picker-indicator {
        display: none;
        -webkit-appearance: none;
    }
    .highcharts-tooltip span {
        min-width:140px;
        background-color:white;
        overflow:auto;
        white-space:normal !important;
    }
</style>
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
                        <div class="row pr-0 pt-4 pl-4 pb-4  d-inline-flex align-items-center w-100">
                            <div class="col-3">
                                <h2 class="mb-0 ibm-sb _f20">สถิติการใช้งานตามแอปพลิเคชัน</h2>    
                            </div>
                            <div class="col-9 w-100">
                                <div class="row d-inline-flex align-items-center w-100">
                                    <div class="col-sm-2 d-flex justify-content-end">
                                        <div class="input-group d-inline-flex align-items-center w-100" style="position: relative;">
                                            <input class="form-control select-filter w-100" type="text" placeholder="ตั้งแต่" onfocus="(this.type='date');this.showPicker()" onblur="if(this.value==''){this.type='text'}" id="start" name="trip-start" style="border-top-right-radius: 8px;border-bottom-right-radius: 8px;">
                                            <i class="fa-regular fa-calendar" style="position: absolute;right: 10px; color: grey;"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 d-flex justify-content-end">
                                        <div class="input-group d-inline-flex align-items-center w-100" style="position: relative;">
                                            <input class="form-control select-filter w-100" type="text" placeholder="จนถึง" onfocus="(this.type='date');this.showPicker()" onblur="if(this.value==''){this.type='text'}" id="end" name="trip-end" style="border-top-right-radius: 8px;border-bottom-right-radius: 8px;">
                                            <i class="fa-regular fa-calendar" style="position: absolute;right: 10px; color: grey;"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 d-flex justify-content-end text-center">
                                        <select class="form-control select-filter year_budget" title="ปีงบประมาณ" tabindex="-98" name="year_budget" id="year_budget" placeholder="ปีงบประมาณ">
                                            <option value="">กรุณาเลือกปีงบประมาณ</option>
                                            <!-- <option value="2020">ปีงบประมาณ ปี 63</option>
                                            <option value="2021">ปีงบประมาณ ปี 64</option> -->
                                        </select>
                                    </div>
                                    <div class="col-sm-3 d-flex justify-content-end text-center">
                                        <select class="form-control select-filter thaiYear" title="พ.ศ." tabindex="-98" name="thaiYear" id="thaiYear" placeholder="พ.ศ.">
                                            <option value="">กรุณาเลือก พ.ศ.</option>
                                            <!-- <option value="2020">พ.ศ. 2563</option>
                                            <option value="2021">พ.ศ. 2564</option> -->
                                        </select>
                                    </div>
                                    <div class="col-sm-2 d-flex justify-content-end text-center">
                                        <button type="button" class="btn btn-download dropdown-toggle w-100" id="dropdownExport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-download"></i><p class="mb-0 ml-2">Download</p>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownExport">
                                          <a class="dropdown-item" role="button" onclick="setTimeout(getPDF, 1000);">PDF</a>
                                          <a class="dropdown-item" role="button" onclick="setTimeout(getJPG, 1000);">JPG</a>
                                          <a class="dropdown-item" role="button" onclick="setTimeout(getCSV, 1000);">CSV</a>
                                          <a class="dropdown-item" role="button" onclick="setTimeout(getExcel, 1000);">Excel</a>
                                        </div>
                                    </div>
                                    <button class="test d-none" ></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="ExportContent">
                    <div class="section mt-2"   >
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <div class="row">
                                    <div class="col-sm-6 col-md-3 mb-4">
                                        <div class="card card-statistic">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 ibm-m _f18 d-inline-flex align-items-center">DITP ONE <span class="badge percen-ditp ibm-sb _f14" id="DITP-ONE-1">0%</span></p>
                                                </div>
                                                <h2 class="ditp-color" id="DITP-ONE-2">0</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label ibm-m">นิติบุคคล</label>
                                                            <p class="ibm-sb _f20 mb-0" id="DITP-ONE-4">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">บุคคลทั่วไป</label>
                                                            <p class="ibm-sb _f20 mb-0" id="DITP-ONE-6">0</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-4">
                                        <div class="card card-statistic">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 ibm-m _f18 d-inline-flex align-items-center">DITP DRIVE <span class="badge percen-drive ibm-sb _f14" id="DITP-DRIVE-1">0%</span></p>
                                                </div>
                                                <h2 class="drive-color" id="DITP-DRIVE-2">0</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">นิติบุคคล</label>
                                                            <p class="ibm-sb _f20 mb-0" id="DITP-DRIVE-4">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">บุคคลทั่วไป</label>
                                                            <p class="ibm-sb _f20 mb-0" id="DITP-DRIVE-6">0</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-4">
                                        <div class="card card-statistic">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 ibm-m _f18 d-inline-flex align-items-center">DITP CARE <span class="badge percen-care ibm-sb _f14" id="DITP-CARE-1">0%</span></p>
                                                </div>
                                                <h2 class="care-color" id="DITP-CARE-2">0</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">นิติบุคคล</label>
                                                            <p class="ibm-sb _f20 mb-0" id="DITP-CARE-4">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">บุคคลทั่วไป</label>
                                                            <p class="ibm-sb _f20 mb-0" id="DITP-CARE-6">0</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-4">
                                        <div class="card card-statistic">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 ibm-m _f18 d-inline-flex align-items-center">E-Academy <span class="badge percen-e-academy ibm-sb _f14" id="E-Academy-1">0%</span></p>
                                                </div>
                                                <h2 class="e-academy-color" id="E-Academy-2">0</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">นิติบุคคล</label>
                                                            <p class="ibm-sb _f20 mb-0" id="E-Academy-4">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">บุคคลทั่วไป</label>
                                                            <p class="ibm-sb _f20 mb-0" id="E-Academy-6">0</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-4">
                                        <div class="card card-statistic">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 ibm-m _f18 d-inline-flex align-items-center">SME Proactive <span class="badge percen-sme ibm-sb _f14" id="SME-Proactive-1">0%</span></p>
                                                </div>
                                                <h2 class="sme-color" id="SME-Proactive-2">0</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">นิติบุคคล</label>
                                                            <p class="ibm-sb _f20 mb-0" id="SME-Proactive-4">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">บุคคลทั่วไป</label>
                                                            <p class="ibm-sb _f20 mb-0" id="SME-Proactive-6">0</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-4">
                                        <div class="card card-statistic">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 ibm-m _f18 d-inline-flex align-items-center">DITP Business AI  <span class="badge percen-business-ai ibm-sb _f14" id="Business-AI-1">0%</span></p>
                                                </div>
                                                <h2 class="business-ai-color" id="Business-AI-2">0</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">นิติบุคคล</label>
                                                            <p class="ibm-sb _f20 mb-0" id="Business-AI-4">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">บุคคลทั่วไป</label>
                                                            <p class="ibm-sb _f20 mb-0" id="Business-AI-6">0</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-4">
                                        <div class="card card-statistic">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 ibm-m _f18 d-inline-flex align-items-center">MOC Account  <span class="badge percen-moc ibm-sb _f14" id="MOC-1">0%</span></p>
                                                </div>
                                                <h2 class="moc-color" id="MOC-2">0</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">นิติบุคคล</label>
                                                            <p class="ibm-sb _f20 mb-0" id="MOC-4">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">บุคคลทั่วไป</label>
                                                            <p class="ibm-sb _f20 mb-0" id="MOC-6">0</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 mb-4">
                                        <div class="card card-statistic">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 ibm-m _f18 d-inline-flex align-items-center">T-Mark <span class="badge percen-tmark ibm-sb _f14" id="T-Mark-1">0%</span></p>
                                                </div>
                                                <h2 class="tmark-color" id="T-Mark-2">0</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">นิติบุคคล</label>
                                                            <p class="ibm-sb _f20 mb-0" id="T-Mark-4">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex flex-column">
                                                            <label class="control-label">บุคคลทั่วไป</label>
                                                            <p class="ibm-sb _f20 mb-0" id="T-Mark-6">0</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="row" style="height:95%">
                                    <div class="col-sm-12">
                                        <div class="card card-statistic all text-center">
                                            <div class="card-body d-flex flex-column justify-content-between p-0">
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 ibm-m _f18 d-inline-flex align-items-center justify-content-center">สถิติผู้เข้าใช้แอปพลิเคชั่น</p>
                                                </div>
                                                <h2 class="ibm-b _f40" id="ALL-1">0</h2>
                                                <label class="control-label d-inline-flex align-items-center justify-content-center ibm-m _f16">นิติบุคคล</label>
                                                <p class="ibm-b _f30 mb-0" id="ALL-2">0</p>
                                                <label class="control-label d-inline-flex align-items-center justify-content-center ibm-m _f16">บุคคลทั่วไป</label>
                                                <p class="ibm-b _f30 mb-0" id="ALL-3">0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                    <h3 class='titel-text-chart ibm-sb _f20'>ประเภทสมาชิกกรม&nbsp;&nbsp;<span class="See-All" style="display:none;">&nbsp;&nbsp;See All&nbsp;&nbsp;</span></h3>
                                        <div class="row w-100">
                                            <div class="col-12">
                                                <figure class="highcharts-figure" style="min-width: unset;max-width: none;overflow: auto;">
                                                <div id="bar" class="w-100"></div>
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                    <h3 class='titel-text-chart ibm-sb _f20'>ผู้ประกอบการตามภูมิภาค&nbsp;&nbsp;<span class="See-All"  style="display:none;">&nbsp;&nbsp;See All&nbsp;&nbsp;</span></h3>
                                    <div class="d-flex">
                                        <div class="row w-100">
                                            <figure class="highcharts-figure col-sm-4" style="min-width: unset;max-width: none;overflow: auto;">

                                                <div class="chart-one3 text-center">
                                                    <!-- <span class="titel-chart-regios ibm-b _f24"></span>
                                                    <p class="sub-titel-chart-regios ibm-l _f16">ราย</p> -->
                                                </div>
                                                <div id="pie"></div>
                                            </figure>
                                            <div class="col-sm-8 center">
                                                <table class='table table-borderless '>
                                                    <thead>
                                                        <tr class='sub-text-chart1 sub-titel-color1'>
                                                            <th class='' width="20%"><span class="ibm-m _f14">&nbsp;ภูมิภาค</span></th>
                                                            <th class=' text-center' width="20%"><span class="ibm-m _f14">นิติบุคคล (ราย)</span></th>
                                                            <th class=' text-center' width="20%"><span class="ibm-m _f14">บุคคลทั่วไป (ราย)</span></th>
                                                            <th class=' text-center' width="20%"><span class="ibm-m _f14">รวม (ราย)</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <tr class='sub-text-chart1 sub-titel-color1 ibm-r _f14'>
                                                            <td class=''><p class="mb-0"><span class="material-symbols-outlined " style="color:#2D6DC4;">crop_square</span>&nbsp;กรุงเทพและปริมณฑล</p></td>
                                                            <td class=' text-center'><span id="Nitiregions-0">1,250</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="Personregions-0">1,250</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="regions-0">1,250</span>&nbsp;</td>
                                                        </tr>
                                                        <tr class='sub-text-chart1 sub-titel-color1 ibm-r _f14'>
                                                            <td class=''><span class="material-symbols-outlined " style="color:#0096DE;">crop_square</span>&nbsp;ภาคกลาง</td>
                                                            <td class=' text-center'><span id="Nitiregions-1">1,250</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="Personregions-1">1,250</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="regions-1">1,250</span>&nbsp;</td>
                                                        </tr>
                                                        <tr class='sub-text-chart1 sub-titel-color1 ibm-r _f14'>
                                                            <td class=''><span class="material-symbols-outlined " style="color:#00B9D4;">crop_square</span>&nbsp;ภาคเหนือ</td>
                                                            <td class=' text-center'><span id="Nitiregions-2">125</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="Personregions-2">125</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="regions-2">125</span>&nbsp;</td>
                                                        </tr>
                                                        <tr class='sub-text-chart1 sub-titel-color1 ibm-r _f14'>
                                                            <td class=''><span class="material-symbols-outlined " style="color:#00D6B0;">crop_square</span>&nbsp;ภาคตะวันออก</td>
                                                            <td class=' text-center'><span id="Nitiregions-3">125</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="Personregions-3">125</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="regions-3" >125</span>&nbsp;</td>
                                                        </tr>
                                                        <tr class='sub-text-chart1 sub-titel-color1 ibm-r _f14'>
                                                            <td class=''><span class="material-symbols-outlined " style="color:#8BEC86;">crop_square</span>&nbsp;ภาคตะวันออกเฉียงเหนือ</td>
                                                            <td class=' text-center'><span id="Nitiregions-4">250</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="Personregions-4" >250</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="regions-4" >250</span>&nbsp;</td>
                                                        </tr>
                                                        <tr class='sub-text-chart1 sub-titel-color1 ibm-r _f14'>
                                                            <td class=''><span class="material-symbols-outlined " style="color:#F9F871;">crop_square</span>&nbsp;ภาคตะวันตก</td>
                                                            <td class=' text-center'><span id="Nitiregions-5">375</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="Personregions-5">375</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="regions-5" >375</span>&nbsp;</td>
                                                        </tr>
                                                        <tr class='sub-text-chart1 sub-titel-color1 ibm-r _f14'>
                                                            <td class=''><span class="material-symbols-outlined " style="color:#636ABE;">crop_square</span>&nbsp;ภาคใต้</td>
                                                            <td class=' text-center'><span id="Nitiregions-6">375</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="Personregions-6">375</span>&nbsp;</td>
                                                            <td class=' text-center'><span id="regions-6" >375</span>&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div>  
                                    </div>     
                                    <div style='margin-top: 6%;'></div>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card ">
                                    <div class="card-body">
                                        <h4 class="titel-text-chart ibm-sb _f20">DITP SSO Account</h4>
                                        <h6 class="sub-titel-text-chart ibm-r _f14">(Active Account มีประวัติ Log in ย้อนหลัง 2 ปี)</h6>
                                        <figure class="highcharts-figure"  style="min-width: unset;max-width: none;overflow: auto;">
                                            <div class="chart-one2 text-center">
                                                <!-- <span class="titel-chart ibm-b _f24"></span>
                                                <p class="sub-titel-chart ibm-l _f16">Accounts</p> -->
                                            </div>  
                                            <div id="variablepie" class="w-100"></div>
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
                                                <td class='col-7 ibm-m _f16'><span class="material-symbols-outlined " style="color:#2D6DC4;">crop_square</span>&nbsp;นิติบุคคล</td>
                                                <td class='col-3 text-right '><span id='sumNiti' class='ibm-b _f14'></span>&nbsp;<a class="ibm-r _f14">Accounts</a></td>
                                            </tr>
                                            <tr class='sub1-titel-text-chart sub-text-1'>
                                                <td class='col-7 ibm-r _f14'>&nbsp;จดทะเบียนกับกรมพัฒนาธุรกิจการค้า</td> <!--นิติบุคคลที่จดทะเบียนกับกรมพัฒนาธุรกิจการค้า -->
                                                <td class='col-3 text-right'><span id='sum_1' class='ibm-b _f14'></span>&nbsp;<a class="ibm-r _f14">Accounts</a></td>
                                            </tr>
                                            <tr class='sub1-titel-text-chart sub-text-1'>
                                                <td class='col-7 ibm-r _f14'>&nbsp;ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า</td>
                                                <td class='col-3 text-right'><span id='sum_6' class='ibm-b _f14'></span>&nbsp;<a class="ibm-r _f14">Accounts</a></td>
                                            </tr>
                                            <tr class='sub1-titel-text-chart sub-text-1'>
                                                <td class='col-7 ibm-r _f14'>&nbsp;นิติบุคคลในต่างประเทศ</td>
                                                <td class='col-3 text-right'><span id='sum_2' class='ibm-b _f14'></span>&nbsp;<a class="ibm-r _f14">Accounts</a></td>
                                            </tr>
                                            <tr class='sub-text-chart1 sub-titel-color1'>
                                                <td class='col-7 ibm-m _f14' style="color:#2D6DC4;">&nbsp;Active Accounts</td>
                                                <td class='col-3 text-right' style="color:#2D6DC4;"><span id='sumActive_1' class='ibm-b _f14' >500</span>&nbsp;<a class="ibm-r _f14">Accounts</a></td>
                                            </tr>
                                            <tr class='text-chart1'>
                                                <td class='col-7 ibm-m _f16'><span class="material-symbols-outlined " style="color:#1B4176;">crop_square</span>&nbsp;บุคคลทั่วไป</td>
                                                <td class='col-3 text-right'><span id='sumPerson' class='ibm-b _f14'></span>&nbsp;<a class="ibm-r _f14">Accounts</a></td>
                                            </tr>
                                            <tr class='sub1-titel-text-chart sub-text-1'>
                                                <td class='col-7 ibm-r _f14'>&nbsp;บุคคลทั่วไปไทย</td>
                                                <td class='col-3 text-right'><span id='sum_3'  class='ibm-b _f14'></span>&nbsp;<a class="ibm-r _f14">Accounts</a></td>
                                            </tr>
                                            <tr class='sub1-titel-text-chart sub-text-1'>
                                                <td class='col-7 ibm-m _f14'>&nbsp;บุคคลต่างชาติ</td>
                                                <td class='col-3 text-right'><span id='sum_4' class='ibm-b _f14'></span>&nbsp;<a class="ibm-r _f14">Accounts</a></td>
                                            </tr>
                                            <tr class='sub-text-chart1 sub-titel-color2'>
                                                <td class='col-7 ibm-m _f14' style="color:#1B4176;">&nbsp;Active Accounts</td>
                                                <td class='col-3 text-right' style="color:#1B4176;"><span id='sumActive_2' class='ibm-b _f14' >1,000</span>&nbsp;<a class="ibm-r _f14">Accounts</a></td>
                                            </tr>
                                        </table>  

                                    </div>
                                </div>
                                <!-- <div class="card ">
                                    <div class="card-body">
                                    <h4 class="titel-text-chart"><b>การยืนยันตัวตนในระบบ DITP ONE</b></h4>
                                    <h4 class="titel-text-chart"><b>ทั้งหมด &nbsp;<span id='allConfirm'></span> &nbsp;Accountt</b></h4>
                                    <figure class="highcharts-figure">
                                                <div id="bar2"></div>
                                                </figure>
                                    </div>
                                </div> -->
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
            <!-- <div style="text-align: center">
            <a href=" https://www.ditp.go.th/ditp_web61/article_sub_view.php?filename=&title=778955&cate=2571&d=0"  target="_blank">
                <img src="<?php echo BASE_PATH; ?>asset/img/PDPA.png" alt="" style="    height:100%; width: 100%;">
            </div> -->
            

            </div>
        </div>
        </div>           
<!-- Footer -->
</div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/user_manage.js"></script>
<script>
$(document).ready(function () {
    // window.addEventListener('resize', function(event){
    //   $("#variablepie").highcharts().reflow();
    // });
    $('#year_budget').each(function() {
        var year = (new Date()).getFullYear();
        var current = (year-2021);
        year -= current;
        for (var i = 0; i < current; i++) {
            $(this).append('<option value="' + (year + i) + '">ปีงบประมาณปี ' + (((year + i)+543)-2500) + '</option>');
        }
    });
    $('#thaiYear').each(function() {
        var year = (new Date()).getFullYear();
        var current = (year-2020);
        year -= current;
        for (var i = 0; i < current; i++) {
            $(this).append('<option value="' + (year + i) + '">พ.ศ. ' + ((year + i)+543) + '</option>');
        }
    });
    
    $('#load_model').modal('show');
    $.ajax({
        url: BASE_URL + _INDEX + "office/statistics",
        method: "post",
        success: function (result) {
            let totalAll = result.total;
            let total_niti = result.total_niti;
            let total_person = result.total_person;
            let data = result.data;
            let count = data.length;
            // $('#start').val(result.startDate);
            // $('#end').val(result.endDate);
            // console.log(totalAll,total_niti,total_person,data);
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
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+'%');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+'%');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+'%');
                        break;
                    case "SME-Proactive":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+'%');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+'%');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+'%');
                        break;
                    case "DITP-CARE":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+'%');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+'%');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));

                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+'%');
                        break;
                    case "T-Mark":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+'%');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+'%');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+'%');
                        break;
                    case "DITP-DRIVE":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+'%');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+'%');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+'%');
                        break;   
                    case "E-Academy":
                        $('#'+name+'-1').text(new Intl.NumberFormat().format(TotalPercent)+'%');
                        $('#'+name+'-2').text(new Intl.NumberFormat().format(total));
                        $('#'+name+'-3').text(new Intl.NumberFormat().format(nitiPercent)+'%');
                        $('#'+name+'-4').text(new Intl.NumberFormat().format(niti));
                        $('#'+name+'-6').text(new Intl.NumberFormat().format(person));
                        $('#'+name+'-5').text(new Intl.NumberFormat().format(personPercent)+'%');
                        break;                      
                }
            }
            // $("#load_model").removeClass("in");
            // $(".modal-backdrop").remove();
            // $('body').removeClass('modal-open');
            // $('body').css('padding-right', '');
            // $("#load_model").hide();
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

            //persent_1 person sumActive_1
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
                type: 'variablepie',
                events: {
                    redraw: function() {
                        var chart = this,
                            title = chart.title;

                        title.update({
                            y: chart.plotTop - title.height
                        });
                        $('.titel-chart').text(new Intl.NumberFormat().format(total));
                    }
                }
            },
            title: {
              text: '<p class="sub-titel-chart ibm-l _f16"><span class="titel-chart ibm-b _f24"></span><br>Accounts</p>',
              align: 'center',
              verticalAlign: 'middle',
              y: 20 // change this to 0
            },
            tooltip: {
                backgroundColor: 'white',
                shadow: true,
                borderColor: 'transparent',
                headerFormat: '',
                formatter: function () {
                    return '<span clas="piechart-tooltips" style="color:'+this.point.color+'"><span class="material-symbols-outlined text-s">crop_square</span></span> <span class="ibm-m _f16 mb-4">'+this.point.name+'</span><br><br>' +
                '<span class="ibm-sb _f20 ml-4">&nbsp;&nbsp;&nbsp;&nbsp;'+this.point.y+'%</span>'
                }
            }, plotOptions: {
                variablepie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
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
                innerSize: '50%',
                zMin: 5,
                name: 'countries',
                color: '#1B4176',
                data: result.data ,

            }]

          });
            $('.titel-chart').text(new Intl.NumberFormat().format(total));
        }
    });
        $.ajax({
            url: BASE_URL + _INDEX + "office/ChartRegios",
            type: "post",
            success: function (result) {
             let Total = result.total;
             let TotalNiti = result.totalNiti;
             let TotalPerson = result.totalPerson;
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
            Highcharts.chart('pie', {
                    chart: {
                        type: 'variablepie',
                        events: {
                            redraw: function() {
                                var chart = this,
                                    title = chart.title;

                                title.update({
                                    y: chart.plotTop - title.height
                                });
                                $('.titel-chart-regios').text(new Intl.NumberFormat().format(Total));
                            }
                        }
                    },
                    title: {
                      floating: true,
                      text: '<p class="sub-titel-chart-regios ibm-l _f16"><span class="titel-chart-regios ibm-b _f24"></span><br>ราย</p>',
                      align: 'center',
                      verticalAlign: 'middle',
                      y: 20, // change this to 0
                      positioner: function(w, h, point) {
                              return { x: point.plotX, y: point.plotY - h };
                          }
                    },
                    tooltip: {
                        backgroundColor: '#FFFFFF',
                        shadow: true,
                        borderColor: 'transparent',
                        headerFormat: '',
                        formatter: function () {
                            return '<span clas="piechart-tooltips" style="color:'+this.point.color+'"><span class="material-symbols-outlined text-s">crop_square</span></span> <span class="ibm-m _f16 mb-4">'+this.point.name+'</span><br><br>' +
                        '<span class="ibm-sb _f20 ml-4">&nbsp;&nbsp;&nbsp;&nbsp;'+this.point.y+'%</span>'
                        }

                    },
                    plotOptions: {
                            variablepie: {
                                allowPointSelect: false,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false,
                                    distance: -30,
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
                        innerSize: '60%',
                        zMin: 0,
                        name: 'countries',
                        data: [
                            {
                            name: 'กรุงเทพและปริมณฑล',
                            y: KrungthepPercent,
                            z: 100,
                            color: '#2D6DC4',
                            },{
                            name: 'ภาคกลาง',
                            y: CentralPercent,
                            z: 100,
                            color: '#0096DE',
                            }, {
                            name: 'ภาคเหนือ',
                            y: NorthPercent,
                            z: 100,
                            color: '#00B9D4',
                            }, {
                            name: 'ภาคตะวันออก',
                            y: EastPercent,
                            z: 100,
                            color: '#00D6B0',
                            }, {
                            name: 'ภาคตะวันออกเฉียงเหนือ',
                            y: NortheastPercent,
                            z: 100,
                            color: '#8BEC86',
                            }, {
                            name: 'ภาคตะวันตก',
                            y: 6,
                            z: 100,
                            color: '#F9F871',
                            }, {
                            name: 'ภาคใต้',
                            y: SouthPercent,
                            z: 100,
                            color: '#636ABE',
                            }]
                        }]
                    })

                $('.titel-chart-regios').text(new Intl.NumberFormat().format(Total));
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
                title:'ประเภทสมาชิกกรม',
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
            Highcharts.chart('bar', {
                chart: {
                    type: 'column',
                    reflow: true,
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
                    reversed: true,
                    align: 'right',
                    verticalAlign: 'top',
                    y: -20,
                    squareSymbol: true,
                    symbolRadius: 2,
                },
                plotOptions: {
                    series: {
                        stacking: 'normal',
                        borderRadius: 8,
                    },
                    column: {
                        grouping: false,
                    }
                },
                series: [{
                    name: 'Inactive Account',
                    data: inactive,
                    color: '#D5E2F3',
                }, {
                    name: 'Active Account',
                    data: active,
                    color: '#2D6DC4',
                    height: '200%'
                }]


            });
        }
    });
$('#start').on('change', function() {
    let start_date = $('#start').val();
    let end_date = $('#end').val();
    if (end_date) {
      $('.test').click();  
    }
    
})
$('#end').on('change', function() {
    let start_date = $('#start').val();
    let end_date = $('#end').val();
    if (start_date) {
      $('.test').click();  
    }
    
})

$('.year_budget').on('change', function() {
    let year_budget = $('.year_budget option:selected').val();
    $('#start').val('');
    $('#end').val('');
    if (year_budget) {
      $('.test').click();  
    }
    
})

$('.thaiYear').on('change', function() {
    let thaiYear = $('.thaiYear option:selected').val();
    $('#start').val('');
    $('#end').val('');
    if (thaiYear) {
      $('.test').click();  
    }
    
})

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
            $('#load_model').modal('show');
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
                //  console.log({
                //                 start_date : data3,
                //                 end_date : data4,
                //                 year_budget: data2,
                //                 thaiYear: data1
                //             });
                if(result.message == 'No data'){
                    $('#load_model').modal('hide');
                    Swal.fire(
                    'ไม่พบข้อมูล',
                    'เนื่องจากไม่มีที่ท่านค้นหากรุณาเลือกใหม่!',
                    'question'
                    )
                }else{
                    let total = result.total;
                    let total_niti = result.total_niti;
                    let total_person = result.total_person;
                    let data = result.data;
                    let count = data.length;
                    $('#ALL-1').text(new Intl.NumberFormat().format(total));
                    $('#ALL-2').text(new Intl.NumberFormat().format(total_niti));
                    $('#ALL-3').text(new Intl.NumberFormat().format(total_person));
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
                    $('#load_model').modal('hide');
              }
            }
        });
        $.ajax({
            url: BASE_URL + _INDEX + "office/ChartRegios",
            type: "post",
            data:{
                start_date : data3,
                end_date : data4,
                year_budget: data2,
                thaiYear: data1
            },
            success: function (result) {
             let Total = result.total;
             let TotalNiti = result.totalNiti;
             let TotalPerson = result.totalPerson;
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
            Highcharts.chart('pie', {
                    chart: {
                        type: 'variablepie',
                        events: {
                            redraw: function() {
                                var chart = this,
                                    title = chart.title;

                                title.update({
                                    y: chart.plotTop - title.height
                                });
                                $('.titel-chart-regios').text(new Intl.NumberFormat().format(Total));
                            }
                        }
                    },
                    title: {
                      floating: true,
                      text: '<p class="sub-titel-chart-regios ibm-l _f16"><span class="titel-chart-regios ibm-b _f24"></span><br>ราย</p>',
                      align: 'center',
                      verticalAlign: 'middle',
                      y: 20, // change this to 0
                      positioner: function(w, h, point) {
                              return { x: point.plotX, y: point.plotY - h };
                          }
                    },
                    tooltip: {
                        backgroundColor: '#FFFFFF',
                        shadow: true,
                        borderColor: 'transparent',
                        headerFormat: '',
                        formatter: function () {
                            return '<span clas="piechart-tooltips" style="color:'+this.point.color+'"><span class="material-symbols-outlined text-s">crop_square</span></span> <span class="ibm-m _f16 mb-4">'+this.point.name+'</span><br><br>' +
                        '<span class="ibm-sb _f20 ml-4">&nbsp;&nbsp;&nbsp;&nbsp;'+this.point.y+'%</span>'
                        }

                    },
                    plotOptions: {
                            variablepie: {
                                allowPointSelect: false,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false,
                                    distance: -30,
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
                        innerSize: '60%',
                        zMin: 0,
                        name: 'countries',
                        data: [
                            {
                            name: 'กรุงเทพและปริมณฑล',
                            y: KrungthepPercent,
                            z: 100,
                            color: '#2D6DC4',
                            },{
                            name: 'ภาคกลาง',
                            y: CentralPercent,
                            z: 100,
                            color: '#0096DE',
                            }, {
                            name: 'ภาคเหนือ',
                            y: NorthPercent,
                            z: 100,
                            color: '#00B9D4',
                            }, {
                            name: 'ภาคตะวันออก',
                            y: EastPercent,
                            z: 100,
                            color: '#00D6B0',
                            }, {
                            name: 'ภาคตะวันออกเฉียงเหนือ',
                            y: NortheastPercent,
                            z: 100,
                            color: '#8BEC86',
                            }, {
                            name: 'ภาคตะวันตก',
                            y: 6,
                            z: 100,
                            color: '#F9F871',
                            }, {
                            name: 'ภาคใต้',
                            y: SouthPercent,
                            z: 100,
                            color: '#636ABE',
                            }]
                        }]
                    })

                $('.titel-chart-regios').text(new Intl.NumberFormat().format(Total));
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
            }
        });
    });

function getPDF() {
    const panel2 = document.getElementById("ExportContent");
    // document.getElementByClassName
    // console.log(panel2);

    // console.log(window);
    var opt = {
        margin: 6,
        filename: 'Dashboard.pdf',
        image: {
            type: 'jpeg',
            quality: 1
        },
        html2canvas: {
            scale: 1
        },
        jsPDF: {
            unit: 'mm',
            format: 'A1',
            orientation: 'landscape'
        }
    };

    let pdf = html2pdf().from(panel2).set(opt).save();

}

function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
}
function getMemberType() {

}
function getJPG() {
    document.getElementById('ExportContent').parentNode.style.overflow = 'visible'; //might need to do this to grandparent nodes as well, possibly.
    html2canvas(document.getElementById("ExportContent"), {
        scale: 0.8,
        logging: true,
        allowTaint: false,
        backgroundColor: '#FFFFFF'
    }).then(canvas => {
      canvas.toBlob(function(blob) {
        window.saveAs(blob, 'my_image.jpg');
      });
    });
}

function getExcel() {


    var blob,
        wb = {
            SheetNames: [],
            Sheets: {}
        },
        wb1 = {
            SheetNames: [],
            Sheets: {}
        },
        wb2 = {
            SheetNames: [],
            Sheets: {}
        },
        wb3 = {
            SheetNames: [],
            Sheets: {}
        };

    var mem = [];
    $.ajax({
        url: BASE_URL + _INDEX + "office/ChartTypeMember",
        method: "post",
        async: false, 
        dataType: "json",
        success: function (result) {
            mem = result;
        }
    })
    var region = [];
    $.ajax({
        url: BASE_URL + _INDEX + "office/ChartRegios",
        type: "post",
        async: false, 
        dataType: "json",
        success: function (result) {
            region = result;
        }
    })

    var sso = [];
    $.ajax({
        url: BASE_URL + _INDEX + "office/DITP_SSO_Account",
        type: "post",
        async: false, 
        dataType: "json",
        success: function (result) {
            sso = result;
        }
    })
    
    let mem1 = mem.export2;
    var ws1 = XLSX.utils.json_to_sheet(mem1);
    wb.SheetNames.push("MemberType");
    wb1.SheetNames.push("MemberType");
    wb.Sheets["MemberType"] = ws1;
    wb1.Sheets["MemberType"] = ws1;

    const Headingregion = [
        ['ภูมิภาค', 'นิติบุคคล (ราย)', 'บุคคลทั่วไป (ราย)', 'รวม (ราย)', '%']
      ];
    let region1 = region.export;
    var ws2 = XLSX.utils.json_to_sheet(region1,{ origin: 'A2', skipHeader: true });
    XLSX.utils.sheet_add_aoa(ws2, Headingregion, { origin: 'A1' });
    wb.SheetNames.push("Region");
    wb2.SheetNames.push("Region");
    wb.Sheets["Region"] = ws2;
    wb2.Sheets["Region"] = ws2;

    const Headingsso = [
        ['#','จำนวน']
    ];
    let sso1 = sso.export;
    var ws3 = XLSX.utils.json_to_sheet(sso1,{ origin: 'A2', skipHeader: true });
    XLSX.utils.sheet_add_aoa(ws3, Headingsso, { origin: 'A1' });
    wb.SheetNames.push("SSO");
    wb3.SheetNames.push("SSO");
    wb.Sheets["SSO"] = ws3;
    wb3.Sheets["SSO"] = ws3;  

    blob = new Blob([s2ab(XLSX.write(wb, {
        bookType: 'xlsx',
        type: 'binary',
        charset: 'utf-8'
    }))], {
        type: "application/octet-stream"
    });

    // blob1 = new Blob([XLSX.write(wb1, {
    //     bookType: 'csv',
    //     type: 'binary',
    //     charset: 'utf-8'
    // })], {
    //     type: "text/csv;charset=utf-8"
    // });

    // blob2 = new Blob([XLSX.write(wb2, {
    //     bookType: 'csv',
    //     type: 'binary',
    //     charset: 'utf-8'
    // })], {
    //     type: "text/csv;charset=utf-8"
    // });

    saveAs(blob, "dashboard.xlsx");
    // saveAs(blob1, "MemberType.csv");
    // saveAs(blob2, "Region.csv");

}

function getCSV() {


    var blob,
        wb = {
            SheetNames: [],
            Sheets: {}
        },
        wb1 = {
            SheetNames: [],
            Sheets: {}
        },
        wb2 = {
            SheetNames: [],
            Sheets: {}
        },
        wb3 = {
            SheetNames: [],
            Sheets: {}
        };

    var mem = [];
    $.ajax({
        url: BASE_URL + _INDEX + "office/ChartTypeMember",
        method: "post",
        async: false, 
        dataType: "json",
        success: function (result) {
            mem = result;
        }
    })
    var region = [];
    $.ajax({
        url: BASE_URL + _INDEX + "office/ChartRegios",
        type: "post",
        async: false, 
        dataType: "json",
        success: function (result) {
            region = result;
        }
    })

    var sso = [];
    $.ajax({
        url: BASE_URL + _INDEX + "office/DITP_SSO_Account",
        type: "post",
        async: false, 
        dataType: "json",
        success: function (result) {
            sso = result;
        }
    })
    
    let mem1 = mem.export2;
    var ws1 = XLSX.utils.json_to_sheet(mem1);
    wb.SheetNames.push("MemberType");
    wb1.SheetNames.push("MemberType");
    wb.Sheets["MemberType"] = ws1;
    wb1.Sheets["MemberType"] = ws1;

    const Headingregion = [
        ['region', 'corporation (account)', 'general individual (account)', 'total (account)', '%']
      ];
    let region1 = region.export2;
    var ws2 = XLSX.utils.json_to_sheet(region1,{ origin: 'A2', skipHeader: true });
    XLSX.utils.sheet_add_aoa(ws2, Headingregion, { origin: 'A1' });
    wb.SheetNames.push("Region");
    wb2.SheetNames.push("Region");
    wb.Sheets["Region"] = ws2;
    wb2.Sheets["Region"] = ws2;

    const Headingsso = [
        ['#','quantity']
    ];
    let sso1 = sso.export2;
    var ws3 = XLSX.utils.json_to_sheet(sso1,{ origin: 'A2', skipHeader: true });
    XLSX.utils.sheet_add_aoa(ws3, Headingsso, { origin: 'A1' });
    wb.SheetNames.push("SSO");
    wb3.SheetNames.push("SSO");
    wb.Sheets["SSO"] = ws3;
    wb3.Sheets["SSO"] = ws3;  

    blob1 = new Blob([s2ab(XLSX.write(wb1, {
        bookType: 'csv',
        type: 'binary',
        charset: 'utf-8'
    }))], {
        type: "text/csv"
    });

    blob2 = new Blob([s2ab(XLSX.write(wb2, {
        bookType: 'csv',
        type: 'binary',
        charset: 'utf-8'
    }))], {
        type: "text/csv"
    });

    blob3 = new Blob([s2ab(XLSX.write(wb3, {
        bookType: 'csv',
        type: 'binary',
        charset: 'utf-8'
    }))], {
        type: "text/csv"
    });


    saveAs(blob1, "MemberType.csv");
    saveAs(blob2, "Region.csv");
    saveAs(blob3, "SSO.csv");

}
</script>
<?php include ('component/footer.php'); ?>