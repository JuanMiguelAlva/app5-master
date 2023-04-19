<?php
/** User roles Model. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin\Admins;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AdminRoles extends Model
{
    use SoftDeletes;
    public $table = 'admins_roles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        "title",
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function permission_many()
    {
        return $this->belongsToMany(AdminRoles::class, 'admins_roles_permission', 'role_id', 'permission');
    }

    public function permission_many_select()
    {
        return DB::table('admins_roles_permission')->where('role_id', $this->id)->pluck('permission');
    }

    public function permission_list()
    {
        return $this->belongsToMany(AdminRoles::class, 'admins_roles_permission', 'role_id', 'role_id')->withPivot('permission');
    }
}

