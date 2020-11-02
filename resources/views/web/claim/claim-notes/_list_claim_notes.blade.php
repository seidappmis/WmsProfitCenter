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
                                 <span>Claim Notes </span>
                              </div>
                           </div>
                           <div class="col s12 m4">
                              <div class="app-wrapper">
                                 <div class="datatable-search mb-0">
                                    <i class="material-icons mr-2 search-icon">search</i>
                                    <input type="text" placeholder="Search" class="app-filter no-propagation" id="global_filter">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="collapsible-body p-0">
                        <div class="section-data-tables">
                           <table id="table-claim-notes" class="display" width="100%">
                              <thead>
                                 <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th style="max-width: 200px;">BERITA ACARA</th>
                                    <th>CLAIM NOTE</th>
                                    <th>REPORTING DATE</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>DESTINATION</th>
                                    <th width="50px;"></th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
                        <!-- datatable ends -->

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
   jQuery(document).ready(function($) {

      @include('layouts.materialize.components.modal-print', [
         'title' => 'Print',
      ])

      dtdatatable_claim_note = $('#table-claim-notes').DataTable({
         serverSide: true,
         scrollX: true,
         responsive: true,
         ajax: {
            url: '{{url("claim-notes/list-claim-notes")}}',
            type: 'GET',
         },
         columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            className: 'center-align'
         }, {
            data: 'berita_acara_group',
            name: 'berita_acara_group',
            className: 'detail'
         }, {
            data: 'claim_note_no',
            name: 'claim_note_no',
            className: 'detail'
         }, {
            data: 'date_of_receipt',
            name: 'date_of_receipt',
            className: 'detail'
         }, {
            data: 'expedition_name',
            name: 'expedition_name',
            className: 'detail'
         }, {
            data: 'destination',
            name: 'destination',
            className: 'center-align'
         }, {
            data: 'id',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
               return '<?= get_button_view(url("claim-notes/:id")) ?>'.replace(':id', data) +
                  ' ' + '<?= get_button_print() ?>';
            },
            className: "center-align"
         }]
      });

      dtdatatable_claim_note.on('click', '.btn-print', function(event) {
         var tr = $(this).parent().parent();
         var data = dtdatatable_claim_note.row(tr).data();
         initPrintPreviewPrint(
            '{{url("claim-notes")}}' + '/' + data.id + '/print'
         )
      });
   });
</script>
@endpush