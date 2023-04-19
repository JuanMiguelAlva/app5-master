@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">Cursos</li>
@endsection
@section('pageTitle')
<h1>Cursos</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.home")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card cursos_index admikoIndex">
    
    <div class="card-body">
        <div class="tableBox" id="tableBox">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="pb-2 pb-sm-0">
                        @if(Gate::any(['cursos_allow']))
                            <a href="{{route('admin.cursos.create')}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                        @endIf
                    </div>
                    <div class="justify-content-start justify-content-md-end">
                        <div class="d-flex">
                            <div class="d-none d-md-block">
                                <div class="btn-group">
                                  <button class="form-select tc w-auto filter-dropdown" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid #e2e8f0; padding-bottom: 4.5px">
                                    <i class="fas fa-filter" style="font-size: 0.85em;"></i>
                                    <span class="pe-2 ps-1">Filtro</span>
                                  </button>
                                  @unless(empty($ciclos))
                                    <style>
                                        .form-select {
                                            border-radius: 0.25rem 0rem 0rem 0.25rem;
                                        }
                                    </style>
                                    <a class="limpiar rounded-end" href="{{ url()->current() }}"><i class="fas fa-times"></i></a>
                                  @endunless
                                  <ul class="dropdown-menu dropdown-menu-end ddf pt-3 pb-2 px-3 mt-2" aria-labelledby="dropdownMenu2" onclick="event.stopPropagation();">
                                    <form action="" method="GET" class="">
                                      <div class="formPage">
                                        <div class="input-form multiSelect p-0 w-100">
                                          <div style="position: relative;">
                                            <label class="col-form-label pt-0" style="font-size: 14px;">Seleccione el ciclo:</label>
                                            <select name="ciclo[]" data-placeholder="Seleccionar" multiple="multiple" id="ciclo" style="width: 100%" data-allow-clear="true">
                                              @php $orderId=0; @endphp
                                              @foreach($ciclos_all as $id => $value)
                                                <option value="{{ $id }}" {{ in_array($id, (array) Request::get('ciclo', [])) ? 'selected' : '' }}>{{ $value }}</option>
                                              @endforeach
                                            </select>
                                            <div class="d-flex flex-row-reverse mt-2">
                                              <button class="btn btn-sm btn-primary" type="submit" style="width: auto"><i class="fas fa-check"></i> Aplicar</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </ul>
                                </div>
                              </div>
                            <div class="searchTable">
                                <div class="input-group ps-2">
                                    <input type="text" name="admiko_search" class="form-control searchTableInput" placeholder="Buscar" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tableLayout pb-2 table-responsive">
                                <table class="table tableSort" style="width:100%" data-dom="ltrip">
                    <thead>
                        <tr data-sort-method='thead'>
							<th scope="col" class="w-5 d-none d-md-table-cell" data-sort-method="number" >ID</th>
							<th scope="col" class="text-nowrap">Código</th>
							<th scope="col" class="text-nowrap">Nombre</th>
							<th scope="col" class="text-nowrap d-none d-lg-table-cell">HT</th>
							<th scope="col" class="text-nowrap d-none d-lg-table-cell">HP</th>
                            <th scope="col" class="text-nowrap">TH</th>
							<th scope="col" class="text-nowrap d-none d-lg-table-cell">Créditos</th>
							<th scope="col" class="text-nowrap d-none d-lg-table-cell">Ciclo</th>
							<th scope="col" class="text-center no-sort" data-orderable="false">Horario</th>
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans("admiko.table_edit")}}</th>
                            @if(Gate::allows('cursos_allow'))
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans('admiko.table_delete')}}</th>
                            @endIf
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tableData as $data)
                        <tr>
							<td class="w-5 d-none d-md-table-cell"><a href="{{route("admin.cursos.edit",[$data->id])}}">{{$data->id}}</a></td>
							<td class="text-nowrap">{{$data->codigo}}</td>
							<td class="text-nowrap">{{$data->nombre}}</td>
							<td class="text-nowrap d-none d-lg-table-cell">{{$data->horas_t}}</td>
							<td class="text-nowrap d-none d-lg-table-cell">{{$data->horas_p}}</td>
                            <td class="text-nowrap">{{$data->horas_p + $data->horas_t}}</td>
							<td class="text-nowrap d-none d-lg-table-cell">{{$data->creditos}}</td>
							<td class="text-nowrap d-none d-lg-table-cell">{{$data->ciclo_id->nombre??""}}</td>
							<td class="text-nowrap text-center childPageLink"><a href="{{route("admin.horario.index",[$data->id])}}"><i class="fas fa-clock fa-fw"></i></a></td>
                            <td class="w-5 no-sort"><a href="{{route("admin.cursos.edit",[$data->id])}}"><i class="fas fa-edit fa-fw"></i></a></td>
                            @if(Gate::allows(['cursos_allow']))
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
    @if(Gate::allows('cursos_allow'))
    <!-- Delete confirm -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.cursos.delete")}}">
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