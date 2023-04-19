<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Requests\Admin\Docentes;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class PublicacionesRequest extends FormRequest
{
    public function rules()
    {
        return [
            "nombre"=>[
				"string",
				"required",
				"sometimes"
			],
			"tipo"=>[
				"required",
				"sometimes"
			],
			"enlace"=>[
				"string",
				"nullable"
			]
        ];
    }
    public function attributes()
    {
        return [
            "nombre"=>"Nombre",
			"tipo"=>"Tipo",
			"enlace"=>"Enlace"
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