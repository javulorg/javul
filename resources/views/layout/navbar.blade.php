
<style>
    div a:hover {
        text-decoration: none !important;
        color: #374957!important;
    }

</style>
@if(isset($unitData))
    <nav class="d-xl-block d-none">
        <div class="container">

            <div class="nav">
                <div class="nav-item">
                    <a class="nav-link{{ request()->is('units/' . $unitIDHashID->encode($unitData->id).'/'.$unitData->slug) ? ' active' : '' }}" href="{{ url('units/'. $unitIDHashID->encode($unitData->id).'/'.$unitData->slug) }}">Home</a>
                </div>
                <div class="separator"></div>

                <div class="nav-item">
                    <a class="nav-link{{ request()->is('issues') ? ' active' : '' }}" href="{{ url('issues?unit=' . $unitData->id) }}">Issues</a>
                </div>

                <div class="nav-item">
                    <a class="nav-link{{ request()->is('ideas') ? ' active' : '' }}" href="{{ url('ideas?unit=' . $unitData->id) }}">Ideas</a>
                </div>

                <div class="nav-item">
                    <a class="nav-link{{ request()->is('objectives') ? ' active' : '' }}" href="{{ url('objectives?unit=' . $unitData->id) }}">Objectives</a>
                </div>

                <div class="nav-item">
                    <a class="nav-link{{ request()->is('tasks') ? ' active' : '' }}" href="{{ url('tasks?unit=' . $unitData->id) }}">Tasks</a>
                </div>


                    <div class="separator"></div>
                    <div class="nav-item">
                        <a class="nav-link{{ request()->is('forum/'. $unitIDHashID->encode($unitData->id)) ? ' active' : '' }}" href="{!! url('forum') !!}/{!! $unitIDHashID->encode($unitData->id) !!}">Forum</a>
                    </div>

                <div class="nav-item">
                    <a class="nav-link{{ request()->is('chat/' . $unitIDHashID->encode($unitData->id)) ? ' active' : '' }}" href="{{ url('chat/create_room?unit_id=' . $unitIDHashID->encode($unitData->id)) }}">Chat</a>
                </div>

                    <div class="separator"></div>
                    <div class="nav-item">
                        <a class="nav-link{{ request()->is('wiki/home/' . $unitIDHashID->encode($unitData->id).'/'.$unitData->slug) ? ' active' : '' }}" href="{!! url('wiki/home') !!}/{!! $unitIDHashID->encode($unitData->id).'/'.$unitData->slug !!}">Wiki</a>
                    </div>

                <div class="separator"></div>
                <div class="nav-item">
                    <a class="nav-link" href="{{ url('activities?unit=' . $unitData->id) }}">Activity Log</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Top Contributors</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Awards</a>
                </div>
                <div class="separator"></div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Finances</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" href="#">Donate</a>
                </div>
            </div>
        </div>
    </nav>
@endif

