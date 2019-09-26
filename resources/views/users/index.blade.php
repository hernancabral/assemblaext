<!-- index.blade.php -->

@extends('layouts.main')

@section('content')
<h1>Usuarios</h1>


<div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo</a>
</div>

<div class="p-3">
  @include('partials.alert')
  @include('partials.sinResultados', ['resultados' => $users])
  <table class="table text-left table-hover">
    <thead class="font-weight-bold">
        <tr>
          <td>Nombre</td>
          <td>Mail</td>
          <td>Fecha de Creacion</td>
          <td style="width: 90px" colspan="3" class="text-center">Accion</td>
        </tr>
    </thead>
    <tbody>
        @include('partials.filtros', ['route' => 'users.index'])
        @foreach($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->created_at}}</td>
            <td style="width: 30px"><a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary">Editar</a></td>
            <td style="width: 30px">
                <form action="{{ route('users.destroy', $user->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button data-name="{{$user->name}}" data-type='el usuario' id="deleteButton"
                    class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                </form>
            </td>               
        </tr>
        @endforeach
    </tbody>
  </table>
  @include('partials.paginado', ['resultados' => $users])
<div>

@endsection