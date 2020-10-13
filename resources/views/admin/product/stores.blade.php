@extends('adminlte::page')

@section('title', __('translations.product_stores'))

@section('content_header')
    <h1 class="header">{{ __('translations.product_stores') }}</h1>
@stop

@section('content')
    <div class="container" style="width:1030px;" >
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ url('/admin/products') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm print-hide"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>

                        <br/>
                        <br/>
                        @if ($product->hasStores() > 0)
                        <form method="GET" action="{{ route('products.stores' , ['id'=>$product->id]) }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                          @include ('admin.partials.form')
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                      <th>{{ __('translations.loop_number') }}</th>
                                      <th>{{ __('translations.exit_date') }}</th>
                                      <th>{{ __('translations.process_number_store') }}</th>
                                      {{-- <th>{{ __('translations.quantity') }}</th> --}}
                                      <th>{{ __('translations.deliver_name') }}</th>
                                      <th></th>
                                </thead>
                                <tbody>
                                @foreach($stores as $item)
                                  {{-- @if ($item->created_at >= $choosenDate && $item->created_at <= $currentDate) --}}
                                    <tr>
                                      <td>{{ $item->id }}</td>
                                      <td>{{ $item->created_at }}</td>
                                      <td>{{ $item->process_number }}</td>
                                      {{-- <td>{{ $item->pivot->quantity }}</td> --}}
                                      <td>{{ $item->deliver_name }}</td>
                                      <td>@if (!is_null($item->cancel_reason))
                                        <span style="font-weight:bold; color:red">{{__('translations.canceled')}}</span>
                                      @endif</td>
                                   </tr>
                                 {{-- @endif --}}
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $stores->appends(['choosen_date' => Request::get('choosen_date') , 'current_date' => Request::get('current_date')])->render() !!} </div>

                        </div>
                        {{-- <button type="button" class="btn btn-success print print-hide"name="button">{{__('translations.PRINT')}}</button> --}}
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
