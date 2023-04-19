@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.resoluciones.index") }}">Resoluciones</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Resoluciones</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.resoluciones.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage resoluciones_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
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
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="documentos" class="col-md-2 col-form-label">Documentos:*</label>
                        <div class="col-md-10">
                            @if (isset($data->documentos) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data['fileInfo']["documentos"]['original']["folder"].$data->documentos))
                            <a href="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data['fileInfo']["documentos"]['original']["folder"].$data->documentos)}}" target="_blank">{{$data->documentos}}</a><br>
    
                            @endif
                            <input type="file" class="fileUpload mt-1" id="documentos"  name="documentos" @if(!isset($data) || !$data->documentos) required="true" @endIf>
                            <input type="hidden" id="documentos_admiko_current" name="documentos_admiko_current" value="{{$data->documentos??''}}">
                            <div class="invalid-feedback @if ($errors->has('documentos')) d-block @endif" data-required="{{trans('admiko.required_text')}}" data-size="{{trans('admiko.required_size')}}" data-type="{{trans('admiko.required_type')}}">
                                @if ($errors->has('documentos')){{ $errors->first('documentos') }}@endif
                            </div>
                            <small id="documentos_help" class="text-muted"></small>
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
                    <a href="{{ route("admin.resoluciones.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection