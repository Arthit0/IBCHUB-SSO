@extends("admin.layouts.default")


@section("admin_content")
<link href="{{ URL::to('/admin_theme/css'); }}/style.min.css" rel="stylesheet">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> --}}
<link href="{{ URL::to('/admin_theme/css'); }}/style_preapprove.css?v=<?= time() ?>" rel="stylesheet">
<script src="{{ URL::to('/admin_theme/js'); }}/jquery-3.5.1.js"></script>
{{-- <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.css"></script>
<script src="print.js"></script> --}}


<style>
	
.panel-body { padding: 5px; }
.wrapper-content {padding-bottom: 0px; }
@font-face{
	font-family: "Kanit-Light";
	src:url('/admin_theme/fonts/Kanit-Light.ttf');
}
.strong_title{
	font-size: 30px;
	font-family: "Kanit-Light";
}
strong{
	color: #2e4050;
  font-size: 18px;
  font-family: "Kanit-Light" !important;
  /* font-weight: 500 !important; */
}
 
.dot1 {
  height: 15px;
  width: 15px;
  background-color: rgb(117, 168, 229);
  border-radius: 50%;
  display: inline-block;
  font-family: "Kanit-Light";
}
.dot2 {
  height: 15px;
  width: 15px;
  background-color: rgb(121, 43, 2);
  border-radius: 50%;
  display: inline-block;
  font-family: "Kanit-Light";
}
.dot3 {
  height: 15px;
  width: 15px;
  background-color: rgb(217, 144, 45);
  border-radius: 50%;
  display: inline-block;
  	font-family: "Kanit-Light";
}
.dot4 {
  height: 15px;
  width: 15px;
  background-color: rgb(116, 167, 0);
  border-radius: 50%;
  display: inline-block;
  	font-family: "Kanit-Light";
}
.dot5 {
  height: 15px;
  width: 15px;
  background-color: rgba(119, 119, 119);
  border-radius: 50%;
  display: inline-block;
  	font-family: "Kanit-Light";
}
.dot6 {
  height: 15px;
  width: 15px;
  background-color: rgb(0, 157, 137);
  border-radius: 50%;
  display: inline-block;
  	font-family: "Kanit-Light";
}
.dot7 {
  height: 15px;
  width: 15px;
  background-color: rgb(172, 30, 81);
  border-radius: 50%;
  display: inline-block;
  	font-family: "Kanit-Light";
}
.dot8 {
  height: 15px;
  width: 15px;
  background-color: rgb(223, 169, 8);
  border-radius: 50%;
  display: inline-block;
  	font-family: "Kanit-Light";
}
.dot9 {
  height: 15px;
  width: 15px;
  background-color: rgb(157, 5, 202);
  border-radius: 50%;
  display: inline-block;
	font-family: "Kanit-Light";
}
.dot1_strong1 {
  color: rgb(117, 168, 229);
  font-size: 20px;
  font-family: "Kanit-Light";
}
.dot1_strong2 {
color: rgb(121, 43, 2);
font-size: 20px;
font-family: "Kanit-Light";
}.dot1_strong3 {
	color: rgb(217, 144, 45);
  font-size: 20px;
  font-family: "Kanit-Light";
}
.dot1_strong4 {
	color: rgb(116, 167, 0);
  font-size: 20px;
  font-family: "Kanit-Light";
}.dot1_strong5 {
	color: rgba(119, 119, 119);
  font-size: 20px;
  font-family: "Kanit-Light";
}
.dot1_strong6 {
	color: rgb(0, 157, 137);
  font-size: 20px;
  font-family: "Kanit-Light";
}
.dot1_strong7 {
	color: rgb(172, 30, 81);
  font-size: 20px;
  font-family: "Kanit-Light";
}
.card-body1 {
  color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 15.5px;  
  height: 69px;
  max-width: 100%;
  border-radius: 2.4px;
  background-image: linear-gradient(to left, #eb8d1d, #d1550d);
}
.card-body2 {
	margin-top: 10px;
	color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 15.5px;  
  height: 69px;
  max-width: 100%;
  border-radius: 2.4px;
  background-image: linear-gradient(to left, #acaec1, #73758d);
}
.card-body3 {
	margin-top: 10px;
	color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 15.5px;  
  height: 69px;
  max-width: 100%;
  border-radius: 2.4px;
  background-image: linear-gradient(to left, #b727d7, #8011ae);
}
.card-body4 {
	
	margin-top: 10px;
	color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 15.5px;  
  height: 69px;
  max-width: 100%;
  border-radius: 2.4px;
  background-image: linear-gradient(to left, #d64089, #ac1e51);
}
.card-body5 {
	
	margin-top: 10px;
	color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 15.5px;  
  height: 69px;
  max-width: 100%;
  border-radius: 2.4px;
  background-image: linear-gradient(to left, #f4d220, #e5a60e);
}
.card-body6 {
	
	margin-top: 10px;
	color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 15.5px;  
  height: 69px;
  max-width: 100%;
  border-radius: 2.4px;
  background-image: linear-gradient(to left, #2cdea8, #14ba6f);
}
.card-body7 {
	
	margin-top: 10px;
	color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 15.5px;  
  height: 69px;
  max-width: 100%;
  border-radius: 2.4px;
  background-image: linear-gradient(to left, #77d3e9, #42a8cf);
}
.card-body8 {
	
	margin-top: 10px;
	color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 15.5px;  
  height: 69px;
  max-width: 100%;
  border-radius: 2.4px;
  background-image: linear-gradient(to left, #598cd8, #2d53b0);
}
.card-top-5-body1 {
  color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 40px;
  min-height: 160px;
  max-height: 190px;
  width: 500px;
  margin: 10px 10px;
  border-radius: 2.4px;
  background-image: linear-gradient(to bottom, #f4d220, #e5a60e);
}
.card-top-5-body2 {
  color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  height: 69px;
  font-size: 28px;
  margin: 10px 10px;
  border-radius: 2.4px;
  background-image: linear-gradient(to bottom,  #acaec1, #73758d);
}
.card-top-5-body3 {
  color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  height: 69px;
   font-size: 28px;
   margin: 10px 10px;
  border-radius: 2.4px;
  background-image: linear-gradient(to top, #ec5f09, #ffb78f);
}
.card-top-5-body4 {
  color: #777777;
  height: 69px;
   font-size: 28px;
  font-family: "Kanit-Light";
  margin: 10px 10px;
  border-radius: 4px;
  box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);
  border-radius: 2.4px;
}
.card-top-5-body5 {
    color: #777777;
  height: 69px;
   font-size: 28px;
  font-family: "Kanit-Light";
  margin: 10px 10px;
  border-radius: 4px;
  box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);
  border-radius: 2.4px;
}
.panel-success{
	border: none !important;
}
.highcharts-axis-title{
	display: none;
}
.company_total{
	width: 100%;position: relative;
}
.count_applications_total{
	position: absolute;
	top: 35%;
	right: 42%;
}
#display_period_countall{
	font-size: 50px;
	font-family: "Kanit-Light";
}
td{
	font-family: "Kanit-Light";
	font-size: 25px;
	padding:10px; 
}
.span-category{
	font-size: 25px;
}
.category-type{
	padding: 25px 20px;
}
.category-icon{
	padding: 15px 15px;
}
.category-count{
	padding: 15px 0px;
}
.top-5-number{
	padding: 10px 10px;
}
.top-5-country{
	padding: 10px 10px;

}
.title-status-item{
	font-family: "Kanit-Light";
	font-size: 20px
}
.count-status{
	font-family: "Kanit-Light";
	font-size: 30px
}
.title-status{
	font-family: "Kanit-Light";
	margin: 15px 0px;
}
#member_total_business{
	position: relative;
	width: auto;
	height:100%;
}
#categoryTypeCountAll{
	font-size: 50px;
	position: absolute;
	top: 23%;
	right: 40%;
}
.categoryTypeCountAll1{
	font-size: 20px;
	position: absolute;
	top: 28%;
	right: 46.5%;
}#category-6{
	word-break: break-all;
    padding: 14px 0px 0px 40px;
}
#category-7{
	word-break: break-all;
	padding: 14px 0px 0px 40px;
}#category-8{
	word-break: break-all;
	padding: 14px 0px 0px 40px;
}
@media (max-width: 1440px) { 
	#member_total_business{
	position: relative;
	width: auto;
	height:365px;
}
	.company_total{
	width: 100%;position: relative;
}
.count_applications_total{
	position: absolute;
	top: 35%;
	right: 38.5%;
}
.count-status{
	font-size: 30px;
}
.member_total_business{
	position: relative;
	top: 23%;
	right: 39.5%;
}
.categoryTypeCountAll{
	font-size: 20px;
	position: absolute;
	top: 19%;
	right: 33%;
}
.categoryTypeCountAll1{
	font-size: 20px;
	position: absolute;
	top: 22%;
	right: 40.5%;
}
.category-icon{
	padding: 20px 5px;
}
.category-type{
	padding: 25px 0px;
}
.category-count{
	padding: 20px 0px;
}
.span-category{
	font-size: 19px;
}
img{
	height: 30px !important;
    width: 30px !important;
}
#category-6{
	word-break: break-all;
	padding: 14px 20px;
}
#category-7{
	word-break: break-all;
	padding: 25px 20px;
	font-size: 15px;
}#category-8{
	word-break: break-all;
	padding: 22px 0px 22px 20px;
	font-size: 15px;
}
.card-top-5-body1 {
  color: rgb(255, 255, 255);
  font-family: "Kanit-Light";
  font-size: 40px;
  min-height: 160px;
  max-height: 190px;
  width: 100%;
  margin: 10px 0px;
  border-radius: 2.4px;
  background-image: linear-gradient(to bottom, #f4d220, #e5a60e);
}
.top-5-country{
	padding: 10px 10px;
	font-size: 22px;

}
}
</style>
 


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
 



