@extends('layouts.main')


@section('content')
<h1>Prioritized</h1>

<div class="d-flex justify-content-center text-primary position-absolute" style="   position: absolute;
left: 50%;
top: 50%;
height:60px;
width:60px;
margin:0px auto;
z-index: 10;">
  <div id ="spinner" class="spinner-border" role="status" style="width: 3rem; height: 3rem; opacity:0"></div>
</div>

<div id="main">
@include('prioritized.create')


<div class="p-3">
  @include('partials.alert')
  @include('partials.sinResultados', ['resultados' => $prioritizeds])
  <table class="table text-left table-hover" id="table">
    <thead class="font-weight-bold">
        <tr>
            <td>Nro de ticket</td>
            <td>Titulo del ticket</td>
            <td>Marca</td>
            <td>Milestone</td>
            <td>Status</td>
            <td>Equipo</td>
            <td>Estimado</td>
            <td>Estimado original</td>
            <td>Horas trabajadas</td>
            <td style="width: 60px;" colspan='2' class="text-center">Acción</td>
        </tr>
    </thead>
    <tbody id="tablecontents">
        @php
        $ruta = route("prioritized.refresh_all");
        $accion = '<td style="width: 30px" colspan="2" class="text-right"><a href="' . $ruta . '" class="btn btn-info"><i class="fa fa-refresh"></i>Actualizar todo</a></td>';
        @endphp
        @include('partials.filtros', ['route' => 'prioritized.index'])
        @foreach($prioritizeds as $prioritized)
        <tr class="row1" data-id="{{ $prioritized->id }}">
            <td>{{isset($prioritized->ticket->nro) ? $prioritized->ticket->nro : "Sin Ticket asignado"}}</td>
            <td>{{isset($prioritized->ticket->title) ? $prioritized->ticket->title : "Sin Ticket asignado"}}</td>
            <td>{{isset($prioritized->ticket->brand->name) ? $prioritized->ticket->brand->name : "Sin Marca asignada"}}</td>
            <td>{{isset($prioritized->ticket->milestone->name) ? $prioritized->ticket->milestone->name : "Sin Ticket asignado"}}</td>
            <td>{{isset($prioritized->ticket->status) ? $prioritized->ticket->status : "Sin Status"}}</td>
            <td>{{isset($prioritized->team->name) ? $prioritized->team->name : "Sin asignar"}}</td>
            <td>{{isset($prioritized->ticket->estimate) ? $prioritized->ticket->estimate : "Sin asignar"}}</td>
            <td>{{isset($prioritized->ticket->original_estimate) ? $prioritized->ticket->original_estimate : "Sin asignar"}}</td>
            <td>{{isset($prioritized->ticket->worked_hours) ? $prioritized->ticket->worked_hours : "Sin asignar"}}</td>
            <td style="width: 30px"><a href="{{ route('prioritized.refresh', $prioritized) }}" class="btn btn-info"><i class="fa fa-refresh"></i></a></td>
            <td style="width: 30px">
                <form action="{{ route('prioritized.destroy', $prioritized) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button data-name="{{$prioritized->name}}" data-type='la prioridad' id="deleteButton" class="btn btn-danger sa-remove" type="submit"><i class="fa fa-trash"></i></button>
                </form>
            </td>         
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>

@include('partials.spinner')
@include('partials.drag', ['route' => 'prioritized.index'])
@endsection