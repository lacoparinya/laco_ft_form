<div class="form-group col-md-4  {{ $errors->has('job_id') ? 'has-error' : ''}}">
    <label for="job_id" class="control-label">{{ 'ส่วนงาน' }}</label>
    <select name="job_id" class="form-control" id="job_id" required>
        <option value="">-</option>
    @foreach ($joblist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($method->job_id) && $method->job_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('job_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input required class="form-control" name="name" type="text" id="name" value="{{ $method->name or ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('desc') ? 'has-error' : ''}}">
    <label for="desc" class="control-label">{{ 'Desc' }}</label>
    <input required class="form-control" name="desc" type="text" id="desc" value="{{ $method->desc or ''}}" >
    {!! $errors->first('desc', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group  col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
