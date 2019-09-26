<!-- Por ahora la version mas completa-->

@extends('layouts.main')

@section('content')
<div class="card uper">
  <div class="card-header">
    Estas editando el Milestone: {{$milestone->name}}
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
      <form method="post" action="{{ route('milestone.update', $milestone->id) }}">
          @csrf
          @method('PATCH')
          <div class="form-group">
              <label for="price">Nombre: </label>
              <input type="text" class="form-control" name="nombre" value="{{$milestone->code}}" readonly/>
          </div>
          <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
            <label>Monitoreo:</label>
            <select class="form-control" name="monitor">
                <option value="1" @if ($milestone->monitor == 1) selected @endif>Activo</option>
                <option value="0" @if ($milestone->monitor == 0) selected @endif>No Activo</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Actualizar</button>
      </form>
  </div>
</div>
@endsection