{{--IMPORTANT: this page will be overwritten and any change will be lost!! Use custom_sidebar_bottom.blade.php and custom_sidebar_top.blade.php--}}

@if(Gate::any(['cursos_allow','cursos_edit','docentes_allow','docentes_edit','tickets_allow','tickets_edit']))
<li class="nav-item dropdown{{ $admiko_data['sideBarActiveFolder'] === "_principal1" ? " open" : "" }}">
    <a href="#" class="nav-link dropdown-link"><i class="fas fa-folder-open fa-fw"></i>PRINCIPAL</a>
    <ul class="nav flex-column dropdown-content" {!! $admiko_data['sideBarActiveFolder'] === "_principal1" ? ' style="display:block"' : '' !!}>
	@if(Gate::any(['cursos_allow', 'cursos_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "cursos" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.cursos.index')}}"><i class="fas fa-book fa-fw"></i>Cursos</a></li>
	@endIf
	@if(Gate::any(['docentes_allow', 'docentes_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "docentes" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.docentes.index')}}"><i class="fas fa-chalkboard-teacher fa-fw"></i>Docentes</a></li>
	@endIf
	@if(Gate::any(['tickets_allow', 'tickets_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "tickets" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.tickets.index')}}"><i class="fas fa-ticket-alt fa-fw"></i>Tickets</a></li>
	@endIf
    </ul>
</li>
@endIf
@if(Gate::any(['ambientes_allow','ambientes_edit','autoridades_allow','autoridades_edit','galeria_allow','galeria_edit','informacion_allow','informacion_edit','historia_allow','historia_edit','noticias_allow','noticias_edit','resoluciones_allow','resoluciones_edit','secigristas_allow','secigristas_edit']))
<li class="nav-item dropdown{{ $admiko_data['sideBarActiveFolder'] === "_sitio_web" ? " open" : "" }}">
    <a href="#" class="nav-link dropdown-link"><i class="fas fa-folder-open fa-fw"></i>SITIO WEB</a>
    <ul class="nav flex-column dropdown-content" {!! $admiko_data['sideBarActiveFolder'] === "_sitio_web" ? ' style="display:block"' : '' !!}>
	@if(Gate::any(['ambientes_allow', 'ambientes_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "ambientes" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.ambientes.index')}}"><i class="fas fa-building fa-fw"></i>Ambientes</a></li>
	@endIf
	@if(Gate::any(['autoridades_allow', 'autoridades_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "autoridades" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.autoridades.index')}}"><i class="fas fa-user-tie fa-fw"></i>Autoridades</a></li>
	@endIf
	@if(Gate::any(['galeria_allow', 'galeria_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "galeria" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.galeria.index')}}"><i class="fas fa-images fa-fw"></i>Galería</a></li>
	@endIf
	@if(Gate::any(['informacion_allow', 'informacion_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "informacion" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.informacion.index')}}"><i class="fas fa-info-circle fa-fw"></i>Información</a></li>
	@endIf
	@if(Gate::any(['historia_allow', 'historia_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "historia" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.historia.index')}}"><i class="fas fa-heading fa-fw"></i>Historia</a></li>
	@endIf
	@if(Gate::any(['noticias_allow', 'noticias_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "noticias" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.noticias.index')}}"><i class="fas fa-newspaper fa-fw"></i>Noticias</a></li>
	@endIf
	@if(Gate::any(['resoluciones_allow', 'resoluciones_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "resoluciones" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.resoluciones.index')}}"><i class="fas fa-file-upload fa-fw"></i>Resoluciones</a></li>
	@endIf
	@if(Gate::any(['secigristas_allow', 'secigristas_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "secigristas" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.secigristas.index')}}"><i class="fas fa-graduation-cap fa-fw"></i>SECIGRISTAS</a></li>
	@endIf
    </ul>
</li>
@endIf
@if(Gate::any(['cargo_allow','cargo_edit','tipo_profesor_allow','tipo_profesor_edit','ciclos_allow','ciclos_edit','condicion_allow','condicion_edit','especialidades_allow','especialidades_edit','grados_allow','grados_edit','aulas_allow','aulas_edit','unidad_allow','unidad_edit','secciones_allow','secciones_edit','tipo_publicacion_allow','tipo_publicacion_edit','dias_allow','dias_edit']))
<li class="nav-item dropdown{{ $admiko_data['sideBarActiveFolder'] === "_recursos" ? " open" : "" }}">
    <a href="#" class="nav-link dropdown-link"><i class="fas fa-allergies fa-fw"></i>RECURSOS</a>
    <ul class="nav flex-column dropdown-content" {!! $admiko_data['sideBarActiveFolder'] === "_recursos" ? ' style="display:block"' : '' !!}>
	@if(Gate::any(['cargo_allow', 'cargo_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "cargo" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.cargo.index')}}"><i class="fas fa-user-cog fa-fw"></i>Cargo</a></li>
	@endIf
	@if(Gate::any(['tipo_profesor_allow', 'tipo_profesor_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "tipo_profesor" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.tipo_profesor.index')}}"><i class="fas fa-stream fa-fw"></i>Categorías</a></li>
	@endIf
	@if(Gate::any(['ciclos_allow', 'ciclos_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "ciclos" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.ciclos.index')}}"><i class="fas fa-bars fa-fw"></i>Ciclos</a></li>
	@endIf
	@if(Gate::any(['condicion_allow', 'condicion_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "condicion" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.condicion.index')}}"><i class="fas fa-address-card fa-fw"></i>Condición</a></li>
	@endIf
	@if(Gate::any(['especialidades_allow', 'especialidades_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "especialidades" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.especialidades.index')}}"><i class="fas fa-medal fa-fw"></i>Especialidades</a></li>
	@endIf
	@if(Gate::any(['grados_allow', 'grados_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "grados" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.grados.index')}}"><i class="fas fa-scroll fa-fw"></i>Grados</a></li>
	@endIf
	@if(Gate::any(['aulas_allow', 'aulas_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "aulas" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.aulas.index')}}"><i class="fas fa-chalkboard fa-fw"></i>Salones</a></li>
	@endIf
	@if(Gate::any(['unidad_allow', 'unidad_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "unidad" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.unidad.index')}}"><i class="fas fa-cube fa-fw"></i>Unidad</a></li>
	@endIf
	@if(Gate::any(['secciones_allow', 'secciones_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "secciones" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.secciones.index')}}"><i class="fas fa-font fa-fw"></i>Secciones</a></li>
	@endIf
	@if(Gate::any(['tipo_publicacion_allow', 'tipo_publicacion_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "tipo_publicacion" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.tipo_publicacion.index')}}"><i class="fas fa-file-alt fa-fw"></i>Tipo de Publicación</a></li>
	@endIf
	@if(Gate::any(['dias_allow', 'dias_edit']))
		<li class="nav-item{{ $admiko_data['sideBarActive'] === "dias" ? " active" : "" }}"><a class="nav-link dropdown-item" href="{{route('admin.dias.index')}}"><i class="fas fa-calendar-day fa-fw"></i>Días</a></li>
	@endIf
    </ul>
</li>
@endIf