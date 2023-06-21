<div class="container-fluid dashboard-container">
	<div class="row">
		<div class="col-sm-3">
			<div class="row w-100"> 
				<div class="col-sm-12 w-100">
					<h2 class="mb-0 mitr-r _f20"><?php echo $user_data['member_nameTh'] ?>&nbsp;<?php echo $user_data['member_lastnameTh'] ?></h2>
					<p class="mb-0 mitr-l _f16"><?php echo $user_data['company_nameTh'] ?></p>
				</div>
				<div class="col-sm-12 mb-2 mt-4">
					<a href="<?php echo BASE_PATH . _INDEX; ?>portal/profile" class="btn profile-btn shadow w-100"><img src="<?php echo BASE_PATH; ?>asset/img/profile.png" alt="">&nbsp;<span>ข้อมูลส่วนตัว</span></a>
				</div>
				<div class="col-sm-12 ">
					<a href="<?php echo BASE_PATH . _INDEX; ?>portal/forget" class="btn change-pass-btn shadow w-100"><img src="<?php echo BASE_PATH; ?>asset/img/change-password.png" alt="">&nbsp;<span>เปลี่ยนรหัสผ่าน</span></a>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<nav>
				<div class="nav nav-tabs " id="nav-tab" role="tablist">
					<button class="nav-link ditp-tab active" id="nav-ditp-tab" data-toggle="tab" data-target="#nav-ditp" type="button" role="tab" aria-controls="nav-ditp" aria-selected="true"><img src="<?php echo BASE_PATH; ?>asset/img/connect-sso.png" alt="">&nbsp;<span><?= lang('home_pill_ditp') ?></span></button>
					<button class="nav-link ditp-tab" id="nav-history-tab" data-toggle="tab" data-target="#nav-history" type="button" role="tab" aria-controls="nav-history" aria-selected="false"><img src="<?php echo BASE_PATH; ?>asset/img/history.png" alt="">&nbsp;<span><?= lang('home_pill_history') ?></span></button>
				</div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-ditp" role="tabpanel" aria-labelledby="nav-ditp-tab">
					<div class="ditp-card col-sm-12">
						<div class="row">
							<?php foreach ($portal as $key => $value): ?>
								<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
									<div class="ditp-item-card <?php echo $value['type'] == 1? 'mobile-card':''; ?>">
										<div class="ditp-item-card-img">
											<img src="<?php echo BASE_PATH . $value['img']; ?>" alt="<?php echo $value['title'] ?>">
										</div>
										<div class="ditp-item-card-title">
											<h2><?php echo $value['title'] ?></h2>
										</div>
										<div class="ditp-item-card-des">
											<p><?php echo $value['des'] ?></p>
										</div>
										<div role="button" class="portal-login-btn" data-client_id="<?php echo $value['client_id'] ?>" data-ssoid="<?php echo $_COOKIE['ssoid'] ?>"target="_blank">
											<div class="ditp-item-card-footer">
												<?php echo $value['type'] == 0? '<i class="fas fa-desktop text-white"></i> <span>Website</span>':'<i class="fa-solid fa-mobile-screen"></i><span>&nbsp;Mobile APP</span>';?>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach ?>
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
							class="table table-striped table-bordered table-caseCh-list sso-table"
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
							data-url="<?php echo BASE_PATH . _INDEX; ?>portal/user_log"
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
	});
	$(document).on('click', '.portal-login-btn', function() {
		let client_id = $(this).data('client_id');
		let ssoid = $(this).data('ssoid');
		console.log("sso :"+ssoid);
		console.log("client_id :"+client_id);

		$.ajax({
			data:{client_id:client_id, ssoid:ssoid},
			type: "POST",
			url: BASE_URL + _INDEX + "auth/login_portal",
			success: function(response) {
				let data = JSON.parse(response);
				console.log(data.url);
				window.open(data.url, '_blank');
				// window.location.href = data.url;
				return false;
			}
		});
	});
</script>