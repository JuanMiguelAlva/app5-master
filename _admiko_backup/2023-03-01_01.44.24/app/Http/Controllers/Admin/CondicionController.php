<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Condicion;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CondicionRequest;
use Gate;

class CondicionController extends Controller
{

    public function index()
    {
        if (Gate::none(['condicion_allow', 'condicion_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "condicion";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Condicion::orderBy("id")->get();
        return view("admin.condicion.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['condicion_allow'])) {
            return redirect(route("admin.condicion.index"));
        }
        $admiko_data['sideBarActive'] = "condicion";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.condicion.store");
        
        
        return view("admin.condicion.manage")->with(compact('admiko_data'));
    }

    public function store(CondicionRequest $request)
    {
        if (Gate::none(['condicion_allow'])) {
            return redirect(route("admin.condicion.index"));
        }
        $data = $request->all();
        
        $Condicion = Condicion::create($data);
        
        return redirect(route("admin.condicion.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Condicion = Condicion::find($id);
        if (Gate::none(['condicion_allow', 'condicion_edit']) || !$Condicion) {
            return redirect(route("admin.condicion.index"));
        }

        $admiko_data['sideBarActive'] = "condicion";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.condicion.update", [$Condicion->id]);
        
        
        $data = $Condicion;
        return view("admin.condicion.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(CondicionRequest $request,$id)
    {
        if (Gate::none(['condicion_allow', 'condicion_edit'])) {
            return redirect(route("admin.condicion.index"));
        }
        $data = $request->all();
        $Condicion = Condicion::find($id);
        $Condicion->update($data);
        
        return redirect(route("admin.condicion.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['condicion_allow'])) {
            return redirect(route("admin.condicion.index"));
        }
        Condicion::destroy($request->idDel);
        return back();
    }
    
    
    
}
