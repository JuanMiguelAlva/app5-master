<?php

namespace App\Services;

use App\Models\Admin\Cursos\Horario;
use App\Models\Admin\DistribucionDeAulas;
use App\Services\TimeService;

class CalendarService
{
    public function generateCalendarData($weekDays,$ciclo,$seccion)
    {
        $calendarData = [];
        
        $dda = DistribucionDeAulas::where('ciclo', $ciclo)->select('turno')->first();
        
        $hora_ini = ($dda->turno == 'M') ? '08:00:00' : '16:30:00';
        $hora_fin = ($dda->turno == 'M') ? '14:00:00' : '22:30:00';

        $timeRange = (new TimeService)->generateTimeRange($hora_ini, $hora_fin);

        if($seccion!=null){

        $lessons = Horario::with(['curso_id', 'docente_id'])
        ->select('cursos_horario.id as id_horario', 'cursos_horario.*', 'cursos.*')
        ->join('cursos', 'cursos.id', '=', 'cursos_horario.admiko_cursos_id')
        ->join('secciones', 'secciones.id', '=', 'cursos_horario.seccin')
        ->where('cursos.ciclo', '=', $ciclo)
        ->where('secciones.id', '=', $seccion)
        ->get();
        

        }else{

        $lessons = Horario::with(['curso_id', 'docente_id'])
        ->select('cursos_horario.id as id_horario', 'cursos_horario.*', 'cursos.*')
        ->join('cursos', 'cursos.id', '=', 'cursos_horario.admiko_cursos_id')
        ->where('cursos.ciclo', $ciclo)
        ->get();
        }

        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $dia)
            {
                $lesson = $lessons->where('dia', $index)->where('hora_inicio', $time['start'])->first();

                if ($lesson)
                {
                    array_push($calendarData[$timeText], [
                        'id_horario'=> $lesson->id_horario,
                        'id_curso'   => $lesson->curso_id->id,
                        'hf'   => $lesson->hora_fin,
                        'dia'   => $lesson->dia,
                        'nombre_curso'   => $lesson->curso_id->nombre,
                        'nombre_profesor' => $lesson->docente_id->nombres,
                        'apellido_profesor' => $lesson->docente_id->apellidos,
                        'rowspan'      => $lesson->difference/45 ?? ''
                    ]);
                }
                else if (!$lessons->where('dia', $index)->where('hora_inicio', '<', $time['start'])->where('hora_fin', '>=', $time['end'])->count())
                {
                    array_push($calendarData[$timeText], 1);
                }
                else
                {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        return $calendarData;
    }
}