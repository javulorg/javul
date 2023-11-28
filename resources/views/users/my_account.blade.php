@extends('layout.master')
@section('title', 'My Account')
@section('style')
    <style>
        /* Customize tab styles */
        .nav-tabs > li > a {
            border: none;
            color: #222;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            background-color: transparent;
            border-radius: 0;
            margin-right: 10px;
        }

        .nav-tabs > li.active > a,
        .nav-tabs > li.active > a:hover,
        .nav-tabs > li.active > a:focus {
            color: #fff;
            background-color: #007bff;
            border: none;
        }

        .nav-tabs > li > a:hover,
        .nav-tabs > li > a:focus {
            color: #007bff;
            background-color: #f7f7f7;
            border: none;
        }

        /* Optional: add a bottom border to the active tab */
        .nav-tabs > li.active > a {
            border-bottom: 2px solid #007bff;
        }

        /* Change tab color when clicked */
        .nav-tabs > li > a:active,
        .nav-tabs > li.active > a {
            color: #fff;
            background-color: #6c757d;
            border: none;
        }

        /* Disable other tabs */
        .nav-tabs > li.disabled > a {
            color: #999;
            background-color: transparent;
            border: none;
            cursor: not-allowed;
        }

        .nav-tabs > li.disabled > a:hover,
        .nav-tabs > li.disabled > a:focus {
            color: #999;
            background-color: transparent;
            border: none;
            cursor: not-allowed;
        }
        #address{ resize: vertical; }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-sm-12">
        <div class="card mb-6">
            <div class="card-body overflow-auto">

                <div class="row">
                    @include('users.user-account-partials.profile-summery')
                    @include('users.user-account-partials.profile-picture')
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs navigation -->
    <ul class="nav nav-tabs mt-4 mb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal_info" type="button" role="tab" aria-controls="personal-info" aria-selected="true">Personal Info</button>
        </li>

        @if(!empty($availableBalance) && $availableBalance > 0)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="withdraw-amount-tab" data-bs-toggle="tab" data-bs-target="#withdraw_amount" type="button" role="tab" aria-controls="withdraw_amount" aria-selected="false">Withdraw</button>
            </li>
        @endif

        @if(!empty($withdrawal_list) && count($withdrawal_list) > 0)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="withdrawal-list-tab" data-bs-toggle="tab" data-bs-target="#withdrawal_list" type="button" role="tab" aria-controls="withdrawal-list" aria-selected="false">Withdrawal List</button>
            </li>
        @endif

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="account-settings-tab" data-bs-toggle="tab" data-bs-target="#account_settings" type="button" role="tab" aria-controls="account-settings" aria-selected="false">Alert Settings</button>
        </li>
    </ul>

    <!-- Tabs content -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="personal_info" role="tabpanel" aria-labelledby="personal-info-tab">
            @include('users.user-account-partials.personal-info')
        </div>

        <div class="tab-pane fade" id="withdraw_amount" role="tabpanel" aria-labelledby="withdraw-amount-tab">
            @include('users.user-account-partials.withdraw-amount')
        </div>

        <div class="tab-pane fade" id="withdrawal_list" role="tabpanel" aria-labelledby="withdrawal-list-tab">
            @include('users.user-account-partials.withdraw-list')
        </div>

        <div class="tab-pane fade" id="account_settings" role="tabpanel" aria-labelledby="account-settings-tab">
            @include('users.user-account-partials.account-settings')
        </div>

    </div>

