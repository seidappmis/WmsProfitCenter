@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Finish Good Production</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('finish-good-production') }}">Finish Good Production</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
            <div class="col s12 m2"></div>
            <div class="col s12 m4">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <select id="area_filter"
                          class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
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
                	   <p>Receipt No &ensp;: <b class="green-text text-darken-3"></b class="green-text text-darken-3"></p>
                      <p>Ticket No &emsp;&nbsp;: <b class="green-text text-darken-3"></b class="green-text text-darken-3"></p>
                      <p>Warehouse &nbsp;: <b class="green-text text-darken-3">SHARP KARAWANG W/H</b class="green-text text-darken-3"></p>
                      <p>Factory &emsp;&emsp;: <b class="green-text text-darken-3"></b class="green-text text-darken-3"></p>
                      <br>

                      <!-- List Barcode -->
                    	<h4 class="card-title">List Barcode Detailed from Factory</h4>
                      <hr>
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
                            <tbody></tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
                      <br>

                      <!-- Find Delivery Ticket -->
                  		<h4 class="card-title">Find Delivery Ticket</h4>
                      <hr>
                      <div>
                        @include('web.incoming.finish-good-production._form_find_delivery_ticket')
                      </div>
                      <br>

                      <!-- Assign Delivery Ticket -->
                    	<h4 class="card-title">Assign Delivery Ticket</h4>
                      <hr>
                      <div>
                        @include('web.incoming.finish-good-production._form_assign_delivery_ticket')
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
 	var dtdatatable = $('#data-table-section-contents').DataTable({
    // serverSide: true,
    // scrollX: true,
    responsive: true,
  });

  // Filter Area
  $('#area_filter').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });
</script>
@endpush