$(function(){
    $('#tabs').tab();

    $('[data-numeric]').payment('restrictNumeric');
    $('.cc-number').payment('formatCardNumber');
    $('.cc-cvc').payment('formatCardCVC');
    $.fn.toggleInputError = function(erred) {
        this.parents('.form-row').toggleClass('has-error', erred);
        return this;
    };

    $('.new_cc_submit').on('click',function(e) {
        e.preventDefault();
        var $form = $('#new-credit-card-form');
        var cardType = $.payment.cardType($('.cc-number').val());
        $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
        //$('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
        $('[name="exp_month"]').toggleInputError(!$.payment.validateCardExpiry($("[name='exp_month']").val(),
            $("[name='exp_year']").val()));
        $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));
        $("#cc-amount").toggleInputError(!$.payment.validateAmount($('#cc-amount').val()));
        $("#cc-card-type").toggleInputError(!$.payment.validateCardType($('#cc-card-type').val()));
        $('.cc-brand').text(cardType);
        $('.validation').removeClass('text-danger text-success');
        if($('.has-error').length == 0){
            $that = $(this);
            $that.prop('disabled', true);
            $(".new_cc_btn_text").html('<span class="saving">Submitting<span>.</span><span>.</span><span>.</span></span>');
            $.ajax({
                type:'post',
                url:siteURL+'/funds/donate-amount',
                data:$form.serialize(),
                dataType:'json',
                success:function(resp){
                    if(!resp.success){
                        var html = '';
                        $.each(resp.errors,function(index,val){
                            html+="<span>"+val+"</span>";
                        })
                        var errorHTML = '<div class="alert alert-danger">'+
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+html
                            '</div>';
                        $form.prepend(errorHTML);
                        $that.prop('disabled', false);
                        $(".new_cc_btn_text").html('Submit Payment');

                    }
                    else
                    {
                        $form.find("input,select").val('');
                        var errorHTML = '<div class="alert alert-success">'+
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                            '<strong>Success!!!</strong> Amount donated successfully.'+
                        '</div>';
                        $form.prepend(errorHTML);
                        $that.prop('disabled', false);
                        $(".new_cc_btn_text").html('Submit Payment');
                    }
                }
            });
            return false;
            //$form.get(0).submit();
        }
    });


    $('.reuse-card').on('click',function(e) {
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
            $(this).prop('disabled', true);
            $that = $(this);
            //$form.get(0).submit();
            $.ajax({
                type:'post',
                url:siteURL+'/funds/donate-amount',
                data:$form.serialize(),
                dataType:'json',
                success:function(resp){
                    if(!resp.success){
                        var html = '';
                        $.each(resp.errors,function(index,val){
                            html+="<span>"+val+"</span>";
                        })
                        var errorHTML = '<div class="alert alert-danger">'+
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+html
                        '</div>';
                        $form.prepend(errorHTML);
                        $that.prop('disabled', false);
                        $(".old_cc_btn_text").html('Submit Payment');

                    }
                    else
                    {
                        $form.find("input,select").val('');
                        var errorHTML = '<div class="alert alert-success">'+
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                            '<strong>Success!!!</strong> Amount donated successfully.'+
                            '</div>';
                        $form.prepend(errorHTML);
                        $that.prop('disabled', false);
                        $(".old_cc_btn_text").html('Submit Payment');
                    }
                }
            });
            return false;
        }
    });


    $("#cc-number").on('keyup',function(){
        var cardType = $.payment.cardType($(this).val());

        if($.trim(cardType) != "" && cardType != 'null'){
            $(".card_image").html('<img src="'+url+'/'+cardType+'.png" height="30px;">');
            $("#cc-card-type").val(cardType);
        }
        else{
            $(".card_image").html('');
            $("#cc-card-type").val('');
        }

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
            var img = '';
            var type= $(this).find(':selected').data('type');
            var last4 = $(this).find(':selected').data('last4');
            if(type =="amex")
                img = 'amex.png';
            if(type == "discover")
                img = 'discover.png';
            if(type == "MasterCard")
                img = 'mastercard.png';
            if(type == "visa")
                img =  'visa.png';
            if(type == "maestro")
                img = 'maestro.png';


            if($.trim(img) != '')
                $(".reused_card_image").html('<img src="'+siteURL+'/assets/images/'+img+'" style="height:40px;"/>');
            else
                $(".reused_card_image").html('');

            $("[name='card_number']").val('XXXX XXXX XXXX '+last4);
        }
        return false;
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

