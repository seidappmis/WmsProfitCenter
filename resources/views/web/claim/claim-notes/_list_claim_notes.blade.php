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
                                    <input type="text" placeholder="Search" class="app-filter no-propagation" id="claim-note-search">
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
                                    <th>BERITA ACARA</th>
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
            name: 'bad.berita_acara_no',
            className: 'detail',
            // searchable: false,
            render: function(data, type, row, meta) {
               return truncate(data, 35);
            }
         }, {
            data: 'claim_note_no',
            name: 'n.claim_note_no',
            className: 'detail'
         }, {
            data: 'date_of_receipt',
            name: 'ba.date_of_receipt',
            className: 'detail'
         }, {
            data: 'expedition_name',
            name: 'e.expedition_name',
            searchable: false,
            className: 'detail'
         }, {
            data: 'destination',
            name: 'nd.destination',
            className: 'center-align'
         }, {
            data: 'id',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
               return ' <button class="waves-effect waves-light btn btn-small indigo darken-4 btn-detail">Detail</button>' +
                  ' ' + '<?= get_button_view(url("claim-notes/:id")) ?>'.replace(':id', data) +
                  ' ' + '<?= get_button_print() ?>' +
                  ' <a class="waves-effect waves-light btn btn-small green darken-4 btn-print-detail" href="#">Print Detail</a>'
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

      dtdatatable_claim_note.on('click', '.btn-print-detail', function(event) {
         var tr = $(this).parent().parent();
         var data = dtdatatable_claim_note.row(tr).data();
         initPrintPreviewPrint(
            '{{url("claim-notes")}}' + '/' + data.id + '/print-detail'
         )
      });
   });

   $("input#claim-note-search").on("keyup click", function() {
      dtdatatable_claim_note.search($("#claim-note-search").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
   });

   // Add event listener for opening and closing details
   $('#table-claim-notes tbody').on('click', '.btn-detail', function() {
      var tr = $(this).closest('tr');
      var row = dtdatatable_claim_note.row(tr);

      if (row.child.isShown()) {
         // This row is already open - close it
         row.child.hide();
         tr.removeClass('shown');
      } else {
         // Open this row
         row.child(format(row.data())).show();
         tr.addClass('shown');
      }
   });

   /* Formatting function for row details - modify as you need */
   function format(d) {
      // `d` is the original data object for the row
      html = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
         '<tr>' +
         '<td>Bertia acara:</td>' +
         '<td>';

      if (d.berita_acara_group) {
         var array = d.berita_acara_group.split(', ');
         $.each(array, function(i, v) {
            html += v + "<br>";
         });
      }

      html += '</td>' +
         '</tr>' +
         '<tr>' +
         '<td>Claim Note:</td>' +
         '<td>' + d.claim_note_no + '</td>' +
         '</tr>' +
         '<tr>' +
         '<td>Reporting Date:</td>' +
         '<td>' + d.date_of_receipt + '</td>' +
         '</tr>' +
         '<tr>' +
         '<td>Expedition_name:</td>' +
         '<td>' + d.expedition_name + '</td>' +
         '</tr>' +
         '<tr>' +
         '<td>Destination:</td>' +
         '<td>' + d.destination + '</td>' +
         '</tr>' +
         '<tr>' +
         '</table>';
      return html;
   };

   function truncate(source, size) {
      return source.length > size ? source.slice(0, size - 1) + "…" : source;
   }
</script>
@endpush