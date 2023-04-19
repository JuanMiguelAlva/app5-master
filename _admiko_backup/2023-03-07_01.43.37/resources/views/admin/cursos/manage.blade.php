@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.cursos.index") }}">Cursos</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Cursos</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.cursos.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage cursos_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="codigo" class="col-md-2 col-lg-4 col-form-label">Código:*</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control limitPozNegNumbers numbersWidth" id="codigo" name="codigo" required="true" placeholder="Código"
                                   step="1" 
                                   value="{{{ old('codigo', isset($data)?$data->codigo : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('codigo')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="codigo_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="ciclo" class="col-md-2 col-lg-4 col-form-label">Ciclo:*</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-select" id="ciclo" name="ciclo" required="true">
                                
                                @foreach($ciclos_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('ciclo') ? old('ciclo') : $data->ciclo ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('ciclo')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="ciclo_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

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
                        <label for="linea" class="col-md-2 col-form-label">Línea de Carrera:*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="linea" name="linea" required="true" placeholder="Línea de Carrera"  value="{{{ old('linea', isset($data)?$data->linea : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('linea')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="linea_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="horas_t" class="col-md-2 col-lg-4 col-form-label">Horas Teóricas:*</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control limitPozNegNumbers numbersWidth" id="horas_t" name="horas_t" required="true" placeholder="Horas Teóricas"
                                   step="1"  data-min="1" min="1" data-max="5" max="5"
                                   value="{{{ old('horas_t', isset($data)?$data->horas_t : '1') }}}">
                            <div class="invalid-feedback @if ($errors->has('horas_t')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="horas_t_help" class="text-muted"> Min: 1 Max: 5</small>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="horas_p" class="col-md-2 col-lg-4 col-form-label">Horas Prácticas:*</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control limitPozNegNumbers numbersWidth" id="horas_p" name="horas_p" required="true" placeholder="Horas Prácticas"
                                   step="1"  data-min="1" min="1" data-max="5" max="5"
                                   value="{{{ old('horas_p', isset($data)?$data->horas_p : '1') }}}">
                            <div class="invalid-feedback @if ($errors->has('horas_p')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="horas_p_help" class="text-muted"> Min: 1 Max: 5</small>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="creditos" class="col-md-2 col-lg-4 col-form-label">Créditos:*</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control limitPozNegNumbers numbersWidth" id="creditos" name="creditos" required="true" placeholder="Créditos"
                                   step="1"  data-min="1" min="1" data-max="5" max="5"
                                   value="{{{ old('creditos', isset($data)?$data->creditos : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('creditos')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="creditos_help" class="text-muted"> Min: 1 Max: 5</small>
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
                    <a href="{{ route("admin.cursos.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection