<div class="content_block mt-3">
    <div class="table_block table_block_objectives">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
            </div>
            Objectives
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table id="watchlist-objectives-table-id">
                <thead>
                    <tr>
                        <th class="title_col">Objective Name</th>
                        <th class="title_col">Description</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($watchedUnits as $watchedUnit)
                        <tr>
                            <td>
                                    <a href="{!! url('objectives/' . $objectiveIDHashID->encode($watchedUnit->id) . '/' . $watchedUnit->slug) !!}"
                                        title="edit">
                                        {{ $watchedUnit->name }}
                                    </a>
                                </td>
                            {{-- <td>{{ $watchedUnit->name }}</td> --}}
                            <td style="display: none"></td>
                            <!-- Use strip_tags to remove HTML tags from description -->
                            <td>{{ strip_tags($watchedUnit->description) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
