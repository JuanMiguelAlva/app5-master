<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class NoticiasRequest extends FormRequest
{
    public function rules()
    {
        return [
            "titulo"=>[
				"string",
				"required"
			],
			"fecha"=>[
				'date_format:"'.config('admiko_config.table_date_format').'"',
				"required"
			],
			"descripcion"=>[
				"required"
			],
			"imagen"=>[
				"image",
				"file_extension:jpg,png,jpeg",
				"mimes:jpg,png,jpeg",
				"nullable"
			]
        ];
    }
    public function attributes()
    {
        return [
            "titulo"=>"Título",
			"fecha"=>"Fecha",
			"descripcion"=>"Descripción",
			"imagen"=>"Imagen"
        ];
    }
    
    public function authorize()
    {
        if (!auth("admin")->check()) {
            return false;
        }
        return true;
    }
}