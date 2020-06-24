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
                    <li class="breadcrumb-item active"><a href="{{ url('stock-take-schedule') }}">View Detail</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Edit Stock Take SAP</div>
                          <div class="collapsible-body">
                          <form class="form-table" id="form-stocktake-schedule-detail">
                            <table>
                              <tr>
                                <td>STO NO.</td>
                                <td>
                                  <div class="input-field col s12 m4">
                                    <input id="sto_id" type="text" class="validate" name="sto_id" value="{{old('sto_id', !empty($stockTakeScheduleDetail) ? $stockTakeScheduleDetail->sto_id : '')}}" required readonly>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>MATERIAL NO.</td>
                                <td>
                                  <div class="input-field col s12 m4">
                                    <input id="material_no" type="text" class="validate" name="material_no" value="{{old('material_no', !empty($stockTakeScheduleDetail) ? $stockTakeScheduleDetail->material_no : '')}}" required readonly>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>QTY</td>
                                <td>
                                  <div class="input-field col s12 m4">
                                    <input id="qty" name="qty" type="text" class="validate" value="{{old('qty', !empty($stockTakeScheduleDetail) ? $stockTakeScheduleDetail->qty : '')}}" required>
                                  </div>
                                </td>
                              </tr>
                            </table>
                            {!! get_button_save() !!}
                            {!! get_button_cancel(url('stock-take-schedule/' . $stockTakeSchedule->sto_id)) !!}
                          </form>
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

    $('.btn-save').html('Update');
  });

  $("#form-stocktake-schedule-detail").validate({
    submitHandler: function(form) {
      $.ajax({
        url: '{{ url("stock-take-schedule/" . $stockTakeSchedule->sto_id . "/view-detail/" . $stockTakeScheduleDetail->id) }}',
        type: 'PUT',
        data: $(form).serialize(),
      })
      .done(function() { // selesai dan berhasil
        swal("Good job!", "You clicked the button!", "success")
          .then((result) => { 
            // Kalau klik Ok redirect ke index
            window.location.href = "{{ url('stock-take-schedule/' . $stockTakeSchedule->sto_id) }}"
          }) // alert success
      })
      .fail(function(xhr) {
          showSwalError(xhr) // Custom function to show error with sweetAlert
      });
    }
  });
</script>
@endpush