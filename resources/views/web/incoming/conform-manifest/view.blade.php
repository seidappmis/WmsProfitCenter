@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m10">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Conform Manifest {{$type}}</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('finish-good-production') }}">Conform Manifest</a></li>
                    <li class="breadcrumb-item active">{{$manifestHeader->do_manifest_no}}</li>
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
                      <form id="form-conform-manifest">
                        <input type="hidden" name="type_conform" value="{{$type}}">
                      <div class="row mb-0">
                        <div class="col s12 m3">
                          <span class="waves-effect waves-light btn blue darken-2 btn-hold-transit">Hold/Transit</span>
                          <div class="input-field col s12">
                            <input id="hold_transit" type="text" class="validate datepicker" name="hold_transit" required>
                            <label for="hold_transit"></label>
                          </div>
                        </div>
                        <div class="col s12 m4 p-0">
                          <span class="waves-effect waves-light btn blue darken-2 btn-conform">Conform</span>
                          <div class="row mb-0">
                            <div class="input-field col s12 m6">
                              <input id="arrival_date" type="text" class="validate datepicker" name="arrival_date" required>
                              <label for="arrival_date">Arrival Date</label>
                            </div>
                            <div class="input-field col s12 m6">
                              <input id="unloading_date" type="text" class="validate datepicker" name="unloading_date" required>
                              <label for="unloading_date">Unloading Date</label>
                            </div>
                          </div>
                        </div>
                        <div class="col s12 m5">
                          <p>
                            <label>
                              <input type="checkbox" name="rejected" />
                              <span class="red-text">Rejected</span>
                            </label>
                          </p>
                        </div>
                      </div>
                      <div class="section-data-tables"> 
                        <table id="data-table-section-contents" class="bordered" width="100%">
                            <thead>
                                <tr>
                                  <th>DO MANIFEST</th>
                                  <th>EXPEDITION NAME</th>
                                  <th>DESTINATION CITY</th>
                                  <th>DELIVERY NO</th>
                                  <th>DO INTERNAL</th>
                                  <th>MODEL</th>
                                  <th>QUANTITY</th>
                                  <th>SHIP TO</th>
                                  <th width="50px;">
                                    <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($manifestHeader->details AS $key => $manifestDetail)
                              <tr>
                                <td>{{ $manifestDetail->do_manifest_no }}</td>
                                <td>{{ $manifestDetail->expedition_name }}</td>
                                <td>{{ $manifestHeader->city_name }}</td>
                                <td>{{ $manifestDetail->delivery_no }}</td>
                                <td>{{ $manifestDetail->internal_do }}</td>
                                <td>{{ $manifestDetail->model }}</td>
                                <td>{{ $manifestDetail->quantity }}</td>
                                <td>{{ $manifestDetail->ship_to }}</td>
                                <td>
                                  <label>
                                    <input type="checkbox" name="manifest_detail[{{$manifestDetail->id}}]"/>
                                    <span class="red-text"></span>
                                  </label>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
                      </form>
                    </div>
                    <div class="card-content p-0">

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
    $('.btn-hold-transit').click(function(event) {
      /* Act on the event */
      setLoading(true);
      $.ajax({
        url: '{{url('conform-manifest/' . $manifestHeader->do_manifest_no)}}',
        type: 'PUT',
        dataType: 'json',
        data: $('#form-conform-manifest').serialize() + '&status=hold_transit',
      })
      .done(function(result) {
        if (result.status) {
          window.location.href = '{{url('conform-manifest')}}'
        } else {
          setLoading(false);
          showSwalAutoClose('Warning', result.message)
        }
      })
      .fail(function() {
        setLoading(false);
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
      
    });
    $('.btn-conform').click(function(event) {
      /* Act on the event */
      setLoading(true);
      $.ajax({
        url: '{{url('conform-manifest/' . $manifestHeader->do_manifest_no)}}',
        type: 'PUT',
        dataType: 'json',
        data: $('#form-conform-manifest').serialize() + '&status=conform',
      })
      .done(function(result) {
        if (result.status) {
          window.location.href = '{{url('conform-manifest')}}'
        } else {
          setLoading(false);
          showSwalAutoClose('Warning', result.message)
        }
      })
      .fail(function() {
        setLoading(false);
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
      
    });
  });
</script>
@endpush