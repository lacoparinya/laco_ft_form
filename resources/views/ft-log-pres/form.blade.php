<div class="row">
    <div class="form-group col-md-3 {{ $errors->has('process_date') ? 'has-error' : ''}}">
        <label for="process_date" class="control-label">{{ 'Process Date' }}</label>
        <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $ftlogpre->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
        {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('process_time') ? 'has-error' : ''}}">
        <label for="process_time" class="control-label">{{ 'วันผลิต' }}</label>
        @php
            if(isset($ftlogpre)){
                $timeval = substr($ftlogpre->process_time,0,5);
            }
        @endphp
        <input class="form-control" name="process_time" type="time" step="900" id="process_time" value="{{ $timeval or \Carbon\Carbon::now()->format('H:00') }}" >
        {!! $errors->first('process_time', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('shift_id') ? 'has-error' : ''}}">
        <label for="shift_id" class="control-label">{{ 'Shift' }}</label>
        <select name="shift_id" class="form-control dynamic" id="shift_id" required>
            <option value="">-</option>
        @foreach ($shiftlist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($ftlogpre->shift_id) && $ftlogpre->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('shift_id', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('workhours') ? 'has-error' : ''}}">
        <label for="workhours" class="control-label">{{ 'จำนวน ชม.' }}</label>
        <input class="form-control" name="workhours" type="text" id="workhours" value="{{ $ftlogpre->workhours or '1' }}" >
        {!! $errors->first('workhours', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-3 {{ $errors->has('targets') ? 'has-error' : ''}}">
        <label for="targets" class="control-label">{{ 'Target' }}</label>
        <input class="form-control" name="targets" type="text" id="targets" value="{{ $ftlogpre->targets or '1' }}" >
        {!! $errors->first('targets', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('pre_prod_id') ? 'has-error' : ''}}">
        <label for="pre_prod_id" class="control-label">{{ 'ผลิตภัณฑ์' }}</label>
        <select name="pre_prod_id" class="form-control dynamic" id="pre_prod_id" required>
            <option value="">-</option>
        @foreach ($preprodlist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($ftlogpre->pre_prod_id) && $ftlogpre->pre_prod_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('pre_prod_id', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('input') ? 'has-error' : ''}}">
        <label for="input" class="control-label">{{ 'Input' }}</label>
        <input class="form-control" name="input" type="number" id="input" value="{{ $ftlogpre->input or '0' }}" >
        {!! $errors->first('input', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('output') ? 'has-error' : ''}}">
        <label for="output" class="control-label">{{ 'Output' }}</label>
        <input class="form-control" name="output" type="number" id="output" value="{{ $ftlogpre->output or '0' }}" >
        {!! $errors->first('output', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-2 {{ $errors->has('num_pre') ? 'has-error' : ''}}">
        <label for="num_pre" class="control-label">{{ 'จำนวนเตรียมการ' }}</label>
        <input class="form-control" name="num_pre" type="number" id="num_pre" value="{{ $ftlogpre->num_pre or '0' }}" >
        {!! $errors->first('num_pre', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('num_iqf') ? 'has-error' : ''}}">
        <label for="num_iqf" class="control-label">{{ 'จำนวน IQF/F' }}</label>
        <input class="form-control" name="num_iqf" type="number" id="num_iqf" value="{{ $ftlogpre->num_iqf or '0' }}" >
        {!! $errors->first('num_iqf', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('num_all') ? 'has-error' : ''}}">
        <label for="num_all" class="control-label">{{ 'จำนวนรวม' }}</label>
        <input class="form-control" name="num_all" type="number" id="num_all" value="{{ $ftlogpre->num_all or '0' }}" readonly>
        {!! $errors->first('num_all', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('input_sum') ? 'has-error' : ''}}">
        <label for="input_sum" class="control-label">{{ 'Sum Input' }}</label>
        <input class="form-control" name="input_sum" type="number" id="input_sum" value="{{ $ftlogpre->input_sum or '0' }}" readonly>
        {!! $errors->first('input_sum', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('output_sum') ? 'has-error' : ''}}">
        <label for="output_sum" class="control-label">{{ 'Sum Output' }}</label>
        <input class="form-control" name="output_sum" type="number" id="output_sum" value="{{ $ftlogpre->output_sum or '0' }}" readonly>
        {!! $errors->first('output_sum', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note' }}</label>
        <input class="form-control" name="note" type="text" id="note" value="{{ $ftlogpre->note or '' }}" >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
