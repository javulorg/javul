<div class="row">
    <div class="col-sm-6 form-group">
        <div class="panel panel-default panel-grey">
            <div class="panel-heading">
                <h4>Withdrawal Request</h4>
            </div>
            <div class="panel-body table-inner table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($withdrawal_list) > 0)
                        @foreach($withdrawal_list as $withdraw)
                            <tr>
                                <td>{{ date('d-m-Y',strtotime($withdraw->created_at)) }}</td>
                                <td>{{$withdraw->amount}}</td>
                                <td style="text-transform:capitalize">{{$withdraw->status}}</td>
                                <td>
                                    @if($withdraw->withdrawal_status == "withdrawal")
                                        <a class="btn btn-xs btn-danger zcash-cancel" data-id="{{$withdraw->id}}" href="">Cancel</a>
                                    @elseif($withdraw->withdrawal_status == "rejected")
                                        <a class="btn btn-xs btn-danger" href="javascript:void(0);">Rejected by Admin</a>
                                    @elseif($withdraw->withdrawal_status == "approved")
                                        <a class="btn btn-xs btn-success" herf="javascript:void(0);">Approved</a>
                                    @elseif($withdraw->withdrawal_status == "cancel")
                                        <a class="btn btn-xs btn-danger" herf="javascript:void(0);">Cancelled by You</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">
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
