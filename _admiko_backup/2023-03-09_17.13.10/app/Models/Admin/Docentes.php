<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\TipoProfesor;
use App\Models\Admin\Condicion;
use App\Models\Admin\Especialidades;
use App\Models\Admin\Grados;
use Illuminate\Support\Str;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Docentes extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'docentes';
    static $admikoCascadeDelete = ["admiko_docentes_id"=>['Publicaciones']];
    
	static $admiko_file_info = [
		"foto"=>[
			"original"=>["action"=>"resize","width"=>500,"height"=>500,"folder"=>"upload/"],
			"thumbnail"=>[
				["action"=>"resize","width"=>200,"height"=>200,"folder"=>"upload/","prefix"=>"thb_"]
			]
		],
		"cv"=>[
			"original"=>["folder"=>"upload/"]
		]
	];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"codigo",
		"nombres",
		"apellidos",
		"categoria",
		"condicion",
		"especialidad",
		"grado",
		"correo",
		"celular",
		"activo",
		"horas",
		"descripcion",
		"foto",
		"foto_admiko_delete",
		"cv",
		"cv_admiko_delete",
    ];
    public function categoria_id()
    {
        return $this->belongsTo(TipoProfesor::class, 'categoria');
    }
	public function condicion_id()
    {
        return $this->belongsTo(Condicion::class, 'condicion');
    }
	public function especialidad_id()
    {
        return $this->belongsTo(Especialidades::class, 'especialidad');
    }
	public function grado_id()
    {
        return $this->belongsTo(Grados::class, 'grado');
    }
	public function setFotoAttribute()
    {
        if (request()->hasFile('foto')) {
            $this->attributes['foto'] = $this->imageUpload(request()->file("foto"), Docentes::$admiko_file_info["foto"], $this->getOriginal('foto'));
        }
    }
    public function setFotoAdmikoDeleteAttribute($value)
    {
        if (!request()->hasFile('foto') && $value == 1) {
            $this->attributes['foto'] = $this->imageUpload('', Docentes::$admiko_file_info["foto"], $this->getOriginal('foto'), $value);
        }
    }
	public function setCvAttribute()
    {
        if (request()->hasFile('cv')) {
            $this->attributes['cv'] = $this->fileUpload(request()->file("cv"), Docentes::$admiko_file_info["cv"], $this->getOriginal('cv'));
        }
    }
    public function setCvAdmikoDeleteAttribute($value)
    {
        if (!request()->hasFile('cv') && request()->cv_admiko_delete == 1) {
            $this->attributes['cv'] = $this->fileUpload('', Docentes::$admiko_file_info["cv"], $this->getOriginal('cv'), $value);
        }
    }
	public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->orWhere("codigo","like","%".$search."%")
			->orWhere("nombres","like","%".$search."%")
			->orWhere("apellidos","like","%".$search."%")
			->orWhereHas("categoria_id", function($q) use($search) { $q->where("tipo", "like", "%".$search."%"); })
			->orWhereHas("condicion_id", function($q) use($search) { $q->where("nombre", "like", "%".$search."%"); })
			->orWhereHas("especialidad_id", function($q) use($search) { $q->where("nombre", "like", "%".$search."%"); })
			->orWhereHas("grado_id", function($q) use($search) { $q->where("abreviatura", "like", "%".$search."%"); })
			->orWhere("correo","like","%".$search."%")
			->orWhere("celular","like","%".$search."%")
			->orWhere("activo","like","%".$search."%")
			->orWhere("horas","like","%".$search."%")
			->orWhere("descripcion","like","%".$search."%");
        }
    }
}