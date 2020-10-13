@extends('adminlte::page')

@section('title', __('translations.edit_outcome'))

@section('content_header')
    <h1>{{ __('translations.edit_outcome') }}</h1>
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

                        <form method="POST" action="{{ url('/admin/outcomes/' . $outcome->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('admin.outcome.form', ['formMode' => 'edit'])

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
     var minus ;
// Assign Jquery Materials Variable To php Variable
     var materials = new Array();
     <?php foreach ($materials as $key => $value) { ?>
       materials.push({
         id : <?php echo $value->id ;?> ,
         name: '<?php echo $value->name ;?>'
       });
     <?php }?>

// Display Edit Form For Materials And quantity
    var html = '<?php foreach ($outcome->materials as $item) { ?>';
        count++;
        html += '<div id="div'+count+'" class="parentDiv">';
        html += '<hr>';
        html += '<label for="material_id'+count+'" class="control-label">{{ __('translations.material_name') }}*</label>';
        html += '<select name="material_id'+count+'" class="form-control material_id" id="material_id'+count+'" >';
        html += '<option value="" disabled>{{ __('translations.select_material_name') }}</option>';
        html += '<?php foreach ($materials as $material) {?>';
        html += '<option <?php if($material->id == $item->pivot->material_id ){echo 'selected';}?> value="<?php echo $material->id ?>"><?php echo $material->name ?></opyion>';
        html +='<?php }?>' ;
        html +='</select>';
        html +='<label for="quantity'+count+'" class="control-label">{{ __('translations.quantity') }}*</label>'
        html +='<input class="form-control" name="quantity'+count+'" type="number" id="quantity'+count+'" value="<?php echo $item->pivot->quantity; ?>" required>';
        html += "<input type='checkbox' name='record' class='record'><span class='error-message' style='margin-left:10px;display:none;'>{{__('translations.please_select_check_box_to_remove')}}</span>";
        html +=' <input type="hidden" name="count" value="'+count+'">';
        html += '</div>';
        html += '<?php } ?>';

      $('#group').append(html);

// Remove selected Options
   var selectedMaterial = new Array();
   for (var i = 1; i <= count ; i++) {
     selectedMaterial.push($('#material_id'+i).children("option:selected").val());

   }

   for (var i = 0; i < materials.length; i++) {
     for (var x = 0; x < selectedMaterial.length; x++) {
       if (materials[i].id == selectedMaterial[x] ) {
           materials.splice(i, 1);
       }
     }
  }

  // Display Remove And Submit Button
  if (selectedMaterial.length > 0) {

         $('#remove').css("display","inline");
          $('.submit').css("display","inline");
  }



//  Remove Checked Form
      $('#remove').on("click", function(){
          $(".parentDiv input[name='record']:checked").each(function(){ $(this).parent().remove(); });
          if ("input[name='record']:checked") {
            $('.error-message').css({'display':'inline','color':"red"});
          }
      });
// Actions After Click Add Button
          $('#add').click(function(){
            count++ ;
            $('#remove').css("display","inline");

        // Display Form For Material And Quantity
          var html = '<div id="div'+count+'" class="parentDiv">';
              html += '<hr>';
              html += '<label for="material_id'+count+'" class="control-label">{{ __('translations.material_name') }}*</label>';
              html += '<select name="material_id'+count+'" class="form-control material_id" id="material_id'+count+'"required >';
              html += '<option value="" selected disabled>{{ __('translations.select_material_name') }}</option>';
              for (var i = 0; i < materials.length; i++) {;
             html += '<option value="'+materials[i].id+'">'+materials[i].name+'</option>';
              } ;
              html +='</select>';
              html +='<label for="quantity'+count+'" class="control-label">{{ __('translations.quantity') }}*</label>'
              html +='<input class="form-control" name="quantity'+count+'" type="number" id="quantity'+count+'" value="{{ isset($outcome->quantity) ? $outcome->quantity : old('quantity')}}" required>';
              html += "<input type='checkbox' name='record' class='record'><span class='error-message' style='margin-left:10px;display:none;'>{{__('translations.please_select_check_box_to_remove')}}</span>";
              html +=' <input type="hidden" name="count" value="'+count+'">';
              html += '</div>';
            $('#group').append(html);
        // Decrease Selected Option Of Materials
            $("select.material_id").change(function(){
                var selectedMaterial = $(this).children("option:selected").val();
                for (var i = 0; i < materials.length; i++) {
                  if (materials[i].id == selectedMaterial ) {
                     materials.splice(i, 1);
                  }
                }
            });

            });
// Action In ajax when Click Submit Button
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
