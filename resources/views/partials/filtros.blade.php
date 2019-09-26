<tr class="filtros">
    <form action="{{ route($route) }}" id="filtro"></form>
    @foreach($opciones as $nombreBonito => $opcion)
    <td><input form="filtro" class="form-control form-control-sm" type="search" 
        name="{{$opcion}}" placeholder="{{ $nombreBonito }}"></td>
    @endforeach
    @if (isset($combo))
        <td><select form="filtro" type="search"class="form-control form-control-sm" name="monitor">
            <option value="" selected>Indistinto</option>
            @foreach($combo as $nombreLindo => $value)
                <option value="{{$value}}">{{$nombreLindo}}</option>
            @endforeach      
        </select></td>
    @endif       
    <input form="filtro" type="submit" style="visibility: hidden;" />
    @if (isset($accion))
        {!! $accion !!}
    @endif
</tr>