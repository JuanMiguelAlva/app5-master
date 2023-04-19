<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\TipoPublicacion;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\TipoPublicacionRequest;
use Gate;

class TipoPublicacionController extends Controller
{

    public function index()
    {
        if (Gate::none(['tipo_publicacion_allow', 'tipo_publicacion_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "tipo_publicacion";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = TipoPublicacion::orderBy("id")->get();
        return view("admin.tipo_publicacion.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['tipo_publicacion_allow'])) {
            return redirect(route("admin.tipo_publicacion.index"));
        }
        $admiko_data['sideBarActive'] = "tipo_publicacion";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.tipo_publicacion.store");
        
        
        return view("admin.tipo_publicacion.manage")->with(compact('admiko_data'));
    }

    public function store(TipoPublicacionRequest $request)
    {
        if (Gate::none(['tipo_publicacion_allow'])) {
            return redirect(route("admin.tipo_publicacion.index"));
        }
        $data = $request->all();
        
        $TipoPublicacion = TipoPublicacion::create($data);
        
        return redirect(route("admin.tipo_publicacion.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $TipoPublicacion = TipoPublicacion::find($id);
        if (Gate::none(['tipo_publicacion_allow', 'tipo_publicacion_edit']) || !$TipoPublicacion) {
            return redirect(route("admin.tipo_publicacion.index"));
        }

        $admiko_data['sideBarActive'] = "tipo_publicacion";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.tipo_publicacion.update", [$TipoPublicacion->id]);
        
        
        $data = $TipoPublicacion;
        return view("admin.tipo_publicacion.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(TipoPublicacionRequest $request,$id)
    {
        if (Gate::none(['tipo_publicacion_allow', 'tipo_publicacion_edit'])) {
            return redirect(route("admin.tipo_publicacion.index"));
        }
        $data = $request->all();
        $TipoPublicacion = TipoPublicacion::find($id);
        $TipoPublicacion->update($data);
        
        return redirect(route("admin.tipo_publicacion.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['tipo_publicacion_allow'])) {
            return redirect(route("admin.tipo_publicacion.index"));
        }
        TipoPublicacion::destroy($request->idDel);
        return back();
    }
    
    
    
}
