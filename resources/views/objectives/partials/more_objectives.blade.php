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

    @if($objectives->lastPage() > 1 && $objectives->lastPage() != $objectives->currentPage())
        <a href="#" data-url="{{$objectives->url($objectives->currentPage()+1) }}" class="btn
                                    more-black-btn more-objectives" type="button">
            <span class="more_dots">...</span> MORE OBJECTIVES
        </a>
    @endif
@endif