<figure class="highcharts-figure">
  <div id="container"></div>
   
</figure>
{{-- {{ Form::model($period, ['action' => array('AdminController@AdminHomePDF', $period->periods_id)]) }} --}}
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-md-10">
		<h2><i class="fa fa-home"></i> Dashboards</h2>
	</div>
	<div class="col-md-2">
		<br>
		{{-- <button class="btn btn-primary"><a  class="btn btn-primary btn-xs" id="AdminHomePDF" onclick="AdminHomePDF()"> --}}
			<button class="btn btn-primary"><a  class="btn btn-primary btn-xs" id="downloadPdfBtn">
			
		 Export Dashboards
		</a></button>
</div>
</div>

<div class="row" id="panel2">
	<div class="panel-group">
		<div class="col-md-12">
			<div class="wrapper wrapper-content">
				  <div class="panel panel-success">
				    <div  class="panel-collapse collapse in" id="panel1">
				      <div class="panel-body">		
						<div class="col-md-10"><br>
							<strong class="strong_title">สถานะการสมัครสมาชิก</strong>
									  </div>
									  <div class="col-md-2">
										  <br>
										<select name="status" id="status" class="form-control" onchange="select_period(this.value)">
											<option class="form-control" value="all" selected>- All -</option>

											@foreach ($display_period as $key => $period)
											<option class="form-control" value="{{$period->periods_id}}">{{$period->periods_title_en}} ({{$period->periods_title_th}}) </option>
												
											@endforeach
										  </select>									  
										</div>

										<center>
						  <div class="col-md-5">

						<div id="company_total" class="company_total">

						</div>
						<div class="count_applications_total">
						{{-- <span class="count-status" id="display_period_countall">{{ number_format($count_applications_total) }}</span><br>
						<span class="count-status" style="font-size:24px !important	;">Company</span> --}}
						</div>
					</div>
						</center>
			<div class="col-md-7" style="padding:40px;">
				<div class="row" style="border-bottom:solid 1px #dddddd;">
					<div class="col-md-10 title-status">
							<span class="title-status-item">
						<i class="dot1"></i>					
								On process(New) / อยู่ระหว่างกรอกใบสมัคร
							</span>
					</div>
						<div class="col-md-2  text-right">
								<span class="dot1_strong1 count-status" id="display_period_count1">
									{{ number_format($count_applications1) }}
								</span>
						</div>
				</div>

					<div class="row" style="border-bottom:solid 1px #dddddd;">
						<div class="col-md-10 title-status">
						<span class="title-status-item">
					<i class="dot2"></i>
							First Review / รอเจ้าหน้าที่พิจารณา
						</span>
					</div>
					<div class="col-md-2  text-right">
						<span class="dot1_strong2 count-status" id="display_period_count15">
							{{ number_format($count_applications15) }}
						</span>
					</div>
					</div>

					<div class="row" style="border-bottom:solid 1px #dddddd;">
						<div class="col-md-10 title-status">
						<span class="title-status-item">
					<i class="dot3"></i>

							Final Review / รอกรรมการพิจารณา
						</span>
					</div>
					<div class="col-md-2  text-right">
						<span class="dot1_strong3 count-status" id="display_period_count14">{{ number_format($count_applications14) }}</span>
					</div>
					</div>


					<div class="row" style="border-bottom:solid 1px #dddddd;">
					<div class="col-md-10 title-status">
						<span class="title-status-item">
					<i class="dot4"></i>

							Member / ได้รับการพิจารณาแล้ว
						</span>
					</div>
					<div class="col-md-2  text-right">
						<span class="dot1_strong4 count-status" id="display_period_count4">{{ number_format($count_applications4) }}</span>
					</div>
					</div>
 					<div class="row" style="border-bottom:solid 1px #dddddd;">
					<div class="col-md-10 title-status">
						<span class="title-status-item">
					<i class="dot5"></i>

							Expired / หมดอายุ
						</span>
					</div>
					<div class="col-md-2  text-right">
						<span class="dot1_strong5 count-status" id="display_period_count6">{{ number_format($count_applications6) }}</span>
					</div>
					</div>
					<div class="row" style="border-bottom:solid 1px #dddddd;">
						<div class="col-md-10 title-status">
						<span class="title-status-item">
					<i class="dot6"></i>

							On Process (Renew) / กำลังดำเนินการต่ออายุ
						</span>
					</div>
						<div class="col-md-2  text-right">
						<span class="dot1_strong6 count-status" id="display_period_count7">{{ number_format($count_applications7) }}</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-10 title-status ">
						<span class="title-status-item">
					<i class="dot7"></i>

							Rejected / ไม่ผ่านการพิจารณาจากกรรมการ
						</span>
					</div>
						<div class="col-md-2  text-right">
						<span class="dot1_strong7 count-status" id="display_period_count5">{{ number_format($count_applications5) }}</span>
						</div>
					</div>
					{{-- <div class="row" style="border-bottom:solid 1px #dddddd;">
						<div class="col-md-10 title-status">
					<i></i>
						<span class="title-status-item">Total</span>
					</div>
						<div class="col-md-2  text-right">
						<span class="count-status" id="display_period_countall">{{ number_format($count_applications_total) }}</span>
						</div>
					</div> --}}
						  </div>
				    </div>
					</div>
				  </div>
				  <div class=" col-md-8" style="padding-left: 0!important"><br>
					<div class="panel panel-success">
						<br>
						<div class="col-md-8">
					<label><strong class="strong_title">&nbsp;&nbsp;&nbsp;&nbsp;จำนวนผู้สมัครสมาชิก (ราย)</strong></label>	
						</div>
						<div class="col-md-4 text-right">							
							 <strong class="strong_title" style="font-size: 20px !important;">ปีงบประมาณ</strong> 
						
							<select name="YearMemberTotal" id="YearMemberTotal" onchange="selectYearMemberTotal()"  style="width: 80px;height: 34px !important;background-color: #FFF;border: 1px solid #e5e6e7;">
								@foreach ($fiscalyear2_arr as $item)
								<option class="form-control" value="{{ $item }}">{{ $item;}}</option>	
								@endforeach
							  </select>
						</div>		  
				    <div  class="panel-collapse collapse in">
				      <div class="panel-body">
						<div id="member_total"  style="width: 100%;height:auto;">
							
						</div>
						<br>
						 <center>
							 <table>
							<tr>
								 <td>จำนวนสมาชิก (Member)</td>
								 <td>{{ number_format($count_member_date_total) }}</td>
								 <td>ราย</td>
							</tr>							
							<tr>
								<td>จำนวนผู้สมัคร (Application)</td>
								<td>{{ number_format($count_app_date_total) }}</td>
								<td>ราย</td>
						   </tr>
							 </table>
						{{-- <label class="control-label">
							<strong class="strong_title">จำนวนสมาชิก (Member) {{ number_format($count_member_date_total) }} ราย</strong>
						</label>
						<br>
						<label class="control-label">
							<strong class="strong_title">จำนวนผู้สมัคร (Application) {{ number_format($count_app_date_total) }} ราย</strong>
						</label>	 --}}
						 </center>
				      </div>
				    </div>
					<br>
					<br>
				</div>

				
					<div class="panel panel-success">
					<div class="col-md-9">
						<br>
					<label class="control-label"><strong class="strong_title">มูลค่าการค้าย้อนหลัง 3 ปี (ล้านบาท)	</strong></label>	
					</div>	
				  <div class="col-md-3"><br>
					<i class="dot8"></i>&nbsp;&nbsp;
					<label class="control-label"><strong>ภายในประเทศ</strong></label><br>
					<i class="dot9"></i>&nbsp;&nbsp;
					<label class="control-label"><strong>ในต่างประเทศ</strong></label><br>
					</div>			  
				    <div  class="panel-collapse collapse in">
				      <div class="panel-body">
						<div id="profit" style="width: 100%">
						 
						</div>
						<div class="row">
							<div class="col-md-3">
								รวม
							</div>
							<div class="col-md-3">
								{{ number_format($last_in_thai_count2019+$last_count2019) }}
							</div>
							<div class="col-md-3">
								{{ number_format($last_in_thai_count2020+$last_count2020) }}
							</div>
							<div class="col-md-3">
								{{ number_format($last_in_thai_count2021+$last_count2021) }}
							</div>
						</div>
						

				      </div>					  
				    </div>

				</div>	
				<br>			  
			  </div><br>

			  		<div class="col-md-4">		
						  <div class="text-right" style="margin-right: 20px;">			
					<label class="control-label"><strong class="strong_title">จำนวนสมาชิก<br>ในแต่ละประเภทธุรกิจ (ราย)</strong></label>
				</div>
					<div class="row">
					<div class="col-md-4">      
						<select name="" id="" class="form-control" onchange="selecet_provine(this.value)" style="width: 100%;">
							<option value="all" selected>ภูมิภาค</option>
							<option value="1">ภาคเหนือ</option>
							<option value="2">ภาคกลาง</option>
							<option value="3">ภาคตะวันออกเฉียงเหนือ</option>
							<option value="4">ภาคตะวันตก</option>
							<option value="5">ภาคตะวันออก</option>
							<option value="6">ภาคใต้</option>
					  </select>                                  
					</div>
					<div class="col-md-4">      
						<select name="province" id="province" class="form-control" onchange="selecet_provine(this.value)" style="width: 100%;">
							<option value="all" selected>จังหวัด</option>
							<option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
							<option value="กระบี่">กระบี่ </option>
							<option value="กาญจนบุรี">กาญจนบุรี </option>
							<option value="กาฬสินธุ์">กาฬสินธุ์ </option>
							<option value="กำแพงเพชร">กำแพงเพชร </option>
							<option value="ขอนแก่น">ขอนแก่น</option>
							<option value="จันทบุรี">จันทบุรี</option>
							<option value="ฉะเชิงเทรา">ฉะเชิงเทรา </option>
							<option value="ชัยนาท">ชัยนาท </option>
							<option value="ชัยภูมิ">ชัยภูมิ </option>
							<option value="ชุมพร">ชุมพร </option>
							<option value="ชลบุรี">ชลบุรี </option>
							<option value="เชียงใหม่">เชียงใหม่ </option>
							<option value="เชียงราย">เชียงราย </option>
							<option value="ตรัง">ตรัง </option>
							<option value="ตราด">ตราด </option>
							<option value="ตาก">ตาก </option>
							<option value="นครนายก">นครนายก </option>
							<option value="นครปฐม">นครปฐม </option>
							<option value="นครพนม">นครพนม </option>
							<option value="นครราชสีมา">นครราชสีมา </option>
							<option value="นครศรีธรรมราช">นครศรีธรรมราช </option>
							<option value="นครสวรรค์">นครสวรรค์ </option>
							<option value="นราธิวาส">นราธิวาส </option>
							<option value="น่าน">น่าน </option>
							<option value="นนทบุรี">นนทบุรี </option>
							<option value="บึงกาฬ">บึงกาฬ</option>
							<option value="บุรีรัมย์">บุรีรัมย์</option>
							<option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์ </option>
							<option value="ปทุมธานี">ปทุมธานี </option>
							<option value="ปราจีนบุรี">ปราจีนบุรี </option>
							<option value="ปัตตานี">ปัตตานี </option>
							<option value="พะเยา">พะเยา </option>
							<option value="พระนครศรีอยุธยา">พระนครศรีอยุธยา </option>
							<option value="พังงา">พังงา </option>
							<option value="พิจิตร">พิจิตร </option>
							<option value="พิษณุโลก">พิษณุโลก </option>
							<option value="เพชรบุรี">เพชรบุรี </option>
							<option value="เพชรบูรณ์">เพชรบูรณ์ </option>
							<option value="แพร่">แพร่ </option>
							<option value="พัทลุง">พัทลุง </option>
							<option value="ภูเก็ต">ภูเก็ต </option>
							<option value="มหาสารคาม">มหาสารคาม </option>
							<option value="มุกดาหาร">มุกดาหาร </option>
							<option value="แม่ฮ่องสอน">แม่ฮ่องสอน </option>
							<option value="ยโสธร">ยโสธร </option>
							<option value="ยะลา">ยะลา </option>
							<option value="ร้อยเอ็ด">ร้อยเอ็ด </option>
							<option value="ระนอง">ระนอง </option>
							<option value="ระยอง">ระยอง </option>
							<option value="ราชบุรี">ราชบุรี</option>
							<option value="ลพบุรี">ลพบุรี </option>
							<option value="ลำปาง">ลำปาง </option>
							<option value="ลำพูน">ลำพูน </option>
							<option value="เลย">เลย </option>
							<option value="ศรีสะเกษ">ศรีสะเกษ</option>
							<option value="สกลนคร">สกลนคร</option>
							<option value="สงขลา">สงขลา </option>
							<option value="สมุทรสาคร">สมุทรสาคร </option>
							<option value="สมุทรปราการ">สมุทรปราการ </option>
							<option value="สมุทรสงคราม">สมุทรสงคราม </option>
							<option value="สระแก้ว">สระแก้ว </option>
							<option value="สระบุรี">สระบุรี </option>
							<option value="สิงห์บุรี">สิงห์บุรี </option>
							<option value="สุโขทัย">สุโขทัย </option>
							<option value="สุพรรณบุรี">สุพรรณบุรี </option>
							<option value="สุราษฎร์ธานี">สุราษฎร์ธานี </option>
							<option value="สุรินทร์">สุรินทร์ </option>
							<option value="สตูล">สตูล </option>
							<option value="หนองคาย">หนองคาย </option>
							<option value="หนองบัวลำภู">หนองบัวลำภู </option>
							<option value="อำนาจเจริญ">อำนาจเจริญ </option>
							<option value="อุดรธานี">อุดรธานี </option>
							<option value="อุตรดิตถ์">อุตรดิตถ์ </option>
							<option value="อุทัยธานี">อุทัยธานี </option>
							<option value="อุบลราชธานี">อุบลราชธานี</option>
							<option value="อ่างทอง">อ่างทอง </option>
							<option value="อื่นๆ">อื่นๆ</option>
					  </select>                                  
					</div>
					<div class="col-md-4">
						<select name="year" id="year" class="form-control" style="width: 100%;" onchange="selecet_provine(this.value)">
							@foreach ($fiscalyear2_arr as $item)
							<option class="form-control" value="{{ $item-543 }}">ปีงบประมาณ {{ $item;}}</option>	
							@endforeach
						  </select>
					</div>
				</div>

				{{-- chart pie --}}
				<center>
					<div id="member_total_business">
					</div>
					{{-- <div class="text-center categoryTypeCountAll">
						<span class="count-status" id="categoryTypeCountAll">{{number_format($categoryTypeCountAll)}}</span>
					</div>
					<div class="text-center categoryTypeCountAll1">
						<span class="count-status">ราย</span>
					</div> --}}
				</center>

				<center>
				<div class="col-md-12">	
					<div class="card-body1 d-flex align-items-center">
						<div class="col-md-1 category-icon">
							<img src="{{{ url('assets/2019/images/icon/cutlery.png')}}}" alt="">
						{{-- <span style="margin-right:10px;">ICON</span> --}}
					</div>	
						<div class="col-md-9 text-left category-type">
						<span style="margin-left:20px;">อุตสาหกรรมอาหารและเกษตร</span>
					</div>	
						<div class="col-md-2 category-count" >
						<span class="span-category" id="display_prov_count1">{{ number_format($category1) }}</span>
					</div>
				  </div> 
				  <div class="card-body2 d-flex align-items-center">
					<div class="col-md-1 category-icon">
						<img src="{{{ url('assets/2019/images/icon/gear.png')}}}" alt="">					
				</div>	
					<div class="col-md-9 text-left category-type">
					<span style="margin-left:20px;">อุตสาหกรรมหนัก</span>
				</div>	
					<div class="col-md-2 category-count" >
					<span class="span-category" id="display_prov_count2">{{ number_format($category2) }}</span>
				</div>
			  </div> 
			  <div class="card-body3 d-flex align-items-center">
				<div class="col-md-1 category-icon">
					<img src="{{{ url('assets/2019/images/icon/work-space.png')}}}" alt="">				
			</div>	
				<div class="col-md-9 text-left category-type">
				<span style="margin-left:20px;">อุตสาหกรรมไลฟ์สไตล์</span>
			</div>	
				<div class="col-md-2 category-count" >
				<span class="span-category" id="display_prov_count3">{{ number_format($category3) }}</span>
			</div>
		  </div> 
		  <div class="card-body4 d-flex align-items-center">
			<div class="col-md-1 category-icon">
				<img src="{{{ url('assets/2019/images/icon/clothes-hanger.png')}}}" alt="">			
		</div>	
			<div class="col-md-9 text-left category-type">
			<span style="margin-left:20px;">อุตสาหกรรมแฟชั่น</span>
		</div>	
			<div class="col-md-2 category-count" >
			<span class="span-category" id="display_prov_count4">{{ number_format($category4) }}</span>
		</div>
	  </div> 
			<div class="card-body5 d-flex align-items-center">
				<div class="col-md-1 category-icon">
					<img src="{{{ url('assets/2019/images/icon/open-box.png')}}}" alt="">			
			</div>	
				<div class="col-md-9 text-left category-type">
				<span style="margin-left:20px;">อุตสาหกรรมอื่นๆ</span>
			</div>	
				<div class="col-md-2 category-count" >
				<span class="span-category" id="display_prov_count5">{{ number_format($category5) }}</span>
			</div>
		</div> 
		<div class="card-body6 d-flex align-items-center">
			<div class="col-md-1 category-icon">
				<img src="{{{ url('assets/2019/images/icon/health.png')}}}" alt="">			
		</div>	
			<div class="col-md-9 text-left category-type" id="category-6">
			<span>ธุรกิจบริการรักษาพยาบาล (โรงพยาบาล/คลินิก)</span>
		</div>	
			<div class="col-md-2 category-count" >
			<span class="span-category" id="display_prov_count6">{{ number_format($category6) }}</span>
		</div>
		</div> 

		<div class="card-body7 d-flex align-items-center">
			<div class="col-md-1 category-icon">
				<img src="{{{ url('assets/2019/images/icon/cosmetic.png')}}}" alt="">												

		</div>	
			<div class="col-md-9 text-left category-type" id="category-7">
			<span >ธุรกิจบริการส่งเสริมสุขภาพ (สปา)</span>
		</div>	
			<div class="col-md-2 category-count" >
			<span class="span-category" id="display_prov_count7">{{ number_format($category7) }}</span>
		</div>
		</div>
		<div class="card-body8 d-flex align-items-center">
			<div class="col-md-1 category-icon">
				<img src="{{{ url('assets/2019/images/icon/mortarboard.png')}}}" alt="">												
		</div>	
			<div class="col-md-9 text-left category-type" id="category-8">
			<span>ธุรกิจบริการการศึกษานานาชาติ</span>
		</div>	
			<div class="col-md-2 category-count" >
			<span class="span-category" id="display_prov_count8">{{ number_format($category8) }}</span>
		</div>
		</div> 
				</div>
			</center>
				</div>
				<div class="panel panel-success col-md-12">
					<div class="row">
						<div class="col-md-4">
							<label class="control-label strong_title"><strong>5 อันดับประเทศคู่ค้า</strong></label>
						</div>
					</div>
				<div class="row" style="height: auto;">
					<div class="col-md-4">
						{{-- 11111 --}}
						<div class="col-lg-4 card-top-5-body1">
								<div class="row" style="height: 160px">
								<div class="col-md-3" style="padding: 10px 30px;">			
									<span class="top5-order-1" style="font-size: 100px;">
										1.
									</span>
								</div>
								<div class="col-md-4">			
									<span>
										
									</span>
								</div>	
								<div class="col-md-5" style="padding: 45px 30px;">			
									<span style="font-size: 45px;">
										China
									</span>
								</div>
							</div>
							</div> 
					</div> 
					<div class="col-lg-4">	
						{{-- 2222 --}}
						<div class="row">
						<div class="card-top-5-body2">
							<div class="col-md-3 top-5-number">			
								<span>
									2.
								</span>
							</div>
							<div class="col-md-4">			
								<span>
									
								</span>
							</div>	
							<div class="col-md-5 top-5-country">			
								<span>
									United States
								</span>
							</div>
						</div>
						</div>
						<div class="row">
							<div class="card-top-5-body4">
								<div class="col-md-3 top-5-number">			
									<span>
										4.
									</span>
								</div>
								<div class="col-md-4">			
									<span>
										
									</span>
								</div>	
								<div class="col-md-5 top-5-country">			
									<span>
										Philippines
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">	
						{{-- 333 --}}
						<div class="row">
						<div class="card-top-5-body3">
							<div class="col-md-3 top-5-number">			
								<span>
									3.
								</span>
							</div>
							<div class="col-md-4">			
								<span>
									
								</span>
							</div>	
							<div class="col-md-5 top-5-country">			
								<span>
									India
								</span>
							</div>
						</div>
						</div>
						<div class="row">
							<div class="card-top-5-body5">
								<div class="col-md-3 top-5-number">			
									<span>
										5.
									</span>
								</div>
								<div class="col-md-4">			
									<span>
										
									</span>
								</div>	
								<div class="col-md-5 top-5-country">			
									<span>
										Singapore
									</span>
								</div>
							</div>
						</div>
					</div>
		</div>	
				</div>
		  </div>

