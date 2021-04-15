@extends('layouts.materialize.index')

@section('content')
  <div class="row">

    @component('layouts.materialize.components.title-wrapper')
      <div class="row">
        <div class="col s12 m6">
          <h5 class="breadcrumbs-title mt-0 mb-0"><span>Claim Insurance</span></h5>
          <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Claim Insurance</li>
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
                            <input type="text" placeholder="Search" class="app-filter no-propagation"
                              id="outstanding-search">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="collapsible-body p-0" id="body">
                    {!! get_button_delete('Multi Delete Selected Items', 'btn-multi-delete-selected-item mb-1 mt-1') !!}
                    <div class="section-data-tables">
                      <table id="table-outstanding" class="display" width="100%">
                        <thead>
                          <tr>
                            <th class="center-align" data-priority="1" width="30px"><label><input type="checkbox"
                                  class="select-all" /><span></span></label></th>
                            <th class="center-align">Berita Acara No.</th>
                            <th class="center-align">No. DO</th>
                            <th class="center-align">Model / Item No.</th>
                            <th class="center-align">No. Seri</th>
                            <th class="center-align">Qty</th>
                            <th class="center-align">Jenis Kerusakan</th>
                            <th class="center-align">Keterangan</th>
                            <th class="center-align" width="50px"></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </li>
              </ul>

              <button class="btn mt-2 mb-1 ml-1 mr-1" id="create-claim-insurance">Claim Insurance</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    @push('page-modal')
      <div id="modal-form-claim-insurance" class="modal">
        <form id="form-claim-insurance" class="form-table">
          <div class="modal-content">
            <input type="hidden" name="id">
            <table>
              <tr>
                <td width="200px">Claim Report</td>
                <td>
                  <div class="input-field">
                    <input type="text" name="claim_report">
                  </div>
                </td>
              </tr>
              <tr>
                <td width="200px">Branch</td>
                <td>
                  <div class="input-field">
                    <input type="text" name="branch">
                  </div>
                </td>
              </tr>
              <tr>
                <td width="200px">Date of Loss</td>
                <td>
                  <div class="input-field">
                    <input type="text" name="date_of_loss" class="datepicker">
                  </div>
                </td>
              </tr>
              <tr>
                <td width="200px">Keterangan Kejadian</td>
                <td>
                  <div class="input-field">
                    <input type="text" name="keterangan_kejadian">
                  </div>
                </td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn waves-effect waves-green btn-store btn blue darken-4">Create Claim
              Insurance</button>
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
          </div>
        </form>
      </div>
    @endpush

    @include('web.claim.claim-insurance._list_claim_insurance')

    @push('script_js')
      <script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
      </script>
    @endpush


    @push('script_js')
      <script type="text/javascript">
        jQuery(document).ready(function($) {
          dtOutstanding = $('#table-outstanding').DataTable({
            {{-- paging: false, --}}
            serverSide: true,
            scrollX: true,
            responsive: true,
            ajax: {
              url: '{{ url('claim-insurance') }}',
              type: 'GET',
            },
            order: [1, 'asc'],
            columns: [{
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                  return '<label><input type="checkbox" name="outstanding[]" value="' + data +
                    '" class="checkbox checkbox-outstanding"><span></span></label>';
                },
                className: "datatable-checkbox-cell"
              },
              {
                data: 'berita_acara_no',
                name: 'berita_acara_no',
                className: 'detail'
              },
              {
                data: 'do_no',
                name: 'do_no',
                className: 'detail'
              },
              {
                data: 'model_name',
                name: 'model_name',
                className: 'detail'
              },
              {
                data: 'serial_number',
                name: 'serial_number',
                className: 'detail',
                render: function(data, type, row) {
                  return data ? data.split(",").join("<br>") : '';
                }
              },
              {
                data: 'qty',
                name: 'qty',
                className: 'center-align'
              },
              {
                data: 'description',
                name: 'description',
                className: 'detail'
              },
              {
                data: 'keterangan',
                name: 'keterangan',
                className: 'detail'
              },
              {
                data: 'id',
                render: function(data, type, row) {
                  return '<?= get_button_delete() ?>';
                }
              },
            ]
          });

          $('.btn-multi-delete-selected-item').click(function(event) {
            /* Act on the event */
            /* Act on the event */
            swal({
              title: "Are you sure?",
              text: "Are you sure delete selected item?",
              icon: 'warning',
              buttons: {
                cancel: true,
                delete: 'Yes, Delete It'
              }
            }).then(function(confirm) { // proses confirm
              var data_outstandings = [];
              dtOutstanding.$('input[type="checkbox"]').each(function() {
                /* iterate through array or object */
                if (this.checked) {
                  var row = $(this).closest('tr');
                  var row_data = dtOutstanding.row(row).data();
                  data_outstandings.push(row_data);
                }
              });
              if (confirm) { // Bila oke post ajax ke url delete nya
                // Ajax Post Delete
                $.ajax({
                    url: "{{ url('claim-insurance/delete-multiple-outstandings') }}",
                    type: 'DELETE',
                    data: 'data_outstandings=' + JSON.stringify(data_outstandings),
                  })
                  .done(function() { // Kalau ajax nya success
                    showSwalAutoClose('Success', 'selected data deleted.')
                    dtOutstanding.ajax.reload(null, false)
                  })
                  .fail(function() { // Kalau ajax nya gagal
                    console.log("error");
                  });

              }
            })
          });

          dtOutstanding.on('click', '.btn-delete', function() {
            var tr = $(this).parent().parent();
            var data = dtOutstanding.row(tr).data();
            swal({
              text: "Are you sure want to delete this details?",
              icon: 'warning',
              buttons: {
                cancel: true,
                delete: 'Yes, Delete It'
              }
            }).then(function(confirm) { // proses confirm
              if (confirm) {
                $.ajax({
                    url: ('{{ url('/claim-insurance/outstanding/:id') }}').replace(':id', data.id),
                    type: 'DELETE',
                    dataType: 'json',
                  })
                  .done(function() {
                    swal("Deleted!", "Claim insurance has been deleted.", "success") // alert success
                    dtOutstanding.ajax.reload(null,
                      false); // (null, false) => user paging is not reset on reload
                    dtdatatable_claim_note.ajax.reload(null,
                      false); // (null, false) => user paging is not reset on reload
                  })
                  .fail(function() {
                    console.log("error");
                  });
              }
            })
          })

          set_datatables_checkbox('#table-outstanding', dtOutstanding);

          $('.datepicker').datepicker({
            container: '#body',
            autoClose: true,
            format: 'yyyy-mm-dd'
          });
        });


        $("input#outstanding-search").on("keyup click", function() {
          dtOutstanding.search($("#outstanding-search").val(), $("#global_regex").prop("checked"), $("#global_smart")
            .prop("checked")).draw();
        });

        $('#create-claim-insurance').click(function() {


          if ($('#table-outstanding tbody input[type=checkbox]:checked').length <= 0) {
            showSwalAutoClose('Warning', 'Empty Checked Data');
            return;
          }

          $('#modal-form-claim-insurance').modal('open');
        });

        $('#form-claim-insurance').validate({
          submitHandler: function(form) {
            var checkedData = $();
            $('#table-outstanding tbody input[type=checkbox]:checked').each(function() {
              var row = dtOutstanding.row($(this).parents('tr')).data(); // here is the change
              array = generateArray(row);
              checkedData.push(array);
            });
            // push(checkedData, form.serialize());
            setLoading(true);
            $.ajax({
                type: "POST",
                url: '{{ url('claim-insurance/create') }}',
                data: $(form).serialize() + '&data=' + JSON.stringify(checkedData),
                // data: {
                //   data: JSON.stringify(checkedData)
                // },
                cache: false,
              })
              .done(function(result) {
                setLoading(false);
                if (result.status) {
                  showSwalAutoClose("Success", result.message)
                  dtOutstanding.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                  dtdatatable_claim_note.ajax.reload(null,
                    false); // (null, false) => user paging is not reset on reload
                  $('#modal-form-claim-insurance').modal('close');
                  $(form)[0].reset();
                } else {
                  showSwalAutoClose('Warning', result.message)
                }
              })
              .fail(function() {
                setLoading(false);
              })
              .always(function() {
                setLoading(false);
              });
          }
        })

        function push(checkedData, form) {
          /* Act on the event */
          setLoading(true);
          $.ajax({
              type: "POST",
              url: '{{ url('claim-insurance/create') }}',
              data: form + '&data=' + JSON.stringify(checkedData),
              // data: {
              //   data: JSON.stringify(checkedData)
              // },
              cache: false,
            })
            .done(function(result) {
              if (result.status) {
                swal("Success!", result.message)
                  .then((response) => {
                    // Kalau klik Ok redirect ke view
                    dtOutstanding.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                    dtdatatable_claim_note.ajax.reload(null,
                      false); // (null, false) => user paging is not reset on reload
                  }) // alert success
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
        };

        function generateArray(row) {
          var array = $();
          array = {
            berita_acara_detail_id: row.id,
            berita_acara_no: row.berita_acara_no,
            date_of_receipt: row.date_of_receipt,
            expedition_code: row.expedition_code,
            driver_name: row.driver_name,
            vehicle_number: row.vehicle_number,
            do_no: row.do_no,
            model_name: row.model_name,
            serial_number: row.serial_number,
            qty: row.qty,
            description: row.description,
          }
          return array;
        }

      </script>
    @endpush


  </div>
@endsection
