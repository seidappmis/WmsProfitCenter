@extends('layouts.materialize.index')

@section('content')
<div class="row">

   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m6">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Marine Cargo</span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/marine-cargo') }}">Marine Cargo</a></li>
            <li class="breadcrumb-item active">New Marine Cargo</li>
         </ol>
      </div>
   </div>
   @endcomponent

   <div class="col s12">
      <div class="container">
         <div class="section">
            <div class="card">
               <div class="card-header pl-1">

               </div>
               <div class="card-content">
                  <h4 class="card-title">
                     <strong>MARINE CARGO</strong>
                  </h4>
                  <hr>
                  <form class="form-table" id="form-create">
                     @include('web.during.marine-cargo._form')
                     {!! get_button_cancel(url('marine-cargo'), 'Back') !!}
                     {!! get_button_save() !!}
                     <button type="button" class="waves-effect waves-light indigo btn-small btn-save mt-2 form-berita-acara-detail-wrapper hide" style="display: none;" id="btn-update">Update</button>
                  </form>
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
   // create
   $("#form-create").validate({
      submitHandler: function(form) {
         var formBiasa = $(form).serialize(); // form biasa
         var isiForm = new FormData($(form)[0]); // form data untuk browse file
         /* Act on the event */
         setLoading(true);
         $.ajax({
               url: '{{ url("/marine-cargo/create") }}',
               type: 'POST',
               data: isiForm,
               contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
               processData: false, // NEEDED, DON'T OMIT THIS
            })
            .done(function(result) {
               if (result.status) {
                  showSwalAutoClose('Success', result.message);
                  setTimeout(function() {
                     window.location.href = '{{ url("/marine-cargo") }}';
                  }, 1000);
                  // set_form_data(result.data.during);
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
      }
   });
</script>
@endpush