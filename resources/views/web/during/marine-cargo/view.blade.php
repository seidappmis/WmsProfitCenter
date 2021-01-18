@extends('layouts.materialize.index')

@section('content')
<div class="row">

   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m6">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Marine Cargo</span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/marine-cargo') }}">Marine Cargo</a></li>
            <li class="breadcrumb-item active">New Marine Cargo</li>
         </ol>
      </div>
   </div>
   @endcomponent

   <div class="col s12">
      <div class="container">
         <div class="section">
            <div class="card">
               <div class="card-header pl-1">

               </div>
               <div class="card-content">
                  <h4 class="card-title">
                     <strong>MARINE CARGO</strong>
                  </h4>
                  <hr>
                  <form class="form-table" id="form-marine-cargo">
                     @include('web.during.marine-cargo._form')
                     {!! get_button_cancel(url('marine-cargo'), 'Back') !!}
                     <button type="button" class="waves-effect waves-light indigo btn-small btn-save mt-2 form-berita-acara-detail-wrapper hide" style="display: none;" id="btn-update">Update</button>
                  </form>
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
   $(document).ready(function(){
      $('#form-marine-cargo [name="insurance_policy_no"]').val('{{ $marineCargo->insurance_policy_no }}').attr('readonly','readonly');
      $('#form-marine-cargo [name="vessel_name"]').val('{{ $marineCargo->vessel_name }}').attr('readonly','readonly');
      $('#form-marine-cargo [name="sailed_on"]').val('{{ $marineCargo->sailed_on }}').attr('readonly','readonly');
      $('#form-marine-cargo [name="sailed_date"]').val('{{ $marineCargo->sailed_date }}').attr('readonly','readonly');
      $('#form-marine-cargo [name="arrived_date"]').val('{{ $marineCargo->arrived_date }}').attr('readonly','readonly');
      $('#form-marine-cargo [name="discharging_date"]').val('{{ $marineCargo->discharging_date }}').attr('readonly','readonly');
      $('#form-marine-cargo [name="delivery_date"]').val('{{ $marineCargo->delivery_date }}').attr('readonly','readonly');
      $('#form-marine-cargo [name="cargo_description"]').val('{{ $marineCargo->cargo_description }}').attr('readonly','readonly');
      $('#form-marine-cargo [name="qty"]').val('{{ $marineCargo->qty }}').attr('readonly','readonly');
      set_select2_value('#form-marine-cargo [name="dur_dgr_id"]', '{{ $marineCargo->dur_dgr_id }}', '{{ $marineCargo->dgr->dgr_no }}')
      $('#form-marine-cargo [name="dur_dgr_id"]').attr('disabled', 'disabled');
   })
</script>
@endpush