<div class="row">
<div class="form-group col-md-3 {{ $errors->has('process_date') ? 'has-error' : ''}}">
        <label for="process_date" class="control-label">{{ 'Process Date' }}</label>
        <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $logpreparem->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
        {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('pre_prod_id') ? 'has-error' : ''}}">
        <label for="pre_prod_id" class="control-label">{{ 'ผลิตภัณฑ์' }}</label>
        <select name="pre_prod_id" class="form-control dynamic" id="pre_prod_id" required>
            <option value="">-</option>
        @foreach ($preprodlist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($logpreparem->pre_prod_id) && $logpreparem->pre_prod_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('pre_prod_id', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('targetperhr') ? 'has-error' : ''}}">
        <label for="targetperhr" class="control-label">{{ 'แผนการทำงานต่อชม.(kg/hr/คน)' }}</label>
        <input class="form-control" name="targetperhr" type="text" id="targetperhr" value="{{ $logpreparem->targetperhr or '1' }}" >
        {!! $errors->first('targetperhr', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('target_result') ? 'has-error' : ''}}">
        <label for="target_result" class="control-label">{{ 'เป้าที่ต้องผลิตได้ (kg)' }}</label>
        <input class="form-control" name="target_result" type="text" id="target_result" value="{{ $logpreparem->target_result or '1' }}" >
        {!! $errors->first('target_result', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('target_workhours') ? 'has-error' : ''}}">
        <label for="target_workhours" class="control-label">{{ 'เป้าชม.ที่ใช้ผลิตเสร็จ (hrs)' }}</label>
        <input class="form-control" name="target_workhours" type="text" id="target_workhours" value="{{ $logpreparem->target_workhours or '1' }}" >
        {!! $errors->first('target_workhours', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group col-md-2 {{ $errors->has('staff_target') ? 'has-error' : ''}}">
        <label for="staff_target" class="control-label">{{ 'เป้าจำนวนคน' }}</label>
        <input class="form-control" name="staff_target"  id="staff_target" type="number" value="{{ $logpreparem->staff_target or '0' }}" >
        {!! $errors->first('staff_target', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('staff_operate') ? 'has-error' : ''}}">
        <label for="staff_operate" class="control-label">{{ 'พนักงานผู้ดูแล'}}</label>
        <input class="form-control" name="staff_operate"  id="staff_operate" value="{{ $logpreparem->staff_operate or '' }}" >
        {!! $errors->first('target_hr', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('staff_pf') ? 'has-error' : ''}}">
        <label for="staff_pf" class="control-label">{{ 'พนักงาน PF' }}</label>
        <input class="form-control" name="staff_pf"  id="staff_pf" type="number" value="{{ $logpreparem->staff_pf or '0' }}" >
        {!! $errors->first('staff_pf', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('staff_pk') ? 'has-error' : ''}}">
        <label for="staff_pk" class="control-label">{{ 'พนักงานช่วยจาก PK' }}</label>
        <input class="form-control" name="staff_pk"  id="staff_pk" type="number" value="{{ $logpreparem->staff_pk or '0' }}" >
        {!! $errors->first('staff_pk', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('staff_pst') ? 'has-error' : ''}}">
        <label for="staff_pst" class="control-label">{{ 'พนักงานช่วยจาก PST' }}</label>
        <input class="form-control" name="staff_pst"  id="staff_pst" type="number" value="{{ $logpreparem->staff_pst or '0' }}" >
        {!! $errors->first('staff_pst', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note' }}</label>
        <input class="form-control" name="note" type="text" id="note" value="{{ $logpreparem->note or '' }}" >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
