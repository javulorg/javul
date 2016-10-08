@extends('layout.default')
@section('page-css')
<link href="{!! url('assets/plugins/bootstrap-fileinput/fileinput.min.css') !!}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css" rel="stylesheet" type="text/css" />
<style>
    .file-loading{margin: 80px auto;}
    #kv-avatar-errors-1{width: auto !important;}
    .kv-file-zoom{display: none;}
    .select2-results {
        margin: 4px 4px 4px 0;
        max-height: 300px;
        overflow-x: hidden;
        overflow-y: auto;
        padding: 0 0 0 4px;
        position: relative;
    }
    hr, p{margin:0 0 10px !important;}
    .files_image:hover{text-decoration: none;}
    .file_documents{display: inline-block;padding: 10px;}
    select[name='exp_month']{width:80px;display: inline-block;}
    select[name="exp_year"]{width:100px;display: inline-block;}

     .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
         margin: 0;
         padding: 0;
         border: none;
         box-shadow: none;
         text-align: center;
     }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
    .help-block{color:#a94442}

</style>
@endsection
@section('content')

    <div class="container">
        <div class="row form-group">
            @include('elements.user-menu',array('page'=>'user_profile'))
        </div>
        <div class="grey-bg" style="padding:10px;margin-bottom: 10px;margin-top: 15px;  ">
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <div id="kv-avatar-errors-1" class="center-block" style="width:800px;display:none"></div>
                    <div class="profile-div">
                        @if(!empty(Auth::user()->profile_pic))
                            <div class="file-preview-frame" id="preview-1475558631183-0" data-fileindex="0" data-template="image"><div class="kv-file-content">
                                    <img src="{!! url('uploads/user_profile/'.$user_id_encoded.'/'.Auth::user()->profile_pic) !!}"
                                         class="kv-preview-data file-preview-image" style="width:160px;height:auto;">
                                </div><div class="file-thumbnail-footer">
                                    <div class="file-thumb-progress hide"><div class="progress">
                                            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                                                0%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-actions">
                                        <div class="file-footer-buttons">
                                            <button type="button" class="btn btn-xs btn-default remove_profile_pic"
                                                    title="Remove file"><i class="glyphicon glyphicon-trash text-danger"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form class="text-center" method="post" enctype="multipart/form-data">
                                <input id="avatar-2" name="profile_pic" type="file" class="file-loading">
                                <!-- include other inputs if needed and include a form submit (save) button -->
                            </form>
                        @endif

                    </div>
                </div>
                <div class="col-sm-8 col-xs-12">
                    <div class="panel form-group marginTop10">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12"><strong>Society Points:</strong></div>
                                <div class="col-xs-6">
                                    Last 6 months
                                </div>
                                <div class="col-xs-6 text-right">
                                    3,000
                                </div>
                                <div class="col-xs-7">
                                    All time:
                                </div>
                                <div class="col-xs-5 text-right">
                                    50,000
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel form-group">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-8">
                                    <strong>Contribution Ranking:</strong>
                                </div>
                                <div class="col-xs-4 text-right text-gold">
                                    Gold
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel form-group">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <strong>Donations:</strong>
                                </div>
                                <div class="col-xs-7">
                                    Donations Received:
                                </div>
                                <div class="col-xs-5 text-right">
                                    <span class="donation_received">{{number_format($availableBalance,2)}}</span> $
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="message"></div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <!-- tabs left -->
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li @if(count($errors) == 0 || ($errors->has('active') && $errors->first('active')=="personal_info"))
                    class="active" @endif><a href="#personal_info" data-toggle="tab">Personal Info</a></li>
                    @if(!empty($availableBalance) && $availableBalance >= 20)
                    <li @if($errors->has('active') && $errors->first('active')=="withdraw") class="active" @endif>
                        <a href="#withdraw_amount" data-toggle="tab">Withdraw</a>
                    </li>
                    @endif
                    <li><a href="#account_settings" data-toggle="tab">Account Settings</a></li>
                </ul>
                <div id="my-tab-content" class="tab-content">
                    <div class="list-group tab-pane @if(count($errors) == 0 || ($errors->has('active') && $errors->first('active')
                    =='personal_info')) active @endif" id="personal_info">
                        <form novalidate autocomplete="off" method="POST"  id="personal-info">
                            {!! csrf_field() !!}
                            <input type="hidden" name="opt_typ" value="used"/>
                            <div class="list-group tab-pane" id="personal_info">
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label" for="textinput">First Name</label>
                                        <input id="first_name" name="first_name" placeholder="First Name" class="form-control input-md" type="text"
                                            @if(!empty(old('first_name'))) value="{{old('first_name')}}" @else value="{{Auth::user()->first_name}}"
                                        @endif>
                                        <span class="help-block"></span>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label class="control-label" for="textinput">Last Name</label>
                                        <input id="last_name" name="last_name" placeholder="Last Name" class="form-control input-md" type="text"
                                        @if(!empty(old('last_name'))) value="{{old('last_name')}}" @else value="{{Auth::user()->last_name}}" @endif>
                                        <span class="help-block"></span>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label class="control-label" for="textinput">Email</label>
                                        <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text"
                                        @if(!empty(old('email'))) value="{{old('email')}}" @else value="{{Auth::user()->email}}" @endif>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label" for="textinput">Phone</label>
                                        <input id="phone" name="phone" placeholder="Phone" class="form-control input-md" type="text"
                                        @if(!empty(old('phone'))) value="{{old('phone')}}" @else value="{{Auth::user()->phone}}" @endif>
                                        <span class="help-block"></span>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label class="control-label" for="textinput">Mobile</label>
                                        <input id="mobile" name="mobile" placeholder="Mobile" class="form-control input-md" type="text"
                                        @if(!empty(old('mobile'))) value="{{old('mobile')}}" @else value="{{Auth::user()->mobile}}" @endif>
                                        <span class="help-block"></span>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label class="control-label">Country</label>
                                        <div class="input-icon right">
                                            <i class="fa select-error"></i>
                                            <select class="form-control" name="country" id="country">
                                                <option value="">{!! trans('messages.select') !!}</option>
                                                @if(count($countries) > 0)
                                                    @foreach($countries as $id=>$val)
                                                        @if($val == "dash_line" || $val == "dash_line1")
                                                            <option value="{{$id}}" disabled></option>
                                                        @else
                                                            <option value="{{$id}}" @if(Auth::user()->country_id == $id)
                                                            selected=selected @endif>{{$val}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label">State</label>
                                        <div class="input-icon right">
                                            <i class="fa select-error"></i>
                                            <select class="form-control" name="state" id="state" @if(Auth::user()->country_id == "global")
                                                    disabled @endif>
                                                @foreach($states as $id=>$val)
                                                    <option value="{{$id}}" @if(Auth::user()->state_id == $id)
                                                    selected=selected @endif>{{$val}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block"></span>
                                            <span class="states_loader location_loader" style="display: none">
                                                <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label">City</label>
                                        <div class="input-icon right">
                                            <i class="fa select-error"></i>
                                            <select class="form-control" name="city" id="city" @if(Auth::user()->country_id == "global")
                                                disabled @endif>
                                                    @foreach($cities as $cid=>$val)
                                                        <option value="{{$cid}}" @if(Auth::user()->city_id == $cid)
                                                        selected=selected @endif>{{$val}}</option>
                                                    @endforeach
                                            </select>
                                            <span class="help-block"></span>
                                            <span class="cities_loader location_loader" style="display: none">
                                                <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label" for="textinput">Address</label>
                                        <textarea name="address" id="address" @if(!empty(old('address'))) value="{{old('address')}}" @else value="{{Auth::user()->address}}"
                                                  @endif class="form-control input-md">{{Auth::user()->address}}</textarea>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label">Job Skills</label>
                                        <div class="input-icon right">
                                            <i class="fa select-error"></i>
                                            <select class="form-control" name="job_skills[]" id="job_skills" multiple>
                                                @foreach($job_skills as $skill_id=>$skill_name)
                                                    <option value="{{$skill_id}}" @if(!empty($users_skills) && in_array($skill_id,$users_skills))
                                                    selected=selected @endif>{{$skill_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label">Area of Interest</label>
                                        <div class="input-icon right">
                                            <i class="fa select-error"></i>
                                            <select class="form-control" name="area_of_interest[]" id="area_of_interest" multiple>
                                                @foreach($area_of_interest as $area_id=>$area_name)
                                                    <option value="{{$area_id}}" @if(!empty($users_area_of_interest) && in_array($area_id,$users_area_of_interest))
                                                    selected=selected @endif>{{$area_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button id="update_profile" type="button"  class="btn black-btn">
                                            <span class="glyphicon glyphicon-edit"></span> Update Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="list-group tab-pane @if($errors->has('active') && $errors->first('active')=='withdraw') active @endif" id="withdraw_amount">
                        <form role="form" method="post" id="withdraw-amount"  novalidate="novalidate" action="{!! url('account/withdraw') !!}">
                            {!! csrf_field() !!}
                            @if($errors->has('error'))
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Error!</strong> {{$errors->first('error')}}.
                            </div>
                            @endif

                            @if($errors->has('paypal_email'))
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Error!</strong> {{$errors->first('paypal_email')}}.
                            </div>
                            @endif
                            @if(empty(Auth::user()->paypal_email))
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <label for="paypal_email" class="control-label">Paypal Email ID</label>
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input id="paypal_email" type="email" class="form-control" value="{{old('paypal_email')}}"
                                               name="paypal_email"
                                               autocomplete="off" required >
                                    </div>
                                </div>
                            </div>
                            @endif
                            <button type="button" class="btn orange-bg withdraw-submit">
                                <span class="withdraw-text">Transfer my full balance to my Paypal account</span>
                            </button>
                        </form>
                    </div>

                    <div class="list-group tab-pane " id="account_settings">
                         Account Settings
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
    </div>
    @include('elements.footer')
@endsection
@section('page-scripts')
    <script src="{!! url('assets/plugins/bootstrap-fileinput/fileinput.min.js') !!}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.js" type="text/javascript"></script>
    <script>

        var profile_image = '{{Auth::user()->profile_pic}}';
        var remove = ''
        function bindProfilePicUpload(){
            $("#avatar-2").fileinput({
                overwriteInitial: true,
                maxFileSize: 1500,
                showClose: true,
                showCaption: false,
                showBrowse: false,
                browseOnZoneClick: true,
                removeLabel: '',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                showRemove:false,
                showUpload:false,
                removeTitle: 'Cancel or reset changes',
                elErrorContainer: '#kv-avatar-errors-1',
                msgErrorClass: 'alert alert-block alert-danger',
                uploadAsync: false,
                uploadUrl: "{!! url('account/upload_profile') !!}", // your upload server url
                uploadExtraData:{_token:'{{csrf_token()}}'},
                allowedFileExtensions: ["jpg", "png", "gif"]
            });

            $('#avatar-2').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                        response = data.response, reader = data.reader;
                $("#avatar-2").fileinput('destroy');

                var html  ='<div class="file-preview-frame" id="preview-1475558631183-0" data-fileindex="0" data-template="image"><div ' +
                        'class="kv-file-content">'+
                        '<img src="'+response.filename+'?'+Math.random()+'"'+
                        'class="kv-preview-data file-preview-image" style="width:160px;height:auto;">'+
                        '</div><div class="file-thumbnail-footer">'+
                        '<div class="file-actions">'+
                        '<div class="file-footer-buttons">'+
                        '<button type="button" class="btn btn-xs btn-default remove_profile_pic"'+
                        'title="Remove file"><i class="glyphicon glyphicon-trash text-danger"></i></button>'+
                        '</div>'+
                        '<div class="clearfix"></div>'+
                        '</div>'+
                        '</div>'+
                        '</div>';
                $(".profile-div").html(html);

            });

            $("#avatar-2").on('change', function(event) {

                /*$('.kv-preview-data').css('max-width','100%').cropper({
                    aspectRatio: 16 / 9,
                    crop: function(e) {
                        // Output the result data for cropping image.
                        console.log(e.x);
                        console.log(e.y);
                        console.log(e.width);
                        console.log(e.height);
                        console.log(e.rotate);
                        console.log(e.scaleX);
                        console.log(e.scaleY);
                    }
                });*/
            });
        }
        if($.trim(profile_image) != ""){
            $("#avatar-2").fileinput({
                overwriteInitial: true,
                maxFileSize: 1500,
                showClose: false,
                showCaption: false,
                showBrowse: false,
                browseOnZoneClick: false,
                removeLabel: '',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                removeTitle: 'remove profile picture',
                elErrorContainer: '#kv-avatar-errors-2',
                msgErrorClass: 'alert alert-block alert-danger',
                defaultPreviewContent: '<img src="{!! url('uploads/user_profile/'.$user_id_encoded.'/'.Auth::user()->profile_pic) !!}" alt="Your Avatar" style="width:160px">',
                layoutTemplates: {main2: '{preview} ' +  ' {remove} {browse}'},
                allowedFileExtensions: ["jpg", "png", "gif"]
            });
        }
        else {
            bindProfilePicUpload();
        }
    </script>
    <script>
        var url = '{{url("assets/images")}}';
        var msg_flag ='{{ $msg_flag }}';
        var msg_type ='{{ $msg_type }}';
        var msg_val ='{{ $msg_val }}';

        $(function(){

            $(document).off("click",".remove_profile_pic").on('click',".remove_profile_pic",function(e){
                e.preventDefault();
                $.ajax({
                    type:'post',
                    url:'{!!   url("account/remove_profile_pic") !!}',
                    data:{_token:'{{ csrf_token() }}'},
                    dataType:'json',
                    success:function(resp){
                        $(".profile-div").html('<form class="text-center" method="post" enctype="multipart/form-data">'+
                                '<input id="avatar-2" name="profile_pic" type="file" class="file-loading">'+
                        '</form>');
                        bindProfilePicUpload();
                    }
                })
            });

        })

    </script>
    <script src="{!! url('assets/js/custom_tostr.js') !!}" type="text/javascript"></script>
    <script type="text/javascript" src="{!! url('assets/js/users/my_account.js') !!}"></script>
    <script type="text/javascript" src="{!! url('assets/js/jquery.payment.js') !!}"></script>
    <script type="text/javascript" src="{!! url('assets/js/donations.js') !!}"></script>
@endsection