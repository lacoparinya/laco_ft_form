<div class="row">
    <div class="form-group col-md-3 {{ $errors->has('process_datetime') ? 'has-error' : ''}}">
        <label for="process_datetime" class="control-label">{{ 'วัน-เวลา' }}</label>
        <input class="form-control" name="process_datetime" type="datetime-local" id="process_datetime" 
        value = "@php
            if(isset($logpstselectd->process_datetime)){
                echo date('Y-m-d\TH:i',strtotime($logpstselectd->process_datetime));
            }else{
                echo \Carbon\Carbon::now()->format('Y-m-d\TH:i');
            }
        @endphp" >
        {!! $errors->first('process_datetime', '<p class="help-block">:message</p>') !!}
    </div>
    
   
    <div class="form-group col-md-3 {{ $errors->has('workhours') ? 'has-error' : ''}}">
        <label for="workhours" class="control-label">{{ 'ชม.' }}</label>
        <input class="form-control" name="workhours" type="text" id="workhours" value="{{ $logpstselectd->workhours or '1' }}" >
        {!! $errors->first('workhours', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group col-md-3 {{ $errors->has('input_kg') ? 'has-error' : ''}}">
        <label for="input_kg" class="control-label">{{ 'Input (kg)' }}</label>
        <input class="form-control calpercent" name="input_kg" type="text" id="input_kg" value="{{ $logpstselectd->input_kg or '0' }}" >
        {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-3 {{ $errors->has('output_kg') ? 'has-error' : ''}}">
        <label for="output_kg" class="control-label">{{ 'Output (kg)' }}</label>
        <input class="form-control calpercent calpack" name="output_kg" type="text" id="output_kg" value="{{ $logpstselectd->output_kg or '0' }}" >
        {!! $errors->first('output_kg', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3">
    </div>
    <div class="form-group col-md-3 {{ $errors->has('yeild_percent') ? 'has-error' : ''}}">
    <label for="yeild_percent" class="control-label">{{ 'Yeild %' }}</label>
    <input class="form-control" name="yeild_percent" type="text" readonly id="yeild_percent" value="{{ $logpstselectd->yeild_percent or ''}}" >
    {!! $errors->first('yeild_percent', '<p class="help-block">:message</p>') !!}
</div>
    <div class="form-group col-md-3 {{ $errors->has('sum_in_kg') ? 'has-error' : ''}}">
        <label for="sum_in_kg" class="control-label">{{ 'รวม Input (kg)' }}</label>
        <input class="form-control" name="sum_in_kg" type="text" id="sum_in_kg" value="{{ $logpstselectd->sum_in_kg or '0' }}" readonly>
        {!! $errors->first('sum_in_kg', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-3 {{ $errors->has('sum_kg') ? 'has-error' : ''}}">
        <label for="sum_kg" class="control-label">{{ 'รวม Output (kg)' }}</label>
        <input class="form-control" name="sum_kg" type="text" id="sum_kg" value="{{ $logpstselectd->sum_kg or '0' }}" readonly>
        {!! $errors->first('sum_kg', '<p class="help-block">:message</p>') !!}
    </div>
    
<div class="form-group col-md-3 {{ $errors->has('num_classify') ? 'has-error' : ''}}">
    <label for="num_classify" class="control-label">{{ 'จำนวนคน' }}</label>
    <input class="form-control" name="num_classify" type="number" id="num_classify" value="{{ $logpstselectd->num_classify or ''}}" >
    {!! $errors->first('num_classify', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('grade') ? 'has-error' : ''}}">
    <label for="grade" class="control-label">{{ 'เกรด' }}</label>
    <select name="grade" class="form-control" id="shift_id" >
    @foreach ($gradelist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logpstselectd->grade) && $logpstselectd->grade == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('grade', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('ref_note') ? 'has-error' : ''}}">
    <label for="ref_note" class="control-label">{{ 'SAP REF' }}</label>
    <input required class="form-control" name="ref_note" type="numtextber" id="ref_note" value="{{ $logpstselectd->ref_note or ''}}" >
    {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
</div>

    <div class="form-group col-md-6 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note' }}</label>
        <input class="form-control" name="note" type="text" id="note" value="{{ $logpstselectd->note or '' }}" >
        <input type='hidden' name='log_pst_select_m_id' id='log_pst_select_m_id' value='{{ $logpstselectm->id }}' >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-6 {{ $errors->has('problem') ? 'has-error' : ''}}">
        <label for="problem" class="control-label">{{ 'ปัญหาที่พบ' }}</label>
        <input class="form-control" name="problem"  id="problem" value="{{ $logpstselectd->problem or '' }}" >
        {!! $errors->first('problem', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
