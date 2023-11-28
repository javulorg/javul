@extends('layout.master')
@section('title', 'Wiki : Create Page' )
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
            <div class="card">
                <div class="card-header d-flex align-items-center" style="background-color: #D3D3D3;">
                    <div class="featured_unit current_task me-3">
                        <i class="fa fa-book"></i>
                    </div>
                    @if(isset($edit) && $edit == false)
                    <h4 class="card-title m-0" style="color: #0d1217;">Create New Wiki Page</h4>
                    @else
                        <h4 class="card-title m-0" style="color: #0d1217;">Edit Wiki Page</h4>
                    @endif
                </div>
                <div class="card-body">
                    <form action="" method="post" id="wiki_forum" role="form" enctype="multipart/form-data">
                        @csrf
                        <?php if(isset($wiki_page_rev_id)) { ?>
                        <div class="alert alert-danger text-center mb-4">You are editing an older revision of <?= date("d/m/Y ha",strtotime($wiki_page['time_stamp'])) ?> </div>
                        <?php } ?>
                        <?php if( (isset($wiki_page) && !$wiki_page['is_wikihome']) || !isset($wiki_page) )  { ?>
                        <div class="mb-3">
                            <label class="form-label">Page Title</label>
                            <input class="form-control" name="title" value="<?=  isset($wiki_page) ? $wiki_page['wiki_page_title'] : '' ?>">
                        </div>
                        <?php } else{ ?>
                        <input class="form-control" type="hidden" name="title" value="">
                        <?php } ?>
                        <div class="mb-3">
                            <label class="form-label">Page Content</label>
{{--                            <textarea class="form-control old_value hide" ><?=  isset($wiki_page) ? $wiki_page['page_content'] : '' ?></textarea>--}}
                            <textarea class="form-control" id="description" name="description"><?=  isset($wiki_page) ? $wiki_page['page_content'] : '' ?></textarea>
                        </div>
                        <?php if( isset($wiki_page) )  { ?>
                        <div class="mb-3">
{{--                            <label class="form-label">Edit Comment</label>--}}
{{--                            <input class="form-control" name="edit_comment" value="{{ $ }}">--}}
                        </div>
                        <?php } ?>
                        <input type="hidden" name="id" value="<?=  isset($wiki_page) ? $wiki_page['wiki_page_id'] : '0' ?>">
                        <input type="hidden" name="is_wikihome" value="<?=  isset($wiki_page) ? $wiki_page['is_wikihome'] : '0' ?>">
                        <input type="hidden" name="wiki_page_rev_id" value="<?=  isset($wiki_page_rev_id) ? $wiki_page_rev_id : '0' ?>">



                        @if(isset($edit) && $edit == false)
                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-primary">Save Page</button>
                            </div>
                        @else
                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-primary">Update Page</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>




        </div>
    </div>
@endsection
@section('scripts')

    <script type="text/javascript">
        $(document).ready(function () {
            ClassicEditor
                .create(document.querySelector('#description'))
                .catch(error => {
                    console.error(error);
                });
            var xhr;
            $("#wiki_forum").submit(function ()
            {
                if (xhr && xhr.readyState != 4)
                {
                    xhr.abort();
                }
                $("#wiki_forum").find(".alert").remove();
                xhr = $.ajax({
                    type: 'post',
                    url: '{!! url('wiki/edit')."/". $unit_id ."/". $slug  !!}',
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function () {
                        $("#wiki_forum button").button("loading");
                    },
                    error: function () {

                    },
                    complete: function () {
                        $("#wiki_forum button").button("reset");
                    },
                    success: function (json) {
                        console.log(json);
                        if (json['errors']) {
                            $.each(json['errors'], function (i, j) {
                                $("[name='" + i + "']").after("<div class='alert alert-danger'> " + j + " </div>");
                            })
                        }
                        if (json['success']) {
                            toastr['success'](json['success'], '');
                            toastr.success('The new page has been created', 'Success')
                            setTimeout(function () {
                                location = json['location']
                            }, 1000);
                            //setTimeout(function(){ history.back() },1000);
                        }
                        if (json['error']) {
                            toastr['error'](json['error'], '');
                        }
                    }
                });
                return false;
            });

        });
    </script>
@endsection
