@extends('layouts.materialize.index')

@section('content')
<div class="row">

   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m6">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Marine Cargo</span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Marine Cargo</li>
         </ol>
      </div>
      <div class="col s12 m6">
         <div class="display-flex">
            <!---- Search ----->
            <div class="app-wrapper mr-2">
               <div class="datatable-search">
                  <i class="material-icons mr-2 search-icon">search</i>
                  <input type="text" placeholder="Search" class="app-filter" id="global_filter">
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col s12 m4">
         <a href="{{ url('marine-cargo/create') }}" class="btn btn-large waves-effect waves-light btn-add">
            New Marine Cargo
         </a>
      </div>
   </div>
   @endcomponent

   <div class="col s12">
      <div class="container">
         <div class="section">
            <div class="card">
               <div class="card-content p-0">
                  <div class="section-data-tables">
                     <table id="data-table" class="display" width="100%">
                        <thead>
                           <tr>
                              <th data-priority="1" width="30px">NO.</th>
                              <th>Damage Good Report</th>
                              <th width="200px"></th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
                  <!-- datatable ends -->
               </div>
            </div>
         </div>
      </div>
      <div class="content-overlay"></div>
   </div>
</div>
@endsection

@push('page-modal')
<div id="modal-form-print-letter" class="modal" style="">
   <div class="modal-content">
      <form id="form-print-letter" class="form-table">
         <input type="hidden" name="id">
         <table>
            <tr>
               <td width="150px">Checker</td>
               <td>
                  <div class="input-field">
                     <input type="text" name="checker">
                  </div>
               </td>
            </tr>
            <tr>
               <td width="150px">Driver/Operator</td>
               <td>
                  <div class="input-field">
                     <input type="text" name="driver_or_operator">
                  </div>
               </td>
            </tr>
            <tr>
               <td width="150px">Kepala Operasional</td>
               <td>
                  <div class="input-field">
                     <input type="text" name="kepala_operasional">
                  </div>
               </td>
            </tr>
         </table>
      </form>
   </div>
   <div class="modal-footer">
      <a href="#!" class="btn waves-effect waves-green btn-show-print-preview-letter btn green darken-4">Print Letter</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
   </div>
</div>
@endpush

@push('script_js')
<script type="text/javascript">
   var dtdatatable = $('#data-table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
         url: "{{ url('marine-cargo') }}",
         type: 'GET',
         data: function(d) {
            d.search['value'] = $('#global_filter').val()
         }
      },
      // order: [1, 'asc'],
      columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            className: 'center-align'
         },
         {
            data: 'dgr_no',
            name: 'dgr_no',
            className: 'detail'
         }, {
            data: 'id',
            name: 'id',
            className: 'left-align',
            searchable: false,
            orderable: false,
            render: function(data, type, row, meta) {
               return ' ' + '<?= get_button_view(url("/marine-cargo/:id")) ?>'.replace(':id', data) +
                  ' ' + '<?= get_button_print("#!", "Print Claim Note", "btn-print-claim-note") ?>' +
                  ' ' + '<?= get_button_print("#!", "Print Notice Of Claim", "btn-print-notice-of-claim") ?>' +
                  ' ' + '<?= get_button_delete() ?>';
            }
         },
      ]
   });


   @include('layouts.materialize.components.modal-print', [
      'title' => 'Print Claim Note',
   ]);

   @include('layouts.materialize.components.modal-print', [
      'title' => 'Print Notice of Claim',
   ]);

   dtdatatable.on('click', '.btn-print-claim-note', function(event) {
      var tr = $(this).parent().parent();
      var data = dtdatatable.row(tr).data();

      swal({
         text: "Are you sure want to print Marine Cargo Claim Note with Insurance Policy No. " + data.insurance_policy_no + " and the details?",
         icon: 'warning',
         buttons: {
            cancel: true,
            delete: 'Yes, Print It'
         }
      }).then(function(confirm) { // proses confirm
         if (confirm) {
            initPrintPreviewPrintClaimNote(
               '{{url("/marine-cargo/{id}/export-claim-note")}}'.replace('{id}', data.id)
            )
         }
      })
   });

   dtdatatable.on('click', '.btn-print-notice-of-claim', function(event) {
      var tr = $(this).parent().parent();
      var data = dtdatatable.row(tr).data();

      swal({
         text: "Are you sure want to print Marine Cargo Notice of Claim with Insurance Policy No. " + data.insurance_policy_no + " and the details?",
         icon: 'warning',
         buttons: {
            cancel: true,
            delete: 'Yes, Print It'
         }
      }).then(function(confirm) { // proses confirm
         if (confirm) {
            initPrintPreviewPrintNoticeofClaim(
               '{{url("/marine-cargo/{id}/export-notice-of-claim")}}'.replace('{id}', data.id)
            )
         }
      })
   });

   dtdatatable.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var tr = $(this).parent().parent();
      var data = dtdatatable.row(tr).data();
      swal({
         text: "Are you sure want to delete " + data.insurance_policy_no + " and the details?",
         icon: 'warning',
         buttons: {
            cancel: true,
            delete: 'Yes, Delete It'
         }
      }).then(function(confirm) { // proses confirm
         if (confirm) {
            $.ajax({
                  url: ('{{ url("/marine-cargo/:id") }}').replace(':id', data.id),
                  type: 'DELETE',
                  dataType: 'json',
               })
               .done(function() {
                  swal("Deleted!", "Berita Acara During with Berita Acara During No. " + data.berita_acara_during_no + " has been deleted.", "success") // alert success
                  dtdatatable.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
               })
               .fail(function() {
                  console.log("error");
               });
         }
      })
   });

   $("input#global_filter").on("keyup click", function() {
      filterGlobal();
   });

   // Custom search
   function filterGlobal() {
      dtdatatable.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
   };
</script>
@endpush