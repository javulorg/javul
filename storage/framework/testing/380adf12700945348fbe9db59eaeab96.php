<!DOCTYPE html>
<html lang="en" <?php if(!empty(session('locale')) && session('locale') == "ar"): ?> dir="rtl" <?php endif; ?>>
<head>
    <title><?php echo $__env->yieldContent('title'); ?> - Javul.org</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

</head>
<body>
<?php echo $__env->make('layout.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchButton = document.querySelector('.search_form button');
    const searchInput = document.querySelector('.search_form input');

    if (!searchButton || !searchInput) return;

    searchButton.addEventListener('click', function (e) {
        e.preventDefault();
        const keyword = searchInput.value.trim();
        alert("You searched for: " + keyword);
    });
});
</script>

</body>
</html>
<?php /**PATH /var/www/html/javul-staging/javul/resources/views/layout/app.blade.php ENDPATH**/ ?>