<div class="sidebar_block">
    <div class="sidebar_block_ttl ">
        About
        {{-- <a href="{{ url('wiki/home/' . $unitIDHashID->encode($unitObj->id) . '/' . $unitObj->slug) }}"><img
                src="{{ asset('v2/assets/img/more.svg') }}" alt=""></a> --}}
    </div>
    <div class="sidebar_block_content_txt" style="text-align: justify;">
    @if(isset($unitObj) && $unitObj->description)
        <div class="overflow-hidden" style="
            display: -webkit-box;
            -webkit-line-clamp: 16;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.35em;
            max-height: calc(1.35em * 16);">
            {!! $unitObj->description !!}
        </div>

        <div class="mt-2" style="display: flex; justify-content: flex-end;">
    <a href="{{ url('wiki/home/' . $unitIDHashID->encode($unitObj->id) . '/' . $unitObj->slug) }}">
        <img src="{{ asset('v2/assets/img/more.svg') }}" alt="More" style="width:18px; height:18px;" />
    </a>
</div>

    @endif
</div>

</div>
