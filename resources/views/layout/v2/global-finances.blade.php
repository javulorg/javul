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
                Received: $3,000
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                <div class="sidebar_block_right">
                    <div class="green_progress"></div> 105%
                </div>
            </div>
            <div class="sidebar_block_left text-left">
                Awarded:  {{ $awardedFunds }}
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
            </div>
            <div class="sidebar_block_right">
                Available: {{ $availableFunds }}
            </div>
        </div>
        <div class="sidebar_block_content_bottom">
            <a href="#">Donate</a> <div class="separator"></div> <a href="#">Financial Activity</a>
        </div>
    </div>
</div>
