@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m3">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Finish Good Production</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Finish Good Production</li>
                </ol>
            </div>
            <div class="col s12 m3">
              <!---- Filter ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <select id="area_filter"
                          class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
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
            <div class="col s12 m3"></div>
        </div>
        <div class="row">
          <div class="col s12 m4">
            <!---- Button Add ----->
            {!! get_button_create(url('finish-good-production/create'), 'New Incoming Finish Good') !!}
          </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="table-finish-good-production" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>RECEIPT NO</th>
                                    <th>TICKET NO</th>
                                    <th>WAREHOUSE</th>
                                    <th>FACTORY</th>
                                    <th width="50px;"></th>
                                    <th width="50px;"></th>
                                    <th width="50px;"></th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                {{-- <tr>
                                  <td>1.</td>
                                  <td>ARV-WHHYP-181003-019</td>
                                  <td>L-TV-1810010006</td>
                                  <td>SHARP KARAWANG W/H</td>
                                  <td>TV</td>
                                  <td>
                                    {!! get_button_view(url('finish-good-production/1')) !!}
                                    {!! get_button_print() !!}
                                  </td>
                                </tr> --}}
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
<div id="modal-form-print" class="modal" style="">
    <div class="modal-content">
      <form id="form-print" class="form-table">
        <input type="hidden" name="receipt_no">
        <table>
          <tr>
            <td width="100px">Transfer By</td>
            <td>
              <div class="input-field">
                <input type="text" name="transfer_by">
              </div>
            </td>
          </tr>
          <tr>
            <td width="100px">Checked By</td>
            <td>
              <div class="input-field">
                <input type="text" name="checked_by">
              </div>
            </td>
          </tr>
          <tr>
            <td width="100px">Locate</td>
            <td>
              <div class="input-field">
                <input type="text" name="locate">
              </div>
            </td>
          </tr>
        </table>
      </form>
    </div>
    <div class="modal-footer">
      <a href="#!" class="btn waves-effect waves-green btn-show-print-preview btn green darken-4">Print Report</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>
@endpush

@push('script_js')
<script type="text/javascript">

  // Filter Area
  $('#area_filter').select2({
    placeholder: '-- Select Area --',
    allowClear: true,
    ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
  @if (auth()->user()->area != 'All')
    set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
    $('#area_filter').attr('disabled','disabled')
  @endif

  var table
  jQuery(document).ready(function($) {
    table = $('#table-finish-good-production').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: false,
      ajax: {
          url: '{{ url('finish-good-production') }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#global_filter').val(),
              d.area = $('#area_filter').val()
            }
      },
      order: [1, 'desc'],
      columns: [
          {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'receipt_no', name: 'receipt_no', className: 'detail'},
          {data: 'bar_ticket_header', name: 'bar_ticket_header', className: 'detail'},
          {data: 'warehouse', name: 'warehouse', className: 'detail'},
          {data: 'supplier', name: 'supplier', className: 'detail'},
          {data: 'action_view', className: 'center-align', searchable: false, orderable: false},
          {data: 'action_delete', className: 'center-align', searchable: false, orderable: false},
          {data: 'action_submit_to_inventory', className: 'center-align', searchable: false, orderable: false},
          {data: 'action_print', className: 'center-align', searchable: false, orderable: false},
      ]
    });

    table.on('click', '.btn-delete', function(event) {
          event.preventDefault();
          /* Act on the event */
          // Ditanyain dulu usernya mau beneran delete data nya nggak.
          var tr = $(this).parent().parent();
          var data = table.row(tr).data();
          swal({
            text: "Are you sure want to delete " + data.receipt_no + " and the details?",
            icon: 'warning',
            buttons: {
              cancel: true,
              delete: 'Yes, Delete It'
            }
          }).then(function (confirm) { // proses confirm
            if (confirm) {
                $.ajax({
                url: '{{ url('finish-good-production') }}' + '/' + data.receipt_no ,
                type: 'DELETE',
                dataType: 'json',
              })
              .done(function() {
                showSwalAutoClose('Success', "Data with Receipt No No. " + data.receipt_no + " has been deleted.")
                table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
              })
              .fail(function() {
                console.log("error");
              });
            }
          })
        });

    table.on('click', '.btn-print', function(event) {
      var tr = $(this).parent().parent();
      var data = table.row(tr).data();
      $('#form-print [name="receipt_no"]').val(data.receipt_no)
      $('#modal-form-print').modal('open')
    })

    {{-- Load Modal Print --}}
    @include('layouts.materialize.components.modal-print', [
      'title' => 'Print',
    ])

    $('.btn-show-print-preview').click(function(event) {
      /* Act on the event */
      initPrintPreviewPrint(
        '{{url("finish-good-production")}}' + '/' + $('#form-print [name="receipt_no"]').val() + '/export',
        $('#form-print').serialize()
      )
    });

    table.on('click', '.btn-submit-to-inventory', function(event) {
          var tr = $(this).parent().parent();
          var data = table.row(tr).data();
          swal({
            text: "Are you sure want to Submit to Inventory " + data.receipt_no + " and the details?",
            icon: 'warning',
            buttons: {
              cancel: true,
              delete: 'Yes, Submit It'
            }
          }).then(function (confirm) { // proses confirm
            if (confirm) {
              $.ajax({
                url: '{{ url('finish-good-production') }}' + '/' + data.receipt_no + '/submit-to-inventory',
                type: 'POST',
                dataType: 'json',
              })
              .done(function() {
                showSwalAutoClose("Success", "Data with Receipt No. " + data.receipt_no + " has been submited to inventory.")
                table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
              })
              .fail(function() {
                console.log("error");
              });
            }
          })
          
        });
  });

</script>
@endpush