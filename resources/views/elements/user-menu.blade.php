<div class="col-sm-12 blue-bg alert user-menu">
    <a href="{!! url('units') !!}"class="btn blue-bg btn-lg @if($page=='units') active @endif"><span class="glyphicon glyphicon-list-alt"></span> Units</a>
    <a href="{!! url('objectives') !!}"class="btn blue-bg btn-lg @if($page=='objectives') active @endif"><span class="glyphicon glyphicon-list-alt"></span> Objectives</a>
    <a href="{!! url('tasks') !!}"class="btn blue-bg btn-lg @if($page=='tasks') active @endif"><span class="glyphicon glyphicon-tasks"></span> Tasks</a>
</div>