{{--			<div class="panel panel-success col-md-12">
				<div class="row">
					<div class="col-md-4">
						<label class="control-label strong_title"><strong>5 อันดับประเทศคู่ค้า</strong></label>
					</div>
				</div>
			<div class="row" style="height: auto;">
				<div class="col-md-4">	
					<div class="col-lg-4 card-top-5-body1">
						<div class="">
							<div class="row" style="height: 160px">
							<div class="col-md-3" style="padding: 10px 30px;">			
								<span style="font-size: 100px;">
									1.
								</span>
							</div>
							<div class="col-md-4">			
								<span>
									
								</span>
							</div>	
							<div class="col-md-5" style="padding: 45px 30px;">			
								<span style="font-size: 45px;">
									China
								</span>
							</div>
						</div>
						  </div>
						</div> 
				</div> 
				<div class="col-lg-4">	
					<div class="row">
					<div class="card-top-5-body2">
						<div class="col-md-3 top-5-number">			
							<span>
								2.
							</span>
						</div>
						<div class="col-md-4">			
							<span>
								
							</span>
						</div>	
						<div class="col-md-5 top-5-country">			
							<span>
								United States
							</span>
						</div>
					</div>
					</div>
					<div class="row">
						<div class="card-top-5-body4">
							<div class="col-md-3 top-5-number">			
								<span>
									4.
								</span>
							</div>
							<div class="col-md-4">			
								<span>
									
								</span>
							</div>	
							<div class="col-md-5 top-5-country">			
								<span>
									Philippines
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">	
					<div class="row">
					<div class="card-top-5-body3">
						<div class="col-md-3 top-5-number">			
							<span>
								3.
							</span>
						</div>
						<div class="col-md-4">			
							<span>
								
							</span>
						</div>	
						<div class="col-md-5 top-5-country">			
							<span>
								India
							</span>
						</div>
					</div>
					</div>
					<div class="row">
						<div class="card-top-5-body5">
							<div class="col-md-3 top-5-number">			
								<span>
									5.
								</span>
							</div>
							<div class="col-md-4">			
								<span>
									
								</span>
							</div>	
							<div class="col-md-5 top-5-country">			
								<span>
									Singapore
								</span>
							</div>
						</div>
					</div>
				</div>
	</div>
	   </div>--}}

	 </div> 

	 .
 </div>
