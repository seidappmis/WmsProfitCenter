@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m9">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Manifest Regular</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Manifest Regular</li>
              </ol>
          </div>
          <div class="col s12 m3">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                      <option>-Select Area-</option>
                      <option>KARAWANG</option>
                      <option>SURABAYA HUB</option>
                      <option>SWADAYA</option>
                    </select>
                  </div>
                </div>
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
                  <div class="collapsible-header">
                      <div class="row">
                        <div class="col s12 m6">
                          <i class="material-icons">filter_drama</i>Truck Waiting Manifest
                        </div>
                        <div class="col s12 m6">
                          <div class="app-wrapper">
                            <div class="datatable-search">
                              <i class="material-icons mr-2 search-icon">search</i>
                              <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="collapsible-body p-0">
                    <div class="section-data-tables"> 
                      <table id="data-table-1" class="display" width="100%">
                        <thead>
                          <tr>
                            <th>VEHICLE NUMBER</th>
                            <th>DRIVER NAME</th>
                            <th>TRANSPORTER</th>
                            <th>DESTINATION</th>
                            <th>PICKING NO.</th>
                            <th width="50px;"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>BE 9062 AP</td>
                            <td>TRIYANTO</td>
                            <td>SARANA AGUNG MULIA SETIA, PT.</td>
                            <td>Lampung</td>
                            <td></td>
                            <td>Create</td>
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

    <div class="container">
        <div class="section">
          <div class="card mt-0">
            <div class="card-content p-0">
              <ul class="collapsible m-0">
                <li class="active">
                  <div class="collapsible-header">
                    <i class="material-icons">filter_drama</i>Data Manifest Normal
                  </div>
                  <div class="collapsible-body p-0">
                    <div class="app-wrapper ml-2 mt-2 mr-2">
                      <div class="datatable-search">
                        <i class="material-icons mr-2 search-icon">search</i>
                        <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                      </div>
                    </div>
                    <div class="section-data-tables"> 
                      <table id="data-table-2" class="display" width="100%">
                        <thead>
                          <tr>
                            <th>NO.</th>
                            <th>MANIFEST</th>
                            <th>EXPEDITION</th>
                            <th>DESTINATION</th>
                            <th>VEHICLE NO</th>
                            <th>PICKING NO</th>
                            <th>STATUS</th>
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

    <div class="content-overlay"></div>
  </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#data-table-1').DataTable({
        serverSide: false,
        responsive: true
    });
    var dtdatatable2 = $('#data-table-2').DataTable({
        serverSide: false,
        responsive: true
    });
</script>
@endpush