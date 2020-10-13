@extends('adminlte::page')

@section('title', __('translations.order'))

@section('content_header')
    <h1 class="header">{{ __('translations.order') }}</h1>
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
    <div class="container" style="width:1030px;" >
      <h2 class="text-center headerPrint">{{__('translations.royal_factory')}}</h2>
      <div class="row">
        <div class="h3 text-center col-md-3 permPrint" style="border:1px solid; margin:auto;">{{__('translations.supply_permission')}}</div>
      </div>
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ url('/admin/orders') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm print-hide"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>

                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                      <th> {{ __('translations.date_of_order') }} </th><td> {{ $order->created_at }} </td>
                                    </tr>
                                    <tr>
                                      <th> {{ __('translations.process_number_order') }} </th><td> {{ $order->process_number }} </td>
                                    </tr>
                                    <tr>
                                      <th> {{ __('translations.quantity') }} </th><td> {{ $order->quantity }} </td>
                                    </tr>
                                    <tr>
                                      <th> {{ __('translations.expire_date') }} </th><td> {{ $order->expire_date }} </td>
                                    </tr>
                                    <tr>
                                      <th> {{ __('translations.material_name') }} </th><td> {{$order->material['name']}}</td>                                    </tr>
                                    <tr>
                                      <th> {{ __('translations.supplier_name') }} </th><td> {{$order->supplier['name']}}</td>
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
            <img src="{{asset('lux-new-logo.png')}}" alt="logo" style="width:100px;" class="logoPrint">
            <p class="logoPrint  h3">امضاء المسؤول</p>
           </div>
        </div>
    </div>

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
