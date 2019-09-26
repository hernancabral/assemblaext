@extends('layouts.main')

@section('content')

<div class="card" style="width:60%;margin:auto;">
    <div class="card-header">
        Estas editando una Prioridad
    </div>
    
    <div class="card-body">
        <form method="POST" action="{{ route('prioritized.update', $prioritized) }}">
            @csrf
            @method('PATCH')  
            <div class="form-group row">
                <label for="ticket_id" class="col-md-4 col-form-label text-md-right">Numero de Ticket:</label>
                <div class="col-md-6">
                <input id="ticket_id" type="text" class="form-control @error('ticket_id') is-invalid @enderror" 
                name="ticket_id" value="{{isset($prioritized->ticket->nro) ? $prioritized->ticket->nro : "Sin Ticket asignado"}}" autocomplete="ticket_id" autofocus>

                @error('ticket_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="people_id" class="col-md-4 col-form-label text-md-right">Asignado a:</label>
                <div class="col-md-6">
                <select name="people_id" class="form-control">
                    @foreach($peoples as $people)
                    <option value="{{ $people->id }}">{{ $people->name }}</option>
                    @endforeach
                </select>

                @error('leader_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="order" class="col-md-4 col-form-label text-md-right">Orden:</label>
                <div class="col-md-6">
                <input id="order" type="text" class="form-control @error('order') is-invalid @enderror" 
                name="order" value="{{$prioritized->order}}" autocomplete="order" autofocus>

                @error('order')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Titulo del ticket:</label>
                <div class="col-md-6">
                <input type="text" class="form-control " 
                 value="{{isset($prioritized->ticket->title) ? $prioritized->ticket->title : "Sin Ticket asignado"}}"readonly autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Brand del ticket:</label>
                <div class="col-md-6">
                <input type="text" class="form-control" 
                value="{{isset($prioritized->ticket->brand->name) ? $prioritized->ticket->brand->name : "Sin Marca asignada"}}" readonly autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Creado:</label>
                <div class="col-md-6">
                <input type="text" class="form-control" 
                value="{{$prioritized->created_at}}" readonly autofocus>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Actualizar') }}
                    </button>
                </div>
                
            </div>
        </form>

    
    </div>
</div>
@endsection