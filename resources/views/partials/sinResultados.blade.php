@if(is_countable($resultados) && count($resultados) == 0)
<script>
  swal.fire({
    type: 'error',
    title: 'Oops...',
    text: 'No se encontro nada!',
    timer:3000
  })
  </script>
@endif