<div class="form-group col-md-4  {{ $errors->has('method_id') ? 'has-error' : ''}}">
    <label for="method_id" class="control-label">{{ 'วิธี' }}</label>
    <select name="method_id" class="form-control" id="method_id" required>
        <option value="">-</option>
    @foreach ($methodlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($stdpack->method_id) && $stdpack->method_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('method_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4  {{ $errors->has('package_id') ? 'has-error' : ''}}">
    <label for="package_id" class="control-label">{{ 'บรรจุ' }}</label>
    <select name="package_id" class="form-control" id="package_id" required>
        <option value="">-</option>
    @foreach ($packagelist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($stdpack->package_id) && $stdpack->package_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('package_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('std_rate') ? 'has-error' : ''}}">
    <label for="std_rate" class="control-label">{{ 'Std Rate' }}</label>
    <input required class="form-control" name="std_rate" type="text" id="std_rate" value="{{ $stdpack->std_rate or ''}}" >
    {!! $errors->first('std_rate', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <input required class="form-control" name="status" type="text" id="status" value="{{ $stdpack->status or '1'}}" >
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
