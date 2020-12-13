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


@push('page-modal')
<div id="modal-detail" class="modal" style="width: 75% !important ;">
   <div class="modal-content">
      <table id="detail-data" class="display" width="100%">
         <thead>
            <tr>
               <th data-priority="1" width="30px">No.</th>
               <th>Berita Acara</th>
               <th>Expediton Name</th>
               <th>Driver</th>
               <th>Car No</th>
               <th>DO NO</th>
               <th>Model</th>
               <th>Serial No</th>
               <th>Damage Description</th>
               <th>Reason</th>
               <th>Destination</th>
               <th>Warehouse</th>
               <th>Photo</th>
               <th>Qty</th>
               <th id="price-condition"></th>
               <th style="display: none;" id="price-unit">Price</th>
               <th>Total</th>
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
            className: 'detail',
            render: function(data, type, row, meta) {
               return data ? moment(data).format('Y-MMM-DD') : '';
            }
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
               var btn = ' <button class="waves-effect waves-light btn btn-small indigo darken-4 btn-detail">Detail</button>' +
                  ' ' + '<?= get_button_view(url("claim-notes/:id")) ?>'.replace(':id', data) +
                  ' ' + '<?= get_button_print() ?>' +
                  ' <a class="waves-effect waves-light btn btn-small green darken-4 btn-print-detail" href="#">Print Detail</a>';
               if (row.submit_date == null) {
                  btn += ' <span class="waves-effect waves-light btn btn-small amber darken-4 btn-submit">Submit</span>';
                  btn += ' <span class="waves-effect waves-light btn btn-small red darken-4 btn-delete">Delete</span>';
               }
               return btn;
            },
            // className: "center-align"
         }]
      });

      dtdatatable_claim_note.on('click', '.btn-submit', function(event) {
         event.preventDefault();
         /* Act on the event */
         var tr = $(this).parent().parent();
         var data = dtdatatable_claim_note.row(tr).data();
         swal({
            text: "Are you sure want to submit " + data.claim_note_no + " and the details?",
            icon: 'warning',
            buttons: {
               cancel: true,
               delete: 'Yes, Submit It'
            }
         }).then(function(confirm) { // proses confirm
            if (confirm) {
               $.ajax({
                     url: "{{ url('claim-notes') }}" + '/' + data.id + '/submit',
                     type: 'PUT',
                     dataType: 'json',
                  })
                  .done(function(result) {
                     if (result.status) {
                        showSwalAutoClose('Success', "Claim Note with Claim Note No. " + data.claim_note_no + " has been submited.")
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
            text: "Are you sure want to delete " + data.claim_note_no + " and the details?",
            icon: 'warning',
            buttons: {
               cancel: true,
               delete: 'Yes, Delete It'
            }
         }).then(function(confirm) { // proses confirm
            if (confirm) {
               $.ajax({
                     url: "{{ url('claim-notes') }}" + '/' + data.id,
                     type: 'DELETE',
                     dataType: 'json',
                  })
                  .done(function(result) {
                     if (result.status) {
                        showSwalAutoClose("Success", "Claim Note with Claim Note No. " + data.claim_note_no + " has been deleted.")
                        dtdatatable_claim_note.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                        dtOutstanding.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                     }
                  })
                  .fail(function() {
                     console.log("error");
                  });
            }
         })
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

      var row = $(this).closest('tr');
      var row = dtdatatable_claim_note.row(row).data();

      $('#modal-detail').modal('open');
      $.ajax({
            type: "GET",
            url: '{{url("claim-notes/{id}/detail")}}'.replace('{id}', row.id),
            cache: false,
         })
         .done(function(result) {
            if (result.status) {

               var main = result.data.main,
                  detail = result.data.detail,
                  claim = main.claim;

               $('#price-condition').html('Price' + (claim == 'unit' ? ' (condition)' : ''))

               if (claim == 'unit') {
                  $('#price-unit').show();
               } else {
                  $('#price-unit').hide();
               }

               html = '';
               no = 1;

               $('#detail-data tbody').empty();
               $.each(detail, function(i, v) {
                  console.log(v);
                  var price_condition = v.price;
                  if (v.description == 'Carton Box Damage' && !v.price) {
                     price_condition = v.price_carton_box;
                  }

                  var price_unit = format_currency((price_condition * 110 / 100));

                  if (claim == 'unit') {
                     total = format_currency(v.qty * (price_condition * 110 / 100));
                  } else {
                     total = format_currency(v.qty * price_condition);
                  }
                  html += `<tr>
                     <td data-priority="1" widtd="30px">` + (no++) + `</td>
                     <td>` + (v.berita_acara_no ? v.berita_acara_no : '') + `</td>
                     <td>` + (v.expedition_name ? v.expedition_name : '') + `</td>
                     <td>` + (v.driver_name ? v.driver_name : '') + `</td>
                     <td>` + (v.vehicle_number ? v.vehicle_number : '') + `</td>
                     <td>` + (v.do_no ? v.do_no : '') + `</td>
                     <td>` + (v.model_name ? v.model_name : '') + `</td>
                     <td>` + (v.serial_number ? v.serial_number.split(",").join("<br>") : '') + `</td>
                     <td>` + (v.description ? v.description : '') + `</td>
                     <td>` + (v.reason ? v.reason : '') + `</td>
                     <td>` + (v.destination ? v.destination : '') + `</td>
                     <td>` + (v.warehouse ? v.warehouse : '') + `</td>
                     <td>` + (v.photo_url ? '<img class="materialboxed center-align" width="200" height="200" src="' + "{{asset('storage/')}}/" + v.photo_url + '">' : '') + `</td>
                     <td>` + (v.qty ? v.qty : '') + `</td>
                     <td>` + format_currency(price_condition) + `</td>`;

                  if (claim == 'unit') {
                     html += `<td>` + price_unit + `</td>`;
                  }

                  html += `<td>` + total + `</td>
                     </tr>`;
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

   function truncate(source, size) {
      return source.length > size ? source.slice(0, size - 1) + "…" : source;
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
      return x1 + x2;
   }
</script>
@endpush