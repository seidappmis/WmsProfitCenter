@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m10">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>View Log Storage Inventory</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('storage-inventory-monitoring') }}">Storage Inventory Monitoring</a></li>
                    <li class="breadcrumb-item active">View Log</li>
                </ol>
            </div>
            <div class="col s12 m2">
              <div class="display-flex">
                @component('layouts.materialize.components.back-button')
                @endcomponent
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="storage-inventory-monitoring-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>MODEL NAME</th>
                                    <th>MOVEMENT TYPE</th>
                                    <th>STORAGE LOCATION FROM</th>
                                    <th>STORAGE LOCATION TO</th>
                                    <th>REF</th>
                                    <th>QTY</th>
                                    <th>CREATED DATE</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
jQuery(document).ready(function($) {
    dttable_storage_inventory_monitoring = $('#storage-inventory-monitoring-table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: '{{ url('storage-inventory-monitoring/' . $inventoryStorage->id) }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#storage-inventory-monitoring-filter').val()
            }
      },
      order: [7, 'desc'],
      columns: [
          {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'model', className: 'detail'},
          {data: 'movement_code', className: 'detail'},
          {data: 'storage_location_from', className: 'detail'},
          {data: 'storage_location_to', className: 'detail'},
          {data: 'ref', className: 'detail'},
          {data: 'quantity', name: 'quantity', className: 'detail'},
          {data: 'created_at', name: 'created_at', className: 'detail'},
      ],
      "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
        if (aData.movement_action == "DECREASE") {
            $('td', nRow).css('background-color', '#FFBACB');
          }
        }
    });
  });
</script>
@endpush