<div class="form-group {{ $errors->has('quantity') ? 'has-error' : ''}}" id="group">

</div>
<div class="form-group">
    <button class="btn btn-primary" type="button" name="add" id="add">{{ __('translations.add') }} </button>
    <button class="btn btn-danger" type="button" style="display:none" name="remove" id="remove">{{ __('translations.remove') }} </button>
</div>
<div class="form-group">
    <input class="btn btn-primary submit" type="submit" style="display:none" value="{{ $formMode === 'edit' ? __('translations.update')  :  __('translations.create')  }}">
</div>
