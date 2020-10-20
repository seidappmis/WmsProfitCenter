@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Gate Status</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Gate Status</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">filter_drama</i>Loading Status Gates</div>
                          <div class="collapsible-body pt-0 pb-1">
                            <form>
                              <div class="row">
                                <div class="input-field col s12">
                                  <div class="row">
                                    <div class="col s2 m1 pt-1">
                                      Area
                                    </div>
                                    <div class="col s6 m3">
                                      <select id="filter-area" class="select2-data-ajax browser-default app-filter">
                                      </select>
                                    </div>
                                  </div>
                                  {{-- <label for="expedition">Area</label> --}}
                                </div>

                                @push('script_css')
                                <style type="text/css">
                                  .row.gate-row .col {
                                    padding: 0 .2rem;
                                  }
                                  .row.gate-row .col p {
                                    font-size: 11px;
                                  }
                                </style>

                                @endpush
                                <div id="gate-rows" class="row gate-row">
                                </div>
                                <strong>
                                  <span class="green-text">Green = No Loading</span> <span class="red-text">Red = Loading</span>.
                                </strong>
                              </div>
                            </form>
                          </div>
                        </li>
                      </ul>
                    </div>
                </div>
            </div>
            </div>
        </div>
        {{-- <div class="col s12">
        <div class="container">
            <div class="section pt-0">
                <div class="card">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">filter_drama</i>Select Gate</div>
                          <div class="collapsible-body p-0">
                            <div class="section-data-tables"> 
                              <table id="data-table-2" class="display" width="100%">
                                  <thead>
                                      <tr>
                                        <th>NO.</th>
                                        <th>STATUS</th>
                                        <th>VEHICLE NO.</th>
                                        <th>DESTINATION</th>
                                        <th>EXPEDITION NAME</th>
                                        <th>VEHICLE TYPE</th>
                                        <th>TOTAL CBM</th>
                                        <th>CAPACITY</th>
                                        <th>BALANCE</th>
                                        <th width="50px;"></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                              </table>
                            </div>
                            <!-- datatable ends -->

                          </div>
                        </li>
                      </ul>
                    </div>
                </div>
            </div>
            </div>
        </div> --}}
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
  $('#filter-area').select2({
   placeholder: '-- Select Area --',
   allowClear: true,
   ajax: get_select2_ajax_options('/master-area/select2-area-only')
});

  jQuery(document).ready(function($) {
    @if (auth()->user()->area != 'All')
      set_select2_value('#filter-area', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
      $('#filter-area').attr('disabled','disabled')
    @endif
  });

  $('#filter-area').change(function(event) {
    /* Act on the event */
    $.ajax({
      url: '{{ url("select-gate") }}',
      type: 'GET',
      data: 'area=' + $(this).val(),
    })
    .done(function(data) { // selesai dan berhasil
      $('#gate-rows').empty();
      $.each(data, function(index, val) {
         /* iterate through array or object */
         var card = '';
        card += '<div class="col s2 m1">';
        card += '<div class="card">';
        card += '<div class="card-content p-0">';
        card += '<p class="center-align">&nbsp; ' + (val.vehicle_number != null ? val.vehicle_number : '') + ' </p>';
        card += '<div class="center-align pt-5">';
        card += '<i class="fa fa-truck ' + ((val.vehicle_number != null || val.city_code == 'AS') ? 'red-text' : 'green-text') + '" style="font-size: 40px;"></i>';
        // card += '<i class="material-icons ' + (val.vehicle_number != null ? 'red-text' : 'green-text') + '" style="font-size: 60px;">directions_bus</i>';
        card += '</div>';
        card += '<h4 class="card-title center-align mb-0">' + val.gate_number + '</h4>';
        card += '</div>';
        card += '</div>';
        card += '</div>';

        $('#gate-rows').append(card);
      });
    })
    .fail(function(xhr) {
        showSwalError(xhr) // Custom function to show error with sweetAlert
    });
  });
</script>
@endpush