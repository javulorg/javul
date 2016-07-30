@extends('layout.default')
@section('page-css')
<style>
    .select2-results {
        margin: 4px 4px 4px 0;
        max-height: 300px;
        overflow-x: hidden;
        overflow-y: auto;
        padding: 0 0 0 4px;
        position: relative;
    }
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
            @include('elements.user-menu',array('page'=>'user_profile'))
        </div>
        <div class="grey-bg" style="padding:10px;margin-bottom: 20px; ">
            <div class="row">
                <div class="col-sm-7">
                    <h1><span class="glyphicon glyphicon-user"></span> &nbsp; <strong>John Doe</strong></h1><br /><br /><br />
                    <button class="btn orange-bg"><span class="glyphicon glyphicon-send"></span> &nbsp; Send Private Message</button>
                </div>
                <div class="col-sm-5">
                    <div class="panel form-group marginTop10">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12"><strong>Society Points:</strong></div>
                                <div class="col-xs-6">
                                    Last 6 months
                                </div>
                                <div class="col-xs-6 text-right">
                                    3,000
                                </div>
                                <div class="col-xs-7">
                                    All time:
                                </div>
                                <div class="col-xs-5 text-right">
                                    50,000
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel form-group">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-8">
                                    <strong>Contribution Ranking:</strong>
                                </div>
                                <div class="col-xs-4 text-right text-gold">
                                    Gold
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel form-group">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <strong>Donations:</strong>
                                </div>
                                <div class="col-xs-7">
                                    Donations Received:
                                </div>
                                <div class="col-xs-5 text-right">
                                    <span class="donation_received">{{number_format($availableBalance,2)}}</span> $
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <!-- tabs left -->
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li @if(count($errors) == 0 || ($errors->has('active') && $errors->first('active')=="personal_info"))
                    class="active"
                    @endif><a
                        href="#personal_info" data-toggle="tab">Personal Info</a></li>
                    @if(!empty($authUserObj) && !empty($authUserObj->credit_card_id))
                        <li><a href="#credit_card_setting" data-toggle="tab">Credit Card Details</a></li>
                    @endif
                    @if(!empty($availableBalance) && $availableBalance >= 20)
                    <li @if($errors->has('active') && $errors->first('active')=="withdraw") class="active" @endif>
                        <a href="#withdraw_amount" data-toggle="tab">Withdraw</a>
                    </li>
                    @endif
                    <li><a href="#account_settings" data-toggle="tab">Account Settings</a></li>
                </ul>
                <div id="my-tab-content" class="tab-content">
                    <div class="list-group tab-pane @if(count($errors) == 0 || ($errors->has('active') && $errors->first('active')
                    =='personal_info')) active @endif" id="personal_info">
                        <form novalidate autocomplete="off" method="POST"  id="personal-info">
                            {!! csrf_field() !!}
                            <input type="hidden" name="opt_typ" value="used"/>
                            <div class="list-group tab-pane" id="personal_info">
                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="textinput">First Name</label>
                                    <input id="first_name" name="first_name" placeholder="First Name" class="form-control input-md" type="text"
                                        @if(!empty(old('first_name'))) value="{{old('first_name')}}" @else value="{{Auth::user()->first_name}}"
                                    @endif">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="textinput">Last Name</label>
                                    <input id="last_name" name="last_name" placeholder="Last Name" class="form-control input-md" type="text"
                                    @if(!empty(old('last_name'))) value="{{old('last_name')}}" @else value="{{Auth::user()->last_name}}" @endif">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="textinput">Email</label>
                                    <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text"
                                    @if(!empty(old('email'))) value="{{old('email')}}" @else value="{{Auth::user()->email}}" @endif">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="textinput">Phone</label>
                                    <input id="phone" name="phone" placeholder="Phone" class="form-control input-md" type="text"
                                    @if(!empty(old('phone'))) value="{{old('phone')}}" @else value="{{Auth::user()->phone}}" @endif">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="textinput">Mobile</label>
                                    <input id="mobile" name="mobile" placeholder="Mobile" class="form-control input-md" type="text"
                                    @if(!empty(old('mobile'))) value="{{old('mobile')}}" @else value="{{Auth::user()->mobile}}" @endif">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="textinput">Address</label>
                                    <input id="mobile" name="mobile" placeholder="Address" class="form-control input-md" type="text"
                                    @if(!empty(old('address'))) value="{{old('address')}}" @else value="{{Auth::user()->address}}"
                                    @endif">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="control-label">Country</label>
                                    <div class="input-icon right">
                                        <i class="fa select-error"></i>
                                        <select class="form-control" name="country" id="country">
                                            <option value="">{!! trans('messages.select') !!}</option>
                                            @if(count($countries) > 0)
                                                @foreach($countries as $id=>$val)
                                                    @if($val == "dash_line" || $val == "dash_line1")
                                                        <option value="{{$id}}" disabled></option>
                                                    @else
                                                        <option value="{{$id}}" @if(Auth::user()->country_id == $id)
                                                        selected=selected @endif>{{$val}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="control-label">State</label>
                                    <div class="input-icon right">
                                        <i class="fa select-error"></i>
                                        <select class="form-control" name="state" id="state" @if(Auth::user()->country_id == "global")
                                                disabled @endif>
                                            @foreach($states as $id=>$val)
                                                <option value="{{$id}}" @if(Auth::user()->state_id == $id)
                                                selected=selected @endif>{{$val}}</option>
                                            @endforeach
                                        </select>
                                        <span class="states_loader location_loader" style="display: none">
                                            <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="control-label">City</label>
                                    <div class="input-icon right">
                                        <i class="fa select-error"></i>
                                        <select class="form-control" name="city" id="city" @if(!empty($unitObj) && $unitObj->country_id == "global")
                                            disabled @endif>
                                            @if(!empty($unitObj))
                                                @foreach($cities as $cid=>$val)
                                                    <option value="{{$cid}}" @if(!empty($unitObj) && $unitObj->city_id == $cid)
                                                    selected=selected @endif>{{$val}}</option>
                                                @endforeach
                                            @else
                                            <option value="">{!! trans('messages.select') !!}</option>
                                            @endif
                                        </select>
                                        <span class="cities_loader location_loader" style="display: none">
                                            <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="list-group tab-pane @if($errors->has('active') && $errors->first('active')=='credit_card') active @endif"
                         id="credit_card_setting">
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <form novalidate autocomplete="off" method="POST" id="new-credit-card-form">
                                    <input type="hidden" name="opt_typ" value="new"/>
                                    {!! csrf_field() !!}
                                    <div class="form-row form-group" style="position: relative;">
                                        <label for="cc-number" class="control-label">ENTER CARD NUMBER
                                            <input id="cc-number" type="tel" class="input-lg form-control cc-number" name="cc-number"
                                                   autocomplete="cc-number" required style="width:300px;">
                                            <span style="" class="card_image"></span>
                                        </label>
                                    </div>
                                    <div class="form-row form-group">
                                        <label class="control-label">
                                            <span style="display: block;">CARD TYPE</span>
                                            <select name="cc-card-type" id="cc-card-type" class="form-control" required="">
                                                <option value="">Select Card Type</option>
                                                <option value="visa">Visa</option>
                                                <option value="mastercard">MasterCard</option>
                                                <option value="amex">American Express</option>
                                                <option value="discover">Discover</option>
                                                <option value="maestro">Maestro</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="form-row form-group">
                                        <label class="control-label">
                                            <span style="display: block;">EXPIRY DATE</span>
                                            <select name="exp_month" class="form-control" required="">
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
                                            <select name="exp_year" class="form-control" required="">
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
                                                   autocomplete="off" required>
                                        </label>
                                    </div>
                                    <button type="button" class="btn orange-bg update-creditcard">
                                        <span class="update-cc-text">Update Details</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="list-group tab-pane @if($errors->has('active') && $errors->first('active')=='withdraw') active @endif" id="withdraw_amount">
                        <form role="form" method="post" id="withdraw-amount"  novalidate="novalidate" action="{!! url('account/withdraw') !!}">
                            {!! csrf_field() !!}
                            @if($errors->has('error'))
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Error!</strong> {{$errors->first('error')}}.
                            </div>
                            @endif
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <label for="paypal_email" class="control-label">Paypal Email ID</label>
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input id="paypal_email" type="email" class="form-control" value="{{old('paypal_email')}}"
                                               name="paypal_email"
                                               autocomplete="off" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group amount-field" style="display: none;">
                                <div class="col-sm-4">
                                    <label for="cc-amount" class="control-label">Amount to withdraw</label>
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input id="cc-amount" name="cc-amount" type="text" class="form-control cc-amount"
                                               value="{{old('cc-amount')}}" autocomplete="off" required data-numeric>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn orange-bg withdraw-submit">
                                <span class="withdraw-text">Verify Email</span>
                            </button>
                        </form>
                    </div>

                    <div class="list-group tab-pane " id="account_settings">
                         Account Settings
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('elements.footer')
@endsection
@section('page-scripts')
<script>
    var url = '{{url("assets/images")}}';
    var msg_flag ='{{ $msg_flag }}';
    var msg_type ='{{ $msg_type }}';
    var msg_val ='{{ $msg_val }}';
</script>
<script src="{!! url('assets/js/custom_tostr.js') !!}" type="text/javascript"></script>
<script type="text/javascript" src="{!! url('assets/js/users/my_account.js') !!}"></script>
<script type="text/javascript" src="{!! url('assets/js/jquery.payment.js') !!}"></script>
<script type="text/javascript" src="{!! url('assets/js/donations.js') !!}"></script>
@endsection