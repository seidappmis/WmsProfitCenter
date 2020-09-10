<br>
<h6>Total Manifest: 1</h6>
<h5 class="card-title">List DO</h5>
<hr>
<a href="#modal-upload-do" class="waves-effect waves-light indigo btn-small modal-trigger mb-1">Upload DO</a>
@include('web.outgoing.manifest-regular.modal_upload_do')
<a href="#modal-upload-return" class="waves-effect waves-light indigo btn-small modal-trigger mb-1">Upload Return</a>
@include('web.outgoing.manifest-regular.modal_upload_return')
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
        {{-- <th>Status</th> --}}
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
        <td>{{ $manifestDetail->getDesc() }}</td>
        {{-- <td>{{ $manifestDetail->status }}</td> --}}
        <td>{{ $manifestDetail->ship_to_code }}</td>
        <td>{!! get_button_delete() !!}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
  <!-- datatable ends -->