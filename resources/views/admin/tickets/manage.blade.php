@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.tickets.index") }}">Tickets</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Tickets</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.tickets.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage tickets_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="estado" class="col-md-2 col-form-label">Estado:*</label>
                        <div class="col-md-10">
                            <select class="form-select" id="estado" name="estado" required="true">
                                
                                @foreach($estado_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('estado') ? old('estado') : $data->estado ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('estado')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="estado_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-12">
                    <div class="form-group row">
                        <label for="asunto" class="col-md-2 col-form-label">Asunto:*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="asunto" name="asunto" required="true" placeholder="Asunto"  value="{{{ old('asunto', isset($data)?$data->asunto : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('asunto')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="asunto_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="solicitante" class="col-md-2 col-form-label">Solicitante:*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="solicitante" name="solicitante" required="true" placeholder="Solicitante"  value="{{{ old('solicitante', isset($data)?$data->solicitante : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('solicitante')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="solicitante_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="correo" class="col-md-2 col-form-label">Correo:*</label>
                        <div class="col-md-10">
                            <input type="email" class="form-control" id="correo" name="correo" required="true" placeholder="Correo"  value="{{{ old('correo', $data->correo??'') }}}">
                            <div class="invalid-feedback @if ($errors->has('correo')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="correo_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="mensaje" class="col-md-2 col-form-label">Mensaje:*</label>
                        <div class="col-md-10">
                            <textarea class="form-control form-control-textarea simple_text_editor" id="mensaje" name="mensaje" required="true" placeholder="Mensaje">{{{ old('mensaje', isset($data)?$data->mensaje : '') }}}</textarea>
                            <div class="invalid-feedback @if ($errors->has('mensaje')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="mensaje_help" class="text-muted"></small>
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
                    <a href="{{ route("admin.tickets.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection