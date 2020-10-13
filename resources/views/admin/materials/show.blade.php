@extends('adminlte::page')

@section('title', __('translations.material_orders'))

@section('content_header')
    <h1 class="header">{{ __('translations.material_orders') }}</h1>
@stop


@section('content')
    <div class="container" style="width:1030px;" >
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ url('/admin/materials') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm print-hide"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        @if ($material->hasOrders() > 0)
                        <form method="GET" action="{{ url('/admin/materials/' . $material->id) }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                          @include ('admin.partials.form')
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('translations.process_number_order') }}</th>
                                        <th>{{ __('translations.date_of_order') }}</th>
                                        <th>{{ __('translations.quantity') }}</th>
                                        <th>{{ __('translations.expire_date') }}</th>
                                        <th>{{ __('translations.supplier_name') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $item)
                                  {{-- @if (is_null($item->cancel_reason)) --}}

                                    <tr>
                                        <td>{{ $item->process_number }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->expire_date }}</td>
                                        <td>{{ $item->supplier['name']}}</td>
                                        <td>@if (!is_null($item->cancel_reason))
                                          <span style="font-weight:bold; color:red">{{__('translations.canceled')}}</span>
                                        @endif</td>
                                    </tr>
                                  {{-- @endif --}}
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $orders->appends(['choosen_date' => Request::get('choosen_date') , 'current_date' => Request::get('current_date')])->render() !!} </div>
                          @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
