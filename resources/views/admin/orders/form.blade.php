<div class="form-group {{ $errors->has('process_number') ? 'has-error' : ''}}">
    <label for="process_number" class="control-label">{{ __('translations.process_number_order') }}*</label>
    <input class="form-control" name="process_number" type="number" id="process_number" value="{{ isset($order->process_number) ? $order->process_number : old('process_number')}}" >
    {!! $errors->first('process_number', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('quantity') ? 'has-error' : ''}}">
    <label for="quantity" class="control-label">{{ __('translations.quantity') }}*</label>
    <input class="form-control" name="quantity" type="number" id="quantity" value="{{ isset($order->quantity) ? $order->quantity : old('quantity')}}" >
    {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('expire_date') ? 'has-error' : ''}}">
    <label for="expire_date" class="control-label">{{ __('translations.expire_date') }}*</label>
    <input class="form-control" name="expire_date" type="date" id="expire_date" value="{{ isset($order->expire_date) ? $order->expire_date : old('expire_date')}}" >
    {!! $errors->first('expire_date', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('translations.update')  : __('translations.create')  }}">
</div>
