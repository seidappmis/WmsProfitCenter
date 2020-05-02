@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Receipt Invoice</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('receipt-invoice') }}">Receipt Invoice</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
            <div class="col s12 m4"></div>
            <div class="col s12 m2">
              <div class="display-flex right">
                <!---- Button Back ----->
                <!-- <a class="waves-effect btn-flat btn-large" href="{{ url('receipt-invoice') }}">Back</a> -->
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <div class="row">
                      <form class="col s12">
                          <div class="row">
                            <h4 class="card-title">Filter</h4>
                            <hr>
                            <br>
                            <div class="input-field col s4">
                                <select required>
                                  <option value="" selected>-- Select Expedition --</option>
                                  <option value="1">Option 1</option>
                                  <option value="2">Option 2</option>
                                  <option value="3">Option 3</option>
                                </select>
                                <label for="first_name">Expedition Name</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="name" type="text" placeholder="" required>
                                <label for="first_name">Manifest Date</label>
                            </div>
                            <div class="input-field col s2">
                                <a class="waves-effect waves-light indigo btn datepicker"></a>
                            </div>
                          </div>
                          <div class="row">
                            <h4 class="card-title">Manifest</h4>
                            <hr>
                            <br>
                          </div>
                          {!! get_button_save() !!}
                          {!! get_button_cancel(url('receipt-invoice'), 'Back') !!}
                      </form>
                      </div> 
                    </div>
                    <!-- Receipt Invoice -->
                    <div class="card-content">
                      <div class="row">
                      <form class="col s12">
                          <div class="row">
                            <h4 class="card-title">Receipt Invoice</h4>
                            <hr>
                            <br>
                            <div class="section-data-tables">
                                <h4 class="card-title">List Manifest Receipt</h4>
                                <hr>
                                <br>
                                <table id="data-table-section-contents" class="display" width="100%">
                                    <thead>
                                      <tr>
                                        <th data-priority="1" width="30px">NO.</th>
                                        <th>Manifest No</th>
                                        <th>DATE MANIFEST</th>
                                        <th>VEHICLE NO</th>
                                        <th>VEHICLE</th>
                                        <th>DESTINATION</th>
                                        <th>COUNT OF DO</th>
                                        <th>SUM OF CBM</th>
                                        <th>CBM</th>
                                        <th>RITASE</th>
                                        <th>RITASE2</th>
                                        <th>MULTIDROP</th>
                                        <th>UNLOADING</th>
                                        <th>OVERSTAY</th>
                                        <th>TOTAL</th>
                                        <th width="50px;"></th>
                                      </tr>
                                    </thead>
                                    <tbody></tbody> 
                                </table>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s3">
                                <input id="name" type="text" placeholder="">
                                <label for="first_name">Kwitansi No.</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="name" type="text" placeholder="" readonly="">
                                <label for="first_name">Receipt ID.</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="name" type="text" placeholder="" readonly="">
                                <label for="first_name">Receipt No.</label>
                            </div>
                          </div>
                          <hr>
                          <br>
                          <div class="row">
                              <div class="input-field col s2">
                                <input id="name" type="text" placeholder="" required>
                                <label for="first_name">PPh 2% (A)</label>
                            </div>
                            <div class="input-field col s2">
                                <input id="name" type="text" placeholder="" required>
                                <label for="first_name">PPn 10% (B)</label>
                            </div>
                            <div class="input-field col s2">
                                <input id="name" type="text" placeholder="" readonly="">
                                <label for="first_name">Amount Invoice (X)</label>
                            </div>
                            <div class="input-field col s2">
                                <input id="name" type="text" placeholder="" readonly="">
                                <label for="first_name">Amount Invoice + PPn(B+X)</label>
                            </div>
                          </div>
                          <div class="row">
                              <div class="input-field col s12 m4">
                                  <textarea id="textarea2" class="materialize-textarea" placeholder=""></textarea>
                                  <label for="textarea2">REMARKS</label>
                              </div>
                          </div>
                          {!! get_button_save('Submit to Accounting') !!}
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
        serverSide: false,
        scrollY: true,
        scrollX: true,
        // responsive: true,
        order: [1, 'asc'],
    });

  M.textareaAutoResize($('#textarea2')); 
</script>
@endpush