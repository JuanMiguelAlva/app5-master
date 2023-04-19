<?php
/** Gate restrictions. Developer always has full access to all pages. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Middleware;
use App\Models\Admin\Admins\AdminRoles;
use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class AdmikoGates
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if ($user && $user->getTable() == 'admins') {
            if ($user->role_id == 1) {
                /**Developer always has full access to all pages**/
                Gate::after(function () {
                    return true;
                });
            }
            $permissionsAll = AdminRoles::with('permission_list')->find($user->role_id);
            foreach ($permissionsAll->permission_list as $permissions) {
                Gate::define($permissions->pivot->permission, function () {
                    return true;
                });
            }
        }
        return $next($request);
    }
}
