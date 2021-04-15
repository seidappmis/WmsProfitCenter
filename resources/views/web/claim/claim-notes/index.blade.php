@extends('layouts.materialize.index')

@section('content')
  <div class="row">

    @component('layouts.materialize.components.title-wrapper')
      <div class="row">
        <div class="col s12 m6">
          <h5 class="breadcrumbs-title mt-0 mb-0"><span>Claim Notes</span></h5>
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
                            <input type="text" placeholder="Search" class="app-filter no-propagation"
                              id="outstanding-search">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="collapsible-body p-0">
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
                            <th width="30px;"></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </li>
              </ul>

              <button class="btn mt-2 mb-1 ml-1 mr-1" id="create-claim-carton-box">Claim Note Carton Box</button>
              <button class="btn mt-2 mb-1 ml-1 mr-1" id="create-claim-unit">Claim Note Unit</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    @include('web.claim.claim-notes._list_claim_notes')

    @push('script_js')
      <script type="text/javascript">
        var selectedRows = [];
        var dtOutstanding;
        jQuery(document).ready(function($) {
          dtOutstanding = $('#table-outstanding').DataTable({
            {{-- paging: false, --}}
            //serverSide: true,
            scrollX: true,
            responsive: true,
            ajax: {
              url: '{{ url('claim-notes/list-outstanding') }}',
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
                data: 'berita_acara_no'
              },
              {
                data: 'do_no'
              },
              {
                data: 'model_name'
              },
              {
                data: 'serial_number',
                render: function(data, type, row) {
                  return data ? data.split(",").join("<br>") : '';
                }
              },
              {
                data: 'qty'
              },
              {
                data: 'description'
              },
              {
                data: 'keterangan'
              },
              {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                  return '<span class="waves-effect waves-light btn btn-small red darken-4 btn-delete">Delete</span>';
                }
              }
            ]
          });

          dtOutstanding.on('click', '.btn-delete', function(event) {
            event.preventDefault();
            //Konfirmasi user

            var tr = $(this).parent().parent();
            var data = dtOutstanding.row(tr).data();
            swal({
              text: "Are you sure want to delete " + data.model_name + " ?",
              icon: 'warning',
              buttons: {
                cancel: true,
                delete: 'Yes, Delete It'
              }
            }).then(function(confirm) {
              if (confirm) {
                $.ajax({
                  url: "{{ url('claim-notes/delete-outstanding') }}" + '/' + data.id,
                  type: 'DELETE',
                  dataType: 'json',
                }).done(function(result) {
                  if (result.status) {
                    showSwalAutoClose("Success", "Outstanding item with Model Name " + data.model_name +
                      " has been deleted.");
                    dtOutstanding.ajax.reload(null, false); // reload tanpa reset user paging
                  } else {
                    swal("Error", result.message);
                  }
                }).fail(function(err) {
                  console.log("error");
                });
              }
            })
          });

          set_datatables_checkbox('#table-outstanding', dtOutstanding)

        });

        $('#table-outstanding tbody').on('click', 'input[type="checkbox"]', function(e) {
          var $tr = $(this).closest('tr');
          var data = dtOutstanding.row($tr).data();
          var index = $.inArray(data, selectedRows);

          if (this.checked && index === -1) {
            //checked dan tidak ada di selectedRows, maka masukkan selectedRows
            selectedRows.push(data);
          } else if (!this.checked && index !== -1) {
            selectedRows.splice(index, 1);
          }
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
                  url: "{{ url('claim-notes/delete-multiple-outstandings') }}",
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

        $("input#outstanding-search").on("keyup click", function() {
          dtOutstanding.search($("#outstanding-search").val(), $("#global_regex").prop("checked"), $("#global_smart")
            .prop("checked")).draw();
        });

        $('#create-claim-unit').click(function() {
          var checkedData = $();
          /*
                    $('#table-outstanding tbody input[type=checkbox]:checked').each(function() {
                        var row = dtOutstanding.row($(this).parents('tr')).data(); // here is the change
                        array = generateArray(row, 'unit');
                        checkedData.push(array);
                    });
           */
          selectedRows.forEach(function(item) {
            array = generateArray(item, 'unit');
            checkedData.push(array);
          });
          push(checkedData, 'unit');
        });

        $('#create-claim-carton-box').click(function() {
          var checkedData = $();
          /*
                    $('#table-outstanding tbody input[type=checkbox]:checked').each(function() {
                        var row = dtOutstanding.row($(this).parents('tr')).data(); // here is the change
                        array = generateArray(row, 'carton-box');
                        checkedData.push(array);
                    });
           */
          selectedRows.forEach(function(item) {
            array = generateArray(item, 'carton-box');
            checkedData.push(array);
          });
          push(checkedData, 'carton-box');
        });

        function push(checkedData, type) {
          /* Act on the event */
          setLoading(true);
          $.ajax({
              type: "POST",
              url: '{{ url('claim-notes/create') }}',
              data: {
                data: JSON.stringify(checkedData),
                type: type
              },
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

        function generateArray(row, type) {
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
            claim: type
          }
          return array;
        }

      </script>
    @endpush


  </div>
@endsection