<?php 
 
 ?>

<br/><br/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js" integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg==" crossorigin="anonymous"></script>




<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.css"></script>
{{-- <script src="print.js"></script> --}}
{{-- <script src="print.js"></script> --}}
{{-- <script src="http://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script>

// $('#province').on('change', function() {
//   alert( this.value );
// });
function select_period(){
	var period = $('#status').val();
	// console.log(period);
	$.ajax({
		type: "GET",
		url: '{{ action("AdminController@select_period") }}',
		data: {
			period : period
		},
		dataType: "json",
		success: function (response) {
			var period1 = JSON.parse(response.display_period_count1);
			var period2 = JSON.parse(response.display_period_count2);
			var period3 = JSON.parse(response.display_period_count3);
			var period4 = JSON.parse(response.display_period_count4);
			var period5 = JSON.parse(response.display_period_count5);
			var period6 = JSON.parse(response.display_period_count6);
			var period7 = JSON.parse(response.display_period_count7);
			var period8 = JSON.parse(response.display_period_count8);
			var period9 = JSON.parse(response.display_period_count9);
			var period10 = JSON.parse(response.display_period_count10);
			var period11 = JSON.parse(response.display_period_count11);
			var period12 = JSON.parse(response.display_period_count12);
			var period13 = JSON.parse(response.display_period_count13);
			var period14 = JSON.parse(response.display_period_count14);
			var period15 = JSON.parse(response.display_period_count15);
			var count_all = period1+period15+period14+period4+period6+period7+period5;
			$("#display_period_count1").html(response.display_period_count1);
			$("#display_period_count2").html(response.display_period_count2);
			$("#display_period_count3").html(response.display_period_count3);
			$("#display_period_count4").html(response.display_period_count4);
			$("#display_period_count5").html(response.display_period_count5);
			$("#display_period_count6").html(response.display_period_count6);
			$("#display_period_count7").html(response.display_period_count7);
			$("#display_period_count8").html(response.display_period_count8);
			$("#display_period_count9").html(response.display_period_count9);
			$("#display_period_count10").html(response.display_period_count10);
			$("#display_period_count11").html(response.display_period_count11);
			$("#display_period_count12").html(response.display_period_count12);
			$("#display_period_count13").html(response.display_period_count13);
			$("#display_period_count14").html(response.display_period_count14);
			$("#display_period_count15").html(response.display_period_count15);
			$("#display_period_countall").html(count_all);

	let arr = [{
					name: '',
					y: period1,
					z:  10,
					color:'rgb(117, 168, 229)',
					}, 
					{
					name: '',
					y: period15,
					z:  10,
					color:'rgb(121, 43, 2)',
					}, 
					{
					name: '',
					y: period14,
					z:  10,
					color:'rgb(217, 144, 45)',
					}, 
					{
					name: '',
					y: period4,
					z:  10,
					color:'rgb(116, 167, 0)',
					}, 
					{
					name: '',
					y: period6,
					z:  10,
					color:'rgba(119, 119, 119)',
					}, 
					{
					name: '',
					y: period7,
					z:  10,
					color:'rgb(0, 157, 137)',
					}, 
					{
					name: '',
					y: period5,
					z:  10,
					color:'rgb(172, 30, 81)'
					},
					]
	let arrnew = arr.filter((item,index)=>  item.y > 0)


	let paramComTotal = {
				backgroundColor: 'transparent',
				title: {
    					text: null
  						},
				data:arrnew ,
			
	}
	
	
		setHighChartDougenut(paramComTotal,'company_total','Company')


			
		}
	});
}

 
function selecet_provine(){

	
		var province_value =  $('#province').val();
		var year =  $('#year').val();
	$.ajax({
		type: "GET",
		url: '{{ action("AdminController@select_member_business_type") }}',
		data: {
			province_value : province_value,
			year : year,
		},
		dataType: "json",
		beforsend: function(response){
			member_total_business_start.destroy();
		},
		success: function (response) {		

			var prov1 = JSON.parse(response.display_prov_count1);
			var prov2 = JSON.parse(response.display_prov_count2);
			var prov3 = JSON.parse(response.display_prov_count3);
			var prov4 = JSON.parse(response.display_prov_count4);
			var prov5 = JSON.parse(response.display_prov_count5);
			var prov6 = JSON.parse(response.display_prov_count6);
			var prov7 = JSON.parse(response.display_prov_count7);
			var prov8 = JSON.parse(response.display_prov_count8);
			var categoryTypeCountAll = prov1+prov2+prov3+prov4+prov5+prov6+prov7+prov8;
			$("#display_prov_count1").html(response.display_prov_count1);
			$("#display_prov_count2").html(response.display_prov_count2);
			$("#display_prov_count3").html(response.display_prov_count3);
			$("#display_prov_count4").html(response.display_prov_count4);
			$("#display_prov_count5").html(response.display_prov_count5);
			$("#display_prov_count6").html(response.display_prov_count6);
			$("#display_prov_count7").html(response.display_prov_count7);
			$("#display_prov_count8").html(response.display_prov_count8);
			$("#categoryTypeCountAll").html(categoryTypeCountAll); 

			let arr =[{
					name: '',
					y: prov1,
					z:  10,
					color:'#d1550d'
					}, 
					{
					name: '',
					y: prov2,
					z:  10,
					color:'#73758d'
					},
					{
					name: '',
					y: prov3,
					z:  10,
					color:'#8011ae'
					},
					{
					name: '',
					y: prov4,
					z:  10,
					color:'#ac1e51'
					},
					{
					name: '',
					y: prov5,
					z:  10,
					color:'#e5a60e'
					},
					{
					name: '',
					y: prov6,
					z:  10,
					color:'#14ba6f'
					},
					{
					name: '',
					y: prov7,
					z:  10,
					color:'#42a8cf'
					},{
					name: '',
					y: prov8,
					z:  10,
					color:'#2d53b0'
					}]
			let arrnew = arr.filter((item,index)=>  item.y > 0)

			let paramMembus = {
				backgroundColor: 'transparent',
				title: {
    					text: null
  						},
				data: arrnew,
			
	}
	
	setHighChartDougenut(paramMembus,'member_total_business','ราย')

	
		}
	});
	
} 


const setHighChartLine = (param,idContainer)=>{
	// console.log({param})
  const {title,chart,data,tooltip,backgroundColor} = param;
	Highcharts.chart(idContainer, {
	chart: {
				type: 'area',
				backgroundColor,
				
			},
  title,
  series: data,
  credits: {
    enabled: false
  },
  xAxis: {
        categories: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ค.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ศ.','ธ.ค.']
    },
});
Highcharts.setOptions({
	lang: {
  	thousandsSep: ','
  }
}) 
}	

const setHighChartColumn = (param,idContainer)=>{
	// console.log({param})
  const {title,chart,data,tooltip,backgroundColor} = param;
	Highcharts.chart(idContainer, {
	chart: {
				type: 'column',
				backgroundColor,
			
			},
  title,
   
  series: data,


  credits: {
    enabled: false
  },

  xAxis: {
        categories: ['ปี พ.ศ. 2561', 'ปี พ.ศ. 2562', 'ปี พ.ศ. 2563']
    },

});
Highcharts.setOptions({
	lang: {
  	thousandsSep: ','
  }
})
}	


const setHighChartDougenut = (param,idContainer,typeUnit)=>{
	const {title,chart,data,tooltip,backgroundColor} = param;
	console.log({param})
	Highcharts.chart(idContainer, {
	chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
		allowPointSelect: true,
        cursor: 'pointer',
		borderWidth: 0,
        type: 'pie',
		backgroundColor,
    },
    title,
    tooltip: {
        pointFormat: `{series.name}: <b>{point.percentage:.1f}%</b>`
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
            	distance: -30,
                enabled: true,
                format: ` {point.percentage:.2f}  %`,
				
            }
        }
    },
    series: [{
    minPointSize: 10,
    innerSize: '55%',
    zMin: 0,
    name: '',
    data}],
	
	credits: {
		enabled: false
	},

	},function(e){
		let sumData = data.map((item)=>item.y).reduce((a,b)=>a+b).toLocaleString('en-US')
		let cssAdd = `transform: translateX(-50%) translateY(-50%);
						top: 50%;
						left: 50%;
						display:flex;
						position: absolute;
						flex-direction: column;
   						 `
		let cssTxt = `margin-right: auto;
    				margin-left: auto;`	
		let cssFontSize = `font-size:5rem;font-family:'Kanit-Light';`				
		let cssFontSize2 = `font-size:2rem;font-family:'Kanit-Light';`				
		$(e.container).prepend(`<div style="${cssAdd}">
								<span style="${cssTxt}${cssFontSize}">${sumData}</span>
								<span style="${cssTxt}${cssFontSize2}">${typeUnit}</span>
								
								</div>`) 	
		// console.log(`checkCallBack`)
		// // console.log(e)
		// console.log( data)
	})

	return
 
 
}	

