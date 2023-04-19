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
use App\Http\Controllers\Traits\Admin\AdmikoFileUploadTrait;

class DistribucionDeAulas extends Model
{
    use AdmikoFileUploadTrait;

    public $table = 'distribucion_de_aulas';
    
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
		"ciclo",
		"aulas",
		"admiko_parent_child",
		"a",
    ];
    public function ciclo_id()
    {
        return $this->belongsTo(Ciclos::class, 'ciclo');
    }
	public function aulas_id()
    {
        return $this->belongsTo(Aulas::class, 'aulas');
    }
	public static function buildParentChildrenBreadcrumbs($id)
    {
        $data = array();
        $DistribucionDeAulasList = DistribucionDeAulas::where('id', $id)->first();
        if ($DistribucionDeAulasList) {
            $data[$DistribucionDeAulasList->id] = $DistribucionDeAulasList->a;
            if($DistribucionDeAulasList->admiko_parent_child > 0){
                $dataParent = DistribucionDeAulas::buildParentChildrenBreadcrumbs($DistribucionDeAulasList->admiko_parent_child);
                if (is_array($dataParent)) {
                    $data =  $dataParent + $data;
                }
            }
            return $data;
        }
        return $data;
    }

    public static function getParentChildrenList($parentId = 0, $indent = '')
    {
        $DistribucionDeAulasList = DistribucionDeAulas::where('admiko_parent_child', "=", $parentId)->orderByDesc("id")->get();
        if ($DistribucionDeAulasList) {
            $data = array();
            foreach ($DistribucionDeAulasList as $list) {
                $data[$list->id] = $indent . ' ' . $list->a;
                $dataChild = DistribucionDeAulas::getParentChildrenList($list->id, $indent . '-');
                if (is_array($dataChild)) {
                    $data = $data + $dataChild;
                }
            }
            return $data;
        }
        return '';
    }
    public function parentChildrenPrepareDelete($delete_ids)
    {
        foreach($delete_ids as $id) {
            $this->parentChildrenDelete($id);
        }
    }
    public function parentChildrenDelete($parentId)
    {
        $DistribucionDeAulasList = DistribucionDeAulas::where('admiko_parent_child', "=", $parentId)->orderByDesc("id")->get();
        if ($DistribucionDeAulasList) {
            foreach ($DistribucionDeAulasList as $list) {
                DistribucionDeAulas::parentChildrenDelete($list->id);
                DistribucionDeAulas::destroy($list->id);
            }
        }
    }
}