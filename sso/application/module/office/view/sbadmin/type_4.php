<!-- บุคคลต่างชาติ -->

      <div class="sso-section">
        <!-- row 1 --> 
        <div class="row">
          <div class="col-12">
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>รหัส SSO (SSO ID)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="sso_id" autocomplete="off" 
                placeholder="" value="<?php echo htmlentities($member['sso_id']); ?>" readonly>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>วันที่สมัครสมาชิก</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="create_date" autocomplete="off" placeholder=""
                value="<?php echo htmlentities(date('d-m-Y H:i:s',strtotime($member['create_date']))); ?>" readonly>
              </div>
            </div>
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>เลขนิติบุคคล (Username)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="naturalId" autocomplete="off" 
                placeholder="" value="<?php echo htmlentities($member['cid']); ?>" required>
              </div>
            </div>
           
          </div>
        </div>
        <!-- end of row1 -->
      <hr class="sso-hr">

      <!-- row 4 --> 
      <div class="row">
        <div class="col-12">
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Country</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="country" autocomplete="off" 
              placeholder="" value="<?php echo htmlentities($member_type['country']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Corparate address</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="address" autocomplete="off" placeholder=""
              placeholder="" value="<?php echo htmlentities($member_type['address']); ?>">
            </div>
          </div>
        </div>
      </div>
      <!-- end of row4 -->
      <hr class="sso-hr">

      <!-- row 5 --> 
      <div class="row">
        <div class="col-12">
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Title Name</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_title" autocomplete="off" 
              placeholder="" value="<?php echo htmlentities($member_type['member_title']); ?>">
            </div>
          </div>
         
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>First name</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_nameEn" autocomplete="off" 
              placeholder="" value="<?php echo htmlentities($member_type['member_nameEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Last name</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_lastnameEn" autocomplete="off" 
              placeholder="" value="<?php echo htmlentities($member_type['member_lastnameEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>อีเมล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="email" autocomplete="off" 
              placeholder="" value="<?php echo htmlentities($member_type['email']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Tel</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="tel" autocomplete="off" 
              placeholder="" value="<?php echo htmlentities($member_type['tel']); ?>">
            </div>
          </div>
          <input type="hidden" name="type" value = "<?php echo htmlentities($member['type']); ?>">
          <input type="hidden" name="member_id" value = "<?php echo htmlentities($member['member_id']); ?>">
        </div>
      </div>
      <!-- end of row5 -->
      </div>