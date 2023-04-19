<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="icon" href="{{ asset('assets/admiko/images/logo.png') }}">
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Facultad de Derecho y Ciencias Políticas</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        {{-- Plantilla --}}
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
      
        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        
        {{-- Iconos --}}
        <link rel="stylesheet" href="https://unpkg.com/@icon/icofont/icofont.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

        {{-- Historia --}}
        <script src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js'></script>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css'>

        @vite(['resources/css/app.css','resources/js/app.js'])

    </head>

    <body>
      <div id="preloader"></div>
          <a href="#" class="back-to-top"><i class="bi bi-arrow-up-short"></i></a>
        <header id="header" class="sticky-top">
            <div class="container d-flex align-items-center">
                <div class="logo me-auto">
                  <a href="{{ route('inicio') }}">
                    <img src="{{ asset('assets/admiko/images/logos.png') }}">
                  </a>
                </div>

                <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li class="active"><a href="#inicio">Inicio</a></li>
                    <li class="drop-down"><a href="javascript:void(0);">Facultad</a>
                    <ul>
                        <li><a href="#historia">Historia</a></li>
                        <li><a href="#mision">Misión y Visión</a></li>
                        <li><a href="#plana">Plana Docente</a></li>
                        {{-- <li><a href="#autoridades">Autoridades</a></li>
                        <li><a href="#ambientes">Ambientes</a></li> --}}
                    </ul>
                    </li>
                    <li class="drop-down"><a href="javascript:void(0);">Estudiantes</a>
                    <ul>
                        <li><a href="#horario">Horario</a></li>
                        {{-- <li><a href="#">Perfil Profesional</a></li> --}}
                        <li><a href="https://aulafdcp.unjfsc.edu.pe/login_aulavirtual/index_fdcp.php" target="_blank">Aula Virtual</a></li>
                        <li><a href="https://intranet.unjfsc.edu.pe/" target="_blank">Intranet</a></li>
                    </ul>
                    </li>
                    <li><a href="#consultas">Consultas</a></li>
                    <li><a href="{{route("admin.home")}}" target="_blank">Ingresar</a></li>
                </ul>
                </nav>
            </div>
        </header>
        
        {{-- Inicio --}}
        <section id="inicio" class="d-flex align-items-center">
            <div class="container" data-aos="zoom-out" data-aos-delay="100">
              <h1 class="text-light">Facultad de <span><br> Derecho y <br></span><span>Ciencias Políticas</span>
              </h1>
              <h2 class="text-light">Universidad José Faustino Sánchez Carrión</h2>
              <div class="">
                <a href="#historia" class="btn-get-started scrollto">Conócenos</a>
              </div>
            </div>
        </section>

        {{-- Historia --}}
        <main id="main">
            <section id="historia" class="about pb-3 pb-lg-4">
              <div class="container" data-aos="fade-up">
                <div class="section-title pb-2 pb-lg-3">
                  <h2>Historia</h2>
                  <h3>Nuestra <span>Historia</span></h3>
                  <p>{{html_entity_decode(strip_tags($info_all[2]->descripcin))}}</p>
                </div>
                <div class="timeline-carousel pt-2 pb-4 pb-lg-5 mb-0 mb-lg-3">
                  <div class="timeline-carousel__item-wrapper" data-js="timeline-carousel"  style="padding-left: 48px;">
                    @php
                      $anio_anterior=0;
                    @endphp
                    @foreach ($historia_all as $key)
                        @php
                        $fecha = \Carbon\Carbon::parse($key->fecha)->locale('es_ES')->isoFormat('DD [de] MMMM');
                        $anio = \Carbon\Carbon::parse($key->fecha)->year;
                        @endphp
                    <div class="timeline-carousel__item">
                      <div class="timeline-carousel__item-inner">
                        @if($anio==$anio_anterior)
                        <div class="pointer"></div>
                        @else
                        <span class="year h1 mb-2">{{$anio}}</span>
                        @endif
                        <span class="month">{{$fecha}}</span>
                        <p class="card-text">{{html_entity_decode(strip_tags($key->descripcion))}}</p>
                      </div>
                    </div>
                    @php
                    $anio_anterior = $anio;
                    @endphp
                    @endforeach
                  </div>
                </div>
            </section>

            <section id="mision" class="mision section-bg">
                <div class="container" data-aos="fade-up">
                <div class="section-title pb-4">
                      <h2>Identidad</h2>
                      <h3><span>Misión y Visión</span></h3>
                      <p>{{html_entity_decode(strip_tags($info_all[7]->descripcin))}}</p>
                    </div>
                    <div class="row py-4  mb-2">
                      <div class="col-lg-6">
                        <div class="icon-box" style="height: 100%;">
                        <div class="d-flex flex-column">
                            <div class="icon"><i class="ri-focus-2-line"></i></div>
                            <h4>Misión</h4>
                            <p class="text-muted">{{html_entity_decode(strip_tags($info_all[0]->descripcin))}}</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="icon-box mt-3 mt-lg-0" style="height: 100%;">
                          <div class="d-flex flex-column">
                            <div class="icon"><i class="ri-lightbulb-line"></i></div>
                            <h4>Visión</h4>
                            <p class="text-muted">{{html_entity_decode(strip_tags($info_all[1]->descripcin))}}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </section>
        
        {{-- Plana Docente --}}
        <section id="plana" class="">
          <div class="container" data-aos="fade-up">
    
            <div class="section-title" id="docentes">
              <h2>DOCENTES</h2>
              <h3>Plana <span>Docente</span></h3>
              <p>{{html_entity_decode(strip_tags($info_all[3]->descripcin))}}</p>
            </div>
            <div class="row d-flex justify-content-center">
              <div class="col-auto">
                <input type="text" style="text-align:center;" id="buscadordocente" name="admiko_search" class="form-control my-3" placeholder='Buscar Docente' value="">
              </div>
            </div>

            <script>
            </script>


            <div class="row contenido my-3 d-flex justify-content-center">
                @foreach ($docentes_all as $docente)
                  <div class="col-6 col-lg-4 col-xl-3 c p-2 e-docente" data-aos="fade-up" data-aos-delay="100">
                    <div class="row g-0">
                      <div class="p-2 pb-md-3 pt-md-2 px-md-5">
                        <center>
                          <div class="position-relative">
                          @if (isset($docente->foto) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data_doc["fileInfo"]["foto"]["original"]["folder"].$docente->foto))
                          <img src="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data_doc["fileInfo"]["foto"]["original"]["folder"].$docente->foto) }}" class="img-fluid rounded-circle img-thumbnail img-docente" width="140px" height="140px" alt="" style="object-fit: cover;">
                          @else
                          <img src="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data_doc["fileInfo"]["foto"]["original"]["folder"]."docente_sinfoto.png") }}" class="img-fluid rounded-circle img-thumbnail img-docente" width="140px" height="140px" alt="" style="object-fit: cover;">
                          @endIf
                          <button type="button" class="position-absolute top-50 b-info" data-bs-toggle="modal" data-bs-target="#exampleModal{{$docente->id}}">
                            <i class="bi bi-info-lg" style="vertical-align: -0.1em;"></i>
                          </button>
                          </div>
                        
                        </center>
                      </div>
                      <div class="d-flex flex-column col-12 justify-content-center text-center pb-1">
                        <div class="p-1 docente-info">
                          @php
                          $id = $docente->id;
                          $nombres_completos = $docente->nombres;
                          $nombres = explode(' ', $nombres_completos);
                          $nya=$docente->apellidos.' '.$nombres[0];
                          @endphp
                          <h6 class="mb-0 nombre-docente">{{$docente->abreviatura.' '.mb_convert_case($nya, MB_CASE_TITLE, "UTF-8")}}</h6>
                          <span>{{$docente->tipo}}</span>
                        </div>
                      </div>
                      
                      <div class="modal fade" id="exampleModal{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                          <div class="modal-content">
                            <div class="modal-header px-4">
                              <h5 class="modal-title" id="exampleModalLabel">Información del docente</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                              <div class="row m-0">
                                <div class="col-12 col-lg-5 rounded-bottom text-center text-lg-start modal-p" style="background-color: #f1f6fd;">
                                  <div class="row">
                                    <div class="col-12 col-lg-12">
                                      @if (isset($docente->foto) && Storage::disk(config("admiko_config.filesystem"))->exists($admiko_data_doc["fileInfo"]["foto"]["original"]["folder"].$docente->foto))
                                        <img src="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data_doc["fileInfo"]["foto"]["original"]["folder"].$docente->foto) }}" class="img-fluid rounded-3 mb-3" width="100%" alt="" style="object-fit: cover; max-width: 260px;">
                                      @else 
                                        <img src="{{ Storage::disk(config("admiko_config.filesystem"))->url($admiko_data_doc["fileInfo"]["foto"]["original"]["folder"]."docente_sinfoto.png") }}" class="img-fluid rounded-3 mb-3" width="100%" alt="" style="object-fit: cover; max-width: 260px;">
                                      @endIf
                                    </div>
                                    <div class="col-12 col-lg-12">
                                      <div class="mt-3 d-flex justify-content-center justify-content-lg-start">
                                        <div>
                                          @if($docente->correo!=null||docente->celular!=null)
                                          <h5 class="mb-3 text-center text-lg-start">Contacto</h5>
                                          @endif
                                          @if($docente->correo!=null)
                                          <p class="mb-3 d-flex">
                                            <i class="bi bi-envelope fs-6"></i>
                                            <a href="mailto:{{$docente->correo}}" class="text-start ps-2" style="font-size: 14px;">{{$docente->correo}}</a>
                                          </p>
                                          @endIf
                                          @if($docente->celular!=null)
                                          <p class="mb-0 mb-lg-3 d-flex"><i class="bi bi-phone fs-6"></i><a href="tel:{{$docente->celular}}" class="text-start ps-2" style="font-size: 14px;">{{$docente->celular}}</a></p>
                                          @endIf
                                        </div>
                                      </div>  
                                    </div>
                                  </div>                             
                                </div>
                                <div class="col-12 col-lg-7 info modal-p">
                                  <h4 class="mb-0">{{mb_convert_case($docente->nombres, MB_CASE_TITLE, "UTF-8")}} {{mb_convert_case($docente->apellidos, MB_CASE_TITLE, "UTF-8")}}</h4>
                                  <p class="text-muted mb-3 fs-6">{{$docente->grado}}</p>
                                  {!! nl2br(html_entity_decode($docente->descripcion)) !!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
            </div>

            

            <div class="pagination justify-content-center mt-3 pt-2" data-aos="fade-up" data-aos-delay="100">
              <li class="page-item prev-page disabled">
                <a class="page-link scrollto" href="javascript:void(0)" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="page-item current-page active"><a class="page-link" href="#">1</a></li>
              <li class="page-item dots"><a class="page-link" href="#">...</a></li>
              <li class="page-item current-page"><a class="page-link" href="#">5</a></li>
              <li class="page-item current-page"><a class="page-link" href="#">6</a></li>
              <li class="page-item dots"><a class="page-link" href="#">...</a></li>
              <li class="page-item current-page"><a class="page-link" href="#">10</a></li>
              <li class="page-item next-page">
                <a class="page-link scrollto" href="javascript:void(0)" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </a></li>
            </div>
          </div>
          {{-- <a class="page-link scrollto" href="javascript:void(0)" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a> --}}
        </section>
        @php
            function toRoman($number) {
            $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
                'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
                'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
            $result = '';
            while ($number > 0) {
                foreach ($map as $roman => $int) {
                    if ($number >= $int) {
                        $number -= $int;
                        $result .= $roman;
                        break;
                    }
                }
            }
            return $result;
        }
        @endphp
        <section id="horario" class="section-bg">
          <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Horario</h2>
                <h3><span>Horarios</span> de cada Ciclo</h3>
                <p>{{html_entity_decode(strip_tags($info_all[4]->descripcin))}}</p>
            </div>
            {{-- {{$dda_all}} --}}
            <div class="row d-flex justify-content-center mt-2">
              {{-- Horario --}}
              {{-- {{$calendarData[]}} --}}
              <div class="col-auto d-flex mb-2">
                <h5 class="my-auto text-end" style="min-width: 150px">Seleccione:</h5>
                <div style="padding-left: calc(var(--bs-gutter-x) * .5);">
                  <select class="form-select" id="select-ciclo" style="min-width: 150px">
                    @for ($i=1; $i <= 12; $i++)
                      @if (isset($calendarData[$i])&& is_array($calendarData[$i]))
                        @php
                        $ultimo_registro = $dda_all->last(function ($registro) use ($i) {
                            return $registro->ciclo == $i;
                        });
                        @endphp
                        @if ($ultimo_registro)
                        <option value="{{ strval($i) }}">Ciclo {{ toRoman($i) }}</option>
                        @endif
                      @endif
                    @endfor
                  </select>
                </div>
              </div>
                @for ($i=1; $i <= 12; $i++)
                  @if (isset($calendarData[$i])&& is_array($calendarData[$i]))
                    @php
                    $ultimo_registro = $dda_all->last(function ($registro) use ($i) {
                        return $registro->ciclo == $i;
                    });
                    @endphp
                    @if ($ultimo_registro)
                      <div class="container cont" data-ciclo="{{ strval($i) }}" style="display: none;">
                        <div class="mt-2 align-middle horariot mb-3">
                          <div class="row d-flex justify-content-center mb-4">
                            <div class="col-auto d-flex mb-2 mb-md-0 px-0 justify-content-center">
                              <div class="d-flex detalle">
                                <p class="me-1">Aula: </p><p>{{ $ultimo_registro->codigo }}</p>
                              </div>
                            </div>
                            <div class="col-auto d-flex mb-2 mb-md-0 pe-0  justify-content-center">
                              <div class="d-flex detalle">
                              <p class="me-1">Turno: </p><p>{{ $ultimo_registro->turno == 'M' ? 'Mañana' : 'Noche' }}</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="pr mb-3 mt-1 p-0 table-responsive">
                          <table class="table table-bordered tablahorario m-0 p-0">
                            <thead>
                                <th width="10%" class="text-center">Hora</th>
                                @foreach($weekDays as $day)
                                    <th width="18%" class="text-center">{{ $day }}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach($calendarData[$i] as $time => $days)
                                  <tr>
                                    <td class="align-middle text-center text-nowrap" class="mb-2" style="color:#444444">
                                      {{ substr($time, 0, 5) }} - {{ substr($time, -8, 5) }}
                                    </td>
                                    @foreach ($days as $day)
                                      @if (is_array($day))
                                        @php
                                          $endTime = ($ultimo_registro->turno == 'M') ? '14:00' : '22:30';
                                          $fullName = mb_convert_case(explode(' ', $day['nombre_profesor'])[0] . ' ' . $day['apellido_profesor'], MB_CASE_TITLE, "UTF-8");
                                        @endphp
                                        <td rowspan="{{ $day['rowspan'] }}"  class="align-middle text-center curso_horario" style="@if($day['dia']==5)border-right: 0px;@endif @if(substr($day['hf'], 0, -3)==$endTime)border-bottom-right-radius: 5px; border-bottom-width: 0px!important;@endif">
                                          <div class="inside_curso">
                                            <p class="mb-2"><strong>Curso:</strong> {{ $day['nombre_curso'] }}</p>
                                            <p class="mb-0"><strong>Docente:</strong> {{ $fullName }}</p>
                                          </div>
                                        </td>
                                      @elseif ($day === 1)
                                        <td></td>
                                      @endif
                                    @endforeach
                                  </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    @endif
                  @endif
                @endfor
            </div>
          </div>
      </section>
      <!-- ======= Resoluciones ======= -->
      {{-- <section id="resoluciones" class="section-bg">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>TRANSPARENCIA</h2>
            <h3><span>Resoluciones</span></h3>
            <p>{{html_entity_decode(strip_tags($info_all[5]->descripcin))}}</p>
            <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-6">
              <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Accordion Item #1
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Accordion Item #2
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Accordion Item #3
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Accordion Item #1
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Accordion Item #2
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Accordion Item #3
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section> --}}
      <!-- End Contact Section -->
      <section id="consultas" class="contact">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
            <h2>Consultas</h2>
            <h3>Envía tu <span>Consulta</span></h3>
            <p>{{html_entity_decode(strip_tags($info_all[5]->descripcin))}}</p>
          </div>

          <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-5">
              <div class="d-flex info-box mb-3 ps-4">
                <i class="bx bx-map"></i>
                <div class="ms-4">
                  <h3 class="mb-1">Dirección</h3>
                  <p class="text-nowrap">Av. Mercedes Indacochea N° 609</p>
                </div>
              </div>
              <div class="d-flex info-box mb-3 ps-4">
                <i class="bx bx-envelope"></i>
                <div class="ms-4">
                  <h3 class="mb-1">Email</h3>
                  <p>fderecho@unjfsc.edu.pe</p>
                </div>
              </div>
              <div class="d-flex info-box mb-3 ps-4">
                <i class="bx bx-phone-call"></i>
                <div class="ms-4">
                  <h3 class="mb-1">Teléfono</h3>
                  <p>232 2118</p>
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <form action="{{ route('guardar.tickets') }}" method="post" role="form" class="php-email-form" id="my-form">
                @csrf
                <div class="row">
                  <div class="col form-group">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nombres y Apellidos" data-rule="minlen:4" data-msg="Por favor ingrese al menos 4 caracteres" />
                    <div class="validate"></div>
                  </div>
                  <div class="col form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Por favor introduzca una dirección de correo electrónico válida" />
                    <div class="validate"></div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" data-rule="minlen:4" data-msg="Ingrese al menos 8 caracteres de asunto" />
                  <div class="validate"></div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Por favor escribe algo para nosotros" placeholder="Mensaje"></textarea>
                  <div class="validate"></div>
                </div>
                <div class="mb-3">
                  <div class="loading">Cargando</div>
                  {{-- <div class="error-message"></div> --}}
                  <div class="sent-message alert alert-dismissible fade show">
                    Tu mensaje ha sido enviado. ¡Gracias!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                </div>
                <div class="text-center"><button type="submit">Enviar</button></div>
              </form>
            </div>

          </div>

        </div>
      </section><!-- End Contact Section -->

      </main>
        {{-- Footer --}}
        <footer id="footer">

            <div class="footer-newsletter">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-lg-6">
                    <h4 style="color:#106eea">¡Gracias por visitarnos!</h4>
                    <p class="m-0">{{html_entity_decode(strip_tags($info_all[6]->descripcin))}}</p>
                    {{-- <form action="" method="post">
                      <input type="email" name="email"><input type="submit" value="Subscribe">
                    </form> --}}
                  </div>
                </div>
              </div>
            </div>
        
            <div class="footer-top">
              <div class="container">
                <div class="row">
        
                  <div class="col-lg-3 col-md-6 footer-contact">
                    <h4>Facultad de Derecho y <br> Ciencias Políticas</h4>
                    <p>
                      Av. Mercedes Indacochea N°  609 <br>
                      Huacho - Perú<br><br>
                      <strong>Atención:</strong> 8:00 a.m. – 5:00 p.m.<br>
                      <strong>Teléfono:</strong> 232 2118<br>
                      <strong>Email:</strong> fderecho@unjfsc.edu.pe<br>
                    </p>
                  </div>
        
                  <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Facultad</h4>
                    <ul>
                      <li><i class="bx bx-chevron-right"></i> <a href="#inicio" class="scrollto">Inicio</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="#historia" class="scrollto">Historia</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="#mision" class="scrollto">Misión y Visión</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="#plana" class="scrollto">Plana Docente</a></li>
                      {{-- <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li> --}}
                    </ul>
                  </div>
        
                  <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Estudiantes</h4>
                    <ul>
                      <li><i class="bx bx-chevron-right"></i> <a href="#horario" class="scrollto">Horario</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="https://aulafdcp.unjfsc.edu.pe/login_aulavirtual/index_fdcp.php" target="_blank">Aula Virtual</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="https://intranet.unjfsc.edu.pe/" target="_blank">Intranet</a></li>
                      {{-- <li><i class="bx bx-chevron-right"></i> <a href="#historia" class="scrollto">Conócenos</a></li> --}}
                      {{-- <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li> --}}
                    </ul>
                    <br>
                    <h4><a href="#consultas" class="scrollto" style="color:#444444!important;text-decoration:none;">Consultas</a></h4>
                  </div>
        
                  <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Redes Sociales</h4>
                    <p>Nos puedes encontrar en:</p>
                    <div class="social-links mt-3">
                      {{-- <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a> --}}
                      <a href="https://unjfsc.edu.pe/facultades/ciencias-politicas/" class="web" target="_blank"><i class="bi bi-link-45deg"></i></a>
                      <a href="https://www.facebook.com/derechounjfscoficial" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a>
                      {{-- <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a> --}}
                      <a href="https://www.linkedin.com/company/facultad-de-derecho-y-ciencias-pol%C3%ADticas-unjfsc" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a>
                    </div>
                  </div>
        
                </div>
              </div>
            </div>
        
            <div class="container py-4">
              <div class="copyright">
                Página Principal <a href="https://unjfsc.edu.pe/" target="_blank">UNJFSC</a>
              </div>
              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bizland-bootstrap-business-template/ -->
                {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
                &copy; Copyright 2023.
                Todos los derechos reservados
              </div>
            </div>
          </footer>
          
    </body>
</html>