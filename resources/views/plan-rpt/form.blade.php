@php
    $monthlist = array(
        '1' => 'Jan',
        '2' => 'Feb',
        '3' => 'Mar',
        '4' => 'Apr',
        '5' => 'May',
        '6' => 'Jun',
        '7' => 'Jul',
        '8' => 'Aug',
        '9' => 'Sep',
        '10' => 'Oct',
        '11' => 'Nov',
        '12' => 'Dec'
    );

@endphp
<div class="form-group col-md-4 {{ $errors->has('enter_date') ? 'has-error' : ''}}">
    <label for="plan_date" class="control-label">{{ 'แผนวันที่' }}</label>
    <input class="form-control" name="enter_date" type="date" id="enter_date" 
    value="{{ $planrptm->enter_date or \Carbon\Carbon::now()->format('Y-m-d') }}"
    @if (isset($planrptm->enter_date))
        readonly 
    @endif
    >
    {!! $errors->first('enter_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-4  {{ $errors->has('month') ? 'has-error' : ''}}">
    <label for="month" class="control-label">{{ 'เดือน' }}</label>
    <select name="month" class="form-control" id="month" required 
    @if (isset($planrptm->month))
        readonly 
    @endif
    >
        <option value="">-</option>
    @foreach ($monthlist as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" 
        @if ((isset($planrptm->month) && $planrptm->month == $optionKey))
            selected
        @else
            @if (\Carbon\Carbon::now()->format('m') == $optionKey)
                selected
            @endif    
        @endif
         >{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-4 {{ $errors->has('year') ? 'has-error' : ''}}">
    <label for="year" class="control-label">{{ 'ปี' }}</label>
    <input required class="form-control" name="year" type="number" id="year" value="{{ $planrptm->year or \Carbon\Carbon::now()->format('Y')}}" 
    @if (isset($planrptm->year))
        readonly 
    @endif
    >
    {!! $errors->first('year', '<p class="help-block">:message</p>') !!}
</div>
<div class='row'>
<div class="col-md-2">&nbsp;</div>
<div class="col-md-2">Delivery Plan</div>
<div class="col-md-2">Confirm</div>
<div class="col-md-2">บรรจุได้</div>
<div class="col-md-2">รอส่งมอบ</div>
</div>
@foreach ($plangrouplist as $key=>$item)
<div class='row'>
<div class="col-md-2">{{ $item }}</div>
<div class="col-md-2 form-group{{ $errors->has('num_delivery_plan-'.$key ) ? 'has-error' : ''}}">
    @if (isset($planrptds[$key]))
        <input required class="form-control" name="num_delivery_plan-{{ $key }}" type="number" id="num_delivery_plan-{{ $key }}" value="{{ $planrptds[$key]->num_delivery_plan }}" >
    @else
        @if (isset($prevplanrptds[$key]))
            <input required class="form-control" name="num_delivery_plan-{{ $key }}" type="number" id="num_delivery_plan-{{ $key }}" value="{{ $prevplanrptds[$key]->num_delivery_plan }}" >
        @else
            <input required class="form-control" name="num_delivery_plan-{{ $key }}" type="number" id="num_delivery_plan-{{ $key }}" value="" >
        @endif
        
    @endif
    
    {!! $errors->first('num_delivery_plan-'.$key, '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-2 form-group{{ $errors->has('num_confirm-'.$key) ? 'has-error' : ''}}">
    @if (isset($planrptds[$key]))
        <input required class="form-control" name="num_confirm-{{ $key }}" type="number" id="num_confirm-{{ $key }}" value="{{ $planrptds[$key]->num_confirm }}" >
    @else
        @if (isset($prevplanrptds[$key]))
            <input required class="form-control" name="num_confirm-{{ $key }}" type="number" id="num_confirm-{{ $key }}" value="{{ $prevplanrptds[$key]->num_confirm }}" >
        @else
            <input required class="form-control" name="num_confirm-{{ $key }}" type="number" id="num_confirm-{{ $key }}" value="" >
        @endif        
    @endif
    {!! $errors->first('num_confirm-'.$key, '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-2 form-group{{ $errors->has('num_packed-'.$key) ? 'has-error' : ''}}">
    @if (isset($planrptds[$key]))
        <input required class="form-control" name="num_packed-{{ $key }}" type="number" id="num_packed-{{ $key }}" value="{{ $planrptds[$key]->num_packed }}" >
    @else
        @if (isset($prevplanrptds[$key]))
            <input required class="form-control" name="num_packed-{{ $key }}" type="number" id="num_packed-{{ $key }}" value="{{ $prevplanrptds[$key]->num_packed }}" >
        @else
            <input required class="form-control" name="num_packed-{{ $key }}" type="number" id="num_packed-{{ $key }}" value="" >
        @endif 
    @endif
    {!! $errors->first('num_packed-'.$key, '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-2 form-group{{ $errors->has('num_wait-'.$key) ? 'has-error' : ''}}">
    @if (isset($planrptds[$key]))
        <input required class="form-control" name="num_wait-{{ $key }}" type="number" id="num_wait-{{ $key }}" value="{{ $planrptds[$key]->num_wait }}" >
    @else
        @if (isset($prevplanrptds[$key]))
            <input required class="form-control" name="num_wait-{{ $key }}" type="number" id="num_wait-{{ $key }}" value="{{ $prevplanrptds[$key]->num_wait }}" >
        @else
            <input required class="form-control" name="num_wait-{{ $key }}" type="number" id="num_wait-{{ $key }}" value="" >
        @endif 
    @endif
    {!! $errors->first('num_wait-'.$key, '<p class="help-block">:message</p>') !!}
</div> 
</div>
@endforeach
<div class="form-group col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Save' }}">
</div>