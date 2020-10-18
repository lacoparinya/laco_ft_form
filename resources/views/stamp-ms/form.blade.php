    <div class="form-group col-md-2 {{ $errors->has('process_date') ? 'has-error' : ''}}">
        <label for="process_date" class="control-label">{{ 'Process Date' }}</label>
        <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $stampm->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
        {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-2 {{ $errors->has('shift_id') ? 'has-error' : ''}}">
        <label for="shift_id" class="control-label">{{ 'กะ' }}</label>
        <select name="shift_id" class="form-control dynamic" id="shift_id" required>
            <option value="">-</option>
        @foreach ($shiftlist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($stampm->shift_id) && $stampm->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('mat_pack_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-3 {{ $errors->has('mat_pack_id') ? 'has-error' : ''}}">
        <label for="mat_pack_id" class="control-label">{{ 'ผลิตภัณฑ์' }}</label>
        <select name="mat_pack_id" class="form-control dynamic" id="mat_pack_id" required>
            <option value="">-</option>
        @foreach ($matpacklist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($stampm->mat_pack_id) && $stampm->mat_pack_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('mat_pack_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-3 {{ $errors->has('stamp_machine_id') ? 'has-error' : ''}}">
        <label for="stamp_machine_id" class="control-label">{{ 'เครื่อง' }}</label>
        <select name="stamp_machine_id" class="form-control dynamic" id="stamp_machine_id" required>
            <option value="">-</option>
        @foreach ($stampmachinelist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($stampm->stamp_machine_id) && $stampm->stamp_machine_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('stamp_machine_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-2 {{ $errors->has('rateperhr') ? 'has-error' : ''}}">
        <label for="rateperhr" class="control-label">{{ 'Rate per Hr'}}</label>
        <input class="form-control" name="rateperhr"  id="rateperhr" value="{{ $stampm->rateperhr or '' }}" >
        {!! $errors->first('rateperhr', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-3 {{ $errors->has('order_no') ? 'has-error' : ''}}">
        <label for="order_no" class="control-label">{{ 'Order No'}}</label>
        <input class="form-control" name="order_no"  id="order_no" value="{{ $stampm->order_no or '' }}" >
        {!! $errors->first('order_no', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-3 {{ $errors->has('pack_date') ? 'has-error' : ''}}">
        <label for="pack_date" class="control-label">{{ 'Pack Date' }}</label>
        <input class="form-control" name="pack_date" type="date" id="pack_date" value="{{ $stampm->pack_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
        {!! $errors->first('pack_date', '<p class="help-block">:message</p>') !!}
    </div>

    

    <div class="form-group col-md-3 {{ $errors->has('staff_target') ? 'has-error' : ''}}">
        <label for="staff_target" class="control-label">{{ 'เป้าพนักงาน' }}</label>
        <input class="form-control" name="staff_target"  id="staff_target" value="{{ $stampm->staff_target or '' }}" >
        {!! $errors->first('staff_target', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-3 {{ $errors->has('staff_operate') ? 'has-error' : ''}}">
        <label for="staff_operate" class="control-label">{{ 'พนักงานดูแล'}}</label>
        <input class="form-control" name="staff_operate"  id="staff_operate" value="{{ $stampm->staff_operate or '' }}" >
        {!! $errors->first('staff_operate', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-3 {{ $errors->has('staff_actual') ? 'has-error' : ''}}">
        <label for="staff_actual" class="control-label">{{ 'พนักงานจริง'}}</label>
        <input class="form-control" name="staff_actual"  id="staff_actual" value="{{ $stampm->staff_actual or '' }}" >
        {!! $errors->first('staff_actual', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-3 {{ $errors->has('status') ? 'has-error' : ''}}">
        <label for="status" class="control-label">{{ 'Status'}}</label>
        <input class="form-control" name="status"  id="status" value="{{ $stampm->status or 'Active' }}" >
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-6 {{ $errors->has('note') ? 'has-error' : ''}}">
        <label for="note" class="control-label">{{ 'Note'}}</label>
        <input class="form-control" name="note"  id="note" value="{{ $stampm->note or '' }}" >
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>


<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
