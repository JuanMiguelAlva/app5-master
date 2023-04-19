@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active"><a href="{{ route("admin.cursos.index") }}">Cursos</a></li>
<li class="breadcrumb-item active" aria-current="page">Horario</li>
@endsection
@section('pageTitle')
<h1>{{$curso->nombre}}</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.cursos.index")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card horario_index admikoIndex">
    <div class="card-body">
        <div class="tableBox" id="tableBox">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="pb-2 pb-sm-0">
                        <div class="lengthTable">
                    <select name="length" class="form-select tableLength pagination_length">
                        @foreach(config("admiko_config.length_menu_table") as $key => $value)
                        <option value="{{$key}}" @if(isset(Request()->length) && Request()->length == $key) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
				</div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-start justify-content-sm-end">
                            <div class="searchTable">
					<form action="">
                        <div class="input-group ps-2">
                            <input type="text" name="search" class="form-control" placeholder="Buscar" value="{{app('request')->input('search')}}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search fa-fw"></i></button>
                            </div>
                        </div>
                    </form></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tableLayout pb-2">
                                <table class="table tableSort" style="width:100%" data-dom="tr" data-paging="false">
                    <thead>
                        <tr data-sort-method='thead'>
							{{-- <th scope="col" class="w-5" data-sort-method="number" >ID</th> --}}
							<th scope="col" class="text-nowrap">Docente</th>
							<th scope="col" class="text-nowrap d-none d-sm-table-cell">Dia</th>
							<th scope="col" class="text-nowrap d-none d-md-table-cell">Hora de inicio</th>
							<th scope="col" class="text-nowrap d-none d-lg-table-cell">Hora de fin</th>
							@if(count($secciones_all) > 0)
                            <th scope="col" class="text-nowrap d-none d-lg-table-cell">Sección</th>
                            @endif
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans("admiko.table_edit")}}</th>
                            @if(Gate::allows('horario_allow'))
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans('admiko.table_delete')}}</th>
                            @endIf
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tableData as $data)
                        <tr>
							{{-- <td class="w-5"><a href="{{route("admin.horario.edit",[Request()->admiko_cursos_id,$data->id])}}">{{$data->id}}</a></td> --}}
							<td class="text-nowrap">{{$data->docente_id->apellidos??""}} {{$data->docente_id->nombres??""}}</td>
							<td class="text-nowrap d-none d-sm-table-cell">{{$data->dia_id->dia_de_semana??""}}</td>
							<td class="text-nowrap d-none d-md-table-cell">{{$data->hora_inicio}}</td>
							<td class="text-nowrap d-none d-lg-table-cell">{{$data->hora_fin}}</td>
							@if(count($secciones_all) > 0)
							<td class="text-nowrap d-none d-lg-table-cell">{{$data->seccin_id->nombre??""}}</td>
                            @endif
                            <td class="w-5 no-sort"><a href="{{route("admin.horario.edit",[Request()->admiko_cursos_id,$data->id])}}"><i class="fas fa-edit fa-fw"></i></a></td>
                            @if(Gate::allows(['horario_allow']))
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
                    @if(Gate::any(['horario_allow']))
                        <a href="{{route('admin.horario.create',[Request()->admiko_cursos_id])}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                    @endIf
                </div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 align-self-center paginationInfo">@if($tableData->withQueryString()->total()) {{$tableData->withQueryString()->firstItem()}} {{trans("admiko.tablePaginationInfoTo")}} {{$tableData->withQueryString()->lastItem()}} {{trans("admiko.tablePaginationInfoTotal")}} {{$tableData->withQueryString()->total()}} @endIf</div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 text-end paginationBox">{{ $tableData->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
    @if(Gate::allows('horario_allow'))
    <!-- Delete confirm -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.horario.delete",[Request()->admiko_cursos_id])}}">
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