<div class="list-group tab-pane @if(count($errors) == 0 || ($errors->has('active') && $errors->first('active')
                    =='personal_info')) active @endif" id="personal_info">
    <form novalidate autocomplete="off" id="personal-info">
        <input type="hidden" name="opt_typ" value="used"/>
        <div class="list-group tab-pane" id="personal_info">
            <div class="row mt-2 mb-3">
                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">First Name</label>
                    <input id="first_name" name="first_name" placeholder="First Name" class="form-control input-md" type="text"
                           @if(!empty(old('first_name'))) value="{{old('first_name')}}" @else value="{{ auth()->user()->first_name }}"
                        @endif>
                    <span class="help-block"></span>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Last Name</label>
                    <input id="last_name" name="last_name" placeholder="Last Name" class="form-control input-md" type="text"
                           @if(!empty(old('last_name'))) value="{{old('last_name')}}" @else value="{{ auth()->user()->last_name}}" @endif>
                    <span class="help-block"></span>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Email</label>
                    <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text"
                           @if(!empty(old('email'))) value="{{old('email')}}" @else value="{{ auth()->user()->email}}" @endif>
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="row mt-2 mb-3">
                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Phone</label>
                    <input id="phone" name="phone" placeholder="Phone" class="form-control input-md" type="text"
                           @if(!empty(old('phone'))) value="{{old('phone')}}" @else value="{{auth()->user()->phone}}" @endif>
                    <span class="help-block"></span>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Mobile</label>
                    <input id="mobile" name="mobile" placeholder="Mobile" class="form-control input-md" type="text"
                           @if(!empty(old('mobile'))) value="{{old('mobile')}}" @else value="{{auth()->user()->mobile}}" @endif>
                    <span class="help-block"></span>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label">Country</label>
                    <select class="form-control selectpicker" data-live-search="true" name="country" id="country">
                        <option value="">{!! trans('messages.select') !!}</option>
                        @if(count($countries) > 0)
                            @foreach($countries as $id=>$val)
                                @if($val == "dash_line" || $val == "dash_line1")
                                    <option value="{{$id}}" disabled></option>
                                @else
                                    <option value="{{$id}}" @if(auth()->user()->country_id == $id)
                                    selected=selected @endif>{{$val}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="row mt-2 mb-3">
                <div class="col-sm-4 form-group">
                    <label class="control-label">State</label>
                    <div class="input-icon right">
                        <select class="form-control selectpicker" data-live-search="true" name="state" id="state" @if(auth()->user()->country_id == "global")
                        disabled @endif>
                            @foreach($states as $id=>$val)
                                <option value="{{$id}}" @if(auth()->user()->state_id == $id)
                                selected=selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                        <span class="states_loader location_loader" style="display: none">
                                                <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                                        </span>
                    </div>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label">City</label>
                    <div class="input-icon right">
                        <select class="form-control selectpicker" data-live-search="true" name="city" id="city" @if(auth()->user()->country_id == "global")
                        disabled @endif>
                            @foreach($cities as $cid=>$val)
                                <option value="{{$cid}}" @if(auth()->user()->city_id == $cid)
                                selected=selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                        <span class="cities_loader location_loader" style="display: none">
                                                <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                                            </span>
                    </div>
                </div>

                <div class="col-sm-4 form-group">
                    <label class="control-label">Timezone</label>
                    <div class="input-icon right">
                        <select class="form-control selectpicker" data-live-search="true" name="timezone" id="timezone">
                            @foreach(\App\Models\SiteConfigs::get_timezones_list() as $timezone_index=>$timezone_name)
                                <option value="{{$timezone_index}}" @if(auth()->user()->timezone == $timezone_index)
                                selected=selected @endif>{{$timezone_name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                        <span class="cities_loader location_loader" style="display: none">
                                                <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                                            </span>
                    </div>
                </div>
            </div>

            <div class="row mt-2 mb-3">
                <div class="col-sm-4 form-group">
                    <label class="control-label" for="textinput">Address</label>
                    <textarea name="address" id="address" class="form-control input-md">{{ auth()->user()->address }}</textarea>
                    <span class="help-block"></span>
                </div>
                <div class="col-sm-4 form-group">
                    <label class="control-label">Job Skills</label>
                    <div class="input-icon right">
                        <div class="input-group">
                            <select class="form-control selectpicker" data-live-search="true" name="job_skills[]" id="task_skills" multiple>
                                @foreach($job_skills as $skill_id=>$skill_name)
                                    <option value="{{$skill_id}}" @if(!empty($users_skills) && in_array($skill_id,$users_skills))
                                    selected=selected @endif>{{$skill_name}}</option>
                                @endforeach
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
                                @foreach($area_of_interest as $area_id=>$area_name)
                                    <option value="{{$area_id}}" @if(!empty($users_area_of_interest) && in_array($area_id,$users_area_of_interest))
                                    selected=selected @endif>{{$area_name}}</option>
                                @endforeach
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
                           @if(!empty(old('paypal_email'))) value="{{old('paypal_email')}}" @else value="{{auth()->user()->paypal_email}}"
                        @endif>
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
