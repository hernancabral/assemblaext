@extends('layouts.main')


@section('content')
<h1>Tickets</h1>

<div class="p-3">
    @include('partials.alert')
    @include('partials.sinResultados', ['resultados' => $tickets])
  <table class="table text-left table-hover">
    <thead class="font-weight-bold">
        <tr>
          <th>Numero</th>
          <th>Titulo</th>
          <th>Asignado a</th>
          <th>Estado</th>
          <th style="width: 60px;" colspan='2' class="text-center">Acción</th>
        </tr>
    </thead>
    <tbody>
      @include('partials.filtros', ['route' => 'ticket.index'])  
      @foreach($tickets as $ticket)
        <tr>
            <td>{{$ticket->nro}}</td>
            <td>{{$ticket->title}}</td>
            <td>{{isset($ticket->assigned->name) ? $ticket->assigned->name : "Sin asignar"}}</td>
            <td>{{$ticket->status}}</td>
            <td style="width: 60px">
            <a href="{{ route('ticket.show',$ticket->id)}}" 
              class="btn btn-primary">Ver</a>
        </tr>
        @endforeach
    </tbody>
  </table>
  @include('partials.paginado', ['resultados' => $tickets])
<div>
@endsection