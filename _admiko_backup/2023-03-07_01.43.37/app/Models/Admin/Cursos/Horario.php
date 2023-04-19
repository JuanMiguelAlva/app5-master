<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin\Cursos;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Docentes;
use App\Models\Admin\Dias;
use App\Models\Admin\Aulas;
use Carbon\Carbon;
use App\Models\Admin\Secciones;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Horario extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'cursos_horario';
    
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"docente",
		"dia",
		"aula",
		"hora_inicio",
		"hora_fin",
		"seccin",
		"admiko_cursos_id",
    ];
    public function docente_id()
    {
        return $this->belongsTo(Docentes::class, 'docente');
    }
	public function dia_id()
    {
        return $this->belongsTo(Dias::class, 'dia');
    }
	public function aula_id()
    {
        return $this->belongsTo(Aulas::class, 'aula');
    }
	public function getHoraInicioAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('admiko_config.table_time_format')) : null;
    }
    public function setHoraInicioAttribute($value)
    {
        $this->attributes['hora_inicio'] = $value ? Carbon::createFromFormat(config('admiko_config.table_time_format'), $value)->format('H:i:s') : null;
    }
	public function getHoraFinAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('admiko_config.table_time_format')) : null;
    }
    public function setHoraFinAttribute($value)
    {
        $this->attributes['hora_fin'] = $value ? Carbon::createFromFormat(config('admiko_config.table_time_format'), $value)->format('H:i:s') : null;
    }
	public function seccin_id()
    {
        return $this->belongsTo(Secciones::class, 'seccin');
    }
	public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->orWhereHas("docente_id", function($q) use($search) { $q->where("apellidos", "like", "%".$search."%"); })
			->orWhereHas("dia_id", function($q) use($search) { $q->where("dia_de_semana", "like", "%".$search."%"); })
			->orWhereHas("aula_id", function($q) use($search) { $q->where("codigo", "like", "%".$search."%"); })
			->orWhere("hora_inicio","like","%".$search."%")
			->orWhere("hora_fin","like","%".$search."%")
			->orWhereHas("seccin_id", function($q) use($search) { $q->where("nombre", "like", "%".$search."%"); });
        }
    }
}