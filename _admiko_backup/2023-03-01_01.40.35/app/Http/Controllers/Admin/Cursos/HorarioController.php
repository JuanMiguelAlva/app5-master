<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin\Cursos;
use App\Http\Controllers\Controller;
use App\Models\Admin\Cursos\Horario;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Cursos\HorarioRequest;
use Gate;
use App\Models\Admin\Dias;
use App\Models\Admin\Aulas;
use App\Models\Admin\Docentes;

class HorarioController extends Controller
{

    public function index()
    {
        if (Gate::none(['horario_allow', 'horario_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "cursos";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        
        $tableData = Horario::where("admiko_cursos_id",Request()->admiko_cursos_id)->orderByDesc("id")->get();
        return view("admin.cursos.horario.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['horario_allow'])) {
            return redirect(route("admin.horario.index",[Request()->admiko_cursos_id]));
        }
        $admiko_data['sideBarActive'] = "cursos";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.horario.store",[Request()->admiko_cursos_id]);
        
        
		$dias_all = Dias::all()->sortBy("dia_de_semana")->pluck("dia_de_semana", "id");
		$aulas_all = Aulas::all()->sortBy("codigo")->pluck("codigo", "id");
		$docentes_all = Docentes::all()->sortBy("apellidos")->pluck("apellidos", "id");
        return view("admin.cursos.horario.manage")->with(compact('admiko_data','dias_all','aulas_all','docentes_all'));
    }

    public function store(HorarioRequest $request)
    {
        if (Gate::none(['horario_allow'])) {
            return redirect(route("admin.horario.index",[Request()->admiko_cursos_id]));
        }
        $data = $request->all();
        
		$data["admiko_cursos_id"] = Request()->admiko_cursos_id;
        $Horario = Horario::create($data);
        
        return redirect(route("admin.horario.index",[Request()->admiko_cursos_id]));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($admiko_cursos_id,$id)
    {
        $Horario = Horario::find($id);
        if (Gate::none(['horario_allow', 'horario_edit']) || !$Horario) {
            return redirect(route("admin.horario.index",[$admiko_cursos_id]));
        }

        $admiko_data['sideBarActive'] = "cursos";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.horario.update", [$admiko_cursos_id,$Horario->id]);
        
        
		$dias_all = Dias::all()->sortBy("dia_de_semana")->pluck("dia_de_semana", "id");
		$aulas_all = Aulas::all()->sortBy("codigo")->pluck("codigo", "id");
		$docentes_all = Docentes::all()->sortBy("apellidos")->pluck("apellidos", "id");
        $data = $Horario;
        return view("admin.cursos.horario.manage")->with(compact('admiko_data', 'data','dias_all','aulas_all','docentes_all'));
    }

    public function update(HorarioRequest $request,$admiko_cursos_id,$id)
    {
        if (Gate::none(['horario_allow', 'horario_edit'])) {
            return redirect(route("admin.horario.index",[$admiko_cursos_id]));
        }
        $data = $request->all();
        $Horario = Horario::find($id);
        $Horario->update($data);
        
        return redirect(route("admin.horario.index",[$admiko_cursos_id]));
    }

    public function destroy(Request $request,$admiko_cursos_id)
    {
        if (Gate::none(['horario_allow'])) {
            return redirect(route("admin.horario.index",[$admiko_cursos_id]));
        }
        Horario::destroy($request->idDel);
        return back();
    }
    
    
    
}
