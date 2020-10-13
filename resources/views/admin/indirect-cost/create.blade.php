@extends('adminlte::page')

@section('title', __('translations.create_new_indirect_cost'))

@section('content_header')
    <h1>{{ __('translations.create_new_indirect_cost') }}</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('/admin/indirect-cost') }}" title="{{ __('translations.back') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('translations.back') }}</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/admin/indirect-cost') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('indirect_cost_type_id') ? 'has-error' : ''}}">
                                <label for="indirect_cost_type_id" class="control-label">{{ __('translations.indirect_cost_type') }}*</label>
                                <select name="indirect_cost_type_id" class="form-control" id="indirect_cost_type_id" >
                                  <option value=""selected disabled>{{ __('translations.select_indirect_cost_type') }}</option>
                                  @foreach($indirectCostTypes as $indirectCostType)
                                    <option value="{{$indirectCostType->id}}"{{$indirectCostType->id == old('indirect_cost_type_id') ? 'selected' : ''}}>{{$indirectCostType->name}}</option>
                                  @endforeach

                            </select>
                                {!! $errors->first('indirect_cost_type_id', '<p class="help-block">:message</p>') !!}
                            </div>

                            @include ('admin.indirect-cost.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
