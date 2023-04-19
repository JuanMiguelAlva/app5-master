<?php
/** Helper for creating table and table columns. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */

namespace App\Http\Controllers\Traits\Admin;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;

trait AdmikoHelperTrait
{
    public function setupDatabase($tableData,$decode=true)
    {
        foreach ($tableData as $dataCoded) {
            if ($decode == true) {
                $data = json_decode(base64_decode($dataCoded), true);
            } else {
                $data = $dataCoded;
            }

            $afterField = 'id';
            if (!Schema::hasTable($data['table'])) {
                Schema::create($data['table'], function (Blueprint $table) use ($data) {
                    $table->id();
                    if ($data['timeStamp'] == 1) {
                        $table->timestamps();
                        $table->softDeletes();
                    }
                });
            }
            if (isset($data['tableFields']) && count($data['tableFields']) > 0) {
                foreach ($data['tableFields'] as $columnName => $val) {
                    if (!Schema::hasColumn($data['table'], $columnName)) {
                        Schema::table($data['table'], function (Blueprint $table) use ($columnName, $val, $afterField) {
                            switch ($val) {
                                case 'integer';
                                    $table->integer($columnName)->nullable()->after($afterField);
                                    break;
                                case 'bigIntegerUnsigned';
                                    $table->bigInteger($columnName)->unsigned()->after($afterField);
                                    break;
                                case 'bigInteger';
                                    $table->bigInteger($columnName)->after($afterField);
                                    break;
                                case 'bigIntegerNullable';
                                    $table->bigInteger($columnName)->unsigned()->nullable()->after($afterField);
                                    break;
                                case 'integerDefault';
                                    $table->integer($columnName)->default(10000)->nullable()->after($afterField);
                                    break;
                                case 'decimal';
                                    $table->decimal($columnName, 20, 6)->nullable()->after($afterField);
                                    break;
                                case 'float';
                                    $table->decimal($columnName, 20, 10)->nullable()->after($afterField);
                                    break;
                                case 'text';
                                    $table->text($columnName)->nullable()->after($afterField);
                                    break;
                                case 'string';
                                    $table->string($columnName)->nullable()->after($afterField);
                                    break;
                                case 'string100';
                                    $table->string($columnName)->nullable()->after($afterField);
                                    break;
                                case 'string300';
                                    $table->string($columnName, 300)->nullable()->after($afterField);
                                    break;
                                case 'stringUnique';
                                    $table->string($columnName)->unique()->after($afterField);
                                    break;
                                case 'dateTime';//
                                    $table->dateTime($columnName)->nullable()->after($afterField);
                                    break;
                                case 'time';
                                    $table->time($columnName)->nullable()->after($afterField);
                                    break;
                                case 'binary';
                                    $table->binary($columnName);
                                    break;
                                case 'foreignId';
                                    $table->foreignId($columnName)->after($afterField);
                                    break;
                            }
                        });
                    }
                    $afterField = $columnName;
                }
            }

            if (isset($data['tableForeignKeys']) && count($data['tableForeignKeys']) > 0) {
                foreach ($data['tableForeignKeys'] as $columnName => $val) {
                    if (!in_array($val['key_name'], $this->listTableForeignKeys($data['table'], $columnName))) {
                        Schema::table($data['table'], function (Blueprint $table) use ($columnName, $val) {
                            $table->foreign($columnName,$val['key_name'])->references('id')->on($val['parentTable'])->onDelete('cascade');
                        });
                    }
                }
            }
        }
    }

    public function listTableForeignKeys($table, $foreignKey)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();
        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

    public function listRouteNames()
    {
        $routeName = array();
        $allRoutes = Route::getRoutes();
        $skip_pages = array('admins', 'admin_roles', 'admiko_auditable_logs');
        foreach ($allRoutes as $route) {
            if (strpos($route->getName(), 'admin.') !== false && strpos($route->getName(), '.index') !== false) {
                $name = str_replace('admin.', '', $route->getName());
                $name = str_replace('.index', '', $name);
                if (!in_array($name, $skip_pages)) {
                    $routeName[] = $name;
                }
            }
        }
        return $routeName;
    }
}
