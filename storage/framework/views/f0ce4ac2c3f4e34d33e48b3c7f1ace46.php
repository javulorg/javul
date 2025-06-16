<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('style'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-name'); ?>
    <h1>Javul.org</h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">
            <?php if(isset($unitData)): ?>
                <?php
                $title = 'Activity Log';
                ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php
                $title = 'Global Activity Log';
                ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>
        <div class="main_content">

            <?php echo $__env->make('layout.v2.master.units', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.master.issues', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.master.ideas', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.master.tasks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('layout.v2.master.objectives', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchButton = document.querySelector('.search_form button');
    const searchInput = document.querySelector('.search_form input');

    searchButton.addEventListener('click', function (e) {
        e.preventDefault();
        const keyword = searchInput.value.toLowerCase();

        const tableIds = ['units_table', 'issues_table', 'ideas_table'];

        tableIds.forEach(function (tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;
            const rows = table.querySelectorAll('tbody tr');
            let matchFound = false;

            rows.forEach(function (row) {
                const rowText = row.innerText.toLowerCase();
                if (rowText.includes(keyword)) {
                    row.style.display = '';
                    matchFound = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // No result logic
            const noResultId = `${tableId}_no_result`;
            let noResultRow = document.getElementById(noResultId);

            if (!matchFound) {
                if (!noResultRow) {
                    noResultRow = document.createElement('tr');
                    noResultRow.id = noResultId;
                    noResultRow.innerHTML = `<td colspan="100%" style="text-align:center; color:red;">No results found</td>`;
                    table.querySelector('tbody').appendChild(noResultRow);
                }
            } else if (noResultRow) {
                noResultRow.remove();
            }
        });
    });

    // Optional: Enable Enter key search
    searchInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            searchButton.click();
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/master.blade.php ENDPATH**/ ?>