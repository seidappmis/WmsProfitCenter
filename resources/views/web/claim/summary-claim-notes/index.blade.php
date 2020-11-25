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
      <div class="col s12 m3">
      </div>
   </div>
   @endcomponent

   <div class="col s12">
      <div class="container">
         <div class="section">
            <div class="card mb-0">
               <div class="card-content p-0">
                  <ul class="collapsible m-0">
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
                           <div class="section-data-tables">
                              <table id="data-table" class="display" width="100%">
                                 <thead>
                                    <tr>
                                       <th rowspan="2" class="center-align" data-priority="1" width="30px">No</th>
                                       <th rowspan="2" class="center-align">Berita Acara No.</th>
                                       <th rowspan="2" class="center-align">Claim Note</th>
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
                                       <th class="center-align">DN Issue Date</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table><input type="text" class="datepicker">
                           </div>
                        </div>
                     </li>
                  </ul>
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
               data: 'DT_RowIndex',
               orderable: false,
               searchable: false,
               className: 'center-align'
            },
            {
               data: 'berita_acara_group',
               render: function(data, type, row) {
                  return data ? data.split(",").join("<br>") : '';
               }

            },
            {
               data: 'claim_note_no'
            },
            {
               data: 'total',
               render: function(data, type, row) {
                  return format_currency(data);
               },
               className: 'right-align'
            },
            {
               data: 'send_to_management',
               render: function(data, type, row) {
                  return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="send_to_management" class="datepicker">';
               }
            },
            {
               data: 'approval_start_date',
               render: function(data, type, row) {
                  return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="approval_start_date" class="datepicker">';
               }
            },
            {
               data: 'approval_finish_date',
               render: function(data, type, row) {
                  return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="approval_finish_date" class="datepicker">';
               }
            },
            {
               data: 'so_issue_date',
               render: function(data, type, row) {
                  return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="so_issue_date" class="datepicker">';
               }
            },
            {
               data: 'date_picking_expedition',
               render: function(data, type, row) {
                  return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="date_picking_expedition" class="datepicker">';
               }
            },
            {
               data: 'dn_issue_date',
               render: function(data, type, row) {
                  return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="dn_issue_date" class="datepicker">';
               }
            },
            {
               data: 'remarks',
               render: function(data, type, row) {
                  return '<textarea name="remarks" style="resize: vertical;" cols="30" rows="10">' + (data ? data : '') + '</textarea>';
               }
            },
            {
               data: 'id',
               className: 'center-align',
               render: function(data, type, row, meta) {
                  return ' ' + '<?= get_button_save() ?>' + ' ' + '<?= get_button_view(url("summary-claim-notes/:id")) ?>'.replace(':id', data);
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
                        dn_issue_date: tr.find('[name="dn_issue_date"]').val(),
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
         if (nStr === null || isNaN(nStr)) return '0,00';
         nStr += '';
         x = nStr.split(',');
         x1 = x[0];
         x2 = x.length > 1 ? ',' + x[1] : '';
         var rgx = /(\d+)(\d{3})/;
         while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
         }
         return +x1 + x2;
      }
   </script>
   @endpush


</div>
@endsection