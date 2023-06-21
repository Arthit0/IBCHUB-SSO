$(document).ready(function () {
    $(`#form_reg_noncompany [name="contact_province_old"]`).hide();
    $(`#form_reg_noncompany [name="contact_district_old"]`).hide();
    $(`#form_reg_noncompany [name="contact_subdistrict_old"]`).hide();
    $(`#form_reg_noncompany [name="contact_address_old"]`).hide();
    $(`#form_reg_noncompany [name="contact_postcode_old"]`).hide();
    $(`#form_reg_noncompany [name="state"]`).val('new');
    console.log('noncom');
    $.ajax({
        url: BASE_URL + _INDEX + "register/get_provinces",
        method: "post",
        beforeSend: function(){
            $('.modal-spin').modal('show');
        },
        data: '',
        success: function (result) {
            $.each(result, function (key, value) {
                if (result.lang === 'th') {
                    $(`#form_reg_noncompany [name^="contact_province"]`).append(`<option value="${value.id}">${value.name_th}</option>`);
                } else {
                    $(`#form_reg_noncompany [name^="contact_province"]`).append(`<option value="${value.id}">${value.name_en}</option>`);
                }
            });
            $('.selectpicker').selectpicker('refresh');
        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
})

const change_district =(obj)=>{
    $(`#form_reg_noncompany [name^="contact_subdistrict"]`).find('option').remove();
    $(`#form_reg_noncompany [name^="contact_subdistrict"]`).html(`<option value="">กรุณาเลือกอำเภอ</option>`);
    $('.selectpicker').selectpicker('refresh');
    $(`#form_reg_noncompany [name^="contact_postcode"]`).val('');

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
                if (result.lang == 'th') {
                    $(`#form_reg_noncompany [name^="contact_subdistrict"]`).append(`<option value="${value.id}">${value.name_th}</option>`);
                } else {
                    $(`#form_reg_noncompany [name^="contact_subdistrict"]`).append(`<option value="${value.id}">${value.name_en}</option>`);
                }
            });
            $('.selectpicker').selectpicker('refresh');

            let select_subdistrict = $("#form_reg_noncompany [name='contact_subdistrict']").val();
            let option_subdistrict = $("#form_reg_noncompany [name='contact_subdistrict]'] option");
            $.each(option_subdistrict, function (index, item) {
                if ($(item).html() == select_subdistrict) {
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');
                    return false;
                }
            });
        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
}

const change_province = (obj) => {
    $(`#form_reg_noncompany [name="contact_district"]`).find('option').remove();
    $(`#form_reg_noncompany [name="contact_subdistrict"]`).find('option').remove();
    $(`#form_reg_noncompany [name="contact_postcode"]`).val('');

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
                if (result.lang == 'th') {
                    $(`#form_reg_noncompany [name^="contact_district"]`).append(`<option value="${value.id}">${value.name_th}</option>`);
                } else {
                    $(`#form_reg_noncompany [name^="contact_district"]`).append(`<option value="${value.id}">${value.name_en}</option>`);
                }
            });
            $('.selectpicker').selectpicker('refresh');

            let select_district = $("#form_reg_noncompany [name='contact_district']").val();
            let option_district = $("#form_reg_noncompany [name='contact_district'] option");
            $.each(option_district, function (index, item) {
                if ($(item).html() == select_district) {
                    $(item).prop("selected", true);
                    $('.selectpicker').selectpicker('refresh');
                    return false;
                }
            });

            // store data option to sub_districe
            change_district($(`[name^="contact_district"]`))
        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
}

/********** On Change Province จังหวัด ***********/
$(`#form_reg_noncompany [name^="contact_province"]`).on('change', function () {
    change_province($(this));
})


/********** On Change amphures อำเภอ ***********/
$(`#form_reg_noncompany [name^="contact_district"]`).on('change', function () {
    change_district($(this));
})

/********** On Change districe ตำบล ***********/
$(`#form_reg_noncompany [name^="contact_subdistrict"]`).on('change', function () {
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
            $(`#form_reg_noncompany [name^="contact_postcode"]`).val(result[0].zip_code);

        },
        complete: function() {
            $('.modal-spin').modal('hide');
        }
    });
})

$(".radio_new_adress1").click(function () {
    $(`#form_reg_noncompany [name="state"]`).val('new');
    $(`#form_reg_noncompany [name="contact_province_old"]`).val('').hide();
    $(`#form_reg_noncompany [name="contact_district_old"]`).val('').hide();
    $(`#form_reg_noncompany [name="contact_subdistrict_old"]`).val('').hide();
    $(`#form_reg_noncompany [name="contact_address_old"]`).val('').hide();
    $(`#form_reg_noncompany [name="contact_postcode_old"]`).val('').hide();

    $(`#form_reg_noncompany [name="contact_postcode"]`).show();
    $(`#form_reg_noncompany [name="contact_address"]`).show();
    $(`#form_reg_noncompany [name="contact_province"]`).selectpicker('show');
    $(`#form_reg_noncompany [name="contact_district"]`).selectpicker('show');
    $(`#form_reg_noncompany [name="contact_subdistrict"]`).selectpicker('show');
    
});

$(".radio_new_adress6").click(function () {
    $(`#form_reg_noncompany [name="state"]`).val('new');
    $(`#form_reg_noncompany [name="contact_province_old"]`).val('').hide();
    $(`#form_reg_noncompany [name="contact_district_old"]`).val('').hide();
    $(`#form_reg_noncompany [name="contact_subdistrict_old"]`).val('').hide();
    $(`#form_reg_noncompany [name="contact_address_old"]`).val('').hide();
    $(`#form_reg_noncompany [name="contact_postcode_old"]`).val('').hide();

    $(`#form_reg_noncompany [name="contact_postcode"]`).show();
    $(`#noncontact_address`).show();
    $(`#noncontact_province`).selectpicker('show');
    $(`#noncontact_district`).selectpicker('show');
    $(`#noncontact_subdistrict`).selectpicker('show');
    
});

