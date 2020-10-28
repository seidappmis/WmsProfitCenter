<br>
<h6>Total Manifest: 1</h6>
<h5 class="card-title">List DO</h5>
<hr>
{!! get_button_delete('Multi Delete Selected Items', 'btn-multi-delete-selected-item  mb-1') !!}
<div class="section-data-tables"> 
  <table id="list-do-table" class="display" width="100%">
    <thead>
      <tr>
        <th data-priority="1" class="datatable-checkbox-cell" width="30px">
          <label>
              <input type="checkbox" class="select-all" />
              <span></span>
          </label>
        </th>
        <th>NO.</th>
        <th>No Shipment</th>
        <th>DO No</th>
        <th>DO Int No</th>
        <th>City Ship To</th>
        <th>Items</th>
        <th>Model</th>
        <th>QTY</th>
        <th>DESC</th>
        <th>Status</th>
        <th>Customer Code</th>
        <th width="50px;"></th>
      </tr>
    </thead>
    <tbody>
     {{--  @foreach($manifestHeader->details AS $key => $manifestDetail)
      <tr>
        <td>{{$key+1}}</td>
        <td>{{$manifestDetail->invoice_no}}</td>
        <td>{{ $manifestDetail->delivery_no }}</td>
        <td>{{ $manifestDetail->do_internal }}</td>
        <td>{{ $manifestDetail->ship_to }}</td>
        <td>{{ $manifestDetail->delivery_items }}</td>
        <td>{{ $manifestDetail->model }}</td>
        <td>{{ $manifestDetail->quantity }}</td>
        <td>{{ $manifestHeader->manifest_type == "REGULAR" ? 'NORMAL' : '' }}</td>
        <td>{{ $manifestDetail->status() }}</td>
        <td>{{ $manifestDetail->ship_to_code }}</td>
        <td><input type="hidden" name="id" value="{{$manifestDetail->id}}">{!! $manifestDetail->status_confirm ? '' : get_button_delete() !!}</td>
      </tr>
      @endforeach --}}
    </tbody>
  </table>
</div>
  <!-- datatable ends -->

@push('script_js')
<script type="text/javascript">
  var dttable_list_do
  jQuery(document).ready(function($) {
    dttable_list_do = $('#list-do-table').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('branch-manifest/' . $manifestHeader->do_manifest_no . '/list-do') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [3, 'asc'],
    columns: [
        {
          data: 'DT_RowIndex',
          orderable: false,
          render: function ( data, type, row ) {
              if ( type === 'display' ) {
                  return '<label><input type="checkbox" name="id[]" value="" class="checkbox"><span></span></label>';
              }
              return data;
          },
          className: "datatable-checkbox-cell"
        },
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'invoice_no', name: 'invoice_no', className: 'detail'},
        {data: 'delivery_no', name: 'delivery_no', className: 'detail'},
        {data: 'do_internal', name: 'do_internal', className: 'detail'},
        {data: 'ship_to', name: 'ship_to', className: 'detail'},
        {data: 'delivery_items', name: 'delivery_items', className: 'detail'},
        {data: 'model', name: 'model', className: 'detail'},
        {data: 'quantity', name: 'quantity', className: 'detail'},
        {data: 'desc', name: 'desc', className: 'detail'},
        {data: 'status_confirm', name: 'status_confirm', className: 'detail'},
        {data: 'ship_to_code', name: 'ship_to_code', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
      ],
    });

    set_datatables_checkbox('#list-do-table', dttable_list_do)

    $('.btn-multi-delete-selected-item').click(function(event) {
      /* Act on the event */
      swal({
        title: "Are you sure?",
        text: "Are you sure delete selected item?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        var data_list_do = [];
        dttable_list_do.$('input[type="checkbox"]').each(function() {
           /* iterate through array or object */
           if(this.checked){
            var row = $(this).closest('tr');
            var row_data = dttable_list_do.row(row).data();
            data_list_do.push(row_data);
           }
        });
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '{{ url('branch-manifest/delete-selected-do') }}' ,
            type: 'DELETE',
            data: 'data_list_do=' + JSON.stringify(data_list_do),
          })
          .done(function() { // Kalau ajax nya success
            showSwalAutoClose('Success', 'selected data deleted.')
            setTimeout(function(){ location.reload() }, 2000);
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
    });

    $('#list-do-table').on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
       var tr = $(this).parent().parent();
      var data = dttable_list_do.row(tr).data();
      swal({
          text: "Are you sure delete this line?",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, Delete It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) { // Bila oke post ajax ke url delete nya
            // Ajax Post Delete
            $.ajax({
              url: '{{url('branch-manifest/' . $manifestHeader->do_manifest_no )}}' + '/details/' + data.id,
              type: 'DELETE',
            })
            .done(function() { // Kalau ajax nya success
              showSwalAutoClose('Success', 'detail deleted.')
              window.location.href = '{{url('branch-manifest/' . $manifestHeader->do_manifest_no . '/edit')}}'
            })
            .fail(function() { // Kalau ajax nya gagal
              console.log("error");
            });

          }
        })
    });
  });
</script>
@endpush