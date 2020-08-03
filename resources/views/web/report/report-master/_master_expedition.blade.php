<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-expedition" class="display" width="100%">
    <thead>
        <tr>
          <th>NAME</th>
          <th>ADDRESS</th>
          <th>CODE</th>
          <th>SAP VENDOR NAME</th>
          <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-expedition').DataTable({
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
        url: '{{ url('master-expedition') }}',
        type: 'GET',
    },
    columns: [
        {data: 'expedition_name', className: 'detail'},
        {data: 'address', className: 'detail'},
        {data: 'code', className: 'detail'},
        {data: 'sap_vendor_code', className: 'detail'},
        {data: 'status_active', className: 'detail'},
    ]
  });
</script>
@endpush