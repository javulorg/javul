@extends('layout.default')
@section('content')
    <div class="container">
        <div class="row">
            @include('elements.user-menu',['page'=>'units'])
        </div>
        <div class="row form-group">
            <div class="col-sm-8">
                <div class="panel panel-default panel-dark-grey">
                    <div class="panel-heading">
                        <h4>{!! trans('messages.units') !!}</h4>
                    </div>
                    <div class="panel-body table-inner table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{!! trans('messages.unit_name') !!}</th>
                                    <th>{!! trans('messages.unit_category') !!}</th>
                                    <th>{!! trans('messages.description') !!}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($units) > 0 )
                                    @foreach($units as $unit)
                                        <?php $category_ids = $unit->category_id;
                                        $category_names = $unit->category_name;
                                        $category_ids = explode(",",$category_ids);
                                        $category_names  = explode(",",$category_names );
                                        ?>
                                        <tr>
                                            <td><a href="{!! url('units/'.$unitIDHashID->encode($unit->id)) !!}">{{$unit->name}}</a></td>
                                            <td>
                                                @if(count($category_ids) > 0 )
                                                    @foreach($category_ids as $index=>$category)
                                                        <a href="{!! url('units/category/'.$unitCategoryIDHashID->encode($category)) !!}">{{$category_names[$index]}}</a>
                                                        @if(count($category_ids) > 1 && $index != count($category_ids) -1)
                                                        ,
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td><div class="text_wraps"><span class="ellipsis_text">{{$unit->description}}</span></div></td>
                                            <td width="11%">
                                                @if(\Auth::check())
                                                    <a class="btn btn-xs btn-primary"
                                                       href="{!! url('units/'.$unitIDHashID->encode($unit->id).'/edit') !!}" title="edit">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                    </a>
                                                @endif

                                                @if(!empty($authUserObj) && ($authUserObj->role == "superadmin" || $unit->user_id ==
                                                $authUserObj->id))
                                                <a title="delete" href="#" class="btn btn-xs btn-danger delete-unit"
                                                   data-id="{{$unitIDHashID->encode($unit->id)}}">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No record(s) found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{!! url('units/add')!!}"class="btn orange-bg" id="add_unit_btn" type="button">
                    <span class="glyphicon glyphicon-plus"></span> {!! trans('messages.add_unit') !!}
                </a>
            </div>
            <div class="col-sm-4">
                @include('elements.site_activities')
            </div>
        </div>
    </div>
@include('elements.footer')
@stop
@section('page-scripts')
<script src="{!! url('assets/plugins/jquery.ThreeDots.min.js') !!}" type="text/javascript"></script>
<script type="text/javascript">
    var msg_flag ='{{ $msg_flag }}';
    var msg_type ='{{ $msg_type }}';
    var msg_val ='{{ $msg_val }}';
    $(function(){
        var the_obj = $('.text_wraps').ThreeDots({
            max_rows: 1
        });
    })
</script>
<script src="{!! url('assets/js/units/delete_unit.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/js/custom_tostr.js') !!}" type="text/javascript"></script>
@endsection