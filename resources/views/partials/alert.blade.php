@if(session()->get('msg'))
    <script>
    var popupId = "{{ uniqid() }}";
    if(!sessionStorage.getItem('shown-' + popupId)) {
    const Toast = swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
    
    Toast.fire({
      type: "{{ session()->get('msg') }}",
      title: "{{ session()->get('txt') }}"
    })
    }
    sessionStorage.setItem('shown-' + popupId, '1');
  </script>
@endif
