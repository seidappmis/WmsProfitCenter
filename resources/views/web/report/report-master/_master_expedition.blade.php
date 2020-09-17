<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-expedition" class="display" width="100%">
    <thead>
        <tr>
          <th>CODE</th>
          <th>SAP VENDOR CODE</th>
          <th>NAME</th>
          <th>ADDRESS</th>
          <th>CONTACT PERSON</th>
          <th>PHONE NUMBER 1</th>
          <th>PHONE NUMBER 2</th>
          <th>FAX NUMBER</th>
          <th>BANK</th>
          <th>CURRENCY</th>
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
    // scrollY: '60vh',
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
        {data: 'code', className: 'detail'},
        {data: 'sap_vendor_code', className: 'detail'},
        {data: 'expedition_name', className: 'detail'},
        {data: 'address', className: 'detail'},
        {data: 'contact_person', className: 'detail'},
        {data: 'phone_number_1', className: 'detail'},
        {data: 'phone_number_2', className: 'detail'},
        {data: 'fax_number', className: 'detail'},
        {data: 'bank', className: 'detail'},
        {data: 'currency', className: 'detail'},
        {data: 'status_active', className: 'detail'},
    ]
  });
</script>
@endpush