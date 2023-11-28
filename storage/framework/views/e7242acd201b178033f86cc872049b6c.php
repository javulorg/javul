








































<div class="card mt-4" style="margin-bottom: 30px;">
    <div class="card-header">
        File Attachments
    </div>
    <div class="card-body">
        <?php if(!empty($issueObj->issue_documents) && count($issueObj->issue_documents) > 0): ?>
            <ul class="list-group" style="list-style-type: decimal;">
                <?php $__currentLoopData = $issueObj->issue_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>
                    <?php if($extension == "pdf"): ?>
                        <?php $extension = "pdf"; ?>
                    <?php elseif(in_array($extension, ["doc", "docx"])): ?>
                        <?php $extension = "docx"; ?>
                    <?php elseif(in_array($extension, ["jpg", "jpeg"])): ?>
                        <?php $extension = "jpeg"; ?>
                    <?php elseif(in_array($extension, ["ppt", "pptx"])): ?>
                        <?php $extension = "pptx"; ?>
                    <?php else: ?>
                        <?php $extension = "file"; ?>
                    <?php endif; ?>
                    <li class="list-group-item">
                        <a class="files_image" href="<?php echo e(asset($document->file_path)); ?>" target="_blank">
                            <?php if(empty($document->file_name)): ?>
                                &nbsp;
                            <?php else: ?>
                                <?php echo e($document->file_name); ?>

                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <div class="list-group">
                <li class="list-group-item">No documents found.</li>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\javul\resources\views/issues/v2/partials/file-attachments.blade.php ENDPATH**/ ?>