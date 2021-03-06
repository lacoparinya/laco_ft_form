<div class="row">
<div class="col-md-4 {{ $errors->has('product_id') ? 'has-error' : ''}}">
        {!! Form::label('product_id', 'Product', ['class' => 'control-label']) !!}
        @if (isset($packaging->product_id))
            {!! Form::select('product_id', $productlist,$packaging->product_id, ['class' => 'form-control caldate getorderlist getprice']) !!}   
        @else
            {!! Form::select('product_id', $productlist,null, ['class' => 'form-control caldate getorderlist  getprice']) !!}
        @endif
        {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-4 {{ $errors->has('start_date') ? 'has-error' : ''}}">
    <label for="start_date" class="control-label">{{ 'Start Date' }}</label>
    <input class="form-control" name="start_date" type="date" id="start_date" value="{{ $packaging->start_date ?? \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-4 {{ $errors->has('end_date') ? 'has-error' : ''}}">
    <label for="end_date" class="control-label">{{ 'End Date' }}</label>
    <input class="form-control" name="end_date" type="date" id="end_date" value="{{ $packaging->end_date ?? \Carbon\Carbon::now()->format('Y-m-d') }}" >
    {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-8 {{ $errors->has('version') ? 'has-error' : ''}}">
    <label for="version" class="control-label">{{ 'Version name' }}</label>
    <input class="form-control" name="version" type="text" id="version" required value="{{ $packaging->version ?? ''}}" >
    {!! $errors->first('version', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-4  {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'status' }}</label>
    <input class="form-control" name="status" type="text" id="status" required value="{{ $packaging->status ?? 'Active'}}" >
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>

<div class="col-md-4  {{ $errors->has('inner_weight_g') ? 'has-error' : ''}}">
    <label for="inner_weight_g" class="control-label">{{ '?????????????????????/????????? (g.)' }}</label>
    <input class="form-control calweight" name="inner_weight_g" type="text" id="inner_weight_g" value=@if(!empty($packaging->inner_weight_g))
    "{{ number_format($packaging->inner_weight_g,2,".",",") ?? ''}}"
    @else
        "0"
    @endif    
     >
    {!! $errors->first('inner_weight_g', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-4  {{ $errors->has('number_per_pack') ? 'has-error' : ''}}">
    <label for="number_per_pack" class="control-label">{{ '????????????????????????/???????????????' }}</label>
    <input class="form-control calweight" name="number_per_pack" type="text" id="number_per_pack" value="{{ $packaging->number_per_pack ?? '0'}}" >
    {!! $errors->first('number_per_pack', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-4  {{ $errors->has('outer_weight_kg') ? 'has-error' : ''}}">
    <label for="outer_weight_kg" class="control-label">{{ '?????????????????????/??????????????? (kg.)' }}</label>
    <input class="form-control" name="outer_weight_kg" type="text" id="outer_weight_kg" 
    value=@if(!empty($packaging->outer_weight_kg)) "{{ number_format($packaging->outer_weight_kg,3,".",",") ?? ''}}" @else "0" @endif
    >
    {!! $errors->first('outer_weight_kg', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-12  {{ $errors->has('desc') ? 'has-error' : ''}}">
    <label for="desc" class="control-label">{{ '??????????????????????????????' }}</label>
    <textarea class="form-control" name="desc" type="text" id="desc">{{ $packaging->desc ?? ''}}</textarea>
    {!! $errors->first('desc', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-12">
    <div class="row">
@foreach ($packagetypelist as $packagetypeObj)
@if (isset($packagearr[$packagetypeObj->id]))
<div class="col-md-4 {{ $errors->has('package_id-'.$packagetypeObj->id) ? 'has-error' : ''}}">
        
        
       
        @if (isset($packageid[$packagetypeObj->id]))
            {!! Form::checkbox('package_id-chk-'.$packagetypeObj->id,$packagetypeObj->id,true,['class'=>'packagedata']); !!}
            {!! Form::label('package_id-'.$packagetypeObj->id, $packagetypeObj->name , ['class' => 'control-label']) !!}
             <div id="dd-{{ $packagetypeObj->id }}" style='display: block'>
            {!! Form::select('package_id-'.$packagetypeObj->id, $packagearr[$packagetypeObj->id],$packageid[$packagetypeObj->id], ['class' => 'form-control caldate getorderlist getprice','placeholder' => '===Select===']) !!}   
        @else
            {!! Form::checkbox('package_id-chk-'.$packagetypeObj->id,$packagetypeObj->id,false,['class'=>'packagedata']); !!}
            {!! Form::label('package_id-'.$packagetypeObj->id, $packagetypeObj->name , ['class' => 'control-label']) !!}
             <div id="dd-{{ $packagetypeObj->id }}" style='display: none'>
            {!! Form::select('package_id-'.$packagetypeObj->id, $packagearr[$packagetypeObj->id],null, ['class' => 'form-control caldate getorderlist  getprice','placeholder' => '===Select===']) !!}
        @endif
        </div>
        
        {!! $errors->first('package_id-'.$packagetypeObj->id, '<p class="help-block">:message</p>') !!}
</div>      
@endif

@endforeach
</div> </div>
<div class="col-md-3">
     {!! Form::label('stamp_id_head','????????????????????? Stamp'  , ['class' => 'control-label']) !!}
</div>
<div class="col-md-9">
    @foreach ($stamplist as $key=>$item)
    @if (!empty($stampid) && in_array($key,$stampid))
        {!! Form::checkbox('stamp_id[]', $key, true); !!}
    @else
        {!! Form::checkbox('stamp_id[]', $key); !!}
    @endif
      
        {!! Form::label('stamp_id[]', $item , ['class' => 'control-label']) !!}
      
    @endforeach    
</div>
<div class="col-md-3">
     {!! Form::label('pack_machine_id_head','????????????????????? Pack'  , ['class' => 'control-label']) !!}
</div>
<div class="col-md-9">
    @foreach ($packmachinelist as $key=>$item)

    @if (!empty($packmachineid) && in_array($key,$packmachineid))
        {!! Form::checkbox('pack_machine_id[]', $key, true); !!}
    @else
        {!! Form::checkbox('pack_machine_id[]', $key); !!}
    @endif
        {!! Form::label('pack_machine_id[]', $item , ['class' => 'control-label']) !!}
        
    @endforeach    
</div>
<div class="col-md-12">
    <input class="btn btn-primary form-group" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
</div>

    <script>$(document).ready(function () {
        $('.calweight').change(function() {
            var innerweight = parseFloat($('#inner_weight_g').val());
            var numperpack= parseInt($('#number_per_pack').val());
            var totalweight = (innerweight*numperpack/1000);
            $('#outer_weight_kg').val(totalweight);
        });

        $(".packagedata").click(function(){
            $( "#dd-"+$(this).val() ).toggle( "slow" );
        });
    });
    </script>