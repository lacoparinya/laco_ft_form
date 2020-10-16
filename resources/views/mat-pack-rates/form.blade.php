    <div class="form-group col-md-3 {{ $errors->has('mat_pack_id') ? 'has-error' : ''}}">
        <label for="mat_pack_id" class="control-label">{{ 'ผลิตภัณฑ์' }}</label>
        <select name="mat_pack_id" class="form-control dynamic" id="mat_pack_id" required>
            <option value="">-</option>
        @foreach ($matpacklist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($matpackrate->mat_pack_id) && $matpackrate->mat_pack_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('mat_pack_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-3 {{ $errors->has('stamp_machine_id') ? 'has-error' : ''}}">
        <label for="stamp_machine_id" class="control-label">{{ 'เครื่อง' }}</label>
        <select name="stamp_machine_id" class="form-control dynamic" id="stamp_machine_id" required>
            <option value="">-</option>
        @foreach ($stampmachinelist as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($matpackrate->stamp_machine_id) && $matpackrate->stamp_machine_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
        {!! $errors->first('stamp_machine_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-md-3 {{ $errors->has('rateperhr') ? 'has-error' : ''}}">
    <label for="rateperhr" class="control-label">{{ 'STD Rate per Hr' }}</label>
    <input class="form-control" name="rateperhr" type="text" id="rateperhr" value="{{ $matpackrate->rateperhr or ''}}" >
    {!! $errors->first('rateperhr', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-3 {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <input class="form-control" name="status" type="text" id="status" value="{{ $matpackrate->status or 'Active'}}" >
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
