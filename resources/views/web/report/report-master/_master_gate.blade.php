<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-gate" class="display" width="100%">
    <thead>
        <tr>
          <th>GATE</th>
          <th>DESCRIPTION</th>
          <th>AREA</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-gate').DataTable({
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
        url: '{{ url('master-gate') }}',
        type: 'GET',
    },
    columns: [
        {data: 'gate_number', className: 'detail'},
        {data: 'description', className: 'detail'},
        {data: 'area', className: 'detail'},
    ]
  });
</script>
@endpush