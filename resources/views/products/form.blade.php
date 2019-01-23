<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ $product->name or ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('desc') ? 'has-error' : ''}}">
    <label for="desc" class="control-label">{{ 'Desc' }}</label>
    <input class="form-control" name="desc" type="text" id="desc" value="{{ $product->desc or ''}}" >
    {!! $errors->first('desc', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('product_group_id') ? 'has-error' : ''}}">
    <label for="product_group_id" class="control-label">{{ 'Product Group' }}</label>
    <select name="product_group_id" class="form-control" id="product_group_id" >
    @foreach ($productgrouplist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($product->product_group_id) && $product->product_group_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('product_group_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
