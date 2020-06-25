@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Vehicle</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('master-vehicle') }}">Master Vehicle</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <!-- <div class="card"> -->
                    <div class="card-content">
                      <ul class="collapsible">
          						  <li class="active">
          							  <div class="collapsible-header">Edit Vehicle Group Category</div>
          							  <div class="collapsible-body white">
                            @include('web.master.master-vehicle.group._form')  
          							  </div>
          						  </li>
          						</ul>
                    </div>
                    <!-- </div> -->
                    <div class="card-content">
                        <ul class="collapsible">
                           <li class="active">
                               <div class="collapsible-header">Detail</div>
                               <div class="collapsible-body white">
                                <div class="row">
                                <a class="waves-effect waves-light indigo btn" href="{{ url('master-vehicle/' . $vehicleGroup->id . '/detail/create') }}">Add New Detail</a></div>
                                <div class="row">
                                    <div class="section-data-tables">
                                      <table id="data-table-vehicle-detail" class="display" width="100%">
                                          <thead>
                                              <tr>
                                                <th data-priority="1" width="30px">NO.</th>
                                                <th>CODE TYPE</th>
                                                <th>DESCRIPTION</th>
                                                <th>SAP DESCRIPTION</th>
                                                <th>CBM MIN</th>
                                                <th>CBM MAX</th>
                                                <th width="50px;"></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                      </table>
                                    </div>
                                    <!-- datatable ends -->
                                </div>
                               </div>
                           </li>
                        </ul>
                    </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
        $('.btn-save').html('Update');
    });

 	$('.collapsible').collapsible({
        accordion:true
    });

    // VEHICLE GROUP CATEGORY
    $("#form-vehicle-group").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("master-vehicle/" . $vehicleGroup->id) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          swal("Good job!", "Vehicle Group Category has been change", "success")
            .then((result) => { 
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('master-vehicle/' . $vehicleGroup->id . '/detail') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

    // DETAIL
    var table = $('#data-table-vehicle-detail').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
         ajax: {
            url: '{{ url('master-vehicle/'. $vehicleGroup->id . '/detail') }}',
            type: 'GET',
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'vehicle_code_type', name: 'vehicle_code_type', className: 'detail'},
            {data: 'vehicle_description', name: 'vehicle_description', className: 'detail'},
            {data: 'sap_description', name: 'sap_description', className: 'detail'},
            {data: 'cbm_min', name: 'cbm_min', className: 'detail'},
            {data: 'cbm_max', name: 'cbm_max', className: 'detail'},
            {data: 'action', className: 'center-align', searchable: false, orderable: false},
        ]
    });

    table.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = table.row(tr).data();

      // Ask user confirmation to delete the data.
      swal({
        text: "Delete Vehicle Code " + data.vehicle_code_type + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // if CONFIRMED send DELETE Request to endpoint
          $.ajax({
            url: '{{ url("master-vehicle/". $vehicleGroup->id . "/detail") }}' + '/' + data.id ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            swal("Good job!", "You clicked the button!", "success") // alert success
            table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            console.log("error");
          });
        }
      })
    });
</script>
@endpush