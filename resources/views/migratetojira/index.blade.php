@extends('layouts.main')

@section('content')
@include('partials.alert')
<div class="card">
  <div class="card-header">
    Estas migrando un milestone a jira
  </div>
  @include("partials.spinnerTop")
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
        <form method="GET" action="{{ route('migratetojira.nextStep') }}">
            <div class="form-group row">
                <label for="space_from" class="col-md-4 col-form-label text-md-right">Space:</label>
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

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                  <button type="submit" id="accionprincipal" class="btn btn-primary">
                      {{ __('Siguiente paso') }}
                  </button>
              </div>
            </div>
          </form>
    </div>
  </div>
</div>
@include('partials.spinner')
@endsection