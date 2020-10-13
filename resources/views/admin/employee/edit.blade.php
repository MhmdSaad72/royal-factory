@extends('adminlte::page')

@section('title', __('translations.edit_employee'))

@section('content_header')
    <h1>{{ __('translations.edit_employee') }}</h1>
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

                        <form method="POST" action="{{ url('/admin/employee/' . $employee->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('position_id') ? 'has-error' : ''}}">
                                <label for="position_id" class="control-label">{{ __('translations.position_type') }}*</label>
                                <select name="position_id" class="form-control" id="position_id" >
                                  <option selected disabled>{{__('translations.select_position_type')}}</option>
                                  @foreach($positionTypes as $positionType)
                                    <option value="{{$positionType->id}}"{{$positionType->id == $employee->position_id ? 'selected' : ''}}>{{$positionType->name}}</option>
                                  @endforeach

                            </select>
                                {!! $errors->first('position_id', '<p class="help-block">:message</p>') !!}
                            </div>


                            @include ('admin.employee.form', ['formMode' => 'edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
