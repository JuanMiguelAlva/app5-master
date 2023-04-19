@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.tickets.index") }}">Tickets</a></li>
<li class="breadcrumb-item active"><a href="{{ route("admin.respuesta.index",[Request()->admiko_tickets_id]) }}">Respuesta</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Respuesta</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.respuesta.index",[Request()->admiko_tickets_id]) }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage respuesta_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="destino" class="col-md-2 col-form-label">Destino:*</label>
                        <div class="col-md-10">
                            {{-- <input type="email" class="form-control" id="destino" name="destino" required="true" placeholder="Destino"  value="{{{ old('destino', $data->destino??'') }}}"> --}}
                            <input type="email" class="form-control" id="destino" name="destino" required="true" placeholder="Destino"  value="{{ $tickets->correo }}" readonly>
                            <div class="invalid-feedback @if ($errors->has('destino')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="destino_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="asunto" class="col-md-2 col-form-label">Asunto:*</label>
                        <div class="col-md-10">
                            {{-- <input type="text" class="form-control" id="asunto" name="asunto" required="true" placeholder="Asunto"  value="{{{ old('asunto', isset($data)?$data->asunto : '') }}}"> --}}
                            <input type="text" class="form-control" id="asunto" name="asunto" required="true" placeholder="Asunto"  value="Respuesta: {{ $tickets->asunto }}">
                            <div class="invalid-feedback @if ($errors->has('asunto')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="asunto_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="mensaje" class="col-md-2 col-form-label">Mensaje:*</label>
                        <div class="col-md-10">
                            <textarea class="form-control form-control-textarea advanced_text_editor" id="mensaje" name="mensaje" required="true" placeholder="Mensaje">{{{ old('mensaje', isset($data)?$data->mensaje : '') }}}</textarea>
                            <div class="invalid-feedback @if ($errors->has('mensaje')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="mensaje_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                {{-- <div class=" col-12">
                    <div class="form-group row">
                        <label for="file" class="col-md-2 col-form-label">File:</label>
                        <div class="col-md-10">
                            @if (isset($data->file) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data['fileInfo']["file"]['original']["folder"].$data->file))
                            <a href="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data['fileInfo']["file"]['original']["folder"].$data->file)}}" target="_blank">{{$data->file}}</a><br>
                                <div class="form-check form-checkbox">
                                <input class="form-check-input" type="checkbox" name="file_admiko_delete" id="file_admiko_delete" value="1">
                                <label class="form-check-label" for="file_admiko_delete"> {{trans('admiko.remove_file')}}</label>
                            </div>
                            @endif
                            <input type="file" class="fileUpload mt-1" id="file"  name="file" >
                            <input type="hidden" id="file_admiko_current" name="file_admiko_current" value="{{$data->file??''}}">
                            <div class="invalid-feedback @if ($errors->has('file')) d-block @endif" data-required="{{trans('admiko.required_text')}}" data-size="{{trans('admiko.required_size')}}" data-type="{{trans('admiko.required_type')}}">
                                @if ($errors->has('file')){{ $errors->first('file') }}@endif
                            </div>
                            <small id="file_help" class="text-muted"></small>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="card-footer form-actions" id="form-group-buttons">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary float-start me-1 mb-1 mb-sm-0 save-button">{{trans('admiko.table_save')}}</button>
                    <a href="{{ route("admin.respuesta.index",[Request()->admiko_tickets_id]) }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection