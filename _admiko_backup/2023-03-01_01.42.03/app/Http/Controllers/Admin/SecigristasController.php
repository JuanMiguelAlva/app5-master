<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Secigristas;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SecigristasRequest;
use Gate;

class SecigristasController extends Controller
{

    public function index()
    {
        if (Gate::none(['secigristas_allow', 'secigristas_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "secigristas";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        
        $tableData = Secigristas::orderBy("id")->get();
        return view("admin.secigristas.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['secigristas_allow'])) {
            return redirect(route("admin.secigristas.index"));
        }
        $admiko_data['sideBarActive'] = "secigristas";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.secigristas.store");
        
        
        return view("admin.secigristas.manage")->with(compact('admiko_data'));
    }

    public function store(SecigristasRequest $request)
    {
        if (Gate::none(['secigristas_allow'])) {
            return redirect(route("admin.secigristas.index"));
        }
        $data = $request->all();
        
        $Secigristas = Secigristas::create($data);
        
        return redirect(route("admin.secigristas.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Secigristas = Secigristas::find($id);
        if (Gate::none(['secigristas_allow', 'secigristas_edit']) || !$Secigristas) {
            return redirect(route("admin.secigristas.index"));
        }

        $admiko_data['sideBarActive'] = "secigristas";
		$admiko_data["sideBarActiveFolder"] = "_sitio_web";
        $admiko_data['formAction'] = route("admin.secigristas.update", [$Secigristas->id]);
        
        
        $data = $Secigristas;
        return view("admin.secigristas.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(SecigristasRequest $request,$id)
    {
        if (Gate::none(['secigristas_allow', 'secigristas_edit'])) {
            return redirect(route("admin.secigristas.index"));
        }
        $data = $request->all();
        $Secigristas = Secigristas::find($id);
        $Secigristas->update($data);
        
        return redirect(route("admin.secigristas.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['secigristas_allow'])) {
            return redirect(route("admin.secigristas.index"));
        }
        Secigristas::destroy($request->idDel);
        return back();
    }
    
    
    
}
