<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin\Docentes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\TipoPublicacion;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Publicaciones extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'docentes_publicaciones';
    static $admikoGlobalSearchParent = ["parent_model"=>"Docentes", "child_parent_id"=>"admiko_docentes_id"];
	
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"nombre",
		"tipo",
		"enlace",
		"admiko_docentes_id",
		"admiko_dynamic_fields",
    ];
    public function tipo_id()
    {
        return $this->belongsTo(TipoPublicacion::class, 'tipo');
    }
	public function getAdmikoDynamicFieldsAttribute($value)
    {
        return collect(json_decode($value));
    }
    public function setAdmikoDynamicFieldsAttribute($value)
    {
        $this->attributes['admiko_dynamic_fields'] = json_encode($value);
    }
}