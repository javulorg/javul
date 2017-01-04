
$('.summernote').summernote({
    toolbar: [
        ['style', ['bold', 'italic', 'underline']],
        ['font', []],
        ['fontsize', []],
        ['color', []],
        ['para', ['ul', 'ol']],
        ['height', []],
        ['fullscreen',['fullscreen']],
        ['codeview',['codeview']]
    ],
    height:100
});

var xhr;

$(".objectiveComment #form_topic_form").submit(function(){
    if(xhr && xhr.readyState != 4){
        xhr.abort();
    }

    $("#form_topic_form").find(".alert").remove();

    xhr = $.ajax({
        type:'post',
        url:siteURL + '/forum/submitauto',
        data:$(this).serialize(),
        dataType:'json',
        beforeSend:function(){
            $("#form_topic_form button.btn").button("loading");
        },
        error:function(){
            
        },
        complete:function(){
            $("#form_topic_form button.btn").button("reset");
        },
        success:function(json){

            if(json['success']){
                $('.summernote').summernote('reset');
                loadComments();
                toastr['success'](json['success'], '');
            }

            if(json['error']){
                toastr['error'](json['error'], '');
            }
        }
    });

    return false;
})


function loadComments(){
    $.ajax({
        type:'post',
        url: siteURL + '/forum/loadObjectiveComment' ,
        data:$(".objectiveComment #form_topic_form").serialize(),
        dataType:'json',
        beforeSend:function(){
            $(".objectiveLoader").show();
        },
        error:function(){
            $(".objectiveLoader").hide();
        },
        complete:function(){
            $(".objectiveLoader").hide();
        },
        success:function(json){
            var html = '';
            var count = 0;
            $.each(json['comments']['items'],function(i,j){
                var b = j['ideapoint'] == 1 ? 'active' : '';
                count ++;

                html += '<li class="post-div">';
                html += '    <div class="heading"><a href="' + j['link'] +'">';
                html += '        ' + j['first_name'] +  " " +   j['last_name'] ;
                html += '        </a><span class="date">' + j['created_time'] +'</span>';
                html += '        <span class="point">' + j['updownpoint'] +' points</span>  ';
                html += '        <span class="idea-point"><i class="fa ideapoint ' + b +'  fa-lightbulb-o"></i>' + j['ideascore'] +'</span>';
                html += '    </div>';
                html += '    <div class="post-body">';
                html += '        ' + j['post'] +'';
                html += '    </div>';
                html += '</li>';
            })

            if(html == ''){
                html = '<h4 class="text-center">No forum threads found</h4><br>';
            }

            $(".objectiveComment .pagingnation-forum .item-count").html(count);

            $(".objectiveComment .posts").html(html);
        }
    })
}
loadComments();