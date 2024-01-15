<?php $__env->startSection('title', 'Create Unit'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <?php echo $__env->make('layout.v2.global-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="panel panel-grey panel-default">
            <div class="panel-heading">
                <h4>Create Unit</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post" id="form_sample_2" action="<?php echo e(url('units')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Unit Information Section -->
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <label class="control-label mb-1"><?php echo e(__('messages.unit_name')); ?></label>
                                <div class="input-icon right">
                                    <input type="text" name="unit_name" value="<?php echo e((!empty($unitObj))? $unitObj->name : old('unit_name')); ?>" class="form-control" placeholder="<?php echo e(__('messages.unit_name')); ?>"/>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label mb-1"><?php echo e(__('messages.unit_category')); ?> <span class="text-danger">*</span></label>
                                    <select class="form-select"  name="unit_category[]" id="unit_category" multiple>
                                        <?php $__currentLoopData = $unit_category_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($val); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label mb-1">Unit Type <span class="text-danger">*</span></label>
                                    <select class="form-select"  name="unit_type" id="unit_type">
                                        <option selected disabled>Select Type</option>
                                        <option value="0">Product</option>
                                        <option value="1">Service</option>
                                        <option value="2">People’s Government</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group mt-3">
                                <label class="control-label">Country<span class="text-danger">*</span></label>
                                <select class="form-control"  id="country" name="country">
                                    <option value=""><?php echo trans('messages.select'); ?></option>
                                    <?php if(count($countries) > 0): ?>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



                                                <option value="<?php echo e($id); ?>" <?php if(!empty($unitObj) && $unitObj->country_id == $id): ?> selected=selected <?php endif; ?>><?php echo e($val); ?></option>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>


                            <div class="col-sm-4 mt-3 form-group">
                                <label class="control-label">State<span class="text-danger">*</span></label>
                                <select class="form-control" name="state" id="state" <?php if(!empty($unitObj) && $unitObj->country_id == "global"): ?> disabled <?php endif; ?>>
                                    <?php if(!empty($unitObj)): ?>
                                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php if(!empty($unitObj) && $unitObj->state_id == $id): ?> selected=selected <?php endif; ?>><?php echo e($val); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <option value=""><?php echo trans('messages.select'); ?></option>
                                    <?php endif; ?>
                                </select>
                                <span class="states_loader location_loader" style="display: none"><img src="<?php echo url('assets/images/small_loader.gif'); ?>"/></span>
                            </div>

                            <div class="col-sm-4 mt-3 form-group">
                                <label class="control-label">City<span class="text-danger">*</span></label>
                                <select class="form-control" name="city" id="city" <?php if(!empty($unitObj) && $unitObj->country_id == "global"): ?> disabled <?php endif; ?>>
                                    <?php if(!empty($unitObj)): ?>
                                        <?php if(!empty($state_name_as_city_for_field)): ?>
                                            <option value="<?php echo e($state_name_as_city_for_field->id); ?>" selected><?php echo e($state_name_as_city_for_field->name); ?></option>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cid=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($cid); ?>" <?php if(!empty($unitObj) && $unitObj->city_id == $cid): ?> selected=selected <?php endif; ?>><?php echo e($val); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <option value=""><?php echo e(__('messages.select')); ?></option>
                                    <?php endif; ?>
                                </select>
                                <input type="hidden" name="empty_city_state_name" id="empty_city_state_name"
                                       <?php if(!empty($state_name_as_city_for_field)): ?> value="<?php echo e($unitObj->state_id_for_city_not_exits); ?>" <?php endif; ?>/>
                                <span class="cities_loader location_loader" style="display: none"><img src="<?php echo url('assets/images/small_loader.gif'); ?>"/>
                                 </span>
                            </div>

                            <!-- Unit Credibility Section -->
                            <div class="col-sm-4 mt-3 form-group">
                                <label class="control-label"><?php echo e(__('messages.unit_credibility')); ?><span class="text-danger">*</span></label>
                                <select class="form-control"  name="credibility">
                                    <option value=""><?php echo trans('messages.select'); ?></option>
                                    <?php if(count($unit_credibility_arr) > 0): ?>
                                        <?php $__currentLoopData = $unit_credibility_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php if(!empty($unitObj) && $unitObj->credibility == $id): ?> selected=selected <?php endif; ?>><?php echo e($val); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Parent Unit and Status Section -->
                            <div class="col-sm-4 mt-3 form-group">
                                <label class="control-label">Parent Unit</label>
                                <select class="form-control" name="parent_unit" id="parent_unit">
                                    <option value="">Select</option>
                                    <?php if(count($parentUnitsObj) > 0 ): ?>
                                        <?php $__currentLoopData = $parentUnitsObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php if(!empty($unitObj) && $id == $unitObj->parent_id): ?> selected=selected <?php endif; ?>><?php echo e($parent); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <!-- Related Units and Status Section -->
                            <div class="col-sm-4 mt-3 form-group">
                                    <label class="control-label">Related To</label>
                                    <select class="form-control" name="related_to[]" id="related_to">
                                        <?php if(count($relatedUnitsObj) > 0 ): ?>
                                            <?php $__currentLoopData = $relatedUnitsObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$relate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($id); ?>" <?php if(!empty($unitObj) && !empty($relatedUnitsofUnitObj) && in_array($id,$relatedUnitsofUnitObj)): ?> selected=selected <?php endif; ?>><?php echo e($relate); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                            </div>

                            <?php if(!empty($unitObj) && $authUserObj->role == "superadmin"): ?>
                                <div class="col-sm-4 form-group">
                                    <label class="control-label" style="width: 100%;">Status</label>
                                    <input data-toggle="toggle" data-on="Active" data-off="Disabled" type="checkbox" name="status" <?php if(!empty($unitObj) && $unitObj->status == "active"): ?> checked <?php elseif(empty($unitObj)): ?> checked <?php endif; ?>>
                                </div>
                            <?php endif; ?>

                        </div>

                        <!-- Description and Comments Section -->
                        <div class="col-sm-12 mt-3 form-group">
                            <label class="control-label">Unit Description</label>
                            <textarea class="form-control" id="description" name="description">
                                 <?php if(!empty($unitObj)): ?> <?php echo e($unitObj->description); ?> <?php endif; ?>
                            </textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit" id="create_unit">
                                    <i class="fa fa-plus"></i> <span class="plus_text"><?php echo e(__('messages.create_unit')); ?></span>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#unit_category").select2({
                theme: "bootstrap-5",
                containerCssClass: "select2--small",
                dropdownCssClass: "select2--small",
            });

            ClassicEditor
                .create( document.querySelector( '#description' ) )
                .catch( error => {
                    console.error( error );
                } );

            $("#country").on('change',function(){
                $("#state").val('');
                $("#empty_city_state_name").val('');
                $("#city").val('');
                var value = $(this).val();
                var token = $('[name="_token"]').val();
                if($.trim(value) == "" && value != 247){
                    $("#state").html('<option value="">Select</option>');
                    $("#city").html('<option value="">Select</option>');
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
                        url:  '<?php echo e(url("units/get_state")); ?>',
                        dataType:'json',
                        async:true,
                        data:{country_id:value,_token:token },
                        success:function(resp){
                            $(".states_loader.location_loader").hide();
                            $("#state").prop('disabled',false);
                            $("#city").prop('disabled',false);
                            if(resp.success){
                                var html='<option value=""></option>';
                                $.each(resp.states,function(index,val){
                                    html+='<option value="'+index+'">'+val+'</option>'
                                });
                                $("#state").append(html);
                            }
                        }
                    })
                }
            });
            $("#state").on('change',function(){
                var value = $(this).val();
                var token = $('[name="_token"]').val();
                if($.trim(value) == ""){
                    $("#city").html('<option value="">Select</option>');
                    $("#city").prop('disabled',false);
                }
                else
                {
                    $(".cities_loader.location_loader").show();
                    $("#city").prop('disabled',true);
                    $.ajax({
                        type:'POST',
                        url: '<?php echo e(url("units/get_city")); ?>',
                        dataType:'json',
                        async:true,
                        data:{state_id:value,_token:token },
                        success:function(resp){

                            $(".cities_loader.location_loader").hide();
                            $("#city").prop('disabled',false);
                            if(resp.success){

                                if(Object.keys(resp.cities).length > 0)
                                {
                                    $.each(resp.cities,function(index,val){
                                        html ='<option value="'+index+'">'+val+'</option>'
                                    });
                                    $("#city").append(html);
                                    $("#empty_city_state_name").val('');
                                }else{
                                    var html ='<option value="'+value+'">'+resp.state_name+'</option>';

                                    $("#city").append(html);
                                    $("#empty_city_state_name").val(JSON.stringify([{"id":value,"name":resp.state_name}]));
                                }
                            }
                        }
                    })
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/units/create.blade.php ENDPATH**/ ?>