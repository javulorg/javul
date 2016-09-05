@if(count($objectives) > 0 )
    @foreach($objectives as $obj)
        <tr>
            <td>
                <a href="{!! url('objectives/'.$objectiveIDHashID->encode($obj->id).'/'.$obj->slug) !!}" title="edit">
                    {{$obj->name}}
                </a>
            </td>
            <td  class="text-center">{{\App\Task::getTaskCount('available',$obj->id)}}</td>
            <td  class="text-center">{{\App\Task::getTaskCount('in-progress',$obj->id)}}</td>
            <td  class="text-center">{{\App\Task::getTaskCount('completed',$obj->id)}}</td>
        </tr>
    @endforeach
@endif