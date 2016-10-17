<div class="all_levels @if($from == "task") task_listing_skills @endif">
    @if(count($firstBox_skills) > 0)
        <div class="hierarchy_parent">
            <select name="skill" id="skill_firstbox" class="first_level hierarchy" size="5" data-number="1">
                @foreach($firstBox_skills as $skill_id=>$skill)
                    <option value="{{$skill_id}}" data-type="{{$skill['type']}}">{{$skill['name']}}&nbsp;></option>
                @endforeach
            </select>
            @if($from == "site_admin")
                <div style="margin-left:10px;margin-top:5px;">
                    <a class="btn black-btn btn-xs add_skill" data-pos="first" id="add_skill_btn" style="padding:5px 10px 5px;
                                            text-decoration:none;">
                        <i class="fa fa-plus plus"></i> <span class="plus_text" style="left:-5px;">ADD</span>
                    </a>
                </div>
            @endif
        </div>
    @endif
</div>
@if($from != "site_admin")
    <div class="row">
        <div class="col-xs-12">
            <div class="text-center"><h5>You have selected:<span class="selected_text_task">None</span></h5></div>
        </div>
    </div>
@endif