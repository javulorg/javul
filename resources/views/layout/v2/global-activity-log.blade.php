<div class="sidebar_block">
    <div class="sidebar_block_ttl">
        @if(isset($title))
            {{ $title }}
        @else
            Global Activity Log
        @endif
        <div class="arrow">
            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
        </div>
    </div>
    <div class="sidebar_block_content">
        @if(count($site_activity) > 0)
            @foreach($site_activity as $index => $activity)
        <div class="log_item">
            <div class="log_icon">
                <img src="{{ asset('v2/assets/img/commen.svg') }}" alt="">
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

            <div class="sidebar_block_content_bottom">
                <a href="#">Top Contributors</a>
                <div class="separator"></div>
                @if(isset($unit) && $unit != null)
                    <a href="{{ url('activities?unit=' . $unit) }}">More Activity</a>
                @else
                    <a href="{{ url('activities') }}">More Activity</a>
                @endif
            </div>
    </div>
</div>
