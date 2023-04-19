<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CalendarService;
use App\Models\Admin\Cursos\Horario;
use App\Models\Admin\Secciones;
use App\Models\Admin\Historia;
use App\Models\Admin\Docentes;
use App\Models\Admin\Tickets;
use App\Models\Admin\Informacion;
use App\Models\Admin\DistribucionDeAulas;
use Intervention\Image\Size;

class inicioController extends Controller
{
    public function index(CalendarService $calendarService)
    {
        $weekDays = Horario::WEEK_DAYS;

        //Historia
        $historia_all = Historia::orderBy('fecha', 'ASC')->get();

        //Informacion
        $info_all = Informacion::all();

        //Docentes
        $admiko_data_doc['sideBarActive'] = "docentes";
		$admiko_data_doc["sideBarActiveFolder"] = "_principal1";
        $admiko_data_doc["fileInfo"] = Docentes::$admiko_file_info;
        $docentes_all = Docentes::join('grados as g', 'docentes.grado', '=', 'g.id')
        ->join('tipo_docente as td', 'docentes.categoria', '=', 'td.id')
        ->select('docentes.*','g.nombre as grado', 'g.abreviatura', 'td.tipo')
        ->orderBy('td.tipo', 'asc')
        ->orderBy('docentes.apellidos', 'asc')
        ->get();

        //Aulas
        $dda_all = DistribucionDeAulas::join('aulas', 'distribucion_de_aulas.aula', '=', 'aulas.id')
        ->select('ciclo', 'seccin', 'codigo', 'turno')
        ->get();

        //Horario
        for ($i = 3; $i <= 12; $i++) {
            $secciones = Secciones::where('ciclo', $i)->get();
                if (count($secciones)>1){
                    foreach($secciones as $seccion){
                        // echo  "ciclo=".$i." seccion=".$seccion->id."<br>";
                        // $id=30+$i+$seccion->id;
                        $calendarData[$i]= $calendarService->generateCalendarData($weekDays, $i, $seccion->id);
                    }
                }else{
                    $calendarData[$i] = $calendarService->generateCalendarData($weekDays, $i, null);
                }
        }

        return view('inicio', compact('weekDays', 'calendarData','historia_all','info_all','docentes_all','admiko_data_doc','dda_all'));
    }

    public function store(Request $request)
    {
        $ticket = new Tickets;
        $ticket->estado = 0;
        $ticket->asunto = $request->input('subject');
        $ticket->solicitante = $request->input('name');
        $ticket->correo = $request->input('email');
        $ticket->mensaje = $request->input('message');
        $ticket->save();

        return back()->with('success', 'Tu mensaje ha sido enviado. ¡Gracias!');
    }
}
