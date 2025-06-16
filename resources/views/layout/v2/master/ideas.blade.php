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
        {{-- <div class="table_block_body">
            <table>
                <thead>
                    <tr>
                        <th class="type_col">Idea Name</th>
                        <th class="title_col">Unit Name</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($ideasMaster) > 0)
                    @foreach ($ideasMaster->take(5) as $idea)
                    <tr>
                        <td class="type_col">
                            <a href="{!! url('ideas/' . $ideaHashID->encode($idea->id)) !!}">
                                {{ $idea->title }}
                            </a>
                        </td>
                        <td class="title_col">
                            <a
                                href="{!! url('units/' . $unitIDHashID->encode($idea->unit_id) . '/' . \App\Models\Unit::getSlug($idea->unit_id)) !!}">
                                {{ \App\Models\Unit::getUnitName($idea->unit_id) }}
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
            <table id="ideas_table">
                <thead>
                    <tr>
                        <th class="type_col">Idea Name</th>
                        <th class="title_col">Unit Name</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ideasMaster->count() > 0)
                    @foreach ($ideasMaster->take(5) as $idea)
                    <tr>
                        <td class="type_col">
                            <a href="{{ url('ideas/' . $ideaHashID->encode($idea->id)) }}">
                                {{ $idea->title }}
                            </a>
                        </td>
                        <td class="title_col">
                            <a
                                href="{{ url('units/' . $unitIDHashID->encode($idea->unit_id) . '/' . \App\Models\Unit::getSlug($idea->unit_id)) }}">
                                {{ \App\Models\Unit::getUnitName($idea->unit_id) }}
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

            <!-- Mobile View -->
            <div class="mob_table d-sm-none d-block">
                @if ($ideasMaster->count() > 0)
                @foreach ($ideasMaster->take(5) as $idea)
                <div class="mob_table_section">
                    <div class="mob_table_row">
                        <div class="mob_table_ttl">Idea Name</div>
                        <div class="mob_table_val">
                            <a href="{{ url('ideas/' . $ideaHashID->encode($idea->id)) }}">
                                {{ $idea->title }}
                            </a>
                        </div>
                    </div>
                    <div class="mob_table_row">
                        <div class="mob_table_ttl">Unit Name</div>
                        <div class="mob_table_val">
                            <a
                                href="{{ url('units/' . $unitIDHashID->encode($idea->unit_id) . '/' . \App\Models\Unit::getSlug($idea->unit_id)) }}">
                                {{ \App\Models\Unit::getUnitName($idea->unit_id) }}
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
        <a href="{{ isset($idea) ? url('ideas/' . $unitIDHashID->encode($idea->unit_id) . '/add') : '#' }}">
            Add New
        </a>
        <div class="separator"></div>
        <a href="{{ url('ideas') }}">See more</a>
    </div>
</div>
