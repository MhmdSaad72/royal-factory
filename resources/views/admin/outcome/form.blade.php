<div class="form-group {{ $errors->has('process_number') ? 'has-error' : ''}}">
    <label for="process_number" class="control-label">{{ __('translations.process_number_outcome') }}*</label>
    <input class="form-control" name="process_number" type="number" id="process_number" value="{{ isset($outcome->process_number) ? $outcome->process_number : old('process_number')}}" >
    {!! $errors->first('process_number', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('material_id') ? 'has-error' : ''}}" id="group">

</div>

<div class="form-group">
    <button class="btn btn-primary" type="button" name="add" id="add">{{__('translations.add')}}</button>
    <button class="btn btn-danger" type="button" style="display:none" name="remove" id="remove">{{__('translations.remove')}}</button>
</div>

<div class="form-group">
    <input class="btn btn-primary submit" type="submit" value="{{ $formMode === 'edit' ? __('translations.update')  :  __('translations.create')  }}">
</div>
