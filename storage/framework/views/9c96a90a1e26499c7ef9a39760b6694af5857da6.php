<div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
    <label for="name" class="control-label"><?php echo e('Name'); ?></label>
    <input class="form-control" name="name" type="text" id="name" value="<?php echo e(isset($group->name) ? $group->name : ''); ?>" >
    <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

</div>
<div class="form-group <?php echo e($errors->has('desc') ? 'has-error' : ''); ?>">
    <label for="desc" class="control-label"><?php echo e('Desc'); ?></label>
    <input class="form-control" name="desc" type="text" id="desc" value="<?php echo e(isset($group->desc) ? $group->desc : ''); ?>" >
    <?php echo $errors->first('desc', '<p class="help-block">:message</p>'); ?>

</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Update' : 'Create'); ?>">
</div>
