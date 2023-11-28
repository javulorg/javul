@extends('layout.master')
@section('title', 'Comparing Revisions')
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
                        <div class="featured_unit current_task me-3">
                            <i class="fa fa-book"></i>
                        </div>
                        <h4 class="card-title m-0" style="color: #0d1217;">Comparing Revisions: {{ $difference['title'] }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row hide">
                                <div class="col-md-6">
                                    <hr>
                                    <div class="sub-content main-content">
                                        {!! $difference['main']['page_content'] !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <hr>
                                    <div class="sub-content compare-content">
                                        {!! $difference['compare']['page_content'] !!}
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
                    <div class="d-flex justify-content-between mt-2">
                        <div class="pagination-left">
                            <a href="{!! url('wiki/all_pages') !!}/{!! $unit_id !!}/{!! $slug !!}"><i class="fa fa-list"></i>  List All Pages</a>
                        </div>
                        <div class="pagination-right">
                            <a href="{!! url('wiki/edit') !!}/{!! $unit_id !!}/{!! $slug !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
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
                baseTextName: "New : {!! date('d/m/Y ha',strtotime($difference['main']['time_stamp'])) !!}",
                newTextName: "Old : {!! date('d/m/Y ha',strtotime($difference['compare']['time_stamp'])) !!}",
                contextSize: contextSize,
                viewType: viewType
            }));
        }
    </script>
@endsection
