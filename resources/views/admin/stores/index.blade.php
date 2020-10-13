@extends('adminlte::page')

@section('title', __('translations.stores'))

@section('content_header')
    <h1>{{ __('translations.stores') }}</h1>
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
                        <a href="{{ route('stores.create') }}" class="btn btn-success btn-sm" title="{{ __('translations.add_new') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i> {{ __('translations.add_new') }}
                        </a>
                        <a href="{{ route('stores.canceled.reports') }}" class="btn btn-danger btn-sm" title="{{ __('translations.cancel_store_reports') }}">
                            <i class="fa fa-folder" aria-hidden="true"></i> {{ __('translations.cancel_store_reports') }}
                        </a>
                        {{-- <a href="{{route('stores.next.expire')}}" class="btn btn-warning btn-sm" title="Next Expirations">
                           <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>  {{ __('translations.next_expirations') }}
                        </a> --}}
                        <a href="{{route('stores.reports.show')}}" class="btn btn-sm" style="background:#333; color:#fff;" title="{{ __('translations.period_reports') }}">
                          <i class="fa fa-folder" aria-hidden="true"></i>  {{ __('translations.period_reports') }}
                        </a>
                        <a href="{{route('store.export')}}" class="btn btn-sm" style="background:#186807; color:#fff;" title="{{ __('translations.store_excel') }}">
                           {{ __('translations.store_excel') }}
                        </a>

                        <form method="GET" action="{{ url('/admin/stores') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>{{ __('translations.exit_date') }}</th>
                                        <th>{{ __('translations.process_number_store') }}</th>
                                        <th>{{ __('translations.quantity') }}</th>
                                        <th>{{ __('translations.product') }}</th>
                                        <th>{{ __('translations.deliver_name') }}</th>
                                        <th>{{ __('translations.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($stores as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->process_number }}</td>
                                        <td><ul>
                                          @foreach ($item->products as  $value)
                                            <li>{{$value->pivot->quantity}}</li>
                                          @endforeach
                                        </ul></td>
                                        <td><ul>
                                          @foreach ($item->products as  $value)
                                            <li>{{$value->name}}</li>
                                          @endforeach
                                        </ul> </td>
                                        <td>{{ $item->deliver_name}}</td>
                                        <td>
                                          @if (!$item->cancel_reason)

                                            {{-- <a href="{{ url('/admin/stores/' . $item->id . '/edit') }}" title="Edit Order"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ __('translations.edit') }}</button></a> --}}
                                            <a href="{{ url('/admin/stores/' . $item->id) }}" title="Print view"><button class="btn btn-info btn-sm "><i class="fa fa-eye" aria-hidden="true"></i> {{__('translations.print_view')}}</button></a>
                                            <a href="{{ url('/admin/stores/cancel/' . $item->id) }}" title="cancel"><button class="btn btn-warning btn-sm "><i class="fa fa-eye" aria-hidden="true"></i> {{__('translations.cancel')}}</button></a>

                                            <form method="POST" action="{{ url('/admin/stores' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                @if ($item->hasProducts() == 0)
                                                  {{-- <button type="submit" class="btn btn-danger btn-sm" title="Delete Order" onclick="return confirm(&quot;{{__('translations.confirm_delete')}}&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> {{ __('translations.delete') }}</button> --}}
                                                @endif
                                            </form>
                                            @else
                                              <p class="h4">{{__('translations.replace_process_number')}}<span style="font-weight:bold; color:red"> {{$item->cancel_reason}}</span></p>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $stores->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
