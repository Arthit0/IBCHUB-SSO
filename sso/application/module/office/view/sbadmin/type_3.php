<!-- บุคคลไทย -->
      <div class="sso-section">
        <!-- row 1 --> 
        <div class="row">
          <div class="col-12">
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>รหัส SSO (SSO ID)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="sso_id" autocomplete="off" 
                placeholder="รหัส SSO (SSO ID)" value="<?php echo htmlentities($member['sso_id']); ?>" readonly>
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
                placeholder="เลขนิติบุคคล (Username)" value="<?php echo htmlentities($member['cid']); ?>" required>
              </div>
            </div>
           
          </div>
        </div>
        <!-- end of row1 -->
      <hr class="sso-hr">

      <!-- row 5 --> 
      <div class="row">
        <div class="col-12">
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>คำนำหน้าชื่อ</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_title" autocomplete="off" 
              placeholder="คำนำหน้าชื่อ" value="<?php echo htmlentities($member_type['member_title']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ชื่อ</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_nameTh" autocomplete="off" 
              placeholder="ชื่อ" value="<?php echo htmlentities($member_type['member_nameTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>นามสกุล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_lastnameTh" autocomplete="off" 
              placeholder="นามสกุล" value="<?php echo htmlentities($member_type['member_lastnameTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>First name</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_nameEn" autocomplete="off" 
              placeholder="First name" value="<?php echo htmlentities($member_type['member_nameEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Last name</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_lastnameEn" autocomplete="off" 
              placeholder="Last name" value="<?php echo htmlentities($member_type['member_lastnameEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>เลขบัตรประชาชน</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="cid" autocomplete="off" 
              placeholder="เลขบัตรประชาชน" value="<?php echo htmlentities($member['cid']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>อีเมล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="email" autocomplete="off" 
              placeholder="อีเมล" value="<?php echo htmlentities($member_type['email']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>หมายเลขโทรศัพท์</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="tel" autocomplete="off" 
              placeholder="หมายเลขโทรศัพท์" value="<?php echo htmlentities($member_type['tel']); ?>">
            </div>
          </div>
          
        </div>
      </div>
      <!-- end of row5 -->
      <hr class="sso-hr">

      <!-- row 4 --> 
      <div class="row">
        <div class="col-12">
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ที่อยู่</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="addressTh" autocomplete="off" 
              placeholder="ที่อยู่" value="<?php echo htmlentities($member_type['addressTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>จังหวัด</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="provinceTh" autocomplete="off" 
              placeholder="จังหวัด" value="<?php echo htmlentities($member_type['provinceTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>อำเภอ</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="districtTh" autocomplete="off" 
              placeholder="อำเภอ" value="<?php echo htmlentities($member_type['districtTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ตำบล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="subdistrictTh" autocomplete="off" 
              placeholder="ตำบล" value="<?php echo htmlentities($member_type['subdistrictTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>รหัสไปรษณีย์</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="postcode" autocomplete="off" 
              placeholder="รหัสไปรษณีย์" value="<?php echo htmlentities($member_type['postcode']); ?>">
            </div>
          </div>
          <input type="hidden" name="type" value = "<?php echo htmlentities($member['type']); ?>">
          <input type="hidden" name="member_id" value = "<?php echo htmlentities($member['member_id']); ?>">
        </div>
      </div>
      <!-- end of row4 -->

      </div>