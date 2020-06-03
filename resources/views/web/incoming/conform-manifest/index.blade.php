@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Conform Manifest</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Conform Manifest</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card mb-0">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header p-0">
                            <div class="row">
                              <div class="col s12 m8">
                                <div class="collapsible-main-header">
                                  <i class="material-icons expand">expand_less</i>
                                  <span>From Manifest HQ</span>
                                </div>
                              </div>
                              <div class="col s12 m4">
                                <div class="app-wrapper">
                                  <div class="datatable-search mb-0">
                                    <i class="material-icons mr-2 search-icon">search</i>
                                    <input type="text" placeholder="Search" class="app-filter no-propagation" id="global_filter">
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
                                        <th>DO MANIFEST</th>
                                        <th>EXPEDITION NAME</th>
                                        <th>DESTINATION CITY</th>
                                        <th>STATUS</th>
                                        <th width="50px;"></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>JKT-180903-053</td>
                                      <td>PUTRA NAGITA PRATAMA, PT.</td>
                                      <td>BOGOR</td>
                                      <td>-</td>
                                      <td>{!! get_button_view(url('conform-manifest/1'), 'View for Conform') !!}</td>
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
        <div class="col s12">
        <div class="container">
            <div class="section pt-0">
                <div class="card">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header p-0">
                            <div class="row">
                              <div class="col s12 m8">
                                <div class="collapsible-main-header">
                                  <i class="material-icons expand">expand_less</i>
                                  <span>From Manifest Branch</span>
                                </div>
                              </div>
                              <div class="col s12 m4">
                                <div class="app-wrapper">
                                  <div class="datatable-search mb-0">
                                    <i class="material-icons mr-2 search-icon">search</i>
                                    <input type="text" placeholder="Search" class="app-filter no-propagation" id="global_filter">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="collapsible-body p-0">
                            <div class="section-data-tables"> 
                              <table id="data-table-2" class="display" width="100%">
                                  <thead>
                                      <tr>
                                        <th>DO MANIFEST</th>
                                        <th>EXPEDITION NAME</th>
                                        <th>DESTINATION CITY</th>
                                        <th width="50px;"></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>JKT-180903-053</td>
                                      <td>PUTRA NAGITA PRATAMA, PT.</td>
                                      <td>BOGOR</td>
                                      <td>{!! get_button_view(url('conform-manifest/1'), 'View for Conform') !!}</td>
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