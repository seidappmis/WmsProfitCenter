<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-model" class="display" width="100%">
    <thead>
        <tr>
            <th>MODEL NAME</th>
            <th>MODEL BPROD</th>
            <th>EAN CODE</th>
            <th>CBM</th>
            <th>MATERIAL GROUP</th>
            <th>CATEGORY</th>
            <th>TYPE</th>
            <th>DESCRIPTION</th>
            <th>PALET</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-model').DataTable({
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
        url: '{{ url('master-model') }}',
        type: 'GET',
    },
    columns: [
        {data: 'model_name', className: 'detail'},
        {data: 'model_from_apbar', className: 'detail'},
        {data: 'ean_code', className: 'detail'},
        {data: 'cbm', className: 'detail'},
        {data: 'material_group_description', className: 'detail'},
        {data: 'category', className: 'detail'},
        {data: 'model_type', className: 'detail'},
        {data: 'description', className: 'detail'},
        {data: 'max_pallet', className: 'detail'},
    ]
  });
</script>
@endpush