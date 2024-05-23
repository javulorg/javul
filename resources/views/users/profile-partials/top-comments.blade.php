<div class="list-group tab-pane active table-responsive" id="unit_details">
    <div class="table-responsive" style="border:1px solid #ddd; ">
        <table class="table">
            <thead>
            <tr>
                <th>Unit</th>
                <th>Section</th>
                <th>Comment</th>
                <th>Time</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($topComments) && count($topComments) > 0)
                @foreach($topComments as $comment)
                    <tr>
                        <td>
                            @php $section = \App\Models\Forum::checkSection($comment->topic_id) @endphp
                            <a href="{!! $section['unit_url'] !!}">
                                {{ $section['unit_name'] }}
                            </a>
                        </td>
                        <td>
                            @php $section = \App\Models\Forum::checkSection($comment->topic_id) @endphp
                            <span class="colorLightGreen">{!! $section['section'] !!}</span>
                        </td>
                        <td>
                            @php $section = \App\Models\Forum::checkSection($comment->topic_id) @endphp
                            <a href="{!! $section['url'] !!}">
                                {{ substr($comment->post, 0, 60) }}{{ strlen($comment->post) > 60 ? '...' : '' }}
                            </a>
                        </td>

                        <td>
                            @if($comment->created_time)
                                {{ Carbon\Carbon::parse($comment->created_time)->diffForHumans() }}
                            @else
                                N/A
                            @endif
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
