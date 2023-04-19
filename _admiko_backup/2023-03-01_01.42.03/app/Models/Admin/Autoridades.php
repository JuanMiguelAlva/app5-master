<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Cargo;
use App\Models\Admin\Grados;
use App\Models\Admin\Unidad;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Autoridades extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'autoridades';
    
    
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
		"nombres",
		"apellidos",
		"cargo",
		"grado",
		"unidad",
		"foto",
		"foto_admiko_delete",
    ];
    public function cargo_id()
    {
        return $this->belongsTo(Cargo::class, 'cargo');
    }
	public function grado_id()
    {
        return $this->belongsTo(Grados::class, 'grado');
    }
	public function unidad_id()
    {
        return $this->belongsTo(Unidad::class, 'unidad');
    }
	public function setFotoAttribute()
    {
        if (request()->hasFile('foto')) {
            $this->attributes['foto'] = $this->imageUpload(request()->file("foto"), Autoridades::$admiko_file_info["foto"], $this->getOriginal('foto'));
        }
    }
    public function setFotoAdmikoDeleteAttribute($value)
    {
        if (!request()->hasFile('foto') && $value == 1) {
            $this->attributes['foto'] = $this->imageUpload('', Autoridades::$admiko_file_info["foto"], $this->getOriginal('foto'), $value);
        }
    }
}