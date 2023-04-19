<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\DistribucionDeAulas;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\DistribucionDeAulasRequest;
use Gate;
use App\Models\Admin\Ciclos;
use App\Models\Admin\Secciones;
use App\Models\Admin\Aulas;

class DistribucionDeAulasController extends Controller
{

    public function index()
    {
        if (Gate::none(['distribucion_de_aulas_allow', 'distribucion_de_aulas_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "distribucion_de_aulas";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        
        $tableData = DistribucionDeAulas::orderBy("id")->get();
        return view("admin.distribucion_de_aulas.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['distribucion_de_aulas_allow'])) {
            return redirect(route("admin.distribucion_de_aulas.index"));
        }
        $admiko_data['sideBarActive'] = "distribucion_de_aulas";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.distribucion_de_aulas.store");
        
        
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
		$secciones_all = Secciones::all()->sortBy("nombre")->pluck("nombre", "id");
		$aulas_all = Aulas::all()->sortBy("codigo")->pluck("codigo", "id");
		$turno_all = DistribucionDeAulas::TURNO_CONS;
        return view("admin.distribucion_de_aulas.manage")->with(compact('admiko_data','ciclos_all','secciones_all','aulas_all','turno_all'));
    }

    public function store(DistribucionDeAulasRequest $request)
    {
        if (Gate::none(['distribucion_de_aulas_allow'])) {
            return redirect(route("admin.distribucion_de_aulas.index"));
        }
        $data = $request->all();
        
        $DistribucionDeAulas = DistribucionDeAulas::create($data);
        
        return redirect(route("admin.distribucion_de_aulas.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit(Request $request,$id)
    {
        $DistribucionDeAulas = DistribucionDeAulas::find($id);
        if (Gate::none(['distribucion_de_aulas_allow', 'distribucion_de_aulas_edit']) || !$DistribucionDeAulas) {
            return redirect(route("admin.distribucion_de_aulas.index"));
        }

        if($request->ciclo!=null){
            $ciclo=$request->ciclo;
        }else{
            $ciclo=null;
        }

        $admiko_data['sideBarActive'] = "distribucion_de_aulas";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.distribucion_de_aulas.update", [$DistribucionDeAulas->id]);
        
        
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
		$secciones_all = Secciones::all()->sortBy("nombre")->pluck("nombre", "id");
		$aulas_all = Aulas::all()->sortBy("codigo")->pluck("codigo", "id");
		$turno_all = DistribucionDeAulas::TURNO_CONS;
        $data = $DistribucionDeAulas;
        return view("admin.distribucion_de_aulas.manage")->with(compact('admiko_data', 'data','ciclos_all','secciones_all','aulas_all','turno_all','ciclo'));
    }

    public function update(DistribucionDeAulasRequest $request,$id)
    {
        if (Gate::none(['distribucion_de_aulas_allow', 'distribucion_de_aulas_edit'])) {
            return redirect(route("admin.distribucion_de_aulas.index"));
        }
        $data = $request->all();
        $DistribucionDeAulas = DistribucionDeAulas::find($id);
        $DistribucionDeAulas->update($data);

        if($request->ciclo){
            return redirect(route('admin.horarios.index').'?ciclo='.$request->ciclo);
        }else{
            return redirect(route("admin.distribucion_de_aulas.index"));
        }        
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['distribucion_de_aulas_allow'])) {
            return redirect(route("admin.distribucion_de_aulas.index"));
        }
        DistribucionDeAulas::destroy($request->idDel);
        return back();
    }
    
    
    
}
