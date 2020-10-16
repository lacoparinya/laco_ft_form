<div class="form-group {{ $errors->has('matname') ? 'has-error' : ''}}">
    <label for="matname" class="control-label">{{ 'Mat Name' }}</label>
    <input class="form-control" name="matname" type="text" id="matname" value="{{ $matpack->matname or ''}}" >
    {!! $errors->first('matname', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('packname') ? 'has-error' : ''}}">
    <label for="packname" class="control-label">{{ 'Pack Name' }}</label>
    <input class="form-control" name="packname" type="text" id="packname" value="{{ $matpack->packname or ''}}" >
    {!! $errors->first('packname', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('stdrateperhr') ? 'has-error' : ''}}">
    <label for="stdrateperhr" class="control-label">{{ 'STD Rate per Hr' }}</label>
    <input class="form-control" name="stdrateperhr" type="text" id="stdrateperhr" value="{{ $matpack->stdrateperhr or ''}}" >
    {!! $errors->first('stdrateperhr', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <input class="form-control" name="status" type="text" id="status" value="{{ $matpack->status or 'Active'}}" >
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
