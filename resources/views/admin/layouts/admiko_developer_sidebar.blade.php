@if(auth()->user()->role_id == 1)
    <!-- <li class="nav-item">
         <div class="menu-title">
            <div>{{ trans('admiko.developer_tools') }}</div>
        </div>
    </li> -->
    {{-- <li class="nav-item{{ $admiko_data['sideBarActive'] === "admikoImport" ? " active" : "" }}">
        <a class="nav-link" href="{{route("admin.admiko_page_import")}}"><i class="fas fa-tools fa-fw"></i>{{trans('admiko.developer_page_import') }}</a>
    </li> --}}
    <li class="nav-item{{ $admiko_data['sideBarActive'] === "admikoAdmins" ? " active" : "" }}">
        <a class="nav-link" href="{{route("admin.admins.index")}}"><i class="fas fa-users fa-fw"></i>{{trans('admiko.developer_users') }}</a>
    </li>
    <li class="nav-item{{ $admiko_data['sideBarActive'] === "admiko_auditable_logs" ? " active" : "" }}">
        <a class="nav-link" href="{{route('admin.admiko_auditable_logs.index')}}"><i class="fas fas fa-filter fa-fw fa-fw"></i>{{trans('admiko.developer_logs') }}</a>
    </li>
@endif