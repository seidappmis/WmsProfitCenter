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
                    <div class="card-content">
                      <h4 class="card-title"><strong>BERITA ACARA DURING</strong></h4>
                      <hr> 
                      @include('web.during.berita-acara-during._form_berita_acara_during')
                    </div>
                    <div class="card-content">
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
  jQuery(document).ready(function($) {
    $('.collapsible').collapsible({
        accordion:true
    });

    $('#form-berita-acara select').attr('required', 'required');
    
  });

  $("#form-berita-acara").validate({
      submitHandler: function(form) {
        var formBiasa = $(form).serialize(); // form biasa
        var isiForm = new FormData($(form)[0]); // form data untuk browse file
        // console.log(formBiasa)
        // console.log(isiForm)
        $.ajax({
          url: '{{ url("berita-acara") }}',
          type: 'POST',
          data: isiForm,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
        })
        .done(function(response) { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke view
              window.location.href = "{{ url('berita-acara') }}" + '/' + response.id
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush