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

                return moment(start_date[0]+'-'+start_date[1]+'-'+start_date[2]+' '+start_time).isBefore(end_date[0]+'-'+end_date[1]+'-'+end_date[2]+' '+end_time);
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

                // for each task action insert into task_actions table.
                /*var code = $("#action_items").code();
                var text = code.replace(/<p>/gi, " ");
                var data= text.split("</li>");

                for(var i=0;i<data.length;i++){
                    if(i==0)
                        $('.action_items_class').eq(i).val(data[i]);
                    else{
                        $(".all_action_items").append('<input type="hidden" name="action_items_array[]" id="action_items_array" class="action_items_class" value="'+data[i]+'"/>')
                    }
                }*/

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

    $(function(){
        if(editTask)
        {
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY/MM/DD HH:mm'
            });
            $('#datetimepicker2').datetimepicker({
                format: 'YYYY/MM/DD HH:mm'
            });

            $("#datetimepicker1").on("dp.change", function(e) {
                addEditedFieldName('datetimepicker1');
            });

            $("#datetimepicker2").on("dp.change", function(e) {
                addEditedFieldName('datetimepicker2');
            });
        }
        else{
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY/MM/DD HH:mm',
                minDate:moment()
            });
            $('#datetimepicker2').datetimepicker({
                format: 'YYYY/MM/DD HH:mm',
                minDate:moment()
            });
        }

        $("#action_items").summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline']],
                ['font', []],
                ['fontsize', []],
                ['color', []],
                ['para', []],
                ['height', []],
                ['fullscreen',['fullscreen']],
                ['codeview',['codeview']]
            ]
        });

        if(!actionListFlag)
            $('#action_items').summernote('insertUnorderedList');

        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
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






        $("#unit").select2({
            allowClear:true,
            placeholder:"Select Unit"
        });

        $("#objective").select2({
            allowClear: true,
            placeholder: "Select Objective"
        });

        if(from_unit) {
            $("#objective").select2('enable',false);
        }

        function formatSkills (repo) {
            if (repo.loading) return repo.text;

            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.name + "</div></div></div></div>";

            /*if (repo.description) {
                markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
            }

            markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
                "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
                "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
                "</div>" +
                "</div></div>";*/

            return markup;
        }

        function formatSkillsSelection (repo) {
            return repo.text;
        }


        $("#task_skills").select2({
            allowClear: true,
            width: '100%',
            displayValue:'skill_name',
            ajax: {
                url: siteURL+"/job_skills/get_skills",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {

                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            //more: (params.page * 1) < data.total_counts
                            more:false
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatSkills, // omitted for brevity, see the source of this page
            templateSelection: formatSkillsSelection // omitted for brevity, see the source of this page
        });

        $("#unit").on('change',function(){
            var unit_val = $(this).val();
            var token = $('[name="_token"]').val();
            if($.trim(unit_val) == "")
            {
                $("#objective").html('<option value="">Select</option>');
                return false;
            }
            else
            {
                $(".objective_loader.location_loader").show();
                $("#objective").prop('disabled',true);
                $.ajax({
                    type:'POST',
                    url:siteURL+'/tasks/get_objective',
                    dataType:'json',
                    data:{unit_id:unit_val,_token:token },
                    success:function(resp){
                        $(".objective_loader.location_loader").hide();
                        $("#objective").prop('disabled',false);
                        if(resp.success){
                            var html='<option value="">Select</option>';
                            $.each(resp.objectives,function(index,val){
                                html+='<option value="'+index+'">'+val+'</option>'
                            });
                            $("#objective").html(html).select2({allowClear:true,placeholder:"Select Objective"});
                        }
                    }
                })
            }
            return false
        });

        $("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});

        $(".editFileInput").fileinput({'showUpload':false, 'previewFileType':'any'});

    });

    $(document).off('click','.addMoreDocument').on('click',".addMoreDocument",function(){
        cloneTR();
        return false;
    });

    $(document).on("click","table.documents tbody .remove-row", function(){
        var index_tr = $(".documents").find("tbody").find("tr").index($(this));
        var id = $(this).attr('data-id');
        var task_id = $(this).attr('data-task_id');
        var fromEdit = $(this).attr('data-from_edit');
        $that = $(this);
        if($.trim(id) != "" && $.trim(task_id) != ""){
            addEditedFieldName("remove_doc");

            $.ajax({
                type:'get',
                url:siteURL+'/tasks/remove_task_document',
                data:{id:id,task_id:task_id,fromEdit:fromEdit },
                dataType:'json',
                success:function(resp){
                    if(resp.success){
                        toastr['success']('Document deleted successfully.', '');
                        if ($("table.documents tbody tr").length > 1)
                            $that.parents('tr:eq(0)').remove();

                        $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
                    }
                    else
                        toastr['error']('Something goes wrong. please try again later.', '');
                }
            })
        }
        else{

            if ($("table.documents tbody tr").length > 1)
                $(this).parents('tr:eq(0)').remove();

            var addedDocLength = $(".fileinput-new:not(:hidden)").length;
            if(addedDocLength == 0)
                $(".changed_items[value='"+field_name+"']").remove();

            $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
        }

        return false;
    });


    // when user click on submit for approval.
    $(".submit_for_approval").click(function(){
       var tid = $(this).attr('data-task_id');
        if($.trim(tid) != ""){
            $.ajax({
                type:'get',
                url:siteURL+'/tasks/submit_for_approval',
                data:{task_id:tid},
                dataType:'json',
                success:function(resp){
                    if(resp.success){
                        toastr['success']('Request submitted successfully.', '');
                        if($.trim(resp.status) != "" && resp.status == "awaiting_approval")
                            window.location.reload(true);
                    }
                    else
                        toastr['error']('Something goes wrong. please try again later.', '');
                }
            })
        }
        return false;
    });

    // if edit task then only bind keyup event to all field to get field name which are getting change
    if(editTask){
        $("select").on('change',function(){
            var field_name = $(this).attr('id');
            addEditedFieldName(field_name);
        });

        $("input[type='text']").on("input",function(){
            var field_name = $(this).attr('name');
            addEditedFieldName(field_name);
        });

        $(".summernote,#action_items").on("summernote.change", function (e) {   // callback as jquery custom event
            var field_name = $(this).attr('name');
            addEditedFieldName(field_name);
        });

        $("input[name='documents[]'").on('change',function(){
            addEditedFieldName('add_document');
        });
    }

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

function addEditedFieldName(field_name){
    var cnt = $(".changed_items").length;
    if($(".changed_items[value='"+field_name+"']").length)
        $(".changed_items[value='"+field_name+"']").val(field_name);
    else
        $('<input type="hidden" class="changed_items" name="changed_items[]" id="'+(cnt+1)+'" value="'+field_name+'"/>').appendTo("#form_sample_2");
}



