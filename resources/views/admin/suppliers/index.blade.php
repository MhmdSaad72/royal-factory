@extends('adminlte::page')

@section('title', __('translations.all_suppliers'))

@section('content_header')
    <h1>{{ __('translations.all_suppliers') }}</h1>
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
                      <a href="{{ route('suppliers.create') }}" class="btn btn-success btn-sm" title="{{ __('translations.add_new') }}">
                          <i class="fa fa-plus" aria-hidden="true"></i> {{ __('translations.add_new') }}
                      </a>


                        <form method="GET" action="{{ url('/admin/suppliers') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>{{ __('translations.email') }}</th>
                                        <th>{{ __('translations.phone') }}</th>
                                        <th>{{ __('translations.contact_type') }}</th>
                                        <th>{{ __('translations.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($suppliers as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->contact_type }}</td>
                                        <td>
                                            <a href="{{ url('/admin/suppliers/' . $item->id) }}" title="{{ __('translations.supplier_orders') }}"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ __('translations.supplier_orders') }}</button></a>
                                            @if ($item->hasOrders() == 0)
                                              <a href="{{ url('/admin/suppliers/' . $item->id . '/edit') }}" title="{{ __('translations.edit') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ __('translations.edit') }}</button></a>
                                              <form method="POST" action="{{ url('/admin/suppliers' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                  {{ method_field('DELETE') }}
                                                  {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="{{ __('translations.delete') }}" onclick="return confirm(&quot;{{__('translations.confirm_delete')}}&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> {{ __('translations.delete') }}</button>
                                              </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $suppliers->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
