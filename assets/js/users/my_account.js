$(document).ready(function() {
    $('#tabs').tab();
    $(document).off('click',".withdraw-submit").on('click','.withdraw-submit',function(){
        $(".remove-alert").remove();
        var Emailflag = validateEmail();
        if(!Emailflag)
            return false;
        $(this).prop('disabled', true);
        $that = $(this);
        $(".withdraw-submit").html('<span class="saving">Verifying Email<span>.</span><span>.</span><span>.</span></span>');
        var $form = $("#withdraw-amount");
        $.ajax({
            type:'post',
            data:$form.serialize(),
            url:siteURL+'/account/paypal_email_check',
            success:function(resp){
                if(!resp.success){
                    $("#withdraw-amount").prepend('<div class="remove-alert alert alert-danger">' +
                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                        '<strong>Error!</strong> '+resp.message+
                        '</div>')
                    $(".withdraw-submit").html('<span class="withdraw-text">Verify Email</span>');
                    $that.prop('disabled', false);
                }
                else{
                    $(".amount-field").show();
                    $(".withdraw-submit").html('<span class="withdraw-text">Withdraw</span>');
                    $(".withdraw-submit").addClass('withdraw-amount-btn').removeClass('withdraw-submit');
                    $that.prop('disabled', false);
                }
            }
        });
        return false;

    });

    $(document).off('click',".withdraw-amount-btn").on('click','.withdraw-amount-btn',function(){
        $(".remove-alert").remove();
        var $form = $("#withdraw-amount");
        var Emailflag = validateEmail();
        var amountFlag = validateAmount();
        if(!Emailflag)
            return false;
        if(!amountFlag)
            return false;

        $(this).prop('disabled', true);
        $(".withdraw-amount-btn").html('<span class="saving">Submitting<span>.</span><span>.</span><span>.</span></span>');
        $.ajax({
            type:'post',
            data:$form.serialize(),
            url:siteURL+'/account/withdraw',
            success:function(resp){
                if(!resp.success){
                    var html = '';
                    $.each(resp.errors,function(index,val){
                        html+="<span>"+val+"</span>";
                    })
                    var errorHTML = '<div class="remove-alert alert alert-danger">'+
                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+html
                    '</div>';
                    $form.prepend(errorHTML);
                    $that.prop('disabled', false);
                    $(".withdraw-amount-btn").html('<span class="withdraw-text">Withdraw</span>');
                }
                else
                {
                    $form.find("input,select").val('');
                    var errorHTML = '<div class="remove-alert alert alert-success">'+
                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                        '<strong>Success!!!</strong> Amount transfered successfully.'+
                        '</div>';
                    $form.prepend(errorHTML);
                    $that.prop('disabled', false);
                    $(".amount-field").hide();
                    $(".donation_received").html(resp.availableBalance);
                    $(".withdraw-amount-btn").addClass('withdraw-submit').removeClass('withdraw-amount-btnt').html('<span class="withdraw-text">Verify Email</span>');
                }
            }
        });
        return false;
    });

    $('[data-numeric]').payment('restrictNumeric');
    $('.cc-number').payment('formatCardNumber');
    $('.cc-cvc').payment('formatCardCVC');
    $.fn.toggleInputError = function(erred) {
        this.parents('.form-row').toggleClass('has-error', erred);
        return this;
    };

    $('.update-creditcard').on('click',function() {
        $(".remove-alert").remove();
        var $form = $('#new-credit-card-form');
        var cardType = $.payment.cardType($('.cc-number').val());
        $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
        //$('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
        $('[name="exp_month"]').toggleInputError(!$.payment.validateCardExpiry($("[name='exp_month']").val(),
            $("[name='exp_year']").val()));
        $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));
        $("#cc-card-type").toggleInputError(!$.payment.validateCardType($('#cc-card-type').val()));
        $('.cc-brand').text(cardType);
        if($('.has-error').length == 0){
            $(this).prop('disabled', true);
            $that = $(this);
            $that.html('<span class="saving">Updating<span>.</span><span>.</span><span>.</span></span>');
            $.ajax({
                type:'post',
                data:$form.serialize(),
                url:siteURL+'/account/update-creditcard',
                success:function(resp){
                    if(!resp.success){
                        var html = '';
                        $.each(resp.errors,function(index,val){
                            html+="<span>"+val+"</span>";
                        })
                        var errorHTML = '<div class="remove-alert alert alert-danger">'+
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+html
                        '</div>';
                        $form.prepend(errorHTML);
                        $that.prop('disabled', false);
                        $that.html('Update Details');
                    }
                    else{
                        var errorHTML = '<div class="remove-alert alert alert-success">'+
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                            '<strong>Success!!!</strong> Credit card details updated'+
                        '</div>';
                        $form.prepend(errorHTML);
                        $form.find('input').val('');
                        $that.prop('disabled', false);
                        $that.html('Update Details');
                    }
                }
            });
        }
    });

    $("#cc-number").on('keyup',function(){
        var cardType = $.payment.cardType($(this).val());

        if($.trim(cardType) != "" && cardType != 'null')
            $(".card_image").html('<img src="'+url+'/'+cardType+'.png" height="30px;">');
        else
            $(".card_image").html('');

    })

    $("[name='amount_from_available_bal']").on('keyup keydown',function(e){
        var val = $(this).val();
        if(val < avlblamt)
            $(".availableLabel").html(avlblamt-val);
        else{
            $(".availableLabel").html(0);
            $(this).val(avlblamt);
        }
    })

    $("[name='credit_available_bal']").on('click',function(){
        var val = $(this).val();
        $(".donationDiv").hide();
        $("."+val).show();
    });

    $("#pay_now").on('click',function(){
        var amount = $("[name='amount_from_available_bal']").val();
        if($.trim(amount) == "" || (amount != avlblamt && amount > avlblamt )){
            $("[name='amount_from_available_bal']").parent('div').addClass('has-error');
            return false;
        }
    });

    //change card number on selected card
    /*$("[name='credit_cards']").on('change',function(){
        var val =$(this).val();
        if(val == "")
            $("[name='card_number']").val('');
        else{
            $loading.show();
            $.ajax({
                type:'get',
                data:{last4:val},
                url:siteURL+'/funds/get-card-name',
                success:function(resp){
                    if($.trim(resp) != ""){
                        $(".reused_card_image").html('<img src="'+siteURL+'/assets/images/'+resp+'" style="height:40px;"/>');
                    }
                    else
                        $(".reused_card_image").html('');
                    $loading.hide();
                }
            });
            $("[name='card_number']").val('XXXX XXXX XXXX '+val);
        }
        return false;
    });*/


    $("#country").on('change',function(){
        var value = $(this).val();
        var token = $('[name="_token"]').val();
        if($.trim(value) == "" && value != 247){
            $("#state").html('<option value="">Select</option>').select2({allowClear:true,placeholder:"Select State"});
            $("#city").html('<option value="">Select</option>').select2({allowClear:true,placeholder:"Select City"});
            $("#state").prop('disabled',false);
            $("#city").prop('disabled',false);
        }
        else if($.trim(value) == 247){
            $("#state").prop('disabled',true);
            $("#city").prop('disabled',true);
            return false;
        }
        else
        {

            $(".states_loader.location_loader").show();
            $("#state").prop('disabled',true);
            $("#city").prop('disabled',true);
            $.ajax({
                type:'POST',
                url:siteURL+'/units/get_state',
                dataType:'json',
                async:true,
                data:{country_id:value,_token:token },
                success:function(resp){
                    $(".states_loader.location_loader").hide();
                    $("#state").prop('disabled',false);
                    $("#city").prop('disabled',false);
                    if(resp.success){
                        var html='<option value="">Select</option>';
                        $.each(resp.states,function(index,val){
                            html+='<option value="'+index+'">'+val+'</option>'
                        });
                        $("#state").html(html).select2({allowClear:true,placeholder:"Select State"});
                    }
                }
            })
        }
    });

    //get state after selecting country
    $("#state").on('change',function(){
        var value = $(this).val();
        var token = $('[name="_token"]').val();
        if($.trim(value) == ""){
            $("#city").html('<option value="">Select</option>').select2({allowClear:true,placeholder:"Select City"});
            $("#city").prop('disabled',false);
        }
        else
        {
            $(".cities_loader.location_loader").show();
            $("#city").prop('disabled',true);
            $.ajax({
                type:'POST',
                url:siteURL+'/units/get_city',
                dataType:'json',
                async:true,
                data:{state_id:value,_token:token },
                success:function(resp){
                    $(".cities_loader.location_loader").hide();
                    $("#city").prop('disabled',false);
                    if(resp.success){
                        var html='<option value="">Select</option>';
                        $.each(resp.cities,function(index,val){
                            html+='<option value="'+index+'">'+val+'</option>'
                        });
                        $("#city").html(html).select2({allowClear:true,placeholder:"Select City"});
                    }
                }
            })
        }
    });

    $("#country").select2({
        theme: "bootstrap",
        placeholder:"Select Country",
        templateResult:format,
        escapeMarkup: function(m) {
            return m;
        }
    });

    $("#state").select2({
        theme: "bootstrap",
        placeholder:"Select State"
    });

    $("#city").select2({
        theme: "bootstrap",
        placeholder:"Select City"
    });
});

