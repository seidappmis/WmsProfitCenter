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
          <div class="col s12 m3">
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
          
          <div class="col s12 m5">
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

      <div class="row">
      <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Input Stok Take 2</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <div class="input-field col s12">
                                 <div class="col s12 m4 l3">
                                    <p>No Tag :</p>
                                 </div>
                                 <div class="col s12 m8 l9">
                                    <p>-</p>
                                 </div>
                              </div>
                              <div class="input-field col s12">
                                 <div class="col s12 m4 l3">
                                    <p>Model :</p>
                                 </div>
                                 <div class="col s12 m8 l9">
                                    <p>-</p>
                                 </div>
                              </div>
                              <div class="input-field col s12">
                                 <div class="col s12 m4 l3">
                                    <p>Location :</p>
                                 </div>
                                 <div class="col s12 m8 l9">
                                    <p>-</p>
                                 </div>
                              </div>
                              <div class="input-field col s12">
                                 <div class="col s12 m4 l3">
                                    <p>Quantity :</p>
                                 </div>
                                 <div class="col s12 m8 l9">
                                    <p>-</p>
                                 </div>
                              </div>
                            </div>
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
                                  <td>S1-N162D-AB</td>
                                  <td>A</td>
                                  <td>1854</td>
                                  <th width="50px;">
                                    <span class="waves-effect btn-floating btn-small amber darken-4 btn-edit" href="#"><i class="material-icons">edit</i></span>
                                    <span class="waves-effect btn-floating red darken-4 btn-small btn-delete"><i class="material-icons">delete</i></span>
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
@endsection

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: false,
    });
</script>
@endpush