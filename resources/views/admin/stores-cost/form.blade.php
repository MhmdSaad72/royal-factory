<div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    <label for="price" class="control-label">{{ __('translations.price') }}*</label>
    <input class="form-control" name="price" type="number" id="price" value="{{ isset($storescost->price) ? $storescost->price : old('price')}}" >
    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('reason') ? 'has-error' : ''}}">
    <label for="reason" class="control-label">{{ __('translations.reason') }}</label>
    <textarea class="form-control" rows="5" name="reason" type="textarea" id="reason" >{{ isset($storescost->reason) ? $storescost->reason : old('reason')}}</textarea>
    {!! $errors->first('reason', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('translations.update')  :  __('translations.create')  }}">
</div>