$(".radio_old_adress1").on('click',function() {
    console.log("clicked");
    $(`#form_reg_noncompany [name="state"]`).val('old');
    let company_address = $(`#form_reg_noncompany [name="company_address"]`).val();
    let company_province = $(`#form_reg_noncompany [name="company_province"]`).val();
    let company_district = $(`#form_reg_noncompany [name="company_district"]`).val();
    let company_subdistrict = $(`#form_reg_noncompany [name="company_subdistrict"]`).val();
    let company_postcode = $(`#form_reg_noncompany [name="company_postcode"]`).val();

    $(`#form_reg_noncompany [name="contact_address_old"]`).val(company_address).show();
    $(`#form_reg_noncompany [name="contact_province_old"]`).val(company_province).show();
    $(`#form_reg_noncompany [name="contact_district_old"]`).val(company_district).show();
    $(`#form_reg_noncompany [name="contact_subdistrict_old"]`).val(company_subdistrict).show();
    $(`#form_reg_noncompany [name="contact_postcode_old"]`).val(company_postcode).show();
    
    $(`#form_reg_noncompany [name="contact_address"]`).hide();
    $(`#form_reg_noncompany [name="contact_province"]`).selectpicker('hide');
    $(`#form_reg_noncompany [name="contact_district"]`).selectpicker('hide');
    $(`#form_reg_noncompany [name="contact_subdistrict"]`).selectpicker('hide');
    $(`#form_reg_noncompany [name="contact_postcode"]`).hide();
    
    // tranfer data to province
    //prop_dropdown();

    /*$("#form_reg_noncompany input[name='bus[province]']").val(
      $("#form_reg_noncompany input[name='province']").val()
    );
    $("#form_reg_noncompany input[name='bus[district]']").val(
      $("#form_reg_noncompany input[name='district']").val()
    );
    $("#form_reg_noncompany input[name='bus[subdistrict]']").val(
      $("#form_reg_noncompany input[name='subdistrict']").val()
    );*/
});

$(".radio_old_adress6").on('click',function() {
    $(`#form_reg_noncompany [name="state"]`).val('old');
    let company_address = $(`#noncompany_address`).val();
    let company_province = $(`#noncompanyTH_province option:selected`).text();
    let company_district = $(`#noncompanyTH_districts option:selected`).text();
    let company_subdistrict = $(`#noncompanyTH_subdistricts option:selected`).text();
    let company_postcode = $(`#noncompany_postcode`).val();
    console.log(company_address)
    console.log(company_province)
    console.log(company_district)
    console.log(company_subdistrict)
    console.log(company_postcode)

    $(`#form_reg_noncompany [name="contact_address_old"]`).val(company_address).show();
    $(`#form_reg_noncompany [name="contact_province_old"]`).val(company_province).show();
    $(`#form_reg_noncompany [name="contact_district_old"]`).val(company_district).show();
    $(`#form_reg_noncompany [name="contact_subdistrict_old"]`).val(company_subdistrict).show();
    $(`#form_reg_noncompany [name="contact_postcode_old"]`).val(company_postcode).show();
    
    // $(`#form_reg_noncompany [name="contact_address"]`).hide();
    // $(`#form_reg_noncompany [name="contact_province"]`).selectpicker('hide');
    // $(`#form_reg_noncompany [name="contact_district"]`).selectpicker('hide');
    // $(`#form_reg_noncompany [name="contact_subdistrict"]`).selectpicker('hide');
    $(`#noncontact_postcode`).hide();
    
    $(`#noncontact_address`).hide();
    $(`#noncontact_province`).selectpicker('hide');
    $(`#noncontact_district`).selectpicker('hide');
    $(`#noncontact_subdistrict`).selectpicker('hide');
    // tranfer data to province
    //prop_dropdown();

    /*$("#form_reg_noncompany input[name='bus[province]']").val(
      $("#form_reg_noncompany input[name='province']").val()
    );
    $("#form_reg_noncompany input[name='bus[district]']").val(
      $("#form_reg_noncompany input[name='district']").val()
    );
    $("#form_reg_noncompany input[name='bus[subdistrict]']").val(
      $("#form_reg_noncompany input[name='subdistrict']").val()
    );*/
});

/*const prop_dropdown =()=> {
    let select_province = $("#form_reg_noncompany [name='company_province']").val();
    let option_province = $("#form_reg_noncompany [name='bus[province]'] option");

    $.each(option_province, function (index_province, item_province) {
        if ($(item_province).html() == select_province) {
            console.log('select province');
            $(item_province).prop("selected", true);
            // store data to district
            change_province($(`#form_reg_noncompany [name^="bus[province]"]`));
            $('.selectpicker').selectpicker('refresh');
            //return false;
        }
    });
    test();
    $("#form_reg_noncompany input[name='bus[address]']").val(
        $("#form_reg_noncompany input[name='address']").val()
    );
}

function test(){
    $('.selectpicker').selectpicker('refresh');
    let select_district = $("#form_reg_noncompany [name='company_district']").val();
    let option_district = $("#form_reg_noncompany [name='bus[district]'] option");
    $.each(option_district, function (index_district, item_district) {
        console.log(item_district);
        if ($(index_district).html() == option_district) {
            console.log('select province');
            $(item_province).prop("selected", true);
            // store data to district
            change_province($(`#form_reg_noncompany [name^="bus[province]"]`));
            $('.selectpicker').selectpicker('refresh');

            return false;
        }
    });
}*/

