@extends('adminlte::page')

@section('title', __('translations.create_new_employee'))

@section('content_header')
    <h1>{{ __('translations.create_new_employee') }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('/admin/employee') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/admin/employee') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('position_id') ? 'has-error' : ''}}">
                                <label for="position_id" class="control-label">{{ __('translations.position_type') }}*</label>
                                <select name="position_id" class="form-control" id="position_id" >
                                  <option selected disabled>{{__('translations.select_position_type')}}</option>
                                  @foreach($positionTypes as $positionType)
                                    <option value="{{$positionType->id}}"{{$positionType->id == old('position_id') ? 'selected' : ''}}>{{$positionType->name}}</option>
                                  @endforeach

                            </select>
                                {!! $errors->first('position_id', '<p class="help-block">:message</p>') !!}
                            </div>

                            @include ('admin.employee.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
