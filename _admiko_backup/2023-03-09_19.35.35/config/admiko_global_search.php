<?php
/** Admiko global search configuration**/



/**IMPORTANT: this page will be overwritten and any change will be lost!!
 ** use admiko_global_search_custom.php to add your models into global search!!
 **/
return [
    [
        'name' => 'Cursos',
        'route_id' => 'cursos',
        'model' => 'Cursos',
        'fields' => [
            ["field"=>"codigo","show"=>1],
			["field"=>"nombre","show"=>1],
			["field"=>"linea","show"=>1]
        ]
    ],
    [
        'name' => 'Docentes',
        'route_id' => 'docentes',
        'model' => 'Docentes',
        'fields' => [
            ["field"=>"codigo","show"=>1],
			["field"=>"nombres","show"=>1],
			["field"=>"apellidos","show"=>1],
			["field"=>"correo","show"=>1],
			["field"=>"celular","show"=>1]
        ]
    ],
    [
        'name' => 'Docentes > Publicaciones',
        'route_id' => 'publicaciones',
        'model' => 'Docentes\Publicaciones',
        'fields' => [
            ["field"=>"nombre","show"=>1]
        ]
    ],
    [
        'name' => 'Tickets',
        'route_id' => 'tickets',
        'model' => 'Tickets',
        'fields' => [
            ["field"=>"asunto","show"=>1],
			["field"=>"solicitante","show"=>1]
        ]
    ],
    [
        'name' => 'Tickets > Respuesta',
        'route_id' => 'respuesta',
        'model' => 'Tickets\Respuesta',
        'fields' => [
            ["field"=>"asunto","show"=>1]
        ]
    ],
    [
        'name' => 'Ambientes',
        'route_id' => 'ambientes',
        'model' => 'Ambientes',
        'fields' => [
            ["field"=>"nombre","show"=>1]
        ]
    ],
    [
        'name' => 'Información',
        'route_id' => 'informacion',
        'model' => 'Informacion',
        'fields' => [
            ["field"=>"tipo","show"=>1],
			["field"=>"descripcin","show"=>0]
        ]
    ],
    [
        'name' => 'Historia',
        'route_id' => 'historia',
        'model' => 'Historia',
        'fields' => [
            ["field"=>"fecha","show"=>1]
        ]
    ],
    [
        'name' => 'Noticias',
        'route_id' => 'noticias',
        'model' => 'Noticias',
        'fields' => [
            ["field"=>"titulo","show"=>1],
			["field"=>"fecha","show"=>1]
        ]
    ],
    [
        'name' => 'Resoluciones',
        'route_id' => 'resoluciones',
        'model' => 'Resoluciones',
        'fields' => [
            ["field"=>"nombre","show"=>1]
        ]
    ],
    [
        'name' => 'SECIGRISTAS',
        'route_id' => 'secigristas',
        'model' => 'Secigristas',
        'fields' => [
            ["field"=>"nombres","show"=>1],
			["field"=>"apellidos","show"=>1],
			["field"=>"unidad_receptora","show"=>0]
        ]
    ],
    [
        'name' => 'Categorías',
        'route_id' => 'tipo_profesor',
        'model' => 'TipoProfesor',
        'fields' => [
            ["field"=>"tipo","show"=>1]
        ]
    ],
    [
        'name' => 'Condición',
        'route_id' => 'condicion',
        'model' => 'Condicion',
        'fields' => [
            ["field"=>"nombre","show"=>1]
        ]
    ],
    [
        'name' => 'Salones',
        'route_id' => 'aulas',
        'model' => 'Aulas',
        'fields' => [
            ["field"=>"codigo","show"=>1]
        ]
    ],
    [
        'name' => 'Unidad',
        'route_id' => 'unidad',
        'model' => 'Unidad',
        'fields' => [
            ["field"=>"nombre","show"=>1]
        ]
    ],
];
