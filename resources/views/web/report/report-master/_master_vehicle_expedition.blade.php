<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-vehicle-expedition" class="display" width="100%">
    <thead>
        <tr>
            <th>VEHICLE NO</th>
            <th>VEHICLE TYPE</th>
            <th>VEHICLE GROUP</th>
            <th>EXPEDITION NAME</th>
            <th>CBM MIN</th>
            <th>CBM MAX</th>
            <th>DESTINATION</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-vehicle-expedition').DataTable({
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
        url: '{{ url('master-vehicle-expedition') }}',
        type: 'GET',
    },
    columns: [
        {data: 'vehicle_number', className: 'detail'},
        {data: 'vehicle_type', className: 'detail'},
        {data: 'vehicle_group', className: 'detail'},
        {data: 'expedition_name', className: 'detail'},
        {data: 'cbm_min', className: 'detail'},
        {data: 'cbm_max', className: 'detail'},
        {data: 'destination_name',  className: 'detail'},
        {data: 'status_active', className: 'detail'},
    ]
  });
</script>
@endpush