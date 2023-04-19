<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Docentes;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\DocentesRequest;
use Gate;
use App\Models\Admin\TipoProfesor;
use App\Models\Admin\Condicion;
use App\Models\Admin\Grados;
use App\Models\Admin\Especialidades;

class DocentesController extends Controller
{

    public function index()
    {
        if (Gate::none(['docentes_allow', 'docentes_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "docentes";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data["fileInfo"] = Docentes::$admiko_file_info;
        $tableData = Docentes::orderBy("id")->get();
        return view("admin.docentes.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['docentes_allow'])) {
            return redirect(route("admin.docentes.index"));
        }
        $admiko_data['sideBarActive'] = "docentes";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.docentes.store");
        $admiko_data["fileInfo"] = Docentes::$admiko_file_info;
        
		$tipo_profesor_all = TipoProfesor::all()->sortBy("tipo")->pluck("tipo", "id");
		$condicion_all = Condicion::all()->sortBy("nombre")->pluck("nombre", "id");
		$grados_all = Grados::all()->sortBy("abreviatura")->pluck("abreviatura", "id");
		$especialidades_all = Especialidades::all()->sortBy("nombre")->pluck("nombre", "id");
        return view("admin.docentes.manage")->with(compact('admiko_data','tipo_profesor_all','condicion_all','grados_all','especialidades_all'));
    }

    public function store(DocentesRequest $request)
    {
        if (Gate::none(['docentes_allow'])) {
            return redirect(route("admin.docentes.index"));
        }
        $data = $request->all();
        
        $Docentes = Docentes::create($data);
        
        return redirect(route("admin.docentes.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Docentes = Docentes::find($id);
        if (Gate::none(['docentes_allow', 'docentes_edit']) || !$Docentes) {
            return redirect(route("admin.docentes.index"));
        }

        $admiko_data['sideBarActive'] = "docentes";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.docentes.update", [$Docentes->id]);
        $admiko_data["fileInfo"] = Docentes::$admiko_file_info;
        
		$tipo_profesor_all = TipoProfesor::all()->sortBy("tipo")->pluck("tipo", "id");
		$condicion_all = Condicion::all()->sortBy("nombre")->pluck("nombre", "id");
		$grados_all = Grados::all()->sortBy("abreviatura")->pluck("abreviatura", "id");
		$especialidades_all = Especialidades::all()->sortBy("nombre")->pluck("nombre", "id");
        $data = $Docentes;
        return view("admin.docentes.manage")->with(compact('admiko_data', 'data','tipo_profesor_all','condicion_all','grados_all','especialidades_all'));
    }

    public function update(DocentesRequest $request,$id)
    {
        if (Gate::none(['docentes_allow', 'docentes_edit'])) {
            return redirect(route("admin.docentes.index"));
        }
        $data = $request->all();
        $Docentes = Docentes::find($id);
        $Docentes->update($data);
        
        return redirect(route("admin.docentes.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['docentes_allow'])) {
            return redirect(route("admin.docentes.index"));
        }
        Docentes::destroy($request->idDel);
        return back();
    }
    
    
    
}
