<?php
$lang = 'th';
if (!empty($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
//include ('component/menu.php');
include ('component/header.php');
?>
<style>
    .col-sm-3-5 {
    -ms-flex: 0 0 30%;
    flex: 0 0 30%;
    max-width: 30%;
}
.col-sm-2-5 {
    -ms-flex: 0 0 26%;
    flex: 0 0 26.5%;
    max-width: 26.5%;
}
  .loader_input {
    position: relative;
  }
  input:read-only {
  box-sizing: border-box;
  width: 90%!important;
  height: 48px!important;
  left: 357px!important;
  top: 269px!important;
  background: #F0F1F2!important;
  border: 0.5px solid #A6ACB6!important;
  border-radius: 8px!important;
}
.input-sso {
  box-sizing: border-box;
  width: 90%!important;
  height: 48px!important;
  left: 357px!important;
  top: 269px!important;
  border: 0.5px solid #A6ACB6!important;
  border-radius: 8px!important;;
}
  .sso-text-pass{
    font-family: 'IBM Plex Sans Thai Looped';
    font-style: normal;
  }
  .container-fluid{
    width: 98%;
    padding-right: 20.5px;
    padding-left: 20.5px;
    margin-right: auto;
    margin-left: auto;
  }

  .sso-input{
    height: 48px;
    object-fit: contain;
    border-radius: 24px;
    border: solid 1px #629cc1;
    background-color: #ffffff;
    padding: 22px 25px;
    width:100%;
    outline: 0;
    font-size: 20px;
  }
  .sso-input:focus {
    border-color: dodgerBlue;
    box-shadow: 0 0 8px 0 dodgerBlue;
  }
  .sso-row{
    padding:5px;
  }
  .sso-section{
    border-radius: 10px;
    box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.3);
    background-color: #ffffff;
    padding:20px;
  }

  .sso-btn-edit:hover{
    color:white;
  }
  .sso-btn-pass:hover{
    color:white;
  }
  .sso-btn-backs {
  /* font-family: 'IBM Plex Sans Thai Looped', sans-serif;
  border-radius: 8px;
  background-color: #6F7887;
  border: 0px;
  color: white;
  width: max-content;
  font-size: 16px;
  font-weight: 500;
  mix-blend-mode: normal; */

  font-family: 'IBM Plex Sans Thai Looped', sans-serif;
  color: white;
  width: 120px;
  font-size: 16px;
  font-weight: 500;
  mix-blend-mode: normal;
  width: 162px;
  height: 48px;
  background: #6F7887;
  border-radius: 8px;
  padding: 13px 19px;
}

  .sso-btn-backs:hover{
    color:white;
  }
  .sso-hr{
    width:95%;
    background-color:#629cc1;
  }
  .btn-danger-delete{
    border-radius: 8px;
    border:0px;
    background-color: #c82333;
    color:white !important;
    width: 120px;
    font-size: 16px;
  }
  .btn-danger-delete:hover{
    color:white !important;
  }
  .title-dropdown{
    width: 90%!important
  }
  .detail-sso{
    margin-top: 31px;
  }
  .dropdown-menu.show {
		overflow: scroll;
    top:0px !important;
	}
  .sso-radio {
    display: block;
    position: relative;
    padding-left: 24px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}


/* Hide the browser's default radio button */

.sso-radio input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}


/* Create a custom radio button */

.checkmarks {
    position: absolute;
    top: 50%;
    left: 0%;
    transform: translate(0%, -50%);
    height: 20px;
    width: 20px;
    background-color: #ffff;
    border-radius: 50%;
    border: 1px solid #cfcfcf;
}
/* On mouse-over, add a grey background color */

.sso-radio:hover input ~ .checkmarks {
    background-color: #ccc;
}


/* When the radio button is checked, add a blue background */

.sso-radio input:checked ~ .checkmarks {
    background-color: #ffff;
}


/* Create the indicator (the dot/circle - hidden when not checked) */

.checkmarks:before {
    content: "";
    position: absolute;
    display: none;
}


/* Show the indicator (dot/circle) when checked */

.sso-radio input:checked ~ .checkmarks:before {
    display: block;
}
.checkmarked  {
    width: 10px !important;
    height: 10px !important;
    border-radius: 50% !important;
    background: #7ed321 !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
}

/* Style the indicator (dot/circle) */

