@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    Estas editando al Planning {{$planning->name}}
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
      <form method="POST" action="{{ route('planning.update', $planning) }}">
        @csrf
        @method('PATCH')    
            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre:') }}</label>
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                  name="name" value="{{$planning->name}}" autocomplete="name" autofocus>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="state" class="col-md-4 col-form-label text-md-right">State:</label>
              <div class="col-md-6">
                <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" 
                name="state" value="{{$planning->state}}" autocomplete="state" autofocus>

                @error('state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>

            <div class="form-group row">
              <label for="date_from" class="col-md-4 col-form-label text-md-right">Desde:</label>
              <div class="col-md-6">
                <input class="form-control datepicker col-md-3" 
                required="required" value="{{ \Carbon\Carbon::parse($planning->date_from)->format('d/m/Y')}}" name="date_from" type="text" id="date_from">
              </div>
            </div>

            <div class="form-group row">
                <label for="date_to" class="col-md-4 col-form-label text-md-right">Hasta:</label>
                <div class="col-md-6">
                  <input class="form-control datepicker col-md-3" 
                  required="required" value="{{ \Carbon\Carbon::parse($planning->date_to)->format('d/m/Y')}}" name="date_to" type="text" id="date_to">
                </div>
            </div>

            <div class="form-group row">
              <label for="available_hours" class="col-md-4 col-form-label text-md-right">{{ __('Horas disponibles:') }}</label>
                <div class="col-md-6">
                  <input id="available_hours" type="text" class="form-control @error('available_hours') is-invalid @enderror" 
                  name="available_hours" value="{{isset($planning->available_hours) ? $planning->available_hours : null}}" autocomplete="available_hours" autofocus>

                  @error('available_hours')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>

            <div class="form-group row">
                <label for="tag_id" class="col-md-4 col-form-label text-md-right">Tag:</label>
                  <div class="col-md-6">
                  <select name="tag_id" class="form-control form-control col-md-6">
                      @foreach($tags as $tag)
                      <option value="{{ $tag->id }}" @if (isset($planning->tag) && $tag->id == $planning->tag->id) selected @endif>{{ $tag->name }}</option>
                      @endforeach
                  </select>
  
                    @error('tag_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
            </div>

            <div class="form-group row">
                <label for="team_id" class="col-md-4 col-form-label text-md-right">Equipo:</label>
                  <div class="col-md-6">
                  <select name="team_id" class="form-control form-control col-md-6">
                      @foreach($teams as $team)
                      <option value="{{ $team->id }}" @if (isset($planning->team) 
                      && $team->id == $planning->team->id) selected @endif >{{ $team->name }}</option>
                      @endforeach
                  </select>
  
                    @error('leader_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
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
      <div class="p-5">
        <h2>Tickets</h2>
          <table class="table text-left table-hover">
              <thead class="font-weight-bold">
                  <tr>
                    <td>Nro</td>
                    <td>Title</td>
                    <td>Milestone</td>
                    <td>Status</td>
                  </tr>
              </thead>
              <tbody>
                  @foreach($planning->tickets as $ticket)
                  <tr>
                      <td>{{$ticket->nro}}</td>
                      <td>{{$ticket->title}}</td>
                      <td>{{isset($ticket->milestone->name) ? $ticket->milestone->name : "Sin Milestone asignado"}}</td>
                      <td>{{$ticket->status}}</td>        
                  </tr>
                  @endforeach
              </tbody>
            </table>
        </table>
      </div>
  </div>
</div>

<script type="application/javascript">
  $.datepicker.regional['es'] = {
  closeText: 'Cerrar',
  prevText: '< Ant',
  nextText: 'Sig >',
  currentText: 'Hoy',
  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
  dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
  weekHeader: 'Sm',
  dateFormat: 'dd/mm/yy',
  firstDay: 1,
  isRTL: false,
  showMonthAfterYear: false,
  yearSuffix: ''
  };

  $.datepicker.setDefaults($.datepicker.regional['es']);
  
  $( function() {
    $( ".datepicker" ).datepicker();
  });
</script>
@endsection