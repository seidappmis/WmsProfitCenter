@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Claim Insurance</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('claim-insurance') }}">Claim Insurances</a></li>
                    <li class="breadcrumb-item active">Create Claim Insurance</li>
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
                             <div class="collapsible-header">Create Claim Insurance</div>
                             <div class="collapsible-body white pt-1 pb-1">
                                @include('web.claim.claim-notes._form_claim_note')
                             </div>
                           </li>
                        </ul>
                    </div>
                <!-- </div> -->
                    <div class="card-content">
                        <ul class="collapsible">
                           <li class="">
                               <div class="collapsible-header">Add New Detail</div>
                               <div class="collapsible-body white pt-1 pb-1">
                                 @include('web.claim.claim-notes._form_detail')
                               </div>
                           </li>
                        </ul>
                    </div>
                    <div class="card-content">
                        <ul class="collapsible">
                           <li class="active">
                               <div class="collapsible-header">Detail</div>
                               <div class="collapsible-body white pt-1 pb-1">
                                <table id="data-table-section-contents" class="display" width="100%">
                                  <thead>
                                      <tr>
                                        <th data-priority="1" width="30px">No.</th>
                                        <th>Berita Acara</th>
                                        <th>Expediton Name</th>
                                        <th>Driver</th>
                                        <th>Car No</th>
                                        <th>Destination</th>
                                        <th>DO NO</th>
                                        <th>Model</th>
                                        <th>Serial No</th>
                                        <th>Qty</th>
                                        <th>Location</th>
                                        <th>Damage Description</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th width="50px;"></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                              </table>
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

</script>
@endpush