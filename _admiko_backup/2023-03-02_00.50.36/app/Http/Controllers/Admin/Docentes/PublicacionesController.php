<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin\Docentes;
use App\Http\Controllers\Controller;
use App\Models\Admin\Docentes\Publicaciones;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Docentes\PublicacionesRequest;
use Gate;

class PublicacionesController extends Controller
{

    public function index()
    {
        if (Gate::none(['publicaciones_allow', 'publicaciones_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "docentes";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        
        $tableData = Publicaciones::where("admiko_docentes_id",Request()->admiko_docentes_id)->orderBy("id")->get();
        return view("admin.docentes.publicaciones.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['publicaciones_allow'])) {
            return redirect(route("admin.publicaciones.index",[Request()->admiko_docentes_id]));
        }
        $admiko_data['sideBarActive'] = "docentes";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.publicaciones.store",[Request()->admiko_docentes_id]);
        
        
        return view("admin.docentes.publicaciones.manage")->with(compact('admiko_data'));
    }

    public function store(PublicacionesRequest $request)
    {
        if (Gate::none(['publicaciones_allow'])) {
            return redirect(route("admin.publicaciones.index",[Request()->admiko_docentes_id]));
        }
        $data = $request->all();
        
		$data["admiko_docentes_id"] = Request()->admiko_docentes_id;
        $Publicaciones = Publicaciones::create($data);
        
        return redirect(route("admin.publicaciones.index",[Request()->admiko_docentes_id]));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($admiko_docentes_id,$id)
    {
        $Publicaciones = Publicaciones::find($id);
        if (Gate::none(['publicaciones_allow', 'publicaciones_edit']) || !$Publicaciones) {
            return redirect(route("admin.publicaciones.index",[$admiko_docentes_id]));
        }

        $admiko_data['sideBarActive'] = "docentes";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.publicaciones.update", [$admiko_docentes_id,$Publicaciones->id]);
        
        
        $data = $Publicaciones;
        return view("admin.docentes.publicaciones.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(PublicacionesRequest $request,$admiko_docentes_id,$id)
    {
        if (Gate::none(['publicaciones_allow', 'publicaciones_edit'])) {
            return redirect(route("admin.publicaciones.index",[$admiko_docentes_id]));
        }
        $data = $request->all();
        $Publicaciones = Publicaciones::find($id);
        $Publicaciones->update($data);
        
        return redirect(route("admin.publicaciones.index",[$admiko_docentes_id]));
    }

    public function destroy(Request $request,$admiko_docentes_id)
    {
        if (Gate::none(['publicaciones_allow'])) {
            return redirect(route("admin.publicaciones.index",[$admiko_docentes_id]));
        }
        Publicaciones::destroy($request->idDel);
        return back();
    }
    
    
    
    public function admiko_dynamic_fields(Request $request,$admiko_docentes_id,$id)
    {
        if(Gate::none(['publicaciones_allow'])) { return redirect(route("admin.publicaciones")); }
        Publicaciones::find($id)->update($request->all());
        return back();
    }

}
