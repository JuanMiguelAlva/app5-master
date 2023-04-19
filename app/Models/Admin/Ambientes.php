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

class Ambientes extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'ambientes';
    
    
	static $admiko_file_info = [
		"foto"=>[
			"original"=>["action"=>"resize","width"=>1920,"height"=>1080,"folder"=>"upload/"]
		]
	];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"nombre",
		"descripcion",
		"foto",
		"foto_admiko_delete",
    ];
    public function setFotoAttribute()
    {
        if (request()->hasFile('foto')) {
            $this->attributes['foto'] = $this->imageUpload(request()->file("foto"), Ambientes::$admiko_file_info["foto"], $this->getOriginal('foto'));
        }
    }
    public function setFotoAdmikoDeleteAttribute($value)
    {
        if (!request()->hasFile('foto') && $value == 1) {
            $this->attributes['foto'] = $this->imageUpload('', Ambientes::$admiko_file_info["foto"], $this->getOriginal('foto'), $value);
        }
    }
	public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->orWhere("nombre","like","%".$search."%")
			->orWhere("descripcion","like","%".$search."%")
			->orWhere("foto","like","%".$search."%");
        }
    }
}