function validateEmail(){
    var email=$("#paypal_email").val();
    if($.trim(email) =="")
    {
        $("#paypal_email").closest('.col-sm-4').addClass('has-error');
        var icon = $("#paypal_email").parent('.input-icon').children('i');
        icon.removeClass('fa-check').addClass("fa-warning");
        icon.attr("data-original-title", 'Please enter paypal email').tooltip({'container': 'body'});
        return false;
    }
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var flag = re.test(email);
    if(!flag){
        $("#paypal_email").closest('.col-sm-4').addClass('has-error');
        var icon = $("#paypal_email").parent('.input-icon').children('i');
        icon.removeClass('fa-check').addClass("fa-warning");
        icon.attr("data-original-title", 'Email address is invalid').tooltip({'container': 'body'});
        return false;
    }
    var icon = $("#paypal_email").parent('.input-icon').children('i');
    $("#paypal_email").closest('.col-sm-4').removeClass('has-error').addClass('has-success'); // set success class to the control group
    icon.removeClass("fa-warning").addClass("fa-check");
    return true;
}

function validateAmount(){
    var amount=$("#cc-amount").val();
    if($.trim(amount) =="")
    {
        $("#cc-amount").closest('.col-sm-4').addClass('has-error');
        var icon = $("#cc-amount").parent('.input-icon').children('i');
        icon.removeClass('fa-check').addClass("fa-warning");
        icon.attr("data-original-title", 'Please enter amount').tooltip({'container': 'body'});
        return false;
    }

    if(isNaN(amount)){
        $("#cc-amount").closest('.col-sm-4').addClass('has-error');
        var icon = $("#cc-amount").parent('.input-icon').children('i');
        icon.removeClass('fa-check').addClass("fa-warning");
        icon.attr("data-original-title", 'Amount must be numeric only').tooltip({'container': 'body'});
        return false;
    }
    var icon = $("#cc-amount").parent('.input-icon').children('i');
    $("#cc-amount").closest('.col-sm-4').removeClass('has-error').addClass('has-success'); // set success class to the control group
    icon.removeClass("fa-warning").addClass("fa-check");
    return true;
}
function format(country) {
    if (country.id == "dash_line1" || country.id == "dash_line"){
        // return ' <span><img src="'+horiz_line+'" style="width:100%"></span> ';
        return '<hr style="margin:0px;">';
    }
    else
        return country.text;
}

