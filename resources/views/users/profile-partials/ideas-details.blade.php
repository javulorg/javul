<div class="list-group tab-pane table-responsive" id="tasks_details">
    <div class="table-responsive" style="border:1px solid #ddd;">
        <table class="table" style="margin-bottom: 0px;">
            <thead>
            <tr>
                <th>Idea Name</th>
                <th>Unit Name</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($mostTopIdeas) && count($mostTopIdeas) > 0)
                @foreach($mostTopIdeas as $idea)
                    <tr>
                        <td>
                            <a href="{!! url('ideas/'.$ideaHashID->encode($idea->idea->id).'/edit') !!}">
                                {{ $idea->idea->title }}
                            </a>
                        </td>
                        <td>
                            <a href="{!! url('units/'.$unitIDHashID->encode($idea->idea->unit_id).'/edit') !!}">
                                {{\App\Models\Unit::getUnitName($idea->idea->unit_id)}}
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
