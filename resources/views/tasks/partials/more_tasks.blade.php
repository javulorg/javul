@if(count($tasks) > 0 )
    @foreach($tasks as $obj)
        <tr>
            <td width="60%">
                <a href="{!! url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug) !!}"
                   title="edit">
                    {{$obj->name}}
                </a>
            </td>
            <td width="20%" class="text-center">
                @if($obj->status == "editable")
                    <span class="colorLightGreen">{{\App\SiteConfigs::task_status($obj->status)}}</span>
                @else
                    <span class="colorLightGreen">{{\App\SiteConfigs::task_status($obj->status)}}</span>
                @endif
            </td>
            <td class="text-center">{{\App\Task::getTaskCount('in-progress',$obj->id)}}</td>
            <td class="text-center">{{\App\Task::getTaskCount('completed',$obj->id)}}</td>
        </tr>
    @endforeach

    @if($tasks->lastPage() > 1 && $tasks->lastPage() != $tasks->currentPage())
        <tr style="background-color: #fff !important;text-align: right">
        <td colspan="4">
            <a href="#" data-url="{{$tasks->url($tasks->currentPage()+1) }}" class="btn
                                    more-black-btn more-tasks" type="button">
                <span class="more_dots">...</span> MORE TASKS
            </a>
        </td>
        </tr>
    @endif

@endif