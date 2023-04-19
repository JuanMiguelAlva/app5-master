<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Galeria;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\GaleriaRequest;
use Gate;

class GaleriaController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::none(['galeria_allow', 'galeria_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "galeria";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data["fileInfo"] = Galeria::$admiko_file_info;
        $tableData = Galeria::search($request->query("search"))->orderByDesc("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table_gallery")));
        return view("admin.galeria.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['galeria_allow'])) {
            return redirect(route("admin.galeria.index"));
        }
        $admiko_data['sideBarActive'] = "galeria";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.galeria.store");
        $admiko_data["fileInfo"] = Galeria::$admiko_file_info;
        
        return view("admin.galeria.manage")->with(compact('admiko_data'));
    }

    public function store(GaleriaRequest $request)
    {
        if (Gate::none(['galeria_allow'])) {
            return redirect(route("admin.galeria.index"));
        }
        $data = $request->all();
        
        $Galeria = Galeria::create($data);
        
        return redirect(route("admin.galeria.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Galeria = Galeria::find($id);
        if (Gate::none(['galeria_allow', 'galeria_edit']) || !$Galeria) {
            return redirect(route("admin.galeria.index"));
        }

        $admiko_data['sideBarActive'] = "galeria";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.galeria.update", [$Galeria->id]);
        $admiko_data["fileInfo"] = Galeria::$admiko_file_info;
        
        $data = $Galeria;
        return view("admin.galeria.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(GaleriaRequest $request,$id)
    {
        if (Gate::none(['galeria_allow', 'galeria_edit'])) {
            return redirect(route("admin.galeria.index"));
        }
        $data = $request->all();
        $Galeria = Galeria::find($id);
        $Galeria->update($data);
        
        return redirect(route("admin.galeria.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['galeria_allow'])) {
            return redirect(route("admin.galeria.index"));
        }
        Galeria::destroy($request->idDel);
        return back();
    }
    
    public function admiko_many_files_store(Request $request)
    {
        if(Gate::none(['galeria_allow'])) { return redirect(route("admin.galeria")); };
        if($request->hasFile("foto")) {
            $data = $request->all();
            Galeria::create($data);
        }

    }
    
    
}
