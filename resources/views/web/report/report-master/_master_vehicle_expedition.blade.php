<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-vehicle-expedition" class="display" width="100%">
    <thead>
        <tr>
            <th>CODE</th>
            <th>EXPEDITION NAME</th>
            <th>VEHICLE NO</th>
            <th>DESTINATION</th>
            <th>DESCRIPTION</th>
            <th>REMARKS 1</th>
            <th>REMARKS 2</th>
            <th>REMARKS 3</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('script_js')
<script type="text/javascript">
@if(auth()->user()->cabang->hq)
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
    order: [[0, 'asc'], [1, 'asc']],  
    columns: [
        {data: 'expedition_code', className: 'detail'},
        {data: 'expedition_name', name:'tr_expedition.expedition_name', className: 'detail'},
        {data: 'vehicle_number', className: 'detail'},
        {data: 'destination_name', name: 'tr_destination.destination_description', className: 'detail'},
        {data: 'vehicle_detail_description', className: 'detail'},
        {data: 'remark1', className: 'detail'},
        {data: 'remark2',  className: 'detail'},
        {data: 'remark3',  className: 'detail'},
        {data: 'status_active', className: 'detail'},
    ]
  });
@else
@endif
</script>
@endpush