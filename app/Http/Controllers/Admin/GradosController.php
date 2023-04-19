<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Grados;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\GradosRequest;
use Gate;

class GradosController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['grados_allow', 'grados_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "grados";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Grados::search($request->query("search"))->orderBy("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table")));
        return view("admin.grados.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['grados_allow'])) {
            return redirect(route("admin.grados.index"));
        }
        $admiko_data['sideBarActive'] = "grados";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.grados.store");
        
        
        return view("admin.grados.manage")->with(compact('admiko_data'));
    }

    public function store(GradosRequest $request)
    {
        if (Gate::none(['grados_allow'])) {
            return redirect(route("admin.grados.index"));
        }
        $data = $request->all();
        
        $Grados = Grados::create($data);
        
        return redirect(route("admin.grados.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Grados = Grados::find($id);
        if (Gate::none(['grados_allow', 'grados_edit']) || !$Grados) {
            return redirect(route("admin.grados.index"));
        }

        $admiko_data['sideBarActive'] = "grados";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.grados.update", [$Grados->id]);
        
        
        $data = $Grados;
        return view("admin.grados.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(GradosRequest $request,$id)
    {
        if (Gate::none(['grados_allow', 'grados_edit'])) {
            return redirect(route("admin.grados.index"));
        }
        $data = $request->all();
        $Grados = Grados::find($id);
        $Grados->update($data);
        
        return redirect(route("admin.grados.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['grados_allow'])) {
            return redirect(route("admin.grados.index"));
        }
        Grados::destroy($request->idDel);
        return back();
    }
    
    
    
}
