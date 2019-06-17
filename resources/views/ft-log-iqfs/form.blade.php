<div class="row">
    <div class="form-group col-md-4 {{ $errors->has('process_date') ? 'has-error' : ''}}">
        <label for="process_date" class="control-label">{{ 'วันผลิต' }}</label>
        <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $ftlogiqf->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
        {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('timeslot_id') ? 'has-error' : ''}}">
        <label for="timeslot_id" class="control-label">{{ 'เวลา' }}</label>
        <select name="timeslot_id" class="form-control dynamic" id="timeslot_id" data-dependent = 'shift_id' required>
            <option value="">-</option>
        @foreach ($timeslotlist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($ftlogiqf->timeslot_id) && $ftlogiqf->timeslot_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('timeslot_id', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('shift_id') ? 'has-error' : ''}}">
        <label for="shift_id" class="control-label">{{ 'กะ' }}</label>
        <input type="hidden" name="shift_id" id="shift_id" value="{{  $ftlogiqf->shift_id or '' }}" />
        <input class="form-control" name="shift_id_show" type="text" readonly id="shift_id_show" value="{{ $ftlogiqf->shift->name or ''}}" >
        {!! $errors->first('shift_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4 {{ $errors->has('workhours') ? 'has-error' : ''}}">
        <label required for="workhours" class="control-label">{{ 'จำนวนชม' }}</label>
        <input class="form-control" name="workhours" type="text" id="workhours" value="{{ $ftlogiqf->workhours or ''}}" >
        {!! $errors->first('workhours', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('mechine_id') ? 'has-error' : ''}}">
        <label for="mechine_id" class="control-label">{{ 'เครื่อง' }}</label>
        <select name="mechine_id" class="form-control" id="mechine_id" >
        @foreach ($mechinelist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($ftlogiqf->product_id) && $ftlogiqf->product_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('mechine_id', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('iqf_job_id') ? 'has-error' : ''}}">
        <label for="iqf_job_id" class="control-label">{{ 'งาน' }}</label>
        <select name="iqf_job_id" class="form-control" id="iqf_job_id" >
        @foreach ($iqfjoblist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($ftlogiqf->product_id) && $ftlogiqf->product_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('iqf_job_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4 {{ $errors->has('input_kg') ? 'has-error' : ''}}">
        <label for="input_kg" class="control-label">{{ 'Input/kgs' }}</label>
        <input required class="form-control" name="input_kg" type="number" id="input_kg" value="{{ $ftlogiqf->input_kg or ''}}" >
        {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('output_kg') ? 'has-error' : ''}}">
        <label for="output_kg" class="control-label">{{ 'Output/kg.' }}</label>
        <input required class="form-control" name="output_kg" type="number" id="output_kg" value="{{ $ftlogiqf->output_kg or ''}}" >
        {!! $errors->first('output_kg', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('num_man') ? 'has-error' : ''}}">
        <label required for="num_man" class="control-label">{{ 'จำนวนคน' }}</label>
        <input class="form-control" name="num_man" type="number" id="num_man" value="{{ $ftlogiqf->num_man or ''}}" >
        {!! $errors->first('num_man', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="row">

<div class="form-group col-md-4 {{ $errors->has('sum_kg') ? 'has-error' : ''}}">
    <label for="sum_kg" class="control-label">{{ 'คัดได้สะสม' }}</label>
    <input required class="form-control" name="sum_kg" type="number" id="sum_kg" value="{{ $ft_log->sum_kg or '0'}}" >
    {!! $errors->first('sum_kg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('yeild_percent') ? 'has-error' : ''}}">
    <label for="yeild_percent" class="control-label">{{ '% yeild' }}</label>
    <input class="form-control" name="yeild_percent" type="text" readonly id="yeild_percent" value="{{ $ft_log->yeild_percent or ''}}" >
    {!! $errors->first('yeild_percent', '<p class="help-block">:message</p>') !!}
</div>
</div>
<div class="row">

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