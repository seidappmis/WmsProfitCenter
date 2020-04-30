@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m12 mb-1">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Create Tag</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Stock Take Create Tag</li>
              </ol>
          </div>
      </div>

      
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content">
                  
                  <div class="row mb-5">
                    <div class="col s12 m2 pt-2">
                        <p>Periode STO</p>
                    </div>
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
                    <div class="col s12 m6">
                    
                    </div>
                  </div>

                  <div class="row">
                  <div class="col s12 m2">
                      <p>Data File</p>
                  </div>  
                  <div class="col s12 m10">
                       <div class="file-field input-field">
                          <div class="btn indigo btn">
                              <span>Browse</span>
                              <input type="file">
                          </div>
                          <div class="file-path-wrapper">
                              <input class="file-path validate" type="text" placeholder="Select File   Format File : csv">
                          </div>
                        </div>
                    </div>
                  </div>

  

                  <div class="row">
                      <div class="col s12 m6">
                        <div class="display-flex">
                          <!---- Search ----->
                          {!! get_button_submit() !!}
                          {!! get_button_print(url('#')) !!}
                        </div>
                      </div>
                    
                  </div>

                  <div class="row">
                      
                          <div class="display-flex">
                            <!---- Search ----->
                            <div class="col s12 m2">
                            <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('stock-take-create-tag/create') }}">New Tag</a>  
                            
                            </div>
                            <div class="col s12 m10">
                              <div class="app-wrapper">
                                <div class="datatable-search">
                                  <i class="material-icons mr-2 search-icon">search</i>
                                  <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                                </div>
                              </div>
                            </div>
                          </div>
                      
                  </div>
                             
                         <div class="container">
                            <div class="section">
                                <div class="card">
                                    <div class="card-content p-0">
                                        <div class="section-data-tables"> 
                                          <table id="data-table-section-contents" class="display" width="100%">
                                              <thead>
                                                  <tr>
                                                    <th data-priority="1" width="30px">No.</th>
                                                    <th>No Tag</th>
                                                    <th>Model</th>
                                                    <th>Location</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <td>1.</td>
                                                  <td>ES-TT8902-PK</td>
                                                  <td>A</td>
                                                  <td>-</td>
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
        </div>
      </div>
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