<div class="row">
    {{-- <div>{{ $resultados->links() }}</div> --}}
    <div>{{ $resultados->appends(Request::except('page'))->links() }}</div>
    <div class="col-md-6 text-right"><label style="float: left" class="px-1">Mostrar</label>
        <select form="filtro" style="float: left" name="perPage" class="form-control form-control-sm col-sm-2 px-1" value="{{ $perPage }}">
        @foreach(['10', '20','50','100'] as $page)
        <option @if($page == $perPage) selected @endif value="{{ $page }}">{{ $page }}</option>
        @endforeach
        </select><label style="float: left" class="px-1">por pagina</label></td>
    </div>
</div>  