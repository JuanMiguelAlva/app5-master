<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;

class Dias extends Model
{
    use AdmikoFileUploadTrait;

    public $table = 'dias';
    
    
	const P_CONS = ["1"=>"1","2"=>"2"];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"dia_de_semana",
    ];
    public function p_many()
    {
        return $this->belongsToMany(Dias::class, 'dias_p_many', 'parent_id', 'selected_id');
    }
    public function p_many_select()
    {
        return DB::table('dias_p_many')->where('parent_id',$this->id)->pluck('selected_id');
    }
	public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->orWhere("dia_de_semana","like","%".$search."%");
        }
    }
}