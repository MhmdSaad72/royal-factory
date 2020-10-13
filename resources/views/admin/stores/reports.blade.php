@extends('adminlte::page')

@section('title', __('translations.store_reports'))

@section('content_header')
    <h1>{{ __('translations.store_reports') }}</h1>
@stop

@section('content')
  <div class="container">
    <a href="{{ url('/admin/stores/') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm print-hide"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
    <form method="GET" action="{{ url('/admin/stores/reports/reports') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
      @include ('admin.partials.form')
    </form>
      <div class="row" style="margin-top:50px;">

          <div class="col-md-9">
              <div class="card">
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                    <th>{{ __('translations.loop_number') }}</th>
                                    <th>{{ __('translations.exit_date') }}</th>
                                    <th>{{ __('translations.process_number_store') }}</th>
                                    <th>{{ __('translations.quantity') }}</th>
                                    {{-- <th>{{ __('translations.expire_date') }}</th> --}}
                                    <th>{{ __('translations.product') }}</th>
                                    <th>{{ __('translations.deliver_name') }}</th>
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
                                        <li>{{ $value->pivot->quantity }}</li>
                                      @endforeach
                                    </ul> </td>
                                    <td><ul>
                                      @foreach ($item->products as  $value)
                                        <li>{{ $value->name }}</li>
                                      @endforeach
                                    </ul> </td>
                                    {{-- <td>{{ $item->expire_date }}</td> --}}
                                    <td>{{ $item->deliver_name}}</td>
                                  </tr>
                              @endforeach
                              </tbody>
                          </table>
                          <div class="pagination-wrapper"> {!! $stores->appends(['choosen_date' => Request::get('choosen_date') , 'current_date' => Request::get('current_date')])->render() !!} </div>
                      </div>

                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection
