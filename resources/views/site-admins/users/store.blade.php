@extends('layout.app')

@section('title', 'Create User')
@section('style')
@endsection
@section('site-name')
    <h1>Javul.org</h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
@endsection
@section('content')
    <div class="content_row">
        <div class="sidebar">
            <?php $title = 'Global Activity Log'; ?>
            @include('layout.v2.global-activity-log',['title' => $title])
        </div>

        <div class="panel panel-grey panel-default col-md-9">
            <div class="panel-heading">
                <h4>Create User</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post"  action="{{ url('ideas') }}">
                        @csrf
                        @method('post')
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label class="control-label">First Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name"/>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="control-label">Last Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"/>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label class="control-label">E-mail</label>
                                <div class="input-icon right">
                                    <input type="email" name="email" class="form-control" placeholder="E-mail"/>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label class="control-label">Phone</label>
                                <div class="input-icon right">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone"/>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 form-group">
                                <label class="control-label">Role : </label>
                                <div class="input-icon right">
                                    <select class="form-control" data-live-search="true" name="role">
                                        <option selected disabled>Select Role</option>
                                            <option value="unit_admin">Unit Administration</option>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Create User</span>
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
    <script type="text/javascript">
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
