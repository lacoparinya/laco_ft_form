<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ $iqfmapcol->name or ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group {{ $errors->has('col_name') ? 'has-error' : ''}}">
    <label for="col_name" class="control-label">{{ 'Map' }}</label>
    <input class="form-control" name="col_name" type="text" id="col_name" value="{{ $iqfmapcol->col_name or ''}}" >
    {!! $errors->first('col_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Statis' }}</label>
    <input class="form-control" name="status" type="text" id="status" value="{{ $iqfmapcol->status or ''}}" >
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
