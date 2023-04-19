<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Ciclos;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CiclosRequest;
use Gate;

class CiclosController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['ciclos_allow', 'ciclos_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "ciclos";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Ciclos::search($request->query("search"))->orderBy("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table")));
        return view("admin.ciclos.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['ciclos_allow'])) {
            return redirect(route("admin.ciclos.index"));
        }
        $admiko_data['sideBarActive'] = "ciclos";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.ciclos.store");
        
        
        return view("admin.ciclos.manage")->with(compact('admiko_data'));
    }

    public function store(CiclosRequest $request)
    {
        if (Gate::none(['ciclos_allow'])) {
            return redirect(route("admin.ciclos.index"));
        }
        $data = $request->all();
        
        $Ciclos = Ciclos::create($data);
        
        return redirect(route("admin.ciclos.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Ciclos = Ciclos::find($id);
        if (Gate::none(['ciclos_allow', 'ciclos_edit']) || !$Ciclos) {
            return redirect(route("admin.ciclos.index"));
        }

        $admiko_data['sideBarActive'] = "ciclos";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.ciclos.update", [$Ciclos->id]);
        
        
        $data = $Ciclos;
        return view("admin.ciclos.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(CiclosRequest $request,$id)
    {
        if (Gate::none(['ciclos_allow', 'ciclos_edit'])) {
            return redirect(route("admin.ciclos.index"));
        }
        $data = $request->all();
        $Ciclos = Ciclos::find($id);
        $Ciclos->update($data);
        
        return redirect(route("admin.ciclos.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['ciclos_allow'])) {
            return redirect(route("admin.ciclos.index"));
        }
        Ciclos::destroy($request->idDel);
        return back();
    }
    
    
    
}
