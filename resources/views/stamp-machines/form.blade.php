<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ $stampmachine->name or ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('desc') ? 'has-error' : ''}}">
    <label for="desc" class="control-label">{{ 'Desc' }}</label>
    <input class="form-control" name="desc" type="text" id="desc" value="{{ $stampmachine->desc or ''}}" >
    {!! $errors->first('desc', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('standardrate') ? 'has-error' : ''}}">
    <label for="standardrate" class="control-label">{{ 'STD Rate' }}</label>
    <input class="form-control" name="standardrate" type="text" id="standardrate" value="{{ $stampmachine->standardrate or ''}}" >
    {!! $errors->first('standardrate', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
