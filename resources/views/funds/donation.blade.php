@extends('layout.master')
@section('title', 'Donation')
@section('style')
<style>
    .badge {
        display: inline-block;
        white-space: nowrap;
    }
</style>
@endsection
@section('content')
{{-- @dd($data) --}}
{{-- @php $obj_identifier = get_class($obj); @endphp --}}
<div class="bg-light p-3 mb-4">
    <div class="row">
        <div class="col-sm-4 text-center">
            <div>
                @if(!empty($obj->profile_pic))
                <img src="{{ $obj->profile_pic }}" class="rounded-circle" style="width: 160px;">
                @else
                <img src="{!! url('assets/images/user.png') !!}" class="rounded-circle" style="width: 160px;">
                @endif
            </div>
            <label class="form-label d-block mb-0">Task Completion Ratings</label>
            <div class="rating" style="font-size: 2rem;">
                <input type="hidden" name="rating" value="{{ $rating_points }}" />
                <span class="star @if($rating_points >= 1) checked @endif"
                    style="opacity: {{ $rating_points >= 1 ? 1 : 0.3 }};">&#9733;</span>
                <span class="star @if($rating_points >= 2) checked @endif"
                    style="opacity: {{ $rating_points >= 2 ? 1 : 0.3 }};">&#9733;</span>
                <span class="star @if($rating_points >= 3) checked @endif"
                    style="opacity: {{ $rating_points >= 3 ? 1 : 0.3 }};">&#9733;</span>
                <span class="star @if($rating_points >= 4) checked @endif"
                    style="opacity: {{ $rating_points >= 4 ? 1 : 0.3 }};">&#9733;</span>
                <span class="star @if($rating_points == 5) checked @endif"
                    style="opacity: {{ $rating_points == 5 ? 1 : 0.3 }};">&#9733;</span>
            </div>
            <span class="d-block text-center fw-bold">{{$rating_points}}/5</span>
        </div>
        <div class="col-sm-8">
            <div class="user-header">
                <h3>{{$data->first_name.' '.$data->last_name}}</h3>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="user-header">
                    <span class="bi bi-clock"></span>
                    Account age: {{$obj->created_at}}
                </div>
                {{-- <div class="user-header">
                    <span class="bi bi-hand-thumbs-up"></span>
                    Skills:
                    <?php $job_skills = explode(",",$obj->job_skills); ?>
                    @if(!empty($job_skills))
                    @foreach($job_skills as $skill)
                    <span class="badge bg-info">{{\App\Models\JobSkill::getName($skill)}}</span>
                    @endforeach
                    @endif
                </div> --}}
            </div>
            {{-- <div class="user-header mb-2">
                <span class="bi bi-bookmark"></span>
                Area of Interest:
                <?php $area_of_interest = explode(",",$obj->area_of_interest); ?>
                @if(!empty($area_of_interest))
                @foreach($area_of_interest as $interest)
                <span class="badge bg-info"
                    style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{\App\Models\AreaOfInterest::getName($interest)}}</span>
                @endforeach
                @endif
            </div> --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="bi bi-geo-alt"></span>
                    {{\App\Models\Country::getName($obj->country_id)}}
                    <span class="bi bi-caret-right"></span>
                    {{\App\Models\State::getName($obj->state_id)}}
                    <span class="bi bi-caret-right"></span>
                    {{\App\Models\City::getName($obj->city_id)}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        @include('layout.v2.global-sidebar')
    </div>

    <div class="col-sm-8">
        @if(isset($obj_identifier) && $obj_identifier != 'App\Models\Objective')
        <form accept-charset="UTF-8" action="{!! url('funds/donate-amount') !!}" class="simple_form form-horizontal"
            method="post" novalidate="novalidate" id="donate_amount_form">
            {{ csrf_field() }}
            @if(count($errors->all()) > 0)
            <?php $err_msg ='';?>
            @foreach($errors->all() as $err)
            <?php $err_msg.='<span>'.$err.'</span>';?>
            @endforeach

            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <img src="{!! url('assets/images/error-icon.png') !!}"> <strong>Error!</strong> {!!$err_msg!!}
            </div>

            @endif
            @if($current_payment_method == "PAYPAL")
            <div class="row form-group donationDiv credit_card">
                <div class="col-sm-4">
                    <label for="amount" class="control-label">Amount to Donate</label>
                    <input type="text" value="" name="donate_amount" id="donate_amount" data-numeric
                        placeholder="Amount" class="form-control" required autocomplete="off" maxlength="10">

                    <label id="paypal-fees" class="control-label"></label>
                </div>
            </div>
            @endif
            <div class="row form-group donationDiv credit_card">
                <div class="col-sm-4">
                    @if($current_payment_method == "Zcash")
                    <button id="submit_donate" class="btn black-btn">Donate With Zcash</button>
                    @else
                    <input type="image" id="submit_donate"
                        src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" />
                    @endif
                    <input type="hidden" id="paymentMethod" name="paymentMethod"
                        value="{{ $current_payment_method }}" />
                </div>
            </div>
        </form>
        @else
        {{-- <form accept-charset="UTF-8" action="{!! url('funds/transfer-from-unit') !!}"
            class="simple_form form-horizontal" method="post" novalidate="novalidate">
            {{ csrf_field() }}
            @if(count($errors->all()) > 0)
            <?php $err_msg ='';?>
            @foreach($errors->all() as $err)
            <?php $err_msg.='<span>'.$err.'</span>';?>
            @endforeach

            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <img src="{!! url('assets/images/error-icon.png') !!}"> <strong>Error!</strong> {!!$err_msg!!}
            </div>

            @endif
            <div class="row form-group donationDiv credit_card">
                <div class="col-sm-4">
                    <label for="amount" class="control-label">Amount to Donate For User</label>

                    <input type="text" placeholder="Unit Name" id="unit_name" class="form-control"
                        value="{{ $obj->name }}"><br>
                    <label for="">Username</label>
                    <input type="text" placeholder="User Name" id="user_name" class="form-control"
                        value="{{ Auth::user()->username }}"><br>

                    <label for="">amount</label>
                    <input type="text" value="" name="donate_amount" id="donate_amount" data-numeric
                        placeholder="Amount" class="form-control" required autocomplete="off" maxlength="10">


                    <label id="paypal-fees" class="control-label" @if($current_payment_method=="Zcash" )
                        style="display:none" @endif></label>
                </div>
            </div>
            <div class="row form-group donationDiv credit_card">
                <div class="col-sm-2 col-xs-12">
                    @if($current_payment_method == "Zcash")
                    <button id="submit_donate" class="btn black-btn"
                        style="padding: 6px 12px;line-height: unset !important;">Donate With Zcash</button>
                    @else
                    <input type="image" id="submit_donate"
                        src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" />
                    @endif
                    <input type="hidden" id="paymentMethod" name="paymentMethod"
                        value="{{ $current_payment_method }}" />
                </div><br><br><br>
                <div class="col-sm-2 col-xs-12">
                    <a type="submit" class="btn btn-primary">Transfer from Unit</a>
                </div>
            </div>
        </form> --}}

        @php
        $donateToType = request()->segment(3); // 'objective' from /funds/donate/objective/abc123
        @endphp




        <form accept-charset="UTF-8" action="{{ route('donation.submit') }}" class="simple_form form-horizontal"
            method="post" novalidate="novalidate" id="donationForm">
            {{ csrf_field() }}

            <input type="hidden" name="donate_to_type" value="{{ $donateToType }}">


            @if($errors->any())
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <img src="{!! url('assets/images/error-icon.png') !!}"> <strong>Error!</strong>
                {!! implode('', $errors->all('<span>:message</span>')) !!}
            </div>
            @endif

            <div class="row form-group donationDiv credit_card">
                <div class="col-sm-4">
                    <label class="control-label">Amount to Donate For User</label>

                    <label>Unit Name</label>
                    <input type="text" name="unit_name" placeholder="Unit Name" id="unit_name" class="form-control"
                        value="{{ $obj->name }}" readonly><br>

                    <input type="hidden" name="unit_id" value="{{ $obj->id }}">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="User Name" id="user_name" class="form-control"
                        value="{{ Auth::user()->username }}" readonly><br>

                    <label>Amount</label>
                    <input type="text" name="donate_amount" id="donate_amount" data-numeric placeholder="Amount"
                        class="form-control" required autocomplete="off" maxlength="10">

                    <label id="paypal-fees" class="control-label" @if($current_payment_method=="Zcash" )
                        style="display:none" @endif></label>
                </div>
            </div>

            <div class="row form-group donationDiv credit_card">
                <div class="col-sm-2 col-xs-12">
                    @if($current_payment_method == "Zcash")
                    <button type="submit" class="btn black-btn" style="padding: 6px 12px;">Donate With Zcash</button>
                    @else
                    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" />
                    @endif
                    <input type="hidden" name="paymentMethod" value="{{ $current_payment_method }}">
                </div>

                <div class="col-sm-2 col-xs-12">
                    <button type="submit" class="btn btn-primary">Transfer from Unit</button>
                </div>
            </div>
        </form>

        <div id="responseMsg"></div>


        @endif
    </div>
</div>




@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script>
    $(document).ready(function () {
        $('#donationForm').on('submit', function (e) {
            e.preventDefault(); // ✅ Prevent page reload

            $.ajax({
                url: '{{ url("funds/transfer-from-unit") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Transaction Successful!',
                        text: 'Transaction ID: ' + res.transaction_id
                    });

                    $('#donationForm')[0].reset();
                },
                error: function (xhr) {
                    let message = 'Something went wrong.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors).join('\n');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Transaction Failed',
                        text: message
                    });
                }
            });
        });
    });
</script> --}}
