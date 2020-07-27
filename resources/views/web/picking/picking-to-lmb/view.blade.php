@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>View Detail Picking to LMB</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('picking-to-lmb') }}">Picking To LMB</a></li>
                    <li class="breadcrumb-item active">View Detail Picking to LMB</li>
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
                      <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Detail</div>
                      <div class="collapsible-body padding-1">
                        <h4 class="card-title">Header</h4>
                        <table class="form-table mb-1">
                          <tr>
                            <td>LMB Date</td>
                            <td>{{$lmbHeader->lmb_date}}</td>
                            <td>Expedisi</td>
                            <td>{{$lmbHeader->expedition_name}}</td>
                          </tr>
                          <tr>
                            <td>Picking No</td>
                            <td>{{$lmbHeader->picking->picking_no}}</td>
                            <td>Vehicle No</td>
                            <td>{{$lmbHeader->vehicle_number}}</td>
                          </tr>
                          <tr>
                            <td>Ship to City</td>
                            <td>{{$lmbHeader->picking->city_name}}</td>
                            <td></td>
                            <td></td>
                          </tr>
                        </table>
                        {!! get_button_save('Send Manifest', 'btn-send-manifest ' . ($lmbHeader->send_manifest ? 'hide' : '')) !!}
                        {!! get_button_save('Print', 'btn-print-manifest ' . ($lmbHeader->send_manifest ? '' : 'hide')) !!}
                        {!! get_button_cancel(url('picking-to-lmb'), 'Back', '') !!}

                        <hr>
                        
                        <div class="section-data-tables"> 
                          <table id="serial-number-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="2" width="30px">No.</th>
                                    <th>SERIAL NUMBER</th>
                                    <th>DELIVERY NO</th>
                                    <th>MODEL</th>
                                    <th>EAN CODE</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($lmbHeader->details as $key => $lmbDetail)
                                  <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$lmbDetail->serial_number}}</td>
                                    <td>{{$lmbDetail->delivery_no}}</td>
                                    <td>{{$lmbDetail->model}}</td>
                                    <td>{{$lmbDetail->ean_code}}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
                      </div>

                    </li>
                  </ul>
                </div>
                <div class="content-overlay"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('page-modal')
<!-- Modal Structure -->
<div id="modal-send-manifest" class="modal">
  <form id="form-send-manifest">
  <div class="modal-content">
    @include('web.picking.picking-to-lmb._modal_send_manifest')
  </div>
  </form>
</div>
@endpush

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
   $('.btn-send-manifest').click(function(event) {
     /* Act on the event */
      $.ajax({
        url: '{{ url("picking-to-lmb/" . $lmbHeader->driver_register_id) }}',
        type: 'GET',
      })
      .done(function(result) { // selesai dan berhasil

        $('#modal-send-manifest').modal('open')
      })
      .fail(function(xhr) {
          showSwalError(xhr) // Custom function to show error with sweetAlert
      });
   });

   $('#form-send-manifest').validate({
    submitHandler: function(form) {
      $.ajax({
          url: '{{ url("picking-to-lmb/" . $lmbHeader->driver_register_id . "/send-manifest") }}',
          type: 'POST',
        })
        .done(function(result) { // selesai dan berhasil
          showSwalAutoClose('Success', result.message)
          // swal("Good job!", "You clicked the button!", "success")
          //   .then((result) => {
          //     // Kalau klik Ok redirect ke index
          //   }) // alert success
          $('.btn-send-manifest').hide();
          $('.btn-print-manifest').removeClass('hide');
          $('#modal-send-manifest').modal('close')
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
    }
   })
</script>
@endpush
