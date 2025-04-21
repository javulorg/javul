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
        {{-- <div class="table_block_body">
            <table>
                <thead>
                    <tr>
                        <th class="type_col">Issue Name</th>
                        <th class="title_col">Unit Name</th>
                    </tr>
                </thead>
                <tbody>

                    @if (count($issuesMasterData) > 0)


                        @foreach ($issuesMasterData->take(5) as $issueData)
                            <tr>
                                <td class="type_col">
                                    <a href="{!! url('issues/' . $issueIDHashID->encode($issueData->id) . '/view') !!}">
                                        {{ $issueData->title }}
                                    </a>
                                </td>
                                <td class="title_col">
                                    <a href="{!! url(
                                        'units/' . $unitIDHashID->encode($issueData->unit_id) . '/' . \App\Models\Unit::getSlug($issueData->unit_id),
                                    ) !!}">
                                        {{ \App\Models\Unit::getUnitName($issueData->unit_id) }}
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
        </div> --}}

        <div class="table_block_body">
            <table>
                <thead>
                    <tr>
                        <th class="type_col">Issue Name</th>
                        <th class="title_col">Unit Name</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($issuesMasterData->count() > 0)
                        @foreach ($issuesMasterData->take(5) as $issueData)
                            <tr>
                                <td class="type_col">
                                    <a href="{{ url('issues/' . $issueIDHashID->encode($issueData->id) . '/view') }}">
                                        {{ $issueData->title }}
                                    </a>
                                </td>
                                <td class="title_col">
                                    <a href="{{ url('units/' . $unitIDHashID->encode($issueData->unit_id) . '/' . \App\Models\Unit::getSlug($issueData->unit_id)) }}">
                                        {{ \App\Models\Unit::getUnitName($issueData->unit_id) }}
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

            <!-- Mobile Table -->
            <div class="mob_table d-sm-none d-block">
                @if ($issuesMasterData->count() > 0)
                    @foreach ($issuesMasterData->take(5) as $issueData)
                        <div class="mob_table_section">
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Issue Name</div>
                                <div class="mob_table_val">
                                    <a href="{{ url('issues/' . $issueIDHashID->encode($issueData->id) . '/view') }}">
                                        {{ $issueData->title }}
                                    </a>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Unit Name</div>
                                <div class="mob_table_val">
                                    <a href="{{ url('units/' . $unitIDHashID->encode($issueData->unit_id) . '/' . \App\Models\Unit::getSlug($issueData->unit_id)) }}">
                                        {{ \App\Models\Unit::getUnitName($issueData->unit_id) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mob_table_section">
                        <div class="mob_table_row">
                            <div class="mob_table_val text-center">No record(s) found.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
    <div class="content_block_bottom">
        <a href="{{ url('issues') }}">See more</a>
    </div>
</div>
