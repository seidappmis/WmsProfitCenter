<form class="form-table" id="form-berita-acara" onsubmit="return false;">
  <input type="hidden" name="id">
  <table>
    <tr>
      <td>No. Berita Acara</td>
      <td>
        <input id="berita_acara_no" name="berita_acara_no" type="text" class="validate" value="" placeholder="[AUTO]" readonly>
      </td>
    </tr>
    <tr>
      <td>Tanggal Terima</td>
      <td>
        <input id="date_of_receipt" name="date_of_receipt" type="text" class="validate datepicker" value="{{date('Y-m-d')}}">
      </td>
    </tr>
    <tr>
      <td>Expedition</td>
      <td>
        <select id="expedition_code" name="expedition_code" class="select2-data-ajax browser-default">
        </select>
        <input type="hidden" name="expedition_name">
      </td>
    </tr>
    <tr>
      <td>Driver</td>
      <td>
        <select id="driver_name" name="driver_name" class="select2-data-ajax browser-default">
        </select>
      </td>
    </tr>
    <tr>
      <td>Vehicle Number</td>
      <td>
        <select id="vehicle_number" name="vehicle_number" class="select2-data-ajax browser-default">
        </select>
      </td>
    </tr>
    <tr>
      <td>DO Manifest</td>
      <td>
        <div class="file-field input-field">
          <div class="btn">
            <span>Choose New Image</span>
            <input type="file" name="file-do-manifest">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
        @if(isset($beritaAcara->do_manifest))
        <div id="img_file_do_manifest" style="display: none;" class="text-center">
          <img class="materialboxed" width="200" height="200" src="">
          <a download="" href="/path/to/image" title="img_file_do_manifest" class="btn mt-1">
            Download
          </a>
          <a class="waves-effect waves-light red darken-4 btn-small btn-delete-image btn mt-1 ml-1 form-berita-acara-detail-wrapper hide" data-type="do_manifest" data-name="DO MANIFEST">Delete</a>
        </div>
        @endif
      </td>
    </tr>
    <tr>
      <td>Internal DO / DO</td>
      <td>
        <div class="file-field input-field">
          <div class="btn">
            <span>Choose New Image</span>
            <input type="file" name="file-internal-do">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
        @if(isset($beritaAcara->internal_do))
        <div id="img_file_internal_do" style="display: none;" class="text-center">
          <img class="materialboxed" width="200" height="200" src="">
          <a download="" href="/path/to/image" title="img_file_internal_do" class="btn mt-1">
            Download
          </a>
          <a class="waves-effect waves-light red darken-4 btn-small btn-delete-image btn mt-1 ml-1 form-berita-acara-detail-wrapper hide" data-type="internal_do" data-name="INTERNAL DO / DO">Delete</a>
        </div>
        @endif
      </td>
    </tr>
    <tr>
      <td>LMB</td>
      <td>
        <div class="file-field input-field">
          <div class="btn">
            <span>Choose New Image</span>
            <input type="file" name="file-lmb">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
        @if(isset($beritaAcara->lmb))
        <div id="img_file_lmb" style="display: none;" class="text-center">
          <img class="materialboxed" width="200" height="200" src="">
          <a download="" href="/path/to/image" title="img_file_lmb" class="btn mt-1">
            Download
          </a>
          <a class="waves-effect waves-light red darken-4 btn-small btn-delete-image btn mt-1 ml-1 form-berita-acara-detail-wrapper hide" data-type="lmb" data-name="LMB">Delete</a>
        </div>
        @endif
      </td>
    </tr>

  </table>
  {!! get_button_save() !!}
  {!! get_button_cancel(url('berita-acara'), 'Back') !!}
</form>

@push('script_js')
<script type="text/javascript">
  set_select_expedition()
  set_select_driver()
  set_select_vehicle_number()

  jQuery(document).ready(function($) {
    $('.btn-delete-image').click(function() {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var attribute = $(this),
        div = attribute.parent(),
        img = div.find('img'),
        href = div.find('a');

      setLoading(true);
      swal({
        text: "Are you sure want to delete " + attribute.attr('data-name') + " Image ?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function(confirm) { // proses confirm
        if (confirm) {
          $.ajax({
              url: ('{{ url("/berita-acara/:id/delete/:type") }}').replace(':id', $('#form-berita-acara [name="id"]').val()).replace(':type', attribute.attr('data-type')),
              type: 'DELETE',
              contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
              processData: false, // NEEDED, DON'T OMIT THIS
            })
            .done(function(result) {
              if (result.status) {
                showSwalAutoClose('Success', result.message);
                img.attr('src', '');
                href.attr('href', '');
                div.hide();
              } else {
                showSwalAutoClose('Warning', result.message)
              }
              setLoading(false);
            })
            .fail(function() {
              setLoading(false);
            })
            .always(function() {
              setLoading(false);
            });
        } else {
          setLoading(false)
        }
      })
    });
  });

  $('#form-berita-acara [name="expedition_code"]').change(function(event) {
    /* Act on the event */
    var data = $(this).select2('data')[0]
    set_select_driver({
      expedition_code: $(this).val()
    })
    set_select_vehicle_number({
      expedition_code: $(this).val()
    })
    // set_select2_value('#form-berita-acara [name="driver_name"]', '', '')
    // set_select2_value('#form-berita-acara [name="vehicle_number"]', '', '')
    $('#form-berita-acara [name="expedition_name"]').val(data.text)
  });

  function set_select_expedition() {
    $('#form-berita-acara [name="expedition_code"]').select2({
      placeholder: '-- Select Expedition --',
      ajax: get_select2_ajax_options('/master-expedition/select2-active-expedition')
    })
  }

  function set_select_driver(filter = {
    expedition_code: ''
  }) {
    $('#form-berita-acara [name="driver_name"]').select2({
      placeholder: '-- Select Driver --',
      @if(auth()->user()->cabang->hq)
      ajax: get_select2_ajax_options('/master-driver/select2-driver-expedition', filter)
      @else
      ajax: get_select2_ajax_options('/master-driver/select2-branch-driver-expedition', filter)
      @endif
    })
  }

  function set_select_vehicle_number(filter = {
    expedition_code: ''
  }) {
    $('#form-berita-acara [name="vehicle_number"]').select2({
      placeholder: '-- Select Vehicle Number --',
      @if(auth()->user()->cabang->hq)
      ajax: get_select2_ajax_options('/master-vehicle-expedition/select2-vehicle-number', filter)
      @else
      ajax: get_select2_ajax_options('{{url('/branch-expedition-vehicle/select2-vehicle-number-without-vehicle-type')}}', filter)
      @endif
    })
  }
</script>
@endpush