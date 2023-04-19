<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Secigristas extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'secigristas';
    
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"nombres",
		"apellidos",
		"unidad_receptora",
    ];
    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->orWhere("nombres","like","%".$search."%")
			->orWhere("apellidos","like","%".$search."%")
			->orWhere("unidad_receptora","like","%".$search."%");
        }
    }
}