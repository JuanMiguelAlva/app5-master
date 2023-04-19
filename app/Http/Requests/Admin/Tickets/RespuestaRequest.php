<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Requests\Admin\Tickets;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class RespuestaRequest extends FormRequest
{
    public function rules()
    {
        return [
            "destino"=>[
				"email",
				"required"
			],
			"asunto"=>[
				"string",
				"required"
			],
			"mensaje"=>[
				"required"
			],
			"file"=>[
				"file",
				"nullable"
			]
        ];
    }
    public function attributes()
    {
        return [
            "destino"=>"Destino",
			"asunto"=>"Asunto",
			"mensaje"=>"Mensaje",
			"file"=>"File"
        ];
    }
    public function messages()
    {
        return [
            "file.required_without"=>trans("validation.required")
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