@extends('adminlte::page')

@section('title', __('translations.orders'))

@section('content_header')
    <h1>{{ __('translations.orders') }}</h1>
@stop

@section('content')
    <div class="container">
      @if (session('flash_message'))
          <div class="alert alert-success col-12">
              {{ session('flash_message') }}
          </div>
      @endif
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('orders.create') }}" class="btn btn-success btn-sm" title="{{ __('translations.add_new') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i> {{ __('translations.add_new') }}
                        </a>
                        <a href="{{ route('orders.canceled.reports') }}" class="btn btn-danger btn-sm" title="{{ __('translations.cancel_order_reports') }}">
                            <i class="fa fa-folder" aria-hidden="true"></i> {{ __('translations.cancel_order_reports') }}
                        </a>
                        <a href="{{route('orders.next.expire')}}" class="btn btn-warning btn-sm" title="{{ __('translations.next_expirations') }}">
                           <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>  {{ __('translations.next_expirations') }}
                        </a>
                        <a href="{{route('orders.reports.show')}}" class="btn btn-sm" style="background:#333; color:#fff;" title="{{ __('translations.period_reports') }}">
                          <i class="fa fa-folder" aria-hidden="true"></i>  {{ __('translations.period_reports') }}
                        </a>
                        <a href="{{route('orders.expired')}}" class="btn btn-sm" style="background:#999; color:#fff;" title="{{ __('translations.expired_orders') }}">
                          <i class="fa fa-folder" aria-hidden="true"></i>  {{ __('translations.expired_orders') }}
                        </a>
                        <a href="{{route('order.export')}}" class="btn btn-sm" style="background:#186807; color:#fff;" title="{{ __('translations.order_excel') }}">
                            {{ __('translations.order_excel') }}
                        </a>


                        <form method="GET" action="{{ url('/admin/orders') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>{{ __('translations.remaining_quantity') }}</th>
                                        <th>{{ __('translations.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->process_number }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->expire_date }}</td>
                                        <td>{{ $item->material['name']}}</td>
                                        <td>{{ $item->supplier['name']}}</td>
                                        <td>{{ $item->remainQuantityOrder($item->material_id , $item->process_number) }}</td>
                                        <td>
                                          @if (!$item->cancel_reason)
                                            @if ($item->hasOutcomes($item->id) == 0)
                                              <a href="{{ url('/admin/orders/cancel/' . $item->id) }}" title="{{__('translations.cancel')}}"><button class="btn btn-warning btn-sm "><i class="fa fa-eye" aria-hidden="true"></i> {{__('translations.cancel')}}</button></a>
                                            @endif
                                            <a href="{{ url('/admin/orders/' . $item->id) }}" title="{{__('translations.print_view')}}"><button class="btn btn-info btn-sm "><i class="fa fa-eye" aria-hidden="true"></i> {{__('translations.print_view')}}</button></a>

                                            <form method="POST" action="{{ url('/admin/orders' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                @if ($item->hasMaterial() == 0 && $item->hasSupplier() == 0)
                                                  <button type="submit" class="btn btn-danger btn-sm" title="{{ __('translations.delete') }}" onclick="return confirm(&quot;{{__('translations.confirm_delete')}}&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> {{ __('translations.delete') }}</button>
                                                @endif
                                            </form>
                                            @else
                                              <p class="h4">{{__('translations.replace_process_number_order')}}<span style="font-weight:bold; color:red"> {{$item->cancel_reason}}</span></p>
                                            @endif

                                        </td>
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
