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
            @if(!empty($mostTopTasks) && count($mostTopTasks) > 0)
                @foreach($mostTopTasks as $task)
                    <tr>
                        <td>
                            <a href="{!! url('tasks/'.$taskIDHashID->encode($task->task->id).'/edit') !!}">
                                {{$task->task->name}}
                            </a>
                        </td>
                        <td>
                            <a href="{!! url('objectives/'.$objectiveIDHashID->encode($task->task->objective_id).'/edit') !!}">
                                {{\App\Models\Objective::getObjectiveName($task->task->objective_id)}}
                            </a>
                        </td>
                        <td>
                            <a href="{!! url('units/'.$unitIDHashID->encode($task->task->unit_id).'/edit') !!}">
                                {{\App\Models\Unit::getUnitName($task->task->unit_id)}}
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
