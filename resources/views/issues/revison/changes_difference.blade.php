@extends('layout.master')
@section('title', 'Issue: Change Difference')
@section('site-name')
    @if(isset($unitData))
        <h1>{{ $unitData->name }}</h1>
    @else
        <h1>Javul.org</h1>
    @endif
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
@endsection

@section('navbar')
    @if(isset($unitData))
        @include('layout.navbar', ['unitData' => $unitData])
    @endif
@endsection

@section('content')
    <div class="content_row">
        <div class="sidebar">
            @if(isset($unitData))
                @include('layout.v2.global-unit-overview')
                <?php
                $title = 'Activity Log';
                ?>
                @include('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id])

                @include('layout.v2.global-finances')

                @include('layout.v2.global-about-site')
            @else
                <?php
                $title = 'Global Activity Log';
                ?>
                @include('layout.v2.global-activity-log',['title' => $title])
            @endif
        </div>

        <div class="col-md-9 mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-heading d-flex align-items-center">
                        <div class="table_block_icon featured_unit current_issue">
                            <img src="{{ asset('v2/assets/img/bug.svg') }}" style="margin-bottom:6px;" alt="" class="img-fluid">
                        </div>
                        <h4 class="card-title ml-3" style="font-size: medium;">Comparing Revisions</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row hide">
                                <div class="col-md-6">
                                    <hr>
                                    <div class="sub-content main-content">
                                        {{--                                        {!! strip_tags($revisions[0]['description']) !!}--}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <hr>
                                    <div class="sub-content compare-content">
                                        {{--                                        {!! strip_tags($revisions[1]['description']) !!}--}}
                                    </div>
                                </div>
                            </div>
                            <div class="viewType">
                                <input type="radio" name="_viewtype" id="sidebyside" onclick="diffUsingJS(0);" />
                                <label for="sidebyside">Side by Side Diff</label>
                                <input type="radio" name="_viewtype" id="inline" onclick="diffUsingJS(1);" />
                                <label for="inline">Inline Diff</label>
                            </div>
                            <div id="diffoutput"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link href="{!! url('assets/plugins/jsdifflib-master/diffview.css') !!}" rel="stylesheet" type="text/css" />
    <script src="{!! url('assets/plugins/jsdifflib-master/difflib.js') !!}" type="text/javascript"></script>
    <script src="{!! url('assets/plugins/jsdifflib-master/diffview.js') !!}" type="text/javascript"></script>


    <script type="text/javascript">
        diffUsingJS();
        function diffUsingJS(viewType) {
            "use strict";

            var getContent = function (id) {
                    var oldHTML = $(id).html().trim();
                    return oldHTML;
                },
                byId = function (id) {
                    return document.getElementById(id);
                },
                base = difflib.stringAsLines(getContent(".compare-content")),
                newtxt = difflib.stringAsLines(getContent(".main-content")),
                sm = new difflib.SequenceMatcher(base, newtxt),
                opcodes = sm.get_opcodes(),
                diffoutputdiv = byId("diffoutput"),
                contextSize = null;

            diffoutputdiv.innerHTML = "";
            diffoutputdiv.appendChild(diffview.buildView({
                baseTextLines: base,
                newTextLines: newtxt,
                opcodes: opcodes,
                baseTextName: "New: {!! date('d/m/Y ha', strtotime($revisions[0]['created_at'])) !!}",
                newTextName: "Old: {!! date('d/m/Y ha', strtotime($revisions[1]['created_at'])) !!}",
                contextSize: contextSize,
                viewType: viewType
            }));
        }
    </script>
@endsection
