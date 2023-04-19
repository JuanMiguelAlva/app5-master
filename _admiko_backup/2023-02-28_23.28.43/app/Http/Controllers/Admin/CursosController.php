<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Cursos;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CursosRequest;
use Gate;
use App\Models\Admin\Ciclos;

class CursosController extends Controller
{

    public function index()
    {
        if (Gate::none(['cursos_allow', 'cursos_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "cursos";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        
        $tableData = Cursos::orderBy("id")->get();
        return view("admin.cursos.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['cursos_allow'])) {
            return redirect(route("admin.cursos.index"));
        }
        $admiko_data['sideBarActive'] = "cursos";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.cursos.store");
        
        
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
        return view("admin.cursos.manage")->with(compact('admiko_data','ciclos_all'));
    }

    public function store(CursosRequest $request)
    {
        if (Gate::none(['cursos_allow'])) {
            return redirect(route("admin.cursos.index"));
        }
        $data = $request->all();
        
        $Cursos = Cursos::create($data);
        
        return redirect(route("admin.cursos.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Cursos = Cursos::find($id);
        if (Gate::none(['cursos_allow', 'cursos_edit']) || !$Cursos) {
            return redirect(route("admin.cursos.index"));
        }

        $admiko_data['sideBarActive'] = "cursos";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.cursos.update", [$Cursos->id]);
        
        
		$ciclos_all = Ciclos::all()->sortBy("nombre")->pluck("nombre", "id");
        $data = $Cursos;
        return view("admin.cursos.manage")->with(compact('admiko_data', 'data','ciclos_all'));
    }

    public function update(CursosRequest $request,$id)
    {
        if (Gate::none(['cursos_allow', 'cursos_edit'])) {
            return redirect(route("admin.cursos.index"));
        }
        $data = $request->all();
        $Cursos = Cursos::find($id);
        $Cursos->update($data);
        
        return redirect(route("admin.cursos.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['cursos_allow'])) {
            return redirect(route("admin.cursos.index"));
        }
        Cursos::destroy($request->idDel);
        return back();
    }
    
    
    
}
