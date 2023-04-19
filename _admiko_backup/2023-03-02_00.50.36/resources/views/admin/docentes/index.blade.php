@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">Docentes</li>
@endsection
@section('pageTitle')
<h1>Docentes</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.home")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card docentes_index admikoIndex">
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
                        <input type="text" name="admiko_search" class="form-control searchTableInput" placeholder="Search" value="">
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
							<th scope="col" class="text-nowrap">Código</th>
							<th scope="col" class="d-none d-sm-table-cell">Foto</th>
							<th scope="col" class="d-none d-sm-table-cell">Apellidos y Nombres</th>
							<th scope="col" class="text-nowrap d-none d-lg-table-cell">Categoría</th>
							<th scope="col" class="text-nowrap d-none d-lg-table-cell">Condición</th>
							<th scope="col" class="text-nowrap d-none d-lg-table-cell">Especialidad</th>
							<th scope="col" class="text-nowrap d-none d-lg-table-cell">Estado</th>
							<th scope="col" class="text-center no-sort" data-orderable="false">Publicaciones</th>
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans("admiko.table_edit")}}</th>
                            @if(Gate::allows('docentes_allow'))
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans('admiko.table_delete')}}</th>
                            @endIf
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tableData as $data)
                        <tr class="align-middle">
							<td class="w-5"><a href="{{route("admin.docentes.edit",[$data->id])}}">{{$data->id}}</a></td>
							<td class="text-nowrap">{{$data->codigo}}</td>
							<td class="d-none d-sm-table-cell">@if (isset($data->foto) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data["fileInfo"]["foto"]["original"]["folder"].$data->foto))
                            <a href="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data["fileInfo"]["foto"]["original"]["folder"].$data->foto) }}" target="_blank" class="tableImage">
                                <img class="rounded-circle" width="60px" height="60px" src="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data["fileInfo"]["foto"]["original"]["folder"].$data->foto) }}">
                            </a>@endIf</td>
							<td class="d-none d-sm-table-cell">{{$data->grado_id->abreviatura??""}} {{$data->apellidos}} {{$data->nombres}}<br>{{$data->correo}}</td>
							<td class="text-nowrap d-none d-lg-table-cell">{{$data->categoria_id->tipo??""}}</td>
							<td class="text-nowrap d-none d-lg-table-cell">{{$data->condicion_id->nombre??""}}</td>
							<td class="text-nowrap d-none d-lg-table-cell">{{$data->especialidad_id->nombre??""}}</td>
							<td class="text-nowrap d-none d-lg-table-cell"><div>
                                    <style>
                                        .text-xs {
                                            font-size: .75rem;
                                            line-height: 1rem;
                                        }

                                        .font-medium {
                                            font-weight: 600;
                                        }

                                        .text-success-800 {
                                            --tw-text-opacity: 1;
                                            color: rgb(22 101 52 / var(--tw-text-opacity));
                                        }

                                        .rounded-full {
                                            border-radius: 9999px;
                                        }

                                        .h-4 {
                                            height: 1rem;
                                        }

                                        .text-success-400 {
                                            --tw-text-opacity: 1;
                                            color: rgb(74 222 128 / var(--tw-text-opacity));
                                        }

                                        .bg-success-100 {
                                            --tw-bg-opacity: 1;
                                            background-color: rgb(220 252 231 / var(--tw-bg-opacity));
                                        }
                                        .bg-gray-100 {
                                            --tw-bg-opacity: 1;
                                            background-color: rgb(203 206 209 / 0.25);
                                        }
                                    </style>

                                    <?php
                                    $estado = $data->activo;
                                    if ($estado == 0) {
                                        echo '<span class="bg-gray-100 text-gray-800 rounded-full text-xs relative inline-flex items-center px-2 py-1 font-medium" role="status"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="-ml-0.5 mr-1 text-gray-400 h-4 w-4"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"></path></svg> Inactivo</span>';
                                    } else {
                                        echo '<span class="bg-success-100 text-success-800 rounded-full text-xs relative inline-flex items-center px-2 py-1 font-medium" role="status"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="-ml-0.5 mr-1 text-success-400 h-4 w-4">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"></path>
                                        </svg> Activo</span>';
                                    }
                                    ?>
                                </div></td>
							<td class="text-nowrap text-center childPageLink"><a href="{{route("admin.publicaciones.index",[$data->id])}}"><i class="fas fa-bookmark fa-fw"></i></a></td>
                            <td class="w-5 no-sort"><a href="{{route("admin.docentes.edit",[$data->id])}}"><i class="fas fa-edit fa-fw"></i></a></td>
                            @if(Gate::allows(['docentes_allow']))
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
                    @if(Gate::any(['docentes_allow']))
                        <a href="{{route('admin.docentes.create')}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                    @endIf
                </div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 align-self-center paginationInfo"></div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 text-end paginationBox"></div>
            </div>
        </div>
    </div>
    @if(Gate::allows('docentes_allow'))
    <!-- Delete confirm -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.docentes.delete")}}">
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