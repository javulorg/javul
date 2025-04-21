<div class="content_block mt-3">
    <div class="table_block table_block_objectives">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
            </div>
            Objectives ({{ $objectivesTotal }})
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        {{-- <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col">Objective Name</th>
                    <th class="last_reply_col">Unit Name</th>
                </tr>
                </thead>
                <tbody>
                @if(count($objectivesMaster) > 0 )
                    @foreach($objectivesMaster as $objective)
                        <tr>
                            <td class="title_col">
                                <a href="{!! url('objectives/'.$objectiveIDHashID->encode($objective->id).'/'.$objective->slug)!!}">
                                    {{ $objective->name }}
                                </a>
                            </td>
                            <td class="last_reply_col">
                                <a href="{!! url('units/'.$unitIDHashID->encode($objective->unit_id).'/'. \App\Models\Unit::getSlug($objective->unit_id) )!!}">
                                    {{ $objective->unit->name }}
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
        </div> --}}

        <div class="table_block_body">
            <table>
                <thead>
                    <tr>
                        <th class="title_col">Objective Name</th>
                        <th class="last_reply_col">Unit Name</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($objectivesMaster->count() > 0)
                        @foreach ($objectivesMaster as $objective)
                            <tr>
                                <td class="title_col">
                                    <a href="{{ url('objectives/' . $objectiveIDHashID->encode($objective->id) . '/' . $objective->slug) }}">
                                        {{ $objective->name }}
                                    </a>
                                </td>
                                <td class="last_reply_col">
                                    <a href="{{ url('units/' . $unitIDHashID->encode($objective->unit_id) . '/' . \App\Models\Unit::getSlug($objective->unit_id)) }}">
                                        {{ $objective->unit->name }}
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
                @if ($objectivesMaster->count() > 0)
                    @foreach ($objectivesMaster as $objective)
                        <div class="mob_table_section">
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Objective Name</div>
                                <div class="mob_table_val">
                                    <a href="{{ url('objectives/' . $objectiveIDHashID->encode($objective->id) . '/' . $objective->slug) }}">
                                        {{ $objective->name }}
                                    </a>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Unit Name</div>
                                <div class="mob_table_val">
                                    <a href="{{ url('units/' . $unitIDHashID->encode($objective->unit_id) . '/' . \App\Models\Unit::getSlug($objective->unit_id)) }}">
                                        {{ $objective->unit->name }}
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
        <a href="{{ url('objectives') }}">See more</a>
    </div>
</div>
