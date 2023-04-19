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

class Tickets extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'tickets';
    static $admikoCascadeDelete = ["admiko_tickets_id"=>['Respuesta']];
    
	const ESTADO_CONS = ["0"=>"Nuevo","1"=>"En progreso","2"=>"Terminado"];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"estado",
		"asunto",
		"solicitante",
		"correo",
		"mensaje",
    ];
    
}