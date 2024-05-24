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
            @if(!empty($mostActiveUnits) && count($mostActiveUnits) > 0)
                @foreach($mostActiveUnits as $unit)
                    <tr>
                        <td>
                            <a href="{!! url('units/'.$unitIDHashID->encode($unit->unit->id).'/edit') !!}">
                                {{$unit->unit->name}}
                            </a>
                        </td>
                        <td>
                            <span class="colorLightGreen">{{$unit->total_points}}</span>
                        </td>
                    </tr>
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
