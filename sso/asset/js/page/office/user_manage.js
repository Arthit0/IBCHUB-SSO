

/*$.ajax({ 
    url: BASE_URL + _INDEX + "office/data_table",
    method: "post",
    data: '',
    success: function (result) {
        var res = JSON.parse(result);
        $('.sso-table').bootstrapTable({data: res});
        $('.sso-table').bootstrapTable('refresh');
    }
});*/
var time_send_postcode;

$(document).ready(function(){

    
    setTimeout(function(){
        let title_name =  $(`#select_title`).val();
      $("div.member_title select").val(title_name).change();
    }, 500);
        $(`#form_add_user`).submit(function(){
            let data_form = $(this).serialize();
            $.ajax({
                url: BASE_URL + _INDEX + "office/save_add_member",
                method: "post",
                data: data_form,
                success: function (result) {
                    let data = JSON.parse(result);
                    if(data.code === '00'){
                        //success
                        Swal.fire({
                            icon: "success",
                            title: "บันทึกสำเร็จ"
                            //text: data.error,
                        }).then(()=>{
                            window.location.href = BASE_URL + "office/user";
                        });
                    }else{
                        //fail
                        Swal.fire({
                            icon: "error",
                            title: "เกิดข้อผิดพลาด : "+data.message,
                            //text: data.error,
                        });
                    }
                }
            });
            return false;
        });
        $(`#form_edit_member`).submit(function(){
            let data_form = $(this).serialize();
            $.ajax({
                url: BASE_URL + _INDEX + "office/save_edit_member",
                method: "post",
                data: data_form,
                success: function (result) {
                    let data = JSON.parse(result);
                    // console.log(data);
                    // return false;
                    if(data.status === '00'){
                        // console.log(data)
                        Swal.fire({
                            icon: "success",
                            title: "บันทึกสำเร็จ"
                            //text: data.error,
                        }).then(()=>{
                            window.location.href = BASE_URL + "office/detail_member?type="+data.type+"&id="+data.member_id;
                        });
                    }else{
                        //fail
                        Swal.fire({
                            icon: "error",
                            title: "เกิดข้อผิดพลาด : "+data.message,
                            //text: data.error,
                        });
                    }
                    //console.log(data);
                }
            });
            return false;
        });
});
$(`#foreigner`).on('click', function() {
        $(`#member_cid`).val('');
        $('#ck_cid').empty().append('<p id="ck_cid">พาสปอร์ต : <a id="a_name_laser"></a></p>');
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
});
$(`#national_thai`).on('click', function() {
        $(`#member_cid`).val('');
        let icon_laser = $(`#icon_laser`).val();
        let icon_color_laser = $(`#icon_color_laser`).val();
        let status_name_laser = $(`#status_name_laser`).val();//member_cid
        $('#ck_cid').empty().append('<p id="ck_cid">เลขบัตรประชาชน :<a id="a_name_laser">&nbsp;<i class="'+icon_laser+'"  style="color:'+icon_color_laser+'"></i>&nbsp;&nbsp;'+status_name_laser+'</a></p>');
        var div_nameTh = document.getElementById("div_nameTh");
        var div_midnameTh = document.getElementById("div_midnameTh");
        var div_lastnameTh = document.getElementById("div_lastnameTh");
        var div_nameEn = document.getElementById("div_nameEn");
        var div_midnameEn = document.getElementById("div_midnameEn");
        var div_lastnameEn = document.getElementById("div_lastnameEn");
        div_nameEn.classList.remove("col-sm-3-5");
        div_nameEn.classList.add("col-sm-4");
        div_midnameEn.classList.remove("col-sm-2-5");
        div_midnameEn.classList.add("col-sm-4");
        div_lastnameEn.classList.remove("col-sm-2-5");
        div_lastnameEn.classList.add("col-sm-4");
        div_nameTh.removeAttribute("style");
        div_midnameTh.removeAttribute("style");
        div_lastnameTh.removeAttribute("style");
});
$(`[name="contact_postcode"]`).on('click', function() {
    if ($(this).val() == '') {
        show_drop_down_default('#dropdown_contact_postcode')
    }else{
        document.getElementById("dropdown_contact_postcode").style.width = "87%";
        let postcode = $(this).val();
        let dropdown = '#dropdown_contact_postcode';
        let province = "[name='contact_province']";
        let district = "[name='contact_district']";
        let subdistrict = "[name='contact_subdistrict']";
        let zipcode = "[name='contact_postcode']";
        let lang = 'th'
        show_drop_down_load(dropdown);
        add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    }
});
$(`[name="contact_postcode"]`).on('keyup', function() {
    let postcode = $(this).val();
    let dropdown = '#dropdown_contact_postcode';
    let province = "[name='contact_province']";
    let district = "[name='contact_district']";
    let subdistrict = "[name='contact_subdistrict']";
    let zipcode = "[name='contact_postcode']";
    let lang = 'th'
    show_drop_down_load(dropdown);
    add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    
});

$(`[name="company_postcodeEn"]`).on('click', function() {
    if ($(this).val() == '') {
        show_drop_down_default('#dropdown_company_postcodeEn')
    }else{
        document.getElementById("dropdown_company_postcodeEn").style.width = "87%";
        let postcode = $(this).val();
        let dropdown = '#dropdown_company_postcodeEn';
        let province = "[name='company_provinceEn']";
        let district = "[name='company_districtEn']";
        let subdistrict = "[name='company_subdistrictEn']";
        let zipcode = "[name='company_postcodeEn']";
        let lang = 'en'
        show_drop_down_load(dropdown);
        add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    }
});
$(`[name="company_postcodeEn"]`).on('keyup', function() {
    let postcode = $(this).val();
    let dropdown = '#dropdown_company_postcodeEn';
    let province = "[name='company_provinceEn']";
    let district = "[name='company_districtEn']";
    let subdistrict = "[name='company_subdistrictEn']";
    let zipcode = "[name='company_postcodeEn']";
    let lang = 'en'
    show_drop_down_load(dropdown);
    add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    
});

$(`[name="postcode"]`).on('click', function() {
    if ($(this).val() == '') {
        show_drop_down_default('#dropdown_contact_postcode')
    }else{
        document.getElementById("dropdown_contact_postcode").style.width = "87%";
        let postcode = $(this).val();
        let dropdown = '#dropdown_contact_postcode';
        let province = "[name='provinceTh']";
        let district = "[name='districtTh']";
        let subdistrict = "[name='subdistrictTh']";
        let zipcode = "[name='postcode']";
        let lang = 'th'
        show_drop_down_load(dropdown);
        add_data_dropdown2(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    }
});
$(`[name="postcode"]`).on('keyup', function() {
    let postcode = $(this).val();
    let dropdown = '#dropdown_contact_postcode';
    let province = "[name='provinceTh']";
    let district = "[name='districtTh']";
    let subdistrict = "[name='subdistrictTh']";
    let zipcode = "[name='postcode']";
    let lang = 'th'
    show_drop_down_load(dropdown);
    add_data_dropdown2(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    
});

$(`#noncompany_postcodeTh`).on('click', function() {
    if ($(this).val() == '') {
        show_drop_down_default('#dropdown_company_postcodeTh')
    }else{
        document.getElementById("dropdown_company_postcodeTh").style.width = "87%";
        let postcode = $(this).val();
        let dropdown = '#dropdown_company_postcodeTh';
        let province = "[name='noncompany_provinceTh']";
        let district = "[name='noncompany_districtTh']";
        let subdistrict = "[name='noncompany_subdistrictTh']";
        let zipcode = "[name='noncompany_postcodeTh']";
        let lang = 'th'
        show_drop_down_load(dropdown);
        add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    }
});
$(`#noncompany_postcodeTh`).on('keyup', function() {
    let postcode = $(this).val();
    let dropdown = '#dropdown_company_postcodeTh';
    let province = "[name='noncompany_provinceTh']";
    let district = "[name='noncompany_districtTh']";
    let subdistrict = "[name='noncompany_subdistrictTh']";
    let zipcode = "[name='noncompany_postcodeTh']";
    let lang = 'th'
    show_drop_down_load(dropdown);
    add_data_dropdown(postcode, dropdown, province, district, subdistrict, zipcode, lang);
    
})
const store_addr = (e) => {
    $('.dropdown-menu').find('a.dropdown-item.dropdown-link.active').removeClass('active')
    $(e).addClass('active')
    let amphure_id = $(e).attr('amphure-id')
    let province_id = $(e).attr('province-id')
    let district_id = $(e).attr('district-id')
    let zip_code = $(e).attr('zip-code')

    let province_tag = $(e).attr('province-tag')
    let district_tag = $(e).attr('district-tag')
    let subdistrict_tag = $(e).attr('subdistrict-tag')
    let zipcode_tag = $(e).attr('zipcode-tag')
    let lang = $(e).attr('lang')
    $(zipcode_tag).val(zip_code)
    $.ajax({
        url:BASE_URL + _INDEX +"office/get_provinces",
        method: "post",
        data: {id:province_id},
        success: function(result) {
            $.each(result, function(key, value) {
                if(value.id != undefined){
                    if (lang == 'th') {
                        $(province_tag).val(value.name_th).change();
                    }
                    else {
                        $(province_tag).val(value.name_en).change();
                    }
                }
            });
        }
    });

    $.ajax({
        url:BASE_URL + _INDEX +"office/get_amphures",
        method: "post",
        data: {id:amphure_id},
        success: function(result) {
            $.each(result, function(key, value) {
                if(value.id != undefined){
                    if (lang == 'th') $(district_tag).val(value.name_th).change(); 
                    else $(district_tag).val(value.name_en).change();
                }
            });
        }
    });

    $.ajax({
        url:BASE_URL + _INDEX +"office/get_districts",
        method: "post",
        data: {id:district_id},
        success: function(result) {
            $.each(result, function(key, value) {subdistrict_tag
                if(value.id != undefined){
                    if (lang == 'th') $(subdistrict_tag).val(value.name_th).change();
                    else $(subdistrict_tag).val(value.name_en).change();
                }
            });
        }
    });
}

const store_addr2 = (e) => {
    $('.dropdown-menu').find('a.dropdown-item.dropdown-link.active').removeClass('active')
    $(e).addClass('active')
    let amphure_id = $(e).attr('amphure-id')
    let province_id = $(e).attr('province-id')
    let district_id = $(e).attr('district-id')
    let zip_code = $(e).attr('zip-code')

    let province_tag = $(e).attr('province-tag')
    let district_tag = $(e).attr('district-tag')
    let subdistrict_tag = $(e).attr('subdistrict-tag')
    let zipcode_tag = $(e).attr('zipcode-tag')
    let lang = $(e).attr('lang')
    $(zipcode_tag).val(zip_code)
    // console.log(
    //     province_tag,
    //     district_tag,
    //     subdistrict_tag
    // );
    // return false;
    $.ajax({
        url:BASE_URL + _INDEX +"office/get_provinces",
        method: "post",
        data: {id:province_id},
        success: function(result) {
            $.each(result, function(key, value) {
                if(value.id != undefined){
                    if (lang == 'th') {
                        $(province_tag).val(value.name_th).change();
                        $(`[name='provinceEn']`).val(value.name_en).change();
                    }
                    else {
                        $(province_tag).val(value.name_en).change();
                        $(`[name='provinceEn']`).val(value.name_en).change();
                    }
                }
            });
        }
    });

    $.ajax({
        url:BASE_URL + _INDEX +"office/get_amphures",
        method: "post",
        data: {id:amphure_id},
        success: function(result) {
            $.each(result, function(key, value) {
                if(value.id != undefined){
                    if (lang == 'th') {
                        $(district_tag).val(value.name_th).change();
                        $(`[name="districtEn"]`).val(value.name_en).change();
                    } else {
                        $(district_tag).val(value.name_en).change();
                        $(`[name="districtEn"]`).val(value.name_en).change();
                    }
                }
            });
        }
    });

    $.ajax({
        url:BASE_URL + _INDEX +"office/get_districts",
        method: "post",
        data: {id:district_id},
        success: function(result) {
            $.each(result, function(key, value) {subdistrict_tag
                if(value.id != undefined){
                    if (lang == 'th') {
                        $(subdistrict_tag).val(value.name_th).change();
                        $(`[name="subdistrictEn"]`).val(value.name_en).change();
                    }else {
                        $(subdistrict_tag).val(value.name_en).change();
                        $(`[name="subdistrictEn"]`).val(value.name_en).change();
                    }
                }
            });
        }
    });
}

const show_drop_down_default = (e) => {
    $(e).empty();
    $(e).append(`<a class="dropdown-items drop-down-icon"><i class="fa fa-address-card-o" aria-hidden="true" style="font-size:1rem;top: 0px !important;"></i> กรอกรหัสไปรษณีย์</a>`)
}
const show_drop_down_load = (e) => {
    $(e).empty();
    $(e).append(`<a class="dropdown-item drop-down-icon text-center" style="top: 0px !important;">Loading...</a>`)
}
const add_data_dropdown = (postcode, dropdown, province, district, subdistrict, zipcode, lang) => {
    if (postcode != '') {
        clearTimeout(time_send_postcode);
        time_send_postcode = setTimeout(function() {
            get_address_from_zipcode(postcode, dropdown, province, district, subdistrict, zipcode, lang)
        }, 750);
    } else {
        $(dropdown).dropdown(`hide`)

    }
}
const add_data_dropdown2 = (postcode, dropdown, province, district, subdistrict, zipcode, lang) => {
    if (postcode != '') {
        clearTimeout(time_send_postcode);
        time_send_postcode = setTimeout(function() {
            get_address_from_zipcode2(postcode, dropdown, province, district, subdistrict, zipcode, lang)
        }, 750);
    } else {
        $(dropdown).dropdown(`hide`)

    }
}
const get_address_from_zipcode = (postcode, dropdown, province, district, subdistrict, zipcode, lang) => {
    $.ajax({
        type: "post",
        url:BASE_URL + _INDEX +"office/get_address_from_zipcode",
        data: { postcode: postcode },
        success: function(response) {
            $(dropdown).empty();
            if (response.res_code == '00') {
                response.res_result.forEach(function(value) {
                    if (lang == 'th') {
                        subdistrict_name = value.name_th
                        amphure_name = value.amphure_name_th
                        province_name = value.province_name_th
                    } else {
                        subdistrict_name = value.name_en
                        amphure_name = value.amphure_name_en
                        province_name = value.province_name_en
                    }
                    let drop_down = `
                            <a class="dropdown-item dropdown-postcode dropdown-link" 
                                amphure-id="${value.amphure_id}" 
                                province-id="${value.province_id}" 
                                district-id="${value.district_id}"
                                zip-code="${value.zip_code}"

                                province-tag="${province}"
                                district-tag="${district}"
                                subdistrict-tag="${subdistrict}"
                                zipcode-tag="${zipcode}"

                                lang="${lang}"
                                onclick="store_addr(this)" style="top: 0px !important;">
                                ${subdistrict_name
                                    // +' <i class="fa fa-angle-double-right addr-icon" aria-hidden="true"></i> '+amphure_name
                                    // +' <i class="fa fa-angle-double-right addr-icon" aria-hidden="true"></i> '+province_name
                                    +' <i class="fa fa-angle-right addr-icon" aria-hidden="true"></i> '+value.zip_code
                                }
                            </a>`;
                    $(dropdown).append(drop_down)
                })
            } else {
                $(dropdown).append(`<a class="dropdown-item drop-down-icon text-center" style="top: 0px !important;">ไม่พบข้อมูล</a>`)
                    //console.log('ไม่พบข้อมูล')
            }
            //console.log(data)
            $(dropdown).dropdown('show')
        }
    });
}

const get_address_from_zipcode2 = (postcode, dropdown, province, district, subdistrict, zipcode, lang) => {
    $.ajax({
        type: "post",
        url:BASE_URL + _INDEX +"office/get_address_from_zipcode",
        data: { postcode: postcode },
        success: function(response) {
            $(dropdown).empty();
            if (response.res_code == '00') {
                response.res_result.forEach(function(value) {
                    if (lang == 'th') {
                        subdistrict_name = value.name_th
                        amphure_name = value.amphure_name_th
                        province_name = value.province_name_th
                    } else {
                        subdistrict_name = value.name_en
                        amphure_name = value.amphure_name_en
                        province_name = value.province_name_en
                    }
                    let drop_down = `
                            <a class="dropdown-item dropdown-postcode dropdown-link" 
                                amphure-id="${value.amphure_id}" 
                                province-id="${value.province_id}" 
                                district-id="${value.district_id}"
                                zip-code="${value.zip_code}"

                                province-tag="${province}"
                                district-tag="${district}"
                                subdistrict-tag="${subdistrict}"
                                zipcode-tag="${zipcode}"

                                lang="${lang}"
                                onclick="store_addr2(this)">
                                ${subdistrict_name
                                    // +' <i class="fa fa-angle-double-right addr-icon" aria-hidden="true"></i> '+amphure_name
                                    // +' <i class="fa fa-angle-double-right addr-icon" aria-hidden="true"></i> '+province_name
                                    +' <i class="fa fa-angle-right addr-icon" aria-hidden="true"></i> '+value.zip_code
                                }
                            </a>`;
                    $(dropdown).append(drop_down)
                })
            } else {
                $(dropdown).append(`<a class="dropdown-item drop-down-icon text-center">ไม่พบข้อมูล</a>`)
                    //console.log('ไม่พบข้อมูล')
            }
            //console.log(data)
            $(dropdown).dropdown('show')
        }
    });
}
$(document).on('click', '#btn_search', function () {
    $('.sso-table').bootstrapTable('refresh');
}) 



$(document).on('click', '#ShowDataDBD', function () { 
    let member_cid = $(`#member_cid`).val();
    let serviceId = '0101';
    var sum = 0;
    const yeararr = [];
    var year = ((new Date()).getFullYear()-1);
    var current = (year-(year-5));
    year -= current;
    for (var i = 0; i < current; i++) {
        yeararr.push((year + i)+543);
    }
    $(`#load_model`).modal('show');
    $.ajax({
        url: BASE_URL + _INDEX + "api/ck_com_dbd?client_id=BackOffice&cid="+member_cid,
        method: "GET",
        dataType: "text",
        success: function (result) {
            let data = JSON.parse(result);
            if(data.ns0getDataResponse.return.length == 0){
                $(`#load_model`).modal('hide');
                Swal.fire({
                    icon: "error",
                    title: "เลขนิติบุคคลของผู้ใช้ไม่ตรงกับ DBD โปรดติดต่อเจ้าหน้าที่เพื่อดำเนินการเเก้ไข",
                });
                return false;
            }
            var nameCommittee = '';
            var nameDetail = '';
            var memberDetail = '';
            var OLDJURISTIC_ID = '';
            var nameAddress = '';
            let num = 1;
            let nums = 1;
            var dateString  = data.ns0getDataResponse.return.arrayRRow.columns[2].columnValue;
            var year = dateString.substring(0, 4);
            var month = dateString.substring(4, 6);
            var day = dateString.substring(6, 8);
            const months = [
                'ม.ค.',
                'ก.พ.',
                'มี.ค.',
                'เม.ย.',
                'พ.ค.',
                'มิ.ย.',
                'ก.ค.',
                'ส.ค.',
                'ก.ย.',
                'ต.ค.',
                'พ.ย.',
                'ธ.ค.'
              ];
            const monthNumber = parseInt(month, 10);
            const thaiMonth = months[monthNumber - 1];
            const numberString = data.ns0getDataResponse.return.arrayRRow.columns[7].columnValue;
            const numberWithCommas = parseInt(numberString).toLocaleString();
            if((data.ns0getDataResponse.return.arrayRRow.columns[3].columnValue === 'undefined') || (data.ns0getDataResponse.return.arrayRRow.columns[3].columnValue === undefined)){
                OLDJURISTIC_ID += '-';
            }else{
                OLDJURISTIC_ID += data.ns0getDataResponse.return.arrayRRow.columns[3].columnValue;
            }
            var AddressDetail  = data.ns0getDataResponse.return.arrayRRow.childTables[2].rows.columns[1].columnValue+' '+data.ns0getDataResponse.return.arrayRRow.childTables[2].rows.columns[12].columnValue+' '+data.ns0getDataResponse.return.arrayRRow.childTables[2].rows.columns[13].columnValue+' '+data.ns0getDataResponse.return.arrayRRow.childTables[2].rows.columns[14].columnValue;
            memberDetail += `
                            <p class="sso-text-DBD text-left">ชื่อนิติบุคคล : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>`+data.ns0getDataResponse.return.arrayRRow.columns[4].columnValue+`</a></p>
                            <p class="sso-text-DBD text-left">เลขทะเบียนนิติบุคคล : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>`+data.ns0getDataResponse.return.arrayRRow.columns[1].columnValue+`</a></p>
                            <p class="sso-text-DBD text-left">ประเภทนิติบุคคล : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>`+data.ns0getDataResponse.return.arrayRRow.columns[0].columnValue+`</a></p>
                            <p class="sso-text-DBD text-left">สถานะนิติบุคคล : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>`+data.ns0getDataResponse.return.arrayRRow.columns[6].columnValue+`</a></p>
                            <p class="sso-text-DBD text-left">วันที่จัดทะเบียนจัดตั้ง : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>`+day+` `+thaiMonth+` `+year+`</a></p>
                            <p class="sso-text-DBD text-left">ทุนจดทะเบียน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>`+numberWithCommas+` บาท</a></p>
                            <p class="sso-text-DBD text-left">เลขทะเบียนเดิม : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>`+OLDJURISTIC_ID+`</a></p>
                            <p class="sso-text-DBD text-left">กลุ่มธุรกิจ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>`+data.ns0getDataResponse.return.arrayRRow.childTables[3].rows.columns.columnValue+`</a></p>
                            <p class="sso-text-DBD text-left">ขนาดธุรกิจ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  id="business_size">-</a></p>
                            <p class="sso-text-DBD text-left">ที่ตั้งสำนักงานใหญ่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>`+AddressDetail+`</a></p>
                            `;
                       
            switch (data.ns0getDataResponse.return.arrayRRow.columns[0].columnValue) {
                case 'ห้างหุ้นส่วนจำกัด':
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[0].rows, function(key,Committee) {
                        if (Committee.columns) {
                            if(Committee.columns[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (key+1) +". "+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                key = 0;
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }
                        } else {
                            if(Committee[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (num) +". "+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }
                        }
                        num = num + 1;
                    });   
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[1].rows, function(keys,Detail) {
                        if (Detail.columns) {
                            if(Detail.columns[2].columnValue.replace("/", "") != "ไม่มี"){
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Detail.columns[2].columnValue.replace("/", "")+"</p>";
                            }
                        } else {
                            if(Detail[2].columnValue.replace("/", "") != "ไม่มี"){
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Detail[2].columnValue.replace("/", "")+"</p>";
                            }
                        }
                        nums = nums + 1;
                    });  
                    var modal = `<div class="row row-modal DBD">
                        <div class="col-lg-6">
                            <a class="sso-text-DBD text-left">ข้อมูลนิติบุคคล</a>
                        </div>
                        <div class="col-lg-6 text-right">
                            <p class="btn btn-primary active" id="UpdateDataDBD" style="width: 119px;height: 38px;border-radius: 8px;text-align: center;padding: 6px 18px;"><i class='fa fa-refresh'></i>อัพเดต</p>
                        </div>
                        <div class="col-lg-12 Committee" id="MemberDetail_DBD">
                        </div>
                        <div class="col-lg-6">
                            <br>
                            <p class="sso-text-DBD text-left">รายชื่อผู้เป็นหุ้นส่วน</p>
                        </div>
                        <div class="col-lg-66">
                        </div>
                        <div class="col-lg-55">
                            <br>
                            <p class="sso-text-DBD text-left">หุ้นส่วนผู้จัดการ</p>
                        </div>
                        <div class="col-lg-6 Committee" id="nameCommittee">
                        </div>
                        <div class="col-lg-66">
                        </div>
                        <div class="col-lg-55 Committee" id="nameDetail">
                        </div>
                    </div>`;
                  break;
                case "หอการค้า":
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[0].rows, function(key,Committee) {
                        if (Committee.columns) {
                            if(Committee.columns[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (key+1) +". "+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                key = 0;
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }
                        } else {
                            if(Committee[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (num) +". "+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }
                        }
                        num = num + 1;
                    }); 
                    var modal = `<div class="row row-modal DBD">
                        <div class="col-lg-6">
                            <a class="sso-text-DBD text-left">ข้อมูลนิติบุคคล</a>
                        </div>
                        <div class="col-lg-6 text-right">
                            <p class="btn btn-primary active" id="UpdateDataDBD" style="width: 119px;height: 38px;border-radius: 8px;text-align: center;padding: 6px 18px;"><i class='fa fa-refresh'></i>อัพเดต</p>
                        </div>
                        <div class="col-lg-12 Committee" id="MemberDetail_DBD">
                        </div>
                        <div class="col-lg-6">
                            <br>
                            <p class="sso-text-DBD text-left">รายชื่อกรรมการ</p>
                        </div>
                        <div class="col-lg-6 Committee" id="nameCommittee">
                        </div>
                    </div>`;
                  break;
                case "บริษัทจำกัด":
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[0].rows, function(key,Committee) {
                        if (Committee.columns) {
                            nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (key+1) +". "+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                        } else {
                            nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (num) +". "+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                        }
                        num = num + 1;
                    });   
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[1].rows, function(keys,Detail) {
                        if (Detail.columns) {
                            nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (keys+1) +". "+Detail.columns[2].columnValue.replace("/", "")+"</p>";
                        } else {
                            nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (nums) +". "+Detail[2].columnValue.replace("/", "")+"</p>";
                        }
                        nums = nums + 1;
                    });  
                    var modal = `<div class="row row-modal DBD">
                        <div class="col-lg-6">
                            <a class="sso-text-DBD text-left">ข้อมูลนิติบุคคล</a>
                        </div>
                        <div class="col-lg-6 text-right">
                            <p class="btn btn-primary active" id="UpdateDataDBD" style="width: 119px;height: 38px;border-radius: 8px;text-align: center;padding: 6px 18px;"><i class='fa fa-refresh'></i>อัพเดต</p>
                        </div>
                        <div class="col-lg-12 Committee" id="MemberDetail_DBD">
                        </div>
                        <div class="col-lg-6">
                            <br>
                            <p class="sso-text-DBD text-left">รายชื่อกรรมการ</p>
                        </div>
                        <div class="col-lg-66">
                        </div>
                        <div class="col-lg-55">
                            <br>
                            <p class="sso-text-DBD text-left">กรรมการลงชื่อผูกพัน</p>
                        </div>
                        <div class="col-lg-6 Committee" id="nameCommittee">
                        </div>
                        <div class="col-lg-66">
                        </div>
                        <div class="col-lg-55 Committee" id="nameDetail">
                        </div>
                    </div>`;
                  break;
                case "ห้างหุ้นส่วนสามัญนิติบุคคล":
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[0].rows, function(key,Committee) {
                        if (Committee.columns) {
                            if(Committee.columns[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (key+1) +". "+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                key = 0;
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }
                        } else {
                            if(Committee[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (num) +". "+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }
                        }
                        num = num + 1;
                    });   
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[1].rows, function(keys,Detail) {
                        if (Detail.columns) {
                            if(Detail.columns[2].columnValue.replace("/", "") != "ไม่มี"){
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Detail.columns[2].columnValue.replace("/", "")+"</p>";
                            }
                        } else {
                            if(Detail[2].columnValue.replace("/", "") != "ไม่มี"){
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Detail[2].columnValue.replace("/", "")+"</p>";
                            }
                        }
                        nums = nums + 1;
                    });  
                    var modal = `<div class="row row-modal DBD">
                        <div class="col-lg-6">
                            <a class="sso-text-DBD text-left">ข้อมูลนิติบุคคล</a>
                        </div>
                        <div class="col-lg-6 text-right">
                            <p class="btn btn-primary active" id="UpdateDataDBD" style="width: 119px;height: 38px;border-radius: 8px;text-align: center;padding: 6px 18px;"><i class='fa fa-refresh'></i>อัพเดต</p>
                        </div>
                        <div class="col-lg-12 Committee" id="MemberDetail_DBD">
                        </div>
                        <div class="col-lg-6">
                            <br>
                            <p class="sso-text-DBD text-left">รายชื่อผู้เป็นหุ้นส่วน</p>
                        </div>
                        <div class="col-lg-66">
                        </div>
                        <div class="col-lg-55">
                            <br>
                            <p class="sso-text-DBD text-left">หุ้นส่วนผู้จัดการ</p>
                        </div>
                        <div class="col-lg-6 Committee" id="nameCommittee">
                        </div>
                        <div class="col-lg-66">
                        </div>
                        <div class="col-lg-55 Committee" id="nameDetail">
                        </div>
                    </div>`;
                  break;
                case "สมาคมการค้า":
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[0].rows, function(key,Committee) {
                        if (Committee.columns) {
                            if(Committee.columns[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (key+1) +". "+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                key = 0;
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }
                        } else {
                            if(Committee[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (num) +". "+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }
                        }
                        num = num + 1;
                    }); 
                    var modal = `<div class="row row-modal DBD">
                        <div class="col-lg-6">
                            <a class="sso-text-DBD text-left">ข้อมูลนิติบุคคล</a>
                        </div>
                        <div class="col-lg-6 text-right">
                            <p class="btn btn-primary active" id="UpdateDataDBD" style="width: 119px;height: 38px;border-radius: 8px;text-align: center;padding: 6px 18px;"><i class='fa fa-refresh'></i>อัพเดต</p>
                        </div>
                        <div class="col-lg-12 Committee" id="MemberDetail_DBD">
                        </div>
                        <div class="col-lg-12">
                            <br>
                            <p class="sso-text-DBD text-left">รายชื่อกรรมการ</p>
                        </div>
                        <div class="col-lg-6 Committee" id="nameCommittee">
                        </div>
                    </div>`;
                  break;
                case "บริษัทมหาชนจำกัด":
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[0].rows, function(key,Committee) {
                        if (Committee.columns) {
                            if(Committee.columns[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (key+1) +". "+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                key = 0;
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee.columns[2].columnValue+" "+Committee.columns[3].columnValue+" "+Committee.columns[4].columnValue.replace("/", "")+"</p>";
                            }
                        } else {
                            if(Committee[1].columnValue === "K"){
                                nameCommittee += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+ (num) +". "+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }else{
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Committee[2].columnValue+" "+Committee[3].columnValue+" "+Committee[4].columnValue.replace("/", "")+"</p>";
                            }
                        }
                        num = num + 1;
                    });   
                    $.each(data.ns0getDataResponse.return.arrayRRow.childTables[1].rows, function(keys,Detail) {
                        if (Detail.columns) {
                            if(Detail.columns[2].columnValue.replace("/", "") != "ไม่มี"){
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Detail.columns[2].columnValue.replace("/", "")+"</p>";
                            }
                        } else {
                            if(Detail[2].columnValue.replace("/", "") != "ไม่มี"){
                                nameDetail += "<p class='sso-text-DBD text-left' style='font-weight: 540!important;'>"+Detail[2].columnValue.replace("/", "")+"</p>";
                            }
                        }
                        nums = nums + 1;
                    });  
                    var modal = `<div class="row row-modal DBD">
                        <div class="col-lg-6">
                            <a class="sso-text-DBD text-left">ข้อมูลนิติบุคคล</a>
                        </div>
                        <div class="col-lg-6 text-right">
                            <p class="btn btn-primary active" id="UpdateDataDBD" style="width: 119px;height: 38px;border-radius: 8px;text-align: center;padding: 6px 18px;"><i class='fa fa-refresh'></i>อัพเดต</p>
                        </div>
                        <div class="col-lg-12 Committee" id="MemberDetail_DBD">
                        </div>
                        <div class="col-lg-6">
                            <br>
                            <p class="sso-text-DBD text-left">รายชื่อผู้เป็นหุ้นส่วน</p>
                        </div>
                        <div class="col-lg-66">
                        </div>
                        <div class="col-lg-55">
                            <br>
                            <p class="sso-text-DBD text-left">หุ้นส่วนผู้จัดการ</p>
                        </div>
                        <div class="col-lg-6 Committee" id="nameCommittee">
                        </div>
                        <div class="col-lg-66">
                        </div>
                        <div class="col-lg-55 Committee" id="nameDetail">
                        </div>
                    </div>`;
                  break;
              }

            $('#modalBody').empty().append(modal);
            $.each(data.ns0getDataResponse.return.arrayRRow.childTables[2].rows, function(keys,Address) {
                nameAddress += Address[1].columnValue+" ต."+Address[12].columnValue+" อ."+Address[13].columnValue+" จ."+Address[14].columnValue;
            }); 
            $('#ModalLabel').empty().append('ข้อมูลจากระบบ DBD');
            $('#cid_DBD').empty().append('เลขนิติบุคคล :&nbsp;&nbsp;&nbsp;&nbsp;'+' '+data.ns0getDataResponse.return.arrayRRow.columns[1].columnValue);
            $('#com_name_DBD').empty().append('ชื่อนิติบุคคล :&nbsp;&nbsp;&nbsp;&nbsp;'+data.ns0getDataResponse.return.arrayRRow.columns[4].columnValue);
            $('#com_address_DBD').empty().append('ที่อยู่นิติบุคคล :&nbsp;&nbsp;&nbsp;&nbsp;'+nameAddress);
            $('#MemberDetail_DBD').empty().append(memberDetail);
            $('#nameCommittee').empty().append(nameCommittee);
            $('#nameDetail').empty().append(nameDetail);
        }
    });
    var size = '';
    $.each(yeararr, function(key_arr,arr) {
        $.ajax({
            url: BASE_URL + _INDEX + "api/BalanceService",
            method: "POST",
            data: {serviceId: serviceId,cid: member_cid,year: arr},
            success: function (result) {
                if(result.ns0getDataAndBalanceResponse.return.arrayRRow){
                    sum += Number(result.ns0getDataAndBalanceResponse.return.arrayRRow.columns[18].columnValue)
                }
                if(sum < 1800000){
                    size = 'Micro';
                }else if(sum <= 100000000){
                    size = 'S';
                }else if(sum <= 500000000){
                    size = 'M';
                }else if(sum > 500000000){
                    size = 'L';
                }
                $('#business_size').empty().append(size);
            }
        });
    }); 
    setTimeout(function() {
        $(`#load_model`).modal('hide');
        $(`#ShowModalDBD`).modal('show');
      }, 10000);
});
$(document).on('click', '#UpdateDataDBD', function () { 
    let member_cid = $(`#member_cid`).val();
    $(`#ShowModalDBD`).modal('hide');
    $(`#load_model`).modal('show');
    $.ajax({
        url: BASE_URL + _INDEX + "api/userinfo",
        method: "POST",
        data: {refid: member_cid,reftext: 'BackOffice'},
        success: function (result) {
            window.location.reload();
        }
    });
});
$(document).on('click', '#checkmark_1,#director_status_1', function () { 
    $('#director_status_2').prop('checked', false);
    $('#director_status_1').prop('checked', true);
});
$(document).on('click', '#checkmark_2,#director_status_2', function () { 
    $('#director_status_2').prop('checked', true);
    $('#director_status_1').prop('checked', false);
});

$(document).on('click', '#checkmark_3,#ck_national_thai', function () { 
    $('#ck_national_foreigner').prop('checked', false);
    $('#ck_national_thai').prop('checked', true);
});
$(document).on('click', '#checkmark_4,#ck_national_foreigner', function () { 
    $('#ck_national_foreigner').prop('checked', true);
    $('#ck_national_thai').prop('checked', false);
});

$(document).on('click', '#ShowAttachment', function () {
    $(`#ShowModalAttachment`).modal('show');
    let member_id = $(`#member_id`).val();
    let director_status = $(`#director_status`).val();
        $.ajax({
            url: BASE_URL + _INDEX + "office/getAttachment?member_id="+member_id+"&director_status="+director_status,
            method: "GET",
            dataType: "text",
            success: function (result) {
                let data = JSON.parse(result);
                var classed = '';
                var authFiles = '';
                var authApprove = '';
                var authNoApprove = '';
                var powerFiles = '';
                var powerApprove = '';
                var powerNoApprove = '';
                var renameFiles = '';
                var renameApprove = '';
                var renameNoApprove = '';
                var  modalApprove = '';
                if(director_status == '2'){
                    if(!data['authorization'] || data['authorization']['file'] == null){
                        // authFiles = `<a> - </a>`;
                        // classed = `text-center`;
                        authFiles = `<a><input type="file" name="file_authApprove" id="file_authApprove"> <input type="hidden" name="type" id="file_typeAuth" value="2"></a>`;
                        classed = `text-left`;
                    }else{
                        authFiles = `<a href="`+BASE_URL + "asset/attach/"+data['authorization']['folder']+"/"+data['authorization']['filename']+`" style="text-decoration-line: underline;" target="_blank">`+data['authorization']['file']+`</a>`;
                        classed = `text-left`;
                    }
                    if(!data['power_attorney'] || data['power_attorney']['file'] == null){
                        // powerFiles = `<a> - </a>`;
                        // classed = `text-center`;
                        powerFiles = `<a><input type="file" name="file_powerApprove" id="file_powerApprove"> <input type="hidden" name="type" id="file_typePower" value="1"></a>`;
                        classed = `text-left`;
                    }else{
                        powerFiles = `<a href="`+BASE_URL + "asset/attach/"+data['power_attorney']['folder']+"/"+data['power_attorney']['filename']+`" style="text-decoration-line: underline;" target="_blank">`+data['power_attorney']['file']+`</a>`;
                        classed = `text-left`;
                    }
                    if(data['power_attorney'] && data['power_attorney']['status'] == '1'){
                        powerNoApprove =`<div class="pl-1 icon-center-con btn btn-danger sso-btn-hold" id="powerNoApprove"  style="color:#A6ACB6;"><i class="fas fa-times-circle powerNoApprove" ></i>&nbsp; ไม่อนุมัติ</div>`;
                        powerApprove =`<div class="pl-1 icon-center-con btn btn-success" id="powerApprove"><i class="fas fa-check-circle powerApprove"></i>&nbsp; อนุมัติ</div>`;
                    }else if(data['power_attorney'] && data['power_attorney']['status'] == '2'){
                        powerApprove =`<div class="pl-1 icon-center-con btn btn-success sso-btn-hold" id="powerApprove" style="color:#A6ACB6;"><i class="fas fa-check-circle powerApprove" ></i>&nbsp; อนุมัติ</div>`;
                        powerNoApprove =`<div class="pl-1 icon-center-con btn btn-danger" id="powerNoApprove"><i class="fas fa-times-circle powerNoApprove" ></i>&nbsp; ไม่อนุมัติ</div>`;
                    }else{
                        powerApprove =`<div class="pl-1 icon-center-con btn btn-success sso-btn-hold" id="powerApprove" style="color:#A6ACB6;"><i class="fas fa-check-circle powerApprove" ></i>&nbsp; อนุมัติ</div>`;
                        powerNoApprove =`<div class="pl-1 icon-center-con btn btn-danger sso-btn-hold" id="powerNoApprove"  style="color:#A6ACB6;"><i class="fas fa-times-circle powerNoApprove" ></i>&nbsp; ไม่อนุมัติ</div>`;
                    }

                    if(data['authorization'] && data['authorization']['status']  == '1'){
                        authNoApprove =`<div class="pl-1 icon-center-con btn btn-danger sso-btn-hold" id="authNoApprove" style="color:#A6ACB6;"><i class="fas fa-times-circle authNoApprove"></i>&nbsp; ไม่อนุมัติ</div>`;
                        authApprove =`<div class="pl-1 icon-center-con btn btn-success " id="authApprove"><i class="fas fa-check-circle authApprove" ></i>&nbsp; อนุมัติ</div>`;
                    }else  if(data['authorization'] && data['authorization']['status']  == '2'){
                        authApprove =`<div class="pl-1 icon-center-con btn btn-success sso-btn-hold" id="authApprove" ><i class="fas fa-check-circle authApprove"></i>&nbsp; อนุมัติ</div>`;
                        authNoApprove =`<div class="pl-1 icon-center-con btn btn-danger " id="authNoApprove"><i class="fas fa-times-circle authNoApprove" ></i>&nbsp; ไม่อนุมัติ</div>`;
                    }else{
                        authApprove =`<div class="pl-1 icon-center-con btn btn-success sso-btn-hold" id="authApprove" style="color:#A6ACB6;"><i class="fas fa-check-circle authApprove"></i>&nbsp; อนุมัติ</div>`;
                        authNoApprove =`<div class="pl-1 icon-center-con btn btn-danger sso-btn-hold" id="authNoApprove" style="color:#A6ACB6;"><i class="fas fa-times-circle authNoApprove"></i>&nbsp; ไม่อนุมัติ</div>`;
                    }


         
                          modalApprove = `
                                        <table class="table table-bordered Approve sso-text-Approve">
                                        <tbody>
                                        <tr>
                                            <td>เอกสารมอบอำนาจ :</td>
                                            <td id="power_attorney" class="`+classed+`">`+powerFiles+`</td>
                                            <td>`+ powerApprove+`</td>
                                            <td>`+ powerNoApprove+`</td>
                                        </tr>
                                        <tr>
                                            <td>สำเนาบัตรประชาชนของกรรมการ :</td>
                                            <td class="`+classed+`">`+authFiles+`</td>
                                            <td>`+authApprove+`</td>
                                            <td>`+authNoApprove+`</td>
                                        </tr>
                                        </tbody>
                                    </table>`;
                }else{
                    if(data['rename']['file'] == null){
                        // renameFiles = `<a> - </a>`;
                        // classed = `text-center`;
                        renameFiles = `<a><input type="file" name="file_renameApprove" id="file_renameApprove"> <input type="hidden" name="type" id="file_typeRename" value="0"></a>`;
                        classed = `text-left`;
                    }else{
                        renameFiles = ``;
                        data.rename.file.forEach(function(v,k){
                            renameFiles += `<a href="`+BASE_URL + "asset/attach/"+data['rename']['folder']+"/"+data['rename']['filename'][k]+`" style="text-decoration-line: underline;" target="_blank">`+data['rename']['file'][k]+`</a><br>`;
                            classed = `text-left`;
                        })
                    }
         
                    if(data['rename']['status']  == '1'){
                        renameNoApprove =`<div class="pl-1 icon-center-con btn btn-danger sso-btn-hold" id="renameNoApprove" style="color:#A6ACB6;"><i class="fas fa-times-circle renameNoApprove"></i>&nbsp; ไม่อนุมัติ</div>`;
                        renameApprove =`<div class="pl-1 icon-center-con btn btn-success" id="renameApprove"><i class="fas fa-check-circle renameApprove" ></i>&nbsp; อนุมัติ</div>`;
                    }else  if(data['rename']['status']  == '2'){
                        renameApprove =`<div class="pl-1 icon-center-con btn btn-success sso-btn-hold" id="renameApprove" style="color:#A6ACB6;"><i class="fas fa-check-circle renameApprove"></i>&nbsp; อนุมัติ</div>`;
                        renameNoApprove =`<div class="pl-1 icon-center-con btn btn-danger " id="renameNoApprove"><i class="fas fa-times-circle renameNoApprove" ></i>&nbsp; ไม่อนุมัติ</div>`;
                    }else{
                        renameApprove =`<div class="pl-1 icon-center-con btn btn-success sso-btn-hold" id="renameApprove" style="color:#A6ACB6;"><i class="fas fa-check-circle renameApprove"></i>&nbsp; อนุมัติ</div>`;
                        renameNoApprove =`<div class="pl-1 icon-center-con btn btn-danger sso-btn-hold" id="renameNoApprove" style="color:#A6ACB6;"><i class="fas fa-times-circle renameNoApprove"></i>&nbsp; ไม่อนุมัติ</div>`;
                    }
     
         
                          modalApprove = `
                                        <table class="table table-bordered Approve sso-text-Approve">
                                        <tbody>
                                        <tr>
                                            <td>เอกสาร :</td>
                                            <td id="power_attorney" class="`+classed+`">`+renameFiles+`</td>
                                            <td style='vertical-align:middle;'>`+ renameApprove+`</td>
                                            <td style='vertical-align:middle;'>`+ renameNoApprove+`</td>
                                        </tr>
                                        </tbody>
                                    </table>`;                    
                }


                $('#modalBodyApprove').empty().append(modalApprove);
            }
        });
});
$(document).on('click', '#renameApprove', function(){
    $(`#load_model`).modal('show');
    let member_id = $(`#member_id`).val();
    $.ajax({
        url: BASE_URL + _INDEX + "office/saveAttachment",
        method: "post",
        data: {renameApprove: 1,member_id:member_id},
        success: function (result) {
            $(`#load_model`).modal('hide');
            let data = JSON.parse(result);
            if(data.res_code === '00'){
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    $("#renameApprove").css("color", "#39414F");
                    $(".renameApprove").css("color", "#0AC37D");
                    $("#renameNoApprove").css("color", "#A6ACB6");
                    $(".renameNoApprove").css("color", "#A6ACB6");
                    document.getElementById("renameApprove").classList.remove('sso-btn-hold');
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-check-circle" style="color: #0AC37D;"></i>&nbsp;&nbsp; อนุมัติแล้ว</a>');
                  });
            }else{
                //fail
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด : ผู้ใช้ยังไม่ได้ทำการอัพโหลดไฟล์",
                });
            }
        }
    });
});
$(document).on('click', '#renameNoApprove', function(){
    let member_id = $(`#member_id`).val();
    $(`#load_model`).modal('show');
    $.ajax({
        url: BASE_URL + _INDEX + "office/saveAttachment",
        method: "post",
        data: {renameNoApprove: 1,member_id:member_id},
        success: function (result) {
            $(`#load_model`).modal('hide');
            let data = JSON.parse(result);
            if(data.res_code === '00'){
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    $("#renameNoApprove").css("color", "#39414F");
                    $(".renameNoApprove").css("color", "red");
                    $("#renameApprove").css("color", "#A6ACB6");
                    $(".renameApprove").css("color", "#A6ACB6");
                    document.getElementById("renameNoApprove").classList.remove('sso-btn-hold');
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-times-circle" style="color: red;"></i>&nbsp;&nbsp; ไม่อนุมัติ</a>');
                });
            }else{
                //fail
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด : ผู้ใช้ยังไม่ได้ทำการอัพโหลดไฟล์",
                });
            }
        }
    });
});

$(document).on('click', '#authApprove', function(){
    let member_id = $(`#member_id`).val();
    $(`#load_model`).modal('show');
    $.ajax({
        url: BASE_URL + _INDEX + "office/saveAttachment",
        method: "post",
        data: {authApprove: 1,member_id:member_id},
        success: function (result) {
            $(`#load_model`).modal('hide');
            let data = JSON.parse(result);
            if(data.res_code === '02'){
                //อนุมัติแล้ว 2 file
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    // $("#authApprove").css("color", "#39414F");
                    // $(".authApprove").css("color", "#0AC37D");
                    // $("#authNoApprove").css("color", "#A6ACB6");
                    // $(".authNoApprove").css("color", "#A6ACB6");
                    $("#authApprove").css("color", "#ffff");
                    $(".authApprove").css("color", "#ffff");
                    $('#authNoApprove').addClass('sso-btn-hold');
                    document.getElementById("authApprove").classList.remove('sso-btn-hold');
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-check-circle" style="color: #0AC37D;"></i>&nbsp;&nbsp; อนุมัติแล้ว</a>');
                  });
                  $(`#load_model`).modal('hide');
            }else if(data.res_code === '03'){
                //รออนุมัติ
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    // $("#authApprove").css("color", "#39414F");
                    // $(".authApprove").css("color", "#0AC37D");
                    // $("#authNoApprove").css("color", "#A6ACB6");
                    // $(".authNoApprove").css("color", "#A6ACB6");
                    $("#authApprove").css("color", "#ffff");
                    $(".authApprove").css("color", "#ffff");
                    $('#authNoApprove').addClass('sso-btn-hold');
                    document.getElementById("authApprove").classList.remove('sso-btn-hold');
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-clock" style="color: #FFC80A;"></i>&nbsp;&nbsp; รออนุมัติ</a>');
                  });
                  $(`#load_model`).modal('hide');
            }else if(data.res_code === '04'){
                $(`#load_model`).modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    // $("#authApprove").css("color", "#39414F");
                    // $(".authApprove").css("color", "#0AC37D");
                    // $("#authNoApprove").css("color", "#A6ACB6");
                    // $(".authNoApprove").css("color", "#A6ACB6");
                    $(`#load_model`).modal('hide');
                    $("#authApprove").css("color", "#ffff");
                    $(".authApprove").css("color", "#ffff");
                    $('#authNoApprove').addClass('sso-btn-hold');
                    document.getElementById("authApprove").classList.remove('sso-btn-hold');
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-times-circle" style="color: red;"></i>&nbsp;&nbsp; ไม่อนุมัติ</a>');
                });
                    $(`#load_model`).modal('hide');
            }else{
                //fail
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด : ผู้ใช้ยังไม่ได้ทำการอัพโหลดไฟล์",
                });
            }
        }
    });
    $(`#load_model`).modal('hide');
});
$(document).on('click', '#authNoApprove', function(){
    $(`#ShowModalRemarkAttachment`).modal('show');
    $(`#ShowModalAttachment`).modal('hide');
    $(".power").css("display", "none");
    $(".auth").css("display", "flex"); 
});
$(document).on('click', '#notation_seve', function(){
    let member_id = $(`#member_id`).val(); 
    let remark = $(`#remark_Attachment`).val(); 
    $(`#load_model`).modal('show');
    $.ajax({
        url: BASE_URL + _INDEX + "office/saveAttachment",
        method: "post",
        data: {authNoApprove: 1,member_id:member_id,remark:remark},
        success: function (result) {
            $(`#load_model`).modal('hide');
            let data = JSON.parse(result);
            if(data.res_code === '00'){
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    $(`#ShowModalRemarkAttachment`).modal('hide');
                    $(`#ShowModalAttachment`).modal('show');
                    // $("#authNoApprove").css("color", "#39414F");
                    // $(".authNoApprove").css("color", "red");
                    // $("#authApprove").css("color", "#A6ACB6");
                    // $(".authApprove").css("color", "#A6ACB6");
                    $("#authNoApprove").css("color", "#ffff");
                    $(".authNoApprove").css("color", "#ffff");
                    $('#authApprove').addClass('sso-btn-hold');
                    document.getElementById("authNoApprove").classList.remove('sso-btn-hold');
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-times-circle" style="color: red;"></i>&nbsp;&nbsp; ไม่อนุมัติ</a>');
                });
            }else{
                //fail
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด : ผู้ใช้ยังไม่ได้ทำการอัพโหลดไฟล์",
                });
            }
        }
    });
    $(`#load_model`).modal('hide');
});
$(document).on('click', '#powerApprove', function(){
    let member_id = $(`#member_id`).val();
    $(`#load_model`).modal('show');
    $.ajax({
        url: BASE_URL + _INDEX + "office/saveAttachment",
        method: "post",
        data: {powerApprove: 1,member_id:member_id},
        success: function (result) {
            $(`#load_model`).modal('hide');
            let data = JSON.parse(result);
            if(data.res_code === '02'){
                //อนุมัติแล้ว 2 file
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    $("#powerApprove").css("color", "#ffff");
                    $(".powerApprove").css("color", "#ffff");
                    $('#powerNoApprove').addClass('sso-btn-hold');
                    $(`#load_model`).modal('hide');
                    // $("#powerNoApprove").css("color", "#A6ACB6");
                    document.getElementById("powerApprove").classList.remove('sso-btn-hold');
                    // $(".powerNoApprove").css("color", "#A6ACB6");
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-check-circle" style="color: #0AC37D;"></i>&nbsp;&nbsp; อนุมัติแล้ว</a>');
                  });
            }else if(data.res_code === '03'){
                //รออนุมัติ
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    // $("#powerApprove").css("color", "#39414F");
                    // $(".powerApprove").css("color", "#0AC37D");
                    // $("#powerNoApprove").css("color", "#A6ACB6");
                    // $(".powerNoApprove").css("color", "#A6ACB6");
                    $(`#load_model`).modal('hide');
                    document.getElementById("powerApprove").classList.remove('sso-btn-hold');
                    $("#powerApprove").css("color", "#ffff");
                    $(".powerApprove").css("color", "#ffff");
                    $('#powerNoApprove').addClass('sso-btn-hold');
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-clock" style="color: #FFC80A;"></i>&nbsp;&nbsp; รออนุมัติ</a>');
                  });
            }else if(data.res_code === '04'){
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    // $("#powerApprove").css("color", "#39414F");
                    // $(".powerApprove").css("color", "#0AC37D");
                    // $("#powerNoApprove").css("color", "#A6ACB6");
                    // $(".powerNoApprove").css("color", "#A6ACB6");
                    $(`#load_model`).modal('hide');
                    $("#powerApprove").css("color", "#ffff");
                    $(".powerApprove").css("color", "#ffff");
                    $('#powerNoApprove').addClass('sso-btn-hold');
                    document.getElementById("powerApprove").classList.remove('sso-btn-hold');
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-times-circle" style="color: red;"></i>&nbsp;&nbsp; ไม่อนุมัติ</a>');
                });
            }else{
                //fail
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด : ผู้ใช้ยังไม่ได้ทำการอัพโหลดไฟล์",
                });
            }
        }
    });
    $(`#load_model`).modal('hide');
});
$(document).on('click', '#powerNoApprove', function(){
    $(`#ShowModalRemarkAttachment`).modal('show');
    $(`#ShowModalAttachment`).modal('hide');
    $(".auth").css("display", "none");
    $(".power").css("display", "flex"); 
});

$(document).on('click', '#power_notation_seve', function(){
    let member_id = $(`#member_id`).val(); 
    let remark = $(`#remark_power`).val(); 
    $(`#load_model`).modal('show');
    $.ajax({
        url: BASE_URL + _INDEX + "office/saveAttachment",
        method: "post",
        data: {powerNoApprove: 1,member_id:member_id,remark:remark},
        success: function (result) {
            $(`#load_model`).modal('hide');
            let data = JSON.parse(result);
            if(data.res_code === '00'){
                Swal.fire({
                    icon: "success",
                    title: "บันทึกสำเร็จ"
                }).then((result) => {
                    $(`#ShowModalRemarkAttachment`).modal('hide');
                    $(`#ShowModalAttachment`).modal('show');
                    $(`#load_model`).modal('hide');
                    // $("#authNoApprove").css("color", "#39414F");
                    // $(".authNoApprove").css("color", "red");
                    // $("#authApprove").css("color", "#A6ACB6");
                    // $(".authApprove").css("color", "#A6ACB6");
                    $("#powerNoApprove").css("color", "#ffff");
                    $(".powerNoApprove").css("color", "#ffff");
                    $('#powerApprove').addClass('sso-btn-hold');
                    document.getElementById("powerNoApprove").classList.remove('sso-btn-hold');
                    $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-times-circle" style="color: red;"></i>&nbsp;&nbsp; ไม่อนุมัติ</a>');
                });
            }else{
                    $(`#load_model`).modal('hide');
                    //fail
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด : ผู้ใช้ยังไม่ได้ทำการอัพโหลดไฟล์",
                });
            }
        }
    });
    $(`#load_model`).modal('hide');
});

$(document).on('change', '#file_authApprove', function(){
    let member_id = $(`#member_id`).val(); 
    let type = $(`#file_typeAuth`).val(); 
    let file = $(this)[0].files[0];
    var myformData = new FormData();
    myformData.append('file', file);
    myformData.append('member_id', member_id);
    myformData.append('type', type);
        $(`#load_model`).modal('show');
        $.ajax({
            url: BASE_URL + _INDEX + "office/upload_attach_file",
            type: 'POST',
            data:myformData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            success: function (result) {
                if(result.res_code === '00'){
                $(`#load_model`).modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: "บันทึกสำเร็จ"
                    }).then((result) => {
                        $(`#load_model`).modal('hide');
                        $(`#ShowModalAttachment`).modal('hide');
                        if(result.COUNT > 1){
                            $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-check-circle" style="color: #0AC37D;"></i>&nbsp;&nbsp; อนุมัติเเล้ว</a>');
                        }else{
                            $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-clock" style="color: #FFC80A;"></i>&nbsp;&nbsp; รออนุมัติ</a>');
                        }
                    });
                }else{
                    //fail
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด : ผู้ใช้ยังไม่ได้ทำการอัพโหลดไฟล์",
                    });
                }
            }
        });
        $(`#load_model`).modal('hide');
});
$(document).on('change', '#file_powerApprove', function(){
    let member_id = $(`#member_id`).val(); 
    let type = $(`#file_typePower`).val(); 
    let file = $(this)[0].files[0];
    var myformData = new FormData();
    myformData.append('file', file);
    myformData.append('member_id', member_id);
    myformData.append('type', type);
        $(`#load_model`).modal('show');
        $.ajax({
            url: BASE_URL + _INDEX + "office/upload_attach_file",
            type: 'POST',
            data:myformData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            async:true,
            success: function (result) {
                if(result.res_code === '00'){
                $(`#load_model`).modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: "บันทึกสำเร็จ"
                    }).then((results) => {
                        $(`#load_model`).modal('hide');
                        $(`#ShowModalAttachment`).modal('hide');
                        if(result.COUNT > 1){
                            $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-check-circle" style="color: #0AC37D;"></i>&nbsp;&nbsp; อนุมัติเเล้ว</a>');
                        }else{
                            $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-clock" style="color: #FFC80A;"></i>&nbsp;&nbsp; รออนุมัติ</a>');
                        }
                    });
                }else{
                    //fail
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด : ผู้ใช้ยังไม่ได้ทำการอัพโหลดไฟล์",
                    });
                }
            }
        });
        $(`#load_model`).modal('hide');
});

$(document).on('change', '#file_renameApprove', function(){
    let member_id = $(`#member_id`).val(); 
    let type = $(`#file_typeRename`).val(); 
    let file = $(this)[0].files[0];
    var myformData = new FormData();
    myformData.append('file', file);
    myformData.append('member_id', member_id);
    myformData.append('type', type);
        $(`#load_model`).modal('show');
        $.ajax({
            url: BASE_URL + _INDEX + "office/upload_attach_file",
            type: 'POST',
            data:myformData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            async:true,
            success: function (result) {
                if(result.res_code === '00'){
                $(`#load_model`).modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: "บันทึกสำเร็จ"
                    }).then((results) => {
                        $(`#load_model`).modal('hide');
                        $(`#ShowModalAttachment`).modal('hide');
                        $('#status_name').empty().append('<a id="status_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-check-circle" style="color: #0AC37D;"></i>&nbsp;&nbsp; อนุมัติเเล้ว</a>');
                    });
                }else{
                    //fail
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด : ผู้ใช้ยังไม่ได้ทำการอัพโหลดไฟล์",
                    });
                }
            }
        });
        $(`#load_model`).modal('hide');
});


$(document).on('keyup', '#search', function () {
    $('.sso-table').bootstrapTable('refresh');
})

$(document).on('change', '#select_status', function () {
    $('.sso-table').bootstrapTable('refresh');
})
$(document).on('change', '#select_verify', function () {
    $('.sso-table').bootstrapTable('refresh');
}) 
$(document).on('change', '#select_director', function () {
    $('.sso-table').bootstrapTable('refresh');
})

$(document).on('click', '.edit-pass', function(){
    // console.log($(this).attr('member-id'))
    let id = $(this).attr('member-id')
    let name = $(this).attr('member-name')
    $('#name_edit').html(name)
    $(`#member_id`).val(id)
    $(`#type`).val(name)
})
$(document).on('click','.reset_save', function(){
    let password = $('#password').val();
    let repassword = $('#repassword').val();
    let member_id = $(`#member_id`).val();
    let type = $(`#type`).val();
    let letters = /[A-Za-z]+/;

    // -- รหัสผ่าน -- //
    if(password == ""){
        Swal.fire({
            icon: "info",
            title: `รหัสผ่าน : กรุณากรอกข้อมูล`,
            //text: obj.message,
        });
        return false;
    }
    if(password.length < 8){
        Swal.fire({
            icon: "info",
            title: `รหัสผ่าน : อย่างน้อย 8 ตัว`,
            //text: obj.message,
        });
        return false;
    }
    if(letters.test(password) == false){
        Swal.fire({
            icon: "info",
            title: `รหัสผ่าน : อักษร a - z อย่างน้อย 1 ตัว`,
            //text: obj.message,
        });
        return false;
    }

    //-- เช็ครหัสผ่าน --//
    if(repassword == ""){
        Swal.fire({
            icon: "info",
            title: `ยืนยันรหัสผ่าน : กรุณากรอกข้อมูล`,
            //text: obj.message,
        });
        return false;
    }
    if(repassword.length < 8){
        Swal.fire({
            icon: "info",
            title: `ยืนยันรหัสผ่าน : อย่างน้อย 8 ตัว`,
            //text: obj.message,
        });
        return false;
    }

    if(!letters.test(repassword)){
        Swal.fire({
            icon: "info",
            title: `ยืนยันรหัสผ่าน : อักษร a - z อย่างน้อย 1 ตัว`,
            //text: obj.message,
        });
        return false;
    }

    //-- เช็คตรงกัน --
    if(password != repassword){
        Swal.fire({
            icon: "error",
            title: `เกิดข้อผิดพลาด : ยืนยันรหัสผ่านไม่ตรงกัน`,
            //text: obj.message,
        });
        return false;
    }
    //window.location.reload();
    $.ajax({
        type: "post",
        url: BASE_URL + 'office/edit_password', 
        data: {password : password, member_id : member_id, type : type},
        success: function (response) {
            let data = JSON.parse(response)
            // console.log(data)
            $(`#ShowModal`).modal('hide')
            if(data.res_code === '00'){
                Swal.fire({
                    icon: "success",
                    title: `บันทึกข้อมูลสำเร็จ`,
                    //text: obj.message,
                }).then(function(){
                    window.location.reload();
                })
            }else{
                Swal.fire({
                    icon: "error",
                    title: `เกิดข้อผิดพลาด : `+data.res_text,
                    //text: obj.message,
                }).then(function(){
                    window.location.reload();
                })
            }
            
        }
    });
})
$(document).on('click', '#note_seve', function(){
    let member_id = $(`#member_id`).val();
    let note_member = $(`#note_member`).val();
    // console.log("ผ่าน",note_member,member_id);
    $.ajax({
        type: "post",
        url: BASE_URL + 'office/edit_note', 
        data: {note : note_member, member_id : member_id},
        success: function (response) {
            let data = JSON.parse(response)
            // console.log("ผ่าน",data);
            if(data.res_code === '200'){
                Swal.fire({
                    icon: "success",
                    title: `บันทึกโน๊ตสำเร็จ`,
                    //text: obj.message,
                })
                // .then(function(){
                //     window.location.reload();
                // })
            }else{
                Swal.fire({
                    icon: "error",
                    title: `เกิดข้อผิดพลาด : บันทึกโน๊ตไม่สำเร็จ`,
                    //text: obj.message,
                })
                // .then(function(){
                //     window.location.reload();
                // })
            }
            
        }
    });
})

$(document).on('click','.btn-danger-delete', function(){
    let member_id = $(`#member_id`).val();
    let type = $(`[name=type]`).val();
    if(type == "corporate"){
        member_id = $(`[name=member_id]`).val();
    }else if(type == "person"){
        member_id = $(`[name=member_id]`).val();
    }
    Swal.fire({
        title: 'ต้องการลบข้อมูลหรือไม่?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: ' ยกเลิก',
        confirmButtonText: ' ตกลง'
      }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: BASE_URL + 'office/delete_user', 
                data: {type : type,member_id : member_id},
                success: function (response) {
                    let data = JSON.parse(response)
                    $(`#ShowModal`).modal('hide')
                    if(data.res_code === true){
                        Swal.fire({
                            icon: "success",
                            title: `ลบข้อมูลสำเร็จ`,
                            //text: obj.message,
                        }).then(function(){
                            window.location.href = BASE_URL + _INDEX + 'office/user?type='+type;
                        })
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: `เกิดข้อผิดพลาด : `+data.res_text,
                            //text: obj.message,
                        }).then(function(){
                            window.location.reload();
                        })
                    }
                    
                }
            });
        }
      })
});
function searchQueryParams(params) {
    // console.log(params);
    // params.type = $(`#select_type`).val();
    params.text_search = $(`#search`).val();
    params.status = $(`#select_status`).val();
    params.verify = $(`#select_verify`).val();
    params.director = $(`#select_director`).val();
    return params; // body data

}
function select_type(){
    $('.sso-table').bootstrapTable('refresh');
}

function select_status(){
    $('.sso-table').bootstrapTable('refresh');
}


$(document).on('click', '#show-pass', function(){
  let type = $(`input[name="password"]`).attr("type");
  if(type == 'password'){
    $(`input[name="password"]`).attr("type", "text");
    $(this).attr("class", "fa fa-eye icon-password");
  }else{
    $(`input[name="password"]`).attr("type", "password");
    $(this).attr("class", "fa fa-eye-slash icon-password");
  }
 
})

$(document).on('click', '#show-repass', function(){
  let type = $(`input[name="repassword"]`).attr("type");
  if(type == 'password'){
    $(`input[name="repassword"]`).attr("type", "text");
    $(this).attr("class", "fa fa-eye icon-password");
  }else{
    $(`input[name="repassword"]`).attr("type", "password");
    $(this).attr("class", "fa fa-eye-slash icon-password");
  }
 
})
