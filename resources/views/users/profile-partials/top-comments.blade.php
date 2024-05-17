<div class="list-group tab-pane active table-responsive" id="unit_details">
    <div class="table-responsive" style="border:1px solid #ddd; ">
        <table class="table">
            <thead>
            <tr>
                <th>Comment</th>
                <th>Likes</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($topComments) && count($topComments) > 0)
                @foreach($topComments as $comment)
                    <tr>
                        <td>
                            @php $section = \App\Models\Forum::checkSection($comment->topic_id) @endphp
                            <a href="{!! $section !!}">
                                {{$comment->post}}
                            </a>
                        </td>
                        <td>
                            <span class="colorLightGreen">{{$comment->likes}}</span>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">No record(s) found.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
