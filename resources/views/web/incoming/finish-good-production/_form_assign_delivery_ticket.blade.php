<form class="form-table" id="form-assign-delivery-ticket">
    <table>
      <td width="45%" style="vertical-align: top;">
            <div class="red-text">Use (Shift or Ctrl) + left click mouse for range multi select.</div>
            <b>From Barcode Production</b>
            <table id="from-tcs-table" class="table-pick-list-result display">
                <thead><tr><th>Delivery Ticket | Model | Qty | Ean | Type</th></tr></thead>
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
                <thead><tr><th>Delivery Ticket | Model | Qty | Ean | Type</th></tr></thead>
                <tbody></tbody>
            </table>
            <table>
            <tr>
                <td>Storage Location</td>
                <td>
                  <div class="input-field col s12">
                  <select id="storage_id"
                          name="storage_id"
                          class="select2-data-ajax browser-default select-storage-location" required>
                    <option></option>
                  </select>
                  </div> 
                </td>
            </tr>
            </table>
            <button type="submit" class="waves-effect waves-light indigo btn-small mt-2 mb-2 btn-save" data-type="save">Save</button>
            <button type="submit" class="waves-effect waves-light indigo btn-small mt-2 mb-2 btn-submit-to-inventory" data-type="submit-to-inventory">Submit to Inventory</button>
            </td>
    </table>
</form>

@push('script_js')
<script type="text/javascript">
  var dtdatatable_submit_to_logsys, dttable_from_barcode_production;
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
                      return row.HEADER_NAME + ' | ' 
                      + row.MODEL + ' | '
                      + row.quantity + ' | '
                      + row.EAN_CODE + ' | '
                      + row.TIPE;
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

      dttable_from_barcode_production = $('#from-tcs-table').DataTable({
          scrollY: '60vh',
          scrollCollapse: true,
          paging:   false,
          ordering: false,
          searching: false,
          select: true,
          info:     false,
          data: [],
          columns: [
            {
              render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return row.HEADER_NAME + ' | ' 
                        + row.MODEL + ' | '
                        + row.quantity + ' | '
                        + row.EAN_CODE + ' | '
                        + row.TIPE;
                    }
                    return data;
                },
              }
          ]
        });

        dttable_from_barcode_production.on('click', 'tr', function(event) {
          event.preventDefault();
          /* Act on the event */
          $(this).toggleClass('selected');
        });



      // Storage Location
      $('.select-storage-location').select2({
         placeholder: '-- Select Storage Location --',
         allowClear: true,
         ajax: get_select2_ajax_options('/storage-master/select2-storage')
      });

      $('#form-assign-delivery-ticket').validate({
        submitHandler: function(form){
          var selected_list = [];
          dtdatatable_submit_to_logsys.$('tr').each(function() {
            var row_data = dtdatatable_submit_to_logsys.row(this).data()
            selected_list.push(row_data);
          });
          console.log($($(this)[0].submitButton).data('type'))
          setLoading(true)          
          $.ajax({
            url: '{{url('finish-good-production')}}',
            type: 'POST',
            dataType: 'json',
            data: $(form).serialize() + '&tipe_submit=' + $($(this)[0].submitButton).data('type') + '&selected_list=' + JSON.stringify(selected_list) + '&' + $('#form-find-delivery-ticket').serialize() ,
          })
          .done(function(result) {
            if (result.status) {
              window.location.href = '{{url("finish-good-production")}}'
            }
            else {
              setLoading(false)
              showSwalAutoClose('Warning', result.message)
            }
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          
        }
      })
   });


  function pickRowData(){
    dttable_from_barcode_production.$('tr.selected').each(function(index, el) {
        var row_data = dttable_from_barcode_production.row(this).data();
        dtdatatable_submit_to_logsys.row.add(row_data) 
    });
    dttable_from_barcode_production.rows( '.selected' )
        .remove()
        .draw();

    dtdatatable_submit_to_logsys.draw()
   }
   function removeRowData(){
    dtdatatable_submit_to_logsys.$('tr.selected').each(function(index, el) {
        var row_data = dtdatatable_submit_to_logsys.row(this).data();
        dttable_from_barcode_production.row.add(row_data) 
    });
    dtdatatable_submit_to_logsys.rows( '.selected' )
        .remove()
        .draw();

    dttable_from_barcode_production.draw()
   }
</script>
@endpush