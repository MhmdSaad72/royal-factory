@extends('adminlte::page')

@section('title', __('translations.create_new_order'))

@section('content_header')
    <h1>{{ __('translations.create_new_order') }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('/admin/orders') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/admin/orders') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('material_id') ? 'has-error' : ''}}">
                                <label for="material_id" class="control-label">{{ __('translations.material_name') }}*</label>
                                <select name="material_id" class="form-control" id="material_id" >
                                  <option value="" selected disabled>{{ __('translations.select_material_name') }}</option>
                                  @foreach($materials as $material)
                                    <option value="{{$material->id}}"{{$material->id == old('material_id') ? 'selected': ''}}>{{$material->name}}</option>
                                  @endforeach

                            </select>
                                {!! $errors->first('material_id', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('supplier_id') ? 'has-error' : ''}}">
                                <label for="supplier_id" class="control-label">{{ __('translations.supplier_name') }}*</label>
                                <select name="supplier_id" class="form-control" id="supplier_id" >
                                  <option value="" selected disabled>{{ __('translations.select_supplier_name') }}</option>
                                  @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}"{{$supplier->id == old('supplier_id') ? 'selected': ''}}>{{$supplier->name}}</option>
                                  @endforeach

                            </select>
                                {!! $errors->first('supplier_id', '<p class="help-block">:message</p>') !!}
                            </div>

                            @include ('admin.orders.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
