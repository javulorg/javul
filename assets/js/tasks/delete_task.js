$(function(){
   $(".delete-task").on('click',function(){
       var id = $(this).attr('data-id');
       var that = $(this);
       if($.trim(id) != ""){
           //disable click event until result not come
           $(this).addClass('prevent-click');
           var total_rows = $(this).parents('tbody').find('tr').length;
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
       return false;
   })
})