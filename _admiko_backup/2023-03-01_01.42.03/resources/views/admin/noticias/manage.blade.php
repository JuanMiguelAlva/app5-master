@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.noticias.index") }}">Noticias</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Noticias</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.noticias.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage noticias_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="titulo" class="col-md-2 col-form-label">Título:*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="titulo" name="titulo" required="true" placeholder="Título"  value="{{{ old('titulo', isset($data)?$data->titulo : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('titulo')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="titulo_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="fecha" class="col-md-2 col-form-label">Fecha:*</label>
                        <div class="col-md-10">
                            <div class="input-group" id="datePicker_fecha" data-target-input="nearest">
                                <input type="text" autocomplete="off" style="max-width: 170px;border-right: unset;"
                                       data-date_time_format="{{config('admiko_config.form_date_format')}}"
                                       class="form-control datetimepicker-input datePicker"
                                       data-target="#datePicker_fecha" required="true" id="fecha" data-toggle="datetimepicker"
                                       placeholder="Fecha" name="fecha" value="{{{ old('fecha', isset($data)?$data->fecha : '') }}}">
                                <div class="input-group-append input-group-text" data-target="#datePicker_fecha" data-toggle="datetimepicker">
                                    <i class="fas fa-calendar-alt fa-fw"></i>
                                </div>
                            </div>
                            <div class="invalid-feedback @if ($errors->has('fecha')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="fecha_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="descripcion" class="col-md-2 col-form-label">Descripción:*</label>
                        <div class="col-md-10">
                            <textarea class="form-control form-control-textarea simple_text_editor" id="descripcion" name="descripcion" required="true" placeholder="Descripción">{{{ old('descripcion', isset($data)?$data->descripcion : '') }}}</textarea>
                            <div class="invalid-feedback @if ($errors->has('descripcion')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="descripcion_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="imagen" class="col-md-2 col-form-label">Imagen:</label>
                        <div class="col-md-10">
                            @if (isset($data->imagen) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data['fileInfo']["imagen"]['original']["folder"].$data->imagen))
                            <a href="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data['fileInfo']["imagen"]['original']["folder"].$data->imagen) }}" target="_blank" class="tableImage">
                                    <img src="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data['fileInfo']["imagen"]['original']["folder"].$data->imagen) }}">
                                </a><br>
                                <div class="form-check form-checkbox">
                                <input class="form-check-input" type="checkbox" name="imagen_admiko_delete" id="imagen_admiko_delete" value="1">
                                <label class="form-check-label" for="imagen_admiko_delete"> {{trans('admiko.remove_file')}}</label>
                            </div>
                            @endif
                            <input type="file" class="imageUpload mt-1" id="imagen" accept=".jpg,.png,.jpeg" data-type=".jpg,.png,.jpeg"  name="imagen"  data-selected="{{trans('admiko.selected_image_preview')}}" >
                            <input type="hidden" id="imagen_admiko_current" name="imagen_admiko_current" value="{{$data->imagen??''}}">
                            <div class="invalid-feedback @if ($errors->has('imagen')) d-block @endif" data-required="{{trans('admiko.required_image')}}" data-size="{{trans('admiko.required_size')}}" data-type="{{trans('admiko.required_type')}}">
                                @if ($errors->has('imagen')){{ $errors->first('imagen') }}@endif
                            </div>
                            <small id="imagen_help" class="text-muted">{{trans("admiko.file_extension_limit")}}.jpg,.png,.jpeg. {{trans("admiko.recommended")}}{{trans("admiko.width")}}1920px, {{trans("admiko.height")}}1080px. {{trans("admiko.image_action")}}{{trans("admiko.image_action_resize")}}.</small>
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
                    <a href="{{ route("admin.noticias.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection