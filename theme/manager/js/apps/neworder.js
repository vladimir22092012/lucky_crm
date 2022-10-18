;function NeworderApp()
{
    var app = this;
    
    app.debug = 1;
    
    app.$input = {};
    
    var _init = function(){
        
        app.$input.user = $('.js-user-input');
        
        app.$input.user_id = $('.js-user-id-input');

        app.$input.phone = $('.js-phone-input');
        app.$input.email = $('.js-email-input');
        
        app.$input.percent = $('.js-percent-input');
        app.$input.charge = $('.js-charge-input');
//        app.$input.insure = $('.js-insure-input');
        
        app.$input.lastname = $('.js-lastname-input');
        app.$input.firstname = $('.js-firstname-input');
        app.$input.patronymic = $('.js-patronymic-input');
        app.$input.gender = $('.js-gender-input');
        app.$input.birth = $('.js-birth-input');
        app.$input.birth_place = $('.js-birth-place-input');

        app.$input.passport_serial = $('.js-passport-serial-input');
        app.$input.passport_date = $('.js-passport-date-input');
        app.$input.subdivision_code = $('.js-subdivision-code-input');
        app.$input.passport_issued = $('.js-passport-issued-input');
        
        app.$input.equal_address = $('.js-equal-address');
        
        app.$input.regregion = $('.js-regregion-input');
        app.$input.regregion_type = $('.js-regregion-type-input');
        app.$input.regdistrict = $('.js-regdistrict-input');
        app.$input.regdistrict_type = $('.js-regdistrict-type-input');
        app.$input.regcity = $('.js-regcity-input');
        app.$input.regcity_type = $('.js-regcity-type-input');
        app.$input.reglocality = $('.js-reglocality-input');
        app.$input.reglocality_type = $('.js-reglocality-type-input');
        app.$input.regstreet = $('.js-regstreet-input');
        app.$input.regstreet_type = $('.js-regstreet-type-input');
        app.$input.regindex = $('.js-regindex-input');
        app.$input.reghousing = $('.js-reghousing-input');
        app.$input.regbuilding = $('.js-regbuilding-input');
        app.$input.regroom = $('.js-regroom-input');

        app.$input.faktregion = $('.js-faktregion-input');
        app.$input.faktregion_type = $('.js-faktregion-type-input');
        app.$input.faktdistrict = $('.js-faktdistrict-input');
        app.$input.faktdistrict_type = $('.js-faktdistrict-type-input');
        app.$input.faktcity = $('.js-faktcity-input');
        app.$input.faktcity_type = $('.js-faktcity-type-input');
        app.$input.faktlocality = $('.js-faktlocality-input');
        app.$input.faktlocality_type = $('.js-faktlocality-type-input');
        app.$input.faktstreet = $('.js-faktstreet-input');
        app.$input.faktstreet_type = $('.js-faktstreet-type-input');
        app.$input.faktindex = $('.js-faktindex-input');
        app.$input.fakthousing = $('.js-fakthousing-input');
        app.$input.faktbuilding = $('.js-faktbuilding-input');
        app.$input.faktroom = $('.js-faktroom-input');

        app.$input.workplace = $('.js-workplace-input');
        app.$input.profession = $('.js-profession-input');
        app.$input.workaddress = $('.js-workaddress-input');
        app.$input.workphone = $('.js-workphone-input');
        app.$input.income = $('.js-income-input');
        app.$input.expenses = $('.js-expenses-input');
        app.$input.chief_name = $('.js-chief-name-input');
        app.$input.chief_position = $('.js-chief-position-input');
        app.$input.chief_phone = $('.js-chief-phone-input');
        app.$input.workcomment = $('.js-workcomment-input');

        app.$input.contactperson_name = $('.js-contactperson-name-input');
        app.$input.contactperson_relation = $('.js-contactperson-relation-input');
        app.$input.contactperson_phone = $('.js-contactperson-phone-input');
        app.$input.contactperson2_name = $('.js-contactperson2-name-input');
        app.$input.contactperson2_relation = $('.js-contactperson2-relation-input');
        app.$input.contactperson2_phone = $('.js-contactperson2-phone-input');

//        app.$input. = $('.js--input');
//        app.$input. = $('.js--input');
        
    };
    
    var _init_user_autocomplete = function(){
        app.$input.user.autocomplete({
            serviceUrl:'ajax/search_users.php',
      		minChars:1,
            noCache: true,
            onSelect: function(suggestion){
                
                set_user(suggestion.data);
                
                if (app.debug)
                    console.info('users', suggestion);
    		},
            formatResult: function(suggestion, currentValue){
    		    var res = '<div>';
                
    		    res += '<b>'+suggestion.data.lastname+' '+suggestion.data.firstname+' '+suggestion.data.patronymic+' </b>';
    		    res += '<small> '+suggestion.data.birth+'</small>';
    		    res += '<br /><span class="text-primary"><b>'+suggestion.data.phone_mobile+'</b></span>';
    		    res += '</div>';
                return res;
    		}          
        });        
    };
    
    var _init_copy_address = function(){
        app.$input.equal_address.change(function(){
            if ($(this).is(':checked'))
            {
                copy_address();
            }
            else
            {
                rid_address();
            }
        })
    };
    
    var rid_address = function(){
        app.$input.faktregion.removeAttr('readonly');
        app.$input.faktregion_type.removeAttr('readonly');
        app.$input.faktdistrict.removeAttr('readonly');
        app.$input.faktdistrict_type.removeAttr('readonly');
        app.$input.faktcity.removeAttr('readonly');
        app.$input.faktcity_type.removeAttr('readonly');
        app.$input.faktlocality.removeAttr('readonly');
        app.$input.faktlocality_type.removeAttr('readonly');
        app.$input.faktstreet.removeAttr('readonly');
        app.$input.faktstreet_type.removeAttr('readonly');
        app.$input.faktindex.removeAttr('readonly');
        app.$input.fakthousing.removeAttr('readonly');
        app.$input.faktbuilding.removeAttr('readonly');
        app.$input.faktroom.removeAttr('readonly');       
    };
    
    var copy_address = function(){
        app.$input.faktregion.val(app.$input.regregion.val()).attr('readonly', true);
        app.$input.faktregion_type.val(app.$input.regregion_type.val()).attr('readonly', true);
        app.$input.faktdistrict.val(app.$input.regdistrict.val()).attr('readonly', true);
        app.$input.faktdistrict_type.val(app.$input.regdistrict_type.val()).attr('readonly', true);
        app.$input.faktcity.val(app.$input.regcity.val()).attr('readonly', true);
        app.$input.faktcity_type.val(app.$input.regcity_type.val()).attr('readonly', true);
        app.$input.faktlocality.val(app.$input.reglocality.val()).attr('readonly', true);
        app.$input.faktlocality_type.val(app.$input.reglocality_type.val()).attr('readonly', true);
        app.$input.faktstreet.val(app.$input.regstreet.val()).attr('readonly', true);
        app.$input.faktstreet_type.val(app.$input.regstreet_type.val()).attr('readonly', true);
        app.$input.faktindex.val(app.$input.regindex.val()).attr('readonly', true);
        app.$input.fakthousing.val(app.$input.reghousing.val()).attr('readonly', true);
        app.$input.faktbuilding.val(app.$input.regbuilding.val()).attr('readonly', true);
        app.$input.faktroom.val(app.$input.regroom.val()).attr('readonly', true);
    }
    
    var set_user = function(data){
        
        if (!!data.id) app.$input.user_id.val(data.id);

        if (!!data.phone_mobile) app.$input.phone.val(data.phone_mobile);
        if (!!data.email) app.$input.email.val(data.email);

        if (!!data.lastname) app.$input.lastname.val(data.lastname);
        if (!!data.firstname) app.$input.firstname.val(data.firstname);
        if (!!data.patronymic) app.$input.patronymic.val(data.patronymic);
        if (!!data.gender) app.$input.gender.find('[value='+data.gender+']').attr('selected', true);
        if (!!data.birth) app.$input.birth.val(data.birth);
        if (!!data.birth_place) app.$input.birth_place.val(data.birth_place);
        
        if (!!data.passport_serial) app.$input.passport_serial.val(data.passport_serial);
        if (!!data.passport_date) app.$input.passport_date.val(data.passport_date);
        if (!!data.subdivision_code) app.$input.subdivision_code.val(data.subdivision_code);
        if (!!data.passport_issued) app.$input.passport_issued.val(data.passport_issued);

        if (!!data.Regregion) app.$input.regregion.val(data.Regregion);
        if (!!data.Regregion_shorttype) app.$input.regregion_type.val(data.Regregion_shorttype);
        if (!!data.Regcity) app.$input.regcity.val(data.Regcity);
        if (!!data.Regcity_shorttype) app.$input.regcity_type.val(data.Regcity_shorttype);
        if (!!data.Regdistrict) app.$input.regdistrict.val(data.Regdistrict);
        if (!!data.Regdistrict_shorttype) app.$input.regdistrict_type.val(data.Regdistrict_shorttype);
        if (!!data.Reglocality) app.$input.reglocality.val(data.Reglocality);
        if (!!data.Reglocality_shorttype) app.$input.reglocality_type.val(data.Reglocality_shorttype);
        if (!!data.Regstreet) app.$input.regstreet.val(data.Regstreet);
        if (!!data.Regstreet_shorttype) app.$input.regstreet_type.val(data.Regstreet_shorttype);
        if (!!data.Reghousing) app.$input.reghousing.val(data.Reghousing);
        if (!!data.Regbuilding) app.$input.regbuilding.val(data.Regbuilding);
        if (!!data.Regroom) app.$input.regroom.val(data.Regroom);

        if (!!data.Faktregion) app.$input.faktregion.val(data.Faktregion);
        if (!!data.Faktregion_shorttype) app.$input.faktregion_type.val(data.Faktregion_shorttype);
        if (!!data.Faktcity) app.$input.faktcity.val(data.Faktcity);
        if (!!data.Faktcity_shorttype) app.$input.faktcity_type.val(data.Faktcity_shorttype);
        if (!!data.Faktdistrict) app.$input.faktdistrict.val(data.Faktdistrict);
        if (!!data.Faktdistrict_shorttype) app.$input.faktdistrict_type.val(data.Faktdistrict_shorttype);
        if (!!data.Faktlocality) app.$input.faktlocality.val(data.Faktlocality);
        if (!!data.Faktlocality_shorttype) app.$input.faktlocality_type.val(data.Faktlocality_shorttype);
        if (!!data.Faktstreet) app.$input.faktstreet.val(data.Faktstreet);
        if (!!data.Faktstreet_shorttype) app.$input.faktstreet_type.val(data.Faktstreet_shorttype);
        if (!!data.Fakthousing) app.$input.fakthousing.val(data.Fakthousing);
        if (!!data.Faktbuilding) app.$input.faktbuilding.val(data.Faktbuilding);
        if (!!data.Faktroom) app.$input.faktroom.val(data.Faktroom);

        if (!!data.workplace) app.$input.workplace.val(data.workplace);
        if (!!data.profession) app.$input.profession.val(data.profession);
        if (!!data.workaddress) app.$input.workaddress.val(data.workaddress);
        if (!!data.workphone) app.$input.workphone.val(data.workphone);
        if (!!data.income) app.$input.income.val(data.income);
        if (!!data.expenses) app.$input.expenses.val(data.expenses);
        if (!!data.chief_name) app.$input.chief_name.val(data.chief_name);
        if (!!data.chief_position) app.$input.chief_position.val(data.chief_position);
        if (!!data.chief_phone) app.$input.chief_phone.val(data.chief_phone);
        if (!!data.workcomment) app.$input.workcomment.val(data.workcomment);

        if (!!data.contact_person_name) app.$input.contactperson_name.val(data.contact_person_name);
        if (!!data.contact_person_relation) app.$input.contactperson_relation.val(data.contact_person_relation);
        if (!!data.contact_person_phone) app.$input.contactperson_phone.val(data.contact_person_phone);
        if (!!data.contact_person2_name) app.$input.contactperson2_name.val(data.contact_person2_name);
        if (!!data.contact_person2_relation) app.$input.contactperson2_relation.val(data.contact_person2_relation);
        if (!!data.contact_person2_phone) app.$input.contactperson2_phone.val(data.contact_person2_phone);

    };
    
    var _init_masks = function(){        
        $('.js-mask-input').each(function(){
            var _mask = $(this).data('mask');
            $(this).inputmask(_mask)
        })
    };
    
    var _init_loantypes = function(){
        $('.js-select-loantype').change(function(){
            var $option = $(this).find('option:selected');
        
            var _params = $option.data('params')

            app.$input.percent.val(_params.percent);
            app.$input.charge.val(_params.charge);
//            app.$input.insure.val(_params.insure);
            
            if (_params.bot_inform > 0)
                $('#bot_inform').attr('checked', true).val(_params.bot_inform).closest('.form-group').show()                
            else
                $('#bot_inform').removeAttr('checked').val(0).closest('.form-group').hide()

            if (_params.sms_inform > 0)
                $('#sms_inform').attr('checked', true).val(_params.sms_inform).closest('.form-group').show()                
            else
                $('#sms_inform').removeAttr('checked').val(0).closest('.form-group').hide()
            
console.log(_params)            
        });
    };
    
    var _init_get_uid = function(){
        $('.js-lastname-input, .js-firstname-input, .js-patronymic-input, .js-birth-input').blur(function(){
            if (app.$input.lastname.val() != '' && app.$input.firstname.val() != '' && app.$input.patronymic.val() != '' && app.$input.birth.val() != '')
            {
                $.ajax({
                    url: 'ajax/get_info.php',
                    data: {
                        action: 'offline_user',
                        lastname: app.$input.lastname.val(),
                        firstname: app.$input.firstname.val(),
                        patronymic: app.$input.patronymic.val(),
                        birth: app.$input.birth.val(),
                    },
                    beforeSend: function(){
                        $('form').addClass('loading');
                    },
                    success: function(resp){
                        console.log(resp);
                        $('form').removeClass('loading');
                        
                        set_user(resp.format);
                    }
                });
            }
        })
        app.$input.lastname = $('.js-lastname-input');
        app.$input.firstname = $('.js-firstname-input');
        app.$input.patronymic = $('.js-patronymic-input');
        app.$input.birth = $('.js-birth-input');

    };
    
    ;(function(){
        _init();
        _init_user_autocomplete();
        _init_masks();
        _init_copy_address();
        _init_get_uid();
        _init_loantypes();
    })();
};

$(function(){
    new NeworderApp();
});