<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Informacion;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\InformacionRequest;
use Gate;

class InformacionController extends Controller
{

    public function index()
    {
        if (Gate::none(['informacion_allow', 'informacion_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "informacion";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        
        $tableData = Informacion::orderBy("id")->get();
        return view("admin.informacion.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['informacion_allow'])) {
            return redirect(route("admin.informacion.index"));
        }
        $admiko_data['sideBarActive'] = "informacion";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.informacion.store");
        
        
        return view("admin.informacion.manage")->with(compact('admiko_data'));
    }

    public function store(InformacionRequest $request)
    {
        if (Gate::none(['informacion_allow'])) {
            return redirect(route("admin.informacion.index"));
        }
        $data = $request->all();
        
        $Informacion = Informacion::create($data);
        
        return redirect(route("admin.informacion.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Informacion = Informacion::find($id);
        if (Gate::none(['informacion_allow', 'informacion_edit']) || !$Informacion) {
            return redirect(route("admin.informacion.index"));
        }

        $admiko_data['sideBarActive'] = "informacion";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.informacion.update", [$Informacion->id]);
        
        
        $data = $Informacion;
        return view("admin.informacion.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(InformacionRequest $request,$id)
    {
        if (Gate::none(['informacion_allow', 'informacion_edit'])) {
            return redirect(route("admin.informacion.index"));
        }
        $data = $request->all();
        $Informacion = Informacion::find($id);
        $Informacion->update($data);
        
        return redirect(route("admin.informacion.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['informacion_allow'])) {
            return redirect(route("admin.informacion.index"));
        }
        Informacion::destroy($request->idDel);
        return back();
    }
    
    
    
}