$(document).ready(function () {

 

	let paramMemProfit = {
				title: {
    					text: null
  						},
				data:  [{
							showInLegend: false,     
							name: null,
							data: [{{$last_in_thai_count2019}},{{$last_in_thai_count2020}},{{$last_in_thai_count2021}}],
							color: 'rgb(223, 169, 8)'
						},
						{
							showInLegend: false,   
							name: null,
							data: [{{$last_count2019}},{{$last_count2020}},{{$last_count2021}}],
							color: 'rgb(157, 5, 202)'

						}],
				  
			
	}
	
	setHighChartColumn(paramMemProfit,'profit')

 
	let paramMemTotal = {
				title: {
    					text: null
  						},
				data: [{
					showInLegend: false,        
        		name: '',
				data: [{{$count_app_date1}}, {{$count_app_date2}}, {{$count_app_date3}}, {{$count_app_date4}}, {{$count_app_date5}}, {{$count_app_date6}},{{$count_app_date7}}, {{$count_app_date8}}, {{$count_app_date9}}, {{$count_app_date10}}, {{$count_app_date12}}, {{$count_app_date12}}],
				color:'rgb(14, 222, 187,0.3)',
				}],
			
	}
	setHighChartLine(paramMemTotal,'member_total')
	let paramMembus = {
				backgroundColor: 'transparent',
				title: {
    					text: null
  						},
				data: [{
					name: '',
					y: {{$category1}},
					z:  10,
					color:'#d1550d'
					}, 
					{
					name: '',
					y: {{$category2}},
					z:  10,
					color:'#73758d'
					},
					{
					name: '',
					y: {{$category3}},
					z:  10,
					color:'#8011ae'
					},
					{
					name: '',
					y: {{$category4}},
					z:  10,
					color:'#ac1e51'
					},
					{
					name: '',
					y: {{$category5}},
					z:  10,
					color:'#e5a60e'
					},
					{
					name: '',
					y: {{$category6}},
					z:  10,
					color:'#14ba6f'
					},
					{
					name: '',
					y: {{$category7}},
					z:  10,
					color:'#42a8cf'
					},
					{
					name: '',
					y: {{$category8}},
					z:  10,
					color:'#2d53b0'
					},
					
					],
			
	}
	setHighChartDougenut(paramMembus,'member_total_business','ราย')
					
					
	let arr = [{
					name: '',
					y: {{$count_applications1}},
					z:  10,
					color:'rgb(117, 168, 229)',
					}, 
					{
					name: '',
					y: {{$count_applications15}},
					z:  10,
					color:'rgb(121, 43, 2)',
					}, 
					{
					name: '',
					y: {{$count_applications14}},
					z:  10,
					color:'rgb(217, 144, 45)',
					}, 
					{
					name: '',
					y: {{$count_applications4}},
					z:  10,
					color:'rgb(116, 167, 0)',
					}, 
					{
					name: '',
					y: {{$count_applications6}},
					z:  10,
					color:'rgba(119, 119, 119)',
					}, 
					{
					name: '',
					y: {{$count_applications12}},
					z:  10,
					color:'rgb(0, 157, 137)',
					}, 
					{
					name: '',
					y: {{$count_applications5}},
					z:  10,
					color:'rgb(172, 30, 81)'
					}
					]
					// console.log({arr})
		let arrnew = arr.filter((item,index)=>  item.y > 0)
		//  console.log({arrnew})

	let paramComTotal = {
				backgroundColor: 'transparent',
				title: {
    					text: null
  						},
				data: arrnew,
			
	}
	
		setHighChartDougenut(paramComTotal,'company_total','Company')
 
});
 
