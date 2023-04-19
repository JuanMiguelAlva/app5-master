<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Noticias extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'noticias';
    
    
	static $admiko_file_info = [
		"imagen"=>[
			"original"=>["action"=>"resize","width"=>1920,"height"=>1080,"folder"=>"upload/"]
		]
	];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"titulo",
		"fecha",
		"descripcion",
		"imagen",
		"imagen_admiko_delete",
    ];
    public function getFechaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('admiko_config.table_date_format')) : null;
    }
    public function setFechaAttribute($value)
    {
        $this->attributes['fecha'] = $value ? Carbon::createFromFormat(config('admiko_config.table_date_format'), $value)->format('Y-m-d H:i:s') : null;
    }
	public function setImagenAttribute()
    {
        if (request()->hasFile('imagen')) {
            $this->attributes['imagen'] = $this->imageUpload(request()->file("imagen"), Noticias::$admiko_file_info["imagen"], $this->getOriginal('imagen'));
        }
    }
    public function setImagenAdmikoDeleteAttribute($value)
    {
        if (!request()->hasFile('imagen') && $value == 1) {
            $this->attributes['imagen'] = $this->imageUpload('', Noticias::$admiko_file_info["imagen"], $this->getOriginal('imagen'), $value);
        }
    }
}