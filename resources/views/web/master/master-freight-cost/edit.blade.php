@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6 mb-1">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Freight Cost</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Freight Cost</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card-content p-0">
                <ul class="collapsible">
                  <li>
                    <div class="collapsible-header">UPLOAD DATA</div>
                    <div class="collapsible-body white">
                      @include('web.master.master-freight-cost.upload._form')
                    </div>
                  </li>
                </ul>
                </div>
                <div class="card">
                    <div class="card-content">
                      <h4 class="card-title">Edit Freight Cost</h4>
                         @include('web.master.master-freight-cost._form')
                    </div>
                </div>
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
    set_initial_form_data();
    set_format_data();
    $('.btn-save').html('Update');
  });

  function set_initial_form_data(){
    set_select2_value('#area', '{{$masterFreight->area}}', '{{$masterFreight->Area->area}}')
    set_select2_value('#city_code', '{{$masterFreight->city_code}}', '{{$masterFreight->DestinationCity->city_name}}')
    set_select2_value('#expedition_code', '{{$masterFreight->expedition_code}}', '{{$masterFreight->MasterExpedition->expedition_name}}')
    set_select2_value('#vehicle_code_type', '{{$masterFreight->vehicle_code_type}}', '{{$masterFreight->VehicleDetail->vehicle_desription}}')
  };

  function set_format_data(){
    thousand_reformat('{{$masterFreight->ritase}}')
  };

  $("#form-master-freight").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("master-freight-cost/" . $masterFreight->id) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => { 
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('master-freight-cost') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush