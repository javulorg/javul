<div class="content_block mt-3">
    <div class="table_block table_block_ideas">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/humbleicons_bulb.svg') }}" alt="" class="img-fluid">
            </div>
            Idea
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        <div class="table_block_body">


            <table id="watchlist-idea-table-id">
                <thead>
                <tr>
                    <th class="title_col">Idea Name</th>
                    <th class="type_col">Description</th>
                </tr>
                </thead>
                <tbody>
                    {{-- @dd($watchedIdea) --}}
                    @foreach ($watchedIdea as $watchedIdeas)
                        <tr>
                            <td>{{ $watchedIdeas->title }}</td>
                            <td style="display: none"></td>
                            <td>{{strip_tags($watchedIdeas->description)  }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
