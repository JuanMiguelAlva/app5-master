<?php
/** Helper to reset password. **/
/**
 * @author     Admiko.com
 * @copyright  2020-2120
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admins\Admins;
use Str;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('admin.auth.passwords.email');
    }

    public function sendResetLink(Request $request, Admins $Admins)
    {
        $this->validatorEmail($request);
        $email = $Admins->where('email', $request->email)->first();
        if ($email) {
            $reset_token = Str::random(80);
            $data['reset_token'] = $reset_token;
            $Admins->find($email->id)->update($data);
            $data['email'] = $email->email;
            \Mail::to($email->email)->send(new \App\Http\Controllers\Admin\Auth\EmailResetLink($data));
            return redirect()->back()->with('message_sent', trans('admiko.reset_email_send_success'));
        } else {
            return redirect()->back()->withInput()->with('error', trans('admiko.reset_email_send_fail'));
        }
    }

    public function showResetForm(Request $request, Admins $Admins)
    {
        $token = $this->checkToken($request, $Admins);
        if ($token) {
            $reset_token = $request->reset_token;
            return view('admin.auth.passwords.reset')->with(compact('reset_token'));
        }
        return redirect(route('admin.login'));
    }

    public function updatePassword(Request $request, Admins $Admins)
    {
        $this->validatorPassword($request);
        $token = $this->checkToken($request, $Admins);
        if ($token) {
            $data['password'] = $request->password;
            $data['reset_token'] = null;
            $Admins->find($token->id)->update($data);
        }
        return redirect(route('admin.login'));
    }

    private function validatorEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email'
        ];
        $request->validate($rules);
    }

    private function validatorPassword(Request $request)
    {
        $rules = [
            'password'              => 'required_with:password_confirmation|same:password_confirmation|string|min:6|max:100',
            'password_confirmation' => 'min:6'
        ];
        $request->validate($rules);
    }

    private function checkToken(Request $request, Admins $Admins)
    {
        if (isset($request->reset_token) && !empty($request->reset_token)) {
            return $Admins->where('reset_token', $request->reset_token)->first();
        }
        return null;
    }
}
