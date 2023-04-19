<?php
/** Admins users Model. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin\Admins;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admins extends Model
{
    use SoftDeletes;
    public $table = 'admins';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        "name",
        "email",
        "image",
        "theme",
        "password",
        "role_id",
        "delete",
        "radio_group",
        "reset_token",
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function setPasswordAttribute($value)
    {
        if ($value != '') {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function setImageAttribute($value)
    {
        if ($value == '') {
            $avatar = file_get_contents(base_path('public/assets/admiko/images/').'avatar.jpg');
            $base64 = base64_encode($avatar);
            $this->attributes['image'] = 'data:image/jpeg;base64,'.$base64;
        } else {
            $this->attributes['image'] = $value;
        }
    }

    public function adminsRole()
    {
        return $this->belongsTo(AdminRoles::class, 'role_id', 'id');
    }

    public function multi_tenancy_access()
    {
        return $this->belongsToMany(Admins::class, 'admins_multi_tenancy_access', 'parent_id', 'selected_id');
    }
}

