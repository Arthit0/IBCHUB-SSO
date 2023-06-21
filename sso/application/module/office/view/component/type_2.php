<!-- นิติบุคคลต่างชาติ -->
<div class="sso-section">
      <!-- container-fluid 1 --> 
     <div class="container-fluid">
        <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-12  text-left">
                   <p class="sso-title">Juristic Person Information</p>
                </div>
                <div class="col-sm-4 text-left">
                    <p>Corporate Number :</p>
                     <input type="text" class="input-sso sso-input" name="cid" id="cid" placeholder="<?php echo lang('edit_cid'); ?>" value="<?php echo (!empty($member['cid']))? htmlentities($member['cid']) : ""; ?>" >
                     <br>
                </div>
                <!-- /.col -->
                <div class="col-sm-4  text-left">
                    <p>Name of legal entity :</p>
                    <input type="text" class="input-sso sso-input" name="corporate_name" id="corporate_name" placeholder="<?php echo lang('edit_company_Th'); ?>" value="<?php echo (!empty($member_type['corporate_name']))? htmlentities($member_type['corporate_name']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-3-5 text-left Countrys"> 
                    <p>Country :</p>
                        <select  class="input-sso" title="Country" name="country" id="country" style="font-size: 19px;padding: 1px 18px;"></select>
                </div>
                <!-- /.col -->
                <div class="col-sm-2  text-left detail-sso member_title">
                    <p>Title :</p>
                    <select  class="input-sso" title="<?php echo lang('edit_member_title'); ?>" name="member_title" id="member_title" style="font-size: 19px;padding: 1px 18px;">
                        <option value="Mr.">Mr</option>
                        <option value="Mrs.">Mrs</option>
                        <option value="Miss">Ms</option>
                    </select>
                </div>
                <!-- /.col -->
                <div class="col-sm-3  text-left detail-sso">
                    <p>First Name :</p>
                    <input type="text" class="input-sso sso-input" name="member_nameEn" id="member_nameEn" placeholder="<?php echo lang('edit_member_nameEn'); ?>" value="<?php echo (!empty($member_type['member_nameEn']))? htmlentities($member_type['member_nameEn']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-2-5  text-left detail-sso">
                    <p>Mid Name :</p>
                    <input type="text" class="input-sso sso-input" name="member_midnameEn" id="member_midnameEn" placeholder="<?php echo lang('edit_member_nameEn'); ?>" value="<?php echo (!empty($member_type['member_midnameEn']))? htmlentities($member_type['member_midnameEn']) : ""; ?>" >
                </div>                
                <!-- /.col -->
                <div class="col-sm-2-5 text-left detail-sso"> 
                    <p>Last Name :</p>
                    <input type="text" class="input-sso sso-input" name="member_lastnameEn" id="member_lastnameEn" placeholder="<?php echo lang('edit_member_lastnameEn'); ?>" value="<?php echo (!empty($member_type['member_lastnameEn']))? htmlentities($member_type['member_lastnameEn']) : ""; ?>" >
                </div>
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>Email :<a>&nbsp;<i class="<?php echo htmlentities($status_email['icon_email'])?>" style="color: <?php echo htmlentities($status_email['icon_color_email'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_email['status_name_email'])?></a></p>
                    <input type="text" class="input-sso sso-input" name="email" id="email" placeholder="<?php echo lang('edit_member_email'); ?>" value="<?php echo (!empty($member_type['email']))? htmlentities($member_type['email']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-4 text-left detail-sso"> 
                    <p>Telephone Number :<a>&nbsp;<i class="<?php echo htmlentities($status_sms['icon_sms'])?>" style="color: <?php echo htmlentities($status_sms['icon_color_sms'])?>"></i>&nbsp;&nbsp;<?php echo htmlentities($status_sms['status_name_sms'])?></a></p>
                    <input type="text" class="input-sso sso-input" name="tel" id="tel" placeholder="<?php echo lang('edit_member_tel'); ?>" value="<?php echo (!empty($member_type['tel']))? htmlentities($member_type['tel']) : ""; ?>" >
                </div>
                <!-- /.col -->
                <div class="col-sm-12  text-left detail-sso">
                   <p class="sso-title">Contact Information</p>
                </div>
                <div class="col-sm-4  text-left detail-sso">
                    <p>Address :</p>
                    <textarea class="input-textarea"  name="address" id="address" autocomplete="off" placeholder="<?php echo lang('edit_contact_address'); ?>"><?php echo (!empty($member_type['address']))? htmlentities($member_type['address']) : ""; ?></textarea>
                </div>
        </div><!-- /.row -->
        <input type="hidden" name="select_country " id="select_country" value = "<?php echo htmlentities($member_type['country']); ?>">
        <input type="hidden" name="select_title" id="select_title" value = "<?php echo htmlentities($member_type['member_title']); ?>">
        <input type="hidden" name="type" id="type" value = "<?php echo htmlentities($member['type']); ?>">
        <input type="hidden" name="member_id"  id="member_id" value = "<?php echo htmlentities($member['member_id']); ?>">
    </div>
      <!-- end of container-fluid 1 -->
</div>