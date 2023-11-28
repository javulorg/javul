<form role="form" method="post" id="withdraw-amount"  novalidate="novalidate" @if($payment_method == "Zcash") action="{{ url('account/request-to-transfer-zcash') }}" @else action="{{ url('account/withdraw') }}" @endif>
    @csrf
    @if($errors->has('error'))
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <img src="{!! url('assets/images/error-icon.png') !!}"> <strong>Error!</strong> {{$errors->first('error')}}.
        </div>
    @endif

    @if($errors->has('paypal_email'))
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <img src="{!! url('assets/images/error-icon.png') !!}"> <strong>Error!</strong> {{$errors->first('paypal_email')}}.
        </div>
    @endif
    @if(empty(auth()->user()->paypal_email) && $payment_method == "PAYPAL")
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
    @endif
    @if($payment_method == "Zcash")
        <div class="row form-group">
            <div class="col-sm-4">
                <label for="zcash_address" class="control-label">Enter your address</label>
                <div class="input-icon right">
                    <i class="fa"></i>
                    <input id="zcash_address" type="text" class="form-control" value="{{old('zcash_address')}}" placeholder="Please enter Zcash address" name="zcash_address" autocomplete="off" required>
                </div>
            </div>
        </div>
    @endif
    <button type="button" class="btn orange-bg withdraw-submit">
        @if($payment_method == "Zcash")
            <span class="withdraw-text">Send Transfer Request</span>
        @else
            <span class="withdraw-text">Transfer my full balance to my Paypal account</span>
        @endif
    </button>

    <input type="hidden" value="{{ $payment_method }}" id="payment_method" name="payment_method"/>
</form>