@endsection
@section('scripts')
    <script>

        var profile_image = '{{auth()->user()->profile_pic}}';
        var remove = '';
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
                    '<img id="profpicc" src="'+response.filename+'?'+Math.random()+'"'+
                    'class="kv-preview-dataaa file-preview-image" style="width:160px;height:auto;">'+
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
                $(".profile-div").append(html);

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
                defaultPreviewContent: '<img src="{!! url('uploads/user_profile/'.$user_id_encoded.'/'.auth()->user()->profile_pic) !!}" alt="Your Avatar" style="width:160px">',
                layoutTemplates: {main2: '{preview} ' +  ' {remove} {browse}'},
                allowedFileExtensions: ["jpg", "png", "gif"]
            });
        }
        else {
            bindProfilePicUpload();
        }

        $(function(){
            $(".alerts").on('change',function(e){
                var flag=$(this).prop('checked');
                var field_name = $(this).val();
                var changedBy = $("#changed_by").val();
                var flag_to_return = true;
                if(field_name == "all")
                    $("#changed_by").val(1);
                else if(changedBy == 1) {
                    flag_to_return = false;
                }

                if(flag_to_return) {
                    $.ajax({
                        type: 'post',
                        url:  '{{ url("/alerts/set_alert") }}',
                        data: {_token: '{{csrf_token()}}', field_name: field_name, flag: flag},
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.success) {
                                if (flag) {
                                    if (field_name == "all") {
                                        $('.dynamic_alert').bootstrapToggle('on');
                                    }
                                    toastr.success(field_name + 'enabled successfully');
                                }
                                else {
                                    if (field_name == "all") {
                                        $('.dynamic_alert').bootstrapToggle('off');
                                    }
                                    toastr.success(field_name + 'disabled successfully');
                                }
                                $("#changed_by").val('');
                            }
                        },
                        error:function(err){
                            console.log(err);
                        }
                    });
                }
                return true;
            });
        });
    </script>
    <script>
        var url = '{{url("assets/images")}}';
        var msg_flag ='{{ $msg_flag }}';
        var msg_type ='{{ $msg_type }}';
        var msg_val ='{{ $msg_val }}';
        var page='account';
        var browse_skill_box='';
        var selected_skill_id= new Array();
        var selected_job_skill = '{!! json_encode($users_skills) !!}';
        var hasOpenJobSkill = false;
        if(selected_job_skill && $.trim(selected_job_skill) !== ''){
            selected_job_skill = JSON.parse(selected_job_skill);
            selected_skill_id = selected_job_skill;
        }

        var browse_area_of_interest_box='';
        var actual_area_of_interest = [];
        var selected_area_of_interest_id= new Array();
        $(function(){
            $(document).off("click",".remove_profile_pic").on('click',".remove_profile_pic",function(e){
                e.preventDefault();
                $.ajax({
                    type:'post',
                    url:'{{ url("account/remove_profile_pic") }}',
                    data:{_token:'{{ csrf_token() }}'},
                    dataType:'json',
                    success:function(resp){
                        $(".profile-div").append('<form class="text-center" method="post" enctype="multipart/form-data">'+
                            '<input id="avatar-2" name="profile_pic" type="file" class="file-loading">'+
                            '</form>');
                        bindProfilePicUpload();
                    }
                })
            });

        })

    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#tabs').tab();
            $(".selectpicker").selectpicker('refresh');

            $("#country").on('change',function(){
                $("#state").empty().append('<option value="">Select</option>');
                $("#city").empty().append('<option value="">Select</option>');
                var value = $(this).val();
                var token = $('[name="_token"]').val();
                if($.trim(value) == "" && value != 247){
                    // Clear the State dropdown and set it to the default "Select" option
                    $("#state").empty().append('<option value="">Select</option>');
                    // Clear the City dropdown and set it to the default "Select" option
                    $("#city").empty().append('<option value="">Select</option>');
                }
                else if($.trim(value) == 247){
                    $("#state").prop('disabled',true);
                    return false;
                }
                else
                {
                    $(".states_loader.location_loader").show();
                    $("#state").prop('disabled',true);
                    $("#city").prop('disabled',true);
                    $.ajax({
                        type:'POST',
                        url: '{{ url("/units/get_state") }}',
                        dataType:'json',
                        async:true,
                        data:{country_id:value,_token:token },
                        success:function(resp){
                            $(".states_loader.location_loader").hide();
                            $("#state").prop('disabled',false);
                            $("#city").prop('disabled',true);
                            if(resp.success){
                                console.log(resp)
                                var html;
                                $.each(resp.states,function(index,val){
                                    html+='<option value="'+index+'">'+val+'</option>'
                                });

                                // Clear the State dropdown and set it to the default "Select" option
                                $("#state").empty().append('<option value="">Select</option>');
                                $("#city").empty();
                                $("#state").append(html);
                                $('.selectpicker').selectpicker('refresh');
                            }
                        }
                    });
                }
            });

            //get state after selecting country
            $("#state").on('change',function(){
                var value = $(this).val();
                var token = $('[name="_token"]').val();
                if($.trim(value) == ""){
                    $("#city").append('<option value="">Select</option>');
                    $("#city").prop('disabled',false);
                }
                else
                {
                    $(".cities_loader.location_loader").show();
                    $("#city").prop('disabled',true);
                    $.ajax({
                        type:'POST',
                        url: '{{ url("/units/get_city") }}',
                        dataType:'json',
                        async:true,
                        data:{state_id:value,_token:token },
                        success:function(resp){
                            $(".cities_loader.location_loader").hide();
                            $("#city").prop('disabled',false);
                            if(resp.success){
                                var html;
                                $.each(resp.cities,function(index,val){
                                    html+='<option value="'+index+'">'+val+'</option>'
                                });
                                $("#city").append(html);
                                $('.selectpicker').selectpicker('refresh');
                            }
                        }
                    })
                }
            });


            $(document).off('click',".withdraw-submit").on('click','.withdraw-submit',function(e){
                $(".remove-alert").remove();
                $that = $(this);
                var $form = $("#withdraw-amount");
                if($('#paypal_email').length > 0 && $("#payment_method").val() == "PAYPAL"){
                    var Emailflag = validateEmail();
                    if(!Emailflag){
                        e.preventDefault();
                        return false;
                    }
                }else if($("#payment_method").val() == "Zcash"){
                    //show error message when zcash address field is empty
                    var zcash_address = $("#zcash_address").val();
                    if($.trim(zcash_address) == ""){
                        if($.trim(zcash_address) == ""){
                            $("#zcash_address").closest('.col-sm-4').addClass('has-error');
                            var icon = $("#zcash_address").parent('.input-icon').children('i');
                            icon.removeClass('fa-check').addClass("fa-warning");
                            icon.attr("data-original-title", 'Please enter Zcash address').tooltip({'container': 'body'});

                            e.preventDefault();
                            return false;
                        }
                    }
                }
                $(this).prop('disabled', true);
                var modal_title = "Transfer amount to Paypal account";
                var text = "Transfer all your balance of $"+$(".donation_received").html()+" to your Paypal account?";
                if($("#payment_method").val() == "Zcash"){
                    modal_title = "Request to transfer amount to Zcash account";
                    text = "Transfer all your balance of "+$(".donation_received").html()+" to your Zcash account?";
                }

                bootbox.dialog({
                    message: text,
                    title: modal_title,
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-success",
                            callback: function() {
                                if($("#payment_method").val() == "Zcash"){
                                    $(".withdraw-submit").html('<span class="saving">Sending request<span>.</span><span>.</span><span>.</span></span>');
                                }else{
                                    $(".withdraw-submit").html('<span class="saving">Transferring amount<span>.</span><span>.</span><span>.</span></span>');
                                }
                                $.ajax({
                                    type:'post',
                                    data:$form.serialize(),
                                    url:$('#withdraw-amount').attr('action'),
                                    success:function(resp){
                                        if(!resp.success){
                                            var html = '';
                                            $.each(resp.errors,function(index,val){
                                                html+="<span>"+val+"</span>";
                                            })
                                            toastr.error(html, 'Error')
                                            $form.prepend(errorHTML);
                                            $that.prop('disabled', false);
                                            if($("#payment_method").val() == "Zcash"){
                                                $(".withdraw-submit").append('<span class="withdraw-text">Send transfer request</span>');
                                            }else{
                                                $(".withdraw-submit").append('<span class="withdraw-text">Transfer my full balance to my Paypal account</span>');
                                            }
                                        }
                                        else
                                        {
                                            toastr.success('Amount transferred successfully', 'Success');
                                            var buttonText = "Transfer my full balance to my Paypal account";
                                            if($("#payment_method").val() == "Zcash"){
                                               toastr.success('Request sent successfully', 'Success');
                                                buttonText = "Send transfer request";
                                            }
                                            $form.find("input,select").val('');
                                            $form.prepend(errorHTML);
                                            $that.prop('disabled', false);
                                            $(".amount-field").hide();
                                            $(".donation_received").append(resp.availableBalance);
                                            $(".withdraw-submit").append('<span class="withdraw-text">'+buttonText+'</span>');
                                        }
                                    }
                                });
                            }
                        },
                        danger: {
                            label: "Cancel",
                            className: "btn-danger",
                            callback:function(){
                                $that.prop('disabled', false);
                            }
                        }
                    },
                    onEscape: function() {
                        $that.prop('disabled', false);
                    }
                });
                return false;

            });

            $(document).off('click',".withdraw-amount-btn").on('click','.withdraw-amount-btn',function(){
                $(".remove-alert").remove();
                var $form = $("#withdraw-amount");
                var Emailflag = validateEmail();
                var amountFlag = validateAmount();
                if(!Emailflag)
                    return false;
                if(!amountFlag)
                    return false;

                $(this).prop('disabled', true);
                $(".withdraw-amount-btn").append('<span class="saving">Submitting<span>.</span><span>.</span><span>.</span></span>');
                $.ajax({
                    type:'post',
                    data:$form.serialize(),
                    url:'{{ url("/account/withdraw") }}',
                    success:function(resp){
                        if(!resp.success){
                            var html = '';
                            $.each(resp.errors,function(index,val){
                                html+="<span>"+val+"</span>";
                            })
                            toastr.error('Amount transferred successfully', 'Error')
                            $form.prepend(errorHTML);
                            $that.prop('disabled', false);
                            $(".withdraw-amount-btn").append('<span class="withdraw-text">Withdraw</span>');
                        }
                        else
                        {
                            $form.find("input,select").val('');
                            toastr.error('Amount transferred successfully', 'Error')
                            $form.prepend(errorHTML);
                            $that.prop('disabled', false);
                            $(".amount-field").hide();
                            $(".donation_received").append(resp.availableBalance);
                            $(".withdraw-amount-btn").addClass('withdraw-submit').removeClass('withdraw-amount-btnt').append('<span class="withdraw-text">Verify Email</span>');
                        }
                    }
                });
                return false;
            });
        });


        $(document).ready(function() {
            var $form = $("#personal-info");
            $form.on('submit', function (event) {
                event.preventDefault();
                var token = $('[name="_token"]').val();
                var profilePic = $(".kv-file-content").find('img').attr("src");
                var formData = $form.serializeArray();
                formData.push({name: '_token', value: token});
                formData.push({name: 'profilePic', value: profilePic});
                var dataString = $.param(formData);
                $form.find('.help-block').append('');
                $.ajax({
                    type: 'POST',
                    url: '{{ url("/account/update_personal_info") }}',
                    data: dataString,
                    success: function (resp) {
                        if (resp.success) {
                            toastr.success('Profile updated successfully', 'Success', {
                                progressBar: true,
                                timeOut: 3000,
                                extendedTimeOut: 2000,
                                closeButton: true,
                                tapToDismiss: false,
                                positionClass: 'toast-top-right',
                                // Customize the background color
                                onShown: function () {
                                    $('.toast-success').css('background-color', '#28a745');
                                }
                            });

                            // toastr.error('Profile updated successfully', 'Error', {
                            //     progressBar: true,
                            //     timeOut: 3000,
                            //     extendedTimeOut: 2000,
                            //     closeButton: true,
                            //     tapToDismiss: false,
                            //     positionClass: 'toast-top-right',
                            //     // Customize the background color
                            //     onShown: function () {
                            //         $('.toast-error').css('background-color', '#8f0b33');
                            //     }
                            // });

                        } else {
                            $.each(resp.errors, function (index, value) {
                                $form.find("#" + index).parent('.col-sm-4').find('.help-block').append(value);
                            });
                        }
                    }
                })
            });
        });
    </script>
@endsection
