{{-- <div class="section-data-tables">  --}}
  <input type="hidden" id="report-master-value" value="{{$report_master_value}}">
  <table id="data-table-master-cabang" class="display" width="100%">
      <thead>
          <tr>
            <th>KODE CUSTOMER</th>
            <th>KODE CABANG</th>
            <th>SHORT DESCRIPTION</th>
            <th>LONG DESCRIPTION</th>
            <th>TYPE</th>
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
  var table = $('#data-table-master-cabang').DataTable({
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
        url: '{{ url('master-cabang') }}',
        type: 'GET',
    },
    order: [0, 'asc'],
    columns: [
        {data: 'kode_customer', className: 'detail'},
        {data: 'kode_cabang', className: 'detail'},
        {data: 'short_description', className: 'detail'},
        {data: 'long_description', className: 'detail'},
        {data: 'type', className: 'detail'},
        {data: 'region', className: 'detail'},
    ]
  });
</script>
@endpush