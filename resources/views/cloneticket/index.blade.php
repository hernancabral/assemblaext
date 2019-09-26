@extends('layouts.main')

@section('content')
@include('partials.alert')
<div class="card">
  <div class="card-header">
    Estas clonando un Ticket
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
        <form method="POST" action="{{ route('cloneticket.store') }}">
            @csrf    
            <div class="form-group row">
                <label for="space_from" class="col-md-4 col-form-label text-md-right">Desde:</label>
                <div class="col-md-6">
                <select name="space_from" class="form-control form-control col-md-6">
                    @foreach($spaces as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>

                @error('space_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
    
                <div class="form-group row">
                    <label for="space_tp" class="col-md-4 col-form-label text-md-right">Hasta:</label>
                      <div class="col-md-6">
                      <select name="space_to" class="form-control form-control col-md-6">
                          @foreach($spaces as $id => $name)
                          <option value="{{ $id }}">{{ $name }}</option>
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
                    <label for="nro" class="col-md-4 col-form-label text-md-right">Numero ticket:</label>
                      <div class="col-md-6">
                        <input id="nro" type="text" class="form-control form-control col-md-6 @error('nro') is-invalid @enderror" 
                        name="nro" value="{{ old('nro') }}" autocomplete="nro" autofocus>
      
                        @error('nro')
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