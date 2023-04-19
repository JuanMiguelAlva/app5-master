<?php
namespace App\Models\Admin\Admins\Auth;
use App\Models\Admin\Admins\Admins;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use Notifiable,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function multi_tenancy_access()
    {
        return $this->belongsToMany(Admins::class, 'admins_multi_tenancy_access', 'parent_id', 'selected_id');
    }
}
