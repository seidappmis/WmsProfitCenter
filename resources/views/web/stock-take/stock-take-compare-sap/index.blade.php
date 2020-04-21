@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m12 mb-1">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Quick Count</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Stock Take Quick Count</li>
              </ol>
          </div>
        </div>

      <div class="row">
          <div class="col s12 m4">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                      <option>-Select Schedule ID-</option>
                      <option>SBY-STO-200201-001</option>
                      <option>KRW-STO-199801-002</option>
                    </select>
                  </div>
                </div>
          </div>
          <div class="col s12 m2">
          <div class="display-flex">
                <button class="btn btn-large waves-effect waves-light btn-add" type="submit" name="action">
                  {{-- <i class="material-icons right">add</i> --}}
                  Compare
                </button>
              </div>
          </div>
          <div class="col s12 m2">
              <div class="display-flex">
                <button class="btn btn-large waves-effect waves-light btn-add" type="submit" name="action">
                  {{-- <i class="material-icons right">add</i> --}}
                  Print
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
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>Model</th>
                                    <th>SAP</th>
                                    <th>Input 1</th>
                                    <th>Input 2</th>
                                    <th>SAP vs Input 1</th>
                                    <th>SAP vs Input 2</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1.</td>
                                  <td>2T-C3BA21</td>
                                  <td>56456</td>
                                  <td>34545</td>
                                  <td>1854</td>
                                  <td>0</td>
                                  <td>0</td>
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