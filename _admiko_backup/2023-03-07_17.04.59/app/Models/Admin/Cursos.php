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
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Cursos extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'cursos';
    static $admikoCascadeDelete = ["admiko_cursos_id"=>['Horario']];
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"codigo",
		"ciclo",
		"nombre",
		"linea",
		"horas_t",
		"horas_p",
		"creditos",
    ];
    public function ciclo_id()
    {
        return $this->belongsTo(Ciclos::class, 'ciclo');
    }
}