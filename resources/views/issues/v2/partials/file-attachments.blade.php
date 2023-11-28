{{--<div class="panel panel-grey panel-default mt-2" style="margin-bottom: 30px;">--}}
{{--    <div class="panel-heading">--}}
{{--        File Attachments--}}
{{--    </div>--}}
{{--    <div class="panel-body">--}}
{{--        @if(!empty($issueObj->issue_documents) && count($issueObj->issue_documents) > 0)--}}
{{--            <ul class="list-group" style="list-style-type: decimal;">--}}
{{--                @foreach($issueObj->issue_documents as $index => $document)--}}
{{--                    <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>--}}
{{--                    @if($extension == "pdf")--}}
{{--                        <?php $extension = "pdf"; ?>--}}
{{--                    @elseif(in_array($extension, ["doc", "docx"]))--}}
{{--                        <?php $extension = "docx"; ?>--}}
{{--                    @elseif(in_array($extension, ["jpg", "jpeg"]))--}}
{{--                        <?php $extension = "jpeg"; ?>--}}
{{--                    @elseif(in_array($extension, ["ppt", "pptx"]))--}}
{{--                        <?php $extension = "pptx"; ?>--}}
{{--                    @else--}}
{{--                        <?php $extension = "file"; ?>--}}
{{--                    @endif--}}
{{--                    <li class="list-group-item">--}}
{{--                        <a class="files_image" href="{!! url($document->file_path) !!}" target="_blank">--}}
{{--                            @if(empty($document->file_name))--}}
{{--                                &nbsp;--}}
{{--                            @else--}}
{{--                                {{$document->file_name}}--}}
{{--                            @endif--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        @else--}}
{{--            <div class="list-group">--}}
{{--                <li class="list-group-item">No documents found.</li>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}



<div class="card mt-4" style="margin-bottom: 30px;">
    <div class="card-header">
        File Attachments
    </div>
    <div class="card-body">
        @if(!empty($issueObj->issue_documents) && count($issueObj->issue_documents) > 0)
            <ul class="list-group" style="list-style-type: decimal;">
                @foreach($issueObj->issue_documents as $index => $document)
                    <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>
                    @if($extension == "pdf")
                        <?php $extension = "pdf"; ?>
                    @elseif(in_array($extension, ["doc", "docx"]))
                        <?php $extension = "docx"; ?>
                    @elseif(in_array($extension, ["jpg", "jpeg"]))
                        <?php $extension = "jpeg"; ?>
                    @elseif(in_array($extension, ["ppt", "pptx"]))
                        <?php $extension = "pptx"; ?>
                    @else
                        <?php $extension = "file"; ?>
                    @endif
                    <li class="list-group-item">
                        <a class="files_image" href="{{ asset($document->file_path) }}" target="_blank">
                            @if(empty($document->file_name))
                                &nbsp;
                            @else
                                {{$document->file_name}}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="list-group">
                <li class="list-group-item">No documents found.</li>
            </div>
        @endif
    </div>
</div>
