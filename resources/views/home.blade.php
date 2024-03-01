@extends('layout.default')
@section('content')
    <div class="container">
        <div class="row form-group" style="margin-bottom:15px">
            @include('elements.user-menu',array('page'=>'home'))
        </div>
        <div class="row">
            <div class="col-md-8 col-md-push-4">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading">
                                <h4>MOST ACTIVE UNITS</h4>
                            </div>
                            <div class="panel-body list-group">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Name</th>
                                        <th>Categories</th>
                                        <th>Location</th>
                                    </thead>
                                    <tbody>
                                    @if(count($recentUnits) > 0)
                                        @foreach($recentUnits as $unit)
                                            <?php $categories = \App\Models\Unit::getCategoryNames($unit->category_id); ?>
                                            <tr>
                                                <td width="70%">
{{--                                                    <a href="{!! url('units/'.$unitIDHashID->encode($unit->id).'/'.$unit->slug) !!}"--}}
{{--                                                       class="colorLightBlue" >--}}
{{--                                                        {{$unit->name}}--}}
{{--                                                    </a>--}}
                                                </td>
                                                <td width="15%">
                                                    <a href="#">{{$categories}}</a>
                                                </td>
                                                <td>
                                                    @if(empty($unit->city_id) && $unit->country_id == 247)
                                                    GLOBAL
                                                    @else
                                                    {{\App\Models\City::getName($unit->city_id)}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">No unit found.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(count($recentUnits) > 5)
                            <!--<a class="btn orange-bg" href="{!! url('') !!}">{!! Lang::get('messages.all_units') !!}</a>-->
                        @endif
                        <!--<a class="btn orange-bg" href="{!! url('units/create') !!}">{!! Lang::get('messages.create_units') !!}</a>-->
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading">
                                <h4>RECENTLY CREATED UNITS</h4>
                            </div>
                            <div class="panel-body list-group">
                                <table class="table table-striped">
                                    <thead>
                                    <th>Name</th>
                                    <th>Categories</th>
                                    <th>Location</th>
                                    </thead>
                                    <tbody>
                                    @if(count($recentUnits) > 0)
                                    @foreach($recentUnits as $unit)
                                    <?php $categories = \App\Models\Unit::getCategoryNames($unit->category_id); ?>
                                    <tr>
                                        <td width="70%">
{{--                                            <a href="{!! url('units/'.$unitIDHashID->encode($unit->id).'/'.$unit->slug) !!}"--}}
{{--                                               class="colorLightBlue" >--}}
{{--                                                {{$unit->name}}--}}
{{--                                            </a>--}}
                                        </td>
                                        <td width="15%">
                                            <a href="#">{{$categories}}</a>
                                        </td>
                                        <td>
                                            @if(empty($unit->city_id) && $unit->country_id == 247)
                                                GLOBAL
                                            @else
                                                {{\App\Models\City::getName($unit->city_id)}}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3">No unit found.</td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(count($recentUnits) > 5)
                        <!--<a class="btn orange-bg" href="{!! url('') !!}">{!! Lang::get('messages.all_units') !!}</a>-->
                        @endif
                        <!--<a class="btn orange-bg" href="{!! url('units/create') !!}">{!! Lang::get('messages.create_units') !!}</a>-->
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-pull-8">
                <div class="site_activity_list">
                    <div class="site_activity_loading loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    @include('elements.site_activities',['ajax'=>false])
                </div>
            </div>

        </div>
    </div>
    @include('elements.footer')
@endsection
@section('page-scripts')
<script type="text/javascript">
    window.onresize = function(event) {
        var $iW = $(window).innerWidth();
        if ($iW < 992){
            $('.right').insertBefore('.left');
        }else{
            $('.right').insertAfter('.left');
        }
    }
    $(function(){
        var $iW = $(window).innerWidth();
        if ($iW < 992){
            $('.right').insertBefore('.left');
        }else{
            $('.right').insertAfter('.left');
        }
    })
</script>
@endsection
