<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ __('translations.name') }}*</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($material->name) ? $material->name : old('name')}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('max_order') ? 'has-error' : ''}}">
    <label for="max_order" class="control-label">{{ __('translations.max_order') }}*</label>
    <input class="form-control" name="max_order" type="number" id="max_order" value="{{ isset($material->max_order) ? $material->max_order : old('max_order')}}" >
    {!! $errors->first('max_order', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('translations.update') : __('translations.create') }}">
</div>
