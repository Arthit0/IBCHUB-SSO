<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
//include ('component/menu.php');
include ('component/header.php');
?>
<style>
  .loader_input {
    position: relative;
  }
  .sso-input{
    height: 48px;
    object-fit: contain;
    border-radius: 24px;
    border: solid 1px #629cc1;
    background-color: #ffffff;
    padding: 22px 25px;
    width:100%;
    outline: 0;
    font-size: 20px;
  }
  .sso-input:focus {
    border-color: dodgerBlue;
    box-shadow: 0 0 8px 0 dodgerBlue;
  }
  .sso-row{
    padding:5px;
  }
  .sso-section{
    border-radius: 10px;
    box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.3);
    background-color: #ffffff;
    padding:20px;
  }
  .sso-btn-save{
    border-radius: 21.5px;
    border:0px;
    background-color: #4189b7;
    color:white;
    width: 120px;
    font-size: 18px;
  }
  .sso-btn-save:hover{
    color:white;
  }
  .sso-btn-back{
    border-radius: 21.5px;
    background-color: #2b485b;
    border:0px;
    color:white;
    width: 100px;
    font-size: 18px;
  }
  .sso-btn-back:hover{
    color:white;
  }
  .sso-hr{
    width:95%;
    background-color:#629cc1;
  }
  .btn-danger-delete{
    border-radius: 21.5px;
    border:0px;
    background-color: #c82333;
    color:white !important;
    width: 120px;
    font-size: 18px;
  }
  .btn-danger-delete:hover{
    color:white !important;
  }
  
</style>
<div class="wrapper">
<?php 
  include ('component/nav.php'); 
  include ('component/menu_lte.php'); 
?>
    <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">

       <form id="form_edit_member" method="post" enctype="multipart/form-data">
      
       <div class="row w-100 d-inline-flex align-items-center">
            <div class="col-6 text-left">
            <h2 class="ibm-sb _f20 p-4">ยกเลิกสมาชิก</h2>
            </div>
            <div class="col-sm-6 text-right">
            <a href="<?php echo BASE_PATH; ?>office/edit_text" class="btn sso-btn-add"><i class="fa fa-plus mx-2 my-1"></i>แก้ไข</a>
            </div><!-- /.col -->
       </div>
       <?php //print_r($member_type); //echo $data['data']; die(); //echo $data['member_name']; ?>
       <div class="row mb-2">
            <div class="col-sm-12">
                                <table class="table table-striped table-bordered sso-table"
                                data-pagination="true"
                                data-toggle="table"
                                data-url="<?php echo BASE_URL . _INDEX ; ?>office/data_table_cancel"
                                data-sort-order="asc">

                                <thead>
                                    <tr class="text-center">
                                    <th data-field="td1" scope="col" data-align="center">No.</th>
                                    <th data-field="td2" scope="col" data-sortable="ture" data-align="center">Name</th>
                                    <th data-field="td3" scope="col" data-sortable="ture" data-align="center">Target</th>
                                    <th data-field="td4" scope="col" data-sortable="ture" data-align="center">Date</th>
                                    <th data-field="td5" scope="col" data-sortable="ture" data-align="center">Note</th>
                                    </tr>
                                </thead>
                                </table>

            </div><!-- /.col -->
        </div><!-- /.row -->
  
    </form>
      </div>
    </div>
      </div>
</div>
<!-- Footer -->
  </div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/user_manage.js"></script>
<?php include ('component/footer.php'); ?>