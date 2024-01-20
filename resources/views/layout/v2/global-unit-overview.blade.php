<div class="sidebar_block">
    <div class="sidebar_block_ttl">
        Unit Overview
        <div class="arrow">
            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
        </div>
    </div>
    <div class="sidebar_block_content">
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Type:
            </div>
            <div class="sidebar_block_right">
                @if(isset($unitObj) && $unitObj->unit_type == 0)
                    Product
                @elseif(isset($unitObj) && $unitObj->unit_type == 1)
                    Service
                @else
                    People’s Government
                @endif
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Issue Resolution:
            </div>
            <div class="sidebar_block_right">
                <div class="blue_progress"></div> 94%
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Location:
            </div>
            <div class="sidebar_block_right">
                Worldwide
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Operational Grade:
            </div>
            <div class="sidebar_block_right">
                A+ <img src="{{ asset('v2/assets/img/question.svg') }}" alt="" class="question">
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Funded:
            </div>
            <div class="sidebar_block_right">
                <div class="green_progress"></div> 105%
            </div>
        </div>
        @if(isset($unitObj))
        <div class="sidebar_block_content_bottom">
            <a href="{!! route('unit_revison',[$unitIDHashID->encode($unitObj->id)]) !!}"><i class="fa fa-history"></i></a>
            <div class="separator"></div>
            <a href="{!! url('units/'.$unitIDHashID->encode($unitObj->id).'/edit') !!}"><i class="fa fa-edit"></i></a>
            <div class="separator"></div>
            <a class="add_to_my_watchlist" data-type="unit"  data-id="{{$unitIDHashID->encode($unitObj->id)}}" data-redirect="{{url()->current()}}"><i class="fa fa-list"></i></a>
        </div>
        @endif
    </div>
</div>
