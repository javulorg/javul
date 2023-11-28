<div class="list-group tab-pane table-responsive" id="objectives_details">
    <div class="table-responsive" style="border:1px solid #ddd;">
        <table class="table" style="margin-bottom: 0px;">
            <thead>
            <tr>
                <th>Objective Name</th>
                <th>Unit Name</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($objectivesObj) && count($objectivesObj) > 0)
                @foreach($objectivesObj as $objective)
                    <tr>
                        <td>
                            <a href="{!! url('objectives/'.$objectiveIDHashID->encode($objective->id).'/edit') !!}">
                                {{$objective->name}}
                            </a>
                        </td>
                        <td>
                            <a href="{!! url('units/'.$unitIDHashID->encode($objective->unit_id).'/edit') !!}">
                                {{\App\Models\Unit::getUnitName($objective->unit_id)}}
                            </a>
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
