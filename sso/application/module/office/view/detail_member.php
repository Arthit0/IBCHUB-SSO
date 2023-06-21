<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
//include ('component/menu.php');
include ('component/header.php');
?>
<style>
  .col-sm-3 {
    -ms-flex: 0 0 30%;
    flex: 0 0 30%;
    max-width: 30%;
}
.col-sm-2-5 {
    -ms-flex: 0 0 26%;
    flex: 0 0 26.5%;
    max-width: 26.5%;
}
  .loader_input {
    position: relative;
  }
  .sso-text-pass{
    font-family: 'IBM Plex Sans Thai Looped';
    font-style: normal;
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

  .sso-btn-edit:hover{
    color:white;
  }
  .sso-btn-pass:hover{
    color:white;
  }
  .sso-btn-back:hover{
    color:white;
  }
  .sso-hr{
    width:95%;
    background-color:#629cc1;
  }
  .btn-danger-delete{
    font-family: 'IBM Plex Sans Thai Looped', sans-serif;
    color: white !important;
    width: 120px;
    font-size: 16px;
    font-weight: 500;
    mix-blend-mode: normal;
    width: 162px;
    background-color:#A1363E;
    height: 48px;
    border-radius: 8px;
    padding: 13px 19px;
  }
  .btn-danger-delete:hover{
    color:white !important;
  }
  .modal {
    overflow: scroll !important;
}
 .modal-DBD{
     border: 0.5px solid #C3C7CD; 
     border-radius: 8px;
     width: 204%;
     left: -51%;
     right: 34%;
 }
 .col-lg-66 {
    -ms-flex: 0 0 3%;
    flex: 0 0 3%;
    max-width: 20%;
  }
  .col-lg-55 {
      -ms-flex: 0 0 47%;
      flex: 0 0 47%;
      max-width: 83%;
  }
 .sso-title-DBD{
  width: 185px;
  height: 33px;
  left: 655px;
  top: 187px;
  font-family: 'IBM Plex Sans Thai Looped';
  font-style: normal;
  font-weight: 600;
  font-size: 20px;
  line-height: 33px;
  color: #2D6DC4;
  mix-blend-mode: normal;
 }
 .sso-text-DBD{
  font-family: 'IBM Plex Sans Thai Looped';
  font-style: normal;
  font-weight: 500;
  font-size: 16px;
  line-height: 26px;
  color: #39414F;
 }
 .Committee{
    width: 75%;
    height: auto;
    background: #EAF0F9;
    border-radius: 8px;
    padding: 12px 23px;
 }
 .Committee-text{
    position: inherit;
    left: 9px;
 }
 
 .sso-text-Approve{
  font-family: 'IBM Plex Sans Thai Looped';
  font-style: normal;
  font-weight: 500;
  font-size: 16px;
  line-height: 26px;

  color: #39414F;
 }
 .Approve{
    border: 0.5px solid #8A919E;
    border-collapse: collapse;
    border-radius: 8px;
    border-style: hidden;
    box-shadow: 0 0 0 0.5px #8a919e;
 }
 .sso-btn-edit{
  font-family: 'IBM Plex Sans Thai Looped', sans-serif;
  color: white;
  width: 120px;
  font-size: 16px;
  font-weight: 500;
  mix-blend-mode: normal;
  width: 162px;
  height: 48px;
  background: #D4A400;
  border-radius: 8px;
  padding: 13px 19px;
   }
   .sso-btn-back-detail-member {
     width: 162px;
     height: 48px;
     background: #6F7887;
     border-radius: 8px;
     padding: 13px 19px;
     font-family: 'IBM Plex Sans Thai Looped';
     font-style: normal;
     font-weight: 500;
     font-size: 16px;
     color: white;
     line-height: 26px;
   }
   #powerApprove,
   #powerNoApprove,
   #authApprove,
   #authNoApprove,
   #renameApprove,
   #renameNoApprove {
    cursor: pointer;
   }
   
   .sso-btn-hold {
      color: #ffff !important;
      background-color: #A6ACB6;
      border-color: #A6ACB6;
      box-shadow: none;
   }
   .power-textarea{
    position: absolute;
    left: auto;
    top: 71.9px;
    margin-left: 88%;
    line-height: 1 !important;
    z-index: 4;
    background-color: #FFFFFF;
    padding: 10px 23px;
    border: 0.5px solid #FFFFFF;
    border-radius: 8px;
    color: #2D6DC4 !important;
    font-weight: 500 !important;
    font-size: 14px !important;
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
      
       <div class="row">
        <div class="col-6 text-left">
          <h2 class="ibm-sb _f20 p-4"><?php echo $title ?></h2>
        </div>
       </div>
      <?php
        if($member['type'] == 1){ //นิติบุคคลไทย
          include ('detail/detail_type_1.php');
        }else if($member['type'] == 2){ //นิติบุคคลต่างชาติ
          include ('detail/detail_type_2.php');
        }else if($member['type'] == 3){ //บุคคลไทย 
          include ('detail/detail_type_3.php');
        }else if($member['type'] == 4){ //บุคคลต่างชาติ
          include ('detail/detail_type_4.php');
        }if($member['type'] == 5){ //บุคคลต่างชาติ
          include ('detail/detail_type_5.php');
        }if($member['type'] == 6){ //นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
          include ('detail/detail_type_6.php');
        }
        if($member[0]['UserType'] == "corporate" ){ //นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
          include ('detail/corporate_Y.php');
        }else if($member[0]['UserType'] == "person"){ //นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
          include ('detail/person_Y.php');
        }
      ?>  
      <br>
      <div class="row">
          <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-2  text-left">
                </div>
                <!-- /.col -->
                <div class="col-sm-12  text-center">
                    <a href="<?php echo BASE_PATH; ?>office/user?type=<?php echo $member['type'] ?>" class="btn sso-btn-back-detail-member">ย้อนกลับ</a>
                    <a href="<?php echo BASE_PATH; ?>office/edit_member?type=<?php echo $member['type'] ?>&id=<?php echo $member['member_id'] ?>" class="btn sso-btn-edit">แก้ไขข้อมูล</a>
                    <a class='btn sso-btn-pass edit-pass' member-id="<?php echo $member['member_id']; ?>" member-name="<?php echo $member_type['company_nameEn']; ?>" data-toggle='modal' data-target='#ShowModal'>เปลี่ยนรหัสผ่าน</a>
                    <a class="btn btn-danger-delete">ลบข้อมูล</a>
                </div>
                <div class="col-sm-2  text-left">
                </div>
          </div>
        <!-- <div class="col-12 my-3 text-center d-inline-flex align-items-center justify-content-center">
        </div> -->
      </div>
    </form>
      </div>
    </div>
      </div>
</div>
<!-- Footer -->
      <div class="modal fade" id="ShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title sso-text-pass" id="exampleModalLabel"><i class='fa fa-key mr-1'></i>เปลี่ยนรหัสผ่าน</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row row-modal">
                <div class="col">
                  <p class="sso-text-pass text-center" id="name_edit"  ></p>
                </div>
              </div>
              <hr style="margin-bottom: 1rem;margin-top: 0rem; width:70%">
              <div class="row row-modal mb-2">
                <div class="col-lg-4">
                  <p class="main-color sso-text-pass" style="margin-bottom: 0rem;margin-top: 0rem;">รหัสผ่านใหม่&nbsp;<span class="text-danger">*</span></p>
                </div>
                <div class="col-lg-8 inputWithIcon box-username">
                  <input type="password" name="password" id="password" required autocomplete="off" placeholder="รหัสผ่านใหม่" class="input-sso sso-text-pass" aria-label="<?php echo lang('passport_id'); ?>">
                  <i id="show-pass" class="fa fa-eye-slash icon-password"></i>  
                </div>
              </div>
              <div class="row row-modal">
                <div class="col-lg-4">
                  <p class="main-color sso-text-pass" style="margin-bottom: 0rem;margin-top: 0rem;">ยืนยันรหัสผ่าน&nbsp;<span class="text-danger">*</span></p>
                </div>
                  <div class="col-lg-8 inputWithIcon box-username">
                    <input type="password" name="repassword" id="repassword" required autocomplete="off" placeholder="ยืนยันรหัสผ่าน" class="input-sso sso-text-pass" aria-label="<?php echo lang('passport_id'); ?>">
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

      <div class="modal fade" id="ShowModalDBD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog bd-example-modal-xl">
          <div class="modal-content modal-xl modal-DBD">
            <div class="modal-header">
              <div class="container" style="margin-left: 37px;">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-family: 'IBM Plex Sans Thai Looped';font-style: normal;color: #39414F !important;font-weight: 500;font-size: 30px">&times;</span>
                  </button>
                  <h5 class="modal-title sso-title-DBD" id="ModalLabel">ข้อมูลจากระบบ DBD</h5>
              </div>
            </div>
            <div class="modal-body" id="modalBody" style="margin-left: 37px;margin-right: 37px">
              
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade bd-example-modal-xl" id="ShowModalAttachment" tabindex="-1" style="z-index: 1041 !important;" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
               <div class="container" style="margin-left: 37px;">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-family: 'IBM Plex Sans Thai Looped';font-style: normal;color: #39414F !important;font-weight: 500;font-size: 30px">&times;</span>
                  </button>
                  <h5 class="modal-title sso-title-DBD">เอกสารแนบ</h5>
               </div>
            </div>
            <div class="modal-body" id="modalBodyApprove" style="margin-left: 37px;margin-right: 37px">

            </div>
          </div>
        </div>
      </div>

      <div class="modal fade bd-example-modal-xl" id="ShowModalRemarkAttachment" tabindex="-1" style="z-index: 1041 !important;" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
               <div class="container" style="margin-left: 37px;">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-family: 'IBM Plex Sans Thai Looped';font-style: normal;color: #39414F !important;font-weight: 500;font-size: 30px">&times;</span>
                  </button>
                  <h5 class="modal-title sso-title-DBD">หมายเหตุ</h5>
               </div>
            </div>
            <div class="modal-body" style="margin-left: 37px;margin-right: 37px">
                    <div class="form-group auth" style="display:none;">
                        <textarea class="input-textarea"  name="notation" id="remark_Attachment" autocomplete="off" placeholder="เขียนหมายเหตุ...."></textarea>
                        <a class="btn  power-textarea" type="button" id="notation_seve">บันทึก</a> 
                    </div>
                    <div class="form-group power" style="display:none;">
                        <textarea class="input-textarea"  name="power_notation" id="remark_power" autocomplete="off" placeholder="เขียนหมายเหตุ...."></textarea>
                        <a class="btn  power-textarea" type="button" id="power_notation_seve">บันทึก</a> 
                    </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/user_manage.js"></script>
<?php include ('component/footer.php'); ?>