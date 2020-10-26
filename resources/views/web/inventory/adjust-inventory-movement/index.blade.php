@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6 mb-1">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Adjust Inventory Movement</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Adjust Inventory Movement</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content">
                  @include('web.inventory.adjust-inventory-movement._form')
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
    $("#form-adjust-inventory-movement").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("adjust-inventory-movement") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          showSwalAutoClose('Success', 'Adjust success.')
          var qty_total = parseInt($('#form-adjust-inventory-movement [name="prev_quantity"]').val())
          if ($('#form-adjust-inventory-movement [name="movement_code_type_action"]').val() == "INCREASE") {
            qty_total += parseInt($('#form-adjust-inventory-movement [name="quantity"]').val())
          } else {
            qty_total -= parseInt($('#form-adjust-inventory-movement [name="quantity"]').val())
          }
          $('#form-adjust-inventory-movement [name="prev_quantity"]').val(qty_total)
          $('#form-adjust-inventory-movement [name="quantity"]').val(0)
          setLoading(false)
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush
