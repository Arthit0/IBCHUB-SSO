$(document).ready(function () {
    $.ajax({
        url: BASE_URL + _INDEX + "register/get_provinces",
        method: "post",
        data: '',
        success: function (result) {
            $.each(result, function (key, value) {
                $(`#form_reg_people [name^="provinceTh"]`).append(`<option value="${value.id}">${value.name_th}</option>`);
            });
            $('.selectpicker').selectpicker('refresh');
        }
    });
})

const change_district_people =(obj)=>{
    $(`#form_reg_people [name^="subdistrictTh"]`).find('option').remove();
    $(`#form_reg_people [name^="subdistrictTh"]`).html(`<option value="">กรุณาเลือกอำเภอ</option>`);
    $('.selectpicker').selectpicker('refresh');
    $(`#form_reg_people [name^="postcode"]`).val('');


    var id = obj.val();
    console.log(id)
    //console.log(id)
    $.ajax({
        url: BASE_URL + _INDEX + "register/get_districts",
        method: "post",
        data: "id=" + id,
        success: function (result) {
            //console.log(result)
            $.each(result, function (key, value) {
                //console.log(value)
                $(`#form_reg_people [name^="subdistrictTh"]`).append(`<option value="${value.id}">${value.name_th}</option>`);
            });
            $('.selectpicker').selectpicker('refresh');

            let select_subdistrict = $("#form_reg_people [name='subdistrictTh']").val();
            let option_subdistrict = $("#form_reg_people [name='subdistrictTh'] option");
            $.each(option_subdistrict, function (index, item) {
                if ($(item).html() == select_subdistrict) {
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');
                    return false;
                }
            });
        }
    });
}

const change_province_people = (obj) => {
    $(`#form_reg_people [name="districtTh"]`).find('option').remove();
    $(`#form_reg_people [name="subdistrictTh"]`).find('option').remove();
    $(`#form_reg_people [name="postcode"]`).val('');

    var id = obj.val();
    console.log('in change' + id);
    //console.log(id)
    $.ajax({
        url: BASE_URL + _INDEX + "register/get_amphures",
        method: "post",
        data: "id=" + id,
        success: function (result) {
            $.each(result, function (key, value) {
                $(`#form_reg_people [name="districtTh"]`).append(`<option value="${value.id}">${value.name_th}</option>`);
            });
            $('.selectpicker').selectpicker('refresh');
            
            let select_district = $("#form_reg_people [name='districtTh']").val();
            let option_district = $("#form_reg_people [name='districtTh'] option");
            $.each(option_district, function (index, item) {
                if ($(item).html() == select_district) {
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');
                    return false;
                }
            });

            // store data option to sub_districe
            change_district_people($(`[name^="districtTh"]`))
        }
    });
}

/********** On Change Province จังหวัด ***********/
$(`#form_reg_people [name^="provinceTh"]`).on('change', function () {
    change_province_people($(this));
})


/********** On Change amphures อำเภอ ***********/
$(`#form_reg_people [name^="districtTh"]`).on('change', function () {
    change_district_people($(this));
})

/********** On Change districe ตำบล ***********/
$(`#form_reg_people [name^="subdistrictTh"]`).on('change', function () {
    var id = $(this).val();

    $.ajax({
        url: BASE_URL + _INDEX + "register/get_zipcode",
        method: "post",
        data: "id=" + id,
        success: function (result) {
            //console.log(result[0].zip_code)
            $(`#form_reg_people [name^="postcode"]`).val(result[0].zip_code);

        }
    });
})
