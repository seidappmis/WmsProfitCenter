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
                                    <input type="text" placeholder="Search" class="app-filter no-propagation" id="claim-insurance-search">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="collapsible-body p-0">
                        <div class="section-data-tables">
                           <table id="table-claim-insurance" class="display" width="100%">
                              <thead>
                                 <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>BERITA ACARA</th>
                                    <th>INSURANCE DATE</th>
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
@push('page-modal')
<div id="modal-detail" class="modal" style="width: 75% !important ;">
   <div class="modal-content">
      <table id="detail-content">
         <tr>
            <td width="200px">Claim Report</td>
            <td>
               <div class="input-field">
                  <span name="claim_report"></span>
               </div>
            </td>
         </tr>
         <tr>
            <td width="200px">Branch</td>
            <td>
               <div class="input-field">
                  <span name="branch"></span>
               </div>
            </td>
         </tr>
         <tr>
            <td width="200px">Date of Loss</td>
            <td>
               <div class="input-field">
                  <span name="date_of_loss"></span>
               </div>
            </td>
         </tr>
         <tr>
            <td width="200px">Keterangan Kejadian</td>
            <td>
               <div class="input-field">
                  <span name="keterangan_kejadian"></span>
               </div>
            </td>
         </tr>
      </table>

      <table id="detail-data" class="display" width="100%">
         <thead>
            <tr>
               <th data-priority="1" width="30px">No.</th>
               <th>Serial Number</th>
               <th>Product</th>
               <th>Unit</th>
               <th>Price/Unit</th>
               <th width="100px">Total</th>
               <th>Nature of Loss</th>
               <th>Location</th>
               <th>Photo</th>
               <th>Remarks</th>
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

      @include('layouts.materialize.components.modal-print', [
         'title' => 'Print RPT',
      ])

      dtdatatable_claim_note = $('#table-claim-insurance').DataTable({
         serverSide: true,
         scrollX: true,
         ajax: {
            url: '{{url("claim-insurance/list-claim-insurance")}}',
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
            render: function(data, type, row, meta) {
               return truncate(data, 35);
            }
         }, {
            data: 'insurance_date',
            name: 'i.insurance_date',
            className: 'detail'
         }, {
            data: 'date_of_receipt',
            name: 'ba.date_of_receipt',
            className: 'detail'
         }, {
            data: 'expedition_name',
            name: 'e.expedition_name',
            className: 'detail'
         }, {
            data: 'destination',
            name: 'insurance.destination',
            className: 'center-align'
         }, {
            data: 'id',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
               var btn = ' <button class="waves-effect waves-light btn btn-small indigo darken-4 btn-detail">Detail</button>' +
                  ' ' + '<?= get_button_view(url("claim-insurance/:id")) ?>'.replace(':id', data) +
                  ' ' + '<?= get_button_print("#!", "Print RPT", "btn-print-rpt") ?>' +
                  ' ' + '<?= get_button_print() ?>' +
                  (!row.submit_date ? ' ' + '<?= get_button_edit('#!', 'Submit', 'btn-submit') ?>' + ' ' + '<?= get_button_delete() ?>' : '');
               return btn;
            },
            className: "left-align"
         }]
      });

      dtdatatable_claim_note.on('click', '.btn-print', function(event) {
         var tr = $(this).parent().parent();
         var data = dtdatatable_claim_note.row(tr).data();
         initPrintPreviewPrint(
            '{{url("claim-insurance")}}' + '/' + data.id + '/print'
         )
      });

      dtdatatable_claim_note.on('click', '.btn-print-rpt', function(event) {
         var tr = $(this).parent().parent();
         var data = dtdatatable_claim_note.row(tr).data();
         initPrintPreviewPrintRPT(
            '{{url("claim-insurance")}}' + '/' + data.id + '/print-rpt'
         )
      });



      dtdatatable_claim_note.on('click', '.btn-submit', function(event) {
         event.preventDefault();
         /* Act on the event */
         var tr = $(this).parent().parent();
         var data = dtdatatable_claim_note.row(tr).data();

         swal({
            text: "Are you sure want to submit and the details?",
            icon: 'warning',
            buttons: {
               cancel: true,
               delete: 'Yes, Submit It'
            }
         }).then(function(confirm) { // proses confirm
            if (confirm) {
               $.ajax({
                     url: "{{ url('claim-insurance') }}" + '/' + data.id + '/submit',
                     type: 'PUT',
                     dataType: 'json',
                  })
                  .done(function(result) {
                     if (result.status) {
                        showSwalAutoClose('Success', "Claim insurance has been submited.")
                        dtdatatable_claim_note.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                     }
                  })
                  .fail(function() {
                     console.log("error");
                  });
            }
         })
      });

      dtdatatable_claim_note.on('click', '.btn-delete', function(event) {
         event.preventDefault();
         /* Act on the event */
         // Ditanyain dulu usernya mau beneran delete data nya nggak.
         var tr = $(this).parent().parent();
         var data = dtdatatable_claim_note.row(tr).data();
         swal({
            text: "Are you sure want to delete and the details?",
            icon: 'warning',
            buttons: {
               cancel: true,
               delete: 'Yes, Delete It'
            }
         }).then(function(confirm) { // proses confirm
            if (confirm) {
               $.ajax({
                     url: ('{{ url("/claim-insurance/:id") }}').replace(':id', data.id),
                     type: 'DELETE',
                     dataType: 'json',
                  })
                  .done(function() {
                     swal("Deleted!", "Claim insurance has been deleted.", "success") // alert success
                     dtOutstanding.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                     dtdatatable_claim_note.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                  })
                  .fail(function() {
                     console.log("error");
                  });
            }
         })
      });
   });

   $("input#claim-insurance-search").on("keyup click", function() {
      dtdatatable_claim_note.search($("#claim-insurance-search").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
   });

   // // Add event listener for opening and closing details
   // $('#table-claim-insurance tbody').on('click', '.btn-detail', function() {
   //    var tr = $(this).closest('tr');
   //    var row = dtdatatable_claim_note.row(tr);

   //    if (row.child.isShown()) {
   //       // This row is already open - close it
   //       row.child.hide();
   //       tr.removeClass('shown');
   //    } else {
   //       // Open this row
   //       row.child(format(row.data())).show();
   //       tr.addClass('shown');
   //    }
   // });

   // Add event listener for opening and closing details
   $('#table-claim-insurance tbody').on('click', '.btn-detail', function() {

      var row = $(this).closest('tr');
      var row = dtdatatable_claim_note.row(row).data();

      $('#modal-detail').modal('open');
      $.ajax({
            type: "GET",
            url: '{{url("claim-insurance/{id}/detail")}}'.replace('{id}', row.id),
            cache: false,
         })
         .done(function(result) {
            if (result.status) {
               $('#detail-content [name="claim_report"]').html(result.data.content.claim_report);
               $('#detail-content [name="branch"]').html(result.data.content.branch);
               $('#detail-content [name="date_of_loss"]').html(moment(result.data.content.date_of_loss).format('DD MMM YYYY'));
               $('#detail-content [name="keterangan_kejadian"]').html(result.data.content.keterangan_kejadian);

               html = '';
               no = 1;
               $.each(result.data.data, function(i, v) {
                  let price = v.price;
                  if (v.description == 'Carton Box Damage' && !v.prive) {
                     price = v.price_carton_box;
                  };

                  html += `<tr>
                           <td data-priority="1" widtd="30px">` + (no++) + `</td>
                           <td>` + (v.serial_number ? v.serial_number.split(",").join("<br>") : '') + `</td>
                           <td>` + v.model_name + `</td>
                           <td>` + (!isNaN(v.qty) ? v.qty : 0) + `</td>
                           <td class="right-align">` + format_currency(price) + `</td>
                           <td class="right-align">` + format_currency(price * v.qty) + `</td>
                           <td>` + v.description + `</td>
                           <td>` + v.location + `</td>
                           <td>` + (v.photo_url ? '<img class="materialboxed center-align" width="200" height="200" src="' + "{{asset('storage/')}}/" + v.photo_url + '">' : '-') + `</td>
                           <td>` + v.keterangan + `</td>
                           </tr>`;
               });

               $('#detail-data tbody').append(html);
               $('#detail-data').DataTable();
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
         '<td>Insurance Date:</td>' +
         '<td>' + d.insurance_date + '</td>' +
         '</tr>' +
         '<tr>' +
         '<td>Date of Receipt:</td>' +
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
      if (source) {
         return source.length > size ? source.slice(0, size - 1) + "…" : source;
      } else {
         return source
      }
   }

   // convert to format currency
   function format_currency(nStr) {
      if (nStr === null) return '0,00';
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