<div class="row">
    <div class="form-group col-md-4 {{ $errors->has('process_date') ? 'has-error' : ''}}">
        <label for="process_date" class="control-label">{{ 'วันผลิต' }}</label>
        <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $freezem->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
        {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('targets') ? 'has-error' : ''}}">
        <label for="targets" class="control-label">{{ 'Target (kg/hr/person)' }}</label>
        <input class="form-control" name="targets"  id="targets" value="{{ $freezem->targets or '0' }}" >
        {!! $errors->first('targets', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-4 {{ $errors->has('iqf_job_id') ? 'has-error' : ''}}">
        <label for="iqf_job_id" class="control-label">{{ 'งาน' }}</label>
        <select name="iqf_job_id" class="form-control" id="iqf_job_id">
        @foreach ($iqfjoblist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($freezem->iqf_job_id) && $freezem->iqf_job_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
   @endforeach
    </select>
        {!! $errors->first('iqf_job_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4 {{ $errors->has('start_RM') ? 'has-error' : ''}}">
        <label for="start_RM" class="control-label">{{ 'รับเข้า (kg)' }}</label>
        <input class="form-control" name="start_RM"  id="start_RM" value="{{ $freezem->start_RM or '0' }}" >
        {!! $errors->first('start_RM', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('target_hr') ? 'has-error' : ''}}">
        <label for="target_hr" class="control-label">{{ 'เป้าจำนวน ชม.' }}</label>
        <input class="form-control" name="target_hr"  id="target_hr" value="{{ $freezem->target_hr or '0' }}" >
        {!! $errors->first('target_hr', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-6 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note' }}</label>
        <input class="form-control" name="note"  id="note" value="{{ $freezem->note or '' }}" >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
