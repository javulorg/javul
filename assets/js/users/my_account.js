$(function(){
    $('#tabs').tab();



    $('#new-credit-card-form').submit(function(e) {
        e.preventDefault();
        var cardType = $.payment.cardType($('.cc-number').val());
        $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
        //$('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
        $('[name="exp_month"]').toggleInputError(!$.payment.validateCardExpiry($("[name='exp_month']").val(),
            $("[name='exp_year']").val()));
        $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));
        $("#cc-amount").toggleInputError(!$.payment.validateAmount($('#cc-amount').val()));
        $('.cc-brand').text(cardType);
        $('.validation').removeClass('text-danger text-success');
        if($('.has-error').length == 0){
            $(this).find('.submit').prop('disabled', true);
            Stripe.card.createToken($(this), stripeResponseHandler);
        }
    });


    $('#reused-credit-card-form').submit(function(e) {
        var $form = $('#reused-credit-card-form');
        e.preventDefault();
        var selectCard = $("[name='credit_cards']").val();
        var flag = true;
        if(selectCard == ""){
            flag=false
            $("[name='credit_cards']").css('border','1px solid #a94442');
        }
        else
            $("[name='credit_cards']").css('border','1px solid #ccc');

        var amount = $("#amount_reused_card").val();
        if($.trim(amount) == "" || parseInt(amount) <= 0){
            flag=false
            $("[id='amount_reused_card']").css('border','1px solid #a94442');
        }
        else
            $("[id='amount_reused_card']").css('border','1px solid #ccc');

        if(flag){
            $(this).find('.reuse-card').prop('disabled', true);
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


})
function stripeResponseHandler(status, response) {
    // Grab the form:
    var $form = $('#new-credit-card-form');

    if (response.error) { // Problem!

        // Show the errors on the form:
        $form.find('.payment-errors').text(response.error.message);
        $form.find('.submit').prop('disabled', false); // Re-enable submission

    } else { // Token was created!

        // Get the token ID:
        var token = response.id;
        var cardId = response.card.id;

        // Insert the token ID into the form so it gets submitted to the server:
        $form.append($('<input type="hidden" name="stripeToken">').val(token));
        $form.append($('<input type="hidden" name="cardId" />').val(cardId));

        // Submit the form:
        $form.get(0).submit();
    }
};

function format(country) {
    if (country.id == "dash_line1" || country.id == "dash_line"){
        // return ' <span><img src="'+horiz_line+'" style="width:100%"></span> ';
        return '<hr style="margin:0px;">';
    }
    else
        return country.text;
}

