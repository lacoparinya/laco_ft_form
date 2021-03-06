<div class="form-group col-md-4 {{ $errors->has('process_date') ? 'has-error' : ''}}">
    <label for="process_date" class="control-label">{{ 'วันผลิต' }}</label>
    <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $logpstselect->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-2 {{ $errors->has('shift_id') ? 'has-error' : ''}}">
    <label for="shift_id" class="control-label">{{ 'Shift' }}</label>
    <select name="shift_id" class="form-control" id="product_id" >
    @foreach ($shiftlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logpstselect->shift_id) && $logpstselect->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('shift_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-2 {{ $errors->has('pst_type_id') ? 'has-error' : ''}}">
    <label for="pst_type_id" class="control-label">{{ 'Type' }}</label>
    <select name="pst_type_id" class="form-control" id="pst_type_id" >
    @foreach ($psttypelist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logpstselect->pst_type_id) && $logpstselect->pst_type_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('pst_type_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'คัดผลิตภัณท์' }}</label>
    <a href="{{ url('/pst-products/create') }}" target="_blank" class="btn btn-success btn-sm" title="Add New PRoduct">
                            <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มสินค้า
                        </a>
    <select name="product_id" class="form-control" id="product_id" >
    @foreach ($productlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logpstselect->product_id) && $logpstselect->product_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('hourperday') ? 'has-error' : ''}}">
    <label for="hourperday" class="control-label">{{ 'จำนวนชม.ที่ใช้ในการผลิต' }}</label>
    <input required class="form-control" name="hourperday" type="number" id="hourperday" value="{{ $logpstselect->hourperday or ''}}" >
    {!! $errors->first('hourperday', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('targetperday') ? 'has-error' : ''}}">
    <label for="targetperday" class="control-label">{{ 'จำนวนสินค้าที่ต้องผลิต' }}</label>
    <input required class="form-control" name="targetperday" type="number" id="targetperday" value="{{ $logpstselect->targetperday or ''}}" >
    {!! $errors->first('targetperday', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('ref_note') ? 'has-error' : ''}}">
    <label for="ref_note" class="control-label">{{ 'SAP REF' }}</label>
    <input class="form-control" name="ref_note" type="numtextber" id="ref_note" value="{{ $logpstselect->ref_note or ''}}" >
    {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <textarea class="form-control" rows="5" name="note" type="textarea" id="note" >{{ $logpstselect->note or ''}}</textarea>
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
