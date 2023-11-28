@extends('layout.master')
@section('title', 'Issue: ' . $issueObj->title)
@section('style')
    <style>
        .importance-div {
            line-height: 30px;
            padding-top: 4px;
            padding-bottom: 2px;
        }
        .control-label {
            font-weight: 400;
            margin-top: 12px;
        }
        .upper {
            text-transform: uppercase;
        }

        .downvote {
            padding: -2px;
            cursor: pointer;
            color: #7878f5;
        }
        .upvote {
            padding: -2px;
            cursor: pointer;
            color: #d97d43;
        }

        .colorLightBlue, .colorLightBlue a {
            color: #58a0e0 !important;
        }
        .colorLightGreen {
            color: #84b660 !important;
        }

    </style>
@endsection
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

        <div class="main_content">
            <div class="content_block">
                <div class="row form-group">
                    <div class="col-md-12 order-md-2">

                        @include('issues.v2.partials.issue-information')

                        @include('issues.v2.partials.file-attachments')

                        @if($issueObj->status == "resolved")
                            <div class="card mb-3">
                                <div class="card-header">
                                    Resolution
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    {!! $issueObj->resolution !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @include('issues.v2.partials.relation-objectives-tasks')


                        @include('issues.v2.partials.comments')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            ClassicEditor
                .create( document.querySelector('#comment') )
                .catch( error => {
                    console.error(error);
                } );
        });
    </script>

@endsection
