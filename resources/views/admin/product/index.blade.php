@extends('adminlte::page')

@section('title', __('translations.products'))

@section('content_header')
    <h1>{{ __('translations.products') }}</h1>
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
                      <a href="{{ route('products.create') }}" class="btn btn-success btn-sm" title="{{ __('translations.add_new') }}">
                          <i class="fa fa-plus" aria-hidden="true"></i>  {{ __('translations.add_new') }}
                      </a>


                        <form method="GET" action="{{ url('/admin/products') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>{{ __('translations.remaining_quantity') }}</th>
                                        <th>{{ __('translations.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->remainingQuantity($item->id) }}</td>
                                        <td>
                                          <a href="{{ url('/admin/products/outcomes/' . $item->id ) }}" title="{{ __('translations.product_outcomes') }}"><button class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ __('translations.product_outcomes') }}</button></a>
                                          <a href="{{ url('/admin/products/stores/' . $item->id ) }}" title="{{ __('translations.stores') }}"><button class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ __('translations.stores') }}</button></a>
                                          <a href="{{ url('/admin/products/movement/' . $item->id) }}" title="{{ __('translations.product_movements') }}"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ __('translations.product_movements') }}</button></a>

                                            @if ($item->hasOutcomes() == 0)
                                              <a href="{{ url('/admin/products/' . $item->id . '/edit') }}" title="{{ __('translations.edit') }}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ __('translations.edit') }}</button></a>
                                              <form method="POST" action="{{ url('/admin/products' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
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
                            <div class="pagination-wrapper"> {!! $products->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
