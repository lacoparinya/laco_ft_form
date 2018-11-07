<div class="form-group {{ $errors->has('process_date') ? 'has-error' : ''}}">
    <label for="process_date" class="control-label">{{ 'Process Date' }}</label>
    <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $ft_log->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('process_time') ? 'has-error' : ''}}">
    <label for="process_time" class="control-label">{{ 'Process Time' }}</label>
    <input class="form-control" name="process_time" type="time" id="process_time" value="{{ $process_time_format or \Carbon\Carbon::now()->format('H:i:s') }}" >
    {!! $errors->first('process_time', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'Product Id' }}</label>
    <select name="product_id" class="form-control" id="product_id" >
    @foreach ($productlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ft_log->product_id) && $ft_log->product_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shift_id') ? 'has-error' : ''}}">
    <label for="shift_id" class="control-label">{{ 'Shift' }}</label>
    <select name="shift_id" class="form-control" id="shift_id" >
    @foreach ($shiftlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ft_log->shift_id) && $ft_log->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('shift_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('input_kg') ? 'has-error' : ''}}">
    <label for="input_kg" class="control-label">{{ 'Input Kg' }}</label>
    <input class="form-control" name="input_kg" type="number" id="input_kg" value="{{ $ft_log->input_kg or ''}}" >
    {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('output_kg') ? 'has-error' : ''}}">
    <label for="output_kg" class="control-label">{{ 'Output Kg' }}</label>
    <input class="form-control" name="output_kg" type="number" id="output_kg" value="{{ $ft_log->output_kg or ''}}" >
    {!! $errors->first('output_kg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sum_kg') ? 'has-error' : ''}}">
    <label for="sum_kg" class="control-label">{{ 'Sum Kg' }}</label>
    <input class="form-control" name="sum_kg" type="number" id="sum_kg" value="{{ $ft_log->sum_kg or ''}}" >
    {!! $errors->first('sum_kg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('yeild_percent') ? 'has-error' : ''}}">
    <label for="yeild_percent" class="control-label">{{ 'Yeild Percent' }}</label>
    <input class="form-control" name="yeild_percent" type="number" id="yeild_percent" value="{{ $ft_log->yeild_percent or ''}}" >
    {!! $errors->first('yeild_percent', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('num_pk') ? 'has-error' : ''}}">
    <label for="num_pk" class="control-label">{{ 'Num Pk' }}</label>
    <input class="form-control" name="num_pk" type="number" id="num_pk" value="{{ $ft_log->num_pk or ''}}" >
    {!! $errors->first('num_pk', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('num_pf') ? 'has-error' : ''}}">
    <label for="num_pf" class="control-label">{{ 'Num Pf' }}</label>
    <input class="form-control" name="num_pf" type="number" id="num_pf" value="{{ $ft_log->num_pf or ''}}" >
    {!! $errors->first('num_pf', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('num_pst') ? 'has-error' : ''}}">
    <label for="num_pst" class="control-label">{{ 'Num Pst' }}</label>
    <input class="form-control" name="num_pst" type="number" id="num_pst" value="{{ $ft_log->num_pst or ''}}" >
    {!! $errors->first('num_pst', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('num_classify') ? 'has-error' : ''}}">
    <label for="num_classify" class="control-label">{{ 'Num Classify' }}</label>
    <input class="form-control" name="num_classify" type="number" id="num_classify" value="{{ $ft_log->num_classify or ''}}" >
    {!! $errors->first('num_classify', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('line_a') ? 'has-error' : ''}}">
    <label for="line_a" class="control-label">{{ 'Line A' }}</label>
    <input class="form-control" name="line_a" type="number" id="line_a" value="{{ $ft_log->line_a or ''}}" >
    {!! $errors->first('line_a', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('line_b') ? 'has-error' : ''}}">
    <label for="line_b" class="control-label">{{ 'Line B' }}</label>
    <input class="form-control" name="line_b" type="number" id="line_b" value="{{ $ft_log->line_b or ''}}" >
    {!! $errors->first('line_b', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('line_classify') ? 'has-error' : ''}}">
    <label for="line_classify" class="control-label">{{ 'Line Classify' }}</label>
    <input class="form-control" name="line_classify" type="number" id="line_classify" value="{{ $ft_log->line_classify or ''}}" >
    {!! $errors->first('line_classify', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('line_classify_unit') ? 'has-error' : ''}}">
    <label for="line_classify_unit" class="control-label">{{ 'Line Classify Unit' }}</label>
    <select name="line_classify_unit" class="form-control" id="line_classify_unit" >
    @foreach ($unitlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ft_log->line_classify_unit) && $ft_log->line_classify_unit == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('line_classify_unit', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <textarea class="form-control" rows="5" name="note" type="textarea" id="note" >{{ $ft_log->note or ''}}</textarea>
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
