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
                          {!! get_button_create('#!', 'New Tag', ' btn-add btn-new-tag') !!}
                           {{-- <a class="btn waves-effect waves-light btn-add btn-new-tag" href="#">New Tag</a> --}}
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
                                            <th width="20px"></th>
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
                <br>
                <div id="print-area" class="hide">
                  <h4>
                    <div class="row mb-0 mt-0">
                      <div class="col m6 print-pagination">
                         
                      </div>
                      <div class="col m6">
                        <span class="right">
                          <a id="btn-reload" href="#!" class="waves-effect waves-light indigo lighten-5 black-text btn mb-1"><i class="material-icons">refresh</i></a>
                          <a id="btn-print-export-xls" href="#!" class="waves-effect waves-light indigo lighten-5 black-text btn mb-1">EXCEL</a>
                          <a id="btn-print-export-pdf" href="#!" class="waves-effect waves-light indigo lighten-5 black-text btn mb-1">PDF</a>
                          <a id="btn-print" href="#!" class="waves-effect waves-light indigo lighten-5 black-text btn mb-1">Print</a>
                        </span>
                      </div>
                    </div>
                </h4>
                <iframe id="frame" class="frame-print" src="" width="100%" height="700px">
                </iframe>
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
       ajax: get_select2_ajax_options('{{url('/stock-take-schedule/select2-schedule')}}')
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
            {data: 'action', orderable: false, searchable: false},
        ]
      });

      dtdatatable.on('click', '.btn-edit', function(event) {
        event.preventDefault();
        /* Act on the event */
        var tr = $(this).parent().parent();
        var data = dtdatatable.row(tr).data();
        window.location.href = "{{url('stock-take-create-tag')}}" + '/' + $('#sto_id').val() + '/edit/' + data.no_tag
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
          initPrintPreview('{{ url('stock-take-create-tag/export') }}', $('#form-print').serialize())
           $('#print-area').removeClass('hide');
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
      } else if(dtdatatable.page.info().recordsDisplay == 0) {
        showSwalAutoClose('Warning', 'Can Not Create Manual No Tag, Before No Tag in Upload!')
      } else {
        window.location.href = '{{ url('stock-take-create-tag/create') }}' + '?sto_id=' + $('#sto_id').val();
      }
    });

    function setSelect2Print(sto_id){
       $('#form-print [name="no_tag_start"]').select2({
        placeholder: '',
        ajax: get_select2_ajax_options('{{url('/stock-take-create-tag/select2-no-tag')}}', {sto_id: sto_id})
      })

      $('#form-print [name="no_tag_end"]').select2({
        placeholder: '',
        ajax: get_select2_ajax_options('{{url('/stock-take-create-tag/select2-no-tag')}}', {sto_id: sto_id})
      })
    }

    // Custom search
  function filterGlobal() {
      dtdatatable.search($("#tag_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }

  function initPrintPreview(url, extraParams = null, page = 1){
    loadPrintPagination(page)
      $('.frame-print').attr("src", url + "?filetype=html" + (extraParams != null ? '&' + extraParams : '') + '&page=' + page);
      
      $('#btn-reload').click(function(event) {
        /* Act on the event */
        $('.frame-print').attr("src", $('.frame-print').attr("src"))
      });
      $('#btn-print-export-xls').attr('href', url + '?filetype=xls' + (extraParams != null ? '&' + extraParams : '') + '&page=' + page);
      $('#btn-print-export-pdf').attr('href', url + '?filetype=pdf' + (extraParams != null ? '&' + extraParams : '') + '&page=' + page);
      $('#btn-print').click(function(event) {
        /* Act on the event */
        $.ajax({
            type: 'GET',
            url: url + '?filetype=print' + (extraParams != null ? '&' + extraParams : ''),
            dataType: 'html',
            timeout: 10000,
            success: function (html) {
              w = window.open(window.location.href,"_blank");
              w.document.open();
              w.document.write(html);
              w.document.close();
              w.window.print();
              w.window.close();
            },
            error: function (data) {
              console.log('Error:', data);
            }
          });
      });
    }

    function loadPrintPagination(page){
      var total_page = $('#form-print [name="no_tag_end"]').val() - $('#form-print [name="no_tag_start"]').val();

      total_page = (total_page / 2) + 1;

      var pagination = '';
      pagination += '<ul class="pagination mb-0 mt-0">';
      pagination += '<li class="waves-effect"><a href="#"><i class="material-icons">chevron_left</i></a></li>';
      for (var i = 1; i <= total_page; i++) {
        pagination += '<li class="' + (i == page ? 'active' : 'waves-effect') + '">';
        pagination += "<a href='#!' onclick=\"initPrintPreview('{{ url('stock-take-create-tag/export') }}', $('#form-print').serialize(), " + i + ")\">" + i + '</a>';
        pagination += '</li>';
      }
      pagination += '<li class="waves-effect"><a href="#"><i class="material-icons">chevron_right</i></a></li>';
      pagination += '</ul>';

      $('.print-pagination').empty()
      $('.print-pagination').append(pagination)
    }

   
</script>
@endpush
