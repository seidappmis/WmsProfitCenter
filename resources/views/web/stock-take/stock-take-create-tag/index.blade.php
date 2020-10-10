@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m6">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Create Tag</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Stock Take Create Tag</li>
              </ol>
          </div>
          {{-- <div class="col s12 m6">
            <div class="display-flex">
              <!---- Search ----->
              <div class="app-wrapper mr-2">
                <div class="datatable-search">
                  <i class="material-icons mr-2 search-icon">search</i>
                  <input type="text" placeholder="Search" class="app-filter" id="tag_filter">
                </div>
              </div>
            </div>
          </div> --}}
          <div class="col s12 m3"></div>
      </div>
      
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content">
                  <form id="form-stock-take-create-tag">
                  <div class="row mb-5">
                    <div class="col s12 m2 pt-2">
                        <p>Periode STO</p>
                    </div>
                    <div class="col s12 m4">
                      <!---- Filter STO ID ----->
                      <div class="app-wrapper ml-3">
                        <div class="datatable-search">
                          <select id="sto_id" name="sto_id">
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Upload File -->
                  <div class="row">
                    <div class="col s12 m2 pt-2">
                        <p>Data File</p>
                    </div>
                    <div class="col s12 m10">
                      <div class="file-field input-field col s12 m6 l6">
                        <div class="btn btn-small waves-effect waves-light">
                          <span>Browse</span>
                          <input type="file" name="file-stock-take-tag">
                        </div>
                        <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" placeholder="Select File..">
                        </div>
                      </div>
                      <div class="col s12 m6 l6 mt-4">
                        <p>Format File : .csv*</p>
                      </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 mb-2">
                        {!! get_button_save('Submit') !!}
                        {!! get_button_print('#', 'Print', 'btn-print mt-2') !!}
                    </div>
                  </div>
                  </form>

                <!-- Main Table -->
                <div class="container">
                    <div class="section">
                      <div class="row">
                        <div class="col m6">
                           <a class="btn waves-effect waves-light btn-add btn-new-tag" href="#">New Tag</a>
                        </div>
                        <div class="col m6 right-align">
                          <input type="text" placeholder="Search" class="app-filter" id="tag_filter">
                        </div>
                      </div>
                        <div class="card">
                            <div class="card-content p-0">
                                <div class="section-data-tables">
                                  <table id="data-table-section-contents" class="display" width="100%">
                                      <thead>
                                          <tr>
                                            <th data-priority="1" width="30px">No.</th>
                                            <th>No Tag</th>
                                            <th>Model</th>
                                            <th>Location</th>
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

                    <table id="data-table-print" class="display hide" width="100%">
                        <thead>
                            <tr>
                              <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- datatable ends -->
                   </div>
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
        <input type="hidden" name="sto_id">
        <table>
          <tr>
            <td width="100px">No Tag Start</td>
            <td>
              <div class="input-field">
                <select name="no_tag_start" required="" class="select2-data-ajax browser-default"></select>
              </div>
            </td>
          </tr>
          <tr>
            <td width="100px">No Tag End</td>
            <td>
              <div class="input-field">
                <select name="no_tag_end" required="" class="select2-data-ajax browser-default"></select>
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

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
   $('#sto_id').select2({
       placeholder: '-- Select Schedule ID --',
       allowClear: true,
       ajax: get_select2_ajax_options('/stock-take-schedule/select2-schedule')
    });

    

    var dtdatatable;
    jQuery(document).ready(function($) {

    
      $("#form-stock-take-create-tag").validate({
        submitHandler: function(form) {
          setLoading(true); // Disable Button when ajax post data
          var fdata = new FormData(form);
          $.ajax({
            url: '{{ url("stock-take-create-tag") }}',
            type: 'POST',
            data: fdata,
            contentType: "application/json",
            dataType: "json",
            contentType: false,
            processData: false
          })
          .done(function(data) { // selesai dan berhasil
            setLoading(false);
            if (data.status == false) {
              showSwalAutoClose('Failed !', data.message)
              // swal("Failed!", data.message, "warning");
              return;
            }
            showSwalAutoClose("Success", data.message)
            dtdatatable.ajax.reload(null, false)
          })
          .fail(function(xhr) {
              setLoading(false);
              showSwalError(xhr) // Custom function to show error with sweetAlert
          });
        }
      });

      dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('stock-take-create-tag') }}',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#tag_filter').val(),
                d.sto_id = $('#sto_id').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'no_tag', name: 'no_tag', className: 'detail'},
            {data: 'model', name: 'model', className: 'detail'},
            {data: 'location', name: 'location', className: 'detail'},
        ]
      });

      $("input#tag_filter").on("keyup click", function () {
        filterGlobal();
      });

      $('.btn-print').click(function(event) {
        /* Act on the event */
        setSelect2Print($('#sto_id').val())
        $('#form-print [name="sto_id"]').val($('#sto_id').val());
        $('#modal-form-print').modal('open');
      });

      $('.btn-show-print-preview').click(function(event) {
          /* Act on the event */
        $('#modal-form-print').modal('close');
         $('#data-table-print').removeClass('hide')
         setTimeout(function() {
          
         }, 10);
        });

      $('#sto_id').change(function(event) {
        /* Act on the event */
        dtdatatable.ajax.reload(null, false)
      });

        @if(!empty($sto_id))
      set_select2_value('#sto_id', '{{$sto_id}}', '{{$sto_id}}')
      @endif

    });

    $('.btn-new-tag').click(function(event) {
      /* Act on the event */
      if ($('#sto_id').val() == '' || $('#sto_id').val() == null) {
        showSwalAutoClose('Warning', 'Please Select STO ID!')
      } else {
        window.location.href = '{{ url('stock-take-create-tag/create') }}' + '?sto_id=' + $('#sto_id').val();
      }
    });

    function setSelect2Print(sto_id){
       $('#form-print [name="no_tag_start"]').select2({
        placeholder: '',
        ajax: get_select2_ajax_options('/stock-take-create-tag/select2-no-tag', {sto_id: sto_id})
      })

      $('#form-print [name="no_tag_end"]').select2({
        placeholder: '',
        ajax: get_select2_ajax_options('/stock-take-create-tag/select2-no-tag', {sto_id: sto_id})
      })
    }

    // Custom search
  function filterGlobal() {
      dtdatatable.search($("#tag_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }

   
</script>
@endpush
