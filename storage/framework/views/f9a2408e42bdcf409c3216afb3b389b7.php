<?php $__env->startSection('title', 'Wiki : Create Page' ); ?>
<?php $__env->startSection('site-name'); ?>
    <?php if(isset($unitData)): ?>
        <h1><?php echo e($unitData->name); ?></h1>
    <?php else: ?>
        <h1>Javul.org</h1>
    <?php endif; ?>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('navbar'); ?>
    <?php if(isset($unitData)): ?>
        <?php echo $__env->make('layout.navbar', ['unitData' => $unitData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content_row">
        <div class="sidebar">

            <?php if(isset($unitData)): ?>
                <?php echo $__env->make('layout.v2.global-unit-overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php
                $title = 'Activity Log';
                ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('layout.v2.global-finances', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('layout.v2.global-about-site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php
                $title = 'Global Activity Log';
                ?>
                <?php echo $__env->make('layout.v2.global-activity-log',['title' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

        </div>
        <div class="main_content">
            <div class="card">
                <div class="card-header d-flex align-items-center" style="background-color: #D3D3D3;">
                    <div class="featured_unit current_task me-3">
                        <i class="fa fa-book"></i>
                    </div>
                    <?php if(isset($edit) && $edit == false): ?>
                    <h4 class="card-title m-0" style="color: #0d1217;">Create New Wiki Page</h4>
                    <?php else: ?>
                        <h4 class="card-title m-0" style="color: #0d1217;">Edit Wiki Page</h4>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form action="" method="post" id="wiki_forum" role="form" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if(isset($wiki_page_rev_id)) { ?>
                        <div class="alert alert-danger text-center mb-4">You are editing an older revision of <?= date("d/m/Y ha",strtotime($wiki_page['time_stamp'])) ?> </div>
                        <?php } ?>
                        <?php if( (isset($wiki_page) && !$wiki_page['is_wikihome']) || !isset($wiki_page) )  { ?>
                        <div class="mb-3">
                            <label class="form-label">Page Title</label>
                            <input class="form-control" name="title" value="<?=  isset($wiki_page) ? $wiki_page['wiki_page_title'] : '' ?>">
                        </div>
                        <?php } else{ ?>
                        <input class="form-control" type="hidden" name="title" value="">
                        <?php } ?>
                        <div class="mb-3">
                            <label class="form-label">Page Content</label>

                            <textarea class="form-control" id="description" name="description"><?=  isset($wiki_page) ? $wiki_page['page_content'] : '' ?></textarea>
                        </div>
                        <?php if( isset($wiki_page) )  { ?>
                        <div class="mb-3">


                        </div>
                        <?php } ?>
                        <input type="hidden" name="id" value="<?=  isset($wiki_page) ? $wiki_page['wiki_page_id'] : '0' ?>">
                        <input type="hidden" name="is_wikihome" value="<?=  isset($wiki_page) ? $wiki_page['is_wikihome'] : '0' ?>">
                        <input type="hidden" name="wiki_page_rev_id" value="<?=  isset($wiki_page_rev_id) ? $wiki_page_rev_id : '0' ?>">



                        <?php if(isset($edit) && $edit == false): ?>
                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-primary">Save Page</button>
                            </div>
                        <?php else: ?>
                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-primary">Update Page</button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>




        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

    <script type="text/javascript">
        $(document).ready(function () {
            ClassicEditor
                .create(document.querySelector('#description'))
                .catch(error => {
                    console.error(error);
                });
            var xhr;
            $("#wiki_forum").submit(function ()
            {
                if (xhr && xhr.readyState != 4)
                {
                    xhr.abort();
                }
                $("#wiki_forum").find(".alert").remove();
                xhr = $.ajax({
                    type: 'post',
                    url: '<?php echo url('wiki/edit')."/". $unit_id ."/". $slug; ?>',
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function () {
                        $("#wiki_forum button").button("loading");
                    },
                    error: function () {

                    },
                    complete: function () {
                        $("#wiki_forum button").button("reset");
                    },
                    success: function (json) {
                        console.log(json);
                        if (json['errors']) {
                            $.each(json['errors'], function (i, j) {
                                $("[name='" + i + "']").after("<div class='alert alert-danger'> " + j + " </div>");
                            })
                        }
                        if (json['success']) {
                            toastr['success'](json['success'], '');
                            toastr.success('The new page has been created', 'Success')
                            setTimeout(function () {
                                location = json['location']
                            }, 1000);
                            //setTimeout(function(){ history.back() },1000);
                        }
                        if (json['error']) {
                            toastr['error'](json['error'], '');
                        }
                    }
                });
                return false;
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/wiki/edit.blade.php ENDPATH**/ ?>