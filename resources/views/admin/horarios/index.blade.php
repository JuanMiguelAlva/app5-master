@extends("admin.layouts.default")
@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">Horario</li>
@endsection
@section('pageTitle')
<h1>Horario</h1>
@endsection
@section('pageInfo')
@endsection
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

@section('backBtn')
<a href="{{route("admin.home")}}"><i class="fas fa-angle-left"></i> {{trans('admiko.page_back_btn')}}</a>
@endsection
@section('content')
<div class="card horario_index admikoIndex">
    <div class="card-body">
        <div class="tableBox" id="tableBox">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <div class="pb-2 pb-sm-0">
                        <select class="form-select" id="select-ciclo">
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
            </div>
            @if($ciclo!=null)
            <script>
              document.getElementById('select-ciclo').value = {{ $ciclo }};
            </script>  
            @endif
            {{-- <div class="tableLayout pb-2">
                <table class="table tableSort" style="width:100%" data-dom="ltrip">
                    <thead>
                        <tr data-sort-method='thead'>
							<th scope="col" class="w-5" data-sort-method="number" >ID</th>
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans("admiko.table_edit")}}</th>
                            @if(Gate::allows('horario_allow'))
                            <th scope="col" class="w-5 no-sort" data-orderable="false">{{trans('admiko.table_delete')}}</th>
                            @endIf
                        </tr>
                    </thead>
                    <tbody> --}}
                    {{-- @foreach($tableData as $data)
                        <tr>
							<td class="w-5"><a href="{{route("admin.horario.edit",[$data->id])}}">{{$data->id}}</a></td>
                            <td class="w-5 no-sort"><a href="{{route("admin.horario.edit",[$data->id])}}"><i class="fas fa-edit fa-fw"></i></a></td>
                            @if(Gate::allows(['horario_allow']))
                            <td class="w-5 no-sort">
                            <a href="#" data-id="{{$data->id}}" class="admiko_deleteConfirm" data-bs-toggle="modal" data-bs-target="#deleteConfirm"><i class="fas fa-trash fa-fw"></i></a>
                        </td>
                            @endIf
                        </tr>
                    @endforeach --}}
                    {{-- </tbody>
                </table>
            </div> --}}
                @for ($i=1; $i <= 12; $i++)
                  @if (isset($calendarData[$i])&& is_array($calendarData[$i]))
                    @php
                    $ultimo_registro = $dda_all->last(function ($registro) use ($i) {
                        return $registro->ciclo == $i;
                    });
                    @endphp
                    @if ($ultimo_registro)
                      <div class="cont px-0 mb-3" data-ciclo="{{ strval($i) }}" style="display: none;">
                        <div class="mt-3 align-middle horariot mb-3">
                          <div class="row d-flex mb-4">
                            <div class="col-auto d-flex pe-0">
                              <div class="d-flex detalle form-control">
                                <p class="me-1 mb-0">Aula: </p><p class="mb-0">{{ $ultimo_registro->codigo }}</p>
                              </div>
                            </div>
                            <div class="col-auto d-flex">
                              <div class="d-flex detalle form-control">
                              <p class="me-1 mb-0">Turno: </p><p class="mb-0">{{ $ultimo_registro->turno == 'M' ? 'Mañana' : 'Noche' }}</p>
                              </div>
                            </div>
                            <div class="col-auto my-auto ps-1">
                              <a href="{{route("admin.distribucion_de_aulas.edit",[$ultimo_registro->id])}}?ciclo={{$i}}"><i class="fas fa-edit fa-fw fs-6"></i></a>
                            </div>
                          </div>
                          
                        </div>
                        <div class="pr mb-1 mt-1 p-0 table-responsive">
                          <table class="table tablahorario m-0 p-0">
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
                                        <td rowspan="{{ $day['rowspan'] }}"  class="text-center curso_horario align-middle" style="@if($day['dia']==5)border-right: 0px;@endif @if(substr($day['hf'], 0, -3)==$endTime)border-bottom-right-radius: 5px; border-bottom-width: 0px!important;@endif">
                                          <div>
                                            <div class="d-flex justify-content-end mb-auto horario_edit" >
                                              <a href="{{route("admin.horario.edit",[$day['id_curso'], $day['id_horario']]) }}?ciclo={{$i}}"><i class="fas fa-edit fa-fw"></i></a>
                                              <a href="#" data-id="{{$day['id_horario']}}" data-ciclo="{{$i}}" class="admiko_deleteConfirm delete" data-bs-toggle="modal" data-bs-target="#deleteConfirm"><i class="fas fa-trash fa-fw"></i></a>
                                            </div>
                                            <p class="mt-1 mb-2" style="color: #444444"><strong>Curso:</strong> {{ $day['nombre_curso'] }}</p>
                                            <p class="mb-3" style="color: #444444"><strong>Docente:</strong> {{ $fullName }}</p>
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
            {{-- 
            <div class="row">
                <div class="col-12 col-sm order-3 order-sm-0 pt-2">
                    @if(Gate::any(['horario_allow']))
                        <a href="{{route('admin.horario.create')}}" class="btn btn-primary" role="button"><i class="fas fa-plus fa-fw"></i> {{trans('admiko.table_add')}}</a>
                    @endIf
                </div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 align-self-center paginationInfo"></div>
                <div class="col-12 col-sm-auto order-0 order-sm-3 pt-2 text-end paginationBox"></div>
            </div> --}}
        </div>
    </div>

    @if(Gate::allows(['horario_allow']))
      <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" class="w-100" action="{{route("admin.horarios.delete")}}">
            @method('DELETE')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{trans('admiko.delete_confirm')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start" style="font-size: 14px;">{{trans('admiko.delete_message')}}</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{trans('admiko.delete_close_btn')}}</button>
                    <button type="submit" class="btn btn-danger deleteSoft">{{trans('admiko.delete_delete_btn')}}</button>
                </div>
            </div>
            <div class="dataDelete">
            </div>
            </form>
        </div>
      </div>
      @endIf
      </div>
@endsection