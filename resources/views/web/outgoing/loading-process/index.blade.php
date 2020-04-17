@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m6">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Loading Process</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Loading Process</li>
              </ol>
          </div>
          <div class="col s12 m2">
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
          <div class="col s12 m4">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div>
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
                        <div class="section-data-tables"> 
                          <table id="data-table-section-contents" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th>GATE</th>
                                    <th>STATUS</th>
                                    <th>VEHICLE NO.</th>
                                    <th>DESTINATION</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>VEHICLE TYPE</th>
                                    <th>TOTAL CBM</th>
                                    <th>CAPACITY</th>
                                    <th>BALANCE</th>
                                    <th>START TIME</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>603</td>
                                  <td>Loading Process</td>
                                  <td>BE 9387 AC BOIMIN</td>
                                  <td>Lampung Jakarta-Lampung</td>
                                  <td>SARANA AGUNG MULIA SETIA, PT.</td>
                                  <td>TRONTON 10 M</td>
                                  <td>70.224</td>
                                  <td>65.000</td>
                                  <td>-5.224</td>
                                  <td>2020-02-07 14:03:PM</td>
                                  <td></td>
                                </tr>
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
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
    var dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: false,
    });
</script>
@endpush