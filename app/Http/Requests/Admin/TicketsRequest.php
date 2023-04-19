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

class TicketsRequest extends FormRequest
{
    public function rules()
    {
        return [
            "estado"=>[
				"required"
			],
			"asunto"=>[
				"string",
				"required"
			],
			"solicitante"=>[
				"string",
				"required"
			],
			"correo"=>[
				"email",
				"required"
			],
			"mensaje"=>[
				"required"
			]
        ];
    }
    public function attributes()
    {
        return [
            "estado"=>"Estado",
			"asunto"=>"Asunto",
			"solicitante"=>"Solicitante",
			"correo"=>"Correo",
			"mensaje"=>"Mensaje"
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