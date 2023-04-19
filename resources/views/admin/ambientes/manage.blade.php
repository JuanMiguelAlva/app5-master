@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.ambientes.index") }}">Ambientes</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Ambientes</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.ambientes.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage ambientes_manage admikoForm">
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
                            <small id="foto_help" class="text-muted">{{trans("admiko.file_extension_limit")}}.jpg,.png,.jpeg. {{trans("admiko.recommended")}}{{trans("admiko.width")}}1920px, {{trans("admiko.height")}}1080px. {{trans("admiko.image_action")}}{{trans("admiko.image_action_resize")}}.</small>
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
                    <a href="{{ route("admin.ambientes.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection