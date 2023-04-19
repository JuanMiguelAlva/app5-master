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

class ResolucionesRequest extends FormRequest
{
    public function rules()
    {
        return [
            "nombre"=>[
				"string",
				"required"
			],
			"documentos"=>[
				"file",
				"required_without:documentos_admiko_current"
			]
        ];
    }
    public function attributes()
    {
        return [
            "nombre"=>"Nombre",
			"documentos"=>"Documentos"
        ];
    }
    public function messages()
    {
        return [
            "documentos.required_without"=>trans("validation.required")
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