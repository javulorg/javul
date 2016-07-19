@extends('layout.default')
@section('page-css')
<style>
    hr, p{margin:0 0 10px !important;}
    .files_image:hover{text-decoration: none;}
    .file_documents{display: inline-block;padding: 10px;}
    select[name='exp_month']{width:80px;display: inline-block;}
    select[name="exp_year"]{width:100px;display: inline-block;}

</style>
@endsection
@section('content')

<div class="container">
    <div class="row form-group">
        <div class="col-sm-12">
            <div class="col-sm-12 grey-bg unit_description">
                <h2 class="unit-heading"><span class="glyphicon glyphicon-edit"></span> &nbsp; <strong>{{$obj->name}}</strong></h2>

                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <strong>{{ucfirst(trim($donateTo))}} Information<span class="caret"></span> </strong>
                            </div>
                            <div class="col-xs-5">{{{ucfirst(trim($donateTo))}}} Name</div>
                            <div class="col-xs-7 text-right">{{$obj->name}}</div>
                            <div class="col-xs-5">{!! trans('messages.funds') !!}</div>
                            <div class="col-xs-7 text-right">{!! trans('messages.available') !!}: {{number_format($availableFunds,0)}}$</div>
                            <div class="col-xs-5">{!! trans('messages.awarded') !!}</div>
                            <div class="col-xs-7 text-right">{{number_format($awardedFunds,0)}}$</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12">
            <h3>Available Balance : $<span class="availableLabel">{{$availableBalance}}</span></h3>
        </div>
    </div>

    <!--<div class="radio radio-primary">
        <input type="radio" name="credit_available_bal" id="radio1" value="availablebalance" @if($availableBalance == 0 ||
        $availableBalance < 0) disabled @endif>
        <label for="radio1">
            Use available balance
        </label>
    </div>-->
    <!--<div class="radio radio-primary">
        <input type="radio" name="credit_available_bal" id="radio2" value="credit_card">
        <label for="radio2">
            Use credit card
        </label>
    </div>-->
    @if($availableBalance > 0)
    <!--<div class="row form-group donationDiv availablebalance"  style="display: none;">
        <div class="col-sm-12">
            <div style="background-color: #eeeeee;padding:20px;">
                <label class="control-label">
                    <span style="display: inline-block;font-size: 24px;">{{$availableBalance}}</span>
                    <span style="display: inline-block;font-size: 24px;padding:10px">-</span>
                    <div style="display:inline-block;width: 180px;font-size: 24px;position:relative;top:9px" class="">
                        <input type="text" data-numeric name="amount_from_available_bal" class="form-control"/>
                    </div>
                    <input type="button" value="Pay now" id="pay_now" class="btn orange-bg">
                </label>

            </div>
        </div>
    </div>-->
    @endif
    <div class="row form-group donationDiv credit_card"  >
        <div class="col-sm-12">
            <!-- tabs left -->
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                @if(!empty($credit_cards) && count($credit_cards) > 0)
                <li><a href="#saved_details" data-toggle="tab">Saved Details</a></li>
                @endif
                <li class="active"><a href="#credit_card" data-toggle="tab">Credit Card</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
                <div class="list-group tab-pane" id="saved_details">
                @if(!empty($credit_cards) && count($credit_cards) > 0)
                    <form novalidate autocomplete="off" method="POST"  id="reused-credit-card-form">
                        {!! csrf_field() !!}
                        <input type="hidden" name="opt_typ" value="used"/>
                        <div class="list-group tab-pane" id="saved_details">
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    @if(isset($credit_cards->data) && !empty($credit_cards->data) && count($credit_cards->data) > 0)
                                    <label class="sr-only">Card Type</label>
                                    <select name="credit_cards" class="form-control">
                                        <option value="">Select Card</option>
                                        @foreach($credit_cards->data as $card)
                                            <option value="{{$card->last4}}">{{'XXXX-XXXX-XXXX-'.$card->last4}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="credit_card_box">
                                        <div class="credit_card_heading">
                                            <span class="reused_card_image" style="float:left">

                                            </span>
                                             <span class="remove_card" style="float:right">
                                                <a class="" href="#">Remove Card</a>
                                            </span>
                                        </div>
                                        <div style="padding:10px 20px;">
                                            <input type="text" value="" disabled="disabled" class="text-input fl disabled
                                        credit_card_number" name="card_number">
                                            <input type="text" value="" name="amount_reused_card" id="amount_reused_card" data-numeric
                                                   placeholder="Amount"
                                                   class="form-control
                                            amount-reuse-card">
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <button class="btn orange-bg reuse-card submit" style="margin-top: 20px;">Submit Payment</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
                </div>
                <div class="list-group tab-pane active" id="credit_card">
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <form novalidate autocomplete="off" method="POST" id="new-credit-card-form">
                                <input type="hidden" name="opt_typ" value="new"/>
                                {!! csrf_field() !!}
                                <div class="form-row form-group" style="position: relative;">
                                    <label for="cc-number" class="control-label">ENTER CARD NUMBER
                                    <input id="cc-number" type="tel" class="input-lg form-control cc-number" name="cc-number"
                                           data-stripe="number"
                                           autocomplete="cc-number" required style="width:300px;">
                                    <span style="" class="card_image">

                                    </span>
                                    </label>
                                </div>
                                <div class="form-row form-group">
                                    <label class="control-label">
                                        <span style="display: block;">EXPIRY DATE</span>
                                        <select name="exp_month" data-stripe="exp_month" class="form-control" name="cc-month" required="">
                                            <option value="">MM</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        <select name="exp_year" data-stripe="exp_year" class="form-control" name="cc-year" required="">
                                            <option value="">YYYY</option>
                                            @foreach($expiry_years as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </label>

                                </div>

                                <div class="form-row form-group">
                                    <label for="cc-cvc" class="control-label">CVC
                                        <input id="cc-cvc" type="password" class="input-lg form-control cc-cvc" name="cc-cvc"
                                               autocomplete="off"
                                               data-stripe="cvc" required>
                                    </label>
                                </div>

                                <div class="form-row form-group">
                                    <label for="cc-amount" class="control-label">AMOUNT
                                        <input id="cc-amount" name="cc-amount" type="text" class="input-lg form-control cc-amount"
                                               autocomplete="off"
                                               data-stripe="amount" required data-numeric>
                                    </label>
                                </div>

                                <input type="submit" class="submit btn orange-bg" value="Submit Payment">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@include('elements.footer')
@endsection
@section('page-scripts')
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    var url = '{{url("assets/images")}}';
    var avlblamt = {{$availableBalance}};
    var msg_flag ='{{ $msg_flag }}';
    var msg_type ='{{ $msg_type }}';
    var msg_val ='{{ $msg_val }}';
</script>
<script src="{!! url('assets/js/custom_tostr.js') !!}" type="text/javascript"></script>
<script type="text/javascript" src="{!! url('assets/js/jquery.payment.js') !!}"></script>
<script type="text/javascript" src="{!! url('assets/js/donations.js') !!}"></script>

@endsection