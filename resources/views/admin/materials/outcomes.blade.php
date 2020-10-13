@extends('adminlte::page')

@section('title', __('translations.material_outcomes'))

@section('content_header')
    <h1 class="header">{{ __('translations.material_outcomes') }}</h1>
@stop

@section('content')
    <div class="container" style="width:1030px;" >
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ url('/admin/materials') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm print-hide"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        @if ($material->hasOutcomes() > 0)
                        <form method="GET" action="{{ url('/admin/materials/outcomes/' . $material->id) }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                          @include ('admin.partials.form')
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
                                      <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($outcomes as $item)
                                  {{-- @if ($item->created_at >= $choosenDate && $item->created_at <= $currentDate) --}}
                                    <tr>
                                      <td>{{ $item->id }}</td>
                                      <td>{{ $item->process_number }}</td>
                                      <td>{{ $item->created_at }}</td>
                                      <td>{{ $item->outcomePeriod($item->id) }}</td>
                                      <td>@if (!is_null($item->cancel_reason))
                                        <span style="font-weight:bold; color:red">{{__('translations.canceled')}}</span>
                                      @endif</td>
                                    </tr>
                                  {{-- @endif --}}
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $outcomes->appends(['choosen_date' => Request::get('choosen_date') , 'current_date' => Request::get('current_date')])->render() !!} </div>
                        </div>
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
