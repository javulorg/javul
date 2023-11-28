<?php echo $__env->make('layout.header-dependencies', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="wrapper position-relative">
    <div class="banner">
        <div class="banner_left_side">
            <div class="banner_car">
                <img src="<?php echo e(asset('v2/assets/img/main-logo.png')); ?>" alt="" class="img-fluid">
            </div>
            <div>
                <?php echo $__env->yieldContent('site-name'); ?>
            </div>
        </div>
        <div class="container">
            <div class="search_block d-lg-block d-none">
                <div class="search_form">
                    <div class="separator"></div>
                    <input type="text" placeholder="Search Site-wide">
                    <div class="separator"></div>
                    <button type="submit"><img src="<?php echo e(asset('v2/assets/img/search.svg')); ?>" alt=""></button>
                    <div class="clear_search"></div>
                </div>
                <a href="#">
                    Advanced Search
                </a>
            </div>
            <div class="search_btn d-md-none d-flex" id="search_btn">
                <img src="<?php echo e(asset('v2/assets/img/search.svg')); ?>" alt="">
            </div>
        </div>
    </div>

    <?php echo $__env->yieldContent('navbar'); ?>

    <div class="breadcrumbs">
        <!-- <div class="container">
            <div class="bread">
                <a href="/">Urban Planning</a><div class="separator"></div><a href="#">Public Transport</a><div class="separator"></div><a href="#">Taxis</a>
            </div>
        </div> -->
    </div>

    <div class="content">
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <div class="site_statistic">
        <?php echo $__env->make('layout.site-statistic', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <footer>
    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('scripts'); ?>
    </footer>
</div>



<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/head.blade.php ENDPATH**/ ?>