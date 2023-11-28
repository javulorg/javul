<div class="card" style="margin-top: 29px;">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">User Wiki</h4>
            <div class="user-wikihome-tool small-a">
                <div class="user-wikihome-tool small-a">
                    <a href="{{ route('user_wiki_newpage',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])  }}"> + New Page </a> |
                    <a href="{{ route('user_wiki_recent_changes',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])  }}"> Recent Changes </a> |
                    <a href="{{ route('user_wiki_page_list',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash ])  }}"> List All Pages </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive loading_content_hide">
        <div class="wiki-home" style="padding: 5px;">
            <div class="d-flex justify-content-between align-items-center small-a">
                <a href="{{ route('user_wiki_editpage',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash, $page_id_hase ])  }}">Edit</a>
                <a href="{{ route('user_wiki_history',[ str_replace(' ', '_', strtolower($userObj->first_name." ".$userObj->last_name) ),$user_id_hash, $page_id_hase ])  }}">View History</a>
            </div>
            <div class="clearfix"></div>
            <?= $userWiki[0]->page_content ?>
        </div>
    </div>
</div>
