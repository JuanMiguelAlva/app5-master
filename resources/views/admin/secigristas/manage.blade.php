@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.secigristas.index") }}">SECIGRISTAS</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>SECIGRISTAS</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.secigristas.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage secigristas_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="nombres" class="col-md-2 col-lg-4 col-form-label">Nombres:*</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" id="nombres" name="nombres" required="true" placeholder="Nombres"  value="{{{ old('nombres', isset($data)?$data->nombres : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('nombres')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="nombres_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="apellidos" class="col-md-2 col-lg-4 col-form-label">Apellidos:*</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required="true" placeholder="Apellidos"  value="{{{ old('apellidos', isset($data)?$data->apellidos : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('apellidos')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="apellidos_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="unidad_receptora" class="col-md-2 col-form-label">Unidad Receptora:*</label>
                        <div class="col-md-10">
                            <textarea class="form-control form-control-textarea " id="unidad_receptora" name="unidad_receptora" required="true" placeholder="Unidad Receptora">{{{ old('unidad_receptora', isset($data)?$data->unidad_receptora : '') }}}</textarea>
                            <div class="invalid-feedback @if ($errors->has('unidad_receptora')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="unidad_receptora_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer form-actions" id="form-group-buttons">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary float-start me-1 mb-1 mb-sm-0 save-button">{{trans('admiko.table_save')}}</button>
                    <a href="{{ route("admin.secigristas.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection