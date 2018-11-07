<div class="form-group <?php echo e($errors->has('process_date') ? 'has-error' : ''); ?>">
    <label for="process_date" class="control-label"><?php echo e('Process Date'); ?></label>
    <input class="form-control" name="process_date" type="date" id="process_date" value="<?php echo e(isset($ft_log->process_date) ? $ft_log->process_date : \Carbon\Carbon::now()->format('Y-m-d')); ?>" >
    <?php echo $errors->first('process_date', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('process_time') ? 'has-error' : ''); ?>">
    <label for="process_time" class="control-label"><?php echo e('Process Time'); ?></label>
    <input class="form-control" name="process_time" type="time" id="process_time" value="<?php echo e(isset($ft_log->process_time) ? $ft_log->process_time : \Carbon\Carbon::now()->format('H:i:s')); ?>" >
    <?php echo $errors->first('process_time', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('product_id') ? 'has-error' : ''); ?>">
    <label for="product_id" class="control-label"><?php echo e('Product Id'); ?></label>
    <select name="product_id" class="form-control" id="product_id" >
    <?php $__currentLoopData = $productlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($optionKey); ?>" <?php echo e((isset($ft_log->product_id) && $ft_log->product_id == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
    <?php echo $errors->first('product_id', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('shift_id') ? 'has-error' : ''); ?>">
    <label for="shift_id" class="control-label"><?php echo e('Shift'); ?></label>
    <select name="shift_id" class="form-control" id="shift_id" >
    <?php $__currentLoopData = $shiftlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($optionKey); ?>" <?php echo e((isset($ft_log->shift_id) && $ft_log->shift_id == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
    <?php echo $errors->first('shift_id', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('input_kg') ? 'has-error' : ''); ?>">
    <label for="input_kg" class="control-label"><?php echo e('Input Kg'); ?></label>
    <input class="form-control" name="input_kg" type="number" id="input_kg" value="<?php echo e(isset($ft_log->input_kg) ? $ft_log->input_kg : ''); ?>" >
    <?php echo $errors->first('input_kg', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('output_kg') ? 'has-error' : ''); ?>">
    <label for="output_kg" class="control-label"><?php echo e('Output Kg'); ?></label>
    <input class="form-control" name="output_kg" type="number" id="output_kg" value="<?php echo e(isset($ft_log->output_kg) ? $ft_log->output_kg : ''); ?>" >
    <?php echo $errors->first('output_kg', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('sum_kg') ? 'has-error' : ''); ?>">
    <label for="sum_kg" class="control-label"><?php echo e('Sum Kg'); ?></label>
    <input class="form-control" name="sum_kg" type="number" id="sum_kg" value="<?php echo e(isset($ft_log->sum_kg) ? $ft_log->sum_kg : ''); ?>" >
    <?php echo $errors->first('sum_kg', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('yeild_percent') ? 'has-error' : ''); ?>">
    <label for="yeild_percent" class="control-label"><?php echo e('Yeild Percent'); ?></label>
    <input class="form-control" name="yeild_percent" type="number" id="yeild_percent" value="<?php echo e(isset($ft_log->yeild_percent) ? $ft_log->yeild_percent : ''); ?>" >
    <?php echo $errors->first('yeild_percent', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('num_pk') ? 'has-error' : ''); ?>">
    <label for="num_pk" class="control-label"><?php echo e('Num Pk'); ?></label>
    <input class="form-control" name="num_pk" type="number" id="num_pk" value="<?php echo e(isset($ft_log->num_pk) ? $ft_log->num_pk : ''); ?>" >
    <?php echo $errors->first('num_pk', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('num_pf') ? 'has-error' : ''); ?>">
    <label for="num_pf" class="control-label"><?php echo e('Num Pf'); ?></label>
    <input class="form-control" name="num_pf" type="number" id="num_pf" value="<?php echo e(isset($ft_log->num_pf) ? $ft_log->num_pf : ''); ?>" >
    <?php echo $errors->first('num_pf', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('num_pst') ? 'has-error' : ''); ?>">
    <label for="num_pst" class="control-label"><?php echo e('Num Pst'); ?></label>
    <input class="form-control" name="num_pst" type="number" id="num_pst" value="<?php echo e(isset($ft_log->num_pst) ? $ft_log->num_pst : ''); ?>" >
    <?php echo $errors->first('num_pst', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('num_classify') ? 'has-error' : ''); ?>">
    <label for="num_classify" class="control-label"><?php echo e('Num Classify'); ?></label>
    <input class="form-control" name="num_classify" type="number" id="num_classify" value="<?php echo e(isset($ft_log->num_classify) ? $ft_log->num_classify : ''); ?>" >
    <?php echo $errors->first('num_classify', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('line_a') ? 'has-error' : ''); ?>">
    <label for="line_a" class="control-label"><?php echo e('Line A'); ?></label>
    <input class="form-control" name="line_a" type="number" id="line_a" value="<?php echo e(isset($ft_log->line_a) ? $ft_log->line_a : ''); ?>" >
    <?php echo $errors->first('line_a', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('line_b') ? 'has-error' : ''); ?>">
    <label for="line_b" class="control-label"><?php echo e('Line B'); ?></label>
    <input class="form-control" name="line_b" type="number" id="line_b" value="<?php echo e(isset($ft_log->line_b) ? $ft_log->line_b : ''); ?>" >
    <?php echo $errors->first('line_b', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('line_classify') ? 'has-error' : ''); ?>">
    <label for="line_classify" class="control-label"><?php echo e('Line Classify'); ?></label>
    <input class="form-control" name="line_classify" type="number" id="line_classify" value="<?php echo e(isset($ft_log->line_classify) ? $ft_log->line_classify : ''); ?>" >
    <?php echo $errors->first('line_classify', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('line_classify_unit') ? 'has-error' : ''); ?>">
    <label for="line_classify_unit" class="control-label"><?php echo e('Line Classify Unit'); ?></label>
    <select name="line_classify_unit" class="form-control" id="line_classify_unit" >
    <?php $__currentLoopData = $unitlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($optionKey); ?>" <?php echo e((isset($ft_log->line_classify_unit) && $ft_log->line_classify_unit == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
    <?php echo $errors->first('line_classify_unit', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('note') ? 'has-error' : ''); ?>">
    <label for="note" class="control-label"><?php echo e('Note'); ?></label>
    <textarea class="form-control" rows="5" name="note" type="textarea" id="note" ><?php echo e(isset($ft_log->note) ? $ft_log->note : ''); ?></textarea>
    <?php echo $errors->first('note', '<p class="help-block">:message</p>'); ?>

</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Update' : 'Create'); ?>">
</div>
