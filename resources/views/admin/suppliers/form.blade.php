
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ __('translations.name') }}*</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($supplier->name) ? $supplier->name : old('name')}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ __('translations.email') }}</label>
    <input class="form-control" name="email" type="text" id="email" value="{{ isset($supplier->email) ? $supplier->email : old('email')}}" >
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
    <label for="phone" class="control-label">{{ __('translations.phone') }}*</label>
    <input class="form-control" name="phone" type="text" id="phone" value="{{ isset($supplier->phone) ? $supplier->phone : old('phone')}}" >
    {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('contact_type') ? 'has-error' : ''}}">
    <label for="contact_type" class="control-label">{{ __('translations.contact_type') }}</label>
    <input class="form-control" name="contact_type" type="text" id="contact_type" value="{{ isset($supplier->contact_type) ? $supplier->contact_type : old('contact_type')}}" >
    {!! $errors->first('contact_type', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ?  __('translations.update')  :  __('translations.create')  }}">
</div>
