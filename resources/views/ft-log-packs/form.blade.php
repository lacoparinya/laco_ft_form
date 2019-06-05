<div class="form-group col-md-4 {{ $errors->has('process_date') ? 'has-error' : ''}}">
    <label for="process_date" class="control-label">{{ 'Process Date' }}</label>
    <input type="hidden" name="job_id" id="job_id" value="{{  $ftlogpack->job_id or '2' }}" />
    <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $ftlogpack->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('timeslot_id') ? 'has-error' : ''}}">
    <label for="timeslot_id" class="control-label">{{ 'เวลา' }}</label>
    <select name="timeslot_id" class="form-control dynamic" id="timeslot_id" data-dependent = 'shift_id' required>
        <option value="">-</option>
    @foreach ($timeslotlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ftlogpack->timeslot_id) && $ftlogpack->timeslot_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('timeslot_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('shift_id') ? 'has-error' : ''}}">
    <label for="shift_id" class="control-label">{{ 'กะ' }}</label>
    <input type="hidden" name="shift_id" id="shift_id" value="{{  $ftlogpack->shift_id or '' }}" />
    <input class="form-control" name="shift_id_show" type="text" readonly id="shift_id_show" value="{{ $ftlogpack->shift->name or ''}}" >
    {!! $errors->first('shift_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('workhours') ? 'has-error' : ''}}">
    <label for="workhours" class="control-label">{{ 'เวลาทำงาน' }}</label>
    <input class="form-control" name="workhours" id="workhours" value={{ $ftlogpack->workhours or '' }}  >
    {!! $errors->first('workhours', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('method_id') ? 'has-error' : ''}}">
    <label for="method_id" class="control-label">{{ 'วิธี' }}</label>
    <select name="method_id" class="form-control dynamicx" id="method_id" data-dependent = 'std_pack_id' required>
        <option value="">-</option>
    @foreach ($methodlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($ftlogpack->method_id) && $ftlogpack->method_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('method_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('package_name') ? 'has-error' : ''}}">
    <label for="package_name" class="control-label">{{ 'บรรจุผลิตภัณฑ์' }}</label>
    <input required class="form-control uicomplete" autocomplete="on" name="package_name" type="text" id="package_name" value={{ $ftlogpack->package->name or '' }}  >
    <input name="package_id" type="hidden" id="package_id"  value={{ $ftlogpack->package->id or '' }}  >
    {!! $errors->first('package_name', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group col-md-4 {{ $errors->has('order_name') ? 'has-error' : ''}}">
    <label for="order_name" class="control-label">{{ 'Order No.' }}</label>
    <input required class="form-control uicomplete" autocomplete="on" name="order_name" type="text" id="order_name"   value={{ $ftlogpack->order->order_no or '' }}  >
    <input name="order_id" type="hidden" id="order_id"  value={{ $ftlogpack->order->id or '' }}  >
    {!! $errors->first('order_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('order_date') ? 'has-error' : ''}}">
    <label for="order_date" class="control-label">{{ 'Loading Date' }}</label>
    <input class="form-control" name="order_date" type="date" id="order_date" value="{{ $ftlogpack->order->loading_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('order_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('kgsperpack') ? 'has-error' : ''}}">
    <label for="kgsperpack" class="control-label">{{ 'kgs ต่อ กล่อง หรือ EA' }}</label>
    <input class="form-control" name="kgsperpack" id="kgsperpack" value={{ $ftlogpack->package->kgsperpack or '' }}  >
    {!! $errors->first('kgsperpack', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('input_kg') ? 'has-error' : ''}}">
    <label for="input_kg" class="control-label">{{ 'Input (kg)' }}</label>
    <input required class="form-control" name="input_kg" type="number" id="input_kg" value="{{ $ftlogpack->input_kg or ''}}" >
    {!! $errors->first('input_kg', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('output_kg') ? 'has-error' : ''}}">
    <label for="output_kg" class="control-label">{{ 'Output (kg)' }}</label>
    <input required class="form-control" name="output_kg" type="number" id="output_kg" value="{{ $ftlogpack->output_kg or ''}}" >
    {!! $errors->first('output_kg', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('output_kg_sum') ? 'has-error' : ''}}">
    <label for="output_kg_sum" class="control-label">{{ 'บรรจุได้สะสม (kg)' }}</label>
    <input readonly class="form-control" name="output_kg_sum" type="number" id="output_kg_sum" value="{{ $ftlogpack->output_kg_sum or '0'}}" >
    {!! $errors->first('output_kg_sum', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('output_pack') ? 'has-error' : ''}}">
    <label for="output_pack" class="control-label">{{ 'Output (กล่อง หรือ EA)' }}</label>
    <input required class="form-control" name="output_pack" type="number" id="output_pack" value="{{ $ftlogpack->output_pack or ''}}" >
    {!! $errors->first('output_pack', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('output_pack_sum') ? 'has-error' : ''}}">
    <label for="output_pack_sum" class="control-label">{{ 'Output สะสม (กล่อง หรือ EA)' }}</label>
    <input readonly class="form-control" name="output_pack_sum" type="number" id="output_pack_sum" value="{{ $ftlogpack->output_pack_sum or '0'}}" >
    {!! $errors->first('output_pack_sum', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group col-md-4 {{ $errors->has('num_pack') ? 'has-error' : ''}}">
    <label for="num_pack" class="control-label">{{ 'จำนวนคน' }}</label>
    <input required class="form-control" name="num_pack" type="number" id="num_pack" value="{{ $ftlogpack->num_pack or '0'}}" >
    {!! $errors->first('num_pack', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('std_pack_id') ? 'has-error' : ''}}">
    <label for="std_pack_id" class="control-label">{{ 'STD Productivity' }}</label>
    <input type="hidden" name="std_pack_id" id="std_pack_id" value="{{  $ftlogpack->std_pack_id or '' }}" />
    <input class="form-control" name="std_pack_id_show" type="text" readonly id="std_pack_id_show" value="{{ $ftlogpack->stdpack->std_rate or ''}}" >
    {!! $errors->first('std_pack_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('productivity') ? 'has-error' : ''}}">
    <label for="productivity" class="control-label">{{ 'Productivity' }}</label>
    <input class="form-control" name="productivity" type="text" readonly id="productivity" value="{{ $ftlogpack->productivity or ''}}" >
    {!! $errors->first('productivity', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4 {{ $errors->has('yeild_percent') ? 'has-error' : ''}}">
    <label for="yeild_percent" class="control-label">{{ 'Yeild %' }}</label>
    <input class="form-control" name="yeild_percent" type="text" readonly id="yeild_percent" value="{{ $ftlogpack->yeild_percent or ''}}" >
    {!! $errors->first('yeild_percent', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-8 {{ $errors->has('note') ? 'has-error' : ''}}">
    <label for="yeild_percent" class="control-label">{{ 'Note' }}</label>
    <input class="form-control" name="note" type="text" id="note" value="{{ $ftlogpack->note or ''}}" >
    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
