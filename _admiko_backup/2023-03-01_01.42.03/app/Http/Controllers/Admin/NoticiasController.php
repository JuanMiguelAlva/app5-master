<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Noticias;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\NoticiasRequest;
use Gate;

class NoticiasController extends Controller
{

    public function index()
    {
        if (Gate::none(['noticias_allow', 'noticias_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "noticias";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data["fileInfo"] = Noticias::$admiko_file_info;
        $tableData = Noticias::orderBy("id")->get();
        return view("admin.noticias.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['noticias_allow'])) {
            return redirect(route("admin.noticias.index"));
        }
        $admiko_data['sideBarActive'] = "noticias";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.noticias.store");
        $admiko_data["fileInfo"] = Noticias::$admiko_file_info;
        
        return view("admin.noticias.manage")->with(compact('admiko_data'));
    }

    public function store(NoticiasRequest $request)
    {
        if (Gate::none(['noticias_allow'])) {
            return redirect(route("admin.noticias.index"));
        }
        $data = $request->all();
        
        $Noticias = Noticias::create($data);
        
        return redirect(route("admin.noticias.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Noticias = Noticias::find($id);
        if (Gate::none(['noticias_allow', 'noticias_edit']) || !$Noticias) {
            return redirect(route("admin.noticias.index"));
        }

        $admiko_data['sideBarActive'] = "noticias";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.noticias.update", [$Noticias->id]);
        $admiko_data["fileInfo"] = Noticias::$admiko_file_info;
        
        $data = $Noticias;
        return view("admin.noticias.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(NoticiasRequest $request,$id)
    {
        if (Gate::none(['noticias_allow', 'noticias_edit'])) {
            return redirect(route("admin.noticias.index"));
        }
        $data = $request->all();
        $Noticias = Noticias::find($id);
        $Noticias->update($data);
        
        return redirect(route("admin.noticias.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['noticias_allow'])) {
            return redirect(route("admin.noticias.index"));
        }
        Noticias::destroy($request->idDel);
        return back();
    }
    
    
    
}
