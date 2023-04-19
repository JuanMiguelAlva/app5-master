<?php
/** Admiko static file for routes. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::get('login', [Auth\LoginController::class, 'index'])->name('login');
Route::post('login', [Auth\LoginController::class, 'login']);
/**Forgot Password Routes**/
Route::get('password/request', [Auth\ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('password/email', [Auth\ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
/**Reset Password Routes**/
Route::get('password/reset/{reset_token}', [Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset/{reset_token}', [Auth\ForgotPasswordController::class, 'updatePassword'])->name('password.update');

Route::middleware('auth:admin')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('cuenta', [Admins\MyAccountController::class, 'index'])->name('myaccount');
    Route::put('cuenta/update', [Admins\MyAccountController::class, 'update'])->name('myaccount.update');
    Route::put('cuenta/updatepassword', [Admins\MyAccountController::class, 'updatepassword'])->name('myaccount.updatepassword');

    /**Logout Routs**/
    Route::get('logout', [Auth\LoginController::class, 'logout'])->name('logout');
    /**Admins**/
    Route::delete("admins/destroy", [Admins\AdminsController::class, 'destroy'])->name("admins.delete");
    Route::resource("admins", Admins\AdminsController::class)->parameters(['admins' => 'admins']);
    Route::delete("admin_roles/destroy", [Admins\AdminRolesController::class, 'destroy'])->name("admin_roles.delete");
    Route::resource("admin_roles", Admins\AdminRolesController::class)->parameters(['admin_roles' => 'admin_roles']);
    Route::get('admiko_page_import', [Admins\AdmikoPageImport\AdmikoPageImportController::class, 'index'])->name('admiko_page_import');
    Route::post('admiko_page_import/import', [Admins\AdmikoPageImport\AdmikoPageImportController::class, 'import'])->name('admiko_page_import.import');
    /**Admiko Auditable Logs**/
    Route::resource("admiko_auditable_logs", Admins\AdmikoAuditableLogsController::class)->parameters(["admiko_auditable_logs" => "admiko_auditable_logs"]);
    /**Admiko global search**/
    Route::get("admiko_global_search", [Admins\AdminGlobalSearchController::class,'global_search'])->name('admiko_global_search');
    /**All generated Admiko routes will be defined here...**/
    require_once __DIR__.'/admiko_admin_routes.php';
    /**Add your CMS routes bellow**/
    require_once __DIR__.'/admiko_your_custom_routes.php';
});