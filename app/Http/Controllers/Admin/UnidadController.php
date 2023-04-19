<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Unidad;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UnidadRequest;
use Gate;

class UnidadController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['unidad_allow', 'unidad_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "unidad";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Unidad::search($request->query("search"))->orderBy("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table")));
        return view("admin.unidad.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['unidad_allow'])) {
            return redirect(route("admin.unidad.index"));
        }
        $admiko_data['sideBarActive'] = "unidad";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.unidad.store");
        
        
        return view("admin.unidad.manage")->with(compact('admiko_data'));
    }

    public function store(UnidadRequest $request)
    {
        if (Gate::none(['unidad_allow'])) {
            return redirect(route("admin.unidad.index"));
        }
        $data = $request->all();
        
        $Unidad = Unidad::create($data);
        
        return redirect(route("admin.unidad.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Unidad = Unidad::find($id);
        if (Gate::none(['unidad_allow', 'unidad_edit']) || !$Unidad) {
            return redirect(route("admin.unidad.index"));
        }

        $admiko_data['sideBarActive'] = "unidad";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.unidad.update", [$Unidad->id]);
        
        
        $data = $Unidad;
        return view("admin.unidad.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(UnidadRequest $request,$id)
    {
        if (Gate::none(['unidad_allow', 'unidad_edit'])) {
            return redirect(route("admin.unidad.index"));
        }
        $data = $request->all();
        $Unidad = Unidad::find($id);
        $Unidad->update($data);
        
        return redirect(route("admin.unidad.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['unidad_allow'])) {
            return redirect(route("admin.unidad.index"));
        }
        Unidad::destroy($request->idDel);
        return back();
    }
    
    
    
}
