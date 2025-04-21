<div class="content_block mt-3 mb-4">
    <div class="table_block table_block_issues">
        <div class="table_block_head">
            <div class="table_block_icon">
                <img src="{{ asset('v2/assets/img/bug.svg') }}" alt="" class="img-fluid">
            </div>
            Issues
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>
        {{-- <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col">Issue Name</th>
                    <th class="type_col">Status</th>
                    <th class="type_col">Created By</th>
                    <th class="type_col">Created Date</th>
                </tr>
                </thead>

                <tbody>

                @if(count($issues) > 0)
                    @foreach($issues as $obj)
                        <tr>
                            <td class="title_col">
                                <a href="{!! url('issues/'.$issueIDHashID->encode($obj->id).'/view') !!}"
                                   title="edit">
                                    {{$obj->title}}
                                </a>
                            </td>
                            <td class="type_col">
                                <?php $status_class=''; $verified_by =''; $resolved_by ='';
                                if($obj->status=="unverified")
                                    $status_class="text-danger";
                                elseif($obj->status=="verified"){
                                    $status_class="text-info";
                                    $verified_by = " (by ".App\Models\User::getUserName($obj->verified_by).')';
                                }
                                elseif($obj->status == "resolved"){
                                    $status_class = "text-success";
                                    $resolved_by = " (by ".App\Models\User::getUserName($obj->resolved_by).')';
                                }
                                ?>
                                <span class="{{$status_class}}">{{ucfirst($obj->status).$verified_by. $resolved_by}}</span>
                            </td>
                            <td class="type_col">
                                <a href="{!! url('userprofiles/'.$userIDHashID->encode($obj->user_id).'/'.strtolower(str_replace(" ","_",App\Models\User::getUserName($obj->user_id)))) !!}">
                                    {{App\Models\User::getUserName($obj->user_id)}}
                                </a>
                            </td>
                            <td class="type_col">{{$obj->created_at}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No record(s) found.</td>
                    </tr>
                @endif
                </tbody>

            </table>

        </div> --}}

        <div class="table_block_body">
            <table>
                <thead>
                    <tr>
                        <th class="title_col">Issue Name</th>
                        <th class="type_col">Status</th>
                        <th class="type_col">Created By</th>
                        <th class="type_col">Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($issues) > 0)
                        @foreach($issues as $obj)
                            @php
                                $status_class = '';
                                $status_note = '';

                                if($obj->status == "unverified") {
                                    $status_class = "text-danger";
                                } elseif($obj->status == "verified") {
                                    $status_class = "text-info";
                                    $status_note = ' (by ' . \App\Models\User::getUserName($obj->verified_by) . ')';
                                } elseif($obj->status == "resolved") {
                                    $status_class = "text-success";
                                    $status_note = ' (by ' . \App\Models\User::getUserName($obj->resolved_by) . ')';
                                }
                            @endphp
                            <tr>
                                <td class="title_col">
                                    <a href="{!! url('issues/' . $issueIDHashID->encode($obj->id) . '/view') !!}" title="edit">
                                        {{ $obj->title }}
                                    </a>
                                </td>
                                <td class="type_col">
                                    <span class="{{ $status_class }}">{{ ucfirst($obj->status) . $status_note }}</span>
                                </td>
                                <td class="type_col">
                                    <a href="{!! url('userprofiles/' . $userIDHashID->encode($obj->user_id) . '/' . strtolower(str_replace(' ', '_', \App\Models\User::getUserName($obj->user_id)))) !!}">
                                        {{ \App\Models\User::getUserName($obj->user_id) }}
                                    </a>
                                </td>
                                <td class="type_col">
                                    {{ $obj->created_at }}
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

            {{-- ✅ Mobile Responsive View --}}
            <div class="mob_table d-sm-none d-block">
                @if(count($issues) > 0)
                    @foreach($issues as $obj)
                        @php
                            $status_class = '';
                            $status_note = '';

                            if($obj->status == "unverified") {
                                $status_class = "text-danger";
                            } elseif($obj->status == "verified") {
                                $status_class = "text-info";
                                $status_note = ' (by ' . \App\Models\User::getUserName($obj->verified_by) . ')';
                            } elseif($obj->status == "resolved") {
                                $status_class = "text-success";
                                $status_note = ' (by ' . \App\Models\User::getUserName($obj->resolved_by) . ')';
                            }
                        @endphp
                        <div class="mob_table_section">
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Issue Name</div>
                                <div class="mob_table_val">
                                    <a href="{!! url('issues/' . $issueIDHashID->encode($obj->id) . '/view') !!}">
                                        {{ $obj->title }}
                                    </a>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Status</div>
                                <div class="mob_table_val">
                                    <span class="{{ $status_class }}">{{ ucfirst($obj->status) . $status_note }}</span>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Created By</div>
                                <div class="mob_table_val">
                                    <a href="{!! url('userprofiles/' . $userIDHashID->encode($obj->user_id) . '/' . strtolower(str_replace(' ', '_', \App\Models\User::getUserName($obj->user_id)))) !!}">
                                        {{ \App\Models\User::getUserName($obj->user_id) }}
                                    </a>
                                </div>
                            </div>
                            <div class="mob_table_row">
                                <div class="mob_table_ttl">Created Date</div>
                                <div class="mob_table_val">
                                    {{ $obj->created_at }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mob_table_section">
                        <div class="mob_table_row">
                            <div class="mob_table_val text-center w-100">No record(s) found.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
    <div class="d-flex justify-content-between mt-2">
        <div class="pagination-left">
        </div>
        <div class="pagination-right">
            <a href="{!! url('issues/'.$unitIDHashID->encode($unit_activity_id).'/add') !!}"><img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New</a>
        </div>
    </div>
</div>










