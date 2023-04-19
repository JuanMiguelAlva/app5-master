<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin\Tickets;
use App\Http\Controllers\Controller;
use App\Models\Admin\Tickets\Respuesta;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Tickets\RespuestaRequest;
use Gate;
use App\Models\Admin\Tickets;

class RespuestaController extends Controller
{

    public function index()
    {
        if (Gate::none(['respuesta_allow', 'respuesta_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "tickets";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data["fileInfo"] = Respuesta::$admiko_file_info;
        $tableData = Respuesta::where("admiko_tickets_id",Request()->admiko_tickets_id)->orderBy("id")->get();
        return view("admin.tickets.respuesta.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['respuesta_allow'])) {
            return redirect(route("admin.respuesta.index",[Request()->admiko_tickets_id]));
        }

        
        $tickets = Tickets::findOrFail(Request()->admiko_tickets_id);

        $admiko_data['sideBarActive'] = "tickets";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.respuesta.store",[Request()->admiko_tickets_id]);
        $admiko_data["fileInfo"] = Respuesta::$admiko_file_info;
        
        return view("admin.tickets.respuesta.manage")->with(compact('admiko_data','tickets'));
    }

    public function store(RespuestaRequest $request)
    {
        if (Gate::none(['respuesta_allow'])) {
            return redirect(route("admin.respuesta.index",[Request()->admiko_tickets_id]));
        }
        $data = $request->all();
        
		$data["admiko_tickets_id"] = Request()->admiko_tickets_id;
        $Respuesta = Respuesta::create($data);

        $url = "https://script.google.com/macros/s/AKfycbxjiTkvt_B84ulbvYVcdVUxmMTJIfvPGaY3K9pShGI93i-WYsJ-tbWnUI9uVMB3YaP8aw/exec";
        
        $data1 = array(
            "recipient" => $data["destino"],
            "subject" => $data["asunto"],
            "body" => $request->mensaje,
            "isHTML" => 'true'
         );
         
         $ch = curl_init($url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
         $result = curl_exec($ch);
        
        return redirect(route("admin.respuesta.index",[Request()->admiko_tickets_id]));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($admiko_tickets_id,$id)
    {
        $Respuesta = Respuesta::find($id);
        if (Gate::none(['respuesta_allow', 'respuesta_edit']) || !$Respuesta) {
            return redirect(route("admin.respuesta.index",[$admiko_tickets_id]));
        }

        $admiko_data['sideBarActive'] = "tickets";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.respuesta.update", [$admiko_tickets_id,$Respuesta->id]);
        $admiko_data["fileInfo"] = Respuesta::$admiko_file_info;
        
        $data = $Respuesta;
        return view("admin.tickets.respuesta.manage")->with(compact('admiko_data', 'data'));
    }

    public function update(RespuestaRequest $request,$admiko_tickets_id,$id)
    {
        if (Gate::none(['respuesta_allow', 'respuesta_edit'])) {
            return redirect(route("admin.respuesta.index",[$admiko_tickets_id]));
        }
        $data = $request->all();
        $Respuesta = Respuesta::find($id);
        $Respuesta->update($data);
        
        return redirect(route("admin.respuesta.index",[$admiko_tickets_id]));
    }

    public function destroy(Request $request,$admiko_tickets_id)
    {
        if (Gate::none(['respuesta_allow'])) {
            return redirect(route("admin.respuesta.index",[$admiko_tickets_id]));
        }
        Respuesta::destroy($request->idDel);
        return back();
    }
    
    
    
}
