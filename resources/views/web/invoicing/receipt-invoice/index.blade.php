@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Receipt Invoice</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Receipt Invoice List</li>
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
            <div class="col s12 m3">
            </div>
        </div>
        <div class="row">
          <div class="col s12 m4">
            {!! get_button_create(url('receipt-invoice/create'), 'Create Reciept') !!}
            {{-- <a class="btn btn-large waves-effect waves-light btn-add" href="{{url('receipt-invoice/create')}}">
              Create Reciept
            </a> --}}
          </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="datatable-receipt-invoice" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>RECEIPT ID</th>
                                    <th>RECEIPT NO</th>
                                    <th>RECIEPT DATE</th>
                                    <th>KWITANSI NO</th>
                                    <th>EXPEDITION NAME</th>
                                    <th width="50px;"></th>
                                    <th width="50px;"></th>
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
            <!---- Button Add ----->
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
  var dtdatatable
  jQuery(document).ready(function($) {
    
    dtdatatable = $('#datatable-receipt-invoice').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{url("receipt-invoice")}}',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#global_filter').val();
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'invoice_receipt_id'},
            {data: 'invoice_receipt_no'},
            {data: 'invoice_receipt_date'},
            {data: 'kwitansi_no'},
            {data: 'expedition_name'},
            {data: 'action_view', className: 'center-align'},
            {data: 'action_delete', className: 'center-align'},
        ]
    });

    dtdatatable.on('click', '.btn-edit', function(event) {
      var id = $(this).data('id');
      window.location.href = '' ;
    });

    dtdatatable.on('click', '.btn-delete', function(event) {
      var tr = $(this).parent().parent();
      var data = dtdatatable.row(tr).data();
      id = data.id
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        text: "Delete the record ?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '{{url('receipt-invoice')}}' + '/' + id,
            type: 'DELETE',
          })
          .done(function(result) { // Kalau ajax nya success
            if (result.status) {
              showSwalAutoClose('Success', result.message)
              dtdatatable.ajax.reload(null, false); // reload datatable
            }
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
        }
      })
    });

    $("input#global_filter").on("keyup click", function () {
        filterGlobal();
      });
  });

  function filterGlobal() {
      dtdatatable.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush