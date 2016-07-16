@extends('layout.default')
@section('page-css')
<style>
    hr, p{margin:0 0 10px !important;}
    .files_image:hover{text-decoration: none;}
    .file_documents{display: inline-block;padding: 10px;}

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
            <div class="radio radio-primary">
                <input type="radio" name="radio1" id="radio2" value="option2">
                <label for="radio2">
                    Use Javul.org Wallet
                </label>
            </div>
        </div>
    </div>



    <div class="row form-group">
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
    $(function(){
        $('#tabs').tab();
    })
</script>
@endsection