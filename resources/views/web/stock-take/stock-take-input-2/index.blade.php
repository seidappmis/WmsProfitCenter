@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m12 mb-1">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Input 2</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Stock Take Input 2</li>
              </ol>
          </div>
        </div>

      <div class="row">
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
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                      <option>-Select Branch-</option>
                      <option>[JF] PT. SEID CAB. JAKARTA</option>
                      <option>[BDG] PT. SEID CAB. BANDUNG</option>
                      <option>[CRB] PT. SEID CAB. CIREBON</option>
                    </select>
                  </div>
                </div>
          </div>
          <div class="col s12 m6">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div>
                </div>
                <button class="btn btn-large waves-effect waves-light btn-add" type="submit" name="action">
                  {{-- <i class="material-icons right">add</i> --}}
                  New Stock Take Schedule
                </button>
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
                                    <th>STO NO.</th>
                                    <th>DESCRIPTION</th>
                                    <th>SCHEDULE START DATE</th>
                                    <th>SCHEDULE END DATE</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1.</td>
                                  <td>BTM-STO-200202-001</td>
                                  <td>Stock_Tacking_Before_Go_Live</td>
                                  <td>2020-02-02</td>
                                  <td>2020-02-02</td>
                                  <td>Delete</td>
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