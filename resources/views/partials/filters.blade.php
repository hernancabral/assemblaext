<form class="p-3" action="{{ route($route) }}">
  <div class="row">
    <div class="col-md-4">
      <input class="form-control form-control-sm" type="search" name="q" value="{{ $q }}">
    </div>

    <div class="col-md-2 col-3">
      <select name="sortBy" class="form-control form-control-sm" value="{{ $sortBy }}">
        @foreach($opciones as $filtro => $col)
          <option @if($col == $sortBy) selected @endif value="{{ $col }}">Buscar por {{ ucfirst($filtro) }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-2 col-3">
      <select name="orderBy" class="form-control form-control-sm" value="{{ $orderBy }}">
        @foreach(['asc', 'desc'] as $order)
          <option @if($order == $orderBy) selected @endif value="{{ $order }}">Orden {{ ucfirst($order) }}endente</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-3 col-3">
      <select name="perPage" class="form-control form-control-sm" value="{{ $perPage }}">
        @foreach(['10', '20','50','100'] as $page)
          <option @if($page == $perPage) selected @endif value="{{ $page }}">Mostrar {{ $page }} por pagina</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-1 col-3">
      <button type="submit" class="btn btn-secondary">Filtrar</button>
    </div>
  </div>
</form>