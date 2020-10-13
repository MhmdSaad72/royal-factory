@extends('adminlte::page')

@section('title', __('translations.edit_store'))

@section('content_header')
    <h1>{{ __('translations.edit_store') }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('/admin/stores') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/admin/stores/' . $order->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
                                <label for="product_id" class="control-label">{{ __('translations.product') }}*</label>
                                <select name="product_id" class="form-control" id="product_id" >
                                  <option value="" selected disabled>{{ __('translations.select_product') }}</option>
                                  @foreach($products as $product)
                                    <option value="{{$product->id}}"{{$product->id == $store->product_id ? 'selected': ''}}>{{$product->name}}</option>
                                  @endforeach

                            </select>
                                {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
                            </div>

                            @include ('admin.stores.form', ['formMode' => 'edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
