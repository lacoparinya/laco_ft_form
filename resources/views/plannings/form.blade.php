<div class="form-group col-md-6  {{ $errors->has('job_id') ? 'has-error' : ''}}">
    <label for="job_id" class="control-label">{{ 'ส่วนงาน' }}</label>
    <select name="job_id" class="form-control" id="job_id" required>
        <option value="">-</option>
    @foreach ($joblist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($planning->job_id) && $planning->job_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('job_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6  {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'สินค้า' }}</label>
    <select name="product_id" class="form-control" id="product_id" required>
        <option value="">-</option>
    @foreach ($productlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($planning->product_id) && $planning->product_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('plan_date') ? 'has-error' : ''}}">
    <label for="plan_date" class="control-label">{{ 'แผนวันที่' }}</label>
    <input class="form-control" name="plan_date" type="date" id="plan_date" value="{{ $planning->plan_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('plan_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('target_man') ? 'has-error' : ''}}">
    <label for="target_man" class="control-label">{{ 'แผนจำนวนคน' }}</label>
    <input required class="form-control" name="target_man" type="number" id="target_man" value="{{ $planning->target_man or ''}}" >
    {!! $errors->first('target_man', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('target_value') ? 'has-error' : ''}}">
    <label for="target_value" class="control-label">{{ 'แผนจำนวน(kg)' }}</label>
    <input required class="form-control" name="target_value" type="number" id="target_value" value="{{ $planning->target_value or ''}}" >
    {!! $errors->first('target_value', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <input class="form-control" name="note" type="numtextber" id="note" value="{{ $planning->note or ''}}" >
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
