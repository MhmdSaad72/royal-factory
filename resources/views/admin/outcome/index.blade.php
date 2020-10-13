@extends('adminlte::page')

@section('title', __('translations.outcomes'))

@section('content_header')
    <h1>{{ __('translations.outcomes') }}</h1>
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
                      <a href="{{ route('outcomes.create') }}" class="btn btn-success btn-sm" title="{{ __('translations.add_new') }}">
                          <i class="fa fa-plus" aria-hidden="true"></i>  {{ __('translations.add_new') }}
                      </a>
                      <a href="{{route('outcomes.canceled.reports')}}" class="btn btn-danger btn-sm" title="{{ __('translations.canceled_outcomes') }}">
                         <i class="fa fa-folder" aria-hidden="true"></i>  {{ __('translations.canceled_outcomes') }}
                     </a>
                     <a href="{{route('outcomes.reports.show')}}" class="btn btn-sm" style="background:#333; color:#fff;" title="{{ __('translations.period_reports') }}">
                       <i class="fa fa-folder" aria-hidden="true"></i>  {{ __('translations.period_reports') }}
                     </a>
                     <a href="{{route('outcome.export')}}" class="btn btn-sm" style="background:#186807; color:#fff;" title="{{ __('translations.outcome_excel') }}">
                         {{ __('translations.outcome_excel') }}
                     </a>
                     <form method="GET" action="{{ url('/admin/outcomes') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        {{-- <th>{{ __('translations.remaining_quantity') }}</th> --}}
                                        <th>{{ __('translations.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($outcomes as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->process_number }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->outcomePeriod($item->id) }}</td>
                                        {{-- <td>{{ $item->remainQuantityOutcome($item->id) }}</td> --}}
                                        <td>
                                          @if (!$item->cancel_reason)
                                            @if ($item->hasStores($item->id) == 0)
                                              <a href="{{ url('/admin/outcomes/cancel/' . $item->id) }}" title="{{__('translations.cancel')}}"><button class="btn btn-warning btn-sm "><i class="fa fa-eye" aria-hidden="true"></i> {{__('translations.cancel')}}</button></a>

                                            @endif
                                            <a href="{{ url('/admin/outcomes/' . $item->id) }}" title="{{ __('translations.print_view') }}"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ __('translations.print_view') }}</button></a>
                                            <a href="{{ url('/admin/outcomes/outcome-products/' . $item->id) }}" title="{{ __('translations.print_view_products') }}"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ __('translations.print_view_products') }}</button></a>
                                            <a href="{{ url('/admin/outcomes/' . $item->id . '/product') }}" title="{{ __('translations.add_products') }}"><button class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ __('translations.add_products') }}</button></a>

                                            <form method="POST" action="{{ url('/admin/outcomes' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                @if ($item->hasProducts() == 0 && $item->hasMaterials() == 0)
                                                  {{-- <button type="submit" class="btn btn-danger btn-sm" title="Delete Outcome" onclick="return confirm(&quot;{{__('translations.confirm_delete')}}&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> {{ __('translations.delete') }}</button> --}}
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
                            <div class="pagination-wrapper"> {!! $outcomes->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
