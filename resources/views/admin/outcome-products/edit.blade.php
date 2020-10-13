@extends('adminlte::page')

@section('title', __('translations.edit_outcome_product'))

@section('content_header')
    <h1>{{ __('translations.edit_outcome_product') }}</h1>
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

                        <form method="POST" action="{{ url('/admin/outcomes/outcome-products/' . $outcome->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('admin.outcome-products.form', ['formMode' => 'edit'])

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

     var count = 0 ;

     $('#add').css('display','none');
    var html = '<?php foreach ($outcome->products as $item) {  ?>';
        count++;
        html += '<div id="div'+count+'" class="parentDiv" >';
        html += '<hr>';
        html += '<label for="quantity'+count+'" class="control-label">{{ __('translations.quantity') }}*</label>'
        html += '<input class="form-control" name="quantity'+count+'" type="number" id="quantity'+count+'" value="{{$item->pivot->quantity}}" required>';
        html += '<label for="product_id'+count+'" class="control-label">{{ __('translations.products') }}*</label>';
        html += '<select name="product_id'+count+'" class="form-control" id="product_id'+count+'" >';
        html += '<option value="" disabled>{{ __('translations.select_products') }}</option>';
        html += '<?php foreach ($products as $product) {?>';
        html += '<option <?php if($product->id == $item->pivot->product_id ){echo 'selected';}?> value="<?php echo $product->id ?>"><?php echo $product->name ?></opyion>';
        html +='<?php }?>' ;
        html +='</select>';
        html += "<input type='checkbox' name='record' class='record'><span class='error-message' style='margin-left:10px;display:none;'>{{__('translations.please_select_check_box_to_remove')}}</span>";
        html +=' <input type="hidden" name="count" value="'+count+'">';
        html += '</div>';
        html += '<?php } ?>';

      $('#group').append(html);
      if (count > 0) {
        $('#remove').css("display","inline");
        $('.submit').css("display","inline");
      }


        $('#remove').on("click", function(){
            $(".parentDiv input[name='record']:checked").each(function(){ $(this).parent().remove(); });
            if ("input[name='record']:checked") {
              $('.error-message').css({'display':'inline','color':"red"});
            }
        });

        $(".submit").click(function() {
          function sendData(){
                $.ajax({
                    url:"/admin/outcomes/{outcome}",
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