function selectYearMemberTotal(){
	var YearMemberTotal =  $('#YearMemberTotal').val();
	// console.log(YearMemberTotal);
	$.ajax({
		type: "GET",
		url: '{{ action("AdminController@selectYearMemberTotal") }}',
		data: {
			YearMemberTotal : YearMemberTotal,
		},
		dataType: "json",
		success: function (response) {
			var count_app_date1 = JSON.parse(response.count_app_date1);
			var count_app_date2 = JSON.parse(response.count_app_date2);
			var count_app_date3 = JSON.parse(response.count_app_date3);
			var count_app_date4 = JSON.parse(response.count_app_date4);
			var count_app_date5 = JSON.parse(response.count_app_date5);
			var count_app_date6 = JSON.parse(response.count_app_date6);
			var count_app_date7 = JSON.parse(response.count_app_date7);
			var count_app_date8 = JSON.parse(response.count_app_date8);
			var count_app_date9 = JSON.parse(response.count_app_date9);
			var count_app_date10 = JSON.parse(response.count_app_date10);
			var count_app_date11 = JSON.parse(response.count_app_date11);
			var count_app_date12 = JSON.parse(response.count_app_date12);

			let paramMemTotal = {
				title: {
    					text: null
  						},
				data: [{
					showInLegend: false,        
        		name: 'Installation',
				data: [
				count_app_date1,
				count_app_date2,
				count_app_date3,
				count_app_date4,
				count_app_date5,
				count_app_date6,
				count_app_date7,
				count_app_date8,
				count_app_date9,
				count_app_date10,
				count_app_date11,
				count_app_date12
				],
				color:'rgb(14, 222, 187,0.3)',
				}],
			
	}
	setHighChartLine(paramMemTotal,'member_total')

		}
	});
}

// function AdminHomePDF(){
// // console.log('PDF');
// $.ajax({
// 	type: "POST",
// 	url: '{{ action("AdminController@AdminHomePDF") }}',
// 	data: {
// 		status:$('#status').val(),
// 		YearMemberTotal:$('#YearMemberTotal').val(),
// 		province:$('#province').val(),
// 		year:$('#year').val()
// 	},
// 	dataType: "json",
// 	// success: function (response) {
		
// 	// }
// });
// }

window.onload = function () {
    document.getElementById("downloadPdfBtn")
        .addEventListener("click", () => {
            const panel2 = this.document.getElementById("panel2");
            // console.log(panel2);
            // console.log(window);
            var opt = {
                margin: 6,
                filename: 'Dashboard.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 1 },
                jsPDF: { unit: 'mm', format: 'a2', orientation: 'landscape' }
            };
            html2pdf().from(panel2).set(opt).save();
        })
}

	</script>
@stop


