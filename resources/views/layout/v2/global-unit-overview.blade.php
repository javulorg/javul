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
                @if(isset($unitObj) && $unitObj->unit_type == 0 )
                    Product
                @elseif(isset($unitObj) && $unitObj->unit_type == 1)
                    Service
                @else
                    People’s Government
                @endif
            </div>
        </div>

        @if(isset($unitObj) && ( $unitObj->unit_type == 0 || $unitObj->unit_type == 1) )
            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Product Name:
                </div>
                <div class="sidebar_block_right">
                   {{ $unitObj->product_name }}
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Service Name:
                </div>
                <div class="sidebar_block_right">
                    {{ $unitObj->service_name }}
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Business Model:
                </div>
                <div class="sidebar_block_right">
                    @if($unitObj->business_model == 0)
                        Community-owned
                    @else
                        Corporate
                    @endif
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Operational Grade:
                </div>
                <div class="sidebar_block_right">
                    {{ $unitObj->operational_grade }} <img src="{{ asset('v2/assets/img/question.svg') }}" alt="" class="question">
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                   Company :
                </div>
                <div class="sidebar_block_right">
                    {{ $unitObj->company }}
                </div>
            </div>
        @elseif(isset($unitObj) && ($unitObj->unit_type == 2))
            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Scope :
                </div>
                <div class="sidebar_block_right">
                    {{ $unitObj->scope }}
                </div>
            </div>
        @else
            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Scope :
                </div>
                <div class="sidebar_block_right">

                </div>
            </div>
        @endif





        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Issue Resolution:
            </div>
            <div class="sidebar_block_right">
                <div class="blue_progress"></div> {{ $totalIssueResolutions }} %
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
