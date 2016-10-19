var FormValidation = function () {

    // validation using icons
    var handleValidation = function() {

        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form2 = $('#form_sample_2');
        var error2 = $('.alert-danger', form2);
        var success2 = $('.alert-success', form2);

        form2.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                unit_name: {
                    required: true
                },
                "unit_category[]": {
                    required: true
                },
                credibility: {
                    required: true
                },
                country: {
                    required: true
                },
                state: {
                    required: function(){
                        var c_id = $("#country").val();
                        if(c_id  == "global")
                            return false;
                        else
                            return true;
                    }
                },
                city: {
                    required: function(){
                        var c_id = $("#country").val();
                        if(c_id  == "global")
                            return false;
                        else
                            return true;
                    }
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success2.hide();
                error2.show();
                App.scrollTo(error2, -200);
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                var field_name = $(element).attr('name');
                if(field_name == "unit_category[]" || field_name == "country" || field_name == "state" || field_name == "city")
                    $(element).parents('.input-icon').find(".select2").find(".select2-selection").css("border-color","#a94442");

                if(field_name == "unit_category[]"){
                    var icon = $(element).parents('.input-icon').children('i');
                }
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
                var field_name = $(element).attr('name');
                if(field_name == "unit_category[]")
                    var icon = $(element).parents('.input-icon').children('i');
                else
                    var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.col-sm-4').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");

                if(field_name == "unit_category[]" || field_name == "country" || field_name == "state" || field_name == "city")
                    $(element).parents('.input-icon').find(".select2").find(".select2-selection").css("border-color","#3c763d");

            },

            submitHandler: function (form) {
                success2.show();
                error2.hide();
                form.submit(); // submit the form

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

    //get state after selecting country
    $("#country").on('change',function(){
        var value = $(this).val();
        var token = $('[name="_token"]').val();
        if($.trim(value) == "" && value != 247){
            $("#state").html('<option value="">Select</option>').select2({allowClear:true,placeholder:"Select State"});
            $("#city").html('<option value="">Select</option>').select2({allowClear:true,placeholder:"Select City"});
            $("#state").prop('disabled',false);
            $("#city").prop('disabled',false);
        }
        else if($.trim(value) == 247){
            $("#state").prop('disabled',true);
            $("#city").prop('disabled',true);
            return false;
        }
        else
        {

            $(".states_loader.location_loader").show();
            $("#state").prop('disabled',true);
            $("#city").prop('disabled',true);
            $.ajax({
                type:'POST',
                url:siteURL+'/units/get_state',
                dataType:'json',
                async:true,
                data:{country_id:value,_token:token },
                success:function(resp){
                    $(".states_loader.location_loader").hide();
                    $("#state").prop('disabled',false);
                    $("#city").prop('disabled',false);
                    if(resp.success){
                        var html='<option value="">Select</option>';
                        $.each(resp.states,function(index,val){
                            html+='<option value="'+index+'">'+val+'</option>'
                        });
                        $("#state").html(html).select2({allowClear:true,placeholder:"Select State"});
                    }
                }
            })
        }
    });
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

    //get state after selecting country
    $("#state").on('change',function(){
        var value = $(this).val();
        var token = $('[name="_token"]').val();
        if($.trim(value) == ""){
            $("#city").html('<option value="">Select</option>').select2({allowClear:true,placeholder:"Select City"});
            $("#city").prop('disabled',false);
        }
        else
        {
            $(".cities_loader.location_loader").show();
            $("#city").prop('disabled',true);
            $.ajax({
                type:'POST',
                url:siteURL+'/units/get_city',
                dataType:'json',
                async:true,
                data:{state_id:value,_token:token },
                success:function(resp){
                    $(".cities_loader.location_loader").hide();
                    $("#city").prop('disabled',false);
                    if(resp.success){
                        var html='<option value="">Select</option>';
                        $.each(resp.cities,function(index,val){
                            html+='<option value="'+index+'">'+val+'</option>'
                        });
                        $("#city").html(html).select2({allowClear:true,placeholder:"Select City"});
                    }
                }
            })
        }
    });

    $("#country").select2({
        theme: "bootstrap",
        placeholder:"Select Country",
        templateResult:format,
        escapeMarkup: function(m) {
            return m;
        }
    });

    $("#state").select2({
        theme: "bootstrap",
        placeholder:"Select State"
    });

    $("#city").select2({
        theme: "bootstrap",
        placeholder:"Select City"
    });

    function formatSkills (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.name + "</div></div></div></div>";
        return markup;
    }

    function formatSkillsSelection (repo) {
        console.log(repo.text);
        return repo.text;
    }
    var categoriesSelect2 = $("#unit_category").select2({
        allowClear: true,
        width: '100%',
        displayValue:'skill_name',
        ajax: {
            url: siteURL+"/unit_category/get_categories",
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

    categoriesSelect2.on("select2:unselect",function(e){
        var id = e.params.data.id;
        var index = selected_categories_id.indexOf(id);
        if (index > -1) {
            selected_categories_id.splice(index, 1);
        }
        return false;
    });

    $("#related_to").select2({
        theme: "bootstrap",
        allowClear: true,
        placeholder: "Select an option"
    });

    $(".browse-categories").on('click',function(){
        $.ajax({
            type:'get',
            url:siteURL+'/unit_category/browse_categories',
            dataType:'json',
            success:function(resp){
                if(resp.success){
                    browse_category_box = bootbox.dialog({
                        message: resp.html,
                        title: "Browse Category",
                        buttons: {
                            success: {
                                label: "Set Category",
                                className: "btn-success okay-btn",
                                callback: function(e) {
                                    if($.trim(selected_categories_id) != ""){
                                        $("#unit_category").select2('val',selected_categories_id);
                                    }
                                    else {
                                        toastr['error']('Please select category', '');
                                        return false;
                                    }
                                }
                            }
                        }
                    });
                    browse_category_box.on("shown.bs.modal", function (e) {
                        browse_category_box.find('.okay-btn').prop('disabled',true);
                    });
                    browse_category_box.on("hidden.bs.modal", function (e) {
                        browse_category_box='';
                    });

                    browse_category_box.modal('show');
                }
            }
        });
        return false;
    });

    function format(country) {
        if (country.id == "dash_line1" || country.id == "dash_line"){
            // return ' <span><img src="'+horiz_line+'" style="width:100%"></span> ';
            return '<hr style="margin:0px;">';
        }
        else
            return country.text;
    }
});



