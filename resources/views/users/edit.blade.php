<!-- edit.blade.php -->

@extends('layouts.main')

@section('content')
<div class="card">
  <div class="card-header">
    Estas editando al Usuario {{$user->name}}
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
      <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        {{ method_field('patch') }}    
          <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

              <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                  placeholder="{{$user->name}}" value="{{ old('name') }}" autocomplete="name" autofocus>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

              <div class="col-md-6">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" readonly>

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row mb-0">
              <div class="col-md-2 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                      {{ __('Actualizar') }}
                  </button>
              </div>
              <div class="col-md-2">
                  <a href="{{ route('users.reset', $user->id) }}" class="btn btn-warning">Resetar Password</a>
              </div>              
          </div>
      </form>

      
  </div>
</div>
@endsection