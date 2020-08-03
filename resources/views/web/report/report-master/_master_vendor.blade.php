<input type="hidden" id="report-master-value" value="{{$report_master_value}}">
<table id="data-table-master-vendor" class="display" width="100%">
    <thead>
        <tr>
            <th>VENDOR CODE</th>
            <th>VENDOR NAME</th>
            <th>DESCRIPTION</th>
            <th>VENDOR ADDRESS</th>
            <!-- <th>CONTACT PERSON NAME</th>
            <th>CONTACT PERSON PHONE</th>
            <th>CONTACT PERSON EMAIL</th> -->
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-vendor').DataTable({
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
        url: '{{ url('master-vendor') }}',
        type: 'GET',
    },
    columns: [
        {data: 'vendor_code', className: 'detail'},
        {data: 'vendor_name', className: 'detail'},
        {data: 'description', className: 'detail'},
        {data: 'vendor_address', className: 'detail'},
        // {data: 'contact_person_name', className: 'detail'},
        // {data: 'contact_person_phone', className: 'detail'},
        // {data: 'contact_person_email', className: 'detail'},
    ]
  });
</script>
@endpush