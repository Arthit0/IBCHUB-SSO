<!-- นิติบุคคลไทย -->
<div class="sso-section">
      <!-- container-fluid 1 --> 
     <div class="container-fluid">
        <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left detail-sso">
                   <p class="sso-title">ข้อมูลส่วนตัว</p>
                </div>
                <div class="col-sm-2  text-left detail-sso member_title">
                    <p>คำนำหน้า :</p>
                    <select class="input-sso" title="<?php echo lang('edit_member_title'); ?>"
                        tabindex="-98" name="member_title" id="member_title" placeholder="<?php echo lang('edit_member_title'); ?>" style="width: 90%!important;color: #404040 !important;border-radius: 8px !important;height: 48px !important;border: 1px solid #A6ACB6 !important;background-color: #ffffff !important;border: 0.5px solid #A6ACB6 !important;">
                        <option value="นาย"><?php echo lang('edit_Mr'); ?></option>
                        <option value="นาง"><?php echo lang('edit_Mrs'); ?></option>
                        <option value="นางสาว"><?php echo lang('edit_Ms'); ?></option>
                    </select>
                </div>
                <!-- /.col -->
                <div class="col-sm-3-5  text-left detail-sso">
                    <p>ชื่อ :</p>
                    <input type="text" class="input-sso sso-input" name="member_nameTh" id="member_nameTh" placeholder="<?php echo lang('edit_member_nameTh'); ?>" value="<?php echo (!empty($member_type['member_nameTh']))? htmlentities($member_type['member_nameTh']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-2-5  text-left detail-sso">
                    <p>ชื่อกลาง :</p>
                    <input type="text" class="input-sso sso-input" name="member_midnameTh" id="member_midnameTh" placeholder="<?php echo lang('edit_member_midnameTh'); ?>" value="<?php echo (!empty($member_type['member_midnameTh']))? htmlentities($member_type['member_midnameTh']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-2-5 text-left detail-sso"> 
                    <p>นามสกุล :</p>
                    <input type="text" class="input-sso sso-input" name="member_lastnameTh" id="member_lastnameTh" placeholder="<?php echo lang('edit_member_lastnameTh'); ?>" value="<?php echo (!empty($member_type['member_lastnameTh']))? htmlentities($member_type['member_lastnameTh']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>ชื่อ(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="member_nameEn" id="member_nameEn" placeholder="<?php echo lang('edit_member_nameEn'); ?>" value="<?php echo (!empty($member_type['member_nameEn']))? htmlentities($member_type['member_nameEn']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>ชื่อกลาง(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="member_midnameEn" id="member_midnameEn" placeholder="<?php echo lang('edit_member_midnameEn'); ?>" value="<?php echo (!empty($member_type['member_midnameEn']))? htmlentities($member_type['member_midnameEn']) : ""; ?>" >
                </div>                
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>นามสกุล(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="member_lastnameEn" id="member_lastnameEn" placeholder="<?php echo lang('edit_member_lastnameEn'); ?>" value="<?php echo (!empty($member_type['member_lastnameEn']))? htmlentities($member_type['member_lastnameEn']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <!-- <div class="col-sm-4 text-left detail-sso"> 
                    <p>วันเดือนปีเกิด </p>
                    <input type="date" class="input-sso sso-input" name="member_birthday" id="member_birthday" placeholder="<?php echo lang('edit_member_birthday'); ?>" value="<?php echo (!empty($member_type['member_birthday']))? htmlentities($member_type['member_birthday']) : ""; ?>" >
                </div> -->
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>เลขบัตรประชาชน  <a>&nbsp;<i class="<?php echo htmlentities($status_laser['icon_laser'])?>" style="color: <?php echo htmlentities($status_laser['icon_color_laser'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_laser['status_name_laser'])?></a></p>
                    <input type="text" class="input-sso sso-input" name="cid" id="cid" placeholder="<?php echo lang('edit_member_cid'); ?>" value="<?php echo (!empty($member['cid']))? htmlentities($member['cid']) : ""; ?>" readonly>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>อีเมล  <a>&nbsp;<i class="<?php echo htmlentities($status_email['icon_email'])?>" style="color: <?php echo htmlentities($status_email['icon_color_email'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_email['status_name_email'])?></a></p>
                    <input type="text" class="input-sso sso-input" name="email" id="email" placeholder="<?php echo lang('edit_member_email'); ?>" value="<?php echo (!empty($member_type['email']))? htmlentities($member_type['email']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>หมายเลขโทรศัพท์  <a>&nbsp;<i class="<?php echo htmlentities($status_sms['icon_sms'])?>" style="color: <?php echo htmlentities($status_sms['icon_color_sms'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_sms['status_name_sms'])?></a></p>
                    <input type="text" class="input-sso sso-input" name="tel" id="tel" placeholder="<?php echo lang('edit_member_tel'); ?>" value="<?php echo (!empty($member_type['tel']))? htmlentities($member_type['tel']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-12  text-left detail-sso">
                   <p class="sso-title">ข้อมูลที่อยู่ติดต่อ</p>
                </div>
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>รหัสไปรษณีย์ </p>
                    <input type="text" class="input-sso sso-input" name="postcode" id="postcode" placeholder="<?php echo lang('edit_contact_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"   value="<?php echo (!empty($member_type['postcode']))? htmlentities($member_type['postcode']) : ""; ?>" >
                    <div class="dropdown-menu dropdown_addr" id="dropdown_contact_postcode">
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso companyProvinceTh"> 
                    <p>จังหวัด </p>
                        <select  class="input-sso" title="<?php echo lang('edit_contact_province'); ?>" name="provinceTh" id="provinceTh" style="font-size: 19px;padding: 1px 18px;"></select>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso companyDistrictTh"> 
                    <p>อำเภอ </p>
                    <select  class="input-sso" title="<?php echo lang('edit_contact_district'); ?>" name="districtTh" id="districtTh" style="font-size: 19px;padding: 1px 18px;"></select>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso companySubdistrictTh"> 
                    <p>ตำบล </p>
                    <select  class="input-sso" title="<?php echo lang('edit_contact_subdistrict'); ?>" name="subdistrictTh" id="subdistrictTh" style="font-size: 19px;padding: 1px 18px;"></select>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>ที่อยู่ </p>
                    <input type="text" class="input-sso sso-input" name="addressTh" id="addressTh" placeholder="<?php echo lang('edit_contact_address'); ?>" value="<?php echo (!empty($member_type['addressTh']))? htmlentities($member_type['addressTh']) : ""; ?>" >
                </div>
                <div class="col-sm-4 text-left detail-sso ProvinceEn"> 
                    <p>จังหวัด(ภาษาอังกฤษ)</p>
                        <select  class="input-sso" title="<?php echo lang('edit_contact_province'); ?>" name="provinceEn" id="provinceEn" style="font-size: 19px;padding: 1px 18px;"></select>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso companyDistrictEn"> 
                    <p>อำเภอ(ภาษาอังกฤษ)</p>
                    <select  class="input-sso" title="<?php echo lang('edit_contact_district'); ?>" name="districtEn" id="districtEn" style="font-size: 19px;padding: 1px 18px;"></select>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso companySubdistrictEn"> 
                    <p>ตำบล(ภาษาอังกฤษ)</p>
                    <select  class="input-sso" title="<?php echo lang('edit_contact_subdistrict'); ?>" name="subdistrictEn" id="subdistrictEn" style="font-size: 19px;padding: 1px 18px;"></select>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>ที่อยู่(ภาษาอังกฤษ) </p>
                    <input type="text" class="input-sso sso-input" name="addressEn" id="addressEn" placeholder="<?php echo lang('edit_contact_address'); ?>" value="<?php echo (!empty($member_type['addressEn']))? htmlentities($member_type['addressEn']) : ""; ?>" >
                </div>
        </div><!-- /.row -->
        <input type="hidden" name="select_title" id="select_title" value = "<?php echo htmlentities($member_type['member_title']); ?>">
        <input type="hidden" name="select_noncompany_provinceTh" id="select_noncompany_provinceTh" value = "<?php echo htmlentities($member_type['provinceTh']); ?>">
        <input type="hidden" name="select_noncompany_districtTh" id="select_noncompany_districtTh" value = "<?php echo htmlentities($member_type['districtTh']); ?>">
        <input type="hidden" name="select_noncompany_subdistrictTh" id="select_noncompany_subdistrictTh" value = "<?php echo htmlentities($member_type['subdistrictTh']); ?>">
        <input type="hidden" name="select_company_provinceEn" id="select_company_provinceEn" value = "<?php echo htmlentities($member_type['provinceEn']); ?>">
        <input type="hidden" name="select_company_districtEn" id="select_company_districtEn" value = "<?php echo htmlentities($member_type['districtEn']); ?>">
        <input type="hidden" name="select_company_subdistrictEn" id="select_company_subdistrictEn" value = "<?php echo htmlentities($member_type['subdistrictEn']); ?>">
        <input type="hidden" name="type" id="type" value = "<?php echo htmlentities($member['type']); ?>">
        <input type="hidden" name="member_id"  id="member_id" value = "<?php echo htmlentities($member['member_id']); ?>">
    </div>
      <!-- end of container-fluid 1 -->
</div>

