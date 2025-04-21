<?php echo $__env->make('layout.header-dependencies', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="wrapper">
    <div class="main-header">

        <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                    <select name="search_select" id="search_select_modal">
                        <option value="">Search with this Unit</option>
                        <option value="">Search with another Unit</option>
                    </select>
                    <div class="separator"></div>
                    <input type="text" placeholder="">
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

        <?php if(!Route::is('login') && !Route::is('register')): ?>
            <div class="content">
                <div class="container">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
         <?php endif; ?>


    </div>

    <?php if(Route::is('login') || Route::is('register')): ?>
    <div class="content">
            <div class="container">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    <?php endif; ?>


    <div class="main-footer">
        <div class="site_statistic">
            <?php echo $__env->make('layout.site-statistic', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <footer>
            <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldContent('scripts'); ?>
        </footer>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/head.blade.php ENDPATH**/ ?>