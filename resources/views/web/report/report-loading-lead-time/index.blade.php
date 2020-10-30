@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Loading Lead Time</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Loading Lead Time</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-3">
                        <form class="form-table" id="form-filter">
                            <table>
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="area" class="select2-data-ajax browser-default" required="">
                                        </select>
                                      </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Period</td>
                                    <td>
                                        <input placeholder="" name="periode" type="text" class="validate monthpicker" required autocomplete="off">
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <form class="form-table hide" id="form-normal-time">
                            <br>
                            <div class="section-data-tables"> 
                                <table  class="display centered" width="100%">
                                <thead>
                                    <tr>
                                      <th>NO</th>
                                      <th>Vahicle Description</th>
                                      <th>Input</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            </div>
                            <div class="input-field col s12">
                               <h href="#!" class="waves-effect waves-light indigo btn btn-submit-loading-lead-time mt-1 mb-1">Submit</h>
                             </div>
                        </form>
                    </div>
                </div>
            </div>
            
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
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_css')
<link rel="stylesheet" href="{{ asset('vendors/datepicker/datepicker.css') }}">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endpush

@push('vendor_js')
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="{{ asset('vendors/datepicker/datepicker.js') }}"></script>
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    $('.monthpicker').datepicker({
      format: 'mm/yyyy',
      autoHide: true
    });

    $('#form-filter [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });

    jQuery(document).ready(function($) {
        $('#form-filter').change(function(event) {
            /* Act on the event */
            $.ajax({
                url: '{{url("report-loading-lead-time")}}',
                type: 'GET',
                dataType: 'json',
                data: $(this).serialize(),
            })
            .done(function(result) {
                if (result.status) {
                    loadFormNormalTime(result.data)
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        });

        $('.btn-submit-loading-lead-time').click(function(event) {
            /* Act on the event */
            initPrintPreview('{{ url('report-loading-lead-time/export') }}')
           $('#print-area').removeClass('hide');
        });
    });

    function loadFormNormalTime(data){
        if (data.length > 0) {
            $('#form-normal-time tbody').empty();
            $.each(data, function(index, val) {
                 /* iterate through array or object */
                var row = '';
                row += '<tr>';
                row += '<td>' + (index+1) + '</td>';
                row += '<td>' + val.reg_vehicle_type + '</td>';
                row += '<td><input class="timepicker" name="normal_time[' + val.reg_vehicle_type + ']" type="text" value="00:00:00"></td>';
                row += '</tr>';

                $('#form-normal-time tbody').append(row)
            });
            $('.timepicker').timepicker({
                timeFormat: 'HH:mm:ss',
                interval: 5,
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
            $('#form-normal-time').removeClass('hide')
        } else {
            $('#form-normal-time').addClass('hide')
        }
    }

    function initPrintPreview(url, extraParams = null, page = 1){
    loadPrintPagination(page)
      $('.frame-print').attr("src", url + "?filetype=html" + (extraParams != null ? '&' + extraParams : '') + '&page=' + page + '&' + $("#form-normal-time").serialize() + '&' + $("#form-filter").serialize());
      
      $('#btn-reload').click(function(event) {
        /* Act on the event */
        $('.frame-print').attr("src", $('.frame-print').attr("src"))
      });
      $('#btn-print-export-xls').attr('href', url + '?filetype=xls' + (extraParams != null ? '&' + extraParams : '') + '&page=' + page + '&' + $("#form-normal-time").serialize() + '&' + $("#form-filter").serialize());
      $('#btn-print-export-pdf').attr('href', url + '?filetype=pdf' + (extraParams != null ? '&' + extraParams : '') + '&page=' + page + '&' + $("#form-normal-time").serialize() + '&' + $("#form-filter").serialize());
      $('#btn-print').click(function(event) {
        /* Act on the event */
        $.ajax({
            type: 'GET',
            url: url + '?filetype=html' + (extraParams != null ? '&' + extraParams : '') + '&' + $("#form-normal-time").serialize() + '&' + $("#form-filter").serialize(),
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
      pagination += '<li class="waves-effect"><a href="#!"><i class="material-icons">chevron_left</i></a></li>';
      for (var i = 1; i <= total_page; i++) {
        pagination += '<li class="' + (i == page ? 'active' : 'waves-effect') + '">';
        pagination += "<a href='#!' onclick=\"initPrintPreview('{{ url('report-loading-lead-time/export') }}', $('#form-print').serialize(), " + i + ")\">" + i + '</a>';
        pagination += '</li>';
      }
      pagination += '<li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>';
      pagination += '</ul>';

      $('.print-pagination').empty()
      $('.print-pagination').append(pagination)
    }
</script>
@endpush


