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
    }
})

function check_assigned_task(){
    $.ajax({
        type:'get',
        url:siteURL+'/tasks/check_assigned_task',
        dataType:'json',
        success:function(resp){
            if(resp.success){
                bootbox.dialog({
                    message: resp.html,
                    title: "Bid Selected by Unit Admin",
                    buttons: {
                        success: {
                            label: "Accept",
                            className: "btn-success",
                            callback: function() {
                                accept_reject_offer(resp.task_id,'/tasks/accept_offer');
                            }
                        },
                        danger: {
                            label: "Reject",
                            className: "btn-danger",
                            callback: function() {
                                accept_reject_offer(resp.task_id,'/tasks/reject_offer');
                            }
                        }
                    }
                });
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
            setTimeout(function(){
                check_assigned_task();
            },15000)
        }
    });
}