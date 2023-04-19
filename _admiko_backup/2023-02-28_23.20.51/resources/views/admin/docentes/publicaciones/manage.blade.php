@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.docentes.index") }}">Docentes</a></li>
<li class="breadcrumb-item active"><a href="{{ route("admin.publicaciones.index",[Request()->admiko_docentes_id]) }}">Publicaciones</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Publicaciones</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.publicaciones.index",[Request()->admiko_docentes_id]) }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage publicaciones_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
				@if(!isset($data) || $data->admiko_dynamic_fields->contains("nombre"))
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="nombre" class="col-md-2 col-form-label">Nombre:*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nombre" name="nombre" required="true" placeholder="Nombre"  value="{{{ old('nombre', isset($data)?$data->nombre : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('nombre')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="nombre_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
				@endif
            </div>
        </div>
        <div class="card-footer form-actions" id="form-group-buttons">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary float-start me-1 mb-1 mb-sm-0 save-button">{{trans('admiko.table_save')}}</button>
                    <a href="{{ route("admin.publicaciones.index",[Request()->admiko_docentes_id]) }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
        @if(auth()->user()->role_id == 1 && isset($data))
        <legend class="action">{{trans('admiko.dynamic_form_elements')}}</legend>
        <div class="card formPage">
            <legend class="action">{{trans('admiko.dynamic_form_elements_description')}}
                <small id="image_help" class="text-muted">{{trans('admiko.dynamic_form_elements_info')}}</small>
            </legend>
            <form method="POST" action="{{route('admin.publicaciones.admiko_dynamic_fields',[Request()->admiko_docentes_id,$data->id])}}">
                @csrf
                <div class="card-body">
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="admiko_dynamic_field_nombre" class="col-md-2 col-form-label">Nombre:</label>
                        <div class="col-md-10">
                            <div class="form-check form-checkbox">
                                <input class="form-check-input" type="checkbox" id="admiko_dynamic_field_nombre" name="admiko_dynamic_fields[]" @if($data->admiko_dynamic_fields->contains("nombre")) checked @endif value="nombre">
                                <label class="form-check-label" for="admiko_dynamic_field_nombre"></label>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="card-footer">
                    <div class="form-group form-actions mb-0">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary me-1 mb-1 mb-sm-0">{{trans('admiko.table_save')}}</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="save_dynamic_fields"/>
                </div>
            </form>
        </div>
        @endif
@endsection