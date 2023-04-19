@extends("admin.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active">{{ trans('admiko.admins_page_import_title') }}</li>
@endsection
@section('pageTitle')
    <h1>{{ trans('admiko.admins_page_import_title') }}</h1>
@endsection
@section('pageInfo')@endsection
@section('backBtn')
    <a href="{{route("admin.home")}}"><i class="fas fa-angle-left"></i> {{ trans('admiko.page_back_btn') }}</a>
@endsection
@section('content')
    @if($errors)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col"><div class="invalid-feedback d-block">{!!$errors!!}</div></div>
                </div>
            </div>
        </div>
    @else
        @if($admikoUpdateInfo)
            <div class="card">
                <div class="card-body">
                    <h4>Admiko update:</h4>
                    {!!$admikoUpdateInfo!!}
                    <form method="post" action="{{route("admin.admiko_page_import.import")}}">
                        @method('POST')
                        @csrf
                        <div class="col-12">
                            <p class="text-muted pb-2">{{trans('admiko.admins_admiko_update_backup_info')}} {{base_path().'/'.config("admiko_config.backup_location")}}</p>
                        </div>
                        <input type="hidden" name="admikoUpdate" value="1">
                        <div class="btn btn-primary spinnerBox" style="display: none"><div class="h-100 d-flex align-items-center justify-content-around"><div class="spinner-border spinner-border-sm" role="status"></div></div></div>
                        <button type="submit" class="btn btn-primary importButtonAdmikoUpdate"><i class="fas fa-download fa-fw"></i> {{trans('admiko.admins_admiko_update')}}</button>
                    </form>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="tableBox">
                    <div class="row">
                        <div class="col-auto mb-2 lengthTable">Admiko early access: v.{{config("admiko_version.version")}}</div>
                        <div class="col mb-2 searchTable">
                            <div class="input-group ms-auto">
                                <input type="text" name="admiko_search" class="form-control" placeholder="Buscar" value="">
                            </div>
                        </div>
                    </div>
                    <div class="tableLayout">
                        <table class="table" data-dom="tr" data-page-length='-1'>
                            <thead>
                            <tr data-sort-method='thead'>
                                <th scope="col" class="w-5 no-sort importSelectAll" data-orderable="false"><i class="fas fa-check-double"></i> {{ trans('admiko.admins_page_import') }}</th>
                                <th scope="col" class="">{{ trans('admiko.admins_page_name') }}</th>
                                <th scope="col" class="">{{ trans('admiko.admins_soft_delete') }}</th>
                                <th scope="col" class="w-5 no-sort" data-orderable="false">{{ trans('admiko.admins_page_import') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($tableData)
                                @foreach($tableData as $data)
                                    <tr>
                                        <td class="w-5 no-sort">
                                            <input type="checkbox" value="{{$data->id}}" class="form-check-input importSelectMe" id="page_{{$data->id}}">
                                        </td>
                                        <td class=" nowrap"><label for="page_{{$data->id}}">{{{$data->title}}}</label></td>
                                        <td class=" nowrap">{{$data->soft_delete?'Yes':'No'}}</td>
                                        <td class="w-5 no-sort">
                                            <form method="post" action="{{route("admin.admiko_page_import.import")}}">
                                                @method('POST')
                                                @csrf
                                                <input type="hidden" value="{{$data->id}}" name="page_id[]">
                                                <div class="btn btn-primary spinnerBox" style="display: none"><div class="h-100 d-flex align-items-center justify-content-around"><div class="spinner-border spinner-border-sm" role="status"></div></div></div>
                                                <button type="submit" class="btn btn-primary importButton"><i class="fas fa-download fa-fw" style="color: white"></i> {{trans('admiko.admins_page_import')}}</button>
                                                <div class="singleImportFinished" style="display: none"><i class="fas fa-check"></i> {{trans('admiko.admins_page_import_single_finished')}}</div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <form method="post" action="{{route("admin.admiko_page_import.import")}}">
                            @method('POST')
                            @csrf
                            <div class="col-12 col-sm order-3 order-sm-0 pt-3">
                                <div class="row multiImportForm pt-2" style="display: none">
                                    <div class="col-12">
                                        <div class="dataImport"></div>
                                        <div class="btn btn-primary spinnerBox" style="display: none"><div class="h-100 d-flex align-items-center justify-content-around"><div class="spinner-border spinner-border-sm" role="status"></div></div></div>
                                        <button type="submit" class="btn btn-primary importAllButton" style="width: 100px"><i class="fas fa-download fa-fw"></i> {{trans('admiko.admins_page_import')}}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="importFinished" style="display: none">
                                    <div class="alert alert-success mt-3" role="alert"><i class="fas fa-check"></i> {{trans('admiko.admins_page_import_finished')}}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress" style="display: none">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        <p class="text-muted py-2">{{trans('admiko.admins_admiko_update_backup_info')}} {{base_path().'/'.config("admiko_config.backup_location")}}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Error -->
        <div class="modal fade" id="errorInfo" tabindex="-1" role="dialog" aria-labelledby="errorInfo" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{trans('admiko.error_page_import_title')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">{{trans('admiko.error_page_import_message')}}</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{trans('admiko.error_page_import_close_btn')}}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('footerCode')
    <script>
        $('.tableLayout').on('click', '.importSelectAll', function (event) {
            event.preventDefault();
            var checkBoxes = $(".importSelectMe");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
            showImportButton();
        });
        $('.tableLayout').on('click', '.importSelectMe', function (event) {
            showImportButton();
        });
        $('.importButtonAdmikoUpdate').on('click', function (event) {
            var form = $(this).closest('form');
            form.find('.importButtonAdmikoUpdate').hide();
            form.find('.spinnerBox').show();
        })
        $('.importButton').on('click', function (event) {
            event.preventDefault();
            var form = $(this).closest('form');
            var data = form.serialize();
            form.find('.importButton').hide();
            form.find('.spinnerBox').show();
            form.find('.singleImportFinished').hide();
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (results) {
                    if (results.status == "done") {
                        form.find('.importButton').show();
                        form.find('.spinnerBox').hide();
                        form.find('.singleImportFinished').show();
                        importGlobalFiles(form);
                    } else {
                        $('#errorInfo').modal('show');
                    }
                },
                error: function () {
                    $('#errorInfo').modal('show');
                }
            });
        });

        var totalPages = 0;
        var totalPagesFinished = 0;
        var progress = 0;
        var backup_folder = '';

        $('.multiImportForm').on('click', '.importAllButton',function (event) {
            event.preventDefault();
            backup_folder = '';
            var form = $(this).closest('form');
            form.find('.multiImportForm').hide();
            form.find('.progress').show();
            form.find('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
            form.find('.importFinished').slideUp();
            totalPages = form.find('.dataImport input').length + 1;
            totalPagesFinished = 0;
            progress = 0;
            startImport(form.find('.dataImport input').serializeArray(),0,form);
        });
        function startImport(data,i,form) {
            totalPagesFinished++;
            progress = (totalPagesFinished/totalPages)*100;
            form.find('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);

            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: {'page_id[]': data[i]['value'], '_token': form.find("input[name=_token]").val(), 'backup_folder': backup_folder},
                dataType: 'json',
                success: function (results) {
                    if (results.status == "done") {
                        backup_folder = results.backup_folder;
                        i++;
                        if(data.length > i){
                            startImport(data,i,form)
                        } else {
                            importGlobalFiles(form)
                        }
                    } else {
                        $('#errorInfo').modal('show');
                    }
                },
                error: function () {
                    $('#errorInfo').modal('show');
                }
            });
        }
        function importGlobalFiles(form) {
            totalPagesFinished++;
            progress = (totalPagesFinished/totalPages)*100;
            form.find('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: {'importGlobal': 1, '_token': form.find("input[name=_token]").val(), 'backup_folder': backup_folder},
                dataType: 'json',
                success: function (results) {
                    if (results.status == "done") {
                        form.find('.progress').hide();
                        form.find('.multiImportForm').show();
                        form.find('.importFinished').slideDown();
                    } else {
                        $('#errorInfo').modal('show');
                    }
                },
                error: function () {
                    $('#errorInfo').modal('show');
                }
            });
        }

        function showImportButton() {
            if ($(".importSelectMe:checked").length > 0) {
                $('.dataImport').html('');
                $(".importSelectMe:checked").each(function (i) {
                    importId = $(this).val();
                    $('<input>').attr({
                        type: 'hidden',
                        value: importId,
                        name: 'page_id[]'
                    }).appendTo('.dataImport');
                })
                $(".multiImportForm").show();
            } else {
                $(".multiImportForm").hide();
            }
        }
    </script>
@endpush
