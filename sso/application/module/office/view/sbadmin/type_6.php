<!-- นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า -->
<div class="sso-section">
        <!-- row 1 --> 
        <div class="row">
          <div class="col-12">
            <div class="row sso-row">
              <div class="col-3 text-right"><h5>รหัส SSO (SSO ID)</h5></div>
              <div class="col-1"></div>
              <div class="col-6">
                <input class="sso-input" type="text" name="sso_id" autocomplete="off" placeholder=""
                value="<?php echo htmlentities($member['sso_id']); ?>" readonly>
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
                <input class="sso-input" type="text" name="naturalId" autocomplete="off" placeholder=""
                value="<?php echo htmlentities($member['cid']); ?>" required>
              </div>
            </div>
            
           
          </div>
        </div>
        <!-- end of row1 -->
      <hr class="sso-hr">

      <!-- row 2 --> 
      <div class="row">
        <div class="col-12">
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ชื่อบริษัท</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_nameTh" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_nameTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ที่อยู่</h5></h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_addressTh" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_addressTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>จังหวัด</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_provinceTh" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_provinceTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>อำเภอ</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_districtTh" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_districtTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ตำบล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_subdistrictTh" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_subdistrictTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>รหัสไปรษณีย์</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_postcodeTh" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_postcodeTh']); ?>">
            </div>
          </div>
          
        </div>
      </div>
      <!-- end of row2 -->
      <hr class="sso-hr">
      <!-- row 3 --> 
      <div class="row">
        <div class="col-12">
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Corparate name</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_nameEn" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_nameEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Address</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_addressEn" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_addressEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Province</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_provinceEn" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_provinceEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>District</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_districtEn" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_districtEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Sub district</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_subdistrictEn" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_subdistrictEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Postcode</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="company_postcodeEn" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['company_postcodeEn']); ?>">
            </div>
          </div>
          
        </div>
      </div>
      <!-- end of row3 -->
      <hr class="sso-hr">
      <!-- row 4 --> 
      <div class="row">
        <div class="col-12">
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ที่อยู่ติดต่อ</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <!--<input class="sso-input" type="text" name="ssoid" autocomplete="off" placeholder="">-->
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ที่อยู่</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="contact_address" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['contact_address']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>จังหวัด</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="contact_province" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['contact_province']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>อำเภอ</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="contact_district" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['contact_district']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ตำบล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="contact_subdistrict" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['contact_subdistrict']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>รหัสไปรษณีย์</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="contact_postcode" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['contact_postcode']); ?>">
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
            <div class="col-3 text-right"><h5>คำนำหน้าชื่อ / Title name</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_title" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['member_title']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>ชื่อ</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_nameTh" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['member_nameTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>นามสกุล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_lastnameTh" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['member_lastnameTh']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>First name</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_nameEn" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['member_nameEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>Last name</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_lastnameEn" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['member_lastnameEn']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>เลขบัตรประชาชน</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_cid" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['member_cid']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>อีเมล</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_email" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['member_email']); ?>">
            </div>
          </div>
          <div class="row sso-row">
            <div class="col-3 text-right"><h5>หมายเลขโทรศัพท์</h5></div>
            <div class="col-1"></div>
            <div class="col-6">
              <input class="sso-input" type="text" name="member_tel" autocomplete="off" placeholder=""
              value="<?php echo htmlentities($member_type['member_tel']); ?>">
            </div>
          </div>
          <input type="hidden" name="type" value = "<?php echo htmlentities($member['type']); ?>">
          <input type="hidden" name="member_id" value = "<?php echo htmlentities($member['member_id']); ?>">
        </div>
      </div>
      <!-- end of row5 -->
      </div>