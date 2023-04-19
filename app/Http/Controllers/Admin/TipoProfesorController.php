<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\TipoProfesor;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\TipoProfesorRequest;
use Gate;

class TipoProfesorController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['tipo_profesor_allow', 'tipo_profesor_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "tipo_profesor";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = TipoProfesor::search($request->query("search"))->orderBy("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table")));
        return view("admin.tipo_profesor.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['tipo_profesor_allow'])) {
            return redirect(route("admin.tipo_profesor.index"));
        }
        $admiko_data['sideBarActive'] = "tipo_profesor";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.tipo_profesor.store");
        
        
        return view("admin.tipo_profesor.manage")->with(compact('admiko_data'));
    }

    public function store(TipoProfesorRequest $request)
    {
        if (Gate::none(['tipo_profesor_allow'])) {
            return redirect(route("admin.tipo_profesor.index"));
        }
        $data = $request->all();
        
        $TipoProfesor = TipoProfesor::create($data);
        
        return redirect(route("admin.tipo_profesor.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $TipoProfesor = TipoProfesor::find($id);
        if (Gate::none(['tipo_profesor_allow', 'tipo_profesor_edit']) || !$TipoProfesor) {
            return redirect(route("admin.tipo_profesor.index"));
        }

        $admiko_data['sideBarActive'] = "tipo_profesor";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.tipo_profesor.update", [$TipoProfesor->id]);
        
        
        $data = $TipoProfesor;
        return view("admin.tipo_profesor.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(TipoProfesorRequest $request,$id)
    {
        if (Gate::none(['tipo_profesor_allow', 'tipo_profesor_edit'])) {
            return redirect(route("admin.tipo_profesor.index"));
        }
        $data = $request->all();
        $TipoProfesor = TipoProfesor::find($id);
        $TipoProfesor->update($data);
        
        return redirect(route("admin.tipo_profesor.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['tipo_profesor_allow'])) {
            return redirect(route("admin.tipo_profesor.index"));
        }
        TipoProfesor::destroy($request->idDel);
        return back();
    }
    
    
    
}
