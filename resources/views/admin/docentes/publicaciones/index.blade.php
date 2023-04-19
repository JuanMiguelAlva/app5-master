@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active"><a href="{{ route("admin.docentes.index") }}">Docentes</a></li>
<li class="breadcrumb-item active" aria-current="page">Publicaciones</li>
@endsection
@section('pageTitle')
<h1>Publicaciones</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.docentes.index")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card publicaciones_index admikoIndex">
    <div class="card-body">
        <div class="tableBox" id="tableBox">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="pb-2 pb-sm-0">
                        <div class="lengthTable"></div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-start justify-content-sm-end">
                            <div class="searchTable">
                    <div class="input-group ps-2">
                        <input type="text" name="admiko_search" class="form-control searchTableInput" placeholder="Buscar" value="">
                    </div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tableLayout pb-2 table-responsive">
                                <table class="table tableSort" style="width:100%" data-dom="ltrip">
                    <thead>
                        <tr data-sort-method='thead'>
                            <th scope="col" class="w-5" data-sort-method="number" >ID</th>
                            <th scope="col" class="text-nowrap">Nombre</th>
                            <th scope="col" class="text-nowrap d-none d-sm-table-cell">Tipo</th>
                            <th scope="col" class="text-nowrap d-none d-md-table-cell">Enlace</th>
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans("admiko.table_edit")}}</th>
                            @if(Gate::allows('publicaciones_allow'))
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans('admiko.table_delete')}}</th>
                            @endIf
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tableData as $data)
                        <tr>
                            <td class="w-5"><a href="{{route("admin.publicaciones.edit",[Request()->admiko_docentes_id,$data->id])}}">{{$data->id}}</a></td>
                            <td class="text-nowrap">
                                {{-- {{$data->nombre}} --}}
                                {!!Str::limit(strip_tags($data["nombre"]), 50, "...")!!}
                            </td>
                            <td class="text-nowrap d-none d-sm-table-cell">{{$data->tipo_id->nombre??""}}</td>
                            <td class="text-nowrap d-none d-md-table-cell"><a href="{{$data->enlace}}" target="_blank">{!!Str::limit(strip_tags($data["enlace"]), 50, "...")!!}</a></td>
                            <td class="w-5 no-sort"><a href="{{route("admin.publicaciones.edit",[Request()->admiko_docentes_id,$data->id])}}"><i class="fas fa-edit fa-fw"></i></a></td>
                            @if(Gate::allows(['publicaciones_allow']))
                            <td class="w-5 no-sort">
                            <a href="#" data-id="{{$data->id}}" class="admiko_deleteConfirm" data-bs-toggle="modal" data-bs-target="#deleteConfirm"><i class="fas fa-trash fa-fw"></i></a>
                        </td>
                            @endIf
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-12 col-sm order-3 order-sm-0 pt-2">
                    @if(Gate::any(['publicaciones_allow']))
                        <a href="{{route('admin.publicaciones.create',[Request()->admiko_docentes_id])}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                    @endIf
                </div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 align-self-center paginationInfo"></div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 text-end paginationBox"></div>
            </div>
        </div>
    </div>
    @if(Gate::allows('publicaciones_allow'))
    <!-- Delete confirm -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.publicaciones.delete",[Request()->admiko_docentes_id])}}">
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
    @endIf
   
</div>
@endsection
