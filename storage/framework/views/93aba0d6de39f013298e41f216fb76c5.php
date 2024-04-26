<?php $__env->startSection('title', 'Objective: Change Difference'); ?>
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

        <div class="col-md-9 mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-heading d-flex align-items-center">
                        <div class="table_block_icon featured_unit current_objective">
                            <img src="<?php echo e(asset('v2/assets/img/location.svg')); ?>" style="margin-bottom:6px;" alt="" class="img-fluid">
                        </div>
                        <h4 class="card-title ml-3" style="font-size: medium;">Comparing Revisions</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row hide">
                                <div class="col-md-6">
                                    <hr>
                                    <div class="sub-content main-content">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <hr>
                                    <div class="sub-content compare-content">

                                    </div>
                                </div>
                            </div>
                            <div class="viewType">
                                <input type="radio" name="_viewtype" id="sidebyside" onclick="diffUsingJS(0);" />
                                <label for="sidebyside">Side by Side Diff</label>
                                <input type="radio" name="_viewtype" id="inline" onclick="diffUsingJS(1);" />
                                <label for="inline">Inline Diff</label>
                            </div>
                            <div id="diffoutput"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <link href="<?php echo url('assets/plugins/jsdifflib-master/diffview.css'); ?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo url('assets/plugins/jsdifflib-master/difflib.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo url('assets/plugins/jsdifflib-master/diffview.js'); ?>" type="text/javascript"></script>


    <script type="text/javascript">
        diffUsingJS();
        function diffUsingJS(viewType) {
            "use strict";

            var getContent = function (id) {
                    var oldHTML = $(id).html().trim();
                    return oldHTML;
                },
                byId = function (id) {
                    return document.getElementById(id);
                },
                base = difflib.stringAsLines(getContent(".compare-content")),
                newtxt = difflib.stringAsLines(getContent(".main-content")),
                sm = new difflib.SequenceMatcher(base, newtxt),
                opcodes = sm.get_opcodes(),
                diffoutputdiv = byId("diffoutput"),
                contextSize = null;

            diffoutputdiv.innerHTML = "";
            diffoutputdiv.appendChild(diffview.buildView({
                baseTextLines: base,
                newTextLines: newtxt,
                opcodes: opcodes,
                baseTextName: "New: <?php echo date('d/m/Y ha', strtotime($revisions[0]['created_at'])); ?>",
                newTextName: "Old: <?php echo date('d/m/Y ha', strtotime($revisions[1]['created_at'])); ?>",
                contextSize: contextSize,
                viewType: viewType
            }));
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\javul\resources\views/objectives/revison/changes_difference.blade.php ENDPATH**/ ?>