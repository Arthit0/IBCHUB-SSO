<div class="container-fluid dashboard-container">
	<div class="news-container">
		<div class="input-group d-flex justify-content-between">

			<div class="form-group respon w-100 d-flex justify-content-between">
				<h2><?= lang('home_news_title') ?></h2>
				<div class="input-group" style="width:60%;">
					<button class="btn border-right-0 border" type="button" id="btn_search" class="btn btn-primary" style="border-radius: 0;border-top-left-radius: 0;
					border-bottom-left-radius: 0;border-top-left-radius: 8px;border-bottom-left-radius: 8px;">
					<span class="glyphicon glyphicon-search" aria-hidden="true"><i class="fa fa-search main-color"></i></span>
					</button>
					<input class="form-control py-2 border-left-0 border" type="text"  value="" name="search" id="search" placeholder="ค้นหา.." style="border-top-right-radius: 8px;
					border-bottom-right-radius: 8px;font-weight: 400;font-size: 22px;">
				</div>
			</div>
		</div>
		<!-- <table data-toggle="table"
			class=" table table-striped table-bordered sso-table table-caseCh-list"
			data-sort-order="asc"
			data-sort-name="company_id"
			data-side-pagination="server"
			data-pagination="true"
			data-pagination-loop="false"
			data-page-size="10"
			data-page-list="[10, 50, 100, 250, ALL]"
			data-query-params="searchQueryParams"
			data-content-type="application/x-www-form-urlencoded"
			data-url="<?php echo BASE_PATH . _INDEX; ?>portal/news_list"
			data-method="POST">
			<thead>
				<tr id="dataAlltable">
					<th data-field="td1" data-sortable="false" data-align="left">
						<div class="text_head_table_form_list font-th">
							<?= lang('home_news_table_title'); ?>
						</div>
					</th>
					<th data-field="td2" data-sortable="true" data-align="left"  data-width="200">
						<div class="text_head_table_form_list font-th">
							<?= lang('home_news_table_date') ?>
						</div>
					</th>
				</tr>
			</thead>
		</table> -->
		<table class="table table-striped table-bordered table-caseCh-list sso-table"
		data-pagination="true" data-toggle="table" data-url="<?php echo BASE_URL . _INDEX ; ?>portal/news_list" data-sort-order="asc" data-query-params="searchQueryParams" data-pagination-loop="false" data-page-size="10" data-side-pagination="server" data-page-list="[10, 25, 50, 100, all]">
		  <thead>
		    <tr class="text-center">
		      <th data-field="n_title" scope="col" data-sortable="ture" data-align="left"><?= lang('home_news_table_title') ?></th>
		      <th data-field="publicdate" scope="col" data-sortable="ture" data-align="center"><?= lang('home_news_table_date') ?></th>
		    </tr>
		  </thead>
		</table>

	</div>
</div>
<script>
	$(document).on('keyup', '#search', function () {
	    $('.sso-table').bootstrapTable('refresh');
	})

	$(document).on('click', '#btn_search', function () {
	    $('.sso-table').bootstrapTable('refresh');
	})
	function searchQueryParams(params) {
	    console.log(params);
	    params.type = $(`#select_type`).val();
	    params.text_search = $(`#search`).val();
	    params.status = $(`#select_status`).val();
	    return params; // body data

	}
</script>