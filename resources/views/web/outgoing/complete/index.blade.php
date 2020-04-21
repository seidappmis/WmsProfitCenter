@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m6">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Complete</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Complete</li>
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
                                <tr>
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