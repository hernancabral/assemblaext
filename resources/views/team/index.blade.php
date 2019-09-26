@extends('layouts.main')


@section('content')
<h1>Teams</h1>

<div>
  <a href="{{ route('team.create') }}" class="btn btn-primary">Nuevo</a>
</div>

<div class="p-3">
    @include('partials.alert')
    @include('partials.sinResultados', ['resultados' => $teams])
  <table class="table text-left table-hover">
    <thead class="font-weight-bold">
        <tr>
          <td>Nombre</td>
          <td>Lider</td>
          <td>Actualizado</td>
          <td style="width: 60px;" colspan='2' class="text-center">Acción</td>
        </tr>
    </thead>
    <tbody>
        @include('partials.filtros', ['route' => 'team.index'])
        @foreach($teams as $team)
        <tr>
            <td>{{$team->name}}</td>
            <td>{{isset($team->leader->name) ? $team->leader->name : "Sin Lider asignado"}}</td>
            <td>{{$team->updated_at}}</td>
            <td style="width: 30px">
            <a href="{{ route('team.edit',$team->id)}}" 
              class="btn btn-primary">Editar</a></td>
            <td style="width: 30px">
                <form action="{{ route('team.destroy', $team) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button data-name="{{$team->name}}" data-type='el team' id="deleteButton" 
                    class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                </form>
            </td>         
        </tr>
        @endforeach
    </tbody>
  </table>
  @include('partials.paginado', ['resultados' => $teams])
<div>
@endsection