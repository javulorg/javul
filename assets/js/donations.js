$(function(){
    $('#tabs').tab();

    $('[data-numeric]').payment('restrictNumeric');
    $('.cc-number').payment('formatCardNumber');
    $('.cc-cvc').payment('formatCardCVC');
    $.fn.toggleInputError = function(erred) {
        this.parents('.form-row').toggleClass('has-error', erred);
        return this;
    };

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
            $(this)[0].submit(false);
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
    })
})