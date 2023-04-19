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

class Secciones extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'secciones';
    
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"nombre",
		"ciclo",
    ];
    public function ciclo_id()
    {
        return $this->belongsTo(Ciclos::class, 'ciclo');
    }
	public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->orWhere("nombre","like","%".$search."%")
			->orWhereHas("ciclo_id", function($q) use($search) { $q->where("nombre", "like", "%".$search."%"); });
        }
    }
}