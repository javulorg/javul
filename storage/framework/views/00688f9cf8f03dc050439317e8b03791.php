<div class="list-group tab-pane <?php if(count($errors) == 0 || ($errors->has('active') && $errors->first('active')
                    =='personal_info')): ?> active <?php endif; ?>" id="personal_info">
    <form novalidate autocomplete="off" id="personal-info">
        <input type="hidden" name="opt_typ" value="used"/>
        <div class="list-group tab-pane" id="personal_info">
            <div class="row mt-2 mb-3">
                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">First Name</label>
                    <input id="first_name" name="first_name" placeholder="First Name" class="form-control input-md" type="text"
                           <?php if(!empty(old('first_name'))): ?> value="<?php echo e(old('first_name')); ?>" <?php else: ?> value="<?php echo e(auth()->user()->first_name); ?>"
                        <?php endif; ?>>
                    <span class="help-block"></span>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Last Name</label>
                    <input id="last_name" name="last_name" placeholder="Last Name" class="form-control input-md" type="text"
                           <?php if(!empty(old('last_name'))): ?> value="<?php echo e(old('last_name')); ?>" <?php else: ?> value="<?php echo e(auth()->user()->last_name); ?>" <?php endif; ?>>
                    <span class="help-block"></span>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Email</label>
                    <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text"
                           <?php if(!empty(old('email'))): ?> value="<?php echo e(old('email')); ?>" <?php else: ?> value="<?php echo e(auth()->user()->email); ?>" <?php endif; ?>>
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="row mt-2 mb-3">
                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Phone</label>
                    <input id="phone" name="phone" placeholder="Phone" class="form-control input-md" type="text"
                           <?php if(!empty(old('phone'))): ?> value="<?php echo e(old('phone')); ?>" <?php else: ?> value="<?php echo e(auth()->user()->phone); ?>" <?php endif; ?>>
                    <span class="help-block"></span>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Mobile</label>
                    <input id="mobile" name="mobile" placeholder="Mobile" class="form-control input-md" type="text"
                           <?php if(!empty(old('mobile'))): ?> value="<?php echo e(old('mobile')); ?>" <?php else: ?> value="<?php echo e(auth()->user()->mobile); ?>" <?php endif; ?>>
                    <span class="help-block"></span>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label">Country</label>
                    <select class="form-control selectpicker" data-live-search="true" name="country" id="country">
                        <option value=""><?php echo trans('messages.select'); ?></option>
                        <?php if(count($countries) > 0): ?>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($val == "dash_line" || $val == "dash_line1"): ?>
                                    <option value="<?php echo e($id); ?>" disabled></option>
                                <?php else: ?>
                                    <option value="<?php echo e($id); ?>" <?php if(auth()->user()->country_id == $id): ?>
                                    selected=selected <?php endif; ?>><?php echo e($val); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="row mt-2 mb-3">
                <div class="col-sm-4 form-group">
                    <label class="control-label">State</label>
                    <div class="input-icon right">
                        <select class="form-control selectpicker" data-live-search="true" name="state" id="state" <?php if(auth()->user()->country_id == "global"): ?>
                        disabled <?php endif; ?>>
                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php if(auth()->user()->state_id == $id): ?>
                                selected=selected <?php endif; ?>><?php echo e($val); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="help-block"></span>
                        <span class="states_loader location_loader" style="display: none">
                                                <img src="<?php echo url('assets/images/small_loader.gif'); ?>"/>
                                        </span>
                    </div>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label">City</label>
                    <div class="input-icon right">
                        <select class="form-control selectpicker" data-live-search="true" name="city" id="city" <?php if(auth()->user()->country_id == "global"): ?>
                        disabled <?php endif; ?>>
                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cid=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cid); ?>" <?php if(auth()->user()->city_id == $cid): ?>
                                selected=selected <?php endif; ?>><?php echo e($val); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="help-block"></span>
                        <span class="cities_loader location_loader" style="display: none">
                                                <img src="<?php echo url('assets/images/small_loader.gif'); ?>"/>
                                            </span>
                    </div>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label">Timezone</label>
                    <div class="input-icon right">
                        <select class="form-control selectpicker" data-live-search="true" name="timezone" id="timezone">
                            <?php $__currentLoopData = \App\Models\SiteConfigs::get_timezones_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone_index=>$timezone_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($timezone_index); ?>" <?php if(auth()->user()->timezone == $timezone_index): ?>
                                selected=selected <?php endif; ?>><?php echo e($timezone_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="help-block"></span>
                        <span class="cities_loader location_loader" style="display: none">
                                                <img src="<?php echo url('assets/images/small_loader.gif'); ?>"/>
                                            </span>
                    </div>
                </div>
            </div>

            <div class="row mt-2 mb-3">
                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Address</label>
                    <textarea name="address" id="address" class="form-control input-md"><?php echo e(auth()->user()->address); ?></textarea>
                    <span class="help-block"></span>
                </div>
                <div class="col-sm-4 form-group">
                    <label class="control-label">Job Skills</label>
                    <div class="input-icon right">
                        <div class="input-group">
                            <select class="form-control selectpicker" data-live-search="true" name="job_skills[]" id="task_skills" multiple>
                                <?php $__currentLoopData = $job_skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill_id=>$skill_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($skill_id); ?>" <?php if(!empty($users_skills) && in_array($skill_id,$users_skills)): ?>
                                    selected=selected <?php endif; ?>><?php echo e($skill_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label">Area of Interest</label>
                    <div class="input-icon right">
                        <div class="input-group">
                            <select class="form-control selectpicker" data-live-search="true" name="area_of_interest[]" id="area_of_interest" multiple>
                                <?php $__currentLoopData = $area_of_interest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area_id=>$area_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($area_id); ?>" <?php if(!empty($users_area_of_interest) && in_array($area_id,$users_area_of_interest)): ?>
                                    selected=selected <?php endif; ?>><?php echo e($area_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>

            </div>

            <div class="row mt-2 mb-3">
                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">PayPal Email ID</label>
                    <input id="paypal_email" name="paypal_email" placeholder="PayPal Email ID" class="form-control input-md" type="text"
                           <?php if(!empty(old('paypal_email'))): ?> value="<?php echo e(old('paypal_email')); ?>" <?php else: ?> value="<?php echo e(auth()->user()->paypal_email); ?>"
                        <?php endif; ?>>
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="row justify-content-center mt-3">
                <div class="col-md-6 col-lg-4">
                    <button class="btn btn-secondary btn-block" type="submit">
                        <i class="fa fa-edit"></i> <span class="plus_text">Update Profile</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/user-account-partials/personal-info.blade.php ENDPATH**/ ?>