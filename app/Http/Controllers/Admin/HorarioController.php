<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Cursos\Horario;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\HorarioRequest;
use Gate;
use App\Services\CalendarService;
use App\Models\Admin\DistribucionDeAulas;
use App\Models\Admin\Secciones;

class HorarioController extends Controller
{
    public function index(CalendarService $calendarService,Request $request)
    {
        $weekDays = Horario::WEEK_DAYS;
        if (Gate::none(['horarios_allow'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "horarios";
		$admiko_data["sideBarActiveFolder"] = "_principal1";

        $ciclo = $request->ciclo !== null ? $request->ciclo : null;

        //Aulas
        $dda_all = DistribucionDeAulas::join('aulas', 'distribucion_de_aulas.aula', '=', 'aulas.id')
        ->select('distribucion_de_aulas.id','ciclo', 'seccin', 'codigo', 'turno')
        ->get();

        //Horario
        for ($i = 3; $i <= 12; $i++) {
            $secciones = Secciones::where('ciclo', $i)->get();
                if (count($secciones)>1){
                    foreach($secciones as $seccion){
                        $calendarData[$i]= $calendarService->generateCalendarData($weekDays, $i, $seccion->id);
                    }
                }else{
                    $calendarData[$i] = $calendarService->generateCalendarData($weekDays, $i, null);
                }
        }

        return view("admin.horarios.index")->with(compact('admiko_data','weekDays', 'calendarData','dda_all','ciclo'));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['horarios_allow'])) {
            // return redirect(route("admin.horario.index").'?ciclo='.$request->ciclo);
        }
        Horario::destroy($request->idDel);
        return redirect(route("admin.horarios.index").'?ciclo='.$request->ciclo);
    }

}
