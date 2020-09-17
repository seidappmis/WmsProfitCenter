@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Schedule</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('stock-take-schedule') }}">Stock Take Schedule</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="row">
      <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Add Stock Take Schedule</div>
                          <div class="collapsible-body">
                          @include('web.stock-take.stock-take-schedule._form')
                          </div>
                        </li>
                      </ul>
                    </div>
                </div>
            </div>
            </div>
        </div>
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

    // setDataFromFilter();
  });
 	

  // data select filter from localstorage index
  function setDataFromFilter() {
    var stockTakeScheduleFilter = JSON.parse(localStorage.getItem('stockTakeScheduleFilter'));

    if (stockTakeScheduleFilter.type == 'area') {
      $('#kode').val(stockTakeScheduleFilter.value);
      $('#area').val(stockTakeScheduleFilter.text);
    } else if (stockTakeScheduleFilter.type == 'branch'){
      $('#kode_cabang').val(stockTakeScheduleFilter.value);
      $('#desc_cabang').val(stockTakeScheduleFilter.text);
    }
  }
  
  $("#form-stock-take-schedule").validate({
      submitHandler: function(form) {
        var fdata = new FormData(form);
        $.ajax({
          url: '{{ url("stock-take-schedule") }}',
          type: 'POST',
          data: fdata,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false
        })
        .done(function(data) { // selesai dan berhasil
          // console.log(data);
          if (data.status == false) {
            swal("Failed!", data.message, "warning");
            return;
          }
          showSwalAutoClose('Success', 'Stock Take Schedule Success')
          window.location.href = "{{ url('stock-take-schedule') }}"
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush