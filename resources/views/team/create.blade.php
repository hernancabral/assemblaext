@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    Estas creando un Equipo
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
      <form method="POST" action="{{ route('team.store') }}">
        @csrf 
            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre del Equipo:') }}</label>
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                  name="name" value="{{ old('name') }}" autocomplete="name" requiered autofocus>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="leader_id" class="col-md-4 col-form-label text-md-right">{{ __('Lider del Equipo:') }}</label>
                <div class="col-md-6">
                <select name="leader_id" class="form-control form-control col-md-6">
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

          <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                      {{ __('Crear') }}
                  </button>
              </div>
              
          </div>
      </form>

      
  </div>
</div>
@endsection