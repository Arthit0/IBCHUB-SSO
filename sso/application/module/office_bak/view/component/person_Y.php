<!-- นิติบุคคลไทย -->
    <div class="sso-section">
      <!-- row 2 --> 
      <div class="row">
        <div class="col-12">
          <div class="row sso-row">
              <div class="col-3 text-right"><h5>รหัส SSO (SSO ID)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="sso_id" autocomplete="off" placeholder=""
                value="ยังไม่ได้เป็นสมาชิก SSO" readonly>
              </div>
          </div>
          <div class="row sso-row">
                <div class="col-3 text-right"><h5>เลขนิติบุคคล (Username)</h5></div>
                <div class="col-1"></div>
                <div class="col-6">
                    <input class="sso-input" type="text" name="naturalId" autocomplete="off" placeholder=""
                    value="<?php echo htmlentities($member[0]['Username']); ?>" required>
                </div>
          </div>            
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ชื่อ</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_nameTh" autocomplete="off" 
              placeholder="ชื่อ" value="<?php echo htmlentities($member[0]['Firstname']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>นามสกุล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_lastnameTh" autocomplete="off" 
              placeholder="นามสกุล" value="<?php echo htmlentities($member[0]['LastName']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>อีเมล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">sadsd
              <input class="sso-input" type="text" name="member_email" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member[0]['Mail']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>หมายเลขโทรศัพท์</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_tel" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member[0]['Telephone']); ?>">
            </div>
          </div>
          <input type="hidden" name="type" value = "<?php echo htmlentities($member[0]['UserType']); ?>">
          <input type="hidden" name="member_id" value = "<?php echo htmlentities($member[0]['UserID']); ?>">
        </div>
      </div>
      <!-- end of row2 -->
      </div>