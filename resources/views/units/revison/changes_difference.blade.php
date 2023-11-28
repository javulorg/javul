@extends('layout.master')
@section('title', 'Unit : Compare Revisions')
@section('style')
    <link href="{!! url('assets/plugins/jsdifflib-master/diffview.css') !!}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="content_row">

    @include('layout.v2.global-sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header current_unit_heading featured_unit_heading">
                    <h4 class="card-title">Comparing Revisions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 d-none">
                            <hr>
                            <div class="sub-content main-content">
                                {!! strip_tags($revisions[0]['description']) !!}
                            </div>
                        </div>
                        <div class="col-md-6 d-none">
                            <hr>
                            <div class="sub-content compare-content">
                                {!! strip_tags($revisions[1]['description']) !!}
                            </div>
                        </div>
                        <div class="viewType mt-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="_viewtype" id="sidebyside" onclick="diffUsingJS(0);" />
                                <label class="form-check-label" for="sidebyside">Side by Side Diff</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="_viewtype" id="inline" onclick="diffUsingJS(1);" />
                                <label class="form-check-label" for="inline">Inline Diff</label>
                            </div>
                        </div>
                        <div id="diffoutput"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script src="{!! url('assets/plugins/jsdifflib-master/difflib.js') !!}" type="text/javascript"></script>
    <script src="{!! url('assets/plugins/jsdifflib-master/diffview.js') !!}" type="text/javascript"></script>
    <script type="text/javascript">

        diffUsingJS();
        function diffUsingJS(viewType) {
            "use strict";
            var getContent = function (id) {
                    var oldHTML = $.trim($(id).html());
                    return  oldHTML;
                },
                byId = function (id) { return document.getElementById(id); },
                base = difflib.stringAsLines(getContent(".compare-content")),
                newtxt = difflib.stringAsLines(getContent(".main-content")),
                sm = new difflib.SequenceMatcher(base, newtxt),
                opcodes = sm.get_opcodes(),
                diffoutputdiv = byId("diffoutput"),
                contextSize =  null;
                diffoutputdiv.innerHTML = "";
                diffoutputdiv.appendChild(diffview.buildView({
                baseTextLines: base,
                newTextLines: newtxt,
                opcodes: opcodes,
                baseTextName: "New : {!! date('d/m/Y ha',strtotime($revisions[0]['created_at'])) !!}",
                newTextName: "Old : {!! date('d/m/Y ha',strtotime($revisions[1]['created_at'])) !!}",
                contextSize: contextSize,
                viewType: viewType
            }));
        }
    </script>
@endsection
