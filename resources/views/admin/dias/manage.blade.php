@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.dias.index") }}">Días</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
<h1>Días</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{ route("admin.dias.index") }}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card formPage dias_manage admikoForm">
    <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
    <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @if(isset($data)) @method('PUT') @endIf
        @csrf
        <div class="card-body">
            @if ($errors->any())<div class="row"><div class="col-2"></div><div class="col"><div class="invalid-feedback d-block">@foreach($errors->all() as $error) {{$error}}<br> @endforeach</div></div></div>@endif
            <div class="row">
                
                <div class=" col-12">
                    <div class="form-group row">
                        <label for="dia_de_semana" class="col-md-2 col-form-label">Día de Semana:*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="dia_de_semana" name="dia_de_semana" required="true" placeholder="Día de Semana"  value="{{{ old('dia_de_semana', isset($data)?$data->dia_de_semana : '') }}}">
                            <div class="invalid-feedback @if ($errors->has('dia_de_semana')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="dia_de_semana_help" class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class=" col-12">
                    <div class="form-group row multiSelect">
                        <label for="ciclo" class="col-md-2 col-form-label">Ciclo:</label>
                        <div class="col-md-10" style="position: relative">
                            <select name="ciclo[]" data-placeholder="{{trans('admiko.select_from_list')}}" multiple="multiple" id="ciclo"  style="width: 100%" data-allow-clear="true">
                            @php $orderId=0; @endphp
                            @foreach($ciclos_all as $id => $value)
                                @php $selected = ""; @endphp
                                @php $orderId++; @endphp
                                @if(in_array($id, old('ciclo', [])))
                                    @php $selected = "selected"; @endphp
                                @elseIf(isset($data) && $data->ciclo_many->contains($id))
                                    @php $selected = "selected"; @endphp
                                    @php $orderId = $data->ciclo_many->firstWhere('id', $id)->pivot->admiko_order; @endphp
                                @endIf
                                <option value="{{ $id }}" {{$selected}} data-order="{{$orderId}}">{{ $value }}</option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback @if ($errors->has('ciclo')) d-block @endif">{{trans('admiko.required_text')}}</div>
                            <small id="ciclo_help" class="text-muted"></small>
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
                    <a href="{{ route("admin.dias.index") }}" class="btn btn-secondary float-end" role="button">{{trans('admiko.table_cancel')}}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection