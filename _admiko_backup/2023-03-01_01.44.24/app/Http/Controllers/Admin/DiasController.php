<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Dias;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\DiasRequest;
use Gate;

class DiasController extends Controller
{

    public function index()
    {
        if (Gate::none(['dias_allow', 'dias_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "dias";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Dias::orderBy("id")->get();
        return view("admin.dias.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['dias_allow'])) {
            return redirect(route("admin.dias.index"));
        }
        $admiko_data['sideBarActive'] = "dias";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.dias.store");
        
        
        return view("admin.dias.manage")->with(compact('admiko_data'));
    }

    public function store(DiasRequest $request)
    {
        if (Gate::none(['dias_allow'])) {
            return redirect(route("admin.dias.index"));
        }
        $data = $request->all();
        
        $Dias = Dias::create($data);
        
        return redirect(route("admin.dias.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Dias = Dias::find($id);
        if (Gate::none(['dias_allow', 'dias_edit']) || !$Dias) {
            return redirect(route("admin.dias.index"));
        }

        $admiko_data['sideBarActive'] = "dias";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.dias.update", [$Dias->id]);
        
        
        $data = $Dias;
        return view("admin.dias.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(DiasRequest $request,$id)
    {
        if (Gate::none(['dias_allow', 'dias_edit'])) {
            return redirect(route("admin.dias.index"));
        }
        $data = $request->all();
        $Dias = Dias::find($id);
        $Dias->update($data);
        
        return redirect(route("admin.dias.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['dias_allow'])) {
            return redirect(route("admin.dias.index"));
        }
        Dias::destroy($request->idDel);
        return back();
    }
    
    
    
}
