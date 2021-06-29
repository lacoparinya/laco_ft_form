<div class="row">
    <div class="form-group col-md-4  {{ $errors->has('shift_id') ? 'has-error' : '' }}">
        <label for="shift_id" class="control-label">{{ 'กะ' }}</label>
        <select name="shift_id" class="form-control" id="package_id" required>
            <option value="">-</option>
            @foreach ($shiftlist as $optionKey => $optionValue)
                <option value="{{ $optionKey }}"
                    {{ isset($seeddropselect->shift_id) && $seeddropselect->shift_id == $optionKey ? 'selected' : '' }}>
                    {{ $optionValue }}</option>
            @endforeach
        </select>
        {!! $errors->first('shift_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-4 {{ $errors->has('check_date') ? 'has-error' : '' }}">
        <label for="check_date" class="control-label">{{ 'วันที่ตรวจสอบ' }}</label>
        <input required class="form-control" name="check_date" type="date" id="check_date"
            value="{{ $seeddropselect->check_date or \Carbon\Carbon::now()->format('Y-m-d') }}">
        {!! $errors->first('check_date', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-4 {{ $errors->has('material') ? 'has-error' : '' }}">
        <label for="material" class="control-label">{{ 'ประเภท' }}</label>
        <input class="form-control" name="material" type="text" id="material"
            value="{{ $seeddropselect->material or '' }}">
        {!! $errors->first('material', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-4 {{ $errors->has('input_w') ? 'has-error' : '' }}">
        <label for="input_w" class="control-label">{{ 'RM-Input (Kg)' }}</label>
        <input class="form-control" name="input_w" type="text" id="input_w"
            value="{{ $seeddropselect->input_w or '0' }}">
        {!! $errors->first('input_w', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-4 {{ $errors->has('output_w') ? 'has-error' : '' }}">
        <label for="output_w" class="control-label">{{ 'Output (Kg)' }}</label>
        <input class="form-control" name="output_w" type="text" id="output_w"
            value="{{ $seeddropselect->output_w or '' }}">
        {!! $errors->first('output_w', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="row">

<div class="form-group col-md-3 {{ $errors->has('incline_a') ? 'has-error' : '' }}">
    <label for="incline_a" class="control-label">Incline<br/>(Machine)</label>
    <input class="form-control" name="incline_a" type="text" id="incline_a" value="{{ $seeddropselect->incline_a or '0' }}">
    {!! $errors->first('incline_a', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-3 {{ $errors->has('incline_m') ? 'has-error' : '' }}">
    <label for="incline_m" class="control-label">Incline<br/>(Man)</label>
    <input class="form-control" name="incline_m" type="text" id="incline_m" value="{{ $seeddropselect->incline_m or '0' }}">
    {!! $errors->first('incline_m', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-3 {{ $errors->has('beltrecheck_a') ? 'has-error' : '' }}">
    <label for="beltrecheck_a" class="control-label">สายพานรับถั่วจากRecheck<br/>(Machine)</label>
    <input class="form-control" name="beltrecheck_a" type="text" id="beltrecheck_a" value="{{ $seeddropselect->beltrecheck_a or '0' }}">
    {!! $errors->first('beltrecheck_a', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-3 {{ $errors->has('beltrecheck_m') ? 'has-error' : '' }}">
    <label for="beltrecheck_m" class="control-label">สายพานรับถั่วจากRecheck<br/>(Man)</label>
    <input class="form-control" name="beltrecheck_m" type="text" id="beltrecheck_m" value="{{ $seeddropselect->beltrecheck_m or '0' }}">
    {!! $errors->first('beltrecheck_m', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-3 {{ $errors->has('beltautoweight_a') ? 'has-error' : '' }}">
    <label for="beltautoweight_a" class="control-label">สายพานลำเลียงถั่วเข้า Auto weight<br/>(Machine)</label>
    <input class="form-control" name="beltautoweight_a" type="text" id="beltautoweight_a" value="{{ $seeddropselect->beltautoweight_a or '0' }}">
    {!! $errors->first('beltautoweight_a', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-3 {{ $errors->has('beltautoweight_m') ? 'has-error' : '' }}">
    <label for="beltautoweight_m" class="control-label">สายพานลำเลียงถั่วเข้า Auto weight<br/>(Man)</label>
    <input class="form-control" name="beltautoweight_m" type="text" id="beltautoweight_m" value="{{ $seeddropselect->beltautoweight_m or '0' }}">
    {!! $errors->first('beltautoweight_m', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-3 {{ $errors->has('underbelt_a') ? 'has-error' : '' }}">
    <label for="underbelt_a" class="control-label">ใต้สายพานไลน์คัด "ของตกเกรด"<br/>(Machine)</label>
    <input class="form-control" name="underbelt_a" type="text" id="underbelt_a" value="{{ $seeddropselect->underbelt_a or '0' }}">
    {!! $errors->first('underbelt_a', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-3 {{ $errors->has('underbelt_m') ? 'has-error' : '' }}">
    <label for="underbelt_m" class="control-label">ใต้สายพานไลน์คัด "ของตกเกรด"<br/>(Man)</label>
    <input class="form-control" name="underbelt_m" type="text" id="underbelt_m" value="{{ $seeddropselect->underbelt_m or '0' }}">
    {!! $errors->first('underbelt_m', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12 {{ $errors->has('note') ? 'has-error' : '' }}">
    <label for="note" class="control-label">Note</label>
    <input class="form-control" name="note" type="text" id="note" value="{{ $seeddropselect->note or '' }}">
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'แก้ไข' : 'เพิ่ม' }}">
</div>

</div>