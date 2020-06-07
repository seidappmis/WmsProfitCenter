@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m10">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>View Complete</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('complete') }}">Complete</a></li>
                    <li class="breadcrumb-item active">B_9168_UO</li>
                </ol>
            </div>
            <div class="col s12 m2">
              <div class="display-flex">
                @component('layouts.materialize.components.back-button')
                @endcomponent
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <p>VEHICLE NO. : <b class="green-text text-darken-3">B_9168_UO</b></p>
                      <p>STATUS : <b class="green-text text-darken-3">Waiting D/O</b></p>
                      <br>
                      <div class="section-data-tables"> 
                        <table id="data-table-section-contents" class="bordered" width="100%">
                            <thead>
                                <tr>
                                  <th>DO MANIFEST</th>
                                  <th>INVOICE NO</th>
                                  <th>LINE NO</th>
                                  <th>DELIVERY NO</th>
                                  <th>DELIVERY ITEMS</th>
                                  <th>MODEL</th>
                                  <th>QUANTITY</th>
                                  <th>CBM</th>
                                  <th>STATUS</th>
                                  <th width="50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($manifestHeader->details AS $key => $manifestDetail)
                              <tr>
                                @if($key == 0)
                                <td rowspan="{{$manifestHeader->details->count()}}"></td>
                                @endif
                                <td>{{$manifestDetail->invoice_no}}</td>
                                <td>{{$manifestDetail->line_no}}</td>
                                <td>{{$manifestDetail->delivery_no}}</td>
                                <td>{{$manifestDetail->delivery_items}}</td>
                                <td>{{$manifestDetail->model}}</td>
                                <td>{{$manifestDetail->quantity}}</td>
                                <td>{{$manifestDetail->cbm}}</td>
                                <td>-</td>
                                <td><a href="#" class="btn btn-small">Overload</a></td>
                              </tr>
                              @endforeach
                              {{-- <tr>
                                <td rowspan="4">KRW-200207-023</td>
                                <td>1000402706</td>
                                <td>1</td>
                                <td>2101447957</td>
                                <td>10</td>
                                <td>ES-T65MW-BK</td>
                                <td>6</td>
                                <td>2.106</td>
                                <td>-</td>
                                <td><a href="#" class="btn btn-small">Overload</a></td>
                              </tr>
                              <tr>
                                <td>1000402706</td>
                                <td>1</td>
                                <td>2101447957</td>
                                <td>10</td>
                                <td>ES-T65MW-BK</td>
                                <td>6</td>
                                <td>2.106</td>
                                <td>-</td>
                                <td><a href="#" class="btn btn-small">Overload</a></td>
                              </tr>
                              <tr>
                                <td>1000402706</td>
                                <td>1</td>
                                <td>2101447957</td>
                                <td>10</td>
                                <td>ES-T65MW-BK</td>
                                <td>6</td>
                                <td>2.106</td>
                                <td>-</td>
                                <td><a href="#" class="btn btn-small">Overload</a></td>
                              </tr>
                              <tr>
                                <td>1000402706</td>
                                <td>1</td>
                                <td>2101447957</td>
                                <td>10</td>
                                <td>ES-T65MW-BK</td>
                                <td>6</td>
                                <td>2.106</td>
                                <td>-</td>
                                <td><a href="#" class="btn btn-small">Overload</a></td>
                              </tr> --}}
                            </tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
                      <div class="mt-2">
                        {!!get_button_save('Complete', 'btn-complete')!!}
                        {!! get_button_cancel(url('complete'), 'Back') !!}
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
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('.btn-complete').click(function(event) {
      /* Act on the event */
      swal({
        text: "Are you sure to complete this data?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Complete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
            $.ajax({
            url: '{{ url('complete/' . $manifestHeader->driver_register_id . '/complete') }}' ,
            type: 'POST',
            dataType: 'json',
          })
          .done(function() {
            swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('complete') }}"
            }) // alert success
          })
          .fail(function() {
            console.log("error");
          });
        }
      })
    });
  });
</script>
@endpush
