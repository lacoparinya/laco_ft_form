
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="desc" class="control-label">{{ 'Time Show' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ $timeslot->name or ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('gap') ? 'has-error' : ''}}">
    <label for="desc" class="control-label">{{ 'Gap' }}</label>
    <input class="form-control" name="gap" type="text" id="gap" value="{{ $timeslot->gap or ''}}" >
    {!! $errors->first('gap', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('seq') ? 'has-error' : ''}}">
    <label for="desc" class="control-label">{{ 'Sequence' }}</label>
    <input class="form-control" name="seq" type="text" id="seq" value="{{ $timeslot->seq or ''}}" >
    {!! $errors->first('seq', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
