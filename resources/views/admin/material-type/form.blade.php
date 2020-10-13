<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ __('translations.name') }}*</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($materialtype->name) ? $materialtype->name : old('name')}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('translations.update')  :  __('translations.create')  }}">
</div>
