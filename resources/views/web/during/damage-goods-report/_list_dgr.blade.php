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
                                 <span>Damage Goods Report </span>
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
                           <table id="table-dgr" class="display" width="100%">
                              <thead>
                                 <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>BERITA ACARA</th>
                                    <th>DGR NO</th>
                                    <th>REPORTING DATE</th>
                                    <th>EXPEDITION NAME</th>
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

      dtTableDGR = $('#table-dgr').DataTable({
         serverSide: true,
         scrollX: true,
         ajax: {
            url: '{{url("damage-goods-report/list-damage-goods-report")}}',
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
               return data ? data.split(",").join("<br>") : '';
            }
         }, {
            data: 'dgr_no',
            name: 'n.dgr_no',
            className: 'detail'
         }, {
            data: 'created_at',
            name: 'ba.created_at',
            className: 'detail',
            render: function(data, type, row) {
               return moment(data).format('D MMM YYYY');
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
            data: 'id',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
               let btn = ' <button class="waves-effect waves-light btn btn-small indigo darken-4 btn-detail">Detail</button>' +
                  ' ' + '<?= get_button_print() ?>' +
                  ' <a class="waves-effect waves-light btn btn-small green darken-4 btn-print-detail" href="#">Print Detail</a>';
               if (row.submit_date == null) {
                  btn += ' <span class="waves-effect waves-light btn btn-small amber darken-4 btn-submit">Submit</span>';
                  btn += ' <span class="waves-effect waves-light btn btn-small red darken-4 btn-delete">Delete</span>';
               }
               return btn;
            },
            className: "left-align"
         }]
      });

      dtTableDGR.on('click', '.btn-print', function(event) {
         var tr = $(this).parent().parent();
         var data = dtTableDGR.row(tr).data();
         initPrintPreviewPrint(
            '{{url("damage-goods-report")}}' + '/' + data.id + '/print'
         )
      });

      dtTableDGR.on('click', '.btn-print-detail', function(event) {
         var tr = $(this).parent().parent();
         var data = dtTableDGR.row(tr).data();
         initPrintPreviewPrint(
            '{{url("damage-goods-report")}}' + '/' + data.id + '/print-detail'
         )
      });


      dtTableDGR.on('click', '.btn-submit', function(event) {
         event.preventDefault();
         /* Act on the event */
         var tr = $(this).parent().parent();
         var data = dtTableDGR.row(tr).data();
         swal({
            text: "Are you sure want to submit " + data.dgr_no + " and the details?",
            icon: 'warning',
            buttons: {
               cancel: true,
               delete: 'Yes, Submit It'
            }
         }).then(function(confirm) { // proses confirm
            if (confirm) {
               $.ajax({
                     url: "{{ url('damage-goods-report') }}" + '/' + data.id + '/submit',
                     type: 'PUT',
                     dataType: 'json',
                  })
                  .done(function(result) {
                     if (result.status) {
                        showSwalAutoClose('Success', "Claim Note with Claim Note No. " + data.dgr_no + " has been submited.")
                        dtTableDGR.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                     }
                  })
                  .fail(function() {
                     console.log("error");
                  });
            }
         })
      });


      dtTableDGR.on('click', '.btn-delete', function(event) {
         event.preventDefault();
         /* Act on the event */
         // Ditanyain dulu usernya mau beneran delete data nya nggak.
         var tr = $(this).parent().parent();
         var data = dtTableDGR.row(tr).data();
         swal({
            text: "Are you sure want to delete " + data.dgr_no + " and the details?",
            icon: 'warning',
            buttons: {
               cancel: true,
               delete: 'Yes, Delete It'
            }
         }).then(function(confirm) { // proses confirm
            if (confirm) {
               $.ajax({
                     url: "{{ url('damage-goods-report') }}" + '/' + data.id,
                     type: 'DELETE',
                     dataType: 'json',
                  })
                  .done(function(result) {
                     if (result.status) {
                        showSwalAutoClose("Success", "Claim Note with Claim Note No. " + data.dgr_no + " has been deleted.")
                        dtTableDGR.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                        dtOutstanding.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                     }
                  })
                  .fail(function() {
                     console.log("error");
                  });
            }
         })
      });
   });

   $("input#claim-note-search").on("keyup click", function() {
      dtTableDGR.search($("#claim-note-search").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
   });

   // Add event listener for opening and closing details
   $('#table-dgr tbody').on('click', '.btn-detail', function() {
      var tr = $(this).closest('tr');
      var row = dtTableDGR.row(tr);

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
         '<td>' +
         (d.berita_acara_group ? d.berita_acara_group.split(",").join("<br>") : '') +
         '</td>' +
         '</tr>' +
         '<tr>' +
         '<td>DGR:</td>' +
         '<td>' + d.dgr_no + '</td>' +
         '</tr>' +
         '<tr>' +
         '<td>Reporting Date:</td>' +
         '<td>' + moment(d.created_at).format('D MMM YYYY') + '</td>' +
         '</tr>' +
         '<tr>' +
         '<td>Expedition_name:</td>' +
         '<td>' + (d.expedition_name ? d.expedition_name.split("|").join("<br>") : '') + '</td>' +
         '</tr>' +
         '<tr>' +
         '<td>Remark:</td>' +
         '<td>' + (d.remark ? d.remark.split("|").join("<br>") : '') + '</td>' +
         '</tr>' +
         '<tr>' +
         '</table>';
      return html;
   };
</script>
@endpush