.sso-radio .checkmarks:before  {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #7ed321;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@media screen and (max-width: 397px) {
    .checkmarks {
        top: 50%;
    }

    .sso-radio .checkmarks:before {
        width: 8px;
        height: 8px;
    }

    .checkmarks {
        height: 15px;
        width: 15px;
    }
}

/* end sso radio */
 </style>
<div class="wrapper">
<?php 
  include ('component/nav.php'); 
  include ('component/menu_lte.php'); 
?>
    <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">

       <form id="form_edit_member" method="post" enctype="multipart/form-data">
      
       <div class="row">
        <div class="col-6 text-left">
          <h2 class="ibm-sb _f20 p-4"><?php echo $title ?></h2>
        </div>
       </div>
      <?php
        if($member['type'] == 1){ //นิติบุคคลไทย
          include ('component/type_1.php');
        }else if($member['type'] == 2){ //นิติบุคคลต่างชาติ
          include ('component/type_2.php');
        }else if($member['type'] == 3){ //บุคคลไทย 
          include ('component/type_3.php');
        }else if($member['type'] == 4){ //บุคคลต่างชาติ
          include ('component/type_4.php');
        }if($member['type'] == 5){ //บุคคลต่างชาติ
          include ('component/type_5.php');
        }if($member['type'] == 6){ //นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
          include ('component/type_6.php');
        }
        if($member[0]['UserType'] == "corporate" ){ //นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
          include ('component/corporate_Y.php');
        }else if($member[0]['UserType'] == "person"){ //นิติบุคคลไทยนิติบุคคลที่ไม่ได้จดทะเบียนกับกรมพัฒนาธุรกิจการค้า
          include ('component/person_Y.php');
        }
      ?>  
      <br>
      <div class="row">
          <div class="row d-inline-flex align-items-center mb-2 w-100">
                <div class="col-sm-2  text-left">
                </div>
                <!-- /.col -->
                <div class="col-sm-8  text-center">
                   <?php if (!empty($member[0]['UserType'])): ?>
                    <a href="<?php echo BASE_PATH; ?>office/user?type=1" class="btn sso-btn-backs">ย้อนกลับ</a>
                  <?php endif ?>
                  <?php if (!empty($member['type'])): ?>
                    <a href="<?php echo BASE_PATH; ?>office/detail_member?type=<?php echo $member['type'] ?>&id=<?php echo $member['member_id'] ?>" class="btn sso-btn-backs">ย้อนกลับ</a>
                  <?php endif ?>
                    <button class="btn sso-btn-save" type="submit">บันทึก</button>
                </div>
                <div class="col-sm-2  text-left">
                </div>
          </div>
        <!-- <div class="col-12 my-3 text-center d-inline-flex align-items-center justify-content-center">
        </div> -->
      </div>
    </form>
      </div>
    </div>
      </div>
</div>
<!-- Footer -->
  </div>
