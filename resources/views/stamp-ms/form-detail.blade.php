<div class="row">
    <div class="form-group col-md-3 {{ $errors->has('process_datetime') ? 'has-error' : ''}}">
        <label for="process_datetime" class="control-label">{{ 'วัน-เวลา' }}</label>
        <input class="form-control" name="process_datetime" type="datetime-local" id="process_datetime" 
        value = "@php
            if(isset($stampd->process_datetime)){
                echo date('Y-m-d\TH:i',strtotime($stampd->process_datetime));
            }else{
                echo \Carbon\Carbon::now()->format('Y-m-d\TH:i');
            }
        @endphp" >
        {!! $errors->first('process_datetime', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group col-md-2 {{ $errors->has('workhours') ? 'has-error' : ''}}">
        <label for="workhours" class="control-label">{{ 'ชม.' }}</label>
        <input class="form-control" name="workhours" type="text" id="workhours" value="{{ $stampd->workhours or '1' }}" >
        {!! $errors->first('workhours', '<p class="help-block">:message</p>') !!}
    </div>
    
     <div class="form-group col-md-3 {{ $errors->has('output') ? 'has-error' : ''}}">
        <label for="output" class="control-label">{{ 'Output' }}</label>
        <input class="form-control" name="output" type="text" id="output" value="{{ $stampd->output or '0' }}" >
        {!! $errors->first('output', '<p class="help-block">:message</p>') !!}
    </div>
     <div class="form-group col-md-3 {{ $errors->has('outputSum') ? 'has-error' : ''}}">
        <label for="outputSum" class="control-label">{{ 'Sum Output' }}</label>
        <input class="form-control" name="outputSum" type="text" id="outputSum" value="{{ $stampd->outputSum or '0' }}" readonly>
        {!! $errors->first('outputSum', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-6 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note' }}</label>
        <input class="form-control" name="note" type="text" id="note" value="{{ $stampd->note or '' }}" >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-6 {{ $errors->has('problem') ? 'has-error' : ''}}">
        <label for="problem" class="control-label">{{ 'ปัญหาที่พบ' }}</label>
        <input class="form-control" name="problem"  id="problem" value="{{ $stampd->problem or '' }}" >
        {!! $errors->first('problem', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group col-md-6 {{ $errors->has('problem_img') ? 'has-error' : ''}}">
        <label for="problem_img" class="control-label">{{ 'ภาพปัญหาที่พบ' }}</label>
        {!! Form::file('problem_img', $attributes = ['accept'=>'image/jpeg , image/jpg, image/gif, image/png']); !!}   
        @if (isset($stampd->img_path))
            <a href="{{ url($stampd->img_path) }}" target="_blank"><img height="50px" src="{{ url($stampd->img_path) }}" ></a>            
        @endif
        <input name="stamp_m_id" type="hidden" id="stamp_m_id"  value={{ $stampd->stamp_m_id or $stampm->id }}  >
                
    </div>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
