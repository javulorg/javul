<div class="content_block mt-3 mb-4">
    <div class="table_block table_block_tasks">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
            </div>
            Tasks
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col">Task Name</th>
                    <th class="type_col">Status</th>
                    <th class="type_col"><i class="fa fa-trophy"></i></th>
                    <th class="type_col"><i class="fa fa-clock"></i></th>
                </tr>
                </thead>

                <tbody>
                @if(count($tasks) > 0)
                    @foreach($tasks as $obj)
                        <tr>
                            <td class="title_col">
                                <a href="{!! url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug) !!}"
                                   title="edit">
                                    {{$obj->name}}
                                </a>
                            </td>
                            <td class="type_col">
                                @if($obj->status == "draft")
                                    <span class="colorLightGreen">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>
                                @else
                                    <span class="colorLightGreen">{{\App\Models\SiteConfigs::task_status($obj->status)}}</span>
                                @endif
                            </td>
                            <td class="type_col">{{\App\Models\Task::getTaskCount('in-progress',$obj->id)}}</td>
                            <td class="type_col">{{\App\Models\Task::getTaskCount('completed',$obj->id)}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No record(s) found.</td>
                    </tr>
                @endif
                </tbody>

            </table>

        </div>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <div class="pagination-left">
        </div>
        <div class="pagination-right">
            <a href="{!! url('tasks/add?unit='.$unitIDHashID->encode($unitObj->id)) !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
        </div>
    </div>
</div>
