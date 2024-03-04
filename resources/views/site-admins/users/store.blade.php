@extends('layout.app')

@section('title', 'Create User')
@section('style')
    <style>
        .password-container {
            position: relative;
            width: 100%;
            max-width: 400px;
        }
        .password-container input[type="password"],
        .password-container input[type="text"] {
            width: 100%;
            padding-right: 40px; /* Make space for the eye icon */
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
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
                    <form role="form" method="post"  action="{{ url('site-admin/users/store') }}">
                        @csrf
                        @method('post')
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label class="control-label">First Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" required/>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="control-label">Last Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="last_name" class="form-control" placeholder="Enter the Last Name" required/>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label class="control-label">E-mail</label>
                                <div class="input-icon right">
                                    <input type="email" name="email" class="form-control" placeholder="Enter the E-mail" required/>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label for="password"  class="control-label">Password</label>
                                <div class="input-icon right password-container">
                                    <input  type="password" name="password" id="password" class="form-control" placeholder="Enter the password" required/>
                                    <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility()"></i>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label for="phone" class="control-label">Phone</label>
                                <div class="input-icon right">
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone"/>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2 form-group">
                                <label class="control-label">Role : </label>
                                <div class="input-icon right">
                                    <select class="form-control" data-live-search="true" name="role">
                                        <option selected disabled>Select Role</option>
                                            <option value="2">Unit Administration</option>
                                            <option value="3">Task Administration</option>
                                            <option value="4">Normal User</option>
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

            function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            const isPassword = passwordInput.type === 'password';

            if (isPassword) {
            passwordInput.type = 'text';
            toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
        }
    </script>
@endsection
