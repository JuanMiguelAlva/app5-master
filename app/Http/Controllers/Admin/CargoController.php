<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Cargo;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CargoRequest;
use Gate;

class CargoController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['cargo_allow', 'cargo_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "cargo";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        
        $tableData = Cargo::search($request->query("search"))->orderBy("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table")));
        return view("admin.cargo.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['cargo_allow'])) {
            return redirect(route("admin.cargo.index"));
        }
        $admiko_data['sideBarActive'] = "cargo";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.cargo.store");
        
        
        return view("admin.cargo.manage")->with(compact('admiko_data'));
    }

    public function store(CargoRequest $request)
    {
        if (Gate::none(['cargo_allow'])) {
            return redirect(route("admin.cargo.index"));
        }
        $data = $request->all();
        
        $Cargo = Cargo::create($data);
        
        return redirect(route("admin.cargo.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Cargo = Cargo::find($id);
        if (Gate::none(['cargo_allow', 'cargo_edit']) || !$Cargo) {
            return redirect(route("admin.cargo.index"));
        }

        $admiko_data['sideBarActive'] = "cargo";
		$admiko_data["sideBarActiveFolder"] = "_recursos";
        $admiko_data['formAction'] = route("admin.cargo.update", [$Cargo->id]);
        
        
        $data = $Cargo;
        return view("admin.cargo.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(CargoRequest $request,$id)
    {
        if (Gate::none(['cargo_allow', 'cargo_edit'])) {
            return redirect(route("admin.cargo.index"));
        }
        $data = $request->all();
        $Cargo = Cargo::find($id);
        $Cargo->update($data);
        
        return redirect(route("admin.cargo.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['cargo_allow'])) {
            return redirect(route("admin.cargo.index"));
        }
        Cargo::destroy($request->idDel);
        return back();
    }
    
    
    
}
