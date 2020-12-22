@extends('layouts.materialize.index')

@section('content')
<div class="row">

   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m6">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Claim Notes</span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Claim Notes</li>
         </ol>
      </div>
      <div class="col s12 m6">
         <div class="app-wrapper">
            <div class="datatable-search mb-0">
               <i class="material-icons mr-2 search-icon">search</i>
               <input type="text" placeholder="Search" class="app-filter no-propagation" id="outstanding-search">
            </div>
         </div>
      </div>
   </div>
   @endcomponent

   <div class="col s12 pt-3">
      <div class="container">
         <button class="waves-effect waves-light indigo btn " id="btn-download-excel"><i class="material-icons left">file_download</i>Excel</button>
         <div class="section">
            <div class="card mb-0">
               <div class="card-content p-0" id="body">
                  <div class="section-data-tables">
                     <table id="data-table" class="display" width="100%">
                        <thead>
                           <tr>
                              <th rowspan="2" class="center-align" data-priority="1" width="30px"><label><input type="checkbox" class="select-all" /><span></span></label></th>
                              <th rowspan="2" class="center-align">Berita Acara No.</th>
                              <th rowspan="2" class="center-align">Claim Note</th>
                              <th rowspan="2" class="center-align">Date Of Incident</th>
                              <th rowspan="2" class="center-align">Reporting Date</th>
                              <th rowspan="2" class="center-align">Expedition Name</th>
                              <th rowspan="2" class="center-align">Driver</th>
                              <th rowspan="2" class="center-align">Vehicle No</th>
                              <th rowspan="2" class="center-align">Destination</th>
                              <th rowspan="2" class="center-align">Do No</th>
                              <th rowspan="2" class="center-align">Model</th>
                              <th rowspan="2" class="center-align">Serial No</th>
                              <th rowspan="2" class="center-align">Qty</th>
                              <th rowspan="2" class="center-align">Damage Descritption</th>
                              <th rowspan="2" class="center-align">Claim</th>
                              <th rowspan="2" class="center-align">Price</th>
                              <th rowspan="2" class="center-align">Total</th>
                              <th rowspan="2" class="center-align">Send to Management</th>
                              <th colspan="2" class="center-align">Approval Date</th>
                              <th class="center-align">Admin Process</th>
                              <th rowspan="2" class="center-align">Date Picking Expedition</th>
                              <th class="center-align">Admin Process</th>
                              <th rowspan="2" class="center-align">Remarks</th>
                              <th rowspan="2" class="center-align">Action</th>
                           </tr>
                           <tr>
                              <th class="center-align">Start</th>
                              <th class="center-align">Finish</th>
                              <th class="center-align">SO Issue Date</th>
                              <th class="center-align">DN Issue</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
                  {{-- <ul class="collapsible m-0">
                     <li class="active">
                        <div class="collapsible-header p-0">
                           <div class="row">
                              <div class="col s12 m8">
                                 <div class="collapsible-main-header">
                                    <i class="material-icons expand">expand_less</i>
                                    <span>Outstanding</span>
                                 </div>
                              </div>
                              <div class="col s12 m4">
                                 <div class="app-wrapper">
                                    <div class="datatable-search mb-0">
                                       <i class="material-icons mr-2 search-icon">search</i>
                                       <input type="text" placeholder="Search" class="app-filter no-propagation" id="outstanding-search">
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="body p-0" id="body">
                           
                        </div>
                     </li>
                  </ul> --}}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@push('script_js')
