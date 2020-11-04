@extends('layouts.materialize.index')


@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Concept Issue (%)</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Concept Issue</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-3">
                        <form class="form-table" id="form-concept-issue">
                            <table id="data-table-simple" class="display" width="100%">
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
                            <div class="input-field col s12">
                                <a href="#!" type="submit" class="waves-effect btn-submit waves-light indigo btn">Submit</a>
                              </div>
                        </form>
                       <br>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content p-3">
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
                        {{-- <img src="" id="img_graph" width="100%"> --}}
                        {{-- @include('web.report.concept-issue.grap') --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_css')
<link rel="stylesheet" href="{{ asset('vendors/datepicker/datepicker.css') }}">
@endpush

@push('vendor_js')
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
    jQuery(document).ready(function($) {
        $('#form-concept-issue [name="area"]').select2({
           placeholder: '-- Select Area --',
           allowClear: true,
           ajax: get_select2_ajax_options('/master-area/select2-area-only')
        });

        $('#form-concept-issue').validate({
            submitHandler: function (form){
                $('#img_graph').attr('src', '{{url('concept-issue/graph')}}' + '?' + $(form).serialize());
            }
        })

        $('.btn-submit').click(function(event) {
            /* Act on the event */
            initPrintPreview('{{ url('concept-issue/export') }}')
           $('#print-area').removeClass('hide');
        });

    });

    function initPrintPreview(url, extraParams = null, page = 1){
    // loadPrintPagination(page)
      $('.frame-print').attr("src", url + "?filetype=html" + (extraParams != null ? '&' + extraParams : '') + '&' + $("#form-concept-issue").serialize());
      
      $('#btn-reload').click(function(event) {
        /* Act on the event */
        $('.frame-print').attr("src", $('.frame-print').attr("src"))
      });
      $('#btn-print-export-xls').attr('href', url + '?filetype=xls' + (extraParams != null ? '&' + extraParams : '') + '&' + $("#form-concept-issue").serialize());
      $('#btn-print-export-pdf').attr('href', url + '?filetype=pdf' + (extraParams != null ? '&' + extraParams : '') + '&' + $("#form-concept-issue").serialize());
      $('#btn-print').click(function(event) {
        /* Act on the event */
        $.ajax({
            type: 'GET',
            url: url + '?filetype=html' + (extraParams != null ? '&' + extraParams : '') + '&' + $("#form-concept-issue").serialize(),
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
</script>
@endpush