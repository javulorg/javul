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
                <h2 class="unit-heading"><span class="glyphicon glyphicon-edit"></span> &nbsp; <strong>adf</strong></h2>

                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <strong>{!! trans('messages.unit_information') !!}<span class="caret"></span> </strong>
                            </div>
                            <div class="col-xs-5">{!! trans('messages.unit_name') !!}</div>
                            <div class="col-xs-7 text-right">asdfasdfasdf</div>
                            <div class="col-xs-5">{!! trans('messages.type') !!}</div>
                            <div class="col-xs-7 text-right">asdfasdf</div>
                            <div class="col-xs-5">{!! trans('messages.funds') !!}</div>
                            <div class="col-xs-7 text-right">{!! trans('messages.available') !!}: xxxx$</div>
                            <div class="col-xs-5">{!! trans('messages.awarded') !!}</div>
                            <div class="col-xs-7 text-right">xxx$</div>
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

    <div class="radio radio-primary">
        <input type="radio" name="credit_available_bal" id="radio1" value="availablebalance">
        <label for="radio1">
            Use available balance
        </label>
    </div>
    <div class="radio radio-primary">
        <input type="radio" name="credit_available_bal" id="radio2" value="credit_card">
        <label for="radio2">
            Use credit card
        </label>
    </div>

    <div class="row form-group donationDiv availablebalance"  style="display: none;">
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
    </div>

    <div class="row form-group donationDiv credit_card" style="display: none;">
        <div class="col-sm-12">
            <!-- tabs left -->
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                @if(!empty($credit_cards) && count($credit_cards) > 0)
                <li><a href="#saved_details" data-toggle="tab">Saved Details</a></li>
                @endif
                <li class="active"><a href="#credit_card" data-toggle="tab">Credit Card</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
                @if(!empty($credit_cards) && count($credit_cards) > 0)
                    <div class="list-group tab-pane" id="saved_details">
                        <div class="row form-group">
                            <div class="col-sm-4">
                                @if(!empty($credit_cards) && count($credit_cards) > 0)
                                <label class="sr-only">Card Type</label>
                                <select name="credit_cards" class="form-control">
                                    @foreach($credit_cards as $card)
                                    <option value="{{substr($card,-4)}}">{{substr($card,4).'-XXXX-XXXX-'.substr($card,-4)}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="credit_card_box">
                                    <div class="credit_card_heading">
                                         <span class="remove_card" style="float:right">
                                            <a class="" href="#">Remove Card</a>
                                        </span>
                                    </div>

                                    <div style="padding:10px 20px;">
                                        <input type="text" value="5100 XXXX XXXX 0012" disabled="disabled" class="text-input fl disabled
                                    credit_card_number" name="prependedradio" id="prependedradio-112696090">
                                        <input type="text" value="" minlength="3"
                                               maxlength="4" class="form-control" style="width:22%;font-size:12px;height:30px;float:right;"
                                               readonly>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <button class="btn orange-bg" style="margin-top: 20px;"> Proceed Securely</button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="list-group tab-pane active" id="credit_card">
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <form novalidate autocomplete="on" method="POST" id="new-credit-card-form">
                                <div class="form-row form-group">
                                    <label for="cc-number" class="control-label">ENTER CARD NUMBER
                                    <input id="cc-number" type="tel" class="input-lg form-control cc-number" data-stripe="number"
                                           autocomplete="cc-number" required style="width:300px;">
                                    <span style="" class="card_image">

                                    </span>
                                    </label>
                                </div>
                                <div class="form-row form-group">
                                    <label class="control-label">
                                        <span style="display: block;">EXPIRY DATE</span>
                                        <select name="exp_month" data-stripe="exp_month" class="form-control" required="">
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
                                        <select name="exp_year" data-stripe="exp_year" class="form-control" required="">
                                            <option value="">YYYY</option>
                                            @foreach($expiry_years as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </label>

                                </div>

                                <div class="form-row form-group">
                                    <label for="cc-cvc" class="control-label">CVC
                                        <input id="cc-cvc" type="password" class="input-lg form-control cc-cvc" autocomplete="off"
                                               data-stripe="cvc" required>
                                    </label>
                                </div>

                                <div class="form-row form-group">
                                    <label for="cc-amount" class="control-label">AMOUNT
                                        <input id="cc-amount" type="text" class="input-lg form-control cc-amount" autocomplete="off"
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
</script>
<script type="text/javascript" src="{!! url('assets/js/jquery.payment.js') !!}"></script>
<script type="text/javascript" src="{!! url('assets/js/donations.js') !!}"></script>

@endsection