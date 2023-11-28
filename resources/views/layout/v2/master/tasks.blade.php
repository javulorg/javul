<div class="content_block mt-3">
    <div class="table_block table_block_tasks">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
            </div>
            Tasks ({{ $tasksMasterTotal }})
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="type_col">Task Name</th>
                    <th class="title_col">Unit Name</th>
                </tr>
                </thead>
                <tbody>
                @if(count($tasksMaster) > 0 )
                    @foreach($tasksMaster as $task)
                        <tr>
                            <td class="type_col">
                                <a href="{!! url('tasks/'.$taskIDHashID->encode($task->id) . '/' . $task->slug) !!}">
                                    {{$task->name}}
                                </a>
                            </td>
                            <td class="title_col">
                                <a href="{!! url('units/'.$unitIDHashID->encode($task->unit_id).'/'.\App\Models\Unit::getSlug($task->unit_id)) !!}">
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
    <div class="content_block_bottom">
        <a href="{{ url('tasks') }}">See more</a>
    </div>
</div>
