{{-- <div class="section-data-tables">  --}}
  <input type="hidden" id="report-master-value" value="{{$report_master_value}}">
  <table id="data-table-master-destination" class="display" width="100%">
      <thead>
          <tr>
            <th>DESTINATION NUMBER</th>
            <th>DESTINATION NAME</th>
            <th>REGION</th>
          </tr>
      </thead>
      <tbody>
      </tbody>
  </table>
{{-- </div> --}}
<!-- datatable ends -->

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-destination').DataTable({
    serverSide: true,
    scrollX: true,
    dom: 'Bfrtip',
    buttons: [
            {
                text: 'PDF',
                action: function ( e, dt, node, config ) {
                    window.location.href = "{{url('report-master/export?file_type=pdf')}}" + '&report-master=' + $('#report-master-value').val();
                }
            },
             {
                text: 'EXCEL',
                action: function ( e, dt, node, config ) {
                    window.location.href = "{{url('report-master/export?file_type=xls')}}" + '&report-master=' + $('#report-master-value').val();
                }
            }
        ],
    ajax: {
        url: '{{ url('master-destination') }}',
        type: 'GET',
    },
    order: [[2, 'asc'], [1, 'asc']],
    columns: [
        {data: 'destination_number', name: 'destination_number', className: 'detail'},
        {data: 'destination_description', name: 'destination_description', className: 'detail'},
        {data: 'region', name: 'region', className: 'detail'},
    ]
  });
</script>
@endpush