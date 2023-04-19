<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Docentes;
use App\Models\Admin\Cargo;
use App\Models\Admin\Unidad;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Autoridades extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'autoridades';
    
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"docente",
		"cargo",
		"unidad",
    ];
    public function docente_id()
    {
        return $this->belongsTo(Docentes::class, 'docente');
    }
	public function cargo_id()
    {
        return $this->belongsTo(Cargo::class, 'cargo');
    }
	public function unidad_id()
    {
        return $this->belongsTo(Unidad::class, 'unidad');
    }
}