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

class DocentesRequest extends FormRequest
{
    public function rules()
    {
        return [
            "codigo"=>[
				"string",
				"required"
			],
			"nombres"=>[
				"string",
				"required"
			],
			"apellidos"=>[
				"string",
				"required"
			],
			"categoria"=>[
				"required"
			],
			"condicion"=>[
				"required"
			],
			"especialidad"=>[
				"required"
			],
			"grado"=>[
				"required"
			],
			"correo"=>[
				"email",
				"nullable"
			],
			"celular"=>[
				"string",
				"nullable"
			],
			"horas"=>[
				"integer",
				"min:1",
				"nullable"
			],
			"descripcion"=>[
				"nullable"
			],
			"foto"=>[
				"image",
				"file_extension:jpg,png,jpeg",
				"mimes:jpg,png,jpeg",
				"nullable"
			],
			"cv"=>[
				"file",
				"file_extension:pdf,word,wordx",
				"mimes:pdf,word,wordx",
				"nullable"
			]
        ];
    }
    public function attributes()
    {
        return [
            "codigo"=>"Código",
			"nombres"=>"Nombres",
			"apellidos"=>"Apellidos",
			"categoria"=>"Categoría",
			"condicion"=>"Condición",
			"especialidad"=>"Especialidad",
			"grado"=>"Grado",
			"correo"=>"Correo",
			"celular"=>"Celular",
			"horas"=>"Horas",
			"descripcion"=>"Descripción",
			"foto"=>"Foto",
			"cv"=>"CV"
        ];
    }
    public function messages()
    {
        return [
            "cv.required_without"=>trans("validation.required")
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