@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.admins.index") }}">{{ trans('admiko.admins_title') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route("admin.admin_roles.index") }}">{{ trans('admiko.roles_page_title') }}</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
    <h1>{{ trans('admiko.roles_page_title') }}</h1>
@endsection
@section('pageInfo')@endsection
@section('backBtn')
    <a href="{{ route("admin.admin_roles.index") }}"><i class="fas fa-angle-left"></i> {{ trans('admiko.page_back_btn') }}</a>
@endsection
@section('content')
    <div class="card formPage">
        <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
        <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            @if(isset($data)) @method('PUT') @endIf
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">{{ trans('admiko.roles_title') }}:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required id="title" name="title" placeholder="{{ trans('admiko.roles_title') }}" value="{{{ old('title', isset($data)?$data->title : '') }}}">
                        @if ($errors->has('title'))
                            <div class="invalid-feedback d-block">{{ $errors->first('title') }}</div>@endif
                        <div class="invalid-feedback">{{trans('admiko.required_text')}}</div>
                        <small id="title_help" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="permission" class="col-sm-2 col-form-label">{{ trans('admiko.roles_permission') }}:</label>
                    <div class="col-sm-10">@if(count($permission_all) == 0){{ trans('admiko.roles_permission_error') }}@endIf</div>
                </div>
                @if(isset($data))
                    @php $permission_all_select = $data->permission_many_select(); @endphp
                @endIf
                @foreach($permission_all as $id => $value)
                    @php $selected = ""; @endphp
                    @if(in_array($value, old('permission', [])))
                        @php $selected = $value; @endphp
                    @elseIf(isset($data) && $permission_all_select->contains($value.'_allow'))
                        @php $selected = $value.'_allow'; @endphp
                    @elseIf(isset($data) && $permission_all_select->contains($value.'_edit'))
                        @php $selected = $value.'_edit'; @endphp
                    @endIf
                    <div class="form-group row">
                        <label for="permission" class="col-sm-2 col-form-label">{{ $value }}:</label>
                        <div class="col-sm-10">
                            <div>
                                <select class="form-select" name="permission[]" id="permission{{ $id }}">
                                    <option value="{{ $value }}_deny" @if($selected == $value.'_deny') selected @endIf>{{trans('admiko.roles_deny')}}</option>
                                    <option value="{{ $value }}_allow" @if($selected == $value.'_allow') selected @endIf>{{trans('admiko.roles_allow')}}</option>
                                    <option value="{{ $value }}_edit" @if($selected == $value.'_edit') selected @endIf>{{trans('admiko.roles_edit')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <div class="form-actions">
                    <div class="row" id="form-group-buttons">
                        <div class="col-2"></div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary mb-5 mb-sm-0 ms-3 ms-sm-0 save-button">{{ trans('admiko.table_save') }}</button>
                        </div>
                        <div class="secondaryButtons col pt-0 text-end">
                            <a href="{{ route("admin.admin_roles.index") }}" class="btn btn-secondary mb-1 mb-sm-0  ms-3 ms-sm-0" role="button">{{ trans('admiko.table_cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
