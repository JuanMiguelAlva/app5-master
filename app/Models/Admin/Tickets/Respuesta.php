<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Models\Admin\Tickets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;
use App\Http\Controllers\Traits\Admin\AdmikoAuditableTrait;

class Respuesta extends Model
{
    use AdmikoFileUploadTrait,AdmikoAuditableTrait;

    public $table = 'tickets_respuesta';
    static $admikoGlobalSearchParent = ["parent_model"=>"Tickets", "child_parent_id"=>"admiko_tickets_id"];
	
    
	static $admiko_file_info = [
		"file"=>[
			"original"=>["folder"=>"upload/"]
		]
	];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"destino",
		"asunto",
		"mensaje",
		"file",
		"file_admiko_delete",
		"admiko_tickets_id",
    ];
    public function setFileAttribute()
    {
        if (request()->hasFile('file')) {
            $this->attributes['file'] = $this->fileUpload(request()->file("file"), Respuesta::$admiko_file_info["file"], $this->getOriginal('file'));
        }
    }
    public function setFileAdmikoDeleteAttribute($value)
    {
        if (!request()->hasFile('file') && request()->file_admiko_delete == 1) {
            $this->attributes['file'] = $this->fileUpload('', Respuesta::$admiko_file_info["file"], $this->getOriginal('file'), $value);
        }
    }
}