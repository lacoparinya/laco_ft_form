<div class="row">
    <div class="form-group col-md-3 {{ $errors->has('process_datetime') ? 'has-error' : ''}}">
        <label for="process_datetime" class="control-label">{{ 'วัน-เวลา' }}</label>
        <input class="form-control" name="process_datetime" type="datetime-local" id="process_datetime" 
        value = "@php
            if(isset($logpackd->process_datetime)){
                echo date('Y-m-d\TH:i',strtotime($logpackd->process_datetime));
            }else{
                echo \Carbon\Carbon::now()->format('Y-m-d\TH:i');
            }
        @endphp" >
        {!! $errors->first('process_datetime', '<p class="help-block">:message</p>') !!}
    </div>
    
   
    <div class="form-group col-md-3 {{ $errors->has('workhours') ? 'has-error' : ''}}">
        <label for="workhours" class="control-label">{{ 'ชม.' }}</label>
        <input class="form-control" name="workhours" type="text" id="workhours" value="{{ $logpackd->workhours or '1' }}" >
        {!! $errors->first('workhours', '<p class="help-block">:message</p>') !!}
    </div>
<div class="form-group col-md-3 {{ $errors->has('std_rate') ? 'has-error' : ''}}">
    <label for="std_rate" class="control-label">{{ 'STD Productivity' }}</label>
    <input class="form-control" name="std_rate" type="text" readonly id="std_rate" value="{{ $logpackm->stdpack->std_rate or ''}}" >
    {!! $errors->first('std_rate', '<p class="help-block">:message</p>') !!}
</div>
    
    <div class="form-group col-md-3 {{ $errors->has('input_kg') ? 'has-error' : ''}}">
        <label for="input_kg" class="control-label">{{ 'Input (kg)' }}</label>
        <input class="form-control sumkg" name="input_kg" type="text" id="input_kg" value="{{ $logpackd->input_kg or '0' }}" >
        {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-3 {{ $errors->has('output_kg') ? 'has-error' : ''}}">
        <label for="output_kg" class="control-label">{{ 'Output (kg)' }}</label>
        <input class="form-control sumkg calpack" name="output_kg" type="text" id="output_kg" value="{{ $logpackd->output_kg or '0' }}" >
        {!! $errors->first('output_kg', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('input_kg_sum') ? 'has-error' : ''}}">
        <label for="input_kg_sum" class="control-label">{{ 'รวม Input (kg)' }}</label>
        <input class="form-control" name="input_kg_sum" type="text" id="input_kg_sum" value="{{ $logpackd->input_kg_sum or '0' }}" readonly>
        {!! $errors->first('input_kg_sum', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-3 {{ $errors->has('output_kg_sum') ? 'has-error' : ''}}">
        <label for="output_kg_sum" class="control-label">{{ 'รวม Output (kg)' }}</label>
        <input class="form-control" name="output_kg_sum" type="text" id="output_kg_sum" value="{{ $logpackd->output_kg_sum or '0' }}" readonly>
        {!! $errors->first('output_kg_sum', '<p class="help-block">:message</p>') !!}
    </div>
 <div class="form-group col-md-3 {{ $errors->has('output_pack') ? 'has-error' : ''}}">
        <label for="output_pack" class="control-label">{{ 'Output (กล่อง หรือ EA)' }}</label>
        <input class="form-control" name="output_pack" type="text" id="output_pack" value="{{ $logpackd->output_pack or '0' }}" >
        {!! $errors->first('output_pack', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('output_pack_sum') ? 'has-error' : ''}}">
        <label for="output_pack_sum" class="control-label">{{ 'รวม Output (กล่อง หรือ EA)' }}</label>
        <input class="form-control" name="output_pack_sum" type="text" id="output_pack_sum" value="{{ $logpackd->output_pack_sum or '0' }}" readonly>
        {!! $errors->first('output_pack_sum', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-3 {{ $errors->has('num_pack') ? 'has-error' : ''}}">
        <label for="num_pack" class="control-label">{{ 'จำนวนคน' }}</label>
        <input class="form-control sumkg" name="num_pack" type="text" id="num_pack" value="{{ $logpackd->num_pack or '0' }}" >
        {!! $errors->first('num_pack', '<p class="help-block">:message</p>') !!}
    </div>

     <div class="form-group col-md-3 {{ $errors->has('productivity') ? 'has-error' : ''}}">
    <label for="productivity" class="control-label">{{ 'Productivity' }}</label>
    <input class="form-control" name="productivity" type="text" readonly id="productivity" value="{{ $logpackd->productivity or ''}}" >
    {!! $errors->first('productivity', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-3 {{ $errors->has('yeild_percent') ? 'has-error' : ''}}">
    <label for="yeild_percent" class="control-label">{{ 'Yeild %' }}</label>
    <input class="form-control" name="yeild_percent" type="text" readonly id="yeild_percent" value="{{ $logpackd->yeild_percent or ''}}" >
    {!! $errors->first('yeild_percent', '<p class="help-block">:message</p>') !!}
</div>
    <div class="form-group col-md-6 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note' }}</label>
        <input class="form-control" name="note" type="text" id="note" value="{{ $logpackd->note or '' }}" >
        <input type='hidden' name='kgsperpack' id='kgsperpack' value='{{ $logpackm->package->kgsperpack }}' >
        <input type='hidden' name='log_pack_m_id' id='log_pack_m_id' value='{{ $logpackm->id }}' >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group col-md-6 {{ $errors->has('problem') ? 'has-error' : ''}}">
        <label for="problem" class="control-label">{{ 'ปัญหาที่พบ' }}</label>
        <input class="form-control" name="problem"  id="problem" value="{{ $logpackd->problem or '' }}" >
        {!! $errors->first('problem', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
