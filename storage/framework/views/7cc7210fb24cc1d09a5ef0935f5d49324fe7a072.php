<div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
    <label for="name" class="control-label"><?php echo e('Name'); ?></label>
    <input class="form-control" name="name" type="text" id="name" value="<?php echo e(isset($ft_master->name) ? $ft_master->name : ''); ?>" >
    <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('process_date') ? 'has-error' : ''); ?>">
    <label for="process_date" class="control-label"><?php echo e('Process Date'); ?></label>
    <input class="form-control" name="process_date" type="date" id="process_date" value="<?php echo e(isset($ft_master->process_date) ? $ft_master->process_date : ''); ?>" >
    <?php echo $errors->first('process_date', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('product_id') ? 'has-error' : ''); ?>">
    <label for="product_id" class="control-label"><?php echo e('Product Id'); ?></label>
    <select name="product_id" class="form-control" id="product_id" >
    <?php $__currentLoopData = $productlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($optionKey); ?>" <?php echo e((isset($ft_master->product_id) && $ft_master->product_id == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
    <?php echo $errors->first('product_id', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('note') ? 'has-error' : ''); ?>">
    <label for="note" class="control-label"><?php echo e('Note'); ?></label>
    <textarea class="form-control" rows="5" name="note" type="textarea" id="note" ><?php echo e(isset($ft_master->note) ? $ft_master->note : ''); ?></textarea>
    <?php echo $errors->first('note', '<p class="help-block">:message</p>'); ?>

</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Update' : 'Create'); ?>">
</div>
