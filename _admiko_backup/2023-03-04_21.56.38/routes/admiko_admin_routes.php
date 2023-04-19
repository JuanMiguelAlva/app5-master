<?php
/** Admiko routes. This file will be overwritten on page import. Don't add your code here! **/

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/**Cursos**/
Route::delete("cursos/destroy", [CursosController::class,"destroy"])->name("cursos.delete");
Route::resource("cursos", CursosController::class)->parameters(["cursos" => "cursos"]);
/**Cursos Horario**/
Route::delete("cursos/{admiko_cursos_id}/horario/destroy", [Cursos\HorarioController::class,"destroy"])->name("horario.delete");
Route::resource("cursos/{admiko_cursos_id}/horario", Cursos\HorarioController::class)->parameters(["horario" => "horario"]);
/**Docentes**/
Route::delete("docentes/destroy", [DocentesController::class,"destroy"])->name("docentes.delete");
Route::resource("docentes", DocentesController::class)->parameters(["docentes" => "docentes"]);
/**Docentes Publicaciones**/
Route::post("docentes/{admiko_docentes_id}/publicaciones/admiko_dynamic_fields/{id}", [Docentes\PublicacionesController::class,"admiko_dynamic_fields"])->name("publicaciones.admiko_dynamic_fields");
Route::delete("docentes/{admiko_docentes_id}/publicaciones/destroy", [Docentes\PublicacionesController::class,"destroy"])->name("publicaciones.delete");
Route::resource("docentes/{admiko_docentes_id}/publicaciones", Docentes\PublicacionesController::class)->parameters(["publicaciones" => "publicaciones"]);
/**Tickets**/
Route::delete("tickets/destroy", [TicketsController::class,"destroy"])->name("tickets.delete");
Route::resource("tickets", TicketsController::class)->parameters(["tickets" => "tickets"]);
/**Tickets Respuesta**/
Route::delete("tickets/{admiko_tickets_id}/respuesta/destroy", [Tickets\RespuestaController::class,"destroy"])->name("respuesta.delete");
Route::resource("tickets/{admiko_tickets_id}/respuesta", Tickets\RespuestaController::class)->parameters(["respuesta" => "respuesta"]);
/**Ambientes**/
Route::delete("ambientes/destroy", [AmbientesController::class,"destroy"])->name("ambientes.delete");
Route::resource("ambientes", AmbientesController::class)->parameters(["ambientes" => "ambientes"]);
/**Autoridades**/
Route::delete("autoridades/destroy", [AutoridadesController::class,"destroy"])->name("autoridades.delete");
Route::resource("autoridades", AutoridadesController::class)->parameters(["autoridades" => "autoridades"]);
/**Galeria**/
Route::post("galeria/admiko_many_files_store", [GaleriaController::class,"admiko_many_files_store"])->name("galeria.admiko_many_files_store");
Route::delete("galeria/destroy", [GaleriaController::class,"destroy"])->name("galeria.delete");
Route::resource("galeria", GaleriaController::class)->parameters(["galeria" => "galeria"]);
/**Informacion**/
Route::delete("informacion/destroy", [InformacionController::class,"destroy"])->name("informacion.delete");
Route::resource("informacion", InformacionController::class)->parameters(["informacion" => "informacion"]);
/**Historia**/
Route::delete("historia/destroy", [HistoriaController::class,"destroy"])->name("historia.delete");
Route::resource("historia", HistoriaController::class)->parameters(["historia" => "historia"]);
/**Noticias**/
Route::delete("noticias/destroy", [NoticiasController::class,"destroy"])->name("noticias.delete");
Route::resource("noticias", NoticiasController::class)->parameters(["noticias" => "noticias"]);
/**Resoluciones**/
Route::post("resoluciones/admiko_many_files_store", [ResolucionesController::class,"admiko_many_files_store"])->name("resoluciones.admiko_many_files_store");
Route::delete("resoluciones/destroy", [ResolucionesController::class,"destroy"])->name("resoluciones.delete");
Route::resource("resoluciones", ResolucionesController::class)->parameters(["resoluciones" => "resoluciones"]);
/**Secigristas**/
Route::delete("secigristas/destroy", [SecigristasController::class,"destroy"])->name("secigristas.delete");
Route::resource("secigristas", SecigristasController::class)->parameters(["secigristas" => "secigristas"]);
/**Cargo**/
Route::delete("cargo/destroy", [CargoController::class,"destroy"])->name("cargo.delete");
Route::resource("cargo", CargoController::class)->parameters(["cargo" => "cargo"]);
/**TipoProfesor**/
Route::delete("tipo_profesor/destroy", [TipoProfesorController::class,"destroy"])->name("tipo_profesor.delete");
Route::resource("tipo_profesor", TipoProfesorController::class)->parameters(["tipo_profesor" => "tipo_profesor"]);
/**Ciclos**/
Route::delete("ciclos/destroy", [CiclosController::class,"destroy"])->name("ciclos.delete");
Route::resource("ciclos", CiclosController::class)->parameters(["ciclos" => "ciclos"]);
/**Condicion**/
Route::delete("condicion/destroy", [CondicionController::class,"destroy"])->name("condicion.delete");
Route::resource("condicion", CondicionController::class)->parameters(["condicion" => "condicion"]);
/**Especialidades**/
Route::delete("especialidades/destroy", [EspecialidadesController::class,"destroy"])->name("especialidades.delete");
Route::resource("especialidades", EspecialidadesController::class)->parameters(["especialidades" => "especialidades"]);
/**Grados**/
Route::delete("grados/destroy", [GradosController::class,"destroy"])->name("grados.delete");
Route::resource("grados", GradosController::class)->parameters(["grados" => "grados"]);
/**Aulas**/
Route::delete("aulas/destroy", [AulasController::class,"destroy"])->name("aulas.delete");
Route::resource("aulas", AulasController::class)->parameters(["aulas" => "aulas"]);
/**Unidad**/
Route::delete("unidad/destroy", [UnidadController::class,"destroy"])->name("unidad.delete");
Route::resource("unidad", UnidadController::class)->parameters(["unidad" => "unidad"]);
/**Secciones**/
Route::delete("secciones/destroy", [SeccionesController::class,"destroy"])->name("secciones.delete");
Route::resource("secciones", SeccionesController::class)->parameters(["secciones" => "secciones"]);
/**TipoPublicacion**/
Route::delete("tipo_publicacion/destroy", [TipoPublicacionController::class,"destroy"])->name("tipo_publicacion.delete");
Route::resource("tipo_publicacion", TipoPublicacionController::class)->parameters(["tipo_publicacion" => "tipo_publicacion"]);
/**Dias**/
Route::delete("dias/destroy", [DiasController::class,"destroy"])->name("dias.delete");
Route::resource("dias", DiasController::class)->parameters(["dias" => "dias"]);
