<!-- index.blade.php -->

@extends('layouts.main')

@section('content')
<h1>People</h1>

<div class="p-3">
  @include('partials.alert')
  @include('partials.sinResultados', ['resultados' => $peoples])
  <table class="table text-left table-hover">
    <thead class="font-weight-bold">
        <tr>
          <td>Nombre</td>
          <td>Usuario</td>
          <td>Mail</td>
          <td>Equipo</td>
          <td style="width: 30px" colspan="1" class="text-center">Accion</td>
        </tr>
    </thead>
    <tbody>
        @include('partials.filtros', ['route' => 'people.index'])
        @foreach($peoples as $people)
        <tr>
            <td>{{$people->name}}</td>
            <td>{{$people->username}}</td>
            <td>{{$people->email}}</td>
            <td>{{isset($people->team->name) ? $people->team->name : "Sin Equipo asignado"}}</td>
            <td style="width: 30px"><a href="{{ route('people.edit',$people->id)}}" class="btn btn-primary">Editar</a></td>             
        </tr>
        @endforeach
    </tbody>
  </table>
  @include('partials.paginado', ['resultados' => $peoples])
<div>
@endsection