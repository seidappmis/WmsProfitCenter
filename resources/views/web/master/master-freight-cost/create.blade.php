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
                      <h4 class="card-title">Add Freight Cost</h4>
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
      // Hide row
      $('#table-freight-cost tr:has(td.destination_city)').hide();
      $('#table-freight-cost tr:has(td.expedition)').hide();
      $('#table-freight-cost tr:has(td.vehicle_type)').hide();

      // Loading area data
      

      // Area data selected
      $('#area').change(function() {
        if ($("#area option:selected")) {
          $('#table-freight-cost tr:has(td.destination_city)').show();
          $('#table-freight-cost tr:has(td.expedition)').hide();
          $('#table-freight-cost tr:has(td.vehicle_type)').hide();
        }
      });

      // Destination city data selected
      $('#city_code').change(function() {
        if ($("#city_code option:selected")) {
          $('#table-freight-cost tr:has(td.expedition)').show();
          $('#table-freight-cost tr:has(td.vehicle_type)').hide();
        }
      });

      // Expedition data selected
      $('#expedition_code').change(function() {
        if ($("#expedition_code option:selected")) {
          $('#table-freight-cost tr:has(td.vehicle_type)').show();
        }
      });

      // Checkbox ambil sendiri
      
   });
</script>
@endpush