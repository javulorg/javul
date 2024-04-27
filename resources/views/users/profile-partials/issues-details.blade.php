<div class="list-group tab-pane table-responsive" id="tasks_details">
    <div class="table-responsive" style="border:1px solid #ddd;">
        <table class="table" style="margin-bottom: 0px;">
            <thead>
            <tr>
                <th>Issue Name</th>
                <th>Objective Name</th>
                <th>Unit Name</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($mostTopIssues) && count($mostTopIssues) > 0)
                @foreach($mostTopIssues as $issue)
                    <tr>
                        <td>
                            <a href="{!! url('issues/'.$issueIDHashID->encode($issue->issue->id).'/edit') !!}">
                                {{$issue->issue->title}}
                            </a>
                        </td>
                        <td>
                            <a href="{!! url('objectives/'.$objectiveIDHashID->encode($issue->issue->objective_id).'/edit') !!}">
                                {{\App\Models\Objective::getObjectiveName($issue->issue->objective_id)}}
                            </a>
                        </td>
                        <td>
                            <a href="{!! url('units/'.$unitIDHashID->encode($issue->issue->unit_id).'/edit') !!}">
                                {{\App\Models\Unit::getUnitName($issue->issue->unit_id)}}
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
    </div>
</div>
