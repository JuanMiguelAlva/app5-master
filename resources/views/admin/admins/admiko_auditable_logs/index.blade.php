@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">{{trans('admiko.auditable_title')}}</li>
@endsection
@section('pageTitle')
<h1>{{trans('admiko.auditable_title')}}</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
<a href="{{route("admin.home")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="tableBox">
            <div class="row">
                <div class="col-auto lengthTable">
                    <select name="length" class="form-select tableLength">
                        @foreach(config("admiko_config.length_menu_table") as $key => $value)
                        <option value="{{$key}}" @if(isset(Request()->length) && Request()->length == $key) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
				</div>
                <div class="col searchTable">
					<form action="">
                        <div class="input-group ms-auto">
                            <input type="text" name="search" class="form-control" placeholder="Buscar" value="{{app('request')->input('search')}}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search fa-fw"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tableLayout">
                <table class="table tableSort" data-dom="tr" data-paging="false">
                    <thead>
                        <tr data-sort-method='thead'>
							<th scope="col" class="w-5">ID</th>
							<th scope="col" class="nowrap">{{trans('admiko.auditable_action')}}</th>
							<th scope="col" class="d-none d-lg-table-cell">{{trans('admiko.auditable_url')}}</th>
							<th scope="col" class="d-none d-md-table-cell nowrap">{{trans('admiko.auditable_model')}}</th>
							<th scope="col" class="d-none d-lg-table-cell nowrap">{{trans('admiko.auditable_user')}}</th>
							<th scope="col" class="d-none d-lg-table-cell nowrap">{{trans('admiko.auditable_time')}}</th>
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans('admiko.table_view')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tableData as $data)
                        <tr>
							<td class="w-5"><a href="{{route("admin.admiko_auditable_logs.show",[$data->id])}}">{{$data->id}}</a></td>
							<td class="nowrap">{{$data->action}}</td>
							<td class="d-none d-lg-table-cell"><p class="mb-0">{{Str::limit(strip_tags($data["url"]), 50, "...")}}</p></td>
							<td class="d-none d-md-table-cell nowrap">{{$data->model}}</td>
							<td class="d-none d-lg-table-cell nowrap">{{$data->user_info->name??""}}</td>
							<td class="d-none d-lg-table-cell nowrap">{{$data->created_at??""}}</td>
                            <td class="w-5 no-sort"><a href="{{route('admin.admiko_auditable_logs.show',[$data->id])}}"><i class="fas fa-eye fa-fw"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-12 col-sm order-3 order-sm-0 pt-3"></div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-3 align-self-center paginationInfo">@if($tableData->withQueryString()->total()) {{$tableData->withQueryString()->firstItem()}} {{trans("admiko.tablePaginationInfoTo")}} {{$tableData->withQueryString()->lastItem()}} {{trans("admiko.tablePaginationInfoTotal")}} {{$tableData->withQueryString()->total()}} @endIf</div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-3 text-end paginationBox">{{ $tableData->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
