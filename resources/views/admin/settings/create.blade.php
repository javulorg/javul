@extends('layout.master')
@section('title', 'Create Category: ')
@section('style')
    <style>
    </style>
@endsection
@section('site-name')
    <h1>{{ $unitObj->name }}</h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
@endsection
@section('navbar')
    @include('layout.navbar', ['unitData' => $unitObj])
@endsection

@section('content')
    <div class="content_row">
        <div class="sidebar">

            @include('layout.v2.global-unit-overview')
            <?php
            $title = 'Activity Log';
            ?>
            @include('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitObj->id])

            @include('layout.v2.global-finances', ['availableFunds' => $availableFunds, 'awardedFunds' => $awardedFunds])

            @include('layout.v2.global-about-site')
        </div>

        <div class="panel panel-grey panel-default col-md-9">
            <div class="panel-heading">
                <h4>Create Unit Category</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post"  action="{{ url('admin/categories') }}">
                        @csrf
                        @method('post')
                        <div class="row">

                            <input type="hidden" name="unit_id" value="{{ $unitObj->id }}">

                            <div class="col-md-12 form-group">
                                <label class="control-label">Category Title</label>
                                <div class="input-icon right">
                                    <input type="text" name="title" class="form-control" placeholder="Category Name" required/>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-3 form-group">
                                <label class="control-label">Status</label>
                                <select class="form-control" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Create Category</span>
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
@endsection
