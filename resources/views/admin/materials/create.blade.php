@extends('adminlte::page')

@section('title', __('translations.create_new_material'))

@section('content_header')
    <h1>{{ __('translations.create_new_material') }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('/admin/materials') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/admin/materials') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('material_type_id') ? 'has-error' : ''}}">
                                <label for="material_type_id" class="control-label">{{ __('translations.material_type_name') }}*</label>
                                <select name="material_type_id" class="form-control" id="material_type_id" >
                                  <option value="" selected disabled>{{ __('translations.select_material_type_name') }}</option>
                                  @foreach($materialTypes as $materialType)
                                    <option value="{{$materialType->id}}"{{$materialType->id == old('material_type_id') ? 'selected': ''}}>{{$materialType->name}}</option>
                                  @endforeach

                            </select>
                                {!! $errors->first('material_type_id', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('quantity_type') ? 'has-error' : ''}}">
                              <label for="quantity_type" class="control-label">{{ __('translations.quantity_type') }}*</label>
                              <select name="quantity_type" class="form-control" id="quantity_type" >
                                <option selected disabled>{{__('translations.select_quantity_type')}}</option>
                                  <option value="0" {{old('quantity_type') == '0' ? 'selected' : ''}}>{{ __('translations.kilo') }}</option>
                                  <option value="1" {{old('quantity_type') == '1' ? 'selected' : ''}}>{{ __('translations.piece') }}</option>
                             </select>
                             {!! $errors->first('quantity_type', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                <label for="type" class="control-label">{{ __('translations.type') }}*</label>
                                <select name="type" class="form-control" id="type" >
                                  <option selected disabled>{{__('translations.select_type')}}</option>
                                    <option value="0" {{old('type') == '0' ? 'selected' : ''}}>{{ __('translations.primary') }}</option>
                                    <option value="1" {{old('type') == '1' ? 'selected' : ''}}>{{ __('translations.secondary') }}</option>
                               </select>
                                {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
                            </div>

                            @include ('admin.materials.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
