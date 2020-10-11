<hr>
<h4 class="card-title">Find Picking No</h4>
<div class="app-wrapper mr-2">
  <div class="datatable-search">
    <i class="material-icons mr-2 search-icon">search</i>
    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
  </div>
</div>
<form class="form-table" id="form-assign-picking">
  <input type="hidden" name="city_name">
  <input type="hidden" name="destination_number" value="{{$driverRegistered->destination_number}}">
  <input type="hidden" name="destination_name" value="{{$driverRegistered->destination_name}}">
  <table class="form-table">
    <tr>
      <td width="20%">Gate</td>
      <td>
        <div class="input-field col s12">
        <select id="gate_number"
                name="gate_number"
                class="select2-data-ajax browser-default" required>
        </select>
        </div> 
      </td>
    </tr>
    <tr>
      <td width="20%">Ship to City</td>
      <td>
        <div class="input-field col s12">
        <select id="city_code"
                name="city_code"
                class="select2-data-ajax browser-default" required>
        </select>
        </div> 
      </td>
    </tr>
  </table>
  {!! get_button_save('Save Selected Item', 'btn-save-selected-item mt-2 mb-2') !!}
</form>
<div class="section-data-tables"> 
<table id="picking-list-table" class="display" width="100%">
    <thead>
        <tr>
          <th data-priority="1" class="datatable-checkbox-cell" width="30px">
            <label>
                <input type="checkbox" class="select-all" />
                <span></span>
            </label>
          </th>
          <th>PICKING DATE</th>
          <th>PICKING NO.</th>
          <th>SHIP TO CITY</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>

{!! get_button_cancel(url('picking-list'), 'Back', 'mt-1') !!}

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  $('#gate_number').select2({
     placeholder: '-- Select Gate --',
     ajax: get_select2_ajax_options('/master-gate/select2-free-gate', {area: '{{auth()->user()->area}}'})
  });
  $('#city_code').select2({
     placeholder: '-- Select Ship To City --',
     ajax: get_select2_ajax_options('/master-expedition/select2-expedition-destination-city', {expedition_code: '{{$driverRegistered->expedition_code}}'})
  });
  $('#city_code').change(function(event) {
    /* Act on the event */
    var data = $(this).select2('data')[0]
    $('#form-assign-picking [name="city_name"]').val(data.text)
  });

  var dttable_picking;
  jQuery(document).ready(function($) {
    dttable_picking = $('#picking-list-table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: '{{ url('picking-list/non-assign-pickinglist') }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#global_filter').val()
            }
      },
      order: [2, 'asc'],
      columns: [
          {
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            render: function ( data, type, row ) {
                if ( type === 'display' ) {
                    return '<label><input type="checkbox" name="id[]" value="" class="checkbox"><span></span></label>';
                }
                return data;
            },
            className: "datatable-checkbox-cell"
          },
          // {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'picking_date', name: 'picking_date', className: 'detail'},
          {data: 'picking_no', name: 'picking_no', className: 'detail'},
          {data: 'city_name', name: 'city_name', className: 'detail'},
      ],
    });
    set_datatables_checkbox('#picking-list-table', dttable_picking)

    $("input#global_filter").on("keyup click", function () {
      filterGlobal();
    });

    $("#form-assign-picking").validate({
      submitHandler: function(form) {
        swal({
          text: "Are you sure save selected picking ?",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, Submit It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) {
            setLoading(true); // Disable Button when ajax post data
            var data_picking = [];
            dttable_picking.$('input[type="checkbox"]').each(function() {
               /* iterate through array or object */
               if(this.checked){
                var row = $(this).closest('tr');
                var row_data = dttable_picking.row(row).data();
                data_picking.push(row_data);
               }
            });
            $.ajax({
              url: '{{ url("picking-list/transporter/" . $driverRegistered->id) }}',
              type: 'POST',
              data: $(form).serialize() + '&data_picking=' + JSON.stringify(data_picking),
            })
            .done(function(data) { // selesai dan berhasil
              setLoading(false)
              if (data.status) {
                showSwalAutoClose("Success", "Save Vehicle No {{$driverRegistered->vehicle_number}}")
                dttable_picking.ajax.reload(null, false)
                setTimeout(function(){ window.location.href = "{{ url('picking-list') }}" }, 2000);
              } else {
                showSwalAutoClose("Warning", data.message)
              }
            })
            .fail(function(xhr) {
                setLoading(false); // Enable Button when failed
                showSwalError(xhr) // Custom function to show error with sweetAlert
            });
          }
        })
      }
    });
  });

   function filterGlobal() {
      dttable_picking.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush