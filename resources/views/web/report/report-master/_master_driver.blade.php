<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-driver" class="display" width="100%">
    <thead>
        <tr>
          <th>DRIVER ID</th>
          <th>DRIVER NAME</th>
          <th>EXPEDITION</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-driver').DataTable({
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
        url: '{{ url('master-driver') }}',
        type: 'GET',
    },
    columns: [
        {data: 'driver_id', className: 'detail'},
        {data: 'driver_name', className: 'detail'},
        {data: 'expedition_code', className: 'detail'},
    ]
  });
</script>
@endpush