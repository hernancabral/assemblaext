<div class="card" style="width:60%;margin:auto;">
  <div class="card-header">
    Estas creando una Prioridad
  </div>

  <div class="card-body">
      <form method="POST" action="{{ route('prioritized.store') }}">
        @csrf 
            <div class="form-group row">
                <label for="ticket_id" class="col-md-4 col-form-label text-md-right">Numero de Ticket:</label>
                <div class="col-md-6">
                <input id="ticket_id" type="text" class="form-control @error('ticket_id') is-invalid @enderror" 
                name="ticket_id" value="{{ old('ticket_id') }}" autocomplete="ticket_id" autofocus>

                @error('ticket_id')
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
                    <button type="submit" id="accionprincipal" class="btn btn-primary">Priorizar</button>
                </div>
                
            </div>
        </form>

      
    </div>
</div>