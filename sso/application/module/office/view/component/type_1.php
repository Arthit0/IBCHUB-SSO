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
                     <input type="text" class="input-sso sso-input" name="cid" id="cid" placeholder="<?php echo lang('edit_cid'); ?>" value="<?php echo (!empty($member['cid']))? htmlentities($member['cid']) : ""; ?>" readonly>
                     <br>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left">
                    <p>ชื่อนิติบุคคล :</p>
                    <input type="text" class="input-sso sso-input" name="company_nameTh" id="company_nameTh" placeholder="<?php echo lang('edit_company_Th'); ?>" value="<?php echo (!empty($member_type['company_nameTh']))? htmlentities($member_type['company_nameTh']) : ""; ?>" readonly>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left"> 
                    <p>ชื่อนิติบุคคล(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="company_nameEn" id="company_nameEn" placeholder="<?php echo lang('edit_company_En'); ?>" value="<?php echo (!empty($member_type['company_nameEn']))? htmlentities($member_type['company_nameEn']) : ""; ?>" readonly>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>อีเมลบริษัท :</p>
                    <input type="text" class="input-sso sso-input" name="company_email" id="company_email" placeholder="<?php echo lang('edit_company_email'); ?>" value="<?php echo (!empty($member_type['company_email']))? htmlentities($member_type['company_email']) : ""; ?>" readonly>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>เบอร์โทรศัพท์สำนักงาน :</p>
                    <input type="text" class="input-sso sso-input" name="company_tel" id="company_tel" placeholder="<?php echo lang('edit_company_tel'); ?>" value="<?php echo (!empty($member_type['company_tel']))? htmlentities($member_type['company_tel']) : ""; ?>" readonly>
                </div>
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>รหัสไปรษณีย์ </p>
                    <input type="text" class="input-sso sso-input" name="company_postcodeTh" id="company_postcodeTh" placeholder="<?php echo lang('edit_contact_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"   value="<?php echo (!empty($member_type['company_postcodeTh']))? htmlentities($member_type['company_postcodeTh']) : ""; ?>" readonly>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>จังหวัด </p>
                        <input type="text" class="input-sso sso-input" name="company_provinceTh" id="company_provinceTh" placeholder="<?php echo lang('edit_contact_province'); ?>" value="<?php echo (!empty($member_type['company_provinceTh']))? htmlentities($member_type['company_provinceTh']) : ""; ?>" readonly>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>อำเภอ </p>
                    <input type="text" class="input-sso sso-input" name="company_districtTh" id="company_districtTh" placeholder="<?php echo lang('edit_contact_district'); ?>" value="<?php echo (!empty($member_type['company_districtTh']))? htmlentities($member_type['company_districtTh']) : ""; ?>" readonly>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>ตำบล </p>
                    <input type="text" class="input-sso sso-input" name="company_subdistrictTh" id="company_subdistrictTh" placeholder="<?php echo lang('edit_contact_subdistrict'); ?>" value="<?php echo (!empty($member_type['company_subdistrictTh']))? htmlentities($member_type['company_subdistrictTh']) : ""; ?>" readonly>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>ที่อยู่นิติบุคคล :</p>
                    <input type="text" class="input-sso sso-input" name="company_addressTh" id="company_addressTh" placeholder="<?php echo lang('edit_company_addressTh'); ?>" value="<?php echo (!empty($member_type['company_addressTh']))? htmlentities($member_type['company_addressTh']) : ""; ?>" readonly>
                </div>
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>รหัสไปรษณีย์ (ภาษาอังกฤษ)</p>
                    <input type="text" class="input-sso sso-input" name="company_postcodeEn" id="company_postcodeEn" placeholder="<?php echo lang('edit_contact_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"   value="<?php echo (!empty($member_type['company_postcodeEn']))? htmlentities($member_type['company_postcodeEn']) : ""; ?>">
                    <div class="dropdown-menu dropdown_addr" id="dropdown_company_postcodeEn">
                    </div>
                </div>
                <div class="col-sm-4 text-left detail-sso companyProvinceEn"> 
                    <p>จังหวัด (ภาษาอังกฤษ)</p>
                        <select  class="input-sso" title="<?php echo lang('edit_contact_province'); ?>" name="company_provinceEn" id="company_provinceEn" style="font-size: 19px;padding: 1px 18px;"></select>
                        <!-- <input type="text" class="input-sso sso-input" name="company_provinceEn" id="company_provinceEn" placeholder="<?php echo lang('edit_contact_province'); ?>" value="<?php echo (!empty($member_type['company_provinceEn']))? htmlentities($member_type['company_provinceEn']) : ""; ?>" > -->
                </div>
                <div class="col-sm-4 text-left detail-sso companyDistrictEn"> 
                    <p>อำเภอ (ภาษาอังกฤษ)</p>
                        <select  class="input-sso" title="<?php echo lang('edit_contact_district'); ?>" name="company_districtEn" id="company_districtEn" style="font-size: 19px;padding: 1px 18px;"></select>
                        <!-- <input type="text" class="input-sso sso-input" name="company_districtEn" id="company_districtEn" placeholder="<?php echo lang('edit_contact_district'); ?>" value="<?php echo (!empty($member_type['company_districtEn']))? htmlentities($member_type['company_districtEn']) : ""; ?>" > -->
                </div>
                <div class="col-sm-4 text-left detail-sso companySubdistrictEn"> 
                    <p>ตำบล (ภาษาอังกฤษ)</p>
                        <select  class="input-sso" title="<?php echo lang('edit_contact_subdistrict'); ?>" name="company_subdistrictEn" id="company_subdistrictEn" style="font-size: 19px;padding: 1px 18px;"></select>
                        <!-- <input type="text" class="input-sso sso-input" name="company_subdistrictEn" id="company_subdistrictEn" placeholder="<?php echo lang('edit_contact_subdistrict'); ?>" value="<?php echo (!empty($member_type['company_subdistrictEn']))? htmlentities($member_type['company_subdistrictEn']) : ""; ?>" > -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>ที่อยู่นิติบุคคล(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="company_addressEn" id="company_addressEn" placeholder="<?php echo lang('edit_company_addressEn'); ?>" value="<?php echo (!empty($member_type['company_addressEn']))? htmlentities($member_type['company_addressEn']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <!-- <div class="col-sm-4 text-left detail-sso director_status"> 
                    <p>ฐานะ :</p>
                    <select class="input-sso" title="<?php echo lang('edit_director_status'); ?>"
                        tabindex="-98" name="director_status" id="director_status" placeholder="<?php echo lang('edit_director_status'); ?>" style="width: 90%!important;color: #404040 !important;border-radius: 8px !important;height: 48px !important;border: 1px solid #A6ACB6 !important;background-color: #ffffff !important;border: 0.5px solid #A6ACB6 !important; font-size: 19px;padding: 1px 18px;">
                        <option value=""><?php echo lang('edit_director_status'); ?></option>
                        <option value="1"><?php echo lang('director_status_1'); ?></option>
                        <option value="2"><?php echo lang('director_status_2'); ?></option>
                    </select>
                </div> -->
                <!-- /.col -->
                <div class="col-sm-12  text-left detail-sso">
                   <?php if (($member_type['director_status'] == 2) && $member['status_contact_nationality'] == 1): ?>
                            <p class="sso-title">ข้อมูลส่วนตัว (ผู้รับมอบอำนาจ) (ไทย)</p>
                    <?php endif ?>
                    <?php if (($member_type['director_status'] == 2) && $member['status_contact_nationality'] == 2): ?>
                            <p class="sso-title">ข้อมูลส่วนตัว (ผู้รับมอบอำนาจ) (ต่างชาติ)</p>
                    <?php endif ?>
                     <?php if (($member_type['director_status'] == 1)  && $member['status_contact_nationality'] == 1 ): ?>
                            <p class="sso-title">ข้อมูลส่วนตัว (กรรมการ) (ไทย)</p>
                    <?php endif ?>
                    <?php if (($member_type['director_status'] == 1)  && $member['status_contact_nationality'] == 2 ): ?>
                            <p class="sso-title">ข้อมูลส่วนตัว (กรรมการ) (ต่างชาติ)</p>
                    <?php endif ?>
                </div>
                <div class="col-sm-2">
                    <p class="sso-radio pointer" style="font-size: 16px !important;"> <?php echo lang('director_status_1'); ?>    
                        <input class="ck_address" type="radio" role="button" name="director_status_1" id="director_status_1"  value="1" placeholder="<?php echo lang('director_status_1'); ?>"  style="top: 0% !important;left: 0% !important;">
                        <span class="checkmarks" id="checkmark_1"></span>
                    </p>
                </div>
                <div class="col-sm-2">
                    <p class="sso-radio pointer" style="font-size: 16px !important;"> <?php echo lang('director_status_2'); ?>
                        <input class="ck_address" type="radio" role="button" name="director_status_2" id="director_status_2"  value="2" placeholder="<?php echo lang('director_status_2'); ?>" style="top: 0% !important;left: 0% !important;">
                        <span class="checkmarks" id="checkmark_2"></span>
                    </p>
                </div> 
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-12  text-left detail-sso">
                    <p>โปรดระบุสัญชาติ</p>
                </div>
                <div class="col-sm-2">
                    <p class="sso-radio pointer" style="font-size: 16px !important;" value="1" id="national_thai"> <?php echo lang('regis_nationality_checkbox1'); ?>    
                        <input class="ck_address" type="radio" role="button" name="ck_national_thai" id="ck_national_thai"  value="1" placeholder="<?php echo lang('regis_nationality_checkbox1'); ?>"  style="top: 0% !important;left: 0% !important;">
                        <span class="checkmarks" id="checkmark_3"></span>
                    </p>
                </div>
                <div class="col-sm-2">
                    <p class="sso-radio pointer" style="font-size: 16px !important;" value="2" id="foreigner"> <?php echo lang('regis_nationality_checkbox2'); ?>
                        <input class="ck_address" type="radio" role="button" name="ck_national_foreigner" id="ck_national_foreigner"  value="2" placeholder="<?php echo lang('regis_nationality_checkbox2'); ?>" style="top: 0% !important;left: 0% !important;">
                        <span class="checkmarks" id="checkmark_4"></span>
                    </p>
                </div> 
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2  text-left detail-sso member_title">
                    <p>คำนำหน้า :</p>
                    <select class="input-sso" title="<?php echo lang('edit_member_title'); ?>"
                        tabindex="-98" name="member_title" id="member_title" placeholder="<?php echo lang('edit_member_title'); ?>" style="width: 90%!important;color: #404040 !important;border-radius: 8px !important;height: 48px !important;border: 1px solid #A6ACB6 !important;background-color: #ffffff !important;border: 0.5px solid #A6ACB6 !important; font-size: 19px;padding: 1px 18px;">
                        <option value="นาย"><?php echo lang('edit_Mr'); ?></option>
                        <option value="นาง"><?php echo lang('edit_Mrs'); ?></option>
                        <option value="นางสาว"><?php echo lang('edit_Ms'); ?></option>
                    </select>
                </div>

                <!-- /.col -->
                <div class="col-sm-3-5  text-left detail-sso" id="div_nameTh">
                    <p>ชื่อ :</p>
                    <input type="text" class="input-sso sso-input" name="member_nameTh" id="member_nameTh" placeholder="<?php echo lang('edit_member_nameTh'); ?>" value="<?php echo (!empty($member_type['member_nameTh']))? htmlentities($member_type['member_nameTh']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-2-5  text-left detail-sso" id="div_midnameTh">
                    <p>ชื่อกลาง :</p>
                    <input type="text" class="input-sso sso-input" name="member_midnameTh" id="member_midnameTh" placeholder="<?php echo lang('edit_member_midnameTh'); ?>" value="<?php echo (!empty($member_type['member_midnameTh']))? htmlentities($member_type['member_midnameTh']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-2-5 text-left detail-sso" id="div_lastnameTh"> 
                    <p>นามสกุล :</p>
                    <input type="text" class="input-sso sso-input" name="member_lastnameTh" id="member_lastnameTh" placeholder="<?php echo lang('edit_member_lastnameTh'); ?>" value="<?php echo (!empty($member_type['member_lastnameTh']))? htmlentities($member_type['member_lastnameTh']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso" id="div_nameEn">
                    <p>ชื่อ(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="member_nameEn" id="member_nameEn" placeholder="<?php echo lang('edit_member_nameEn'); ?>" value="<?php echo (!empty($member_type['member_nameEn']))? htmlentities($member_type['member_nameEn']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso" id="div_midnameEn">
                    <p>ชื่อกลาง(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="member_midnameEn" id="member_midnameEn" placeholder="<?php echo lang('edit_member_midnameEn'); ?>" value="<?php echo (!empty($member_type['member_midnameEn']))? htmlentities($member_type['member_midnameEn']) : ""; ?>" >
                </div>                
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso" id="div_lastnameEn"> 
                    <p>นามสกุล(ภาษาอังกฤษ) :</p>
                    <input type="text" class="input-sso sso-input" name="member_lastnameEn" id="member_lastnameEn" placeholder="<?php echo lang('edit_member_lastnameEn'); ?>" value="<?php echo (!empty($member_type['member_lastnameEn']))? htmlentities($member_type['member_lastnameEn']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <!-- <?php if ($member['status_laser_verify'] == 0): ?>
                    <div class="col-sm-4 text-left detail-sso"> 
                    <p>วันเดือนปีเกิด :</p>
                    <input type="date" class="input-sso sso-input" name="member_birthday" id="member_birthday" placeholder="<?php echo lang('edit_member_birthday'); ?>" value="<?php echo (!empty($member_type['member_birthday']))? htmlentities($member_type['member_birthday']) : ""; ?>" >
                </div>
                <?php endif ?> -->
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <?php if ($member['status_contact_nationality'] == 1 ): ?>
                         <p id="ck_cid">เลขบัตรประชาชน : <a id="a_name_laser">&nbsp;<i class="<?php echo htmlentities($status_laser['icon_laser'])?>" id="cid_laser" style="color: <?php echo htmlentities($status_laser['icon_color_laser'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_laser['status_name_laser'])?></a></p>
                    <?php endif ?>
                    <?php if ($member['status_contact_nationality'] == 2 ): ?>
                         <p id="ck_cid">พาสปอร์ต : <a id="a_name_laser"></a></p>
                    <?php endif ?>
                    <input type="text" class="input-sso sso-input" name="member_cid" id="member_cid" placeholder="<?php echo lang('edit_member_cid'); ?>" value="<?php echo (!empty($member_type['member_cid']))? htmlentities($member_type['member_cid']) : ""; ?>" >
                    <input type="hidden" id="icon_laser" value="<?php echo htmlentities($status_laser['icon_laser'])?>">
                    <input type="hidden" id="icon_color_laser" value="<?php echo htmlentities($status_laser['icon_color_laser'])?>">
                    <input type="hidden" id="status_name_laser" value="&nbsp;&nbsp;<?php echo htmlentities($status_laser['status_name_laser'])?>">
                    <input type="hidden" id="status_contact" value="<?php echo htmlentities($member['status_contact_nationality'])?>">
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>อีเมล : <a>&nbsp;<i class="<?php echo htmlentities($status_email['icon_email'])?>" style="color: <?php echo htmlentities($status_email['icon_color_email'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_email['status_name_email'])?></a></p>
                    <input type="text" class="input-sso sso-input" name="member_email" id="member_email" placeholder="<?php echo lang('edit_member_email'); ?>" value="<?php echo (!empty($member_type['member_email']))? htmlentities($member_type['member_email']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>หมายเลขโทรศัพท์ : <a>&nbsp;<i class="<?php echo htmlentities($status_sms['icon_sms'])?>" style="color: <?php echo htmlentities($status_sms['icon_color_sms'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_sms['status_name_sms'])?></a></p>
                    <input type="text" class="input-sso sso-input" name="member_tel" id="member_tel" placeholder="<?php echo lang('edit_member_tel'); ?>" value="<?php echo (!empty($member_type['member_tel']))? htmlentities($member_type['member_tel']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-12  text-left detail-sso">
                   <p class="sso-title">ข้อมูลที่อยู่ติดต่อ</p>
                </div>
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>รหัสไปรษณีย์ </p>
                    <input type="text" class="input-sso sso-input" name="contact_postcode" id="contact_postcode" placeholder="<?php echo lang('edit_contact_postcode'); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"   value="<?php echo (!empty($member_type['contact_postcode']))? htmlentities($member_type['contact_postcode']) : ""; ?>" >
                    <div class="dropdown-menu dropdown_addr" id="dropdown_contact_postcode" style="top: 0px !important;">
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso Province"> 
                    <p>จังหวัด </p>
                        <select  class="input-sso" title="<?php echo lang('edit_contact_province'); ?>" name="contact_province" id="contact_province" style="font-size: 19px;padding: 1px 18px;"></select>
                        <!-- <input type="text" class="input-sso sso-input" name="contact_province" id="contact_province" placeholder="<?php echo lang('edit_contact_province'); ?>" value="<?php echo (!empty($member_type['contact_province']))? htmlentities($member_type['contact_province']) : ""; ?>" > -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso District"> 
                    <p>อำเภอ </p>
                    <select  class="input-sso" title="<?php echo lang('edit_contact_district'); ?>" name="contact_district" id="contact_district" style="font-size: 19px;padding: 1px 18px;"></select>
                    <!-- <input type="text" class="input-sso sso-input" name="contact_district" id="contact_district" placeholder="<?php echo lang('edit_contact_district'); ?>" value="<?php echo (!empty($member_type['contact_district']))? htmlentities($member_type['contact_district']) : ""; ?>" > -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso Subdistrict"> 
                    <p>ตำบล </p>
                    <select  class="input-sso" title="<?php echo lang('edit_contact_subdistrict'); ?>" name="contact_subdistrict" id="contact_subdistrict" style="font-size: 19px;padding: 1px 18px;"></select>
                    <!-- <input type="text" class="input-sso sso-input" name="contact_subdistrict" id="contact_subdistrict" placeholder="<?php echo lang('edit_contact_subdistrict'); ?>" value="<?php echo (!empty($member_type['contact_subdistrict']))? htmlentities($member_type['contact_subdistrict']) : ""; ?>" > -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left detail-sso">
                    <p>ที่อยู่ </p>
                    <input type="text" class="input-sso sso-input" name="contact_address" id="contact_address" placeholder="<?php echo lang('edit_contact_address'); ?>" value="<?php echo (!empty($member_type['contact_address']))? htmlentities($member_type['contact_address']) : ""; ?>" >
                </div>
        </div><!-- /.row -->
        <input type="hidden" name="select_company_provinceEn" id="select_company_provinceEn" value = "<?php echo htmlentities($member_type['company_provinceEn']); ?>">
        <input type="hidden" name="select_company_districtEn" id="select_company_districtEn" value = "<?php echo htmlentities($member_type['company_districtEn']); ?>">
        <input type="hidden" name="select_company_subdistrictEn" id="select_company_subdistrictEn" value = "<?php echo htmlentities($member_type['company_subdistrictEn']); ?>">
        <input type="hidden" name="select_province" id="select_province" value = "<?php echo htmlentities($member_type['contact_province']); ?>">
        <input type="hidden" name="select_district" id="select_district" value = "<?php echo htmlentities($member_type['contact_district']); ?>">
        <input type="hidden" name="select_subdistrict" id="select_subdistrict" value = "<?php echo htmlentities($member_type['contact_subdistrict']); ?>">
        <input type="hidden" name="select_title" id="select_title" value = "<?php echo htmlentities($member_type['member_title']); ?>">
        <input type="hidden" name="select_director_status" id="select_director_status" value = "<?php echo htmlentities($member_type['director_status']); ?>">
        <input type="hidden" name="select_contact_nationality" id="select_contact_nationality" value = "<?php echo htmlentities($member['status_contact_nationality']); ?>">
        <input type="hidden" name="type" id="type" value = "<?php echo htmlentities($member['type']); ?>">
        <input type="hidden" name="member_id"  id="member_id" value = "<?php echo htmlentities($member['member_id']); ?>">
    </div>
      <!-- end of container-fluid 1 -->
</div>

