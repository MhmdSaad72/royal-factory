<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ __('translations.name') }}*</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($positiontype->name) ? $positiontype->name : old('name')}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ __('translations.description') }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ isset($positiontype->description) ? $positiontype->description : old('description')}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('translations.update')  : __('translations.create') }}">
</div>
