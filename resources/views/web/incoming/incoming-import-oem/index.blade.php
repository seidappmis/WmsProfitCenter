@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m3">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Incoming Import/OEM</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Incoming Import/OEM</li>
                </ol>
            </div>
            <div class="col s12 m3">
              <!---- Select ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter" class="select2-data-ajax browser-default app-filter">
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
                <a href="{{ url('incoming-import-oem/create') }}" class="btn btn-large waves-effect waves-light btn-add" type="submit" name="action">
                  New Incoming Import/OEM
                </a>
              </div>
            </div>
            <div class="col s12 m3">
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="data-table-incoming-import-oem" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>ARRIVAL NO</th>
                                    <th>PO</th>
                                    <th>VENDOR NAME</th>
                                    <th>STATUS</th>
                                    <th>DOCUMENT DATE</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                {{-- <tr>
                                  <td>1.</td>
                                  <td>OEM-WHKRW-200206-005  </td>
                                  <td>H022202002</td>
                                  <td>FUJISEI PLASTIK SEITEK,PT.</td>
                                  <td>Total Items 1</td>
                                  <td>06-Feb-2020</td>
                                  <td>
                                    {!! get_button_view(url('incoming-import-oem/1')) !!}
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

@push('script_js')
<script type="text/javascript">
    var table = $('#data-table-incoming-import-oem').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('incoming-import-oem') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val(),
            d.area = $('#area_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'arrival_no', name: 'arrival_no', className: 'detail'},
        {data: 'po', name: 'po', className: 'detail'},
        {data: 'vendor_name', name: 'vendor_name', className: 'detail'},
        {data: 'status', name: 'status', className: 'detail'},
        {data: 'document_date', name: 'document_date', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ]
  });

  table.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var tr = $(this).parent().parent();
      var data = table.row(tr).data();
      swal({
        text: "Are you sure want to delete " + data.arrival_no + " and the details?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
            $.ajax({
            url: '{{ url('incoming-import-oem') }}' + '/' + data.arrival_no ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            swal("Good job!", "Incoming with Arrival No. " + data.arrival_no + " has been deleted.", "success") // alert success
            table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            console.log("error");
          });
        }
      })
    });

  $("input#global_filter").on("keyup click", function () {
    filterGlobal();
  });

  $('#area_filter').change(function(event) {
    /* Act on the event */
    table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
  });

  $('#area_filter').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });

  // Custom search
  function filterGlobal() {
      table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush