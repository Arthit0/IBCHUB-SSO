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
  <style>
    .input-group > .form-control:not(:last-child), .input-group > .custom-select:not(:last-child) {
      border-top-right-radius: 8px!important;
      border-bottom-right-radius: 8px!important;
    }
    .page-item.disabled .page-link {
      background-color: transparent;
    }
    .inputWithIcon input {
      border-radius: 8px;
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <form action="javascript:void(0)" autocomplete="off">
          <div class="row d-inline-flex align-items-center mb-2 w-100">
            <div class="col-sm-3">
              <h2 class="ibm-sb _f20 p-4"><?= $title ?></h2>
            </div><!-- /.col -->

            <div class="col-sm-9">

              <div class="row d-inline-flex align-items-center justify-content-end w-100">
                <div class="col-sm-2 text-right d-none" style="padding-bottom:10px">
                  <a href="<?php echo BASE_PATH; ?>office/add_member?type=<?php echo $type ?>" class="btn sso-btn-add w-100"><i class="fa fa-plus mx-2 my-1"></i>เพิ่มผู้ใช้</a>
                </div>
                <?php if ($type == 1): ?>
                <div class="col-sm-3" style="padding-bottom:10px">
                  <select id="select_director" class="form-control select-filter">
                    <option value="" selected>ฐานะทั้งหมด</option>
                    <option value="1">กรรมการ</option>
                    <option value="2">ผู้รับมอบอำนาจ</option>
                  </select>
                </div>

                <div class="col-sm-3" style="padding-bottom:10px">
                  <select id="select_verify" class="form-control select-filter">
                    <option value="" selected>สถานะยืนยันตัวตน</option>
                    <option value="1">ยังไม่ยืนยันตัวตน</option>
                    <option value="2">ไม่ตรงกับรายชื่อกรรมการ</option>
                    <option value="3">รออนุมัติ</option>
                    <option value="4">รอกรรมการอนุมัติอีเมล</option>
                    <option value="5">ไม่อนุมัติ</option>
                    <option value="99">อนุมัติแล้ว</option>
                  </select>
                </div>

                <?php endif ?>
                <?php if ($type != 1): ?>
                <div class="col-sm-3" style="padding-bottom:10px">
                  <select id="select_verify" class="form-control select-filter">
                    <option value="" selected>สถานะยืนยันตัวตน</option>
                    <option value="0">ยังไม่ยืนยันตัวตน</option>
                    <option value="1">ยืนยันตัวตน</option>
                  </select>
                </div>
                <?php endif ?>

                <div class="col-sm-3" style="padding-bottom:10px">
                  <select class="form-control select-filter" title="สถานะการเข้าระบบ" tabindex="-98" id="select_status">
                    <option value="" selected>ทั้งหมด</option>
                    <option value="1">Activate</option>
                    <option value="0">Inactivate</option>
                  </select>
                </div>
                <input type="hidden" name="member_type" value="<?php echo $type ?>">
                <div class="col-sm-3" style="padding-bottom:10px">
                  <div class="input-group">
                    <input class="form-control select-filter" style="padding-left: 2rem;" type="text" value="" id="search" placeholder="ค้นหา">
                    <span class="input-group-append">
                      <button class="btn btn-outline-secondary border-left-0 border search_button" type="button" id="btn_search" class="btn btn-primary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                      </button>
                    </span>
                  </div>
                </div>
                 <!-- <input class=" input-sso pass_input" type="text" name="text_search" minlength="8" require autocomplete="off" placeholder="">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button">Button</button>
                </div> -->
              </div>




            </div><!-- /.col -->
          </div><!-- /.row -->
        </form>
        <div class="row mb-2">
          <div class="col-sm-12">
            <table class="table table-striped table-bordered sso-table" data-pagination="true" data-toggle="table" data-url="<?php echo BASE_URL . _INDEX ; ?>office/data_table?type=<?= $type ?>" data-sort-order="asc" data-query-params="searchQueryParams" data-pagination-loop="false" data-page-size="10" data-side-pagination="server" data-page-list="[10, 25, 50, 100, all]">
              <thead>
                <tr class="text-center">
                  <th data-field="td1" scope="col" data-sortable="true" data-align="left"><?= $type == 1 || $type == 6 ? 'เลขนิติบุคคล':'เลขบัตรประชาชน' ?></th>
                  <?php if ($type == 1 || $type == 6 || $type == 2): ?>
                    <th data-field="td2" scope="col" data-sortable="true" data-align="left">ชื่อนิติบุคคล</th>
                  <?php endif ?>
                  <th data-field="td3" scope="col" data-sortable="true" data-align="left">ชื่อ - นามสกุล</th>
                  <?php if ($type == 1 ): ?>
                  <th data-field="td4" scope="col" data-sortable="true" data-align="left">ฐานะ</th>
                  <?php endif ?>
                  <?php if ($type == 2 || $type == 4): ?>
                    <th data-field="td5" scope="col" data-sortable="true" data-align="left">สถานะยืนยันตัวตน</th>
                    <th data-field="td10" scope="col" data-sortable="true" data-align="left">ยืนยันตัวตนด้วยอีเมล</th>
                    <th data-field="td6" scope="col" data-sortable="true" data-align="left">วันที่สมัคร</th>
                    <th data-field="td7" scope="col" data-sortable="true" data-align="left">สถานะการเข้าระบบ</th>
                    <th data-field="td8" scope="col" data-align="center"></th>
                  <?php else: ?>
                    <th data-field="td5" scope="col" data-sortable="true" data-align="left">สถานะยืนยันตัวตน</th>
                    <th data-field="td9" scope="col" data-sortable="true" data-align="left">ยืนยันตัวตนด้วยเลขหลังบัตร</th>
                    <th data-field="td10" scope="col" data-sortable="true" data-align="left">ยืนยันตัวตนด้วยอีเมล</th>
                    <th data-field="td11" scope="col" data-sortable="true" data-align="left">ยืนยันตัวตนด้วยเบอร์โทร</th>
                    <th data-field="td6" scope="col" data-sortable="true" data-align="left">วันที่สมัคร</th>
                    <th data-field="td7" scope="col" data-sortable="true" data-align="left">สถานะการเข้าระบบ</th>
                    <th data-field="td8" scope="col" data-align="center"></th>
                  <?php endif ?>
                  
                  <!-- <th data-field="td1" scope="col" data-align="center">No.</th>
                  <th data-field="td2" scope="col" data-sortable="ture" data-align="left">First Name</th>
                  <th data-field="td3" scope="col" data-sortable="ture" data-align="left">Last Name</th>
                  <th data-field="td13" scope="col" data-sortable="ture" data-align="left">Position</th>
                  <th data-field="td4" scope="col" data-sortable="ture" data-align="left">Coporate Name</th>
                  <th data-field="td5" scope="col" data-sortable="ture" data-align="center">Coporate ID</th>
                  <th data-field="td6" scope="col" data-sortable="ture" data-align="center">Passport ID</th>
                  <th data-field="td7" scope="col" data-sortable="ture" data-align="center">ID Card Number</th>
                  <th data-field="td8" scope="col" data-sortable="ture" data-align="center">Type</th>
                  <th data-field="td14" scope="col" data-sortable="false" data-align="center">Register Date</th>
                  <th data-field="td12" scope="col" data-sortable="ture" data-align="center">Status</th>
                  <th data-field="td9" scope="col" data-sortable="ture" data-align="center">Username</th>
                  
                  <th data-field="td11" scope="col" data-align="center">Password</th> -->
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

<!-- Modal -->
<div class="modal fade" id="ShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class='fa fa-key mr-1'></i>เปลี่ยนรหัสผ่าน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row row-modal">
          <div class="col">
            <p id="name_edit" class="text-center" style="font-weight : bold"></p>
          </div>
        </div>
        <hr style="margin-bottom: 1rem;margin-top: 0rem; width:70%">
        <div class="row row-modal mb-2">
          <div class="col-lg-4">
            <p class="main-color" style="margin-bottom: 0rem;margin-top: 0rem;">รหัสผ่านใหม่&nbsp;<span class="text-danger">*</span></p>
          </div>
          <div class="col-lg-8 inputWithIcon box-username">
            <input type="password" name="password" id="password" required autocomplete="off" placeholder="รหัสผ่านใหม่" class="input-sso" aria-label="<?php echo lang('passport_id'); ?>">
            <i id="show-pass" class="fa fa-eye-slash icon-password"></i>  
          </div>
        </div>
        <div class="row row-modal">
          <div class="col-lg-4">
            <p class="main-color" style="margin-bottom: 0rem;margin-top: 0rem;">ยืนยันรหัสผ่าน&nbsp;<span class="text-danger">*</span></p>
          </div>
            <div class="col-lg-8 inputWithIcon box-username">
              <input type="password" name="repassword" id="repassword" required autocomplete="off" placeholder="ยืนยันรหัสผ่าน" class="input-sso" aria-label="<?php echo lang('passport_id'); ?>">
              <i id="show-repass" class="fa fa-eye-slash icon-password"></i>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <input type="hidden" id="member_id" value="">
          <input type="hidden" id="type" value="">
          <button type="button" class="btn sso-btn-back modal-cancel" data-dismiss="modal">ยกเลิก</button>
          <button type="button" class="btn sso-btn-add reset_save">บันทึก</button>
        </div>
      </div>

    </div>
  </div>
</div>


<!-- Footer -->
</div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/user_manage.js"></script>
<?php include ('component/footer.php'); ?>