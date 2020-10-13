@extends('adminlte::page')

@section('title', __('translations.material_movements'))

@section('content_header')
    <h1 class="header">{{ __('translations.material_movements') }}</h1>
@stop

@section('content')
    <div class="container" style="width:1030px;" >
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ url('/admin/materials') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm print-hide"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        @if ($material->hasOutcomes() > 0 || $material->hasOrders() > 0)
                        <form method="GET" action="{{ route('materials.movement' , ['id'=>$material->id]) }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                             @include ('admin.partials.form')
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                      <th>{{ __('translations.type') }}</th>
                                      <th>{{ __('translations.created_at') }}</th>
                                      <th>{{__('translations.process_number')}}</th>
                                      <th>{{ __('translations.quantity') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($material->orders as $item)
                                    @if ($item->created_at >= $choosenDate && $item->created_at <= $currentDate)
                                      @if (is_null($item->cancel_reason))
                                        <tr>
                                          <td>{{ __('translations.import') }}</td>
                                          <td>{{ $item->created_at }}</td>
                                          <td>{{ $item->process_number }}</td>
                                          <td>{{ $item->quantity }}</td>
                                        </tr>
                                      @endif
                                    @endif
                                  @endforeach
                                  @foreach($material->outcomes as $item)
                                    @if ($item->created_at >= $choosenDate && $item->created_at <= $currentDate)
                                      @if (is_null($item->cancel_reason))
                                        <tr>
                                          <td>{{ __('translations.out') }}</td>
                                          <td>{{ $item->created_at }}</td>
                                          <td>{{ $item->process_number }}</td>
                                          <td>{{ $item->pivot->quantity }}</td>
                                        </tr>
                                      @endif
                                    @endif
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- <button type="button" class="btn btn-success print print-hide"name="button">{{__('translations.PRINT')}}</button> --}}
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
