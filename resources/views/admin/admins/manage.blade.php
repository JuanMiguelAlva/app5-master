@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.admins.index") }}">{{ trans('admiko.admins_title') }}</a></li>
    @if(isset($data))
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_edit')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{trans('admiko.page_breadcrumbs_add')}}</li>
    @endIf
@endsection
@section('pageTitle')
    <h1>{{ trans('admiko.admins_title') }}</h1>
@endsection
@section('pageInfo')@endsection
@section('backBtn')
    <a href="{{ route("admin.admins.index") }}"><i class="fas fa-angle-left"></i> {{ trans('admiko.page_back_btn') }}</a>
@endsection
@section('content')
    <div class="card formPage">
        <legend class="action">{{ isset($data) ? trans('admiko.update') : trans('admiko.add_new') }}</legend>
        <form method="POST" action="{{ $admiko_data['formAction'] }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            @if(isset($data)) @method('PUT') @endIf
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">{{ trans('admiko.admins_name') }}:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" required placeholder="{{ trans('admiko.admins_name') }}" value="{{{ old('name', isset($data)?$data->name : '') }}}">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>@endif
                        <div class="invalid-feedback">{{trans('admiko.required_text')}}</div>
                        <small id="name_help" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">{{ trans('admiko.admins_email') }}:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" required placeholder="{{ trans('admiko.admins_email') }}" value="{{{ old('email', $data->email??'') }}}">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>@endif
                        <div class="invalid-feedback">{{trans('admiko.required_text')}}</div>
                        <small id="email_help" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Image:</label>
                    <div class="col-sm-10">
                        @if (isset($data->image))
                            <img src="{{$data->image}}"><br>
                        @endif
                        <input type="hidden" name="image" id="imageData" value="{{$data->image??''}}">
                        <input type="file" class="imageAvatarUpload mt-1" id="image" accept=".jpg,.png,.jpeg" data-type=".jpg,.png,.jpeg" data-selected="{{trans('admiko.selected_image_preview')}}">
                        <div class="invalid-feedback" data-required="{{trans('admiko.required_image')}}" data-size="{{trans('admiko.required_size')}}" data-type="{{trans('admiko.required_type')}}"></div>
                        <small id="image_help" class="text-muted">{{trans("admiko.file_extension_limit")}}.jpg,.png,.jpeg. {{trans("admiko.recommended")}}{{trans("admiko.width")}}200px, {{trans("admiko.height")}}200px.</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">{{ trans('admiko.admins_pass') }}:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder="{{ trans('admiko.admins_pass') }}" value="{{{ old('password'??'') }}}">
                        @if ($errors->has('password'))
                            <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>@endif
                        <div class="invalid-feedback">{{trans('admiko.required_text')}}</div>
                        <small id="password_help" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="role_id" class="col-sm-2 col-form-label">{{ trans('admiko.admins_role') }}:</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="role_id" name="role_id">
                            @foreach($role_all as $id => $value)
                                <option value="{{ $id }}" {{ (old('role_id') ? old('role_id') : $data->role_id ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role_id'))
                            <div class="invalid-feedback d-block">{{ $errors->first('role_id') }}</div>@endif
                        <div class="invalid-feedback">{{trans('admiko.required_text')}}</div>
                        <small id="role_id_help" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="access" class="col-sm-2 col-form-label">{{trans('admiko.multi_tenancy_access_title')}}</label>
                    <div class="col-sm-10">
                        @if(isset($data) && $data->role_id != 1)
                            @foreach($multi_tenancy_all as $id => $value)
                                @php $checked = ""; @endphp
                                @if(in_array($id, old('access', [])))
                                    @php $checked = "checked"; @endphp
                                @elseIf(isset($data) && $data->multi_tenancy_access->contains($id))
                                    @php $checked = "checked"; @endphp
                                @endIf
                                <div class="form-check form-checkbox">
                                    <input type="checkbox" class="form-check-input" name="multi_tenancy[]" id="multi_tenancy{{ $id }}" value="{{ $id }}" {{$checked}}>
                                    <label class="form-check-label" for="multi_tenancy{{ $id }}">{{ $value }}</label>
                                </div>
                            @endforeach
                            <div class="invalid-feedback @if ($errors->has('access')) d-block @endif">{{trans('admiko.required_text')}}</div>
                        @else
                            <p class="text-muted pt-2">{{trans('admiko.multi_tenancy_access_limit')}}</p>
                        @endif
                        <small id="access_help" class="text-muted pt-2">{{trans('admiko.multi_tenancy_access')}}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="themes" class="col-sm-2 col-form-label">Theme:</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="theme" name="theme">
                            @foreach($themes as $theme)
                                <option value="{{ $theme }}" {{ (old('theme') ? old('theme') : $data->theme ?? '') == $theme ? 'selected' : '' }}>{{ $theme }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-actions">
                    <div class="row" id="form-group-buttons">
                        <div class="col-2"></div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary mb-5 mb-sm-0 ms-3 ms-sm-0 save-button">{{ trans('admiko.table_save') }}</button>
                        </div>
                        <div class="secondaryButtons col pt-0 text-end">
                            <a href="{{ route("admin.admins.index") }}" class="btn btn-secondary mb-1 mb-sm-0  ms-3 ms-sm-0" role="button">{{ trans('admiko.table_cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
