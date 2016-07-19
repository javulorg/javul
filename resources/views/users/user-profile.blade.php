<div class="grey-bg" style="padding-top:20px;margin-bottom: 20px; ">
        <div class="row">
            <div class="col-sm-3 text-center form-group">
                <img src="{!! url('assets/images/user.png')!!}" class="img-rounded-circle"/>
                <div style="display: block">
                    <ul title="Ratings" class="list-inline ratings text-center">
                        <li>
                            <a href="#"><span class="fa fa-star fa-sm"></span></a>
                        </li>
                        <li>
                            <a href="#"><span class="fa fa-star fa-sm"></span></a>
                        </li>
                        <li>
                            <a href="#"><span class="fa fa-star fa-sm"></span></a>
                        </li>
                        <li>
                            <a href="#"><span class="fa fa-star fa-sm"></span></a>
                        </li>
                        <li>
                            <a href="#"><span class="fa fa-star fa-sm"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-9 hidden-xs">
                <div class="user-header">
                    <h3>{{$userObj->first_name.' '.$userObj->last_name}}</h3>
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-time"></span>
                    Account age: {{$userObj->created_at}}</label>
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    Skills:
                    @if(!empty($skills))
                        @foreach($skills as $skill)
                            <span class="label label-info tags">{{$skill->skill_name}}</span>
                        @endforeach
                    @endif
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Area of Interest:
                    @if(!empty($interestObj))
                        @foreach($interestObj as $interest)
                            <span class="label label-info tags">{{$interest->title}}</span>
                        @endforeach
                    @endif
                </div>
                <span class="glyphicon glyphicon-map-marker"></span>
                {{\App\Country::getName($userObj->country_id)}}
                <span class="glyphicon glyphicon-menu-right"></span>
                {{\App\State::getName($userObj->state_id)}}
                <span class="glyphicon glyphicon-menu-right"></span>
                {{\App\City::getName($userObj->city_id)}}
            </div>
            <div class="col-xs-12 visible-xs text-center">
                <div class="user-header">
                    <h3>{{$userObj->first_name.' '.$userObj->last_name}}</h3>
                </div>
            </div>
            <div class="col-xs-12 visible-xs">
                <div class="user-header">
                    <span class="glyphicon glyphicon-time"></span>
                    Account age: {{$userObj->created_at}}</label>
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    Skills:
                    @if(!empty($skills))
                    @foreach($skills as $skill)
                    <span class="label label-info tags">{{$skill->skill_name}}</span>
                    @endforeach
                    @endif
                </div>
                <div class="user-header">
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Area of Interest:
                    @if(!empty($interestObj))
                    @foreach($interestObj as $interest)
                    <span class="label label-info tags">{{$interest->title}}</span>
                    @endforeach
                    @endif
                </div>
                <span class="glyphicon glyphicon-map-marker"></span>
                {{\App\Country::getName($userObj->country_id)}}
                <span class="glyphicon glyphicon-menu-right"></span>
                {{\App\State::getName($userObj->state_id)}}
                <span class="glyphicon glyphicon-menu-right"></span>
                {{\App\City::getName($userObj->city_id)}}
            </div>
        </div>

    </div>