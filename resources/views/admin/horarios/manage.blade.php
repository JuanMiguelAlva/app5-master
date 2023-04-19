@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.horario.index") }}">Horario</a></li>
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
<a href="{{ route("admin.horario.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
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
                
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="time" class="col-md-2 col-form-label">Time:</label>
                        <div class="col-md-10">
                            <div class="input-group" id="timePicker_time" data-target-input="nearest">
                                <input type="text" autocomplete="off" style="max-width: 170px;border-right: unset;"
                                       data-date_time_format="{{config('admiko_config.form_time_format')}}"
                                       class="form-control datetimepicker-input timePicker"
                                       data-target="#timePicker_time"  id="time" data-toggle="datetimepicker"
                                       placeholder="Time" name="time" value="{{{ old('time', isset($data)?$data->time : '') }}}">
                                <div class="input-group-append input-group-text" data-target="#timePicker_time" data-toggle="datetimepicker">
                                    <i class="fas fa-clock fa-fw"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback @if ($errors->has('time')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="time_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="time1" class="col-md-2 col-form-label">Time:</label>
                        <div class="col-md-10">
                            <div class="input-group" id="timePicker_time1" data-target-input="nearest">
                                <input type="text" autocomplete="off" style="max-width: 170px;border-right: unset;"
                                       data-date_time_format="{{config('admiko_config.form_time_format')}}"
                                       class="form-control datetimepicker-input timePicker"
                                       data-target="#timePicker_time1"  id="time1" data-toggle="datetimepicker"
                                       placeholder="Time" name="time1" value="{{{ old('time1', isset($data)?$data->time1 : '') }}}">
                                <div class="input-group-append input-group-text" data-target="#timePicker_time1" data-toggle="datetimepicker">
                                    <i class="fas fa-clock fa-fw"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback @if ($errors->has('time1')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="time1_help" class="text-muted"></small>
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
                    <a href="{{ route("admin.horario.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection