@extends('layouts.materialize.index')

@section('content')
@component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m8 mb-1">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Trucking Monitor</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Trucking Monitor</li>
              </ol>
          </div>
          <div class="col s12 m4">
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
      </div>
  @endcomponent
<div class="row">
    <div class="col s12">
        <div class="">
            <div class="section">
                <div class="card mb-0">
                    <div class="card-content">
                        <h4 class="header m-0">Loading Status</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col s12">
        <div class="">
            <div class="section">
                <div class="card m-0">
                    <div class="card-content">
                        <h4 class="header m-0">After Loading Status</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>STATUS</th>
                                    <th>MANIFEST NO</th>
                                    <th>VEHICLE NO</th>
                                    <th>DESTINATION</th>
                                    <th>TOTAL CBM</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>VEHICLE TYPE</th>
                                    <th>VEHICLE GROUP</th>
                                    <th>CAPACITY</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Waiting D/O</td>
                                    <td>SBY-200207-001</td>
                                    <td>L 9624_VZ</td>
                                    <td>SURABAYA HUB-SURABAYA34</td>
                                    <td>3.650</td>
                                    <td>NITTSU LEMO INDONESIA LOGISTIK, PT.</td>
                                    <td>CD 6 BAN (CDD)</td>
                                    <td>SMALL TRUCK</td>
                                    <td>32.000</td>
                                </tr>
                                <tr>
                                    <td>Waiting D/O</td>
                                    <td>SBY-200207-002</td>
                                    <td>L 9255_J</td>
                                    <td>SURABAYA HUB-SURABAYA34</td>
                                    <td>3.285</td>
                                    <td>NITTSU LEMO INDONESIA LOGISTIK, PT.</td>
                                    <td>PICK UP</td>
                                    <td>SMALL TRUCK</td>
                                    <td>7.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col s12 m6 mt-2">
        <div class="">
            <div class="section">
                <div class="card m-0">
                    <div class="card-content">
                        <h4 class="header m-0">List Of Vehicle That Already Standby</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col s12 m6 mt-2">
        <div class="">
            <div class="section">
                <div class="card m-0">
                    <div class="card-content">
                        <h4 class="header m-0">Delivery Order List</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>SHIPMENT NO</th>
                                    <th>DELIVERY NO</th>
                                    <th>TOTAL ITEMS DO</th>
                                    <th>TOTAL CBM</th>
                                    <th>DESTIONATION</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>UPLOAD DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1000307683</td>
                                    <td>2800076697</td>
                                    <td>1</td>
                                    <td>4.42</td>
                                    <td>SURABAYA HUB-SURABAYA</td>
                                    <td>MILLENNIUM TRANS BAHARI, PT.</td>
                                    <td>2018-05-11 10:25:50</td>
                                </tr>
                                <tr>
                                    <td>1000308448</td>
                                    <td>2800076904</td>
                                    <td>2</td>
                                    <td>2.295</td>
                                    <td>SURABAYA HUB-KEDIRI</td>
                                    <td>TRISILA, CV.</td>
                                    <td>2018-05-16 14:47:40</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection