@extends('layouts.materialize.index')

@section('content')
<div class="row">
   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m10">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Detail Damage Goods Report </span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('summary-claim-notes') }}">Summary Damage Goods Reports</a></li>
            <li class="breadcrumb-item active">No: {{$dgr->dgr_no}}</li>
         </ol>
      </div>
   </div>
   @endcomponent

   <div class="col s12">
      <div class="container">
         <div class="section">
            <div class="card">
               <div class="card-content">
                  <table id="table-summary" class="display" width="100%">
                     <thead>
                        <tr>
                           <th class="center-align" width="30px"></th>
                           <th class="center-align">No Doc</th>
                           <th class="center-align">Berita Acara No.</th>
                           <th class="center-align">Invoice No</th>
                           <th class="center-align">B/L No</th>
                           <th class="center-align">Container No</th>
                           <th class="center-align">Vendor</th>
                           <th class="center-align">Model</th>
                           <th class="center-align">Qty</th>
                           <th class="center-align">No Seri</th>
                           <th class="center-align">Keterangan</th>
                           <th class="center-align">Claim</th>
                           <th class="center-align">Remarks</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
                  <a class="waves-effect waves-light btn btn-small indigo darken-4 mt-2" href="{{ url('summary-damage-goods-report') }}">Back</a>
                  {!! get_button_view('#', 'Save', 'btn-save mt-2') !!}
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

@php $claimType=$dgr->claim;@endphp
<script type="text/javascript">
   jQuery(document).ready(function() {

      dtSummary = $('#table-summary').DataTable({
         serverSide: true,
         scrollX: true,
         bFilter: false,
         bLengthChange: false,
         bPaginate: false,
         ajax: {
            url: '{{url("summary-damage-goods-report/:id")}}'.replace(':id', "{{$dgr->id}}"),
            type: 'GET',
         },
         columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            className: 'center-align'
         }, {
            data: 'dgr_no',
            name: 'n.dgr_no',
            className: 'detail'
         }, {
            data: 'berita_acara_during_no',
            name: 'ba.berita_acara_during_no',
            className: 'detail',
            // searchable: false,
            render: function(data, type, row, meta) {
               return data ? data.split("|").join("<br>") : '';
            }
         }, {
            data: 'invoice_no',
            name: 'ba.invoice_no',
            className: 'detail',
            // searchable: false,
            render: function(data, type, row, meta) {
               return data ? data.split("|").join("<br>") : '';
            }
         }, {
            data: 'bl_no',
            name: 'ba.bl_no',
            className: 'detail',
            // searchable: false,
            render: function(data, type, row, meta) {
               return data ? data.split("|").join("<br>") : '';
            }
         }, {
            data: 'container_no',
            name: 'ba.container_no',
            className: 'detail',
            // searchable: false,
            render: function(data, type, row, meta) {
               return data ? data.split("|").join("<br>") : '';
            }
         }, {
            data: 'expedition_name',
            name: 'e.expedition_name',
            searchable: false,
            className: 'detail',
            render: function(data, type, row, meta) {
               return data ? data.split("|").join("<br>") : '';
            }
         }, {
            data: 'model_name',
            name: 'bad.model_name',
            searchable: false,
            className: 'detail',
            render: function(data, type, row, meta) {
               return data ? data.split("|").join("<br>") : '';
            }
         }, {
            data: 'qty',
            name: 'bad.qty',
            className: 'detail',
            // render: function(data, type, row) {
            //    return moment(data).format('D MMM YYYY');
            // }
         }, {
            data: 'serial_number',
            name: 'bad.serial_number',
            searchable: false,
            className: 'detail',
            render: function(data, type, row, meta) {
               return data ? data.split(",").join("<br>") : '';
            }
         }, {
            data: 'category_damage',
            name: 'bad.category_damage ',
            searchable: false,
            render: function(data, type, row, meta) {
               val = `
                  <select class="select2-data-ajax browser-default category_damage" data-id="` + row.id + `" style="margin-right:100px;">
                     <option value=""></option>
                     <option value="Carton Box Damage"` + (data == 'Carton Box Damage' ? 'selected' : '') + `>Carton Box Damage</option>
                     <option value="Unit Damage"` + (data == 'Unit Damage' ? 'selected' : '') + `>Unit Damage</option>
                  </select>`;
               return val;
            }
         }, {
            data: 'claim',
            name: 'bad.claim',
            searchable: false,
            className: 'detail center-align',
            render: function(data, type, row, meta) {
               val = '<textarea class="claim materialize-textarea" placeholder="Remarks" style="width:300px;height:100px;resize: vertical;" data-id="' + row.claim_note_detail + '">' + (data ? data : '') + '</textarea>';
               return val;
            }
         }, {
            data: 'damage',
            name: 'bad.damage',
            searchable: false,
            className: 'detail',
            render: function(data, type, row, meta) {
               val = '<textarea class="damage materialize-textarea" placeholder="Remarks" style="width:300px;height:100px;resize: vertical;" data-id="' + row.claim_note_detail + '">' + (data ? data : '') + '</textarea>';
               return val;
            }
         }]
      });
   });

   $('.btn-save').click(function(e) {
      e.preventDefault();

      var array = $();

      $('#table-summary .category_damage').each(function() {
         var input = $(this),
            td = input.parent(),
            tr = td.parent(),
            id = input.attr('data-id');

         if (typeof array[id] === 'undefined') {
            array[id] = {
               category_damage: tr.find('.category_damage').val(),
               claim: tr.find('.claim').val(),
               damage: tr.find('.damage').val()
            }
         }
      });

      setLoading(true);
      $.ajax({
            type: "PUT",
            url: '{{url("summary-damage-goods-report/:id")}}'.replace(':id', "{{$dgr->id}}"),
            data: {
               data: JSON.stringify(array),
            },
            cache: false,
         })
         .done(function(result) {
            if (result.status) {
               swal("Success!", result.message)
                  .then((response) => {
                     // Kalau klik Ok redirect ke view
                     dtdatatable_claim_note.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                  }) // alert success
            } else {
               setLoading(false);
               showSwalAutoClose('Warning', result.message)
            }
         })
         .fail(function() {
            setLoading(false);
         })
         .always(function() {
            setLoading(false);
         });
   });
</script>
@endpush