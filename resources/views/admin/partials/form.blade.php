<div class="row">
  <div class="col-md-1">
    <h3 style="margin-top:0;" class="text-center">{{__('translations.from')}}</h3>
  </div>
  <div class="col-md-3">
    <div class="{{ $errors->has('choosen_date') ? 'has-error' : ''}}">
        <input class="form-control" name="choosen_date" type="date" id="choosen_date" value="{{ $_GET['choosen_date'] ?? $lastDate }}"  style="width: 100%">
        {!! $errors->first('choosen_date', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <div class="col-md-1">
    <h3 style="margin-top:0;" class="text-center">{{__('translations.to')}}</h3>
  </div>
  <div class="col-md-3">
    <div class="{{ $errors->has('current_date') ? 'has-error' : ''}}">
        <input class="form-control" name="current_date" type="date" id="current_date" value="{{ $_GET['current_date'] ?? $date }}"  style="width: 100%">
        {!! $errors->first('choosen_date', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <div class="col-md-2" style="margin-bottom:0;">
    <button type="submit" class="btn btn-success btn-sm" name="button">{{__('translations.srch')}}</button>
  </div>

</div>
