<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Resoluciones;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ResolucionesRequest;
use Gate;

class ResolucionesController extends Controller
{

    public function index()
    {
        if (Gate::none(['resoluciones_allow', 'resoluciones_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "resoluciones";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data["fileInfo"] = Resoluciones::$admiko_file_info;
        $tableData = Resoluciones::orderBy("id")->get();
        return view("admin.resoluciones.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['resoluciones_allow'])) {
            return redirect(route("admin.resoluciones.index"));
        }
        $admiko_data['sideBarActive'] = "resoluciones";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.resoluciones.store");
        $admiko_data["fileInfo"] = Resoluciones::$admiko_file_info;
        
        return view("admin.resoluciones.manage")->with(compact('admiko_data'));
    }

    public function store(ResolucionesRequest $request)
    {
        if (Gate::none(['resoluciones_allow'])) {
            return redirect(route("admin.resoluciones.index"));
        }
        $data = $request->all();
        
        $Resoluciones = Resoluciones::create($data);
        
        return redirect(route("admin.resoluciones.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Resoluciones = Resoluciones::find($id);
        if (Gate::none(['resoluciones_allow', 'resoluciones_edit']) || !$Resoluciones) {
            return redirect(route("admin.resoluciones.index"));
        }

        $admiko_data['sideBarActive'] = "resoluciones";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.resoluciones.update", [$Resoluciones->id]);
        $admiko_data["fileInfo"] = Resoluciones::$admiko_file_info;
        
        $data = $Resoluciones;
        return view("admin.resoluciones.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(ResolucionesRequest $request,$id)
    {
        if (Gate::none(['resoluciones_allow', 'resoluciones_edit'])) {
            return redirect(route("admin.resoluciones.index"));
        }
        $data = $request->all();
        $Resoluciones = Resoluciones::find($id);
        $Resoluciones->update($data);
        
        return redirect(route("admin.resoluciones.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['resoluciones_allow'])) {
            return redirect(route("admin.resoluciones.index"));
        }
        Resoluciones::destroy($request->idDel);
        return back();
    }
    
    public function admiko_many_files_store(Request $request)
    {
        if(Gate::none(['resoluciones_allow'])) { return redirect(route("admin.resoluciones")); };
        if($request->hasFile("documentos")) {
            $data = $request->all();
            Resoluciones::create($data);
        }

    }
    
    
}
