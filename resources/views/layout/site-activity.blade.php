<div class="sidebar_block">
    <div class="sidebar_block_ttl">
        {{ $site_activity_text }}
        <div class="arrow">
            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
        </div>
    </div>
    <div class="sidebar_block_content">
        @if(count($site_activity) > 0)
        @foreach($site_activity as $index=>$activity)
        <div class="log_item">
            <div class="log_icon">
                <img src="{{ asset('v2/assets/img/location.svg') }}" alt="">
            </div>
            <div class="log_txt">
                <a href="#">{!! $activity->comment !!}</a> {!! \App\Library\Helpers::timetostr($activity->created_at) !!}
            </div>
        </div>
        @endforeach
        @else
            <div class="log_item">
                No activity found.
            </div>
        @endif
    </div>
</div>
