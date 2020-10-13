@extends('adminlte::page')

@section('title', __('translations.dashboard_home'))
@section('css')
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@stop

@section('content_header')
    <h1>{{__('translations.dashboard_home')}}</h1>
@stop
@section('content')

<div class="container" style="width:1030px;">
  <div class="row">
    <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$materials}}</h3>

              <p>{{__('translations.all_materials')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('materials.index')}}" class="small-box-footer">{{__('translations.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-navy">
            <div class="inner">
              <h3>{{$suppliers}}</h3>

              <p>{{__('translations.all_suppliers')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{route('suppliers.index')}}" class="small-box-footer">{{__('translations.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$products}}</h3>

              <p>{{__('translations.products')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cart-outline"></i>
            </div>
            <a href="{{route('products.index')}}" class="small-box-footer">{{__('translations.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <h3>{{$employees}}</h3>

              <p>{{__('translations.employees')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="{{route('employee.index')}}" class="small-box-footer">{{__('translations.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

   </div>
   <div class="row">
     <div class="col-lg-3 col-xs-6">
           <!-- small box -->
           <div class="small-box bg-green">
             <div class="inner">
               <h3>{{$outcomes}}</h3>

               <p>{{__('translations.outcomes')}}</p>
             </div>
             <div class="icon">
               <i class="ion ion-ios-barcode-outline"></i>
             </div>
             <a href="{{route('outcomes.index')}}" class="small-box-footer">{{__('translations.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
           </div>
         </div>
         <div class="col-lg-3 col-xs-6">
           <!-- small box -->
           <div class="small-box bg-orange">
             <div class="inner">
               <h3>{{$stores}}</h3>

               <p>{{__('translations.store_details')}}</p>
             </div>
             <div class="icon">
               <i class="ion  ion-android-playstore"></i>
             </div>
             <a href="{{route('stores.index')}}" class="small-box-footer">{{__('translations.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
           </div>
         </div>

         <div class="col-lg-3 col-xs-6">
           <!-- small box -->
           <div class="small-box bg-maroon">
             <div class="inner">
               <h3>{{$orders}}</h3>

               <p>{{__('translations.orders')}}</p>
             </div>
             <div class="icon">
               <i class="ion ion-pie-graph"></i>
             </div>
             <a href="{{route('orders.index')}}" class="small-box-footer">{{__('translations.more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
           </div>
         </div>

    </div>

</div>
@endsection

@section('js')
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="dist/js/demo.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="dist/js/pages/dashboard2.js"></script>
@stop
