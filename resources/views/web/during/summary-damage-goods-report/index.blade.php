@extends('layouts.materialize.index')

@section('content')
<div class="row">


   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m6">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Damage Goods Report</span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Summary Damage Goods Report</li>
         </ol>
      </div>
   </div>
   @endcomponent

   <div class="col s12" id="body">
      <div class="container">

         <div class="row">
            <div class="col s12 m8 mt-3">
               <div class="collapsible-main-header">
                  <button class="waves-effect waves-light indigo btn " id="btn-download-excel"><i class="material-icons left">file_download</i>Excel</button>
               </div>
            </div>
            <div class="col s12 m4  mt-2">
               <div class="app-wrapper">
                  <div class="datatable-search mb-0">
                     <i class="material-icons mr-2 search-icon">search</i>
                     <input type="text" placeholder="Search" class="app-filter no-propagation" id="outstanding-search">
                  </div>
               </div>
            </div>
         </div>

         <div class="section">
            <div class="card mb-0">
               <div class="card-content p-0">
                  <div class="section-data-tables">
                     <table id="table-summary" class="display" width="100%">
                        <thead>
                           <tr>
                              <th class="center-align" data-priority="1" width="30px"><label><input type="checkbox" class="select-all" /><span></span></label></th>
                              <th class="center-align">No Doc</th>
                              {{-- <th class="center-align">Berita Acara No.</th> --}}
                              <th class="center-align">Invoice No</th>
                              <th class="center-align">B/L No</th>
                              {{-- <th class="center-align">Container No</th> --}}
                              <th class="center-align">Vendor</th>
                              <th class="center-align">Model</th>
                              <th class="center-align">Qty</th>
                              <th class="center-align">NO Serie</th>
                              <th class="center-align">Keterangan</th>
                              {{-- <th class="center-align">Claim</th> --}}
                              <th class="center-align">Remarks</th>
                              <th class="center-align"></th>
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
@push('script_js')

<script type="text/javascript">
   jQuery(document).ready(function($) {
      dtSummary = $('#table-summary').DataTable({
         serverSide: true,
         scrollX: true,
         ajax: {
            url: '{{url("summary-damage-goods-report")}}',
            type: 'GET',
         },
         columns: [{
               data: 'id',
               orderable: false,
               searchable: false,
               render: function(data, type, row) {
                  return '<label><input type="checkbox" name="outstanding[]" value="' + data + '" class="checkbox checkbox-outstanding"><span></span></label>';
               },
               className: "datatable-checkbox-cell"
            }, {
               data: 'dgr_no',
               name: 'n.dgr_no',
               className: 'detail'
            },
            {
               data: 'berita_acara_group',
               name: 'ba.berita_acara_during_no',
               className: 'detail',
               // searchable: false,
               render: function(data, type, row, meta) {
                  return data ? data.split("|").join("<br>") : '';
               }
            },
            // {
            //    data: 'invoice_group',
            //    name: 'ba.invoice_no',
            //    className: 'detail',
            //    // searchable: false,
            //    render: function(data, type, row, meta) {
            //       return data ? data.split("|").join("<br>") : '';
            //    }
            // }, 
            {
               data: 'bl_group',
               name: 'ba.bl_no',
               className: 'detail',
               // searchable: false,
               render: function(data, type, row, meta) {
                  return data ? data.split("|").join("<br>") : '';
               }
            },
            // {
            //    data: 'container_group',
            //    name: 'ba.container_no',
            //    className: 'detail',
            //    // searchable: false,
            //    render: function(data, type, row, meta) {
            //       return data ? data.split("|").join("<br>") : '';
            //    }
            // }, 
            {
               data: 'vendor',
               name: 'vendor',
               searchable: false,
               className: 'detail',
               render: function(data, type, row, meta) {
                  return data ? data.split("|").join("<br>") : '';
               }
            }, {
               data: 'model_group',
               name: 'bad.model_name',
               searchable: false,
               className: 'detail',
               render: function(data, type, row, meta) {
                  return data ? data.split("|").join("<br>") : '';
               }
            }, {
               data: 'sum_qty',
               name: 'sum_qty',
               className: 'detail',
               // render: function(data, type, row) {
               //    return moment(data).format('D MMM YYYY');
               // }
            }, {
               data: 'serial_number_group',
               name: 'bad.serial_number',
               searchable: false,
               className: 'detail',
               render: function(data, type, row, meta) {
                  return data ? data.split(",").join("<br>") : '';
               }
            }, {
               data: 'keterangan_group',
               name: 'ba.category_damage ',
               searchable: false,
               className: 'detail',
               render: function(data, type, row, meta) {
                  return data ? data.split("|").join("<br>") : '';
               }
            },
            // {
            //    data: 'claim_group',
            //    name: 'bad.claim',
            //    searchable: false,
            //    className: 'detail',
            //    render: function(data, type, row, meta) {
            //       return data ? data.split("|").join("<br>") : '';
            //    }
            // }, 
            {
               data: 'remark_group',
               name: 'bad.damage',
               searchable: false,
               className: 'detail',
               render: function(data, type, row, meta) {
                  return data ? data.split("|").join("<br>") : '';
               }
            }, {
               data: 'id',
               orderable: false,
               searchable: false,
               render: function(data, type, row, meta) {
                  return '<?= get_button_view() ?>';
               },
               className: "center-align"
            }
         ]
      });

      set_datatables_checkbox('#table-summary', dtSummary);

      dtSummary.on('click', '.btn-view', function(event) {
         event.preventDefault();
         /* Act on the event */
         var tr = $(this).parent().parent();
         var data = dtSummary.row(tr).data();
         window.location.href = '{{url("summary-damage-goods-report/{id}")}}'.replace('{id}', data.id);
      });
   });

   $('#btn-download-excel').click(function() {

      // var checkedData = $();
      var url = "{{url('summary-damage-goods-report/0/export')}}" + '?file_type=excel',
         data = '';
      $('#table-summary tbody input[type=checkbox]:checked').each(function() {
         var row = dtSummary.row($(this).parents('tr')).data(); // here is the change
         // array = generateArray(row, 'carton-box');
         data += '&data[]=' + row.id;
      });

      if (!data) {
         showSwalAutoClose("Error", 'No selected data');
         return;
      }
      window.location.href = url + data;
   });
</script>
@endpush


</div>
@endsection