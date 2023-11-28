<div class="content_block">
    <div class="table_block table_block_units">
        <div class="table_block_head">
            <div class="table_block_icon">
                <i class="fa-brands fa-stack-overflow"></i>
            </div>
            Units ({{ $unitsTotal }})
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col">{{ __('messages.unit_name') }}</th>
                    <th class="last_reply_col">{{ __('messages.unit_category') }}</th>
                </tr>
                </thead>
                <tbody>
                @if($unitsMaster->count() > 0)
                @foreach($unitsMaster as $unit)
                    @php
                        $category_ids = $unit->category_id;
                        $category_names = App\Models\UnitCategory::getName($category_ids);
                        $category_ids = explode(",", $category_ids);
                        $category_names = explode(",", $category_names);
                    @endphp
                    <tr>

                        <td class="title_col">
                            <a href="{!! url('units/'.$unitIDHashID->encode($unit->id).'/'.$unit->slug) !!}">{{$unit->name}}</a>
                        </td>
                        <td class="last_reply_col">
                            @if(count($category_ids) > 0)
                                @foreach($category_ids as $index => $category)
                                    <a href="{!! url('units/category='.strtolower($category_names[$index])) !!}">{{$category_names[$index]}}</a>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="4">No record(s) found.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="content_block_bottom">
        <a href="{{ url('units') }}">See more</a>
    </div>
</div>
