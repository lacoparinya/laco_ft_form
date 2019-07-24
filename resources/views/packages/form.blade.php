<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ $package->name or ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('desc') ? 'has-error' : ''}}">
    <label for="desc" class="control-label">{{ 'Desc' }}</label>
    <input class="form-control" name="desc" type="text" id="desc" value="{{ $package->desc or ''}}" >
    {!! $errors->first('desc', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('kgsperpack') ? 'has-error' : ''}}">
    <label for="kgsperpack" class="control-label">{{ 'Kgs per Pack' }}</label>
    <input class="form-control" name="kgsperpack" type="text" id="kgsperpack" value="{{ $package->kgsperpack or ''}}" >
    {!! $errors->first('kgsperpack', '<p class="help-block">:message</p>') !!}
</div>

@php
    $statuslist = array('Active'=>'Active','Inactive'=>'Inactve');
@endphp
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'เวลา' }}</label>
    <select name="status" class="form-control dynamic" id="status" required>
    @foreach ($statuslist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($package->status) && $package->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
