@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">Tickets</li>
@endsection
@section('pageTitle')
<h1>Tickets</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.home")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card tickets_index admikoIndex">
    <div class="card-body">
        <div class="tableBox" id="tableBox">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="pb-2 pb-sm-0">
                        @if(Gate::any(['tickets_allow']))
                        <a href="{{route('admin.tickets.create')}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                    @endIf
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
							<th scope="col" class="text-nowrap">Asunto</th>
							<th scope="col">Solicitante</th>
							<th scope="col" class="d-none d-md-table-cell">Mensaje</th>
                            <th scope="col" >Estado</th>
							<th scope="col" class="text-center no-sort" data-orderable="false">Respuesta</th>
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans("admiko.table_edit")}}</th>
                            @if(Gate::allows('tickets_allow'))
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans('admiko.table_delete')}}</th>
                            @endIf
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tableData as $data)
                        <tr>
							<td class="w-5"><a href="{{route("admin.tickets.edit",[$data->id])}}">{{$data->id}}</a></td>
							<td class="text-nowrap">{{$data->asunto}}</td>
							<td >{{$data->solicitante}}<br>{{$data->correo}}</td>
							<td class="d-none d-md-table-cell text-nowrap">{!!Str::limit(strip_tags($data["mensaje"]), 50, "...")!!}</td>
                            <td class="text-nowrap">
                                @php
                                    $es=$data->estado;
                                    switch ($es) {
                                        case 0:
                                            echo '<span class="bg-gray-100 text-gray-800 rounded-full text-xs relative inline-flex items-center px-2 py-1 font-medium" role="status"><svg xmlns="http://www.w3.org/2000/svg" viewBox="1 2 20 20" fill="currentColor" aria-hidden="true" class="-ml-0.5 mr-1 text-gray-400 h-4 w-4"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg> Nuevo</span>';
                                            break;
                                        case 1:
                                            echo '<span class="bg-warning-100 text-warning-800 rounded-full text-xs relative inline-flex items-center px-2 py-1 font-medium" role="status"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="1 2 20 20" fill="currentColor" aria-hidden="true" class="-ml-0.5 mr-1 text-warning-400 h-4 w-4"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg> En progreso</span>';
                                            break;
                                        case 2:
                                            echo '<span class="bg-success-100 text-success-800 rounded-full text-xs relative inline-flex items-center px-2 py-1 font-medium" role="status"><svg xmlns="http://www.w3.org/2000/svg" viewBox="1 2 20 20" fill="currentColor" aria-hidden="true" class="-ml-0.5 mr-1 text-success-400 h-4 w-4">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"></path>
                                            </svg> Terminado</span>';
                                            break;
                                        
                                        default:
                                            break;
                                    }
                                @endphp
                            </td>
							<td class="text-nowrap text-center childPageLink"><a href="{{route("admin.respuesta.index",[$data->id])}}"><i class="fas fa-reply fa-fw"></i></a></td>
                            <td class="w-5 no-sort"><a href="{{route("admin.tickets.edit",[$data->id])}}"><i class="fas fa-edit fa-fw"></i></a></td>
                            @if(Gate::allows(['tickets_allow']))
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
                <div class="d-flex col-12 col-sm order-3 order-sm-0 pt-3">
                    <div class="lengthTable"></div>
                    <div class="my-auto ms-2 paginationInfo"></div>
                </div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 text-end paginationBox"></div>
            </div>
        </div>
    </div>
    @if(Gate::allows('tickets_allow'))
    <!-- Delete confirm -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.tickets.delete")}}">
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