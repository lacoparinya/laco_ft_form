<div class="row">
    <div class="form-group col-md-3 {{ $errors->has('process_date') ? 'has-error' : ''}}">
        <label for="process_date" class="control-label">{{ 'วันผลิต' }}</label>
        <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $ftlogfreeze->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
        {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('process_time') ? 'has-error' : ''}}">
        <label for="process_time" class="control-label">{{ 'วันผลิต' }}</label>
        <input class="form-control" name="process_time" type="time" step="900" id="process_time" value="{{ $ftlogfreeze->process_time or \Carbon\Carbon::now()->format('H:00') }}" >
        {!! $errors->first('process_time', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('targets') ? 'has-error' : ''}}">
        <label for="targets" class="control-label">{{ 'Target' }}</label>
        <input class="form-control" name="targets"  id="targets" value="{{ $ftlogfreeze->targets or '0' }}" >
        {!! $errors->first('targets', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('workhours') ? 'has-error' : ''}}">
        <label for="workhours" class="control-label">{{ 'Working Time (ชม.)' }}</label>
        <input class="form-control" name="workhours"  id="workhours" value="{{ $ftlogfreeze->manhours or '1' }}" >
        {!! $errors->first('workhours', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class='row'>
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
        <input class="form-control sumkg" name="{{ $key }}" id="{{ $key }}" value="{{ $ftlogfreeze->$key or '0'}}" >
        {!! $errors->first($key , '<p class="help-block">:message</p>') !!}
    </div>
    @endforeach
    <div class="form-group col-md-4 {{ $errors->has('output_sum') ? 'has-error' : ''}}">
        <label for="output_sum" class="control-label">{{ 'รวม '.$str }}</label>
        <input class="form-control" name="output_sum" id="output_sum" value="{{ $ftlogfreeze->output_sum or '0'}}" >
        {!! $errors->first('output_sum' , '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class='row'>
    <div class="form-group col-md-4 {{ $errors->has('output_all_sum') ? 'has-error' : ''}}">
        <label for="output_all_sum" class="control-label">{{ 'สะสม' }}</label>
    <input name="prev_output_all_sum" type='hidden' id="prev_output_all_sum" value="{{ $prevftlogfreeze->output_all_sum or '0' }}" >
        <input readonly class="form-control" name="output_all_sum" id="output_all_sum" value="{{ $ftlogfreeze->output_all_sum or '0'}}" >
        {!! $errors->first('output_all_sum' , '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('current_RM') ? 'has-error' : ''}}">
        <label for="current_RM" class="control-label">{{ 'ปริมาณ RM คงเหลือ' }}</label>
        <input readonly class="form-control" name="current_RM" id="current_RM" value="{{ $ftlogfreeze->current_RM or '0'}}" >
        {!! $errors->first('current_RM' , '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('iqf_job_id') ? 'has-error' : ''}}">
        <label for="iqf_job_id" class="control-label">{{ 'งาน' }}</label>
        <select name="iqf_job_id" class="form-control" id="iqf_job_id" >
        @foreach ($iqfjoblist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($ftlogfreeze->product_id) && $ftlogfreeze->product_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('iqf_job_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class='row'>
    
    <div class="form-group col-md-4 {{ $errors->has('prev_current_RM') ? 'has-error' : ''}}">
        <label for="prev_current_RM" class="control-label">{{ 'ปริมาณ RM คงค้าง' }}</label>
        <input readonly class="form-control" name="prev_current_RM" id="prev_current_RM" value="{{ $prevftlogfreeze->current_RM or '0'}}" >
        {!! $errors->first('prev_current_RM' , '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('start_RM') ? 'has-error' : ''}}">
        <label for="start_RM" class="control-label">{{ 'ปริมาณ RM เริ่มต้น' }}</label>
        @if (isset($prevftlogfreeze))
            @if ($prevftlogfreeze->current_RM > 0)
                <input readonly class="form-control" name="start_RM"  id="start_RM" value="{{ $prevftlogfreeze->start_RM or '0' }}" >
            @else
                <input readonly class="form-control" name="start_RM"  id="start_RM" value="{{  '0' }}" >
            @endif
        @else
        <input readonly class="form-control" name="start_RM"  id="start_RM" value="{{  '0' }}" >
        @endif

         {!! $errors->first('start_RM' , '<p class="help-block">:message</p>') !!}
    </div> 
    <div class="form-group col-md-4 {{ $errors->has('recv_RM') ? 'has-error' : ''}}">
        <label for="recv_RM" class="control-label">{{ 'ปริมาณ RM รับเข้า' }}</label>
        <input class="form-control" name="recv_RM" id="recv_RM" value="{{ $ftlogfreeze->recv_RM or '0'}}" >
        {!! $errors->first('recv_RM' , '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class='row'>
<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
</div>
