@extends('layouts.main')

@section('content')
<h1>Tags</h1>

<div class="p-3" style="margin-left:20%; margin-right:20%">
  @include('partials.alert')
  @include('partials.sinResultados', ['resultados' => $tags])
  <table class="table text-left table-hover">
    <thead class="font-weight-bold">
        <tr>
          <td>Nombre</td>
        </tr>
    </thead>
    <tbody>
        @include('partials.filtros', ['route' => 'tag.index'])
        @foreach($tags as $tag)
        <tr>
            <td>{{$tag->name}}</td>            
        </tr>
        @endforeach
    </tbody>
  </table>
  @include('partials.paginado', ['resultados' => $tags])
<div>
@endsection