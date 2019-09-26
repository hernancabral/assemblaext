@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    Estas editando a {{$people->name}}
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

  <div class="card-body" style="display:flex">
    <div style="display: block" class="rounded float-left">
      <img src='{{ asset('img/export.png') }}'>
    </div>
    <div style="display: inline" class="col-md-12 float-right">
      <form method="POST" action="{{ route('people.update', $people) }}">
        @csrf
        @method('PATCH')    
            <div class="form-group row">
              <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Nombre:') }}</label>
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                  name="name" value="{{$people->name}}" readonly autofocus>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>

            <div class="form-group row">
                <label for="username" class="col-md-2 col-form-label text-md-right">Usuario:</label>
                <div class="col-md-6">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" 
                name="username" value="{{$people->username}}" readonly autofocus>

                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-2 col-form-label text-md-right">Mail:</label>
                <div class="col-md-6">
                  <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" 
                  name="email" value="{{$people->email}}" readonly autofocus>
  
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>

            <div class="form-group row">
                <label for="code" class="col-md-2 col-form-label text-md-right">Codigo:</label>
                <div class="col-md-6">
                  <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" 
                  name="code" value="{{$people->code}}" readonly autofocus>
  
                  @error('code')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>

            <div class="form-group row">
                <label for="team_id" class="col-md-2 col-form-label text-md-right">Equipo:</label>
                  <div class="col-md-6">
                  <select name="team_id" class="form-control form-control col-md-6">
                      @foreach($teams as $team)
                      <option value="{{ $team->id }}" @if (isset($people->team) && $team->id == $people->team->id) selected @endif >{{ $team->name }}</option>
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
    </div>
      
  </div>
</div>

<script type="application/javascript">
  $( function() {
    $( ".datepicker" ).datepicker();
  });
</script>
@endsection