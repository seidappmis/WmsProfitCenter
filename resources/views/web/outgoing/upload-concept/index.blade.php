@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Upload Concept</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Upload Concept</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <form id="form-upload-concept">
                        <div class="file-field input-field">
                            <div class="row">
                                <div class="col m2">
                                    Data File
                                </div>
                                <div class="col m10">
                                  <div class="btn btn-sm">
                                    <span>Browse</span>
                                    <input type="file" name="file_concept">
                                  </div>
                                  <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="select file"> File Format: csv
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <div class="row">
                                <div class="col m2">
                                    Area
                                </div>
                                <div class="col m4">
                                  <select name="area" class="select2-data-ajax browser-default app-filter" required>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="input-field col s12 m12 mb-2">
                          <button class="btn btn-sm waves-effect waves-light btn-add" type="submit">
                            UPLOAD
                          </button>
                        </div>
                      </form>

                      <div id="concept-wrapper" style="display: none;">
                        <table id="table-concept" class="table striped table-scroll-x">
                          <thead>
                            <tr>
                              <th>VEHICLE_NO</th>
                              <th>LINE_NO</th>
                              <th>OUTPUT_DATE</th>
                              <th>OUTPUT_TIME</th>
                              <th>DESTINATION_NAME</th>
                              <th>VEHICLE_CODE_TYPE</th>
                              <th>EXPEDITION_NAME</th>
                              <th>CAR_NO</th>
                              <th>CONT_NO</th>
                              <th>CHECKIN_DATE</th>
                              <th>CHECKIN_TIME</th>
                              <th>DELIVERY_NO</th>
                              <th>DELIVERY_ITEMS</th>
                              <th>MODEL</th>
                              <th>QUANTITY</th>
                              <th>CBM</th>
                              <th>SHIP_TO</th>
                              <th>SOLD_TO</th>
                              <th>SHIP_TO_CITY</th>
                              <th>SHIP_TO_DISTRICT</th>
                              <th>SHIP_TO_STREET</th>
                              <th>SOLD_TO_CITY</th>
                              <th>SOLD_TO_DISTRICT</th>
                              <th>SOLD_TO_STREET</th>
                              <th>REMARKS</th>
                              <th>AREA</th>
                              <th>SOLD_TO_CODE</th>
                              <th>SHIP_TO_CODE</th>
                              <th>EXPEDITION_CODE</th>
                              <th>CODE_SALES</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                        <button class="waves-effect waves-light indigo btn-small btn-save mt-2 mr-1 mb-1" onclick="submit_concept()">Submit</button>
                      </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  var data_concept;
  $('#form-upload-concept [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
  @if (auth()->user()->area != "All") 
    set_select2_value('#form-upload-concept [name="area"]', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
    $('#form-upload-concept [name="area"]').attr('disabled', 'disabled');
  @endif
  $("#form-upload-concept").validate({
      submitHandler: function(form) {
        var fdata = new FormData(form);
        $.ajax({
          url: '{{ url("upload-concept/upload-csv") }}',
          type: 'POST',
          data: fdata,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false
        })
        .done(function(data) { // selesai dan berhasil
          data_concept = data;
          if (data.status == false) {
            $('#table-concept tbody').empty();
            swal("Failed!", data.message, "warning");
            return;
          }
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              $('#concept-wrapper').show();
              $('#table-concept tbody').empty();
              $.each(data, function(index, val) {
                 /* iterate through array or object */
                 var row = '<tr>';
                 row += '<td>' + val.invoice_no + '</td>';
                 row += '<td>' + val.line_no + '</td>';
                 row += '<td>' + val.output_date + '</td>';
                 row += '<td>' + val.output_time + '</td>';
                 row += '<td>' + val.destination_name + '</td>';
                 row += '<td>' + val.vehicle_code_type + '</td>';
                 row += '<td>' + val.expedition_name + '</td>';
                 row += '<td>' + val.car_no + '</td>';
                 row += '<td>' + val.cont_no + '</td>';
                 row += '<td>' + val.checkin_date + '</td>';
                 row += '<td>' + val.checkin_time + '</td>';
                 row += '<td>' + val.delivery_no + '</td>';
                 row += '<td>' + val.delivery_items + '</td>';
                 row += '<td>' + val.model + '</td>';
                 row += '<td>' + val.quantity + '</td>';
                 row += '<td>' + val.cbm + '</td>';
                 row += '<td>' + val.ship_to + '</td>';
                 row += '<td>' + val.sold_to + '</td>';
                 row += '<td>' + val.ship_to_city + '</td>';
                 row += '<td>' + val.ship_to_district + '</td>';
                 row += '<td>' + val.ship_to_street + '</td>';
                 row += '<td>' + val.sold_to_city + '</td>';
                 row += '<td>' + val.sold_to_district + '</td>';
                 row += '<td>' + val.sold_to_street + '</td>';
                 row += '<td>' + val.remarks + '</td>';
                 row += '<td>' + val.area + '</td>';
                 row += '<td>' + val.sold_to_code + '</td>';
                 row += '<td>' + val.ship_to_code + '</td>';
                 row += '<td>' + val.expedition_code + '</td>';
                 row += '<td>' + val.code_sales + '</td>';
                 row += '</tr>';

                 $('#table-concept tbody').append(row);
              });
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

  function submit_concept(){
    $.ajax({
      url: '{{ url("upload-concept") }}',
      type: 'POST',
      data: 'data_concept=' + JSON.stringify(data_concept),
    })
    .done(function() { // selesai dan berhasil
      swal("Good job!", "You clicked the button!", "success")
        .then((result) => {
          window.location.href = "{{ url('upload-concept') }}"
        }) // alert success
    })
    .fail(function(xhr) {
        showSwalError(xhr) // Custom function to show error with sweetAlert
    });
  }
</script>
@endpush