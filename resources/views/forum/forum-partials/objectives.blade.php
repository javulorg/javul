<div class="content_block mt-3">
    <div class="table_block table_block_objectives">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
            </div>
            {{ __('messages.objectives') }}
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
                @if(isset($topics[1]) > 0)
                    @foreach($topics[1] as $key => $topic)
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

            </table>

        </div>
    </div>
    <div class="content_block_bottom">
        <a href="{!! url('forum/create').'/'.$unit_id.'/'.'objectives' !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
    </div>
</div>
