<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Ambientes;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AmbientesRequest;
use Gate;

class AmbientesController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['ambientes_allow', 'ambientes_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "ambientes";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data["fileInfo"] = Ambientes::$admiko_file_info;
        $tableData = Ambientes::search($request->query("search"))->orderBy("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table_card")));
        return view("admin.ambientes.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['ambientes_allow'])) {
            return redirect(route("admin.ambientes.index"));
        }
        $admiko_data['sideBarActive'] = "ambientes";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.ambientes.store");
        $admiko_data["fileInfo"] = Ambientes::$admiko_file_info;
        
        return view("admin.ambientes.manage")->with(compact('admiko_data'));
    }

    public function store(AmbientesRequest $request)
    {
        if (Gate::none(['ambientes_allow'])) {
            return redirect(route("admin.ambientes.index"));
        }
        $data = $request->all();
        
        $Ambientes = Ambientes::create($data);
        
        return redirect(route("admin.ambientes.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Ambientes = Ambientes::find($id);
        if (Gate::none(['ambientes_allow', 'ambientes_edit']) || !$Ambientes) {
            return redirect(route("admin.ambientes.index"));
        }

        $admiko_data['sideBarActive'] = "ambientes";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.ambientes.update", [$Ambientes->id]);
        $admiko_data["fileInfo"] = Ambientes::$admiko_file_info;
        
        $data = $Ambientes;
        return view("admin.ambientes.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(AmbientesRequest $request,$id)
    {
        if (Gate::none(['ambientes_allow', 'ambientes_edit'])) {
            return redirect(route("admin.ambientes.index"));
        }
        $data = $request->all();
        $Ambientes = Ambientes::find($id);
        $Ambientes->update($data);
        
        return redirect(route("admin.ambientes.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['ambientes_allow'])) {
            return redirect(route("admin.ambientes.index"));
        }
        Ambientes::destroy($request->idDel);
        return back();
    }
    
    
    
}
