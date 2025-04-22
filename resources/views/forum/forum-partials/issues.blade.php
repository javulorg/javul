{{--<div class="d-flex justify-content-between mt-2">--}}
{{--    <div class="pagination-left">--}}
{{--        <a class="btn btn-secondary btn-sm" href="{!! url('forum/create').'/'.$unit_id.'/'.'issues' !!}">Create New Topic</a>--}}
{{--    </div>--}}
{{--    <div class="pagination-right">--}}
{{--        <a class="btn btn-secondary btn-sm" href="{!! url('forum/'. $unit_id .'/issues') !!}">All Topics</a>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="content_block mt-3">
    <div class="table_block table_block_issues">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">
            </div>
            Issues
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col">Thread title </th>
                    <th class="last_reply_col">Created By</th>
                    <th class="last_reply_col">Replies</th>
                </tr>
                </thead>

                <tbody>
                @if(isset($topics[3]) > 0)
                    @foreach($topics[3] as $key => $topic)
                        <tr>
                            <td class="title_col">
                                <a href="{!! url('forum/post').'/'.$topic['topic_id'].'/'.$topic['slug'] !!}"> <?= $topic['title'] ?> </a>
                            </td>

                            <td class="last_reply_col">
                                <a href="{!! $topic['link_user'] !!}"> <?= $topic['first_name'] ." ". $topic['last_name'] ?> </a>
                            </td>

                            <td class="last_reply_col">
                                <?= $topic['post'] ?>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No record(s) found.</td>
                    </tr>
                @endif
                </tbody>


                <div class="mob_table d-sm-none d-block">
                    @if(isset($topics[3]) && count($topics[3]) > 0)
                        @foreach($topics[3] as $key => $topic)
                            <div class="mob_table_section">
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">Thread Title</div>
                                    <div class="mob_table_val">
                                        <a href="{{ url('forum/post/'.$topic['topic_id'].'/'.$topic['slug']) }}">
                                            {{ $topic['title'] }}
                                        </a>
                                    </div>
                                </div>
                
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">Created By</div>
                                    <div class="mob_table_val">
                                        <a href="{{ $topic['link_user'] }}">
                                            {{ $topic['first_name'] . ' ' . $topic['last_name'] }}
                                        </a>
                                    </div>
                                </div>
                
                                <div class="mob_table_row">
                                    <div class="mob_table_ttl">Replies</div>
                                    <div class="mob_table_val">
                                        {{ $topic['post'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="mob_table_section">
                            <div class="mob_table_row">
                                <div class="mob_table_val text-center">No record(s) found.</div>
                            </div>
                        </div>
                    @endif
                </div>
                
            </table>

        </div>
    </div>
    <div class="content_block_bottom">
        <a href="{!! url('forum/create').'/'.$unit_id.'/'.'issues' !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
    </div>
</div>

