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
use App\Models\Admin\Aulas;

class DistribucionDeAulasController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['distribucion_de_aulas_allow', 'distribucion_de_aulas_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "distribucion_de_aulas";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
		if($request->id == "0"){ return redirect(route("admin.distribucion_de_aulas.index")); }
		$data_admiko_parent_child = DistribucionDeAulas::getParentChildrenList();
        $tableData = DistribucionDeAulas::where("admiko_parent_child",$request->id??0)->orderByDesc("id")->get();
        return view("admin.distribucion_de_aulas.index")->with(compact('admiko_data', "tableData",'data_admiko_parent_child'));
    }

    public function create()
    {
        if (Gate::none(['distribucion_de_aulas_allow'])) {
            return redirect(route("admin.distribucion_de_aulas.index",Request()->return_page??""));
        }
        $admiko_data['sideBarActive'] = "distribucion_de_aulas";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.distribucion_de_aulas.store",Request()->id??"");
        
        
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
		$aulas_all = Aulas::all()->sortBy("codigo")->pluck("codigo", "id");
		$data_admiko_parent_child = DistribucionDeAulas::getParentChildrenList();
        return view("admin.distribucion_de_aulas.manage")->with(compact('admiko_data','ciclos_all','aulas_all','data_admiko_parent_child'));
    }

    public function store(DistribucionDeAulasRequest $request)
    {
        if (Gate::none(['distribucion_de_aulas_allow'])) {
            return redirect(route("admin.distribucion_de_aulas.index",Request()->return_page??""));
        }
        $data = $request->all();
        
        $DistribucionDeAulas = DistribucionDeAulas::create($data);
        
        return redirect(route("admin.distribucion_de_aulas.index",Request()->return_page??""));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $DistribucionDeAulas = DistribucionDeAulas::find($id);
        if (Gate::none(['distribucion_de_aulas_allow', 'distribucion_de_aulas_edit']) || !$DistribucionDeAulas) {
            return redirect(route("admin.distribucion_de_aulas.index"));
        }

        $admiko_data['sideBarActive'] = "distribucion_de_aulas";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.distribucion_de_aulas.update", [$DistribucionDeAulas->id]);
        
        
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
		$aulas_all = Aulas::all()->sortBy("codigo")->pluck("codigo", "id");
		$data_admiko_parent_child = DistribucionDeAulas::getParentChildrenList();
        $data = $DistribucionDeAulas;
        return view("admin.distribucion_de_aulas.manage")->with(compact('admiko_data', 'data','ciclos_all','aulas_all','data_admiko_parent_child'));
    }

    public function update(DistribucionDeAulasRequest $request,$id)
    {
        if (Gate::none(['distribucion_de_aulas_allow', 'distribucion_de_aulas_edit'])) {
            return redirect(route("admin.distribucion_de_aulas.index",$request->return_page??""));
        }
        $data = $request->all();
        $DistribucionDeAulas = DistribucionDeAulas::find($id);
        $DistribucionDeAulas->update($data);
        
        return redirect(route("admin.distribucion_de_aulas.index",$request->return_page??""));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['distribucion_de_aulas_allow'])) {
            return redirect(route("admin.distribucion_de_aulas.index",$request->return_page??""));
        }
		$DistribucionDeAulas = new DistribucionDeAulas();
		$DistribucionDeAulas->parentChildrenPrepareDelete($request->idDel);
        DistribucionDeAulas::destroy($request->idDel);
        return back();
    }
    
    
    
}
