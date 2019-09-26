@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    Estas viendo el Ticket {{$ticket->title}}
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif

  <div class="card-body">
      <form method="POST" action="{{ route('ticket.update', $ticket) }}">
        @csrf
        @method('PATCH')
        
        <div style="margin-left:20%; margin-right:20%">
            <div class="text-center"><h4>General</h4></div>
            <div class="pt-2">
                <div class="form-group row">
                    <label for="nro" class="col-md-4 col-form-label text-md-right">Nro:</label>
                    <div class="col-md-6">
                        <input id="nro" type="text" class="form-control @error('nro') is-invalid @enderror" 
                        name="nro" value="{{$ticket->nro}}" autocomplete="nro" readonly autofocus>

                        @error('nro')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label text-md-right">Titulo:</label>
                        <div class="col-md-6">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" 
                        name="title" value="{{$ticket->title}}" autocomplete="tite" readonly autofocus>

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="brand_id" class="col-md-4 col-form-label text-md-right">Brand:</label>
                    <div class="col-md-6">
                        <input id="brand_id" type="text" class="form-control @error('brand_id') is-invalid @enderror" 
                        name="brand_id" value='{{isset($ticket->brand->name) ? $ticket->brand->name : "Sin Brand asignada"}}' 
                        readonly autocomplete="brand_id" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="created_at" class="col-md-4 col-form-label text-md-right">Creado:</label>
                    <div class="col-md-6">
                        <input id="created_at" type="text" class="form-control @error('created_at') is-invalid @enderror" 
                        name="created_at" value="{{ \Carbon\Carbon::parse($ticket->created_at)->format('h:m d/m/Y')}}" readonly autocomplete="created_at" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="updated_at" class="col-md-4 col-form-label text-md-right">Actualizado:</label>
                    <div class="col-md-6">
                        <input id="updated_at" type="text" class="form-control @error('updated_at') is-invalid @enderror" 
                        name="updated_at" value="{{ \Carbon\Carbon::parse($ticket->updated_at)->format('h:m d/m/Y')}}" readonly autocomplete="updated_at" autofocus>
                    </div>
                </div>
            </div>
        </div>

        <hr style="margin: 20px 30%">

        <div  style="margin-left:20%; margin-right:20%">
            <div class="text-center"><h4>Responsables</h4></div>
            <div class="pt-2">
                <div class="form-group row">
                    <label for="assigned_id" class="col-md-4 col-form-label text-md-right">{{ __('Asignado a:') }}</label>
                    <div class="col-md-6">
                        <input id="assigned_id" type="text" class="form-control @error('assigned_id') is-invalid @enderror" 
                        name="assigned_id" value="{{isset($ticket->assigned->name) ? $ticket->assigned->name : 'Sin asignar'}}" 
                        autocomplete="assigned_id" readonly autofocus>

                    @error('assigned_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tester_id" class="col-md-4 col-form-label text-md-right">Tester:</label>
                    <div class="col-md-6">
                        <input id="tester_id" type="text" class="form-control @error('tester_id') is-invalid @enderror" 
                        name="tester_id" value='{{isset($ticket->tester->name) ? $ticket->tester->name : "Sin Tester asignado"}}' 
                        autocomplete="tester_id" readonly autofocus>

                        @error('tester_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <hr style="margin: 20px 30%">

        <div  style="margin-left:20%; margin-right:20%">
            <div class="text-center"><h4>Estado</h4></div>
            <div class="pt-2">
                <div class="form-group row">
                    <label for="milestone_id" class="col-md-4 col-form-label text-md-right">Milestone:</label>
                    <div class="col-md-6">
                        <input id="milestone_id" type="text" class="form-control @error('milestone_id') is-invalid @enderror" 
                        name="milestone_id" value="{{isset($ticket->milestone->name) ? $ticket->milestone->name : 'Sin Milestone asignado'}}" 
                        autocomplete="milestone_id" readonly autofocus>

                        @error('milestone_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-4 col-form-label text-md-right">Status:</label>
                    <div class="col-md-6">
                        <input id="status" type="text" class="form-control @error('status') is-invalid @enderror" 
                        name="status" value="{{$ticket->status}}" autocomplete="status" readonly autofocus>

                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <hr style="margin: 20px 30%">

        <div  style="margin-left:20%; margin-right:20%">
            <div class="text-center"><h4>Estado</h4></div>
            <div class="pt-2">

                <div class="form-group row">
                    <label for="estimate" class="col-md-4 col-form-label text-md-right">Estimado:</label>
                    <div class="col-md-6">
                        <input id="estimate" type="text" class="form-control @error('estimate') is-invalid @enderror" 
                        name="estimate" value="{{$ticket->estimate}}" readonly autocomplete="estimate" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="worked_hours" class="col-md-4 col-form-label text-md-right">Horas Trabajadas:</label>
                    <div class="col-md-6">
                        <input id="worked_hours" type="text" class="form-control @error('worked_hours') is-invalid @enderror" 
                        name="worked_hours" value="{{$ticket->worked_hours}}" readonly autocomplete="worked_hours" readonly autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="original_estimate" class="col-md-4 col-form-label text-md-right">Estimado:</label>
                    <div class="col-md-6">
                        <input id="original_estimate" type="text" class="form-control @error('original_estimate') is-invalid @enderror" 
                        name="original_estimate" value="{{$ticket->original_estimate}}" readonly autocomplete="original_estimate" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="production_date" class="col-md-4 col-form-label text-md-right">Fecha en Produccion:</label>
                    <div class="col-md-6">
                        <input id="production_date" type="text" class="form-control @error('production_date') is-invalid @enderror" 
                        name="production_date" value="{{ \Carbon\Carbon::parse($ticket->production_date)->format('h:m d/m/Y')}}" readonly autocomplete="production_date" autofocus>
                    </div>
                </div>
            </div>
        </div>

        <hr style="margin: 20px 30%">

        <div  style="margin-left:20%; margin-right:20%">
            <div class="text-center"><h4>Tags</h4></div>
            <div class="pt-2">
                <div class="form-group row">
                    <label for="tags" class="col-md-4 col-form-label text-md-right">Tags:</label>
                    <div class="col-md-6">
                        <input id="tags" type="text" class="form-control @error('tags') is-invalid @enderror" 
                        name="tags" value='{{empty($ticket->tags->pluck('name')->all()) ? "Sin Tag asignada" : $ticket->tags->pluck('name')->implode(', ')}}' 
                        readonly autocomplete="tags" autofocus>
                    </div>
                </div>
            </div>
        </div>

    </form> 
    </div>
</div>
@endsection