@push('page-modal')
<!-- Modal Structure -->
  <div id="modal-print" class="modal modal-fixed-footer" style="min-width: 80%; min-height: 85%; height: 85%;">
    <div class="modal-content" style="height: 90vh;">
      <h4>
      {{$title}}
      <span class="right">
        <a href="{{ url($url . '?filetype=xls') }}" class="waves-effect waves-light indigo lighten-5 black-text btn mb-1">EXCEL</a>
        <a href="{{ url($url . '?filetype=pdf') }}" class="waves-effect waves-light indigo lighten-5 black-text btn mb-1">PDF</a>
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
  jQuery(document).ready(function($) {
    $('{{$trigger}}').click(function(event) {
      /* Act on the event */
      $('#modal-print').modal('open');
      $('#frame').attr("src", "{{ url($url . '?filetype=html') }}");
    });
  });
</script>
@endpush