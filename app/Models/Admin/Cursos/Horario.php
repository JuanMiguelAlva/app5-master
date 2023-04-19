<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin\Cursos;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Secciones;
use App\Models\Admin\Docentes;
use App\Models\Admin\Cursos;
use App\Models\Admin\Dias;
use Carbon\Carbon;
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
		"seccin",
		"docente",
		"dia",
		"hora_inicio",
		"hora_fin",
		"admiko_cursos_id",
    ];
    public function seccin_id()
    {
        return $this->belongsTo(Secciones::class, 'seccin');
    }
	public function docente_id()
    {
        return $this->belongsTo(Docentes::class, 'docente');
    }

    public function curso_id()
    {
        return $this->belongsTo(Cursos::class, 'admiko_cursos_id');
    }

	public function dia_id()
    {
        return $this->belongsTo(Dias::class, 'dia');
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
	public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->orWhereHas("seccin_id", function($q) use($search) { $q->where("nombre", "like", "%".$search."%"); })
			->orWhereHas("docente_id", function($q) use($search) { $q->where("apellidos", "like", "%".$search."%"); })
			->orWhereHas("dia_id", function($q) use($search) { $q->where("dia_de_semana", "like", "%".$search."%"); })
			->orWhere("hora_inicio","like","%".$search."%")
			->orWhere("hora_fin","like","%".$search."%");
        }
    }

    public function scopeCalendarByRoleOrClassId($query)
    {
        return $query->when(!request()->input('class_id'), function ($query) {
            $query->when(auth()->user()->is_teacher, function ($query) {
                $query->where('teacher_id', auth()->user()->id);
            })
                ->when(auth()->user()->is_student, function ($query) {
                    $query->where('class_id', auth()->user()->class_id ?? '0');
                });
        })
            ->when(request()->input('class_id'), function ($query) {
                $query->where('class_id', request()->input('class_id'));
            });
    }

    public static function isTimeAvailable($weekday, $startTime, $endTime, $class, $teacher, $lesson)
    {
        $lessons = self::where('dia', $weekday)
            ->when($lesson, function ($query) use ($lesson) {
                $query->where('id', '!=', $lesson);
            })
            ->where(function ($query) use ($class, $teacher) {
                $query->where('admiko_cursos_id', $class)
                    ->orWhere('docente', $teacher);
            })
            ->where([
                ['hora_inicio', '<', $endTime],
                ['hora_fin', '>', $startTime],
            ])
            ->count();

        return !$lessons;
    }

    const WEEK_DAYS = [
        '1' => 'Lunes',
        '2' => 'Martes',
        '3' => 'Miercoles',
        '4' => 'Jueves',
        '5' => 'Viernes'
        // '6' => 'Saturday',
        // '7' => 'Sunday',
    ];

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->hora_fin)->diffInMinutes($this->hora_inicio);
    }
}