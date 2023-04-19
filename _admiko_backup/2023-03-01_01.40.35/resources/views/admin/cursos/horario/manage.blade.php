@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.cursos.index") }}">Cursos</a></li>
<li class="breadcrumb-item active"><a href="{{ route("admin.horario.index",[Request()->admiko_cursos_id]) }}">Horario</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Horario</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.horario.index",[Request()->admiko_cursos_id]) }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage horario_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="dia" class="col-md-2 col-lg-4 col-form-label">Dia:*</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-select" id="dia" name="dia" required="true">
                                
                                @foreach($dias_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('dia') ? old('dia') : $data->dia ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('dia')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="dia_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="aula" class="col-md-2 col-lg-4 col-form-label">Aula:*</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-select" id="aula" name="aula" required="true">
                                
                                @foreach($aulas_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('aula') ? old('aula') : $data->aula ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('aula')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="aula_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

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
                    <div class="form-group row">
                        <label for="hora_inicio" class="col-md-2 col-lg-4 col-form-label">Hora de inicio:*</label>
                        <div class="col-md-10 col-lg-8">
                            <div class="input-group" id="timePicker_hora_inicio" data-target-input="nearest">
                                <input type="text" autocomplete="off" style="max-width: 170px;border-right: unset;"
                                       data-date_time_format="{{config('admiko_config.form_time_format')}}"
                                       class="form-control datetimepicker-input timePicker"
                                       data-target="#timePicker_hora_inicio" required="true" id="hora_inicio" data-toggle="datetimepicker"
                                       placeholder="Hora de inicio" name="hora_inicio" value="{{{ old('hora_inicio', isset($data)?$data->hora_inicio : '') }}}">
                                <div class="input-group-append input-group-text" data-target="#timePicker_hora_inicio" data-toggle="datetimepicker">
                                    <i class="fas fa-clock fa-fw"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback @if ($errors->has('hora_inicio')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="hora_inicio_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="hora_fin" class="col-md-2 col-lg-4 col-form-label">Hora de fin:*</label>
                        <div class="col-md-10 col-lg-8">
                            <div class="input-group" id="timePicker_hora_fin" data-target-input="nearest">
                                <input type="text" autocomplete="off" style="max-width: 170px;border-right: unset;"
                                       data-date_time_format="{{config('admiko_config.form_time_format')}}"
                                       class="form-control datetimepicker-input timePicker"
                                       data-target="#timePicker_hora_fin" required="true" id="hora_fin" data-toggle="datetimepicker"
                                       placeholder="Hora de fin" name="hora_fin" value="{{{ old('hora_fin', isset($data)?$data->hora_fin : '') }}}">
                                <div class="input-group-append input-group-text" data-target="#timePicker_hora_fin" data-toggle="datetimepicker">
                                    <i class="fas fa-clock fa-fw"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback @if ($errors->has('hora_fin')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="hora_fin_help" class="text-muted"></small>
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
                    <a href="{{ route("admin.horario.index",[Request()->admiko_cursos_id]) }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection