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
                        <th class="type_col text-center"><i class="fa fa-trophy"></i></th>
                        <th class="type_col text-center"><i class="fa fa-clock"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($tasks) > 0)
                        @foreach($tasks as $obj)
                            <tr>
                                <td class="title_col">
                                    <a href="{!! url('tasks/' . $taskIDHashID->encode($obj->id) . '/' . $obj->slug) !!}" title="edit">
                                        {{ $obj->name }}
                                    </a>
                                </td>
                                <td class="type_col">
                                    <span class="colorLightGreen">
                                        {{ \App\Models\SiteConfigs::task_status($obj->status) }}
                                    </span>
                                </td>
                                <td class="type_col text-center">
                                    {{ \App\Models\Task::getTaskCount('in-progress', $obj->id) }}
                                </td>
                                <td class="type_col text-center">
                                    {{ \App\Models\Task::getTaskCount('completed', $obj->id) }}
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

            {{-- ✅ Mobile Responsive View --}}
            <div class="mob_table d-sm-none d-block">
                @if(count($tasks) > 0)
                    @foreach($tasks as $obj)
                        <div class="mob_table_section">
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Task Name</div>
                                <div class="mob_table_val">
                                    <a href="{!! url('tasks/' . $taskIDHashID->encode($obj->id) . '/' . $obj->slug) !!}" title="edit">
                                        {{ $obj->name }}
                                    </a>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Status</div>
                                <div class="mob_table_val">
                                    <span class="colorLightGreen">
                                        {{ \App\Models\SiteConfigs::task_status($obj->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl"><i class="fa fa-trophy"></i> In Progress</div>
                                <div class="mob_table_val">
                                    {{ \App\Models\Task::getTaskCount('in-progress', $obj->id) }}
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl"><i class="fa fa-clock"></i> Completed</div>
                                <div class="mob_table_val">
                                    {{ \App\Models\Task::getTaskCount('completed', $obj->id) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mob_table_section">
                        <div class="mob_table_row">
                            <div class="mob_table_val text-center w-100">
                                No record(s) found.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
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
