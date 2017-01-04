$(function(){
   $(".delete-task").on('click',function(){
       var id = $(this).attr('data-id');
       var that = $(this);
       if($.trim(id) != ""){
           //disable click event until result not come
           $(this).addClass('prevent-click');
           var total_rows = $(this).parents('tbody').find('tr').length;
           var task_name = $(this).parents('tr').find('td:first-child').find('a').html();
           bootbox.dialog({
               title: "Are you sure?",
               message: "<p>You want delete <b>Task: </b>"+task_name+'?<p>',
               buttons: {
                   danger: {
                       label: "Cancel",
                       className: "btn-danger",
                       callback: function() {
                           that.removeClass('prevent-click');
                           bootbox.hideAll();
                       }
                   },
                   success: {
                       label: "Delete",
                       className: "btn-success",
                       callback: function() {
                           $.ajax({
                               type:'get',
                               url:siteURL+'/tasks/delete_task',
                               data:{id:id},
                               dataType:'json',
                               success:function(resp){
                                   if(resp.success){
                                       if(total_rows == 1)
                                           that.parents('tr').html('<td colspan="7">No record(s) found.</td>');
                                       else
                                           that.parents('tr').remove();
                                       toastr['success']('Task deleted successfully!!!', '') ;
                                   }
                                   else{
                                       toastr['error']('Something goes wrong. please try again.', '') ;
                                       //enable click event if result is false.
                                       that.removeClass('prevent-click');
                                   }
                               }
                           })
                       }
                   }
               }
           });

       }
       return false;
   });

    $(document).off('click','.search_tasks').on('click','.search_tasks',function(){
        var task_skill_search = $("#task_skill_search").val();
        var task_status_search = $("#task_status_search").val();
        if($.trim(task_skill_search) == "" && $.trim(task_status_search) == ""){
            $("#task_skill_search").parent('td').addClass('has-error');
            $("#task_status_search").parent('td').addClass('has-error');
        }else{
            $("#task_skill_search").parent('td').removeClass('has-error');
            $("#task_status_search").parent('td').removeClass('has-error');
            $(".reset_unit_search").show();
            var token = $(this).attr('data-token');

            $(".task_loading").show();
            $(this).parents(".loading_content_hide").css('opacity','0.5');

            $.ajax({
                type:'post',
                url:siteURL+'/tasks/search_tasks',
                data:{task_skill_search:task_skill_search,task_status_search:task_status_search,_token:token},
                dataType:'json',
                success:function(resp){
                    $(".tasks-table tbody").html(resp.html);
                    $(".task_loading").hide();
                    $(".loading_content_hide").css('opacity','1');
                    if($(".text_wraps").length > 0) {
                        var the_obj = $('.text_wraps').ThreeDots({
                            max_rows: 1
                        });
                    }
                }
            })
        }

        return false;
    });
});