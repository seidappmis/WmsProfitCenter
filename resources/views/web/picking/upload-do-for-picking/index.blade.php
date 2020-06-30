@extends('layouts.materialize.index')
@include('web.picking.upload-do-for-picking.modal-upload-do')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8 l8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Upload DO for Picking</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Upload DO for Picking</li>
                </ol>
            </div>
            <div class="col s12 m4 l4">
                <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div>
                </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="row mb-1">
                            <div class="col s12 m6">
                              <div class="display-flex">
                                <!---- Search ----->
                                <!-- Modal Trigger -->
                                <a class="waves-effect waves-light btn modal-trigger indigo btn mt-1 mr-1 " href="#modal1">Upload DO</a>
                                {!! get_button_delete('Multi Delete Selected Items', 'btn-multi-delete-selected-item mt-1') !!}
                              </div>
                            </div>
                        </div>
                        
                        <div class="section-data-tables"> 
                          <table id="do-for-picking-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" class="datatable-checkbox-cell" width="30px">
                                      <label>
                                          <input type="checkbox" class="select-all" />
                                          <span></span>
                                      </label>
                                    </th>
                                    <th data-priority="2" width="30px">No.</th>
                                    <th>DELIVERY NO.</th>
                                    <th>DELIVERY ITEM</th>
                                    <th>DO DATE</th>
                                    <th>CUSTOMER CODE</th>
                                    <th>CUSTOMER NAME</th>
                                    <th>MODEL</th>
                                    <th>EAN CODE</th>
                                    <th>QTY</th>
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
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#do-for-picking-table').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('upload-do-for-picking') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [2, 'asc'],
    columns: [
        {
          data: 'DT_RowIndex',
          orderable: false,
          render: function ( data, type, row ) {
              if ( type === 'display' ) {
                  return '<label><input type="checkbox" name="id[]" value="" class="checkbox"><span></span></label>';
              }
              return data;
          },
          className: "datatable-checkbox-cell"
        },
        // {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'delivery_no', name: 'delivery_no', className: 'detail'},
        {data: 'delivery_items', name: 'delivery_items', className: 'detail'},
        {data: 'do_date', name: 'do_date', className: 'detail'},
        {data: 'kode_customer', name: 'kode_customer', className: 'detail'},
        {data: 'long_description_customer', name: 'long_description_customer', className: 'detail'},
        {data: 'model', name: 'model', className: 'detail'},
        {data: 'ean_code', name: 'ean_code', className: 'detail'},
        {data: 'quantity', name: 'quantity', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ],
  });

    jQuery(document).ready(function($) {
      dtdatatable.ajax.reload(null, false)
      $("#form-upload-do-for-picking").validate({
        submitHandler: function(form) {
          var fdata = new FormData(form);
          $.ajax({
            url: '{{ url("upload-do-for-picking") }}',
            type: 'POST',
            data: fdata,
            contentType: "application/json",
            dataType: "json",
            contentType: false,
            processData: false
          })
          .done(function(data) { // selesai dan berhasil
            data_concept = data;
            if (data.status == false) {
              $('#table-concept tbody').empty();
              swal("Failed!", data.message, "warning");
              return;
            }
            swal("Good job!", "You clicked the button!", "success")
              .then((result) => {
                 $('#modal1').modal('close');
                 dtdatatable.ajax.reload(null, false)
              }) // alert success
          })
          .fail(function(xhr) {
              showSwalError(xhr) // Custom function to show error with sweetAlert
          });
        }
      });
    });

    set_datatables_checkbox('#do-for-picking-table', dtdatatable)

    $('.btn-multi-delete-selected-item').click(function(event) {
      /* Act on the event */
      swal({
        title: "Are you sure?",
        text: "Are you sure delete selected DO items?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        var data_do = [];
        dtdatatable.$('input[type="checkbox"]').each(function() {
           /* iterate through array or object */
           if(this.checked){
            var row = $(this).closest('tr');
            var row_data = dtdatatable.row(row).data();
            data_do.push(row_data);
           }
        });
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '{{ url('upload-do-for-picking/multi-delete-selected-item') }}' ,
            type: 'DELETE',
            data: 'data_do=' + JSON.stringify(data_do),
          })
          .done(function() { // Kalau ajax nya success
            swal("Good job!", "You clicked the button!", "success") // alert success
            if ($('thead input[type="checkbox"]', dtdatatable.table().container()).attr("checked")) {
              $('thead input[type="checkbox"]', dtdatatable.table().container()).trigger('click')
            }
            dtdatatable.ajax.reload(null, false); // reload datatable
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
    });


    dtdatatable.on('click', '.btn-edit', function(event) {
      var id = $(this).data('id');
      window.location.href = '' ;
    });

    $("input#global_filter").on("keyup click", function () {
    filterGlobal();
  });

  // Custom search
  function filterGlobal() {
      dtdatatable.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }

    dtdatatable.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      var tr = $(this).parent().parent();
      var data = dtdatatable.row(tr).data();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '{{ url('upload-do-for-picking') }}' ,
            type: 'DELETE',
            data: 'invoice_no=' + data.invoice_no + '&delivery_no=' + data.delivery_no + '&delivery_items=' + data.delivery_items 
          })
          .done(function() { // Kalau ajax nya success
            swal("Good job!", "You clicked the button!", "success") // alert success
            dtdatatable.ajax.reload(null, false); // reload datatable
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
    });
</script>
@endpush