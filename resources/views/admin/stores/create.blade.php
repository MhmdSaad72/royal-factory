@extends('adminlte::page')

@section('title', __('translations.create_new_store'))

@section('content_header')
    <h1>{{ __('translations.create_new_store') }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('/admin/stores') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        <br />
                        <br />
                        @if (session('flash_message'))
                            <div class="alert alert-danger" style="margin:10px 0;">{{ session('flash_message') }}</div>
                        @endif

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/admin/stores') }}" accept-charset="UTF-8" id="form" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('admin.stores.form', ['formMode' => 'create'])

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
          products = new Array();
      <?php foreach ($products as $key => $value) { ?>
        products.push({
          id : <?php echo $value->id ;?> ,
          name: '<?php echo $value->name ;?>'
        });
      <?php }?>
      $('#add').click(function(){
        count++ ;

       var  html = '<div id="div'+count+'" class="parentDiv" >';
            html += '<hr>';
            html += '<label for="product_id'+count+'" class="control-label">{{ __('translations.product') }}*</label>';
            html += '<select name="product_id'+count+'" data-count="'+count+'" class="form-control product_id" id="product_id'+count+'" required >';
            html += '<option value="" selected disabled>{{ __('translations.select_product') }}</option>';
             for (var i = 0; i < products.length; i++) {;
            html += '<option value="'+products[i].id+'">'+products[i].name+'</option>';
             } ;
            html +='</select>';
            html += '<label for="code_number'+count+'" class="control-label">{{ __('translations.code_number_outcome') }}*</label>';
            html += '<select name="code_number'+count+'" class="form-control code_number'+count+'" id="code_number'+count+'" required >';
            html += '<option value="" selected disabled>{{ __('translations.select_code_number') }}</option>';
            html +='</select>';
            html +='<label for="quantity'+count+'" class="control-label">{{ __('translations.quantity') }}*</label>'
            html +='<div class="input'+count+'">';
            html +='</div>';
            html += "<input type='checkbox' name='record' class='record'><span class='error-message' style='margin-left:10px;display:none;'>{{__('translations.please_select_check_box_to_remove')}}</span>";
            html +=' <input type="hidden" name="count" value="'+count+'">';
            html += '</div>';
          $('#group').append(html);

          $('#remove').css("display","inline");
        });
        setInterval(function(){
          $(".product_id").change(function(){
            var selectedProduct = $(this).children("option:selected").val(),
                number = $(this).data('count');

            $.get( '{{ url('admin/products/api') }}/'+ selectedProduct , function( result ) {
                $('.code_number'+count).html('');
                for (var i = 0; i < result.outcomes.length; i++) {
                  $('.code_number'+count).append('<option value="'+result.outcomes[i]+'">'+result.outcomes[i]+'</option>');
                 } ;

                 var input ='<input class="form-control" name="quantity'+number+'" min="1" max="'+result.quantity+'" type="number" id="quantity'+number+'"  required style="margin-top: 5px">';
                  $('.input'+number).html('');
                  $('.input'+number).append(input);
            });
            for (var i = 0; i < products.length; i++) {
              if (products[i].id == selectedProduct ) {
                 products.splice(i, 1);
              }
            }
            $('select.product_id').off('change');
          });

        }, 1000);
        //  Remove Checked Form
              $('#remove').on("click", function(){
                  $(".parentDiv input[name='record']:checked").each(function(){ $(this).parent().remove(); });
                  if ("input[name='record']:checked") {
                    $('.error-message').css({'display':'inline','color':"red"});
                  }
              });
          $(".submit").click(function() {
            function sendData(){
                  $.ajax({
                      url:"/admin/stores/",
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
