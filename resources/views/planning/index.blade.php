@extends('layouts.main')


@section('content')
<h1>Plannings</h1>

<div>
  <a href="{{ route('planning.create') }}" class="btn btn-primary">Nuevo</a>
</div>

<div class="p-3">
  @include('partials.alert')
  @include('partials.sinResultados', ['resultados' => $plannings])
  <table class="table text-left table-hover">
    <thead class="font-weight-bold">
        <tr>
          <td>Nombre</td>
          <td>Tag</td>
          <td>State</td>
          <td>Desde</td>
          <td>Hasta</td>
          <td>Equipo</td>
          <td>Horas disponibles</td>
          <td style="width: 60px;" colspan='2' class="text-center">Acción</td>
        </tr>
    </thead>
    <tbody>
        @include('partials.filtros', ['route' => 'planning.index'])
        @foreach($plannings as $planning)
        <tr>
            <td>{{isset($planning->name) ? $planning->name : "Sin Nombre"}}</td>
            <td>{{isset($planning->tag->name) ? $planning->tag->name : "Sin Tag asignada"}}</td>
            <td>{{$planning->state}}</td>
            <td>{{$planning->date_from}}</td>
            <td>{{$planning->date_to}}</td>
            <td>{{isset($planning->team->name) ? $planning->team->name : "Sin Equipo asignado"}}</td>
            <td>{{isset($planning->available_hours) ? $planning->available_hours : "Sin horas disponibles"}}</td>
            <td style="width: 30px">
            <a href="{{ route('planning.edit',$planning->id)}}" 
              class="btn btn-primary">Editar</a></td>
            <td style="width: 30px">
                <form action="{{ route('planning.destroy', $planning) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button data-name="{{$planning->name}}" data-type='el planning' id="deleteButton" class="btn btn-danger sa-remove" type="submit"><i class="fa fa-trash"></i></button>
                </form>
            </td>         
        </tr>
        @endforeach
    </tbody>
  </table>
  @include('partials.paginado', ['resultados' => $plannings])
<div>
@endsection