@extends('layout.master')
@section('title', 'New Message')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>New Message</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            @include('message.menu', array())
                        </div>
                        <div class="col-md-10">
                            <form role="form" method="post" id="form_topic_form" enctype="multipart/form-data">
                                @csrf
                                <br>
                                @if($user_id > 0)
                                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                                @else
                                    <div class="col-sm-12 form-group">
                                        <label for="user_id_fromSel2">To</label>
                                        <select id="user_id_fromSel2" name="user_id" class="form-control">
                                            @foreach ($user as $key => $value)
                                                <option value="{{ $value->id }}">
                                                    {{ $value->first_name }} {{ $value->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-sm-12 form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control summernote" rows="5" name="message" id="message"></textarea>
                                </div>
                                <div class="col-sm-12 mt-3 form-group">
                                    <button class="btn btn-dark float-end">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
