<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Ciclos;
use App\Models\Admin\Aulas;
use App\Models\Admin\Secciones;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class DistribucionDeAulas extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'distribucion_de_aulas';
    
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"ciclo",
		"aulas",
		"seccin",
    ];
    public function ciclo_id()
    {
        return $this->belongsTo(Ciclos::class, 'ciclo');
    }
	public function aulas_id()
    {
        return $this->belongsTo(Aulas::class, 'aulas');
    }
	public function seccin_id()
    {
        return $this->belongsTo(Secciones::class, 'seccin');
    }
}