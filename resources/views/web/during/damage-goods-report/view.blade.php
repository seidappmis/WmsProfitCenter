@extends('layouts.materialize.index')

@section('content')
<div class="row">


   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m6">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Damage Goods Report</span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('damage-goods-report') }}">Damage Goods Report</a></li>
            <li class="breadcrumb-item active">{{ $dgr->dgr_no }}</li>
         </ol>
      </div>
   </div>
   @endcomponent

   <div class="col s12">
      <div class="container">
         <div class="section">
            <div class="card">
               <div class="card-content pl-1 pr-1 pt-1 pb-1">
               asfd
               </div>
               <div class="card-content p-0">
                  <div class="section-data-tables">
                     <table id="detail-data" class="display" width="100%">
                        <thead>
                           <tr>
                              <th><strong>NO</strong></th>
                              <th><strong>DATE</strong></th>
                              <th><strong>NO. BERITA ACARA</strong></th>
                              <th><strong>INVOICE NO</strong></th>
                              <th><strong>B/L NO</strong></th>
                              <th><strong>CONTAINER NO</strong></th>
                              <th><strong>MODEL</strong></th>
                              <th><strong>POM</strong></th>
                              <th><strong>QTY</strong></th>
                              <th><strong>NO. SERI</strong></th>
                              <th><strong>REMARKS</strong></th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>
@endsection



@push('script_js')
<script type="text/javascript">
   
</script>
@endpush