@extends('layout.default')

@section('content')

<div class="container">
<div class="row form-group">
    @include('elements.user-menu',array('page'=>'home'))
</div>
<div class="row form-group" >
    <div class="col-sm-6">
        <div class="panel panel-default panel-dark-grey">
            <div class="panel-heading">
                <h4>My Bids</h4>
            </div>
            <div class="panel-body table-inner table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Bid Details</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($myBids) > 0 && !empty($myBids))
                            @foreach($myBids as $bid)
                                <tr>
                                    <td>
                                        <a href="{!! url('tasks/'.$taskIDHashID->encode($bid->task_id).'/'.$bid->slug)!!}">
                                            {{$bid->name}}
                                        </a>
                                    </td>
                                    <td><a class="show_bid_details" data-id="{{$bid->id}}">Show Details</a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">
                                    No record found.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default panel-dark-grey">
            <div class="panel-heading">
                <h4>My Assigned Task</h4>
            </div>
            <div class="panel-body table-inner table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($myAssignedTask) > 0)
                        @foreach($myAssignedTask as $assigned_task)
                            <tr>
                                <td>
                                    <a href="{!! url('tasks/'.$taskIDHashID->encode($assigned_task->task_id).'/'.$assigned_task->slug)!!}">
                                        {{$assigned_task->name}}
                                    </a>
                                </td>
                                <td>{{\App\SiteConfigs::task_status($assigned_task->status)}}</td>
                                <td>
                                    <a href="{!! url('tasks/complete_task/'.$taskIDHashID->encode($assigned_task->id)) !!}"
                                       class="btn btn-xs btn-success complete_task" >
                                        Complete Task
                                    </a>
                                </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">
                                No record found.
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
@section('page-scripts')
<script type="text/javascript">
    $(function(){
        $('.show_bid_details').on('click',function(){
            var id = $(this).attr('data-id');
            if($.trim(id) != ""){
                $.ajax({
                    type:'get',
                    url:siteURL+'/tasks/get_biding_details',
                    data:{id:id},
                    dataType:'json',
                    success:function(resp){
                        if(resp.success){
                            bootbox.dialog({
                                message: resp.html
                            });
                        }
                    }
                })
            }
            return false;
        });
    })
</script>
@endsection