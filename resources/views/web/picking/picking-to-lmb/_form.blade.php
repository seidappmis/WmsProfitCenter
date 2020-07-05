<form class="form-table" id="form-picking-to-lmb">
  <input type="hidden" name="driver_register_id" value="{{$picking->driver_register_id}}">
    <table class="mb-1">
        <tr>
            <td width="30%">Picking No.</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="picking_no" 
                        value="{{$picking->picking_no}}"
                        readonly 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>No. Seal</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="seal_no" 
                        required
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>No. Container</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="container_no" 
                        required
                        />
              </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('picking-to-lmb'), 'Back') !!}
</form>

<div class="row mt-2">
    <div class="col s12 m6">
      <div class="display-flex">
        <!---- Search ----->
        <!-- Modal Trigger -->
        {!! get_button_delete('Multi Delete Selected Items', 'btn-multi-delete-selected-item') !!}
      </div>
    </div>
</div>

<div class="section-data-tables"> 
  <table id="serial-number-table" class="display" width="100%">
      <thead>
          <tr>
            <th data-priority="1" class="datatable-checkbox-cell" width="30px">
              <label>
                  <input type="checkbox" class="select-all" />
                  <span></span>
              </label>
            </th>
            <th data-priority="2" width="30px">No.</th>
            <th>SERIAL NUMBER</th>
            <th>DELIVERY NO</th>
            <th>MODEL</th>
            <th>EAN CODE</th>
            <th width="50px;"></th>
          </tr>
      </thead>
      <tbody>
      </tbody>
  </table>
</div>
<!-- datatable ends -->

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    var dtdatatable_serial_number = $('#serial-number-table').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('picking-to-lmb/picking-list/' . $picking->id) }}',
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
          render: function ( data, type, row ) {
              if ( type === 'display' ) {
                  return '<label><input type="checkbox" name="id[]" value="" class="checkbox"><span></span></label>';
              }
              return data;
          },
          className: "datatable-checkbox-cell"
        },
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'serial_number', name: 'serial_number', className: 'detail'},
        {data: 'delivery_no', name: 'delivery_no', className: 'detail'},
        {data: 'model', name: 'model', className: 'detail'},
        {data: 'ean_code', name: 'ean_code', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ],
  });

    dtdatatable_serial_number.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = dtdatatable_serial_number.row(tr).data();

      // Ask user confirmation to delete the data.
      swal({
        text: "Delete the this item ?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // if CONFIRMED send DELETE Request to endpoint
          $.ajax({
            url: '{{ url('picking-to-lmb/picking-list') }}',
            type: 'DELETE',
            data: 'ean_code=' + data.ean_code + '&serial_number=' + data.serial_number + '&picking_id=' + data.picking_id ,
            dataType: 'json',
          })
          .done(function() {
            swal("Good job!", "You clicked the button!", "success") // alert success
            dtdatatable_serial_number.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            console.log("error");
          });
        }
      })
    });

     $("#form-picking-to-lmb").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("picking-to-lmb") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function(data) { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('picking-to-lmb') }}" + '/' + data.driver_register_id ;
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush