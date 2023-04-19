<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Historia;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\HistoriaRequest;
use Gate;

class HistoriaController extends Controller
{

    public function index()
    {
        if (Gate::none(['historia_allow', 'historia_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "historia";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        
        $tableData = Historia::orderBy("id")->get();
        return view("admin.historia.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['historia_allow'])) {
            return redirect(route("admin.historia.index"));
        }
        $admiko_data['sideBarActive'] = "historia";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.historia.store");
        
        
        return view("admin.historia.manage")->with(compact('admiko_data'));
    }

    public function store(HistoriaRequest $request)
    {
        if (Gate::none(['historia_allow'])) {
            return redirect(route("admin.historia.index"));
        }
        $data = $request->all();
        
        $Historia = Historia::create($data);
        
        return redirect(route("admin.historia.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Historia = Historia::find($id);
        if (Gate::none(['historia_allow', 'historia_edit']) || !$Historia) {
            return redirect(route("admin.historia.index"));
        }

        $admiko_data['sideBarActive'] = "historia";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.historia.update", [$Historia->id]);
        
        
        $data = $Historia;
        return view("admin.historia.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(HistoriaRequest $request,$id)
    {
        if (Gate::none(['historia_allow', 'historia_edit'])) {
            return redirect(route("admin.historia.index"));
        }
        $data = $request->all();
        $Historia = Historia::find($id);
        $Historia->update($data);
        
        return redirect(route("admin.historia.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['historia_allow'])) {
            return redirect(route("admin.historia.index"));
        }
        Historia::destroy($request->idDel);
        return back();
    }
    
    
    
}
