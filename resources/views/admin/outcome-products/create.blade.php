@extends('adminlte::page')

@section('title', __('translations.create_outcome_product'))

@section('content_header')
    <h1>{{ __('translations.create_outcome_product') }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('/admin/outcomes/') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form   method="POST" action="{{ url('/admin/outcomes/outcome-products') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" id="test">
                            {{ csrf_field() }}
                            <div class="">
                              <h3>{{__('translations.process_number')}}:{{$outcome->process_number}}</h3>
                            </div>

                            @include ('admin.outcome-products.form', ['formMode' => 'create'])


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
  <script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
      </script>
    <script type="text/javascript">

    $(document).ready(function(){
      var count = 0,
          minus ,
          index ,
          outcomeProduct= new Array(),
          products = new Array();
      // All Products
      <?php foreach ($products as $key => $value) { ?>
        products.push({
          id : <?php echo $value->id ;?> ,
          name: '<?php echo $value->name ;?>'
        });
      <?php }?>
      // All Outcome Products
      <?php foreach ($outcome->products as  $value): ?>
        outcomeProduct.push(<?php echo $value->id ;?>);
      <?php endforeach; ?>
      // Remove Products WHich Related To This Outcome
          for (var i in products) {
              for (var x in outcomeProduct) {
                if (products[i].id == outcomeProduct[x]) {
                  products.splice(i, 1);
                }
              }
          }
          console.log(products);
//  Process After Click On Add Button
        $('#add').click(function(){
          count++ ;
          $('.submit').css('display','inline');

          // Test
          var caf = '';
          for (var i = 0; i < products.length; i++) {;
            caf += '<option value="'+products[i].id+'">'+products[i].name+'</opyion>';
          }
          // Test

       var  html = '<div id="div'+count+'" class="parentDiv">';
            html += '<hr>';
            html += '<label for="quantity'+count+'" class="control-label">{{ __('translations.quantity') }}*</label>'
            html += '<input class="form-control" name="quantity'+count+'" type="number" id="quantity'+count+'" value="{{ isset($outcome->quantity) ? $outcome->quantity : old('quantity')}}" required>';
            html += '<label for="product_id'+count+'" class="control-label">{{ __('translations.products') }}*</label>';
            html += '<select name="product_id'+count+'" class="form-control product_id" id="product_id'+count+'" required>';
            html += '<option value="" selected disabled>{{ __('translations.select_product') }}</option>';
           //  for (var i = 0; i < products.length; i++) {;
           // html += '<option value="'+products[i].id+'">'+products[i].name+'</opyion>';
           //  } ;
            html +=caf;
            html +='</select>';
            html += "<input type='checkbox' name='record' class='record'><span class='error-message' style='margin-left:10px;display:none;'>{{__('translations.please_select_check_box_to_remove')}}</span>";
            html +='<input type="hidden" name="count" value="'+count+'">';
            html +='<input type="hidden" name="outcome" value="{{$outcome->id}}">';
            html += '</div>';
          $('#group').append(html);
          $('#remove').css("display","inline");
        });
        setInterval(function(){
          $("select.product_id").change(function(){
              var selectedProduct = $(this).children("option:selected").val();
              for (var i = 0; i < products.length; i++) {
                if (products[i].id == selectedProduct ) {
                   products.splice(i, 1);
                }
              }
          });
        }, 1000);
        $('#remove').on("click", function(){
            $(".parentDiv input[name='record']:checked").each(function(){ $(this).parent().remove(); });
            if ("input[name='record']:checked") {
              $('.error-message').css({'display':'inline','color':"red"});
            }
        });

//  Submit data With Ajax
          $(".submit").click(function() {
            function sendData(){
                  $.ajax({
                      url:"/admin/outcome-products/",
                      type: 'POST',
                      dataType:'json',
                      contentType: 'json',
                      data: {data:data},
                      contentType: 'application/json; charset=utf-8',
                      success: function (data)
                        {
                            console.log(data);
                        },
                  });
            }

            });
     });

    </script>
@stop
