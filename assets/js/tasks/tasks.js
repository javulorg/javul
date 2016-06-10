var FormValidation = function () {

    // validation using icons
    var handleValidation = function() {

        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form2 = $('#form_sample_2');
        var error2 = $('.alert-danger', form2);
        var success2 = $('.alert-success', form2);

        jQuery.validator.addMethod("checkGreaterOrNot", function(value, element) {
            var start_datetime = $("#estimated_completion_time_start").val();
            var end_datetime = $("#estimated_completion_time_end").val();
            if($.trim(start_datetime) != "" &&  $.trim(end_datetime) != ""){
                var start = start_datetime.split(" ");
                var start_date = start[0].split("/");
                var start_time = start[1];

                var end = end_datetime.split(" ");
                var end_date = end[0].split("/");
                var end_time = end[1];

                return moment(start_date[2]+'-'+start_date[1]+'-'+start_date[0]+' '+start_time).isBefore(end_date[2]+'-'+end_date[1]+'-'+end_date[0]+' '+end_time);
            }
            else{
                jQuery.extend(jQuery.validator.messages, {
                    checkGreaterOrNot:'Please enter start datetime and end datetime.'
                });
                return false;
            }
        }, "end datetime must be greater than start datetime.");

        form2.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                unit: {
                    required: true
                },
                objective: {
                    required: true
                },
                task_name: {
                    required: true
                },
                task_skills: {
                    required: true
                },
                estimated_completion_time_start: {
                    required: true
                },
                estimated_completion_time_end: {
                    required: true,
                    checkGreaterOrNot : true
                },
                city: {
                    required: true
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success2.hide();
                error2.show();
                App.scrollTo(error2, -200);
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                var field_name = $(element).attr('name');
                if(field_name == "unit" || field_name == "objective" || field_name == "task_skills")
                    $(element).parents('.input-icon').find(".select2").find(".select2-selection").css("border-color","#a94442");

                if(field_name == "estimated_completion_time_end" || field_name == "estimated_completion_time_start")
                    var icon = $(element).parent('.input-group').children('i');
                else if(field_name == "unit" || field_name == "objective" || field_name == "task_skills"  )
                    var icon = $(element).parents('.input-icon').children('i');
                else
                    var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.col-sm-4').removeClass("has-success").addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight

            },

            success: function (label, element) {
                var field_name =$(element).attr('name');
                if(field_name == "estimated_completion_time_end" || field_name == "estimated_completion_time_start")
                    var icon = $(element).parent('.input-group').children('i');
                else if(field_name == "unit" || field_name == "objective" || field_name == "task_skills"  )
                    var icon = $(element).parents('.input-icon').children('i');
                else
                    var icon = $(element).parent('.input-icon').children('i');

                if(field_name == "unit" || field_name == "objective" || field_name == "task_skills")
                    $(element).parents('.input-icon').find(".select2").find(".select2-selection").css("border-color","#3c763d");

                $(element).closest('.col-sm-4').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },

            submitHandler: function (form) {
                success2.show();
                error2.hide();

                var code = $("#action_items").code();
                var text = code.replace(/<p>/gi, " ");
                var data= text.split("</li>");

                for(var i=0;i<data.length;i++){
                    if(i==0)
                        $('.action_items_class').eq(i).val(data[i]);
                    else{
                        $(".all_action_items").append('<input type="hidden" name="action_items_array[]" id="action_items_array" class="action_items_class" value="'+data[i]+'"/>')
                    }
                }

                form.submit();  // submit the form

            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleValidation();
        }
    };

}();

$(document).ready(function() {
    FormValidation.init();

    $(document).off('click','.addMoreDocument').on('click',".addMoreDocument",function(){
        cloneTR();
        return false;
    });

    $(document).on("click","table.documents tbody .remove-row", function(){
        var index_tr = $(".documents").find("tbody").find("tr").index($(this));
        var id = $(this).attr('data-id');
        if($.trim(id) != ""){
            /*$.ajax({
                type:'get',
                url:siteURL+'/properties/remove_property_unit',
                data:{id:id},
                dataType:'json',
                success:function(resp){

                }
            })*/
        }
        if ($("table.documents tbody tr").length > 1)
            $(this).parents('tr:eq(0)').remove();

        $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");

        return false;
    })

});
function cloneTR(){
    var last = $("table.documents tbody tr:last").clone();
    last.find(".remove-row").attr('data-id','').removeClass('hide');
    $("table.documents tbody tr:last").find(".addMoreDocument").addClass("hide");
    $("table.documents tbody tr:last").after("<tr>" + last.html() + "</tr>");
    $("table.documents tbody tr:last").find(".fileinput").find("a.input-group-addon").trigger('click');
    $("table.documents tbody tr:last").find('.fileinput').fileinput();
    // reset all values
    $("table.documents tbody tr:last :input:not(:checked)").val("").removeAttr('selected');
    return false;
}



