<div class="content_block mt-3">
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
            <table id="watchlist-tasks-table-id">
                <thead>
                    <tr>
                        <th class="title_col">Task Name</th>
                        <th class="type_col">Description</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($watchedTasks as $watchedTask)
                    <tr>

                        <td class="title_col">
                            <a href="{!! url('tasks/'.$taskIDHashID->encode($watchedTask->id).'/'.$watchedTask->slug) !!}" title="edit">
                             {{ $watchedTask->name }}
                            </a>
                        </td>
                        {{-- <td>{{ $watchedTask->name }}</td> --}}
                        <td style="display: none"></td>
                        <td>{{strip_tags($watchedTask->description) }}</td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>


</div>
