<div class="form-group col-md-4  {{ $errors->has('method_id') ? 'has-error' : ''}}">
    <label for="method_id" class="control-label">{{ 'วิธี' }}</label>
    <select name="method_id" class="form-control" id="method_id" required>
        <option value="">-</option>
    @foreach ($methodlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($seeddroppack->method_id) && $seeddroppack->method_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('method_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4  {{ $errors->has('shift_id') ? 'has-error' : ''}}">
    <label for="shift_id" class="control-label">{{ 'กะ' }}</label>
    <select name="shift_id" class="form-control" id="package_id" required>
        <option value="">-</option>
    @foreach ($shiftlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($seeddroppack->shift_id) && $seeddroppack->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('shift_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('check_date') ? 'has-error' : ''}}">
    <label for="check_date" class="control-label">{{ 'วันที่ตรวจสอบ' }}</label>
    <input required class="form-control" name="check_date" type="date" id="check_date" value="{{ $seeddroppack->check_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('check_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('cabin') ? 'has-error' : ''}}">
    <label for="cabin" class="control-label">{{ 'บริเวณลากกระบะ (KG.)' }}</label>
    <input class="form-control" name="cabin" type="text" id="cabin" value="{{ $seeddroppack->cabin or '0'}}" >
    {!! $errors->first('cabin', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('belt_start') ? 'has-error' : ''}}">
    <label for="belt_start" class="control-label">{{ 'สายพานจุดปล่อยถั่ว  (KG.)' }}</label>
    <input class="form-control" name="belt_start" type="text" id="belt_start" value="{{ $seeddroppack->belt_start or '0'}}" >
    {!! $errors->first('belt_start', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('belt_Intralox') ? 'has-error' : ''}}">
    <label for="belt_Intralox" class="control-label">{{ 'สายพาน Intralox/โครง Z  (KG.)' }}</label>
    <input class="form-control" name="belt_Intralox" type="text" id="belt_Intralox" value="{{ $seeddroppack->belt_Intralox or '0'}}" >
    {!! $errors->first('belt_Intralox', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('weight_head') ? 'has-error' : ''}}">
    <label for="weight_head" class="control-label">{{ 'หัวชั่ง' }}</label>
    <input class="form-control" name="weight_head" type="text" id="weight_head" value="{{ $seeddroppack->weight_head or '0'}}" >
    {!! $errors->first('weight_head', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('pack_part') ? 'has-error' : ''}}">
    <label for="pack_part" class="control-label">{{ 'ในเครื่องบรรจุ (KG.)' }}</label>
    <input class="form-control" name="pack_part" type="text" id="pack_part" value="{{ $seeddroppack->pack_part or '0'}}" >
    {!! $errors->first('pack_part', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('shaker') ? 'has-error' : ''}}">
    <label for="shaker" class="control-label">{{ 'Shaker' }}</label>
    <input class="form-control" name="shaker" type="text" id="shaker" value="{{ $seeddroppack->shaker or '0'}}" >
    {!! $errors->first('shaker', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('table') ? 'has-error' : ''}}">
    <label for="table" class="control-label">{{ 'โต๊ะบรรจุ (KG.)' }}</label>
    <input class="form-control" name="table" type="text" id="table" value="{{ $seeddroppack->table or '0'}}" >
    {!! $errors->first('table', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-8 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="note" class="control-label">{{ 'Note' }}</label>
    <input class="form-control" name="note" type="text" id="note" value="{{ $seeddroppack->note or ''}}" >
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'แก้ไข' : 'เพิ่ม' }}">
</div>
