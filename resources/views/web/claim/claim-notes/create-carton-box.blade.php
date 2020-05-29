@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m10">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Claim Note Carton Box</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('claim-notes') }}">Claim Notes</a></li>
                    <li class="breadcrumb-item active">Create Claim Note Carton Box</li>
                </ol>
            </div>
            <div class="col s12 m2">
                <a class="btn btn-large waves-effect waves-light indigo" href="{{ url('claim-notes') }}">Back</a>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <!-- <div class="card"> -->
                    <div class="card-content">
                        <ul class="collapsible">
                           <li class="active">
                             <div class="collapsible-header">List Berita Acara</div>
                             <div class="collapsible-body white p-0">
                                <div class="row mb-0">
                                  <div class="col s12 offset-m6 m6">
                                    <div class="app-wrapper ml-2 mt-2 mr-2">
                                      <div class="datatable-search mb-0">
                                        <i class="material-icons mr-2 search-icon">search</i>
                                        <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="section-data-tables"> 
                                    <table id="data-table-section-contents" class="display" width="100%">
                                      <thead>
                                          <tr>
                                            <th data-priority="1" width="30px">NO.</th>
                                            <th>BERITA ACARA</th>
                                            <th>DATE</th>
                                            <th>EXPEDITION NAME</th>
                                            <th>DRIVER</th>
                                            <th>VEHICLE NO.</th>
                                            <th width="50px;"></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td>1.</td>
                                          <td>01/BA-HQ/02/2015</td>
                                          <td>May 21, 2020</td>
                                          <td>Expedition 1</td>
                                          <td>Driver 1</td>
                                          <td>B 1231 DE</td>
                                          <td>
                                            {!! get_button_view('#', 'Select') !!}
                                          </td>
                                        </tr>
                                      </tbody>
                                  </table>

                                  <h6 class="card-title mt-2 ml-2">Berita Acara Detail</h6>
                                  <hr>
                                  <div class="pl-2 pr-2 pb-2">
                                      <table id="data-table-section-contents" class="bordered striped" width="100%">
                                          <thead>
                                              <tr>
                                                <th data-priority="1" width="30px">No.</th>
                                                <th>Berita Acara</th>
                                                <th>Expediton Name</th>
                                                <th>Driver</th>
                                                <th>Car No</th>
                                                <th>Destination</th>
                                                <th>DO NO</th>
                                                <th>Model</th>
                                                <th>Serial No</th>
                                                <th>Qty</th>
                                                <th>Location</th>
                                                <th>Damage Description</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                                {{-- <th width="50px;"></th> --}}
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td>01/BA-HQ/02/2015</td>
                                                <td>Expedition 1</td>
                                                <td>Driver 1</td>
                                                <td>B 1231 DE</td>
                                                <td>Yogyakarta</td>
                                                <td>DO</td>
                                                <td>MOD001</td>
                                                <td>124141</td>
                                                <td>2</td>
                                                <td>LOC</td>
                                                <td>Kerusakan</td>
                                                <td>
                                                    <div class="form-table">
                                                      <input placeholder="Price" id="first_name" type="text" class="validate">
                                                  </div>
                                                </td>
                                                <td>12.000.000</td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>01/BA-HQ/02/2015</td>
                                                <td>Expedition 1</td>
                                                <td>Driver 1</td>
                                                <td>B 1231 DE</td>
                                                <td>Yogyakarta</td>
                                                <td>DO</td>
                                                <td>MOD002</td>
                                                <td>124141</td>
                                                <td>2</td>
                                                <td>LOC</td>
                                                <td>Kerusakan</td>
                                                <td>
                                                    <div class="form-table">
                                                      <input placeholder="Price" id="first_name" type="text" class="validate">
                                                  </div>
                                                </td>
                                                <td>12.000.000</td>
                                            </tr>
                                          </tbody>
                                      </table>
                                      {!! get_button_view(url('claim-notes'), 'Save') !!}
                                  </div>  
                              </div>
                             </div>
                           </li>
                        </ul>
                    </div>
                <!-- </div> -->
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>

    <div class="col s12">
        <div class="container">
            <div class="section">
                <!-- <div class="card"> -->
                    <div class="card-content">
                        <ul class="collapsible">
                           <li class="active">
                             <div class="collapsible-header">Claim Note Carton Box</div>
                             <div class="collapsible-body white p-0">
                                <div class="section-data-tables"> 
                                  <div class="pl-2 pr-2 pb-2">
                                    {!!get_button_print()!!}
                                      <table id="data-table-section-contents" class="bordered striped" width="100%">
                                          <thead>
                                              <tr>
                                                <th data-priority="1" width="30px">No.</th>
                                                <th>Berita Acara</th>
                                                <th>Expediton Name</th>
                                                <th>Driver</th>
                                                <th>Car No</th>
                                                <th>Destination</th>
                                                <th>DO NO</th>
                                                <th>Model</th>
                                                <th>Serial No</th>
                                                <th>Qty</th>
                                                <th>Location</th>
                                                <th>Damage Description</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                                <th width="170px;"></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td>01/BA-HQ/02/2015</td>
                                                <td>Expedition 1</td>
                                                <td>Driver 1</td>
                                                <td>B 1231 DE</td>
                                                <td>Yogyakarta</td>
                                                <td>DO</td>
                                                <td>MOD001</td>
                                                <td>124141</td>
                                                <td>2</td>
                                                <td>LOC</td>
                                                <td>Kerusakan</td>
                                                <td>
                                                    <div class="form-table">
                                                      <input placeholder="Price" id="first_name" type="text" class="validate">
                                                  </div>
                                                </td>
                                                <td>12.000.000</td>
                                                <td>
                                                    {!!get_button_edit('#', 'Update')!!}
                                                    {!!get_button_delete()!!}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>01/BA-HQ/02/2015</td>
                                                <td>Expedition 1</td>
                                                <td>Driver 1</td>
                                                <td>B 1231 DE</td>
                                                <td>Yogyakarta</td>
                                                <td>DO</td>
                                                <td>MOD002</td>
                                                <td>124141</td>
                                                <td>2</td>
                                                <td>LOC</td>
                                                <td>Kerusakan</td>
                                                <td>
                                                    <div class="form-table">
                                                      <input placeholder="Price" id="first_name" type="text" class="validate">
                                                  </div>
                                                </td>
                                                <td>12.000.000</td>
                                                <td>
                                                    {!!get_button_edit('#', 'Update')!!}
                                                    {!!get_button_delete()!!}
                                                </td>
                                            </tr>
                                          </tbody>
                                      </table>
                                  </div>  
                              </div>
                             </div>
                           </li>
                        </ul>
                    </div>
                <!-- </div> -->
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  $('.collapsible').collapsible({
        accordion:true
    });
var dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: false,
        order: [1, 'asc'],
    });
</script>
@endpush