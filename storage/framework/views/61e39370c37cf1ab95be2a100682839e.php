<div class="col-md-4 col-sm-12">
    <div id="kv-avatar-errors-1" class="center-block" style="width:100%;display:none"></div>
    <div class="profile-div">
        <?php if(!empty( auth()->user()->profile_pic)): ?>
            <div class="card-img-top">
                <img src="<?php echo e(auth()->user()->profile_pic); ?>" class="img-fluid rounded-start" alt="Profile Picture">
            </div>
        <?php else: ?>
            <form class="text-center" method="post" enctype="multipart/form-data" id="profilePic">
                <input id="avatar-2" name="profile_pic" type="file" class="file-loading">
                <!-- include other inputs if needed and include a form submit (save) button -->
            </form>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/users/user-account-partials/profile-picture.blade.php ENDPATH**/ ?>