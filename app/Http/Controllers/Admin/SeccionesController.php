<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Secciones;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SeccionesRequest;
use Gate;
use App\Models\Admin\Ciclos;

class SeccionesController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['secciones_allow', 'secciones_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "secciones";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Secciones::search($request->query("search"))->orderBy("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table")));
        return view("admin.secciones.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['secciones_allow'])) {
            return redirect(route("admin.secciones.index"));
        }
        $admiko_data['sideBarActive'] = "secciones";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.secciones.store");
        
        
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
        return view("admin.secciones.manage")->with(compact('admiko_data','ciclos_all'));
    }

    public function store(SeccionesRequest $request)
    {
        if (Gate::none(['secciones_allow'])) {
            return redirect(route("admin.secciones.index"));
        }
        $data = $request->all();
        
        $Secciones = Secciones::create($data);
        
        return redirect(route("admin.secciones.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Secciones = Secciones::find($id);
        if (Gate::none(['secciones_allow', 'secciones_edit']) || !$Secciones) {
            return redirect(route("admin.secciones.index"));
        }

        $admiko_data['sideBarActive'] = "secciones";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.secciones.update", [$Secciones->id]);
        
        
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
        $data = $Secciones;
        return view("admin.secciones.manage")->with(compact('admiko_data', 'data','ciclos_all'));
    }

    public function update(SeccionesRequest $request,$id)
    {
        if (Gate::none(['secciones_allow', 'secciones_edit'])) {
            return redirect(route("admin.secciones.index"));
        }
        $data = $request->all();
        $Secciones = Secciones::find($id);
        $Secciones->update($data);
        
        return redirect(route("admin.secciones.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['secciones_allow'])) {
            return redirect(route("admin.secciones.index"));
        }
        Secciones::destroy($request->idDel);
        return back();
    }
    
    
    
}
