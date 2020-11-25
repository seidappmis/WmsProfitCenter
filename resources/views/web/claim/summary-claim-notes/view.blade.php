@extends('layouts.materialize.index')

@section('content')
<div class="row">
   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m10">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Detail Claim Note {{$claimNote->claim_note_no}}</span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('summary-claim-notes') }}">Summary Claim Notes</a></li>
            <li class="breadcrumb-item active">Detail Summary Claim Note {{$claimNote->claim_note_no}}</li>
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
                     <div class="collapsible-header p-0">
                        <div class="row">
                           <div class="col s12 m8">
                              <div class="collapsible-main-header">
                                 <i class="material-icons expand">expand_less</i>
                                 <span>Berita Acara Detail</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="collapsible-body white p-0">
                        <a class="waves-effect waves-light btn btn-small indigo darken-4 mt-2 ml-2 mb-2" href="{{ url('summary-claim-notes') }}">Back</a>
                        <div class="section-data-tables">
                           <div class="pl-2 pr-2 pb-2">
                              <table id="table-claim-notes" class="bordered striped" width="100%">
                                 <thead>
                                    <tr>
                                       <th data-priority="1" width="30px">No.</th>
                                       <th>Berita Acara</th>
                                       <th>Expediton Name</th>
                                       <th>Driver</th>
                                       <th>Car No</th>
                                       <th>DO NO</th>
                                       <th>Model</th>
                                       <th>Serial No</th>
                                       <th>Damage Description</th>
                                       <th>Destination</th>
                                       <th>Warehouse</th>
                                       <th>Photo</th>
                                       <th>Qty</th>
                                       <th>Price {{ ($claimNote->claim == 'unit') ? '(condition)' : '' }}</th>
                                       @if($claimNote->claim == 'unit')
                                       <th>Price</th>
                                       @endif
                                       <th>Total</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
            <!-- </div> -->
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

@php $claimType=$claimNote->claim;@endphp
<script type="text/javascript">
   jQuery(document).ready(function() {
      $('.mask-currency').inputmask('currency');

   });

   var dtdatatable_claim_note = $('#table-claim-notes').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: false,
      paging: false,
      ajax: {
         url: '{{url("claim-notes/".$claimNote->id."/list-claim-notes")}}',
         type: 'GET',
      },
      columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            className: 'center-align'
         }, {
            data: 'berita_acara_no',
            name: 'berita_acara_no',
            className: 'detail'
         }, {
            data: 'expedition_name',
            name: 'expedition_name',
            className: 'detail'
         }, {
            data: 'driver_name',
            name: 'driver_name',
            className: 'detail'
         }, {
            data: 'vehicle_number',
            name: 'vehicle_number',
            className: 'detail'
         }, {
            data: 'do_no',
            name: 'do_no',
            className: 'center-align'
         }, {
            data: 'model_name',
            name: 'model_name',
            className: 'center-align'
         }, {
            data: 'serial_number',
            name: 'serial_number',
            className: 'center-align',
            render: function(data, type, row) {
               return data ? data.split(",").join("<br>") : '';
            }
         }, {
            data: 'description',
            name: 'description',
            className: 'center-align'
         },
         {
            data: 'destination',
            name: 'destination',
            className: 'center-align',
            render: function(data, type, row, meta) {
               var val = data;
               return val;
            }
         },
         {
            data: 'warehouse',
            name: 'warehouse',
            className: 'center-align',
            render: function(data, type, row, meta) {
               var val = data;
               return val;
            }
         },
         {
            data: 'photo_url',
            orderable: false,
            render: function(data, type, row) {
               if (data) {
                  return '<img class="materialboxed center-align" width="200" height="200" src="' + "{{asset('storage/')}}/" + data + '">';
               }
               return '-';
            },
            className: "center-align"
         }, {
            data: 'qty',
            name: 'qty',
            className: 'center-align',
            render: function(data, type, row, meta) {
               var val = data;
               return val;
            }
         },
         {
            data: 'price',
            name: 'price',
            render: function(data, type, row, meta) {
               var val = format_currency(data);
               return val;
            },
            className: 'center-align'
         },
         @if($claimType == 'unit') {
            data: 'claim_note_detail',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
               return '<tag class="price-10"> ' + format_currency((row.price * 110 / 100));
            },
            className: "center-align"
         },
         @endif {
            data: 'claim_note_detail',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
               @if($claimType == 'unit')
               return '<tag class="sub-total"> ' + format_currency(row.qty * (row.price * 110 / 100));
               @else
               return '<tag class="sub-total"> ' + format_currency(row.qty * row.price);
               @endif
            },
            className: "center-align"
         }
      ]
   });
   // convert to format currency
   function format_currency(nStr) {
      if (nStr === null) return 'Rp. ' + '0,00';
      nStr += '';
      x = nStr.split(',');
      x1 = x[0];
      x2 = x.length > 1 ? ',' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
         x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return 'Rp. ' + x1 + x2;
   }

   $('.collapsible').collapsible({
      accordion: true
   });
</script>
@endpush