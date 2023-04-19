@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">Noticias</li>
@endsection
@section('pageTitle')
<h1>Noticias</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.home")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card cardIndex noticias_index admikoIndex">
    <div class="card-body">
        <div class="tableBox" id="tableBox">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="pb-2 pb-sm-0">
                        <div class="lengthTable">
                    <select name="length" class="form-select tableLength pagination_length">
                        @foreach(config("admiko_config.length_menu_table_card") as $key => $value)
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
            <div class="tableLayout">
                <div class="row cardElements">
                    @foreach($tableData as $data)
                    <div class="rowElement col-12 col-md-6 col-xxl-4 mb-4">
                        <div class="card h-100">
                            <div class="row g-0 h-100">
								<div class="col-5">@if (isset($data->imagen) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data["fileInfo"]["imagen"]["original"]["folder"].$data->imagen))                            
                                        <div class="bg-image" style="background-image: url('{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data["fileInfo"]["imagen"]["original"]["folder"].$data->imagen) }}');">
                                            <a href="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data["fileInfo"]["imagen"]["original"]["folder"].$data->imagen) }}" target="_blank" class="tableImage"></a>
                                        </div>
                                    @endIf
								</div>
                                <div class="col-7">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <div class="card-body-items">
											<div class="pb-1 search-js-titulo card-body-title">{{$data->titulo}}</div>
											<div class="pb-1 search-js-fecha">{{$data->fecha}}</div>
											<div class="pb-1 search-js-descripcion">{!!Str::limit(strip_tags($data["descripcion"]), 50, "...")!!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="manageTools">
                                    <a href="{{route("admin.noticias.edit",[$data->id])}}"><i class="fas fa-edit fa-fw"></i></a>
                                    @if(Gate::allows(['noticias_allow']))
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
                    @if(Gate::any(['noticias_allow']))
                        <a href="{{route('admin.noticias.create')}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                    @endIf
                </div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 align-self-center paginationInfo">@if($tableData->withQueryString()->total()) {{$tableData->withQueryString()->firstItem()}} {{trans("admiko.tablePaginationInfoTo")}} {{$tableData->withQueryString()->lastItem()}} {{trans("admiko.tablePaginationInfoTotal")}} {{$tableData->withQueryString()->total()}} @endIf</div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 text-end paginationBox">{{ $tableData->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
    @if(Gate::allows('noticias_allow'))
    <!-- Delete confirm -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.noticias.delete")}}">
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