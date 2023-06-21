$(document).ready(function () {
    $.ajax({
        url: BASE_URL + _INDEX + "register/get_provinces",
        method: "post",
        data: '',
        success: function (result) {
            $.each(result, function (key, value) {
                $(`#form_reg_people [name^="province"]`).append(`<option value="${value.id}">${value.name_th}</option>`);
                
            });
            $('.selectpicker').selectpicker('refresh');
        }
    });
})

const change_district =(obj)=>{
    $(`#form_reg_company [name^="bus[subdistrict]"]`).find('option').remove();
    $(`#form_reg_company [name^="bus[subdistrict]"]`).html(`<option value="">กรุณาเลือกอำเภอ</option>`);
    $('.selectpicker').selectpicker('refresh');
    $(`#form_reg_company [name^="bus[postcode]"]`).val('');

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
                $(`#form_reg_company [name^="bus[subdistrict]"]`).append(`<option value="${value.id}">${value.name_th}</option>`);
                
            });
            $('.selectpicker').selectpicker('refresh');

            let select_subdistrict = $("#form_reg_company [name='subdistrict']").val();
            let option_subdistrict = $("#form_reg_company [name='bus[subdistrict]'] option");
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

const change_province = (obj) => {
    $(`#form_reg_company [name="bus[district]"]`).find('option').remove();
    $(`#form_reg_company [name="bus[subdistrict]"]`).find('option').remove();
    $(`#form_reg_company [name="bus[postcode]"]`).val('');

    var id = obj.val();
    console.log('in change' + id);
    //console.log(id)
    $.ajax({
        url: BASE_URL + _INDEX + "register/get_amphures",
        method: "post",
        data: "id=" + id,
        success: function (result) {
            $.each(result, function (key, value) {
                $(`#form_reg_company [name="bus[district]"]`).append(`<option value="${value.id}">${value.name_th}</option>`);
                
            });
            $('.selectpicker').selectpicker('refresh');
            
            let select_district = $("#form_reg_company [name='district']").val();
            let option_district = $("#form_reg_company [name='bus[district]'] option");
            $.each(option_district, function (index, item) {
                if ($(item).html() == select_district) {
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');
                    return false;
                }
            });

            // store data option to sub_districe
            change_district($(`[name^="bus[district]"]`))
        }
    });
}

/********** On Change Province จังหวัด ***********/
$(`#form_reg_company [name^="bus[province]"]`).on('change', function () {
    change_province($(this));
})


/********** On Change amphures อำเภอ ***********/
$(`#form_reg_company [name^="bus[district]"]`).on('change', function () {
    change_district($(this));
})

/********** On Change districe ตำบล ***********/
$(`#form_reg_company [name^="bus[subdistrict]"]`).on('change', function () {
    var id = $(this).val();

    $.ajax({
        url: BASE_URL + _INDEX + "register/get_zipcode",
        method: "post",
        data: "id=" + id,
        success: function (result) {
            //console.log(result[0].zip_code)
            $(`#form_reg_company [name^="bus[postcode]"]`).val(result[0].zip_code);

        }
    });
})

$(".radio_new_adress").click(function () {
    $("#form_reg_company input[name='bus[address]']").val('');
    $("#form_reg_company [name='bus[district]']").val('');
    $("#form_reg_company [name='bus[province]']").val('');
    $("#form_reg_company [name='bus[district]']").val('');
    $("#form_reg_company [name='bus[subdistrict]']").val('');
    $('.selectpicker').selectpicker('refresh');
});

const prop_dropdown =()=> {
    let select = $("#form_reg_company [name='province']").val();
    let option = $("#form_reg_company [name='bus[province]'] option");
    $.each(option, function (index, item) {
        if ($(item).html() == select) {
            console.log('select province');
            $(item).prop("selected", true);
            
            // store data to district
            change_province($(`#form_reg_company [name^="bus[province]"]`));

            $('.selectpicker').selectpicker('refresh');
            return false;
        }
    });

    $("#form_reg_company input[name='bus[address]']").val(
        $("#form_reg_company input[name='address']").val()
    );
}
$(".radio_old_adress").on('click',function() {

    // tranfer data to province
    prop_dropdown();

    /*$("#form_reg_company input[name='bus[province]']").val(
      $("#form_reg_company input[name='province']").val()
    );
    $("#form_reg_company input[name='bus[district]']").val(
      $("#form_reg_company input[name='district']").val()
    );
    $("#form_reg_company input[name='bus[subdistrict]']").val(
      $("#form_reg_company input[name='subdistrict']").val()
    );*/
});