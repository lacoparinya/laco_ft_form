<div class="form-group col-md-6  {{ $errors->has('pre_prod_id') ? 'has-error' : ''}}">
    <label for="pre_prod_id" class="control-label">{{ 'Prepare Product' }}</label>
    <select name="pre_prod_id" class="form-control" id="pre_prod_id" required>
        <option value="">-</option>
    @foreach ($preprodlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($stdpreprod->pre_prod_id) && $stdpreprod->pre_prod_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('pre_prod_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('std_rate_per_h_m') ? 'has-error' : ''}}">
    <label for="std_rate_per_h_m" class="control-label">{{ 'Rate Per Hour and Man' }}</label>
    <input class="form-control" name="std_rate_per_h_m" type="number" id="std_rate_per_h_m" value="{{ $stdpreprod->std_rate_per_h_m or '0'}}" >
    {!! $errors->first('std_rate_per_h_m', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <input class="form-control" name="note" type="text" id="note" value="{{ $stdpreprod->note or ''}}" >
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <input class="form-control" name="status" type="text" id="status" value="{{ $stdpreprod->status or '1'}}" >
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
