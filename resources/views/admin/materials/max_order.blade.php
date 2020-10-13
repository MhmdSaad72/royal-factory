@extends('adminlte::page')

@section('title', __('translations.under_max_order'))

@section('content_header')
    <h1>{{ __('translations.under_max_order') }}</h1>
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
                      <a href="{{ url('/admin/materials') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('translations.name') }}</th>
                                        <th>{{ __('translations.created_at') }}</th>
                                        <th>{{ __('translations.quantity_type') }}</th>
                                        <th>{{ __('translations.type') }}</th>
                                        <th>{{ __('translations.material_type') }}</th>
                                        <th>{{ __('translations.remaining_quantity') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($materials as $item)
                                  @if (($item->allMaxOrders($item->id))->count() == 0)

                                    <tr>
                                        <td>{{$item->name }}</td>
                                        <td>{{$item->created_at }}</td>
                                        <td>{{$item->quantity_type ?  __('translations.piece') :  __('translations.kilo')}}</td>
                                        <td>{{$item->type ?  __('translations.secondary') :  __('translations.primary') }}</td>
                                        <td>{{$item->material_type['name']}}</td>
                                        <td>{{$item->remainingQuantity($item->id)}}</td>
                                    </tr>
                                  @endif
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $materials->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
