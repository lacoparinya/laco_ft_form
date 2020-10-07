<div class="form-group col-md-3 {{ $errors->has('process_date') ? 'has-error' : ''}}">
    <label for="process_date" class="control-label">{{ 'Process Date' }}</label>
    <input type="hidden" name="job_id" id="job_id" value="{{  $ftlogpack->job_id or '2' }}" />
    <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $logpackm->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-1 {{ $errors->has('shift_id') ? 'has-error' : ''}}">
        <label for="shift_id" class="control-label">{{ 'กะ' }}</label>
        <select name="shift_id" class="form-control dynamic" id="shift_id" required>
            <option value="">-</option>
        @foreach ($shiftlist as $optionKey => $optionValue)logpackd
            <option value="{{ $optionKey }}" {{ (isset($logpackm->shift_id) && $logpackm->shift_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('pre_prod_id', '<p class="help-block">:message</p>') !!}
    </div>
<div class="form-group col-md-4 {{ $errors->has('method_id') ? 'has-error' : ''}}">
    <label for="method_id" class="control-label">{{ 'วิธี' }}</label>
    <select name="method_id" class="form-control dynamicx" id="method_id" data-dependent = 'std_pack_id' required>
        <option value="">-</option>
    @foreach ($methodlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logpackm->method_id) && $logpackm->method_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('method_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('package_id') ? 'has-error' : ''}}">
    <label for="package_id" class="control-label">{{ 'สินค้า' }}</label>
    <select name="package_id" class="form-control" id="package_id" required>
        <option value="">-</option>
    @foreach ($packagelist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($logpackm->package_id) && $logpackm->package_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('package_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('order_name') ? 'has-error' : ''}}">
    <label for="order_name" class="control-label">{{ 'Order No.' }}</label>
    <input required class="form-control uicomplete" autocomplete="on" name="order_name" type="text" id="order_name"   value="{{ $logpackm->order->order_no or '' }}"  >
    <input name="order_id" type="hidden" id="order_id"  value={{ $logpackm->order->id or '' }}  >
    {!! $errors->first('order_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('order_date') ? 'has-error' : ''}}">
    <label for="order_date" class="control-label">{{ 'Loading Date' }}</label>
    <input class="form-control" name="order_date" type="date" id="order_date" value="{{ $logpackm->order->loading_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('order_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('kgsperpack') ? 'has-error' : ''}}">
    <label for="kgsperpack" class="control-label">{{ 'หน่วย ต่อ pack' }}</label>
    <input class="form-control" name="kgsperpack" id="kgsperpack" value={{ $logpackm->package->kgsperpack or '' }}  >
    {!! $errors->first('kgsperpack', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('overalltargets') ? 'has-error' : ''}}">
    <label for="overalltargets" class="control-label">{{ 'ยอดรวมของสินค้านี้' }}</label>
    <input class="form-control" name="overalltargets" id="overalltargets" value={{ $logpackm->overalltargets or '' }}  >
    {!! $errors->first('overalltargets', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('targetperday') ? 'has-error' : ''}}">
    <label for="targetperday" class="control-label">{{ 'ยอดที่ต้องผลิดได้ต่อวัน' }}</label>
    <input class="form-control" name="targetperday" id="targetperday" value={{ $logpackm->targetperday or '' }}  >
    {!! $errors->first('targetperday', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('houroverall') ? 'has-error' : ''}}">
    <label for="houroverall" class="control-label">{{ 'จำนวน ชม. ที่ทั้งหมดใช้ผลิตสินค้านี้' }}</label>
    <input class="form-control" name="houroverall" id="houroverall" value={{ $logpackm->houroverall or '' }}  >
    {!! $errors->first('houroverall', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('hourperday') ? 'has-error' : ''}}">
    <label for="hourperday" class="control-label">{{ 'จำนวน ชม. ต่อวันที่ผลิตสินค้านี้' }}</label>
    <input class="form-control" name="hourperday" id="hourperday" value={{ $logpackm->hourperday or '' }}  >
    {!! $errors->first('hourperday', '<p class="help-block">:message</p>') !!}
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
<div class="form-group col-md-4 {{ $errors->has('staff_pk') ? 'has-error' : ''}}">
    <label for="staff_pk" class="control-label">{{ 'พนักงาน PK' }}</label>
    <input required class="form-control" name="staff_pk" type="number" id="staff_pk" value="{{ $logselectm->staff_pk or ''}}" >
    {!! $errors->first('staff_pk', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('staff_pf') ? 'has-error' : ''}}">
    <label for="staff_pf" class="control-label">{{ 'พนักงานช่วยงานจาก PF' }}</label>
    <input required class="form-control" name="staff_pf" type="number" id="staff_pf" value="{{ $logselectm->staff_pf or ''}}" >
    {!! $errors->first('staff_pf', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('staff_pst') ? 'has-error' : ''}}">
    <label for="staff_pst" class="control-label">{{ 'พนักงานช่วยงานจาก PST' }}</label>
    <input required class="form-control" name="staff_pst" type="number" id="staff_pst" value="{{ $logselectm->staff_pst or ''}}" >
    {!! $errors->first('staff_pst', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-8 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="yeild_percent" class="control-label">{{ 'Note' }}</label>
    <input class="form-control" name="note" type="text" id="note" value="{{ $logpackm->note or ''}}" >
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group  col-md-12 ">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
