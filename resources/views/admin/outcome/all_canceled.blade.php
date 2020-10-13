@extends('adminlte::page')

@section('title', __('translations.all_canceled_outcomes'))

@section('content_header')
    <h1>{{ __('translations.all_canceled_outcomes') }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                      <a href="{{ url('/admin/outcomes') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm print-hide"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                      <form method="GET" action="{{ route('outcomes.canceled.reports') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                      <th>{{ __('translations.process_number_outcome') }}</th>
                                      <th>{{ __('translations.created_at') }}</th>
                                      <th>{{ __('translations.outcome_period') }}</th>
                                      <th>{{ __('translations.materials') }}</th>
                                      <th>{{ __('translations.materials_quantities') }}</th>
                                      <th>{{ __('translations.products') }}</th>
                                      <th>{{ __('translations.productss_quantities') }}</th>

                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($outcomes as $item)
                                    <tr>
                                      <td>{{ $item->id}}</td>
                                      <td>{{ $item->process_number }}</td>
                                      <td>{{ $item->created_at }}</td>
                                      <td>{{ $item->outcomePeriod($item->id) }}</td>
                                      <td>
                                        <ul>
                                          @foreach ($item->materials as $value)
                                          <li>{{$value->name}}</li>
                                          @endforeach
                                        </ul>
                                      </td>
                                      <td>
                                        <ul>
                                          @foreach ($item->materials as $value)
                                          <li>{{$value->pivot->quantity}}</li>
                                          @endforeach
                                        </ul>
                                      </td>
                                      <td>
                                        <ul>
                                          @foreach ($item->products as $value)
                                          <li>{{$value->name}}</li>
                                          @endforeach
                                        </ul>
                                      </td>
                                      <td>
                                        <ul>
                                          @foreach ($item->products as $value)
                                          <li>{{$value->pivot->quantity}}</li>
                                          @endforeach
                                        </ul>
                                      </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $outcomes->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
