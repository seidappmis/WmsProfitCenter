@extends('layouts.materialize.index')

@section('content')
<div class="row">

   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m6">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Claim Insurance</span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Claim Insurance</li>
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

   <div class="col s12" id="body">
      <div class="container">
         <div class="section">
            <div class="card mb-0">
               <div class="card-content p-0">
                  <div class="section-data-tables">
                     <table id="data-table" class="display" width="100%">
                        <thead>
                           <tr>
                              <th class="center-align" data-priority="1" width="30px">No</th>
                              <th class="center-align">Berita Acara No.</th>
                              <th class="center-align">Insurance Date</th>
                              <th class="center-align">Total</th>
                              <th class="center-align">Payment Date</th>
                              <th class="center-align">Remark</th>
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
   dtOutstanding = $('#data-table').DataTable({
      paging: true,
      serverSide: true,
      scrollX: true,
      ajax: {
         url: '{{url("summary-claim-insurance")}}',
         type: 'GET',
      },
      // order: [1, 'asc'],
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
            },
            name: 'bad.berita_acara_no'
         },
         {
            data: 'insurance_date',
            searchable: false,
            render: function(data, type, row) {
               return (data ? moment(data).format('Y-M-DD') : '');
            }
         },
         {
            data: 'total',
            searchable: false,
            render: function(data, type, row) {
               return format_currency(data);
            }
         },
         {
            data: 'payment_date',
            searchable: false,
            render: function(data, type, row) {
               return '<input type="text" value="' + (data ? moment(data).format('Y-M-DD') : '') + '" name="payment_date" class="datepicker">';
            }
         },
         {
            data: 'remark',
            searchable: false,
            render: function(data, type, row) {
               return '<textarea name="remark" style="resize: vertical;width:200px;height:50px;">' + (data ? data : '') + '</textarea>';
            }
         },
         {
            data: 'id',
            className: 'center-align',
            searchable: false,
            render: function(data, type, row, meta) {
               return ' ' + '<?= get_button_save() ?>' +
                  ' ' + '<?= get_button_delete() ?>' + ' ';
            }
         },
      ],
      initComplete: function(settings, json) {
         $('.datepicker').datepicker({
            container: 'body',
            autoClose: true,
            format: 'yyyy-mm-dd'
         });

         $('.mask-currency').inputmask('currency');
      }
   });
   jQuery(document).ready(function($) {

      set_datatables_checkbox('#data-table', dtOutstanding)

   });

   var initComplete = function() {
      $('.datepicker').datepicker({
         container: '#body',
         autoClose: true,
         format: 'yyyy-mm-dd'
      });
      $('.mask-currency').inputmask('currency');
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
         text: "Are you sure want to update this?",
         icon: 'warning',
         buttons: {
            cancel: true,
            delete: 'Yes, Update It'
         }
      }).then(function(confirm) { // proses confirm
         if (confirm) {
            $.ajax({
                  url: "{{ url('summary-claim-insurance') }}" + '/' + data.id,
                  type: 'PUT',
                  data: {
                     payment_date: tr.find('[name="payment_date"]').val(),
                     remark: tr.find('[name="remark"]').val(),
                  },
                  dataType: 'json',
               })
               .done(function(result) {
                  if (result.status) {
                     showSwalAutoClose("Success", "Claim Insurance has been updated.")
                     dtOutstanding.ajax.reload(initComplete, false); // (null, false) => user paging is not reset on reload
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
   dtOutstanding.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var tr = $(this).parent().parent();
      var data = dtOutstanding.row(tr).data();
      setLoading(true);
      swal({
         text: "Are you sure want to delete this?",
         icon: 'warning',
         buttons: {
            cancel: true,
            delete: 'Yes, Delete It'
         }
      }).then(function(confirm) { // proses confirm
         if (confirm) {
            $.ajax({
                  url: "{{ url('summary-claim-insurance') }}" + '/' + data.id,
                  type: 'DELETE',
                  dataType: 'json',
               })
               .done(function(result) {
                  if (result.status) {
                     showSwalAutoClose("Success", "Claim Insurance has been deleted.")
                     dtOutstanding.ajax.reload(initComplete, false); // (null, false) => user paging is not reset on reload
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