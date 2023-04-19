<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Autoridades;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AutoridadesRequest;
use Gate;
use App\Models\Admin\Cargo;
use App\Models\Admin\Grados;
use App\Models\Admin\Unidad;

class AutoridadesController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['autoridades_allow', 'autoridades_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "autoridades";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data["fileInfo"] = Autoridades::$admiko_file_info;
        $tableData = Autoridades::search($request->query("search"))->orderBy("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table")));
        return view("admin.autoridades.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['autoridades_allow'])) {
            return redirect(route("admin.autoridades.index"));
        }
        $admiko_data['sideBarActive'] = "autoridades";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.autoridades.store");
        $admiko_data["fileInfo"] = Autoridades::$admiko_file_info;
        
		$cargo_all = Cargo::all()->sortBy("nombre")->pluck("nombre", "id");
		$grados_all = Grados::all()->sortBy("abreviatura")->pluck("abreviatura", "id");
		$unidad_all = Unidad::all()->sortBy("nombre")->pluck("nombre", "id");
        return view("admin.autoridades.manage")->with(compact('admiko_data','cargo_all','grados_all','unidad_all'));
    }

    public function store(AutoridadesRequest $request)
    {
        if (Gate::none(['autoridades_allow'])) {
            return redirect(route("admin.autoridades.index"));
        }
        $data = $request->all();
        
        $Autoridades = Autoridades::create($data);
        
        return redirect(route("admin.autoridades.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Autoridades = Autoridades::find($id);
        if (Gate::none(['autoridades_allow', 'autoridades_edit']) || !$Autoridades) {
            return redirect(route("admin.autoridades.index"));
        }

        $admiko_data['sideBarActive'] = "autoridades";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.autoridades.update", [$Autoridades->id]);
        $admiko_data["fileInfo"] = Autoridades::$admiko_file_info;
        
		$cargo_all = Cargo::all()->sortBy("nombre")->pluck("nombre", "id");
		$grados_all = Grados::all()->sortBy("abreviatura")->pluck("abreviatura", "id");
		$unidad_all = Unidad::all()->sortBy("nombre")->pluck("nombre", "id");
        $data = $Autoridades;
        return view("admin.autoridades.manage")->with(compact('admiko_data', 'data','cargo_all','grados_all','unidad_all'));
    }

    public function update(AutoridadesRequest $request,$id)
    {
        if (Gate::none(['autoridades_allow', 'autoridades_edit'])) {
            return redirect(route("admin.autoridades.index"));
        }
        $data = $request->all();
        $Autoridades = Autoridades::find($id);
        $Autoridades->update($data);
        
        return redirect(route("admin.autoridades.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['autoridades_allow'])) {
            return redirect(route("admin.autoridades.index"));
        }
        Autoridades::destroy($request->idDel);
        return back();
    }
    
    
    
}
