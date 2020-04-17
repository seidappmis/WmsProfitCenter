@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Freight Cost</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Freight Cost</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card-content p-0">
                <ul class="collapsible">
                  <li>
                    <div class="collapsible-header">UPLOAD DATA</div>
                    <div class="collapsible-body white">
                      <div class="row">
                        <div class="input-field col s12">
                          <div class="col s12 m4 l3">
                            <p>Data File</p>
                          </div>
                          <div class="col s12 m8 l9">
                            <input type="file" required id="input-file-now" class="dropify" name="file" data-default-file="" data-height="100"/>
                            <p>Format File : .csv</p>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <button type="submit" class="waves-effect waves-light indigo btn">Upload</button>
                      </div>
                    </div>
                  </li>
                </ul>
                </div>
                <div class="row">
                  <div class="col s12 m3">
                    <!---- Search ----->
                    <div class="app-wrapper">
                      <div class="datatable-search">
                        <select id="area_filter">
                          <option>-- Select Area --</option>
                          <option>KARAWANG</option>
                          <option>SURABAYA HUB</option>
                          <option>SWADAYA</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m3"></div>
                  <div class="col s12 m6">
                    <div class="display-flex">
                      <!---- Search ----->
                      <div class="app-wrapper mr-2">
                        <div class="datatable-search">
                          <i class="material-icons mr-2 search-icon">search</i>
                          <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                        </div>
                      </div>
                      <!---- Button Modal Add ----->
                      <a class="btn btn-large waves-effect waves-light btn-add" href="#">New Freight Cost</a>
                    </div>
                  </div>
                </div>
                <div class="card">
                    <div class="card-content p-0">
                      <div class="section-data-tables"> 
                        <table id="data-table-simple" class="display" width="100%">
                            <thead>
                                <tr>
                                  <th data-priority="1" width="30px">NO.</th>
                                  <th>ORIGIIN AREA</th>
                                  <th>TRANSPORTER</th>
                                  <th>DESTINATION</th>
                                  <th>TRUCK TYPE</th>
                                  <th>RITASE</th>
                                  <th>CBM (M3)</th>
                                  <th>LEAD TIME (DAYS)</th>
                                  <th width="50px;"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
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
  var table = $('#data-table-simple').DataTable({
    "responsive": true,
  });

  //Upload File
  $('.dropify').dropify();

  $("input#global_filter").on("keyup click", function () {
    filterGlobal();
  });

  // Custom search
  function filterGlobal() {
      table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush