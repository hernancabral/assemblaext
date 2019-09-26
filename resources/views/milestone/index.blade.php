@extends('layouts.main')

@section('content')
<h1>Milestones</h1>

<div class="p-3" style="margin-left:20%; margin-right:20%">
    @include('partials.alert')
    @include('partials.sinResultados', ['resultados' => $milestones])
  <table class="table text-left table-hover">
    <thead class="font-weight-bold">
        <tr>
          <td>Nombre</td>
          <td>Monitor</td>
          <td style="width: 30px">Acción</td>
        </tr>
    </thead>
    <tbody>
        @include('partials.filtros', ['route' => 'milestone.index'])
        @foreach($milestones as $milestone)
        <tr>
            <td>{{$milestone->name}}</td>
            <td>{{$milestone->monitor ? "Activo" : "No Activo"}}</td>
            <td style="width: 30px">
            <a href="{{ route('milestone.edit',$milestone->id)}}" 
            class="btn btn-primary">Editar</a></td>         
        </tr>
        @endforeach
    </tbody>
  </table>
  @include('partials.paginado', ['resultados' => $milestones])
<div>
@endsection