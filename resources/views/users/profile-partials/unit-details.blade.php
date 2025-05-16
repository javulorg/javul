<div class="list-group tab-pane active table-responsive" id="unit_details">
    <div class="table-responsive" style="border:1px solid #ddd; ">
        <table class="table">
            <thead>
                <tr>
                    <th>Unit Name</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($mostActiveUnits) && count($mostActiveUnits) > 0)

                    @foreach ($mostActiveUnits as $unit)
                        @if ($unit->total_points > 0)
                            <tr>
                                <td>{{ $unit->unit_name }}</td> {{-- ya $unit->name agar naam chahiye --}}
                                <td>{{ $unit->total_points }}</td>
                            </tr>
                        @endif
                    @endforeach

                @else
                    <tr>
                        <td colspan="3">No record(s) found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
