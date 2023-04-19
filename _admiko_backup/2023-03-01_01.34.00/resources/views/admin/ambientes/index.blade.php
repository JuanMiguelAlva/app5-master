@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">Ambientes</li>
@endsection
@section('pageTitle')
<h1>Ambientes</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.home")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card cardIndex ambientes_index admikoIndex">
    <div class="card-body">
        <div class="tableBox" id="tableBox">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="pb-2 pb-sm-0">
                        <div class="lengthTable">
                    <select name="length" class="form-select tableLength pagination_js_length">
                        @foreach(config("admiko_config.length_menu_table_card") as $key => $value)
                        <option value="{{$key}}" @if(isset(Request()->length) && Request()->length == $key) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
				</div>
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
            <div class="tableLayout">
                <div class="row cardElements pagination_js_data">
                    @foreach($tableData as $data)
                    <div class="rowElement col-12 col-md-6 col-xxl-4 mb-4">
                        <div class="card h-100">
                            <div class="row g-0 h-100">
								<div class="col-5">@if (isset($data->foto) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data["fileInfo"]["foto"]["original"]["folder"].$data->foto))                            
                                        <div class="bg-image" style="background-image: url('{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data["fileInfo"]["foto"]["original"]["folder"].$data->foto) }}');">
                                            <a href="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data["fileInfo"]["foto"]["original"]["folder"].$data->foto) }}" target="_blank" class="tableImage"></a>
                                        </div>
                                    @endIf
								</div>
                                <div class="col-7">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <div class="card-body-items">
											<div class="pb-1 search-js-nombre card-body-title">{{$data->nombre}}</div>
											<div class="pb-1 search-js-descripcion">{!!Str::limit(strip_tags($data["descripcion"]), 50, "...")!!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="manageTools">
                                    <a href="{{route("admin.ambientes.edit",[$data->id])}}"><i class="fas fa-edit fa-fw"></i></a>
                                    @if(Gate::allows(['ambientes_allow']))
                                        <a href="#" data-id="{{$data->id}}" class="admiko_deleteConfirm" data-bs-toggle="modal" data-bs-target="#deleteConfirm"><i class="fas fa-trash fa-fw"></i></a>
                                    @endIf
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if(count($tableData) == 0)
                        <div class="col-12 py-4">{{trans('admiko.noTableData')}}</div>
                    @endIf
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm order-3 order-sm-0 pt-2">
                    @if(Gate::any(['ambientes_allow']))
                        <a href="{{route('admin.ambientes.create')}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                    @endIf
                </div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 align-self-center paginationInfo"><span class="from_items_js"></span> {{trans("admiko.tablePaginationInfoTo")}} <span class="to_items_js"></span> {{trans("admiko.tablePaginationInfoTotal")}} <span class="total_items_js"></span></div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 text-end paginationBox"><ul class="pagination"></ul></div>
            </div>
        </div>
    </div>
    @if(Gate::allows('ambientes_allow'))
    <!-- Delete confirm -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.ambientes.delete")}}">
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