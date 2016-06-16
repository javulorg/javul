$(function(){
    $(".delete-unit").on('click',function(){
        var id = $(this).attr('data-id');
        var that = $(this);
        if($.trim(id) != ""){
            //disable click event until result not come
            var total_rows = $(this).parents('tbody').find('tr').length;
            $(this).addClass('prevent-click');
            $.ajax({
                type:'get',
                url:siteURL+'/units/delete_unit',
                data:{id:id},
                dataType:'json',
                success:function(resp){
                    if(resp.success){
                        if(total_rows == 1)
                            that.parents('tr').html('<td colspan="4">No record(s) found.</td>');
                        else
                            that.parents('tr').remove();
                        toastr['success']('Unit deleted successfully!!!', '') ;
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