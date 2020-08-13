@push('page-modal')

  @php
  $print_selector_id = str_replace(' ', '', $title);
  $show_button = [];
  @endphp

  <!-- Modal Structure -->
  <div id="modal-print-{{$print_selector_id}}" class="modal modal-fixed-footer" style="min-width: 80%; min-height: 85%; height: 85%;">
    <div class="modal-content" style="height: 90vh;">
      @include('layouts.materialize.components.print-area')
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>
@endpush

@push('script_js')
  <script type="text/javascript">
    @if(!empty($trigger))
    jQuery(document).ready(function($) {
      $('{{$trigger}}').click(function(event) {
        /* Act on the event */
        $('#modal-print-{{$print_selector_id}}').modal('open');
        initPrintPreview{{$print_selector_id}}('{{url($url)}}');
      });
    });
    @endif

    function initPrintPreview{{$print_selector_id}}(url, extraParams = null){
      $('#modal-print-{{$print_selector_id}}').modal('open');
      $('#frame').attr("src", url + "?filetype=html" + (extraParams != null ? '&' + extraParams : ''));
      
      $('#btn-print-export-xls-{{$print_selector_id}}').attr('href', url + '?filetype=xls' + (extraParams != null ? '&' + extraParams : ''));
      $('#btn-print-export-pdf-{{$print_selector_id}}').attr('href', url + '?filetype=pdf' + (extraParams != null ? '&' + extraParams : ''));
    }
  </script>
@endpush