<div class="row">
    <div class="form-group col-md-3 {{ $errors->has('process_datetime') ? 'has-error' : ''}}">
        <label for="process_datetime" class="control-label">{{ 'วัน-เวลา' }}</label>
        <input class="form-control" name="process_datetime" type="datetime-local" id="process_datetime" 
        value = "@php
            if(isset($logprepared->process_datetime)){
                echo date('Y-m-d\TH:i',strtotime($logprepared->process_datetime));
            }else{
                echo \Carbon\Carbon::now()->format('Y-m-d\TH:i');
            }
        @endphp" >
        {!! $errors->first('process_datetime', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-1 {{ $errors->has('shift_id') ? 'has-error' : ''}}">
        <label for="shift_id" class="control-label">{{ 'กะ' }}</label>
        <select name="shift_id" class="form-control dynamic" id="shift_id" required>
            <option value="">-</option>
        @foreach ($shiftlist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($logprepared->shift_id) && $logprepared->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('pre_prod_id', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group col-md-4 {{ $errors->has('pre_prod_id') ? 'has-error' : ''}}">
        <input name="log_prepare_m_id" type="hidden" id="freeze_m_id"  value={{ $logprepared->log_prepare_m_id or $logpreparem->id }}  >
        <label for="pre_prod_id" class="control-label">{{ 'ผลิตภัณฑ์' }}</label>
        <select name="pre_prod_id" class="form-control dynamic" id="pre_prod_id" required>
            <option value="">-</option>
        @foreach ($preprodlist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ 
                (isset($logprepared->pre_prod_id) && $logprepared->pre_prod_id == $optionKey) ? 'selected' : 
                (isset($logpreparem->pre_prod_id) && $logpreparem->pre_prod_id == $optionKey) ? 'selected' : ''
            }}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('pre_prod_id', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('workhours') ? 'has-error' : ''}}">
        <label for="workhours" class="control-label">{{ 'ชม.' }}</label>
        <input class="form-control" name="workhours" type="text" id="workhours" value="{{ $logprepared->workhours or '1' }}" >
        {!! $errors->first('workhours', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('targets') ? 'has-error' : ''}}">
        <label for="targets" class="control-label">{{ 'Target' }}</label>
        <input class="form-control" name="targets" type="text" id="targets" value="{{ $logprepared->targets or '1' }}" >
        {!! $errors->first('targets', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group col-md-3 {{ $errors->has('input') ? 'has-error' : ''}}">
        <label for="input" class="control-label">{{ 'Input' }}</label>
        <input class="form-control" name="input" type="text" id="input" value="{{ $logprepared->input or '0' }}" >
        {!! $errors->first('input', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-3 {{ $errors->has('output') ? 'has-error' : ''}}">
        <label for="output" class="control-label">{{ 'Output' }}</label>
        <input class="form-control" name="output" type="text" id="output" value="{{ $logprepared->output or '0' }}" >
        {!! $errors->first('output', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('input_sum') ? 'has-error' : ''}}">
        <label for="input_sum" class="control-label">{{ 'Sum Input' }}</label>
        <input class="form-control" name="input_sum" type="text" id="input_sum" value="{{ $logprepared->input_sum or '0' }}" readonly>
        {!! $errors->first('input_sum', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-3 {{ $errors->has('output_sum') ? 'has-error' : ''}}">
        <label for="output_sum" class="control-label">{{ 'Sum Output' }}</label>
        <input class="form-control" name="output_sum" type="text" id="output_sum" value="{{ $logprepared->output_sum or '0' }}" readonly>
        {!! $errors->first('output_sum', '<p class="help-block">:message</p>') !!}
    </div>


    <div class="form-group col-md-2 {{ $errors->has('num_pre') ? 'has-error' : ''}}">
        <label for="num_pre" class="control-label">{{ 'จำนวนเตรียมการ' }}</label>
        <input class="form-control" name="num_pre" type="text" id="num_pre" value="{{ $logprepared->num_pre or '0' }}" >
        {!! $errors->first('num_pre', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-2 {{ $errors->has('num_iqf') ? 'has-error' : ''}}">
        <label for="num_iqf" class="control-label">{{ 'จำนวน IQF/F' }}</label>
        <input class="form-control" name="num_iqf" type="text" id="num_iqf" value="{{ $logprepared->num_iqf or '0' }}" >
        {!! $errors->first('num_iqf', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('num_all') ? 'has-error' : ''}}">
        <label for="num_all" class="control-label">{{ 'จำนวนรวม' }}</label>
        <input class="form-control" name="num_all" type="number" id="num_all" value="{{ $logprepared->num_all or '0' }}" readonly>
        {!! $errors->first('num_all', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-6 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note' }}</label>
        <input class="form-control" name="note" type="text" id="note" value="{{ $logprepared->note or '' }}" >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-6 {{ $errors->has('problem') ? 'has-error' : ''}}">
        <label for="problem" class="control-label">{{ 'ปัญหาที่พบ' }}</label>
        <input class="form-control" name="problem"  id="problem" value="{{ $logprepared->problem or '' }}" >
        {!! $errors->first('problem', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group col-md-6 {{ $errors->has('problem_img') ? 'has-error' : ''}}">
        <label for="problem_img" class="control-label">{{ 'ภาพปัญหาที่พบ' }}</label>
        {!! Form::file('problem_img', $attributes = ['accept'=>'image/jpeg , image/jpg, image/gif, image/png']); !!}   
        @if (isset($logprepared->img_path))
            <a href="{{ url($logprepared->img_path) }}" target="_blank"><img height="50px" src="{{ url($logprepared->img_path) }}" ></a>            
        @endif          
    </div>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
