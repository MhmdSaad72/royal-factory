<div class="form-group {{ $errors->has('process_number') ? 'has-error' : ''}}">
    <label for="process_number" class="control-label">{{ __('translations.process_number_store') }}*</label>
    <input class="form-control" name="process_number" type="number" id="process_number" value="{{ isset($store->process_number) ? $store->process_number : old('process_number')}}" >
    {!! $errors->first('process_number', '<p class="help-block">:message</p>') !!}
</div>
{{-- <div class="form-group {{ $errors->has('quantity') ? 'has-error' : ''}}">
    <label for="quantity" class="control-label">{{ __('translations.quantity') }}*</label>
    <input class="form-control" name="quantity" type="number" id="quantity" value="{{ isset($store->quantity) ? $store->quantity : old('quantity')}}" >
    @if (session('flash_message'))
        <span style="color:red;">{{ session('flash_message') }}</span>
    @endif
    {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
</div> --}}


<div class="form-group {{ $errors->has('deliver_name') ? 'has-error' : ''}}">
    <label for="deliver_name" class="control-label">{{ __('translations.deliver_name') }}*</label>
    <input class="form-control" name="deliver_name" type="text" id="deliver_name" value="{{ isset($supplier->deliver_name) ? $supplier->deliver_name : old('deliver_name')}}" >
    {!! $errors->first('deliver_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group" id="group">

</div>

<div class="form-group">
    <button class="btn btn-primary" type="button" name="add" id="add">{{__('translations.add')}}</button>
    <button class="btn btn-danger" type="button" style="display:none" name="remove" id="remove">{{__('translations.remove')}}</button>
</div>


<div class="form-group">
    <input class="btn btn-primary submit" type="submit" value="{{ $formMode === 'edit' ? __('translations.update')  : __('translations.create')  }}">
</div>
