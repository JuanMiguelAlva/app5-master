@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active"><a href="{{ route("admin.tickets.index") }}">Tickets</a></li>
<li class="breadcrumb-item active" aria-current="page">Respuesta</li>
@endsection
@section('pageTitle')
<h1>Respuesta</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.tickets.index")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card respuesta_index admikoIndex">
    <div class="card-body">
        <div class="tableBox" id="tableBox">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="pb-2 pb-sm-0">
                        @if(Gate::any(['respuesta_allow']))
                        <a href="{{route('admin.respuesta.create',[Request()->admiko_tickets_id])}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                        @endIf
                    </div>
                    <div>
                        <div class="d-flex justify-content-start justify-content-sm-end">
                    {{-- @if(Gate::allows('respuesta_allow'))
                    <div class="row multiDeleteButton" style="display: none">
                        <div class="col-12 text-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#deleteConfirm" class="btn btn-danger" role="button"><i class="fas fa-trash fa-fw"></i> {{trans('admiko.delete_delete_btn')}}</a>
                        </div>
                    </div>
                    @endIf --}}
                            <div class="searchTable">
					<div class="input-group ps-2">
                        <input type="text" name="admiko_search" class="form-control searchTableInput" placeholder="Buscar" value="">
                    </div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tableLayout pb-2">
                                <table class="table tableSort" style="width:100%" data-dom="ltrip">
                    <thead>
                        <tr data-sort-method='thead'>
							<th scope="col" class="w-5" data-sort-method="number" >ID</th>
							<th scope="col">Mensaje</th>
							<th scope="col" class="text-nowrap d-none d-sm-table-cell">Asunto</th>
                            {{-- <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans("admiko.table_edit")}}</th> --}}
                            @if(Gate::allows('respuesta_allow'))
                            <th scope="col" class="w-5 no-sort deleteSelectAll" data-orderable="false"><i class="fas fa-check-double"></i> {{trans('admiko.table_delete')}}</th>
                            @endIf
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tableData as $data)
                        <tr>
							<td class="w-5"><a href="{{route("admin.respuesta.edit",[Request()->admiko_tickets_id,$data->id])}}">{{$data->id}}</a></td>
							<td>{!!Str::limit(strip_tags($data["mensaje"]), 50, "...")!!}</td>
							<td class="text-nowrap d-none d-sm-table-cell">{{$data->asunto}}</td>
                            {{-- <td class="w-5 no-sort"><a href="{{route("admin.respuesta.edit",[Request()->admiko_tickets_id,$data->id])}}"><i class="fas fa-edit fa-fw"></i></a></td> --}}
                            @if(Gate::allows(['respuesta_allow']))
                            <td class="w-5 no-sort"><div class="form-check form-checkbox">
                                <input type="checkbox" value="{{$data->id}}" class="form-check-input deleteSelectMe" id="multiple_delete_{{$data->id}}">
                            </div></td>
                            @endIf
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
                    @if(Gate::allows('respuesta_allow'))
                    <div class="row multiDeleteButton" style="display: none">
                        <div class="col-12 text-end">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#deleteConfirm" class="btn btn-danger" role="button"><i class="fas fa-trash fa-fw"></i> {{trans('admiko.delete_delete_btn')}}</a>
                        </div>
                    </div>
                    @endIf
                    <div class="row">
                        <div class="d-flex col-12 col-sm order-3 order-sm-0 pt-3">
                            <div class="lengthTable"></div>
                            <div class="my-auto ms-2 paginationInfo"></div>
                        </div>
                        <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 text-end paginationBox"></div>
                    </div>
        </div>
    </div>
    @if(Gate::allows('respuesta_allow'))
    <!-- Delete confirm -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.respuesta.delete",[Request()->admiko_tickets_id])}}">
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