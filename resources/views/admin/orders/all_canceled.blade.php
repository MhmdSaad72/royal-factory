@extends('adminlte::page')

@section('title', __('translations.all_canceled_orders'))

@section('content_header')
    <h1>{{ __('translations.all_canceled_orders') }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                      <a href="{{ url('/admin/orders') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm print-hide"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                      <form method="GET" action="{{ route('orders.canceled.reports') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                          <div class="input-group">
                              <input type="text" class="form-control" name="search" placeholder="{{ __('translations.search') }}" value="{{ request('search') }}">
                              <span class="input-group-append">
                                  <button class="btn btn-secondary" type="submit">
                                      <i class="fa fa-search"></i>
                                  </button>
                              </span>
                          </div>
                      </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('translations.loop_number') }}</th>
                                        <th>{{ __('translations.date_of_order') }}</th>
                                        <th>{{ __('translations.process_number_order') }}</th>
                                        <th>{{ __('translations.quantity') }}</th>
                                        <th>{{ __('translations.expire_date') }}</th>
                                        <th>{{ __('translations.material_name') }}</th>
                                        <th>{{ __('translations.supplier_name') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $item)
                                    <tr>
                                        <td>{{ $item->id}}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->process_number }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->expire_date }}</td>
                                        <td>{{ $item->material['name']}}</td>
                                        <td>{{ $item->supplier['name']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $orders->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
