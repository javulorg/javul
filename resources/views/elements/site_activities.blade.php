<div class="panel panel-grey panel-default">
    <div class="panel-heading loading_content_hide">
        <h4>{{$site_activity_text}}</h4>
    </div>
    <div class="panel-body list-group loading_content_hide">
        @if(count($site_activity) > 0)
            @foreach($site_activity as $activity)
                <div class="list-group-item" style="padding: 0px;">
                    <div class="row" style="padding: 7px 15px">
                        <div class="col-xs-3">
                            {!! \App\Library\Helpers::timetostr($activity->created_at) !!}
                        </div>
                        <div class="col-xs-2 text-center round_ line">
                            <div class="circle activity-refresh" style="width: 30px;">
                                <i class="fa fa-refresh"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            {!! $activity->comment !!}
                        </div>
                    </div>
                </div>
            @endforeach
            @if($site_activity->lastPage() > 1 && $site_activity->lastPage() != $site_activity->currentPage())
                <div class="list-group-item text-right">
                    <a href="#"class="btn black-btn @if($site_activity_text == 'Site Activity') more_site_activity_btn
                    @else more_unit_site_activity_btn @endif"
                       data-url="{{$site_activity->url($site_activity->currentPage()+1) }}" @if($site_activity_text == 'Unit Site Activity')
                    data-unit_id="{{$unitIDHashID->encode($unit_activity_id)}}" @endif
                    type="button">MORE ACTIVITY
                    </a>
                </div>
            @endif
        @else
            <div class="list-group-item">
                No activity found.
            </div>
        @endif
    </div>

</div>