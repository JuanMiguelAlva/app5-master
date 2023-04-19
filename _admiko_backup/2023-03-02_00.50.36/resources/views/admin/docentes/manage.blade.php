@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.docentes.index") }}">Docentes</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Docentes</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.docentes.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage docentes_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="codigo" class="col-md-2 col-form-label">Código:*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="codigo" name="codigo" required="true" placeholder="Código"  value="{{{ old('codigo', isset($data)?$data->codigo : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('codigo')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="codigo_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
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
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="categoria" class="col-md-2 col-lg-4 col-form-label">Categoría:*</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-select" id="categoria" name="categoria" required="true">
                                
                                @foreach($tipo_profesor_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('categoria') ? old('categoria') : $data->categoria ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('categoria')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="categoria_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="condicion" class="col-md-2 col-lg-4 col-form-label">Condición:*</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-select" id="condicion" name="condicion" required="true">
                                
                                @foreach($condicion_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('condicion') ? old('condicion') : $data->condicion ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('condicion')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="condicion_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="especialidad" class="col-md-2 col-lg-4 col-form-label">Especialidad:*</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-select" id="especialidad" name="especialidad" required="true">
                                
                                @foreach($especialidades_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('especialidad') ? old('especialidad') : $data->especialidad ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('especialidad')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="especialidad_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="grado" class="col-md-2 col-lg-4 col-form-label">Grado:*</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-select" id="grado" name="grado" required="true">
                                
                                @foreach($grados_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('grado') ? old('grado') : $data->grado ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('grado')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="grado_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="correo" class="col-md-2 col-lg-4 col-form-label">Correo:</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="email" class="form-control" id="correo" name="correo"  placeholder="Correo"  value="{{{ old('correo', $data->correo??'') }}}">
                            <div class="invalid-feedback @if ($errors->has('correo')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="correo_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="celular" class="col-md-2 col-lg-4 col-form-label">Celular:</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" id="celular" name="celular"  placeholder="Celular"  value="{{{ old('celular', isset($data)?$data->celular : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('celular')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="celular_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="activo" class="col-md-2 col-lg-4 col-form-label">Activo:</label>
                        <div class="col-md-10 col-lg-8">
                            <div class="form-check form-checkbox">
                                <input type="hidden" name="activo" value="0">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1"
                                       @if(old("activo") || ((isset($data)&&$data->activo=="1")) || !isset($data)) checked @endif >
                                <label class="form-check-label" for="activo"></label>
                            </div>
                            <small id="activo_help" class="text-muted m-0">¿Está en activo?</small>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-6">
                    <div class="form-group row">
                        <label for="horas" class="col-md-2 col-lg-4 col-form-label">Horas:</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control limitPozNegNumbers numbersWidth" id="horas" name="horas"  placeholder="Horas"
                                   step="1"  data-min="1" min="1"
                                   value="{{{ old('horas', isset($data)?$data->horas : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('horas')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="horas_help" class="text-muted"> Min: 1</small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="descripcion" class="col-md-2 col-form-label">Descripción:</label>
                        <div class="col-md-10">
                            <textarea class="form-control form-control-textarea simple_text_editor" id="descripcion" name="descripcion"  placeholder="Descripción">{{{ old('descripcion', isset($data)?$data->descripcion : '') }}}</textarea>
                            <div class="invalid-feedback @if ($errors->has('descripcion')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="descripcion_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="foto" class="col-md-2 col-form-label">Foto:</label>
                        <div class="col-md-10">
                            @if (isset($data->foto) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data['fileInfo']["foto"]['original']["folder"].$data->foto))
                            <a href="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data['fileInfo']["foto"]['original']["folder"].$data->foto) }}" target="_blank" class="tableImage">
                                    <img src="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data['fileInfo']["foto"]['original']["folder"].$data->foto) }}">
                                </a><br>
                                <div class="form-check form-checkbox">
                                <input class="form-check-input" type="checkbox" name="foto_admiko_delete" id="foto_admiko_delete" value="1">
                                <label class="form-check-label" for="foto_admiko_delete"> {{trans('admiko.remove_file')}}</label>
                            </div>
                            @endif
                            <input type="file" class="imageUpload mt-1" id="foto" accept=".jpg,.png,.jpeg" data-type=".jpg,.png,.jpeg"  name="foto"  data-selected="{{trans('admiko.selected_image_preview')}}" >
                            <input type="hidden" id="foto_admiko_current" name="foto_admiko_current" value="{{$data->foto??''}}">
                            <div class="invalid-feedback @if ($errors->has('foto')) d-block @endif" data-required="{{trans('admiko.required_image')}}" data-size="{{trans('admiko.required_size')}}" data-type="{{trans('admiko.required_type')}}">
                                @if ($errors->has('foto')){{ $errors->first('foto') }}@endif
                            </div>
                            <small id="foto_help" class="text-muted">{{trans("admiko.file_extension_limit")}}.jpg,.png,.jpeg. {{trans("admiko.recommended")}}{{trans("admiko.width")}}500px, {{trans("admiko.height")}}500px. {{trans("admiko.image_action")}}{{trans("admiko.image_action_resize")}}.</small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="cv" class="col-md-2 col-form-label">CV:</label>
                        <div class="col-md-10">
                            @if (isset($data->cv) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data['fileInfo']["cv"]['original']["folder"].$data->cv))
                            <a href="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data['fileInfo']["cv"]['original']["folder"].$data->cv)}}" target="_blank">{{$data->cv}}</a><br>
                                <div class="form-check form-checkbox">
                                <input class="form-check-input" type="checkbox" name="cv_admiko_delete" id="cv_admiko_delete" value="1">
                                <label class="form-check-label" for="cv_admiko_delete"> {{trans('admiko.remove_file')}}</label>
                            </div>
                            @endif
                            <input type="file" class="fileUpload mt-1" id="cv" accept=".pdf,.word,.wordx" data-type=".pdf,.word,.wordx" name="cv" >
                            <input type="hidden" id="cv_admiko_current" name="cv_admiko_current" value="{{$data->cv??''}}">
                            <div class="invalid-feedback @if ($errors->has('cv')) d-block @endif" data-required="{{trans('admiko.required_text')}}" data-size="{{trans('admiko.required_size')}}" data-type="{{trans('admiko.required_type')}}">
                                @if ($errors->has('cv')){{ $errors->first('cv') }}@endif
                            </div>
                            <small id="cv_help" class="text-muted">Puede subir archivos .pdf, .word y .wordx{{trans("admiko.file_extension_limit")}}.pdf,.word,.wordx. </small>
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
                    <a href="{{ route("admin.docentes.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection