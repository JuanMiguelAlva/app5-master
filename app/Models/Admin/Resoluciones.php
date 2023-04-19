<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Resoluciones extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'resoluciones';
    
    
	static $admiko_file_info = [
		"documentos"=>[
			"original"=>["folder"=>"upload/"]
		]
	];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"nombre",
		"documentos",
		"documentos_admiko_delete",
    ];
    public function setDocumentosAttribute()
    {
        if (request()->hasFile('documentos')) {
            $this->attributes['documentos'] = $this->fileUpload(request()->file("documentos"), Resoluciones::$admiko_file_info["documentos"], $this->getOriginal('documentos'));
        }
    }
    public function setDocumentosAdmikoDeleteAttribute($value)
    {
        if (!request()->hasFile('documentos') && request()->documentos_admiko_delete == 1) {
            $this->attributes['documentos'] = $this->fileUpload('', Resoluciones::$admiko_file_info["documentos"], $this->getOriginal('documentos'), $value);
        }
    }
	public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->orWhere("nombre","like","%".$search."%")
			->orWhere("documentos","like","%".$search."%");
        }
    }
}