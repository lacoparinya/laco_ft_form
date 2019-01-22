<div class="row">
<div class="form-group col-md-6 {{ $errors->has('process_date') ? 'has-error' : ''}}">
    <label for="process_date" class="control-label">{{ 'วันผลิต' }}</label>
    <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $ft_log->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('timeslot_id') ? 'has-error' : ''}}">
    <label for="timeslot_id" class="control-label">{{ 'เวลา' }}</label>
    <select name="timeslot_id" class="form-control dynamic" id="timeslot_id" data-dependent = 'shift_id'>
    @foreach ($timeslotlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ft_log->timeslot_id) && $ft_log->timeslot_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('timeslot_id', '<p class="help-block">:message</p>') !!}
</div>


</div>
<div class="row">
<div class="form-group col-md-4 {{ $errors->has('shift_id') ? 'has-error' : ''}}">
    <label for="shift_id" class="control-label">{{ 'กะ' }}</label>
    <select name="shift_id" class="form-control" id="shift_id" >
    @foreach ($shiftlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ft_log->shift_id) && $ft_log->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('shift_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'คัดผลิตภัณท์' }}</label>
    <select name="product_id" class="form-control" id="product_id" >
    @foreach ($productlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ft_log->product_id) && $ft_log->product_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('input_kg') ? 'has-error' : ''}}">
    <label for="input_kg" class="control-label">{{ 'Input/kgs' }}</label>
    <input required class="form-control" name="input_kg" type="number" id="input_kg" value="{{ $ft_log->input_kg or ''}}" >
    {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
</div>
</div>
<div class="row">
<div class="form-group col-md-4 {{ $errors->has('output_kg') ? 'has-error' : ''}}">
    <label for="output_kg" class="control-label">{{ 'Output/kg.' }}</label>
    <input required class="form-control" name="output_kg" type="number" id="output_kg" value="{{ $ft_log->output_kg or ''}}" >
    {!! $errors->first('output_kg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('sum_kg') ? 'has-error' : ''}}">
    <label for="sum_kg" class="control-label">{{ 'คัดได้สะสม' }}</label>
    <input required class="form-control" name="sum_kg" type="number" id="sum_kg" value="{{ $ft_log->sum_kg or ''}}" >
    {!! $errors->first('sum_kg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('yeild_percent') ? 'has-error' : ''}}">
    <label for="yeild_percent" class="control-label">{{ '% yeild' }}</label>
    <input class="form-control" name="yeild_percent" type="text" readonly id="yeild_percent" value="{{ $ft_log->yeild_percent or ''}}" >
    {!! $errors->first('yeild_percent', '<p class="help-block">:message</p>') !!}
</div>
</div>
<div class="row">
<div class="form-group col-md-4 {{ $errors->has('num_pk') ? 'has-error' : ''}}">
    <label required for="num_pk" class="control-label">{{ 'PK' }}</label>
    <input class="form-control" name="num_pk" type="number" id="num_pk" value="{{ $ft_log->num_pk or ''}}" >
    {!! $errors->first('num_pk', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('num_pf') ? 'has-error' : ''}}">
    <label for="num_pf" class="control-label">{{ 'PF' }}</label>
    <input required class="form-control" name="num_pf" type="number" id="num_pf" value="{{ $ft_log->num_pf or ''}}" >
    {!! $errors->first('num_pf', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('num_pst') ? 'has-error' : ''}}">
    <label for="num_pst" class="control-label">{{ 'PST' }}</label>
    <input required class="form-control" name="num_pst" type="number" id="num_pst" value="{{ $ft_log->num_pst or ''}}" >
    {!! $errors->first('num_pst', '<p class="help-block">:message</p>') !!}
</div>
</div>
<div class="row">
<div class="form-group col-md-4 {{ $errors->has('num_classify') ? 'has-error' : ''}}">
    <label for="num_classify" class="control-label">{{ 'จำนวนคน' }}</label>
    <input class="form-control" name="num_classify" type="number" readonly id="num_classify" value="{{ $ft_log->num_classify or ''}}" >
    {!! $errors->first('num_classify', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('line_a') ? 'has-error' : ''}}">
    <label for="line_a" class="control-label">{{ 'เปิดไลน์ฝั่ง A' }}</label>
    <input required class="form-control" name="line_a" type="number" id="line_a" value="{{ $ft_log->line_a or ''}}" >
    {!! $errors->first('line_a', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('line_b') ? 'has-error' : ''}}">
    <label for="line_b" class="control-label">{{ 'เปิดไลน์ฝั่ง B' }}</label>
    <input required class="form-control" name="line_b" type="number" id="line_b" value="{{ $ft_log->line_b or ''}}" >
    {!! $errors->first('line_b', '<p class="help-block">:message</p>') !!}
</div>
</div>
<div class="row">
<div class="form-group col-md-4 {{ $errors->has('line_classify') ? 'has-error' : ''}}">
    <label for="line_classify" class="control-label">{{ 'เปิดไลน์คัด' }}</label>
    <input required class="form-control" name="line_classify" type="number" readonly id="line_classify" value="{{ $ft_log->line_classify or ''}}" >
    {!! $errors->first('line_classify', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('line_classify_unit') ? 'has-error' : ''}}">
    <label for="line_classify_unit" class="control-label">{{ '&nbsp;' }}</label>
    <select name="line_classify_unit" class="form-control" id="line_classify_unit" >
    @foreach ($unitlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ft_log->line_classify_unit) && $ft_log->line_classify_unit == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('line_classify_unit', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('grade') ? 'has-error' : ''}}">
    <label for="grade" class="control-label">{{ 'เกรด' }}</label>
    <select name="grade" class="form-control" id="shift_id" >
    @foreach ($gradelist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ft_log->grade) && $ft_log->grade == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('grade', '<p class="help-block">:message</p>') !!}
</div>
</div>
<div class="form-group col-md-12 {{ $errors->has('ref_note') ? 'has-error' : ''}}">
    <label for="ref_note" class="control-label">{{ 'SAP REF' }}</label>
    <input required class="form-control" name="ref_note" type="numtextber" id="ref_note" value="{{ $ft_log->ref_note or ''}}" >
    {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <textarea class="form-control" rows="5" name="note" type="textarea" id="note" >{{ $ft_log->note or ''}}</textarea>
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group  col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
