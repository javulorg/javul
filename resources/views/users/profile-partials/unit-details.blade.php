<div class="list-group tab-pane active table-responsive" id="unit_details">
    <div class="table-responsive" style="border:1px solid #ddd; ">
        <table class="table">
            <thead>
            <tr>
                <th>Unit Name</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($unitsObj) && count($unitsObj) > 0)
                @foreach($unitsObj as $unit)
                    <tr>
                        <td>
                            <a href="{!! url('units/'.$unitIDHashID->encode($unit->id).'/edit') !!}">
                                {{$unit->name}}
                            </a>
                        </td>
                        <td>
                            <span class="colorLightGreen">{{$unit->status}}</span>
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
