<div class="container-fluid dashboard-container">
	<div class="contact-container">
		<h2 class="contact-title"><?= lang('home_contact_title') ?></h2>
		<div class="row">
			<div class="col-sm-12 mb-4">
				<div class="contact-card">
					<div class="contact-card-title"><h4><b>กรมส่งเสริมการค้าระหว่างประเทศ</b></h4></div>
					<div class="contact-card-detail">
						<p>563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000</p>
						<p>โทรศัพท์ : 0-2507-7999</p>
						<p>E-mail : tiditp@ditp..go.th</p>
						<p><span class="t-main1 mr-4"><i class="fa-solid fa-phone"></i></span>สายตรงการค้าระหว่างประเทศ : 1169</p>
						<button class="btn btn-facebook-msg"><span class="mr-3"><i class="fa-brands fa-facebook-messenger"></i></span>Facebook Messenger</button>
					</div>
				</div>
			</div>
			<div class="col-sm-12 mb-4">
				<div class="contact-card">
					<div class="contact-card-title"><h4><b>กรมส่งเสริมการค้าระหว่างประเทศ (ถนนรัชดาภิเษก)</b></h4></div>
					<div class="contact-card-detail">
						<p>22/77 ถนนรัชดาภิเษก เขตจตุจักร กรุงเทพ 10900</p>
						<p>โทรศัพท์ : 0-2513-1909</p>
						<p>สายตรงการค้าระหว่างประเทศ : 1169</p>
						<p>E-mail : tiditp@ditp..go.th</p>
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