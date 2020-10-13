@extends('adminlte::page')

@section('title', __('translations.outcome'))

@section('content_header')
    <h1 class="header">{{ __('translations.outcome') }}</h1>
@stop
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
.header{
  display: none;
}
</style>

@section('content')
    <div class="container">
      <h2 class="text-center headerPrint">{{__('translations.royal_factory')}}</h2>
      <div class="row">
        <div class="h3 text-center col-md-3 permPrint" style="border:1px solid; margin:auto;">اذن تشغيل</div>
      </div>
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ url('/admin/outcomes/') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm print-hide"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>

                        <br/>
                        <br/>
  @if ($outcome->hasMaterials() > 0)
                        <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">{{ __('translations.process_number_outcome') }}</th>
                                  <th scope="col">{{ __('translations.material_name') }}</th>
                                  <th scope="col">{{ __('translations.quantity') }}</th>
                                  <th scope="col">{{ __('translations.created_at') }}</th>
                                  <th scope="col">{{ __('translations.order_number') }}</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>{{ $outcome->process_number }}</td>
                                  <td><ul>
                                    @foreach ($outcome->materials as $item)
                                    <li>{{$item->name}}</li>
                                    @endforeach
                                  </ul></td>
                                  <td><ul>
                                    @foreach ($outcome->materials as $item)
                                    <li>{{$item->pivot->quantity}}</li>
                                    @endforeach
                                  </ul></td>
                                  <td>
                                    <ul>
                                      @foreach ($outcome->materials as $item)
                                      <li>{{$item->pivot->created_at}}</li>
                                      @endforeach
                                    </ul>
                                  </td>
                                  <td>
                                  <ul>
                                    @foreach ($outcome->materials as $item)
                                    <li>{{$item->pivot->order_number}}</li>
                                    @endforeach
                                  </ul>
                                </td>
                                </tr>
                              </tbody>
                            </table>

                        </div>
                        <button type="button" class="btn btn-success print print-hide"name="button">{{__('translations.PRINT')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row logoPrint" style="justify-content:end;">
          <div class="col-md-3">
            <img src="{{asset('lux-new-logo.png')}}" alt="logo" style="max-width:100%;" class="logoPrint">
            <p class="logoPrint  h3">امضاء المسؤول</p>
           </div>
        </div>
    </div>
@endif
@endsection
@section('js')
  <script type="text/javascript">
  $( document ).ready(function() {
    $( ".print" ).click(function( event ) {
      event.preventDefault();
      window.print();
      });
    });
  </script>

@endsection
