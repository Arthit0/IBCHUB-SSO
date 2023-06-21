<div class="container-fluid dashboard-container">
	<div class="row">
		<div class="col-sm-3">
			<div class="row w-100"> 
				<div class="col-sm-12 w-100">
					<h2 class="mb-0"><b>สมชาย แสงมั่งมี</b></h2>
					<p>บริษัท ทรัพย์สิน จำกัด</p>
				</div>
				<div class="col-sm-12 mb-2">
					<button class="btn profile-btn w-100"><img src="<?php echo BASE_PATH; ?>asset/img/profile.png" alt="">&nbsp;<span><b>ข้อมูลส่วนตัว</b></span></button>
				</div>
				<div class="col-sm-12 ">
					<a href="<?php echo BASE_PATH . _INDEX; ?>home/forget" class="btn change-pass-btn shadow w-100"><img src="<?php echo BASE_PATH; ?>asset/img/change-password.png" alt="">&nbsp;<span><b>เปลี่ยนรหัสผ่าน</b></span></a>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<nav>
				<div class="nav nav-tabs " id="nav-tab" role="tablist">
					<button class="nav-link ditp-tab active" id="nav-ditp-tab" data-toggle="tab" data-target="#nav-ditp" type="button" role="tab" aria-controls="nav-ditp" aria-selected="true"><img src="<?php echo BASE_PATH; ?>asset/img/connect-sso.png" alt="">&nbsp;<span><b><?= lang('home_pill_ditp') ?></b></span></button>
					<button class="nav-link ditp-tab" id="nav-history-tab" data-toggle="tab" data-target="#nav-history" type="button" role="tab" aria-controls="nav-history" aria-selected="false"><img src="<?php echo BASE_PATH; ?>asset/img/history.png" alt="">&nbsp;<span><b><?= lang('home_pill_history') ?></b></span></button>
				</div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-ditp" role="tabpanel" aria-labelledby="nav-ditp-tab">
					<div class="ditp-card col-sm-12">
						<div class="row">
							<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
								<div class="ditp-item-card">
									<div class="ditp-item-card-img">
										<img src="<?php echo BASE_PATH; ?>asset/img/value-creation-logo.png" alt="value-creation-logo">
									</div>
									<div class="ditp-item-card-title">
										<h2><b>Value Creation-DITP</b></h2>
									</div>
									<div class="ditp-item-card-des">
										<p>
											สำนักส่งเสริมนวัตกรรมและสร้างมูลค่า
											เพิ่มเพื่อการค้า กรมส่งเสริมการค้า
											ระหว่างประเทศ กระทรวงพาณิชย์ 
											ประสบความสำเร็จ
										</p>
									</div>
									<a href="https://valuecreation.ditp.go.th/" target="_blank">
										<div class="ditp-item-card-footer">
											<i class="fas fa-desktop text-white"></i> <span>Website</span>
										</div>
									</a>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
								<div class="ditp-item-card">
									<div class="ditp-item-card-img">
										<img src="<?php echo BASE_PATH; ?>asset/img/care-logo.png" alt="care-logo">
									</div>
									<div class="ditp-item-card-title">
										<h2><b>DITP CARE</b></h2>
									</div>
									<div class="ditp-item-card-des">
										<p>
											ระบบบริหารจัดการเรื่องร้องเรียนและ
											ข้อพิพาททางการค้าระหว่างประเทศ
										</p>
									</div>
									<a href="https://care.ditp.go.th/frontend/index.php?page=home" target="_blank">
										<div class="ditp-item-card-footer">
											<i class="fas fa-desktop text-white"></i> <span>Website</span>
										</div>
									</a>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
								<div class="ditp-item-card">
									<div class="ditp-item-card-img">
										<img src="<?php echo BASE_PATH; ?>asset/img/thaitrade-logo.png" alt="Thaitrade-logo">
									</div>
									<div class="ditp-item-card-title">
										<h2><b>Thaitrade.com</b></h2>
									</div>
									<div class="ditp-item-card-des">
										<p>
											ตลาดกลางพาณิชย์ดิจิตอลหนึ่งเดียว
											ของไทย
										</p>
									</div>
									<a href="https://www.thaitrade.com/home" target="_blank">
										<div class="ditp-item-card-footer">
											<i class="fas fa-desktop text-white"></i> <span>Website</span>
										</div>
									</a>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
								<div class="ditp-item-card">
									<div class="ditp-item-card-img">
										<img src="<?php echo BASE_PATH; ?>asset/img/drive-logo.png" alt="drive-logo">
									</div>
									<div class="ditp-item-card-title">
										<h2><b>DITP DRIVE</b></h2>
									</div>
									<div class="ditp-item-card-des">
										<p>
											สมัครเข้าร่วมกิจกรรมกรม ทั้งกิจกรรม
											ส่งเสริมการค้า และฝึกอบรม/สัมมนา เพื่อขับเคลื่อนผู้ประกอบการ
										</p>
									</div>
									<a href="https://drive.ditp.go.th/th-th/" target="_blank">
										<div class="ditp-item-card-footer">
											<i class="fas fa-desktop text-white"></i> <span>Website</span>
										</div>
									</a>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
								<div class="ditp-item-card">
									<div class="ditp-item-card-img">
										<img src="<?php echo BASE_PATH; ?>asset/img/tilog-logo.png" alt="Tradelogistics-logo">
									</div>
									<div class="ditp-item-card-title">
										<h2><b>Tradelogistics</b></h2>
									</div>
									<div class="ditp-item-card-des">
										<p>
											การส่งเสริมและพัฒนา
											ผู้ประกอบการ
											โลจิสติกส์ระหว่างประเทศของไทย 
											พัฒนาการให้บริการและขยายเครือข่าย
											ของผู้ให้บริการโลจิสติกส์ไทยสู่สากล
										</p>
									</div>
									<a href="https://www.tradelogistics.go.th/th/home" target="_blank">
										<div class="ditp-item-card-footer">
											<i class="fas fa-desktop text-white"></i> <span>Website</span>
										</div>
									</a>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
								<div class="ditp-item-card">
									<div class="ditp-item-card-img">
										<img src="<?php echo BASE_PATH; ?>asset/img/t-mark-logo.png" alt="TMark-logo">
									</div>
									<div class="ditp-item-card-title">
										<h2><b>TMark</b></h2>
									</div>
									<div class="ditp-item-card-des">
										<p>
											ตราสัญลักษณ์รับรองคุณภาพสินค้าที่
											กำหนดขึ้นเพื่อส่งเสริมคุณค่าของสินค้า
											และบริการของไทยที่ผลิตในประเทศไทย
										</p>
									</div>
									<a href="https://www.thailandtrustmark.com/th" target="_blank">
										<div class="ditp-item-card-footer">
											<i class="fas fa-desktop text-white"></i> <span>Website</span>
										</div>
									</a>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
								<div class="ditp-item-card">
									<div class="ditp-item-card-img">
										<img src="<?php echo BASE_PATH; ?>asset/img/ditp-logo.png" alt="DITP-PDPA-logo">
									</div>
									<div class="ditp-item-card-title">
										<h2><b>DITP PDPA</b></h2>
									</div>
									<div class="ditp-item-card-des">
										<p>
											หนังสือแสดงความยินยอมในการเก็บ
											รวบรวม ใช้ หรือเผยข้อมูลส่วนบุคคล
											สำหรับประชาชน
										</p>
									</div>
									<a href="#" target="_blank">
										<div class="ditp-item-card-footer">
											<i class="fas fa-desktop text-white"></i> <span>Website</span>
										</div>
									</a>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
								<div class="ditp-item-card mobile-card">
									<div class="ditp-item-card-img">
										<img src="<?php echo BASE_PATH; ?>asset/img/one-logo.png" alt="DITP-ONE-logo">
									</div>
									<div class="ditp-item-card-title">
										<h2><b>DITP ONE</b></h2>
									</div>
									<div class="ditp-item-card-des">
										<p>
											ตราสัญลักษณ์รับรองคุณภาพสินค้าที่
											กำหนดขึ้นเพื่อส่งเสริมคุณค่าของสินค้า
											และบริการของไทยที่ผลิตในประเทศไทย
										</p>
									</div>
									<a href="#" target="_blank">
										<div class="ditp-item-card-footer">
											<i class="fas fa-desktop text-white"></i> <span>Mobile App</span>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
					<div class="history-container">
						<form class="input-group d-none">
							<div class="form-group respon w-100 d-flex justify-content-end">
							  <div class="input-group" style="width:60%;">
							  	<button class="btn border-right-0 border" type="sunmit" id="btn_search" class="btn btn-primary" style="border-radius: 0;border-top-left-radius: 0;
							  	border-bottom-left-radius: 0;border-top-left-radius: 8px;border-bottom-left-radius: 8px;">
							  	  <span class="glyphicon glyphicon-search" aria-hidden="true"><i class="fa fa-search main-color"></i></span>
							  	</button>
							   <input class="form-control py-2 border-left-0 border" type="text"  value="" id="search" placeholder="ค้นหา.." style="border-top-right-radius: 8px;
							   border-bottom-right-radius: 8px;    font-weight: bold;font-size: 22px;">
							  </div>
							</div>
						</form>
						<table data-toggle="table"
							class="table-caseCh-list"
							data-sort-order="asc"
							id="data_table"
							data-sort-name="member_id"
							data-side-pagination="server"
							data-pagination="true"
							data-pagination-loop="false"
							data-page-size="10"
							data-page-list="[10, 50, 100, 250, ALL]"
							data-query-params="searchQueryParams"
							data-content-type="application/x-www-form-urlencoded"
							data-url="<?php echo BASE_PATH . _INDEX; ?>home/fetch_data"
							data-method="post">
							<thead>
								<tr id="dataAlltable">
									<th class="tb-radius-left" data-field="td1" data-sortable="false" data-align="center" data-width="50">
										<div class="text_head_table_form_list font-th">
											ลำดับ
										</div>
									</th>
									<th class="tb-radius" data-field="td2" data-sortable="false" data-align="left" >
										<div class="text_head_table_form_list font-th">
											ระบบที่เข้าใช้
										</div>
									</th>
									<th class="tb-radius-right" data-field="td3" data-sortable="false" data-align="left" data-width="200">
										<div class="text_head_table_form_list font-th">
											วันที่/เวลา
										</div>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function searchQueryParams(params) {
	  params.search = $('#search').val();
	  console.log(params);
	  return params; // body data
	}
	$(document).on('click', '#btn_search', function () {
	  $('.table-caseCh-list').bootstrapTable('refresh');
	  return false;
	})
</script>