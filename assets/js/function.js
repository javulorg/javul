$(function(){
    // allowed only digits
    $(".onlyDigits").keypress(function (e) {
        //if the letter is not digit then don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    //show loaded on ajax calls.
    $loading = $('#loadingDiv').hide();
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

    //add item to watchlist
    $(".add_to_my_watchlist").on('click',function(){
        var type=$(this).data('type');
        var id = $(this).data('id');

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        if($.trim(type) != "" && $.trim(id) != ''){
            $.ajax({
                type:'get',
                url:siteURL+'/add_to_watchlist',
                data:{type:type,id:id},
                dataType:'json',
                success:function(resp){
                    if(!resp.success)
                        toastr['error'](resp.msg, '');
                    else
                        toastr['success'](resp.msg, '');
                }
            })
        }
    })
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

function getUnitActivity(page,unit_id){

    $(".loading_content_hide").css('opacity','0.5');
    $.ajax({
        type:'get',
        url:siteURL+'/get_unit_site_activity_paginate',
        data:{page:page,unit_id:unit_id},
        success:function(resp){
            $(".site_activity_list").html(resp.html);
            $(".loading_dots").hide();
            $(".loading_content_hide").css('opacity','1');
        }
    });
}