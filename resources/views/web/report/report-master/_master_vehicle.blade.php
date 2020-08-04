<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-vehicle" class="display" width="100%">
    <thead>
        <tr>
            <th>GROUP NAME</th>
            <th>VEHICLE CODE</th>
            <th>VEHICLE DESCRIPTION</th>
            <th>VEHICLE SAP DESCRIPTION</th>
            <th>CBM MIN</th>
            <th>CBM MAX</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-vehicle').DataTable({
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
        url: '{{ url('report-master') }}',
        type: 'GET',
    },
    order: [[0, 'asc'], [1, 'asc']],
    columns: [
        {data: 'vehicle_group', name: 'tr_vehicle_type_group.group_name', className: 'detail'},
        {data: 'vehicle_code_type', className: 'detail'},
        {data: 'vehicle_description', className: 'detail'},
        {data: 'sap_description', className: 'detail'},
        {data: 'cbm_min', className: 'detail'},
        {data: 'cbm_max', className: 'detail'},
    ]
  });
</script>
@endpush