
<div class="sidebar_block">
    <div class="sidebar_block_ttl">
        About
        <div class="arrow">
            <img src="<?php echo e(asset('v2/assets/img/bottom_y.svg')); ?>" alt="">
        </div>
    </div>
    <div class="sidebar_block_content">
        <div class="sidebar_block_content_txt">
            <?php if(isset($unitObj) && $unitObj->description): ?>

                <?php echo $unitObj->description; ?><a
                href="<?php echo e(url('wiki/home/' . $unitIDHashID->encode($unitObj->id) . '/' . $unitObj->slug)); ?>"><img
                    src="<?php echo e(asset('v2/assets/img/more.svg')); ?>" alt=""></a>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul-new\javul\resources\views/layout/v2/global-about-site.blade.php ENDPATH**/ ?>