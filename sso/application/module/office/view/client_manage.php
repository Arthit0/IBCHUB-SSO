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

      <div class="row mb-2 d-inline-flex align-items-center w-100">
        <div class="col-sm-6">
          <h2 class="ibm-sb _f20 p-4">จัดการผู้ให้บริการ API</h2>
        </div><!-- /.col -->
        <div class="col-sm-6 text-right">
          <a href="<?php echo BASE_PATH; ?>office/add_client" class="btn sso-btn-add"><i class="fa-solid fa-circle-plus mx-2 my-1"></i>เพิ่มผู้เชื่อมต่อ</a>  
        </div><!-- /.col -->
      </div><!-- /.row -->

      <div class="row mb-2">
        <div class="col-sm-12">
        <!--<table class="table table-striped table-bordered sso-table"
              data-pagination="true"
              data-search="false">-->
            <table class="table table-striped table-bordered sso-table"
              data-pagination="true"
              data-toggle="table"
              data-url="<?php echo BASE_URL . _INDEX ; ?>office/data_table_client"
              data-sort-order="asc">

              <thead>
                <tr class="text-center">
                  <!--<th data-field="td1" scope="col" data-align="center">No.</th>-->
                  <th data-field="td2" scope="col" data-sortable="ture" data-align="center">Client Name</th>
                  <th data-field="td3" scope="col" data-sortable="ture" data-align="center">Client ID</th>
                  <th data-field="td4" scope="col" data-sortable="ture" data-align="center">URL For Reply</th>
                  <th data-field="td5" scope="col" data-align="center">Manage Client</th>
                  <th data-field="td6" scope="col" data-align="center">Portal Status</th>
                  <th data-field="td7" scope="col" data-align="center"></th>
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
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/client_manage.js"></script>
<?php include ('component/footer.php'); ?>




