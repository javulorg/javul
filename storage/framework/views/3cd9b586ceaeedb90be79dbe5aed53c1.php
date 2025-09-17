<?php echo $__env->make('layout.header-dependencies', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
    .search-form {
        display: flex;
        align-items: center;
        gap: 10px;
        /* space between items */
    }

    .search-input {
        padding: 6px 10px;
        font-size: 14px;
        flex: 1;
    }

    .separator {
        width: 1px;
        height: 24px;
        background-color: #ccc;
    }

    .search-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
    }

    .search-button img {
        width: 18px;
        height: 18px;
    }

    .clear_search {
        cursor: pointer;
        font-size: 16px;
        padding: 0 5px;
        color: #888;
        user-select: none;
    }
</style>

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

                    <?php if(request()->is('/') || request()->is('units') || request()->is('objectives') || request()->is('tasks') || request()->is('ideas') || request()->is('issues')): ?>
    <div class="row">
        <div class="col-lg-6"></div> 

        <div class="col-lg-6">
            <div class="search_form">
                <div class="separator"></div>

                <!-- ✅ SEARCH FORM -->
                <form action="<?php echo e(url()->current()); ?>" method="GET" class="search-form">
                    
                    <input type="text" name="search" id="search_input" placeholder="Search..."
                        value="<?php echo e(request('search')); ?>" class="search-input">

                    <div class="separator"></div>

                    <button type="submit" class="search-button">
                        <img src="<?php echo e(asset('v2/assets/img/search.svg')); ?>" alt="Search">
                    </button>

                    <div class="clear_search" id="clearSearchBtn" onclick="clearSearch()" style="cursor: pointer;">✖</div>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="search_form">
        <div class="separator"></div>

        <!-- ✅ SEARCH FORM -->
        <form action="<?php echo e(url()->current()); ?>" method="GET" class="search-form">
            
            <select name="search_select" id="search_select_modal">
                <option value="this" <?php echo e(request('search_select')==='this' ? 'selected' : ''); ?>>
                    Search with this Unit
                </option>
                <option value="another" <?php echo e(request('search_select')==='another' ? 'selected' : ''); ?>>
                    Search with another Unit
                </option>
            </select>

            <input type="text" name="search" id="search_input" placeholder="Search..."
                value="<?php echo e(request('search')); ?>" class="search-input">

            <div class="separator"></div>

            <button type="submit" class="search-button">
                <img src="<?php echo e(asset('v2/assets/img/search.svg')); ?>" alt="Search">
            </button>

            <div class="clear_search" id="clearSearchBtn" onclick="clearSearch()" style="cursor: pointer;">✖</div>
        </form>
    </div>
<?php endif; ?>



                </div>

                <!-- Mobile Search Button -->
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

<!-- ✅ SCRIPTS SECTION -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clearBtn = document.getElementById('clearSearchBtn');

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                const input = document.querySelector('.search-input');
                if (input) input.value = '';

                const url = new URL(window.location.href);
                url.searchParams.delete('search');
                window.location.href = url.href;
            });
        }
    });
</script>

<script>
    // ✅ Global clearSearch function
    // ✅ Make function global (defined outside any function or block)
    function clearSearch() {
        const input = document.querySelector('.search-input');
        if (input) input.value = ''; // clear field

        const url = new URL(window.location.href);
        url.searchParams.delete('search'); // remove ?search=
        window.location.href = url.href;   // reload page with clean URL
    }

    // ✅ Optional: Filter logic (for client-side filtering if needed)
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search_input');
        const searchBtn = document.getElementById('search_btn');

        function filterItems(sectionId, itemClass) {
            const searchValue = searchInput.value.toLowerCase();
            const section = document.getElementById(sectionId);
            const items = section ? section.querySelectorAll(`.${itemClass}`) : [];

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchValue) ? 'block' : 'none';
            });
        }

        if (searchBtn && searchInput) {
            searchBtn.addEventListener('click', function () {
                filterItems('objectives_section', 'objective-link');
                filterItems('tasks_section', 'task-link');
                filterItems('issues_section', 'issue-link');
                filterItems('ideas_section', 'idea-link');
            });
        }
    });
</script>
<?php /**PATH /var/www/html/javul-staging/javul/resources/views/layout/head.blade.php ENDPATH**/ ?>