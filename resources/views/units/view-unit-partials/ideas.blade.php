<div class="content_block mt-3 mb-4">
    <div class="table_block table_block_ideas">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <img src="{{ asset('v2/assets/img/humbleicons_bulb.svg') }}" alt="" class="img-fluid">
                        </div>
                        Ideas
                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="table_block_body">
                        <table>
                            <thead>
                            <tr>
                                <th class="title_col">Idea Name</th>
                                <th class="type_col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($ideas) > 0)
                                @foreach($ideas as $idea)
                                    <tr>
                                        <td class="title_col">
                                            <a href="{!! url('ideas/'.$ideaHashID->encode($idea->id)) !!}">
                                                {{ $idea->title }}
                                            </a>
                                        </td>
                                        @if($idea->status == 1)
                                             <td class="type_col"> Draft</td>
                                        @elseif($idea->status == 2)
                                            <td class="type_col">Assigned to Task</td>
                                        @else
                                            <td class="type_col">Implemented</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No record(s) found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="mob_table d-sm-none d-block">
                        </div>
                    </div>
                </div>
    <div class="d-flex justify-content-between mt-2">
        <div class="pagination-left">
        </div>
        <div class="pagination-right">
            <a href="{!! url('ideas/'.$unitIDHashID->encode($unit_activity_id).'/add') !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
        </div>
    </div>
</div>


