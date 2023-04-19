@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route("admin.distribucion_de_aulas.index") }}">Distribucion de Aulas</a></li>
    @foreach(App\Models\Admin\DistribucionDeAulas::buildParentChildrenBreadcrumbs(Request()->id) as $id => $title)
        <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route("admin.distribucion_de_aulas.index",$id) }}">{{$title}}</a>
        </li>
    @endforeach
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Distribucion de Aulas</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.distribucion_de_aulas.index",$data->admiko_parent_child??Request()->id) }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
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
                
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="ciclo" class="col-md-2 col-form-label">Ciclo:</label>
                        <div class="col-md-10">
                            <select class="form-select" id="ciclo" name="ciclo" >
                                <option value="">{{trans("admiko.select")}}</option>
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
                        <label for="aulas" class="col-md-2 col-form-label">Aulas:</label>
                        <div class="col-md-10">
                            <select class="form-select" id="aulas" name="aulas" >
                                <option value="">{{trans("admiko.select")}}</option>
                                @foreach($aulas_all as $id => $value)
                                    <option value="{{ $id }}" {{ (old('aulas') ? old('aulas') : $data->aulas ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('aulas')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="aulas_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class=" col-12">
                    <div class="form-group row">
                        <label for="admiko_parent_child" class="col-md-2 col-form-label">parent:</label>
                        <div class="col-md-10">
                            <select class="form-select" id="admiko_parent_child" name="admiko_parent_child">
                                <option value="0">{{trans('admiko.parent_title')}}</option>
                                @foreach($data_admiko_parent_child as $id => $value)
                                <option value="{{ $id }}" @if(isset($data) && $id == Request()->id)disabled="disabled"@endif {{ (old('admiko_parent_child') ? old('admiko_parent_child') : $data->admiko_parent_child ?? (Request()->id??0)) == $id ? 'selected' : '' }}>{{ $value}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('admiko_parent_child')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="admiko_parent_child_help" class="text-muted"></small>
                            <input type="hidden" name="return_page" value="{{$data->admiko_parent_child??(Request()->id??'')}}">
                            <input type="hidden" name="admiko_parent_id" value="{{$data->admiko_parent_child??''}}">
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="a" class="col-md-2 col-form-label">a:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="a" name="a"  placeholder="a"  value="{{{ old('a', isset($data)?$data->a : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('a')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="a_help" class="text-muted"></small>
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
                    <a href="{{ route("admin.distribucion_de_aulas.index",$data->admiko_parent_child??Request()->id) }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection