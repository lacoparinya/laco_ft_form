<div class="row">
    <div class="form-group col-md-3 {{ $errors->has('process_datetime') ? 'has-error' : ''}}">
        <label for="process_datetime" class="control-label">{{ 'วัน-เวลา' }}</label>
        <input class="form-control" name="process_datetime" type="datetime-local" id="process_datetime" 
        value = "@php
            if(isset($logselectd->process_datetime)){
                echo date('Y-m-d\TH:i',strtotime($logselectd->process_datetime));
            }else{
                echo \Carbon\Carbon::now()->format('Y-m-d\TH:i');
            }
        @endphp" >
        {!! $errors->first('process_datetime', '<p class="help-block">:message</p>') !!}
    </div>
    
   
    <div class="form-group col-md-3 {{ $errors->has('workhours') ? 'has-error' : ''}}">
        <label for="workhours" class="control-label">{{ 'ชม.' }}</label>
        <input class="form-control" name="workhours" type="text" id="workhours" value="{{ $logselectd->workhours or '1' }}" >
        {!! $errors->first('workhours', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group col-md-3 {{ $errors->has('input_kg') ? 'has-error' : ''}}">
        <label for="input_kg" class="control-label">{{ 'Input (kg)' }}</label>
        <input class="form-control calpercent" name="input_kg" type="text" id="input_kg" value="{{ $logselectd->input_kg or '0' }}" >
        {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-3 {{ $errors->has('output_kg') ? 'has-error' : ''}}">
        <label for="output_kg" class="control-label">{{ 'Output (kg)' }}</label>
        <input class="form-control calpercent calpack" name="output_kg" type="text" id="output_kg" value="{{ $logselectd->output_kg or '0' }}" >
        {!! $errors->first('output_kg', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3">
    </div>
    <div class="form-group col-md-3 {{ $errors->has('yeild_percent') ? 'has-error' : ''}}">
    <label for="yeild_percent" class="control-label">{{ 'Yeild %' }}</label>
    <input class="form-control" name="yeild_percent" type="text" readonly id="yeild_percent" value="{{ $logselectd->yeild_percent or ''}}" >
    {!! $errors->first('yeild_percent', '<p class="help-block">:message</p>') !!}
</div>
    <div class="form-group col-md-3 {{ $errors->has('sum_in_kg') ? 'has-error' : ''}}">
        <label for="sum_in_kg" class="control-label">{{ 'รวม Input (kg)' }}</label>
        <input class="form-control" name="sum_in_kg" type="text" id="sum_in_kg" value="{{ $logselectd->sum_in_kg or '0' }}" readonly>
        {!! $errors->first('sum_in_kg', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-3 {{ $errors->has('sum_kg') ? 'has-error' : ''}}">
        <label for="sum_kg" class="control-label">{{ 'รวม Output (kg)' }}</label>
        <input class="form-control" name="sum_kg" type="text" id="sum_kg" value="{{ $logselectd->sum_kg or '0' }}" readonly>
        {!! $errors->first('sum_kg', '<p class="help-block">:message</p>') !!}
    </div>
    
    
    <div class="form-group col-md-3 {{ $errors->has('num_pk') ? 'has-error' : ''}}">
    <label for="num_pk" class="control-label">{{ 'PK' }}</label>
    <input required class="form-control calselectnum" name="num_pk" type="number" id="num_pk" value="{{ $logselectd->num_pk or ''}}" >
    {!! $errors->first('num_pk', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('num_pf') ? 'has-error' : ''}}">
    <label for="num_pf" class="control-label">{{ 'PF' }}</label>
    <input required class="form-control calselectnum" name="num_pf" type="number" id="num_pf" value="{{ $logselectd->num_pf or ''}}" >
    {!! $errors->first('num_pf', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('num_pst') ? 'has-error' : ''}}">
    <label for="num_pst" class="control-label">{{ 'PST' }}</label>
    <input required class="form-control calselectnum" name="num_pst" type="number" id="num_pst" value="{{ $logselectd->num_pst or ''}}" >
    {!! $errors->first('num_pst', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('num_classify') ? 'has-error' : ''}}">
    <label for="num_classify" class="control-label">{{ 'จำนวนคน' }}</label>
    <input class="form-control" name="num_classify" type="number" readonly id="num_classify" value="{{ $logselectd->num_classify or ''}}" >
    {!! $errors->first('num_classify', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('line_a') ? 'has-error' : ''}}">
    <label for="line_a" class="control-label">{{ 'เปิดไลน์ฝั่ง A' }}</label>
    <input required class="form-control calLine" name="line_a" type="number" id="line_a" value="{{ $logselectd->line_a or ''}}" >
    {!! $errors->first('line_a', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('line_b') ? 'has-error' : ''}}">
    <label for="line_b" class="control-label">{{ 'เปิดไลน์ฝั่ง B' }}</label>
    <input required class="form-control calLine" name="line_b" type="number" id="line_b" value="{{ $logselectd->line_b or ''}}" >
    {!! $errors->first('line_b', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('line_classify') ? 'has-error' : ''}}">
    <label for="line_classify" class="control-label">{{ 'เปิดไลน์คัด' }}</label>
    <input class="form-control" name="line_classify" type="number" readonly id="line_classify" value="{{ $logselectd->line_classify or ''}}" >
    {!! $errors->first('line_classify', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('line_classify_unit') ? 'has-error' : ''}}">
    <label for="line_classify_unit" class="control-label">{{ '&nbsp;' }}</label>
    <select name="line_classify_unit" class="form-control calLine" id="line_classify_unit" >
    @foreach ($unitlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logselectd->line_classify_unit) && $logselectd->line_classify_unit == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('line_classify_unit', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('grade') ? 'has-error' : ''}}">
    <label for="grade" class="control-label">{{ 'เกรด' }}</label>
    <select name="grade" class="form-control" id="shift_id" >
    @foreach ($gradelist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logselectd->grade) && $logselectd->grade == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('grade', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-9 {{ $errors->has('ref_note') ? 'has-error' : ''}}">
    <label for="ref_note" class="control-label">{{ 'SAP REF' }}</label>
    <input required class="form-control" name="ref_note" type="numtextber" id="ref_note" value="{{ $logselectd->ref_note or ''}}" >
    {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
</div>

    <div class="form-group col-md-6 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note' }}</label>
        <input class="form-control" name="note" type="text" id="note" value="{{ $logselectd->note or '' }}" >
        <input type='hidden' name='log_select_m_id' id='log_select_m_id' value='{{ $logselectm->id }}' >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-6 {{ $errors->has('problem') ? 'has-error' : ''}}">
        <label for="problem" class="control-label">{{ 'ปัญหาที่พบ' }}</label>
        <input class="form-control" name="problem"  id="problem" value="{{ $logselectd->problem or '' }}" >
        {!! $errors->first('problem', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
