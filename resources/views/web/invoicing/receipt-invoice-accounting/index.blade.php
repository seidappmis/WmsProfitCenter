@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Receipt Invoice Accounting</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Receipt Invoice Accounting</li>
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
            <a class="btn btn-large waves-effect waves-light btn-add" href="{{url('receipt-invoice-accounting/create')}}">
              New Report
            </a>
          </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="table_report_accounting" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>REPORT ACCOUNTING DATE</th>
                                    <th>REPORT ID</th>
                                    <th>INVOICE RECEIPT ID</th>
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
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#table_report_accounting').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '/receipt-invoice-accounting',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#global_filter').val();
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'group_id_report'},
            {data: 'group_id_report'},
            {data: 'invoice_receipt_id'},
            {data: 'action', className: 'center-align'},
        ]
    });


    dtdatatable.on('click', '.btn-delete', function(event) {
      var tr = $(this).parent().parent();
      var data = dtdatatable.row(tr).data();
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        title: "Are you sure?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Roll It back'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '/receipt-invoice-accounting/' + data.group_id_report,
            type: 'DELETE',
          })
          .done(function(result) { // Kalau ajax nya success
            if(result.status){
              showSwalAutoClose('Success', result.message);
              dtdatatable.ajax.reload(null, false); // reload datatable
            } else {
              showSwalAutoClose("Failed", result.message);
            }
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
    });
</script>
@endpush