<!-- นิติบุคคลต่างชาติ -->
  <div class="sso-section">
      <div class="container-fluid">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
              <div class="col-sm-4  text-center">
                <a id="status"> สถานะยืนยันตัวตน :</a><a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="<?php echo htmlentities($status_case['icon'])?>" style="color: <?php echo htmlentities($status_case['icon_color'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_case['status_name'])?></a>
              </div>
              <div class="col-sm-2  text-center">
              </div>
            </div>
        </div>
  </div>
  <br>
  <div class="sso-section">
     <br>
      <!-- container 1 --> 
      <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">Juristic Person Information</p>
                </div>
                <div class="col-sm-4  text-left">
                    <p>Corporate Number :</p>
                    <p> <?php echo (!empty($member['cid']))? htmlentities($member['cid']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left">
                    <p>Name of legal entity :</p>
                    <p> <?php echo (!empty($member_type['corporate_name']))? htmlentities($member_type['corporate_name']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left"> 
                    <p>Country  :</p>
                    <p> <?php  echo (!empty($member_type['country']))? htmlentities($member_type['country']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-2  text-left">
                    <p>Title :</p>
                    <p> <?php  echo (!empty($member_type['member_title']))? htmlentities($member_type['member_title']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-3  text-left">
                    <p>First Name :</p>
                    <p> <?php echo (!empty($member_type['member_nameEn']))? htmlentities($member_type['member_nameEn']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-2-5  text-left">
                    <p>Mid Name :</p>
                    <p> <?php echo (!empty($member_type['member_midnameEn']))? htmlentities($member_type['member_midnameEn']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-2-5 text-left"> 
                    <p>Last Name :</p>
                    <p> <?php echo (!empty($member_type['member_lastnameEn']))? htmlentities($member_type['member_lastnameEn']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left"> 
                    <p>Email : <a>&nbsp;<i class="<?php echo htmlentities($status_email['icon_email'])?>" style="color: <?php echo htmlentities($status_email['icon_color_email'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_email['status_name_email'])?></a></p>
                    <p> <?php echo (!empty($member_type['email']))? htmlentities($member_type['email']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left"> 
                    <p>Telephone Number : <a>&nbsp;<i class="<?php echo htmlentities($status_sms['icon_sms'])?>" style="color: <?php echo htmlentities($status_sms['icon_color_sms'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_sms['status_name_sms'])?></a></p>
                    <p> <?php echo (!empty($member_type['tel']))? htmlentities($member_type['tel']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
            </div><!-- /.row -->
      </div>
      <!-- end of container 1 -->
      <!-- container 2 --> 
      <!-- <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">ข้อมูลส่วนตัว (ผู้รับมอบอำนาจ)</p>
                </div>
                <div class="col-sm-4 text-left"> 
                    <p>วันเดือนปีเกิด :</p>
                    <p> <?php echo (!empty($member_type['member_birthday']))? htmlentities($member_type['member_birthday']) : "-"; ?> </p>
                </div>
                <div class="col-sm-4 text-left"> 
                    <p>เลขบัตรประชาชน :</p>
                    <p> <?php echo (!empty($member_type['member_cid']))? htmlentities($member_type['member_cid']) : "-"; ?> </p>
                </div>

            </div>
      </div> -->
      <!-- end of container 2 -->
      <br>
      <!-- container 3 --> 
      <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">Contact Information</p>
                </div>
                <div class="col-sm-4  text-left">
                    <p>Address :</p>
                    <p> <?php echo (!empty($member_type['address']))? htmlentities($member_type['address']) : "-"; ?> </p>
                </div>
            </div>
      </div>
      <!-- end of container 3 -->
  </div>
  <br>
  <!-- <div class="sso-section">
      <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">เอกสารแนบ</p>
                </div>
                <div class="col-sm-4  text-left">
                    <p>เอกสารมอบอำนาจ :</p>
                </div>
                <div class="col-sm-6  text-left">
                    <p> <?php echo (!empty($attachment['power_attorney']))? htmlentities($attachment['power_attorney']) : "-"; ?> </p>
                </div>
                <div class="col-sm-4  text-left">
                    <p>สำเนาบัตรประชาชนผู้มอบอำนาจ :</p>
                </div>
                <div class="col-sm-6  text-left">
                    <p> <?php echo (!empty($attachment['authorization']))? htmlentities($attachment['authorization']) : "-"; ?> </p>
                </div>
            </div>
      </div>
  </div>
  <br> -->
  <div class="sso-section">
      <!-- container 1 --> 
      <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-2  text-left">
                   <p class="sso-title">Note</p>
                </div>
                <div class="col-sm-8  text-left">
                    <!-- <textarea class="input-sso"  name="note" id="note_member" autocomplete="off" placeholder=""></textarea> 
                    <a class="btn btn-primary" type="button">บันทึก</a>  -->
                    <div class="form-group">
                        <textarea class="input-textarea"  name="note" id="note_member" autocomplete="off" placeholder="เขียนบันทึก...."><?php echo htmlentities($note['note']); ?></textarea>
                        <a class="btn  note-textarea" type="button" id="note_seve">บันทึก</a> 
                    </div>
                </div>
                <!-- /.col -->
                    <!-- <p> <?php echo (!empty($member_type['company_addressEn']))? htmlentities($member_type['company_addressEn']) : "-"; ?> </p> -->
            </div><!-- /.row -->
      </div>
      <!-- end of container 1 -->
      <br>
        <input type="hidden" name="title_name" value = "<?php echo htmlentities($member_type['member_title']); ?>">
        <input type="hidden" name="type" value = "<?php echo htmlentities($member['type']); ?>">
        <input type="hidden" name="member_id"  id="member_id" value = "<?php echo htmlentities($member['member_id']); ?>">
        <input type="hidden" name="member_cid"  id="member_cid" value = "<?php echo htmlentities($member['cid']); ?>">
  </div>

