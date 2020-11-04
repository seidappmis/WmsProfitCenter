<div class="assign-do-wrapper">
<h4 class="card-title mt-2">Assign DO</h4>
<hr>
<form class="form-table" id="form-assign-do">
  <input type="hidden" name="do_manifest_no" value="{{$manifestHeader->do_manifest_no}}">
    <table>
        <tr>
            <td width="45%" style="vertical-align: top;">
            <div class="red-text">Use (Shift or Ctrl) + left click mouse for range multi select.</div>
            <b>From TCS</b>
            <table id="from-tcs-table" class="table-pick-list-result display">
                <thead><tr><th>Delivery No | CBM | Qty | Model</th></tr></thead>
                <tbody>
                </tbody>
            </table>
            </td>
            <td width="10%" class="center-align">
              <div class="col s12">
                  <p><span class="waves-effect waves-light indigo btn" onclick="pickRowData()">>></span></p>
                  <br>
                  <p><span class="waves-effect waves-light indigo btn" onclick="removeRowData()"><<</span></p>
              </div>
            </td>
            <td width="45%" style="vertical-align: top;">
            <b>Submit to Logsys</b>
            <table id="submit-to-logsys-table" class="table-pick-list-result display">
                <thead><tr><th>Delivery No | CBM | Qty | Model</th></tr></thead>
                <tbody></tbody>
            </table>
            <table class="form-table">
            <tr>
                <td width="30%">City Ship To.</td>
                <td>
                  <div class="input-field col s12">
                  <select id="ship_to"
                          name="ship_to"
                          class="select2-data-ajax browser-default" required>
                  </select>
                  <input type="hidden" name="city_name">
                  </div> 
                </td>
            </tr>
            <tr>
                <td>DO Internal</td>
                <td>
                  <div class="input-field col s12">
                  <input type="text" name="do_internal" class="validate">
                  </div> 
                </td>
            </tr>
            <tr>
                <td>Reservasi No</td>
                <td>
                  <div class="input-field col s12">
                  <input type="text" name="reservasi_no" class="validate">
                  </div> 
                </td>
            </tr>
            </table>
            {!! get_button_save() !!}
            </td>
        </tr>
    </table>
</form>
  
</div>

@push('script_js')
<script type="text/javascript">
    var dtdatatable_submit_to_logsys, dttable_from_tcs;
   jQuery(document).ready(function($) {
        dtdatatable_submit_to_logsys = $('#submit-to-logsys-table').DataTable({
          scrollY: '60vh',
          scrollCollapse: true,
          paging:   false,
          ordering: false,
          searching: false,
          info:     false,
          select: true,
          data: [],
          columns: [
            {
              render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return row.delivery_no + ' | ' 
                        + row.cbm + ' | '
                        + row.quantity + ' | '
                        + row.model;
                    }
                    return data;
                },
              }
          ]
        });

        dtdatatable_submit_to_logsys.on('click', 'tr', function(event) {
          event.preventDefault();
          /* Act on the event */
          $(this).toggleClass('selected');
        });

        @if ($lmbHeader->do_details->count() == 0)
        $('.assign-do-wrapper').addClass('hide')
        @endif

        dttable_from_tcs = $('#from-tcs-table').DataTable({
          scrollY: '60vh',
          scrollCollapse: true,
          paging:   false,
          ordering: false,
          searching: false,
          select: true,
          info:     false,
          data: {!!$lmbHeader->do_details->toJson()!!},
          columns: [
            {
              render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return row.delivery_no + ' | ' 
                        + row.cbm + ' | '
                        + row.quantity + ' | '
                        + row.model;
                    }
                    return data;
                },
              }
          ]
        });

        dttable_from_tcs.on('click', 'tr', function(event) {
          event.preventDefault();
          /* Act on the event */
          $(this).toggleClass('selected');
        });

        $('#form-assign-do [name="ship_to"]').select2({
          placeholder: '-- Select Ship to City --',
          allowClear: true,
          ajax: get_select2_ajax_options(
            '{{url('/master-expedition/select2-expedition-destination-city')}}', {expedition_code: '{{$lmbHeader->expedition_code}}', vehicle_code_type:'{{$manifestHeader->vehicle_code_type}}'})
        })
        $('#form-assign-do [name="ship_to"]').change(function(event) {
          /* Act on the event */
          var data = $(this).select2('data')[0]
          $('#form-assign-do [name="city_name"]').val(data.text)
        });
   });

   function pickRowData(){
    dttable_from_tcs.$('tr.selected').each(function(index, el) {
        var row_data = dttable_from_tcs.row(this).data();
        dtdatatable_submit_to_logsys.row.add(row_data) 
    });
    dttable_from_tcs.rows( '.selected' )
        .remove()
        .draw();

    dtdatatable_submit_to_logsys.draw()
   }
   function removeRowData(){
    dtdatatable_submit_to_logsys.$('tr.selected').each(function(index, el) {
        var row_data = dtdatatable_submit_to_logsys.row(this).data();
        dttable_from_tcs.row.add(row_data) 
    });
    dtdatatable_submit_to_logsys.rows( '.selected' )
        .remove()
        .draw();

    dttable_from_tcs.draw()
   }
</script>
@endpush