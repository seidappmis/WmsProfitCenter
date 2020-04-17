@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m5">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Overload Concept or DO</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Overload Concept or DO</li>
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
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>SHIPMENT NO</th>
                                    <th>LINE NO</th>
                                    <th>DELIVERY NO</th>
                                    <th>DELIVERY ITEMS</th>
                                    <th>QUANTITY</th>
                                    <th>MODEL</th>
                                    <th>CBM</th>
                                    <th>DESCRIPTION</th>
                                    <th>OVERLOAD DATE</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1.</td>
                                  <td>1000402671</td>
                                  <td>4</td>
                                  <td>2101447850</td>
                                  <td>30</td>
                                  <td>6</td>
                                  <td>SJ-X165MG-GB</td>
                                  <td>2.190</td>
                                  <td>TIDAK MUAT</td>
                                  <td>2020-02-06</td>
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