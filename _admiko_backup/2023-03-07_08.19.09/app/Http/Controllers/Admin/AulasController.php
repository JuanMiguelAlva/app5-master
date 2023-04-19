<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Aulas;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AulasRequest;
use Gate;
use App\Models\Admin\Ciclos;
use App\Models\Admin\Secciones;

class AulasController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['aulas_allow', 'aulas_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "aulas";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Aulas::search($request->query("search"))->orderBy("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table")));
        return view("admin.aulas.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['aulas_allow'])) {
            return redirect(route("admin.aulas.index"));
        }
        $admiko_data['sideBarActive'] = "aulas";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.aulas.store");
        
        
		$turno_all = Aulas::TURNO_CONS;
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
		$secciones_all = Secciones::all()->sortBy("nombre")->pluck("nombre", "id");
        return view("admin.aulas.manage")->with(compact('admiko_data','turno_all','ciclos_all','secciones_all'));
    }

    public function store(AulasRequest $request)
    {
        if (Gate::none(['aulas_allow'])) {
            return redirect(route("admin.aulas.index"));
        }
        $data = $request->all();
        
        $Aulas = Aulas::create($data);
        
        return redirect(route("admin.aulas.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Aulas = Aulas::find($id);
        if (Gate::none(['aulas_allow', 'aulas_edit']) || !$Aulas) {
            return redirect(route("admin.aulas.index"));
        }

        $admiko_data['sideBarActive'] = "aulas";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.aulas.update", [$Aulas->id]);
        
        
		$turno_all = Aulas::TURNO_CONS;
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
		$secciones_all = Secciones::all()->sortBy("nombre")->pluck("nombre", "id");
        $data = $Aulas;
        return view("admin.aulas.manage")->with(compact('admiko_data', 'data','turno_all','ciclos_all','secciones_all'));
    }

    public function update(AulasRequest $request,$id)
    {
        if (Gate::none(['aulas_allow', 'aulas_edit'])) {
            return redirect(route("admin.aulas.index"));
        }
        $data = $request->all();
        $Aulas = Aulas::find($id);
        $Aulas->update($data);
        
        return redirect(route("admin.aulas.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['aulas_allow'])) {
            return redirect(route("admin.aulas.index"));
        }
        Aulas::destroy($request->idDel);
        return back();
    }
    
    
    
}
