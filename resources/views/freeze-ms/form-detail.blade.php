<div class="row">
    <input name="freeze_m_id" type="hidden" id="freeze_m_id"  value={{ $freezem->id or '' }}  >
    <div class="form-group col-md-4 {{ $errors->has('process_datetime') ? 'has-error' : ''}}">
        <label for="process_datetime" class="control-label">{{ 'วัน-เวลา' }}</label>
        <input class="form-control" name="process_datetime" type="datetime-local" id="process_datetime" 
        value = "@php
            if(isset($freezed->process_datetime)){
                echo date('Y-m-d\TH:i',strtotime($freezed->process_datetime));
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
            <option value="{{ $optionKey }}" {{ (isset($freezed->shift_id) && $freezed->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('pre_prod_id', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('workhour') ? 'has-error' : ''}}">
        <label for="workhour" class="control-label">{{ 'เวลาทำงาน' }}</label>
        <input class="form-control" name="workhour"  id="workhour" value="{{ $freezed->workhour or '0' }}" >
        {!! $errors->first('workhour', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('iqf_job_id') ? 'has-error' : ''}}">
        <label for="iqf_job_id" class="control-label">{{ 'งาน' }}</label>
        <select name="iqf_job_id" class="form-control" id="iqf_job_id">
        @foreach ($iqfjoblist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($freezed->iqf_job_id) && $freezed->iqf_job_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
   @endforeach
    </select>
        {!! $errors->first('iqf_job_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    @php
        $str = "";
        $lp = 0;
    @endphp
    @foreach ($iqfmapcollist as $key=>$item)
    @php
        if($lp == 0){
            $str .= $item;
        }else{
            $str .= " , ".$item;
        }
        $lp++;
    @endphp
    <div class="form-group col-md-4 {{ $errors->has($key) ? 'has-error' : ''}}">
        <label for="{{ $key }}" class="control-label">{{ $item }}</label>
        <input class="form-control sumkg" name="{{ $key }}" id="{{ $key }}" value="{{ $freezed->$key or '0'}}" >
        {!! $errors->first($key , '<p class="help-block">:message</p>') !!}
    </div>
    @endforeach
    <div class="form-group col-md-4 {{ $errors->has('output_sum') ? 'has-error' : ''}}">
        <label for="output_sum" class="control-label">{{ 'รวม '.$str }}</label>
        <input required="required" class="form-control" name="output_sum" id="output_sum" value="{{ $freezed->output_sum or '0'}}" >
        {!! $errors->first('output_sum' , '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-4 {{ $errors->has('current_RM') ? 'has-error' : ''}}">
        @if(isset($freezed->id))
        <input name="remain"  id="remain" type='hidden' value="{{$freezem->start_RM + $freezed->output_sum - $freezeall}}" >
        @else
        <input name="remain"  id="remain" type='hidden' value="{{$freezem->start_RM - $freezeall}}" >
        @endif

        
        
        <label for="current_RM" class="control-label">{{ 'คงเหลือขณะนี้ (kg)' }}</label>
        <input class="form-control" name="current_RM"  id="current_RM" value="{{ $freezed->current_RM or '0' }}" >
        {!! $errors->first('current_RM', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-8 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note' }}</label>
        <input class="form-control" name="note"  id="note" value="{{ $freezem->note or '' }}" >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-8 {{ $errors->has('problem') ? 'has-error' : ''}}">
        <label for="problem" class="control-label">{{ 'ปัญหาที่พบ' }}</label>
        <input class="form-control" name="problem"  id="problem" value="{{ $freezed->problem or '' }}" >
        {!! $errors->first('problem', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('problem_img') ? 'has-error' : ''}}">
        <label for="problem_img" class="control-label">{{ 'ภาพปัญหาที่พบ' }}</label>
        {!! Form::file('problem_img', $attributes = ['accept'=>'image/jpeg , image/jpg, image/gif, image/png']); !!}   
        @if (isset($freezed->img_path))
            <a href="{{ url($freezed->img_path) }}" target="_blank"><img height="50px" src="{{ url($freezed->img_path) }}" ></a>            
        @endif          
    </div>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
