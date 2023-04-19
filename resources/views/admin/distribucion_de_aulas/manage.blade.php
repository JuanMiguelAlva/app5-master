@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.distribucion_de_aulas.index") }}">Distribución de Aulas</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Distribución de Aulas</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.distribucion_de_aulas.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage distribucion_de_aulas_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-lg-6">
                    <div class="form-group row multiSelect">
                        <label for="ciclo" class="col-md-2 col-lg-4 col-form-label">Ciclo:*</label>
                        <div class="col-md-10 col-lg-8" style="position: relative">
                            <select class="form-select" id="ciclo" name="ciclo" required="true" data-placeholder="{{trans('admiko.select')}}" style="width: 100%" data-width="100%" data-allow-clear="true">
                                
                                @foreach($ciclos_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('ciclo') ? old('ciclo') : $data->ciclo ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('ciclo')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="ciclo_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="seccin" class="col-md-2 col-lg-4 col-form-label">Sección:</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-select" id="seccin" name="seccin" >
                                <option value="">{{trans("admiko.select")}}</option>
                                @foreach($secciones_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('seccin') ? old('seccin') : $data->seccin ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('seccin')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="seccin_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row multiSelect">
                        <label for="aula" class="col-md-2 col-lg-4 col-form-label">Aula:*</label>
                        <div class="col-md-10 col-lg-8" style="position: relative">
                            <select class="form-select" id="aula" name="aula" required="true" data-placeholder="{{trans('admiko.select')}}" style="width: 100%" data-width="100%" data-allow-clear="true">
                                
                                @foreach($aulas_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('aula') ? old('aula') : $data->aula ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('aula')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="aula_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="turno" class="col-md-2 col-lg-4 col-form-label">Turno:*</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-select" id="turno" name="turno" required="true">
                                
                                @foreach($turno_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('turno') ? old('turno') : $data->turno ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('turno')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="turno_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer form-actions" id="form-group-buttons">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-sm-10">
                    @if(isset($ciclo)&&$ciclo!=null)
                    <input type="hidden" name="ciclo" value="{{$ciclo}}">
                    <button type="submit" class="btn btn-primary float-start me-1 mb-1 mb-sm-0 save-button">{{trans('admiko.table_save')}}</button>
                    <a href="{{route('admin.horarios.index')}}?ciclo={{$ciclo}}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                    @else
                    <button type="submit" class="btn btn-primary float-start me-1 mb-1 mb-sm-0 save-button">{{trans('admiko.table_save')}}</button>
                    <a href="{{ route("admin.distribucion_de_aulas.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
@endsection