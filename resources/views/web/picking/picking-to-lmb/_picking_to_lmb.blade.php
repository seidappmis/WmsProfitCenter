<div class="row mb-0">
  <div class="col s12 m6">
    <h5>Picking to LMB</h5>
  </div>
  <div class="col s12 m6">
    <!---- Search ----->
    <div class="app-wrapper">
      <div class="datatable-search">
        <i class="material-icons mr-2 search-icon">search</i>
        <input type="text" placeholder="Search" class="app-filter" id="picking_to_lmb_filter">
      </div>
   </div>
  </div>
</div>

<div class="section-data-tables"> 
  <table id="picking-to-lmb-table" class="display" width="100%">
      <thead>
          <tr>
            <th>PICKING NO</th>
            <th>DRIVER NAME</th>
            <th>DESTINATION</th>
            <th>EXPEDITION NAME</th>
            <th>LMB.</th>
            <th width="50px;"></th>
          </tr>
      </thead>
      <tbody>
      </tbody>
  </table>
</div>
<!-- datatable ends -->

@push('script_js')
<script type="text/javascript">
  var dtdatatable_picking_to_lmb;
  jQuery(document).ready(function($) {
    dtdatatable_picking_to_lmb = $('#picking-to-lmb-table').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{url('picking-to-lmb')}}',
            type: 'GET',
            data: function(d) {
              d.search['value'] = $('#picking_to_lmb_filter').val()
            }
        },
        order: [0, 'asc'],
        columns: [
            {data: 'picking_no', name: 'wms_pickinglist_header.picking_no', className: 'detail'},
            {data: 'driver_name', name: 'driver_name', className: 'detail'},
            {data: 'destination_name', name: 'destination_name', className: 'detail'},
            {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
            {data: 'lmb_date', name: 'lmb_date', className: 'detail'},
            {data: 'action', className: 'center-align', orderable:false, searchable: false},
        ]
    });
    dtdatatable_picking_to_lmb.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
        var data = dtdatatable_picking_to_lmb.row(tr).data();
        id = data.driver_register_id
        event.preventDefault();
        /* Act on the event */
        // Ditanyain dulu usernya mau beneran delete data nya nggak.
        swal({
          title: "Are you sure?",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, Cancel It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) { // Bila oke post ajax ke url delete nya
            // Ajax Post Delete
            $.ajax({
              url: '{{url('picking-to-lmb')}}' + '/' + id,
              type: 'DELETE',
            })
            .done(function() { // Kalau ajax nya success
              swal("Good job!", "You clicked the button!", "success") // alert success
              dtdatatable_picking_to_lmb.ajax.reload(null, false); // reload datatable
              dttable_picking_list.ajax.reload(null, false); // reload datatable
            })
            .fail(function() { // Kalau ajax nya gagal
              console.log("error");
            });

          }
        })
    });
    $("input#picking_to_lmb_filter").on("keyup click", function () {
        filterGlobalPickingToLMB();
      });
  });
  function filterGlobalPickingToLMB() {
      dtdatatable_picking_to_lmb.search($("#picking_list_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
    }
</script>
@endpush