<div class="card">
    <div class="card-body">
        <h4 class="card-title">Relation to objective and task</h4>
        <div class="list-group">
            <div class="list-group-item">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="control-label">
                            Associated Objective
                        </label>
                        <label class="control-label colorLightBlue form-control label-value">
                            @php
                                $objectiveID = $issueObj->objective_id;
                                $objSlug = \App\Models\Objective::getSlug($objectiveID);
                                $objectiveUrl = url('objectives/'.$objectiveIDHashID->encode($objectiveID).'/'.$objSlug);
                                $objectiveName = \App\Models\Objective::getObjectiveName($objectiveID);
                            @endphp
                            <a style="font-weight: normal;" class="no-decoration" href="{{ $objectiveUrl }}">
                                <span class="badge">{{ $objectiveName }}</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">
                            Associated Tasks
                        </label>
                        <label class="control-label colorLightGreen form-control label-value">
                            @php
                                $taskIDs = explode(",", $issueObj->task_id);
                            @endphp
                            @if(count($taskIDs) > 0)
                                @foreach($taskIDs as $taskID)
                                    @php
                                        $taskSlug = \App\Models\Task::getSlug($taskID);
                                        $taskUrl = url('tasks/'.$taskIDHashID->encode($taskID).'/'.$taskSlug);
                                        $taskName = \App\Models\Task::getName($taskID);
                                    @endphp
                                    <a style="font-weight: normal;" class="no-decoration" href="{{ $taskUrl }}">
                                        <span class="badge">{{ $taskName }}</span>
                                    </a>
                                @endforeach
                            @endif
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
