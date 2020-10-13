<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ __('translations.name') }}*</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($employee->name) ? $employee->name : old('name')}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('salary') ? 'has-error' : ''}}">
    <label for="salary" class="control-label">{{ __('translations.salary') }}*</label>
    <input class="form-control" name="salary" type="number" id="salary" value="{{ isset($employee->salary) ? $employee->salary : old('salary')}}" >
    {!! $errors->first('salary', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('translations.update') : __('translations.create') }}">
</div>
