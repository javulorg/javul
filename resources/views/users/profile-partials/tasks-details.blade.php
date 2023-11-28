<div class="list-group tab-pane table-responsive" id="tasks_details">
    <div class="table-responsive" style="border:1px solid #ddd;">
        <table class="table" style="margin-bottom: 0px;">
            <thead>
            <tr>
                <th>Task Name</th>
                <th>Objective Name</th>
                <th>Unit Name</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($tasksObj) && count($tasksObj) > 0)
                @foreach($tasksObj as $task)
                    <tr>
                        <td>
                            <a href="{!! url('tasks/'.$taskIDHashID->encode($task->id).'/edit') !!}">
                                {{$task->name}}
                            </a>
                        </td>
                        <td>
                            <a href="{!! url('objectives/'.$objectiveIDHashID->encode($task->objective_id).'/edit') !!}">
                                {{\App\Models\Objective::getObjectiveName($task->objective_id)}}
                            </a>
                        </td>
                        <td>
                            <a href="{!! url('units/'.$unitIDHashID->encode($task->unit_id).'/edit') !!}">
                                {{\App\Models\Unit::getUnitName($task->unit_id)}}
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
