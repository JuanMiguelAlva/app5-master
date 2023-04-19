<?php
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Requests\Admin\Cursos;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class HorarioRequest extends FormRequest
{
    public function rules()
    {
        return [
            "docente"=>[
				"required"
			],
			"dia"=>[
				"required"
			],
			"aula"=>[
				"required"
			],
			"hora_inicio"=>[
				'date_format:"'.config('admiko_config.table_time_format').'"',
				"required"
			],
			"hora_fin"=>[
				'date_format:"'.config('admiko_config.table_time_format').'"',
				"required"
			],
			"seccin"=>[
				"nullable"
			]
        ];
    }
    public function attributes()
    {
        return [
            "docente"=>"Docente",
			"dia"=>"Dia",
			"aula"=>"Aula",
			"hora_inicio"=>"Hora de inicio",
			"hora_fin"=>"Hora de fin",
			"seccin"=>"Sección"
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