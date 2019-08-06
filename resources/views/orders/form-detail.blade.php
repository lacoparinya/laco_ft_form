
<div class="col-md-6">
<h3>Order : {{ $order->order_no }}</h3>
</div>
<div class="col-md-6">
<h3>Loading Date : {{ $order->loading_date }}</h3>
<input name="order_id" type="hidden" id="order_id"  value={{ $order->id or '' }}  >
</div>

<div class="form-group col-md-6 {{ $errors->has('method_id') ? 'has-error' : ''}}">
    <label for="method_id" class="control-label">{{ 'วิธี' }}</label>
    <select name="method_id" class="form-control" id="method_id" required>
        <option value="">-</option>
    @foreach ($methodlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($orderdetail->method_id) && $orderdetail->method_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('method_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('package_id') ? 'has-error' : ''}}">
    <label for="package_id" class="control-label">{{ 'สินค้า' }}</label>
    <select name="package_id" class="form-control" id="package_id" required>
        <option value="">-</option>
    @foreach ($packagelist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($orderdetail->package_id) && $orderdetail->package_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('package_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('total_pack') ? 'has-error' : ''}}">
    <label for="total_pack" class="control-label">{{ 'Total Packs' }}</label>
    <input class="form-control" name="total_pack" type="text" id="total_pack" value="{{ $orderdetail->total_pack or ''}}" >
    {!! $errors->first('total_pack', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('total_kg') ? 'has-error' : ''}}">
    <label for="total_kg" class="control-label">{{ 'Total Kgs' }}</label>
    <input class="form-control" name="total_kg" type="text" id="total_kg" value="{{ $orderdetail->total_kg or ''}}" >
    {!! $errors->first('total_kg', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <input class="form-control" name="note" type="text" id="note" value="{{ $orderdetail->note or ''}}" >
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group  col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
