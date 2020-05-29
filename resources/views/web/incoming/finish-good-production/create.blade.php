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
                	   <p>Receipt No : <b class="green-text text-darken-3"></b class="green-text text-darken-3"></p>
                      <p>Ticket No : <b class="green-text text-darken-3"></b class="green-text text-darken-3"></p>
                      <p>Warehouse : <b class="green-text text-darken-3">SHARP KARAWANG W/H</b class="green-text text-darken-3"></p>
                      <p>Factory : <b class="green-text text-darken-3"></b class="green-text text-darken-3"></p>
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
                            <tbody></tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
                      <br>
                      <!-- Find Delivery Ticket -->
                  		<h4 class="card-title">Find Delivery Ticket</h4>
                      <div>
                        <form class="form-table">
                            <table>
                                <tr>
                                    <td>Choose Plant</td>
                                    <td>
                                       <div class="input-field col s12">
                                        <select required="">
                                            <option value="" disabled selected>-- Select Plant--</option>
                                            <option value="1">ALL PLANT</option>
                                            <option value="2">HA</option>
                                            <option value="3">TV</option>
                                        </select>
                                       </div>  
                                    </td>
                                </tr>
                                <tr>
                                    <td>Delivery Ticket</td>
                                    <td>
                                       <div class="input-field col s12">
                                        <input id="delivery" type="text" class="validate" name="delivery" required>
                                      </div> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Choose Type</td>
                                    <td>
                                        <div class="input-field col s12 m6">
                                        <select>
                                            <option value="" disabled>-- Select Type--</option>
                                            <option value="1" selected>Local</option>
                                            <!-- <option value="2">HA</option>
                                            <option value="3">TV</option> -->
                                        </select>
                                        </div>
                                        <div class="input-field col s12 m6">
                                            <button type="submit" class="waves-effect waves-light indigo btn-small btn">Search Delivery Ticket</button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                      </div>
                      <br>
                      <!-- Assign Delivery Ticket -->
                    	<h4 class="card-title">Assign Delivery Ticket</h4>
                      <div>
                        <form class="form-table">
                        <table>
                            <tr>
                                <td width="45%">
                                <b>From Barcode Production</b>
                                <table>
                                    <tr>
                                        <td>
                                        <b>Delivery Ticket| Model | Quantity | Ean | Type</b>
                                        <table>
                                            <tr>
                                                <td class="white-text" height="300">lala</td>
                                            </tr>
                                        </table>
                                        </td>
                                    </tr>
                                </table>
                                <br><br><br><br>
                                </td>
                                <td width="10%" class="center-align">
                                  <div class="col s12">
                                      <p><button type="submit" class="waves-effect waves-light indigo btn">>></button></p>
                                      <br>
                                      <p><button type="submit" class="waves-effect waves-light indigo btn"><<</button></p>
                                  </div>
                                </td>
                                <td width="45%">
                                <b>Submit to Logsys</b>
                                <table>
                                    <tr>
                                        <td>
                                        <b>Delivery Ticket| Model | Quantity | Ean | Type</b>
                                        <table>
                                            <tr>
                                                <td class="white-text" height="300">tes</td>
                                            </tr>
                                        </table>
                                        </td>
                                    </tr>
                                </table>
                                <table>
                                <tr>
                                    <td>Storage Location</td>
                                    <td>
                                      <div class="input-field col s12">
                                      <select required="">
                                          <option value="" selected>-- Select Storage Location--</option>
                                          <option value="1">[1001]HYP-1st Class</option>
                                      </select>
                                      </div> 
                                    </td>
                                </tr>
                                </table>
                                {!! get_button_save() !!}
                                {!! get_button_save('Submit to Inventory') !!}
                                </td>
                            </tr>
                        </table>
                        </form>
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