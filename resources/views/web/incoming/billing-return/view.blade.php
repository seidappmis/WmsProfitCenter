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
                            <input id="delivery" type="text" class="validate" name="delivery" required>
                            <label for="delivery">Document DO Return Date</label>
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
                              <tr>
                                <td rowspan="4">JKT-180903-053</td>
                                <td rowspan="4">PUTRA NAGITA PRATAMA, PT.</td>
                                <td rowspan="4">BOGOR</td>
                                <td>AH-A5UCY</td>
                                <td>10</td>
                                <td>
                                  <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </td>
                              </tr>
                              <tr>
                                <td>AH-A5UCY</td>
                                <td>10</td>
                                <td>
                                  <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </td>
                              </tr>
                              <tr>
                                <td>AH-A5UCY</td>
                                <td>10</td>
                                <td>
                                  <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </td>
                              </tr>
                              <tr>
                                <td>AH-A5UCY</td>
                                <td>10</td>
                                <td>
                                  <label>
                                      <input type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                  </th>
                                </td>
                              </tr>
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
