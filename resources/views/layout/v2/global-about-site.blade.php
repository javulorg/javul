<div class="sidebar_block">
    <div class="sidebar_block_ttl">
        About
        <div class="arrow">
            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
        </div>
    </div>
    <div class="sidebar_block_content">
        <div class="sidebar_block_content_txt">
            @if(isset($unitObj) && $unitObj->description)
                {!! $unitObj->description !!} <a href="#"><img src="{{ asset('v2/assets/img/more.svg') }}" alt=""></a>
            @endif

        </div>
    </div>
</div>
