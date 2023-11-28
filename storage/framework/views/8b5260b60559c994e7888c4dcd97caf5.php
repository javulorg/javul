<!DOCTYPE html>
<html lang="en" <?php if(!empty(session('locale')) && session('locale') == "ar"): ?> dir="rtl" <?php endif; ?>>
<head>
    <title><?php echo $__env->yieldContent('title'); ?> - Javul.org</title>
</head>
<body>
<?php echo $__env->make('layout.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/layout/app.blade.php ENDPATH**/ ?>