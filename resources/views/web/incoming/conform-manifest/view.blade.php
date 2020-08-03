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
                      <div class="row mb-0">
                        <div class="col s12 m3">
                          <a class="waves-effect waves-light btn blue darken-2">Hold/Transit</a>
                          <div class="input-field col s12">
                            <input id="delivery" type="text" class="validate datepicker" name="delivery" required>
                            <label for="delivery"></label>
                          </div>
                        </div>
                        <div class="col s12 m4 p-0">
                          <a class="waves-effect waves-light btn blue darken-2">Conform</a>
                          <div class="row mb-0">
                            <div class="input-field col s12 m6">
                              <input id="delivery" type="text" class="validate datepicker" name="delivery" required>
                              <label for="delivery">Arrival Date</label>
                            </div>
                            <div class="input-field col s12 m6">
                              <input id="delivery" type="text" class="validate datepicker" name="delivery" required>
                              <label for="delivery">Unloading Date</label>
                            </div>
                          </div>
                        </div>
                        <div class="col s12 m5">
                          <p>
                            <label>
                              <input type="checkbox" />
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
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                </td>
                              </tr>
                              @endforeach
                              {{-- <tr>
                                <td rowspan="4">JKT-180903-053</td>
                                <td rowspan="4">PUTRA NAGITA PRATAMA, PT.</td>
                                <td rowspan="4">BOGOR</td>
                                <td rowspan="2">2101067096</td>
                                <td></td>
                                <td>AH-A5UCY</td>
                                <td>10</td>
                                <td>CV AIRBUMI INSANI</td>
                                <td>
                                  <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </td>
                              </tr>
                              <tr>
                                <td></td>
                                <td>AH-A5UCY</td>
                                <td>10</td>
                                <td>CV AIRBUMI INSANI</td>
                                <td>
                                  <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </td>
                              </tr>
                              <tr>
                                <td>2101067096</td>
                                <td></td>
                                <td>AH-A5UCY</td>
                                <td>10</td>
                                <td>CV AIRBUMI INSANI</td>
                                <td>
                                  <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </td>
                              </tr>
                              <tr>
                                <td>2101067096</td>
                                <td></td>
                                <td>AH-A5UCY</td>
                                <td>10</td>
                                <td>CV AIRBUMI INSANI</td>
                                <td>
                                  <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </td>
                              </tr> --}}
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
