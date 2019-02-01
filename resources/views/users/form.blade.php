<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="email" id="email" value="{{ $user->email or ''}}" >
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('username') ? 'has-error' : ''}}">
    <label for="username" class="control-label">{{ 'Username' }}</label>
    <input class="form-control" name="username" type="text" id="username" value="{{ $user->username or ''}}" >
    {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('group_id') ? 'has-error' : ''}}">
    <label for="group_id" class="control-label">{{ 'Group' }}</label>
    <select name="group_id" class="form-control dynamic" id="group_id">
    @foreach ($grouplist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($user->group_id) && $user->group_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('group_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    <label for="password" class="control-label">{{ 'Password' }}</label>
    <input class="form-control" name="password" type="password" id="password" >
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('fname') ? 'has-error' : ''}}">
    <label for="fname" class="control-label">{{ 'First Name' }}</label>
    <input class="form-control" name="fname" type="text" id="fname" value="{{ $user->fname or ''}}" >
    {!! $errors->first('fname', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('lname') ? 'has-error' : ''}}">
    <label for="lname" class="control-label">{{ 'Last Name' }}</label>
    <input class="form-control" name="lname" type="text" id="lname" value="{{ $user->lname or ''}}" >
    {!! $errors->first('lname', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('laconame') ? 'has-error' : ''}}">
    <label for="laconame" class="control-label">{{ 'Laconame' }}</label>
    <input class="form-control" name="laconame" type="text" id="laconame" value="{{ $user->laconame or ''}}" >
    {!! $errors->first('laconame', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
