<div class="form-group col-md-4  {{ $errors->has('iqf_job_id') ? 'has-error' : ''}}">
    <label for="iqf_job_id" class="control-label">{{ 'งาน' }}</label>
    <select name="iqf_job_id" class="form-control" id="iqf_job_id" required>
        <option value="">-</option>
    @foreach ($iqfjoblist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($stdiqf->iqf_job_id) && $stdiqf->iqf_job_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('iqf_job_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4  {{ $errors->has('mechine_id') ? 'has-error' : ''}}">
    <label for="mechine_id" class="control-label">{{ 'เครื่อง' }}</label>
    <select name="mechine_id" class="form-control" id="mechine_id" required>
        <option value="">-</option>
    @foreach ($mechinelist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($stdiqf->mechine_id) && $stdiqf->mechine_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('mechine_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group  col-md-4 {{ $errors->has('std_productivity_person') ? 'has-error' : ''}}">
    <label for="std_productivity_person" class="control-label">{{ 'Target per Person' }}</label>
    <input class="form-control" name="std_productivity_person" type="text" id="std_productivity_person" value="{{ $stdiqf->std_productivity_person or ''}}" >
    {!! $errors->first('std_productivity_person', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group  col-md-12 {{ $errors->has('desc') ? 'has-error' : ''}}">
    <label for="desc" class="control-label">{{ 'Desc' }}</label>
    <input class="form-control" name="desc" type="text" id="std_productivity_person" value="{{ $stdiqf->desc or ''}}" >
    {!! $errors->first('desc', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
