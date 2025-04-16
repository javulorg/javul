
{{-- <div class="sidebar_block">
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
</div> --}}
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
            @foreach($site_activity as $activity)
                @php
                    // Determine type based on which ID is filled
                    if (!empty($activity->task_id)) {
                        $type = 'task';
                    } elseif (!empty($activity->idea_id)) {
                        $type = 'idea';
                    } elseif (!empty($activity->objective_id)) {
                        $type = 'objective';
                    } elseif (!empty($activity->issue_id)) {
                        $type = 'issue';
                    } else {
                        $type = 'comment';
                    }

                    // Check if completed
                    $isComplete = isset($activity->status) && strtolower($activity->status) === 'complete';
                @endphp

                <div class="log_item">
                    <div class="log_icon">
                        @if($isComplete)
                            <i class="fa-solid fa-circle-check" style="color: green;"></i> {{-- completed icon --}}
                        @elseif($type === 'task')
                        <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                        @elseif($type === 'idea')
                        <img src="{{ asset('v2/assets/img/humbleicons_bulb.svg') }}" alt="" class="img-fluid">
                        @elseif($type === 'objective')
                        <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
                        @elseif($type === 'issue')
                        <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">
                        @elseif($type === 'comment')
                            <i class="fa-solid fa-comment-dots"></i>
                        @else
                            <i class="fa-solid fa-comment"></i> {{-- fallback --}}
                        @endif
                    </div>

                    <div class="log_txt">
                        <a href="#">{!! $activity->comment !!}</a>
                        {!! \App\Library\Helpers::timetostr($activity->created_at) !!}
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
