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

@push('page-modal')
<div id="modal-detail" class="modal modal-fixed-footer" style="width: 75% !important ;">
   <div class="modal-content">
      <table id="detail-data" class="display" width="100%">
         <thead>
            <tr>
               <th><strong>NO</strong></th>
               <th><strong>DATE</strong></th>
               <th><strong>NO. BERITA ACARA</strong></th>
               <th><strong>INVOICE NO</strong></th>
               <th><strong>B/L NO</strong></th>
               <th><strong>CONTAINER NO</strong></th>
               <th><strong>MODEL</strong></th>
               <th><strong>POM</strong></th>
               <th><strong>QTY</strong></th>
               <th><strong>NO. SERI</strong></th>
               <th><strong>REMARKS</strong></th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
   <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
   </div>
</div>
@endpush
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
            // name: 'berita_acara_group',
            className: 'detail',
            // searchable: false,
            render: function(data, type, row, meta) {
               return data ? data.split(",").join("<br>") : '';
            }
         }, {
            data: 'dgr_no',
            name: 'dgr_no',
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
                  ' ' + '<?= get_button_print() ?>';
               // ' <a class="waves-effect waves-light btn btn-small green darken-4 btn-print-detail" href="#">Print Detail</a>';
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


   $('#table-dgr tbody').on('click', '.btn-detail', function() {

      var row = $(this).closest('tr');
      var row = dtTableDGR.row(row).data();

      $('#modal-detail').modal('open');
      $.ajax({
            type: "GET",
            url: '{{url("damage-goods-report/{id}/detail")}}'.replace('{id}', row.id),
            cache: false,
         })
         .done(function(result) {
            if (result.status) {
               html = '';
               no = 1;
               $('#detail-data tbody').empty();
               $.each(result.data.data, function(i, v) {
                  if (i == 0 || v.berita_acara_during_no != result.data.data[i - 1].berita_acara_during_no) {
                     html += `
                     <tr>
                        <td rowspan="` + v.rowspan + `">` + (no++) + `</td>
                        <td rowspan="` + v.rowspan + `">` + moment(v.tanggal_kejadian).format('LLL') + `</td>
                        <td rowspan="` + v.rowspan + `">` + v.berita_acara_during_no + `</td>
                        <td rowspan="` + v.rowspan + `">` + v.invoice_no + `</td>
                        <td rowspan="` + v.rowspan + `">` + v.bl_no + `</td>
                        <td rowspan="` + v.rowspan + `">` + v.container_no + `</td>
                        <td>` + v.model_name + `</td>
                        <td>` + v.pom + `</td>
                        <td>` + v.ba_qty + `</td>
                        <td>` + v.serial_number + `</td>
                        <td>` + v.damage + `</td>
                     </tr>
                  `;
                  } else {
                     html += `
                     <tr>
                           <td>` + v.model_name + `</td>
                           <td>` + v.pom + `</td>
                           <td>` + v.ba_qty + `</td>
                           <td>` + v.serial_number + `</td>
                           <td>` + v.damage + `</td>
                        </tr>
                     `;
                  }
               });

               $('#detail-data tbody').append(html);
               // $('#detail-data').DataTable();
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