<script type="text/javascript">
   dtOutstanding = $('#data-table').DataTable({
      paging: true,
      serverSide: true,
      scrollX: true,
      ajax: {
         url: '{{url("summary-claim-notes")}}',
         type: 'GET',
      },
      order: [1, 'asc'],
      columns: [{
               data: 'id',
               orderable: false,
               searchable: false,
               render: function(data, type, row) {
                  return '<label><input type="checkbox" name="outstanding[]" value="' + data + '" class="checkbox checkbox-outstanding"><span></span></label>';
               },
               className: "datatable-checkbox-cell"
         },
         {
            data: 'berita_acara_group',
            render: function(data, type, row) {
               return data ? data.split(",").join("<br>") : '';
            },
            name: ' bad.berita_acara_no'

         },
         {
            data: 'claim_note_no',
            name: ' n.claim_note_no'
         },
         {
            data: 'tanggal_kejadian',
            searchable: false,
            render: function(data, type, row) {
               return  (data ? moment(data).format('Y-M-DD') : '');
            },
            className: 'center-align'
         },
         {
            data: 'insurance_date',
            searchable: false,
            render: function(data, type, row) {
               return  (data ? moment(data).format('Y-M-DD') : '');
            },
            className: 'center-align'
         },
         {
            data: 'expedition_name',
            searchable: false,
         },
         {
            data: 'driver_name',
            searchable: false,
         },
         {
            data: 'vehicle_number',
            searchable: false,
         },
         {
            data: 'vehicle_number',
            searchable: false,
         },
         {
            data: 'do_no',
            searchable: false,
            render: function(data, type, row) {
               return data ? data.split(",").join("<br>") : '';
            },
         },
         {
            data: 'model_name',
            searchable: false,
            render: function(data, type, row) {
               return data ? data.split(",").join("<br>") : '';
            },
         },
         {
            data: 'serial_number',
            searchable: false,
            render: function(data, type, row) {
               return data ? data.split(",").join("<br>") : '';
            },
         },
         {
            data: 'sum_qty',
            searchable: false,
            className: 'right-align'
         },
         {
            data: 'description',
            searchable: false,
            render: function(data, type, row) {
               return data ? data.split(",").join("<br>") : '';
            },
         },
         {
            data: 'claim',
            searchable: false,
            render: function(data, type, row) {
               return data ? data.split(",").join("<br>") : '';
            },
         },
         {
            data: 'sum_price',
            searchable: false,
            render: function(data, type, row) {
               return format_currency(data);
            },
         },
         {
            data: 'sub_total',
            searchable: false,
            render: function(data, type, row) {
               return format_currency(data);
            },
            className: 'right-align'
         },
         {
            data: 'send_to_management',
            searchable: false,
            render: function(data, type, row) {
               @if(auth()->user()->allowTo('edit'))
               return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="send_to_management" class="datepicker">';
               @else
               return data ? moment(data).format('Y-M-DD') : '';
               @endif
            }
         },
         {
            data: 'approval_start_date',
            searchable: false,
            render: function(data, type, row) {
               @if(auth()->user()->allowTo('edit'))
               return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="approval_start_date" class="datepicker">';
               @else
               return data ? moment(data).format('Y-M-DD') : '';
               @endif
            }
         },
         {
            data: 'approval_finish_date',
            searchable: false,
            render: function(data, type, row) {
               @if(auth()->user()->allowTo('edit'))
               return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="approval_finish_date" class="datepicker">';
               @else
               return data ? moment(data).format('Y-M-DD') : '';
               @endif
            }
         },
         {
            data: 'so_issue_date',
            searchable: false,
            render: function(data, type, row) {
               @if(auth()->user()->allowTo('edit'))
               return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="so_issue_date" class="datepicker">';
               @else
               return data ? moment(data).format('Y-M-DD') : '';
               @endif
            }
         },
         {
            data: 'date_picking_expedition',
            searchable: false,
            render: function(data, type, row) {
               @if(auth()->user()->allowTo('edit'))
               return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="date_picking_expedition" class="datepicker">';
               @else
               return data ? moment(data).format('Y-M-DD') : '';
               @endif
            }
         },
         {
            data: 'dn_issue',
            searchable: false,
            render: function(data, type, row) {
               @if(auth()->user()->allowTo('edit'))
               return '<textarea name="dn_issue" style="resize: vertical;width:200px;height:50px;">' + (data ? data : '') + '</textarea>';
               @else
               return data;
               @endif
            }
         },
         {
            data: 'remarks',
            searchable: false,
            render: function(data, type, row) {
               @if(auth()->user()->allowTo('edit'))
               return '<textarea name="remarks" style="resize: vertical;width:200px;height:50px;">' + (data ? data : '') + '</textarea>';
               @else
               return data;
               @endif
            }
         },
         {
            data: 'id',
            className: 'center-align',
            searchable: false,
            render: function(data, type, row, meta) {
               var button = ' ' 
               @if(auth()->user()->allowTo('edit'))
               button += '<?= get_button_save() ?>' 
               @endif
               button += ' ' 
               button += '<?= get_button_view(url("summary-claim-notes/:id")) ?>'.replace(':id', data);

               return button;
            }
         },
      ],
      initComplete: function(settings, json) {
         $('.datepicker').datepicker({
            container: '#body',
            autoClose: true,
            format: 'yyyy-mm-dd'
         });
      }
   });
   jQuery(document).ready(function($) {

      set_datatables_checkbox('#data-table', dtOutstanding)

   });

   var setDatePicker = function() {
      $('.datepicker').datepicker({
         container: '#body',
         autoClose: true,
         format: 'yyyy-mm-dd'
      });
   };

   $("input#outstanding-search").on("keyup click", function() {
      dtOutstanding.search($("#outstanding-search").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
   });


   $('#btn-download-excel').click(function(){
      
      // var checkedData = $();
      var url = "{{url('summary-claim-notes/0/export')}}"+'?file_type=excel',
      data='';
      $('#data-table tbody input[type=checkbox]:checked').each(function() {
            var row = dtOutstanding.row($(this).parents('tr')).data(); // here is the change
            // array = generateArray(row, 'carton-box');
            data+='&data[]='+row.id;
      });
      
      if (!data) {
         showSwalAutoClose("Error",'No selected data');
         return;
      }
      window.location.href = url+data;
   });
            
   dtOutstanding.on('click', '.btn-save', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var tr = $(this).parent().parent();
      var data = dtOutstanding.row(tr).data();
      setLoading(true);
      swal({
         text: "Are you sure want to update " + data.berita_acara_no + " and the details?",
         icon: 'warning',
         buttons: {
            cancel: true,
            delete: 'Yes, Update It'
         }
      }).then(function(confirm) { // proses confirm
         if (confirm) {
            $.ajax({
                  url: "{{ url('summary-claim-notes') }}" + '/' + data.id,
                  type: 'PUT',
                  data: {
                     send_to_management: tr.find('[name="send_to_management"]').val(),
                     approval_start_date: tr.find('[name="approval_start_date"]').val(),
                     approval_finish_date: tr.find('[name="approval_finish_date"]').val(),
                     so_issue_date: tr.find('[name="so_issue_date"]').val(),
                     date_picking_expedition: tr.find('[name="date_picking_expedition"]').val(),
                     dn_issue: tr.find('[name="dn_issue"]').val(),
                     remarks: tr.find('[name="remarks"]').val(),
                  },
                  dataType: 'json',
               })
               .done(function(result) {
                  if (result.status) {
                     showSwalAutoClose("Success", "Berita Acara with Berita Acara No. " + data.claim_note_no + " has been deleted.")
                     dtOutstanding.ajax.reload(setDatePicker, false); // (null, false) => user paging is not reset on reload
                  }
                  setLoading(false);
               })
               .fail(function() {
                  showSwalAutoClose("Error")
                  setLoading(false);
               });
         }
      });
   });

   // convert to format currency
   function format_currency(nStr) {
      if (nStr === null || isNaN(nStr)) return 'Rp. 0,00';
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
</script>
@endpush


</div>
@endsection