<div class="container-fluid dashboard-container">
	<div class="news-container">
		<form class="input-group d-flex justify-content-between">

			<div class="form-group respon w-100 d-flex justify-content-between">
				<h2><b><?= lang('home_news_title') ?></b></h2>
				<div class="input-group" style="width:60%;">
					<button class="btn border-right-0 border" type="sunmit" id="btn_search" class="btn btn-primary" style="border-radius: 0;border-top-left-radius: 0;
					border-bottom-left-radius: 0;border-top-left-radius: 8px;border-bottom-left-radius: 8px;">
					<span class="glyphicon glyphicon-search" aria-hidden="true"><i class="fa fa-search main-color"></i></span>
					</button>
					<input class="form-control py-2 border-left-0 border" type="text"  value="" name="search" id="search" placeholder="ค้นหา.." style="border-top-right-radius: 8px;
					border-bottom-right-radius: 8px;    font-weight: bold;font-size: 22px;">
				</div>
			</div>
		</form>
		<table data-toggle="table"
			class="table-caseCh-list"
			data-sort-order="asc"
			id="data_table"
			data-sort-name="company_id"
			data-side-pagination="server"
			data-pagination="true"
			data-pagination-loop="false"
			data-page-size="10"
			data-page-list="[10, 50, 100, 250, ALL]"
			data-query-params="searchQueryParams"
			data-content-type="application/x-www-form-urlencoded"
			data-url="<?php echo BASE_PATH . _INDEX; ?>home/fetch_data"
			data-method="POST">
			<thead>
				<tr id="dataAlltable">
					<th class="tb-radius-left" data-field="td2" data-sortable="false" data-align="left">
						<div class="text_head_table_form_list font-th">
							<?= lang('home_news_table_title'); ?>
						</div>
					</th>
					<th class="tb-radius-right" data-field="td3" data-sortable="false" data-align="left"  data-width="200">
						<div class="text_head_table_form_list font-th">
							<?= lang('home_news_table_date') ?>
						</div>
					</th>
				</tr>
			</thead>
		</table>
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