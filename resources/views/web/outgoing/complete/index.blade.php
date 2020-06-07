@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m5">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Complete</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Complete</li>
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
                    <input type="text" placeholder="Search" class="app-filter" id="complete-filter">
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
                          <table id="complete-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>STATUS</th>
                                    <th>VEHICLE NO</th>
                                    <th>DESTINATION</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>DO MANIFEST</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                {{-- <tr>
                                  <td>1.</td>
                                  <td>Waiting D/O</td>
                                  <td>B_9168_UO<br>ANDI_</td>
                                  <td>Kendari</td>
                                  <td>SARIJASA TRANSUTAMA, PT.</td>
                                  <td>KRW-200207-023 </td>
                                  <td>
                                    {!! get_button_view(url('complete/1'), 'View Detail') !!}
                                  </td>
                                </tr>
                                <tr>
                                  <td>2.</td>
                                  <td>Waiting D/O</td>
                                  <td>B 9704 KYX<br>RAMLAN PANJAITAN</td>
                                  <td>Lampung</td>
                                  <td>SARANA AGUNG MULIA SETIA, PT.</td>
                                  <td><span class="red-text">-NOT COMPLETE-</span> </td>
                                  <td>
                                    {!! get_button_view(url('complete/1'), 'View Detail') !!}
                                    {!! get_button_return('#', 'Back to Loading') !!}
                                  </td>
                                </tr> --}}
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
    var dttable_complete
    jQuery(document).ready(function($) {
      
      dttable_complete = $('#complete-table').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('complete') }}',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#complete-filter').val(),
                d.area = $('#area_filter').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'status', name: 'status', className: 'detail'},
            {data: 'vehicle_number', name: 'vehicle_number', className: 'detail'},
            {data: 'vehicle_number', name: 'vehicle_number', className: 'detail'},
            {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
            {data: 'do_manifest_no', name: 'do_manifest_no', className: 'detail'},
            {data: 'action', className: 'center-align', searchable: false, orderable: false},
        ]
      });
      $("input#complete-filter").on("keyup click", function () {
        filterManifestBranch();
      });
    });

  function filterManifestBranch(){
    dttable_complete.search($("#complete-filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush