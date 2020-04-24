@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m12 mb-1">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Input 1</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Stock Take Input 1</li>
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
                    <div class="col s12 m2">
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
                    <div class="col s12 ">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Input Stok Take 1</div>
                          <div class="collapsible-body">
                              <form class="form-table">
                                  <table>
                                    <tr>
                                      <td>No Tag</td>
                                      <td>
                                        <div class="input-field col s12">
                                          <input value="" id="notag" type="text" class="validate" name="notag" validated>
                                        </div>
                                      </td>
                                    </tr>
                                    
                                  </table>
                              </form>
                              <br>

                              
                              <form class="form-table">
                                  <table>
                                    <tr>
                                      <td>Model</td>
                                      <td>
                                        <div class="input-field col s12">
                                          <input value="" id="model" type="text" class="validate" name="model" disabled>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>Location</td>
                                      <td>
                                        <div class="input-field col s12">
                                          <input value="" id="loca" type="text" class="validate" name="loca" disabled>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>Quantity</td>
                                      <td>
                                        <div class="input-field col s12">
                                            <input value="" id="qty" type="text" class="validate" name="qty" required>
                                        </div>
                                      </td>
                                    </tr>
                                </table>
                              
                            </form>
                            <div class="row">
                              <div class="input-field col s12">
                                <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
                                <button type="submit" class="waves-effect waves-light indigo btn">Clear</button>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  
                 

                  <div class="row">
                      
                          <div class="display-flex">
                            <!---- Search ----->
                            <div class="col s12 m6">

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
                                                    <th>Quantity</th>
                                                    <th width="50px;"></th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <td>1.</td>
                                                  <td>3</td>
                                                  <td>S1-TT8902-PK</td>
                                                  <td>A</td>
                                                  <td>1223</td>
                                                  <th width="50px;">
                                                    <a class="btn btn-small waves-effect amber darken-4 btn-edit" href="{{ url('stock-take-input-1/edit') }}">Edit</a>
                                                    <a class="btn btn-small waves-effect amber darken-4 btn-edit" href="#">Delete</a>
                                                  </th>
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
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: false,
    });
</script>
@endpush