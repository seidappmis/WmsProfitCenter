<br>
<h6>Total Manifest: 1</h6>
<h5 class="card-title">List DO</h5>
<hr>
<div class="section-data-tables"> 
  <table id="data_manifest_normal_table" class="display" width="100%">
    <thead>
      <tr>
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
      @foreach($manifestHeader->details AS $key => $manifestDetail)
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
      @endforeach
    </tbody>
  </table>
</div>
  <!-- datatable ends -->

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#data_manifest_normal_table').on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      var id = $(this).parent().find('[name=id]').val()
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
              url: '{{url('branch-manifest/' . $manifestHeader->do_manifest_no )}}' + '/details/' + id,
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