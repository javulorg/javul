<div class="col-sm-12">
    <div class="blue-bg alert user-menu">
        <a href="{!! url('units') !!}" class="btn blue-bg btn-md @if($page=='units') active @endif">
            <span class="glyphicon glyphicon-list-alt"></span> Units
        </a>
        <a href="{!! url('objectives') !!}" class="btn blue-bg btn-md @if($page=='objectives') active @endif">
            <span class="glyphicon glyphicon-list-alt"></span> Objectives
        </a>
        <a href="{!! url('tasks') !!}" class="btn blue-bg btn-md @if($page=='tasks') active @endif">
            <span class="glyphicon glyphicon-tasks"></span> Tasks
        </a>
        <a href="{!! url('my_tasks') !!}" class="btn blue-bg btn-md pull-right @if($page=='my_tasks') active @endif">
            <span class="glyphicon glyphicon-tasks"></span> My Tasks
        </a>
    </div>
</div>