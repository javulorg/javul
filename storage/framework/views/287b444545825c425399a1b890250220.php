<?php $__env->startSection('title', 'Unit: ' . $unitObj->name); ?>
<?php $__env->startSection('style'); ?>
    <style>
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />

    </style>

<script>
    let lastUrl = location.href;

    new MutationObserver(() => {
        const currentUrl = location.href;
        if (currentUrl !== lastUrl) {
            lastUrl = currentUrl;
            location.reload(); // ✅ Refresh when URL changes
        }
    }).observe(document, {subtree: true, childList: true});
</script>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-name'); ?>
    <h1><?php echo e($unitObj->name); ?></h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('navbar'); ?>
    <?php echo $__env->make('layout.navbar', ['unitData' => $unitObj], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">

            <?php echo $__env->make('layout.v2.global-unit-overview',['unitData' => $unitObj], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php
            $title = 'Activity Log';
            ?>
            <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitObj->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.global-finances', ['availableFunds' => $availableFunds, 'awardedFunds' => $awardedFunds, 'unitData' => $unitObj], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.global-about-site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="main_content">
            <div class="content_block">

                <?php echo $__env->make('units.view-unit-partials.objectives', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('units.view-unit-partials.tasks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('units.view-unit-partials.issues', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('units.view-unit-partials.ideas', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        window.onload = function()
        {
            function chatOnline()
            {
                $.ajax({
                    type:'post',
                    url: '<?php echo e(url("/chat/online")); ?>',
                    data:{_token:'<?php echo e(csrf_token()); ?>',unit_id:<?php echo $unitObj->id; ?>},
                    dataType:'json',
                    complete: function(xhr, textStatus) {
                        setTimeout(function(){ chatOnline() }, 5000);
                    },
                    success:function(resp,text,xhr){
                        $("#chat-online").html(resp.online);
                    }
                })
            }
            chatOnline();
        }
    </script>
   <script>
    // Agar page refresh flag nahi hai, to reload once and set it
    if (!sessionStorage.getItem('justReloaded')) {
        sessionStorage.setItem('justReloaded', 'true');
        window.location.reload(true); // 🔁 Force reload from server
    } else {
        sessionStorage.removeItem('justReloaded'); // ✅ Clean up
    }

    // Jab page chhode, flag hata do taaki next time firse chale
    window.addEventListener('beforeunload', () => {
        sessionStorage.removeItem('justReloaded');
    });
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/units/view.blade.php ENDPATH**/ ?>