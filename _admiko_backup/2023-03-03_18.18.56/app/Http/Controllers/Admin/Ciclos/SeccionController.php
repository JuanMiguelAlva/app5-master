<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin\Ciclos;
use App\Http\Controllers\Controller;
use App\Models\Admin\Ciclos\Seccion;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Ciclos\SeccionRequest;
use Gate;

class SeccionController extends Controller
{

    public function index()
    {
        if (Gate::none(['seccion_allow', 'seccion_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "ciclos";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Seccion::where("admiko_ciclos_id",Request()->admiko_ciclos_id)->orderBy("id")->get();
        return view("admin.ciclos.seccion.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['seccion_allow'])) {
            return redirect(route("admin.seccion.index",[Request()->admiko_ciclos_id]));
        }
        $admiko_data['sideBarActive'] = "ciclos";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.seccion.store",[Request()->admiko_ciclos_id]);
        
        
        return view("admin.ciclos.seccion.manage")->with(compact('admiko_data'));
    }

    public function store(SeccionRequest $request)
    {
        if (Gate::none(['seccion_allow'])) {
            return redirect(route("admin.seccion.index",[Request()->admiko_ciclos_id]));
        }
        $data = $request->all();
        
		$data["admiko_ciclos_id"] = Request()->admiko_ciclos_id;
        $Seccion = Seccion::create($data);
        
        return redirect(route("admin.seccion.index",[Request()->admiko_ciclos_id]));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($admiko_ciclos_id,$id)
    {
        $Seccion = Seccion::find($id);
        if (Gate::none(['seccion_allow', 'seccion_edit']) || !$Seccion) {
            return redirect(route("admin.seccion.index",[$admiko_ciclos_id]));
        }

        $admiko_data['sideBarActive'] = "ciclos";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.seccion.update", [$admiko_ciclos_id,$Seccion->id]);
        
        
        $data = $Seccion;
        return view("admin.ciclos.seccion.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(SeccionRequest $request,$admiko_ciclos_id,$id)
    {
        if (Gate::none(['seccion_allow', 'seccion_edit'])) {
            return redirect(route("admin.seccion.index",[$admiko_ciclos_id]));
        }
        $data = $request->all();
        $Seccion = Seccion::find($id);
        $Seccion->update($data);
        
        return redirect(route("admin.seccion.index",[$admiko_ciclos_id]));
    }

    public function destroy(Request $request,$admiko_ciclos_id)
    {
        if (Gate::none(['seccion_allow'])) {
            return redirect(route("admin.seccion.index",[$admiko_ciclos_id]));
        }
        Seccion::destroy($request->idDel);
        return back();
    }
    
    
    
}
