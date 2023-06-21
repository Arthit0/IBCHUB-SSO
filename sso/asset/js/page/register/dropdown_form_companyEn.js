$(document).ready(function () {
    $.ajax({
        url: BASE_URL + _INDEX + "register/get_provinces",
        method: "post",
        beforeSend: function(){
            $('.modal-spin').modal('show');
        },
        data: '',
        success: function (result) {
            $.each(result, function (key, value) {
                $(`#form_reg_noncompany [name^="company_provinceEn"]`).append(`<option value="${value.id}">${value.name_en}</option>`);
            });
            $('.selectpicker').selectpicker('refresh');
        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
})

const change_district_com =(obj)=>{
    $(`#form_reg_company [name^="company_subdistrictEn"]`).find('option').remove();
    $(`#form_reg_company [name^="company_subdistrictEn"]`).html(`<option value="">กรุณาเลือกอำเภอ</option>`);
    $('.selectpicker').selectpicker('refresh');
    // $(`#form_reg_company [name^="company_postcode"]`).val('');

    var id = obj.val();
    console.log(id)
    //console.log(id)
    $.ajax({
        url: BASE_URL + _INDEX + "register/get_districts",
        method: "post",
        beforeSend: function(){
            $('.modal-spin').modal('show');
        },
        data: "id=" + id,
        success: function (result) {
            //console.log(result)
            $.each(result, function (key, value) {
                //console.log(value)
                $(`#form_reg_company [name^="company_subdistrictEn"]`).append(`<option value="${value.id}">${value.name_en}</option>`);
            });
            $('.selectpicker').selectpicker('refresh');

            let select_subdistrict = $("#form_reg_company [name='company_subdistrictEn']").val();
            let option_subdistrict = $("#form_reg_company [name='company_subdistrictEn'] option");
            $.each(option_subdistrict, function (index, item) {
                if ($(item).html() == select_subdistrict) {
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');
                    return false;
                }
            });
            var thdistrict = $("#form_reg_company [name='companyTH_districts']").val()
            if(thdistrict != id){
                $("#form_reg_company [name='companyTH_districts']").val(id).change();
            }
            $("#form_reg_company [name='companyTH_district']").val(id).change();
        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
}

const change_province_com = (obj) => {
    $(`#form_reg_company [name="company_districtEn"]`).find('option').remove();
    $(`#form_reg_company [name="company_subdistrictEn"]`).find('option').remove();
    $(`#form_reg_company [name^="company_subdistrictEn"]`).html(`<option value="">กรุณาเลือกอำเภอ</option>`);
    // $(`#form_reg_company [name="company_postcode"]`).val('');

    var id = obj.val();
    console.log('in change' + id);
    //console.log(id)
    $.ajax({
        url: BASE_URL + _INDEX + "register/get_amphures",
        method: "post",
        beforeSend: function(){
            $('.modal-spin').modal('show');
        },
        data: "id=" + id,
        success: function (result) {
            $.each(result, function (key, value) {
                $(`#form_reg_company [name="company_districtEn"]`).append(`<option value="${value.id}">${value.name_en}</option>`);
            });
            $('.selectpicker').selectpicker('refresh');
            
            let select_district = $("#form_reg_company [name='company_districtEn']").val();
            let option_district = $("#form_reg_company [name='company_districtEn'] option");
            $.each(option_district, function (index, item) {
                if ($(item).html() == select_district) {
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');
                    return false;
                }
            });
    
            // store data option to sub_districe
            var thprovince = $("#form_reg_company [name='companyTH_province']").val()
            if(thprovince != id){
                $("#form_reg_company [name='companyTH_province']").val(id).change();
            }
            change_district_com($(`[name^="company_districtEn"]`))
        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
}

/********** On Change Province จังหวัด ***********/
$(`#form_reg_company [name^="company_provinceEn"]`).on('change', function () {
    change_province_com($(this));
})


/********** On Change amphures อำเภอ ***********/
$(`#form_reg_company [name^="company_districtEn"]`).on('change', function () {
    change_district_com($(this));
})

/********** On Change districe ตำบล ***********/
$(`#form_reg_company [name^="company_subdistrictEn"]`).on('change', function () {
    var id = $(this).val();

    $.ajax({
        url: BASE_URL + _INDEX + "register/get_zipcode",
        method: "post",
        beforeSend: function(){
            $('.modal-spin').modal('show');
        },
        data: "id=" + id,
        success: function (result) {
            //console.log(result[0].zip_code)
            $(`#form_reg_company [name^="company_postcodeEn"]`).val(result[0].zip_code);

            var thprovince = $("#form_reg_company [name='companyTH_subdistricts']").val()
            if(thprovince != id){
                $("#form_reg_company [name='companyTH_subdistricts']").val(id).change();
            }
        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
})
