
<!-- นิติบุคคลไทย -->
<div class="sso-section">
      <!-- container-fluid 1 --> 
     <div class="container-fluid">
        <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">ข้อมูลนิติบุคคล</p>
                </div>
                <div class="col-sm-4 text-left">
                    <p>เลขนิติบุคคล :</p>
                     <input type="text" class="input-sso sso-input" name="cid" id="cid" placeholder="<?php echo lang('edit_cid'); ?>" value="<?php echo (!empty($member[0]['Username']))? htmlentities($member[0]['Username']) : "-"; ?>">
                     <br>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left">
                    <p>ชื่อนิติบุคคล :</p>
                    <input type="text" class="input-sso sso-input" name="company_nameTh" id="company_nameTh" placeholder="<?php echo lang('edit_company_Th'); ?>" value="<?php echo (!empty($member[0]['Firstname']))? htmlentities($member[0]['Firstname']) : "-"; ?>">
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left"> 
                    <p>ชื่อนิติบุคคล(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="company_nameEn" id="company_nameEn" placeholder="<?php echo lang('edit_company_En'); ?>" value="<?php echo (!empty($member[0]['Firstname']))? htmlentities($member[0]['Firstname']) : "-"; ?>">
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>อีเมลบริษัท :</p>
                    <input type="text" class="input-sso sso-input" name="company_email" id="company_email" placeholder="<?php echo lang('edit_company_email'); ?>" value="<?php echo (!empty($member[0]['Mail']))? htmlentities($member[0]['Mail']) : "-"; ?>">
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>เบอร์โทรศัพท์สำนักงาน :</p>
                    <input type="text" class="input-sso sso-input" name="company_tel" id="company_tel" placeholder="<?php echo lang('edit_company_tel'); ?>" value="<?php echo (!empty($member[0]['Telephone']))? htmlentities($member[0]['Telephone']) : "-"; ?>">
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>ที่อยู่นิติบุคคล :</p>
                    <input type="text" class="input-sso sso-input" name="company_addressTh" id="company_addressTh" placeholder="<?php echo lang('edit_company_addressTh'); ?>" value="<?php echo (!empty($member_type['company_addressTh']))? htmlentities($member_type['company_addressTh']) : "-"; ?>">
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>ที่อยู่นิติบุคคล(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="company_addressEn" id="company_addressEn" placeholder="<?php echo lang('edit_company_addressEn'); ?>" value="<?php echo (!empty($member_type['company_addressEn']))? htmlentities($member_type['company_addressEn']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-12  text-left detail-sso">
                   <p class="sso-title">ข้อมูลส่วนตัว (ผู้รับมอบอำนาจ)</p>
                </div>
                <div class="col-sm-4  text-left detail-sso member_title">
                    <p>คำนำหน้า :</p>
                    <select class="form-control selectpicker sso-dropdown title-dropdown" title="<?php echo lang('edit_member_title'); ?>"
                        tabindex="-98" name="member_title" id="member_title" placeholder="<?php echo lang('edit_member_title'); ?>" style="width: 90%!important;color: #404040 !important;border-radius: 8px !important;height: 48px !important;border: 1px solid #A6ACB6 !important;background-color: #ffffff !important;border: 0.5px solid #A6ACB6 !important;">
                        <option value="นาย"><?php echo lang('edit_Mr'); ?></option>
                        <option value="นาง"><?php echo lang('edit_Mrs'); ?></option>
                        <option value="นางสาว"><?php echo lang('edit_Ms'); ?></option>
                    </select>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>ชื่อ :</p>
                    <input type="text" class="input-sso sso-input" name="member_nameTh" id="member_nameTh" placeholder="<?php echo lang('edit_member_nameTh'); ?>" value="<?php echo (!empty($member_type['member_nameTh']))? htmlentities($member_type['member_nameTh']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>นามสกุล :</p>
                    <input type="text" class="input-sso sso-input" name="member_lastnameTh" id="member_lastnameTh" placeholder="<?php echo lang('edit_member_lastnameTh'); ?>" value="<?php echo (!empty($member_type['member_lastnameTh']))? htmlentities($member_type['member_lastnameTh']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>ชื่อ(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="member_nameEn" id="member_nameEn" placeholder="<?php echo lang('edit_member_nameEn'); ?>" value="<?php echo (!empty($member_type['member_nameEn']))? htmlentities($member_type['member_nameEn']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>นามสกุล(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="member_lastnameEn" id="member_lastnameEn" placeholder="<?php echo lang('edit_member_lastnameEn'); ?>" value="<?php echo (!empty($member_type['member_lastnameEn']))? htmlentities($member_type['member_lastnameEn']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>วันเดือนปีเกิด :</p>
                    <input type="text" class="input-sso sso-input" name="member_birthday" id="member_birthday" placeholder="<?php echo lang('edit_member_birthday'); ?>" value="<?php echo (!empty($member_type['member_birthday']))? htmlentities($member_type['member_birthday']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>เลขบัตรประชาชน :</p>
                    <input type="text" class="input-sso sso-input" name="member_cid" id="member_cid" placeholder="<?php echo lang('edit_member_cid'); ?>" value="<?php echo (!empty($member_type['member_cid']))? htmlentities($member_type['member_cid']) : "-"; ?>">
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>อีเมล :</p>
                    <input type="text" class="input-sso sso-input" name="member_email" id="member_email" placeholder="<?php echo lang('edit_member_email'); ?>" value="<?php echo (!empty($member_type['member_email']))? htmlentities($member_type['member_email']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>หมายเลขโทรศัพท์ :</p>
                    <input type="text" class="input-sso sso-input" name="member_tel" id="member_tel" placeholder="<?php echo lang('edit_member_tel'); ?>" value="<?php echo (!empty($member_type['member_tel']))? htmlentities($member_type['member_tel']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-12  text-left detail-sso">
                   <p class="sso-title">ข้อมูลที่อยู่ติดต่อ</p>
                </div>
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>รหัสไปรษณีย์ </p>
                    <input type="text" class="input-sso sso-input" name="contact_postcode" id="contact_postcode" placeholder="<?php echo lang('edit_contact_postcode'); ?>" value="<?php echo (!empty($member_type['contact_postcode']))? htmlentities($member_type['contact_postcode']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>จังหวัด </p>
                    <input type="text" class="input-sso sso-input" name="contact_subdistrict" id="contact_subdistrict" placeholder="<?php echo lang('edit_contact_subdistrict'); ?>" value="<?php echo (!empty($member_type['contact_subdistrict']))? htmlentities($member_type['contact_subdistrict']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>อำเภอ </p>
                    <input type="text" class="input-sso sso-input" name="contact_district" id="contact_district" placeholder="<?php echo lang('edit_contact_district'); ?>" value="<?php echo (!empty($member_type['contact_district']))? htmlentities($member_type['contact_district']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>ตำบล </p>
                    <input type="text" class="input-sso sso-input" name="contact_province" id="contact_province" placeholder="<?php echo lang('edit_contact_province'); ?>" value="<?php echo (!empty($member_type['contact_province']))? htmlentities($member_type['contact_province']) : "-"; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>ที่อยู่ </p>
                    <input type="text" class="input-sso sso-input" name="contact_address" id="contact_address" placeholder="<?php echo lang('edit_contact_address'); ?>" value="<?php echo (!empty($member_type['contact_address']))? htmlentities($member_type['contact_address']) : "-"; ?>" >
                </div>
        </div><!-- /.row -->
        <input type="hidden" name="select_title" id="select_title" value = "<?php echo htmlentities($member_type['member_title']); ?>">
    <input type="hidden" name="type" value = "<?php echo htmlentities($member[0]['UserType'].' '.$member[0]['Is_Thai']); ?>">
        <!-- <input type="hidden" name="type" id="type" value = "<?php echo htmlentities($member['type']); ?>"> -->
        <input type="hidden" name="member_id"  id="member_id" value = "<?php echo htmlentities($member['member_id']); ?>">
    </div>
      <!-- end of container-fluid 1 -->
</div>

