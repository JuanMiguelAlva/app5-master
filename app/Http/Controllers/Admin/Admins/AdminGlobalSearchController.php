<?php
/** Admiko Global Search Controller **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Admin\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminGlobalSearchController extends Controller
{
    public $getParentId = [];
    public function global_search(Request $request)
    {
        $search = $request->input('search');
        $searchableData = [];

        foreach ($this->mergeForGlobalSearch() as $data){
            $modelClass = 'App\Models\Admin\\' . $data['model'];
            $query      = $modelClass::query();
            $showOnlyFields = [];
            foreach ($data['fields'] as $field) {
                $query->orWhere($field['field'], 'LIKE', '%' . $search . '%');
                if($field['show'] == 1){
                    $showOnlyFields[] = $field['field'];
                }
            }
            $results = $query->take(10)->get();
            $items = [];
            if(count($results) > 0){
                foreach ($results as $result) {
                    $infoFields = [];
                    foreach ($showOnlyFields as $field) {
                        if($result->$field){
                            $infoFields[] = $result->$field;
                        }
                    }
                    $parsedData['title'] = implode(", ",$infoFields);
                    $ids = $this->getUrlId($data['model'],$result);
                    $parsedData['url'] = route('admin.'.$data['route_id'].'.edit',$ids);
                    $items[] = $parsedData;
                }
                array_pop($ids);
                $searchableData[] = ['name'=>$data['name'],'index_url'=>route('admin.'.$data['route_id'].'.index',$ids),'items'=>$items];
            }
        }
        return response()->json($searchableData);
    }
    public function getUrlId($model,$results){
        $this->getParentId = [$results->id];
        $model = 'App\Models\Admin\\'.$model;
        $this->getParentUrlId($model,$results);
        return $this->getParentId;
    }

    public function getParentUrlId($modelPath,$results){
        if (property_exists(app($modelPath), 'admikoGlobalSearchParent')) {
            $parent_model = $modelPath::$admikoGlobalSearchParent['parent_model'];
            $child_parent_id = $modelPath::$admikoGlobalSearchParent['child_parent_id'];
             $modelClass = 'App\Models\Admin\\' . $parent_model;
            $query      = $modelClass::where('id', $results->{$child_parent_id})->first();
            array_unshift($this->getParentId , $query->id);
            self::getParentUrlId($modelClass, $query);
        }
    }

    public function mergeForGlobalSearch(){
        return array_merge(config("admiko_global_search"), config("admiko_global_search_custom"));
    }
}
