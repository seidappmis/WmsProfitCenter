<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-destination-city" class="display" width="100%">
    <thead>
        <tr>
          <th>CITY CODE</th>
          <th>CITY NAME</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-destination-city').DataTable({
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
        url: '{{ url('destination-city') }}',
        type: 'GET',
    },
    columns: [
        {data: 'city_code', className: 'dt-body-right'},
        {data: 'city_name', className: 'detail'},
    ]
  });
</script>
@endpush