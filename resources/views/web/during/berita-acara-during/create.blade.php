@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
  <div class="row">
    <div class="col s12 m6">
      <h5 class="breadcrumbs-title mt-0 mb-0"><span>Berita Acara During</span></h5>
      <ol class="breadcrumbs mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item">Berita Acara During</li>
        <li class="breadcrumb-item active">Create Berita Acara During</li>
      </ol>
    </div>
  </div>
  @endcomponent

  <div class="col s12">
    <div class="container">
      <div class="section">
        <div class="card">
          <div class="card-header pl-1">

            {!! get_button_cancel(url('berita-acara-during'), 'Back') !!}
          </div>
          <div class="card-content">
            <h4 class="card-title">
              <strong>BERITA ACARA DURING</strong>
            </h4>
            <hr>
            @include('web.during.berita-acara-during._form_berita_acara_during')
          </div>
          <div id="section-berita-acara-during-detail" style="display: block;" class="card-content">
            <!-- Berita Acara Detail -->
            <h4 class="card-title"><strong>BERITA ACARA DETAIL</strong></h4>
            <hr>
            @include('web.during.berita-acara-during._form_berita_acara_detail')
          </div>
        </div>
      </div>
    </div>
    <div class="content-overlay"></div>
  </div>
</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  var berita_acara_id = 0;
  jQuery(document).ready(function($) {
    $('.collapsible').collapsible({
      accordion: true
    });

    $('#section-berita-acara-during-detail').hide();
  });

  $("#form-berita-acara-during").validate({
    submitHandler: function(form) {
      var formBiasa = $(form).serialize(); // form biasa
      var isiForm = new FormData($(form)[0]); // form data untuk browse file

      /* Act on the event */
      setLoading(true);
      $.ajax({
          url: '{{ url("/berita-acara-during/create") }}',
          type: 'POST',
          data: isiForm,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
        })
        .done(function(result) {
          if (result.status) {
            showSwalAutoClose('Success', result.message);
            set_form_data(result.data.during);
          } else {
            setLoading(false);
            showSwalAutoClose('Warning', result.message)
          }
        })
        .fail(function() {
          setLoading(false);
        })
        .always(function() {
          setLoading(false);
        });
    }
  });

  function set_form_data(data) {
    $('#section-berita-acara-during-detail').show();
    $('#form-berita-acara-during #btn-update').show();
    $('#form-berita-acara-during [type="submit"]').hide();

    $('#form-berita-acara-during [name="berita_acara_during_no"]').val(data.berita_acara_during_no);
    $('#form-berita-acara-during [name="tanggal_berita_acara"]').val(data.tanggal_berita_acara);
    $('#form-berita-acara-during [name="ship_name"]').val(data.ship_name);
    $('#form-berita-acara-during [name="expedition_code"]').val(data.expedition_code);
    $('#form-berita-acara-during [name="invoice_no"]').val(data.invoice_no);
    $('#form-berita-acara-during [name="vehicle_number"]').val(data.vehicle_number);
    $('#form-berita-acara-during [name="container_no"]').val(data.container_no);
    $('#form-berita-acara-during [name="weather"]').val(data.weather);
    $('#form-berita-acara-during [name="bl_no"]').val(data.bl_no);
    $('#form-berita-acara-during [name="working_hour"]').val(data.working_hour);
    $('#form-berita-acara-during [name="location"]').val(data.location);
    $('#form-berita-acara-during [name="damage_type"]').val(data.damage_type);
    $('#form-berita-acara-during [name="seal_no"]').val(data.seal_no);

    set_select2_value('#form-berita-acara-during [name="expedition_code"]', data.expedition_code, data.expedition_name);
    set_select2_value('#form-berita-acara-during [name="vehicle_number"]', data.vehicle_number, data.vehicle_number);

    $('#form-berita-acara-during #img_file_photo_container_came').show();
    $('#form-berita-acara-during #img_file_photo_container_came img').attr("src", "{{asset('storage')}}" + '/' + data.photo_container_came);
    $('#form-berita-acara-during #img_file_photo_container_came a').attr("href", "{{asset('storage')}}" + '/' + data.photo_container_came);

    $('#form-berita-acara-during #img_file_photo_loading').show();
    $('#form-berita-acara-during #img_file_photo_loading img').attr("src", "{{asset('storage')}}" + '/' + data.photo_loading);
    $('#form-berita-acara-during #img_file_photo_loading a').attr("href", "{{asset('storage')}}" + '/' + data.photo_loading);

    $('#form-berita-acara-during #img_file_photo_seal_no').show();
    $('#form-berita-acara-during #img_file_photo_seal_no img').attr("src", "{{asset('storage')}}" + '/' + data.photo_seal_no);
    $('#form-berita-acara-during #img_file_photo_seal_no a').attr("href", "{{asset('storage')}}" + '/' + data.photo_seal_no);

    $('#form-berita-acara-during #img_file_photo_container_loading').show();
    $('#form-berita-acara-during #img_file_photo_container_loading img').attr("src", "{{asset('storage')}}" + '/' + data.photo_container_loading);
    $('#form-berita-acara-during #img_file_photo_container_loading a').attr("href", "{{asset('storage')}}" + '/' + data.photo_container_loading);
  }
</script>
@endpush