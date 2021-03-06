<div class="form-group col-md-4 {{ $errors->has('process_date') ? 'has-error' : ''}}">
    <label for="process_date" class="control-label">{{ 'วันผลิต' }}</label>
    <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $logselectm->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('shift_id') ? 'has-error' : ''}}">
    <label for="shift_id" class="control-label">{{ 'Shift' }}</label>
    <select name="shift_id" class="form-control" id="product_id" >
    @foreach ($shiftlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logselectm->shift_id) && $logselectm->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('shift_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'คัดผลิตภัณท์' }}</label>
    <select name="product_id" class="form-control" id="product_id" >
    @foreach ($productlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logselectm->product_id) && $logselectm->product_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('hourperday') ? 'has-error' : ''}}">
    <label for="hourperday" class="control-label">{{ 'จำนวนชม.ที่ใช้ในการผลิต' }}</label>
    <input required class="form-control" name="hourperday" type="number" id="hourperday" value="{{ $logselectm->hourperday or ''}}" >
    {!! $errors->first('hourperday', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('targetperday') ? 'has-error' : ''}}">
    <label for="targetperday" class="control-label">{{ 'จำนวนสินค้าที่ต้องผลิต' }}</label>
    <input required class="form-control" name="targetperday" type="number" id="targetperday" value="{{ $logselectm->targetperday or ''}}" >
    {!! $errors->first('targetperday', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('targetperhr') ? 'has-error' : ''}}">
    <label for="targetperhr" class="control-label">{{ 'เป้าต่อชม (kgs/hr)' }}</label>
    <input required class="form-control" name="targetperhr" type="number" id="targetperhr" value="{{ $logselectm->targetperhr or ''}}" >
    {!! $errors->first('targetperhr', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('planline') ? 'has-error' : ''}}">
    <label for="planline" class="control-label">{{ 'จำนวน Line ที่เปิด' }}</label>
    <input required class="form-control" name="planline" type="number" id="planline" value="{{ $logselectm->planline or ''}}" >
    {!! $errors->first('planline', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('ref_note') ? 'has-error' : ''}}">
    <label for="ref_note" class="control-label">{{ 'SAP REF' }}</label>
    <input required class="form-control" name="ref_note" type="text" id="ref_note" value="{{ $logselectm->ref_note or ''}}" >
    {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('staff_target') ? 'has-error' : ''}}">
    <label for="staff_target" class="control-label">{{ 'เป้าพนักงาน' }}</label>
    <input required class="form-control" name="staff_target" type="number" id="staff_target" value="{{ $logselectm->staff_target or ''}}" >
    {!! $errors->first('staff_target', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('staff_operate') ? 'has-error' : ''}}">
    <label for="staff_operate" class="control-label">{{ 'Staff ผู้ดูแล' }}</label>
    <input required class="form-control" name="staff_operate" type="text" id="staff_operate" value="{{ $logselectm->staff_operate or ''}}" >
    {!! $errors->first('staff_operate', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <textarea class="form-control" rows="5" name="note" type="textarea" id="note" >{{ $logselectm->note or ''}}</textarea>
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
