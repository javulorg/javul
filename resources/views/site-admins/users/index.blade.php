<div class="content_block">
    <div class="table_block table_block_units">
        <div class="table_block_head">
            <div class="table_block_icon">
                <i class="fa fa-users"></i>
            </div>
            @if(isset($users) && $users->count() > 0)
                User Rights ({{ $users->count() }})
            @else
                User Rights ({{ 0 }})
            @endif
            <div class="arrow">

            </div>
        </div>
        <div class="table_block_body">
            <table>
                <thead>
                <tr>
                    <th class="title_col">Full Name</th>
                    <th class="last_reply_col">E-mail</th>
                    <th class="last_reply_col">Role</th>
                    <th class="views_col">Status</th>
                </tr>
                </thead>
                <tbody>
                @if($users->count() > 0)
                    @foreach($users as $user)
                        <tr>
                            <td class="title_col">
                                {{ $user->first_name . '  ' . $user->last_name }}
                            </td>
                            <td class="last_reply_col">
                              {{ $user->email }}
                            </td>
                            <td class="last_reply_col">
                              {{ $user->role }}
                            </td>
                            <td class="views_col">
                                @if($user->status == 1)
                                    Active
                                @else
                                    Inactive
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
    <div class="content_block_bottom">
        <a href="{{ url('site-admin/users/create') }}">
            <img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt="">
            Add New
        </a>
        <div class="separator"></div>
        <a href="#" class="see_more">See more</a>
    </div>
</div>
