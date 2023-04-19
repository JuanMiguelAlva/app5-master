@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">Galería</li>
@endsection
@section('pageTitle')
<h1>Galería</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.home")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card galleryIndex galeria_index admikoIndex">
    <div class="card-body">
        <div class="tableBox" id="tableBox">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="pb-2 pb-sm-0">
                        <div class="lengthTable">
                    <select name="length" class="form-select tableLength pagination_length">
                        @foreach(config("admiko_config.length_menu_table_gallery") as $key => $value)
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
                <div class="row row-cols-1 cardElements galleryElements">
                    @foreach($tableData as $data)
                    <div class="rowElement col px-2 mb-3">
                        <div class="card h-100">
                            <div class="row g-0">
								<div>@if (isset($data->foto) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data["fileInfo"]["foto"]["original"]["folder"].$data->foto))                            
                                        <div class="bg-image" style="background-image: url('{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data["fileInfo"]["foto"]["original"]["folder"].$data->foto) }}');">
                                            <a href="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data["fileInfo"]["foto"]["original"]["folder"].$data->foto) }}" target="_blank" class="tableImage"></a>
                                        </div>
                                    @endIf
								</div>
                                <div class="col-12">
    <div class="card-body">
        <div class="card-body-items">
											<div class="pb-1 search-js-descripcin">{!!Str::limit(strip_tags($data["descripcin"]), 50, "...")!!}</div>
        </div>
    </div>
</div>
                                <div class="manageTools">
                                    <a href="{{route("admin.galeria.edit",[$data->id])}}"><i class="fas fa-edit fa-fw"></i></a>
                                    @if(Gate::allows(['galeria_allow']))
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
                    @if(Gate::any(['galeria_allow']))
                        <a href="{{route('admin.galeria.create')}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                    @endIf
                </div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 align-self-center paginationInfo">@if($tableData->withQueryString()->total()) {{$tableData->withQueryString()->firstItem()}} {{trans("admiko.tablePaginationInfoTo")}} {{$tableData->withQueryString()->lastItem()}} {{trans("admiko.tablePaginationInfoTotal")}} {{$tableData->withQueryString()->total()}} @endIf</div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 text-end paginationBox">{{ $tableData->withQueryString()->links() }}</div>
            </div>
            @if(Gate::allows('galeria_allow'))
                <div class="row mt-3">
                    <div class="col-12">
                        <p class="mb-1">Multiple Foto upload:</p>
                        <a href="#" class="btn btn-primary dropzoneShow mb-1" role="button"><i class="fas fa-file-upload fa-fw"></i> Upload</a>
                        <div class="dropzoneBox">
                            <div id="dropzone">
                                <form action="{{route('admin.galeria.admiko_many_files_store')}}" class="dropzone" id="my-awesome-dropzone">
                                    <div class="dz-message needsclick">
                                        <i class="fas fa-cloud-upload-alt fa-fw"></i><br><i>Drop files here or click to upload.</i>
                                    </div>
                                </form>
                            </div>
                            <p class="mb-0">Allowed extension: .jpg,.png,.jpeg. You can select multiple files by holding the "command" key on Mac or "ctrl" key on PC.</p>
                        </div>
                    </div>
                    <script>
                        Dropzone.options.myAwesomeDropzone = {
                            paramName: "foto",
                            parallelUploads: 5,
                            addRemoveLinks: true,
                            acceptedFiles:".jpg,.png,.jpeg",
                            uploadMultiple: false,
                            init: function () {
                                this.on('queuecomplete', function () {
                                    window.location.reload();
                                }).on("error", function (file) {
                                    console.log(file);
                                })
                            },
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                        };
                    </script>
                </div>
            @endIf
        </div>
    </div>
    @if(Gate::allows('galeria_allow'))
    <!-- Delete confirm -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.galeria.delete")}}">
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