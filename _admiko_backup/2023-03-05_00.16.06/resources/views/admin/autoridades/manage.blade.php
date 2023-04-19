@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.autoridades.index") }}">Autoridades</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Autoridades</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.autoridades.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage autoridades_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-12">
                    <div class="form-group row multiSelect">
                        <label for="docente" class="col-md-2 col-form-label">Docente:*</label>
                        <div class="col-md-10" style="position: relative">
                            <select class="form-select" id="docente" name="docente" required="true" data-placeholder="{{trans('admiko.select')}}" style="width: 100%" data-width="100%" data-allow-clear="true">
                                
                                @foreach($docentes_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('docente') ? old('docente') : $data->docente ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('docente')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="docente_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row multiSelect">
                        <label for="cargo" class="col-md-2 col-lg-4 col-form-label">Cargo:*</label>
                        <div class="col-md-10 col-lg-8" style="position: relative">
                            <select class="form-select" id="cargo" name="cargo" required="true" data-placeholder="{{trans('admiko.select')}}" style="width: 100%" data-width="100%" data-allow-clear="true">
                                
                                @foreach($cargo_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('cargo') ? old('cargo') : $data->cargo ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('cargo')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="cargo_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row multiSelect">
                        <label for="unidad" class="col-md-2 col-lg-4 col-form-label">Unidad:*</label>
                        <div class="col-md-10 col-lg-8" style="position: relative">
                            <select class="form-select" id="unidad" name="unidad" required="true" data-placeholder="{{trans('admiko.select')}}" style="width: 100%" data-width="100%" data-allow-clear="true">
                                
                                @foreach($unidad_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('unidad') ? old('unidad') : $data->unidad ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('unidad')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="unidad_help" class="text-muted"></small>
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
                    <a href="{{ route("admin.autoridades.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection