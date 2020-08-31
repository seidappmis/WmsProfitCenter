<h4 class="card-title">Search Manifest</h4>
<hr>
<div class="row pl-2 mb-0 form-table">
  <div class="input-field col s3">
      <input id="filter-manifest" type="text" class="validate" name="filter-manifest" required>
  </div>
  <div class="col s9">
    <span class="waves-effect waves-light btn btn-small indigo darken-4 btn-search-manifest ml-2" id="btn-search-do">Search</span>
  </div>
</div>
<h4 class="card-title">Manifest</h4>
<hr>
<form>
  <div class="row" style="background-color: #BAE4D8;">
    <div class="input-field col s12">
      Group ID : {{$group_id}}
    </div>
    <div class="section-data-tables table-manifest-wrapper hide"> 
      <table id="data-table-manifest" class="display" width="100%">
        <thead>
            <tr>
              <th>DO MANIFEST</th>
              <th>DO MANFIEST DATE</th>
              <th>VEHICLE NO</th>
              <th>VEHICLE</th>
              <th>DESTINATION CITY</th>
              <th>COUNT OF DO</th>
              <th>SUM OF CBM</th>
              <th width="50px;"></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
  </div>
  <!-- datatable ends -->
  </div>
</form>

@push('script_js')
<script type="text/javascript">
    var dtdatatable_manifest;
    jQuery(document).ready(function($) {
      dtdatatable_manifest = $('#data-table-manifest').DataTable({
          serverSide: true,
          scrollX: true,
          responsive: true,
          ajax: {
              url: '{{url('branch-invoicing/manifest-data')}}',
              type: 'GET',
              data: function(d) {
                d.search['value'] = $('#filter-manifest').val()
              }
          },
          order: [0, 'asc'],
          columns: [
              {data: 'do_manifest_no', name: 'do_manifest_no', className: 'detail'},
              {data: 'do_manifest_date', name: 'do_manifest_date', className: 'detail'},
              {data: 'vehicle_number', name: 'vehicle_number', className: 'detail'},
              {data: 'vehicle_description', name: 'vehicle_description', className: 'detail'},
              {data: 'destination_name_driver', name: 'destination_name_driver', className: 'detail'},
              {data: 'count_of_do', name: 'count_of_do', className: 'detail', orderable:false, searchable: false},
              {data: 'sum_of_cbm', name: 'sum_of_cbm', className: 'detail', orderable:false, searchable: false},
              {data: 'action', className: 'center-align', orderable:false, searchable: false},
          ]
      });

      dtdatatable_manifest.on('draw', function (data) {
        if (dtdatatable_manifest.page.info().recordsDisplay > 0) {
          $('.table-manifest-wrapper').removeClass('hide')
        } else {
          $('.table-manifest-wrapper').addClass('hide')
        }
      });

      $('#data-table-manifest').on('click', '.btn-select-manifest', function(event) {
        event.preventDefault();
        /* Act on the event */
        $.ajax({
          url: '{{ url('branch-invoicing/manifest-details') }}',
          type: 'GET',
          dataType: 'json',
          data: {do_manifest_no: $(this).data('id')},
        })
        .done(function(result) {
          if (result.status) {
            $('#table-new-details tbody').empty()
            $.each(result.data, function(index, val) {
               /* iterate through array or object */
               var row = '';
               row += '<tr>'
               row += '<td>' + (index + 1) + '</td>'
               row += '<td>' + val.do_manifest_date + '</td>'
               row += '<td>' + val.do_manifest_no + '</td>'
               row += '<td>' + val.ship_to_code + '</td>'
               row += '<td>' + val.ship_to + '</td>'
               row += '<td>' + val.city_name + '</td>'
               row += '<td>' + val.model + '</td>'
               row += '<td>' + val.quantity + '</td>'
               row += '<td>' + val.cbm + '</td>'
               row += '<td><input type="hidden" name="detail_id[]" value="' + val.id + '"></input><input type="number" value="0" min="0" name="cost_per_cbm[]"></input></td>'
               row += '<td><input type="number" value="0" min="0" name="cost_per_coli[]"></input></td>'
               row += '<td><input type="number" value="0" min="0" name="cost_per_trip[]"></input></td>'
               row += '</tr>'

               $('#table-new-details tbody').append(row)
            });
            $('.form-manifest-detail-wrapper').removeClass('hide')
          }
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        
      });

      $('.btn-search-manifest').click(function(event) {
        /* Act on the event */
        dtdatatable_manifest.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
      });
    });
</script>
@endpush