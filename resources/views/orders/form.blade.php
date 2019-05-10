
<div class="form-group col-md-6 {{ $errors->has('order_no') ? 'has-error' : ''}}">
    <label for="order_no" class="control-label">{{ 'Order No' }}</label>
    <input required class="form-control" name="order_no" type="text" id="order_no" value="{{ $order->order_no or ''}}" >
    {!! $errors->first('order_no', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('loading_date') ? 'has-error' : ''}}">
    <label for="loading_date" class="control-label">{{ 'Loading Date' }}</label>
    <input class="form-control" name="loading_date" type="date" id="loading_date" value="{{ $order->loading_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('loading_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <input required class="form-control" name="note" type="text" id="note" value="{{ $order->note or ''}}" >
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group  col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
