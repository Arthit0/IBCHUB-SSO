<!-- นิติบุคคลไทย -->
<div class="sso-section">
      <div class="container-fluid">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
              <div class="col-sm-4  text-center">
                <a id="status"> ฐานะยืนยันตัวตน :</a><a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="<?php echo htmlentities($status_case['icon'])?>" style="color: <?php echo htmlentities($status_case['icon_color'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_case['status_name'])?></a>
              </div>
              <!-- /.col --> 
              <div class="col-sm-2  text-center">
              </div>
              <!-- /.col -->
              <div class="col-sm-6 text-right"> 
                  <!-- <div class="col-12 text-right ibm-sb " style="padding-bottom:10px"> -->
                        <a class="btn btn-primary active" id="ShowDataDBD" style="width: 191px;height: 44px;background: #122C4E;border-radius: 8px;text-align: center;padding: 10px 25px;"><i class='fa fa-eye'></i> แสดงข้อมูล DBD</a>&nbsp;
                        <!-- <a class="btn btn-primary active" id="UpdateDataDBD" style="width: 210px;height: 44px;background: #122C4E;border-radius: 8px;text-align: center;padding: 10px 25px;"><i class='fa fa-refresh'></i> อัพเดตข้อมูล DBD</a>&nbsp; -->
                        <!-- <?php if ($member_type['status_case'] != 0): ?>
                            <a class="btn btn-primary" id="ShowAttachment"  style="width: 191px;height: 44px;border-radius: 8px;text-align: center;color: #FFFFFF;padding: 10px 25px;">  อนุมัติ / ไม่อนุมัติ</a>
                        <?php endif ?> -->
                        <a class="btn btn-primary" id="ShowAttachment"  style="width: 191px;height: 44px;border-radius: 8px;text-align: center;color: #FFFFFF;padding: 10px 25px;">  อนุมัติ / ไม่อนุมัติ</a>
                  <!-- </div> -->
              </div>
              <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
  </div>
  <br>
  <div class="sso-section">
     <br>
      <!-- container 1 --> 
      <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">ข้อมูลนิติบุคคล</p>
                </div>
                <div class="col-sm-4  text-left">
                    <p>เลขนิติบุคคล :</p>
                    <p> <?php echo (!empty($member['cid']))? htmlentities($member['cid']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left">
                    <p>ชื่อนิติบุคคล :</p>
                    <p> <?php echo (!empty($member_type['company_nameTh']))? htmlentities($member_type['company_nameTh']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left"> 
                    <p>ชื่อนิติบุคคล(ภาษาอังกฤษ) :</p>
                    <p> <?php echo (!empty($member_type['company_nameEn']))? htmlentities($member_type['company_nameEn']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left">
                    <p>อีเมลบริษัท :</p>
                    <p> <?php echo (!empty($member_type['company_email']))? htmlentities($member_type['company_email']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left">
                    <p>เบอร์โทรศัพท์สำนักงาน :</p>
                    <p> <?php echo (!empty($member_type['company_tel']))? htmlentities($member_type['company_tel']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left"> 
                    <p>ที่อยู่นิติบุคคล :</p>
                    <p> <?php 
                                echo (!empty($member_type['company_addressTh']))? htmlentities($member_type['company_addressTh']) : "-"; 
                                echo (!empty($member_type['company_subdistrictTh']))? htmlentities(' ต.'.$member_type['company_subdistrictTh']) : " ต.-";
                                echo (!empty($member_type['company_districtTh']))? htmlentities(' อ.'.$member_type['company_districtTh']) : " อ.-";
                                echo (!empty($member_type['company_provinceTh']))? htmlentities(' จ.'.$member_type['company_provinceTh']) : " จ.-";
                                echo (!empty($member_type['company_postcodeTh']))? htmlentities(' '.$member_type['company_postcodeTh']) : " ";
                        ?> 
                    </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left"> 
                    <p>ที่อยู่นิติบุคคล(ภาษาอังกฤษ) :</p>
                    <p><?php 
                                echo (!empty($member_type['company_addressEn']))? htmlentities($member_type['company_addressEn']) : "-"; 
                                echo (!empty($member_type['company_subdistrictEn']))? htmlentities(' '.$member_type['company_subdistrictEn']) : " -";
                                echo (!empty($member_type['company_districtEn']))? htmlentities(' '.$member_type['company_districtEn']) : " -";
                                echo (!empty($member_type['company_provinceEn']))? htmlentities(' '.$member_type['company_provinceEn']) : " -";
                                echo (!empty($member_type['company_postcodeEn']))? htmlentities(' '.$member_type['company_postcodeEn']) : " ";
                        ?> 
                    </p>
                </div>
                <!-- /.col -->
            </div><!-- /.row -->
      </div>
      <!-- end of container 1 -->
      <br>
      <!-- container 2 --> 
      <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                 <?php if ($member_type['director_status'] == 2): ?>
                   <!-- <p class="sso-title">ข้อมูลส่วนตัว (ผู้รับมอบอำนาจ) ข้อมูลส่วนตัว (กรรมการผู้มีอำนาจ) (ไทย)</p> -->
                    <p class="sso-title">ข้อมูลส่วนตัว (ผู้รับมอบอำนาจ) (<?php echo ($member['status_contact_nationality'] == 1)?"ไทย":"ต่างชาติ"; ?>)</p>
                <?php endif ?>
                <?php if ($member_type['director_status'] == 1): ?>
                    <p class="sso-title">ข้อมูลส่วนตัว (กรรมการผู้มีอำนาจ) (<?php echo ($member['status_contact_nationality'] == 1)?"ไทย":"ต่างชาติ"; ?>)</p>
                   <!-- <p class="sso-title">ข้อมูลส่วนตัว (กรรมการ)</p> -->
                <?php endif ?>
                </div>
                <?php if ($member['status_contact_nationality'] == 1): ?>
                    <div class="col-sm-2  text-left">
                        <p>คำนำหน้า :</p>
                        <p> <?php echo (!empty($member_type['member_title']))? htmlentities($member_type['member_title']) : "-"; ?> </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3  text-left">
                        <p>ชื่อ :</p>
                        <p> <?php echo (!empty($member_type['member_nameTh']))? htmlentities($member_type['member_nameTh']) : "-"; ?> </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2-5  text-left">
                        <p>ชื่อกลาง :</p>
                        <p> <?php echo (!empty($member_type['member_midnameTh']))? htmlentities($member_type['member_midnameTh']) : "-"; ?> </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2-5 text-left"> 
                        <p>นามสกุล :</p>
                        <p> <?php echo (!empty($member_type['member_lastnameTh']))? htmlentities($member_type['member_lastnameTh']) : "-"; ?> </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2  text-left">
                        <p>คำนำหน้า(ภาษาอังกฤษ)</p>
                        <p> <?php
                            if(!empty($member_type['member_title'])){
                            switch ($member_type['member_title']) {
                                case 'นาย':
                                $titleEn = "Mr.";
                                break;
                                case 'นาง':
                                $titleEn = "Mrs.";
                                break;
                                case 'นางสาว':
                                $titleEn = "Miss";
                                break;
                                case 'คุณ':
                                $titleEn = "Khun";
                                break;
                                case 'ด๊อกเตอร์':
                                $titleEn = "Dr.";
                                break;
                                case 'นางสาว':
                                $titleEn = "Miss";
                                break;
                                default:
                                $titleEn = $member_type['member_title'];
                                break;
                            }
                            echo htmlentities($titleEn);
                            }else{
                            echo "-";
                            } 
                        ?> </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3  text-left">
                        <p>ชื่อ(ภาษาอังกฤษ) :</p>
                        <p> <?php echo (!empty($member_type['member_nameEn']))? htmlentities($member_type['member_nameEn']) : "-"; ?> </p>
                    </div>
                    <div class="col-sm-2-5  text-left">
                        <p>ชื่อกลาง(ภาษาอังกฤษ) :</p>
                        <p> <?php echo (!empty($member_type['member_midnameEn']))? htmlentities($member_type['member_midnameEn']) : "-"; ?> </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2-5 text-left"> 
                        <p>นามสกุล(ภาษาอังกฤษ) :</p>
                        <p> <?php echo (!empty($member_type['member_lastnameEn']))? htmlentities($member_type['member_lastnameEn']) : "-"; ?> </p>
                    </div>
                    <!-- /.col -->
                    <!-- <?php if ($member['status_laser_verify'] == 0): ?>
                        <div class="col-sm-2 text-left"> 
                            <p>วันเดือนปีเกิด :</p>
                            <p> <?php echo (!empty($member_type['member_birthday']))? htmlentities($member_type['member_birthday']) : "-"; ?> </p>
                        </div>
                    <?php endif ?> -->
                    <!-- /.col -->
                    <div class="col-sm-3 text-left"> 
                        <p>เลขบัตรประชาชน : <a>&nbsp;<i class="<?php echo htmlentities($status_laser['icon_laser'])?>" style="color: <?php echo htmlentities($status_laser['icon_color_laser'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_laser['status_name_laser'])?></a></p>
                        <p> <?php echo (!empty($member_type['member_cid']))? htmlentities($member_type['member_cid']) : "-"; ?> </p>
                    </div>
                <?php endif ?>
                <?php if ($member['status_contact_nationality'] == 2): ?>
                    <!-- /.col -->
                    <div class="col-sm-2  text-left">
                        <p>คำนำหน้า(ภาษาอังกฤษ)</p>
                        <p> <?php
                            if(!empty($member_type['member_title'])){
                            switch ($member_type['member_title']) {
                                case 'นาย':
                                $titleEn = "Mr.";
                                break;
                                case 'นาง':
                                $titleEn = "Mrs.";
                                break;
                                case 'นางสาว':
                                $titleEn = "Miss";
                                break;
                                case 'คุณ':
                                $titleEn = "Khun";
                                break;
                                case 'ด๊อกเตอร์':
                                $titleEn = "Dr.";
                                break;
                                case 'นางสาว':
                                $titleEn = "Miss";
                                break;
                                default:
                                $titleEn = $member_type['member_title'];
                                break;
                            }
                            echo htmlentities($titleEn);
                            }else{
                            echo "-";
                            } 
                        ?> </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3  text-left">
                        <p>ชื่อ(ภาษาอังกฤษ) :</p>
                        <p> <?php echo (!empty($member_type['member_nameEn']))? htmlentities($member_type['member_nameEn']) : "-"; ?> </p>
                    </div>
                    <div class="col-sm-2-5  text-left">
                        <p>ชื่อกลาง(ภาษาอังกฤษ) :</p>
                        <p> <?php echo (!empty($member_type['member_midnameEn']))? htmlentities($member_type['member_midnameEn']) : "-"; ?> </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2-5 text-left"> 
                        <p>นามสกุล(ภาษาอังกฤษ) :</p>
                        <p> <?php echo (!empty($member_type['member_lastnameEn']))? htmlentities($member_type['member_lastnameEn']) : "-"; ?> </p>
                    </div>
                    <!-- /.col -->
                    <!-- <?php if ($member['status_laser_verify'] == 0): ?>
                        <div class="col-sm-2 text-left"> 
                            <p>วันเดือนปีเกิด :</p>
                            <p> <?php echo (!empty($member_type['member_birthday']))? htmlentities($member_type['member_birthday']) : "-"; ?> </p>
                        </div>
                    <?php endif ?> -->
                    <!-- /.col -->
                    <div class="col-sm-3 text-left"> 
                        <p>พาสปอร์ต :</p>
                        <p> <?php echo (!empty($member_type['member_cid']))? htmlentities($member_type['member_cid']) : "-"; ?> </p>
                    </div>
                <?php endif ?>

                <!-- /.col -->
                <div class="col-sm-2-5 text-left"> 
                    <p>อีเมล : <a>&nbsp;<i class="<?php echo htmlentities($status_email['icon_email'])?>" style="color: <?php echo htmlentities($status_email['icon_color_email'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_email['status_name_email'])?></a></p>
                    <p> <?php echo (!empty($member_type['member_email']))? htmlentities($member_type['member_email']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-2-5 text-left"> 
                    <p>หมายเลขโทรศัพท์ : <a>&nbsp;<i class="<?php echo htmlentities($status_sms['icon_sms'])?>" style="color: <?php echo htmlentities($status_sms['icon_color_sms'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_sms['status_name_sms'])?></a></p>
                    <p> <?php echo (!empty($member_type['member_tel']))? htmlentities($member_type['member_tel']) : "-"; ?> </p>
                </div>
                <!-- /.col -->
            </div><!-- /.row -->
      </div>
      <!-- end of container 2 -->
      <br>
      <!-- container 3 --> 
      <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">ข้อมูลที่อยู่ติดต่อ</p>
                </div>
                <div class="col-sm-4  text-left">
                    <p>ที่อยู่ติดต่อ :</p>
                    <p> <?php  echo (!empty($member_type['contact_address'])) ?  htmlentities($member_type['contact_address']) :   "-";
                        echo (!empty($member_type['contact_subdistrict']))? htmlentities(' ต.'.$member_type['contact_subdistrict']) : " ต.-";
                        echo (!empty($member_type['contact_district']))? htmlentities(' อ.'.$member_type['contact_district']) : " อ.-";
                        echo (!empty($member_type['contact_province']))? htmlentities(' จ.'.$member_type['contact_province']) : " จ.-";
                        echo (!empty($member_type['contact_postcode']))? htmlentities(' '.$member_type['contact_postcode']) : " ";
                     ?> 
                    </p>
                </div>
            </div><!-- /.row -->
      </div>
      <!-- end of container 3 -->
  </div>
  <br>
  <div class="sso-section">
      <!-- container 1 --> 
      <?php if ($member_type['director_status'] == 2): ?>
        <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">เอกสารแนบ</p>
                </div>
                <div class="col-sm-4  text-left">
                    <p>เอกสารมอบอำนาจ :</p>
                </div>
                <?php if (!empty($attachment['power_attorney_href'])): ?>
                    <!-- /.col -->
                    <div class="col-sm-6  text-left">
                        <a href="<?php echo (!empty($attachment['power_attorney_href']))? htmlentities($attachment['power_attorney_href']) : "-"; ?>" style="text-decoration-line: underline;" target="_blank"><?php echo (!empty($attachment['power_attorney']))? htmlentities($attachment['power_attorney']) : "-"; ?></a>
                    </div>
                <?php endif ?>
                <?php if (empty($attachment['power_attorney_href'])): ?>
                         <a>-</a>
                <?php endif ?>
                <!-- /.col -->
                <div class="col-sm-4  text-left">
                    <p>สำเนาบัตรประชาชนผู้มอบอำนาจ :</p>
                </div>
                <?php if (!empty($attachment['authorization_href'])): ?>
                    <!-- /.col -->
                    <div class="col-sm-6  text-left">
                        <a href="<?php echo (!empty($attachment['authorization_href']))? htmlentities($attachment['authorization_href']) : "-"; ?>" style="text-decoration-line: underline;" target="_blank"><?php echo (!empty($attachment['authorization']))? htmlentities($attachment['authorization']) : "-"; ?></a>
                    </div>
                    <!-- /.col -->
                <?php endif ?>
                <?php if (empty($attachment['authorization_href'])): ?>
                         <a>-</a>
                <?php endif ?>
            </div><!-- /.row -->
      </div>
      <?php endif ?>
      <?php if ($member_type['director_status'] == 1): ?>
        <div class="container">
            <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">เอกสารแนบ</p>
                </div>
                <div class="col-sm-1  text-left">
                    <p>เอกสาร :</p>
                </div>
                <!-- /.col -->
                <div class="col-sm-8  text-left">
                     <?php if (!empty($attachment['power_attorney_href'])): ?>
                         <a href="<?php echo htmlentities($attachment['power_attorney_href']); ?>" style="text-decoration-line: underline;" target="_blank"><?php echo (!empty($attachment['power_attorney']))? htmlentities($attachment['power_attorney']) : "-"; ?></a>
                     <?php endif ?>
                     <?php if (empty($attachment['power_attorney_href'])): ?>
                         <a>-</a>
                     <?php endif ?>
                </div>
                <!-- /.col -->
            </div><!-- /.row -->
      </div>
      <?php endif ?>
     
     
      <!-- end of container 1 -->
  </div>
  <br>
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
        <input type="hidden" name="director_status" id="director_status" value = "<?php echo htmlentities($member_type['director_status']); ?>">
        <input type="hidden" name="member_id"  id="member_id" value = "<?php echo htmlentities($member['member_id']); ?>">
        <input type="hidden" name="member_cid"  id="member_cid" value = "<?php echo htmlentities($member['cid']); ?>">
  </div>