</div>
<script src="<?php echo BASE_PATH; ?>asset/js/page/office/user_manage.js"></script>
    <script>
          let director_status =  $(`#select_director_status`).val();
          let contact_nationality =  $(`#select_contact_nationality`).val();
          if(director_status === '1'){
            $('#director_status_1').prop('checked', true);
          }else if(director_status === '2'){
            $('#director_status_2').prop('checked', true);
          }    
          if(contact_nationality === '1'){
            $('#ck_national_thai').prop('checked', true);
          }else if(contact_nationality === '2'){
            $('#ck_national_foreigner').prop('checked', true);
          }
         if(contact_nationality === '2'){
            var div_nameTh = document.getElementById("div_nameTh");
            var div_midnameTh = document.getElementById("div_midnameTh");
            var div_lastnameTh = document.getElementById("div_lastnameTh");
            var div_nameEn = document.getElementById("div_nameEn");
            var div_midnameEn = document.getElementById("div_midnameEn");
            var div_lastnameEn = document.getElementById("div_lastnameEn");
            div_nameEn.classList.remove("col-sm-4");
            div_nameEn.classList.add("col-sm-3-5");
            div_midnameEn.classList.remove("col-sm-4");
            div_midnameEn.classList.add("col-sm-2-5");
            div_lastnameEn.classList.remove("col-sm-4");
            div_lastnameEn.classList.add("col-sm-2-5");
            div_nameTh.style.display = "none";
            div_midnameTh.style.display = "none";
            div_lastnameTh.style.display = "none";
          }

          var country =  $(`#select_country`).val();
          var province =  $(`#select_province`).val();
          var district =  $(`#select_district`).val();
          var subdistrict =  $(`#select_subdistrict`).val();
          var company_provinceEn =  $(`#select_company_provinceEn`).val();
          var company_districtEn =  $(`#select_company_districtEn`).val();
          var company_subdistrictEn =  $(`#select_company_subdistrictEn`).val();
          var noncompany_provinceTh =  $(`#select_noncompany_provinceTh`).val();
          var noncompany_districtTh =  $(`#select_noncompany_districtTh`).val();
          var noncompany_subdistrictTh =  $(`#select_noncompany_subdistrictTh`).val();
          $.ajax({
            url:BASE_URL + _INDEX +"office/get_provinces",
            method: "post",
            data: '',
            success: function (result) {
                $(`#contact_province,#company_provinceEn,#noncompany_provinceTh`).empty();
              $.each(result, function (key, value) {
                if (result.lang === 'th') {
                    if(value.name_th != undefined){
                        $(`#contact_province`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                        $(`#company_provinceEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#noncompany_provinceTh`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                        $(`#provinceEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#provinceTh`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                    }
                } else {
                    if(value.name_en != undefined){
                        $(`#contact_province`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#company_provinceEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#noncompany_provinceTh`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                        $(`#provinceEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#provinceTh`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                    }
                }
                
              });
                setTimeout(function(){
                        $("div.companyProvinceTh select").val(noncompany_provinceTh).change();
                        $("div.companyProvinceEn select").val(company_provinceEn).change();
                        $("div.Province select").val(province).change();
                }, 600)
            }
          });

          $.ajax({
            url:BASE_URL + _INDEX +"office/get_amphures",
            method: "post",
            data: '',
            success: function (result) {
                $(`#contact_district,#company_districtEn,#noncompany_districtTh`).empty();
              $.each(result, function (key, value) {
                if (result.lang === 'th') {
                    if(value.name_th != undefined){
                        $(`#contact_district`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                        $(`#noncompany_districtTh`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                        $(`#company_districtEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#districtTh`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                        $(`#districtEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                    }
                } else {
                    if(value.name_en != undefined){
                        $(`#contact_district`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#noncompany_districtTh`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#company_districtEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#districtTh`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#districtEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                    }
                }
                
              });
                        // $('#contact_province').selectpicker('refresh');
                        $("div.companyDistrictTh select").val(noncompany_districtTh).change();
                        $("div.companyDistrictEn select").val(company_districtEn).change();
                        $("div.District select").val(district).change();
            }
          });

          $.ajax({
            url:BASE_URL + _INDEX +"office/get_districts",
            method: "post",
            beforeSend: function () {
                $('.modal-spin').modal('show');
              },
            data: '',
            success: function (result) {
                $(`#contact_subdistrict,#company_subdistrictEn,#noncompany_subdistrictTh,#subdistrictTh,#subdistrictEn`).empty();
              $.each(result, function (key, value) {
                if (result.lang === 'th') {
                    if(value.name_th != undefined){
                        $(`#contact_subdistrict`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                        $(`#subdistrictTh`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                        $(`#subdistrictEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#noncompany_subdistrictTh`).append('<option value="' + value.name_th + '">' + value.name_th + '</option>');
                        $(`#company_subdistrictEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                    }
                } else {
                    if(value.name_en != undefined){
                        $(`#subdistrictTh`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#subdistrictEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#noncompany_subdistrictTh`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#company_subdistrictEn`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                        $(`#contact_subdistrict`).append('<option value="' + value.name_en + '">' + value.name_en + '</option>');
                    }
                }
                
              });
                        // $('#contact_province').selectpicker('refresh');
                        $("div.companySubdistrictTh select").val(noncompany_subdistrictTh).change();
                        $("div.companySubdistrictEn select").val(company_subdistrictEn).change();
                        $("div.Subdistrict select").val(subdistrict).change();
            },complete: function () {
                $('.modal-spin').modal('hide');
              }
          });

        $.ajax({
            url:BASE_URL + _INDEX +"office/get_country",
            method: "GET",
            dataType: "text",
            success: function(result) {
                let results = JSON.parse(result);
                $(`#country`).empty();
                $.each(results, function(key, data) {
                    $('#country').append("<option class='country_name' value=" + data.CountryNameEN + ">" + data.CountryNameEN + "</option>");
                });
                setTimeout(function(){
                    $("div.Countrys select").val(country).change();
                }, 600)
            }
        });
    </script>

<?php include ('component/footer.php'); ?>