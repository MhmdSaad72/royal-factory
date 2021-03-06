@extends('adminlte::page')

@section('title', __('translations.cancel_outcome'))

@section('content_header')
    <h1 class="header">{{ __('translations.cancel_outcome') }}</h1>
@stop
@section('content')
  <div class="container">
      <div class="row">

          <div class="col-md-9">
              <div class="card">
                  <div class="card-body">
                      <a href="{{ url('/admin/outcomes') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                      <br />
                      <br />

                      @if ($errors->any())
                          <ul class="alert alert-danger">
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      @endif

                      <form method="POST" action="{{ url('/admin/outcomes/cancel/' . $outcome->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                          {{ method_field('PATCH') }}
                          {{ csrf_field() }}
                          <div class="form-group {{ $errors->has('cancel_reason') ? 'has-error' : ''}}">
                              <label for="cancel_reason" class="control-label">{{ __('translations.process_number') }}*</label>
                              <select name="cancel_reason" class="form-control" id="cancel_reason" >
                                <option value="" selected disabled>{{ __('translations.select_replace_process_number') }}</option>
                                @foreach($outcome->allOutcomesToCanceled($outcome->id) as $outcome)
                                  <option value="{{$outcome->process_number}}">{{$outcome->process_number}}</option>
                                @endforeach

                          </select>
                              {!! $errors->first('cancel_reason', '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="form-group">
                              <input class="btn btn-primary" type="submit" value="{{__('translations.confirm_cancel')}}">
                          </div>

                      </form>

                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection
