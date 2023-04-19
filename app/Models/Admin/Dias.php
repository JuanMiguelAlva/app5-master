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

class Dias extends Model
{
    use AdmikoFileUploadTrait;

    public $table = 'dias';
    
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"dia_de_semana",
    ];
    public function ciclo_many()
    {
        return $this->belongsToMany(Ciclos::class, 'dias_ciclo_many', 'parent_id', 'selected_id');
    }
	public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->orWhere("dia_de_semana","like","%".$search."%");
        }
    }
}