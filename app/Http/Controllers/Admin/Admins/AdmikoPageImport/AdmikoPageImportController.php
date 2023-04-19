<?php
/** Helper for API page import. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */

namespace App\Http\Controllers\Admin\Admins\AdmikoPageImport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Admin\AdmikoHelperTrait;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdmikoPageImportController extends Controller
{
    use AdmikoHelperTrait;

    public function index()
    {
        if (auth()->user()->role_id != 1) {
            return redirect(route("admin.home"));
        }
        $dataApi = $this->makeRequest(['list' => 1]);
        $errors = '';
        $admikoUpdateInfo = '';
        $tableData = '';
        if (isset($dataApi->error) && $dataApi->error != '') {
            $errors = $dataApi->error;
        } else {
            if (Session::has('error')) {
                $errors = Session::get('error');
            }
            $tableData = $dataApi->pagesList;
            if ($dataApi->admikoUpdateInfo) {
                $admikoUpdateInfo = base64_decode($dataApi->admikoUpdateInfo);
            }
        }
        $admiko_data['sideBarActive'] = "admikoImport";
        $admiko_data['sideBarActiveFolder'] = "";
        return view("admin.admins.admiko_page_import.index")->with(compact('admiko_data', "tableData", "admikoUpdateInfo", "errors"));
    }

    public function import(Request $request)
    {
        if (auth()->user()->role_id != 1) {
            return redirect(route("admin.home"));
        }
        if (isset($request->backup_folder) && !empty($request->backup_folder)) {
            $backup_folder = $request->backup_folder;
        } else {
            $backup_folder = Carbon::now()->format("Y-m-d_H.i.s");
        }
        if ($request->admikoUpdate == 1) {
            $dataApi = $this->makeRequest(['admikoUpdate' => 1]);
            if (isset($dataApi->error) && $dataApi->error != '') {
                return redirect(route("admin.admiko_page_import"))->with('error', $dataApi->error);
            }
            if (count($dataApi->files) > 0) {
                foreach ($dataApi->files as $files) {
                    $file = base64_decode($files->file);
                    $code = base64_decode($files->code);
                    $this->backupAndSave($file, $code, $backup_folder.'_update');
                }
            }
            if (count($dataApi->database) > 0) {
                $this->setupDatabase($dataApi->database);
            }
        } elseif ($request->importGlobal == 1) {
            $dataApi = $this->makeRequest(['importGlobal' => 1]);
            if (isset($dataApi->error) && $dataApi->error != '') {
//                return redirect(route("dashboard.admiko_page_import"))->with('error', $dataApi->error);
                return response()->json(['status' => 'error', 'backup_folder' => $backup_folder]);
            }
            if (count($dataApi->files) > 0) {
                foreach ($dataApi->files as $files) {
                    $file = base64_decode($files->file);
                    $code = base64_decode($files->code);
                    $this->backupAndSave($file, $code, $backup_folder);
                }
            }
            if (count($dataApi->database) > 0) {
                $this->setupDatabase($dataApi->database);
            }
            return response()->json(['status' => 'done', 'backup_folder' => $backup_folder]);
        } else {
            foreach ($request->page_id as $id) {
                $dataApi = $this->makeRequest(['page' => $id]);
                if (isset($dataApi->error) && $dataApi->error != '') {
//                    return redirect(route("dashboard.admiko_page_import"))->with('error', $dataApi->error);
                    return response()->json(['status' => 'error', 'backup_folder' => $backup_folder]);
                }
                if (count($dataApi->files) > 0) {
                    foreach ($dataApi->files as $files) {
                        $file = base64_decode($files->file);
                        $code = base64_decode($files->code);
                        $this->backupAndSave($file, $code, $backup_folder);
                    }
                }
                if (count($dataApi->database) > 0) {
                    $this->setupDatabase($dataApi->database);
                }
            }
            return response()->json(['status' => 'done', 'backup_folder' => $backup_folder]);
        }

        return back();
    }

    public function makeRequest($keys)
    {
        $defaultKeys = [
            'key' => config("admiko_version.project_key"),
            'ver' => config("admiko_version.version")
        ];
        $sendKeys = array_merge($defaultKeys, $keys);
        $dataApiCall = Http::withOptions(["verify" => false])->acceptJson()->get('https://admiko.com/account/project/api/1.1', $sendKeys);

        if ($dataApiCall->successful()) {
            /*check if response is valid JSON format*/
            json_decode($dataApiCall->body());
            if (json_last_error() != JSON_ERROR_NONE) {
                /*There was an error in response*/
                return (object)['error'=>'Invalid response from the server, please try again or contact Admiko support.'];
            } else {
                /*huh, everything is fine ;)*/
                return $dataApiCall->object();
            }
        } else {
            return (object)['error'=>'Network or server error, please try later or contact Admiko support.'];
        }
    }

    public function backupAndSave($file, $code, $backup_folder)
    {
        if (config('filesystems.disks.admiko_api_import')) {
            if (Storage::disk('admiko_api_import')->exists($file)) {
                if (Storage::disk('admiko_api_import')->exists(config("admiko_config.backup_location") . '/' . $backup_folder . '/' . $file)) {
                    //Storage::disk('admiko_api_import')->delete(config("admiko_config.backup_location").'/' . $backup_folder .'/'.$file);
                    /**We don't want to lose any file**/
                    $file_new_name = $this->createUniqueName($file, $backup_folder, 1);
                    Storage::disk('admiko_api_import')->move($file, config("admiko_config.backup_location") . '/' . $backup_folder . '/' . $file_new_name);
                } else {
                    Storage::disk('admiko_api_import')->move($file, config("admiko_config.backup_location") . '/' . $backup_folder . '/' . $file);
                }
            }
            Storage::disk('admiko_api_import')->put($file, $code);
        } else {
            return redirect(route("admin.admiko_page_import"))->with('error', trans('admiko.admiko_api_import_missing'));
        }
    }

    public function createUniqueName($file, $backup_folder, $counter)
    {
        if (Storage::disk('admiko_api_import')->exists(config("admiko_config.backup_location") . '/' . $backup_folder . '/' . $file . $counter)) {
            $counter = $counter + 1;
            return $this->createUniqueName($file, $backup_folder, $counter);
        }
        return $file . $counter;
    }
}

