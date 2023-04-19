<?php
/** Update logged user. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin\Admins;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admins\Admins;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;

class MyAccountController extends Controller
{
    public function index()
    {
        $admiko_data['sideBarActive'] = "myaccount";
        $admiko_data['sideBarActiveFolder'] = "";
        $data = auth()->user();
        $themes = Storage::disk('admiko_api_import')->directories('public/assets/admiko/css/theme');
        $themes = array_map('basename', $themes);

        return view("admin.admins.myaccount")->with(compact('admiko_data', 'data', 'themes'));
    }

    public function update(Request $request, Admins $Admins)
    {
        $rules = [
            'email' => [
                "email",
                "unique:admins,email," . auth()->user()->id . ",id,deleted_at,NULL",
                'required'
            ],
        ];
        $message = [];
        $attributes = [
            "email" => trans('admiko.admins_email'),
        ];
        $request->validate($rules, $message, $attributes);
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['image'] = $request->image;
        $data['theme'] = $request->theme;
        $Admins->find(auth()->user()->id)->update($data);
        return redirect(route("admin.myaccount"));
    }

    public function updatePassword(Request $request, Admins $Admins)
    {
        $rules = [
            'password' => 'required|string|min:4|max:255'
        ];
        $message = [];
        $attributes = [
            "password" => trans('admiko.admins_pass'),
        ];
        $request->validate($rules, $message, $attributes);
        $data['password'] = $request->password;
        $Admins->find(auth()->user()->id)->update($data);
        return redirect(route("admin.myaccount"));
    }
}
