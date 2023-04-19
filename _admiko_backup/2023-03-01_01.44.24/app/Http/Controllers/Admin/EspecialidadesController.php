<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Especialidades;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\EspecialidadesRequest;
use Gate;

class EspecialidadesController extends Controller
{

    public function index()
    {
        if (Gate::none(['especialidades_allow', 'especialidades_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "especialidades";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Especialidades::orderBy("id")->get();
        return view("admin.especialidades.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['especialidades_allow'])) {
            return redirect(route("admin.especialidades.index"));
        }
        $admiko_data['sideBarActive'] = "especialidades";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.especialidades.store");
        
        
        return view("admin.especialidades.manage")->with(compact('admiko_data'));
    }

    public function store(EspecialidadesRequest $request)
    {
        if (Gate::none(['especialidades_allow'])) {
            return redirect(route("admin.especialidades.index"));
        }
        $data = $request->all();
        
        $Especialidades = Especialidades::create($data);
        
        return redirect(route("admin.especialidades.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Especialidades = Especialidades::find($id);
        if (Gate::none(['especialidades_allow', 'especialidades_edit']) || !$Especialidades) {
            return redirect(route("admin.especialidades.index"));
        }

        $admiko_data['sideBarActive'] = "especialidades";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.especialidades.update", [$Especialidades->id]);
        
        
        $data = $Especialidades;
        return view("admin.especialidades.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(EspecialidadesRequest $request,$id)
    {
        if (Gate::none(['especialidades_allow', 'especialidades_edit'])) {
            return redirect(route("admin.especialidades.index"));
        }
        $data = $request->all();
        $Especialidades = Especialidades::find($id);
        $Especialidades->update($data);
        
        return redirect(route("admin.especialidades.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['especialidades_allow'])) {
            return redirect(route("admin.especialidades.index"));
        }
        Especialidades::destroy($request->idDel);
        return back();
    }
    
    
    
}
