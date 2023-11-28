
<style>
    div a:hover {
        text-decoration: none !important;
        color: #374957!important;
    }

</style>
<?php if(isset($unitData)): ?>
    <nav class="d-xl-block d-none">
        <div class="container">

            <div class="nav">
                <div class="nav-item">
                    <a class="nav-link<?php echo e(request()->is('units/' . $unitIDHashID->encode($unitData->id).'/'.$unitData->slug) ? ' active' : ''); ?>" href="<?php echo e(url('units/'. $unitIDHashID->encode($unitData->id).'/'.$unitData->slug)); ?>">Home</a>
                </div>
                <div class="separator"></div>

                <div class="nav-item">
                    <a class="nav-link<?php echo e(request()->is('issues') ? ' active' : ''); ?>" href="<?php echo e(url('issues?unit=' . $unitData->id)); ?>">Issues</a>
                </div>

                <div class="nav-item">
                    <a class="nav-link<?php echo e(request()->is('ideas') ? ' active' : ''); ?>" href="<?php echo e(url('ideas?unit=' . $unitData->id)); ?>">Ideas</a>
                </div>

                <div class="nav-item">
                    <a class="nav-link<?php echo e(request()->is('objectives') ? ' active' : ''); ?>" href="<?php echo e(url('objectives?unit=' . $unitData->id)); ?>">Objectives</a>
                </div>

                <div class="nav-item">
                    <a class="nav-link<?php echo e(request()->is('tasks') ? ' active' : ''); ?>" href="<?php echo e(url('tasks?unit=' . $unitData->id)); ?>">Tasks</a>
                </div>


                    <div class="separator"></div>
                    <div class="nav-item">
                        <a class="nav-link<?php echo e(request()->is('forum/'. $unitIDHashID->encode($unitData->id)) ? ' active' : ''); ?>" href="<?php echo url('forum'); ?>/<?php echo $unitIDHashID->encode($unitData->id); ?>">Forum</a>
                    </div>

                <div class="nav-item">
                    <a class="nav-link<?php echo e(request()->is('chat/' . $unitIDHashID->encode($unitData->id)) ? ' active' : ''); ?>" href="<?php echo e(url('chat/create_room?unit_id=' . $unitIDHashID->encode($unitData->id))); ?>">Chat</a>
                </div>

                    <div class="separator"></div>
                    <div class="nav-item">
                        <a class="nav-link<?php echo e(request()->is('wiki/home/' . $unitIDHashID->encode($unitData->id).'/'.$unitData->slug) ? ' active' : ''); ?>" href="<?php echo url('wiki/home'); ?>/<?php echo $unitIDHashID->encode($unitData->id).'/'.$unitData->slug; ?>">Wiki</a>
                    </div>

                <div class="separator"></div>
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('activities?unit=' . $unitData->id)); ?>">Activity Log</a>
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
<?php endif; ?>

<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/navbar.blade.php ENDPATH**/ ?>