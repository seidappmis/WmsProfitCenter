@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Vehicle</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item">Master Vehicle</li>
                    <li class="breadcrumb-item active">Create Detail</li>
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
                                <form class="form-table" id="form-vehicle-group">
                                  <table>
                                      <tr>
                                          <td>VEHICLE GROUP CATEGORY</td>
                                          <td>
                                              <input id="group_name" 
                                              type="text" 
                                              class="validate"
                                              name="group_name"
                                              value="{{old('group_name', !empty($vehicleGroup) ? $vehicleGroup->group_name : '')}}">
                                          </td>
                                      </tr>
                                  </table>
                                  {!! get_button_save('Update') !!}
                                  {!! get_button_cancel(url('master-vehicle'), 'Back') !!}
                              </form>
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
                                 @include('web.master.master-vehicle.detail._form')
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
    $("#form-vehicle-detail").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("master-vehicle/" . $vehicleGroup->id . "/detail") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke view
              window.location.href = "{{ url('master-vehicle/' . $vehicleGroup->id . '/detail') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush