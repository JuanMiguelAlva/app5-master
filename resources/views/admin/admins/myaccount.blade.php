@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active">{{ trans('admiko.myaccount') }}</li>
@endsection
@section('pageTitle')
    <h1>{{ trans('admiko.myaccount') }}</h1>
@endsection
@section('pageInfo')@endsection
@section('backBtn')
    <a href="{{ route("admin.home") }}"><i class="fas fa-angle-left"></i> {{ trans('admiko.page_back_btn') }}</a>
@endsection
@section('content')
    <div class="card formPage">
        <legend class="action">Información Personal:</legend>
        <form method="POST" action="{{route('admin.myaccount.update')}}" enctype="multipart/form-data" class="needs-validation" novalidate>
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">{{ trans('admiko.admins_name') }}:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('admiko.admins_name') }}" value="{{{ old('name', isset($data)?$data->name : '') }}}">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback d-block">{{ $errors->first('name') }}</div>@endif
                        <div class="invalid-feedback">{{trans('admiko.required_text')}}</div>
                        <small id="name_help" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">{{ trans('admiko.admins_email') }}:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="{{ trans('admiko.admins_email') }}" value="{{{ old('email', $data->email??'') }}}">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>@endif
                        <div class="invalid-feedback">{{trans('admiko.required_text')}}</div>
                        <small id="email_help" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Foto:</label>
                    <div class="col-sm-10">
                        @if (isset($data->image))
                            <img class="stored_image" src="{{$data->image}}"><br>
                        @endif
                        <input type="hidden" name="image" id="imageData" value="{{$data->image}}">
                        <input type="file" class="imageAvatarUpload mt-1" id="image" accept=".jpg,.png,.jpeg" data-type=".jpg,.png,.jpeg" data-selected="{{trans('admiko.selected_image_preview')}}">
                        <div class="invalid-feedback" data-required="{{trans('admiko.required_image')}}" data-size="{{trans('admiko.required_size')}}" data-type="{{trans('admiko.required_type')}}"></div>
                        <small id="image_help" class="text-muted">{{trans("admiko.file_extension_limit")}}.jpg,.png,.jpeg. {{trans("admiko.recommended")}}{{trans("admiko.width")}}200px, {{trans("admiko.height")}}200px.</small>
                    </div>
                </div>
                <div class="d-none form-group row">
                    <label for="themes" class="col-sm-2 col-form-label">Themes:</label>
                    <div class="col-sm-10">
                        <div class="row">
                            @foreach($themes as $theme)
                                @php $checked = ""; @endphp
                                @if(old('theme') == $theme)
                                    @php $checked = "checked"; @endphp
                                @elseIf(isset($data) && $data->theme == $theme)
                                    @php $checked = "checked"; @endphp
                                @endIf
                                <div class="col-4 themeSelect mb-3">
                                    <label class="form-check-label" for="theme{{ $theme }}" style="text-transform: capitalize">
                                        {{-- <img src="/assets/admiko/css/theme/{{$theme}}/image.jpg" class="img-thumbnail"> --}}
                                        <input type="radio" class="form-check-input" name="theme" id="theme{{ $theme }}" value="{{ $theme }}" {{$checked}} > {{$theme}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
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
                            <a href="{{ route("admin.home") }}" class="btn btn-secondary mb-1 mb-sm-0  ms-3 ms-sm-0" role="button">{{ trans('admiko.table_cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <legend class="action">{{ trans('admiko.new_password') }}</legend>
        <form method="POST" action="{{route('admin.myaccount.updatepassword')}}" enctype="multipart/form-data" class="needs-validation" novalidate>
            @method('PUT')
            @csrf
            <div class="card-body">
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
            </div>
            <div class="card-footer">
                <div class="form-actions">
                    <div class="row" id="form-group-buttons">
                        <div class="col-2"></div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary mb-5 mb-sm-0 ms-3 ms-sm-0 save-button">{{ trans('admiko.table_save') }}</button>
                        </div>
                        <div class="secondaryButtons col pt-0 text-end">
                            <a href="{{ route("admin.home") }}" class="btn btn-secondary mb-1 mb-sm-0  ms-3 ms-sm-0" role="button">{{ trans('admiko.table_cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
