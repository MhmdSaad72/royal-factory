@extends('adminlte::page')

@section('title', __('translations.create_new_store_cost'))

@section('content_header')
    <h1>{{ __('translations.create_new_store_cost') }}</h1>
@stop
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('/admin/stores-cost') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/admin/stores-cost') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('stores_cost_type_id') ? 'has-error' : ''}}">
                                <label for="stores_cost_type_id" class="control-label">{{ __('translations.store_cost_type') }}*</label>
                                <select name="stores_cost_type_id" class="form-control" id="stores_cost_type_id" >
                                    <option value="" selected disabled>{{__('translations.select_stores_cost_type')}}</option>
                                  @foreach($storesCostTypes as $storesCostType)
                                    <option value="{{$storesCostType->id}}"{{$storesCostType->id == old('stores_cost_type_id') ? 'selected' : ''}}>{{$storesCostType->name}}</option>
                                  @endforeach

                            </select>
                                {!! $errors->first('stores_cost_type_id', '<p class="help-block">:message</p>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('store_id') ? 'has-error' : ''}}">
                                <label for="store_id" class="control-label">{{ __('translations.stores') }}*</label>
                                <select name="store_id" class="form-control" id="store_id" >
                                  <option value="" selected disabled>{{__('translations.select_store')}}</option>
                                  @foreach($stores as $store)
                                    <option value="{{$store->id}}"{{$store->id == old('store_id') ? 'selected' : ''}}>{{$store->name}}</option>
                                  @endforeach

                            </select>
                                {!! $errors->first('store_id', '<p class="help-block">:message</p>') !!}
                            </div>


                            @include ('admin.stores-cost.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
