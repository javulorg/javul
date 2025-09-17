<!-- resources/views/layout/v2/global-finances.blade.php -->
 <?php

use App\Models\Transaction;

$unitTotalAmount = Transaction::sum('amount');
?>

<div class="sidebar_block">
    <div class="sidebar_block_ttl">
        Finances
        <div class="arrow">
            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
        </div>
    </div>
    <div class="sidebar_block_content">
        <div class="sidebar_block_row">
            <div class="sidebar_block_left text-left">
                Funded
            </div>
            <div class="sidebar_block_left text-left">
                Received: ${{ number_format($unitTotalAmount, 2) }}
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                <div class="sidebar_block_right">
                    <div class="green_progress"></div> 105%
                </div>
            </div>
            <div class="sidebar_block_left text-left">
                {{-- Awarded: {{ $awardedFunds }} --}}
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
            </div>
            <div class="sidebar_block_right">

                {{-- Available: {{ $availableFunds }} --}}
            </div>
        </div>
        <style>
        .donate-custom-button{
               color: #319df5;cursor: pointer; text-decoration: underline;
        }
          </style>

        <div class="sidebar_block_content_bottom">
            <a  id="submit_button"  class=" donate-custom-button" 
             data-url="{{url('/donation/submit')}}" 
             data-unit_id="{{ $unitData->id }}"
             data-donation_type="{{ $donationType ?? 'unit' }}"
             >Donate</a>
            <div class="separator"></div>
            <a href="{{url('/finances?unit='.$unitData->id)}}">Financial Activity</a>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/donation.js') }}"></script>
<script>
    $(document).ready(function(){

        handleDonationClick('#submit_button');
        
});

</script> 