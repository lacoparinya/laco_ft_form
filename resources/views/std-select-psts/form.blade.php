<div class="row">
<div class="form-group col-md-5 {{ $errors->has('pst_product_id') ? 'has-error' : ''}}">
    <label for="pst_product_id" class="control-label">{{ 'PST Product' }}</label>
    <select name="pst_product_id" class="form-control" id="pst_product_id" >
    @foreach ($productlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($stdselectpst->pst_product_id) && $stdselectpst->pst_product_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('pst_product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('std_rate_per_h_m') ? 'has-error' : ''}}">
    <label for="std_rate_per_h_m" class="control-label">{{ 'STD Productivity Rate Per Hour' }}</label>
    <input class="form-control" name="std_rate_per_h_m" type="text" id="std_rate_per_h_m" value="{{ $stdselectpst->std_rate_per_h_m or ''}}" >
    {!! $errors->first('std_rate_per_h_m', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control" id="status" >
    @foreach ($statuslist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($stdselectpst->status) && $stdselectpst->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
</div>
<div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <input class="form-control" name="note" type="text" id="note" value="{{ $stdselectpst->note or ''}}" >
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>

    {!! $errors->first('pst_product_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
</div>