<div class="col-md-8 col-sm-12">
    <h5 class="card-title">Profile Summary</h5>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <p class="card-text"><strong>Society Points:</strong></p>
            <div class="row">
                <div class="col-6">
                    <p class="card-text">Last 6 months:</p>
                </div>
                <div class="col-6 text-end">
                    <p class="card-text">3,000</p>
                </div>
                <div class="col-7">
                    <p class="card-text">All time:</p>
                </div>
                <div class="col-5 text-end">
                    <p class="card-text">50,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <p class="card-text"><strong>Contribution Ranking:</strong></p>
            <div class="row">
                <div class="col-6">
                    <p class="card-text">Ranking:</p>
                </div>
                <div class="col-6 text-end text-gold">
                    <p class="card-text">Gold</p>
                </div>
            </div>
            <p class="card-text"><strong>Donations:</strong></p>
            <div class="row">
                <div class="col-7">
                    <p class="card-text">Donations Received:</p>
                </div>
                <div class="col-5 text-end">
                    @if($payment_method == "Zcash")
                        <p class="card-text donation-received">{{number_format($availableBalance,2)}} <img src="{!! url('assets/images/small-zcash-icon.png') !!}" style="width: 15px;padding-bottom: 2px;"/></p>
                    @else
                        <p class="card-text donation-received">{{number_format($availableBalance,2)}} $</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
