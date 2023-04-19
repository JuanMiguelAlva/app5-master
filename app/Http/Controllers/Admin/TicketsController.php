<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Tickets;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\TicketsRequest;
use Gate;

class TicketsController extends Controller
{

    public function index()
    {
        if (Gate::none(['tickets_allow', 'tickets_edit'])) {
            return redirect(route("admin.home"));
        }
        $admiko_data['sideBarActive'] = "tickets";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        
        $tableData = Tickets::orderBy("id")->get();
        return view("admin.tickets.index")->with(compact('admiko_data', "tableData"));
    }

    public function create()
    {
        if (Gate::none(['tickets_allow'])) {
            return redirect(route("admin.tickets.index"));
        }
        $admiko_data['sideBarActive'] = "tickets";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.tickets.store");
        
        
		$estado_all = Tickets::ESTADO_CONS;
        return view("admin.tickets.manage")->with(compact('admiko_data','estado_all'));
    }

    public function store(TicketsRequest $request)
    {
        if (Gate::none(['tickets_allow'])) {
            return redirect(route("admin.tickets.index"));
        }
        $data = $request->all();
        
        $Tickets = Tickets::create($data);
        
        return redirect(route("admin.tickets.index"));
    }

    public function show($id)
    {
        return back();
    }

    public function edit($id)
    {
        $Tickets = Tickets::find($id);
        if (Gate::none(['tickets_allow', 'tickets_edit']) || !$Tickets) {
            return redirect(route("admin.tickets.index"));
        }

        $admiko_data['sideBarActive'] = "tickets";
		$admiko_data["sideBarActiveFolder"] = "_principal1";
        $admiko_data['formAction'] = route("admin.tickets.update", [$Tickets->id]);
        
        
		$estado_all = Tickets::ESTADO_CONS;
        $data = $Tickets;
        return view("admin.tickets.manage")->with(compact('admiko_data', 'data','estado_all'));
    }

    public function update(TicketsRequest $request,$id)
    {
        if (Gate::none(['tickets_allow', 'tickets_edit'])) {
            return redirect(route("admin.tickets.index"));
        }
        $data = $request->all();
        $Tickets = Tickets::find($id);
        $Tickets->update($data);
        
        return redirect(route("admin.tickets.index"));
    }

    public function destroy(Request $request)
    {
        if (Gate::none(['tickets_allow'])) {
            return redirect(route("admin.tickets.index"));
        }
        Tickets::destroy($request->idDel);
        return back();
    }
    
    
    
}
