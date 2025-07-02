@extends('layout.master')
@section('title', 'New Message')

@section('content')
<div class="inbox-app">
    <div class="card card-custom">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 bg-light border-end p-3">
                @include('message.menu', [])
            </div>

            <!-- Content Area -->
            <div class="col-md-9 p-4">
                <h5 class="mb-3">Compose New Message</h5>
                <form method="post"  action="{{ route('message.send-message') }}" enctype="multipart/form-data">

                    @csrf

                    @if($user_id > 0)
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                    @else
                        <div class="mb-3">
                            <label class="form-label">To</label>
                            <select id="user_id_fromSel2" name="user_id" class="form-control" required>
                                <option value="">Select User</option>
                                @foreach ($user as $value)
                                    <option value="{{ $value->id }}">
                                        {{ $value->first_name }} {{ $value->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control summernote" rows="6" name="message" id="message" placeholder="Write your message here..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
        ClassicEditor
            .create( document.querySelector('#message') )
            .catch( error => {
                console.error(error);
            } );

        var xhr;
        $("#form_topic_form").submit(function(){
            if(xhr && xhr.readyState != 4){
                xhr.abort();
            }
            $("#form_topic_form").find(".alert").remove();
            xhr = $.ajax({
                type:'post',
                url:'{!! url('message/send') !!}/{!! $user_id !!}',
                data:$(this).serialize(),
                dataType:'json',
                beforeSend:function(){
                    $("#form_topic_form button").button("loading");
                },
                error:function(){

                },
                complete:function(){
                    $("#form_topic_form button").button("reset");
                },
                success:function(json){
                    if(json['errors']){
                        $.each(json['errors'],function(i,j){
                            $("[name='"+ i +"']").after("<div class='alert alert-danger'> "+ j +" </div>");
                        })
                    }
                    if(json['success']){
                        toastr['success'](json['success'], '');
                        $("#form_topic_form textarea").val('');
                        $("#form_topic_form input").val('');
                        // setTimeout(function(){ location = json['location'] },1000);
                    }
                    if(json['error']){
                        toastr['error'](json['error'], '');
                    }
                }
            });
            return false;
        })
    </script>
@endsection
