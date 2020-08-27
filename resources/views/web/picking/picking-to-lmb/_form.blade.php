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
        @if(auth()->user()->cabang->hq)
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
        @endif
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
  var dtdatatable_serial_number;
    jQuery(document).ready(function($) {
      dtdatatable_serial_number = $('#serial-number-table').DataTable({
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

        set_datatables_checkbox('#serial-number-table', dtdatatable_serial_number)

        $('.btn-multi-delete-selected-item').click(function(event) {
          /* Act on the event */
          swal({
            title: "Are you sure?",
            text: "Are you sure delete selected item?",
            icon: 'warning',
            buttons: {
              cancel: true,
              delete: 'Yes, Delete It'
            }
          }).then(function (confirm) { // proses confirm
            var data_serial_number = [];
            dtdatatable_serial_number.$('input[type="checkbox"]').each(function() {
               /* iterate through array or object */
               if(this.checked){
                var row = $(this).closest('tr');
                var row_data = dtdatatable_serial_number.row(row).data();
                data_serial_number.push(row_data);
               }
            });
            if (confirm) { // Bila oke post ajax ke url delete nya
              // Ajax Post Delete
              $.ajax({
                url: '{{ url('picking-to-lmb/picking-list/multi-delete-selected-item') }}' ,
                type: 'DELETE',
                data: 'data_serial_number=' + JSON.stringify(data_serial_number),
              })
              .done(function() { // Kalau ajax nya success
                showSwalAutoClose('Success', 'selected data deleted.')
                if ($('thead input[type="checkbox"]', dtdatatable_serial_number.table().container()).attr("checked")) {
                  $('thead input[type="checkbox"]', dtdatatable_serial_number.table().container()).trigger('click')
                }
                dtdatatable_serial_number.ajax.reload(null, false); // reload datatable
              })
              .fail(function() { // Kalau ajax nya gagal
                console.log("error");
              });
              
            }
          })
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
                showSwalAutoClose('Success', 'Item deleted.')
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
            setLoading(true); // Disable Button when ajax post data
            $.ajax({
              url: '{{ url("picking-to-lmb") }}',
              type: 'POST',
              data: $(form).serialize(),
            })
            .done(function(data) { // selesai dan berhasil
              showSwalAutoClose('Success', 'Data created.')
              window.location.href = "{{ url('picking-to-lmb') }}" + '/' + data.driver_register_id ;
            })
            .fail(function(xhr) {
              setLoading(false); // Enable Button when failed
                showSwalError(xhr) // Custom function to show error with sweetAlert
            });
          }
        });
    });
</script>
@endpush