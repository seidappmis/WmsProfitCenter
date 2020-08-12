@push('page-modal')

  @php
  $print_selector_id = str_replace(' ', '', $title);
  $show_button = [];
  @endphp

  <!-- Modal Structure -->
  <div id="modal-print-{{$print_selector_id}}" class="modal modal-fixed-footer" style="min-width: 80%; min-height: 85%; height: 85%;">
    <div class="modal-content" style="height: 90vh;">
      <h4>
      {{$title}}
      <span class="right">
        <a id="btn-print-export-xls-{{$print_selector_id}}" href="#!" class="waves-effect waves-light indigo lighten-5 black-text btn mb-1">EXCEL</a>
        <a id="btn-print-export-pdf-{{$print_selector_id}}" href="#!" class="waves-effect waves-light indigo lighten-5 black-text btn mb-1">PDF</a>
      </span>
    </h4>
      <iframe id="frame" src="" width="100%" height="83%">
     </iframe>
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