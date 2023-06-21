<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
include ('component/header.php');
?>

<div class="wrapper">

<?php 
  include ('component/nav.php'); 
  include ('component/menu_lte.php'); 
?>
<style>
  .sso-btn-edit {
    padding: 10px 10px;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <form action="javascript:void(0)" autocomplete="off">
        <div class="row align-items-center mb-2">
          <div class="col-sm-4">
            <h2 class="ibm-sb _f20">จัดการข่าวสาร/แจ้งเตือน</h2>
          </div><!-- /.col -->
          <div class="col-sm-8">
            <div class="row">
              <div class="col-sm-12 text-right d-inline-flex justify-content-end sso-input">
                <div class="input-group mr-4" style="width: 40%;">
                  <span class="input-group-append d-inline-flex align-items-center">
                    <button class="btn btn-outline-secondary border-left-0 border search_button" type="button" id="btn_search">
                      <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                  </span>
                  <input class="form-control border-left-0 border input-sso" type="text" value="" id="search" placeholder="ค้นหา...">
                </div>
                <a href="<?php echo BASE_PATH; ?>office/add_news" class="btn sso-btn-add ibm-m _f16"><i class="fa-solid fa-circle-plus mx-2 my-1"></i><span style="margin-top: 5px;">เพิ่มข่าวสาร</span></a> 
              </div>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </form>
      <div class="row mb-2">
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-caseCh-list sso-table"
            data-pagination="true" data-toggle="table" data-url="<?php echo BASE_URL . _INDEX ; ?>office/data_table_news" data-sort-order="asc" data-query-params="searchQueryParams" data-pagination-loop="false" data-page-size="10" data-side-pagination="server" data-page-list="[10, 25, 50, 100, all]">
              <thead>
                <tr class="text-center ibm-m _f16">
                  <!--<th data-field="td1" scope="col" data-align="center">No.</th>-->
                  <th data-field="td1" scope="col" data-sortable="false" data-align="center">No.</th>
                  <th data-field="n_title" scope="col" data-sortable="ture" data-align="center">หัวข้อข่าว</th>
                  <th data-field="publicdate" scope="col" data-sortable="ture" data-align="center">วันที่เผยแพร่</th>
                  <th data-field="createdate" scope="col" data-sortable="ture" data-align="center">วันที่สร้าง</th>
                  <th data-field="td5" scope="col" data-align="center"></th>
                </tr>
              </thead>
            </table>

        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->

</div>


<!-- Footer -->
  </div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/news_manage.js"></script>
<?php include ('component/footer.php'); ?>
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




