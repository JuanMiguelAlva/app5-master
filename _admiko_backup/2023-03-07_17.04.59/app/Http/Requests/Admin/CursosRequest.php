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

class CursosRequest extends FormRequest
{
    public function rules()
    {
        return [
            "codigo"=>[
				"integer",
				"required"
			],
			"ciclo"=>[
				"required"
			],
			"nombre"=>[
				"string",
				"required"
			],
			"linea"=>[
				"string",
				"required"
			],
			"horas_t"=>[
				"integer",
				"required",
				"min:1",
				"max:5"
			],
			"horas_p"=>[
				"integer",
				"required",
				"min:1",
				"max:5"
			],
			"creditos"=>[
				"integer",
				"required",
				"min:1",
				"max:5"
			]
        ];
    }
    public function attributes()
    {
        return [
            "codigo"=>"Código",
			"ciclo"=>"Ciclo",
			"nombre"=>"Nombre",
			"linea"=>"Línea de Carrera",
			"horas_t"=>"Horas Teóricas",
			"horas_p"=>"Horas Prácticas",
			"creditos"=>"Créditos"
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