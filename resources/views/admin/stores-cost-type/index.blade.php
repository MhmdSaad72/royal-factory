@extends('adminlte::page')

@section('title', 'Stores Cost Types')

@section('content_header')
    <h1>{{ __('translations.stores_cost_types') }}</h1>
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
                      <a href="{{ route('stores-cost-type.create') }}" class="btn btn-success btn-sm" title="Add New IndirectCost">
                          <i class="fa fa-plus" aria-hidden="true"></i> {{ __('translations.add_new') }}
                      </a>


                        <form method="GET" action="{{ url('/admin/stores-cost-type') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>{{ __('translations.name') }}</th>
                                        <th>{{ __('translations.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($storescosttype as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ url('/admin/stores-cost-type/' . $item->id . '/edit') }}" title="Edit StoresCostType"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ __('translations.edit') }}</button></a>

                                            <form method="POST" action="{{ url('/admin/stores-cost-type' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                @if ($item->hasStoresCost()  == 0)
                                                  <button type="submit" class="btn btn-danger btn-sm" title="Delete StoresCostType" onclick="return confirm(&quot;{{__('translations.confirm_delete')}}&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> {{ __('translations.delete') }}</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $storescosttype->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
