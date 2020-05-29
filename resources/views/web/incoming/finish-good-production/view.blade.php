@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>View Finish Good Production</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('finish-good-production') }}">Finish Good Production</a></li>
                    <li class="breadcrumb-item active">ARV-WHHYP-181003-019</li>
                </ol>
            </div>
            <div class="col s12 m2"></div>
            <div class="col s12 m4">
              <div class="display-flex">
                 <div class="app-wrapper mr-2"></div>
                <!---- Button Back ----->
                <a class="btn btn-large waves-effect waves-light indigo" href="{{ url('finish-good-production') }}">Back</a>
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <p>Receipt No &ensp;: <b class="green-text text-darken-3">ARV-WHHYP-181003-019</b></p>
                      <p>Ticket No &emsp;&nbsp;: <b class="green-text text-darken-3">L-TV-1810010006</b></p>
                      <p>Warehouse &nbsp;: <b class="green-text text-darken-3">SHARP KARAWANG W/H</b></p>
                      <p>Factory &emsp;&emsp;: <b class="green-text text-darken-3">TV</b></p>
                      <br>

                      <!-- List Barcode -->
                      <h4 class="card-title">List Barcode Detailed from Factory</h4>
                      <!-- <hr> -->
                      <div class="section-data-tables"> 
                        <table id="data-table-section-contents" class="display" width="100%">
                            <thead>
                                <tr>
                                  <th data-priority="1" width="30px">No.</th>
                                  <th>RECEIPT NO</th>
                                  <th>DELIVERY TICKET</th>
                                  <th>MODEL</th>
                                  <th>QUANTITY</th>
                                  <th>EAN</th>
                                  <th>TYPE</th>
                                  <th>Storage Location</th>
                                  <th width="50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1.</td>
                                <td>ARV-WHHYP-181003-019</td>
                                <td>L-TV-1810010006</td>
                                <td>LC24LE175I</td>
                                <td>118</td>
                                <td>8997401967233</td>
                                <td>Local</td>
                                <td>HYP-1st Class</td>
                                <td>
                                </td>
                              </tr>
                            </tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
                    </div>
                    <div class="card-content p-0">

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
        order: [1, 'asc'],
    });
</script>
@endpush