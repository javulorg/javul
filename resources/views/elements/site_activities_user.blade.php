<div class="panel panel-dark-grey panel-default">
    <div class="panel-heading">
        <h4>{!! Lang::get('messages.activity_log') !!}</h4>
    </div>
    <div class="panel-body list-group">
        @if(count($site_activity) > 0)
            @foreach($site_activity as $activity)
                <div class="list-group-item">
                    <span class="glyphicon glyphicon-ok"></span>
                    {!! $activity->comment !!}
                    <span class="smallText">&nbsp;({{\App\Library\Helpers::timetostr($activity->created_at)}})</span>
                </div>
            @endforeach
        @else
            <div class="list-group-item">
                No activity found.
            </div>
        @endif
        <!--<a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Objective 1 Created by User 3
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Objective 3 edited by User 4
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Task 1 edited(Objective 1)
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Task 2 created(Objective 1)
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Task 3 assigned to User 1 (Objective 1)
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Objective 1 Created by User 3
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Objective 3 edited by User 4
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Task 1 edited(Objective 1)
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Task 2 created(Objective 1)
        </a>
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-ok"></span>
            Objective 3 edited by User 4
        </a>-->
    </div>
</div>