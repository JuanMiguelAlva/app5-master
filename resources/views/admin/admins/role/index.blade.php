@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("admin.admins.index") }}">{{ trans('admiko.admins_title') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('admiko.roles_page_title') }}</li>
@endsection
@section('pageTitle')
    <h1>{{ trans('admiko.roles_page_title') }}</h1>
@endsection
@section('pageInfo')@endsection
@section('backBtn')
    <a href="{{route('admin.admins.index')}}"><i class="fas fa-angle-left"></i> {{ trans('admiko.page_back_btn') }}</a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="tableBox">
                <div class="row">
                    <div class="col-auto mb-2 lengthTable"></div>
                    <div class="col mb-2 searchTable">
                        <div class="input-group ms-auto">
                            <input type="text" name="admiko_search" class="form-control" placeholder="Buscar"  value="">
                        </div>
                    </div>
                </div>
                <div class="tableLayout">
                    <table class="table" data-dom="tr" data-page-length='-1'>
                        <thead>
                        <tr data-sort-method='thead'>
                            <th scope="col" class="w-5">ID</th>
                            <th scope="col" class="">{{ trans('admiko.roles_title') }}</th>
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{ trans('admiko.table_edit') }}</th>
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{ trans('admiko.table_delete') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tableData as $data)
                            <tr>
                                <td class="w-5">{{$data->id}}</td>
                                <td class=" nowrap"><a href="{{route('admin.admin_roles.edit',$data->id)}}">{{{$data->title}}}</a></td>
                                <td class="w-5 no-sort">
                                    @if($data->id != 1)
                                        <a href="{{route('admin.admin_roles.edit',$data->id)}}"><i class="fas fa-edit fa-fw"></i></a>
                                    @endIf
                                </td>
                                <td class="w-5 no-sort">
                                    @if($data->id != 1)
                                        <a href="{{route('admin.admin_roles.destroy',$data->id)}}" data-id="{{$data->id}}" class="admiko_deleteConfirm" data-bs-toggle="modal" data-bs-target="#deleteConfirm"><i class="fas fa-trash fa-fw"></i></a>
                                    @endIf
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12 col-sm order-3 order-sm-0 pt-3">
                        <a href="{{route('admin.admin_roles.create')}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{ trans('admiko.table_add') }}</a>
                    </div>
                    <div class="col-12 col-sm-auto order-0 order-sm-3 pt-3 align-self-center paginationInfo"></div>
                    <div class="col-12 col-sm-auto order-0 order-sm-3 pt-3 text-end paginationBox"></div>
                </div>
            </div>
        </div>
        <!-- Delete confirm -->
        <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" action="{{route("admin.admin_roles.delete")}}">
                    @method('DELETE')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{trans('admiko.delete_confirm')}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">{{trans('admiko.delete_message')}}</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{trans('admiko.delete_close_btn')}}</button>
                            <button type="submit" class="btn btn-danger deleteSoft">{{trans('admiko.delete_delete_btn')}}</button>
                        </div>
                    </div>
                    <div class="dataDelete"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
