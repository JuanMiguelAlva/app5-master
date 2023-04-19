<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Requests\Admin\Ciclos;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class SeccionRequest extends FormRequest
{
    public function rules()
    {
        return [
            "nombre"=>[
				"string",
				"required"
			]
        ];
    }
    public function attributes()
    {
        return [
            "nombre"=>"Nombre"
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