var FormValidation = function () {

    // validation using icons
    var handleValidation = function() {

        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form_withdraw = $('#withdraw-amount');
        var error2 = $('.alert-danger', form_withdraw);
        var success2 = $('.alert-success', form_withdraw);

        form_withdraw.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                paypal_email: {
                    required: true,
                    email:true
                },
                "cc-amount": {
                    required: true,
                    number:true
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success2.hide();
                error2.show();
                App.scrollTo(error2, -200);
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                var field_name = $(element).attr('name');
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.col-sm-4').removeClass("has-success").addClass('has-error'); // set error class to the control group

            },

            unhighlight: function (element) { // revert the change done by hightlight

            },

            success: function (label, element) {
                var field_name = $(element).attr('name');
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.col-sm-4').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },

            submitHandler: function (form) {
                success2.show();
                error2.hide();

                $(form).find('.withdraw-submit').prop('disabled', true);
                $(".withdraw-submit").html('<span class="saving">Checking Email<span>.</span><span>.</span><span>.</span></span>');
                $.ajax({
                    type:'post',
                    data:$(form).serialize(),
                    url:siteURL+'/account/paypal_email_check',
                    success:function(resp){
                        if(!resp.success){
                            console.log(resp);
                            $("#withdraw-amount").prepend('<div class="alert alert-danger">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                '<strong>Error!</strong> '+resp.message+
                                '</div>')
                            $(".withdraw-submit").html('<span class="withdraw-text">Withdraw</span>');
                            $(form).find('.withdraw-submit').prop('disabled', false);
                            /*var icon = $("#paypal_email").parent('.input-icon').children('i');
                            $("#paypal_email").closest('.col-sm-4').removeClass('has-success').addClass('has-error'); // set success class to the control group
                            icon.removeClass("fa-check").addClass("fa-warning");
                            icon.attr("data-original-title", 'Email does not exist in paypal.').tooltip({'container': 'body'});*/
                        }
                        else{
                            $(".withdraw-submit").html('<span class="saving">Submitting<span>.</span><span>.</span><span>.</span></span>');
                            form.submit(); // submit the form
                        }
                    }
                });
                return false;
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleValidation();
        }
    };

}();

$(document).ready(function() {
    $('#tabs').tab();
    FormValidation.init();

    $('[data-numeric]').payment('restrictNumeric');
    $('.cc-number').payment('formatCardNumber');
    $('.cc-cvc').payment('formatCardCVC');
    $.fn.toggleInputError = function(erred) {
        this.parents('.form-row').toggleClass('has-error', erred);
        return this;
    };

    $('#new-credit-card-form').submit(function(e) {
        e.preventDefault();
        var $form = $('#new-credit-card-form');
        var cardType = $.payment.cardType($('.cc-number').val());
        $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
        //$('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
        $('[name="exp_month"]').toggleInputError(!$.payment.validateCardExpiry($("[name='exp_month']").val(),
            $("[name='exp_year']").val()));
        $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));
        $("#cc-card-type").toggleInputError(!$.payment.validateCardType($('#cc-card-type').val()));
        $('.cc-brand').text(cardType);
        $('.validation').removeClass('text-danger text-success');
        if($('.has-error').length == 0){
            $(this).find('.submit').prop('disabled', true);
            $form.get(0).submit();
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
    $("[name='credit_cards']").on('change',function(){
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
    });


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

function format(country) {
    if (country.id == "dash_line1" || country.id == "dash_line"){
        // return ' <span><img src="'+horiz_line+'" style="width:100%"></span> ';
        return '<hr style="margin:0px;">';
    }
    else
        return country.text;
}

