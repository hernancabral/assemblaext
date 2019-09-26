@extends('layouts.main')

@section('content')
<h1>Brands</h1>

<div class="p-3" style="margin-left:20%; margin-right:20%">
    @include('partials.alert')
    @include('partials.sinResultados', ['resultados' => $brands])
  <table class="table text-left table-hover">
    <thead class="font-weight-bold">
        <tr>
          <td>Nombre</td>
        </tr>
    </thead>
    <tbody>
        @include('partials.filtros', ['route' => 'brand.index'])
        @foreach($brands as $brand)
        <tr>
            <td>{{$brand->name}}</td>            
        </tr>
        @endforeach
    </tbody>
  </table>
  @include('partials.paginado', ['resultados' => $brands])
<div>
@endsection