@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Select Gate</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Select Gate</li>
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
                          <div class="collapsible-body">
                            <form>
                              <div class="row">
                                <div class="input-field col s12">
                                  <select>
                                    <option>-Select Area-</option>
                                    <option>KARAWANG</option>
                                    <option>SURABAYA HUB</option>
                                    <option>SWADAYA</option>
                                  </select>
                                  <label for="expedition">Area</label>
                                </div>
                                <div class="row gate-row">
                                  @push('script_css')
                                  <style type="text/css">
                                    .row.gate-row .col {
                                      padding: 0 .5rem;
                                    }
                                    .row.gate-row .col p {
                                      font-size: 11px;
                                    }
                                  </style>
                                  @endpush
                                  <div class="col s2 m1">
                                    <div class="card">
                                      <div class="card-content p-0">
                                        <p class="center-align">&nbsp;</p>
                                        <div class="center-align pt-5">
                                          <i class="material-icons green-text" style="font-size: 60px;">directions_bus</i>
                                        </div>
                                        <h4 class="card-title center-align">101</h4>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col s2 m1">
                                    <div class="card">
                                      <div class="card-content p-0">
                                        <p class="center-align">&nbsp;</p>
                                        <div class="center-align pt-5">
                                          <i class="material-icons green-text" style="font-size: 60px;">directions_bus</i>
                                        </div>
                                        <h4 class="card-title center-align">102</h4>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col s2 m1">
                                    <div class="card">
                                      <div class="card-content p-0">
                                        <p class="center-align">&nbsp;B 9875 UEI</p>
                                        <div class="center-align pt-5">
                                          <i class="material-icons red-text" style="font-size: 60px;">directions_bus</i>
                                        </div>
                                        <h4 class="card-title center-align">103</h4>
                                      </div>
                                    </div>
                                  </div>
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
        <div class="col s12">
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
                                    <tr>
                                      <td>1.</td>
                                      <td>Waiting Loading</td>
                                      <td>B 9101 UEI SANIKIN</td>
                                      <td>Jakarta-Manado <br>Jakarta-Manado</td>
                                      <td>WINDU JAYA UTAMA, PT.</td>
                                      <td>CONT 40 (HC)</td>
                                      <td>63.685</td>
                                      <td>65.000</td>
                                      <td>1.315</td>
                                      <td></td>
                                    </tr>
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
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#data-table-1').DataTable({
        serverSide: false,
        order: [1, 'asc'],
    });
    var dtdatatable2 = $('#data-table-2').DataTable({
        serverSide: false,
        order: [1, 'asc'],
    });
</script>
@endpush