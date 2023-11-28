<div class="content_block">
    <div class="table_block table_block_ideas">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/humbleicons_bulb.svg') }}" alt="" class="img-fluid">
            </div>
            Ideas ({{ $ideasMasterTotal }})
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="type_col">Idea Name</th>
                    <th class="title_col">Unit Name</th>
                </tr>
                </thead>
                <tbody>
                @if(count($ideasMaster) > 0 )
                    @foreach($ideasMaster as $idea)
                        <tr>
                            <td class="type_col">
                                <a href="{!! url('ideas/'.$ideaHashID->encode($idea->id)) !!}">
                                    {{$idea->title}}
                                </a>
                            </td>
                            <td class="title_col">
                                <a href="{!! url('units/'.$unitIDHashID->encode($idea->unit_id).'/'.\App\Models\Unit::getSlug($idea->unit_id)) !!}">
                                    {{\App\Models\Unit::getUnitName($idea->unit_id)}}
                                </a>
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
            <div class="mob_table d-sm-none d-block">
            </div>
        </div>
    </div>
    <div class="content_block_bottom">
        <a href="{{ url('ideas') }}">See more</a>
    </div>
</div>
