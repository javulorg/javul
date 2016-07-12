$(function(){
    // allowed only digits
    $(".onlyDigits").keypress(function (e) {
        //if the letter is not digit then don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
    if(login){
        check_assigned_task();
        $(document).off('click','.offer').on('click','.offer',function(){
            var tid=$(this).attr('data-task_id');
            if($(this).hasClass('btn-success'))
                accept_reject_offer(tid,'/tasks/accept_offer');
            else if($(this).hasClass('re_assigned'))
                accept_reject_offer(tid,'/tasks/accept_offer');
            else if($(this).hasClass('btn-danger'))
                accept_reject_offer(tid,'/tasks/reject_offer');
        })
    }
})

function check_assigned_task(){
    $.ajax({
        type:'get',
        url:siteURL+'/tasks/check_assigned_task',
        dataType:'json',
        success:function(resp){
            if(resp.success){
                if($(".confirmation_box_"+resp.task_id).length == 0){
                    $(".user-menu").parent('.col-sm-12').after('<div class="col-sm-12">'+resp.html+'</div>');
                }
                /*bootbox.dialog({
                    message: resp.html,
                    title: resp.title,
                    buttons: {
                        success: {
                            label: resp.ok,
                            className: "btn-success",
                            callback: function() {
                                accept_reject_offer(resp.task_id,'/tasks/accept_offer');
                            }
                        },
                        danger: {
                            label: resp.cancel,
                            className: "btn-danger",
                            callback: function() {
                                accept_reject_offer(resp.task_id,'/tasks/reject_offer');
                            }
                        }
                    }
                });*/
            }else
            {
                setTimeout(function(){
                    check_assigned_task();
                },15000)
            }
        }
    })
}

function accept_reject_offer(task_id,url){
    $.ajax({
        type:'get',
        url:siteURL+url,
        data:{task_id:task_id},
        dataType:'json',
        success:function(resp){
            $(".close").trigger('click');
            setTimeout(function(){
                check_assigned_task();
            },15000)
        }
    });
}