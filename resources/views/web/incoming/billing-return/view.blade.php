@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m10">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Conform Manifest Branch</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('finish-good-production') }}">Conform Manifest</a></li>
                    <li class="breadcrumb-item active">ARV-WHHYP-181003-019</li>
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
                      <div class="row">
                        <div class="col s12 m3">
                          <a class="waves-effect waves-light btn blue darken-2">Conform</a>
                          <div class="input-field col s12">
                            <input id="doc_do_return_date" type="text" class="validate datepicker" name="doc_do_return_date" required>
                            <label for="doc_do_return_date">Document DO Return Date</label>
                          </div>
                        </div>
                      </div>
                      <div class="section-data-tables"> 
                        <table id="data-table-section-contents" class="bordered" width="100%">
                            <thead>
                                <tr>
                                  <th>DO MANIFEST</th>
                                  <th>EXPEDITION NAME</th>
                                  <th>DESTINATION CITY</th>
                                  <th>MODEL</th>
                                  <th>QUANTITY</th>
                                  <th width="50px;">
                                    <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($manifest->details AS $key => $detail)
                              <tr>
                                @if($key == 0)
                                <td rowspan="{{$manifest->details->count()}}">{{$manifest->do_manifest_no}}</td>
                                <td rowspan="{{$manifest->details->count()}}">{{$manifest->expedition_name}}</td>
                                <td rowspan="{{$manifest->details->count()}}">{{$manifest->city_name}}</td>
                                @endif
                                <td>{{$detail->model}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td>
                                  <label>
                                    <input type="checkbox" name="manifest_detail[{{$detail->id}}]"/>
                                    <span class="red-text"></span>
                                  </label>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
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
