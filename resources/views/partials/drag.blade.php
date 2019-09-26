<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<!-- Datatables Js-->
{{-- <script type="text/javascript" src="//cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script> --}}

<script type="text/javascript">
$(function () {
  // $("#table").DataTable();

  $( "#tablecontents" ).sortable({
    items: "tr:not(.filtros)",
    cursor: 'move',
    opacity: 0.6,
    update: function() {
        sendOrderToServer();
    }
  });

  function sendOrderToServer() {

    var order = [];
    $('tr.row1').each(function(index,element) {
      order.push({
        id: $(this).attr('data-id'),
        position: index+1
      });
    });

    $.ajax({
      type: "PUT", 
      dataType: "json", 
      url: "{{ route($route) }}",
      data: {
        order:order,
        _token: '{{csrf_token()}}'
      },
      success: function(response) {
          if (response.status == "success") {
            console.log(response);
          } else {
            console.log(response);
          }
      }
    });

  }
});
</script>