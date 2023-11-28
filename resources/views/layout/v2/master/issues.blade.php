<div class="content_block mt-3">
    <div class="table_block table_block_issues">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">
            </div>
            Issues ({{ $issuesMasterTotal }})
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="type_col">Issue Name</th>
                    <th class="title_col">Unit Name</th>
                </tr>
                </thead>
                <tbody>

                @if(count($issuesMasterData) > 0 )
                    @foreach($issuesMasterData as $issueData)
                        <tr>
                            <td class="type_col">
                                <a href="{!! url('issues/'.$issueIDHashID->encode($issueData->id).'/view') !!}">
                                    {{$issueData->title}}
                                </a>
                            </td>
                            <td class="title_col">
                                <a href="{!! url('units/'.$unitIDHashID->encode($issueData->unit_id).'/'.\App\Models\Unit::getSlug($issueData->unit_id)) !!}">
                                    {{\App\Models\Unit::getUnitName($issueData->unit_id)}}
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
        <a href="{{ url('issues') }}">See more</a>
    </div>
</div>
